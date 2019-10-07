# 快速学习Nuxt.js前端框架，开启SSR渲染。
> [https://jspang.com/posts/2018/02/26/nuxtjs.html](https://jspang.com/posts/2018/02/26/nuxtjs.html)

## 快速安装与编写`HelloWorld`初始化

### 安装
- `brew install npm`        Mac 安装`npm`包管理
- `npm install vue-cli -g`  安装`vue-cli`脚手架
- `Vue -V`                  查看`vue`版本
- `vue init nuxt/starter`   安装`nuxt`框架
```shell
? Generate project in current directory? Yes
? Project name nuxt
? Project description Nuxt.js project
? Author eson <834767372@qq.com>
```
```shell
? Project name item
? Project description My solid Nuxt.js project
? Use a custom server framework express
? Choose features to install Progressive Web App (PWA) Support, Axios
? Use a custom UI framework element-ui
? Use a custom test framework none
? Choose rendering mode Universal
? Author name eson
? Choose a package manager npm
```
- `npm install`
- `npm run dev`

### 初始化首页的页面
`./nuxt/pages/index.vue`

## 目录结构和配置文件
`.nuxt`             执行`npm run dev` 自动生成的
`assets`            静态资源目录 less sass javascript
`components`        自己的组件目录
`layouts`           视图布局目录
`middleware`        中间件目录
`node_modules`      执行`npm install` 安装依赖目录
`pages`             主要的工作目录，页面的结构等
`plugins`           下载的js插件
`static`            静态资源文件，图标等
`store`             状态管理目录
`.editorconfig`     IDE的编辑工具
`eslintrc.js`       代码检查规则的测试
`.gitgnore`         仓库忽略文件
`nuxt.config.js`    框架`nuxt`的配置文件
`package.json`      默认包管理

## 常用配置项
- 不想用`http://localhost:3000`这么办？修改启动的host和port端口号。
修改`package.json`文件，添加配置项：
```json
"config": {
    "nuxt": {
          "host": "127.0.0.1",
          "port": "8080"
    }
}
```
- 全局修改`css`方式：
1.在`assets`目录下创建`css`文件夹和`init.css`文件
```css
css
```
2.在`nuxt.config.js`文件中添加配置项：
```
css:['~assets/css/init.css'],
```
- 图片打包配置，小于1M直接bate64方式：
在`nuxt.config.js`文件中的`Build configuration`注解处添加配置项：
```
build: {
    loaders: [{
        test: /\.(png|jpg|jpeg|gif|svg)$/,
        loader: "url-loader",
        query: {
            limit: 10000,
            name: 'img/[name].[hash].[ext]'
        }
    }]
},
```

## 路由与参数传递
路由：自动配的，正如你所想的。
eg:页面传参的例子

页面
```html
<nuxt-link :to="{name:'news',params:{newId:520}}">News</nuxt-link>
```

接收参数
```html
<p>NewID:{{$route.params.newId}}</p>
```

## 动态路由和参数校验
在`/pages/news`文件夹下新建`_id.vue`文件，以下画线为前缀的`Vue`文件就是动态路由，然后在文件里边有`$route.params.id`来接收参数。

在`/pages/news/index.vue`编写：
```html
<template>
    <div>
        <h2>News Index page</h2>
        <p>NewID:{{$route.params.newId}}</p>
        <ul>
            <li>
                <nuxt-link :to="{name:'index'}">Home</nuxt-link>
            </li>
            <li>
                <nuxt-link :to="{name:'news-id',params:{id:123}}">news-1</nuxt-link>
            </li>
            <li>
                <nuxt-link :to="{name:'news-id',params:{id:'eson'}}">news-2</nuxt-link>
            </li>
            <li>
                <nuxt-link :to="{name:'news-id',params:{id:789}}">news-3</nuxt-link>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "index.vue"
    }
</script>

<style scoped>

</style>
```

在`/pages/news/_id.vue`编写：
```html
<template>
    <div>
        <h2> News-content </h2>
        <p>NewID:{{$route.params.id}}</p>
        <ul>
            <li>
               <nuxt-link :to="{name:'index'}">Home</nuxt-link>
            </li>
            <li>
                <nuxt-link :to="{name:'news',params:{newId:520}}">News</nuxt-link>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "_id.vue",
        validate({params}){
            return /^\d+$/.test(params.id);
        }
    }
</script>

<style scoped>

</style>
```

## 路由切换的动画效果 

### **全局路由动画方式**
之前说过常用配置方式的全局`css`设置中：
1.在`/assets/init.css`（没有可以创建）文件中编写： 
```css
.page-enter-active, .page-leave-active {
    transition: opacity 2s;
}
.page-enter, .page-leave-active {
    opacity: 0;
}
```
2.在`nuxt.config.js`里加入一个全局的`css`文件就可以了。
```js
css:['assets/css/main.css'],
```
3.使用`<nuxt-link :to="{name:'[路由]',params:{[参数]}}">[文案]</nuxt-link>`标签进行跳转页面和传递参数

### **单独设置页面动画**
**注意`new`名称可以视情况而取名**
1.在`/assets/init.css`文件中编写： 
```
.new-enter-active, .new-leave-active {
    transition: all 2s;
    font-size:12px;
}
.new-enter, .new-leave-active {
    opacity: 0;
    font-size:40px;
}
```
2.在要设置的页面中的组件里编写：
**属性`transition`的值要和类名前缀保持一致**
```
<script>
    export default {
        name: "index.vue",
        transition:'new'
    }
</script>
```

## 默认模板和默认布局
> 注意修改了默认模板需要重新启动服务

### 默认模板修改方式：
在项目根目录直接创建`app.html`就可以了，代码编写如下：
```
<!DOCTYPE html>
<html>
<head>
    {{ HEAD }}
</head>
<body>
    {{ APP }}
</body>
</html>
```

### 默认布局修改方式：
在`./layouts/default.vue`文件就是布局文件：
```
<template>
  <div>
    <nuxt/>
  </div>
</template>
<style>
...
</style>
```

## 错误页面和个性`mate`标签设置

### 错误页面设置：
在`layouts`文件夹下建立一个`error.vue`文件：
```
<template>
    <div>
        <h2 v-if="error.statusCode == 404">404页面，您需要的页面没有找到！</h2>
        <h2 v-else>500页面，服务器错误。</h2>
        <ul>
            <li>
                <nuxt-link :to="{name:'index'}">Home</nuxt-link>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "error.vue",
        props:['error'],
    }
</script>

<style scoped>

</style>
```
### 设置`meta`标签:
1.在`pages/news/index.vue`文件中的链接处传入参数`title`实现标题变化。
```html
<li><nuxt-link :to="{name:'news-id',params:{id:123,title:'title'}}">News-1</nuxt-link></li>
```
2.在`pages/news/_id.vue`中接收参数并且设置需要的属性
```html
<template>
    <div>
        <h2> News-content </h2>
        <p>NewID:{{$route.params.id}}</p>
        <ul>
            <li>
                <nuxt-link :to="{name:'index'}">Home</nuxt-link>
            </li>
            <li>
                <nuxt-link :to="{name:'news',params:{newId:520}}">News</nuxt-link>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "_id.vue",
        validate({params}) {
            return /^\d+$/.test(params.id);
        },
        data() {
            return {
                title: this.$route.params.title,
            }
        },
        /* 独立设置head信息 */
        head(){
            return{
                title:this.title,
                meta:[
                    {hid:'description',name:'new',content:'this is news page'}
                ]
            }
        }
    }
</script>

<style scoped>

</style>
```

## 异步请求`asyncData`方法
- 安装`Axios`
```
npm install axios --save
``` 
- 示例`ansycData`的`promise`方法
```
<template>
  <div>
      <h1>姓名：{{info.name}}</h1>
      <h2>年龄：{{info.age}}</h2>
      <h2>兴趣：{{info.interest}}</h2>
  </div>
</template>
<script>
import axios from 'axios'
export default {
  data(){
     return {
         name:'hello World',
     }
  },
  asyncData(){
      return axios.get('https://api.myjson.com/bins/8gdmr')
      .then((res)=>{
          console.log(res)
          return {info:res.data}
      })
      
  }
}
</script>
```
- 示例ansycData的await方法
```
<template>
  <div>
      <h1>姓名：{{info.name}}</h1>
      <h2>年龄：{{info.age}}</h2>
      <h2>兴趣：{{info.interest}}</h2>
  </div>
</template>
<script>
import axios from 'axios'
export default {
  data(){
     return {
         name:'hello World',
     }
  },
  async asyncData(){
      let {data}=await axios.get('https://api.myjson.com/bins/8gdmr')
      return {info: data}
      
  }
}
</script>
```

## 静态资源文件和生产静态`html`
- 直接引入图片，将图片放入`static`目录下
```
<div><img src="~static/logo.png" /></div>
```
- `CSS`引入图片
```
<style>
  .diss{
    width: 300px;
    height: 100px;
    background-image: url('~static/logo.png')
  }
</style>
```
- 打包静态`HTML`并运行
```
npm run generate
```


