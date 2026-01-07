/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/views/**/*.blade.php",
    "./resources/js/**/*.{js,ts,jsx,tsx}",
  ],

  theme: {
    extend: {
      colors: {
        background: '#EAF6F5',
        primary: '#8BC34A',
        accent: '#F4B400',
        dark: '#222222',
        light: '#6B7280',
        card: '#FFFFFF',
        'card-green': '#Dcedc8',
        'card-blue': '#bbdefb',
        'card-yellow': '#fff9c4',
        'card-pink': '#f8bbd0',
      },

      fontFamily: {
        sans: ['Poppins', 'Inter', 'sans-serif'],
      },

      borderRadius: {
        card: '20px',
        btn: '50px',
      },

      animation: {
        float: 'float 3s ease-in-out infinite',
      },

      keyframes: {
        float: {
          '0%, 100%': { transform: 'translateY(0)' },
          '50%': { transform: 'translateY(-10px)' },
        },
      },
    },
  },

  plugins: [],
};
