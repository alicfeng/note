心情不太好，搞搞代码，提高心境！
--程序猿
___
**fabric简介**
一句话：fabric是python语言实现的一个利用ssh高效部署和管理系统的工具。
___
**fabric安装**
- pip
~~~
sudo pip install fabric
~~~
- apt-get
~~~
sudo apt-get install fabric
~~~
- 源码安装
~~~
git clone https://github.com/fabric/fabric.git
sudo python setup.py install
~~~
**简单使用**
模拟服务器的信息
host-1【运维机器】:172.17.42.1
host-2【服务器1】:172.17.0.1
host-3【服务器2】:172.17.0.2
测试的python脚本
~~~
from fabric.api import *
#主机信息 
host1="root@172.17.0.1:22"
host2="root@172.17.0.2:22"
#定义主机列表
env.hosts=[host1,host2]
env.password="fenglican"
#部署任务
def demo():
	run("uname -a")
~~~
查看任务的方法
fabric默认的文件名是fabfile.py,倘若不使用改名字，查看任务需要加入参数-f 
~~~
fab -l
~~~
执行部署任务
~~~
fab demo
~~~
___
**fabric常用命令**
~~~
fab -l #显示可执行任务
fab -H #指定host，多host以逗号隔开
fab -P #并发数，默认串行
fab -R #指定角色
fab -w #warn_only 遇到异常直接退出
fab -f #指定入口文件 
~~~
___
**fabric常用函数**
~~~
#切换本地目录
lcd()

#切换远程目录
cd()

#执行本地命令
local()

#执行远程命令
run()

#执行远程sudo
sudo()
~~~
___
**基础编辑任务**
~~~
#coding:utf-8
#python方式引用包
from fabric.api import *
import web
import db

#控制服务器的主机信息 ssh语法
host1="root@172.17.0.1:22"
host2="root@172.17.0.2:22"

#env主机列表
env.hosts=[host1,host2]
env.password="fenglican"
#假如密码不一样的话可以使用字典
#env.passwords = {
#	host1 : "fengalic"
#	host2 : "alic"
#}

#@task
def demo00():
	cd("/fengalic/") #切换不存在的目录 默认会导致整个进程终止
	run("ls -a")

#多命令 中间某个命令异常发生后进程直接退出，从而不进行下面的命令
def demo01():
	with cd("/fengalic"):
		run("ls -a")

#多命令 中间某个命令异常发生后继续进行，并不提示错误信息
def demo02():
	with settings(warn_only=True):
		cd("/fengalic/")
	run("ls -a")

#装饰器 @hosts指定host @parallel并行 @task新型任务
@hosts(host1)
def demo03():
	run("uname -a")

@parallel
def demo04():
	run("uname -a")

#角色定义
env.roledefs = {
	"web" : [host1], #多个一逗号隔开
	"db" : [host2]
}
#指定角色的任务
#@roles("web")
def demo05():
	run("uname -a")

#新型任务 类似命名空间 推荐使用 
#@task
def demo05():
	run("uname -a")
~~~
___
**LAMP环境搭建实战**
环境：ubuntu-32bit
~~~
from fabric.api import *

host1 = "alic@172.17.0.1:22"
env.hosts = [host1]
env.passwords = {
	host1 : "fenglican"
}

def install_mysql():
	sudo("apt-get install mysql-server mysql-client -y")

def install_php5():
	sudo("apt-get install php5 -y")
	sudo("apt-get install php5-mysql -y")
	sudo("apt-get install php5-gd php5-cgi -y")

def install_apache2():
	sudo("apt-get install apache2 -y")
	sudo("apt-get install libapache2-mod-auth-mysql -y")
	sudo("service apache2 restart")

@task
def install_lamp():
	install_apache2()
	install_php5()
	install_mysql()

~~~
___
**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
