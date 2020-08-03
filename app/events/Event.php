<?php

namespace App\Events;

use Illuminate\Support\Collection;

abstract class Event
{
    use HasDataContract;

    protected Collection $data;

    protected function __construct(array $data)
    {
        $this->data = new Collection($data);

        $this->assertDefinitions($this->data);
    }

    public static function getEventName() : string
    {
        $name = get_called_class();

        $parts = explode('\\', $name);

        return array_pop($parts);
    }
}