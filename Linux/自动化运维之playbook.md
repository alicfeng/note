**前言**
前段时间总结了ansible的基本配置与使用，那么说到了ansible的话呢，playbook是必不可少的，playbook在我看来就是一个花花公子-playboy！
___
**playbook的介绍**
Playbooks are a completely different way to use ansible than in adhoc task execution mode, and are particularly powerful.
顾名思义，playbooks是一个"剧本",不同于ansible的使用方式，它是按照编排的任务智能地执行，并且非常强大！
Simply put, playbooks are the basis for a really simple configuration management and multi-machine deployment system, unlike any that already exist, and one that is very well suited to deploying complex applications.
简单地来说呢，playbooks适合简单的配置管理以及多服务器机器的管理，同时还可以处理部署复杂的应用。
要是服务器不仅仅复杂，数量上还是成千上万的呢，还是推荐使用重量级又古老文明的saltstack。
[传送ansible文档详解](http://docs.ansible.com/)
[自动化运维之ansible](http://www.jianshu.com/p/d95414df5644)
___
**playbook基础语法**
playbook使用了YAML格式的语法，该语法还是相当简单的，可以体验出程序构造或执行的过程。那么还是具体查看简单的一个实例！
在docker服务器组使用root用户执行更新源命令，如下：
~~~
- hosts: docker
  remote_user: root
  gather_facts: True
  tasks:
   - name: "初始化更新源列表"
     command: apt-get update
~~~
语法注意："-"以及":"后面都需要一个空格。
语法已经主意了吧～～～该注意该注意的内容了，从上面的实例额可以看出有两个必须的属性，那就是服务器主机hosts以及远程用户remote_user，有了它们就可以干点其它事了tasks，自然而然在playbook执行任务是需要通过模块的来操控的。
使用命令检查yaml的语法
~~~
ansible-playbook main.yml --syntax-check
~~~

![Alic_yml_check](http://upload-images.jianshu.io/upload_images/1678789-4c01b03e95016de5.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
___
**playbook模块化task**
(⊙v⊙)嗯～～～模块化的理论就不一一说明了，实践通过时间来领悟理论精华。该是动手的时候了！
- command

~~~
# 在docker服务器组执行一条命令
- hosts: docker
  remote_user: root
  gather_facts: True
  tasks:
   - name: "初始化更新源列表"
     command: apt-get update
~~~
说明：name的属性就是一个任务的昵称，自定义。

- shell

~~~
# 在docker服务器组执行shell命令
- hosts: docker
  remote_user: root
  gather_facts: True
  tasks:
   - name: "删除/home/alic/demo.sh"
     shell: rm -f /home/alic/demo.sh
~~~

- script

~~~
# 在docker服务器组执行控制节点本地的shell脚本
- hosts: docker
  remote_user: root
  gather_facts: True
  tasks:
   - name: "被控节点执行控制节点的shell脚本"
     script: ../scripts/alic.sh
~~~

![Alic_demo_dir_tree](http://upload-images.jianshu.io/upload_images/1678789-98d13f411ad9690b.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

- copy 

~~~
# 将控制节点的文件上传到docker服务器【被控节点】上
- hosts: docker
  remote_user: root
  gather_facts: True
  tasks:
   - name: "控节点文件cp到被控制节点服务器"
     copy:
       src=/etc/ansible/hosts 
       dest=/etc/ansible/hosts 
       owner=root 
       group=root 
       mode=0644
~~~
注意：src代表控制节点路径，dest代表被控节点路径，其它的为可选项目，顾名思义。

- yum

~~~
# 在docker用户组以root用户安装vim编辑器
- hosts: docker
  remote_user: root
  gather_facts: True
  tasks:
   - name: "我正在在centOS安装vim呢~~~"
     yum: name=vim state=latest
~~~
说明：name为安装某某的名称，state则为安装的版本，yum该模块仅仅适合contOS相似的发行版，对于ubuntu呢，还是推荐使用原生的bash咯～～～

- service

~~~
# 在docker用户组以root用户重启apache2
- hosts: docker
  remote_user: root
  gather_facts: True
  tasks:
   - name: "我正在启动apache2服务器~~~"
     service: name=apache2 state=restarted
~~~
说明：service的状态与我们平常使用的多了-ed stsrted stoped restarted

- notify 与 handlers
使用一句英文更好地阐述两者的关系
The things listed in the notify
 section of a task are called handlers.
还是说一下中文吧～～～
notify是一个通知，实质上也是一个任务，不同的是使用handlers定义的任务，handlers里面定义的任务相当于定义方法，提高复用性！

~~~
- hosts: docker
  remote_user: root
  tasks:
    - name: "test notify"
      shell: ls
      notify: 
        - restart apache2
  handlers:
    - name: restart apache2
      service: name=apache2 state=restarted
~~~

- vars
先说明一下，很明显vars模块用户声明变量

~~~
# vars 变量的定义与使用
- hosts: docker
  remote_user: root
  vars: 
     config_path: "/root/application/sise.conf"
  tasks:
    - name: "test notify"
      command: touch {{config_path}}
~~~
然而说到变量还可以这样使用:在yml使用变量，在执行playbook命令是额外赋值，注意记得加上引号 "{{var}}"
ansible-playbook main.yml --extra-vars hosts=docker

~~~
 hosts: "{{hosts}}"
  remote_user: root
  vars: 
  - dir_name: "public"
  tasks: 
  - name: create dir
    shell: mkdir {{dir_name}}
~~~

![Alic_--extra-vars](http://upload-images.jianshu.io/upload_images/1678789-7b1e0dbe52dd851e.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

- when
(⊙o⊙)嗯～～～，when在运维时是一个重点，不同Linux的发行版呢，有些命令就不一样，但都是了解到了条件即可switch地处理。好比如yum只有centOS，RedHat等发行版才具有的包管理命令工具
重点：when主要用于处理不同的操作系统与处理逻辑上。

~~~
- hosts: docker
  remote_user: root
  tasks:
   - name: "我正在红帽子安装vim呢~~~"
     yum: name=vim state=latest
     when: ansible_os_family == "RedHat"
~~~

- with_items

~~~
# 便利迭代 + when
- hosts: docker
  remote_user: root
  tasks:
    - command: echo {{ item }}
      with_items: [ 0, 2, 4, 6, 8, 10 ]
      when: item > 5
~~~

![便利迭代 + when](http://upload-images.jianshu.io/upload_images/1678789-b6258439994c6355.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
___
**Tips and Tricks For Ansible-book Command**
1 查看任务所指定的host列表
~~~
$ ansible-playbook main.yml --list-hosts
~~~
![Alic-查看任务所指定的host列表](http://upload-images.jianshu.io/upload_images/1678789-63655a714e4e29be.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

2 If you need to specify a password to sudo, run ansible-playbook
 with `--ask-pass`
 or when using the old sudo syntax `--ask-sudo-pass`
即当你使用普通用户执行命令需要输入密码时可使用
~~~
$ ansible-playbook main.ym --ask-sudo-pass --ask-pass
~~~

![Alic_密码交互](http://upload-images.jianshu.io/upload_images/1678789-cd4218d7d981bc01.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

3 获取docker server-group主机的所有基本信息
既然可以获取主机信息 当时用when的时候，该命令就其很大作用了！
~~~
$ ansible docker -m setup
~~~

![Alic_还有很多message没有截取](http://upload-images.jianshu.io/upload_images/1678789-ad18759637248ce6.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

4 直接通过ansible-playbook命令来指定主机
~~~
$ ansible-playbook playbook.yml --limit docker
~~~
嘿嘿～～～这个野蛮好的( ⊙o⊙ )哇，有时候我想在某台服务器搭建nginx的话，task只写好模板，需要的服务器就在执行命令指定host或服务器组即可！

**Demo实践目录树**

![Demo实践目录树](http://upload-images.jianshu.io/upload_images/1678789-3fb88a9d5fef52fd.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
___
[自动化运维之ansible](http://www.jianshu.com/p/d95414df5644)
___
**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
