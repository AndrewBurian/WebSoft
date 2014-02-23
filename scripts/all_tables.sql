DROP TABLE IF EXISTS `images`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `posts`;
DROP TABLE IF EXISTS `comments`;

CREATE TABLE IF NOT EXISTS `images`
(
    `id`        int(11)         NOT NULL    AUTO_INCREMENT,
    `filename`  VARCHAR(64)     NOT NULL    UNIQUE,
    `author`    VARCHAR(64)     NULL,
    `date`      DATETIME        NOT NULL    DEFAULT CURRENT_TIMESTAMP,
    `caption`   VARCHAR(256)    NOT NULL,
    `licence`   VARCHAR(64)     NULL,
    `thumbnail` int(11)         NULL,
    `file`      LONGBLOB        NULL,
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
    `id`        INTEGER(11)     NOT NULL    AUTO_INCREMENT,
    `user`      VARCHAR(18)     NOT NULL,
    `title`     VARCHAR(80)     NOT NULL    UNIQUE,
    `slug`      VARCHAR(40)     NOT NULL,
    `story`     TEXT            NULL,
    `updated`   DATETIME        NOT NULL    DEFAULT CURRENT_TIMESTAMP,
    `created`   TIMESTAMP       NOT NULL,
    `pic`       INT(11)         NOT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT fk_user FOREIGN KEY (`user`) REFERENCES users(`id`),
    CONSTRAINT fk_pic FOREIGN KEY(`pic`) REFERENCES images(`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `comments`
(
    `post`      INTEGER(11)     NOT NULL,
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
(0, 'default.png', 'default', CURRENT_TIMESTAMP, 'No image', NULL, NULL, NULL);