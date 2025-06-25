module.exports = {
  content: [
    "./TP2/**/*.php", // Incluye todos los archivos PHP en el directorio TP2
    "./TP2/**/*.html", // Incluye todos los archivos HTML en el directorio TP2
  ],
  theme: {
    extend: {},
  },

  plugins: [require("daisyui")],
  
 daisyui: {
    themes: [
      {
        lightgreen: {
          "color-scheme": "light",
          "base-100": "#FCF9E7",
          "base-200": "#d3dca1",
          "base-300": "#1c6065",
          "base-content": "#052628",
          primary: "#d3dca1",
          "primary-content": "#1c6065",
          secondary: "#1c6065",
          "secondary-content": "#d3dca1",
          accent: "#d8b16b",
          "accent-content": "oklch(38% 0.063 188.416)",
          neutral: "#6D7D7E",
          "neutral-content": "#052628",
          info: "#FCF9E7",
          "info-content": "#1c6065",
          success: "#1c6065",
          "success-content": "#d3dca1",
          warning: "oklch(26% 0.079 36.259)",
          "warning-content": "oklch(83% 0.128 66.29)",
          error: "oklch(25% 0.092 26.042)",
          "error-content": "oklch(88% 0.062 18.334)",
        },
      },
      {
        darkgreen: {
          "color-scheme": "dark",
          "base-100": "#124A4E",
          "base-200": "#052628",
          "base-300": "#455D5E",
          "base-content": "#D2D8B4",
          primary: "#B5BE83",
          "primary-content": "#052628",
          secondary: "#124A4E",
          "secondary-content": "#455D5E",
          accent: "#C49E59",
          "accent-content": "#052628",
          neutral: "oklch(20% 0 0)",
          "neutral-content": "oklch(98% 0 0)",
          info: "#455D5E",
          "info-content": "#B5BE83",
          success: "#B5BE83",
          "success-content": "#052628",
          warning: "#A75F17",
          "warning-content": "oklch(98% 0 0)",
          error: "#A74538",
          "error-content": "oklch(98% 0 0)",
        },
      },
    ],
  }
}