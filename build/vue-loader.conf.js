'use strict'
const utils = require('./utils')
const config = require('../config')
const isProduction = process.env.NODE_ENV === 'production'

const path = require('path')
const museUiThemePath = path.join(
    __dirname,
    '..',
    'node_modules',
    'muse-ui',
    'src/styles/themes/variables/default.less'
)
var a = utils.cssLoaders({
    sourceMap: isProduction ?
        config.build.productionSourceMap : config.dev.cssSourceMap,
    extract: isProduction
})
a.less = [
    'vue-style-loader',
    'css-loader',
    {
        loader: 'less-loader',
        options: {
            globalVars: {
                museUiTheme: `'${museUiThemePath}'`,
            }
        }
    }
]

module.exports = {
    loaders: a
}

postcss: [
    require('autoprefixer')({
      browsers: ['last 20 versions']
    })
  ]




// const sourceMapEnabled = isProduction
//     ? config.build.productionSourceMap
//     : config.dev.cssSourceMap
//
// module.exports = {
//     loaders: utils.cssLoaders({
//         sourceMap: sourceMapEnabled,
//         extract: isProduction
//     }),
//     cssSourceMap: sourceMapEnabled,
//     cacheBusting: config.dev.cacheBusting,
//     transformToRequire: {
//         video: ['src', 'poster'],
//         source: 'src',
//         img: 'src',
//         image: 'xlink:href'
//     }
// }
