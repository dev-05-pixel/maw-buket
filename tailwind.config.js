export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],

    theme: {
        extend: {
            colors: {
                primary: "#000000",
                soft: "#f7f7f7",

                cream: "#F7F3EE",
                "cream-d": "#EDE6DC",

                brown: "#2C2421",
                "brown-m": "#4A3F3A",

                rose: "#D4847A",
                "rose-l": "#E8B5AF",
                "rose-d": "#B85C52",

                sand: "#C9AA86",
                muted: "#9E8E84",
                sage: "#7A9B7A",
            },

            fontFamily: {
                serif: ["Playfair Display", "serif"],
                sans: ["Inter", "sans-serif"],
            },
        },
    },

    plugins: [],
};
