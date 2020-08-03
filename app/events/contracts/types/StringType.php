<?php

namespace App\events\contracts\types;

use PHPUnit\Framework\Assert;

class StringType extends DataType
{
    public static function getType() : string
    {
        return "string";
    }

    protected function meetsType($data): void
    {
        Assert::assertIsString($data, sprintf("%s must be of type %s", $this->property, self::getType()));
    }
}