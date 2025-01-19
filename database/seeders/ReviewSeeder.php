<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $review = new Review();
        $review->customer_id = 'budi';
        $review->product_id = "1";
        $review->rating = 6;
        $review->comment = "bagus banget kualitasnya";
        $review->save();

        $review = new Review();
        $review->customer_id = 'budi';
        $review->product_id = "2";
        $review->rating = 9;
        $review->comment = "bagus banget lumayan";
        $review->save();

    }
}
