**需求**
`oracle存储过程`使用配置的方式加载。
临时的解决方案就是使用`shell`加载`sql`文件的形式来解决。

- 临时的解决方案
> 存储过程的创建脚本为`procedure.sql`
```shell
sqlplus username/pwd@dbsid<< EOF
@procedure.sql
disconnect
quit
EOF
```
