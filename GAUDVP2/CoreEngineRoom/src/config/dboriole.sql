-- phpMyAdmin SQL Dump
-- version 3.3.0
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 25, 2014 at 05:53 PM
-- Server version: 5.5.37
-- PHP Version: 5.5.12-2+deb.sury.org~precise+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `oriole`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblconsumers`
--

CREATE TABLE IF NOT EXISTS `tblconsumers` (
  `fldid`             INT(11)   NOT NULL AUTO_INCREMENT,
  `fldfirstname`      VARCHAR(255)       DEFAULT NULL,
  `fldlastname`       VARCHAR(255)       DEFAULT NULL,
  `fldemailid`        VARCHAR(255)       DEFAULT NULL,
  `fldhashedpassword` VARCHAR(255)       DEFAULT NULL,
  `fldcreateddate`    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fldmodifieddate`   TIMESTAMP NULL,
  PRIMARY KEY (`fldid`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8;


CREATE TABLE IF NOT EXISTS `tblexperts` (
  `fldid`           INT(11)      NOT NULL AUTO_INCREMENT,
  `fldfirstname`    VARCHAR(255)          DEFAULT NULL,
  `fldlastname`     VARCHAR(255)          DEFAULT NULL,
  `fldtitle`        VARCHAR(50)  NOT NULL,
  `fldavatarurl`    VARCHAR(200) NOT NULL,
  `fldisdeleted`    INT(1)       NOT NULL DEFAULT '0',
  `fldcreateddate`  TIMESTAMP    NULL     DEFAULT CURRENT_TIMESTAMP,
  `fldmodifieddate` TIMESTAMP    NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`fldid`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8;


--
-- Table structure for table `tblfavourites`
--

CREATE TABLE IF NOT EXISTS `tblfavourites` (
  `fldid`           INT(11)   NOT NULL AUTO_INCREMENT,
  `fldconsumerid`   INT(11)            DEFAULT NULL,
  `fldinsightid`    INT(11)            DEFAULT NULL,
  `fldcreateddate`  TIMESTAMP NULL,
  `fldmodifieddate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`fldid`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8;


--
-- Table structure for table `tblinsights`
--

CREATE TABLE IF NOT EXISTS `tblinsights` (
  `fldid`           INT(11)      NOT NULL AUTO_INCREMENT,
  `fldname`         VARCHAR(100) NOT NULL,
  `fldinsighturl`   VARCHAR(200) NOT NULL,
  `fldstreamingurl` VARCHAR(256) NOT NULL,
  `fldexpertid`     VARCHAR(11)  NOT NULL,
  `fldisdeleted`    INT(1)       NOT NULL DEFAULT '0',
  `fldcreateddate`  TIMESTAMP    NULL,
  `fldmodifieddate` TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`fldid`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8;


--
-- Table structure for table `tblstations`
--

CREATE TABLE IF NOT EXISTS `tblstations` (
  `fldid`           INT(11)      NOT NULL AUTO_INCREMENT,
  `fldtype`         INT(11)      NOT NULL,
  `fldreferenceid`  INT(11)      NOT NULL,
  `fldtitle`        VARCHAR(100) NOT NULL,
  `fldsubtitle`     VARCHAR(100) NOT NULL,
  `fldcreateddate`  TIMESTAMP    NULL     DEFAULT CURRENT_TIMESTAMP,
  `fldmodifieddate` TIMESTAMP    NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`fldid`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8;


CREATE TABLE IF NOT EXISTS `tbltopicinsight` (
  `fldid`        INT(11)     NOT NULL AUTO_INCREMENT,
  `fldinsightid` VARCHAR(11) NOT NULL,
  `fldtopicid`   VARCHAR(11) NOT NULL,
  PRIMARY KEY (`fldid`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8;


--
-- Table structure for table `tbltopics`
--

CREATE TABLE IF NOT EXISTS `tbltopics` (
  `fldid`           INT(11)     NOT NULL AUTO_INCREMENT,
  `fldname`         VARCHAR(50) NOT NULL,
  `fldisdeleted`    INT(1)      NOT NULL DEFAULT '0',
  `fldcreateddate`  TIMESTAMP   NULL     DEFAULT CURRENT_TIMESTAMP,
  `fldmodifieddate` TIMESTAMP   NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`fldid`),
  UNIQUE KEY `fldname` (`fldname`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8;


--
-- Table structure for table `tbluserdevices`
--

CREATE TABLE IF NOT EXISTS `tbluserdevices` (
  `fldid`             INT(11)     NOT NULL AUTO_INCREMENT,
  `flddeviceid`       VARCHAR(50) NOT NULL,
  `fldconsumerid`     INT(11)     NOT NULL,
  `fldnotificationid` INT(11)     NOT NULL,
  `fldplatformid`     INT(11)     NOT NULL,
  PRIMARY KEY (`fldid`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8;

--
-- Table structure for table `tbluser`
--

CREATE TABLE IF NOT EXISTS `tbluser` (
  `fldid`       INT(11)      NOT NULL AUTO_INCREMENT,
  `fldusername` VARCHAR(100) NOT NULL,
  `fldpassword` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`fldid`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8;


--
-- Dumping data for table `tbluser`
--

INSERT INTO `tbluser` VALUES (1, 'admin@oriole.com', 'password');
INSERT INTO `tbluser` VALUES (2, 'admin@audvisor.com', 'password');

--
-- Table structure for table `tblconsumeranalytics`
--

CREATE TABLE IF NOT EXISTS `tblconsumeranalytics` (
  `fldid`         INT(11)      NOT NULL AUTO_INCREMENT,
  `fldconsumerid` INT(10)      NOT NULL,
  `fldreceiverid` INT(10)      NOT NULL,
  `fldactionid`   INT(10)      NOT NULL,
  `fldactiondata` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`fldid`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8;

--
-- Table structure for table `tblappversioninfo`
--

CREATE TABLE IF NOT EXISTS `tblappversioninfo` (
  `fldid`                 INT(11)       NOT NULL AUTO_INCREMENT,
  `fldcreateddate`        TIMESTAMP     NULL     DEFAULT CURRENT_TIMESTAMP,
  `fldmodifieddate`       TIMESTAMP     NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fldappversion`         VARCHAR(10)   NOT NULL,
  `fldappstoreurl`        VARCHAR(100)  NOT NULL,
  `fldversiondescription` VARCHAR(1000) NOT NULL,
  `fldbundleversion`      INT(11)       NOT NULL,
  `fldmandatoryupdate`    TINYINT(1)    NOT NULL,
  PRIMARY KEY (`fldid`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8;


--
-- Modifying the table structure for table `tblinsights` to include a column to identify whether an insight should be available for public or not.
--

ALTER TABLE `tblinsights` ADD `fldisonline` INT(1) NOT NULL DEFAULT 0;
ALTER TABLE `tblinsights` ADD `fldstaticreputation` INT(2) NOT NULL DEFAULT 5;
UPDATE `tblinsights`
SET `fldisonline` = 1
WHERE `fldisdeleted` = 0;
ALTER TABLE `tblconsumers` ADD `flddevicesignup` INT(1) NOT NULL DEFAULT 0;
ALTER TABLE `tblconsumeranalytics` ADD `fldreceivertype` INT(1) NOT NULL;


--
-- Table structure for table `tbluserstations`
--

CREATE TABLE IF NOT EXISTS `tbluserstations` (
  `fldid`           INT(11)      NOT NULL AUTO_INCREMENT,
  `fldconsumerid`   INT(11)      NOT NULL,
  `fldcreateddate`  DATETIME     NOT NULL,
  `fldmodifieddate` TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fldreceiverid`   VARCHAR(200) NOT NULL,
  `fldtype`         TINYINT(1)   NOT NULL,
  PRIMARY KEY (`fldid`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8;

--
-- Table structure for table `tblpasswordreset`
--

CREATE TABLE IF NOT EXISTS `tblpasswordreset` (
  `fldtoken`      VARCHAR(255) DEFAULT NULL,
  `fldconsumerid` INT(11)      DEFAULT NULL,
  `fldtstamp`     INT(50)      DEFAULT NULL,
  PRIMARY KEY (`fldtoken`),
  FOREIGN KEY (`fldconsumerid`) REFERENCES tblconsumers (`fldid`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8;

--
-- Table structure for table `tblinsightlikes`
--

CREATE TABLE IF NOT EXISTS `tblinsightlikes` (
  `fldid`           INT(11)   NOT NULL AUTO_INCREMENT,
  `fldconsumerid`   INT(11)            DEFAULT NULL,
  `fldinsightid`    INT(11)            DEFAULT NULL,
  `fldcreateddate`  TIMESTAMP NULL     DEFAULT NULL,
  `fldmodifieddate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`fldid`),
  FOREIGN KEY (`fldconsumerid`) REFERENCES tblconsumers (`fldid`)
    ON DELETE CASCADE,
  FOREIGN KEY (`fldinsightid`) REFERENCES tblinsights (`fldid`)
    ON DELETE CASCADE
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8;


ALTER TABLE `tbltopics` ADD `fldavatarurl` VARCHAR(200) NULL;


ALTER TABLE `tblconsumeranalytics` ADD `fldcreateddate` TIMESTAMP NULL;
ALTER TABLE `tblconsumeranalytics` ADD `fldmodifieddate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;
UPDATE `tblconsumeranalytics`
SET `fldcreateddate` = now();
UPDATE `tblconsumeranalytics`
SET `fldmodifieddate` = now();


ALTER TABLE `tblappversioninfo` CHANGE `fldcreateddate` `fldcreateddate` TIMESTAMP NULL DEFAULT NULL;
ALTER TABLE `tblappversioninfo` CHANGE `fldmodifieddate` `fldmodifieddate` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE `tblconsumers` CHANGE `fldcreateddate` `fldcreateddate` TIMESTAMP NULL DEFAULT NULL;
ALTER TABLE `tblconsumers` CHANGE `fldmodifieddate` `fldmodifieddate` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE `tblexperts` CHANGE `fldcreateddate` `fldcreateddate` TIMESTAMP NULL DEFAULT NULL;
ALTER TABLE `tblexperts` CHANGE `fldmodifieddate` `fldmodifieddate` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE `tblinsights` CHANGE `fldcreateddate` `fldcreateddate` TIMESTAMP NULL DEFAULT NULL;
ALTER TABLE `tblinsights` CHANGE `fldmodifieddate` `fldmodifieddate` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE `tbltopics` CHANGE `fldcreateddate` `fldcreateddate` TIMESTAMP NULL DEFAULT NULL;
ALTER TABLE `tbltopics` CHANGE `fldmodifieddate` `fldmodifieddate` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;


ALTER TABLE `tblstations` CHANGE `fldcreateddate` `fldcreateddate` TIMESTAMP NULL DEFAULT NULL;
ALTER TABLE `tblstations` CHANGE `fldmodifieddate` `fldmodifieddate` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE `tbluserdevices` ADD `fldcreateddate` TIMESTAMP NULL DEFAULT NULL
AFTER `fldplatformid`, ADD `fldmodifieddate` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
AFTER `fldcreateddate`;

ALTER TABLE `tblexperts` ADD `flddescription` VARCHAR(1000)
CHARACTER SET utf8
COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `tbltopics` ADD `fldavatarurl_2x` VARCHAR(200) NULL DEFAULT NULL
AFTER `fldavatarurl`, ADD `fldavatarurl_3x` VARCHAR(200) NULL DEFAULT NULL
AFTER `fldavatarurl_2x`, ADD `fldavatarurl_2x_thumbnail` VARCHAR(200) NULL DEFAULT NULL
AFTER `fldavatarurl_3x`, ADD `fldavatarurl_3x_thumbnail` VARCHAR(200) NULL DEFAULT NULL
AFTER `fldavatarurl_2x_thumbnail`;
ALTER TABLE `tblexperts` ADD `fldavatarurl_2x` VARCHAR(200) NULL DEFAULT NULL, ADD `fldavatarurl_3x` VARCHAR(200) NULL DEFAULT NULL, ADD `fldavatarurl_2x_thumbnail` VARCHAR(200) NULL DEFAULT NULL, ADD `fldavatarurl_3x_thumbnail` VARCHAR(200) NULL DEFAULT NULL;
ALTER TABLE `tblexperts` MODIFY `fldtitle` VARCHAR(255);

ALTER TABLE `tblinsights` ADD `fldinsightvoiceoverurl` VARCHAR(255) NULL DEFAULT NULL
AFTER `fldstreamingurl`;
ALTER TABLE `tblexperts` ADD `fldvoiceoverurl` VARCHAR(255) NULL DEFAULT NULL
AFTER `fldavatarurl`;
ALTER TABLE `tblexperts` ADD `flds3avatarurl` VARCHAR(255) NULL DEFAULT NULL
AFTER `fldavatarurl`;

ALTER TABLE tblconsumeranalytics ADD FOREIGN KEY (fldconsumerid) REFERENCES tblconsumers (fldid)
  ON DELETE CASCADE;
ALTER TABLE `tbltopicinsight` CHANGE `fldinsightid` `fldinsightid` INT(11) NOT NULL;
ALTER TABLE tbltopicinsight ADD FOREIGN KEY (fldinsightid) REFERENCES tblinsights (fldid)
  ON DELETE CASCADE;
ALTER TABLE tblfavourites ADD FOREIGN KEY (fldconsumerid) REFERENCES tblconsumers (fldid)
  ON DELETE CASCADE;
ALTER TABLE tblfavourites ADD FOREIGN KEY (fldinsightid) REFERENCES tblinsights (fldid)
  ON DELETE CASCADE;
ALTER TABLE tbluserdevices ADD FOREIGN KEY (fldconsumerid) REFERENCES tblconsumers (fldid)
  ON DELETE CASCADE;
ALTER TABLE `tbltopicinsight` CHANGE `fldtopicid` `fldtopicid` INT(11) NOT NULL;
ALTER TABLE tbltopicinsight ADD FOREIGN KEY (fldtopicid) REFERENCES tbltopics (fldid)
  ON DELETE CASCADE;
ALTER TABLE tblinsightlikes ADD FOREIGN KEY (fldconsumerid) REFERENCES tblconsumers (fldid)
  ON DELETE CASCADE;
ALTER TABLE tblinsightlikes ADD FOREIGN KEY (fldinsightid) REFERENCES tblinsights (fldid)
  ON DELETE CASCADE;

ALTER TABLE `tblexperts` ADD `fldpromotitle` VARCHAR(255) NULL DEFAULT NULL
AFTER `fldtitle`;
ALTER TABLE `tblexperts` CHANGE `fldavatarurl_3x` `fldbioimage` VARCHAR(255) NULL DEFAULT NULL, CHANGE `fldavatarurl_2x_thumbnail` `fldthumbimage` VARCHAR(255) NULL DEFAULT NULL, CHANGE `fldavatarurl_3x_thumbnail` `fldpromoimage` VARCHAR(255) NULL DEFAULT NULL;

-- Build 46

ALTER TABLE `tbltopics` CHANGE `fldavatarurl_2x` `fldiconurl` VARCHAR(100)
CHARACTER SET utf8
COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `tbltopics` CHANGE `fldname` `fldname` VARCHAR(100)
CHARACTER SET utf8
COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `tbltopics` DROP `fldavatarurl`, DROP `fldavatarurl_3x`, DROP `fldavatarurl_2x_thumbnail`, DROP `fldavatarurl_3x_thumbnail`;

ALTER TABLE `tblexperts` ADD `fldrating` INT(3) NULL DEFAULT 50, ADD `fldweighting` INT(3) NULL DEFAULT 50;
ALTER TABLE `tblexperts` DROP `fldavatarurl`;
ALTER TABLE `tblexperts` CHANGE `fldavatarurl_2x` `fldavatarurl` VARCHAR(200)
CHARACTER SET utf8
COLLATE utf8_general_ci NULL DEFAULT NULL;

CREATE TABLE IF NOT EXISTS `tblinsightreputation` (
  `fldinsightid`        INT(5) NOT NULL,
  `fldrating`           INT(3) DEFAULT 50,
  `fldweighting`        INT(3) DEFAULT 50,
  `fldstaticreputation` INT(5) NOT NULL
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8;

ALTER TABLE `tblinsightreputation` ADD FOREIGN KEY (fldinsightid) REFERENCES tblinsights (fldid)
  ON DELETE CASCADE;

-- Migrating Old reputation
INSERT INTO `tblinsightreputation` SELECT
                                     `fldid`,
                                     `fldstaticreputation` * 10,
                                     50,
                                     `fldstaticreputation` * 500 + 2500
                                   FROM `tblinsights`;

UPDATE `tblinsightreputation`
SET `fldinsightid` = `tblinsights`.`fldid`, `fldstaticreputation` = `tblinsights`.`fldstaticreputation` * 50 + 2500,
  `fldrating`      = `tblinsights`.`fldstaticreputation`, `fldweighting` = 50;

-- Build 49
ALTER TABLE `tblexperts` DROP `fldweighting`;
ALTER TABLE `tblinsightreputation` DROP `fldweighting`, DROP `fldstaticreputation`;

CREATE TABLE IF NOT EXISTS `tblgeneralsettings` (
  `fldid`            INT(3)       NOT NULL AUTO_INCREMENT,
  `fldsettingsname`  VARCHAR(100) NOT NULL,
  `fldsettingsvalue` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`fldid`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8;

INSERT INTO `tblgeneralsettings` (`fldid`, `fldsettingsname`, `fldsettingsvalue`) VALUES
  (1, 'fldemailid', 'testber32@gmail.com'),
  (2, 'fldemailpassword', 'admin123$'),
  (3, 'fldinsightweighting', '45'),
  (4, 'fldexpertweighting', '55'),
  (5, 'fldfirstmostlistenedweight', '100'),
  (6, 'fldsecondmostlistenedweight', '90'),
  (7, 'fldthirdmostlistenedweight', '80'),
  (8, 'fldfourthmostlistenedweight', '70'),
  (9, 'fldminimumlistenedcount', '25');


ALTER TABLE `tblappversioninfo` ADD `fldplatform` INT(1) NOT NULL;

-- Build 51

ALTER TABLE `tblinsights` ADD FOREIGN KEY (fldexpertid) REFERENCES tblexperts (fldid)
  ON DELETE CASCADE;
ALTER TABLE `tbluserdevices` ADD FOREIGN KEY (fldconsumerid) REFERENCES tblconsumers (fldid)
  ON DELETE CASCADE;
ALTER TABLE `tbluserstations` ADD FOREIGN KEY (fldconsumerid) REFERENCES tblconsumers (fldid)
  ON DELETE CASCADE;
ALTER IGNORE TABLE `tbluserdevices` ADD UNIQUE (flddeviceid);

ALTER TABLE `tbluserdevices` ADD `fldendpointARN` VARCHAR(255) NULL DEFAULT NULL;

CREATE TABLE IF NOT EXISTS `tbluserdevicesnotificationsubscriptions` (
  `fldid`              INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `flduserdeviceid`    INT(11)          NOT NULL,
  `fldsubscriptionARN` VARCHAR(255)     NOT NULL DEFAULT '',
  `fldcreateddate`     TIMESTAMP        NULL     DEFAULT NULL,
  `fldmodifieddate`    TIMESTAMP        NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`fldid`),
  KEY `flduserdeviceid` (`flduserdeviceid`),
  CONSTRAINT `tbluserdevicesnotificationsubscriptions_ibfk_1` FOREIGN KEY (`flduserdeviceid`) REFERENCES `tbluserdevices` (`fldid`)
    ON DELETE CASCADE
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8;

-- Build 52

ALTER TABLE `tblinsights` ADD `fldduration` INT(4) NULL DEFAULT NULL
AFTER `fldstreamingurl`;
ALTER TABLE `tblexperts` ADD `fldlistviewimage` VARCHAR(255) NULL DEFAULT NULL
AFTER `fldpromoimage`;

-- Build 63
ALTER TABLE `tblexperts` ADD `fldprefix` VARCHAR(50) NULL DEFAULT NULL
AFTER `fldid`;
ALTER TABLE `tblinsights` CHANGE `fldduration` `fldduration` INT(6) NULL DEFAULT NULL;

ALTER TABLE `tblexperts` DROP `flds3avatarurl`;
INSERT INTO `tblgeneralsettings` (`fldid`, `fldsettingsname`, `fldsettingsvalue`)
VALUES (10, 'fldrecommendedinsightlimit', '100');

-- Build 63(2)


ALTER DATABASE audvisor
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

--

ALTER TABLE tblexperts CONVERT TO CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

ALTER TABLE tblexperts CHANGE fldprefix fldprefix VARCHAR(50)
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

ALTER TABLE tblexperts CHANGE fldfirstname fldfirstname VARCHAR(255)
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
ALTER TABLE tblexperts CHANGE fldlastname fldlastname VARCHAR(255)
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

ALTER TABLE tblexperts CHANGE fldtitle fldtitle VARCHAR(255)
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
ALTER TABLE tblexperts CHANGE fldpromotitle fldpromotitle VARCHAR(255)
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

ALTER TABLE tblexperts CHANGE flddescription flddescription VARCHAR(1000)
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

ALTER TABLE tblexperts CHANGE flds3avatarurl flds3avatarurl VARCHAR(255)
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

ALTER TABLE tblexperts CHANGE fldavatarurl fldavatarurl VARCHAR(255)
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
ALTER TABLE tblexperts CHANGE fldvoiceoverurl fldvoiceoverurl VARCHAR(255)
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
ALTER TABLE tblexperts CHANGE fldbioimage fldbioimage VARCHAR(255)
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
ALTER TABLE tblexperts CHANGE fldthumbimage fldthumbimage VARCHAR(255)
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
ALTER TABLE tblexperts CHANGE fldpromoimage fldpromoimage VARCHAR(255)
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
ALTER TABLE tblexperts CHANGE fldlistviewimage fldlistviewimage VARCHAR(255)
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;


ALTER TABLE tblgeneralsettings CONVERT TO CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

ALTER TABLE tblgeneralsettings CHANGE fldsettingsname fldsettingsname VARCHAR(100)
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
ALTER TABLE tblgeneralsettings CHANGE fldsettingsvalue fldsettingsvalue VARCHAR(255)
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

--

ALTER TABLE tblinsights CONVERT TO CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

ALTER TABLE tblinsights CHANGE fldname fldname VARCHAR(100)
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
ALTER TABLE tblinsights CHANGE fldinsighturl fldinsighturl VARCHAR(255)
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
ALTER TABLE tblinsights CHANGE fldstreamingurl fldstreamingurl VARCHAR(255)
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
ALTER TABLE tblinsights CHANGE fldinsightvoiceoverurl fldinsightvoiceoverurl VARCHAR(255)
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

--

ALTER TABLE tblpasswordreset CONVERT TO CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

ALTER TABLE tblpasswordreset CHANGE fldtoken fldtoken VARCHAR(191)
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

--

ALTER TABLE tblstations CONVERT TO CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

ALTER TABLE tblstations CHANGE fldtitle fldtitle VARCHAR(100)
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
ALTER TABLE tblstations CHANGE fldsubtitle fldsubtitle VARCHAR(100)
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

--

ALTER TABLE tbltopics CONVERT TO CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

ALTER TABLE tbltopics CHANGE fldname fldname VARCHAR(100)
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
ALTER TABLE tbltopics CHANGE fldiconurl fldiconurl VARCHAR(100)
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
--

ALTER TABLE tbluser CONVERT TO CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

ALTER TABLE tbluser CHANGE fldusername fldusername VARCHAR(100)
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
ALTER TABLE tbluser CHANGE fldpassword fldpassword VARCHAR(100)
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
--

ALTER TABLE tbluserdevices CONVERT TO CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

ALTER TABLE tbluserdevices CHANGE flddeviceid flddeviceid VARCHAR(50)
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
ALTER TABLE tbluserdevices CHANGE fldnotificationid fldnotificationid VARCHAR(512)
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
ALTER TABLE tbluserdevices CHANGE fldendpointARN fldendpointARN VARCHAR(255)
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
--

ALTER TABLE tbluserdevicesnotificationsubscriptions CONVERT TO CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

ALTER TABLE tbluserdevicesnotificationsubscriptions CHANGE fldsubscriptionARN fldsubscriptionARN VARCHAR(255)
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
--

ALTER TABLE tbluserstations CONVERT TO CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

ALTER TABLE tbluserstations CHANGE fldreceiverid fldreceiverid VARCHAR(200)
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

ALTER TABLE `tblinsights` ADD `fldstreamingfilename` VARCHAR(255) NULL DEFAULT NULL
AFTER `fldstreamingurl`;
ALTER TABLE `tblinsights` ADD `fldstreamingfilenamehlsv4` VARCHAR(255) NULL DEFAULT NULL
AFTER `fldstreamingfilename`;

-- Build 76

ALTER TABLE `tblexperts` ADD `fldtwitterhandle` VARCHAR(20) NULL DEFAULT NULL;

CREATE TABLE IF NOT EXISTS `tblcainsights` (
  `fldid`         INT(11) NOT NULL AUTO_INCREMENT,
  `fldconsumerid` INT(10) NOT NULL,
  `fldinsightid`  INT(10) NOT NULL,
  `fldcount`      INT(10) NOT NULL,
  PRIMARY KEY (`fldid`),
  KEY `fldconsumerid` (`fldconsumerid`),
  KEY `fldinsightid` (`fldinsightid`),
  CONSTRAINT `tblcainsights_ibfk_1` FOREIGN KEY (`fldconsumerid`) REFERENCES `tblconsumers` (`fldid`)
    ON DELETE CASCADE,
  CONSTRAINT `tblcainsights_ibfk_2` FOREIGN KEY (`fldinsightid`) REFERENCES `tblinsights` (`fldid`)
    ON DELETE CASCADE
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8mb4
  COLLATE =utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `tblcatopics` (
  `fldid`         INT(11) NOT NULL AUTO_INCREMENT,
  `fldconsumerid` INT(10) NOT NULL,
  `fldtopicid`    INT(10) NOT NULL,
  `fldcount`      INT(10) NOT NULL,
  PRIMARY KEY (`fldid`),
  KEY `fldconsumerid` (`fldconsumerid`),
  KEY `fldtopicid` (`fldtopicid`),
  CONSTRAINT `tblcatopics_ibfk_1` FOREIGN KEY (`fldconsumerid`) REFERENCES `tblconsumers` (`fldid`)
    ON DELETE CASCADE,
  CONSTRAINT `tblcatopics_ibfk_2` FOREIGN KEY (`fldtopicid`) REFERENCES `tbltopics` (`fldid`)
    ON DELETE CASCADE
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8mb4
  COLLATE =utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `tblcaexperts` (
  `fldid`         INT(11) NOT NULL AUTO_INCREMENT,
  `fldconsumerid` INT(10) NOT NULL,
  `fldexpertid`   INT(10) NOT NULL,
  `fldcount`      INT(10) NOT NULL,
  PRIMARY KEY (`fldid`),
  KEY `fldconsumerid` (`fldconsumerid`),
  KEY `fldexpertid` (`fldexpertid`),
  CONSTRAINT `tblcaexperts_ibfk_1` FOREIGN KEY (`fldconsumerid`) REFERENCES `tblconsumers` (`fldid`)
    ON DELETE CASCADE,
  CONSTRAINT `tblcaexperts_ibfk_2` FOREIGN KEY (`fldexpertid`) REFERENCES `tblexperts` (`fldid`)
    ON DELETE CASCADE
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8mb4
  COLLATE =utf8mb4_unicode_ci;

-- Build 78

ALTER TABLE `tblexperts` ADD `fldtwitterhandle` VARCHAR(20)
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;

-- Build 79

ALTER TABLE `tblconsumers` ADD `fldpromocodeid` INT(20) NULL DEFAULT NULL;

CREATE TABLE `tblpromocode` (
  `fldid`           INT(10)     NOT NULL AUTO_INCREMENT,
  `fldpromocode`    VARCHAR(20) NOT NULL,
  `fldstartdate`    TIMESTAMP   NULL     DEFAULT NULL,
  `fldenddate`      TIMESTAMP   NULL     DEFAULT NULL,
  `fldisdeleted`    INT(11)     NOT NULL DEFAULT '0',
  `fldcreateddate`  TIMESTAMP   NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fldmodifieddate` TIMESTAMP   NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`fldid`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8mb4
  COLLATE =utf8mb4_unicode_ci;

ALTER TABLE `tblconsumers` ADD FOREIGN KEY (`fldpromocodeid`) REFERENCES `tblpromocode` (`fldid`)
  ON DELETE RESTRICT;

-- Build 83

ALTER TABLE `tblexperts` ADD `fldfbshareimage` VARCHAR(200)
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;

-- Build 84

ALTER TABLE `tblinsights` ADD `fldfbsharedescription` VARCHAR(1000)
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;

-- Build 85

ALTER TABLE `tblinsights` CHANGE `fldfbsharedescription` `fldfbsharedescription` VARCHAR(200)
