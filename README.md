## udemy Laravel 講座

## インストール方法

./vendor/bin/sail up -d
composer install
npm install
npm run dev
.env.example をコピーして .env ファイルを作成

.env ファイルの中の下記をご利用の環境に合わせて変更してください。

APP_PORT=8000
DB_HOST=mariadb
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_umarche
DB_USERNAME=umarche
DB_PASSWORD=password123
STRIPE_PUBLIC_KEY
STRIPE_SECRET_KEY

コンテナを起動した後に
./vendor/bin/sail bash
php artisan migrate:fresh --seed

と実行してください。(データベーステーブルとダミーデータが追加されれば OK)

最後に php artisan key:generate と入力してキーを生成

## インストール後の実施事項

-   画像のダミーデータは public/images フォルダ内に sample1.jpg ~ sample5.jpg として保存している

1. php artisan storage:link で storage フォルダにリンクを作る
2. storage/app/public/products フォルダ内に保存すると表示される(ファルダがない場合作成)
3. ショップの画像も表示する場合は storage/app/public/shops フォルダを作成し、画像を保存する
