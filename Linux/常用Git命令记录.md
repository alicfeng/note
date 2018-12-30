**安装Git**
~~~
sudo apt-get install git #ubuntu及其发行版
~~~
___
**配置Git**
~~~
Git的设置文件为.gitconfig，它可以在用户主目录下（全局配置），也可以在项目目录下（项目配置）。
# 编辑Git配置文件
git config -e [--global]

# 设置提交代码时的用户信息
git config --global user.name "your-name"
git config --global user.email "your-mail"

# 显示当前的Git配置
git config --list
~~~
___
**初始化本地仓库**
~~~
# 在当前目录新建一个Git代码库
git init

# 新建一个目录，将其初始化为Git代码库
git init [project-name]

# 下载一个项目和它的整个代码历史
git clone [url]
~~~
___
**增加|删除文件**
~~~
# 添加指定文件到暂存区
git add [file1] [file2] ...

# 添加指定目录到暂存区，包括子目录
git add [dir]

# 添加当前目录的所有文件到暂存区
git add .

# 添加每个变化前，都会要求确认
# 对于同一个文件的多处变化，可以实现分次提交
git add -p

# 删除工作区文件，并且将这次删除放入暂存区
git rm [file1] [file2] ...

# 停止追踪指定文件，但该文件会保留在工作区
git rm --cached [file]

# 改名文件，并且将这个改名放入暂存区
git mv [file-original] [file-renamed]
~~~
___
**代码提交**
~~~
# 提交暂存区到仓库区
$ git commit -m "commit-message"

# 提交暂存区的指定文件到仓库区
$ git commit [file1] [file2] ... -m "commit-message"

# 提交工作区自上次commit之后的变化，直接到仓库区
$ git commit -a

# 提交时显示所有不同信息
$ git commit -v

# 使用一次新的commit，替代上一次提交
# 如果代码没有任何新变化，则用来改写上一次commit的提交信息
$ git commit --amend -m "commit-message"

# 重做上一次commit，并包括指定文件的新变化
$ git commit --amend [file1] [file2] ...
~~~
___
**分支管理**
~~~
# 列出所有本地分支
git branch

# 列出所有远程分支
git branch -r

# 列出所有本地分支和远程分支
git branch -a

# 新建一个分支，但依然停留在当前分支
git branch [branch-name]

# 新建一个分支，并切换到该分支
 git checkout -b [branch-name]

# 新建一个分支，指向指定commit
git branch [branch-name] [commit]

# 新建一个分支，与指定的远程分支建立追踪关系
git branch --track [branch-name] [remote-branch]

# 切换到指定分支，并更新工作区
git checkout [branch-name]

# 切换到上一个分支
git checkout -

# 建立追踪关系，在现有分支与指定的远程分支之间
git branch --set-upstream [branch] [remote-branch]

# 合并指定分支到当前分支
git merge [branch-name]

# 选择一个commit，合并进当前分支
git cherry-pick [commit]

# 删除分支
git branch -d [branch-name]

# 删除远程分支
git push origin --delete [branch-name]
git branch -dr [remote/branch]
~~~
___


**查看git工作信息**
~~~
# 显示有变更的文件
git status

# 显示当前分支的版本历史
git log

# 显示commit历史，以及每次commit发生变更的文件
git log --stat

# 搜索提交历史，根据关键词
git log -S [keyword]

# 显示某个commit之后的所有变动，每个commit占据一行
git log [tag] HEAD --pretty=format:%s

# 显示某个commit之后的所有变动，其"提交说明"必须符合搜索条件
git log [tag] HEAD --grep feature

# 显示某个文件的版本历史，包括文件改名
git log --follow [file]
git whatchanged [file]

# 显示指定文件相关的每一次不同信息
git log -p [file]

# 显示过去5次提交
git log -5 --pretty --oneline

# 显示所有提交过的用户，按提交次数排序
git shortlog -sn

# 显示指定文件是什么人在什么时间修改过
git blame [file]

# 显示暂存区和工作区的差异
git diff

# 显示暂存区和上一个commit的差异
git diff --cached [file]

# 显示工作区与当前分支最新commit之间的差异
git diff HEAD

# 显示两次提交之间的差异
git diff [first-branch]...[second-branch]

# 显示某次提交的元数据和内容变化
git show [commit]

# 显示某次提交发生变化的文件
git show --name-only [commit]

# 显示当前分支的最近几次提交
$ git reflog
~~~
___



**远程同步**
~~~
# 下载远程仓库的所有变动
git fetch [remote]

# 显示所有远程仓库
git remote -v

# 显示某个远程仓库的信息
git remote show [remote]

# 增加一个新的远程仓库，并命名
git remote add [shortname] [url]

# 取回远程仓库的变化，并与本地分支合并
git pull [remote] [branch]

# 上传本地指定分支到远程仓库
git push [remote] [branch]

# 强行推送当前分支到远程仓库，即使有冲突
git push [remote] --force

# 推送所有分支到远程仓库
git push [remote] --all
~~~
___
**具体示例**
提交Git本地仓库代码到远程端
~~~
cd [/git-init-path/branch]  #进入到本地仓库的根目录
git add .  #提交仓库里面的所有代码
git commit -m "这里填写你提交代码的说明"
git push origin master #确认提交本地代码到远程端
~~~
删除远程端的文件或文件夹
~~~
#注意要pull远程端的代码下来以保持项目的一致，否则更新被拒绝
#  使用 git rm 命令即可，有两种选择.
#一种是 git rm --cached "文件路径"，不删除物理文件，仅将该文件从缓存中删除；
#一种是 git rm --f "文件路径"，不仅将该文件从缓存中删除，还会将物理文件删除（不会回收到垃圾桶）
git rm -- cached "路径+文件名"
git commit -m "我删除了文件"
git push
~~~





