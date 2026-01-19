import type { Config } from 'tailwindcss';

export default {
  content: [
    './src/**/*.{js,ts,jsx,tsx}',
  ],
  theme: {
    extend: {
      colors: {
        frs: {
          primary: '#1e40af',
          secondary: '#3b82f6',
          accent: '#60a5fa',
        },
      },
    },
  },
  plugins: [],
} satisfies Config;
