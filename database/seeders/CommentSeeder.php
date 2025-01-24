<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Product;
use App\Models\Voucher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $product = Product::find('1');

        for ($i = 0; $i < 5; $i++) {
            $comment = new Comment();
            $comment->email = "budi@gmail.com";
            $comment->title = "budi";
            $comment->comment = "komentar ke $i";

            $comment->commentable_id = $product->id;
            $comment->commentable_type = 'product';
            $comment->save();
        }

        $voucher = Voucher::query()->first();

        $comment2 = new Comment();
        $comment2->email = "budi@gmail.com";
        $comment2->title = "budi";
        $comment2->comment = "ini gimana cara pakai voucher";

        $comment2->commentable_id = $voucher->id;
        $comment2->commentable_type = 'voucher';
        $comment2->save();
    }
}
