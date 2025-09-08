## vinyl 

ci/cd

- yarn v3.6.0
- node v20.3.1

## Deploy

### develop
yarn vite : static

yarn dev　: static起動

docker compose up -d : docker起動

### production

カスタム投稿
・ニュース：news
・単行本作品：book_work
・単行本の巻：book_volume
・単話配信作品：series_work
・単話：episode

＊作品ごとにシングルページを持たせ、その中で巻・単話を呼び出す仕様
＊単行本と単話作品は関連フィールドを持たせ、関連の有無により表示変更などあり