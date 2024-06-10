CREATE TABLE users ( 
	id INT AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(255) UNIQUE NOT NULL,
	password VARCHAR(255) UNIQUE NOT NULL,
	e_code INT(4) UNIQUE NOT NULL,
	status ENUM('user', 'admin') NOT NULL,
	token VARCHAR(100) UNIQUE NOT NULL,
	deleted TINYINT(1) DEFAULT 0
);

CREATE TABLE rescripts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  number INT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  edited_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  rescript_id VARCHAR(10),
  rescript_year INT(4),
  e_code INT(4),
  e_name VARCHAR(50),
  days_number INT(2),
  from_date DATE,
  to_date DATE,
  author INT,
  deleted TINYINT(1) DEFAULT 0
);

CREATE TABLE old_rescripts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  old_id INT,
  number INT,
  created_at TIMESTAMP,
  edited_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  rescript_id VARCHAR(10),
  rescript_year INT(4),
  e_code INT(4),
  e_name VARCHAR(50),
  days_number INT(2),
  from_date DATE,
  to_date DATE,
  author VARCHAR(50)
);

INSERT INTO users SET username = "mateja", password = "$2y$10$UbPKjvoptq8wc779xvmkOeexi8..Fvb.mIEcIQpNzklcCi9NQRHYu", e_code = 1010, status = "admin", token = "Trs7V3UHSp9Ae1H4r9EOSTBfjxyxjUoAp1nII5OSYGz7aWpJkwMmCKnlY75fqNTevGqwkoseM4M3SQ3Dhz0phm1VoOxV62Iocwju"; 
