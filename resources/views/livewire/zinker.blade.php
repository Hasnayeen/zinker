<section x-data="{tab: 'output'}" id="output" class="bg-gray-900 text-white overflow-y-auto h-full">
    <header
        class="w-full h-12 bg-gray-800 text-gray-400 font-semibold text-sm grid grid-cols-4">
        <button @click="tab = 'output'" :class="tab === 'output' ? 'bg-gray-900' : 'bg-gray-800'" class="grid place-content-center"])>
            Output
        </button>
        <button @click="tab = 'query_log'" :class="tab === 'query_log' ? 'bg-gray-900' : 'bg-gray-800'" class="grid place-content-center"])>
            Query Log
        </button>
        <button @click="tab = 'table'" :class="tab === 'table' ? 'bg-gray-900' : 'bg-gray-800'" class="grid place-content-center"])>
            Table
        </button>
        @if ($rawOutput !== '')
            <button @click="tab = 'raw'" :class="tab === 'raw' ? 'bg-gray-900' : 'bg-gray-800'" class="grid place-content-center"])>
                Raw
            </button>
        @endif
    </header>
    <div x-show="tab === 'output'" x-transition wire:loading.remove>
        {!! $output !!}
    </div>
    <div x-show="tab === 'query_log'" x-transition x-cloak class="animate-plus" wire:loading.remove>
        @if ($queryStats)
            @foreach ($queryStats as $item)
                <div class="w-full py-4">
                    <table class="table-fixed px-4 w-full">
                        <tbody>
                            <tr>
                                <th class="w-20 bg-gray-700 text-gray-300 font-normal text-left border-r border-b border-gray-600 p-2">Query:</th>
                                <th class="bg-black border-r border-b border-gray-600 p-2 text-left font-semibold">{{ $item['query'] }}</th>
                            </tr>
                            @if(count($item['bindings']) > 0)
                                <tr>
                                    <th class="w-20 bg-gray-700 text-gray-300 font-normal text-left border-r border-b border-gray-600 p-2">Bindings:</th>
                                    <th class="bg-black border-r border-b border-gray-600 p-2 text-left font-semibold">
                                        @foreach ($item['bindings'] as $binding)
                                            <span>{{ $binding }}{{ !$loop->last ? ',' : '' }}</span>
                                        @endforeach
                                    </th>
                                </tr>
                            @endif
                            <tr>
                                <th class="w-20 bg-gray-700 text-gray-300 font-normal text-left border-r border-gray-600 p-2">Time:</th>
                                <th class="bg-black border-r border-gray-600 p-2 text-left font-semibold">{{ $item['time'] . 's' }}</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endforeach
        @endif
    </div>
    <div x-show="tab === 'table'" x-transition wire:loading.remove>
        {!! $tableOutput !!}
    </div>
    @if ($rawOutput !== '')
        <div x-show="tab === 'raw'" x-transition wire:loading.remove>
            {!! $rawOutput !!}
        </div>
    @endif
    <div class="grid place-content-center h-full w-full" wire:loading.delay>
        <div class="grid place-items-center h-full">
            <svg class="animate-spin -ml-1 mr-3 h-32 w-32 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
        </div>
    </div>
</section>
