**导出容器-export container**
~~~
#首先列举docker有哪些容器
$sudo docker ps -a
#打包容器
$sudo docker export container_id > /home/alic/ubuntu-purge.tar.gz
~~~
___

**导入容器-import container**
已文件的方式导入
~~~
#导入镜像
$cat /home/alic/ubuntu.tar.gz | sudo docker import - ubuntu:14.04
#查看
$sudo docker ps -a
~~~
以http的方式导入
~~~
$sudo docker import http://example.com/example.tgz example/imagere:demo
~~~

___
**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
