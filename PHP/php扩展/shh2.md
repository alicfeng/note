好记性不如烂笔头，因为信赖权威 [**pecl**](http://pecl.php.net) 导致浪费了十来分钟。

```shell
## 安装依赖
# centos
yum -y install git libssh2-devel
# mac
brew install libssh2

## 编译安装ssh2
git clone https://git.php.net/repository/pecl/networking/ssh2.git
cd ssh2
phpize
./configure
make
sudo make install

# 将ssh2 添加到 php.ini
```





