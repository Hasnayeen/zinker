<x-layout>
    <div x-data="app">
        <main class="grid fixed w-screen h-screen bg-black" :class="needsColumnLayout && 'grid-rows-[100vh]'" :style="gridStyle">
            <section class="">
                <header class="w-full h-10 bg-gray-900 grid grid-cols-6">
                    <div class="col-start-6 grid place-items-center">
                        <button @click="executeCode" class="rounded shadow bg-gray-600 text-white text-xs font-bold px-4 py-1">
                            Run
                        </button>
                    </div>
                </header>
                <div id="editor" class="w-full h-full bg-slate-900 resize-none">
                </div>
            </section>
            <hr id="gutter"
                class="flex items-center justify-center h-auto
                    after:text-gray-300 after:text-[10px] after:leading-[6px] after:content-['\2022\2022\2022'] after:text-center after:break-all cursor-ew-resize" />
            <livewire:zinker :project="$currentProject" />
        </main>
    </div>
</x-layout>
