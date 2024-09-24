<?php

declare(strict_types=1);

namespace App\Livewire\MovieVault;

use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;
use Livewire\Attributes\Layout;
use App\Models\MovieVault\Vault;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

#[Layout('layouts.app')]
class MyVault extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function addToWishlist(Vault $vault): void
    {
        $vault?->update(['on_wishlist' => true]);

        $name = $vault->title ?? $vault->name;

        Toaster::success("Successfully added {$name} to your wishlist");
    }

    public function delete(Vault $vault): void
    {
        Toaster::success("Successfully removed {$vault->name} from your vault");

        $vault?->delete();
    }

    public function render(): View
    {
        return view('livewire.movie-vault.my-vault', [
            'vault_records' => auth()
                ->user()
                ->vaults()
                ->whereOnWishlist(false)
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
