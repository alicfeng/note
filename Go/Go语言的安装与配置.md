先给出官网地址https://golang.org/， [传送](https://golang.org/)

___
**Step-One：获取go的二进制包**
~~~
wget https://storage.googleapis.com/golang/go1.6.2.linux-386.tar.gz
~~~
___
**Step-Two：解压包**
~~~
tar -C /usr/local -xzf  go1.6.2.linux-386.tar.gz
~~~
___
**Step-Three：配置环境变量**
~~~
#GO
export PATH=$PATH:/usr/local/go/bin
#export GOROOT=$HOME/go
#export PATH=$PATH:$GOROOT/bin

#GO project
export GOPATH=$HOME/tutorial/Coding/alic
~~~
___
[详细请看官网文当说明](https://golang.org/doc/install)
___
**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
