<div
    x-data="{ state: $wire.$entangle('{{ $statePath = $getStatePath() }}') }"
    x-on:pexels-selected-images-updated.window="state = $event.detail"
>
</div>
