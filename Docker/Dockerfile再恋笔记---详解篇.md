**前言**
  今晚整理整理dockerfile作为再恋笔记。
  那谁没事安心后随笔整理，想想都心痛。
___
**Dockerfile**

​	Dockerfile是用于自定义构建Docker镜像的规则文件。编辑好了Dockerfile文件后，使用`docker build`即可构建一个镜像。构建一个怎样的镜像那就得看Dockerfile文件。我们来看看具体的Docker有哪些内容与规则。

___

**基本结构**

(1) 文件的编辑类似`键值对`，一个键配置一个值，规范而言，键为大写、值要小写

(2) 使用`#`注释

(3) 整体分为四个部分：镜像信息、作者信息、镜像构建指令信息、容器启动执行指令信息

___

**指令说明**

- **FROM**   `from`

  > *说明*：指定构建的镜像基于哪个镜像，该指令必须位于Dockerfile的第一个指令，倘若不存在该镜像，那就默认从Docker hub拉下来。

  ```dockerfile
  FROM <image>
  # or
  FROM <image><:tag>
  ```

  > *示例* ：基于debain的jessie版本

  ```dockerfile
  FROM debian：jessie
  ```


- **MAINTAINER ** `maintainer`

  > 说明：描述构建者的信息等等。

  ```dockerfile
  MAINTAINER <message>
  ```

  > *示例*：作者AlicFeng 邮箱alic@samego.com

  ```dockerfile
  MAINAINER AlicFeng <alic@samego.com>
  ```


- **RUN ** `run`

  > 说明：构建镜像要执行的shell指令，默认通过/bin/sh解析器进行解析，也可以指定解析器。

  ```dockerfile
  RUN <command>
  # or 
  RUN ["executable","param1","param2"]
  ```

  > *示例 1* ：更新源并安装并安装make，注意安装时一定要使用-y，不然有时会出错

  ```dockerfile
  RUN apt-get update \
  	apt-get install make
  ```

  > *示例2*：执行 `ls -l`shell指令，并指定`/bin/bash`解析器

  ```dockerfile
  RUN ["/bin/bash","ls","-l"]
  ```


- **CMD**  `cmd`

  > 说明：构建的容器启动时要执行的指令。注意主注意注意、cmd指令只能包含一条，多的话只执行最后一条。

  ```dockerfile
  CMD ["executable", "param1", "param2"]   	#将会调用exec执行，首选方式
  # or
  CMD ["param1", "param2"]        			#当使用ENTRYPOINT指令时，为该指令传递默认参数
  # or
  CMD <command> ["param1","param2"]        	#将会调用/bin/sh -c执行
  ```

  > *示例 1*：容器启动时执行`/root/start.sh`脚本。

  ```
  CMD ["/root/start.sh"]
  ```

  > *示例 2*：执行`nginx -g daemon off`

  ```
  CMD ["nginx", "-g", "daemon off"]
  ```


- **ENTRYPOINT**  `entrypoint`

  > 说明：entrypoint与cmd指令类似，entrypoint在dockerfile中只能出现一次，否则只执行最后一条。它是配置容器启动后执行的命令。

  ```dockerfile
  ENTRYPOINT ["executable", "param1", "param2"]       #将会调用exec执行，首选方式
  # or
  ENTRYPOINT <command> ["param1","param2"]       		#将会调用/bin/sh -c执行
  ```

  > *示例 *：执行`/etc/init.d/nginx restart`命令

  ```
  ENTRYPOINT ["/etc/init.d/nginx","restart"]
  ```


- **EXPOSE**  `expose`

  > 说明：指定暴露的端口，供容器之间联系( -link )使用。

  ```dockerfile
  EXPOSE <port> [.....]
  ```

  > *示例*：暴露3306端口

  ```dockerfile
  EXPOSE 3306
  ```


- **ENV**  `env`

  > 说明：指定环境变量，容器运行时也可以指定，这里起到定义的作用。

  ```dockerfile
  ENV <key> <value>
  # or
  ENV <key>=<value>
  ```

  > *示例 1*：设置一个IP环境变量为127.0.0.1。

  ```dockerfile
  ENV IP=127.0.0.1
  ```

  > *示例 2*：设置一个ngixn_dir环境变量为/app/server/nginx。

  ```dockerfile
  ENV nginx_dir /app/server/nginx
  WORKDIR $nginx_dir
  ```


- **ADD**  `add`

  > 说明：拷贝文件，将src拷贝到dest目录下。注意：src支持文件或目录或远程URL，同时src为当前目录的相对目录，而dest是容器的绝对路径，默认拷贝后文件或目录的权限为0775，要是src为容器可识别的压缩文件，那么将会自动解压，这点要注意！

  ```dockerfile
  ADD <src> <dest>
  ```

  > *示例 1*：拷贝一个远程文件，该文件的URL为https://sise.samego.com/Linux/redis.tar.gz，注意，该文件为容器识别的文件，将会自动解压。

  ```dockerfile
  ADD https://sise.samego.com/Linux/redis.tar.gz /app		#执行之后dest为/app/redis/...
  ```

  > *示例 2*：将`/root/bak/conf/redis.conf`文件拷贝到`/app/redis/`目录下。

  ```dockerfile
  ADD /root/bak/conf/redis.conf /app/redis/
  ```


- **COPY**  `copy`

  > 说明：copy与add类似，但是copy的功能比较简洁，没有add强大，不支持远程URL，但是src源文件为容器本地文件或目录的时候，推荐使用copy。

  ```dockerfile
  COPY <src> <dest>
  ```

  > *示例*：将`/root/bak/conf/redis.conf`文件拷贝到`/app/redis/`目录下。

  ```dockerfile
  ADD /root/bak/conf/redis.conf /app/redis/
  ```
  ​


