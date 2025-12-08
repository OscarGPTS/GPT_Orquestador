/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        'brand-red': '#CF0A2C',
        'brand-yellow': '#F9BE00',
      },
    },
  },
  plugins: [],
}
