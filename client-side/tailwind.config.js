module.exports = {
  purge: ['./index.html', './src/**/*.{vue,js,ts,jsx,tsx}'],
  darkMode: 'media',
  theme: {
    extend: {
      fontFamily: {
        'IBMPlexSansArabic-Bold': ['IBMPlexSansArabic-Bold', 'sans-serif'],
        'IBMPlexSansArabic-Medium': ['IBMPlexSansArabic-Medium', 'sans-serif'],
        'IBMPlexSansArabic-Regular': ['IBMPlexSansArabic-Regular', 'sans-serif'],
        'IBMPlexSansArabic-Light': ['IBMPlexSansArabic-Light', 'sans-serif'],
        'IBMPlexSansArabic-ExtraLight': ['IBMPlexSansArabic-ExtraLight', 'sans-serif'],
        'IBMPlexSansArabic-Thin': ['IBMPlexSansArabic-Thin', 'sans-serif'],
        'IBMPlexSansArabic-SemiBold': ['IBMPlexSansArabic-SemiBold', 'sans-serif'],
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