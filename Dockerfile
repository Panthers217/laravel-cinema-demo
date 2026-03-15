FROM node:20-bookworm-slim AS assets

WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY resources ./resources
COPY vite.config.js ./
RUN npm run build

FROM php:8.3-cli-bookworm

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libsqlite3-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql pdo_sqlite mbstring bcmath zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist
COPY --from=assets /app/public/build ./public/build

RUN mkdir -p storage/framework/cache storage/framework/sessions storage/framework/testing storage/framework/views bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

EXPOSE 10000

CMD ["sh", "-c", "if [ \"${DB_CONNECTION}\" = \"sqlite\" ]; then mkdir -p \"$(dirname \"${DB_DATABASE:-/var/www/html/database/database.sqlite}\")\" && touch \"${DB_DATABASE:-/var/www/html/database/database.sqlite}\"; fi && php artisan migrate --force && if [ \"${APP_SEED_ON_BOOT:-true}\" = \"true\" ]; then php artisan db:seed --force; fi && php artisan serve --host=0.0.0.0 --port=${PORT:-10000}"]
