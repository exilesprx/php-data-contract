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
        /**
         * Find a dynamic way to iterate all classes that implement the
         * EventDataContract interface and build the definitions array
         * from that.
         */
        return [
            UserCreatedEvent::getEventName() => UserCreatedEvent::getDataContractDefinitions()
        ];
    }
}