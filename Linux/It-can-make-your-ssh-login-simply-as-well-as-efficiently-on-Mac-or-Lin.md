**[It can make your ssh login simply as well as efficiently on Mac or LInux.](https://github.com/alicfeng/sshAutoLogin)**
[点我翻译](https://github.com/alicfeng/sshAutoLogin/blob/master/README_ZH.md) 
On Mac or Linux system, we are frequently using ssh login remote server by terminal. We will find a headache that is 
 often entering a repetitive command line. Fuck~ it’s a waste of time!Maybe you cloud write configure of alias on profile. enenen~  Finally, I determined to write a time-saving shell.Beginning with university stage.
___

ssha Tool Characteristics
- Scalability configuration
- Automatic interaction login
- Support password and SecretKeyFile method
- Support Mac and Linux
- Saving time

___
- **Easy to use**
> help info
~~~shell
➜  ~ ssha -h
usege:
ssha [-h] [-l] [-s <server alias>]
~~~

> see server list
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

> login sameone server
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
- **Simply to install**
> For Mac System
~~~shell
➜  ~ curl -sSL https://raw.githubusercontent.com/alicfeng/sshAutoLogin/master/iMac.sh | bash
~~~

> For Debian
~~~shell
➜  ~ curl -sSL https://raw.githubusercontent.com/alicfeng/sshAutoLogin/master/iDebian.sh | bash
~~~

> For Redhats
~~~shell
➜  ~ curl -sSL https://raw.githubusercontent.com/alicfeng/sshAutoLogin/master/Redhats.sh | bash
~~~

- **Scalability configuration**
> example server info configure file
~~~ini
Index=0
Name=hostname
Host=IP | domain
Port=22
User=alic
PasswordOrKey=password
~~~

> default configure dir
~~~shell
~/.ssha/
~~~

> configure dir tree
~~~shell
➜  .ssha tree
.
├── 0_localhost.ini
├── 1_47.68.88.88.conf
├── 2_120.88.68.86.ini
└── 3_68.120.80.68.ini

0 directories, 4 files
~~~


~~~shell                                                                                                                                                    
 ▄▄▄▄▄▄▄▄               ██                                                       ▄▄                            ▄▄▄▄▄▄▄▄                      ▄▄▄▄     
 ██▀▀▀▀▀▀               ▀▀                                                       ██                            ▀▀▀██▀▀▀                      ▀▀██     
 ██        ██▄████▄   ████      ▄████▄   ▀██  ███            ▄▄█████▄  ▄▄█████▄  ██▄████▄   ▄█████▄               ██      ▄████▄    ▄████▄     ██     
 ███████   ██▀   ██     ██     ██▀  ▀██   ██▄ ██             ██▄▄▄▄ ▀  ██▄▄▄▄ ▀  ██▀   ██   ▀ ▄▄▄██               ██     ██▀  ▀██  ██▀  ▀██    ██     
 ██        ██    ██     ██     ██    ██    ████▀              ▀▀▀▀██▄   ▀▀▀▀██▄  ██    ██  ▄██▀▀▀██               ██     ██    ██  ██    ██    ██     
 ██▄▄▄▄▄▄  ██    ██     ██     ▀██▄▄██▀     ███              █▄▄▄▄▄██  █▄▄▄▄▄██  ██    ██  ██▄▄▄███               ██     ▀██▄▄██▀  ▀██▄▄██▀    ██▄▄▄  
 ▀▀▀▀▀▀▀▀  ▀▀    ▀▀     ██       ▀▀▀▀       ██                ▀▀▀▀▀▀    ▀▀▀▀▀▀   ▀▀    ▀▀   ▀▀▀▀ ▀▀               ▀▀       ▀▀▀▀      ▀▀▀▀       ▀▀▀▀  
                     ████▀                ███                                                                                                         
                                                                                                                                                      
~~~
___
AlicFeng say : **[价值源于技术，贡献源于分享](https://github.com/alicfeng/sshAutoLogin)**
