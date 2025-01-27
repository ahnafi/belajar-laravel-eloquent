<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PersonTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Person::query()->delete();
    }

    function testPerson()
    {
        $person = new Person();
        $person->first_name = "budiono";
        $person->last_name = "siregar";
        $person->save();

        self::assertEquals("BUDIONO siregar", $person->full_name);

        $person->full_name = "Joko Moro";
        $person->save();

        self::assertEquals("JOKO", $person->first_name);
        self::assertEquals("Moro", $person->last_name);
    }

    public function testAttributeCasting()
    {
        $person = new Person();
        $person->first_name = "budiono";
        $person->last_name = "siregar";
        $person->save();

        self::assertNotNull($person->created_at);
        self::assertNotNull($person->updated_at);
        self::assertInstanceOf(\Carbon\Carbon::class, $person->updated_at);
        self::assertInstanceOf(\Carbon\Carbon::class, $person->created_at);
    }

    public function testCustomCast()
    {
        $person = new Person();
        $person->first_name = "budiono";
        $person->last_name = "siregar";
        $person->address = new Address("Jalan belum jadi", "Banyumas", "Indonesia", "444556");
        $person->save();

        $person = Person::query()->find($person->id);
        self::assertInstanceOf(Address::class, $person->address);
        self::assertNotNull($person->address);
        self::assertEquals("Jalan belum jadi", $person->address->street);
        self::assertEquals("Banyumas", $person->address->city);
        self::assertEquals("Indonesia", $person->address->country);
        self::assertEquals("444556", $person->address->postal_code);
    }
}
