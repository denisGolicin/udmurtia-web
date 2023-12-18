CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    middle_name VARCHAR(100),
    birth_date DATE,
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255) NOT NULL,
    mailing_address VARCHAR(255),
    event_ids JSON,
    friends_ids JSON,
    profile_photo VARCHAR(255),
    certificate_photos JSON, 
    residence_location VARCHAR(255),
    age INT,
    friend_requests_id json,
    gender ENUM('male', 'female', 'other'), 
    status ENUM('confirmed', 'removed', 'blocked', 'not_confirm', 'being_registered'),
    user_type ENUM('user', 'admin', 'organizer'),
    balance INT NOT NULL DEFAULT 0,
    phone_number VARCHAR(20) NOT NULL UNIQUE,
    auth_token VARCHAR(40), 
    code VARCHAR(10),

    modified timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);
INSERT INTO users (first_name, last_name, middle_name, birth_date, email, password, mailing_address, event_ids, friends_ids, profile_photo, certificate_photos, residence_location, age, friend_requests_id, gender, status, user_type, balance, phone_number, auth_token, code)
VALUES
    ('Иван', 'Иванов', 'Иванович', '1990-01-15', 'ivan@example.com', 'hashed_password1', 'Москва', '[]', '[]', 'profile1.jpg', '[]', 'Москва', 31, '[]', 'male', 'confirmed', 'user', 500, '+7-XXX-XXX-XX-X1', '', ''),
    ('Елена', 'Петрова', 'Сергеевна', '1985-07-25', 'elena@example.com', 'hashed_password2', 'Санкт-Петербург', '[]', '[]', 'profile2.jpg', '[]', 'Санкт-Петербург', 36, '[]', 'female', 'confirmed', 'user', 750, '+7-XXX-XXX-XX-X2', '', ''),
    ('Алексей', 'Смирнов', 'Павлович', '1995-03-10', 'alex@example.com', 'hashed_password3', 'Казань', '[]', '[]', 'profile3.jpg', '[]', 'Казань', 26, '[]', 'male', 'confirmed', 'user', 300, '+7-XXX-XXX-XX-X3', '', '');
