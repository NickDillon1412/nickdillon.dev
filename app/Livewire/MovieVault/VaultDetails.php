<?php

declare(strict_types=1);

namespace App\Livewire\MovieVault;

use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use App\Models\MovieVault\Vault;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;

#[Layout('layouts.app')]
class VaultDetails extends Component
{
    public Vault $vault;

    public ?string $previous_url = '';

    public function addToVault(Vault $vault): RedirectResponse|Redirector
    {
        $vault?->update(['on_wishlist' => false]);

        $name = $vault->title ?? $vault->name;

        return redirect(route('movie-vault.my-vault'))->success("Successfully added {$name} to your vault");
    }

    public function addToWishlist(Vault $vault): RedirectResponse|Redirector
    {
        $vault?->update(['on_wishlist' => true]);

        $name = $vault->title ?? $vault->name;

        return redirect(route('movie-vault.wishlist'))->success("Successfully added {$name} to your wishlist");
    }

    public function delete(Vault $vault): RedirectResponse|Redirector
    {
        $page = $vault->on_wishlist ? 'wishlist' : 'vault';

        $route = $vault->on_wishlist ? 'wishlist' : 'my-vault';

        $name = $vault->title ?? $vault->name;

        $vault?->delete();

        return redirect(route("movie-vault.{$route}"))->success("Successfully removed {$name} from your {$page}");
    }

    public function render(): View
    {
        $this->previous_url = Str::afterLast(URL::previous(), '/');

        return view('livewire.movie-vault.vault-details');
    }
}
