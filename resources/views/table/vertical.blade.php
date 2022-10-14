@foreach ($properties as $property => $value)
    <tr>
        <td class="bg-gray-900 text-gray-300 font-normal text-left border-r border-b border-gray-600 px-2 py-3">
            {{ $property }}
        </td>
        <td class="bg-black border-r border-b border-gray-600 px-2 py-3 text-left text-sm font-semibold break-all">
            @if (is_array($value))
                {{ json_encode($value) }}
            @else
                {{ $value }}
            @endif
        </td>
    </tr>
@endforeach
