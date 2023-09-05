import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'
import { resolve } from 'path'

/**
 * Rafraichi la page quand on modifie un fichier twig
 */
const twigRefreshPlugin = () => ({
  name: 'twig-refresh',
  configureServer({ watcher, ws }) {
    watcher.add(resolve(__dirname, "templates/**/*.twig"));
    watcher.on("change", function (path) {
      if (path.endsWith(".twig")) {
        ws.send({
          type: 'full-reload',
        })
      }
    });
  }
})

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [react(), twigRefreshPlugin()],
  root: './assets',
  base: '/assets',
  build: {
    assetsDir: '',
    manifest: true,
    outDir: '../public/assets',
    rollupOptions: {
      output: {
        manualChunks: undefined, // Desactive la separation du vendor
      },
      input: {
        app: resolve(__dirname, 'assets/app.js')
      }
    }
  }
})
