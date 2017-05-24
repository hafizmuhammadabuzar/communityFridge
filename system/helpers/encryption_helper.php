<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if ( ! function_exists('encode'))
{
    function encode($string) {
        return bin2hex($input);
    }
}

if ( ! function_exists('decode'))
{
    function decode($string) {
        return pack("H*", $input);

        return $decrypted;
    }
}

