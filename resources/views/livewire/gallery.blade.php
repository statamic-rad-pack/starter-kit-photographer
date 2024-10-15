<div x-data="gallery" x-cloak class="fluid-container">

    <x-gallery-header />

    <x-masonry-grid
        class="pb-36"
        ::class="{
            'gap-4 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 xl:grid-cols-6 xl:gap-6 2xl:grid-cols-6': currentZoom <= 1,
            'gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-5 xl:gap-6 2xl:grid-cols-5': currentZoom == 2,
            'gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 xl:gap-6 2xl:grid-cols-4': currentZoom == 3,
            'gap-4 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 xl:gap-6 2xl:grid-cols-3': currentZoom == 4,
        }"
    >
        @foreach($this->assets as $asset)
            <div wire:key="{{ $asset->id }}">
                <livewire:gallery-item
                    :key="$asset->id"
                    :id="$asset->id"
                    :downloadEnabled="$this->downloadEnabled"
                    :liked="$this->isLiked($asset->id)"
                />
            </div>
        @endforeach
    </x-masonry-grid>

    <x-gallery-toolbar />

</div>

@script
    <script>
        Alpine.data('gallery', function () {
            return {
                currentZoom: this.$persist(1),
                minZoom: 1,
                maxZoom: 4,
                init() {
                    this.$watch('currentZoom', () => this.$dispatch('reload:masonry'))
                },
                zoomIn() {
                    if (!this.isMaxZoomed) {
                        this.currentZoom++
                    }
                },
                zoomOut() {
                    if (!this.isMinZoomed) {
                        this.currentZoom--
                    }
                },
                get isMinZoomed() {
                    return this.currentZoom <= this.minZoom
                },
                get isMaxZoomed() {
                    return this.currentZoom >= this.maxZoom
                },
            }
        })
    </script>
@endscript
