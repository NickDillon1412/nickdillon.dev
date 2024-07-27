<?php

declare(strict_types=1);

namespace App\Livewire\MovieVault;

use App\Models\MovieVault\Vault;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class MyVault extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function delete(Vault $vault): void
    {
        $vault?->delete();
    }

    public function render(): View
    {
        return view('livewire.movie-vault.my-vault', [
            'vault_records' => auth()
                ->user()
                ->vaults()
                ->when(strlen($this->search) >= 1, function ($query) {
                    return $query
                        ->whereLike('title', "%$this->search%")
                        ->orWhereLike('original_title', "%$this->search%")
                        ->orWhereLike('name', "%$this->search%")
                        ->orWhereLike('original_name', "%$this->search%");
                })
                ->latest()
                ->paginate(9),
        ]);
    }
}
