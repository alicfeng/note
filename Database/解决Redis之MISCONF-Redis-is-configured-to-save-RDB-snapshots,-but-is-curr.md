**前言**
标题很长哈！今天操作Redis的时候出现了MISCONF Redis is configured to save RDB snapshots, but is currently not able to persist on disk. Commands that may modify the data set are disabled. Please check Redis logs for details about the error.这提示及其友好，虽长但我喜欢，框架只返回result=2并且又没有api文档，然而我就懵逼了，你咋不上天，我就立马上服务器，使用command操作，嘿嘿问题来了就去
___
**Redis问题**
MISCONF Redis is configured to save RDB snapshots, but is currently not able to persist on disk. Commands that may modify the data set are disabled. Please check Redis logs for details about the error.
Redis被配置为保存数据库快照，但它目前不能持久化到硬盘。用来修改集合数据的命令不能用。请查看Redis日志的详细错误信息。
___
**原因**
强制关闭Redis快照导致不能持久化。
 ___
**解决方案**
将stop-writes-on-bgsave-error设置为no
~~~
127.0.0.1:6379> config set stop-writes-on-bgsave-error no
~~~
___
**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
