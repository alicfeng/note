**前言：**
空是挺有空的，早上将时间拿来PHP，谁知后来被玩到现在，我都接近愤怒的边缘了，恩～好让你折腾我。还有让我愤怒的就是`pecl`安装扩展，能否安装成功就是看运气的。还有我的主机是32位的，不多说了，图书馆又快将闭关了。
___

**安装LANMP**
> 说明：Linux+Apache+Nginx+MySQL+PHP
Nginx用于代理转发，处理静态资源
其他的交给Apache处理

脚本就不贴出来了，`github-shell` [送你过去](https://github.com/alicfeng/Linux_env/blob/master/server/build/lanmp/build-14.04-32os.sh)。这个脚本安装的环境是Ubuntu14.04-32OS。
___

**安装MongoDB**
```shell
sudo apt-get install mongodb
```
> 我是暂时测试来使用的，apt-get安装的版本会旧，况且我的还是32位系统，其实新版本的都不支持32位系统了，差了好多版本。推荐使用源码编译安装。

___

**PHP-MongoDB-Driver**
重点来说一下**PHP对mongoDB的扩展**，说白了就是PHP对mongoDB的驱动模块。其实很简单，一条命令的事情，为什么很重呢？
- 其一：网络问题，不是一般的网络问题，看运气！推荐使用源码编译安装。
- 其二：依赖问题，来吧Google，去吧，百度。
- 驱动分支问题，mongo驱动被淘汰，迎接mongodb新驱动，我以为老的系统旧的mongo数据库就应该使用旧的驱动。

```shell
# 不行也要多次尝试安装，一定要稳住！！！
sudo pecl install mongodb
```
可能会终端、也可能不能连接网络、也可能提示没有这玩意，各样的问题，但是你要稳住、记住要稳住。

提示一个可能会遇到的依赖问题：
```
In file included from /usr/include/php5/ext/spl/spl_iterators.h:27:0,
                 from /tmp/pear/temp/mongodb/php_phongo.c:34:
/usr/include/php5/ext/pcre/php_pcre.h:29:18: fatal error: pcre.h: No such file or directory
 #include "pcre.h"
                  ^
compilation terminated.
make: *** [php_phongo.lo] 错误 1
ERROR: `make' failed
```
原因就是缺少`libpcre3 `、`libpcre3-dev`这两个玩意。直接安装即可！
解决方案：
```shell
sudo apt-get install libpcre3 libpcre3-dev
```
___

**PHP使用MongoDB**

至此，环境已经搭建完成了，接着就是如何在PHP中使用MongoDB了。
在此，我推荐两个库：ThinkPHP官方的和PHP官方的库。
个人推荐呢，还是使用PHP官方的，因为TP这个库是不久前开发的，处于一直更新的状态，并且封装的不是很好，诸多bug，一眼看过去全都是`MySQL`的味道，PHP官方的很棒，原子操作、简洁，对于TP官方的文件大小相比，PHP文件多大，然而TP就只有三个文件。

- TP官方的使用方法

这里就不多说了，还是扔下一个链接好了-[ThinkPHP-MongoDB-Usage](https://github.com/top-think/think-mongo)。







