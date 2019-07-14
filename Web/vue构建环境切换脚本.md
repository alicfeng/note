---
title: vue构建环境切换脚本
date: 2019-04-23
tags:
  - Vue
  - Node
  - Javascript
categories: Web
---



#### 前言

在项目开发一直到上线的过程中，我们一般会配置至少三个环境( 开发环境`dev`、测试环境`test`、生产环境`prod` ) ，多则还有`sit`、`uat`等环境，不同的环境其配置也是不一样的，比如接口地址、路由模式等配置，如何更加优雅灵活地切换环境呢？我们可以配合`cross-env`，构建不同的`cli build script`。

<!-- more -->

#### 使用

- 安装`cross-env`依赖

  ```bash
  npm install cross-env --save
  ```

  

- 分别声明不同环境的配置，比如接口地址`API_HOST`

  - 开发环境配置，位于`/config/dev.env.js`

    ```javascript
    'use strict'
    const merge = require('webpack-merge')
    const prodEnv = require('./prod.env')
    
    module.exports = merge(prodEnv, {
      NODE_ENV: '"development"', 
      API_HOST:'"http://dev.api.samego.com"'
    })
    ```

  - 测试环境配置，位于`/config/test.env.js`

    ```
    'use strict'
    const merge = require('webpack-merge')
    const devEnv = require('./dev.env')
    
    module.exports = merge(devEnv, {
      NODE_ENV: '"testing"',
      API_HOST:'"http://test.api.samego.com"'
    })
    ```

  - 生产环境配置，位于`/config/prod.env.js`

    ```javascript
    'use strict'
    const merge = require('webpack-merge')
    const devEnv = require('./dev.env')
    
    module.exports = merge(devEnv, {
      NODE_ENV: '"testing"',
      API_HOST:'"http://test.api.samego.com"'
    })
    ```

- 修改`vue`项目的`index.js`的`build`节点配置，修改如下:

  ```javascript
  build: {
      // 声明环境，根据引进不同的环境文件 | add lines
      prodEnv: require('./prod.env'),
      testEnv: require('./test.env'),
      devEnv: require('./dev.env'),
  }
  ```

  

- 修改`build`下的`webpack.prod.conf.js`配置，修改如下：

  ```javascript
  ... ... 
  // const env = process.env.NODE_ENV === 'testing'
  //   ? require('../config/test.env')
  //   : require('../config/prod.env')
  
  const env = config.build[process.env.env_config + 'Env']
  ... ...
  ```



- 修改`build`下的`build.js`配置，修改如下：

  ```javascript
  ... ...
  // process.env.NODE_ENV = 'production'
  ... ...
  // const spinner = ora('building for production...')
  var spinner = ora('building for ' + process.env.NODE_ENV + ' ...')
  ... ...
  ```

  

- 在`package.json`配置文件里声明并自定义构建指令

  ```json
  {  
  "scripts": {
      "build-test": "cross-env NODE_ENV=testing env_config=test node build/build.js",
      "build-prod": "cross-env NODE_ENV=production env_config=prod node build/build.js"
    }
  }
  ```

  

- 新建承载构建时不同环境的配置环境配置文件，`/src/config/application.js`

  ```javascript
  // 接口地址环境
  export const API_HOST = process.env.API_HOST
  ```



- 嗯嗯~此步骤可以根据不同的指令构建不同环境...

  ```shell
  # 开发时使用
  npm run dev
  
  # 测试环境构建
  npm run build-test
  
  # 生产环境构建
  npm run build-prod
  ```

