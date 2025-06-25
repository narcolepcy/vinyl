# 取り扱い

vite + typescript + react + tailwind + sass + postcss  
※pug は検証中

# 初回

```
$ yarn install
```

# 立ち上げ

```
$ yarn dev
```

# pug

html ファイルを任意の位置に作成し、./src/pug 配下の.pug ファイルを読み込む

```
<!DOCTYPE html>
<html class="no-js" lang="ja">
  <head>
		<!-- これはメタタグとかのテンプレート -->
    <pug src="./pug/head.pug" />
		<!-- このページに関連するJS -->
    <script type="module" src="./js/main.tsx"></script>
  </head>
	<!-- このページで使用するメインテンプレート -->
  <pug src="./pug/index.pug" />
</html>
```

pug の構成自体は以前の static_html_skelton と同じ。  
css や js の自動挿入はやってくれないので scss をインクルードした JS を読み込むなどして、\_layout.pug 内のヘッダで調整する

```
//各コンテンツpugファイル（index.pugとか）内でslug変数で定義した内容を参照して分岐することができる

if slug == 'home'
	script(type='module' src='./js/main.tsx')
```

# Js と scss など

JS 内で scss を必要な文だけ読み込む。  
※ページごとに固有の JS を作ることでビルドファイルのファイルサイズ適正化もされる

```
//main.ts

// 使用するscssをここで読み込んでおく
import 'scss/basis.scss';
import 'scss/pages/home.scss';

```

# ビルド

dist 配下にコンパイルされる

```
$ yarn build
```
