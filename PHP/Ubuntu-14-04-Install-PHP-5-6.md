```SHELL
sudo apt-get -y update
sudo add-apt-repository ppa:ondrej/php -y
sudo apt-get -y update
sudo apt-get -y install php5.6 php5.6-mcrypt php5.6-mbstring php5.6-curl php5.6-cli php5.6-mysql php5.6-gd php5.6-xml
sudo add-apt-repository ppa:ondrej/php -r

```

> 注意：
如果安装过 libapache2-mod-php5，要先卸载 libapache2-mod-php5， 然后安装 libapache2-mod-php5.6
否则phpinfo()输出的php版本还是5.5
