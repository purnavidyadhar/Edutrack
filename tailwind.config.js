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
                sans: ['"Inter"', ...defaultTheme.fontFamily.sans],
                display: ['"Plus Jakarta Sans"', 'sans-serif'],
            },
            colors: {
                navy: { 900: '#0B0F19', 800: '#111827', 700: '#1F2937' },
                brand: {
                    50: '#F0F5FF',
                    100: '#E5EDFF',
                    500: '#4F46E5', // Primary Indigo
                    600: '#4338CA',
                    700: '#3730A3',
                    950: '#020617' // Dark Navy
                },
                accent: '#7C3AED', // Secondary Purple
                purple: { 500: '#8B5CF6', 600: '#7C3AED' },
            },
            animation: {
                'float': 'float 6s ease-in-out infinite',
                'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                'fade-in': 'fadeIn 0.5s ease-out forwards',
                'bounce-subtle': 'bounceSubtle 2s infinite',
            },
            keyframes: {
                float: {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-20px)' },
                },
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                bounceSubtle: {
                    '0%, 100%': { transform: 'translateY(-5%)', animationTimingFunction: 'cubic-bezier(0.8, 0, 1, 1)' },
                    '50%': { transform: 'translateY(0)', animationTimingFunction: 'cubic-bezier(0, 0, 0.2, 1)' },
                }
            }
        },
    },

    plugins: [forms],
};
