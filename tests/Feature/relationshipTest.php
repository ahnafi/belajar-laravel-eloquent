<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Wallet;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\WalletSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class relationshipTest extends TestCase
{

    function setUp(): void
    {
        parent::setUp();
        Wallet::query()->delete();
        Customer::query()->delete();
    }

    public function testOneToOne()
    {
        $this->seed([CustomerSeeder::class, WalletSeeder::class]);

        $customer = Customer::find("budi");
        self::assertNotNull($customer);

        // $wallet = Wallet::where("customer_id", $customer->id)->first();
        $wallet = $customer->wallet;
        self::assertNotNull($wallet);

        self::assertEquals(1000000, $wallet->amount);
    }
}
