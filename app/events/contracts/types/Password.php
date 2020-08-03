<?php

namespace App\events\contracts\types;

use PHPUnit\Framework\Assert;

class Password extends DataType
{
    public static function getType(): string
    {
        return "password";
    }

    protected function meetsType($data): void
    {
        Assert::assertMatchesRegularExpression(new \App\Values\Password(), $data);
    }
}