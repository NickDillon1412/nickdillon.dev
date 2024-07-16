import defaultTheme from 'tailwindcss/defaultTheme';
const plugin = require("tailwindcss/plugin")

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [
        require('daisyui'),
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
        plugin(({
            addVariant,
            e
        }) => {
            addVariant('sidebar-expanded', ({
                modifySelectors,
                separator
            }) => {
                modifySelectors(({
                    className
                }) => `.sidebar-expanded .${e(`sidebar-expanded${separator}${className}`)}`);
            });
        }),
    ],
};
