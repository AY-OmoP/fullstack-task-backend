-- Create database (if not exists)
CREATE DATABASE IF NOT EXISTS interview_db;
USE interview_db;

-- Drop old tables if they exist
DROP TABLE IF EXISTS teachers;
DROP TABLE IF EXISTS auth_user;

-- Create auth_user table
CREATE TABLE auth_user (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(191) UNIQUE,
  first_name VARCHAR(100),
  last_name VARCHAR(100),
  password VARCHAR(255),
  created_at DATETIME NULL,
  updated_at DATETIME NULL
);

-- Create teachers table
CREATE TABLE teachers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNIQUE,
  university_name VARCHAR(191),
  gender ENUM('male','female','other') DEFAULT 'other',
  year_joined INT,
  created_at DATETIME NULL,
  updated_at DATETIME NULL,
  CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES auth_user(id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Insert demo users (password = "password123")
INSERT INTO auth_user (email, first_name, last_name, password, created_at) VALUES
('alice@example.com','Alice','Anders','$2y$10$9ojWeA0qV1uPpPOKkF/SEe7FtdZkqZXU3NAh5ZVZazt3Rp3XIan0W','2025-09-02 10:00:00'),
('bob@example.com','Bob','Baker','$2y$10$9ojWeA0qV1uPpPOKkF/SEe7FtdZkqZXU3NAh5ZVZazt3Rp3XIan0W','2025-09-02 10:00:00');

-- Insert teachers (linked to users)
INSERT INTO teachers (user_id, university_name, gender, year_joined, created_at) VALUES
(1,'University of Benin','male',2018,'2025-09-02 10:00:00'),
(2,'Ahmadu Bello University','female',2020,'2025-09-02 10:00:00');
