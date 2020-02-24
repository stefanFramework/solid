<?php


class GMailAPI implements IMailer
{
    public function sendMail($subject, $body) {
        return true;
    }
}