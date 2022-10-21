<?php

namespace App\Http\Livewire;

use App\Models\Project;
use Livewire\Component;

class Settings extends Component
{
    public bool $modalShown = false;
    public bool $creatingProject = false;
    public bool $showDeleteConfirmationModal = false;
    public int $projectBeingEdited;
    public int $projectBeingDeleted;
    public array $state = [];

    protected $listeners = ['show'];

    protected function rules()
    {
        return [
            'state.project.name' => ['required', 'string', 'max:255'],
            'state.project.path' => ['required', 'string', 'max:255'],
            'state.project.database' => ['required', 'string', 'max:255'],
        ];
    }

    public function show()
    {
        $this->modalShown = ! $this->modalShown;
    }

    public function editProject($project)
    {
        $this->projectBeingEdited = $project['id'];
        $this->state = [
            'project' => [
                'name' => $project['name'],
                'path' => $project['path'],
                'database' => $project['database'],
            ],
        ];
        $this->creatingProject = true;
    }

    public function updateProject()
    {
        $project = Project::find($this->projectBeingEdited);
        $project->name = $this->state['project']['name'];
        $project->path = $this->state['project']['path'];
        $project->database = $this->state['project']['database'];
        $project->save();
        $this->projectBeingEdited = null;
        $this->creatingProject = false;
        $this->state = [];
    }

    public function openDeleteConfirmationModal($id)
    {
        $this->showDeleteConfirmationModal = true;
        $this->projectBeingDeleted = $id;
    }

    public function deleteProject()
    {
        $project = Project::find($this->projectBeingDeleted);
        $project->delete();
        $this->showDeleteConfirmationModal = false;
    }

    public function addProject()
    {
        $this->validate();
        $project = new Project();
        $project->name = $this->state['project']['name'];
        $project->path = $this->state['project']['path'];
        $project->database = $this->state['project']['database'];
        $project->save();
        $this->creatingProject = false;
    }

    public function getProjectsProperty()
    {
        return Project::all();
    }

    public function render()
    {
        return view('livewire.settings');
    }
}
