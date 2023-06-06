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
                "color-1": 'rgb(239, 77, 72)',
                "color-2": 'rgb(217, 7, 0)',
                "color-3": 'rgb(43, 22, 27)',
                "color-4": 'rgb(69, 62, 62)',
                "color-5": 'rgb(247, 243, 245)'
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
    }
}
