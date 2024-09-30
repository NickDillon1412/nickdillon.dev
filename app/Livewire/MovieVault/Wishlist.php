<?php

declare(strict_types=1);

namespace App\Livewire\MovieVault;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;
use Livewire\Attributes\Layout;
use App\Models\MovieVault\Vault;
use App\Services\MovieVaultService;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

#[Layout('layouts.app')]
class Wishlist extends Component
{
    use WithPagination;

    public string $search = '';

    public string $type = '';

    public array $ratings = [];

    public array $selected_ratings = [];

    public array $genres = [];

    public array $selected_genres = [];

    public string $sort_direction = 'asc';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    #[On('clear-filters')]
    public function clearFilters(): void
    {
        $this->reset(['type', 'selected_ratings', 'selected_genres']);
    }

    public function addToVault(Vault $vault): void
    {
        $vault?->update(['on_wishlist' => false]);

        $name = $vault->title ?? $vault->name;

        Toaster::success("Successfully added {$name} to your vault");
    }

    public function render(): View
    {
        $this->ratings = MovieVaultService::getRatings(on_wishlist: true);

        $this->genres = MovieVaultService::getGenres(on_wishlist: true);

        return view('livewire.movie-vault.wishlist', [
            'wishlist_records' => auth()
                ->user()
                ->vaults()
                ->whereOnWishlist(true)
                ->when(strlen($this->search) >= 1, function (Builder $query): void {
                    $query->where(function (Builder $query): void {
                        $query->whereLike('title', "%$this->search%")
                            ->orWhereLike('original_title', "%$this->search%")
                            ->orWhereLike('actors', "%$this->search%");
                    });
                })
                ->when($this->type, function (Builder $query): void {
                    $query->where('vault_type', $this->type);
                })
                ->when($this->selected_ratings, function (Builder $query): void {
                    foreach ($this->selected_ratings as $rating) {
                        $query->where('rating', $rating);
                    }
                })
                ->when($this->selected_genres, function (Builder $query): void {
                    foreach ($this->selected_genres as $genre) {
                        $query->where('genres', 'LIKE', "%$genre%");
                    }
                })
                ->orderBy('title', $this->sort_direction)
                ->paginate(9),
        ]);
    }
}
