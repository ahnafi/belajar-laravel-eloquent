<?php

namespace Tests\Feature;

use App\Models\Voucher;
use Database\Seeders\VoucherSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VoucherTest extends TestCase
{

    function setUp(): void
    {
        parent::setUp();
        Voucher::query()->delete();
    }

    function testSoftDelete()
    {
        $this->seed(VoucherSeeder::class);

        $voucher = Voucher::query()->where("name", "=", "Sample voucher")->first();
        $voucher->delete();

        $voucher = Voucher::query()->where("name", "=", "Sample voucher")->first();
        self::assertNull($voucher);

        Voucher::withTrashed()->forceDelete();

        $data = Voucher::withTrashed()->get();
        self::assertNotNull($data);

    }

    function testLocalScope()
    {
        $voucher = new Voucher();
        $voucher->name = "sample voucher";
        $voucher->is_active = true;
        $voucher->save();

        $total = Voucher::query()->active()->count();
        self::assertEquals(1, $total);

        $total = Voucher::query()->nonActive()->count();
        self::assertEquals(0, $total);

    }

}
