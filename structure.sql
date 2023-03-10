CREATE DATABASE IF NOT EXISTS GGMKBook;
USE GGMKBook;

CREATE TABLE authors (
	author_id INT NOT NULL AUTO_INCREMENT,
	surname VARCHAR(50) NULL,
	name VARCHAR(50) NULL,
	patronymic VARCHAR(50) NULL,
	PRIMARY KEY (author_id)
);

CREATE TABLE publishing (
	publish_id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(50) NULL,
	city VARCHAR(50) NULL,
	PRIMARY KEY (publish_id)
);

CREATE TABLE genres (
	genre_id INT NOT NULL AUTO_INCREMENT,
  genre VARCHAR(50) NULL,
	PRIMARY KEY (genre_id)
);

CREATE TABLE books (
	book_id INT NOT NULL AUTO_INCREMENT,
	author_id INT NOT NULL,
	publish_id INT NOT NULL,
	genre_id INT NOT NULL,
	name VARCHAR(50) NOT NULL,
	publish_year VARCHAR(4) NULL,
	description VARCHAR(255) NULL,
	count INT NULL,
	PRIMARY KEY (book_id),
	FOREIGN KEY (author_id) REFERENCES authors(author_id) ON DELETE CASCADE,
	FOREIGN KEY (publish_id) REFERENCES publishing(publish_id) ON DELETE CASCADE,
	FOREIGN KEY (genre_id) REFERENCES genres(genre_id) ON DELETE CASCADE
);

CREATE TABLE groups (
	group_id INT NOT NULL AUTO_INCREMENT,
	group_name VARCHAR(50) NULL,
	PRIMARY KEY (group_id)
); 

CREATE TABLE student_cards (
	student_id INT NOT NULL AUTO_INCREMENT,
	surname VARCHAR(50) NULL,
	name VARCHAR(50) NULL,
	patronymic VARCHAR(50) NULL,
	date_birth DATE NULL,
	address VARCHAR(50) NULL,
	phone VARCHAR(20) NULL,
	group_id INT NOT NULL,
	PRIMARY KEY (student_id),
	FOREIGN KEY (group_id) REFERENCES groups(group_id) ON DELETE CASCADE
); 

CREATE TABLE issued (
	issue_id INT NOT NULL AUTO_INCREMENT,
	book_id INT NOT NULL,
	student_id INT NOT NULL,
	date_give DATE NULL,
	date_return DATE NULL,
	status ENUM('Выдана', 'Возвращена', 'Потеряна') NULL DEFAULT 'Выдана',
	PRIMARY KEY (issue_id),
	FOREIGN KEY (book_id) REFERENCES books(book_id) ON DELETE CASCADE,
	FOREIGN KEY (student_id) REFERENCES student_cards(student_id) ON DELETE CASCADE,
	FOREIGN KEY (book_id) REFERENCES books(book_id) ON DELETE CASCADE
); 

CREATE TABLE librarians (
	librarian_id INT NOT NULL AUTO_INCREMENT,
	login VARCHAR(50) NOT NULL,
	password VARCHAR(255) NOT NULL,
	surname VARCHAR(50) NULL,
	name VARCHAR(50) NULL,
	patronymic VARCHAR(50) NULL,
	is_admin BOOLEAN NOT NULL DEFAULT '0',
	hash VARCHAR(255),
	UNIQUE (login),
	PRIMARY KEY (librarian_id)
);