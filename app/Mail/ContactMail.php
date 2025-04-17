<?php

namespace App\Mail;

class ContactMail extends CustomMail
{
    public $subject = "Quelqu'un vous à contacter";
    protected $templete = 'contact';
}
