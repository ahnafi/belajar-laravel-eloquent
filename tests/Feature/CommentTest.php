<?php

namespace Tests\Feature;

use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CommentTest extends TestCase
{
    function setUp(): void
    {
        parent::setUp();
        DB::delete("delete from comments");
    }

    function testCreateComment()
    {

        $comment = new Comment();
        $comment->email = "contoh@gmail.com";
        $comment->title = "ini contoh comment";
        $comment->comment = "contoh comment bagian comment";
        $comment->created_at = new \DateTime();

        $comment->save();

        self::assertNotNull($comment->id);

    }

    function testDefaultAttributeValues()
    {
        $comment = new Comment();
        $comment->email = "contoh@gmail.com";
        $comment->created_at = new \DateTime();
        $comment->updated_at = new \DateTime();


        $comment->save();

        self::assertNotNull($comment->id);

    }
}
