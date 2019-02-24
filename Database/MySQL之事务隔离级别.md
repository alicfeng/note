## MySQL之事务隔离级别

## 前言

MySQL事务主要用于处理一个包含操作量比较大、复杂的业务。比如说，删除一个学生，我们除了要删除该学生的基本信息，同时也要删除考试记录、违规记录等。诸多的操作组成一个事务。事务是用来管理`insert`、`update`、`delete`基本指令的。当MySQL使用**innodb**引擎的前提下才支持事务操作。

#### 事务的基本特点

- **原子性**

  一个事务的执行所有的操作，结果只有两种：要么全部执行、要么全部不执行。事务在执行的过程中，当在某一个节点执行发生错误的时候，事务会被执行`rollback`操作，将数据恢复到执行该事务之前的状态。A去银行转账，要么转账成功、要么转账失败。

- **一致性**

  从事务开始执行到执行完成后，数据库的完整性约束完全没有收到破坏。A转账给B，不可能发生这种情况：A转账成功、B没有收到款。

- **隔离性**

  在同一时间点，数据库允许多个并发事务同时对其数据进行读写和修改的能力，隔离性可以防止多个事务并发执行时由于交叉执行而导致数据的不一致。事务隔离分为不同级别，包括读未提交( `read uncommitted` )、读提交( `read committed` )、可重复读( `repeatable read`|默认方式 )和串行化( `serializable` )。

- **持久性**

  事务成功执行后，事务的所有操作对数据库的更新是永久的，不能回滚。



#### 隔离性的类别

- `read uncommitted` | 读未提交
- `read committed` | 读已提交
- `repeatable read` | 可重复读
- `serializable` | 串行化

在`MySQL`数据库中，引擎默认使用`repeatable read`

```mysq;
# SELECT @@tx_isolation 或者 SELECT @@transaction_isolation
# MySQL 8.x 
# transaction_isolation在MySQL 5.7.20中添加了作为别名 tx_isolation，现已弃用，并在MySQL 8.0中删除。
# 应调整应用程序transaction_isolation以优先使用 tx_isolation。
mysql> SELECT @@transaction_isolation;
+-------------------------+
| @@transaction_isolation |
+-------------------------+
| REPEATABLE-READ         |
+-------------------------+
1 row in set (0.01 sec)
```



#### 事务的并发问题

- **脏读**

  **事务A**读取了**事务B**更新的数据，然后**事务B**在某些因素下执行了回滚，那么**事务A**读取的数据就是不合理的，即脏数据。

  ```mysql
  ## (1)事务A的操作
  ## 设置为隔离方式为[读未提交 | read uncommitted]
  ## 开启事务并查询id为1的score的值 
  mysql> set session transaction isolation level read uncommitted;
  Query OK, 0 rows affected (0.00 sec)
  
  mysql> start transaction;
  Query OK, 0 rows affected (0.00 sec)
  
  mysql> select * from score;
  +----+----------+-------+
  | id | name     | score |
  +----+----------+-------+
  |  1 | alicfeng |    80 |
  |  2 | feng     |   100 |
  |  3 | alic     |    90 |
  +----+----------+-------+
  3 rows in set (0.00 sec)
  
  ## (2)事务B的操作
  ## 开启事务并将id为1的score修改成 75
  mysql> start transaction;
  Query OK, 0 rows affected (0.00 sec)
  
  mysql> update score set score=75 where id=1;
  Query OK, 1 row affected (0.00 sec)
  Rows matched: 1  Changed: 1  Warnings: 0
  
  mysql> select * from score;
  +----+----------+-------+
  | id | name     | score |
  +----+----------+-------+
  |  1 | alicfeng |    75 |
  |  2 | feng     |   100 |
  |  3 | alic     |    90 |
  +----+----------+-------+
  3 rows in set (0.00 sec)
  
  ## (3)事务A的操作
  ## 再次读取id为1的score值 75
  mysql> select * from score;
  +----+----------+-------+
  | id | name     | score |
  +----+----------+-------+
  |  1 | alicfeng |    75 |
  |  2 | feng     |   100 |
  |  3 | alic     |    90 |
  +----+----------+-------+
  3 rows in set (0.00 sec)
  
  ## (4) 事务B的操作
  ## 事务回滚
  mysql> rollback;
  Query OK, 0 rows affected (0.00 sec)
  ```

  上述四个步骤中，**事务A**在**事务B**前读取的`score`的值为`80`，在**事务B**执行修改后读取`score`的值为`75`，**事务B**再进行回滚操作，那么**事务A**在两次读取的`score`的值是不一致的，那么就是脏读。



