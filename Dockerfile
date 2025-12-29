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

# Salin seluruh kode
COPY . /var/www

# Berikan izin akses
RUN chown -R www-data:www-data /var/www

# Copy script entrypoint dan buat dia bisa dijalankan
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

EXPOSE 9000

CMD ["php-fpm"]