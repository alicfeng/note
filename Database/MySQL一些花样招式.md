他说，这里似乎很多玩的，有没有数据库语句好玩的呢？然而随手写了几条，我觉得呢看看书再实践实践应该很不错的。
___

- `CASE WHEN`

  > 条件判断表达式

```mysql
# 字段的值使用代号，节省内存
mysql> SELECT `name`,`age`,`sex` FROM `admin`;
+----------+-----+-----+
| name     | age | sex |
+----------+-----+-----+
| AlicFeng |  21 |   1 |
| Alice    |  20 |   0 |
+----------+-----+-----+

# 通过CASE WHEN条件判断获取目标值
mysql> SELECT `name`,`age`,CASE `sex` WHEN 1 THEN '男' WHEN 0 THEN '女' ELSE '不公开' END AS `sex` FROM `admin`;
+----------+-----+-----+
| name     | age | sex |
+----------+-----+-----+
| AlicFeng |  21 | 男  |
| Alice    |  20 | 女  |
+----------+-----+-----+
```

- `IFNULL`

  > 判断是否为空并处理，判断空值的处理，有允许空值的列是会自动移除索引的，因此不推荐使用。知道就好！

```mysql
# 直接获取字段值，有些为空值
mysql> SELECT `name`,`message` FROM `admin`;
+----------+--------------------------------------------+
| name     | message                                    |
+----------+--------------------------------------------+
| AlicFeng | 价值源于技术，贡献源于分享。               |
| Alice    | NULL                                       |
+----------+--------------------------------------------+

# 查询数据，处理空值
mysql> SELECT `name`,IFNULL(`message`,"这人很懒,没有留下任何东西。") AS `message` FROM `admin`;
+----------+--------------------------------------------+
| name     | message                                    |
+----------+--------------------------------------------+
| AlicFeng | 价值源于技术，贡献源于分享。               |
| Alice    | 这人很懒,没有留下任何东西。                |
+----------+--------------------------------------------+

```

- `IF(EXP1,VALUE1,VALUE2)`

  > IF条件判断，EXP表达式成立的话值为VALUE1，否则为VALUE2

```mysql
# default SELECT
mysql> SELECT `name`,`age` FROM `admin`;
+----------+-----+
| name     | age |
+----------+-----+
| AlicFeng |  21 |
| Alice    |  20 |
+----------+-----+

# 我要根据年龄来判断这个家伙是不是小屁孩
mysql> SELECT `name`,IF(`age`>20,"这个很很黑","小屁孩一个") AS `who` FROM `admin`;
+----------+-----------------+
| name     | who             |
+----------+-----------------+
| AlicFeng | 这个很很黑      |
| Alice    | 小屁孩一个      |
+----------+-----------------+
```

- `UNION` 以及 `UNION ALL`

  > 就是合并，这个没什么好玩的。但是注意查询的字段名必须相同，不管来自哪一个表， ALL的话就是不消除相同行。使用是尽量使用括号括起来，不然有LIMIT、ORDER BY会提示错误。

```mysql
# UNION 
mysql> (SELECT `name` FROM `admin`) UNION (SELECT `name` FROM `user`);
+----------+
| name     |
+----------+
| AlicFeng |
| Alice    |
| 大傻     |
+----------+

# UNION ALL
mysql> (SELECT `name` FROM `admin`) UNION (ALL SELECT `name` FROM `user`);
+----------+
| name     |
+----------+
| AlicFeng |
| Alice    |
| 大傻     |
| AlicFeng |
+----------+
```

- `GROUP BY`+`SUM`+`COUNT`+`ORDER BY`

  > 这个没什么说的，经常会用到就熟悉了。分组+求和+计数+排序

```mysql
mysql> SELECT `age`,COUNT(*) AS `number` FROM `admin` GROUP BY `age` ORDER BY `number` DESC;
+-----+--------+
| age | number |
+-----+--------+
|  21 |      2 |
|  20 |      1 |
+-----+--------+
```

- `WHERE`和`HAVING`联合使用

  > 说明`having`的话肯定有`ORDER BY`，分组后再帅选

```MYSQL
mysql> SELECT `age`,COUNT(*) FROM `admin` WHERE `age`>18 GROUP BY `age` HAVING COUNT(*) >=1;
+-----+----------+
| age | COUNT(*) |
+-----+----------+
|  20 |        1 |
|  21 |        2 |
+-----+----------+
```

- `FROM`

  > 这里说的是`FROM`子查询。举个例子好了，现在我要查询小学小孩子有两科以及以上不及格的同学的平均分成绩和名字。一步一步来！

