<?php

namespace App\services;

use App\events\contracts\types\Email;
use App\events\contracts\types\Password;
use App\events\contracts\types\StringType;
use App\events\contracts\types\TypeContract;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class Container
{
    protected Collection $bag;

    public function __construct()
    {
        $this->bag = Collection::make(
            [
                StringType::getType() => StringType::class,
                Email::getType() => Email::class,
                Password::getType() => Password::class
            ]
        );
    }

    public function make(string $property, array $rules) : TypeContract
    {
        $type = Arr::get($rules, 'type');

        $class = $this->bag->get($type);

        return new $class($property, $rules);
    }
}