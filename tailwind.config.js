/** @type {import('tailwindcss').Config} */
export default {
    content: ['./resources/**/*.blade.php', './resources/**/*.js', './resources/**/*.vue', './app/**/*.php'],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Satoshi', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                display: ['Cabinet Grotesk', 'Satoshi', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            },
            colors: {
                dark: {
                    bg: '#0a0a0a',
                    surface: '#0e0e0e',
                    border: '#1a1a1a',
                    hover: '#252525',
                },
            },
        },
    },
    plugins: [],
};
