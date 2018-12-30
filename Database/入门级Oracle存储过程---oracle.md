```plsql
-- 第一个存储过程 hello world
CREATE OR REPLACE PROCEDURE sayHello
AS
  word VARCHAR2(10) := 'hello';
  BEGIN
    dbms_output.put_line(word);
  END;
--Execute
BEGIN
  sayHello();
END;


-- 创建学生表
CREATE TABLE student (
  uuid     NUMBER(6, 0) PRIMARY KEY,
  username VARCHAR2(10),
  tuition  NUMBER(6, 0)
);

-- insert values
INSERT INTO student (uuid, username, tuition) VALUES (10001, 'alic', 5000);
INSERT INTO student (uuid, username, tuition) VALUES (10002, 'feng', 8000);
SELECT *
FROM student;

-- 实现带参数的存储过程
-- 学生学费涨价100 前后的金额
CREATE OR REPLACE PROCEDURE upTuition(id IN NUMBER)
AS
  curTuition student.tuition%TYPE;
  BEGIN
    select tuition into curTuition from student where uuid=id;
    update student set tuition=tuition+1000 WHERE uuid=id;

    -- print
    DBMS_OUTPUT.PUT_LINE('before:'||curTuition||';after:'||(curTuition+1000));
  END;

--Execute
BEGIN
  upTuition(10001);
END;


-- 存储函数
-- 根据学生的id查询学生的名字
create or replace function getStuNameById(id in number)
  return varchar2
  as
  usr student.username%type;
  BEGIN
    select username into usr from student where uuid=id;
    return usr;
  END;


-- in out 参数的存储过程
-- 根据学生的uuid获取姓名和学费
create or replace procedure getStuMsg(id in number,stuName out varchar2,stuTuition out number)
  as
  begin
    select username,tuition into stuName,stuTuition from student;
  end;


-- 使用光标 包头 包体
-- 获取所有的学生的所有信息
-- 包头
CREATE OR  REPLACE PACKAGE stuPackage
  AS
  TYPE stuList IS REF CURSOR ;
  PROCEDURE queryStuList(students out stuList);
  END stuPackage;
-- 包体
CREATE OR REPLACE PACKAGE BODY stuPackage
  AS
  PROCEDURE queryStuList(students out stuList)
    AS
    BEGIN
      -- 打开光标
      OPEN students FOR SELECT * FROM student;
    END queryStuList;
  END stuPackage;
```
