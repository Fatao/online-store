# DRIVE ELITE — ПОЛНАЯ ТЕХНИЧЕСКАЯ ДОКУМЕНТАЦИЯ


**Курс:** 2 курс, Семестр 2
**Дисциплина:** Веб-разработка (Лабораторные работы 1–8)
**Проект:** Финальный проект (Лаб. 5.1)

---

## СОДЕРЖАНИЕ

1. Обзор проекта
2. Технологический стек
3. Структура файлов проекта
4. База данных — схема и таблицы
5. Модели (Models)
6. Контроллеры (Controllers)
7. Маршруты (Routes)
8. Представления (Views)
9. Middleware
10. Бизнес-логика
11. Аутентификация и авторизация
12. Загрузка файлов и изображений
13. Деплой на Railway
14. Установка и запуск локально
15. Лабораторные работы 1–8 — реализация
16. Что нужно улучшить для оценки 4–5
17. Известные ограничения

---

## 1. ОБЗОР ПРОЕКТА

**Название:** Drive Elite
**URL (Railway):** https://online-store-production-69c9.up.railway.app
**Тип:** Онлайн-маркетплейс элитных автомобилей

### Что делает проект

Drive Elite — это полноценный интернет-магазин для продажи премиальных автомобилей. Система позволяет:

- Покупателям: просматривать каталог, фильтровать автомобили, добавлять в корзину, оформлять заказы, оставлять отзывы, управлять профилем
- Администраторам: управлять каталогом автомобилей и брендов, просматривать заказы, управлять клиентами, смотреть статистику

### Бизнес-правила (из задания кафедры)

- Покупки от **5000 ₽** → статус «Постоянный клиент» (VIP)
- VIP-клиенты получают **скидку 2%** на все покупки
- Для каждой продажи фиксируется: клиент, товар, количество, цена, дата продажи, дата доставки
- Единица измерения товара: **шт.** (штуки)

---

## 2. ТЕХНОЛОГИЧЕСКИЙ СТЕК

### Backend
| Технология | Версия | Назначение |
|---|---|---|
| PHP | 8.2 | Серверный язык |
| Laravel | 11.53 | MVC-фреймворк |
| Eloquent ORM | — | Работа с БД |
| Laravel Blade | — | Шаблонизатор |
| Laravel Sessions | — | Сессии пользователей |
| Laravel Migrations | — | Управление схемой БД |

### База данных
| Технология | Версия | Назначение |
|---|---|---|
| MySQL | 8.0 | Основная БД |
| XAMPP | — | Локальный сервер (порт 3307) |
| Railway MySQL | — | Продакшн БД |

### Frontend
| Технология | Назначение |
|---|---|
| HTML5 / CSS3 | Разметка и стилизация |
| CSS Custom Properties | Тема (переменные цветов) |
| Vanilla JavaScript | Галерея, гамбургер-меню, калькулятор |
| Google Fonts | Cinzel, Poppins, Montserrat |
| Chart.js (CDN) | Графики в дашборде |
| Bootstrap Icons (CDN) | Иконки в admin-панели |
| AdminLTE 3 (CDN) | Тема административной панели |

### DevOps
| Технология | Назначение |
|---|---|
| Railway | Хостинг (PaaS) |
| Nixpacks | Сборка на Railway |
| Git / GitHub | Контроль версий |
| php -S | Локальный dev-сервер |

---

## 3. СТРУКТУРА ФАЙЛОВ ПРОЕКТА

