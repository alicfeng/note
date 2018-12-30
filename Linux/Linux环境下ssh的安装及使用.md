前言：SSH（全称 Secure Shell)是一种加密的网络协议。使用该协议的数据将被加密，即使在传输中间数据泄漏，也可以确保没有人能读取出有用信息。SSH 是基于客户-服务模式的。 当你想安全的远程连接到主机，可中间的网络（比如因特网）并不安全，通常这种情况下就会使用 SSH。
___
**安装ssh客户端**
```
sudo apt-get install ssh
```
或者
```
sudo apt-get install openssh-client    #推荐
```
**安装ssh服务端**
 ```
sudo apt-get install openssh-server
```
**改变ssh服务器端的状态**
```
sudo service ssh start    #开启
```
```
sudo service ssh stop     #停止
```
```
sudo service ssh restart    #重启
```
**SSH连接常用命令**
```
ssh 172.16.168.111    #无参数运行ssh
```
```
ssh alic@172.16.168.111    #指定用户
```
```
ssh alic@172.16.168.111 -p 22    #指定端口
```
```
ssh -i privateKey.file alic@172.16.168.111     #引用秘钥文件
```
**修改sshd_config配置文件**
```
sudo nano /etc/ssh/sshd_config
```
**SSH基础设置** 

---
* Port 22
  端口设置：SSH 预设使用 22 这个 port，您也可以使用多的 port 
---
* Protocol 2,1
 版本设置：选择的 SSH 协议版本，可以是 1 也可以是 2
---
* ListenAddress 0.0.0.0
监听的主机适配卡设置：默认为任何回环地址，ListenAddress:192.168.0.100 
------
* PrintMotd no             
登入后是否显示出一些信息呢？例如上次登入的时间、地点等，预设是 yes ，但是，如果为了安全，可以考虑改为 no ！
---
* PrintLastLog yes　　　　　
显示上次登入的信息！可以啊！预设也是 yes ！
---
* KeepAlive yes　　　　　　 
 一般而言，如果设定这项目的话，那么 SSH Server 会传送KeepAlive 的讯息给 Client 端，以确保两者的联机正常！在这个情况下，任何一端死掉后， SSH 可以立刻知道！而不会有僵尸程序的发生！
---
* UsePrivilegeSeparation yes 
使用者的权限设定项目,就设定为 yes
---
* MaxStartups 10　　　　　　
同时允许几个尚未登入的联机画面？当我们连上 SSH ,但是尚未输入密码时，这个时候就是我们所谓的联机画面啦！在这个联机画面中，为了保护主机，所以需要设定最大值，预设最多十个联机画面，而已经建立联机的不计算在这十个当中
---
* PidFile /var/run/sshd.pid
可以放置 SSHD 这个 PID 的档案！左列为默认值
---
* LoginGraceTime 600
当使用者连上 SSH server 之后，会出现输入密码的画面,在该画面中，在多久时间内没有成功连上 SSH server ,时间为秒！
---
* Compression yes
是否允许使用压缩指令
---
* HostKey /etc/ssh/ssh_host_key　　　　
SSH version 1 使用的私钥
---
* HostKey /etc/ssh/ssh_host_rsa_key　　
SSH version 2 使用的 RSA 私钥
---
* HostKey /etc/ssh/ssh_host_dsa_key　　
SSH version 2 使用的 DSA 私钥
---
* KeyRegenerationInterval 3600　 　　　
由前面联机的说明可以知道， version 1 会使用
---
* PermitRootLogin no　　 　　
是否允许 root 登入！预设是允许的，但是建议设定成 no！
---
* UserLogin no　　　　　　　 
在 SSH 底下本来就不接受 login 这个程序的登入！
---
* StrictModes yes
当使用者的 host key 改变之后，Server 就不接受联机，　　　　　　　　　　　　　 
可以抵挡部分的木马程序！
---
* RSAAuthentication yes　　
 是否使用纯的 RSA 认证！仅针对 version 1 
---
* PubkeyAuthentication yes　
 是否允许 Public Key ？当然允许啦！只有 version 2
---
* AuthorizedKeysFile      .ssh/authorized_keys　　　　　　　　　　　　　
上面这个在设定若要使用不需要密码登入的账号时，那么那个　　　　　　　　　　　　　 
账号的存放档案所在档名！
---
**SSH认证部分**

---
* RhostsAuthentication no
本机系统不止使用 .rhosts ，因为仅使用 .rhosts 太　　　　　　　　　　　　　
 不安全了，所以这里一定要设定为 no ！
---
* IgnoreRhosts yes　　　　　 
是否取消使用 ~/.ssh/.rhosts 来做为认证！当然是！
---
* RhostsRSAAuthentication no 
这个选项是专门给 version 1 用的，使用 rhosts 档案在　　　　　　　　　　　　　 
/etc/hosts.equiv配合 RSA 演算方式来进行认证！不要使用
---
* HostbasedAuthentication no 
这个项目与上面的项目类似，不过是给 version 2 使用的！
---
* IgnoreUserKnownHosts no　　
是否忽略家目录内的 ~/.ssh/known_hosts 这个档案所记录　　　　　　　　　　　　　
的主机内容？当然不要忽略，所以这里就是 no 啦！
---
* PasswordAuthentication yes
 密码验证当然是需要的！所以这里写 yes 啰！
---
* PermitEmptyPasswords no　　
若上面那一项如果设定为 yes 的话，这一项就最好设定　　　　　　　　　　　　　
 为 no ，这个项目在是否允许以空的密码登入！当然不许！
---
* ChallengeResponseAuthentication yes  
挑战任何的密码认证！所以，任何 login.conf 　　　　　　　　　　　　　　　　　　
规定的认证方式，均可适用！
---
* PAMAuthenticationViaKbdInt yes      
是否启用其它的 PAM 模块！启用这个模块将会　　　　　　　　　　　　　　　　　　 
导致 PasswordAuthentication 设定失效！　
---
**关于使用者抵挡的设定项目**
* DenyUsers *　　　　　　　 
设定受抵挡的使用者名称，如果是全部的使用者，那就是全部挡吧！若是部分使用者，可以将该账号填入！例如下列！
---
* DenyUsers testDenyGroups test　　　　　
与 DenyUsers 相同！仅抵挡几个群组而已！
---
