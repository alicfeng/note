现在使用php某些框架，调用的某些函数动不动就出错，因为调用了PHP7的方法，传言说PHP7的效率很高，我的ubuntu14.04怎么也得试试，这年来都是使用16版本的。
```SHELL
# 添加源
sudo add-apt-repository ppa:ondrej/php
# 更新源：
sudo apt-get update
# 停用PHP5-FPM：
sudo service php5-fpm stop
# 移除原来的PHP5：（我的站点使用的是NGINX-FPM）
sudo apt-get remove --purge php5-fpm php5-cgi php5-mysql php5-curl php5-mcrypt php-pear php5-gd php5-xcache
sudo apt-get autoremove
# 安装PHP7
sudo apt-get install php7.0 php7.0-cli php7.0-fpm php7.0-gd php7.0-json php7.0-mysql php7.0-readline php7.0-xml php7.0-mbstring php7.0-curl
```
