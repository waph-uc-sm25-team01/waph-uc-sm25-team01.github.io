-- Drop in tables in correct dependency order
DROP TABLE IF EXISTS comments;
DROP TABLE IF EXISTS posts;
DROP TABLE IF EXISTS superusers;
DROP TABLE IF EXISTS users;

-- Now create all tables
CREATE TABLE users (
  username VARCHAR(75) PRIMARY KEY,
  password VARCHAR(100) NOT NULL,
  fullname VARCHAR(75) NOT NULL,
  email VARCHAR(100) NOT NULL
);

INSERT INTO users(username,password,fullname,email)
VALUES ('travish111', MD5('changeme'), 'Travis Hurst', 'hurstts@mail.uc.edu');

CREATE TABLE posts (
  post_id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(75) NOT NULL,
  content VARCHAR(250) NOT NULL,
  timestamp DATETIME NOT NULL,
  owner VARCHAR(75),
  FOREIGN KEY (owner) REFERENCES users(username) ON DELETE CASCADE
);

CREATE TABLE comments (
  comment_id INT AUTO_INCREMENT PRIMARY KEY,
  content VARCHAR(250) NOT NULL,
  timestamp DATETIME NOT NULL,
  post_id INT,
  owner VARCHAR(75),
  FOREIGN KEY (post_id) REFERENCES posts(post_id) ON DELETE CASCADE,
  FOREIGN KEY (owner) REFERENCES users(username) ON DELETE CASCADE
);

CREATE TABLE superusers (
  superuser_id VARCHAR(50),
  username VARCHAR(75) PRIMARY KEY,
  password VARCHAR(100) NOT NULL,
  fullname VARCHAR(75) NOT NULL,
  email VARCHAR(100) NOT NULL
);
