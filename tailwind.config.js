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
                primary: '#3B82F6',
                primaryHover: '#2563EB',
                primarySoft: '#DBEAFE',

                appBG: '#F8FAFC',
                cardBg: '#FFFFFF',
                border: '#E5E7EB',
                textPrimary: '#0F172A',
                textSecondary: '#64748B',

                sidebarBg: '#0F172A',
                sidebarText: '#CBD5E1',
                sideBarActive: '#3B82F6',
            }
        },
    },
    plugins: [],
};

/**
 * Azul base: blue-600 / blue-500

Fundo app: gray-100

Sidebar: white

Texto: gray-700

Hover: blue-50
 */


