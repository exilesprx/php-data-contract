<?php

namespace App\events\contracts;

use App\events\contracts\types\TypeContract;
use App\services\Container;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class DataContract
{
    protected Container $container;

    protected Collection $rules;

    public function __construct(array $definition)
    {
        $this->container = new Container();

        $this->rules = new Collection();

        $this->makeRules($definition);
    }

    public function validate(Collection $data) : void
    {
        $this->addDefaults($data);

        $this->rules->each(function(TypeContract $type) use ($data) {
            $value = $data->get($type->getPropertyName());

            $type->assertValueConforms($value);
        });
    }

    public function getRules() : Collection
    {
        return $this->rules;
    }

    private function makeRules($definition) : void
    {
        $propertyRules = Arr::get($definition, 'properties');
        $required = Arr::get($definition, 'required');

        foreach ($propertyRules as $property => $ruleAttributes) {

            if (in_array($property, $required)) {
                $ruleAttributes['required'] = true;
            }

            $this->rules->add(
                $this->container->make($property, $ruleAttributes)
            );
        }
    }

    private function addDefaults(Collection $data) : void
    {
        $this->rules->each(function(TypeContract $type) use($data) {
            $default = $type->getDefault();

            if (! $default) {
                return;
            }

            if (! $data->has($type->getPropertyName())) {
                $data->put($type->getPropertyName(), $default);
            }
        });
    }
}