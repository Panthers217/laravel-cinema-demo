# Laravel Cinema Project Guide for React Developers

This document explains this project using a fullstack React perspective, so you can map familiar JavaScript patterns to Laravel + PHP.

## 1) Quick Mental Model

Think of this project as if it were a single repository with:

- A server app (like Express + ORM)
- A server-rendered UI layer (instead of React components)
- A REST API for JSON consumers
- Database schema + seed scripts

In Laravel, those parts are organized with MVC conventions.

## 2) Folder Mapping: React/Node vs Laravel

### What feels familiar

- Routing exists and is centralized.
- Controllers are like route handlers in Express.
- Models are like Prisma/Sequelize entities.
- Validation is close to Zod/Joi or express-validator.
- Seeders and migrations are equivalent to SQL migration + seed scripts.

### Mapping table

- React/Node route definitions -> Laravel routes in `routes/web.php` and `routes/api.php`
- Express controller functions -> Laravel controllers in `app/Http/Controllers`
- ORM models (Prisma schema + generated client models or Sequelize models) -> Eloquent models in `app/Models`
- JSX pages/components -> Blade templates in `resources/views`
- API endpoints returning JSON -> Controller actions in `app/Http/Controllers/Api`
- Validation middleware/schema -> `$request->validate([...])` inside controller methods
- DB migrations (Knex/Prisma/TypeORM) -> Laravel migrations in `database/migrations`
- Seed scripts -> Laravel seeders in `database/seeders`
- App bootstrap (Express app init) -> `bootstrap/app.php`

## 3) Your Current Project Structure

### Core backend

- `bootstrap/app.php`
  - App bootstrapping and route registration (web + api).

- `routes/web.php`
  - Browser routes for movie listing, movie details, booking flow, and admin pages.

- `routes/api.php`
  - JSON API routes for movies:
  - GET /api/movies
  - GET /api/movies/genres
  - GET /api/movies/{movie}

### Controllers (like Express handlers)

- `app/Http/Controllers/MovieController.php`
  - Public movie list/detail pages.

- `app/Http/Controllers/BookingController.php`
  - Booking form display, booking submit, confirmation page.

- `app/Http/Controllers/Admin/AdminController.php`
  - Admin dashboard, movie CRUD, showings creation, booking list.

- `app/Http/Controllers/Api/MovieApiController.php`
  - API responses for movie data in JSON.

### Models (Eloquent ORM)

- `app/Models/Movie.php`
- `app/Models/Showing.php`
- `app/Models/Booking.php`

These are equivalent to ORM entities/models in Node ecosystems.

### Views (server-rendered UI)

- Public UI:
  - `resources/views/movies/index.blade.php`
  - `resources/views/movies/show.blade.php`
  - `resources/views/bookings/create.blade.php`
  - `resources/views/bookings/confirmation.blade.php`
  - `resources/views/layouts/app.blade.php`

- Admin UI:
  - `resources/views/layouts/admin.blade.php`
  - `resources/views/admin/dashboard.blade.php`
  - `resources/views/admin/movies/*.blade.php`
  - `resources/views/admin/showings/create.blade.php`
  - `resources/views/admin/bookings/index.blade.php`

Blade templates are closest to server-side templating (EJS/Handlebars) rather than client React components.

### Database layer

- Migrations:
  - `database/migrations/2024_01_01_000010_create_movies_table.php`
  - `database/migrations/2024_01_01_000011_create_showings_table.php`
  - `database/migrations/2024_01_01_000012_create_bookings_table.php`

- Seeders:
  - `database/seeders/DatabaseSeeder.php`
  - `database/seeders/MovieSeeder.php`

This is similar to migration + seed files in Node projects.

## 4) Request Lifecycle Compared to React/Node

## Example A: Public movie page

1. User hits `/`
2. `routes/web.php` maps `/` to `MovieController@index`
3. Controller queries `Movie` model
4. Controller returns Blade view `movies.index`
5. HTML is rendered on the server and sent to browser

Equivalent in React stack could be:

- Express route fetches data, then either:
  - sends JSON to React SPA, or
  - renders server template if using SSR

## Example B: Booking form submit

1. User posts to `/showings/{showing}/book`
2. `BookingController@store` validates input
3. Creates booking row
4. Decrements available seats
5. Redirects to confirmation route

Equivalent in Node:

- POST route with validation middleware
- DB transaction/update
- redirect or JSON response

## Example C: API movie fetch

1. Client calls `/api/movies`
2. `routes/api.php` maps to `MovieApiController@index`
3. Controller applies filters and pagination
4. Returns JSON payload

Equivalent in Express:

- `router.get('/movies', handler)` returning JSON.

## 5) Validation Mapping

In this project, validation is in controllers, for example in booking and admin movie actions.

Laravel pattern:

- `$request->validate([...])`

React/Node equivalent:

- Validate body with Zod/Joi/express-validator before DB writes.

Conceptually the same outcome: reject bad input with clear field-level errors.

## 6) Blade vs React Components

### Similarities

- You compose templates/layouts.
- You pass data from controller to UI.
- You can reuse partials (like shared form fragments).

### Differences

- Blade renders on server per request.
- React typically renders on client (or SSR with hydration).
- Blade uses directives like `@if`, `@foreach`, `@extends`, `@section`.

Example in this project:

- Shared admin movie form partial: `resources/views/admin/movies/_form.blade.php`

Think of this partial like a reusable form component used in both create/edit pages.

## 7) Routing: Web vs API

Laravel splits route intent by file:

- `routes/web.php` for browser pages (HTML responses)
- `routes/api.php` for JSON APIs

In Node, you might split similarly:

- `routes/web.js`
- `routes/api.js`

## 8) If You Want a React Frontend Later

You can keep Laravel as API backend and build React separately.

Typical shape:

- Laravel provides `/api/*` endpoints
- React app consumes those endpoints
- Auth can be done with Sanctum/JWT
- Blade pages can be reduced or removed over time

So Laravel can be:

- Fullstack server-rendered app (current setup), or
- API backend for SPA/mobile, or
- Hybrid.

## 9) Where to Edit Common Features

- Add a new page route:
  - `routes/web.php`
  - plus controller action + blade file

- Add a new API endpoint:
  - `routes/api.php`
  - plus API controller method

- Add a new data field:
  - migration + model fillable/casts + form + validation

- Add business rule:
  - usually in controller or model methods/scopes

- Add demo data:
  - `database/seeders/MovieSeeder.php`

## 10) Project Summary in React Terms

This app is effectively:

- Backend framework: Laravel (like Express + batteries included)
- ORM: Eloquent (like Prisma/Sequelize)
- Templates: Blade (like EJS/SSR templates, not SPA components)
- API layer: `/api/movies` endpoints
- Data model: Movies, Showings, Bookings
- Validation: Controller-level request validation
- Seeded local DB for demo use

If you read the app in this order, it will feel natural:

1. `routes/web.php` and `routes/api.php`
2. Controllers used by those routes
3. Models used by controllers
4. Blade views rendered by web controllers
5. Migrations + seeders for DB shape and demo content
