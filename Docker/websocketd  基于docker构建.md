## websocketd | 基于docker构建

#### `websocketd` 是什么

首先它是一个开源的工具，嗯~这是重点，[websocketd老家](https://github.com/joewalnes/websocketd)。

简洁而言、`websocketd` 是一个命令行工具，它包装现有的命令行接口程序，并允许通过 `websocket` 访问它。

首先`websocketd` 非常容易构建一个 `websocket` 服务，或者说该组件自身将创建一个 `websocket` 服务。

只要编写一个可执行程序来读取 `stdin` 并写入 `stdout`，就可以构建一个 `websocket` 服务器。支持 `Python`、`Ruby`、`Perl`、`Bash`、`.net`、`C`、`Go`、`PHP`、`Java`、`Crojule`、`Scala`、`Groovy`、`Vabe`、`AWK`、`VBScript`、`Haskell`、`Lua`、`R`，重点是开发者可以不关心网络这一层。



#### `websocketd` 能做什么

基于 `websocketd` 自身特点，脚本程序控制输入而`websocket` 专注输出，它可以用作于如下

- 实时监控服务器健康状态
- 实时监控日志动态
- 即时通信推送
- … ...



#### 基于`docker`构建

构建的`dockerfile` 非常简易，`dockerfile` [传送](https://github.com/alicfeng/dockerfile/tree/master/websocketd)。镜像使用

```shell
docker pull alicfeng/websocketd:latest
```



#### 使用示例

- 基于 `cli` 模式

  ```shell
  # help document
  docker run -it --rm alicfeng/websocketd websocketd -h
  
  # simple usage
  docker run -it --rm alicfeng/websocketd websocketd --port=8888 your_cmd_script_path
  ```

- 基于 `docker-compose` 编排工具

  > 编排内容如下

  ```shell
  version: "2"
  services:
    websocketd:
      container_name: websocketd
      image: alicfeng/websocketd:latest
      ports:
        - 9508:8888
      volumes:
        # this is cli command script for websocketd
        - ./srv/command.sh:/command.sh
      restart: always
  ```

  根据编排启动并使用服务

  ```shell
  docker-compose up -d
  ```

  使用 `H5` 编写一个与 `websocket` 通讯的[程序](https://github.com/alicfeng/dockerfile/blob/master/websocketd/demo.html)即可看到程序效果。

  ![image](https://github.com/alicfeng/dockerfile/raw/master/asset/websocketd_demo.png)

