cara install nya 

awal nya clone dan masukin ke repo nya

terus install laravel
composer install

terus kan pake vite

npm i

buat env nya

cp .env.example .env

janlupa bikin key nya

php artisan key:generate

terus konekin ke env

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=manajemen_rs  # Pastiin database ini udah kamu buat ya
DB_USERNAME=root          # Biasanya 'root'
DB_PASSWORD=    

migrate deh
php artisan migrate

buat run nya spli terminal nya backend nya pake
php artisan serve

buat fe 
npm run dev

http://127.0.0.1:8000



untuk test nya pake table beda yak