<?php

namespace App\Events;

abstract class Event
{
    use HasDataContract;

    protected array $data;

    protected function __construct(array $data)
    {
        $this->assertDefinitions($data);

        $this->data = $data;
    }

    public static function getEventName() : string
    {
        $name = get_called_class();

        $parts = explode('\\', $name);

        return array_pop($parts);
    }
}