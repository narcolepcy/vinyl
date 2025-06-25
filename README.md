## vinyl 

ci/cd

- yarn v3.6.0
- node v20.3.1

## Deploy

### develop
yarn vite : static

yarn dev　: docker起動


### production

本番環境は git-ftp を使用して push しています。

git-ftp が無い方は brew などを用いてインストール

```
brew install git-ftp
```

git-ftp 設定
公開ディレクトリは権限を与えられている FTP ルートなので、下記の通り接続情報を設定します。
接続情報は CIM を参照してください。 \*注意 FTP アカウントを CCD HOLDINGS 内で複数作成しています。使用するアカウントが与えられている権限を確認してください。

```
git config git-ftp.syncroot data
git config git-ftp.url ftp://ccg-hd.sakura.ne.jp/
git config git-ftp.user <user>
git config git-ftp.password <password>
```

初回デプロイ時のみ

```
 git ftp init -v
```

それ以降は

```
 git ftp push

```