```
online-store/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── BrandController.php
│   │   │   │   ├── CarController.php
│   │   │   │   ├── CustomerController.php
│   │   │   │   ├── DashboardController.php
│   │   │   │   └── OrderController.php
│   │   │   ├── Auth/
│   │   │   │   ├── LoginController.php
│   │   │   │   └── RegisterController.php
│   │   │   ├── Shop/
│   │   │   │   ├── BrandController.php
│   │   │   │   ├── CarController.php
│   │   │   │   ├── CartController.php
│   │   │   │   ├── CheckoutController.php
│   │   │   │   ├── FinanceController.php
│   │   │   │   ├── OrderController.php
│   │   │   │   ├── ProfileController.php
│   │   │   │   └── ReviewController.php
│   │   │   └── Controller.php
│   │   └── Middleware/
│   │       └── AdminMiddleware.php
│   ├── Models/
│   │   ├── Brand.php
│   │   ├── Car.php
│   │   ├── Customer.php
│   │   ├── Order.php
│   │   ├── OrderItem.php
│   │   ├── Review.php
│   │   └── User.php (extends Customer)
│   └── Providers/
│       └── AppServiceProvider.php
├── bootstrap/
│   └── app.php                    ← регистрация маршрутов auth.php + admin.php
├── database/
│   ├── migrations/
│   │   ├── 01_create_brands_table.php
│   │   ├── 02_create_customers_table.php
│   │   ├── 03_create_cars_table.php
│   │   ├── 04_create_orders_table.php
│   │   ├── 05_create_order_items_table.php
│   │   └── 06_create_reviews_table.php
│   └── seeders/
│       ├── BrandSeeder.php
│       ├── CarSeeder.php
│       └── DatabaseSeeder.php
├── public/
│   ├── css/
│   │   └── app.css                ← главный CSS-файл (luxury theme)
│   ├── files/
│   │   ├── cars/                  ← копии фото авто (для Windows local dev)
│   │   └── brands/                ← копии лого брендов
│   └── storage/                   ← symlink → storage/app/public
├── resources/
│   ├── css/
│   │   └── app.css                ← копия public/css/app.css
│   └── views/
│       ├── admin/
│       │   ├── brands/
│       │   │   ├── _form.blade.php
│       │   │   ├── create.blade.php
│       │   │   ├── edit.blade.php
│       │   │   └── index.blade.php
│       │   ├── cars/
│       │   │   ├── _form.blade.php
│       │   │   ├── create.blade.php
│       │   │   ├── edit.blade.php
│       │   │   └── index.blade.php
│       │   ├── orders/
│       │   │   ├── details.blade.php
│       │   │   └── index.blade.php
│       │   ├── users/
│       │   │   ├── index.blade.php
│       │   │   └── show.blade.php
│       │   └── dashboard.blade.php
│       ├── auth/
│       │   ├── login.blade.php
│       │   └── register.blade.php
│       ├── layouts/
│       │   ├── admin.blade.php    ← AdminLTE layout
│       │   └── app.blade.php      ← основной layout с hamburger меню
│       ├── orders/
│       │   ├── details.blade.php
│       │   └── history.blade.php
│       └── shop/
│           ├── _car_card.blade.php
│           ├── brand_cars.blade.php
│           ├── brands.blade.php
│           ├── cart.blade.php
│           ├── checkout.blade.php
│           ├── finance.blade.php
│           ├── home.blade.php
│           ├── inventory.blade.php
│           ├── profile.blade.php
│           └── show.blade.php
├── routes/
│   ├── admin.php
│   ├── auth.php                   ← включает captcha маршрут
│   ├── console.php
│   └── web.php
├── storage/
│   └── app/
│       └── public/
│           ├── cars/              ← загруженные фото авто
│           └── brands/            ← загруженные лого брендов
├── .env                           ← переменные окружения
├── nixpacks.toml                  ← конфигурация Railway
└── composer.json
```

---

## 4. БАЗА ДАННЫХ — СХЕМА И ТАБЛИЦЫ

### ER-Диаграмма (текстовая)

```
brands (1) ────────── (N) cars
                            │
                            │ (N)
                       order_items (N) ──── (1) orders (N) ──── (1) customers
                            │
                         reviews (N) ──── (1) customers
```

### Таблица: brands

