# Тестовое задание: Сервис по аренде или продаже товара

## Описание задачи

Пользователь может:
1. **Купить товар** — закрепить единицу товара за собой навсегда.
2. **Арендовать товар** — взять товар в аренду на определенный срок: 4, 8, 12 или 24 часа.
3. **Продлить аренду** — увеличить срок аренды, при этом общее время аренды не должно превышать 24 часа.

**Особенности:**
- Для покупки или аренды товара у пользователя должен быть достаточный баланс.
- При покупке/аренде пользователь получает идентичный товар.
- При первой проверке статуса купленного/арендованного товара для пользователя генерируется уникальный код, привязанный к товару.

## Требуемая функциональность

### Основные задачи:
1. **Покупка товара.**
2. **Аренда товара.**
3. **Продление аренды товара.**
4. **Проверка статуса товара.**

### Дополнительная функциональность:
5. **История покупок пользователя.** *(опционально)*

## Технические требования

- **Авторизация:** Использование BEARER-токенов для доступа к API. Способ создания, хранения и проверки токенов остается на усмотрение разработчика.
- **Ответы сервиса:**
    - Все ответы должны быть в формате **JSON**.
    - В случае ошибок использовать соответствующие **коды HTTP-состояний**: `500`, `404`, `403`, `401` и т.д.
    - Информация об ошибках должна быть информативной и стандартизированной.
- **Требуемый стек:**
    - PHP 8.2
    - Laravel 10+
    - MySQL
- **Дополнительно (опционально):**
    - Инструменты кеширования.
    - Инструменты для деплоя.
    - Выбор сервера.

## Формат ответа

Каждый API-ответ должен содержать:
- **Код состояния (HTTP).**
- **Статус (`success` или `error`).**
- **Сообщение** (например, описание ошибки или подтверждение успешного действия).
- **Данные** (если применимо).

Пример ответа:

```json
{
  "status": "success",
  "data": {
    "product_id": 1,
    "transaction_id": 123,
    "message": "Product successfully rented"
  },
  "message": "Operation completed successfully"
}
```

### Пример ошибки:

```json
{
  "status": "error",
  "message": "Insufficient balance"
}
```
# Инструкция по разворачиванию проекта KeepCode

Эта инструкция предназначена для демонстрации процесса развертывания решения тестового задания для компании **KeepCode**. Решение выполнено на базе PHP 8.2 с использованием Lumen, Docker и MySQL. Lumen был выбран за свою легковесность, так как приложение представляет собой REST API приложение

---

## Предварительные требования

Перед началом убедитесь, что у вас установлены следующие инструменты:
1. **WSL 2** (рекомендуется дистрибутив Ubuntu).
2. **Docker** и **Docker Compose**.
3. **Git**.
4. **Composer**.

---

## Шаги развертывания

### 1. Клонирование репозитория
Склонируйте проект на вашу локальную машину:

```bash
git clone <URL_репозитория>
cd <название_проекта>
```

---

### 2. Настройка `.env`
1. Скопируйте файл `.env.example` в `.env`:
   ```bash
   cp .env.example .env
   ```

2. Настройте переменные окружения в файле `.env`:
   ```dotenv
   DB_CONNECTION=mysql
   DB_HOST=mysql
   DB_PORT=3306
   DB_DATABASE=keepcode
   DB_USERNAME=keepcoder
   DB_PASSWORD=password
   ```

---

### 3. Сборка и запуск Docker-контейнеров
1. Скомпилируйте и запустите Docker-контейнеры:
   ```bash
   docker-compose up -d
   ```

2. Убедитесь, что все контейнеры работают:
   ```bash
   docker ps
   ```

   Вы должны увидеть три контейнера:
    - `keepcode_app` (PHP-приложение)
    - `keepcode_nginx` (веб-сервер)
    - `keepcode_mysql` (база данных)

---

### 4. Установка зависимостей через Composer
1. Войдите в контейнер приложения:
   ```bash
   docker exec -it keepcode_app bash
   ```

2. Установите зависимости:
   ```bash
   composer install
   ```

3. Выйдите из контейнера:
   ```bash
   exit
   ```

---

### 5. Выполнение миграций и сидов
1. Выполните миграции базы данных:
   ```bash
   docker exec -it keepcode_app php artisan migrate
   ```

2. (Опционально) Заполните базу данных тестовыми данными:
   ```bash
   docker exec -it keepcode_app php artisan db:seed
   ```

---

### 6. Генерация JWT-секрета
Если вы используете JWT для аутентификации, выполните команду:
```bash
docker exec -it keepcode_app php artisan jwt:secret
```

---

### 7. Проверка работы API
1. Приложение доступно по адресу:
   ```plaintext
   http://localhost:8080
   ```

