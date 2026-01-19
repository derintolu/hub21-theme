import { v4wp } from "@kucrut/vite-for-wp";
import react from "@vitejs/plugin-react";
import path from "path";

export default {
  plugins: [
    v4wp({
      input: {
        'sidebar': "src/main.tsx",
        'components-export': "src/components-export.tsx",
      },
      outDir: "assets/sidebar",
    }),
    react(),
  ],
  server: {
    host: 'hub21.local',
    port: 5178,
    cors: true,
    strictPort: true,
    hmr: {
      host: 'hub21.local',
      port: 5178,
    },
  },
  resolve: {
    alias: {
      "@": path.resolve(__dirname, "./src"),
    },
  },
  build: {
    manifest: true,
    rollupOptions: {
      output: {
        manualChunks: undefined,
      },
    },
  },
};
