前言：在python程序里面难免会用到shell命令，在python调用shell脚本也不是很难，记录了一下！
**通过os模块**
system方法会创建子进程运行外部程序，方法只返回外部程序的运行结果
~~~
#os-One
#只返回结果
os.system(command)
~~~
sample
~~~
import os
print os.system("service apache2 status")
~~~
___
popen方不仅仅返回结果，还返回一个类文件对象，通过调用该对象的read()或readlines()方法可以读取输出内容
~~~
#os-Two
#返回结果与终端显示信息
os.popen(command,mode)
~~~
sample
~~~
import os
output = os.popen('service apache2 status', 'r')
print output.read()
~~~
___
**通过commands模块**
使用commands模块的getoutput方法，这种方法同popend的区别在于popen返回的是一个类文件对象，而本方法将外部程序的输出结果当作字符串返回
~~~
#返回(status, output)
commands.getstatusoutput(command)      
#只返回输出结果
commands.getoutput(command)                  
#调用了getoutput，不建议使用此方法
commands.getstatus(file)
~~~
sample
~~~
import commonds
print commands.getstatusoutput("ls")
print commands.getoutput("ls")
~~~
___
**通过subprocess模块**
subprocess与system相比的优势是它更灵活
~~~
#只返回结果
subprocess.call("command", shell=True)
~~~
sample
~~~
import subprocess
print subprocess.call("service apache2 status", shell=True)
~~~

**价值源于技术，贡献源于分享**




























