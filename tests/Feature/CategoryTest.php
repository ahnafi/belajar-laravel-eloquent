<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    function testInsert()
    {
        $category = new Category();

        $category->id = "GADGET";
        $category->name = "gadget";

        $result = $category->save();

        self::assertTrue($result);
    }
}
