USE GGMKBook;

INSERT INTO authors (surname, name, patronymic) VALUES ('Толстой', 'Лев', 'Николаевич');
INSERT INTO authors (surname, name, patronymic) VALUES ('Достоевский', 'Федор', 'Михайлович');
INSERT INTO authors (surname, name, patronymic) VALUES ('Чехов', 'Антон', 'Павлович');
INSERT INTO authors (surname, name, patronymic) VALUES ('Пушкин', 'Александр', 'Сергеевич');
INSERT INTO authors (surname, name, patronymic) VALUES ('Гоголь', 'Николай', 'Васильевич');

INSERT INTO publishing (name, city) VALUES ('Эксмо', 'Москва');
INSERT INTO publishing (name, city) VALUES ('Азбука', 'Санкт-Петербург');
INSERT INTO publishing (name, city) VALUES ('ACT', 'Киев');
INSERT INTO publishing (name, city) VALUES ('Русич', 'Минск');
INSERT INTO publishing (name, city) VALUES ('Харвест', 'Лондон');

INSERT INTO genres (genre) VALUES ('Классическая проза');
INSERT INTO genres (genre) VALUES ('Фантастика');
INSERT INTO genres (genre) VALUES ('Детектив');
INSERT INTO genres (genre) VALUES ('Роман');
INSERT INTO genres (genre) VALUES ('Поэзия');

INSERT INTO books (author_id, publish_id, genre_id, publish_year, description, count) VALUES (1, 1, 1, '1869', 'Великий роман об истинном смысле жизни', 10);
INSERT INTO books (author_id, publish_id, genre_id, publish_year, description, count) VALUES (2, 2, 1, '1866', 'Величайшее произведение Ф. М. Достоевского, созданное под впечатлением жизни в каторжных лагерях', 5);
INSERT INTO books (author_id, publish_id, genre_id, publish_year, description, count) VALUES (3, 3, 4, '1899', 'Знаменитая повесть, отражающая жизнь русской интеллигенции конца XIX века', 7);
INSERT INTO books (author_id, publish_id, genre_id, publish_year, description, count) VALUES (4, 4, 5, '1825', 'Поэма, которая стала знаковым произведением русской литературы', 3);
INSERT INTO books (author_id, publish_id, genre_id, publish_year, description, count) VALUES (5, 5, 1, '1842', 'Шедевр, созданный Н. В. Гоголем, прославивший его как одного из величайших писателей России', 6);

INSERT INTO groups (group_name)
VALUES ('ПК-41'), ('ПСК-21'), ('ТОС-21'), ('ЛЧС-22'), ('ПК-21');

INSERT INTO student_cards (surname, name, patronymic, date_birth, address, phone, group_id)
VALUES 
('Иванов', 'Иван', 'Иванович', '2002-01-01', 'Москва, ул. Ленина 10', '111-11-11', 1),
('Петров', 'Петр', 'Петрович', '2001-02-02', 'Санкт-Петербург, пр. Невский 20', '222-22-22', 2),
('Сидоров', 'Сидор', 'Сидорович', '2003-03-03', 'Екатеринбург, ул. Гагарина 5', '333-33-33', 3),
('Васильев', 'Василий', 'Васильевич', '2000-04-04', 'Красноярск, ул. Ленина 15', '444-44-44', 4),
('Дмитриев', 'Дмитрий', 'Дмитриевич', '2004-05-05', 'Новосибирск, ул. Пушкина 25', '555-55-55', 5);

INSERT INTO issued (book_id, student_id, date_give, date_return, status)
VALUES 
(1, 1, '2022-01-01', '2022-01-31', 'Возвращена'),
(2, 2, '2022-02-01', NULL, 'Выдана'),
(3, 3, '2022-03-01', NULL, 'Выдана'),
(4, 4, '2022-04-01', '2022-04-15', 'Возвращена'),
(5, 5, '2022-05-01', NULL, 'Выдана');

INSERT INTO librarians (librarian_id, login, password, surname, name, patronymic, is_admin) VALUES
(1, 'root', 'root', NULL, NULL, NULL, 1),
(2, 'sasha', 'sasha1234', 'Таранов', 'Александр', NULL, 0);