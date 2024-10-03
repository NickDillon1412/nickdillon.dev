import plugin from "tailwindcss/plugin";
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';
import daisyui from "daisyui";
import preset from './vendor/filament/support/tailwind.config.preset'

/** @type {import('tailwindcss').Config} */
export default {
    presets: [preset],

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
        './vendor/livewire/flux/stubs/**/*.blade.php',
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],

    darkMode: 'class',

    plugins: [
        forms,
        typography,
        daisyui,
        // add custom variant for expanding sidebar
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
