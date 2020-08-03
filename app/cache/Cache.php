<?php

namespace App\Cache;

use App\Events\UserCreatedEvent;
use Illuminate\Support\Arr;

class Cache
{
    public static function get(string $key) : array
    {
        return Arr::get(self::getDefinitions(), $key);
    }

    protected static function getDefinitions() : array
    {
        return [
            UserCreatedEvent::getEventName() => [
                "props" => [
                    "name" => [
                        "required" => true,
                        "length" => 3,
                        "type" => "string"
                    ],
                    "email" => [
                        "required" => true,
                        "length" => 10,
                        "type" => "email"
                    ],
                    "password" => [
                        "required" => true,
                        "length" => 8,
                        "type" => "password"
                    ],
                    "country" => [
                        "required" => false,
                        "length" => 2,
                        "type" => "string",
                        "default" => "USA"
                    ]
                ]
            ]
        ];
    }
}