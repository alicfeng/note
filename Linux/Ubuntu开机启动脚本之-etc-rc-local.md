前言：简单记录一下ubuntu开机启动脚本的方法。就是修改/etc/rc.local配置文件，该方法很简单使用，但是灵活性不好，因为没有start-stop-restart-order。
___
**需求**
在开机的时候用指定的用户来启动脚本,那么可以结合rc.local文件和su命令
su命令：
~~~
su – 用户名 -c 命令
~~~
‘su’ 和 ‘su -’ 的区别是’su -’切换用户的同时也切换了环境变量，所以一般推荐使用 ‘su -’
‘-c’ 后面接要执行的命令
则以上命令实现先切换到指定用户，执行命令，再切换回原来的用户。
`rc.local文件一般为开机最后执行的。编辑/etc/rc.local文件`
___
**解决**
~~~
#!/bin/sh -e
#
# rc.local
#
# This script is executed at the end of each multiuser runlevel.
# Make sure that the script will "exit 0" on success or any other
# value on error.
#
# In order to enable or disable this script just change the execution
# bits.
#
# By default this script does nothing.

# Print the IP address
_IP=$(hostname -I) || true
if [ "$_IP" ]; then
  printf "My IP address is %s\n" "$_IP"
fi
#start gogs-server  这里是我要执行的脚本处理
su - pi -c /home/pi/server/script/gogs.sh


exit 0

~~~
