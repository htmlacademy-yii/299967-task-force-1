CREATE DATABASE task_forse_wel80
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;
USE task_forse_wel80;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date_registration DATETIME NOT NULL DEFAULT NOW(),
    email CHAR(100) NOT NULL UNIQUE,
    hash CHAR(64) NOT NULL,
    name CHAR(100) NOT NULL,
    avatar CHAR(100),
    birthday DATETIME,
    description TEXT,
    city_id INT NOT NULL,
    district CHAR(100),
    phone CHAR(30),
    skype CHAR(100),
    messenger CHAR(100),
    contacts_status TINYINT NOT NULL DEFAULT 0, -- Кому показывать контакты пользователя (Всем - 0, Только заказчику - 1)
    notification_new_message TINYINT NOT NULL DEFAULT 1, -- Уведомлять - 1, Не уведомлять - 0
    notification_new_event_task TINYINT NOT NULL DEFAULT 1, -- Уведомлять - 1, Не уведомлять - 0
    notification_new_review TINYINT NOT NULL DEFAULT 1 -- Уведомлять - 1, Не уведомлять - 0
);

CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    created_at DATETIME NOT NULL DEFAULT NOW(),
    updated_at DATETIME,
    name CHAR(100) NOT NULL, -- Краткое описание задания
    description TEXT NOT NULL,
    category_id INT NOT NULL,
    location CHAR(15), -- Место проведения работ
    city_id INT,
    budget INT,
    term_execution DATETIME,
    author_id INT NOT NULL,
    status CHAR(15) NOT NULL,
    executor_id INT
);

CREATE TABLE cities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name CHAR(100) NOT NULL UNIQUE
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name CHAR(15) NOT NULL UNIQUE,
    alias CHAR(15) NOT NULL UNIQUE
);

CREATE TABLE specializations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name CHAR(15) NOT NULL UNIQUE,
    alias CHAR(15) NOT NULL UNIQUE
);

CREATE TABLE users_specializations (
    user_id INT NOT NULL,
    spec_id INT NOT NULL -- Первичный ключ специализации
);

CREATE TABLE file_list (
    id INT AUTO_INCREMENT PRIMARY KEY,
    path CHAR(100) NOT NULL,
    task_id INT NOT NULL
);

CREATE TABLE reactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    created_at DATETIME NOT NULL DEFAULT NOW(),
    message TEXT,
    servise_cost INT,
    author_id INT NOT NULL,
    task_id INT NOT NULL
);

CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    created_at DATETIME NOT NULL DEFAULT NOW(),
    message TEXT NOT NULL,
    author_id INT NOT NULL,
    recipient_id INT NOT NULL
);

CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    created_at DATETIME NOT NULL DEFAULT NOW(),
    task_is_done TINYINT NOT NULL, -- Cтатус выполненности задания (да - 1 или нет - 0)
    message TEXT,
    evaluation TINYINT,
    author_id INT NOT NULL,
    executor_id INT NOT NULL,
    task_id INT NOT NULL
);

CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    created_at DATETIME NOT NULL DEFAULT NOW(),
    event CHAR(15) NOT NULL,
    author_id INT NOT NULL,
    recipient_id INT NOT NULL,
    task_id INT NOT NULL
);
