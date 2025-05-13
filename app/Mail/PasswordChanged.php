<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordChanged extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $user;
    public $newPassword;
    
    public function __construct($user, $newPassword)
    {
        $this->user = $user;
        $this->newPassword = $newPassword;
    }
    
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Password Has Been Changed',
        );
    }
    
    public function content(): Content
    {
        return new Content(
            view: 'emails.password-changed',
            with: [
                'name' => $this->user->fullname,
                'username' => $this->user->username,
                'password' => $this->newPassword,
            ],
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
