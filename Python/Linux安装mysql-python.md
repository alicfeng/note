前言：大多数Linux系统基本都是带有python的，并且有些还带有两个版本，但是没有带有mysql-python模块，需要自行安装与配置，好吧，下面就来谈谈吧！
___
**系统环境**
操作系统：Ubuntu
数据库：MySQL
脚本语言：Python
___
**Step-One：安装MySQL开发工具libmysqld-dev**
~~~
$ sudo apt-get install libmysqld-dev
~~~
___
**Step-Two：安装Python开发工具python-dev**
~~~
$ sudo apt-get install python-dev
~~~
___
**Step-Three：安装MySQL开发工具libmysqld-dev**
~~~
$ sudo apt-get install libmysqld-dev
~~~
___
**Step-Four：安装Python包管理工具pip**
~~~
$ sudo apt-get install python-pip
~~~
___
**Step-Five：安装mysql-python**
~~~
$ sudo pip install mysql-python
~~~
___
测试已经oka啦

附上ubuntu 163源
~~~
deb http://mirrors.163.com/ubuntu/ trusty main restricted universe multiverse
deb  http://mirrors.163.com/ubuntu/ trusty-security main restricted universe multiverse
deb http://mirrors.163.com/ubuntu/ trusty-updates main restricted universe multiverse
deb http://mirrors.163.com/ubuntu/ trusty-proposed main restricted universe multiverse
deb http://mirrors.163.com/ubuntu/ trusty-backports main restricted universe multiverse
deb-src http://mirrors.163.com/ubuntu/ trusty main restricted universe multiverse
deb-src http://mirrors.163.com/ubuntu/ trusty-security main restricted universe multiverse
deb-src http://mirrors.163.com/ubuntu/ trusty-updates main restricted universe multiverse
deb-src http://mirrors.163.com/ubuntu/ trusty-proposed main restricted universe multiverse
deb-src http://mirrors.163.com/ubuntu/ trusty-backports main restricted universe multiverse
~~~
**价值源于技术，贡献源于分享**
