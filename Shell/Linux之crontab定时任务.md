**前言**
无论是做开发还是做运维的程序猿，crontab命令是必须用到的命令，特别是对于运维的人，自动化运维中，crontab也属于其一。然而就来记录常用的crontab定时处理命令。
___
**crontab简介**
简而言之呢，crontab就是一个自定义定时器。
___
**crontab配置文件**
- 其一：`/var/spool/cron/`
 该目录下存放的是每个用户（包括root）的crontab任务，文件名以用户名命名
- 其二：`/etc/cron.d/ `
这个目录用来存放任何要执行的crontab文件或脚本。
___
**crontab时间说明**
~~~
# .---------------- minute (0 - 59) 
# |  .------------- hour (0 - 23)
# |  |  .---------- day of month (1 - 31)
# |  |  |  .------- month (1 - 12) OR jan,feb,mar,apr ... 
# |  |  |  |  .---- day of week (0 - 6) (Sunday=0 or 7)  OR
#sun,mon,tue,wed,thu,fri,sat 
# |  |  |  |  |
# *  *  *  *  *  command to be executed
~~~
minute：代表一小时内的第几分，范围 0-59。
hour：代表一天中的第几小时，范围 0-23。
mday：代表一个月中的第几天，范围 1-31。
month：代表一年中第几个月，范围 1-12。
wday：代表星期几，范围 0-7 (0及7都是星期天)。
who：要使用什么身份执行该指令，当您使用 crontab -e 时，不必加此字段。
command：所要执行的指令。
___
**crontab服务状态**
~~~
sudo service crond start     #启动服务
sudo service crond stop      #关闭服务
sudo service crond restart   #重启服务
sudo service crond reload    #重新载入配置
sudo service crond status    #查看服务状态
~~~
___
**crontab命令**
重新指定crontab定时任务列表文件
```shell
crontab $filepath
```
查看crontab定时任务
~~~
crontab -l
~~~
编辑定时任务【删除-添加-修改】
~~~
crontab -e
~~~
***添加定时任务【推荐】***
Step-One : 编辑任务脚本【分目录存放】【ex: backup.sh】
Step-Two : 编辑定时文件【命名规则:backup.cron】
Step-Three : crontab命令添加到系统`crontab backup.cron `
Step-Four : 查看crontab列表 `crontab -l`
___
**crontab时间举例**
~~~
# 每天早上6点 
0 6 * * * echo "Good morning." >> /tmp/test.txt //注意单纯echo，从屏幕上看不到任何输出，因为cron把任何输出都email到root的信箱了。

# 每两个小时 
0 */2 * * * echo "Have a break now." >> /tmp/test.txt  

# 晚上11点到早上8点之间每两个小时和早上八点 
0 23-7/2，8 * * * echo "Have a good dream" >> /tmp/test.txt

# 每个月的4号和每个礼拜的礼拜一到礼拜三的早上11点 
0 11 4 * 1-3 command line

# 1月1日早上4点 
0 4 1 1 * command line SHELL=/bin/bash PATH=/sbin:/bin:/usr/sbin:/usr/bin MAILTO=root //如果出现错误，或者有数据输出，数据作为邮件发给这个帐号 HOME=/ 

# 每小时（第一分钟）执行/etc/cron.hourly内的脚本
01 * * * * root run-parts /etc/cron.hourly

# 每天（凌晨4：02）执行/etc/cron.daily内的脚本
02 4 * * * root run-parts /etc/cron.daily 

# 每星期（周日凌晨4：22）执行/etc/cron.weekly内的脚本
22 4 * * 0 root run-parts /etc/cron.weekly 

# 每月（1号凌晨4：42）去执行/etc/cron.monthly内的脚本 
42 4 1 * * root run-parts /etc/cron.monthly 

# 注意:  "run-parts"这个参数了，如果去掉这个参数的话，后面就可以写要运行的某个脚本名，而不是文件夹名。 　 

# 每天的下午4点、5点、6点的5 min、15 min、25 min、35 min、45 min、55 min时执行命令。 
5，15，25，35，45，55 16，17，18 * * * command

# 每周一，三，五的下午3：00系统进入维护状态，重新启动系统。
00 15 * *1，3，5 shutdown -r +5

# 每小时的10分，40分执行用户目录下的innd/bbslin这个指令： 
10，40 * * * * innd/bbslink 

# 每小时的1分执行用户目录下的bin/account这个指令： 
1 * * * * bin/account

# 每天早晨三点二十分执行用户目录下如下所示的两个指令（每个指令以;分隔）： 
203 * * * （/bin/rm -f expire.ls logins.bad;bin/expire$#@62;expire.1st）　
~~~
___
Linux运维基础且常用命令
[Linux之crontab定时任务](http://www.jianshu.com/p/838db0269fd0)
[Linux之sed文本处理命令](http://www.jianshu.com/p/8269c36331ee)
[Linux之ps进程查看命令](http://www.jianshu.com/p/367276be1469)
[Linux之expect交互语言命令](http://www.jianshu.com/p/59f2e14e2535)
[Linux之tail命令](http://www.jianshu.com/p/168e8a01c2e2)
___
**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
