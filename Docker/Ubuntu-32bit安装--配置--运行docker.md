前言：由于官方的docker只支持64位系统，然而我的电脑还是32位的，正因为如此，被它搞得不要不要的，今天终于安心腾出时间来折腾折腾，已经成功运行docker！
___
**Step-One：安装Docker**
安装Docker的很简单，只需要一条命令搞掂
~~~
$sudo apt-get install docker.io
~~~
**Step-Two：配置docker-32位镜像container**
docker内置了一个holle-word镜像来测试运行，那么我们就来测测吧~~
执行`docker run hello-world`命令
~~~
$ sudo docker run hello-world
~~~
然而你会发现，如下的错误信息，很明显看出来就是执行格式出错！当然会出错了，我的系统是32位的，pull下来的镜像当然也是32位的了，不过始终有办法就此解决的，将安装的docker改成32即可，如何修改呢？看吧~~
~~~
alic@alic-ThinkPad-X201:~$ sudo docker run hello-world
Unable to find image 'hello-world:latest' locally
latest: Pulling from hello-world
f9d83caeda74: Pull complete 
2cc48731dfff: Pull complete 
Digest: sha256:ff215bfe287b986dba232bc82892d636b0e1b1c1ae42f779202caced61f6376b
Status: Downloaded newer image for hello-world:latest
exec format error
FATA[0012] Error response from daemon: Cannot start container 62a851ea54f72bb43d35727652b262e23ca9bc80fe28d8607f31a6883d9db076: [8] System error: exec format error 
~~~
解决方案如下
- 找一个32位的Ubuntu镜像，下载[ubuntu-14.04-x86-minimal.tar.gz](http://download.openvz.org/template/precreated/ubuntu-14.04-x86-minimal.tar.gz) 

- 下载完成后输入如下命令即可：
~~~
sudo cat ubuntu-14.04-x86-minimal.tar.gz | docker import - ubuntu:14.04
~~~
此时，会弹出如下的错误提示：
~~~
alic@alic-ThinkPad-X201:~/Alic$ cat ubuntu-14.04-x86-minimal.tar.gz | docker import - ubuntu:14.04
FATA[0000] Post http:///var/run/docker.sock/v1.18/images/create?fromSrc=-&repo=ubuntu%3A14.04: dial unix /var/run/docker.sock: permission denied. Are you trying to connect to a TLS-enabled daemon without TLS? 
~~~
为什么呢？还是权限问题，解决此问题的的一种办法将一举两得，为什么呢？每次执行 docker 都需要运行 sudo 命令，非常浪费时间影响效率。如果不跟 sudo免 sudo 使用 docker如果还没有 docker group 就添加一个：
~~~
$sudo groupadd docker
~~~
将用户加入该 group 内。然后退出并重新登录就生效啦。
~~~
sudo gpasswd -a ${USER} docker
~~~
重启 docker 服务
~~~
$sudo service docker restart
~~~
切换当前会话到新 group
~~~
$newgrp - docker
~~~
~~~
$ sudo ls -l /var/run/docker.sock
~~~
注意，最后一步是必须的，否则因为 groups命令获取到的是缓存的组信息，刚添加的组信息未能生效，所以 docker images执行时同样有错。

 原因分析：因为 /var/run/docker.sock所属 docker 组具有 setuid 权限

- 然而在此重新执行下载完成的命令
~~~
 cat ubuntu-14.04-x86-minimal.tar.gz | docker import - ubuntu:14.04
~~~
执行的效果如下所示：
~~~
alic@alic-ThinkPad-X201:~/Alic$ cat ubuntu-14.04-x86-minimal.tar.gz | docker import - ubuntu:14.04
58bc351ef195f78e2e95778c26000a4d24e1d7966d9bf9c359b5732ab7fd878c
~~~

___
