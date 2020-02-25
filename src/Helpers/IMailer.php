<?php


interface IMailer
{
    public function sendMail($subject, $body);
}