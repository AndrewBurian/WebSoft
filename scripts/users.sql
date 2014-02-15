CREATE TABLE IF NOT EXISTS `users` (
  `id` varchar(10) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL,
  `role` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `users` (`id`, `name`, `password`, `role`) VALUES
("Donald", "D.Duck", md5("Duck"), "Admin"),
("Mickey", "M.Mouse", md5("Mouse"), "User");