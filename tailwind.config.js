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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                blue: '#0D77BD',
                lime: '#D2FF2B',
                gray: '#707070',
                navy: '#1A2755',
                disabled: '#CBD5E1'
            },
        },
    },
    plugins: [forms],
    safelist: [
        'border-green-400',
        'bg-green-100',
        'text-green-500',
        'text-green-700',

        'border-cyan-400',
        'bg-cyan-100',
        'text-cyan-500',
        'text-cyan-700',

        'border-orange-400',
        'bg-orange-100',
        'text-orange-500',
        'text-orange-700',

        'border-red-400',
        'bg-red-100',
        'text-red-500',
        'text-red-700',
    ],
};
