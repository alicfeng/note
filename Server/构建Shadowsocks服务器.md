## 构建Shadowsocks服务器

- **安装**

  ```shell
  [alicfeng@centos ~]# yum update -y
  [alicfeng@centos ~]# yum install -y python-setuptools && easy_install pip
  [alicfeng@centos ~]# pip install -y shadowsocks
  ```

  

- **多用户配置**

  ```shell
  [alicfeng@centos ~]# cat /etc/shadowsocks.json
  {
      "server":"{$server_ip}",
          "port_password":{
          "{$port1}":"{$password1}",
          "{$port2}":"{$password2}",
          "{$port3}":"{$password3}"
       },
      "timeout":60,
      "method":"rc4-md5",
      "fast_open":false,
      "workers":1
  }
  ```



- **启动与开机启动**

  ```shell
  # 启动
  [alicfeng@centos ~]# ssserver -c /etc/shadowsocks.json -d start
  
  # 开机启动  加入下面内容
  # /usr/bin/ssserver -c /etc/shadowsocks.json -d start
  vim  /etc/rc.d/rc.local
  ```

