<?php

namespace App\events\contracts\types;

interface TypeContract
{
    public function assertValueConforms($data) : void;
    public function getPropertyName() : string;
    public function getDefault();

    public static function getType() : string;
}