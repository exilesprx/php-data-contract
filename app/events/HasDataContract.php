<?php

namespace App\Events;

use App\Cache\Cache;
use App\Values\Password;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use PHPUnit\Framework\Assert;

trait HasDataContract
{
    private function assertDefinitions(array &$data) : void
    {
        $definition = $this->getDefinitions();

        $properties = Arr::get($definition, 'props');

        foreach($properties as $property => $attributes) {
            $this->checkRequired($data, $attributes, $property);

            $data = $this->addDefaultsForMissingAttributes($data, $attributes, $property);

            self::assertContractIsValid($data, $attributes, $property);
        }
    }

    private function getDefinitions() : array
    {
        $cache = Cache::get(self::getEventName());

        Assert::assertIsArray($cache);

        if (!is_array($cache)) {
            return json_decode($cache, true);
        }

        return $cache;
    }

    private function checkRequired(array $data, array $attributes, string $property) : void
    {
        $isRequired = Arr::get($attributes, 'required', false);

        if ($isRequired) {
            Assert::assertArrayHasKey($property, $data, sprintf("%s cannot be found", $property));
        }
    }

    private function addDefaultsForMissingAttributes(array $data, array $attributes, string $property) : array
    {
        return array_merge(
            $data,
            [
                $property => Arr::get($data, $property, Arr::get($attributes, 'default', null))
            ]
        );
    }

    private static function assertContractIsValid(array $data, array $attributes, string $property) : void
    {
        $expectedLength = Arr::get($attributes, 'length', 5);
        $expectedType = Arr::get($attributes, 'type', 'string');

        $item = Arr::get($data, $property);

        self::assertType($expectedType, $property, $item);

        Assert::assertGreaterThanOrEqual($expectedLength, Str::length((string)$item), sprintf("%s must be of length %d", $property, $expectedLength));
    }

    private static function assertType(string $type, string $property, $item) : void
    {
        if ($type == 'string') {
            Assert::assertIsString($item, sprintf("%s must be of type %s", $property, $type));
        }

        if ($type == 'email') {
            Assert::assertNotFalse(filter_var($item, FILTER_VALIDATE_EMAIL));
        }

        if ($type == 'password' && is_string($item)) {
            Assert::assertMatchesRegularExpression(new Password(), $item);
        }
    }
}