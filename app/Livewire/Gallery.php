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
        return $this->entry->processed_images;
    }

    #[Computed]
    public function assetsCount(): int
    {
        return empty($this->selection) ? $this->assets->count() : count($this->selection);
    }

    public function isLiked(string $id): bool
    {
        return in_array($id, $this->likes);
    }

    #[Computed(persist: true)]
    public function downloadEnabled(): bool
    {
        return $this->entry->download;
    }

    #[Computed]
    public function zipUrl(): string
    {
        $assets = empty($this->selection)
            ? $this->assets->all()
            : $this->assets->filter(fn ($asset) => in_array($asset->id(), $this->selection))->all();

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

    public function render(): View
    {
        return view('livewire.gallery');
    }
}
