<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::insert([
                [
                    'title'=> 'Pemrograman PHP',
                    'author' => 'Rizu',
                    'year' => 2024,
                    'stock' => 5,
                ],
                [
                    'title'=> 'Pemrograman Laravel',
                    'author' => 'Diman',
                    'year' => 2025,
                    'stock' => 5,
                ],
                [
                    'title'=> 'Pemrograman JavaScript',
                    'author' => 'Rizu',
                    'year' => 2026,
                    'stock' => 10,
                ],
                [
                    'title'=> 'Pemrograman Python',
                    'author' => 'Rizu',
                    'year' => 2024,
                    'stock' => 0,
                ],
                [
                    'title'=> 'Pemrograman Java',
                    'author' => 'Rizu',
                    'year' => 2024,
                    'stock' => 12,
                ],
                [
                'title'=> 'Pemrograman C++',
                'author' => 'Rizu',
                'year' => 2024,
                'stock' => 4,
            ],
        ]);
    }
}
