<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\Showing;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    public function run(): void
    {
        $movies = [
            [
                'title'            => 'Galactic Odyssey',
                'description'      => 'A crew of intrepid astronauts ventures beyond the known galaxy in search of a habitable world, only to encounter an ancient alien civilisation with their own agenda for humanity.',
                'genre'            => 'Sci-Fi',
                'duration_minutes' => 148,
                'release_date'     => '2025-09-12',
                'ticket_price'     => 14.99,
                'poster_url'       => 'https://images.unsplash.com/photo-1465101162946-4377e57745c3?w=600&q=80',
                'total_seats'      => 120,
            ],
            [
                'title'            => 'Shadows of Verona',
                'description'      => 'A brooding detective hunts a serial killer through the rain-drenched streets of a fictional Italian city, uncovering a conspiracy that reaches the highest corridors of power.',
                'genre'            => 'Thriller',
                'duration_minutes' => 122,
                'release_date'     => '2025-08-01',
                'ticket_price'     => 12.99,
                'poster_url'       => 'https://images.unsplash.com/photo-1534809027769-b00d750a6bac?w=600&q=80',
                'total_seats'      => 100,
            ],
            [
                'title'            => 'The Laughing Kingdom',
                'description'      => 'Two misfit royal siblings must join forces with a talking dragon and a loveable thief to save their kingdom from an army of enchanted statues.',
                'genre'            => 'Animation',
                'duration_minutes' => 98,
                'release_date'     => '2025-07-04',
                'ticket_price'     => 10.99,
                'poster_url'       => 'https://images.unsplash.com/photo-1560109947-543149eceb16?w=600&q=80',
                'total_seats'      => 150,
            ],
            [
                'title'            => 'Iron Meridian',
                'description'      => 'An elite soldier is captured behind enemy lines and must survive against impossible odds while a covert rescue operation races against the clock.',
                'genre'            => 'Action',
                'duration_minutes' => 135,
                'release_date'     => '2025-10-24',
                'ticket_price'     => 13.99,
                'poster_url'       => 'https://images.unsplash.com/photo-1519682337058-a94d519337bc?w=600&q=80',
                'total_seats'      => 110,
            ],
            [
                'title'            => 'Last Train to Harlow',
                'description'      => 'A chance encounter on an overnight train sparks an unexpected romance between a struggling musician and a corporate lawyer with a secret past.',
                'genre'            => 'Romance',
                'duration_minutes' => 107,
                'release_date'     => '2025-06-14',
                'ticket_price'     => 11.99,
                'poster_url'       => 'https://images.unsplash.com/photo-1474487548417-781cb71495f3?w=600&q=80',
                'total_seats'      => 90,
            ],
            [
                'title'            => 'Hollow Earth',
                'description'      => 'A geologist leading a routine survey team discovers an enormous cavern system beneath Antarctica that is very much alive — and very hostile.',
                'genre'            => 'Adventure',
                'duration_minutes' => 118,
                'release_date'     => '2025-11-07',
                'ticket_price'     => 14.99,
                'poster_url'       => 'https://images.unsplash.com/photo-1504192010706-dd7f569ee2be?w=600&q=80',
                'total_seats'      => 130,
            ],
        ];

        foreach ($movies as $data) {
            $movie = Movie::create($data);

            // Create 3 upcoming showings per movie
            $halls = ['Hall 1', 'Hall 2', 'IMAX'];
            foreach ($halls as $i => $hall) {
                Showing::create([
                    'movie_id'        => $movie->id,
                    'show_time'       => now()->addDays(random_int(1, 14))->setTime(10 + ($i * 4), 0),
                    'hall'            => $hall,
                    'available_seats' => $movie->total_seats,
                ]);
            }
        }
    }
}
