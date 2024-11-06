<div>
    @if($this->processing)
        <div class="p-3">
            <span class="relative flex w-2.5 h-2.5">
                <span class="absolute inline-flex w-full h-full bg-green-400 rounded-full opacity-75 animate-ping"></span>
                <span class="relative inline-flex w-2.5 h-2.5 bg-green-500 rounded-full"></span>
            </span>
        </div>
    @else
        <div class="relative overflow-hidden rounded-md select-none">

            <div class="absolute inset-0 group hover:bg-black/10 {{ $selected ? 'ring-4 ring-inset ring-blue-500/90' : '' }}">

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
                @responsive($this->asset, [
                    'alt' => $this->asset->alt,
                    'class' => 'w-full',
                    'width' => 1500
                ])
            </div>

        </div>
    @endif
</div>
