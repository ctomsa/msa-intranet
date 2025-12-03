import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class', // важно для dark-темы

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                // если подключён Inter — оставляем так. Можно поменять на Manrope/etc
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },

            colors: {
                // Основная палитра под твой MSA dark theme
                msa: {
                    bg: '#05060A',          // фон страницы
                    bgSoft: '#0B0C12',      // мягкий фон для секций
                    card: '#11121A',        // карточки
                    cardSoft: '#181927',    // ховеры/подсветки
                    border: '#26273A',      // бордеры
                    accent: '#7B61FF',      // фиолетовый акцент (кнопки, active tab)
                    accentSoft: '#2A214A',  // фон под акцент
                    accentAlt: '#4F46E5',   // альтернативный фиолетовый
                    text: '#F9FAFB',        // основной текст
                    muted: '#9CA3AF',       // вторичный текст
                    subtle: '#6B7280',      // ещё чуть менее яркий текст
                    success: '#22C55E',
                    warning: '#FBBF24',
                    danger: '#EF4444',
                    badgeBg: '#1F2937',
                },
            },

            borderRadius: {
                'msa-card': '24px',
                'msa-pill': '999px',
            },

            boxShadow: {
                'msa-card': '0 24px 60px rgba(0, 0, 0, 0.75)',
                'msa-soft': '0 18px 40px rgba(0, 0, 0, 0.55)',
                'msa-glow': '0 0 40px rgba(123, 97, 255, 0.55)',
            },

            backgroundImage: {
                'msa-radial-top':
                    'radial-gradient(circle at 0% 0%, rgba(123,97,255,0.18), transparent 55%)',
                'msa-radial-center':
                    'radial-gradient(circle at 50% 0%, rgba(255,255,255,0.08), transparent 60%)',
            },

            spacing: {
                '18': '4.5rem',
            },
        },
    },

    plugins: [forms],
};