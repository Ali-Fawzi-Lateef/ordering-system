module.exports = {
  purge: ['./index.html', './src/**/*.{vue,js,ts,jsx,tsx}'],
  darkMode: 'media',
  theme: {
    extend: {
      fontFamily: {
        'IBMPlexSansArabic-Medium': ['IBMPlexSansArabic-Medium', 'sans-serif'],
        'IBMPlexSansArabic-Regular': ['IBMPlexSansArabic-Regular', 'sans-serif'],
      },
    },
  },
  daisyui: {
    themes: ['corporate'],
  },
  variants: {
    extend: {},
  },
  plugins: [require("daisyui")],
}
