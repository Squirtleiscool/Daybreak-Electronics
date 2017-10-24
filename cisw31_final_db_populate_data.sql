USE cisw31_final_db;

INSERT INTO `categories` (`catid`, `catname`) VALUES
(6, 'Computers'),
(7, 'Video Games'),
(8, 'Mobile Phones'),
(9, 'Gadgets');

INSERT INTO `products` (`productid`, `title`, `catid`, `price`, `description`) VALUES
('0672319241', 'PHP Developer''s Cookbook', 1, 39.99, 'Provides a complete, solutions-oriented guide to the challenges most often faced by PHP developers\r\nWritten specifically for experienced Web developers, the book offers real-world solutions to real-world needs\r\n'),
('0672329166', 'PHP and MySQL Web Development', 1, 49.99, 'PHP & MySQL Web Development teaches the reader to develop dynamic, secure e-commerce web sites. You will learn to integrate and implement these technologies by following real-world examples and working sample projects.'),
('067232976X', 'Sams Teach Yourself PHP, MySQL and Apache All-in-One', 1, 34.99, 'Using a straightforward, step-by-step approach, each lesson in this book builds on the previous ones, enabling you to learn the essentials of PHP scripting, MySQL databases, and the Apache web server from the ground up.'),
('A75-S213', 'Toshiba Satellite A75-S213', 6, 1499.99, 'Mobile Pentium 4 548 3.33 GHz, 1 GB RAM, 100 GB HDD'),
('BravelySecond', 'Bravely Second', 7, 39.99, 'The icon of world peace, Agnes Oblige, has been captured and imprisoned inside a floating fortress. Adventure through Luxendarc to save her in this sequel to the popular Bravely Default game. Bravely Second: End Layer is a turn-based RPG full of thrilling'),
('C-143XL', 'Gateway C-143XL', 6, 999.99, 'Intel Core 2 Duo  T8300 2.4 GHz, 4 GB RAM, 200 GB HDD'),
('E1505', 'Dell Inspiron E1505', 6, 999.99, 'Intel Core 2 Duo T7200 2.0 GHz, 1 GB RAM, 80 GB HDD'),
('Galaxys6', 'Samsung Galaxy S6', 8, 799.99, '3G network, 32GB,Android 5.0.2(Lollipop) OS'),
('N61JQ-X1', 'ASUS N61JQ-X1', 6, 999.99, 'Intel Core i7 720QM 1.60 Ghz, 4 GB RAM, 250 GB HDD');


INSERT INTO admin VALUES ('admin', sha1('admin'), 'Administrator');
INSERT INTO admin VALUES ('Michael', sha1('cisw31'), 'Standard');
