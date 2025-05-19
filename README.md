# 🛒 Laravel + Vue Storefront - Setup & Usage Guide

Welcome to the Storefront project! This is a full-stack e-commerce demo application built with Laravel (backend) and Vue 3 with Pinia and TypeScript (frontend).

## 📦 Features

* Product listing
* Cart with item quantity, price and image
* Persistent cart via token-based storage
* RESTful API using Laravel and invokable controllers
* Cart service, repository, custom exceptions, DTO's
* Bootstrap styling for UI

---

## ⚙️ Requirements

### Backend (Laravel)

* PHP >= 8.1
* Composer
* Laravel >= 10
* MySQL or SQLite

### Frontend (Vue 3)

* Node.js >= 18.x
* npm or yarn

---

## 🚀 Getting Started

### Clone the repository

```bash
git clone git@github.com:AleksandarKurta/store-laravel-vue.git
```

### Project Structure

```
store/
├── store-backend/   # Laravel API
└── store-frontend/  # Vue 3 frontend
```

---

## 🧱 Backend Setup (Laravel)

```bash
cd store-backend
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate --seed
```

### Run the backend

```bash
php artisan serve
```

### API URL

Default: `http://localhost:8000/api`

### Notes:

* Products are seeded with optional ratings.
* You can clear the cache with:

```bash
php artisan cache:clear
```

---

## 🎨 Frontend Setup (Vue 3 + Vite + Pinia)

```bash
cd ../store-frontend
cp .env.example .env
npm install
```

Update `.env` to point to the backend:

```
VITE_API_BASE_URL=http://localhost:8000/api
```

### Run the frontend

```bash
npm run dev
```

Open in browser: `http://localhost:5173`

---

## 🧪 Testing

### Backend Feature Test

```bash
cd store-backend
php artisan test
```

### Frontend Unit Test (Vitest)

```bash
cd store-frontend
npm run test:unit
```

---

## 📂 Key Directories

### Backend

* `App\Http\Controllers\Api\Cart`: Cart controllers (invokable)
* `App\Services\Cart`: Business logic for cart actions
* `App\Repositories\Cart`: Database access and caching logic
* `App\Exceptions`: Custom exceptions for cart handling
* `App\Http\Resources\Cart`: API response formatting

### Frontend

* `src/stores/cart.ts`: Pinia store for managing cart state
* `src/api/cart.ts`: Cart API service
* `src/views/CartView.vue`: Cart page
* `src/components/common/NavBar.vue`: Navigation bar with cart count

---

## 🔐 Cart Token Handling

* On first visit, a UUID cart token is generated and stored in `localStorage`.
* All cart-related API requests use this token.

### 🔒 Authenticated Admin Actions

* Product updates (Sanctum-protected)

---

## 🔄 Product Update API (Authenticated)

### Endpoint

```
PUT /api/products/{id}
```

### Headers

| Header        | Value                             |
| ------------- | --------------------------------- |
| Authorization | Bearer YOUR\_SANCTUM\_TOKEN\_HERE |
| Accept        | application/json                  |
| Content-Type  | application/json                  |

### Request Body Example

```json
{
  "title": "Updated Product Title",
  "price": 49.99,
  "description": "Updated description.",
  "category": "electronics"
}
```

### How to Get a Sanctum Token

php artisan db:seed --class=UserSeeder

Copy the token and set it as Bearer in Postman

### Example Request in Postman

1. Set method: `PUT`
2. URL: `http://localhost:8000/api/product/1`
3. Headers:

   * `Authorization`: Bearer YOUR\_TOKEN
   * `Content-Type`: application/json
4. Body (raw JSON):

```json
{
  "title": "New iPhone 16",
  "price": 1599,
  "description": "The latest iPhone with AI",
  "category": "electronics"
}
```

### Response Example

```json
{
  "data": {
    "id": 1,
    "title": "New iPhone 16",
    "price": "1599.00",
    "description": "The latest iPhone with AI",
    "category": "electronics",
    "updated_at": "2025-05-19T12:00:00Z"
  },
  "message": "Product updated successfully"
}
``