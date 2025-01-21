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

        $comment = new Comment();
        $comment->email = "budi@gmail.com";
        $comment->title = "budi";
        $comment->comment = "bagus banget produknya";

        $comment->commentable_id = $product->id;
        $comment->commentable_type = Product::class;
        $comment->save();

        $voucher = Voucher::query()->first();

        $comment2 = new Comment();
        $comment2->email = "budi@gmail.com";
        $comment2->title = "budi";
        $comment2->comment = "ini gimana cara pakai voucher";

        $comment2->commentable_id = $voucher->id;
        $comment2->commentable_type = Voucher::class;
        $comment2->save();
    }
}
