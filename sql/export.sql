-- Simple export (MySQL)
CREATE TABLE IF NOT EXISTS auth_user (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(191) UNIQUE,
  first_name VARCHAR(100),
  last_name VARCHAR(100),
  password VARCHAR(255),
  created_at DATETIME NULL,
  updated_at DATETIME NULL
);

CREATE TABLE IF NOT EXISTS teachers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNIQUE,
  university_name VARCHAR(191),
  gender ENUM('male','female','other') DEFAULT 'other',
  year_joined INT,
  created_at DATETIME NULL,
  updated_at DATETIME NULL,
  CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES auth_user(id) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO auth_user (email, first_name, last_name, password, created_at) VALUES
('alice@example.com','Alice','Anders','$2y$10$examplehash','2025-09-02 10:00:00'),
('bob@example.com','Bob','Baker','$2y$10$examplehash','2025-09-02 10:00:00');

INSERT INTO teachers (user_id, university_name, gender, year_joined, created_at) VALUES
(1,'University of Benin','male',2018,'2025-09-02 10:00:00'),
(2,'Ahmadu Bello University','female',2020,'2025-09-02 10:00:00');
