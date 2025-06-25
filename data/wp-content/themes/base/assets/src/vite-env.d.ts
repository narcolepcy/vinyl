/// <reference types="vite/client" />

interface ImportMetaEnv {
  readonly VITE_MODE: string;
  // その他の環境変数...
}

interface ImportMeta {
  readonly env: ImportMetaEnv;
}
