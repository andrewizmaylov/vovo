<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Как и прежде: идеальный фреймворк для быстрого запуска

## ТЗ

Реализовать поиск по товарам с фильтрами
Реализовать HTTP-endpoint (например, GET /api/products), который возвращает список товаров с возможностью фильтрации и сортировки.

У товара должны быть поля:
* id
* name (string, индекс по LIKE или FULLTEXT если захочешь)
* price (decimal)
* category_id (foreign key на таблицу categories)
* in_stock (boolean)
* rating (float, 0–5)
* created_at
* updated_at

Фильтры (через query-параметры):
* q — поиск по подстроке в name
* price_from, price_to
* category_id
* in_stock (true/false)
* rating_from

Сортировка:
параметр sort с допустимыми значениями: price_asc, price_desc, rating_desc, newest.

Обязательна пагинация.

## Реализация

HTTP-endpoint доступен по адресу `/api/products`

По адресу `/api/documentation` доступен Swagger интерфейс

Перед запуском необходимо произвести стандартный набор манипуляций:
* git clone
* copy .env.example .env
* php artisan key:generate
* php artisan migrate --seed

В сидере создается 10 миллионов записей, поэтому процесс довольно долгий, при желании эту цифру можно изменить в файле `DatabaseSeeder`

