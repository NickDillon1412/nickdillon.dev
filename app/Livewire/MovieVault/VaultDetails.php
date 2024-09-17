<?php

declare(strict_types=1);

namespace App\Livewire\MovieVault;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\MovieVault\Vault;
use App\Services\MovieVaultService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Request;

#[Layout('layouts.app')]
class VaultDetails extends Component
{
    public Vault $vault;

    public ?string $previous_url = '';

    public function addToVault(Vault $vault): void
    {
        MovieVaultService::add($vault);

        $this->redirectRoute('movie-vault.my-vault');
    }

    public function addToWishlist(Vault $vault): void
    {
        MovieVaultService::add($vault, wishlist: true);

        $this->redirectRoute('movie-vault.wishlist');
    }

    public function delete(Vault $vault): void
    {
        $on_wishlist = Request::routeIs('movie-vault.wishlist') ? true : false;

        MovieVaultService::delete($vault, $on_wishlist);

        $this->redirectRoute('movie-vault.my-vault');
    }

    public function render(): View
    {
        $this->previous_url = parse_url(URL::previous(), PHP_URL_PATH);

        return view('livewire.movie-vault.vault-details');
    }
}
