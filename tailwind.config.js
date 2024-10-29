import colors from 'tailwindcss/colors';
import { fontFamily } from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.antlers.html',
        './resources/**/*.antlers.php',
        './resources/**/*.blade.php',
        './resources/**/*.vue',
        './resources/**/*.yaml',
        './content/**/*.md',
        './config/statamic/bard_texstyle.php',
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
    ],
};
