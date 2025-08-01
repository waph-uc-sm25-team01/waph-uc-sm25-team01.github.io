drop table if exists users;

create table users(
  username varchar(50) PRIMARY KEY,
  password varchar(100) NOT NULL,
  fullname varchar(75) NOT NULL,
  email varchar(100) NOT NULL);

INSERT INTO users(username,password,fullname,email) VALUES ('travish111',md5('changeme'),'Travis Hurst','hurstts@mail.uc.edu');

drop table if exists messages;

create table messages(
  message_id varchar(50) PRIMARY KEY,
  content varchar(100) NOT NULL,
  timestamp varchar(75) NOT NULL,
  type varchar(100) NOT NULL);
  
 -- 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
