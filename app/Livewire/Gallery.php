<?php

namespace App\Livewire;

use Aerni\Zipper\Zip;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Attributes\Renderless;
use Livewire\Component;
use Statamic\Assets\AssetCollection;
use Statamic\Contracts\Assets\Asset;
use Statamic\Contracts\Entries\Entry;

class Gallery extends Component
{
    #[Locked]
    public string $id;

    public array $selection = [];

    public array $likes = [];

    public function mount()
    {
        $this->likes = $this->entry->likes->map->id->all();
    }

    #[Computed(persist: true)]
    public function entry(): Entry
    {
        return \Statamic\Facades\Entry::find($this->id);
    }

    #[Computed(persist: true)]
    public function assets(): AssetCollection
    {
        return $this->entry->assets;
    }

    #[Computed]
    public function processedAssets(): AssetCollection
    {
        return $this->assets->mapWithKeys(function (Asset $asset) {
            return [$asset->id => $this->isProcessableAsset($asset) ? $asset->processed : $asset];
        });
    }

    public function processedAsset(string $id): ?Asset
    {
        return $this->processedAssets->get($id);
    }

    protected function isProcessableAsset(Asset $asset): bool
    {
        return $this->processingEnabled
            && $asset->isImage()
            && $asset->extension() !== 'gif';
    }

    #[Computed]
    public function assetsProcessing(): bool
    {
        return $this->processedAssets->contains(null);
    }

    #[Computed(persist: true)]
    public function processingEnabled(): bool
    {
        return $this->entry->processing_enabled;
    }

    #[Computed]
    public function assetsCount(): int
    {
        return empty($this->selection) ? $this->assets->count() : count($this->selection);
    }

    #[Computed(persist: true)]
    public function downloadEnabled(): bool
    {
        return $this->entry->download;
    }

    public function isLiked(string $id): bool
    {
        return in_array($id, $this->likes);
    }

    #[Computed]
    public function allowDownload(): bool
    {
        return $this->downloadEnabled
            && $this->assets->isNotEmpty()
            && ! $this->assetsProcessing();
    }

    public function downloadZip(): void
    {
        if (! $this->allowDownload) {
            return;
        }

        $this->redirect($this->zipUrl());
    }

    protected function zipUrl(): string
    {
        $assets = empty($this->selection)
            ? $this->processedAssets->all()
            : $this->processedAssets->filter(fn ($asset) => in_array($asset->id(), $this->selection))->all();

        return Zip::make($assets)
            ->filename($this->entry->title)
            ->url();
    }

    #[On('update-selection')]
    public function updateSelection(string $id): void
    {
        $selection = collect($this->selection);

        $this->selection = $selection->contains($id)
            ? $selection->diff($id)->values()->all()
            : $selection->push($id)->values()->all();
    }

    public function resetSelection(): void
    {
        $this->reset('selection');

        $this->dispatch('reset-selection');
    }

    #[On('update-likes')]
    #[Renderless]
    public function updateLikes(string $id): void
    {
        /**
         * The $id is either from an original or processed asset.
         * For the likes to work, we need to ensure that we're working with the $id of the original asset.
         */
        $id = $this->processedAssets
            ->where(fn ($asset) => $asset?->id() === $id)
            ->keys()
            ->first();

        $likes = collect($this->likes);

        $this->likes = $this->isLiked($id)
            ? $likes->diff($id)->values()->all()
            : $likes->push($id)->values()->all();

        $assets = $this->assets
            ->filter(fn ($asset) => in_array($asset->id(), $this->likes))
            ->map->path()
            ->unique()
            ->values()
            ->all();

        $this->entry
            ->set('likes', $assets)
            ->saveQuietly();
    }
}
