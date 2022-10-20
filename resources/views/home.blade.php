<x-layout>
    <div x-data="app" @keyup.ctrl.slash.window="openCommandPalette" @keyup.alt.slash.window="openCommandPalette" class="w-screen h-screen">
        <header class="w-full h-16 bg-black border-b border-gray-500 flex justify-between px-8 items-center">
            <!-- Project Switcher -->
            <div x-data="{projects: @js($projects), currentProject: @js($currentProject->toArray()) }" class="relative col-start-1 col-span-2">
                <x-dropdown align="left" width="60">
                    <x-slot name="trigger">
                        <span class="inline-flex rounded-md">
                            <button type="button"
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm text-left leading-4 font-medium rounded text-gray-100 bg-indigo-800/70 hover:bg-indigo-900/70 hover:text-gray-300 focus:outline-none focus:bg-indigo-900 active:bg-indigo-900/70 transition">
                                <span class="w-20 truncate" x-text="currentProject.name"></span>

                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </span>
                    </x-slot>

                    <x-slot name="content">
                        <div class="w-60">

                            <template x-for="project in projects">
                                <button @click="switchProject(project)" class="flex block px-4 py-2 text-sm leading-5 text-left text-gray-300 font-semibold w-full hover:bg-indigo-900 focus:outline-none focus:bg-indigo-900 transition">
                                    <template x-if="currentProject.name === project.name">
                                        <svg class="mr-2 h-5 w-5 text-green-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </template>
                                    <span x-text="project.name"></span>
                                </button>
                            </template>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>
            <!-- Right Side Buttons -->
            <div class="col-start-6 flex items-center justify-center space-x-4">
                <button @click="currentLayout = 'column'">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" width="24" height="24"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <rect x="4" y="4" width="16" height="16" rx="2" />
                        <line x1="12" y1="4" x2="12" y2="20" />
                    </svg>
                </button>
                <button @click="currentLayout = 'row'">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" width="24" height="24"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <rect x="4" y="4" width="16" height="16" rx="2" />
                        <line x1="4" y1="12" x2="20" y2="12" />
                    </svg>
                </button>
                <!-- Settings Button -->
                <button @click="openSettings" class="grid place-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-300">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </button>
                <button @click="executeCode" class="rounded shadow bg-indigo-800/70 text-white text-xs font-bold px-6 py-2">
                    Run
                </button>
            </div>
        </header>
         <main class="grid fixed w-full bg-black" :class="needsColumnLayout && 'grid-rows-[calc(100vh-4rem)]'" :style="gridStyle">
            <section class="">
                <div id="editor" class="w-full h-full bg-slate-900 resize-none">
                </div>
            </section>
            <hr id="gutter" :class="currentLayout === 'column' ? 'cursor-ew-resize' : 'cursor-ns-resize' "
                class="flex items-center justify-center h-auto bg-gray-800
                    after:text-gray-300 after:text-[10px] after:leading-[6px] after:content-['\2022\2022\2022'] after:text-center after:break-all" />
            <livewire:zinker :project="$currentProject" />
        </main>

        <livewire:command-palette />
        <livewire:date-time-format />
        <livewire:settings />
    </div>
</x-layout>
