<?php

namespace AppForwardBundle\Manager;

class MailAddress
{
    public static function generateMailAddress($username, $website) {
        $start = md5($username.$website.microtime()."1234");
        $end = "@zz2postfixproject.fr";
        return $start.$end;
    }
}