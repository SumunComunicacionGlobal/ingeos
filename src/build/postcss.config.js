'use strict'

module.exports = ctx => {
  return {
    map: ctx.file.dirname.includes('examples') ?
      false :
      {
        inline: false,
        annotation: true,
        sourcesContent: true
      },
    plugins: {
      autoprefixer: {
        cascade: false
      },
	  "postcss-understrap-palette-generator" : {
      // Para añadir colores nuevos que no estén en $colors. Si pones uno que exista en $colors, no le cambia el color.
      defaults: {
        // "--magenta": "#facab0",
        // "--prueba": "#facab0"
      },
      // Sobrescribe el array de colores completamente. Si el color no está en $colors, no hace nada.
      colors: [
        "--blue",
        // "--indigo",
        "--purple",
        "--pink",
        "--red",
        "--orange",
        "--yellow",
        "--green",
        // "--teal",
        "--cyan",
        "--white",
        "--gray",
        "--gray-dark",
        "--black",
        "--primary",
        "--secondary",
        "--light"

      ]

    }
    }
  }
}