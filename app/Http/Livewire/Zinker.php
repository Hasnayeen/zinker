<?php

namespace App\Http\Livewire;

use App\Actions\CreateTableView;
use App\Actions\ParseCodeInput;
use App\Actions\RunInTinker;
use App\Actions\RunMagicCommands;
use App\Models\Project;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\VarDumper;

class Zinker extends Component
{
    public string $output = '';
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
        $rid = Str::random(8);
        [$code, $formattedCode, $magicCommands] = $parseCodeInput($input, $rid);
        if (!empty($magicCommands)) {
            $runMagicCommands($magicCommands, $code);
        }
        $rawOutput = $runInTinker($formattedCode, $this->project);

        [$this->queryStats, $outputs] = $this->getOutput($rid);

        VarDumper::setHandler(function ($var) {
            $cloner = new VarCloner();
            $dumper = new HtmlDumper();
            return $dumper->dump($cloner->cloneVar($var), true);
        });
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

    private function resetOutputs()
    {
        $this->output = '';
        $this->rawOutput = '';
        $this->tableOutput = '';
        $this->queryStats = [];
    }

    public function getOutput($rid)
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
                $outputs[] = $decodedValue;
            }
            File::delete(storage_path('app/public/'.$rid.'_output.txt'));
            $queryLog = array_pop($outputs);

            return [$queryLog, $outputs];
        }
    }

    public function getTableOutput($data)
    {
        $output = '';
        $createTableView = new CreateTableView();
        foreach ($data as $value) {
            $output .= $createTableView($value);
        }

        return $output;
    }

    public function switchProject($projectId)
    {
        $this->resetOutputs();
        $this->project = Project::find($projectId);
    }

    public function render()
    {
        return view('livewire.zinker');
    }
}
