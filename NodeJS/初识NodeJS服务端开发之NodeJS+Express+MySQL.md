**前言** 
我的天呐，上了一个上午的课，下午呆呆地在图书馆用python玩并发，晚上就玩玩NodeJS，其实是这样的，O(∩_∩)O哈哈~听说14周NodeJS要结课了，我今天就琢磨琢磨了一下NodeJS的开发框架以及熟悉了Express框架的基本环境。... ... 对express框架稍微扩展之后呢，okay之后，我感觉回到了之前写PHP的small-frame似的，结构目录看起来的感觉很熟悉，NodeJS与PHP果然是两兄弟。额额，主要是熟悉Express框架，好了，具体我要回忆我的晚上做了什么喽。
___

**nodeJS是什么**
nodeJS是基于Javascript和Google的V8引擎的一种运行于服务端的一门编程语言，与PHP相比，nodeJS的运行速度以及性能都是想当不错的。
___

**nodeJS的安装**
一切都在Ubuntu下运作... ...
对此不解释，只留步骤O(∩_∩)O哈哈
在官网下载系统对应版本的tar.xz后，Look
```
➜  ~ sudo mkdir /env
➜  ~sudo mv ./node-v6.10.0-linux-x86.tar.xz  /env/
➜  ~cd /env
➜  ~sudo xz node-v6.10.0-linux-x86.tar.xz
➜  ~ sudo tar -xvf node-v6.10.0-linux-x86.tar && sudo rm node-v6.10.0-linux-x86.tar
➜  ~ sudo mv node-v6.10.0-linux-x86 node-v6.10.0
```
配置环境，编辑`/etc/profile`文件添加如下的环境信息

```
#NodeJS
export NODE_HOME=/env/node-6.10.0
export PATH=$PATH:$NODE_HOME/bin
export NODE_PATH=$NODE_HOME/lib/node_module
```
来看看是否安装成功了呢

```
➜  ~ node -v
v6.10.0
➜  ~ npm -v
1.3.10
➜  ~ 

```
(⊙o⊙)嗯。至此，安装完成！
好了，上面的都是吹水的，初识Express开发框架环境才是重点，接下来...  ...
___

**Express简介**
Express 是一个基于 Node.js 平台的极简、灵活的 web 应用开发框架，它提供一系列强大的特性，帮助你创建各种 Web 和移动设备应用。它具有丰富的 HTTP 快捷方法和任意排列组合的 Connect 中间件，让你创建健壮、友好的 API 变得既快速又简单。并且Express 不对 Node.js 已有的特性进行二次抽象，我们只是在它之上扩展了 Web 应用所需的基本功能。

接下来得又是安装，安装express方式有很多种，如下使用npm安装，不解释... ...
- 安装express

```
➜  ~ sudo npm install express express-generator -g
# 安装过程省略 ... ...
➜  ~ express --version
4.14.1
```
okay了，我们开始只用express初始化一份工程demoProject
- 使用express命令初始化demoProject项目

```
➜  ～ express demoProject
```
额额，通过上面的命令已经初始化了一份工程，具体来分析分析工程的目录结构
- demoProject目录结构如下


 ```
➜  demoProject tree
.
├── app.js
├── bin #应用启动bin目录
│   └── www
├── package.json #应用的依赖包信息
├── public  #公共文件夹存放资源文件
│   ├── images
│   ├── javascripts
│   └── stylesheets
│       └── style.css
├── routes #路由文件夹，实际上可以看做Controller
│   ├── index.js
│   └── users.js
└── views #顾名思义，就是视图了，存放模板文件
    ├── error.jade
    ├── index.jade
    └── layout.jade

7 directories, 9 files

```
已经打开了解了Express框架的目录结构，第一感觉我们就是：哦，还是老套路，框架的模式还是基于MVC。既然是老套路我也不敢多说，来启动看看。

- 在Terminal启动demoProject项目服务

```
➜  demoProject ~ DEBUG=start:* npm start

> demoproject@0.0.0 start /home/alic/tutorial/Gogs/demoProject
> node ./bin/www

GET / 200 372.578 ms - 185
GET /stylesheets/style.css 304 3.709 ms - -

```
demoProject已经在3000端口中运行了
至此，我们已经基本认识Express安装、结构以及运行，接下来呢，我们使用Express+NodeJS+MySQL做一个简单的实例。
___
**使用Express+NodeJS+MySQL实现基本业务逻辑增**删改查，只有增是粗体，那就只实现增一个喽。

>**实践环境：**
>SystemOS：Ubuntu
>Database：MySQL
>DevLanguage：NodeJS
>NodeJS-Frame：Express

这次倒过来记录记录，我们先看看完成后的项目目录结构

