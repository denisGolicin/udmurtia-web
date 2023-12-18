CREATE TABLE events (
    id INT PRIMARY KEY AUTO_INCREMENT, -- id мероприятия
    title VARCHAR(500) NOT NULL, -- название мероприятия
    category_id INT NOT NULL, -- id категории. берется из таблицы category_events
    start_date DATE NOT NULL, -- дата начала мероприятия
    end_date DATE NOT NULL, -- дата окончания мероприятия 
    start_time TIME NOT NULL, -- время начала мероприятия
    description TEXT NOT NULL, -- описание
    district_id INT NOT NULL, -- id района мероприятия берется из таблицы district_events
    venue VARCHAR(100) NOT NULL, -- адрес проведения мероприятия
    images JSON, -- картинки мероприятия, хранятся в папке public/events/id/image.jpg - где id это id мероприятия
    status ENUM('removed', 'published', 'hidden', 'new', 'completed') NOT NULL DEFAULT 'new', -- статус мероприятия
    last_name VARCHAR(100), -- имя организатора
    first_name VARCHAR(100), -- фамилия организатора
    middle_name VARCHAR(100), -- отчество организатора 
    post VARCHAR(100), -- должность организатора
    phone_number VARCHAR(20), -- номер телефона оргазинатора
    organization_address VARCHAR(300), -- адрес организации мероприятия
    social_links JSON, -- социальные сети, только youtube, telegram, вконтакте
    experience INT, -- опыт за мероприятие
    currency INT, -- валюта за мероприятие
    users_member JSON, -- id пользователей, которые будут как участники
    users_spectator JSON, -- id пользователей, которые будут как зрители
    evaluation_count JSON, -- json массив оценок, т.е свойства от 1 до 10, со значениями ++ которые ставят пользователи
    evaluation FLOAT, -- общая оценка мероприятия
    ticket VARCHAR(200), -- ссылка на покупку билета
    user_rated json,

    modified timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);