```mysql
# 首先我要查询出有两个科目不及格的同学
mysql> SELECT `name`,COUNT(*) AS `number_class` FROM `user` WHERE `score`<60 GROUP BY `name` HAVING `number_class`>=2;
+----------+--------------+
| name     | number_class |
+----------+--------------+
| AlicFeng |            2 |
| 大傻     |            2 |
+----------+--------------+

# 既然可以查询出名字了，我们只获取名字即可
mysql> SELECT `name` FROM (SELECT `name`,COUNT(*) AS `number_class` FROM `user` WHERE `score`<60 GROUP BY `name` HAVING `number_class`>=2) AS `user_t`;
+----------+
| name     |
+----------+
| AlicFeng |
| 大傻     |
+----------+

# 名字有了，那么就可以获得最后的结果了
mysql> SELECT `name`,AVG(`score`) FROM `user`  WHERE `name` IN (SELECT `name` FROM (SELECT `name`,COUNT(*) AS `number_class` FROM `user` WHERE `score`<60 GROUP BY `name` HAVING `number_class`>=2) AS `user_t`) GROUP BY `name`;
+----------+--------------+
| name     | AVG(`score`) |
+----------+--------------+
| AlicFeng |      59.6667 |
| 大傻     |      61.6667 |
+----------+--------------+

# PS：这里只是举个例子，正确做法根据学号，这里的数据表结构是这样的(冗余、数据类型不严谨)。
mysql> desc user;
+-------+-------------+------+-----+---------+----------------+
| Field | Type        | Null | Key | Default | Extra          |
+-------+-------------+------+-----+---------+----------------+
| id    | int(11)     | NO   | PRI | NULL    | auto_increment |
| name  | varchar(10) | NO   |     | NULL    |                |
| sub   | varchar(10) | NO   |     | NULL    |                |
| score | int(11)     | NO   |     | NULL    |                |
+-------+-------------+------+-----+---------+----------------+
```

- `WHERE`

  > `WHERE`子查询，一句话，内层查询的结果供外层使用。不多话，举个例子！

```mysql
# 查询一个user表效绩最高的人在另一个表的名言
mysql> SELECT `name`,`message` FROM `admin` WHERE `name`=(SELECT `name` FROM (SELECT `name`,max(`score`) FROM `user`) AS `temp_t`);
+--------+---------+
| name   | message |
+--------+---------+
| 大傻   | 追求    |
+--------+---------+
# PS：可以使用连表查询，还可以分组查找。THIS IS DEMO
```

- `EXISTS`

  > 简单说明：外层查询的结果拿到内层查询，是否成立。

```
mysql> SELECT `name`,`message` FROM `admin` WHERE EXISTS(SELECT `name` FROM `user` WHERE `user`.`name`=`admin`.`name`);
+----------+--------------------------------------------+
| name     | message                                    |
+----------+--------------------------------------------+
| AlicFeng | 价值源于技术，贡献源于分享。               |
| 大傻     | 追求                                       |
+----------+--------------------------------------------+
```



**一下操作，我们先打印一下数据表数据，便于观察**

```shell
mysql> SELECT * FROM `admin`;
+----+----------+-----+-----+--------------------------------------------+
| id | name     | age | sex | message                                    |
+----+----------+-----+-----+--------------------------------------------+
|  1 | AlicFeng |  21 |   1 | 价值源于技术，贡献源于分享。               |
|  2 | Alice    |  20 |   0 | NULL                                       |
|  3 | 大傻     |  21 |   1 | 追求                                       |
+----+----------+-----+-----+--------------------------------------------+
3 rows in set (0.00 sec)

mysql> SELECT * FROM `user`;
+--------+----------+---------+-------+
| id     | name     | sub     | score |
+--------+----------+---------+-------+
|      1 | 大傻     | chinese |    48 |
|      2 | AlicFeng | math    |    28 |
|      3 | 大傻     | math    |    38 |
|      4 | AlicFeng | english |    98 |
|      5 | AlicFeng | math    |    53 |
|      6 | 大傻     | english |    99 |
|      7 | 世界     | math    |    88 |
+--------+----------+---------+-------+

```



- 简单连表查询

  > 在简单的两个表连接查询中，使用`WHERE`和`JOIN ON`查询结果是等效的。

