<?php


namespace App\service;


class StringUtils{


    public function capitalize($string)
    {

        return ucfirst(mb_strtolower( $string ));
    }

}