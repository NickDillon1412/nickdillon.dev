<?php

declare(strict_types=1);

namespace App\Livewire\MovieVault;

use App\Models\MovieVault\Vault;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\HtmlString;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class VaultDetails extends Component
{
    public Vault $vault;

    public function delete(Vault $vault): void
    {
        $vault_name = $vault->title ?? $vault->name;

        $vault?->delete();

        Session::flash('alert', [
            'status' => 'success',
            'message' => (string) new HtmlString(
                '<p>Successfully removed <strong>'
                .$vault_name.
                '</strong> from your vault</p>'
            ),
        ]);

        $this->redirectRoute('movie-vault.my-vault');
    }

    public function render(): View
    {
        return view('livewire.movie-vault.vault-details');
    }
}
