<?php
use Symfony\Component\VarDumper\VarDumper;

if (!function_exists('dd')) {
    function dd() {
        array_map(function ($x) {
            (new VarDumper)->dump($x);
        }, func_get_args());

        die(1);
    }
}

if (!function_exists('env')) {
    function env() {
        $env = getenv(func_get_arg(0));
        if ($env == 'env') {

        }
        getenv(func_get_arg(0));
    }
}