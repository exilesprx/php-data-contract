<?php

namespace Tests;

use App\Cache\Cache;
use App\Events\UserEvent;
use Illuminate\Support\Arr;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

class UserEventTest extends TestCase
{
    /** @test */
    public function it_expects_cache_to_have_definitions()
    {
        $cache = Cache::get(UserEvent::getEventName());

        $this->assertIsArray($cache);
    }

    /** @test */
    public function it_expects_user_event_to_pass()
    {
        UserEvent::fromArray(
            [
                'name' => "Tester",
                'email' => "test@test.com",
                'password' => "1aB%tuperT2$#"
            ]
        );
    }

    /** @test */
    public function it_expects_a_user_name_assertion_to_fail()
    {
        $this->expectException(ExpectationFailedException::class);

        UserEvent::fromArray(
            [
                'name' => "",
                'email' => "test@test.com",
                'password' => "1aB%tuperT2$#"
            ]
        );
    }

    /** @test */
    public function it_expects_all_properties_to_be_set()
    {
        $data = [
            'name' => "Tester",
            'email' => "test@test.com",
            'password' => "1aB%tuperT2$#",
            'country' => "CA"
        ];

        $event = UserEvent::fromArray($data);

        $this->assertEquals(Arr::get($data, 'name'), $event->getName());

        $this->assertEquals(Arr::get($data, 'email'), $event->getEmail());

        $this->assertEquals(Arr::get($data, 'password'), $event->getPassword());

        $this->assertEquals(Arr::get($data, 'country'), $event->getCountry());
    }

    /** @test */
    public function it_expects_country_to_be_the_default()
    {
        $cache = Cache::get(UserEvent::getEventName());

        $event = UserEvent::fromArray(
            [
                'name' => "Tester",
                'email' => "test@test.com",
                'password' => "1aB%tuperT2$#",
            ]
        );

        $this->assertEquals(Arr::get($cache, 'props.country.default'), $event->getCountry());
    }
}