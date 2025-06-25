module.exports = {
  plugins: {
    tailwindcss: {},
    autoprefixer: {},
    'postcss-preset-env': {
      stage: 1,
    },
    'postcss-assets': {
      loadPaths: ['src/images/'],
      relative: true,
    },
  },
};
