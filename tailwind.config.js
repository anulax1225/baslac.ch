/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",
    ],
    theme: {
      screens: {
        'tablet': '640px',
        'laptop': '1280px',
        'desktop': '1920px',
      },
      extend: {},
    },
    plugins: [],
  }