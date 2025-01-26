import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        screens: {
            'tablet': '740px',
            // => @media (min-width: 640px) { ... }
      
            'laptop': '1150px',
            // => @media (min-width: 1024px) { ... }
      
            'desktop': '1450px',
            // => @media (min-width: 1280px) { ... }
          },
    
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                roboto: ['Roboto']
            },
            colors: {
                primary: "#681536",
                secondary: "#313771",
            },
        },
    },

    plugins: [forms],
};
