# 环境
 - CentOS 7.2
- Redis 4.0.6

___

**安装编译依赖包**
~~~shell
sudo yum -y install gcc gcc-c++ autoconf automake make
~~~

**安装redis依赖**

~~~shell
sudo yum install tcl
~~~

**编译安装Redis**
~~~shell
wget http://download.redis.io/releases/redis-4.0.6.tar.gz
tar -zxvf redis-4.0.6.tar.gz
cd redis-4.0.6
make -j 4
make install PREFIX=/home/alic/service/redis-4.0.6
cd src
make test
make
sudo make install
~~~

**添加配置文件并配置系统变量**
~~~shell
cp redis.conf  ~/service/redis-4.0.6/
sudo vim /etc/profile
#set redis envirenment
#export REDIS_HOME=/home/alic/service/redis-4.0.6
#export PATH=$PATH:$REDIS_HOME
source /etc/profile
~~~

**启动并使用**
~~~shell
#开启服务端
[alic@samego redis-4.0.6]$ redis-server /home/alic/service/redis-4.0.6/redis.conf 
30389:C 18 Jun 17:10:44.813 # oO0OoO0OoO0Oo Redis is starting oO0OoO0OoO0Oo
30389:C 18 Jun 17:10:44.813 # Redis version=4.0.6, bits=64, commit=00000000, modified=0, pid=30389, just started
30389:C 18 Jun 17:10:44.813 # Configuration loaded

#客户端连接
[alic@samego redis-4.0.6]$ redis-cli -p 6378
127.0.0.1:6378> get name
"alicfeng"
~~~









