**解决方案：**
在连接到数据库后加上这么一句
linux环境
~~~
mysql_query(connection, "SET NAMES UTF8");
~~~
windows环境
~~~
mysql_query(connection, "SET NAMES GB2312");
~~~
注意connection为：
~~~
MYSQL *connection;
~~~
___
**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
