import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/ts/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
                keyframes: {
                    'dropdown-open': {
                        '0%': { opacity: '0', transform: 'translateY(-3rem) scaleY(0.95)' },
                        '60%': { opacity: '1', transform: 'translateY(0) scaleY(1.02)' },
                        '100%': { opacity: '1', transform: 'translateY(0) scaleY(1)' },
                    },
                },
                animation: {
                    'dropdown-open': 'dropdown-open 0.8s cubic-bezier(0.22, 1, 0.36, 1) forwards',
                },
        },
    },

    plugins: [forms],
};