2. Используйте Postman или curl для проверки работы API.

--- 

# API Документация

## Общие сведения
- **Базовый URL**: `http://localhost:8080`
- **Формат данных**: JSON
- **Аутентификация**: Bearer-токен (для защищенных маршрутов)

---

## Эндпоинты

### 1. **Список товаров**
#### Запрос
- **Метод**: `GET`
- **URL**: `/products-list`
- **Аутентификация**: Не требуется

#### Ответ
```json
[
    {
        "id": 1,
        "name": "Product Name",
        "price": 1000,
        "rental": 50,
        ...
    },
    ...
]
```

---

### 2. **Покупка товара**
#### Запрос
- **Метод**: `POST`
- **URL**: `/api/transactions/purchase/{productId}`
- **Аутентификация**: Требуется

#### Пример
```shell
curl -X POST http://localhost:8080/api/transactions/purchase/1 \
  -H "Authorization: Bearer {token}"
```

#### Ответ
```json
{
    "status": "success",
    "data": {
        "id": 123,
        "product_id": 1,
        "type": "purchase",
        ...
    }
}
```

---

### 3. **Аренда товара**
#### Запрос
- **Метод**: `POST`
- **URL**: `/api/transactions/rent/{productId}`
- **Аутентификация**: Требуется

#### Тело запроса
```json
{
    "hours": 12
}
```

#### Пример
```shell
curl -X POST http://localhost:8080/api/transactions/rent/2 \
  -H "Authorization: Bearer {token}" \
  -d '{"hours": 12}'
```

#### Ответ
```json
{
    "status": "success",
    "data": {
        "id": 456,
        "product_id": 2,
        "type": "rental",
        ...
    }
}
```

---

### 4. **Продление аренды**
#### Запрос
- **Метод**: `POST`
- **URL**: `/api/transactions/extend/{productId}`
- **Аутентификация**: Требуется

#### Тело запроса
```json
{
    "hours": 12,
    "transaction_id": 2
}
```

#### Пример
```shell
curl -X POST http://localhost:8080/api/transactions/extend/2 \
  -H "Authorization: Bearer {token}" \
  -d '{"hours": 12, "transaction_id": 2}'
```

#### Ответ
```json
{
    "status": "success",
    "data": {
        "id": 789,
        "rental_end_time": "2024-12-09T12:00:00",
        ...
    }
}
```

---

### 5. **Перевод денег**
#### Запрос
- **Метод**: `POST`
- **URL**: `/api/transfer-money`
- **Аутентификация**: Требуется

#### Тело запроса
```json
{
    "money": 1000
}
```

#### Пример
```shell
curl -X POST http://localhost:8080/api/transfer-money \
  -H "Authorization: Bearer {token}" \
  -d '{"money": 1000}'
```

#### Ответ
```json
{
    "status": "success",
    "data": {
        "new_balance": 1500
    }
}
```

---

### 6. **Просмотр транзакций**
#### Запрос
- **Метод**: `POST`
- **URL**: `/api/get-transactions`
- **Аутентификация**: Требуется

#### Пример
```shell
curl -X POST http://localhost:8080/api/get-transactions \
  -H "Authorization: Bearer {token}"
```

#### Ответ
```json
[
    {
        "id": 1,
        "type": "purchase",
        "product_id": 2,
        ...
    },
    ...
]
```

---

### 7. **Регистрация**
#### Запрос
- **Метод**: `POST`
- **URL**: `/register`
- **Аутентификация**: Не требуется

#### Тело запроса
```json
{
    "name": "Andrew Begeka",
    "email": "begeka15@yandex.ru",
    "password": "password123",
    "password_confirmation": "password123"
}
```

#### Пример
```shell
curl -X POST http://localhost:8080/register \
  -d '{"name": "Andrew Begeka", "email": "begeka15@yandex.ru", "password": "password123", "password_confirmation": "password123"}'
```

#### Ответ
```json
{
    "status": "success",
    "data": {
        "user": {
            "id": 1,
            "name": "Andrew Begeka",
            ...
        },
        "token": "{jwt_token}"
    }
}
```

---

### 8. **Вход**
#### Запрос
- **Метод**: `POST`
- **URL**: `/login`
- **Аутентификация**: Не требуется

#### Тело запроса
```json
{
    "email": "begeka15@yandex.ru",
    "password": "password123"
}
```

#### Пример
```shell
curl -X POST http://localhost:8080/login \
  -d '{"email": "begeka15@yandex.ru", "password": "password123"}'
```

#### Ответ
```json
{
    "status": "success",
    "data": {
        "token": "{jwt_token}"
    }
}
```

---