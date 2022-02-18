<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Author;

class AuthorTest extends TestCase
{
    use RefreshDatabase;
    /**
     *@test
     */
    public function only_name_is_required_to_create_an_author()
    {
        //$this->withoutExceptionHandling();
        Author::firstOrCreate([
            'name' => 'John'
        ]);

        $this->assertCount(1, Author::All());
    }
}
