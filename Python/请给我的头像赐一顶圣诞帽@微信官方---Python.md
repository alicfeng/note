- **前言**
> 昨天，我在朋友圈闲逛了一圈，恰好被一条朋友圈玩了一个上午，我才不爽叻！
> 那么多人在@`微信官方`，傻傻的我也在@`微信官方`,@之后，智商接近地平线
> 据我分析呢，还是很多人和我一样，但我要让你们更傻一点，哈哈😏
> 此文纯属分享 ... ...

```
content = "... ... @微信官方"
result = content.split("@")
前面是True  :  后面是False
```
![图片发自简书APP](http://upload-images.jianshu.io/upload_images/1678789-7400de63b625d80f.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

___

- **概览**
**十八行代码实现微信机器人**
**麻烦将我的微信变成Robot@微信官方**
**麻烦将我好友的头像发我下(最好拼图)@微信官方**
**朋友给我发的消息撤回了麻烦你偷偷告诉我@微信官方**
___

- **圣诞节的前两天我被玩了**

> 昨天朋友圈一直@微信官方

- 请赋予我头像一顶可爱的圣诞帽@微信官方
- 麻烦将我的微信零钱装满@微信官方
- ...

然而我信了，我还真的信了 笑~,早上@`微信官方` ,苦苦等待了微信团队帮我更换头像， 好像傻子一样还隔几分钟看一次，看看是否换了没有。`依然这么单纯！`

>最后朋友告知☛
>"你是不是傻啊，那是自己换的。"  ( by 圣诞头像小程序 )
>`单纯的心灵受到一万点伤害...`

对自己竟然无言以对！好勒, 让你们玩我，不玩下你们才不过瘾呢,哈哈O(∩_∩)O, 搭建`微信机器人`, 好好对待你们, 我也是用同样的套路方式`@微信官方`。说这些不够(｡･∀･)ﾉﾞ嗨。小二麻烦上点`小菜`和点`程序(酒)`。

___

- **圣诞节我要把你们玩了**

> 程序(Python)依赖
> [itchat](https://github.com/littlecodersh/ItChat)
> [图灵](http://www.tuling123.com)

程序只有仅仅的十八行代码，不解释(自带解释)。程序亦可在终端命令行下生成QRCode。

```Python
# coding=utf8
import requests
import itchat

# 图灵账号配置key
KEY = 'your key'
TULING_API_URL = 'http://www.tuling123.com/openapi/api'

def get_response(msg):
    data = {'key': KEY, 'info': msg, 'userid': 'wechat-robot'}
    try:
        r = requests.post(TULING_API_URL, data=data).json()
        return r.get('text')
    except:
        return

@itchat.msg_register(itchat.content.TEXT)
def tuling_reply(msg):
    defaultReply = 'I received: ' + msg['Text']
    reply = get_response(msg['Text'])
    return reply or defaultReply

itchat.auto_login(hotReload=True)
itchat.run()
```
看完程序后，其实很简单，没什么。这才不是我要关注的，我关心的是把你们玩了的效果！
`没有过程的结果是平淡的，没有结果的过程是茫然的。`
[戳这里Code](https://github.com/alicfeng/learncode/blob/master/python/Interesting/wechat_rebot.py)

> 哈哈，看！有很多搞笑的，这只是其中一个`大废`。看图~
> @大家好，我比较爱折腾，更爱笑！😜

![一个大废和Robot的对话](http://upload-images.jianshu.io/upload_images/1678789-3cfc6554193cb1ac.jpg?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

___

-  玩够了？开心去睡觉？No~No~No

>我要让`微信官方团队`加班！
> 听说太多人`@微信官方`，导致微信官方正在寻找外包服务，那肯定啊~忙不过来嘛。
> 那就继续`@微信官方`, 😄哈哈~

- **麻烦将我好友的头像发我下(最好拼图)`@微信官方`**

~~这里还有甚多Desc被我删除了，自由想象喽~~`我承认我很懒，没写`
二话不说，看程序...

```
代码被吃掉了
```
[代码在这里](https://github.com/alicfeng/learncode/blob/master/python/Interesting/wechat_friend_face.pyhttps://www.jianshu.com/u/d3b98b758486)
看完程序看图...
![拼好友头像图](http://upload-images.jianshu.io/upload_images/1678789-168b19b6439611df.jpg?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

___

- **朋友给我发的消息撤回了麻烦你偷偷告诉我@微信官方**
这里就不说了，没意思了，玩过了
[时光机传送](https://github.com/alicfeng/learncode/blob/master/python/Interesting/wechat_withdraw.py)

![仅78行代码实现微信撤回消息查看](http://upload-images.jianshu.io/upload_images/1678789-942d805d5fac3c08.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)


AlicFeng:`这段时间没有动笔，只看没写，快要废了`
**[价值源于技术，贡献源于分享](https://www.jianshu.com/u/d3b98b758486)**





