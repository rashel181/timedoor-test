<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Author;
use App\Models\Category;
use App\Models\Book;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $authors = Author::pluck('id')->all();
        $categories = Category::pluck('id')->all();
        $faker = \Faker\Factory::create();
        $total = 100000;
        $batch = 1000;

        for ($i = 0; $i < $total; $i += $batch) {
            $data = [];
            for ($j = 0; $j < $batch && ($i + $j) < $total; $j++) {
                $data[] = [
                    'title' => $faker->sentence(3),
                    'author_id' => $faker->randomElement($authors),
                    'category_id' => $faker->randomElement($categories),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            Book::insert($data);
        }
    }
}
