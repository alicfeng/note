**前言**
十一点半了，沉淀时间到了。
>PHP在运行的时候，存在这样的一个流程，先将PHP代码预编译，生成字节码后再加载到内存里，最后CPU在内存上执行编译后的字节码片段。我们会发现，在执行PHP程序的时候，每次都经过这样的流程，此非浪费Time，是的，很容易联想到：为何不向C++语言看齐呢，将源码编译成可直接加载到内存so哥呢？呃呃😊。快拿出你的步枪，装上这颗子弹`OPcache`。自从PHP5.5.0出来后，就内置此zend扩展了。
___

**What is OPcache**
`OPcache`是PHP中的Zend扩展，可以大大提升PHP的性能。
OPcache 通过将 PHP 脚本预编译的字节码存储到共享内存中来提升 PHP 的性能， 存储预编译字节码的好处就是 省去了每次加载和解析 PHP 脚本的开销。

___
**Judge whether it has been extended OPcache**
```shell
➜  ~ php -m | grep OPcache
Zend OPcache
Zend OPcache
```
> 倘若没有开启的话，可以在php.ini配置中开启
>/home/samego/service/php7.2/php.ini
```shell
➜  ~ echo zend_extension="opcache.so" >> /home/samego/service/php7.2/php.ini
```
___

**About OPcache configure**
接下来，我们需要在 PHP 的配置文件中启用 OPcache（默认是关闭的）：
```
opcache.enable=1
```

下面我们继续对 OPcache 进行一些优化配置：
```
opcache.memory_consumption=512
```

这个配置表示你想要分配给 OPcache 的内存空间（单位：MB），设置一个大于 64 的值即可。
```
opcache.interned_strings_buffer=64
```

这个配置表示你想要分配给实际字符串的空间（单位：MB），设置一个大于 16 的值即可。
```
opcache.max_accelerated_files=32531
```

这个配置表示可以缓存多少个脚本，将这个值尽可能设置为与项目包含的脚本数接近（或更大）。
```
opcache.validate_timestamps=0
```

改配置值用于重新验证脚本，如果设置为 0（性能最佳），需要手动在每次 PHP 代码更改后手动清除 OPcache。如果你不想要手动清除，可以将其设置为 1 并通过 opcache.revalidate_freq 配置重新验证间隔，这可能会消耗一些性能，因为需要每隔 x 秒检查更改。
```
opcache.save_comments=1
```

这个配置会在脚本中保留注释，我推荐开启该选项，因为一些库依赖于这个配置，并且我也找不出什么关闭它的好处。
```
opcache.fast_shutdown=0
```

快速关闭会给一个更快速清理内存的机制，不过，在我的基准测试中，更慢一些，可能这会应用带来一些性能提升，但是你需要自己去尝试。

所以，最终的配置优化长这样：
```
opcache.enable=1
opcache.memory_consumption=512
opcache.interned_strings_buffer=64
opcache.max_accelerated_files=32531
opcache.validate_timestamps=0
opcache.save_comments=1
opcache.fast_shutdown=0
```
`你可以使用这些配置值进行实验，具体配置值取决于你的应用大小和服务器配置。`
[学习于Laravel社区](http://laravelacademy.org/post/7326.html)

___
**Laravel OPcache**
- install 
```shell
➜  ~ composer require appstract/laravel-opcache
```

- configure
```shell
➜  ~ php artisan vendor:publish --provider="Appstract\Opcache\OpcacheServiceProvider" --tag="config"
```

- command
```shell
# Clear OPcache:
➜  ~ php artisan opcache:clear

# Show OPcache config:
➜  ~ php artisan opcache:config

# Show OPcache status:
➜  ~ php artisan opcache:status

# Pre-compile your application code:
➜  ~ php artisan opcache:optimize
```

**拭目以待的场景测试**
> 个人比较喜欢数据说话
> 场景：(1)请求GET接口 (2)测试次数10  (3)并发数为100

`case non-extension`
> 1000个请求，花费32.32秒，每秒30.94个请求
```shell
Transactions:		        1000 hits
Availability:		      100.00 %
Elapsed time:		       32.32 secs
Data transferred:	        0.97 MB
Response time:		        0.32 secs
Transaction rate:	       30.94 trans/sec
Throughput:		        0.03 MB/sec
Concurrency:		        9.96
Successful transactions:        1000
Failed transactions:	           0
Longest transaction:	        0.44
Shortest transaction:	        0.11
```

`case had extend`
> 1000个请求，花费2.94秒，每秒340.14个请求

```shell
Transactions:		        1000 hits
Availability:		      100.00 %
Elapsed time:		        2.94 secs
Data transferred:	        0.97 MB
Response time:		        0.03 secs
Transaction rate:	      340.14 trans/sec
Throughput:		        0.33 MB/sec
Concurrency:		        9.86
Successful transactions:        1000
Failed transactions:	           0
Longest transaction:	        0.29
Shortest transaction:	        0.01
```

**看到这组数据，我甚是高兴，无比的喜悦。在性能方面，形成如此鲜明的对比，我二话不说~OPcache is right**
`(¦3[▓▓] 晚安`
[价值源于技术，技术源于分享！](https://github.com/alicfeng/)
