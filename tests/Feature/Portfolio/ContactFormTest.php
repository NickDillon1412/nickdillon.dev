<?php

declare(strict_types=1);

use App\Mail\ContactForm;
use Illuminate\Support\Facades\Mail;
use Livewire\Volt\Volt;

it('can fill out form and send email', function () {
    Mail::fake();

    Volt::test('portfolio.contact-form')
        ->set('name', 'Nick')
        ->set('email', 'nick@test.com')
        ->set('message', 'Test message')
        ->call('sendEmail')
        ->assertHasNoErrors();

    Mail::assertSent(function (ContactForm $mail) {
        return $mail->hasTo('nickhds@gmail.com') &&
            $mail->name === 'Nick' &&
            $mail->email === 'nick@test.com' &&
            $mail->message === 'Test message';
    });

    Mail::assertSent(ContactForm::class, function (ContactForm $mail) {
        return $mail->hasSubject('nickdillon.dev - Contact Form') &&
            $mail->assertSeeInOrderInHtml(['Nick', 'nick@test.com', 'Test message']);
    });
});

test('component can render', function () {
    Volt::test('portfolio.contact-form')
        ->assertHasNoErrors();
});
