<?php

declare(strict_types=1);

namespace App\Livewire\MovieVault;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\MovieVault\Vault;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Filament\Notifications\Notification;
use Livewire\Features\SupportRedirects\Redirector;

#[Layout('layouts.app')]
class VaultDetails extends Component
{
    public Vault $vault;

    public ?string $previous_url = '';

    public function addToVault(Vault $vault): RedirectResponse|Redirector
    {
        $vault?->update(['on_wishlist' => false]);

        Notification::make()
            ->title("Successfully added {$vault->title} to your vault")
            ->success()
            ->send();

        return redirect(route('movie-vault.my-vault'));
    }

    public function addToWishlist(Vault $vault): RedirectResponse|Redirector
    {
        $vault?->update(['on_wishlist' => true]);

        Notification::make()
            ->title("Successfully added {$vault->title} to your wishlist")
            ->success()
            ->send();

        return redirect(route('movie-vault.wishlist'));
    }

    public function delete(Vault $vault): RedirectResponse|Redirector
    {
        $page = $vault->on_wishlist ? 'wishlist' : 'vault';

        $route = $vault->on_wishlist ? 'wishlist' : 'my-vault';

        Notification::make()
            ->title("Successfully removed {$vault->title} from your {$page}")
            ->success()
            ->send();

        $vault?->delete();

        return redirect(route("movie-vault.{$route}"));
    }

    public function render(): View
    {
        return view('livewire.movie-vault.vault-details');
    }
}
