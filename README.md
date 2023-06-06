# yBlocker Server

## 本地安裝

依賴 PHP 8.1，Node.js 18+。

```bash
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate
yarn
yarn dev
```

從 `.env` 檔中同步管理員帳號：

```bash
php artisan db:seed AdminSyncFromEnv
```

產生開發用假資料：

```bash
php artisan db:seed UserSeeder
```

清除舊紀錄的指令：

```bash
php artisan history:prune-old
```
