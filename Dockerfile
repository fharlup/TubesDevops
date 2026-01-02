FROM php:8.2-fpm

WORKDIR /var/www

# Install dependensi sistem & Node.js
RUN apt-get update && apt-get install -y \
    build-essential libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    locales zip jpegoptim optipng pngquant gifsicle vim unzip git curl \
    libonig-dev libzip-dev libgd-dev \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install ekstensi PHP
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Salin composer files dulu untuk cache layer
COPY composer.json composer.lock /var/www/

# Install dependencies (FIXED: include dev deps untuk avoid Pail error)
RUN composer install --optimize-autoloader --no-interaction

# Salin seluruh kode
COPY . /var/www

# Install frontend dependencies dan build
RUN npm install && npm run build

# Berikan izin akses
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage \
    && chmod -R 755 /var/www/bootstrap/cache

# Copy dan set permissions untuk entrypoint
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 9000

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["php-fpm"]