```sql
CREATE TABLE brands (
    id         BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(255) NOT NULL,
    slug       VARCHAR(255) UNIQUE NOT NULL,
    category   VARCHAR(255) NOT NULL,
    -- Значения category: hypercar | supercar | luxury | luxury_suv | electric_luxury | performance
    logo       VARCHAR(255) NULL,
    featured   TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

### Таблица: customers

```sql
CREATE TABLE customers (
    id           BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name         VARCHAR(255) NOT NULL,
    email        VARCHAR(255) UNIQUE NOT NULL,
    password     VARCHAR(255) NOT NULL,      -- bcrypt hash
    phone        VARCHAR(255) NULL,
    address      VARCHAR(255) NULL,
    role         VARCHAR(255) DEFAULT 'user', -- user | admin
    is_regular   TINYINT(1) DEFAULT 0,        -- VIP статус
    total_spent  DECIMAL(12,2) DEFAULT 0,     -- общая сумма покупок
    remember_token VARCHAR(100) NULL,
    created_at   TIMESTAMP NULL,
    updated_at   TIMESTAMP NULL
);
```

### Таблица: cars

```sql
CREATE TABLE cars (
    id           BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    brand_id     BIGINT UNSIGNED NOT NULL REFERENCES brands(id) ON DELETE CASCADE,
    model        VARCHAR(255) NOT NULL,
    name         VARCHAR(255) NOT NULL,       -- display name
    price        DECIMAL(12,2) NOT NULL,
    unit         VARCHAR(255) DEFAULT 'шт.',
    year         SMALLINT UNSIGNED NULL,
    mileage      INT UNSIGNED NULL,
    horsepower   INT UNSIGNED NULL,
    fuel_type    VARCHAR(255) NULL,           -- Бензин | Дизель | Гибрид | Электро
    transmission VARCHAR(255) NULL,           -- Автомат | Механика
    body_type    VARCHAR(255) NULL,           -- Седан | Купе | Внедорожник | Кабриолет | Хэтчбек
    color        VARCHAR(255) NULL,
    description  TEXT NULL,
    features     TEXT NULL,                   -- comma-separated
    image        VARCHAR(255) NULL,           -- main photo path
    gallery      JSON NULL,                   -- array of additional photo paths
    stock        INT UNSIGNED DEFAULT 1,
    is_active    TINYINT(1) DEFAULT 1,
    is_featured  TINYINT(1) DEFAULT 0,
    created_at   TIMESTAMP NULL,
    updated_at   TIMESTAMP NULL
);
```

### Таблица: orders

```sql
CREATE TABLE orders (
    id               BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    customer_id      BIGINT UNSIGNED NOT NULL REFERENCES customers(id) ON DELETE CASCADE,
    subtotal         DECIMAL(12,2) NOT NULL,
    discount         DECIMAL(12,2) DEFAULT 0,
    total            DECIMAL(12,2) NOT NULL,
    status           VARCHAR(255) DEFAULT 'pending',
    -- Значения: pending | processing | shipped | delivered | cancelled
    sale_date        DATE NOT NULL,
    delivery_date    DATE NULL,
    shipping_address VARCHAR(255) NULL,
    shipping_phone   VARCHAR(255) NULL,
    created_at       TIMESTAMP NULL,
    updated_at       TIMESTAMP NULL
);
```

### Таблица: order_items

```sql
CREATE TABLE order_items (
    id         BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_id   BIGINT UNSIGNED NOT NULL REFERENCES orders(id) ON DELETE CASCADE,
    car_id     BIGINT UNSIGNED NOT NULL REFERENCES cars(id) ON DELETE CASCADE,
    quantity   INT UNSIGNED DEFAULT 1,
    unit_price DECIMAL(12,2) NOT NULL,   -- цена на момент покупки
    subtotal   DECIMAL(12,2) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

### Таблица: reviews

```sql
CREATE TABLE reviews (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    car_id      BIGINT UNSIGNED NOT NULL REFERENCES cars(id) ON DELETE CASCADE,
    customer_id BIGINT UNSIGNED NOT NULL REFERENCES customers(id) ON DELETE CASCADE,
    rating      TINYINT UNSIGNED NOT NULL,  -- 1-5
    comment     TEXT NOT NULL,
    created_at  TIMESTAMP NULL,
    updated_at  TIMESTAMP NULL
);
```

---

## 5. МОДЕЛИ (MODELS)

### Brand.php

```php
// Ключевые методы:
public function cars()                        // HasMany → Car
public static function categoryLabels(): array // ['hypercar' => 'Гиперкары', ...]
```

### Car.php

```php
// Ключевые методы:
public function brand()                // BelongsTo → Brand
public function reviews()              // HasMany → Review
public function orderItems()           // HasMany → OrderItem
public function averageRating(): float // SQL AVG на reviews.rating
public function featuresList(): array  // explode(',', $this->features)

// Касты:
'gallery' => 'array'   // JSON поле автоматически декодируется
```

### Customer.php (extends Authenticatable)

```php
// Константы:
const REGULAR_THRESHOLD = 5000;   // порог VIP в рублях
const REGULAR_DISCOUNT  = 0.02;   // 2% скидка

// Ключевые методы:
public function orders()                     // HasMany → Order
public function reviews()                    // HasMany → Review
public function isAdmin(): bool              // role === 'admin'
public function addSpending(float $amt): void // total_spent += amt; проверка VIP
public function discountRate(): float         // 0.02 если VIP, иначе 0.0
```

### Order.php

```php
// Ключевые методы:
public function customer()                    // BelongsTo → Customer
public function items()                       // HasMany → OrderItem
public static function statusLabels(): array  // ['pending' => 'Ожидает', ...]
public function statusLabel(): string         // human-readable статус
public function statusColor(): string         // CSS цвет по статусу
```

### User.php

```php
// Пустой класс, наследует Customer
// Нужен Laravel для auth по умолчанию
class User extends Customer {}
```

---

## 6. КОНТРОЛЛЕРЫ (CONTROLLERS)

### Shop\CarController

| Метод | Маршрут | Описание |
|---|---|---|
| `home()` | GET / | Главная: featured cars + brands |
| `index(Request)` | GET /inventory | Каталог с фасетными фильтрами + faceted counts |
| `show(Car)` | GET /inventory/{car} | Карточка автомобиля |

**Фасетные счётчики в index():**
Для каждого фильтра (brand, fuel, transmission, body) выполняется отдельный SQL-запрос, применяющий все остальные активные фильтры КРОМЕ своего. Результат — количество автомобилей, которые показал бы этот вариант фильтра в текущем контексте.

### Shop\BrandController

| Метод | Маршрут | Описание |
|---|---|---|
| `index()` | GET /brands | Все бренды сгруппированы по категориям |
| `show(Brand)` | GET /brands/{slug} | Авто конкретного бренда |

### Shop\FinanceController

| Метод | Маршрут | Описание |
|---|---|---|
| `index(Request)` | GET+POST /finance | Калькулятор; POST запускает calculate() |
| `calculate(float, float, int)` | — | price − downPayment ÷ months |

### Shop\CartController

| Метод | Маршрут | Описание |
|---|---|---|
| `index()` | GET /cart | Список, подытог, скидка |
| `add(Request)` | POST /cart/add | Добавить авто в сессию |
| `update(Request)` | POST /cart/update | Изменить количество |
| `remove(Request)` | POST /cart/remove | Удалить позицию |
| `clear()` | POST /cart/clear | Очистить корзину |

Данные хранятся в `session('cart')` как `[car_id => ['qty' => N]]`

### Shop\CheckoutController

| Метод | Маршрут | Описание |
|---|---|---|
| `index()` | GET /checkout | Форма оформления |
| `store(Request)` | POST /checkout | Создать заказ, обновить customer |

**Логика store():**
1. Считает subtotal из корзины
2. Применяет `customer->discountRate()` → discount
3. Создаёт `Order` + все `OrderItem` в транзакции
4. Вызывает `customer->addSpending(grandTotal)` → обновляет total_spent + VIP статус
5. Очищает корзину

### Shop\OrderController

| Метод | Маршрут | Описание |
|---|---|---|
| `index()` | GET /orders | История заказов текущего пользователя |
| `show(Order)` | GET /orders/{order} | Детали заказа (abort 403 если чужой) |

### Shop\ReviewController

| Метод | Маршрут | Описание |
|---|---|---|
| `store(Request)` | POST /reviews | Сохранить отзыв |

### Shop\ProfileController

| Метод | Маршрут | Описание |
|---|---|---|
| `show()` | GET /profile | Форма редактирования профиля |
| `update(Request)` | PUT /profile | Обновить имя, email, телефон, адрес, пароль |

### Auth\LoginController

| Метод | Описание |
|---|---|
| `showForm()` | GET /login |
| `login(Request)` | POST /login → Auth::attempt() → redirect по роли |
| `logout(Request)` | POST /logout → Auth::logout() → session()->invalidate() |

### Auth\RegisterController

| Метод | Описание |
|---|---|
| `showForm()` | GET /register |
| `register(Request)` | POST /register → валидация капчи → Customer::create() → Auth::login() |

### Admin\DashboardController

```php
// Собирает:
$stats          // cars count, customers count, orders count, revenue sum
$recentOrders   // последние 5 заказов
$topCars        // топ-5 авто по orderItems count
$statusBreakdown // группировка заказов по статусу
$regularCount   // VIP клиентов
$newCount       // обычных клиентов
$monthly        // выручка по месяцам за 6 месяцев
```

### Admin\CarController

| Метод | Описание |
|---|---|
| `index()` | Список авто с поиском, пагинация 15 |
| `create()` | Форма создания |
| `store(Request)` | Сохранить + загрузить фото + copyToPublic() |
| `edit(Car)` | Форма редактирования |
| `update(Request, Car)` | Обновить + заменить фото + copyToPublic() |
| `destroy(Car)` | Удалить + удалить файлы |
| `copyToPublic(string)` | Копирует из storage/ в public/files/ |
| `deleteFromPublic(string)` | Удаляет из public/files/ |

### Admin\BrandController

Аналогичен CarController, работает с Brand моделью.

### Admin\OrderController

| Метод | Описание |
|---|---|
| `index(Request)` | Список заказов с фильтром по статусу |
| `show(Order)` | Детали заказа с items, customer |
| `update(Request, Order)` | Обновить статус |

### Admin\CustomerController

| Метод | Описание |
|---|---|
| `index()` | Список клиентов (role=user) с orders count |
| `show(Customer)` | Профиль клиента + история заказов |
| `toggleRegular(Customer)` | Переключить is_regular |

---

## 7. МАРШРУТЫ (ROUTES)

### routes/web.php — Публичные + Auth-protected

```
GET  /                    → Shop\CarController@home              (home)
GET  /inventory           → Shop\CarController@index             (inventory.index)
GET  /inventory/{car}     → Shop\CarController@show              (inventory.show)
GET  /brands              → Shop\BrandController@index           (brands.index)
GET  /brands/{brand:slug} → Shop\BrandController@show            (brands.show)
GET  /finance             → Shop\FinanceController@index         (finance.index)
POST /finance             → Shop\FinanceController@index         (finance.calculate)
GET  /cart                → Shop\CartController@index            (cart.index)
POST /cart/add            → Shop\CartController@add              (cart.add)
POST /cart/update         → Shop\CartController@update           (cart.update)
POST /cart/remove         → Shop\CartController@remove           (cart.remove)
POST /cart/clear          → Shop\CartController@clear            (cart.clear)

[middleware: auth]
GET  /checkout            → Shop\CheckoutController@index        (checkout.index)
POST /checkout            → Shop\CheckoutController@store        (checkout.store)
GET  /orders              → Shop\OrderController@index           (orders.index)
GET  /orders/{order}      → Shop\OrderController@show            (orders.show)
POST /reviews             → Shop\ReviewController@store          (reviews.store)
GET  /profile             → Shop\ProfileController@show          (profile.show)
PUT  /profile             → Shop\ProfileController@update        (profile.update)
```

### routes/auth.php

```
GET  /captcha             → closure (math captcha JSON)          (captcha)
GET  /login               → Auth\LoginController@showForm        (login)
POST /login               → Auth\LoginController@login
GET  /register            → Auth\RegisterController@showForm     (register)
POST /register            → Auth\RegisterController@register
POST /logout              → Auth\LoginController@logout          (logout)
```

### routes/admin.php

```
[middleware: auth, admin] [prefix: admin] [name: admin.]

GET    /admin                         → Admin\DashboardController@index    (admin.dashboard)
GET    /admin/cars                    → Admin\CarController@index           (admin.cars.index)
POST   /admin/cars                    → Admin\CarController@store           (admin.cars.store)
GET    /admin/cars/create             → Admin\CarController@create          (admin.cars.create)
GET    /admin/cars/{car}              → Admin\CarController@show            (admin.cars.show)
PUT    /admin/cars/{car}              → Admin\CarController@update          (admin.cars.update)
DELETE /admin/cars/{car}              → Admin\CarController@destroy         (admin.cars.destroy)
GET    /admin/cars/{car}/edit         → Admin\CarController@edit            (admin.cars.edit)
GET    /admin/brands                  → Admin\BrandController@index         (admin.brands.index)
POST   /admin/brands                  → Admin\BrandController@store         (admin.brands.store)
GET    /admin/brands/create           → Admin\BrandController@create        (admin.brands.create)
PUT    /admin/brands/{brand}          → Admin\BrandController@update        (admin.brands.update)
DELETE /admin/brands/{brand}          → Admin\BrandController@destroy       (admin.brands.destroy)
GET    /admin/brands/{brand}/edit     → Admin\BrandController@edit          (admin.brands.edit)
GET    /admin/orders                  → Admin\OrderController@index         (admin.orders.index)
GET    /admin/orders/{order}          → Admin\OrderController@show          (admin.orders.show)
PUT    /admin/orders/{order}          → Admin\OrderController@update        (admin.orders.update)
GET    /admin/customers               → Admin\CustomerController@index      (admin.customers.index)
GET    /admin/customers/{customer}    → Admin\CustomerController@show       (admin.customers.show)
PUT    /admin/customers/{c}/toggle    → Admin\CustomerController@toggleRegular
```

### bootstrap/app.php — Регистрация маршрутов

```php
->withRouting(
    web: __DIR__.'/../routes/web.php',
    commands: __DIR__.'/../routes/console.php',
    health: '/up',
    then: function () {
        Route::middleware('web')->group(base_path('routes/auth.php'));
        Route::middleware('web')->group(base_path('routes/admin.php'));
    },
)
```

---

## 8. ПРЕДСТАВЛЕНИЯ (VIEWS)

### layouts/app.blade.php

Основной макет для публичного сайта. Содержит:
- Navbar с hamburger-меню для мобильных
- Flash-сообщения (success / error)
- `@yield('content')`
- Footer с копирайтом "Abdulrahman Fatao 2024–2026"
- `@stack('scripts')` для дополнительных JS

### layouts/admin.blade.php

AdminLTE 3 layout. Содержит:
- Левый сайдбар с навигацией
- Верхняя панель с кнопкой "На сайт" и "Выйти"
- Блок контента с flash-сообщениями
- Chart.js и Bootstrap JS подключены через CDN

### shop/home.blade.php

- Hero секция
- Статистика из БД (Car::count, Customer::count, Brand::count)
- Сетка brands (featuredBrands)
- Сетка cars (featured → is_featured=1)
- Блок "Почему Drive Elite"
- CTA секция
- VIP-баннер для авторизованных пользователей

### shop/inventory.blade.php

- Форма поиска
- Форма фильтров с `onchange="this.form.submit()"` на каждом select
- Каждый `<option>` показывает фасетный счётчик: `Ferrari (3)` — число вычислено с учётом других активных фильтров
- Выбранный фильтр показывается БЕЗ числа (оно уже в results counter)
- Значки активных фильтров с кнопкой ✕
- Results counter с правильным склонением (автомобиль/автомобиля/автомобилей)
- Сетка car cards
- Пагинация

### shop/show.blade.php

- Breadcrumb
- Галерея: главное фото + ряд миниатюр
- `onclick="switchImage(this, src)"` на миниатюрах
- Spec boxes (год, л.с., пробег, топливо, КПП, кузов)
- Цена с единицей измерения
- Описание + features pills
- Форма "Купить сейчас" с qty input
- Блок похожих авто
- Reviews list + form

### shop/finance.blade.php

- Select для выбора авто (data-price → JS заполняет поле цены)
- Inputs: price, down_payment, months
- POST → сервер → результат в той же странице
- Показывает: сумма финансирования + ежемесячный платёж

---

## 9. MIDDLEWARE

### AdminMiddleware.php

```php
public function handle(Request $request, Closure $next): Response
{
    if (!Auth::check() || !Auth::user()->isAdmin()) {
        abort(403, 'Доступ запрещён');
    }
    return $next($request);
}
```

Регистрация в `bootstrap/app.php`:
```php
$middleware->alias([
    'admin' => \App\Http\Middleware\AdminMiddleware::class,
]);
```

---

## 10. БИЗНЕС-ЛОГИКА

### VIP-статус и скидка

```php
// Порог: 5000 ₽
// При оформлении заказа:
$discount   = $subtotal * $customer->discountRate(); // 0.02 если VIP
$grandTotal = $subtotal - $discount;

// После оплаты:
$customer->addSpending($grandTotal);
// Внутри addSpending():
$this->total_spent += $amount;
if ($this->total_spent >= self::REGULAR_THRESHOLD) {
    $this->is_regular = true; // VIP присваивается автоматически
}
$this->save();
```

### Математическая капча

```php
// routes/auth.php
$operations = ['+', '-', '*'];
$op = $operations[array_rand($operations)];
$a  = random_int(2, 9);
$b  = random_int(1, 9);

$answer = match($op) {
    '+' => $a + $b,
    '-' => $a - $b,
    '*' => $a * $b,
};

session(['captcha_code' => (string) $answer]);
session()->save(); // принудительное сохранение ДО вывода ответа

return response()->json(['question' => "$a $op $b = ?"]);
```

### Фасетные счётчики (Faceted Search)

```php
// CarController@index
// Счётчик брендов применяет ВСЕ фильтры КРОМЕ brand:
$brandCounts = Car::where('is_active', true)
    ->when($request->filled('fuel_type'),    fn($q) => $q->where('fuel_type', $request->fuel_type))
    ->when($request->filled('transmission'), fn($q) => $q->where('transmission', $request->transmission))
    ->when($request->filled('body_type'),    fn($q) => $q->where('body_type', $request->body_type))
    // ...price и search тоже
    ->selectRaw('brand_id, count(*) as cnt')
    ->groupBy('brand_id')
    ->pluck('cnt', 'brand_id');
// Аналогично для transmission, fuel_type, body_type
```

---

## 11. АУТЕНТИФИКАЦИЯ И АВТОРИЗАЦИЯ

### Регистрация

1. Пользователь заполняет форму `/register` (имя, email, телефон, пароль, капча)
2. JavaScript делает `fetch('/captcha')` → получает вопрос типа "7 × 3 = ?"
3. Пользователь вводит ответ
4. POST `/register` → валидация → проверка капчи → `Customer::create()` с `Hash::make(password)` → `Auth::login()`
5. Редирект на `/` с flash "Добро пожаловать"

### Вход

1. POST `/login` → `Auth::attempt(['email', 'password'])`
2. Успех: `session()->regenerate()`
3. Если `user->isAdmin()` → redirect `/admin/dashboard`
4. Иначе → redirect `/` (или intended URL)

### Защита маршрутов

```
/checkout, /orders/*, /reviews, /profile  → middleware('auth')
/admin/*                                   → middleware('auth', 'admin')
/login, /register                          → middleware('guest')
```

---

## 12. ЗАГРУЗКА ФАЙЛОВ И ИЗОБРАЖЕНИЙ

### Хранение

- `storage/app/public/cars/`    — загруженные фото авто
- `storage/app/public/brands/`  — логотипы брендов
- `public/storage/`             — symlink (создаётся `php artisan storage:link`)
- `public/files/cars/`          — копии для Windows local dev (php -S не поддерживает symlinks)
- `public/files/brands/`        — копии логотипов

### Загрузка (AdminCarController)

```php
if ($request->hasFile('image')) {
    $data['image'] = $request->file('image')->store('cars', 'public');
    // Копируем в public/files/ для локальной разработки
    $this->copyToPublic($data['image']);
}

// Галерея (несколько файлов):
foreach ($request->file('gallery_images') as $file) {
    $path = $file->store('cars', 'public');
    $this->copyToPublic($path);
    $gallery[] = $path;
}
$data['gallery'] = $gallery;
```

### Отображение в views (dual-path)

```blade
{{-- Пробует storage/ (Railway), fallback на files/ (Windows local) --}}
<img src="{{ asset('storage/' . $car->image) }}"
     onerror="this.onerror=null;this.src='{{ asset('files/' . $car->image) }}'">
```

---

## 13. ДЕПЛОЙ НА RAILWAY

### nixpacks.toml

```toml
[phases.setup]
nixPkgs = ["php82", "php82Extensions.gd", "php82Extensions.pdo",
           "php82Extensions.pdo_mysql", "php82Extensions.mbstring",
           "php82Extensions.tokenizer", "php82Extensions.xml",
           "php82Extensions.curl", "php82Extensions.fileinfo", "php82Extensions.zip"]

[phases.build]
cmds = [
  "composer install --no-dev --optimize-autoloader",
  "php artisan config:cache",
  "php artisan route:cache",
  "php artisan view:cache",
  "php artisan migrate --force",
  "php artisan storage:link"
]

[start]
cmd = "php artisan serve --host=0.0.0.0 --port=$PORT"
```

### Переменные окружения на Railway

```env
APP_NAME="Drive Elite"
APP_ENV=production
APP_KEY=base64:...
APP_DEBUG=false
APP_URL=https://online-store-production-69c9.up.railway.app

DB_CONNECTION=mysql
DB_HOST=...   (из Railway MySQL сервиса)
DB_PORT=3306
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=...

SESSION_DRIVER=file
CACHE_STORE=file
FILESYSTEM_DISK=public
```

### Railway Volume

- Mount path: `/app/public/files`
- Обеспечивает сохранность загруженных изображений между деплоями

### Создание администратора на Railway

```bash
# В Railway Console:
php artisan tinker --execute="
\App\Models\Customer::create([
    'name'     => 'Admin',
    'email'    => 'admin@driveelite.com',
    'password' => bcrypt('password123'),
    'role'     => 'admin',
]);
echo 'Admin created';
"
```

---

## 14. УСТАНОВКА И ЗАПУСК ЛОКАЛЬНО

### Требования

- PHP 8.2+ с расширениями: pdo_mysql, mbstring, tokenizer, xml, gd, fileinfo
- MySQL 8.0 (XAMPP рекомендован, порт 3307)
- Composer
- Git

### Шаги установки

```bash
# 1. Клонировать репозиторий
git clone <repo-url>
cd online-store

# 2. Установить зависимости
composer install

# 3. Скопировать .env
cp .env.example .env

# 4. Настроить .env:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3307
# DB_DATABASE=online_store_db
# DB_USERNAME=root
# DB_PASSWORD=

# 5. Сгенерировать ключ
php artisan key:generate

# 6. Создать БД в phpMyAdmin: online_store_db

# 7. Запустить миграции и сиды
php artisan migrate:fresh --seed

# 8. Создать symlink для storage
php artisan storage:link

# 9. Скопировать изображения для локального dev
mkdir -p public/files/cars public/files/brands
cp storage/app/public/cars/* public/files/cars/ 2>/dev/null
cp storage/app/public/brands/* public/files/brands/ 2>/dev/null

# 10. Запустить сервер
php -S 127.0.0.1:8001 -t public

# 11. Открыть в браузере
# http://127.0.0.1:8001
```

### Создание администратора локально

```bash
php artisan tinker --execute="
\App\Models\Customer::create([
    'name'     => 'Admin User',
    'email'    => 'admin@driveelite.com',
    'password' => bcrypt('admin123'),
    'role'     => 'admin',
]);
echo 'Done';
"
```

---

## 15. ЛАБОРАТОРНЫЕ РАБОТЫ 1–8 — РЕАЛИЗАЦИЯ

### ЛР 1 — Математические операции

**Требование:** +, −, ×, ÷ как отдельные функции, 3 параметра на вход, результат на выход.

**Где реализовано:**

| Операция | Где | Код |
|---|---|---|
| Сложение (+) | Customer::addSpending() | `$this->total_spent += $amount` |
| Вычитание (−) | CheckoutController::store() | `$grandTotal = $subtotal - $discount` |
| Умножение (×) | CheckoutController::store() | `$discount = $subtotal * $customer->discountRate()` |
| Деление (÷) | FinanceController::calculate() | `$monthlyPayment = $financedAmount / $months` |

FinanceController::calculate(float $price, float $downPayment, int $months) — 3 параметра, возвращает массив результатов.

---

### ЛР 2 — Поиск по нескольким критериям, POST

**Требование:** Поиск по 2+ поисковикам, выбор поисковика, POST-запрос.

**Где реализовано:**
- `/inventory` — 7 независимых фильтров (каждый = отдельный "поисковик")
- Форма финансового калькулятора использует `method="POST"`
- Каждый фильтр при изменении делает `onchange="this.form.submit()"`

---

### ЛР 3 — Серверный калькулятор

**Требование:** Калькулятор с серверными вычислениями, использовать функции из ЛР 1.

**Где реализовано:**
- Страница `/finance` — форма POST → FinanceController → результат на сервере
- Использует ÷ и − из ЛР 1

---

### ЛР 4 — Галерея фотографий

**Требование:** Галерея с превью, клик для полного размера, пути в БД.

**Где реализовано:**
- `cars.image` — главное фото (VARCHAR путь)
- `cars.gallery` — JSON массив дополнительных фото
- Загрузка через admin форму (main + multiple gallery)
- `/inventory/{id}` — thumbnail ряд + JS переключатель: `onclick="switchImage(this, src)"`

---

### ЛР 5 — Форма отзывов, средняя оценка

**Требование:** Отзывы в БД, показ N последних, средняя оценка.

**Где реализовано:**
- Таблица `reviews` (car_id, customer_id, rating 1-5, comment)
- CSS star picker на форме (flex row-reverse trick)
- `Car::averageRating()` → SQL AVG
- Показываются все отзывы для данного авто

---

### ЛР 6 — CRUD каталога

**Требование:** Создание, редактирование, удаление элемента каталога, обновление в БД.

**Где реализовано:**
- `/admin/cars` — полный CRUD с загрузкой фото
- `/admin/brands` — полный CRUD с загрузкой логотипа
- Laravel Resource Controllers
- Кнопки "Сохранить" и "Удалить" с confirm() диалогом

---

### ЛР 7 — Регистрация и авторизация

**Требование:** Форма регистрации, сессия, только админ в "Админку", дополнительные блоки после входа.

**Где реализовано:**
- RegisterController → Hash::make(password) → Auth::login()
- LoginController → Auth::attempt() → session()->regenerate() → redirect по роли
- AdminMiddleware → abort(403) если не admin
- После входа: имя, VIP-badge, Orders, Admin (если admin), Profile
- Для гостей: Войти + Регистрация

---

### ЛР 8 — Капча

**Требование:** Аналог капчи (вариант 1: математические операции из предыдущих работ).

**Где реализовано:**
- GET /captcha → random_int(2,9) OP random_int(1,9) → ответ в session → JSON вопрос
- JavaScript fetch() загружает вопрос на страницу
- Кнопка "↻ Обновить" делает новый fetch
- RegisterController проверяет введённый ответ vs session('captcha_code')

---

## 16. ЧТО НУЖНО УЛУЧШИТЬ ДЛЯ ОЦЕНКИ 4–5

При пересдаче на последнем курсе рекомендуется добавить:

### Для оценки 4:

1. **Google Maps** на странице контактов или дилера (требование стека: Maps: Google Maps)
2. **Bootstrap 5** заменить кастомный CSS на Bootstrap 5 (требование стека)
3. **Chart.js** расширить — добавить дополнительные графики (количество заказов по месяцам, популярные бренды)
4. **Тесты** — написать Feature Tests для регистрации, заказа, CRUD
5. **Валидация на клиенте** — добавить HTML5 валидацию + JS
6. **Поиск по году выпуска** — добавить фильтр по году в каталоге
7. **Wishlist / Избранное** — сохранение в сессии или БД

### Для оценки 5:

1. **AdminLTE 3 полностью** — все admin-views переписать на AdminLTE компоненты (сейчас только layout использует AdminLTE, таблицы — кастомные)
2. **AJAX корзина** — добавление в корзину без перезагрузки страницы
3. **Сравнение авто** — страница сравнения характеристик 2-3 авто
4. **История поиска** — сохранять последние поиски в сессии
5. **Email уведомления** — письмо при регистрации и оформлении заказа
6. **Пагинация в API** — REST API endpoints для авто
7. **Экспорт в PDF/Excel** — отчёт по заказам для администратора
8. **Ratings для брендов** — средний рейтинг по отзывам на авто бренда
9. **Полноценные тесты** — Unit + Feature tests покрытием >70%
10. **Docker** — добавить docker-compose для воспроизводимой среды разработки

---

## 17. ИЗВЕСТНЫЕ ОГРАНИЧЕНИЯ

| Ограничение | Причина | Решение |
|---|---|---|
| php -S не поддерживает symlinks на Windows | Windows не создаёт POSIX symlinks | Используем public/files/ как копию |
| Изображения пропадают при редеплое | Railway ephemeral filesystem | Railway Volume на /app/public/files |
| Нет реального платёжного шлюза | Учебный проект | Можно добавить Stripe в будущем |
| Сессии хранятся в файлах | SESSION_DRIVER=file | На Railway может не работать при масштабировании; нужен Redis |
| Нет email-уведомлений | MAIL_MAILER=log | Настроить SMTP (Mailgun, SendGrid) |
| Нет Google Maps | Не успели | Добавить при пересдаче |
| Bootstrap 5 не используется | Кастомный CSS | Миграция на Bootstrap 5 при пересдаче |

---

## ИТОГ

**Drive Elite** — полноценный Laravel 11 интернет-магазин, реализующий все 8 лабораторных работ в единой системе.
