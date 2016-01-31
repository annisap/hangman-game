/**
 * you can create the db of the app
 * by importing following sql command in to your phpmyadmin.
 * database : hangman_project
 * tables : user, game, word
*/


SET NAMES utf8;
SET time_zone = '+00:00';


CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `name_u` varchar(10) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `isAdmin` tinyint(1),
  `motto` text(50) NOT NULL,
  `age` int(11) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `name_u` (`name_u`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;




CREATE TABLE IF NOT EXISTS `word` (
  `id_w` int(11) NOT NULL AUTO_INCREMENT,
  `word_en` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `lower`TINYINT(1),
  `word_gr` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `synonym` text(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_w`),
  UNIQUE KEY `word_en` (`word_en`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



CREATE TABLE IF NOT EXISTS `game` (
  `id_g` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `id_w` int(11) NOT NULL,
  `points` smallint(6) NOT NULL,
  `insert_time` TIMESTAMP NOT NULL,
  PRIMARY KEY (`id_g`),
  FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`id_w`) REFERENCES `word` (`id_w`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



-- 2015-12-02 20:43:09