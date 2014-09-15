
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
  reply_id INTEGER(11) NOT NULL AUTO_INCREMENT,
  user_id INTEGER(11) DEFAULT NULL,
  topic_id INTEGER(11) DEFAULT NULL,
  reply VARCHAR(1000) DEFAULT NULL,
  created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (reply_id)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=UTF8;

-- ---
-- Table topics
-- 
-- ---

DROP TABLE IF EXISTS topics;
    
CREATE TABLE topics (
  topic_id INTEGER(11) NOT NULL AUTO_INCREMENT,
  user_id INTEGER(11) DEFAULT NULL,
  topic_name VARCHAR(50) DEFAULT NULL,
  created TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  grade_level smallINTEGER(1) DEFAULT NULL,
  question VARCHAR(255) DEFAULT NULL,
  subject_category enum('Science','English','History') DEFAULT NULL,
  PRIMARY KEY (topic_id)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=UTF8;

-- ---
-- Table users
-- 
-- ---

DROP TABLE IF EXISTS users;
    
CREATE TABLE users (
  user_id INTEGER(11) NOT NULL AUTO_INCREMENT,
  username VARCHAR(30) DEFAULT NULL,
  password VARCHAR(40) DEFAULT NULL,
  name VARCHAR(40) DEFAULT NULL,
  email VARCHAR(40) DEFAULT NULL,
  grade_level smallINTEGER(1) DEFAULT NULL,
  signup_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  role tinyINTEGER(1) DEFAULT 0,
  status tinyINTEGER(1) DEFAULT 0,
  PRIMARY KEY (user_id)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=UTF8;

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