```MYSQL
# JOIN ON
mysql> SELECT `admin`.`name`,`admin`.`message`,`user`.`score` FROM `admin` JOIN `user` ON `admin`.`name`=`user`.`name`;
+----------+--------------------------------------------+-------+
| name     | message                                    | score |
+----------+--------------------------------------------+-------+
| 大傻     | 追求                                       |    48 |
| AlicFeng | 价值源于技术，贡献源于分享。               |    28 |
| 大傻     | 追求                                       |    38 |
| AlicFeng | 价值源于技术，贡献源于分享。               |    98 |
| AlicFeng | 价值源于技术，贡献源于分享。               |    53 |
| 大傻     | 追求                                       |    99 |
+----------+--------------------------------------------+-------+

# WHERE
mysql> SELECT `admin`.`name`,`admin`.`message`,`user`.`score` FROM `admin`, `user` WHERE `admin`.`name`=`user`.`name`;
+----------+--------------------------------------------+-------+
| name     | message                                    | score |
+----------+--------------------------------------------+-------+
| 大傻     | 追求                                       |    48 |
| AlicFeng | 价值源于技术，贡献源于分享。               |    28 |
| 大傻     | 追求                                       |    38 |
| AlicFeng | 价值源于技术，贡献源于分享。               |    98 |
| AlicFeng | 价值源于技术，贡献源于分享。               |    53 |
| 大傻     | 追求                                       |    99 |
+----------+--------------------------------------------+-------+
```

- `左连接`，推荐

  > 特点：以左表为准，去右表找数据，如果没有匹配的数据，则以null补空位，输出结果数>=左表原元祖数

```MYSQL
mysql> SELECT `admin`.`name`,`admin`.`message` FROM `admin` LEFT JOIN `user` ON `admin`.`name`=`user`.`name`;
+----------+--------------------------------------------+
| name     | message                                    |
+----------+--------------------------------------------+
| AlicFeng | 价值源于技术，贡献源于分享。               |
| AlicFeng | 价值源于技术，贡献源于分享。               |
| AlicFeng | 价值源于技术，贡献源于分享。               |
| Alice    | NULL                                       |
| 大傻     | 追求                                       |
| 大傻     | 追求                                       |
| 大傻     | 追求                                       |
+----------+--------------------------------------------+
```

- `右连接`

  > 特点：以右表为准，去左表找数据，如果没有匹配的数据，则以null补空位，输出结果数>=右表原元祖数

```MYSQL
mysql> SELECT `admin`.`name`,`admin`.`message` FROM `admin` RIGHT JOIN `user` ON `admin`.`name`=`user`.`name`;
+----------+--------------------------------------------+
| name     | message                                    |
+----------+--------------------------------------------+
| 大傻     | 追求                                       |
| AlicFeng | 价值源于技术，贡献源于分享。               |
| 大傻     | 追求                                       |
| AlicFeng | 价值源于技术，贡献源于分享。               |
| AlicFeng | 价值源于技术，贡献源于分享。               |
| 大傻     | 追求                                       |
| NULL     | NULL                                       |
+----------+--------------------------------------------+
```

- `内连接`

  > 特点：左右连接的交集。其实与`WHERE`、`JOIN ON`的查询结果一样。	

```mysql
mysql> SELECT `admin`.`name`,`admin`.`message` FROM `admin` INNER JOIN `user` ON `admin`.`name`=`user`.`name`;
+----------+--------------------------------------------+
| name     | message                                    |
+----------+--------------------------------------------+
| 大傻     | 追求                                       |
| AlicFeng | 价值源于技术，贡献源于分享。               |
| 大傻     | 追求                                       |
| AlicFeng | 价值源于技术，贡献源于分享。               |
| AlicFeng | 价值源于技术，贡献源于分享。               |
| 大傻     | 追求                                       |
+----------+--------------------------------------------+
```



___

- 玩玩效率的查询

  > 玩这个肯定需要海量的数据了，好了～搞一个sheel脚本插入海量的数据。

```mysql
# 先来设置MySQL的最大连接数
mysql> set global max_connections=100000;
Query OK, 0 rows affected (0.00 sec)

mysql> show variables like 'max_connections';
+-----------------+--------+
| Variable_name   | Value  |
+-----------------+--------+
| max_connections | 100000 |
+-----------------+--------+
1 row in set (0.00 sec)
```

`shell`

```shell
#!/bin/bash  
date
for i in `seq 1 100000`
do
{
	mysql -usamego -p!@#$%^&123 demo -e "insert into user(name,score,sub) 	values('ALicFeng',78,'math');"  
	sleep 0.01
} &
done
wait
date
exit 0
```

这里的数据还是很少的，最后很多了，执行这个sh时，我眼睛时刻盯着系统温度等信息、手已经放在`CTRL+C`上面了，O(∩_∩)O哈哈~

待续... ...








































