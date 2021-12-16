# 環境構築

## Laravelのインストール
### コードのクローン
```
$ git clone https://github.com/Yokota0204/contact_app.git
```

### サーバー立ち上げ
```
$ docker-compose up
```

### 動作確認
- アプリケーション<br>
<a href="localhost:3000">localhost:3000</a>

- データベース
```
$ docker-compose exec mariadb  mysql --version
```

## ライブラリのインストール
### leonsansをクローン
```
$ cd public/lib
$ git clone https://github.com/cmiscm/leonsans.git
```

### Bootstrapをインストール
```
$ docker-compose run myapp composer require laravel/ui
$ docker-compose run myapp php artisan ui bootstrap
$ docker-compose run myapp npm install && npm run dev
```

### ログイン機能に必要なパッケージ（Breeze）をインストール
```
$ docker-compose run myapp composer require laravel/breeze --dev
```

# 参照

## レポジトリ
- GitHub｜bitnami-docker-laravel - https://github.com/bitnami/bitnami-docker-laravel
- GitHub｜leonsans - https://github.com/cmiscm/leonsans
## 記事
- note｜案件受注サイト構築　②環境構築 - https://note.com/yokota_tech/n/n7f1fdc26c1b2
- note｜案件受注サイト構築　③開発 - https://note.com/yokota_tech/n/nb4b70f3f7366
- Zenn｜【Laravel】Laravel6.*にBootstrap4を導入する2つの方法 - https://zenn.dev/shimotaroo/articles/9f295a5b9c9912
- Reffect｜Laravel Breezeでマルチ認証(Multi Authentification)の徹底解説 - https://reffect.co.jp/laravel/breeze_multi_auth