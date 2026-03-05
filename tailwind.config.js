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
                sans: ['Inter', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                /* IES Delgado Hernández — Design Tokens */
                'ies-blue': {
                    50: '#e3f0fc',
                    100: '#b5d4f7',
                    200: '#84b8f2',
                    300: '#539ced',
                    400: '#2d86e8',
                    500: '#1976D2',
                    600: '#1565C0',
                    700: '#0D47A1',
                    800: '#0A3A85',
                    900: '#062D6A',
                },
                'ies-green': {
                    50: '#e6f5ec',
                    100: '#c0e6cf',
                    200: '#96d6b0',
                    300: '#6bc690',
                    400: '#4bb979',
                    500: '#2E9B4E',
                    600: '#278A44',
                    700: '#1E7638',
                    800: '#16622D',
                    900: '#0D4E22',
                },
            },
        },
    },

    plugins: [forms],
};
