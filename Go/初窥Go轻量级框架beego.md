**前言**
初窥Go轻量级框架beego
- 基于Go语言的轻量级Web框架
- 国人开发的优秀框架
- 稳定可靠、社区氛围好、作者负责、值得推荐
- 一个值得研究的框架 世界第二个值得我学习的Web框架
___
**测试环境**
- ubuntu 14.04 32-OS
- Go 1.6+[Go语言的安装与配置](http://www.jianshu.com/p/43835e23f195)
-  $GOPATH  ➜ /home/alic/WorkSpace/GoWeb
___
**安装说明**
安装beego框架
~~~
$go get github.com/astaxie/beego
~~~
安装bee框架工具
~~~
go get github.com/beego/bee
~~~
将bee添加到环境变量
~~~
export PATH=$PATH:/home/alic/WorkSpace/GoWeb/bin
~~~
以上执行没有问题的话，那么beego环境搭建已经okay啦！可以创建helloWorld测试环境
~~~
# 建立helloWorld程序
$bee new helloWorld

# 运行helloWorld程序
$bee run helloWorld
~~~
注意：要是出现这个问题的话->看图
![no space left on device](http://upload-images.jianshu.io/upload_images/1678789-37356c14a29721cb.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
解决方案：
[参照markjour](http://www.markjour.com/article/cannot-add-inotify-watch.html)
~~~
# 编辑 /etc/sysctl.conf
vim /etc/sysctl.conf

#添加下面一句
fs.inotify.max_user_watches = 65536

# 重启生效
$ sudo sysctl -p /etc/sysctl.conf
# or 不行就重启机器
$ sudo reboot
~~~
看！！已经okay啦～～～
![Okay](http://upload-images.jianshu.io/upload_images/1678789-21ec2380c53d7591.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
___
**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
