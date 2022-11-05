<?php

namespace App\Http\Livewire;

use App\Actions\CreateTableView;
use App\Actions\ParseCodeInput;
use App\Actions\RunInTinker;
use App\Actions\RunMagicCommands;
use App\Models\Project;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use PhpParser\Error;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\VarDumper;
use Throwable;

class Zinker extends Component
{
    public string $output = <<<output
    <span class="px-4">Press Ctrl+Enter to run code.</span>
    output;
    public string $rawOutput = '';
    public string $tableOutput = '';
    public ?array $queryStats = [];
    public ?Project $project;

    protected $listener = ['execute'];

    public function execute(
        array $input,
        RunInTinker $runInTinker,
        ParseCodeInput $parseCodeInput,
        RunMagicCommands $runMagicCommands,
    ): void {
        $this->resetOutputs();
        $this->setDumperHandler();
        $rid = Str::random(8);
        try {
            [$code, $formattedCode, $magicCommands] = $parseCodeInput($input, $rid);
        } catch (Error $error) {
            $this->output = VarDumper::dump($error->getRawMessage() . ' on ' . $error->getEndLine() - 2);
            $this->rawOutput = $error->getRawMessage();

            return;
        } catch (Throwable $th) {
            $this->output = VarDumper::dump($th->getMessage());
            $this->rawOutput = $th->getMessage();

            return;
        }
        if (!empty($magicCommands)) {
            $runMagicCommands($magicCommands, $code);
        }
        $rawOutput = $runInTinker($formattedCode, $this->project);

        [$this->queryStats, $outputs] = $this->getOutput($rid);

        if (!is_null($outputs)) {
            $this->tableOutput = $this->getTableOutput($outputs);
    
            foreach ($outputs as $key => $value) {
                $this->output .= VarDumper::dump($value);
            }
        } else {
            $this->rawOutput = VarDumper::dump($rawOutput);
            $this->output = VarDumper::dump('Something went wrong!');
        }
    }

    private function resetOutputs(): void
    {
        $this->output = '';
        $this->rawOutput = '';
        $this->tableOutput = '';
        $this->queryStats = [];
    }

    /**
     * @return array<int,mixed>|array<int,null>
     */
    private function getOutput($rid): array
    {
        if (File::exists(storage_path('app/public/'.$rid.'_output.txt'))) {
            $output = File::get(storage_path('app/public/'.$rid.'_output.txt'));
            $jsonStrings = explode($rid, $output);
            $outputs = [];
            foreach ($jsonStrings as $key => $value) {
                if (!trim($value)) {
                    continue;
                }
                $decodedValue = json_decode($value, true);
                if (!is_array($decodedValue) && is_string($decodedValue)) {
                    $decodedValue = ($result = json_decode($decodedValue, true)) ? $result : $decodedValue;
                }
                $outputs[] = $decodedValue;
            }
            File::delete(storage_path('app/public/'.$rid.'_output.txt'));
            $queryLog = array_pop($outputs);

            return [$queryLog, $outputs];
        }

        return [null, null];
    }

    private function getTableOutput($data): string
    {
        $output = '';
        $createTableView = new CreateTableView();
        foreach ($data as $value) {
            if (is_array($value)) {
                $output .= $createTableView($value);
            }
        }

        return $output;
    }

    private function setDumperHandler(): void
    {
        VarDumper::setHandler(function ($var) {
            $cloner = new VarCloner();
            $dumper = new HtmlDumper();
            return $dumper->dump($cloner->cloneVar($var), true);
        });
    }

    public function switchProject($projectId): void
    {
        $this->resetOutputs();
        $this->project = Project::find($projectId);
    }

    public function render(): View|Factory
    {
        return view('livewire.zinker');
    }
}
