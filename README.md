# 書籍検索 Web アプリケーション(Google Books Api)

## 環境構築手順

### 前提条件

Docker がインストールされていること

### 1. リポジトリのクローン

```bash
git clone https://github.com/urape/google-book-api.git
cd google-book-api
```

### 2. 環境設定

プロジェクトのルートディレクトリに .env ファイルを作成する

```bash
cp .env.example .env
```

DB 設定を行う

```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password
```

### 3. Laravel Sail のインストールと実行

依存関係をインストールする

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install
```

Laravel Sail を起動する

```bash
./vendor/bin/sail up -d
```

アプリケーションキーを生成する

```bash
./vendor/bin/sail artisan key:generate
```

データベースのマイグレーションを実行する

```bash
./vendor/bin/sail artisan migrate
```

サーバーを起動する

```bash
./vendor/bin/sail up
```

ブラウザで`http://localhost/`にアクセスし、アプリケーションが実行されていることを確認する

サーバーを停止する

```bash
./vendor/bin/sail down
```

### 使用技術

-   Laravel 11
-   Laravel Sail
-   MySQL
-   JavaScript (jQuery)
-   Bootstrap 5
-   Google Books API
