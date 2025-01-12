<?php

namespace Tests\Feature;

use App\Models\voucher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class uuidTest extends TestCase
{
    function setUp(): void
    {
        parent::setUp();
        DB::delete("delete from vouchers");
    }

    function testCreateVoucher()
    {
        $voucher = new Voucher();
        $voucher->name = "sample voucher ";
        $voucher->voucher_code = "12231231231";
        $voucher->save();

        self::assertNotNull($voucher->id);

    }

    function testCreateVoucherUUID()
    {
        $voucher = new Voucher();
        $voucher->name = "sample voucher ";
        $voucher->save();

        self::assertNotNull($voucher->id);
        self::assertNotNull($voucher->voucher_code);

    }
}
