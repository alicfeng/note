**C语言的数据类型**

![C语言的数据类型](http://see.xidian.edu.cn/cpp/uploads/allimg/120205/1-120205162A4H8.jpg?_=2780149)

- (1)输入输出

```c
#include <stdio.h>

int main(int args, const char *argv){
    //单纯字符串输出
    puts("hello world");
    
    //格式化输出
    printf("hello %s\n","alicfeng");

    //输入
    char username[10];
    int age;
    gets(username);//很危险的做法 推荐不使用
    scanf("%d",&age);//参数-(类型,参数的地址)
    printf("%s age is %d\n",username,age);

    return 0;
}
```

> make && run

```shell
➜  demo gcc -o main demoIO.c && ./main 
demoIO.c: In function ‘main’:
demoIO.c:18:5: warning: implicit declaration of function ‘gets’ [-Wimplicit-function-declaration]
     gets(username);//很危险的做法 推荐不使用
     ^
/tmp/cct0RsLf.o：在函数‘main’中：
demoIO.c:(.text+0x49): 警告： the `gets' function is dangerous and should not be used.
hello world
hello alicfeng
alic
22
alic age is 22
```



- (2)C语言方法的调用

```c
#include <stdio.h>

// 方法的声明和定义
int max(int a, int b) {
    return a > b ? a : b;
}

int main() {
    printf("the max is %d\n",max(10,20));
    return 0;
}
```

> make && run

```shell
➜  demo gcc -o main demoFunc.c && ./main 
the max is 20
```



- (3)C语言的宏定义

```c
#include <stdio.h>

//定义宏 编译前已经准备好 因而速度很快
#define MATH_PI 3.14

int main(){
    printf("the PI value is %f\n",MATH_PI);
    return 0;
}
```

> make && run

```shell
➜  demo gcc -o main demoDefine.c && ./main
the PI value is 3.140000
```



- (4)C语言的宏定义方法

```c
#include <stdio.h>

//定义宏方法 对于多行可以使用反斜杠
#define MAX(A, B) A>B?A:B

int main() {
    printf("the max value is %f\n",MAX(20.4,30.8));
    return 0;
}
```

> make && run

```shell
➜  demo gcc -o main demoDefineFunc.cpp && ./main
the max value is 30.800000
```



- (5)C语言的条件运算符

```c
#include <stdio.h>

//if
void ifCondition(int score) {
    if (score >= 90) {
        printf("优秀\n");
    } else if (score >= 80) {
        printf("良好\n");
    } else if (score >= 60) {
        printf("及格\n");
    } else {
        printf("不及格\n");
    }
}

//switch
void switchCondition(int score) {
    switch (score / 10) {
        case 10:
        case 9:
            printf("优秀\n");
            break;
        case 8:
            printf("良好\n");
            break;
        case 7:
        case 6:
            printf("及格\n");
            break;
        default:
            printf("不及格\n");
            break;
    }
}

//三木运算
void simpleCondition(int score) {
    puts(score >= 60 ? "及格" : "不及格");
}

int main(){
    ifCondition(95);
    switchCondition(88);
    simpleCondition(38);
    return 0;
}
```

> make && run

```shell
➜  demo gcc -o main demoCondition.c && ./main
优秀
良好
不及格
```

- (6)C语言的循环

```c
#include <stdio.h>
int main() {
    /*第一：for*/
    for (int i = 0; i < 10; ++i) {
        printf("hello %d\n", i);
    }

    for (int i = 0; i < 10; printf("hello %d\n", i++)) {
        printf("alicfeng\n");
    }


    /*第二：while*/
//    int index = 10;
//    do {
//        printf("hello %d\n", index--);
//    } while (index > 0);


    int index=0;
    while (index<10){
        printf("hello %d\n", index++);
    }
    return 0;
}
```



- (7)C语言的结构体

```c
#include <stdio.h>

/*定义一个结构体*/
struct User{
    int age;
    char *name;
};

int main(){
    struct User user;
    user.age = 20;
    user.name = "alicfeng";

    //复制一个结构体变量 但是新的变量已经分配新的内存空间
    struct User user1 = user;
    //对user的成员改变不会影响user1的值
    user.age = 21;

    printf("%s age is %d\n",user.name,user.age);
    printf("%s age is %d\n",user1.name,user1.age);
    return 0;
}
```

> make && run

```shell
➜  demo gcc -o main demoStruct.c && ./main 
alicfeng age is 21
alicfeng age is 20
```



- (8)C语言的结构体指针

```c
#include <stdio.h>
#include <stdlib.h>

struct User{
    int age;
    char *username;
};

int main(){
    //对结构体的变量需要开辟内存空间
    struct User *user = malloc(sizeof(struct User));
    user->age = 20;
    user->username = "alicfeng";

    struct User *user1 = user;
    user->age = 22;

    printf("%s age is %d\n",user1->username,user1->age);
    return 0;
}
```

> make && run

```shell
➜  demo gcc -o main demoStructPoint.c && ./main 
alicfeng age is 22
```



- (9)C语言的指针函数

```c
#include <stdio.h>
#include <stdlib.h>

//正常函数 指针调用
void sayPointer(){
    printf("hello pointer\n");
}

//指针参数的方法
void changeValue(int *value){
    *value = 100;
}

int main(){
    //example one
    void (*p)();
    p = sayPointer;
    p();

    //example two
    int value = 0;
    changeValue(&value);
    printf("the value is %d\n",value);

    return 0;
}
```

> make && run

```shell
➜  demo gcc -o main demoFuncPointer.c && ./main
hello pointer
the value is 100
```



- (10)C语言的typedef关键字

```c
#include <stdio.h>

//定义一个People的类型
typedef struct {
    int age;
    char *username;
} People;

void sayHello(){
    printf("hello world\n");
}
//定义一个指针指向一个方法
typedef void (*Func)();

int main(){
    People *people;
    people->age = 22;
    people->username = "alicfeng";
    printf("%s age is %d\n",people->username,people->age);

    //example two

    Func pointer = sayHello;
    pointer();

    return 0;
}
```

> make && run

```shell
➜  demo gcc -o main demoTypedef.c && ./main
alicfeng age is 22
hello world
```



- (11)C语言的头文件

```c
#header.h文件
#ifndef DEMO_DEMOHEADER_H
#define DEMO_DEMOHEADER_H

/**
 * PS:这里只是函数的声明,相当于接口的方法
 */
void sayHello();

#endif //DEMO_DEMOHEADER_H
```

```c
//主体文件.c

#include <stdio.h>
#include "header.h"

/**
 * 函数的定义
 */
void sayHello(){
    printf("hello world\n");
}
```

```c
# mainFunc
#include <stdio.h>
#include "header.h"

int main(){
    sayHello();
    return 0;
}
```

> make && run

```shell
➜  demo gcc -o main demoHeader.c header.c && ./main
hello world
```

- C语言的字符串操作

```c
#include <stdio.h>
#include <string.h>
#include <stdlib.h>
int main(){
    /*字符串的拼接 sprintf*/
    char content[100];
    //void *memset(void *s,int c,size_t n)
    //将已开辟内存空间 s 的首 n 个字节的值设为值 c
    memset(content,0,100);

    //任意类型的值拼接成字符串
    sprintf(content,"hello %s;the value is %f or %d","alicfeng",98.5,100);
    printf("%s\n",content);

    /*memcpy用来做内存拷贝*/
    char *source = "hello world";
    char des[5];
    //开始拷贝
    memcpy(des,source+6* sizeof(char),5* sizeof(char));
    printf("%s\n",des);

    /*字符串拷贝*/
    char str1[10] = "alicfeng";
    char *str2 = malloc(10);//char str2[10];也可以
    strcpy(str2,str1);
    printf("str2 value is %s\n",str2);

    return 0;
}
```

> make &run 

```shell
➜  demo gcc -o main demoString.c && ./main
hello alicfeng;the value is 98.500000 or 100
world
str2 value is alicfeng
```

- C语言的文件操作

```c
#include <stdio.h>
#include <stdlib.h>

int main() {
    /*文件的写入 覆盖式写入*/
    //打开文件
    FILE *file = fopen("log", "w");
    //判断文件是否打开失败
    if (file != NULL) {
        for (int i = 0; i < 5; fprintf(file, "%d\n", ++i)) {
            printf("写 %d 入成功\n", i+1);
        }
    }
    //关闭文件
    fclose(file);

    /*文件的写入 追加式写入*/
    FILE *fileA = fopen("log", "a+");//以追加的方式写入
    if (NULL== fileA){
        perror("open file error");
        exit(1);
    }
    fputs("alic appending",fileA);
    fclose(fileA);

    /*文件的读取*/
    FILE *fileR = fopen("log", "r");
    //获取文件的大小
    //要将指针放置文件流的最末端 参数0为偏移量
    fseek(fileR, 0, SEEK_END);
    long size = ftell(fileR);
    //创建存放内容的缓冲区 并且还想在末端添加\0, 因而调大一个字节
    char buf[size + 1];
    //重新将指针置于文件的开始位置
    fseek(fileR, 0, SEEK_SET);
    fread(buf, sizeof(unsigned char), size, fileR);
    buf[size] = '\0';
    fclose(fileR);
    printf("%s\n", buf);

    /*文件重命名*/
    int result = rename("log", "data");
    printf("文件重命名%s\n", result == 0 ? "成功" : "失败");

    /*删除文件*/
    printf("删除文件%s\n", remove("data") ? "失败" : "成功");

    return 0;
}
```

> make && run

```shell
➜  demo gcc -o main demoFile.c && ./main
写 1 入成功
写 2 入成功
写 3 入成功
写 4 入成功
写 5 入成功
1
2
3
4
5
alic appending
文件重命名成功
删除文件成功
```

- C语言小游戏

```c
#include <time.h>
#include <stdlib.h>
#include <stdio.h>

int main(){
    //设置随机数的机制 否则产生的随机数是固定的值
    srand(time(NULL));
    //随机生成两位数的int
    int randValue = rand()%100;
    int userInput;
    printf("Hello 请输入两位数:\n");
    while(1){
        scanf("%d",&userInput);
        if (userInput>randValue){
            printf("数值过大\n");
        } else if (userInput<randValue){
            printf("数值过小\n");
        } else{
            printf("恭喜您,答对了!\n");
            break;
        }
    }
    return 0;
}
```

> make && run

```shell
➜  demo gcc -o main demoGame.c && ./main
Hello 请输入两位数:
50
数值过小
75
数值过小
85
数值过大
80
数值过小
82
数值过大
81
恭喜您,答对了!
```

___
[源码地址](https://github.com/alicfeng/learncode/tree/master/clang/basic)
**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
