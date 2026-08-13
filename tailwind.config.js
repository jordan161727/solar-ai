import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** Token helper — lets `bg-surface/50` style opacity modifiers work. */
const token = (name) => `rgb(var(--color-${name}) / <alpha-value>)`;

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            colors: {
                canvas: token('canvas'),
                surface: {
                    DEFAULT: token('surface'),
                    muted: token('surface-muted'),
                    hover: token('surface-hover'),
                },
                line: {
                    DEFAULT: token('border'),
                    strong: token('border-strong'),
                },
                content: {
                    DEFAULT: token('content'),
                    muted: token('content-muted'),
                    subtle: token('content-subtle'),
                },
                accent: {
                    DEFAULT: token('accent'),
                    hover: token('accent-hover'),
                    contrast: token('accent-contrast'),
                    soft: token('accent-soft'),
                },
                success: {
                    DEFAULT: token('success'),
                    soft: token('success-soft'),
                },
                warning: {
                    DEFAULT: token('warning'),
                    soft: token('warning-soft'),
                },
                danger: {
                    DEFAULT: token('danger'),
                    soft: token('danger-soft'),
                },
                info: {
                    DEFAULT: token('info'),
                    soft: token('info-soft'),
                },
            },

            fontFamily: {
                sans: ['Inter', 'Figtree', ...defaultTheme.fontFamily.sans],
            },

            fontSize: {
                // Tightened tracking on large sizes — the main lever that makes
                // numeric dashboard type read as considered rather than shouty.
                'display': ['1.75rem', { lineHeight: '2.125rem', letterSpacing: '-0.02em', fontWeight: '600' }],
                'metric': ['1.875rem', { lineHeight: '2.25rem', letterSpacing: '-0.025em', fontWeight: '600' }],
            },

            boxShadow: {
                card: 'var(--shadow-card)',
                raised: 'var(--shadow-raised)',
                overlay: 'var(--shadow-overlay)',
            },

            borderRadius: {
                // One step up from Tailwind's default scale, capped at 12px.
                DEFAULT: '0.5rem',
                lg: '0.625rem',
                xl: '0.75rem',
            },
        },
    },

    plugins: [forms],
};
