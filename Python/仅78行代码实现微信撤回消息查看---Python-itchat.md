**前言**
    今天一大早奔来图书馆，想想了微信很简洁也很强大的一个工具，最近微信的新闻还是比较多的， 比如：`小程序`、`时间轴`等，这不是重点，重点是看到了一个基于python的微信开源库：`itchat`，玩了一天。Python曾经对我说："时日不多，赶紧用Python"。
> 下面就使用`itchat`做一个这样的程序：
私聊撤回的信息可以收集起来并发送到个人微信的文件助手，包括：
(1) who ：谁发送的
(2) when ：什么时候发送的消息
(3) what：什么信息
(4) which：哪一类信息，包括：文本、图片、语音、视频、分享、位置、附件
...

___
**代码实现**
```python
# -*-encoding:utf-8-*-
import os
import re
import shutil
import time
import itchat
from itchat.content import *

# 说明：可以撤回的有文本文字、语音、视频、图片、位置、名片、分享、附件

# {msg_id:(msg_from,msg_to,msg_time,msg_time_rec,msg_type,msg_content,msg_share_url)}
msg_dict = {}

# 文件存储临时目录
rev_tmp_dir = "/home/alic/RevDir/"
if not os.path.exists(rev_tmp_dir): os.mkdir(rev_tmp_dir)

# 表情有一个问题 | 接受信息和接受note的msg_id不一致 巧合解决方案
face_bug = None


# 将接收到的消息存放在字典中，当接收到新消息时对字典中超时的消息进行清理 | 不接受不具有撤回功能的信息
# [TEXT, PICTURE, MAP, CARD, SHARING, RECORDING, ATTACHMENT, VIDEO, FRIENDS, NOTE]
@itchat.msg_register([TEXT, PICTURE, MAP, CARD, SHARING, RECORDING, ATTACHMENT, VIDEO])
def handler_receive_msg(msg):
    global face_bug
    # 获取的是本地时间戳并格式化本地时间戳 e: 2017-04-21 21:30:08
    msg_time_rec = time.strftime("%Y-%m-%d %H:%M:%S", time.localtime())
    # 消息ID
    msg_id = msg['MsgId']
    # 消息时间
    msg_time = msg['CreateTime']
    # 消息发送人昵称 | 这里也可以使用RemarkName备注　但是自己或者没有备注的人为None
    msg_from = (itchat.search_friends(userName=msg['FromUserName']))["NickName"]
    # 消息内容
    msg_content = None
    # 分享的链接
    msg_share_url = None
    if msg['Type'] == 'Text' \
            or msg['Type'] == 'Friends':
        msg_content = msg['Text']
    elif msg['Type'] == 'Recording' \
            or msg['Type'] == 'Attachment' \
            or msg['Type'] == 'Video' \
            or msg['Type'] == 'Picture':
        msg_content = r"" + msg['FileName']
        # 保存文件
        msg['Text'](rev_tmp_dir + msg['FileName'])
    elif msg['Type'] == 'Card':
        msg_content = msg['RecommendInfo']['NickName'] + r" 的名片"
    elif msg['Type'] == 'Map':
        x, y, location = re.search(
            "<location x=\"(.*?)\" y=\"(.*?)\".*label=\"(.*?)\".*", msg['OriContent']).group(1, 2, 3)
        if location is None:
            msg_content = r"纬度->" + x.__str__() + " 经度->" + y.__str__()
        else:
            msg_content = r"" + location
    elif msg['Type'] == 'Sharing':
        msg_content = msg['Text']
        msg_share_url = msg['Url']
    face_bug = msg_content
    # 更新字典
    msg_dict.update(
        {
            msg_id: {
                "msg_from": msg_from, "msg_time": msg_time, "msg_time_rec": msg_time_rec,
                "msg_type": msg["Type"],
                "msg_content": msg_content, "msg_share_url": msg_share_url
            }
        }
    )


# 收到note通知类消息，判断是不是撤回并进行相应操作
@itchat.msg_register([NOTE])
def send_msg_helper(msg):
    global face_bug
    if re.search(r"\<\!\[CDATA\[.*撤回了一条消息\]\]\>", msg['Content']) is not None:
        # 获取消息的id
        old_msg_id = re.search("\<msgid\>(.*?)\<\/msgid\>", msg['Content']).group(1)
        old_msg = msg_dict.get(old_msg_id, {})
        if len(old_msg_id) < 11:
            itchat.send_file(rev_tmp_dir + face_bug, toUserName='filehelper')
            os.remove(rev_tmp_dir + face_bug)
        else:
            msg_body = "告诉你一个秘密~" + "\n" \
                       + old_msg.get('msg_from') + " 撤回了 " + old_msg.get("msg_type") + " 消息" + "\n" \
                       + old_msg.get('msg_time_rec') + "\n" \
                       + "撤回了什么 ⇣" + "\n" \
                       + r"" + old_msg.get('msg_content')
            # 如果是分享存在链接
            if old_msg['msg_type'] == "Sharing": msg_body += "\n就是这个链接➣ " + old_msg.get('msg_share_url')

            # 将撤回消息发送到文件助手
            itchat.send(msg_body, toUserName='filehelper')
            # 有文件的话也要将文件发送回去
            if old_msg["msg_type"] == "Picture" \
                    or old_msg["msg_type"] == "Recording" \
                    or old_msg["msg_type"] == "Video" \
                    or old_msg["msg_type"] == "Attachment":
                file = '@fil@%s' % (rev_tmp_dir + old_msg['msg_content'])
                itchat.send(msg=file, toUserName='filehelper')
                os.remove(rev_tmp_dir + old_msg['msg_content'])
            # 删除字典旧消息
            msg_dict.pop(old_msg_id)


if __name__ == '__main__':
    itchat.auto_login(hotReload=True,enableCmdQR=2)
    itchat.run()
```
___
该程序可以直接在终端运行，在终端扫码成功够即可登录成功，同时也可以打包在window系统运行(注意修改一下路径，推荐使用相对路径)。
```
➜  ~ python wx.py
Getting uuid of QR code.
Downloading QR code.
Please scan the QR code to log in.
Please press confirm on your phone.
Loading the contact, this may take a little while.
[3;J
Login successfully as AlicFeng
Start auto replying.
```
**效果图**

![itchat](http://upload-images.jianshu.io/upload_images/1678789-758c99c41e928c4e.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

___
**itchat**
上面都是编程逻辑的小事，我还是记录一下itchat微信这个开源库。
 - 简介
itchat是一个开源的微信个人号接口，使用python调用微信变得非常简单。简单是用itchat代码即可构建一个基于微信的即时通讯，更不错的体现在于方便扩展个人微信的在其他平台的更多通讯功能。

- 安装
```
pip3 install itchat
```

- itchat - Helloworld
仅仅三行代码发送一条信息给文件助手
```
import itchat
itchat.auto_login(hotReload=True)
itchat.send('Hello AlicFeng', toUserName='filehelper')
```
- 查看客户端

![Result](http://upload-images.jianshu.io/upload_images/1678789-d42e7da3cb2b1d32.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

学习最重要的还是API说明手册
[Github for itchat](https://github.com/liduanwei/ItChat)

[中文API](http://itchat.readthedocs.io/zh/latest/)

___
Alic say :**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
