import react from '@vitejs/plugin-react';
import * as path from 'path';
import { defineConfig, loadEnv } from 'vite';
import liveReload from 'vite-plugin-live-reload';
import pugPlugin from 'vite-plugin-pug';

const root = 'src';
// https://vitejs.dev/config/
export default ({ mode }) => {
  process.env = { ...process.env, ...loadEnv(mode, process.cwd()) };

  const options = { localImports: true, pretty: true };
  const locals = { env: process.env.VITE_MODE };
  return defineConfig({
    //WordPressからviteで建てたサーバを参照する際に必要な設定
    base: './',
    server: {
      https: true,
      host: true,
      hmr: {
        host: 'localhost', //これを設定しないとWordPressのlocation.href拾っちゃう
      },
    },
    plugins: [react(), pugPlugin(options, locals), liveReload('../../app/themes/**/*.(php|twig)')],
    root: root,
    css: {
      preprocessorOptions: {
        scss: {
          includePaths: [path.resolve(__dirname, './src/scss')],
        },
      },
    },
    resolve: {
      alias: {
        '@': path.resolve(__dirname, 'src'),
        scss: path.resolve(__dirname, 'src/scss'),
        images: path.resolve(__dirname, 'src/public/images'),
        js: path.resolve(__dirname, 'src/js'),
      },
    },
    build: {
      outDir: '../dist',
      manifest: true,
      rollupOptions: {
        input: {
          home: path.resolve(__dirname, root, 'index.html'),
        },
        output: {
          assetFileNames: (assetInfo) => {
            let extType = assetInfo.name.split('.')[1];
            if (/png|jpe?g|svg|gif|tiff|bmp|ico/i.test(extType)) {
              extType = 'images';
            }
            //ビルド時のCSS名を明記してコントロールする
            if (extType === 'css') {
              return `css/style.css`;
            }
            return `${extType}/[name][extname]`;
          },
          chunkFileNames: 'js/[name].js',
          entryFileNames: 'js/[name].js',
        },
      },
    },
  });
};
