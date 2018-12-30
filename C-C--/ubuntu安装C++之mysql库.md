**前言：**
恩恩～～，mysql既是独立的又是相互的，后者换句话说呢就是：其它某些语言是可以操作mysql的，只不过需要一些桥梁，比如驱动包等等。当然想使用C++来操作MySQL数据库的话也比例外，需要依赖mysql.h的C++头文件，ubuntu默认是没有自带的，需要我们自行安装，废话就不多说了，来-看NEXT！
___

**安装方法**
~~~
$sudo apt-get install libmysqlclient-dev
~~~
**使用方法**
~~~
#include <mysql/mysql.h>
~~~

___
**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
