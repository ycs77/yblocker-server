# yBlocker Server

## 本地安裝

依賴 Laravel Homestead 環境，PHP 8.0，Node.js 18+。

```bash
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate
yarn
yarn dev
```

產生開發用假資料：

```bash
php artisan db:seed
```
