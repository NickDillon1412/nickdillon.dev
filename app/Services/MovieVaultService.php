<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\MovieVault\Vault;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Session;

class MovieVaultService
{
    public static function add(Vault $vault, bool $wishlist = false): void
    {
        $wishlist
            ? $vault?->update(['on_wishlist' => true])
            : $vault?->update(['on_wishlist' => false]);

        Session::flash('alert', [
            'status' => 'success',
            'message' => 'Successfully added to your ' . $wishlist ? 'wishlist' : 'vault',
        ]);
    }

    public static function delete(Vault $vault, bool $wishlist = false): void
    {
        $vault_name = $vault->title ?? $vault->name;

        $vault?->delete();

        Session::flash('alert', [
            'status' => 'success',
            'message' => (string) new HtmlString(
                '<p>Successfully removed <strong>'
                    . $vault_name .
                    '</strong> from your ' . $wishlist ? 'wishlist' : 'vault' . '</p>'
            ),
        ]);
    }
}
