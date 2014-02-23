DROP TABLE IF EXISTS `images`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `posts`;
DROP TABLE IF EXISTS `comments`;


-- To-do: Create thumbnails table

CREATE TABLE IF NOT EXISTS `images`
(
    `id`        INTEGER(18)     NOT NULL    AUTO_INCREMENT,
    `filename`  VARCHAR(64)     NOT NULL    UNIQUE,
    `author`    VARCHAR(64)     NULL,
    `date`      DATETIME        NOT NULL    DEFAULT CURRENT_TIMESTAMP,
    `caption`   VARCHAR(256)    NOT NULL,
    `licence`   VARCHAR(64)     NULL,
    `thumbnail` int(11)         NULL,
  --`file`      LONGBLOB        NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `users`
(
    `id`        INTEGER(18)     NOT NULL    AUTO_INCREMENT,
    `name`      VARCHAR(40)     NOT NULL    UNIQUE,
    `password`  VARCHAR(60)     NOT NULL,
    `role`      VARCHAR(10)     NOT NULL,
    `email`     VARCHAR(40)     NOT NULL,
    `status`    VARCHAR(1)      NOT NULL,
    `pic`       int(11)         NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT fk_user_pic FOREIGN KEY (`pic`) REFERENCES images(`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `posts`
(
    `id`        INTEGER(18)     NOT NULL    AUTO_INCREMENT,
    `user`      INTEGER(18)     NOT NULL,
    `title`     VARCHAR(80)     NOT NULL    UNIQUE,
    `slug`      VARCHAR(100)    NOT NULL,
    `story`     TEXT            NULL,
    `created`   DATETIME        NOT NULL    DEFAULT CURRENT_TIMESTAMP,
    `updated`   TIMESTAMP       NOT NULL,
    `pic`       INT(11)         NOT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT fk_user FOREIGN KEY (`user`) REFERENCES users(`id`),
    CONSTRAINT fk_pic FOREIGN KEY(`pic`) REFERENCES images(`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `comments`
(
    `post`      INTEGER(18)     NOT NULL,
    `user`      VARCHAR(18)     NOT NULL,
    `time`      DATETIME        NOT NULL    DEFAULT CURRENT_TIMESTAMP,
    `comment`   TEXT            NULL,
    PRIMARY KEY (`post`, `user`, `time`),
    CONSTRAINT fk_user FOREIGN KEY (`user`) REFERENCES users(`id`),
    CONSTRAINT fk_pic FOREIGN KEY(`post`) REFERENCES posts(`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `name`, `password`, `role`, `email`, `status`, `pic`) VALUES
(1, 'ABurian', md5('AB'), 'admin', 'a@b.com', 'A', 0),
(2, 'CHolisky', md5('CH'), 'user', 'c@h.com', 'A', 0);

INSERT INTO `images` (`id`, `filename`, `author`, `date`, `caption`, `licence`, `thumbnail`, `file`) VALUES
(1, 'img01.jpg', 'Who knows', '2014.09.3', 'A flower', 'CCL', 0, NULL),
(2, 'img02.jpg', 'Who knows', '2014.09.2', 'A balloon', 'CCL', 0, NULL),
(3, 'img03.jpg', 'Who knows', '2014.09.1', 'More than one balloon', 'CCL', 0, NULL);

INSERT INTO `posts` (`id`, `user`, `title`, `slug`, `story`, `updated`, `created`, `pic`) VALUES
(1,'1', 'The first pub', 'The waitresses were pretty but kinda slow.', '<p>Seriously, folks.  Why do so many places hire pretty girls that can pass light between their ears?</p>\r\n<p>If I want overpriced beer and pretty girls I don''t go to a pub, I go to Sammy J Peppers.</p>\r\n<p>Right now all I''m doing is filling space.</p>',  '2014.09.3',  '2014.09.3', 1),
(2,'2', 'The second pub','This one had decent food.', '<p>So we decided to eat at this one to help soak up some alchohol.  The plan was that we remember what happened this time.</p>\r\n<p>We ate and I recall that we made exclaimations over the food but we also sampled from alll 278 taps.</p>\r\n<p>Now I''m just trying to fill some space so that this looks a little more like a real post.  Yay for creative writing!</p>','2014.09.2',  '2014.09.2', 2),
(3,'2', 'Another pub',   'Another pub.', '<p>There was beer to be had and we went to drink it.</p>\r\n<p>It was good but we didn''t write anything down.  We forgot in the joy of the sweet amber elixer.</p>\r\n<p>If you want to enjoy forgetfulness, try this pub.</p>','2014.09.1',  '2014.09.1', 3);                                                                  
