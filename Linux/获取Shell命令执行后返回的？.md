前言：有时候写shell命令脚本是总是需要分析此命令返回的结果，数字 字符串等等，从而进行分析，然而shell有一种很简洁的方法，看！
方案如下：

**字符串前后加符号`（在tab键上方）就会将里面的字符串当命令来执行**
___

~~~
#!/bin/bash
#sample
result=`sudo service apache2 restart`
echo $result
~~~
___

实用！推荐！

___
附加：
获取字符串长度
~~~
#!/bin/bash
#sample
result=`012345678`
echo $result  | wc -c
~~~
result:
`9`
___

**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
