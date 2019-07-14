#!/usr/bin/env bash

# 查看当前的服务
kubectl get nodes

# 查看节点 pods
kubectl get pods

# 启动 demo 服务
kubectl create -f demo-service.yaml --record

# 查看服务
kubectl get service
kubectl get svc service_name
kubectl get svc | grep service_name
kubectl describe service service_name


# 删除服务
# 通过 yaml 文件删除
kubectl delete -f demo-service.yaml
# 通过服务名称删除
kubectl delete service service_name
# 删除所有服务
kubectl delete service --all

# 通过 deployment 控制器启动 pod 实例
kubectl create -f demo-deploymen.yaml

#
curl -s http://127.0.0.1:30008/message.php | jq .

#### 服务伸缩( 负载均衡 )
#### 修改配置文件
kubectl apply -f demo-deployment.yaml
#### cli方式修改
kubectl scale deployment/demo-deployment --replicas=2

#### 服务升级 与 回滚
# 修改配置( 镜像版本 ) 记得执行 apply 使得配置生效
# 升级
kubectl rollout status deployment/demo-deployment
# 回滚
kubectl rollout undo deployment/demo-deployment


