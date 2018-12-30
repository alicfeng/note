安装composer
~~~shell
wget curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
~~~

设置国内镜像源姿势一 之 **全局配置**
~~~shell
composer config -g repo.packagist composer https://packagist.phpcomposer.com
~~~

设置国内镜像源姿势之一 之 **单项目配置**
~~~shell
composer config repo.packagist composer https://packagist.phpcomposer.com
~~~

设置国内镜像源姿势之一 之 **composer.json**
~~~json
"repositories": {
    "packagist": {
      "type": "composer",
       "url": "https://packagist.phpcomposer.com"
    }
}
~~~
