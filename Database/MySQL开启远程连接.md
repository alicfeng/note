**前言**
学习MySQL重新整理以前非MK的记载

___

**描述**
没有开启的话连接数据库报错：2003-can't connect to MYSQL

___

**方法/步骤**

- 第一步

> 远程连接上Linux系统，确保Linux系统已经安装上了MySQL数据库。登陆数据库。

```shell
mysql -u$user -p $pwd
```
- 第二步

> 创建用户用来远程连接

```mysql
GRANT ALL PRIVILEGES ON *.* TO '$username'@'%' IDENTIFIED BY '$password' WITH GRANT OPTION;
```

> $username表示用户名，%表示所有的电脑都可以连接，也可以设置某个ip地址运行连接，$password表示密码

- 第三步

> 执行 flush privileges;命令立即生效

```mysql
FLUSH PRIVILEGES;
```

- 第四步

> 查询数据库的用户

```mysql
SELECT DISTINCT CONCAT('User: ''',user,'''@''',host,''';') AS query FROM mysql.user;
```

- 第五步

>然后打开vim /etc/mysql/my.cnf
将bind-address = 127.0.0.1
设置成bind-address = 0.0.0.0（设备地址）

重新启动

```
/etc/init.d/mysql restart
```

- 查看MYsql全局的端口( 默认是3306 )

```mysql
#查看端口号
show global variables like 'port';
```

**至此已经配置完成**

**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
