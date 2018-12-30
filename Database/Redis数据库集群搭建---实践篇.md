**前言**
理论不多说了，图书馆又快要关门了。
-- 课设需要的环境，搭建记录分享！
还是说一句吧！redis跑内存的数据库，是解决数据交互高并发的解决方案。
___
**场景**
服务器系统：ubuntu 14.04
redis版本：redis 3.2.8
说明：为了方便我只在一台机器模拟多台主机
端口：6379、6380、6381、6382、6383、6384
___

**下载Redis**
[Redis官网](https://redis.io)，自行下载最新稳定版本。
```
wget -c http://download.redis.io/releases/redis-3.2.8.tar.gz
```
___

**安装Redis**
说明：可以直接包管理安装，为了安装最新稳定版，下载源码编译。
倘若多主机服务器的话，每一台主机都需要安装redis。
```
tar -xzvf redis-3.2.8.tar.gz
cd redis-3.2.8
make && sudo make
```
___

**创建集群目录**
说明：此步创建redis集群目录，用户存放redis配置文件。
倘若是多主机服务器搭建，创建相应的一个目录即可！
```
sudo mkdir -p /etc/db/redis_cluster/6379
sudo mkdir -p /etc/db/redis_cluster/6380
sudo mkdir -p /etc/db/redis_cluster/6381
sudo mkdir -p /etc/db/redis_cluster/6382
sudo mkdir -p /etc/db/redis_cluster/6383
sudo mkdir -p /etc/db/redis_cluster/6384
```
___

**配置Redis配置**
说明：从下载解压的文件夹复制redis.conf配置文件到集群相应的目录。
PS：可以先改共同的配置再赋值，方便修改，写一个脚本修改更快。使用自动化运维工具ansible更更方便！！！
```
sudo cp redis-3.2.8/redis.conf /etc/db/redis_cluster/6379/
sudo cp redis-3.2.8/redis.conf /etc/db/redis_cluster/6380/
sudo cp redis-3.2.8/redis.conf /etc/db/redis_cluster/6381/
sudo cp redis-3.2.8/redis.conf /etc/db/redis_cluster/6382/
sudo cp redis-3.2.8/redis.conf /etc/db/redis_cluster/6383/
sudo cp redis-3.2.8/redis.conf /etc/db/redis_cluster/6384/
```

___

**修改Redis配置文件**
说明：修改配置文件，如何修改呢，看下图！！！
懒得写，此图借用，谁的呢？[他的](http://www.jianshu.com/p/8059acb45925)

![redis-cluster](http://upload-images.jianshu.io/upload_images/1678789-67cd3b4704984a74.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
___
**启动Redis集群**
```
➜  ~ redis-server /etc/db/redis_cluster/6379/redis.conf

➜  ~ redis-server /etc/db/redis_cluster/6380/redis.conf

➜  ~ redis-server /etc/db/redis_cluster/6381/redis.conf

➜  ~ redis-server /etc/db/redis_cluster/6382/redis.conf

➜  ~ redis-server /etc/db/redis_cluster/6383/redis.conf

➜  ~ redis-server /etc/db/redis_cluster/6384/redis.conf

➜  ~ ps -ef|grep redis
alic     17880     1  0 20:20 ?        00:00:02 redis-server 127.0.0.1:6379 [cluster]             
alic     18040     1  0 20:24 ?        00:00:02 redis-server 127.0.0.1:6384 [cluster]             
alic     18147     1  0 20:26 ?        00:00:02 redis-server 127.0.0.1:6382 [cluster]             
alic     18171     1  0 20:26 ?        00:00:02 redis-server 127.0.0.1:6380 [cluster]             
alic     18180     1  0 20:26 ?        00:00:02 redis-server 127.0.0.1:6381 [cluster]             
alic     18190     1  0 20:26 ?        00:00:02 redis-server 127.0.0.1:6383 [cluster]

```

___
**安装redis集群工具**
```
➜  ~ sudo apt-get install ruby -y
➜  ~ ruby -v
ruby 1.9.3p484 (2013-11-22 revision 43786) [i686-linux]
➜  ~ sudo gem install redis
```
___

**创建Redis集群**
说明：记得看准哪一个master哪一个slave，再enter。
```
# 拷贝创建的脚本
➜  sudo cp redis-3.2.8/src/redis-trib.rb /usr/local/bin/redis-trib

# 开始创建
➜  redis-3.2.8 /usr/local/bin/redis-trib create --replicas 1 127.0.0.1:6379 127.0.0.1:6380 127.0.0.1:6381 127.0.0.1:6382 127.0.0.1:6383 127.0.0.1:6384
>>> Creating cluster
>>> Performing hash slots allocation on 6 nodes...
Using 3 masters:
127.0.0.1:6379
127.0.0.1:6380
127.0.0.1:6381
Adding replica 127.0.0.1:6382 to 127.0.0.1:6379
Adding replica 127.0.0.1:6383 to 127.0.0.1:6380
Adding replica 127.0.0.1:6384 to 127.0.0.1:6381
M: 947909fe824a082e4c25d91114e3441a6c17acd4 127.0.0.1:6379
   slots:0-5460 (5461 slots) master
M: 3cc8f7cadbda82ab6c41c66e4899e7469fa5624d 127.0.0.1:6380
   slots:5461-10922 (5462 slots) master
M: 74c52e6d219ac011cc84c570eca29105c03a5314 127.0.0.1:6381
   slots:10923-16383 (5461 slots) master
S: edf6badbf89f904cbcc03ef9e5b3d55a558e9426 127.0.0.1:6382
   replicates 947909fe824a082e4c25d91114e3441a6c17acd4
S: 9747856c43b1c180f0985e03488d2f8557e05efc 127.0.0.1:6383
   replicates 3cc8f7cadbda82ab6c41c66e4899e7469fa5624d
S: 6cc366542d37fa6ccce48e771750eab50a0659ac 127.0.0.1:6384
   replicates 74c52e6d219ac011cc84c570eca29105c03a5314
Can I set the above configuration? (type 'yes' to accept): yes
>>> Nodes configuration updated
>>> Assign a different config epoch to each node
>>> Sending CLUSTER MEET messages to join the cluster
Waiting for the cluster to join....
>>> Performing Cluster Check (using node 127.0.0.1:6379)
M: 947909fe824a082e4c25d91114e3441a6c17acd4 127.0.0.1:6379
   slots:0-5460 (5461 slots) master
   1 additional replica(s)
S: 9747856c43b1c180f0985e03488d2f8557e05efc 127.0.0.1:6383
   slots: (0 slots) slave
   replicates 3cc8f7cadbda82ab6c41c66e4899e7469fa5624d
S: 6cc366542d37fa6ccce48e771750eab50a0659ac 127.0.0.1:6384
   slots: (0 slots) slave
   replicates 74c52e6d219ac011cc84c570eca29105c03a5314
S: edf6badbf89f904cbcc03ef9e5b3d55a558e9426 127.0.0.1:6382
   slots: (0 slots) slave
   replicates 947909fe824a082e4c25d91114e3441a6c17acd4
M: 3cc8f7cadbda82ab6c41c66e4899e7469fa5624d 127.0.0.1:6380
   slots:5461-10922 (5462 slots) master
   1 additional replica(s)
M: 74c52e6d219ac011cc84c570eca29105c03a5314 127.0.0.1:6381
   slots:10923-16383 (5461 slots) master
   1 additional replica(s)
[OK] All nodes agree about slots configuration.
>>> Check for open slots...
>>> Check slots coverage...
[OK] All 16384 slots covered.
```

___

**环境测试**
说明：不说了！
```
➜  ~ redis-cli -c -p 6379
127.0.0.1:6379> set author alic
-> Redirected to slot [7142] located at 127.0.0.1:6380
OK
127.0.0.1:6380> get author
"alic"
127.0.0.1:6380> exit
➜  ~ redis-cli -c -p 6383
127.0.0.1:6383> get author
-> Redirected to slot [7142] located at 127.0.0.1:6380
"alic"
127.0.0.1:6380> 

```

Alic say : **[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
