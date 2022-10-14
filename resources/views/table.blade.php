<div class="w-full py-4">
    <table class="table-auto px-4 w-full">
        @isset($thead)
            <thead>
               {!! $thead !!}
            </thead>
        @endisset
        <tbody>
            {!! $tbody !!}
        </tbody>
    </table>
</div>
