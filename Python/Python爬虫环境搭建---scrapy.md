**环境**
OS ： Ubuntu14.04
Python ： Python 2.7.6
Scrapy ： Scrapy 1.3.3
___
**安装**
```
sudo apt-get install python-dev libevent-dev python-pip

# install scrapy
sudo pip install Scrapy
```
___
**Question**
- Q1、  `ImportError: Twisted requires zope.interface 3.6.0 or later: no module named zope.interface  `
```
➜  wget http://pypi.python.org/packages/source/z/zope.interface/zope.interface-4.0.1.tar.gz
➜  tar xvf zope.interface-4.0.1.tar.gz 
➜  cd zope.interface-4.0.1
➜  sudo  python setup.py install
```
- Q2、缺少模块
```
sudo pip install $module_name
```
