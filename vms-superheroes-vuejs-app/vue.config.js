const { defineConfig } = require('@vue/cli-service')
module.exports = defineConfig({
  transpileDependencies: true,
  lintOnSave: true,
  'devServer':{
    'proxy': {
      '^/api': {
        'target': 'http://localhost/api',
        'pathRewrite': { '^/api': '' },
        'changeOrigin': true,
        'secure': false
      }
    }
  },
  css: {
    loaderOptions: {
      sass: {
        prependData: `@import "./src/assets/scss/variables.scss";`
      }
    }
  }
})
