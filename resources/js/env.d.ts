/// <reference types="vite/client" />

interface ImportMetaEnv {
  readonly VITE_RECAPTCHA_SITE_KEY: string
  // Add other VITE_* variables here as needed
}

interface ImportMeta {
  readonly env: ImportMetaEnv
}
