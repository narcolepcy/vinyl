const fontSize = require('./tailwind-theme/fontSize.js');
const margin = require('./tailwind-theme/margin.js');
const padding = require('./tailwind-theme/padding.js');
module.exports = {
  content: ['./src/**/*.html', './src/pug/*.pug', './src/js/**/*.{js,ts,jsx,tsx}'],
  darkMode: 'media', // or 'media' or 'class'
  theme: {
    fontSize,
    margin,
    padding,
    extend: {},
  },
  variants: {
    extend: {},
  },
  plugins: [],
};
