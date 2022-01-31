# 環境構築

## GitHubからコードをクローン
### アプリケーションのファイル
```
prd $ sudo yum install git-all
dev prd $ git clone https://github.com/Yokota0204/contact_app.git
```
### leonsans
```
dev prd $ cd contact_app/public/lib
dev prd $ git clone https://github.com/Yokota0204/leonsans.git
```
### Cropperjs
```
dev prd $ git clone https://github.com/Yokota0204/cropperjs.git
```
## 環境設定ファイルを作成
```
prd $ vim .env
```
## Docker
### ドッカーの起動
```
# パッケージの更新
prd $ sudo yum update -y
# Dockerのインストール（AWS EC2）
prd $ sudo amazon-linux-extras install docker
# Dockerの起動
prd $ sudo service docker start
```
### ドッカーの設定
```
# インスタンス起動時にDockerの起動を自動化
prd $ sudo systemctl enable docker
# dockerのグループにec2-userを追加
prd $ sudo usermod -a -G docker ec2-user
prd $ grep docker /etc/group
docker:x:992:ec2-user
```
### docker-composeのインストール
```
# バイナリファイルのインストール
prd $ sudo curl -L "https://github.com/docker/compose/releases/download/1.29.2/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose

# 実行権限を付与
prd $ sudo chmod +x /usr/local/bin/docker-compose
prd $ ls -la /usr/local/bin/docker-compose
-rwxr-xr-x 1 root root 12737304  1月 29 14:55 /usr/local/bin/docker-compose

# シンボリックリンクを作成
prd $ sudo ln -s /usr/local/bin/docker-compose /usr/bin/docker-compose

# 確認
prd $ docker-compose --version
docker-compose version 1.29.2, build 5becea4c
```
### サーバー立ち上げ
```
# awsのアクセスキーを登録
prd $ aws configure
prd $ aws ecr get-login-password --profile default | docker login --username AWS --password-stdin [ecrのURI]
Login Succeeded

# 立ち上げ
$ docker-compose up -d
```
## サーバー起動の動作確認
- アプリケーション（開発環境）｜<a href="localhost:3000" target="_blank">localhost:3000</a>

- データベース
```
$ docker-compose exec mariadb  mysql --version
```
## アプリケーションのセットアップ
### デフォルトで必要なデータを用意
```
dev prd $ docker-compose run myapp php artisan db:seed --class=AdminTableSeeder
dev prd $ docker-compose run myapp php artisan db:seed --class=RoleTableSeeder
dev prd $ docker-compose exec mariadb mysql -u root
dev prd | MariaDB [(none)]> use my_database;
dev prd | MariaDB [my_database]> select * from admins;
dev prd | MariaDB [my_database]> select * from roles;
```

### storage/app/publicへアクセス可能にする。
```
dev prd $ docker-compose exec myapp php artisan storage:link
```

### Bootstrapをインストール【開発環境のみ】
```
dev $ docker-compose run myapp composer require laravel/ui
dev $ docker-compose run myapp php artisan ui bootstrap
dev $ docker-compose run myapp npm install && npm run dev
```
### Breeze（ログイン機能）をインストール【開発環境のみ】
```
dev $ docker-compose run myapp composer require laravel/breeze --dev
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