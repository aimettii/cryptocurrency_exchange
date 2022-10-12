## Backend:
https://laravel.com/docs/9.x/sail#main-content Развернуть с помощью сейла проще всего


- cd to root directory
- sudo chown -R $USER:$USER .
- cp .env.example .env
- docker run --rm -v $(pwd):/app composer require laravel/sail --dev
- alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
- sail up -d
- sail php artisan key:generate
- sail php artisan migrate

## API Endpoints
- GET http://localhost/api/v1/rates (Получить список всех доступных на сайте пар-валют) params: &filter[currency] (поиск по currency_from символу)

- POST http://app.url/api/v1/convert
    {
        currency_from: 'btc', // Что имеем
        currency_to: 'usd', // На что конвертируем
        value: 1 (кол-во валюты)
    }


## Команды
- php artisan tickers:find btc usd (поиск валютной пары по сервисами)
-  php artisan tickers:create btc usd (Поиск валютной пары и сохранение ее в системе)
-  php artisan tickers:delete btc usd (Удаление валютной пары из системы)

## 3 Задача
Необходимо написать SQL запрос. Запрос должен вывести всех читателей в возрасте от 5 и до 19 лет, которые взяли только 2 книги и все книги одного и того же автора. Можно поиграться с запросом в проекте, таблицы нужные созданы, сидеры тоже
SQL запрос:

`SELECT users.*, (
        SELECT COUNT(*)
        FROM user_books
        WHERE user_books.user_id = users.id
        ) as books_count , (
            select COUNT(DISTINCT books.author) from books
            INNER JOIN user_books on user_books.book_id = books.id
            WHERE user_books.user_id = users.id
        ) as author_count FROM `users`
WHERE `age` BETWEEN 5 AND 19
HAVING books_count = 2 AND author_count = 1`

