CREATE TABLE feedback (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(100) NOT NULL,
    title VARCHAR(100) NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    message VARCHAR(1500),

    modified timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO feedback (email, title, phone_number, message) VALUES
  ('john@example.com', 'title', '+7-900-500-50-50', 'Hello World'),
  ('mary@example.com', 'title', '+7-900-500-50-50', 'This is a test message'),
  ('admin@example.com', 'title', '+7-900-500-50-50', 'Welcome to our website');
