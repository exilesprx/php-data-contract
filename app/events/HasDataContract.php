<?php

namespace App\Events;

use App\Cache\Cache;
use App\events\contracts\DataContract;
use Illuminate\Support\Collection;
use PHPUnit\Framework\Assert;

trait HasDataContract
{
    private function assertDefinitions(Collection $data) : void
    {
        $definition = $this->getDefinitions();

        $definition->validate($data);
    }

    private function getDefinitions() : DataContract
    {
        $cache = Cache::get(self::getEventName());

        Assert::assertTrue(is_array($cache));

        return new DataContract($cache);
    }
}