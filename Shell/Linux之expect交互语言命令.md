**前言**
记得在去年在蝴蝶脚本已经看到过expect，只不过没有去留意它是什么，是干什么的，然而今天去了解了，并利用它来写自动化交互脚本。在服务器开发中，有时候需要同步文件(scp)，远程服务器(ssh)等等，难免要进行密码的检验，这就麻烦了，不过认识expect就有解决方案啦，那么我们来认识一下吧~~~
____
**expect简介**
expect是Linux脚本编程工具语言，用来实现自动和交互式任务进行通信，从而不用手动处理。换句话说就是这些命令和程序是期望从终端得到输入，一般来说这些输入都需要手工输入进行的。 expect可以根据程序的提示模拟标准输入提供给程序需要的输入来实现交互程序执行。
___
**expect安装**
~~~
$sudo apt-get install expect
~~~
___
**简单使用**
~~~
#!/usr/bin/expect
# ---------- 配置信息开始----------
#变量
set password heiheiPsd 
# expect脚本设置 
set timeout -1
#  ----------配置信息结束----------

spawn ssh root@192.168.88.888
expect "*password:"
send "$password\r"
interact
~~~
- send：用于向进程发送字符串
- expect: 期望从进程接收到的字符串，后面也可以跟正则表达式
- spawn：启动进程
- set timeout -1 ：脚本运行超时(秒)  -1不会超时 
___
**与bash共用**
从上面可以看出第一行已经指定了脚本的解析器，但是很多时候或场景我们只希望expect作为shell脚本的一个小小的调用部分，然而使可以的，这也是最常用的。
~~~
#!/bin/bash

echo "this bash func"

#---------expect开始----------
set password fenglican 
set timeout -1

expect<<- END
spawn ssh root@192.168.88.888
expect "*password:"
send "$password\r"
interact

END
#---------expect结束----------
~~~
___
Linux运维基础且常用命令
[Linux之crontab定时任务](http://www.jianshu.com/p/838db0269fd0)
[Linux之sed文本处理命令](http://www.jianshu.com/p/8269c36331ee)
[Linux之ps进程查看命令](http://www.jianshu.com/p/367276be1469)
[Linux之expect交互语言命令](http://www.jianshu.com/p/59f2e14e2535)
[Linux之tail命令](http://www.jianshu.com/p/168e8a01c2e2)
___
**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
