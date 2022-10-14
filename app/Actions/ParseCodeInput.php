<?php

namespace App\Actions;

use Illuminate\Support\Str;
use PhpParser\Node;
use PhpParser\ParserFactory;

class ParseCodeInput
{
    const AST_INDEX_OFFSET = 2;

    protected $queryLogStart = 'DB::enableQueryLog();';
    protected $queryLogEnd = 'DB::getQueryLog()';
    protected $magicCommands = [];

    public function __construct(
        protected string $appUrl,
        protected ParserFactory $parserFactory,
    ) {}

    public function __invoke(array $input, string $rid): array
    {
        $code = '';
        foreach ($input as $line) {
            $code .= $line . PHP_EOL;
        }
        $parser = $this->parserFactory->create(ParserFactory::PREFER_PHP7);
        $formattedCode = '';
        $ast = $parser->parse('<?php' . PHP_EOL . $code);
        foreach ($ast as $node) {
            $formattedCode .= match ($node->getType()) {
                'Stmt_Echo' => $this->addEchoStatement($node, $input, $rid),
                'Stmt_Return' => $this->addReturnStatement($node, $input, $rid),
                'Stmt_Expression' => $this->addExpression($node, $input, $rid),
                'Stmt_Nop' => $this->collectMagicCommands($node),
                default => $this->addStatement($node, $input, $rid),
            };
        }

        $formattedCode = $this->queryLogStart . PHP_EOL . $formattedCode;
        $formattedCode .= "Http::post('$this->appUrl', ['output' => $this->queryLogEnd, 'rid' => '$rid']);";

        return [$code, $formattedCode, $this->magicCommands];
    }

    private function addReturnStatement(Node $node, array $input, string $rid)
    {
        # code...
    }

    private function addEchoStatement(Node $node, array $input, string $rid)
    {
        $fnName = '$echo_' . $node->getLine();
        $code = $fnName . " = fn () => '" . $node->exprs[0]->value . "';" ;
        return $code . PHP_EOL . "Http::post('$this->appUrl', ['output' => $fnName(), 'rid' => '$rid']);" . PHP_EOL;
        return $input[$node->getLine() - self::AST_INDEX_OFFSET] . PHP_EOL . "\$__out;" . PHP_EOL;
    }

    private function addStatement(Node $node, array $input, string $rid)
    {
        if ($node->getStartLine() === $node->getEndLine()) {
            return $input[$node->getLine() - self::AST_INDEX_OFFSET] . PHP_EOL;
        }

        $code = '';
        for ($i = $node->getStartLine(); $i <= $node->getEndLine(); $i++) {
            $code .= trim($input[$i - self::AST_INDEX_OFFSET]);
        }

        return $code . PHP_EOL;
    }

    private function addExpression(Node $node, array $input, string $rid)
    {
        $code = '';
        $checkForClass = '';

        if (in_array($node->expr->getType(), ['Expr_MethodCall', 'Expr_StaticCall'])) {
            $className = match (true) {
                $node->expr->class ?? false => $node->expr->class?->parts[0],
                $node->expr->var->class ?? false => $node->expr->var->class?->parts[0],
                $node->expr->var->name ?? false => $node->expr->var->name?->parts[0],
                default => null,
            };
            $checkForClass = $className
                ? "Http::post('$this->appUrl', ['output' => ['isModel' => class_parents('$className'), 'className' => (new ReflectionClass('$className'))->getName()], 'rid' => '$rid']);" . PHP_EOL
                : '';
        }
        if ($node->getStartLine() === $node->getEndLine()) {
            $code = $input[$node->getLine() - self::AST_INDEX_OFFSET];
        } else {
            for ($i = $node->getStartLine(); $i <= $node->getEndLine(); $i++) {
                $code .= trim($input[$i - self::AST_INDEX_OFFSET]);
            }
        }

        $code = rtrim($code, ';');

        return $checkForClass . "Http::post('$this->appUrl', ['output' => $code, 'rid' => '$rid']);" . PHP_EOL;
    }

    private function collectMagicCommands(Node $node)
    {
        $comment = $node->getComments()[0]->getText();
        $this->magicCommands[] = Str::after($comment, '@');
    }
}
