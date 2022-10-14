<?php

namespace App\Actions;

use App\Models\Project;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\InputStream;

class RunInTinker
{
    public function __construct(
        private $phpBinaryPath,
    ) {}

    public function __invoke($code, Project $project)
    {
        $output = '';
        $input = new InputStream();

        $process = $this->startTinkerProcess($input, $project);

        $input->write($code);
        $input->close();

        $process->wait(function ($type, $buffer) use (&$output) {
            $output .= $buffer;
        });
        $process->stop(1, 9);

        return $output;
    }

    private function startTinkerProcess($input, Project $project)
    {
        $process = new Process([$this->phpBinaryPath, 'artisan', 'tinker', '-v']);
        $process->setWorkingDirectory($project->path);
        $process->setEnv(['DB_DATABASE' => $project->database]);
        $process->setInput($input);
        $process->start();

        return $process;
    }
}
