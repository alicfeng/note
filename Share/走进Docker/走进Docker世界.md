## 走进 Docker 世界

#### 1 认识Docker

###### 1.1 Docker 简介



###### 1.2 Docker 虚拟化

###### 1.3 Docker 用途



___



#### 2 环境搭建

###### 2.1 基于 Linux 操作系统安装

###### 2.2 基于 MacOS 操作系统安装

###### 2.3 基于 Windows 操作系统安装



___



#### CICD和DevOps

###### 基于 Docker 践行DevOps 理念

**当 Docker 遇到 CI/CD，让 DevOps 落地于实践**

践行持续集成（CI）、持续部署（CD），简化工作流程，提高工作效率

![当 Docker 遇到 CI/CD，让 DevOps 落地于实践](https://raw.githubusercontent.com/alicfeng/note.samego.com/master/source/images/cicd_devops.png)



Docker容器支持CI / CD实现，允许开发人员通过共享映像协同构建代码，同时简化对不同基础架构的部署。使用Docker Enterprise，您可以构建一个DevOps实践，该实践与您选择的CI工具，任何应用程序堆栈，在Linux或Windows上运行，在任何基础架构（本地，云端或两者）上集成。

###### 使用 gogs + drone 基于docker 构建CI



###### Jenkin pipeline 流水线



###### k8s 集群初体验

> 先构建一个镜像, `dockerfile` 位于 `/走进Docker/k8s/group/application`
>
> ```php
> ➜  application git:(master) ✗ tree
> .
> ├── Dockerfile
> ├── app.k8s.com
> │   └── message.php
> ├── docker-compose.yml
> ├── nginx
> │   └── default.conf
> ├── start.sh
> └── supervisor
>     └── supervisor.ini
> ```

- `Service` 部署

  `demo-service.yaml` 文件详情内容如下

  ```yaml
  apiVersion: v1
  kind: Service
  metadata:
    name: k8s-demo
  spec:
    type: NodePort
    selector:
      app: k8s-demo
    ports:
    - protocol: TCP
      port: 80
      targetPort: 80
      nodePort: 30008
  ```

  ```shell
  # 创建服务
  ➜  group git:(master) ✗ kubectl create -f demo-service.yaml
  service/demo-service created
  ```

  

​	

- `Deployment` 部署

  `demo-deployment.yaml` 文件详情内容如下

  ```yaml
  apiVersion: apps/v1beta1
  kind: Deployment
  metadata:
    name: demo-deployment
    labels:
      app: k8s-demo # 必须与 service 中的 spec.selector.app 保持一致
  spec:
    replicas: 1
    template:
      metadata:
        labels:
          app: k8s-demo
      spec:
        containers:
          - name: demo-k8s
            image: alicfeng/k8s_app:v2.0
            ports:
              - containerPort: 80
  ```

  ```shell
  # 查看服务
  ➜  group git:(master) ✗ kubectl get service demo-service
  NAME           TYPE       CLUSTER-IP       EXTERNAL-IP   PORT(S)        AGE
  demo-service   NodePort   10.111.182.133   <none>        80:30008/TCP   36s
  
  # 创建 pod 节点
  ➜  group git:(master) ✗ kubectl create -f demo-deployment.yaml
  deployment.apps/demo-deployment created
  
  # 查看 pod 节点
  ➜  group git:(master) ✗ kubectl get deployments
  NAME              READY   UP-TO-DATE   AVAILABLE   AGE
  demo-deployment   2/2     2            2           40s
  
  # 查看服务详情
  ➜  group git:(master) ✗ kubectl describe svc/demo-service
  Name:                     demo-service
  Namespace:                default
  Labels:                   <none>
  Annotations:              <none>
  Selector:                 app=k8s-demo
  Type:                     NodePort
  IP:                       10.111.182.133
  LoadBalancer Ingress:     localhost
  Port:                     <unset>  80/TCP
  TargetPort:               80/TCP
  NodePort:                 <unset>  30008/TCP
  Endpoints:                10.1.0.121:80
  Session Affinity:         None
  External Traffic Policy:  Cluster
  Events:                   <none>
  
  # 校验服务中提供服务的 pod
  ➜  group git:(master) ✗ curl 127.0.0.1:30008/message.php -s | jq
  {
    "code": 1000,
    "message": "success",
    "data": {
      "version": "v2.0.0",
      "name": "samego",
      "time": 1563125656,
      "hostname": "demo-deployment-8477fb9ddc-ntb6p"
    }
  }
  ```

  

- 请求分发负载均衡 / 服务伸缩

  ```shell
  ## 调节副本数量
  # 方案一: 修改 yaml 文件
  ➜  group git:(master) ✗ kubectl apply -f demo-deployment.yaml
  Warning: kubectl apply should be used on resource created by either kubectl create --save-config or kubectl apply
  deployment.apps/demo-deployment configured
  
  # 查看 pods 节点数量
  ➜  group git:(master) ✗ kubectl get pods
  NAME                               READY   STATUS      RESTARTS   AGE
  application                        0/1     Completed   0          42d
  demo-deployment-8477fb9ddc-5lr72   1/1     Running     0          93s
  demo-deployment-8477fb9ddc-ntb6p   1/1     Running     0          44m
  
  # 方案二: 通过 scale 指令
  ➜  group git:(master) ✗ kubectl scale deployment/demo-deployment --replicas=3
  deployment.extensions/demo-deployment scaled
  
  # 查看 pods 节点数量
  ➜  group git:(master) ✗ kubectl get pods
  NAME                               READY   STATUS      RESTARTS   AGE
  application                        0/1     Completed   0          42d
  demo-deployment-8477fb9ddc-5lr72   1/1     Running     0          2m7s
  demo-deployment-8477fb9ddc-ntb6p   1/1     Running     0          44m
  demo-deployment-8477fb9ddc-vqjgs   1/1     Running     0          11s
  ```

  

- 升级 与 回滚

  ```shell
  # 升级
  ➜  group git:(master) ✗ kubectl rollout status deployment/demo-deployment
  
  # 回滚
  ➜  group git:(master) ✗ kubectl rollout undo deployment/demo-deployment
  ```

  









