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
                bg: {
                    primary: 'var(--bg-primary)',
                    secondary: 'var(--bg-secondary)',
                    surface: 'var(--bg-surface)',
                },
                text: {
                    primary: 'var(--text-primary)',
                    secondary: 'var(--text-secondary)',
                    inverted: 'var(--text-inverted)',
                },
                brand: {
                    primary: 'var(--brand-primary)',
                    hover: 'var(--brand-hover)',
                    accent: 'var(--brand-accent)',
                },
                border: 'var(--border-color)',
            },
        },
    },

    plugins: [forms],
};
