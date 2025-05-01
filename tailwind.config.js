import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                "dancing-script": ['"Dancing Script"', "cursive"],
                "exo-font": ['"Exo"', "sans-serif"],
                inter: ['"Inter"', "sans-serif"],
                "outfit-font": ['"Outfit"', "sans-serif"],
                quicksand: ['"Quicksand"', "sans-serif"],
                phospor: "Phosphor",
            },
        },
        container: {
            center: true,
        },
    },
    plugins: [
        require('flowbite/plugin')
    ],
};