![demoProject](http://upload-images.jianshu.io/upload_images/1678789-cddb80342f355dd8.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

对比Express的基本目录呢，在这里已经新建了几个，详细来说说这几个目录的作用：
bean：对象的实体即Class
common：项目的架构的通用目录
conf：项目的基本配置目录
dao：拿刀来干，不解释，即model层
utils：工具类封装的存放目录

- 既然是涉及动态的，我们先来建立数据库，跳过~~

```
mysql> desc user_status;
+----------+-------------+------+-----+---------+----------------+
| Field    | Type        | Null | Key | Default | Extra          |
+----------+-------------+------+-----+---------+----------------+
| uuid     | int(11)     | NO   | PRI | NULL    | auto_increment |
| username | varchar(20) | NO   |     | NULL    |                |
| password | varchar(40) | NO   |     | NULL    |                |
| qrcode   | varchar(40) | YES  |     | NULL    |                |
+----------+-------------+------+-----+---------+----------------+
4 rows in set (0.01 sec)

```
- 既然使用到MySQL，那就得来安装nodeJS的MySQL驱动，通过npm安装，在Express框架中呢，很简单，只要在`package.json`文件中声明一下项目的依赖即可！

```
{
  "name": "jobfornodejs",
  "version": "0.0.0",
  "private": true,
  "scripts": {
    "start": "node ./bin/www"
  },
  "dependencies": {
    "body-parser": "~1.16.0",
    "cookie-parser": "~1.4.3",
    "debug": "~2.6.0",
    "express": "~4.14.1",
    "jade": "~1.11.0",
    "morgan": "~1.7.0",
    "serve-favicon": "~2.3.2",
    "mysql": "latest"
  }
}

```
注意，配置完毕之后，是还没有安装的，在项目的根目录执行如下命令就可以了
```
➜  jobForNodeJS git:(master) ✗ sudo npm install 
```

- 在Express框架配置MySQL数据库配置信息
在`conf/`目录下建立MySQL配置信息`database.js`文件，内容如下：

```
// MySQL数据库配置信息
 mysql = {
        host: 'MySQL主机', 
        user: '数据库用户',
        password: '数据库密码',
        database:'数据库名称',
        port: MySQL的端口号
}

//exports
exports.mysql = mysql
```
- 接下来，我们简单封装一下MySQL操作的方法，使用连接池，避免开太多的线程，提升性能。这个该怎么做呢？在`common/`下建立`basicConnection.js`文件，代码如下：

```
var mysql = require('mysql');
var $dbConfig = require('../conf/database');

// 使用连接池，避免开太多的线程，提升性能
var pool = mysql.createPool($dbConfig.mysql);

/**
 * 对query执行的结果自定义返回JSON结果
 */
function responseDoReturn(res, result,resultJSON) {
    if(typeof result === 'undefined') {
        res.json({
            code:'201',
            msg: 'failed to do'
        });
    } else {
        res.json(result);
    }
};

/**
 * 封装query之sql带不占位符func
 */
function query(sql, callback) {
    pool.getConnection(function (err, connection) {
        connection.query(sql, function (err, rows) {
            callback(err, rows);
            //释放链接
            connection.release();
        });
    });
}

/**
 * 封装query之sql带占位符func
 */
function queryArgs(sql,args, callback) {
    pool.getConnection(function (err, connection) {
        connection.query(sql, args,function (err, rows) {
            callback(err, rows);
            //释放链接
            connection.release();
        });
    });
}

//exports
module.exports = {
    query: query,
    queryArgs: queryArgs,
    doReturn: responseDoReturn
}
```
- 记得很深：在深圳开发服务端的时候，MySQL以及Redis的命令语句都是集中在一个文件的使用键值对配置，下面我们模拟一下这种使用方式，笑:) 使用变量来映射。在`common/`目录下新建一个`sqlCommand.js`文件，格式很简单，如下就是一个举例

```
//user_status单一的user_status表SQL-Command
var user_status = {
	insertOne:'INSERT INTO user_status (username, password,qrcode) VALUES(?,?,?)',
};

//exports
module.exports = {
    user_status: user_status
};
```

- 已经准备的差不多了，这一步就是处理业务逻辑的核心，归根到底就是增删改查，需要调用MySQL连接池以及SQL命令语句的模块，比如增加一个用户，示例代码如下：

```
var db = require('../common/basicConnection');
var $sqlCommands = require('../common/sqlCommands');

/**
 * 增加用户Action
 */
function addUserAction(req, res, next){
    // 获取前台页面传过来的参数
    var param = req.query || req.params;
    // 执行Query
    db.queryArgs($sqlCommands.user_status.insertOne, 
        [param.username,param.password,param.qrcode], 
        function(err, result) {
            if(!err){
                result = {
                    code: 200,
                    msg:'successful'
                }; 
            }
            // 以json形式，把操作结果返回给前台页面
            db.doReturn(res, result);
        }
    );
}

// exports
module.exports = {
	addUserAction: addUserAction
};
```

- 万事俱备只欠东风，接下来就是配置路由，从MVC的模式来讲就是Controller，路由配置在  `router/*.js`，客户端访问的接口，可以只用正则表达式来控制。

```
var express = require('express');
var router = express.Router();
var userDao = require('../dao/userDao')

/**
 * 用户增加的路由控制接口
 */
router.get('/addUserAction', function(req, res, next) {
  userDao.addUserAction(req,res,next)
});

module.exports = router;
```

**NodeJS+Express+MySQL**基本如此。(⊙o⊙)嗯，O(∩_∩)O哈哈~刚好断网。









