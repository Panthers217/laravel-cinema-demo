<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Showing;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            ['name' => 'Alice Johnson', 'email' => 'alice@example.com', 'phone' => '555-0101'],
            ['name' => 'Bob Martinez',  'email' => 'bob@example.com',   'phone' => '555-0102'],
            ['name' => 'Carol White',   'email' => 'carol@example.com', 'phone' => '555-0103'],
            ['name' => 'David Brown',   'email' => 'david@example.com', 'phone' => null],
            ['name' => 'Eva Green',     'email' => 'eva@example.com',   'phone' => '555-0105'],
            ['name' => 'Frank Lee',     'email' => 'frank@example.com', 'phone' => '555-0106'],
            ['name' => 'Grace Kim',     'email' => 'grace@example.com', 'phone' => null],
            ['name' => 'Henry Adams',   'email' => 'henry@example.com', 'phone' => '555-0108'],
        ];

        $showings = Showing::with('movie')->get();

        foreach ($showings as $index => $showing) {
            $customer = $customers[$index % count($customers)];
            $seats    = rand(1, 3);
            $price    = $seats * $showing->movie->ticket_price;

            Booking::create([
                'showing_id'        => $showing->id,
                'customer_name'     => $customer['name'],
                'customer_email'    => $customer['email'],
                'customer_phone'    => $customer['phone'],
                'seats_booked'      => $seats,
                'total_price'       => $price,
                'booking_reference' => 'CIN-' . strtoupper(Str::random(8)),
                'status'            => 'confirmed',
            ]);

            $showing->decrement('available_seats', $seats);
        }
    }
}