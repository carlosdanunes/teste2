<?php

namespace App\Mail\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BrokeAccountMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $name,
    ) {
        $this->onQueue('broke-account-mail');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Mantenha o foco e vença novamente em nossos jogos',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.User.broke-account',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
