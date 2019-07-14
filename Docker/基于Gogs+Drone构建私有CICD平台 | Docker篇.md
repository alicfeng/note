---
title: 基于Gogs+Drone构建私有CICD平台 | Docker篇
date: 2018-12-23
tags:
  - CICD
  - Drone
  - gogs
categories: Docker
---


## 前言
`CI / CD`( 持续集成 / 持续部署  )方案是DevOps中不可或缺的流程之一，最近也了解了部分的相关的解决方案，最终选择了`Drone` + `Gogs`基于`docker`容器环境来构建`CI / CD`，本文将分享下如何构建此平台以及如何快速地使用到项目开发中。

<!-- more -->

**应该会有一个疑问？我为什么不选择主流的`GitLab` + `Jenkins` 两个最佳搭档来构建呢？**
- `GitLab`是使用`Ruby`编写的，`Jenkins`更是了不起，使用`Java`来编写的，项目整体比较膨大，同时它们对硬件、CPU等开销比较高
- `Drone`、`Gogs`皆是使用`Go`语言来编写构建，在整体的语言性能与内存开销算是有一定的优势，同时`Drone`支持`Github`、`GitLab`、`Gogs`以及`Bitbucket`，这点很不错！反手就是一个赞?
> GitLab + Jenkins该组合还是一个不错的选择，我并没有反对，为何呢？GitLab是一个非常成熟的git工具之一，同时Jenkins也是非常成熟的CICD组件，功能非常强大。
> 但是我还是要站在正义的一边，选择`Drone` + `Gogs`。O(∩_∩)O哈哈~

## 环境
使用的前提，必须符合以下条件
- 系统安装了`Docker`，同时要安装了`Docker`编排工具`docker-compose`
- 主流的`x64`位系统，`Linux`、`Mac`、`Window`等
- 安装了`git`版本控制工具

## 安装
安装非常简单，拉取`docker-compose.yml`编排文件，基于`Docker`环境自动构建即可！
**同步至[github](https://github.com/alicfeng/gogs-drone-docker) | [戳戳戳](https://github.com/alicfeng/gogs-drone-docker)**
```shell
git clone https://github.com/alicfeng/gogs-drone-docker.git
cd gogs-drone-docker && docker-compose up -d
```
执行`docker ps`来看下容器的运行情况
![alicfeng - docker ps](http://upload-images.jianshu.io/upload_images/1678789-0c71e20c316e1d88.png!large?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
> 对应的配置文件可以根据项目的需求自由灵活改变，同时像我这样强迫症的人，我不喜欢使用`IP`来进行访问请求的以及`http`协议访问，我会使用`nginx`代理。[不详细说了](https://www.jianshu.com/p/5d36ccb5af88)

至此，我们已经完成了平台的构建工作了。我们来欣赏下~干杯~
![Gogs](http://upload-images.jianshu.io/upload_images/1678789-1de3d8bbaa385c05.png!large?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
![Drone](http://upload-images.jianshu.io/upload_images/1678789-f165f6d1d9a07151.png!large?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

有两个地方需要注意：
- `Drone`登录的账号需要在`Gogs`设置为管理员，他俩兄弟的账密是互通的
- `Gogs`的仓库会自动同步到`Drone`上，此时，需要在`Drone`开启钩子才能正常运行

## 使用
好了，是时候来体验两把了，这里需要有一个前提了，O(∩_∩)O哈哈~，你需要了解它是如何运行的，根据什么来自动化构建的
每当分支的代码更新的时候，Gogs会动过钩子同步通知Drone，而Drone收到通知之后会发生一系列动作
 - 通过git插件`clone`分支代码到容器里面
 - 测试
 - 编译代码，构建可执行文件
 - 将项目和运行环境打包成镜像，发布到`Registry`
 - 部署至生产环境
 - 发送邮件等通知信息，这里还有很多插件，比如微信、钉钉、电报等

构建的剧本是通过`.drone.yml`文件编排的，基于`Docker`镜像进行构建，很nice~下面简单体验下`Laravel`项目的即可！
```yml
pipeline:
  build:
    image: motecshine/laravelphp71
    commands:
    - mv $(pwd)/.env.dev $(pwd)/.env
    - composer config repo.packagist composer https://packagist.phpcomposer.com
    - composer install --no-scripts --no-dev
    # others
```
![AlicFeng](http://upload-images.jianshu.io/upload_images/1678789-44e55c14811251a6.png!large?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)


**[价值源于技术，技术源于分享](https://github.com/alicfeng)**
