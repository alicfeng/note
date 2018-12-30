# sshAutoLogin

**It can make your ssh login simply as well as efficiently on Mac or Linux.**

we are frequently using ssh login remote server by terminal. We will find a headache that is often entering a repetitive command line. Fuck~ it’s a waste of time!Maybe you cloud write configure of alias on profile. enenen~ Finally, I determined to write a time-saving shell.Beginning with university stage.


___

它有什么特点或好处呢
- 扩展性、配置化
- 自动交互登录
- 支持密码以及秘钥文件
- 支持Mac以及Linux
- 时间是生命呐

___

- **使用**

> 查看帮助信息

~~~shell
➜  ~ ssha -h
usege:
ssha [-h] [-l] [-s <server alias>]
~~~

> 查看配置的服务器信息列表

~~~shell
➜  ~ ssha -l
Index	Description		Port	Host		Username	Password|SecretKeyFile
┌────────────────────────────────────────────────────────────────────────┐
│0       alicfengPC              127.0.0.1       22      alic    pwdalic │
└────────────────────────────────────────────────────────────────────────┘
┌────────────────────────────────────────────────────────────────────────────────┐
│1       us.samego.com           47.68.88.88     22      alic    u.know.pwd      │
└────────────────────────────────────────────────────────────────────────────────┘
┌────────────────────────────────────────────────────────────────────────────────┐
│2       hk.samego.com           120.88.88.86    22      alic    u.know.pwd      │
└────────────────────────────────────────────────────────────────────────────────┘
┌────────────────────────────────────────────────────────────────────────────────────────────────────────┐
│3       vpn.samego.com          68.120.80.86    22      alic    /home/alic/.ssha/key/vpn.samego.com.key │
└────────────────────────────────────────────────────────────────────────────────────────────────────────┘
~~~

> 快捷登录

~~~
➜  ~ ssha -s 0
┌────────────────────────────────────────┐
│alic logging into the alicfengPC  server│
└────────────────────────────────────────┘
spawn ssh -p 22 alic@127.0.0.1
alic@127.0.0.1's password: 
Welcome to elementary OS 0.4.1 Loki (GNU/Linux 4.13.0-32-generic x86_64)

Last login: Sat Aug 11 16:44:46 2018 from 127.0.0.1
➜  ~ 
successfully logined 【alicfengPC】
➜  ~ 
~~~

___

- **安装**
> Mac系统
~~~shell
➜  ~ curl -sSL https://raw.githubusercontent.com/alicfeng/sshAutoLogin/master/iMac.sh | bash
~~~

> Debian系列
~~~shell
➜  ~ curl -sSL https://raw.githubusercontent.com/alicfeng/sshAutoLogin/master/iDebian.sh | bash
~~~

> Redhats系列
~~~shell
➜  ~ curl -sSL https://raw.githubusercontent.com/alicfeng/sshAutoLogin/master/Redhats.sh | bash
~~~

___

- **配置说明**
> 每一个单元配置长什么样呢？
~~~ini
Index=0
Name=hostname
Host=IP | domain
Port=22
User=alic
PasswordOrKey=password
~~~

> 默认的配置目录路径
~~~shell
~/.ssha/
~~~

> 你看看我的示例目录Tree
~~~shell
➜  .ssha tree
.
├── 0_localhost.ini
├── 1_47.68.88.88.conf
├── 2_120.88.68.86.ini
└── 3_68.120.80.68.ini

0 directories, 4 files
~~~

___
[sshAutoLogin Github](https://github.com/alicfeng/sshAutoLogin) 
