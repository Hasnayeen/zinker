@foreach ($items as $item)
    <tr>
        @foreach ($item as $key => $value)
            <td class="bg-slate-900 border-r border-b border-gray-600 px-2 py-3 text-center text-sm font-semibold">
                @if (is_array($value))
                    {{ $key . ': ' . count($value) }}
                @else
                    {{ $value }}
                @endif
            </td>
        @endforeach
    </tr>
@endforeach
