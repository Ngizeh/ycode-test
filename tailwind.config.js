module.exports = {
  purge: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
      colors: {
        'custom-color': '#3C8999',
      },
    },
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
