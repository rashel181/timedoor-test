<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Rating;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        $total = 500000;
        $batch = 500;

        $minBookId = \App\Models\Book::min('id');
        $maxBookId = \App\Models\Book::max('id');

        for ($i = 0; $i < $total; $i += $batch) {
            $data = [];
            for ($j = 0; $j < $batch && ($i + $j) < $total; $j++) {
                $data[] = [
                    'book_id' => random_int($minBookId, $maxBookId),
                    'rating' => $faker->numberBetween(1, 10),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            Rating::insert($data);
        }
    }
}
