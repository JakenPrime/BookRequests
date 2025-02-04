<?php

namespace Database\Seeders;

use App\Models\Books;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'first_name' => 'Dev',
            'last_name' => 'User',
            'email' => 'dev@test.com',
            'password' => 'dev-test',
        ]);
        Books::create([
            'title' => 'The Hobbit',
            'author' => 'Tolkien',
            'publisher' => 'Houghton Mifflin',
            'isbn' => '00000101',
        ]);
        Books::create([
            'title' => 'Dune',
            'author' => 'Herbert',
            'publisher' => 'Chilton Books',
            'isbn' => '00000111',
        ]);
        Books::create([
            'title' => 'Learning 101',
            'author' => 'Knowledgeman',
            'publisher' => 'Smart House',
            'isbn' => '101010101',
        ]);
        Books::create([
            'title' => 'Learn How to Read',
            'author' => 'Notsmartman',
            'publisher' => 'Smart House',
            'isbn' => '01110101',
        ]);
        Books::create([
            'title' => 'Studyology',
            'author' => 'Thatguy',
            'publisher' => 'That House',
            'isbn' => '11000201',
        ]);
        Books::create([
            'title' => 'The ABCs of Math',
            'author' => 'Mathguy',
            'publisher' => 'Math House',
            'isbn' => '11001101',
        ]);
        Books::create([
            'title' => 'BOOK!',
            'author' => 'Bookman',
            'publisher' => 'Book House',
            'isbn' => '123456789',
        ]);
    }
}
