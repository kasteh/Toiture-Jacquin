<?php

namespace App\Mail;

class PhoneMail extends CustomMail
{
    public $subject = "Quelqu'un à laisser son numéro";
    protected $templete = 'phone';
}
