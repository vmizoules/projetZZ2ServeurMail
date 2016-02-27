<?php

namespace AppForwardBundle\Manager;

class MailAddress
{
    public static function generateMailAddress($username, $website) {
        $start = md5($username.$website.microtime()."caca");
        $end = "@projetmail.zz2";
        return $start.$end;
    }
}