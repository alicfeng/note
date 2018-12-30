**场景**
        有时候我们写的shell脚本不便暴露里面的信息，或许此时我们或想到将不便暴露的信息以参数等方式传进去，还有一种方法：将shell脚本加密即可！
      那么该如何将shell脚本加密呢？使用`shc`~
___
**shc是什么**
[shc](https://github.com/neurobin/shc)是一个脚本编译工具, 使用RC4加密算法, 它能够把shell程序转换成二进制可执行文件(支持静态链接和动态链接)。
___
**安装shc**
```
sudo add-apt-repository ppa:neurobin/ppa
sudo apt-get update
sudo apt-get install shc
```
___
**shc简单使用**
- 基本语法

```
shc -v -r -T -f shell.sh
```
- 案例，我们对一个demo.sh脚加密

```shell
➜  data shc -v -r -T  -f demo.sh 
shc shll=bash
shc [-i]=-c
shc [-x]=exec '%s' "$@"
shc [-l]=
shc opts=
shc: cc  demo.sh.x.c -o demo.sh.x
shc: strip demo.sh.x
shc: chmod go-r demo.sh.x
```
注意：加密的过程中会生成两个文件`*.sh.x`  和 `*.sh.x.c`，
`*.sh.x.c` 是脚本的源文件，可删除。
`*.sh.x`就是原来脚本的可执行文件，可随意改名，可直接执行。
不说了，图书馆关门了～
___
Alic say : **[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
[Email Alic](http://www.jianshu.com/p/ba6cdb0d3f1c)




