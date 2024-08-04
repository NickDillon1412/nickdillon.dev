<?php

declare(strict_types=1);

namespace App\Livewire\MovieVault;

use App\Models\MovieVault\Vault;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\HtmlString;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class VaultDetails extends Component
{
    public Vault $vault;

    public ?string $previous_url = '';

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
        $this->previous_url = parse_url(URL::previous(), PHP_URL_PATH);

        return view('livewire.movie-vault.vault-details');
    }
}
