<?php

namespace App\Events;

use App\events\contracts\EventDataContract;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use PHPUnit\Framework\Assert;

abstract class Event implements EventDataContract
{
    use HasDataContract;

    protected $data;

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

    public static function getDataContractDefinitions() : array
    {
        $file = sprintf("%s%s%s.json", __DIR__, "/definitions/", Str::kebab(static::getEventName()));

        Assert::assertFileExists($file);

        return json_decode(
            file_get_contents($file),
            true
        );
    }
}