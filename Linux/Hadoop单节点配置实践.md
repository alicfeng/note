**服务器环境**
ubuntu-14.04
hadoop-2.7.3
java-1.8(前提：已经安装好！！！)
___
**hadoop用户**
用户组：hadoop
用    户：hadoop
~~~
# 增加hadoop用户组
$ sudo addgroup hadoop

# 在hadoop用户组增加hadoop用户
$ sudo adduser --ingroup hadoop hadoop

# 登陆hadoop用户测试
$su hadoop
~~~
___

**安装Hadoop**
[hadoop官网](http://hadoop.apache.org)
[hadoop-2.7.3](http://apache.fayea.com/hadoop/common/hadoop-2.7.3/hadoop-2.7.3.tar.gz)
terminal-command
~~~
#进入root用户
$sudo -i

# 下载hadoop
$wget -P /usr/local http://apache.fayea.com/hadoop/common/hadoop-2.7.3/hadoop-2.7.3.tar.gz

# 解压安装
$sudo tar  -xzvf  /usr/local/hadoop-2.7.3.tar.gz

# 配置hadoop环境变量
vim /etc/profile
~~~
编辑如下的环境变量
~~~
#HADOOP
export HADOOP_HOME=/usr/local/hadoop-2.7.3
export PATH=$PATH:$HADOOP_HOME/bin
export PATH=$PATH:$HADOOP_HOME/sbin
export HADOOP_MAPRED_HOME=$HADOOP_HOME
export HADOOP_COMMON_HOME=$HADOOP_HOME
export HADOOP_HDFS_HOME=$HADOOP_HOME
# hadoop数据目录
export HADOOP_DATA_DIR=/mnt/hdfs
export YARN_HOME=$HADOOP_HOME
export HADOOP_COMMON_LIB_NATIVE_DIR=$HADOOP_HOME/lib/native
export HADOOP_OPTS="-Djava.library.path=$HADOOP_HOME/lib"
~~~

~~~
# 环境变量生效
$source /etc/profile

# 给予hadoop用户目录权限
$sudo chown hadoop $HADOOP_HOME
~~~
___
**建立数据存储目录**
环境变量`HADOOP_DATA_DIR=/mnt/hdfs`
~~~
sudo mkdir -p $HADOOP_DATA_DIR/namenode
sudo mkdir -p $HADOOP_DATA_DIR/datanode
sudo chown hadoop /mnt/hdfs/namenode
sudo chown hadoop /mnt/hdfs/datanode
~~~


___
**修改hadoop配置文件**
修改文件前需要备份！这就很重要了～～～
~~~
$sudo -i
$cd $HADOOP_HOME/etc/hadoop/
$cp core-site.xml core-site.xml.bak

$cp yarn-site.xml yarn-site.xml.bak

$cp hadoop-env.sh hadoop-env.sh.bak

# 特殊一点：模板文件使用，算是已经备份的了
$cp mapred-site.xml.template mapred-site.xml
~~~
- 修改$HADOOP_HOME/etc/hadoop/core-site.xml文件
在<configuration></configuration>增加hdfs的端口信息
~~~
<!-- alic HDFS的配置信息  -->
<configuration>
    <property>
        <name>fs.default.name</name>
        <value>hdfs://localhost:9000</value>
    </property>
        <!-- 设置每个节点临时文件目录 -->
        <name>hadoop.tmp.dir</name> 
        <!-- 当前用户须要对此目录有读写权限，启动集群时自动创建  -->
        <value>/home/hadoop/bigdata/data/hadoop/tmp</value> 
　　 </property> 
</configuration>
~~~

- 修改$HADOOP_HOME/etc/hadoop/yarn-site.xml文件
~~~
<!-- alic配置信息 -->
<configuration>
<!-- Site specific YARN configuration properties -->
    <property>
        <name>yarn.nodemanager.aux-services</name>
        <value>mapreduce_shuffle</value>
    </property>
    <property>
        <name>yarn.nodemanager.aux-services.mapreduce.shuffle.class</name>
        <value>org.apache.hadoop.mapred.ShuffleHandler</value>
    </property>
</configuration>
~~~

- 修改$HADOOP_HOME/etc/hadoop/mapred-site.xml
~~~
<!-- alic配置信息 -->
<configuration>
    <property>
        <name>mapreduce.framework.name</name>
        <value>yarn</value>
    </property>
<tconfiguration>
~~~

- 修改$HADOOP_HOME/etc/hadoop/hdfs-site.xml
增加DataNode和NameNode的配置 
~~~
<!-- alic配置信息 -->
<configuration>
    <property>
       <name>dfs.replication</name>
       <value>1</value>
    </property>
    <property>
        <name>dfs.namenode.name.dir</name>
        <value>file:/mnt/hdfs/namenode</value>
    </property>
    <property>
        <name>dfs.datanode.data.dir</name>
        <value>file:/mnt/hdfs/datanode</value>
    </property>
</configuration>
~~~

- 修改hadoop的环境文件hadoop-env.sh

~~~
# 将变量改成常亮即路径！！！不然会找不到JAVA_HOME
export JAVA_HOME=$JAVA_HOME //默认
export JAVA_HOME=/usr/java/jdk1.6.0_45 //应该这么改
~~~
___
**出现的问题**
ssh连接-没有host key算法
![ssh.png](http://upload-images.jianshu.io/upload_images/1678789-4f4a8aaa18406e9b.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
解决方案
~~~
$ssh-add
~~~
__
JAVA_HOME没有找到
![图片.png](http://upload-images.jianshu.io/upload_images/1678789-184db20d8972c3be.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
解决办法：
        修改/usr/local/hadoop-2.7.3/etc/hadoop/hadoop-env.sh中设JAVA_HOME。
        应当使用绝对路径。
~~~
export JAVA_HOME=$JAVA_HOME                  //默认
export JAVA_HOME=/usr/java/jdk1.6.0_45        //应该这么改
~~~
