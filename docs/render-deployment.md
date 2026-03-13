# Render Deployment Guide

## Overview

This project is a Laravel monolith (PHP + Blade + server-side routing + database-backed flows).
Render is a suitable host for this architecture.

This repository now includes:

- `Dockerfile` for Render web service runtime
- `.dockerignore` for smaller image contexts
- `render.yaml` blueprint for one-click service setup

## Create a Render Web Service

1. In Render, click **New +** -> **Web Service**.
2. Connect this GitHub repository.
3. Set branch to `main`.

Use these service settings:

- Runtime: `Docker`
- Region: closest to your users
- Auto-Deploy: `Yes`

If you use Render Blueprints, `render.yaml` can create the service with baseline environment variables.

## Required Environment Variables in Render

Set these in your Render service (or confirm values from `render.yaml`):

- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_URL=https://<your-render-service>.onrender.com`
- `APP_KEY=<generated-laravel-app-key>`
- `LOG_CHANNEL=stderr`
- `LOG_LEVEL=info`

Database variables:

- `DB_CONNECTION`
- `DB_HOST`
- `DB_PORT`
- `DB_DATABASE`
- `DB_USERNAME`
- `DB_PASSWORD`

You can use Render Postgres and copy connection values into these keys.

## Post-Deploy Commands

After first successful deploy, open Render Shell and run:

1. `php artisan migrate --force`
2. `php artisan config:cache`
3. `php artisan route:cache`
4. `php artisan view:cache`

If this demo app uses seed data in production:

1. `php artisan db:seed --force`

## Notes for This Repository

- Bookings and admin flows require a working database.
- If using queues later, configure `QUEUE_CONNECTION` and add a separate Render worker.
- For file uploads, prefer an external object store (for example S3) instead of local disk.

## Local Validation Before Push

Run these commands locally before deploying:

1. `composer install`
2. `php artisan test`
3. `npm install`
4. `npm run build`
