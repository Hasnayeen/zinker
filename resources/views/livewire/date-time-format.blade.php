<div>
    <x-dialog wire:model="paletteShown">
        <x-slot name="title">
            <div class="flex items-center pb-3">
                <input id="datetime-format-input" wire:model="input" type="text" class="bg-slate-800 appearance-none text-gray-200 text-sm font-bold flex-grow pb-1 px-3 leading-tight focus:outline-none focus:shadow-outline" placeholder="Write format here" autofocus>
            </div>
        </x-slot>
        <x-slot name="content" class="border-y border-slate-700 divide-y divide-gray-800">
            <div class="px-2 py-3 w-full text-left ring-none outline-none appearance-none">{{ $this->formattedString() }}</div>
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
