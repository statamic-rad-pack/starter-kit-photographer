<div class="relative overflow-hidden rounded-md select-none">

    <div class="absolute inset-0 rounded-md group hover:bg-black/10 {{ $selected ? 'ring-4 ring-inset ring-blue-500/90' : '' }}">

        <div class="absolute top-0 right-0 p-2">
            <x-like-button :$liked />
        </div>

        @if($downloadEnabled)
            <div class="absolute top-0 left-0 p-2">
                <x-select-button :$selected />
            </div>

            <div class="absolute inset-x-0 bottom-0 p-2">
                <x-download-button :url="$this->asset->url" class="w-full opacity-0 group-hover:opacity-100" />
            </div>
        @endif
    </div>

    <div wire:ignore>
        @include('components.image', [
            'asset' => $this->asset,
            'width' => 1500,
        ])
    </div>

</div>
