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

