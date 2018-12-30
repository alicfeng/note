>2017-07-23
>
>学习C++动态库的基本知识
>
>网络总结知识点

___



- **动态库的概念**

  ​	日常编程中，常有一些函数不需要进行编译或者可以在多个文件中使用（如数据库输入/输出操作或屏幕控制等标准任务函数）。可以事先对这些函数进行编译，然后将它们放置在一些特殊的目标代码文件中，这些目标代码文件就称为库。库文件中的函数可以通过连接程序与应用程序进行链接，这样就不必在每次开发程序时都对这些通用的函数进行编译了。

​      动态库是一种在已经编译完毕的程序开始启动运行时，才被加载来调用其中函数的库。其加载方式与静态库截然不同。

___



- **动态库的命名**

  ​	Linux下，动态库通常以.so(shareobject)结尾。(通常/lib和/usr/lib等目录下存在大量系统提供的以.so结尾的动态库文件)

  ​	Windows下，动态库常以.dll结尾。(通常C:\windows\System32等目录下存在大量系统提供的以.dll结尾的动态库文件)

___



- **动态库和静态库的区别**

  ​	静态库是指编译连接时，把库文件的代码全部加入到可执行文件中，所以生成的文件较大，但运行时，就不再需要库文件了。即，程序与静态库编译链接后，即使删除静态库文件，程序也可正常执行。

  ​	动态库正好相反，在编译链接时，没有把库文件的代码加入到可执行文件中，所以生成的文件较小，但运行时，仍需要加载库文件。即，程序只在执行启动时才加载动态库，如果删除动态库文件，程序将会因为无法读取动态库而产生异常。

___



- **动态库的编译**

  下面我们来举一个栗子：

  > 三个文件生成一个`libdemo.so`库文件
  >
  > `so_demo.h`、`demo_say.cpp`、`demo_print.cpp`

  `so_demo.h`源码

  ```c++
  #include <iostream>
  using namespace std;
  void sayHello();
  void printInfo();
  ```

  `demo_say.cpp`源码

  ```c++
  #include "so_demo.h"
  void sayHello(){
  	cout<<"hello AlicFeng"<<endl;
  }
  ```

  `demo_print.cpp`源码

  ```c++
  #include "so_demo.h"
  void printInfo(){
  	cout<<"this is message"<<endl;
  }
  ```

  通过`g++`命令编译生成`libdemo.so`动态库文件

  ```shell
  ➜  g++ demo_say.cpp demo_print.cpp -fPIC -shared -o libdemo.so
  # 查看一下文件，如意生成一个libdemo.so文件
  ➜  ls
  demo_print.cpp  demo_say.cpp  so_demo.h  test.cpp
  ```

___

- **动态库的使用**

  我们编写一个C++程序来使用刚刚生成的动态库文件

  `test.cpp`源码

  ```c++
  #include "so_demo.h"
  int main(){
  	sayHello();
  	printInfo();
  	return 0;
  }
  ```

  编译`test.cpp`源码

  ```shell
  # 先将生成的libdemo.so文件放进系统默认的依赖库目录中
  ➜  sudo cp libdemo.so /usr/lib

  # 编译
  ➜  g++ test.cpp -L/usr/lib -ldemo -o test

  # 使用 it is okay
  ➜  ./test
  hello AlicFeng
  this is message
  ```

___

- **编译参数解析

  `-shared` :该选项指定生成动态连接库（让连接器生成T类型的导出符号表，有时候也生成弱连接W类型的导出符号），不用该标志外部程序无法连接。相当于一个可执行文件

  `-fPIC`：表示编译为位置独立的代码，不用此选项的话编译后的代码是位置相关的所以动态载入时是通过代码拷贝的方式来满足不同进程的需要，而不能达到真正代码段共享的目的。

  `-L.`：表示要连接的库在当前目录中

  `-ltest`：编译器查找动态连接库时有隐含的命名规则，即在给出的名字前面加上lib，后面加上.so来确定库的名称

  `LD_LIBRARY_PATH`：这个环境变量指示动态连接器可以装载动态库的路径。

  当然如果有root权限的话，可以修改/etc/ld.so.conf文件，然后调用 /sbin/ldconfig来达到同样的目的，不过如果没有root权限，那么只能采用输出LD_LIBRARY_PATH的方法了。

- **注意**

  ​	调用动态库的时候有几个问题会经常碰到，明明已经将库的头文件所在目录 通过 “-I” include进来了，库所在文件通过 “-L”参数引导，并指定了“-l”的库名，但通过ldd命令察看时，就是死活找不到你指定链接的so文件，这时你要做的就是通过修改 LD_LIBRARY_PATH或者/etc/ld.so.conf文件来指定动态库的目录。通常这样做就可以解决库无法链接的问题了。

  ​	在linux下可以用export命令来设置这个值，在linux终端下输入:
  export LD_LIBRARY_PATH=/opt/au1200_rm/build_tools/bin: $LD_LIBRARY_PATH: 　　
  然后再输入:export 　　
  即会显示是否设置正确 　　
  export方式在重启后失效，所以也可以用 vim /etc/bashrc ，修改其中的LD_LIBRARY_PATH变量。 　　
  例如：LD_LIBRARY_PATH=$LD_LIBRARY_PATH:/opt/au1200_rm/build_tools/bin。
