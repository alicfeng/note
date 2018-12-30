**前言**
今天在公司玩了一下`UDP`协议通讯，因为公司对服务器的安全性要求很高，没有 `http`协议，要通信那就来`tcp`、`udp`，好勒，那就来`UDP`，其实公司也没有做到高安全性，不说其他的，公司却做了傻逼一样的限制，针对开发者。
> 第一：几乎没有网络
第二：我的电脑安装了公司的一个xx软件，只能上内网服务器，外网？拜拜，怪我太年轻无知。
第三：傻逼式开发，直接在服务器编码。果然有毒，说好的svn、git协作与维护管理呢。哎
___
**UDP传输原理**
UDP传输不需要连接, 发送端只需要把自己的消息打包好(UDP报文), 然后从电脑上发到因特网即可, 不会有任何的确认帧来反馈给你.
___
等着，代码见！(加班困了，晚安)

**PHP-Server**
```php
<?php
include_once "actionLoad.php";
//include_once "config/socket.php";
define("SERVER","udp://127.0.0.1:9998");

$socket = stream_socket_server(SERVER, $errno, $errstr, STREAM_SERVER_BIND);

!$socket ? die("$errstr ($errno)") : null;
echo "udp server had started...\nthe port is 9998...\n";
do {
    //接收客户端发来的信息
    $request_msg = stream_socket_recvfrom($socket, 1024 * 2, 0, $client);
    //打印客户端的传输信息
    echo $request_msg."\n";
    /*路由转发 - 业务逻辑路由器*/
    coreHandler($socket, $request_msg, $client);
} while ($request_msg !== false);
```
Run Server
```
➜  php server.php
udp server had started...
the port is 9998...
```
___
**PHP-Client**
```php
/**
 * @param string $sendMsg
 * @param string $ip
 * @param string $port
 * @return bool|string
 */
function udpRequest($sendMsg = '', $ip = '127.0.0.1', $port = '9998') {
    $handle = stream_socket_client("udp://{$ip}:{$port}", $errno, $errstr);
    !$handle ? die("ERROR: {$errno} - {$errstr}\n") : null;
    fwrite($handle, $sendMsg . "\n");
    $result = fread($handle, 1024);
    fclose($handle);
    return $result;
}

$result = udpRequest(json_encode(array("code" => 4, "name" => "alicfeng")));
echo $result;
```
Run Client
```
➜  php client.php
```
___

**C-Client**
```C
#include <sys/types.h>
#include <sys/socket.h>
#include <string.h>
#include <netinet/in.h>
#include <stdio.h>
#include <stdlib.h>
#include <arpa/inet.h>
#include <unistd.h>

/*UDP服务器地址*/
#define LOG_SERV_ADDR "127.0.0.1"
/*udp服务器端口*/
#define LOG_SERV_PORT 9998
/*环境模式*/
#define LOG_ENV_DEV 1

/**
 * 往udp仍数据
 * @param message
 */
void send_msg_udp(char *message) {
    if(LOG_ENV_DEV!=1){
        return;
    }
    int sockfd;
    struct sockaddr_in servaddr;
    sockfd = socket(AF_INET, SOCK_DGRAM, 0);

    /* 初始化udp信息 */
    bzero(&servaddr, sizeof(servaddr));
    servaddr.sin_family = AF_INET;
    servaddr.sin_port = htons(LOG_SERV_PORT);
    if (inet_pton(AF_INET, LOG_SERV_ADDR, &servaddr.sin_addr) <= 0) {
        return;
    }
    /* 连接UDP服务器 */
    if (connect(sockfd, (struct sockaddr *) &servaddr, sizeof(servaddr)) == -1) {
        perror("connect udp error");
        return;
    }
    /*往UDP写数据*/
    write(sockfd, message, strlen(message));
}

int main(int argc, char **argv) {
    send_msg_udp("alicFeng在扔数据...");
    return 0;
}
```
Run Client
```C
gcc -o client client.c && ./client
```
___
**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
