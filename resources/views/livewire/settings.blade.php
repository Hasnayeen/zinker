<div>
    <!-- Settings Modal -->
    <x-dialog wire:model="modalShown">
        <x-slot name="title">
            <div class="flex justify-between items-center px-4 pb-3">
                <div class="flex items-center text-xl text-gray-400 font-semibold">
                    Settings
                </div>
                <button wire:click="$toggle('modalShown')" class="outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        class="w-6 h-6 text-gray-300">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </button>
            </div>
            <div class="flex items-center border-t border-slate-700/60 text-sm font-semibold text-gray-200">
                <button class="ring-none outline-none px-4 py-3 border-b-2 border-indigo-500">Projects</button>
                <button class="ring-none outline-none px-4 py-3">Appearance</button>
            </div>
        </x-slot>
        <x-slot name="content" class="divide-y divide-gray-800">
            <div class="">
                @if ($creatingProject)
                    <form action="">
                        <div class="px-4 py-3 grid grid-cols-5 items-center">
                            <label for="project-name" class="col-span-1 text-sm text-gray-300 font-semibold">Name</label>
                            <input name="project-name" wire:model="state.project.name" type="text"
                                class="col-span-4 bg-slate-800 appearance-none rounded text-gray-200 text-sm font-bold flex-grow py-3 px-4 leading-tight focus:outline-none focus:shadow-outline"
                                placeholder="Name of the project" autofocus>
                        </div>
                        <div class="px-4 py-3 grid grid-cols-5 items-center">
                            <label for="project-path" class="col-span-1 text-sm text-gray-300 font-semibold">Path</label>
                            <input name="project-path" wire:model="state.project.path" type="text"
                                class="col-span-4 bg-slate-800 appearance-none rounded text-gray-200 text-sm font-bold flex-grow py-3 px-4 leading-tight focus:outline-none focus:shadow-outline"
                                placeholder="absolute/path/to/project/root" autofocus>
                        </div>
                        <div class="px-4 py-3 grid grid-cols-5 items-center">
                            <label for="project-database" class="col-span-1 text-sm text-gray-300 font-semibold">Database</label>
                            <input name="project-database" wire:model="state.project.database" type="text"
                                class="col-span-4 bg-slate-800 appearance-none rounded text-gray-200 text-sm font-bold flex-grow py-3 px-4 leading-tight focus:outline-none focus:shadow-outline"
                                placeholder="Name of the database" autofocus>
                        </div>
                    </form>
                @else
                    <ul class="divide-gray-300">
                        @foreach ($this->projects as $project)
                            <li class="px-4 py-3 flex items-center justify-between {{ $loop->odd ? 'bg-slate-900' : 'bg-indigo-900/25' }}">
                                <div class="flex flex-col">
                                    <span class="font-black">
                                        {{ $project->name }}
                                    </span>
                                    <span class="text-sm text-gray-400">
                                        {{ $project->path }}
                                    </span>
                                </div>
                                <div class="flex items-center space-x-4">
                                    @if ($project->default)
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-indigo-500">
                                            <path fill-rule="evenodd"
                                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    @else
                                        <button>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="w-5 h-5 text-gray-400">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </button>
                                    @endif
                                    <!-- Edit button -->
                                    <button wire:click="editProject({{ $project }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                            class="w-5 h-5 text-gray-400">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                    </button>
                                    <!-- Delete button -->
                                    <button wire:click="openDeleteConfirmationModal({{ $project->id }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                            class="w-5 h-5 text-red-600/50">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </x-slot>
        <x-slot name="footer">
            @if ($creatingProject)
                <div class="flex justify-end space-x-4 p-3">
                    <button wire:click="$toggle('creatingProject')" class="px-6 py-2 rounded-md text-sm text-indigo-200 font-bold border-2 border-slate-500">Cancel</button>
                    @if ($projectBeingEdited)
                        <button wire:click="updateProject" class="px-6 py-2 rounded-md text-sm text-indigo-200 font-bold border-2 border-indigo-900 bg-indigo-900">Update</button>
                    @else
                        <button wire:click="addProject" class="px-6 py-2 rounded-md text-sm text-indigo-200 font-bold border-2 border-indigo-900 bg-indigo-900">Add</button>
                    @endif
                </div>
            @else
                <div class="flex justify-end p-3">
                    <button wire:click="$toggle('creatingProject')" class="px-6 py-2 rounded-md text-sm text-indigo-200 font-bold border-2 border-indigo-900 bg-indigo-900">Add New Project</button>
                </div>
            @endif
        </x-slot>
    </x-dialog>

    <!-- Delete Confirmation Modal -->
    <x-confirmation wire:model="showDeleteConfirmationModal">
        <x-slot name="title">Delete Project</x-slot>
        <x-slot name="content">
            <div class="mb-4">
                Are you sure you want to delete this project? This action cannot be reversed.
            </div>
            </x-slot>
            <x-slot name="footer">
                <div class="flex justify-end space-x-4">
                    <button class="px-6 py-2 rounded-md text-sm text-gray-400 font-bold border-2 border-slate-500" type="button" wire:click="$toggle('showDeleteConfirmationModal')">Cancel</button>
                    <button class="px-6 py-2 rounded-md text-sm text-red-200 font-bold border-2 border-red-900 bg-red-900" wire:click="deleteProject">Delete</button>
                </div>
                </x-slot>
    </x-confirmation>
</div>
