<?php


class AuthenticationHelper
{
    public static function hash($password) {
        return md5(rand());
    }
}