```makefile
# 指定编译工具
CC=g++
# 依赖库
LIB=-lmysqlclient \
    -I/usr/include/mysql/ \
    -L/usr/lib/mysql
    
# 64位系统编译32位程序 显示警告(Wall) g++ -Wall -g -m32
CFLAGS=-Wall -g -m32

# 目标
TARGET=demo.so

OBJ=demo.o

# 通用
$(TARGET):$(OBJ)
	$(CC) $(CFLAGS) -o $(TARGET) $(OBJ) $(LIB)

checklink:$(OBJ)
	$(CC) $(CFLAGS) -o $@ $^ $(LIB)

%.o: %.cpp
	$(CC) $(CFLAGS) $(LIB) -c -o $@ $<
%.o: %.c
	$(CC) $(CFLAGS) $(LIB) -c -o $@ $<
%.o: %.cc
	$(CC) $(CFLAGS) $(LIB) -c -o $@ $<

clean:
	rm -f $(OBJ)
	rm -f $(TARGET)
```
