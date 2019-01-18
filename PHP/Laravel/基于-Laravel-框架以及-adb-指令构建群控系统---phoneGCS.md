# phoneDCS | 手机群控系统

#### 前言

无言...
[view code to github](https://github.com/alicfeng/phoneGCS)


#### 简介

`phoneGCS`全称`phone group control system`，顾名思义即是一款手机(`Android`)群控系统，基于`Cli`形式运行，支持自定义的编排任务、任务录制任务群控。主要有如下特性：

- 自定义剧本任务 | 录制及运行脚本
- 自定义频率控制
- 指定编排任务
- 指定编排任务执行数量
- 查看设备主要信息以及剧本列表
- 实时群控( `未实现` )
- 构建云控系统( `可行`&`未实现` )



#### 使用

- **录制编排任务**

  ```shell
  ➜  ./library/adb-event-record/adbrecord.py -r ./playbook/{编排任务名称}.samego
  ```

- **编排任务执行指令**

  ```
  # 帮助
  ➜ php artisan task:do help
  usage:
  task:do 
          help
          --devices  view devices main info
          --taskCode=playbook code
          --amount=task amount
          --type=playbook type | map(script or playbook)
          --frequency=execute task frequency | s
          
  # 查看设备信息
  ➜ php artisan task:do --devices 
  192.168.2.141:5555	 OPPO A59m
  
  # 编排任务执行
  ➜ php artisan task:do --taskCode={编排任务名称} --amount={数量} --frequency={频率|单位s}
  Task main message :
  taskCode	simple
  amount		1
  frequency	10
  simple playbook running...
  ```



- **编排任务剧本说明**

  - 录制脚本 | `script`

    > 该脚本使用`adbrecord`指令录制自动生成，注意：生成的后缀名必须为`samego`，同时此脚本的生成目录必须位于`base_path()/playbook/script/`目录下。该脚本的内容基于`adb shell sendevent`，示例

    ```
    1542960747204 /dev/input/event2 3 57 513
    1542960749460 /dev/input/event2 3 50 5
    1542960749461 /dev/input/event2 3 53 630
    1542960749461 /dev/input/event2 3 54 836
    1542960749461 /dev/input/event2 1 330 1
    1542960749461 /dev/input/event2 0 0 0
    1542960749461 /dev/input/event2 3 53 621
    1542960749464 /dev/input/event2 3 54 834
    ```

  - 自定义剧本  | `playbook`

    > 该脚本是基于`adb`指令同样是基于`adb shell`，可随心随意编排执行指令，剧本的可执行范围比较广，可控指令以及指令预计时间(`s`)，剧本为一个`json`文件。此脚本的生成目录必须位于`base_path()/playbook/playbook/`目录下。示例

    ```json
    [
      {
        "name": "to menu",
        "command": "input keyevent KEYCODE_HOME",
        "time": 2
      },
      {
        "name": "open wechat application",
        "command": "am start com.tencent.mm/com.tencent.mm.ui.LauncherUI",
        "time": 2
      },
      {
        "name": "call",
        "command": "input keyevent KEYCODE_CALL",
        "time": 2
      },
      {
        "name": "back menu",
        "command": "input keyevent KEYCODE_HOME",
        "time": 2
      }
    ]
    ```
