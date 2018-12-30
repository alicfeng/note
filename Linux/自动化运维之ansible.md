**前言**
O(∩_∩)O一笑而过～～～
___
**ansible介绍**
ansible是最近两年比较热门的一款服务器自动化运维工具，基于python语言来研发的，目前来说还是有很多类似的工具，比如ansible、puppet、cfengine、chef、func、fabric，其中ansible以及fabric还是挺推荐的，ansible集合了许多其它运维工具的优点，比如：批量系统配置、批量程序部署、批量运行命令。它有许多模块组成，简单来说呢，ansib是依赖程序模块并驱动模块工作的一个运维框架！
___
**ansible组件**
- ansible core
核心模块
- host inventory
主机库，需要管理的的主机列表
- connection plugins
连接插件
- modules
core modules(自带模块)
custom modules(自定义模块)
- plugins
为ansible扩展功能组件
- playbook
剧本，按照所设定编排的顺序执行完成安排的任务

___

**ansible的特点**
- 无客户端 轻量级
- 无服务端 轻量级
- 直接执行命令
- 基于模块工作，可配合playbook工作
- 基于ssh连接
- 由python研发
- 支持sudo
___
**注意事项**
主控端Python版本需要2.6或以上
被控端Python版本小于2.4需要安装python-simplejson
被控端如开启SELinux需要安装libselinux-python
windows不能做为主控端
___
**ansible安装**
~~~
# apt-get安装
apt-get install ansible

# pip安装
pip install ansible

#如果提示'module' object has no attribute 'HAVE_DECL_MPZ_POWM_SEC'
pip install pycrypto-on-pypi
~~~
___
**配置文件路径**
~~~
# 主机配置文件
/etc/ansible/hosts

# ansible配置文件
/etc/ansible/ansible.cfg
~~~
![Alic的个性](http://upload-images.jianshu.io/upload_images/1678789-b70f9ac516acd4f2.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
___
ansible.cfg的基本配置
~~~
[defaults]
# 基础配置项
hostfile       = /etc/ansible/hosts
library        = /usr/share/ansible
remote_tmp     = $HOME/.ansible/tmp
pattern        = *
forks          = 5
poll_interval  = 15
sudo_user      = root
#ask_sudo_pass = True
#ask_pass      = True
transport      = smart
remote_port    = 22

# 角色配置路径
#roles_path    = /etc/ansible/roles

[ssh_connection]
ssh_args = ""
# ssh秘钥文件
control_path = ./ssh_keys
 (default is sftp)
# 基于ssh连接
scp_if_ssh = True

[accelerate]
accelerate_port = 5099
accelerate_timeout = 30
accelerate_connect_timeout = 5.0
~~~
hosts的主机清单列表
~~~
# docker服务器主机组
[docker]
172.17.0.1  ansible_ssh_user=root ansible_ssh_pass=fenglican
~~~
___

**一言不合就动手吧~~~***
既然配置好了那就测试控制端与被控端的通讯状态～～～
~~~
root@alic-ThinkPad-X201:~# ansible docker -m ping
172.17.0.1 | success >> {
    "changed": false, 
    "ping": "pong"
}
~~~
在被控端执行命令
~~~
# 在docker服务器组安装vim
root@alic-ThinkPad-X201:~# ansible docker -a "apt-get install vim"
172.17.0.1 | success | rc=0 >>
Reading package lists...
Building dependency tree...
Reading state information...
vim is already the newest version.
0 upgraded, 0 newly installed, 0 to remove and 72 not upgraded.
~~~

将控制端的文件cp到被控端
~~~
root@alic-ThinkPad-X201:/etc/ansible# ansible docker -m copy -a "src=./hosts dest=/root/Alic/"
172.17.0.1 | success >> {
    "changed": false, 
    "dest": "/root/Alic/hosts", 
    "gid": 0, 
    "group": "root", 
    "md5sum": "e36c4ce85f9815ae010ca8d86d1afa0d", 
    "mode": "0644", 
    "owner": "root", 
    "path": "/root/Alic/hosts", 
    "size": 252, 
    "state": "file", 
    "uid": 0
}

~~~
在被控端执行控制端的脚本
~~~
root@alic-ThinkPad-X201:/etc/ansible# ansible docker -m script -a "Alic/demo.sh"
172.17.0.1 | success >> {
    "changed": true, 
    "rc": 0, 
    "stderr": "", 
    "stdout": "hello~~~\r\n"
}
~~~
___
使用ansible运维工具必不能少了**playbook**的。
[来来来-传送-自动化运维之playbook](http://www.jianshu.com/p/07bd3a336a26)
___
**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
