<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $email;
    public $message;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->name    = $request->name;
        $this->email   = $request->email;
        $this->message = $request->message;
    }

    public function build()
    {
        return $this->subject("Contact")->markdown('emails.contact');
    }
}
