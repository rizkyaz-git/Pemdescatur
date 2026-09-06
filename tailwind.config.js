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
        forest: {
          DEFAULT: '#145C3B',
          deep: '#0A3D29',
          mid: '#145C3B',
          sage: '#7D9B78',
          mist: '#F0F5EE',
          soft: '#EAF1E8',
          pale: '#DCE6DA',
        },
        accent: {
          wheat: '#D9B85C',
          ricecream: '#F2E7BF',
        },
        bg: {
          ivory: '#F7F8F2',
          section: '#EAF1E8',
        },
        txt: {
          primary: '#20332A',
          secondary: '#6C7B72',
        }
      },
      fontFamily: {
        serif: ['Merriweather', 'serif'],
        sans: ['Inter', 'sans-serif'],
      },
      borderRadius: {
        'xl': '1rem',
        '2xl': '1.25rem',
        '3xl': '1.75rem',
        '4xl': '2.25rem',
      }
    },
  },
  plugins: [],
}
