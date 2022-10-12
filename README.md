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

