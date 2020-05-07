-- drop DATABASE new_database;
create DATABASE new_database;
use new_database;
CREATE TABLE Admin (
  `loginid` varchar(50) NOT NULL PRIMARY KEY,
  `pass` varchar(50) NOT NULL
) ;


INSERT INTO Admin VALUES
('admin', 'admin@123');


CREATE TABLE Question (
  `ques_id` int NOT NULL , 
  `test_id` int NOT NULL,
  `ques_statement` varchar(2500) NOT NULL,
  `true_ans` int NOT NULL,
    PRIMARY KEY (test_id,ques_id)  
) ;


CREATE TABLE Result (
  `user_id` varchar(20) NOT NULL,
  `test_id` int NOT NULL,
  `test_date` date NOT NULL,
  `total_question` int NOT NULL,
  `attempted` int NOT NULL,
  `correct` int NOT NULL,
  `score` int NOT NULL,
  primary Key (user_id,test_id)
) ;


 
CREATE TABLE Test (
  `test_id` int AUTO_INCREMENT,
  `loginid` varchar(30) NOT NULL,
  `Duration` int NOT NULL,
  `test_password` varchar(20) NOT NULL,
  `positive` int NOT NULL,
  `negative` int NOT NULL,
  PRIMARY KEY(test_id)
  
) ;




CREATE TABLE User (
  `user_id` varchar(20) NOT NULL PRIMARY KEY,
  `pass` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL
) ;



create table Options(
    test_id int NOT NULL,
    ques_id int NOT NULL,
    option_num int NOT NULL,
    option_statement varchar(200) NOT NULL,
    primary key(test_id,ques_id,option_num)
);



create table Question_Tables(
    test_id int NOT NULL,
    ques_id int NOT NULL,
    table_num int NOT NULL,
    row_num int NOT NULL,
    column_num int NOT NULL,
    data varchar(2000) ,
    PRIMARY KEY (test_id,ques_id,table_num,row_num,column_num)
);

--
create table Images(
    test_id int NOT NULL,
    ques_id int NOT NULL,
    img_num int NOT NULL,
    path varchar(150) NOT NULL,
    PRIMARY KEY (test_id,ques_id,img_num)
);


CREATE TABLE UserAnswer (
  `user_id` varchar(20) NOT NULL,
  `test_id` int NOT NULL,
  `ques_id` int NOT NULL,
  `user_ans` int NOT NULL,
   PRIMARY Key (user_id,test_id,ques_id) 
);
