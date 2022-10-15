<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CommandPalette extends Component
{
    public bool $paletteShown = false;
    public string $search = '';

    protected $listeners = ['showCommandPalette', 'updateCommandList'];

    public function showCommandPalette()
    {
        $this->paletteShown = ! $this->paletteShown;
    }

    public function updateCommandList()
    {
        $this->dispatchBrowserEvent('update-command-list', $this->commands);
    }

    public function runCommand()
    {
        # code...
    }

    public function getCommandsProperty()
    {
        return [];
    }

    public function render()
    {
        return view('livewire.command-palette');
    }
}
