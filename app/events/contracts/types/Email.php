<?php

namespace App\events\contracts\types;

use PHPUnit\Framework\Assert;

class Email extends DataType
{
    public static function getType(): string
    {
        return "email";
    }

    protected function meetsType($data): void
    {
        Assert::assertNotFalse(filter_var($data, FILTER_VALIDATE_EMAIL));
    }
}