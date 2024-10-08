<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;
use Statamic\Contracts\Assets\Asset;

class GalleryItem extends Component
{
    #[Locked]
    public string $id;

    #[Locked]
    public bool $downloadEnabled = false;

    public bool $selected = false;

    public bool $liked = false;

    #[Computed]
    public function asset(): Asset
    {
        return \Statamic\Facades\Asset::find($this->id);
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

    public function render(): View
    {
        return view('livewire.gallery-item');
    }
}
