<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendInbox extends Mailable
{

    use Queueable,
        SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->from('info@punyaundangan.id', 'Bank Capital')
            ->subject('Pesan masuk info program pensiun')
            ->view('email.send-inbox');
    }
}
