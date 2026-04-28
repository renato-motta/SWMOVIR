<p>Proyecto inspirado en el siguiente curso de Udemy:</p>

https://www.udemy.com/course/sistema-de-inventario-y-ventas-con-laravel/?couponCode=MT260428G3

Para la parte del backend:

composer install
copy .env.example .env
php artisan key:generate

Configurar la base de datos:

DB_DATABASE=nombre_bd
DB_USERNAME=root
DB_PASSWORD=

Ejecutar migraciones:

php artisan db:seed

Poblar la base de datos con data de los seeders:

php artisan migrate

Para la parte del frontend:

npm i
npm run dev

