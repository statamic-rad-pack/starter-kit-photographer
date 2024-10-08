import colors from 'tailwindcss/colors';
import { fontFamily } from 'tailwindcss/defaultTheme';
import plugin from 'tailwindcss/plugin';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.antlers.html',
        './resources/**/*.antlers.php',
        './resources/**/*.blade.php',
        './resources/**/*.vue',
        './content/**/*.md',
        './config/statamic/bard_texstyle.php',
    ],

    theme: {
        extend: {
            colors: {
                black: colors.zinc[900],
                gray: colors.zinc,
            },
            fontFamily: {
                sans: ['Inter', ...fontFamily.sans],
                serif: ['Newsreader', ...fontFamily.serif],
            }
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        plugin(function ({ addUtilities, matchUtilities, theme }) {
            matchUtilities(
                {
                    'stack': (value) => ({
                        '> *': {
                            '--stack-space': value,
                        },
                        '> *:not(.no-space-y, .no-space-b) + *:not(.no-space-y, .no-space-t)': {
                            'margin-block-start': `var(--stack-item-space, var(--stack-space, ${theme('spacing.16')}))`
                        },
                    }),
                    'stack-space': (value) => ({
                        '--stack-item-space': value,
                        '&:is([class*="stack-"][class*="stack-space-"] > *)': {
                            '--stack-item-space': value,
                        },
                    }),
                },
                { values: theme('spacing') }
            );
            addUtilities({
                '[class*="stack-"][class*="stack-space-"]': {
                    '& > *': {
                        '--stack-item-space': 'initial',
                    },
                },
                '.stack-space-inherit': {
                    '--stack-item-space': 'initial',
                    '&:is([class*="stack-"][class*="stack-space-"] > *)': {
                        '--stack-item-space': 'initial',
                    },
                },
                '[data-stack-space-collapse="true"] + [data-stack-space-collapse="true"]': {
                    '--stack-item-space': 0,
                    '&:is([class*="stack-"][class*="stack-space-"] > *)': {
                        '--stack-item-space': 0,
                    },
                },
                '.stack-space-collapse': {
                    '--stack-space-collapse': 'true',
                },
                '.stack-space-block': {
                    '--stack-space-collapse': 'false',
                }
            });
        }),
    ],
};
