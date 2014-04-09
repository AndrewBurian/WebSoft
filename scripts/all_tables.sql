DROP TABLE IF EXISTS `images`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `posts`;
DROP TABLE IF EXISTS `comments`;
DROP TABLE IF EXISTS `ci_sessions`;
DROP TABLE IF EXISTS `media`;
DROP TABLE IF EXISTS `tags`;
DROP TABLE IF EXISTS `contacts`;
DROP TABLE IF EXISTS `comments`;
DROP TABLE IF EXISTS `info`;


CREATE TABLE IF NOT EXISTS  `ci_sessions` (
	session_id varchar(40) DEFAULT '0' NOT NULL,
	ip_address varchar(45) DEFAULT '0' NOT NULL,
	user_agent varchar(120) NOT NULL,
	last_activity int(10) unsigned DEFAULT 0 NOT NULL,
	user_data text NOT NULL,
	PRIMARY KEY (session_id),
	KEY `last_activity_idx` (`last_activity`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `images`
(
    `iid`       INTEGER(18)     NOT NULL    AUTO_INCREMENT,
    `filename`  VARCHAR(64)     NOT NULL    UNIQUE,
    `author`    VARCHAR(64)     NULL,
    `date`      TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP,
    `caption`   VARCHAR(256)    NOT NULL,
    `licence`   VARCHAR(64)     NULL,
    `thumbnail` int(11)         NULL,
    PRIMARY KEY (`iid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `users`
(
    `id`        INTEGER(18)     NOT NULL    AUTO_INCREMENT,
    `name`      VARCHAR(40)     NOT NULL    UNIQUE,
    `password`  VARCHAR(60)     NOT NULL,
    `role`      VARCHAR(10)     NOT NULL,
    `email`     VARCHAR(40)     NOT NULL,
    `status`    VARCHAR(1)      NOT NULL,
    `pic`       int(11)         NOT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT fk_user_pic FOREIGN KEY (`pic`) REFERENCES images(`iid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `posts`
(
    `pid`       INTEGER(18)     NOT NULL    AUTO_INCREMENT,
    `user`      INTEGER(18)     NOT NULL,
    `ptitle`    VARCHAR(80)     NOT NULL    UNIQUE,
    `slug`      VARCHAR(140)    NOT NULL,
    `story`     TEXT            NULL,
    `created`   TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP,
    `updated`   TIMESTAMP       NOT NULL,
    `pic`       INT(11)         NOT NULL,
    PRIMARY KEY (`pid`),
    CONSTRAINT fk_user FOREIGN KEY (`user`) REFERENCES users(`id`),
    CONSTRAINT fk_pic FOREIGN KEY(`pic`) REFERENCES images(`iid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `comments`
(
    `cid`       INTEGER(18)     NOT NULL    AUTO_INCREMENT,
    `pid`       INTEGER(18)     NOT NULL,
    `uid`       VARCHAR(18)     NOT NULL,
    `time`      TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP,
    `text`      TEXT            NULL,
    PRIMARY KEY (`cid`),
    CONSTRAINT fk_user FOREIGN KEY (`uid`) REFERENCES users(`id`),
    CONSTRAINT fk_pic FOREIGN KEY(`pid`) REFERENCES posts(`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `tags`
(
    `pid`       INTEGER(18)     NOT NULL,
    `tag`       VARCHAR(30)     NOT NULL,
    PRIMARY KEY (`pid`, `tag`),
    CONSTRAINT fk_post FOREIGN KEY (`pid`) REFERENCES posts(`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS contacts 
(
    `id`        VARCHAR(3)      NOT NULL,
    `surname`   VARCHAR(80),
    `firstname` VARCHAR(80),
    `phone`     VARCHAR(80),
    `email`     VARCHAR(80),
    PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `info`
(
    `key`       VARCHAR(140)    NOT NULL,
    `val`       VARCHAR(140)    NOT NULL,
    PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


INSERT INTO `users` (`id`, `name`, `password`, `role`, `email`, `status`, `pic`) VALUES
(1, 'ABurian', md5('AB'), 'admin', 'a@b.com', 'A', 0),
(2, 'CHolisky', md5('CH'), 'user', 'c@h.com', 'A', 0),
(3, 'JPerry', md5('TieGuy'), 'admin', 'j@p.com', 'A', 0);

INSERT INTO `images` (`iid`, `filename`, `author`, `date`, `caption`, `licence`, `thumbnail`) VALUES
(1, 'favicon.ico', 'GVPR', '2014.03.09', 'Logo', 'CCL', 0);

INSERT INTO `posts` (`pid`, `user`, `ptitle`, `slug`, `story`, `created`, `updated`, `pic`) VALUES
(1, 1, 'Welcome!', 'Welcome to Greater Vancouver Pub Reviews!', '<p><strong>Welcome to the official Greater Vancouver Pub Reviews Site!</strong></p>\r\n\r\n<p>We hope to become your go-to source for finding a choice establishment in the Greater Vancouver area.<br />\r\nWhy chose us? We&#39;re experts! But don&#39;t just take our word for it:</p>\r\n\r\n<blockquote>\r\n<p>Vancouver Pub Reviews is the best site for quick and accurate descriptions of pubs!</p>\r\n\r\n<p>&nbsp; &nbsp;<em>- Our mothers</em></p>\r\n</blockquote>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>We hope you enjoy all that our site has to offer!</p>\r\n\r\n<p>Happy drinking!</p>\r\n', '2014-02-20 03:45:11', '2014-03-10 03:45:11', 1);

INSERT INTO `tags` (`pid`, `tag`) VALUES
(1, 'Welcome'),
(1, 'GVPR');

INSERT INTO `comments` (`time`, `uid`, `pid`, `text`) VALUES
('2014-04-08', 1, 1, 'yay!');

INSERT INTO `info` (`key`, `val`) VALUES
('name', 'Greater Vancouver Pub Reviews'),
('code', 'O07'),
('plug', 'Casual reviews of our favorite watering holes.');

INSERT INTO contacts (id, surname, firstname, phone, email) VALUES 
('MM', 'Mouse', 'Mickey', '555-1234', 'mickey@disney.com'),
('DD', 'Duck', 'Donald', '555-1444', 'donald@disney.com'),
('HRH', 'Highness', 'Her Royal', '604-555-9999', 'hrh@buckinghampalace.gov.uk');