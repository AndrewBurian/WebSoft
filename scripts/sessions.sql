-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 11, 2013 at 01:56 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sessions`
--

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS  `ci_sessions` (
	session_id varchar(40) DEFAULT '0' NOT NULL,
	ip_address varchar(45) DEFAULT '0' NOT NULL,
	user_agent varchar(120) NOT NULL,
	last_activity int(10) unsigned DEFAULT 0 NOT NULL,
	user_data text NOT NULL,
	PRIMARY KEY (session_id),
	KEY `last_activity_idx` (`last_activity`)
);

--
-- Table structure for table `media`
--

CREATE TABLE IF NOT EXISTS `media` (
  `uid` int(11) NOT NULL,
  `filename` varchar(64) NOT NULL,
  `author` varchar(64) NOT NULL,
  `mdate` varchar(10) NOT NULL,
  `caption` varchar(256) NOT NULL,
  `licence` varchar(64) NOT NULL,
  `thumbnail` varchar(64) NOT NULL,
  PRIMARY KEY (`uid`,`filename`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`uid`, `filename`, `author`, `mdate`, `caption`, `licence`, `thumbnail`) VALUES
(1, 'img01.jpg', 'Who knows', '2014.09.3', 'A flower', 'CCL', 'img01.jpg'),
(2, 'img02.jpg', 'Who knows', '2014.09.2', 'A balloon', 'CCL', 'img01.jpg'),
(3, 'img03.jpg', 'Who knows', '2014.09.1', 'More than one balloon', 'CCL', 'img01.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `thumb` varchar(64) NOT NULL,
  `ptitle` varchar(64) NOT NULL,
  `pdate` varchar(10) NOT NULL,
  `tags` varchar(16) NOT NULL,
  `slug` varchar(128) NOT NULL,
  `story` text NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`uid`, `thumb`, `ptitle`, `pdate`, `tags`, `slug`, `story`) VALUES
(1, 'img01.jpg', 'The first pub', '2014.09.3', 'o', 'The waitresses were pretty but kinda slow.', '<p>Seriously, folks.  Why do so many places hire pretty girls that can pass light between their ears?</p>\r\n<p>If I want overpriced beer and pretty girls I don''t go to a pub, I go to Sammy J Peppers.</p>\r\n<p>Right now all I''m doing is filling space.</p>'),
(2, 'img02.jpg', 'The second pub', '2014.09.2', 'm', 'This one had decent food.', '<p>So we decided to eat at this one to help soak up some alchohol.  The plan was that we remember what happened this time.</p>\r\n<p>We ate and I recall that we made exclaimations over the food but we also sampled from alll 278 taps.</p>\r\n<p>Now I''m just trying to fill some space so that this looks a little more like a real post.  Yay for creative writing!</p>'),
(3, 'img03.jpg', 'Another pub', '2014.09.1', 'b', 'Another pub.', '<p>There was beer to be had and we went to drink it.</p>\r\n<p>It was good but we didn''t write anything down.  We forgot in the joy of the sweet amber elixer.</p>\r\n<p>If you want to enjoy forgetfulness, try this pub.</p>');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
