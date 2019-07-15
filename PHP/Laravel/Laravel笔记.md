#### CLI

###### 导出数据表信息( 表结构 )

`https://github.com/Xethron/migrations-generator`

```shell
php artisan migrate:generate table1,table2,table3,table4,table5
```



###### 表结构导进数据库

```shell
php artisan migrate --path=
```



###### 生成空表结构

```shell
artisan make:migration --table={table_name} {file_name}
```

