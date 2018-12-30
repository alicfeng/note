
- 使用系统用户登录

```
[username/password][@server][as sysdba|sysoper]
```

- 查看登录的用户

```
show user
```
- 启用scott用户

```
alter user scott account unlock|lock;
```

- 创建表空间

```
# 表空间
create tablespace $teblespace_name datafile '$filepath' size $sizeM;

# 临时表空间
create temporary tablespace $teblespace_name tempfile '$filepath' size $sizeM;
```

- 查看表空间的路径

```
select file_name from dba_data_files where tablespace_name='$tablespace_name';

# 临时表空间的路径
select file_name from dba_data_files where tablespace_name='$tablespace_name';

```

- 修改表空间

```
# 设置联机或脱机状态
alter tablespace $tablespace_name online | offline;

# 增加数据文件
alter tablespace $tablespace_name add datafile '$filepath' size $sizeM;
# 删除数据文件 注意不能删除第一个否则全部删掉
alter tablespace $tablespace_name drop datafile '$filepath' size $sizeM;
```

- 删除表空间

```
# 仅仅删除表空间
drop tablespace $tablespace_name
# 删除表空间以及数据文件
drop tablespace $tablespace_name include contents
```

# 创建表

```
create table $table_name 
(
$column_name datatype,
...
)

create table userinfo
(
id number(6,0),
username vachar2(20),
regdate date
);
```

- 修改表

```
# 添加字段
alter table $table_name add column_name datatype;

# 更改数据的类型
alter table $table_name modify column_name datatype;

# 删除字段
alter table $table_name drop column column_name;

# 修改字段名
alter table $table_name rename column $column_name to $new_column_name;

# 修改表名
rename $table_name to $new_table_name;
```

- 删除表


```
# 删除表数据
truncate table $table_name

# 删除数据表
drop table $table_name

```
a
- 插入数据

```
insert into (id,username,regdate) values (1,'alicfeng',sysdate);
```

- 复制数据

```
# 建表时复制数据
create userinfo_new as select * from userinfo;
create userinfo_new as select id,username from userinfo;

# 在添加时复制 对用的字段名可以不一样，但是类型一定要一致
insert into $table_name 
[(column,...)]
select column,...|from $other_table_name;

```

- 更改表数据

``
update $table_name set column=$value where column=$condition;
```

- 删除表数据

```
delete from $table_name where column=$value;
```

- 非空约束

```
create table $table_name(
column_name datatype not null,
...
)
```

- 主键约束

```
create table $table_name (
column_name datatype primary key,
...
)


# 多字段组合主键约束
create table userinfo(
id number(6,0),
username varchar2(),
userpwd varchar2(32),
constraint pk_userinfo_id_username primary key (id,username);
)

# 查看表的主键名称 注意大写
select constraint_name from user_constraints where table_name='USERINFO';

# 禁用开启主键约束
alter table userinfo disable|enable contraint pk_userinfo_id_username;
# 删除约束
alter table userinfo drop contraint pk_name;
# 等效上面
alter table userinfo drop primary key;
```

- 外键约束

```
create table $table_slave_name (
column_name datatype references $table_master_name(column_primary),
...
)
```
s
