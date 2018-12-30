**uuid是什么**
UUID含义是通用唯一识别码 (Universally Unique Identifier)，这 是一个软件建构的标准。
___

今天编译源码竟然出现这样的问题：g++: error: /usr/lib/libuuid.a: 没有那个文件或目录。
使用`sudo apt-get install uuid-dev`安装uuid开发接口后， 头文件/usr/include/uuid/uuid.h存在，但是libuuid.so.1.*和libuuid.a找不到
___
**解决方案：**
在[传送到这里](https://answers.launchpad.net/ubuntu/+source/util-linux/2.20.1-1ubuntu1)中下载到util-linux_2.20.1.orig.tar.gz，里面包含很多系统工具的目录，如包含libuuid目录。
~~~
$tar -xzvf util-linux_2.20.1.orig.tar.gz
$cd util-linux-2.20.1
$./configure --without-ncurses
$cd libuuid
$sudo makemake install
~~~
搞掂～～～

___
**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
