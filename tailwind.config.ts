import type { Config } from 'tailwindcss'

export default {
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.{ts,vue}',
    './storage/framework/views/*.php',
  ],
  theme: {
    screens: {
      'sm': '640px',
      'md': '768px',
      'lg': '1024px',
      'xl': '1280px',
    },
    container: {
      center: true,
      padding: {
        DEFAULT: '1rem',
      }
    },
    extend: {},
  },
  plugins: [],
} satisfies Config
