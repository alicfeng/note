**前言**
几乎每次面试都会有一个很基本的问题，实习生的基本问题，那就是
> 如何优化数据库或减少数据库的压力？
(1) 合理增加索引
(2) 优化SQL语句
(3) 主从配置(读写分离)
(4) ...
注意：除了上面的几点外，我们还可以使用缓存机制，比如Redis、Memcache等等

___

**Memcache简介**
 Memcache是danga.com的一个项目，最早是为 LiveJournal 服务的，目前全世界不少人使用这个缓存项目来构建自己大负载的网站，来分担数据库的压力。Memcache依赖libevent事件协程组件，存储机制为键值对的形式，数据存储的方式为内存式。它可以应对任意多个连接，使用非阻塞的网络IO。由于它的工作机制是在内存中开辟一块空间，然后建立一个HashTable，Memcached管理这些HashTable，所以速度非常快。
___

 **Memcache的安装** 
```shell
# memcache依赖libevent
sudo apt-get install libevent-2.0-5 memcached
```
___

**在何处使用memcache**
第一：数据库查询（select）使用
第二：在控制回话（sesion）使用
___

**PHP的Memcache客户端所有方法总结** 
```php
Memcache::add – 添加一个值，如果已经存在，则返回false 
Memcache::addServer – 添加一个可供使用的服务器地址 
Memcache::close – 关闭一个Memcache对象 
Memcache::connect – 创建一个Memcache对象 
Memcache::memcache_debug – 控制调试功能 
Memcache::decrement – 对保存的某个key中的值进行减法操作 
Memcache::delete – 删除一个key值 
Memcache::flush – 清除所有缓存的数据 
Memcache::get – 获取一个key值 
Memcache::getExtendedStats – 获取进程池中所有进程的运行系统统计 
Memcache::getServerStatus – 获取运行服务器的参数 
Memcache::getStats – 返回服务器的一些运行统计信息 
Memcache::getVersion – 返回运行的Memcache的版本信息 
Memcache::increment – 对保存的某个key中的值进行加法操作 
Memcache::pconnect – 创建一个Memcache的持久连接对象 
Memcache::replace -对一个已有的key进行覆写操作 
Memcache::set – 添加一个值，如果已经存在，则覆写 
Memcache::setCompressThreshold – 对大于某一大小的数据进行压缩 
Memcache::setServerParams – 在运行时修改服务器的参数 
```
___
**使用缓存的机制**
对于基本的缓存机制很简单，如图所示

![image.png](http://upload-images.jianshu.io/upload_images/1678789-1aa674cf1865b4fb.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

代码展示
```php
<?php
/**
 * Created by alic(AlicFeng) on 17-7-18 下午3:38 from PhpStorm.
 * Email is alic@samego.com
 */
//创建memcache对象
$memcache = new Memcache();
$memcache->connect("localhost", 11211);

/** - core 获取数据 **/

//先从缓存读取数据
$data = $memcache->get("data");
//倘若缓存没有数据，那么我们需要从数据库读取
if(!$data){
    echo "<strong>data come from db</strong><br>";
    $db = new mysqli("localhost","samego","samego","demo");
    $sql = "SELECT * FROM `demo`";
    $result = $db->query($sql);
    $data = array();
    while ($row = $result->fetch_assoc()){
        $data[] = $row;
    }
    $result->free();
    $db->close();
    //既然从数据库获取了数据，那就保存到内存
    $memcache->set("data",$data,MEMCACHE_COMPRESSED,3600);
}

print_r($data);
// close
$memcache->close();

```




