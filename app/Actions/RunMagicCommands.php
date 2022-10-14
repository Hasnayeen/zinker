<?php

namespace App\Actions;

class RunMagicCommands
{
    public function __invoke(array $commands, string $code)
    {
        foreach ($this->magicCommands as $key => $command) {
            match ($command) {
                // 'explain' => $this->explainCode($code),
                default => null,
            };
        }
    }
}
