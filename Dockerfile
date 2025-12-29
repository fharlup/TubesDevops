# Menggunakan image PHP 8.2 FPM sebagai dasar
FROM php:8.2-fpm

# Set working directory di dalam container
WORKDIR /var/www

# Instal dependensi sistem yang diperlukan oleh Laravel
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libonig-dev \
    libzip-dev \
    libgd-dev

# Bersihkan cache apt
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instal ekstensi PHP yang dibutuhkan Laravel
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl

# Perbaikan konfigurasi GD untuk PHP 8.2
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd

# Instal Composer secara langsung dari image resmi Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Salin seluruh isi projek ke dalam working directory di container
COPY . /var/www

# Pastikan folder storage dan bootstrap/cache ada, lalu berikan izin akses
# Penggunaan mkdir -p memastikan folder dibuat jika belum ada
RUN mkdir -p /var/www/storage /var/www/bootstrap/cache && \
    chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Jalankan instalasi dependensi Laravel menggunakan Composer
RUN composer install --no-interaction --optimize-autoloader --no-dev

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

RUN npm install
RUN npm run build

# Expose port 9000 untuk PHP-FPM
EXPOSE 9000

# Jalankan PHP-FPM
CMD ["php-fpm"]