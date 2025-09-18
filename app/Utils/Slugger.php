<?php

namespace App\Utils;

class Slugger
{
    public static function slugify($string)
    {
        $string = mb_strtolower($string, 'UTF-8');
        $string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
        $string = preg_replace('/[^a-z0-9]+/', '-', $string);
        $string = preg_replace('/-+/', '-', $string);

        return trim($string, '-');
    }
}
