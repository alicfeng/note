**前言**
今天再次在MySQL WorkBench折腾，这个开源的数据库客户端老是读不出数据，以为是数据库权限的问题，服务端毕竟是Linux的，但是不是这问题，不过还是搞了。那只好记录记录一下！
___
> 你没有看出标题，是一步就可以迁移`MySQL`数据库目录，但是使用环境是`Ubuntu`、`基于apt-get安装`。一步安装在篇章的最后。

**说明**
在 Ubuntu 下使用 `sudo apt-get install mysql-server` 安装的 MySQL 数据库，默认的数据目录是` /var/lib/mysql`。

___
**原理步骤**
> 现在希望将数据目录移到 /home/alic/data/mysql ，做法如下：

- 停止MySQL服务

```shell
sudo service mysql stop
```

- 迁移数据库文件

```shell
mv /var/lib/mysql /home/alic/data/mysql
```

- 修改配置

```shell
# 将 datadir 对应的值改为 /home/alic/data/mysql
sudo vim /etc/mysql/my.cnf  

sudo vim /etc/apparmor.d/usr.sbin.mysqld #将所有 /var/lib/mysql 改为 /home/alic/data/mysql
```
- 重启`apparmor`以及`mysql`服务

```shell
sudo service apparmor restart
sudo service mysql start
```
此时手动的配置就搞掂了！也可以一步到位，其实还是通过shell脚本实现了，很简单：就是复制上面的整合的，哈哈笑:-D。
```
#!/bin/bash
sudo service mysql stop && \
mkdir -P /home/alic/data && \
sudo mv /var/lib/mysql /home/alic/data/mysql && \
sudo chmod 777 -R /home/alic/data/* && \
sudo sed -i 's/\/var\/lib\/mysql/\/home\/alic\/data\/mysql/g' /etc/mysql/my.cnf && \
sudo sed -i 's/\/var\/lib\/mysql/\/home\/alic\/data\/mysql/g' /etc/apparmor.d/usr.sbin.mysqld && \
sudo service apparmor restart && \
sudo service mysql restart && \
echo "MySQL数据库目录迁移完成！"
```
运行此脚本便可以搞定！
___
**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