INSERT INTO events (title, category_id, start_date, end_date, start_time, description, district_id, venue, images, status, last_name, first_name, middle_name, post, phone_number, organization_address, social_links, experience, currency, users_member, users_spectator, evaluation_count, evaluation, ticket, user_rated)
VALUES
    ('Мероприятие 1', 1, '2023-04-15', '2023-04-15', '18:00', 'Описание мероприятия 1', 2, 'Адрес мероприятия 1', '["public/events/1/image.jpg", "public/events/1/image.jpg"]', 'new', 'Иванов', 'Алексей', 'Петрович', 'Организатор 1', '+7-XXX-XXX-XX-XX', 'Адрес организации 1', '{"youtube": "https://www.youtube.com/user/user1", "telegram": "https://t.me/user1", "vk": "https://vk.com/user1"}', 5, 1, '[1, 2, 3]', '[4, 5, 6]', '{"criterion": {"rating1": 0, "rating2": 0, "rating3": 0, "rating4": 0, "rating5": 0, "rating6": 0, "rating7": 0, "rating8": 0, "rating9": 0, "rating10": 0}}', 3.6, 'https://example.com/ticket1', '[1,2,3]'),
    ('Мероприятие 2', 2, '2023-04-20', '2023-04-25', '10:00', 'Описание мероприятия 2', 1, 'Адрес мероприятия 2', '["public/events/2/image.jpg", "public/events/1/image.jpg"]', 'published', 'Петров', 'Елена', 'Ивановна', 'Организатор 2', '+7-XXX-XXX-XX-YY', 'Адрес организации 2', '{"youtube": "https://www.youtube.com/user/user2", "telegram": "https://t.me/user2", "vk": "https://vk.com/user2"}', 8, 2, '[7, 8, 9]', '[10, 11, 12]', '{"criterion": {"rating1": 0, "rating2": 0, "rating3": 0, "rating4": 0, "rating5": 0, "rating6": 0, "rating7": 0, "rating8": 0, "rating9": 0, "rating10": 0}}', 4.2, 'https://example.com/ticket2', '[1,2,3]'),
    ('Мероприятие 3', 1, '2023-05-01', '2023-05-05', '15:30', 'Описание мероприятия 3', 3, 'Адрес мероприятия 3', '["public/events/3/image.jpg", "public/events/1/image.jpg"]', 'hidden', 'Сидоров', 'Ирина', 'Александровна', 'Организатор 3', '+7-XXX-XXX-XX-ZZ', 'Адрес организации 3', '{"youtube": "https://www.youtube.com/user/user3", "telegram": "https://t.me/user3", "vk": "https://vk.com/user3"}', 10, 3, '[13, 14, 15]', '[16, 17, 18]', '{"criterion": {"rating1": 0, "rating2": 0, "rating3": 0, "rating4": 0, "rating5": 0, "rating6": 0, "rating7": 0, "rating8": 0, "rating9": 0, "rating10": 0}}', 5.0, 'https://example.com/ticket3', '[1,2,3]'),
    ('Мероприятие 4', 2, '2023-05-10', '2023-05-15', '12:45', 'Описание мероприятия 4', 1, 'Адрес мероприятия 4', '["public/events/4/image.jpg", "public/events/1/image.jpg"]', 'completed', 'Кузнецов', 'Михаил', 'Сергеевич', 'Организатор 4', '+7-XXX-XXX-XX-XY', 'Адрес организации 4', '{"youtube": "https://www.youtube.com/user/user4", "telegram": "https://t.me/user4", "vk": "https://vk.com/user4"}', 6, 1, '[19, 20, 21]', '[22, 23, 24]', '{"criterion": {"rating1": 0, "rating2": 0, "rating3": 0, "rating4": 0, "rating5": 0, "rating6": 0, "rating7": 0, "rating8": 0, "rating9": 0, "rating10": 0}}', 4.7, 'https://example.com/ticket4', '[1,2,3]'),
    ('Мероприятие 5', 3, '2023-05-20', '2023-05-25', '14:15', 'Описание мероприятия 5', 2, 'Адрес мероприятия 5', '["public/events/5/image.jpg", "public/events/1/image.jpg"]', 'removed', 'Смирнов', 'Анна', 'Владимировна', 'Организатор 5', '+7-XXX-XXX-XX-XZ', 'Адрес организации 5', '{"youtube": "https://www.youtube.com/user/user5", "telegram": "https://t.me/user5", "vk": "https://vk.com/user5"}', 7, 2, '[25, 26, 27]', '[28, 29, 30]', '{"criterion": {"rating1": 0, "rating2": 0, "rating3": 0, "rating4": 0, "rating5": 0, "rating6": 0, "rating7": 0, "rating8": 0, "rating9": 0, "rating10": 0}}', 3.9, 'https://example.com/ticket5', '[1,2,3]'),
    ('Мероприятие 6', 1, '2023-05-30', '2023-06-03', '16:30', 'Описание мероприятия 6', 3, 'Адрес мероприятия 6', '["public/events/6/image.jpg", "public/events/1/image.jpg"]', 'new', 'Новиков', 'Ольга', 'Александровна', 'Организатор 6', '+7-XXX-XXX-XX-WW', 'Адрес организации 6', '{"youtube": "https://www.youtube.com/user/user6", "telegram": "https://t.me/user6", "vk": "https://vk.com/user6"}', 4, 3, '[31, 32, 33]', '[34, 35, 36]', '{"criterion": {"rating1": 0, "rating2": 0, "rating3": 0, "rating4": 0, "rating5": 0, "rating6": 0, "rating7": 0, "rating8": 0, "rating9": 0, "rating10": 0}}', 3.2, 'https://example.com/ticket6', '[1,2,3]');


/*=======================*/
CREATE TABLE category_events (
    id INT PRIMARY KEY AUTO_INCREMENT,
    category_name VARCHAR(100) NOT NULL
);
INSERT INTO category_events (category_name)
VALUES
    ('Музыка'),
    ('Искусство'),
    ('Спорт'),
    ('Наука'),
    ('Кино');

/*=======================*/
CREATE TABLE district_events (
    id INT PRIMARY KEY AUTO_INCREMENT,
    district_name VARCHAR(100) NOT NULL
);
INSERT INTO district_events (district_name)
VALUES
    ('Центральный район'),
    ('Северный район'),
    ('Южный район'),
    ('Западный район'),
    ('Восточный район');

