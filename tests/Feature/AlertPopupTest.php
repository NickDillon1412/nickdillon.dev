<?php

declare(strict_types=1);

use App\Livewire\AlertPopup;

use function Pest\Livewire\livewire;

it('can set alerts', function () {
    $alert = [
        'status' => 'success',
        'message' => 'Test message',
    ];

    livewire(AlertPopup::class)
        ->call('showAlertPopup', $alert)
        ->assertSet('alerts', [$alert]);
});
