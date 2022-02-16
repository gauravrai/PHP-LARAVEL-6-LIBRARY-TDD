<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Book;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_book_can_be_added_to_library()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/books', [
            'title' => 'Cool book title',
            'author' => 'Gaurav'
        ]);

        $this->assertCount(1, Book::all());

        $book = Book::first();

        $response->assertRedirect($book->path());
    }

    /** @test*/
    public function a_title_is_required()
    {
        //$this->withoutExceptionHandling();
        $response = $this->post('/books', [
            'title' => '',
            'author' => 'Gaurav'
        ]);

        $response->assertSessionHasErrors('title');
    }

    /** @test*/
    public function a_auhtor_is_required()
    {
        //$this->withoutExceptionHandling();
        $response = $this->post('/books', [
            'title' => 'title ',
            'author' => ''
        ]);

        $response->assertSessionHasErrors('author');
    }

    /** @test*/
    public function a_book_can_be_updated()
    {
        //$this->withoutExceptionHandling();
        $this->post('/books', [
            'title' => 'title ',
            'author' => 'auhtor'
        ]);
        $book = Book::first();
        $response = $this->patch($book->path(), [
            'title' => 'New Title',
            'author' => 'New Author'
        ]);
        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals('New Author', Book::first()->author);

        $response->assertRedirect($book->fresh()->path());
    }

    /** @test*/
    public function a_book_can_be_deleted()
    {
        $this->withoutExceptionHandling();
        $this->post('/books', [
            'title' => 'title ',
            'author' => 'auhtor'
        ]);
        $book = Book::first();
        
        $response = $this->delete($book->path());
        $this->assertCount(0, Book::all());

        $response->assertRedirect('/books');
    }
}
