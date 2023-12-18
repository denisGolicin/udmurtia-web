CREATE TABLE news (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(500) NOT NULL,
    category_id INT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    start_time TIME NOT NULL,
    description TEXT NOT NULL,
    source_type ENUM('external', 'internal') NOT NULL DEFAULT 'internal',
    status ENUM('removed', 'published', 'hidden', 'new') NOT NULL DEFAULT 'new',
    source_link VARCHAR(255),
    images JSON,
    event_id INT DEFAULT NULL,
    evaluation_count JSON, -- json массив оценок, т.е свойства от 1 до 10, со значениями ++ которые ставят пользователи
    evaluation FLOAT, -- общая оценка мероприятия
    user_rated json,

    modified timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO news (title, category_id, start_date, end_date, start_time, description, source_type, status, source_link, images, event_id, evaluation_count, evaluation, user_rated)
VALUES
    ('Новость 1', 1, '2023-04-15', '2023-04-15', '08:00', 'Это новость номер 1.', 'internal', 'new', NULL, '["public/news/1/news.jpg"]', NULL, '{"criterion": {"rating1": 0, "rating2": 0, "rating3": 0, "rating4": 0, "rating5": 0, "rating6": 0, "rating7": 0, "rating8": 0, "rating9": 0, "rating10": 0}}', 3.6, '[1,2,3]'),
    ('Новость 2', 2, '2023-04-16', '2023-04-18', '14:30', 'Это новость номер 2.', 'external', 'new', 'http://example.com/news2', '["public/news/2/news.jpg", "public/news/2/news.jpg"]', NULL, '{"criterion": {"rating1": 0, "rating2": 0, "rating3": 0, "rating4": 0, "rating5": 0, "rating6": 0, "rating7": 0, "rating8": 0, "rating9": 0, "rating10": 0}}', 3.6, '[1,2,3]'),
    ('Новость 3', 1, '2023-04-20', '2023-04-25', '10:00', 'Это новость номер 3.', 'internal', 'new', NULL, '["public/news/3/news.jpg", "public/news/3/news.jpg", "public/news/3/news.jpg"]', NULL, '{"criterion": {"rating1": 0, "rating2": 0, "rating3": 0, "rating4": 0, "rating5": 0, "rating6": 0, "rating7": 0, "rating8": 0, "rating9": 0, "rating10": 0}}', 3.6, '[1,2,3]'),
    ('Новость 4', 1, '2023-04-22', '2023-04-24', '09:15', 'Это новость номер 4.', 'internal', 'new', NULL, '["public/news/4/news.jpg"]', NULL, '{"criterion": {"rating1": 0, "rating2": 0, "rating3": 0, "rating4": 0, "rating5": 0, "rating6": 0, "rating7": 0, "rating8": 0, "rating9": 0, "rating10": 0}}', 3.6, '[1,2,3]'),
    ('Новость 5', 2, '2023-04-25', '2023-04-26', '16:45', 'Это новость номер 5.', 'external', 'new', 'http://example.com/news5', '["public/news/5/news.jpg", "public/news/5/news.jpg"]', NULL, '{"criterion": {"rating1": 0, "rating2": 0, "rating3": 0, "rating4": 0, "rating5": 0, "rating6": 0, "rating7": 0, "rating8": 0, "rating9": 0, "rating10": 0}}', 3.6, '[1,2,3]'),
    ('Новость 6', 1, '2023-04-27', '2023-04-28', '12:30', 'Это новость номер 6.', 'internal', 'new', NULL, '["public/news/6/news.jpg", "public/news/6/news.jpg"]', NULL, '{"criterion": {"rating1": 0, "rating2": 0, "rating3": 0, "rating4": 0, "rating5": 0, "rating6": 0, "rating7": 0, "rating8": 0, "rating9": 0, "rating10": 0}}', 3.6, '[1,2,3]'),
    ('Новость 7', 2, '2023-04-29', '2023-04-30', '14:00', 'Это новость номер 7.', 'external', 'new', 'http://example.com/news7', '["public/news/7/news.jpg"]', NULL, '{"criterion": {"rating1": 0, "rating2": 0, "rating3": 0, "rating4": 0, "rating5": 0, "rating6": 0, "rating7": 0, "rating8": 0, "rating9": 0, "rating10": 0}}', 3.6, '[1,2,3]'),
    ('Новость 8', 1, '2023-05-01', '2023-05-03', '10:20', 'Это новость номер 8.', 'internal', 'new', NULL, '["public/news/8/news.jpg", "public/news/8/news.jpg"]', NULL, '{"criterion": {"rating1": 0, "rating2": 0, "rating3": 0, "rating4": 0, "rating5": 0, "rating6": 0, "rating7": 0, "rating8": 0, "rating9": 0, "rating10": 0}}', 3.6, '[1,2,3]'),
    ('Новость 9', 1, '2023-05-04', '2023-05-06', '08:45', 'Это новость номер 9.', 'internal', 'new', NULL, '["public/news/9/news.jpg"]', NULL, '{"criterion": {"rating1": 0, "rating2": 0, "rating3": 0, "rating4": 0, "rating5": 0, "rating6": 0, "rating7": 0, "rating8": 0, "rating9": 0, "rating10": 0}}', 3.6, '[1,2,3]'),
    ('Новость 10', 2, '2023-05-07', '2023-05-10', '13:10', 'Это новость номер 10.', 'external', 'new', 'http://example.com/news10', '["public/news/10/news.jpg", "public/news/10/news.jpg"]', NULL, '{"criterion": {"rating1": 0, "rating2": 0, "rating3": 0, "rating4": 0, "rating5": 0, "rating6": 0, "rating7": 0, "rating8": 0, "rating9": 0, "rating10": 0}}', 3.6, '[1,2,3]'),
    ('Новость 11', 1, '2023-05-11', '2023-05-15', '11:30', 'Это новость номер 11.', 'internal', 'new', NULL, '["public/news/11/news.jpg", "public/news/11/news.jpg"]', NULL, '{"criterion": {"rating1": 0, "rating2": 0, "rating3": 0, "rating4": 0, "rating5": 0, "rating6": 0, "rating7": 0, "rating8": 0, "rating9": 0, "rating10": 0}}', 3.6, '[1,2,3]'),
    ('Новость 12', 2, '2023-05-16', '2023-05-18', '15:55', 'Это новость номер 12.', 'external', 'new', 'http://example.com/news12', '["public/news/12/news.jpg"]', NULL, '{"criterion": {"rating1": 0, "rating2": 0, "rating3": 0, "rating4": 0, "rating5": 0, "rating6": 0, "rating7": 0, "rating8": 0, "rating9": 0, "rating10": 0}}', 3.6, '[1,2,3]'),
    ('Новость 13', 1, '2023-05-19', '2023-05-22', '09:00', 'Это новость номер 13.', 'internal', 'new', NULL, '["public/news/13/news.jpg", "public/news/13/news.jpg"]', NULL, '{"criterion": {"rating1": 0, "rating2": 0, "rating3": 0, "rating4": 0, "rating5": 0, "rating6": 0, "rating7": 0, "rating8": 0, "rating9": 0, "rating10": 0}}', 3.6, '[1,2,3]');



/*=======================*/
CREATE TABLE category_news (
    id INT PRIMARY KEY AUTO_INCREMENT,
    category_name VARCHAR(100) NOT NULL,
    modified timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO category_news (category_name) VALUES
    ('Политика'),
    ('Спорт'),
    ('Наука и технологии'),
    ('Искусство и культура');