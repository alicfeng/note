Message
username:reader
password:fengalic
___
- 创建只读用户
~~~
#任意IP都可以访问
GRANT Select ON *.* TO reader@"%"  IDENTIFIED BY "fengalic"
限制IP sameple 172.16.168.88
GRANT Select ON *.* TO reader@172.16.168.88  IDENTIFIED BY "fengalic"
~~~