- **不可重复读**

  **事务A**需要重复多次读取某组数据，**事务A**在**事务B**对该组数据修改提交前后进行读取，很显然、两次读取的数据是不一致的，即不可重复读。侧重于元数据的修改。

  ```mysql
  ## 使用[读已提交]的模式实践
  mysql> set session transaction isolation level read committed;
  Query OK, 0 rows affected (0.00 sec)
  
  ## (1) 事务A查询id为1的score 80
  mysql> select * from score;
  +----+----------+-------+
  | id | name     | score |
  +----+----------+-------+
  |  1 | alicfeng |    80 |
  |  2 | feng     |   100 |
  |  3 | alic     |    90 |
  +----+----------+-------+
  3 rows in set (0.00 sec)
  
  ## (2) 事务B修改id为1的score并提交事务 75
  mysql> update score set score=75 where id=1;
  Query OK, 1 row affected (0.01 sec)
  Rows matched: 1  Changed: 1  Warnings: 0
  
  mysql> commit;
  Query OK, 0 rows affected (0.00 sec)
  
  ## (3) 事务A再次查询id为1的score的值 75
  mysql> select * from score;
  +----+----------+-------+
  | id | name     | score |
  +----+----------+-------+
  |  1 | alicfeng |    80 |
  |  2 | feng     |   100 |
  |  3 | alic     |    90 |
  +----+----------+-------+
  3 rows in set (0.00 sec)
  
  mysql> select * from score;
  +----+----------+-------+
  | id | name     | score |
  +----+----------+-------+
  |  1 | alicfeng |    75 |
  |  2 | feng     |   100 |
  |  3 | alic     |    90 |
  +----+----------+-------+
  3 rows in set (0.00 sec)
  ```

  从上述的三个步骤中显而易见可以看出，事务A在事务B修改并提交的前后读取同一条数据的值得不一样的，具有不可重复读问题。



- **幻读**

  **事务A**在修改每一条元数据的时候，**事务B**在此时添加了一条新记录，**事务A**在处理的过程中突然多了一条数据，即幻读。侧重于数据的删除与修改。

  ```mysql
  ## 将事务隔离的模式设置为[可重复读]
  mysql> set session transaction isolation level repeatable read;
  Query OK, 0 rows affected (0.00 sec)
  
  ## (1)事务A读取scor数据表
  mysql> select * from score;
  +----+----------+-------+
  | id | name     | score |
  +----+----------+-------+
  |  1 | alicfeng |    75 |
  |  2 | feng     |   100 |
  |  3 | alic     |    90 |
  +----+----------+-------+
  3 rows in set (0.00 sec)
  
  ## (2)事务B新增删除一条数据并提交
  mysql> delete from score where id=1;
  Query OK, 1 row affected (0.01 sec)
  
  mysql> commit;
  Query OK, 0 rows affected (0.01 sec)
  
  ## (3)事务A再次读取score数据表
  mysql> select * from score;
  +----+----------+-------+
  | id | name     | score |
  +----+----------+-------+
  |  1 | alicfeng |    75 |
  |  2 | feng     |   100 |
  |  3 | alic     |    90 |
  +----+----------+-------+
  3 rows in set (0.00 sec)
  ```

  可见，**事务A**在**事务B**删除并提交前后读取的数据一样，出现了幻读。



#### 事务隔离级别的影响

|          事务隔离级别          | 脏读 | 不可重复读 | 幻读 |
| :----------------------------: | :--: | :--------: | :--: |
| 读未提交 \| `read uncommitted` |  会  |     会     |  会  |
|  读已提交 \| `read committed`  | 不会 |     会     |  会  |
| 可重复读 \| `repeatable read`  | 不会 |    不会    |  会  |
|    串行化 \| `serializable`    | 不会 |    不会    | 不会 |



#### **事务隔离性说明**

- **隔离级别越高，越能保证数据的完整性和一致性，但是对并发性能的影响也越大。**
- **事务隔离级别为读提交时，写数据只会锁住相应的行**
- **事务隔离级别为串行化时，读写数据都会锁住整张表**

