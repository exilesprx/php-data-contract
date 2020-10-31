<?php

namespace App\events\policies;

use PHPUnit\Framework\Assert;

class Password extends DataPolicy
{
    public static function getType(): string
    {
        return "password";
    }

    protected function meetsType($data): void
    {
        Assert::assertMatchesRegularExpression(new \App\events\values\Password(), $data);
    }
}