/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.vue',
        './resources/**/*.js',
    ],
    theme: {
        extend: {
            colors: {
                primary: '#2563EB',
                primarySoft: '#EFF6FF',
                sidebarBg: '#0F172A',
                contentBg: '#F8FAFC',
            }
        },
    },
    plugins: [],
};


