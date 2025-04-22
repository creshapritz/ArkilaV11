<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ClientVerifiedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Client Verified Mail',
        );
    }

    
    public function build()
    {
        return $this->subject('Your ARKILA account is now verified!')
            ->view('emails.client_verified');
    }
    
}
