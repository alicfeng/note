- 开启数据持久化，Redis默认的是不开启持久化的，即关机数据就没有了，但是开启之后对CPU的率用率还是挺大的。
```
#/etc/redis/redis.conf
appendonly yes
```
