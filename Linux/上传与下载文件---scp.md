上传：
~~~
scp /path/file  User@host:/LocalPathorFile
~~~

下载：
~~~
scp User@host:/path/file  /LocalPathorFile
~~~
___
**用scp的时候遇到的问题：**
Permission denied
lost connection
原因就是在搭建服务器的时候为了安全性起见，默认已经关闭了scp
**解决办法：**
登陆服务器后 /etc/ssh/ssh_config 中的一个参数改一下：
PasswordAuthentication 将no改为yes
or
PasswordAuthentication前面的#删掉 step
sudo vi /etc/ssh/sshssh_config
