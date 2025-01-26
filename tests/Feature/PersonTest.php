<?php

namespace Tests\Feature;

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
}
