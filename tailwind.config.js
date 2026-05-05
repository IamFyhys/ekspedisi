import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Plus Jakarta Sans', 'Inter', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: '#185FA5',
                surface: '#FFFFFF',
                background: '#F8FAFC',
                accent: '#185FA5',
            }
        },
    },

    plugins: [forms],
};
