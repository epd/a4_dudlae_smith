<?php
/**
 * @file
 * Schema for installation.
 */

$schema = <<<SCHEMA

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `roles` (`id`, `title`)
VALUES
  (1,'Administrator'),
  (2,'User');

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(40) DEFAULT NULL,
  `salt` varchar(40) DEFAULT NULL,
  `role` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  CONSTRAINT users_roles
  FOREIGN KEY (`role`) REFERENCES roles(`id`)
  ON UPDATE CASCADE
  ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `username`, `password`, `salt`, `role`)
VALUES
  (1,'admin','b3a71f770b2e2d49a786394ffab075af5ef6eaab','6eae9035d881508af31d07f9d8eed2a71015f960',1);

SCHEMA;
