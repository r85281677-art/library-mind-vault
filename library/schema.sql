
-- Run this in phpMyAdmin > SQL tab
CREATE DATABASE IF NOT EXISTS mindvault CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE mindvault;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  email VARCHAR(100) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  bio TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS books (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  author VARCHAR(255) NOT NULL,
  category VARCHAR(100),
  cover_url VARCHAR(255),
  file_url VARCHAR(255),
  description TEXT,
  is_free TINYINT(1) DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS library (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  book_id INT NOT NULL,
  status ENUM('reading','finished','wishlist') DEFAULT 'reading',
  progress INT DEFAULT 0,
  added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE,
  UNIQUE KEY user_book (user_id, book_id)
);

CREATE TABLE IF NOT EXISTS community_posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  content TEXT NOT NULL,
  book_id INT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS comments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  post_id INT NOT NULL,
  user_id INT NOT NULL,
  content TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (post_id) REFERENCES community_posts(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Demo books
INSERT INTO books (title, author, category, cover_url, description, is_free) VALUES
('The Midnight Library', 'Matt Haig', 'Fiction', 'https://images.unsplash.com/photo-1543002588-bfa74002ed7e?q=80&w=400', 'Between life and death there is a library...', 1),
('Atomic Habits', 'James Clear', 'Self-Help', 'https://images.unsplash.com/photo-1512820790803-83ca734da794?q=80&w=400', 'An easy way to build good habits...', 1),
('Deep Work', 'Cal Newport', 'Productivity', 'https://images.unsplash.com/photo-1532012197267-da84d127e765?q=80&w=400', 'Rules for focused success...', 0),
('The Alchemist', 'Paulo Coelho', 'Fiction', 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?q=80&w=400', 'A journey of following your dreams', 1),
('Psychology of Money', 'Morgan Housel', 'Finance', 'https://images.unsplash.com/photo-1553729459-efe14ef6055d?q=80&w=400', 'Timeless lessons on wealth', 1);
