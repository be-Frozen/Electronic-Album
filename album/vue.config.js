

module.exports={
  devServer:{
    proxy:{
      '/myApi':{
        target:'http://localhost:80/',
        changeOrigin:true,
        secure:false,
        pathRewrite:{
          '^/myApi':''
        }
      }
    }
  },
  lintOnSave: false,
}