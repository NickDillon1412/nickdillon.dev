<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class ContactForm extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $name,
        public string $email,
        public string $message
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'nickdillon.dev - Contact Form',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.contact-form',
            with: [
                'name' => $this->name,
                'email' => $this->email,
                'message' => $this->message
            ]
        );
    }
}
