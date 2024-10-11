<?php

namespace App\Livewire;

use Aerni\Zipper\Zip;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Attributes\Renderless;
use Livewire\Component;
use Statamic\Assets\AssetCollection;
use Statamic\Contracts\Entries\Entry;

class Gallery extends Component
{
    #[Locked]
    public string $id;

    public array $selection = [];

    #[Computed]
    public function entry(): Entry
    {
        return \Statamic\Facades\Entry::find($this->id);
    }

    #[Computed]
    public function assets(array $selection = []): AssetCollection
    {
        return $this->entry->processed_images
            ->when($selection, function ($assets) use ($selection) {
                return $assets->filter(fn ($asset) => in_array($asset->id(), $selection));
            });
    }

    #[Computed]
    public function assetsCount(): int
    {
        return $this->assets($this->selection)->count();
    }

    #[Computed]
    public function likes(): AssetCollection
    {
        return $this->entry->likes->map->id;
    }

    public function isLiked(string $id): bool
    {
        return $this->likes->contains($id);
    }

    #[Computed]
    public function downloadEnabled(): bool
    {
        return $this->entry->download;
    }

    #[Computed]
    public function zipUrl(): string
    {
        return Zip::make($this->assets($this->selection)->all())
            ->filename($this->entry->title)
            ->url();
    }

    #[On('update-selection')]
    public function updateSelection(string $id): void
    {
        $selection = collect($this->selection);

        $this->selection = $selection->contains($id)
            ? $selection->diff($id)->all()
            : $selection->push($id)->all();
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
        $likes = $this->likes->contains($id)
            ? $this->likes->diff($id)->all()
            : $this->likes->push($id)->all();

        $assets = $this->assets($likes)
            ->map(fn ($asset) => $asset->path())
            ->unique()
            ->values()
            ->all();

        $this->entry
            ->set('likes', $assets)
            ->saveQuietly();
    }

    public function render(): View
    {
        return view('livewire.gallery');
    }
}
