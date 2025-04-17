<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $templete;
    protected $fromMail = 'contact@site-couvreur.com';
    protected $fromName = 'Site Couvreur';
    protected $toMail = 'dhtoiture@gmail.com';
    public $subject;
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(){
        return $this->view('mails.' . $this->templete)
                    ->with('data', $this->data)
                    ->from($this->fromMail, $this->fromName)
                    ->to($this->toMail)
                    ->subject($this->subject);
    }
}
