<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\VirtualAccount;
use App\Models\Wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VirtualAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wallet = Wallet::query()->where("customer_id", "budi")->firstOrFail();

        $virtualAccount = new VirtualAccount();
        $virtualAccount->bank = "BCA";
        $virtualAccount->va_number = "2312123123132";
        $virtualAccount->wallet_id = $wallet->id;
        $virtualAccount->save();
    }
}
