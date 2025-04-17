<?php

namespace App\Mail;

class NewUserMail extends CustomMail
{
    public $subject = "Bienvenue sur Jacquin Toiture";
    protected $templete = 'newUser';

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(){
        return $this->view('mails.'.$this->templete)
            ->with('data',$this->data)
            ->from($this->fromMail, $this->fromName)
            ->to($this->data['email'])
            ->subject($this->subject);
    }
}

