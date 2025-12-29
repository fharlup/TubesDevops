#!/bin/bash

# Install dependensi PHP jika folder vendor belum ada
if [ ! -d "vendor" ]; then
    composer install --no-interaction --optimize-autoloader
fi

# Install dependensi JS & Build Vite jika folder node_modules belum ada
if [ ! -d "node_modules" ]; then
    npm install
    npm run build
fi

# Jalankan migrasi database otomatis (opsional)
# php artisan migrate --force

# Jalankan perintah utama Docker (PHP-FPM)
exec "$@"