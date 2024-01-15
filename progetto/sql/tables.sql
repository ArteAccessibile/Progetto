
USE test2db; 

CREATE TABLE `user` (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY,
  `email` varchar(40) NOT NULL,
  `password` char(64) NOT NULL,
  `name` varchar(20) NOT NULL,
  `surname` varchar(20) NOT NULL
);

CREATE TABLE `artist` (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(11) NOT NULL,
  `alias` char(32) NOT NULL,
  `contact_mail` varchar(40) NOT NULL
);

CREATE TABLE `artwork` (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY,
  `artist_id` int(11) NOT NULL,
  `title` char(32) NOT NULL,
  `short_description` varchar(32) NOT NULL,
  `description` varchar(255) NOT NULL,
  `creation_date` date NOT NULL
);

CREATE TABLE `favourite` (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(11) NOT NULL,
  `artwork_id` int(11) NOT NULL
);