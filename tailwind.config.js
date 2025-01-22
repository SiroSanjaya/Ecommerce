/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './app/Views/**/*.php', // Pastikan Tailwind membaca file view CI4
        './public/**/*.html', // Jika ada file HTML di folder publik
    ],
    theme: {
        extend: {},
    },
    plugins: [
        require('flowbite/plugin')({
            charts: true, // Mengaktifkan dukungan chart
        }),
    ],
    content: [
        "./node_modules/flowbite/**/*.js"
    ]
}