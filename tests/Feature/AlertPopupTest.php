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

it('can flash alert to session', function () {
    session()->flash('alert', [
        'status' => 'success',
        'message' => 'Test message',
    ]);

    $component = livewire(AlertPopup::class)
        ->assertHasNoErrors();

    $component->assertSessionHas('alert');
});
