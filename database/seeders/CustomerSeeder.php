<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customer = new Customer();
        $customer->id = "budi";
        $customer->name = "budi";
        $customer->email = "budi@gmail.com";

        $customer->save();

    }
}
