<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CommandPalette extends Component
{
    public bool $paletteShown = false;
    public string $search = '';

    protected $listeners = ['showCommandPalette', 'updateCommandList'];

    public function showCommandPalette($commandName = null)
    {
        $this->paletteShown = ! $this->paletteShown;
        if ($commandName) {
            $this->runCommand($commandName);
        }
    }

    public function updateCommandList()
    {
        $this->dispatchBrowserEvent('update-command-list', $this->commands);
    }

    public function runCommand(string $commandName)
    {
        match ($commandName) {
            'DateTime Format' => $this->emitTo('date-time-format', 'show'),
            default => null,
        };
        $this->paletteShown = false;
    }

    public function getCommandsProperty()
    {
        return [
            1 => [
                'name' => 'DateTime Format',
            ]
        ];
    }

    public function render()
    {
        return view('livewire.command-palette');
    }
}
