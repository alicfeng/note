## ConfigMap使用

#### 目的

应用程序部署的信息和程序进行模块分离



#### 特点

- 生成为容器内的环境变量

- 设置容器启动的命令参数

- `volume` 形式挂载成容器内的文件或目录



#### 示例

###### 使用文件创建 `configmap`

```shell
# 创建 configmap
➜ kubectl create configmap one.json --from-file=/Users/alicfeng/demo/configmap/one.json
configmap/one.json created

➜ kubectl create configmap one.json --from-file=/Users/alicfeng/demo/configmap/one.ini
configmap/one.json created

# 查看 configmap
➜ kubectl get configmap
NAME       DATA   AGE
one.ini    1      43m
one.json   1      43m

# 查看具体 configmap
➜ kubectl describe configmap one.ini
Name:         one.ini
Namespace:    default
Labels:       <none>
Annotations:  <none>

Data
====
one.ini:
----
name=alicfeng

Events:  <none>
```

###### Pod的yaml

```yaml
apiVersion: v1
kind: Pod
metadata:
    name: web
    labels:
        name: web
spec:
    containers:
        - name: socket
          image: alicfeng/web:socket
          ports:
              - containerPort: 5200
          volumeMounts:
              # 挂载目录
              - name: config
                mountPath: /var/www/config
              # 映射挂载文件
              - name: one-ini
                mountPath: /var/www/config/one.ini
                subPath: one.ini
                readOnly: True
              - name: one-json
                mountPath: /var/www/config/one.json
                subPath: one.json
                readOnly: True
    volumes:
        # 声明主机目录
        - name: config
          hostPath:
              path: /Users/alicfeng/demo/configmap/config
        # 声明定义configMap
        - name: one-ini
          configMap:
              name: one.ini
        - name: one-json
          configMap:
              name: one.json
```

###### 创建pod容器

> 假设运行失败 kubectl describe 查看具体日志

```bash
# 创建 pod
➜  configmap kubectl create -f demo.yaml
pod/web created
```