- **VOLUME** `volume`

  > 说明：指定容器的挂载点，使容器中的一个目录具有持久化存储数据的功能，该目录可以被容器本身使用，也可以共享给其他容器使用。我们知道容器使用的是AUFS，这种文件系统不能持久化数据，当容器关闭后，所有的更改都会丢失。当容器中的应用有持久化数据的需求时可以在Dockerfile中使用该指令。

  ```dockerfile
  VOLUME ["path",...]
  ```

  > *示例* ：挂载`/data/mysql/data`目录。

  ```dockerfile
  VOLUME ["/data/mysql/data/"]
  ```


- **WORKDIR**  `workdir`

  > 说明：指定工作目录。有时执行RUN指令时需要切换目录，那就通过workdir指令进行切换。切换目录后在下一次切换之前都是在此目录下。可以是相对目录也可以是绝对路径。

  ```dockerfile
  WORKDIR <path>
  ```

  > *示例*：将工作目录切换至`/app/nginx`目录。

  ```
  WORKDIR /app/nginx
  ```


- **USER**  `user`

  > 说明：指定容器运行执行RUN、CMD指令时的用户，注意：在下一次切换用户之前将一直使用该用户。

  ```dockerfile
  USER <username | uid>
  ```

  > *示例*：切换用户为same。

  ```dockerfile
  USER alic
  ```


- **ONBUILD**  `onbuild`

  > 说明：配置当所创建的镜像作为其它新创建镜像的基础镜像时，所执行的操作指令。

  ```dockerfile
  ONBUILD [INSTRUCTION]
  ```

  > *示例*：比如有这样一个基础镜像`same:basic`，在构建`same:latest`时，在basic基础镜像中使用ONBUILD声明的`ONBUILD RUN apt-get update`指令，构建latest版本也将会自动执行。

  ```dockerfile
  # 这是same:basic
  ONBUILD RUN apt-get update
  ```

  ```dockerfile
  # 这是same:latest正在构建的镜像
  FROM same:basic
  # 构建时将自动执行基于basic镜像使用ONBUILD的指令 如下
  RUN apt-get update
  ```

  ___

  **构建镜像示例**

  > 说明：基于alpine:3.5构建一个Redis镜像。

  ```dockerfile
  FROM alpine:3.5

  # 创建一个redis用户组并创建一个redis用户将其增加在redis用户组
  RUN addgroup -S redis && adduser -S -G redis redis

  # grab su-exec for easy step-down from root
  RUN apk add --no-cache 'su-exec>=0.2'

  # 定义环境变量
  ENV REDIS_VERSION 3.2.8
  ENV REDIS_DOWNLOAD_URL http://download.redis.io/releases/redis-3.2.8.tar.gz
  ENV REDIS_DOWNLOAD_SHA1 6780d1abb66f33a97aad0edbe020403d0a15b67f

  # for redis-sentinel see: http://redis.io/topics/sentinel
  RUN set -ex \
  	\
  	&& apk add --no-cache --virtual .build-deps \
  		gcc \
  		linux-headers \
  		make \
  		musl-dev \
  		tar \
  	\
  	&& wget -O redis.tar.gz "$REDIS_DOWNLOAD_URL" \
  	&& echo "$REDIS_DOWNLOAD_SHA1 *redis.tar.gz" | sha1sum -c - \
  	&& mkdir -p /usr/src/redis \
  	&& tar -xzf redis.tar.gz -C /usr/src/redis --strip-components=1 \
  	&& rm redis.tar.gz \
  	\
  # Disable Redis protected mode [1] as it is unnecessary in context
  # of Docker. Ports are not automatically exposed when running inside
  # Docker, but rather explicitely by specifying -p / -P.
  # [1] https://github.com/antirez/redis/commit/edd4d555df57dc84265fdfb4ef59a4678832f6da
  	&& grep -q '^#define CONFIG_DEFAULT_PROTECTED_MODE 1$' /usr/src/redis/src/server.h \
  	&& sed -ri 's!^(#define CONFIG_DEFAULT_PROTECTED_MODE) 1$!\1 0!' /usr/src/redis/src/server.h \
  	&& grep -q '^#define CONFIG_DEFAULT_PROTECTED_MODE 0$' /usr/src/redis/src/server.h \
  # for future reference, we modify this directly in the source instead of just supplying a default configuration flag because apparently "if you specify any argument to redis-server, [it assumes] you are going to specify everything"
  # see also https://github.com/docker-library/redis/issues/4#issuecomment-50780840
  # (more exactly, this makes sure the default behavior of "save on SIGTERM" stays functional by default)
  	\
  	&& make -C /usr/src/redis \
  	&& make -C /usr/src/redis install \
  	\
  	&& rm -r /usr/src/redis \
  	\
  	&& apk del .build-deps

  # 还是RUN指令
  RUN mkdir /data && chown redis:redis /data

  # 指定挂载目录
  VOLUME /data

  # 切换当前的目录为/data
  WORKDIR /data

  # 拷贝文件
  COPY docker-entrypoint.sh /usr/local/bin/

  ENTRYPOINT ["docker-entrypoint.sh"]

  #　暴露6379端口
  EXPOSE 6379

  # 容器启动时执行redis-server命令
  CMD [ "redis-server" ]
  ```

  ___

  快要闭馆了，快速借助redis托管在github的一个Dockerfile作为简单的示例。

  Alic say :**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
