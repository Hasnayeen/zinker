@foreach ($properties as $property => $value)
    <tr>
        <td class="bg-slate-900/50 text-gray-300 font-normal text-left border-r border-gray-600 px-2 py-3 {{ $loop->first ? 'border-y' : 'border-b' }}">
            {{ $property }}
        </td>
        <td class="bg-slate-900 border-r border-gray-600 px-2 py-3 text-left text-sm font-semibold break-all {{ $loop->first ? 'border-y' : 'border-b' }}">
            @if (is_array($value))
                {{ json_encode($value) }}
            @else
                {{ $value }}
            @endif
        </td>
    </tr>
@endforeach
