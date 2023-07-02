const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
    content: ['./templates/**/*.twig', './node_modules/xtendui/src/*.mjs'],
    plugins: [],
    presets: [
        require('tailwindcss/defaultConfig'), require('xtendui/tailwind.preset'),
    ],
    theme: {
        extend: {
            colors: {
                "color-1": '#EF4D48',
                "color-2": '#D90700',
                "color-3": '#2B161B',
                "color-4": '#453E3E',
                "color-5": '#F7F3F5'
            },
            fontFamily: {
                sans: ['Cairo', ...defaultTheme.fontFamily.sans],
                serif: ['Bungee', ...defaultTheme.fontFamily.serif]
            }
        },
        xtendui: {
            global: {
                component: theme => ({
                    '::selection': {
                        backgroundColor: theme('colors.color-1'),
                        color: theme('colors.color-3')
                    },
                }),
            },
        },
        container: {
            center: true,
            fluid: 'none',
            padding: {
                DEFAULT: '1rem',
                sm: '1.25rem',
                md: '1.5rem',
                lg: '2rem',
                xl: '2.5rem',
                '2xl': '5vw',
            },
        },
    }
}
