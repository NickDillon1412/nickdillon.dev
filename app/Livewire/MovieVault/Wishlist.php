<?php

declare(strict_types=1);

namespace App\Livewire\MovieVault;

use App\Models\MovieVault\Vault;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Wishlist extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function addToVault(Vault $vault): void
    {
        $vault?->update(['on_wishlist' => false]);

        $this->dispatch('showAlertPopup', [
            'status' => 'success',
            'message' => (string) new HtmlString(
                '<p>Successfully added <strong>'
                .($vault->title ?? $vault->name).
                '</strong> to your vault</p>'
            ),
        ]);
    }

    public function render(): View
    {
        return view('livewire.movie-vault.wishlist', [
            'wishlist_records' => auth()
                ->user()
                ->vaults()
                ->whereOnWishlist(true)
                ->when(strlen($this->search) >= 1, function (Builder $query): void {
                    $query->where(function (Builder $query): void {
                        $query->whereLike('title', "%$this->search%")
                            ->orWhereLike('original_title', "%$this->search%")
                            ->orWhereLike('name', "%$this->search%")
                            ->orWhereLike('original_name', "%$this->search%");
                    });
                })
                ->latest()
                ->paginate(9),
        ]);
    }
}
