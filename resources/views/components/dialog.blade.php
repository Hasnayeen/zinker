@props(['id' => null, 'maxWidth' => null])

<x-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="pt-4">
        <div class="text-lg">
            {{ $title }}
        </div>

        <div {{ $content->attributes->class(['text-gray-300 bg-slate-900']) }}>
            {{ $content }}
        </div>
    </div>

    <div class="flex flex-row justify-end px-6 py-4 bg-slate-800 text-right">
        {{ $footer }}
    </div>
</x-modal>
