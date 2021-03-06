<?php
/**
 * @file
 * Schema for installation.
 */

$schema = <<<SCHEMA
DROP TABLE IF EXISTS links;

DROP TABLE IF EXISTS permissions;

DROP TABLE IF EXISTS users;

DROP TABLE IF EXISTS roles;

CREATE TABLE roles (
  id int(11) unsigned NOT NULL AUTO_INCREMENT,
  title varchar(100) DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY title (title)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE permissions (
  id int(11) unsigned NOT NULL AUTO_INCREMENT,
  role int(11) unsigned DEFAULT NULL,
  can_create tinyint(1) DEFAULT '0',
  can_delete tinyint(1) DEFAULT '0',
  can_delete_own tinyint(1) DEFAULT '0',
  PRIMARY KEY (id),
  UNIQUE KEY role (role),
  CONSTRAINT permissions_role
  FOREIGN KEY (role) REFERENCES roles (id)
  ON DELETE CASCADE
  ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE users (
  id int(11) unsigned NOT NULL AUTO_INCREMENT,
  username varchar(100) DEFAULT NULL,
  password varchar(40) DEFAULT NULL,
  salt varchar(40) DEFAULT NULL,
  role int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY username (username),
  KEY users_roles (role),
  CONSTRAINT users_roles FOREIGN KEY (role) REFERENCES roles (id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE links (
  id int(11) unsigned NOT NULL AUTO_INCREMENT,
  title varchar(255) DEFAULT NULL,
  description varchar(255) DEFAULT NULL,
  url varchar(255) DEFAULT NULL,
  time int(11) DEFAULT NULL,
  uniqid varchar(40) DEFAULT NULL,
  user int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uniqid (uniqid),
  KEY links_users (user),
  CONSTRAINT links_users FOREIGN KEY (user) REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO roles (id, title)
VALUES
  (1,'Administrator'),
  (2,'User'),
  (3,'Disabled');

INSERT INTO permissions (id, role, can_create, can_delete, can_delete_own)
VALUES
  (1,1,1,1,1),
  (2,2,1,0,1),
  (3,3,0,0,0);

INSERT INTO users (id, username, password, salt, role)
VALUES
  (1,'admin','b3a71f770b2e2d49a786394ffab075af5ef6eaab','6eae9035d881508af31d07f9d8eed2a71015f960',1);

INSERT INTO links (id, title, description, url, time, uniqid, user)
VALUES
  (1,'Google.com','The most popular search engine in the world (except China).','http://google.com',1334114562,'6b367639b5ed22728d33d0af362d4d53b111abe3',1);

SCHEMA;

