<div>
    <x-dialog wire:model="paletteShown">
        <x-slot name="title">
            <div class="flex items-center pb-3">
                <input x-ref="datetime_format_input" wire:model="input" type="text" class="bg-slate-800 appearance-none text-gray-200 text-sm font-bold flex-grow pb-1 px-3 leading-tight focus:outline-none focus:shadow-outline" placeholder="Write format here" autofocus>
                <button  @click="$refs.datetime_format_input.select();document.execCommand('copy')" class="px-2 mr-2 flex items-baseline">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        class="w-5 h-5 text-gray-300">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75" />
                    </svg>
                </button>
            </div>
        </x-slot>
        <x-slot name="content" class="border-y border-slate-700 divide-y divide-gray-800">
            <div class="px-2 py-3 w-full text-left text-xl font-bold ring-none outline-none appearance-none">{{ $this->formattedString() }}</div>
        </x-slot>
        <x-slot name="footer">
            <table class="table-auto px-4 w-full text-gray-300">
                <thead>
                    <x-table.thead :keys="['Character', 'Description', 'Example']"></x-table.thead>
                </thead>
                <tbody>
                    @foreach ($this->format as $type => $item)
                        <tr>
                            <td class="bg-black border-r border-b border-gray-600 px-2 py-3 text-center text-sm font-semibold">
                                {{ $type }}
                            </td>
                            <td colspan="2" class="bg-slate-900 border-r border-b border-gray-600 px-2 py-3 text-center text-sm font-semibold">
                            </td>
                        </tr>
                        @foreach ($item as $key => $value)
                            <tr>
                                <td class="bg-black border-r border-b border-gray-600 px-2 py-3 text-center text-sm font-semibold">
                                    {{ $value['character'] }}
                                </td>
                                <td class="bg-black border-r border-b border-gray-600 px-2 py-3 text-center text-sm font-semibold">
                                    {{ $value['desc'] }}
                                </td>
                                <td class="bg-black border-r border-b border-gray-600 px-2 py-3 text-center text-sm font-semibold">
                                    {{ $value['example'] }}
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </x-slot>
    </x-dialog>

</div>
