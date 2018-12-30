**libevent简介**
libevent是一个基于事件触发的网络库，它是轻量级并专注于网络,适用于windows、linux、bsd等多种平台，内部使用select、epoll、kqueue等系统调用管理事件机制,支持多种I/O多路复用技术（epoll、poll、dev/poll、select和kqueue等），在不同的操作系统下，做了多路复用模型的抽象，可以选择使用不同的模型，通过事件函数提供服务。官网[Alic传送](http://libevent.org/)
___
**环境**
ubuntu14.04
___
**libevent安装**
~~~
$sudo apt-get install libevent-dev
~~~
上面是采取源的自动安装方式，也可以采取源码编译的方式，这样的话可以安装最新的版本，不过install也只不过是是安装最新的上一个版本，也不是很旧的。
下载源码后cd到根目录
~~~
#配置安装目录，并非一定要在 /usr 下，默认就是/usr/share但必须保证 libevent 和 memcached 必须安装在同一个目录下
#可以不执行此句
$./configure --prefix=/usr/share
#编译
$make
# 安装
$make install
~~~
___
**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
