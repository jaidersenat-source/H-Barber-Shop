# Barber

Proyecto Laravel (plantilla personalizada) para la gestión de turnos, clientes, productos y servicios de una barbería.

---

## Resumen

Este repositorio contiene una aplicación web construida con Laravel 12, destinada a administrar una barbería: usuarios, turnos, productos, facturas y notificaciones.

Tecnologías principales:
- PHP ^8.2
- Laravel 12
- Vite + TailwindCSS
- Node (Vite)
- Composer
- paquetería adicional: barryvdh/laravel-dompdf, phpoffice/phpspreadsheet

---

## Requisitos

- PHP 8.2 o superior
- Composer
- Node.js (>=16) y npm
- Extensiones PHP comunes: mbstring, bcmath, openssl, pdo, xml, zip, gd (para DOMPDF)
- Base de datos (MySQL, MariaDB, SQLite para pruebas o desarrollo simple)

En Windows puede usar Laragon (recomendado) o XAMPP/WAMP.

---

## Instalación (local)

1. Clona el repositorio y entra en la carpeta del proyecto:

   git clone <repo-url>
   cd Barber-main

2. Instala dependencias PHP con Composer:

   composer install

3. Copia el archivo de entorno y genera la clave de aplicación:

   copy .env.example .env
   php artisan key:generate

4. Configura la conexión a la base de datos en `.env`. Para desarrollo rápido puedes usar SQLite:

   DB_CONNECTION=sqlite
   # crea el archivo si usas sqlite
   touch database/database.sqlite

5. Ejecuta migraciones y seeders si los hay:

   php artisan migrate
   php artisan db:seed --class=DatabaseSeeder

6. Instala dependencias JavaScript y construye los assets:

   npm install
   npm run dev

7. (Opcional) Si usas colas u otros servicios, revisa `.env` y configura drivers.

---

## Ejecución local

Para correr el servidor de desarrollo integrado de Laravel:

   php artisan serve

Luego abre http://127.0.0.1:8000 en tu navegador.

Si trabajas con Vite en modo desarrollo:

   npm run dev

Si deseas ejecutar los comandos definidos en `composer.json`:

   composer run-script setup

---

## Pruebas

Este proyecto usa PHPUnit. Para ejecutar las pruebas:

   ./vendor/bin/phpunit

o usando artisan:

   php artisan test

La configuración de `phpunit.xml` usa SQLite en memoria para acelerar las pruebas.

---

## Estructura del proyecto (resumen)

- `app/` – Lógica de la aplicación: Models, Controllers, Events, Listeners, Mail, Notifications, Providers.
- `bootstrap/` – Archivos de arranque.
- `config/` – Configuraciones.
- `database/` – Migrations, seeders y factories.
- `public/` – Archivos públicos y punto de entrada (`index.php`).
- `resources/` – Vistas Blade, assets sin compilar (css/js).
- `routes/` – Definición de rutas (`web.php`, `console.php`).
- `tests/` – Pruebas unitarias y de integración.

---

## Recomendaciones y notas

- Revisa `composer.json` para dependencias como `barryvdh/laravel-dompdf` (generación de PDFs) y `phpoffice/phpspreadsheet` (exportaciones Excel).
- Para producción, configura correctamente `APP_ENV`, `APP_KEY`, `CACHE`, `QUEUE` y los servicios de correo en `.env`.
- Ejecuta `php artisan config:cache` y `php artisan route:cache` en despliegues para mejorar rendimiento.

---

## Scripts útiles

- `composer run-script setup` — instala dependencias, prepara `.env` y ejecuta migraciones y build de assets.
- `npm run dev` — start Vite en desarrollo.
- `npm run build` — build de producción para assets.
- `php artisan migrate` — ejecutar migraciones.

---

## Próximos pasos sugeridos

- Documentar endpoints API (si existen) y permisos/roles.
- Añadir un Dockerfile / docker-compose para homogeneizar entornos.
- Añadir CI para tests automáticos (Github Actions) y checks de estilo.

---

Si quieres, puedo ajustar el README para incluir pasos específicos de deployment, ejemplos de `.env`, o documentación de endpoints y modelos principales.
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
