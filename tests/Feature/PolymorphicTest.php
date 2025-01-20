<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Image;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\ImageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class PolymorphicTest extends TestCase
{

    use RefreshDatabase;

    function testOneToOnePolymorphic()
    {
        $this->seed([CustomerSeeder::class, ImageSeeder::class]);

        $customer = Customer::find("budi");
        self::assertNotNull($customer);

        $image = $customer->image;

        Log::info(json_encode($image, JSON_PRETTY_PRINT));

        self::assertNotNull($image);
        self::assertEquals('https://picsum.photos/536/354', $image->url);

    }
}
