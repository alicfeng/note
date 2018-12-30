**前言**
记得在去年的去年去了开源中国在广州举行的一次原创会，腾讯负责管理qq空间后台的一位程序员说了一句话：在PHP和NodeJS徘徊中选择了NodeJS开发qq空间后台。这次选了nodeJS听听老师的吹水，顺便也要玩一下...
___

**WebStorm安装**
[WebStorm官网](https://www.jetbrains.com)，WebStorm属于jetbrains全家桶之一，至于如何安装没什么好说的，解压即用。

![WebStormg](http://upload-images.jianshu.io/upload_images/1678789-0cba8a7b2c0bd69d.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
___

**nodeJS安装**
解决nodeJS依赖libssl-dev、g++
~~~
sudo apt-get update && sudo apt-get install -y libssl-dev g++
~~~

方法一：apt-get 安装
此方法极其简单，但是强烈不推荐。
具体安装查看github[nodeJS+npm+express-generator一键安装shell](https://github.com/alicfeng/Alic_env/blob/master/nodeJS/build.sh)脚本。


方法二【推荐】：tar安装
此方法就是将已经编译好的源码直接解压，并配置node环境变量即可！
[nodeJS官网](https://nodejs.org)
获取node压缩文件`node-v6.10.0-linux-x64.tar.xz`
**安装nodeJS**
~~~
sudo mv node-v6.10.0-linux-x64.tar.xz /opt
sudo tar xz -d node-v6.10.0-linux-x64.tar.xz 
sudo tar -xvf node-v6.10.0-linux-x64.tar
#强迫症-改名
sudo mv node-v6.10.0-linux-x64 node-v6.10.0 -r
~~~
**配置环境**
~~~
sudo vim /etc/profile
~~~
>export NODE_HOME=/opt/node-v6.10.0
>export PATH=$PATH:$NODE_HOME/bin
>export NODE_PATH=$NODE_HOME/lib/node_modules

**查看版本**
~~~
#先刷新环境变量...
➜  ~ source /etc/profile
➜  ~ node -v
v6.10.0
~~~
___

**WebStorm配置nodeJS**
  `File`➜ `Settings`➜ `Languages & Framework`➜`node.js and NPM`

![Paste_Image.png](http://upload-images.jianshu.io/upload_images/1678789-da817f21b3a66886.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

___
**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
