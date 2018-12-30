**what  is docker compose**
as for me ~
Docker Compose 是一个为了定义和运行多容器Docker应用管理工具。对于Compose，你可以用Compose file (docker-compose.yml)来配置与管理你的docker应用，然后通过这个Compose file使用一个简单的命令来创建并启动所有的服务!
before
之前在32-os玩docker，常使用docker run -it ...(commit每次要保存一下)觉得挺麻烦的~
___

**how to install docker compose**
前提：
OS已经安装了docker
- 方法一：

~~~
#root user
$ sudo -i
#curl
$ curl -L https://github.com/docker/compose/releases/download/1.3.1/docker-compose-`uname -s`-`uname -m` > /usr/local/bin/docker-compose
#chmod
$ chmod a+x /usr/local/bin/docker-compose

#卸载
#$ rm /usr/local/bin/docker-compose
~~~

- 方法二【个人推荐】

~~~
# pip install 很便利很新
$ sudo pip install -U docker-compose

#卸载
#$ pip uninstall docker-compose
~~~
没有安装python包管理工具的可以参考[Linux安装mysql-python](http://www.jianshu.com/p/df610a488a19)里面有详细说明。

测试安装
~~~
➜  ~ docker-compose --version
docker-compose version 1.8.1, build 878cff1
➜  ~ 
~~~

___

**simple compose file(yml)**
简单的一个dokcer-compose.yml文件
~~~
version: '2'
services:
  bbs:
    container_name: bbs
    image: abiosoft/caddy:php
    volumes:
      - "/home/alic/www/caddy/:/srv/"
    ports:
      - "2015:2015"
    restart: always
~~~
container_name -> 容器的名称
image -> 镜像
volumes -> 挂载
ports -> 端口映射 【宿主:容器】


___



**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
