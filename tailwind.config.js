/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./vendor/tales-from-a-dev/flowbite-bundle/templates/**/*.html.twig",
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  theme: {
    extend: {
      colors: {
        erynn: "#aaa",
        mak: "#cecece",
      },
    },
  },
  plugins: [],
};
