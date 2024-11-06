<?php

namespace App\Livewire;

use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use Statamic\Contracts\Assets\Asset;

class GalleryItem extends Component
{
    #[Locked]
    #[Reactive]
    public ?string $id = null;

    #[Locked]
    public bool $downloadEnabled = false;

    public bool $selected = false;

    public bool $liked = false;

    #[Computed]
    public function asset(): ?Asset
    {
        return $this->id
            ? \Statamic\Facades\Asset::find($this->id)
            : null;
    }

    #[Computed]
    public function processing(): bool
    {
        return is_null($this->asset);
    }

    public function select(): void
    {
        $this->selected = ! $this->selected;

        $this->dispatch('update-selection', $this->id);
    }

    #[On('reset-selection')]
    public function deselect(): void
    {
        $this->selected = false;
    }

    public function like(): void
    {
        $this->liked = ! $this->liked;

        $this->dispatch('update-likes', $this->id);
    }
}
