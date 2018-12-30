**简介**

___
**安装MySQL**
安装mysql就不必多说了
~~~
#server
$sudo apt-get install mysql-server
#client
$sudo apt-get isntall mysql-client
~~~
但是得注意的就是主从mysql的版本最好一致。【推荐版本相同】
___
**MySQL主服务器开启远程连接**
不必浪费时间，直接参考下篇此文章的详细说明
[MySQL开启远程连接](http://www.jianshu.com/p/b9dd813ded09)

___

**服务器信息sameple**
user->admin 
pwd->admin
MySQL主服务器IP->192.16.168.18
MySQL从服务器IP->192.16.168.19
___
**配置MySQL主服务器**
- 配置文件
~~~
$sudo vim /etc/mysql/my.cnf
~~~
- 配置信息
~~~
server-id=1   #必须。设置服务器id，为1表示主服务器。规范为服务器IP的后段
log_bin=mysql-bin  #必须。启动MySQ二进制日志系统。
binlog-do-db=osyunweidb  #需要同步的数据库名，如果有多个数据库，可重复此参数，每个数据库一行。
binlog-ignore-db=mysql   #不同步mysql系统数据库。
~~~
- 重启mysql服务
~~~
$sudo service mysql restart
~~~

![Paste_Image.png](http://upload-images.jianshu.io/upload_images/1678789-ac33b4938045d621.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
注意：主服务器的状态信息从服务器需要用到！
___

**配置MySQL从服务器**
- 配置文件
~~~
$sudo vim /etc/mysql/my.cnf
~~~
- 配置信息
~~~
server-id=2   #必须。设置服务器id，为2表示从服务器。规范为服务器IP的后段
log_bin=mysql-bin  #不必须。启动MySQ二进制日志系统。
binlog-do-db=osyunweidb  #需要同步的数据库名，如果有多个数据库，可重复此参数，每个数据库一行。
binlog-ignore-db=mysql   #不同步mysql系统数据库。
~~~
- 配置MySQL从服务器同步于MySQL主服务器
进入MySQL控制台操作以下命令
~~~
#停止slave同步进程
slave stop;
#执行同步语句
change master to master_host='192.16.168.18',master_user='admin',master_password='admin',master_log_file='mysql-bin.000001' ,master_log_pos=107;    
#开启slave同步进程
slave start;    
#查看slave同步信息。注意：一定要看输出的信息
show slave status;
~~~
 
![show slave status;](http://upload-images.jianshu.io/upload_images/1678789-922682e5c209253b.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
- 重启mysql服务
~~~
$sudo service mysql restart
~~~

___

**测试MySQL主从服务器同步**
首先主从MySQL都要有某个相同的数据库存在！
Step-One：在MySQL主服务器创建一张表demo
Step-Two：在MySQL从服务器查询表demo
要是MySQL从服务器存在demo表即已经成功!

嘿嘿~~~
从MySQL数据库只是随主MySQL而实时改变，但是从MySQL数据库的操作对主MySQL没有任何影响！

___
**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
