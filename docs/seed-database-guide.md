# Seed Database Guide (Movies + Bookings)

This document explains exactly what seed data is created and how to import it into the SQLite database used on Render.

## 1) Movies created by the seeder

Source: `database/seeders/MovieSeeder.php`

The seeder creates these 6 movies:

| Title | Genre | Duration (min) | Release Date | Ticket Price | Total Seats | Poster URL |
|---|---:|---:|---|---:|---:|---|
| Galactic Odyssey | Sci-Fi | 148 | 2025-09-12 | 14.99 | 120 | https://images.unsplash.com/photo-1465101162946-4377e57745c3?w=600&q=80 |
| Shadows of Verona | Thriller | 122 | 2025-08-01 | 12.99 | 100 | https://images.unsplash.com/photo-1534809027769-b00d750a6bac?w=600&q=80 |
| The Laughing Kingdom | Animation | 98 | 2025-07-04 | 10.99 | 150 | https://images.unsplash.com/photo-1560109947-543149eceb16?w=600&q=80 |
| Iron Meridian | Action | 135 | 2025-10-24 | 13.99 | 110 | https://images.unsplash.com/photo-1519682337058-a94d519337bc?w=600&q=80 |
| Last Train to Harlow | Romance | 107 | 2025-06-14 | 11.99 | 90 | https://images.unsplash.com/photo-1474487548417-781cb71495f3?w=600&q=80 |
| Hollow Earth | Adventure | 118 | 2025-11-07 | 14.99 | 130 | https://images.unsplash.com/photo-1504192010706-dd7f569ee2be?w=600&q=80 |

Notes:
- Each movie also gets a poster URL and description from the seeder.
- `is_active` defaults to `true` in the migration.

## 2) Showings created by the seeder

Source: `database/seeders/MovieSeeder.php`

For each movie, the seeder creates 3 showings in:
- Hall 1
- Hall 2
- IMAX

So total showings = 6 movies x 3 = 18 showings.

Show times are generated dynamically (random day offset in the next 14 days), so exact timestamps differ each time seeding runs.

## 3) Bookings created by the seeder

Source: `database/seeders/BookingSeeder.php`

The seeder creates 1 booking per showing, so total bookings = 18.

Each booking is generated with:
- customer chosen from this rotating list:
  - Alice Johnson, alice@example.com, 555-0101
  - Bob Martinez, bob@example.com, 555-0102
  - Carol White, carol@example.com, 555-0103
  - David Brown, david@example.com, null
  - Eva Green, eva@example.com, 555-0105
  - Frank Lee, frank@example.com, 555-0106
  - Grace Kim, grace@example.com, null
  - Henry Adams, henry@example.com, 555-0108
- `seats_booked`: random value from 1 to 3
- `total_price`: `seats_booked * movie.ticket_price`
- `booking_reference`: random string like `CIN-XXXXXXXX`
- `status`: `confirmed`

After each booking, `available_seats` is decremented by `seats_booked`.

Because `seats_booked`, `booking_reference`, and show times are randomized, exact booking rows are different on each seed run.

## 4) Best way to import seed data into Render SQLite

### Option A (recommended): Generate data directly on Render

This is the easiest and safest path:

1. Open Render Shell for your service.
2. Run:

```bash
php artisan migrate:fresh --seed --force
```

This recreates tables and loads all mock data (movies, showings, bookings).

If you do not want to drop tables, run this instead:

```bash
php artisan db:seed --force
```

## 5) If you want an exact snapshot you can re-import

If you want a fixed snapshot (same values every time), first seed once, then dump and import that SQLite file.

1. In Render Shell (or locally), after seeding:

```bash
cp /var/www/html/database/database.sqlite /var/www/html/database/database-seed-snapshot.sqlite
```

2. Keep that snapshot file and replace the active DB with it when needed.

This avoids randomness differences between seed runs.

---

If you want fully repeatable data values every time (no random booking references or seat counts), make the seeders deterministic by replacing random generation with fixed arrays.
