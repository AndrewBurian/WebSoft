DROP TABLE IF EXISTS `images`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `posts`;
DROP TABLE IF EXISTS `comments`;
DROP TABLE IF EXISTS `ci_sessions`;
DROP TABLE IF EXISTS `media`;
DROP TABLE IF EXISTS `tags`;
DROP TABLE IF EXISTS `contacts`;



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
    `slug`      VARCHAR(100)    NOT NULL,
    `story`     TEXT            NULL,
    `created`   TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP,
    `updated`   TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP,
    `pic`       INT(11)         NOT NULL,
    PRIMARY KEY (`pid`),
    CONSTRAINT fk_user FOREIGN KEY (`user`) REFERENCES users(`id`),
    CONSTRAINT fk_pic FOREIGN KEY(`pic`) REFERENCES images(`iid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `tags`
(
    `pid`       INTEGER(18)     NOT NULL,
    `tag`       VARCHAR(30)     NOT NULL,
    PRIMARY KEY (`pid`, `tag`),
    CONSTRAINT fk_post FOREIGN KEY (`pid`) REFERENCES posts(`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `comments`
(
    `post`      INTEGER(18)     NOT NULL,
    `user`      VARCHAR(18)     NOT NULL,
    `time`      TIMESTAMP        NOT NULL    DEFAULT CURRENT_TIMESTAMP,
    `comment`   TEXT            NULL,
    PRIMARY KEY (`post`, `user`, `time`),
    CONSTRAINT fk_user FOREIGN KEY (`user`) REFERENCES users(`id`),
    CONSTRAINT fk_pic FOREIGN KEY(`post`) REFERENCES posts(`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE contacts 
(
`id` varchar(3) NOT NULL,
`surname` varchar(80),
`firstname` varchar(80),
`phone` varchar(80),
`email` varchar(80),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


INSERT INTO `users` (`id`, `name`, `password`, `role`, `email`, `status`, `pic`) VALUES
(1, 'ABurian', md5('AB'), 'admin', 'a@b.com', 'A', 0),
(2, 'CHolisky', md5('CH'), 'user', 'c@h.com', 'A', 0);

INSERT INTO `images` (`iid`, `filename`, `author`, `date`, `caption`, `licence`, `thumbnail`) VALUES
(1, 'img01.jpg', 'Who knows', '2014.09.3', 'A flower', 'CCL', 0),
(2, 'img02.jpg', 'Who knows', '2014.09.2', 'A balloon', 'CCL', 0),
(3, 'img03.jpg', 'Who knows', '2014.09.1', 'More than one balloon', 'CCL', 0);

INSERT INTO `posts` (`pid`, `user`, `ptitle`, `slug`, `story`, `created`, `pic`) VALUES
(1,'1', 'The first pub', 'The waitresses were pretty but kinda slow.', '<p>Seriously, folks.  Why do so many places hire pretty girls that can pass light between their ears?</p>\r\n<p>If I want overpriced beer and pretty girls I don''t go to a pub, I go to Sammy J Peppers.</p>\r\n<p>Right now all I''m doing is filling space.</p>', '2014.09.3', 1),
(2,'2', 'The second pub','This one had decent food.', '<p>So we decided to eat at this one to help soak up some alchohol.  The plan was that we remember what happened this time.</p>\r\n<p>We ate and I recall that we made exclaimations over the food but we also sampled from alll 278 taps.</p>\r\n<p>Now I''m just trying to fill some space so that this looks a little more like a real post.  Yay for creative writing!</p>', '2014.09.2', 2),
(3,'2', 'Another pub',   'Another pub.', '<p>There was beer to be had and we went to drink it.</p>\r\n<p>It was good but we didn''t write anything down.  We forgot in the joy of the sweet amber elixer.</p>\r\n<p>If you want to enjoy forgetfulness, try this pub.</p>', '2014.09.1', 3);                                                                  

INSERT INTO `tags` (`pid`, `tag`) VALUES
(1, 'test'),
(1, 'banana'),
(2, 'test'),
(2, 'apple'),
(2, 'beer');

INSERT INTO contacts (id, surname, firstname, phone, email) 
	VALUES ('MM', 'Mouse', 'Mickey', '555-1234', 'mickey@disney.com');
INSERT INTO contacts (id, surname, firstname, phone, email) 
	VALUES ('DD', 'Duck', 'Donald', '555-1444', 'donald@disney.com');
INSERT INTO contacts (id, surname, firstname, phone, email) 
	VALUES ('HRH', 'Highness', 'Her Royal', '604-555-9999', 'hrh@buckinghampalace.gov.uk');