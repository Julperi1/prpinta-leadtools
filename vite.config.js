import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';

// https://vite.dev/config/
export default defineConfig({
  plugins: [vue()],
  // Make src @ alias
  resolve: {
    alias: {
      '@': '/src',
    },
  },
});
