**Linux下安装和配置JDK**

- Step-one:到oracle官网下载JDK
[传送门](http://www.oracle.com/technetwork/java/javase/downloads/index.html)

- Step-two:安装JDK，即解压
```
sudo tar -zxvf jdk-8u51-linux-i586.gz.tar
```

- Step-three:配置JDK环境变量

>打开profile配置文件，添加jdk配置信息

`sudo vi /etc/profile`

在文件的末尾添加如下代码
```

export JAVA_HOME=/usr/java/jdk1.8.0_51

export JAVA_BIN=/usr/java/jdk1.8.0_51/bin

export PATH=$PATH:$JAVA_HOME/bin
```
___

**Windows下安装和配置JDK**

- Step-one:到oracle官网下载JDK

- Step-two:傻傻瓜式安装

Double click exeFile

- Step-three:打开配置环境变量
右键“我的电脑” -> “属性” -> "高级系统变量" -> "环境变量"

- Step-four:新建jdk变量 如下

```
JAVA_HOME C:\Program Files\Java\jdk1.8.0_51  #注意：是jdk而不是jre

Path ;%JAVA_HOME%\bin;%JAVA_HOME%\jre\bin

CLASSPATH .;%JAVA_HOME%\lib;%JAVA_HOME%\lib\tools.jar #注意前面的一个点
```

- Step-five:测试配置是否成功
在cmd终端运行如下命令
java -version  --查看jdk版本
javac          --查看编译能否成功
java            --查看jdk是否安装成功
