
-- ---
-- Globals
-- ---

-- SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
-- SET FOREIGN_KEY_CHECKS=0;

-- ---
-- Table replies
-- 
-- ---

DROP TABLE IF EXISTS replies;
    
CREATE TABLE replies (
  reply_id INTEGER(6) NOT NULL AUTO_INCREMENT DEFAULT NULL,
  user_id INTEGER(4) NULL DEFAULT NULL,
  topic_id INTEGER(4) NULL DEFAULT NULL,
  reply VARCHAR(255) NULL DEFAULT NULL,
  created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (reply_id)
);

-- ---
-- Table topics
-- 
-- ---

DROP TABLE IF EXISTS topics;
    
CREATE TABLE topics (
  topic_id INTEGER(4) NOT NULL AUTO_INCREMENT DEFAULT NULL,
  user_id INTEGER(4) NULL DEFAULT NULL,
  topic VARCHAR(50) NULL DEFAULT NULL,
  created TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  grade_level INTEGER(1) NULL DEFAULT NULL,
  question VARCHAR(255) NULL DEFAULT NULL,
  subj_id ENUM('Science', 'English', 'History'),
  PRIMARY KEY (topic_id)
);

-- ---
-- Table users
-- 
-- ---

DROP TABLE IF EXISTS users;
    
CREATE TABLE users (
  user_id INTEGER(4) NOT NULL AUTO_INCREMENT DEFAULT NULL,
  username VARCHAR(30) NULL DEFAULT NULL,
  password VARCHAR(30) NULL DEFAULT NULL,
  name VARCHAR(40) NULL DEFAULT NULL,
  email VARCHAR(40) NULL DEFAULT NULL,
  grade_level INTEGER(1) NULL DEFAULT NULL,
  signup_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  role ENUM('Admin', 'User'),
  status ENUM('Clear', 'Blocked'),
  PRIMARY KEY (user_id)
);

-- ---
-- Foreign Keys 
-- ---


-- ---
-- Table Properties
-- ---

-- ALTER TABLE replies ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE topics ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE users ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE subjects ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ---
-- Test Data
-- ---

-- INSERT INTO replies (reply_id,user_id,topic_id,reply,created) VALUES
-- (,,,,);
-- INSERT INTO topics (topic_id,user_id,topic,created,grade_level,question,subj_id) VALUES
-- (,,,,,,);
-- INSERT INTO users (user_id,username,password,name,email,grade_level,signup_date,role,status) VALUES
-- (,,,,,,,,);
-- INSERT INTO subjects (subj_id,subj_name) VALUES
-- (,);
