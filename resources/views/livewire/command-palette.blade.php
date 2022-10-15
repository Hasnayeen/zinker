<div
    @keyup.up="focusedCommand !== 1 ? focusedCommand-- : focusedCommand = null"
    @keyup.down="commands.length !== focusedCommand ? focusedCommand++ : focusedCommand = null"
    @update-command-list="updateCommandList">
    <x-dialog wire:model="paletteShown">
        <x-slot name="title">
            <div class="flex items-center pb-3">
                <input id="command-palette-input" wire:model="search" @keyup.enter="$wire.runCommand(commands[focusedCommand].name)" type="text" class="bg-slate-800 appearance-none text-gray-200 text-sm font-bold flex-grow pb-1 px-3 leading-tight focus:outline-none focus:shadow-outline" placeholder="What would you like to do?" autofocus>
                <span class="bg-gray-900 text-gray-300 text-[.5rem] leading-5 font-black px-2 mr-2 rounded flex items-baseline">ESC</span>
            </div>
        </x-slot>
        <x-slot name="content" class="border-y border-slate-700 divide-y divide-gray-800">
            @forelse ($this->commands as $key => $command)
                <div class="" wire:key="$key">
                    <button type="button" wire:click="runCommand('{{ $command['name'] }}')" :class="focusedCommand === {{ $key }} && 'bg-gray-700'" class="px-2 py-3 w-full text-left ring-none outline-none appearance-none">{{ $command['name'] }}</button>
                </div>
            @empty
                <li class="px-2 py-3 w-full text-left ring-none outline-none appearance-none">No Commands Available</li>
            @endforelse
        </x-slot>
        <x-slot name="footer">
            <div class="flex items-center space-x-2 px-2 py-3 w-full text-gray-300 text-xs">
                <span class="bg-slate-900 rounded p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"
                        class="w-3 h-3 text-gray-300">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m0 0l6.75-6.75M12 19.5l-6.75-6.75" />
                    </svg>
                </span>
                <span class="bg-slate-900 rounded p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3 h-3 text-gray-300">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 19.5v-15m0 0l-6.75 6.75M12 4.5l6.75 6.75" />
                    </svg>
                </span>
                <span>to navigate between commands</span>
                <span>|</span>
                <span class="bg-slate-900 rounded px-2 py-1 font-bold text-[0.6rem]">
                    ENTER
                </span>
                <span>to run command</span>
            </div>
        </x-slot>
    </x-dialog>
</div>
