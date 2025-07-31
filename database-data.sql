drop table if exists users;
create table users(
  username varchar(50) PRIMARY KEY,
  password varchar(100) NOT NULL,
  fullname varchar(75) NOT NULL,
  email varchar(100) NOT NULL);

INSERT INTO users(username,password,fullname,email) VALUES ('admin',md5('MyPa$$w0rd'),'admin','hurstts@mail.uc.edu');
