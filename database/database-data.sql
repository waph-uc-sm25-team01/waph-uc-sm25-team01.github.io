drop table if exists users;
create table users (
  username varchar(75) PRIMARY KEY,
  password varchar(100) NOT NULL,
  fullname varchar(75) NOT NULL,
  email varchar(100) NOT NULL
);

INSERT INTO users(username,password,fullname,email) VALUES ('travish111',md5('changeme'),'Travis Hurst','hurstts@mail.uc.edu');

drop table if exists posts;
create table posts (
  post_id INT AUTO_INCREMENT PRIMARY KEY,
  title varchar(75) NOT NULL,
  content varchar(250) NOT NULL,
  timestamp DATETIME NOT NULL,
  owner varchar(75),
  FOREIGN KEY (owner) REFERENCES users(username) ON DELETE CASCADE
);

drop table if exists comments;
create table comments (
  comment_id INT AUTO_INCREMENT PRIMARY KEY,
  content varchar(250) NOT NULL,
  timestamp DATETIME NOT NULL,
  post_id varchar(50),
  owner varchar(75),
  FOREIGN KEY (post_id) REFERENCES posts(post_id) ON DELETE CASCADE,
  FOREIGN KEY (owner) REFERENCES users(username) ON DELETE CASCADE
);

drop table if exists superusers;
create table superusers (
  superuser_id varchar(50),
  username varchar(75) PRIMARY KEY,
  password varchar(100) NOT NULL,
  fullname varchar(75) NOT NULL,
  email varchar(100) NOT NULL
);
