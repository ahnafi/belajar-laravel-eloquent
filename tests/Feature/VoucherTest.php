<?php

namespace Tests\Feature;

use App\Models\Voucher;
use Database\Seeders\VoucherSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VoucherTest extends TestCase
{
    function testSoftDelete()
    {
        $this->seed(VoucherSeeder::class);

        $voucher = Voucher::query()->where("name", "=", "Sample voucher")->first();
        $voucher->delete();

        $voucher = Voucher::query()->where("name", "=", "Sample voucher")->first();
        self::assertNull($voucher);

//        Voucher::withTrashed()->forceDelete();

        $data = Voucher::withTrashed()->get();
        self::assertNotNull($data);

    }
}
