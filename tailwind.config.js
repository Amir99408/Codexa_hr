import defaultTheme from 'tailwindcss/defaultTheme';

export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './app/Livewire/**/*.php',
    ],
    safelist: [
        'bg-blue-50', 'text-blue-600', 'bg-emerald-50', 'text-emerald-600',
        'bg-amber-50', 'text-amber-600', 'bg-orange-50', 'text-orange-50',
        'bg-emerald-500', 'bg-amber-500', 'from-[#0f4c81]', 'to-blue-600',
        'hover:bg-blue-100', 'hover:bg-emerald-100', 'hover:bg-amber-100',
        'hover:bg-orange-100', 'bg-white/20', 'bg-white/30',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['DM Sans', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [],
};