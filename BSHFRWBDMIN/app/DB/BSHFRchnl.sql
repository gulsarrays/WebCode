-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 19, 2018 at 11:54 PM
-- Server version: 5.7.20-0ubuntu0.16.04.1
-- PHP Version: 7.2.0-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bfchannel_dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `ad_agency`
--

CREATE TABLE `ad_agency` (
  `ad_agency_id` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(250) NOT NULL,
  `email_id` varchar(150) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `reg_status` varchar(20) NOT NULL,
  `reject_reason` varchar(250) DEFAULT NULL,
  `login_name` varchar(110) DEFAULT NULL,
  `login_password` varchar(250) DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `modify_by` varchar(50) DEFAULT NULL,
  `is_active` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ad_payment`
--

CREATE TABLE `ad_payment` (
  `ad_payment_id` varchar(50) NOT NULL,
  `ad_process_id` varchar(50) NOT NULL,
  `tot_amount` decimal(14,2) NOT NULL,
  `paid_amount` decimal(14,2) NOT NULL,
  `payment_mode` varchar(45) NOT NULL,
  `offline_payment_type` varchar(45) DEFAULT NULL,
  `cheque_no` varchar(45) DEFAULT NULL,
  `cheque_of_bank` varchar(100) DEFAULT NULL,
  `online_transaction_no` varchar(45) DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `modify_by` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ad_process`
--

CREATE TABLE `ad_process` (
  `ad_process_id` varchar(50) NOT NULL,
  `file_name` varchar(50) DEFAULT NULL,
  `content_type` varchar(45) NOT NULL,
  `status` varchar(45) NOT NULL,
  `reject_reason` varchar(45) DEFAULT NULL,
  `is_active` char(1) NOT NULL,
  `ad_start_date` datetime NOT NULL,
  `ad_end_date` datetime NOT NULL,
  `frequency` int(11) DEFAULT NULL,
  `views_to_post` bigint(20) NOT NULL,
  `views_posted` bigint(20) DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `modify_by` varchar(50) NOT NULL,
  `content_url` varchar(250) DEFAULT NULL,
  `content_duration` varchar(45) DEFAULT NULL,
  `content_size` longtext,
  `content_thumbnail_url` longtext,
  `content_title` varchar(45) DEFAULT NULL,
  `content_description` varchar(45) DEFAULT NULL,
  `is_paid_back_amt` varchar(1) DEFAULT NULL,
  `content_text` longtext,
  `ad_link_url` longtext,
  `amount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ad_process`
--

INSERT INTO `ad_process` (`ad_process_id`, `file_name`, `content_type`, `status`, `reject_reason`, `is_active`, `ad_start_date`, `ad_end_date`, `frequency`, `views_to_post`, `views_posted`, `created_date`, `modified_date`, `modify_by`, `content_url`, `content_duration`, `content_size`, `content_thumbnail_url`, `content_title`, `content_description`, `is_paid_back_amt`, `content_text`, `ad_link_url`, `amount`) VALUES
('ba449d7a-615a-4b3c-8c7e-e34e7e49663b', NULL, 'text', 'APPROVED', NULL, 'T', '2017-11-09 00:00:00', '2017-11-11 00:00:00', 0, 100, 0, '2017-11-09 12:52:27', '2017-11-09 12:52:27', 'Radhakrishan S', '', '', '0', '', 'day1 ads', NULL, NULL, 'day ad content', 'http://localhost:8001/#/create-ads', 600),
('e56e0324-7bfc-483f-b0b3-b4d8395c4658', NULL, 'text', 'APPROVED', NULL, 'T', '2017-11-09 00:00:00', '2017-11-10 00:00:00', 0, 100, 0, '2017-11-09 15:27:32', '2017-11-09 15:27:32', 'Radhakrishan S', '', '', '0', '', 'test1', NULL, NULL, 'test1', 'http://localhost:8001/#/create-ads', 600),
('2a80aa89-1e29-4930-a2f2-d0e2bec8d9ae', NULL, 'text', 'APPROVED', NULL, 'T', '2017-11-13 00:00:00', '2017-11-30 00:00:00', 0, 10, 0, '2017-11-13 14:18:21', '2017-11-13 14:18:21', 'Radhakrishan S', '', '', '0', '', 'test advertisment', NULL, NULL, 'test', NULL, 60),
('5a516de6-ad95-4f30-8fb8-8891029ba719', NULL, 'text', 'APPROVED', NULL, 'T', '2017-11-13 00:00:00', '2017-11-13 00:00:00', 0, 10, 0, '2017-11-13 14:18:59', '2017-11-13 14:18:59', 'Radhakrishan S', '', '', '0', '', 'test', NULL, NULL, 'test', NULL, 60),
('4ac35949-48db-4045-93b4-d1542e1c5bb0', NULL, 'text', 'APPROVED', NULL, 'T', '2017-11-13 00:00:00', '2017-11-28 00:00:00', 0, 10, 0, '2017-11-13 14:19:42', '2017-11-13 14:19:42', 'Radhakrishan S', '', '', '0', '', 'test', NULL, NULL, 'text', NULL, 60),
('ad93c0eb-be7d-4d07-b383-a94239c3a5ca', NULL, 'text', 'APPROVED', NULL, 'T', '2017-11-13 00:00:00', '2017-11-14 00:00:00', 0, 100, 0, '2017-11-13 16:00:43', '2017-11-13 16:00:43', 'Radhakrishan S', '', '', '0', '', 'my addadad', NULL, NULL, 'hsghjdsgfhdsghfg', 'http://localhost:8001/#/create-ads', 600),
('6ab4dea6-12f0-4c21-9f2b-9ad93bfb0fee', NULL, 'image/jpeg', 'APPROVED', NULL, 'T', '2017-11-13 00:00:00', '2017-11-14 00:00:00', 0, 100, 0, '2017-11-13 16:11:19', '2017-11-13 16:11:19', 'Radhakrishan S', '6ab4dea6-12f0-4c21-9f2b-9ad93bfb0fee/content/6ab4dea612f04c219f2b9ad93bfb0fee.jpg', '', '33337', '6ab4dea6-12f0-4c21-9f2b-9ad93bfb0fee/thumbnails/014052e9b8754b6a80e3d656cf51f076.png', 'musiq collection', NULL, NULL, 'musiq musiq musiq musiq', 'musiqhttp://localhost:8001/#/create-ads', 500),
('dc666b13-02a7-4acb-8892-3401d2c26313', NULL, 'image/jpeg', 'APPROVED', NULL, 'T', '2017-11-13 00:00:00', '2017-11-29 00:00:00', 0, 20, 20, '2017-11-13 17:08:22', '2017-11-13 17:08:22', 'Radhakrishan S', 'dc666b13-02a7-4acb-8892-3401d2c26313/content/dc666b1302a74acb88923401d2c26313.jpg', '', '24258', 'dc666b13-02a7-4acb-8892-3401d2c26313/thumbnails/2c824944c0a24c2c811d5391433a514b.png', 'Paris', NULL, NULL, 'text', NULL, 100),
('84889a1a-2d11-41c9-9540-78e3a261d53d', NULL, 'image/jpeg', 'APPROVED', NULL, 'T', '2017-11-13 00:00:00', '2017-11-13 00:00:00', 0, 20, 0, '2017-11-13 17:09:16', '2017-11-13 17:09:16', 'Radhakrishan S', '84889a1a-2d11-41c9-9540-78e3a261d53d/content/84889a1a2d1141c9954078e3a261d53d.jpg', '', '24258', '84889a1a-2d11-41c9-9540-78e3a261d53d/thumbnails/957afa61880149599831c43f21d3dd34.png', 'Budda', NULL, NULL, 'test', NULL, 100),
('14d69f0e-3565-429e-bc85-9d16b363fa69', NULL, 'image/jpeg', 'APPROVED', NULL, 'T', '2017-11-13 00:00:00', '2017-11-13 00:00:00', 0, 100, 0, '2017-11-13 17:24:58', '2017-11-13 17:24:58', 'Radhakrishan S', '14d69f0e-3565-429e-bc85-9d16b363fa69/content/14d69f0e3565429ebc859d16b363fa69.jpg', '', '33337', '14d69f0e-3565-429e-bc85-9d16b363fa69/thumbnails/5c14e2c3a71e4b0ba0fa1a76131a233e.png', 'sdsfghjgf', NULL, NULL, 'dfghfds', 'sdfghgfd', 500),
('7ad832a3-1177-4e67-ad89-8356da8aadf6', NULL, 'image/jpeg', 'APPROVED', NULL, 'T', '2017-11-15 00:00:00', '2017-11-23 00:00:00', 0, 200, 200, '2017-11-16 11:39:10', '2017-11-16 11:39:10', 'Radhakrishan S', '7ad832a3-1177-4e67-ad89-8356da8aadf6/content/7ad832a311774e67ad898356da8aadf6.jpg', '', '33337', '7ad832a3-1177-4e67-ad89-8356da8aadf6/thumbnails/85d314432477454eacb378aa14e31cfc.png', 'Silk', NULL, NULL, 'test', 'https://www.youtube.com/watch?v=0BO67JYFeBs', 1000),
('f76e3686-0011-4967-8dc1-239ad5e948c4', NULL, 'image/jpeg', 'APPROVED', NULL, 'T', '2017-11-16 00:00:00', '2017-11-30 00:00:00', 0, 10, 0, '2017-11-16 14:39:18', '2017-11-16 14:39:18', 'Radhakrishan S', 'f76e3686-0011-4967-8dc1-239ad5e948c4/content/f76e3686001149678dc1239ad5e948c4.jpg', '', '24258', 'f76e3686-0011-4967-8dc1-239ad5e948c4/thumbnails/48e850bccece41f2b1946ff7b49bc1dd.png', 'test', NULL, NULL, 'test', 'test', 60),
('a38aeb7c-af0a-4ab8-b4c8-43536e74f292', NULL, 'audio/mpeg', 'APPROVED', NULL, 'T', '2017-11-16 00:00:00', '2017-12-01 00:00:00', 0, 11, 0, '2017-11-16 14:42:58', '2017-11-16 14:42:58', 'Radhakrishan S', 'a38aeb7c-af0a-4ab8-b4c8-43536e74f292/content/a38aeb7caf0a4ab8b4c843536e74f292.mp3', '29100.60546875 seconds', '465605', '', 'test', NULL, NULL, 'test', 'test', 66),
('7cc50275-c1b6-4c5f-8f95-98d560d269cf', NULL, 'video/mp4', 'APPROVED', NULL, 'T', '2017-11-16 00:00:00', '2017-11-24 00:00:00', 0, 9, 9, '2017-11-16 14:44:17', '2017-11-16 14:44:17', 'Radhakrishan S', '7cc50275-c1b6-4c5f-8f95-98d560d269cf/content/7cc50275c1b64c5f8f9598d560d269cf.mp4', '13.03 seconds', '9690175', '7cc50275-c1b6-4c5f-8f95-98d560d269cf/thumbnails/f6b4b714491b474f996b467ed09b3ceb.png', 'test', NULL, NULL, 'test', 'https://www.youtube.com', 36),
('c3b929c2-2637-43de-8ee5-e693afa7a76f', NULL, 'text', 'APPROVED', NULL, 'T', '2017-11-16 00:00:00', '2017-11-29 00:00:00', 0, 7, 7, '2017-11-16 15:48:17', '2017-11-16 15:48:17', 'Radhakrishan S', '', '', '0', '', 'Testingggg', NULL, NULL, 'test', 'test', 42),
('a087f028-4f53-4b35-9dc1-da64fbca397d', NULL, 'image/jpeg', 'APPROVED', NULL, 'T', '2017-11-20 00:00:00', '2017-11-30 00:00:00', 0, 500, 166, '2017-11-20 17:53:58', '2017-11-20 17:53:58', '', 'a087f028-4f53-4b35-9dc1-da64fbca397d/content/a087f0284f534b359dc1da64fbca397d.jpg', '', '24258', 'a087f028-4f53-4b35-9dc1-da64fbca397d/thumbnails/523661af8f8a41db9e7ea3801e544890.png', 'Silk', NULL, NULL, 'silk', 'https://www.youtube.com/watch?v=VNi0tIjtnZc', 2500),
('289a516b-92a4-4b99-8e11-abcd8ad3cb7e', NULL, 'text', 'APPROVED', NULL, 'T', '2017-11-20 00:00:00', '2017-11-30 00:00:00', 0, 500, 161, '2017-11-20 17:55:40', '2017-11-20 17:55:40', '', '', '', '0', '', 'Advertisement for silk', NULL, NULL, 'silk', 'https://www.youtube.com/watch?v=VNi0tIjtnZc', 3000),
('3d58d00e-fe8c-4315-a9f7-9ae695f13c80', NULL, 'video/mp4', 'APPROVED', NULL, 'T', '2017-11-20 00:00:00', '2017-11-30 00:00:00', 0, 500, 125, '2017-11-20 18:01:14', '2017-12-07 18:43:11', '919900001201', '3d58d00e-fe8c-4315-a9f7-9ae695f13c80/content/3d58d00efe8c4315a9f79ae695f13c80.mp4', '13.03 seconds', '9690175', '3d58d00e-fe8c-4315-a9f7-9ae695f13c80/thumbnails/5bacc69406034f08ab0eb36463c48f23.png', 'Video upload', NULL, NULL, 'test', 'test', 2000),
('1543ec64-2fd1-4beb-92e6-86bbd32f4a4a', NULL, 'image/jpeg', 'REJECTED', 'Rejected by Bushfire Admin', 'F', '2017-11-20 00:00:00', '2017-11-30 00:00:00', 0, 20, 13, '2017-11-20 18:24:51', '2017-12-07 18:42:14', '919900001201', '/1543ec64-2fd1-4beb-92e6-86bbd32f4a4a/content/1543ec642fd14beb92e686bbd32f4a4a.jpg', '', '24258', '/1543ec64-2fd1-4beb-92e6-86bbd32f4a4a/thumbnails/451f33668ca0432e935bd9a64a1a66f3.png', 'November 20', NULL, NULL, 'test', 'test', 100),
('987fa07d-2772-4b9c-acdf-e65e9f55c318', NULL, 'text', 'REJECTED', 'Rejected by Bushfire Admin', 'F', '2017-11-20 00:00:00', '2017-11-30 00:00:00', 0, 20, 11, '2017-11-20 18:25:52', '2017-12-07 17:51:24', '919900001201', '', '', '0', '', '20 nov', NULL, NULL, 'test', 'test', 120),
('e77d7525-d8d5-4115-8f18-437185d9296d', NULL, 'text', 'APPROVED', NULL, 'T', '2017-12-01 00:00:00', '2017-12-02 00:00:00', 0, 567000, 0, '2017-12-01 16:48:51', '2017-12-01 16:48:51', '', '', '', '0', '', 'test views', NULL, NULL, 'test', 'http://www.dgreetings.com/goodmorning/messages.html', 3402000),
('e91f3ddc-2096-442f-a943-f74a11e8bf76', NULL, 'image/jpeg', 'REJECTED', 'Rejected by Bushfire Admin', 'F', '2017-11-09 00:00:00', '2017-11-10 00:00:00', 0, 1222222, 0, '2017-12-01 16:57:41', '2017-12-07 18:40:52', '919900001201', 'e91f3ddc-2096-442f-a943-f74a11e8bf76/content/e91f3ddc2096442fa943f74a11e8bf76.jpg', '', '10590', 'e91f3ddc-2096-442f-a943-f74a11e8bf76/thumbnails/7f550a61ef2c4e80903fc5aad753ca3a.png', 'day1 ad', NULL, NULL, NULL, 'http://localhost:8001/#/create-ads', 732),
('22307959-b216-40b1-8191-2b02288149e7', NULL, 'image/jpeg', 'APPROVED', NULL, 'T', '2017-11-09 00:00:00', '2017-11-10 00:00:00', 0, 1222222, 0, '2017-12-01 17:37:44', '2017-12-01 17:37:44', 'Naveen50', '22307959-b216-40b1-8191-2b02288149e7/content/22307959b21640b181912b02288149e7.jpg', '', '10590', '22307959-b216-40b1-8191-2b02288149e7/thumbnails/f77ab3fc694143fc87c5d7858d242d72.png', 'day1 ad', NULL, NULL, NULL, 'http://localhost:8001/#/create-ads', 732),
('404800e0-2338-4f33-8eb1-efa55c208a67', NULL, 'image/jpeg', 'APPROVED', NULL, 'T', '2017-11-09 00:00:00', '2017-11-10 00:00:00', 0, 1222222, 0, '2017-12-01 17:38:13', '2017-12-08 15:26:49', '919900001201', '404800e0-2338-4f33-8eb1-efa55c208a67/content/404800e023384f338eb1efa55c208a67.jpg', '', '10590', '404800e0-2338-4f33-8eb1-efa55c208a67/thumbnails/f160d7311e774d289efcb3e8939df91c.png', 'day1 ad', NULL, NULL, NULL, 'http://localhost:8001/#/create-ads', 732),
('521651bd-1f19-4683-8fff-6f3dfe86499b', NULL, 'text', 'APPROVED', NULL, 'T', '2017-12-01 00:00:00', '2017-12-15 00:00:00', 0, 2, 0, '2017-12-01 18:39:13', '2017-12-01 18:39:13', '', '', '', '0', '', 'fgdgfddf', NULL, NULL, 'sadas', 'dasd', 12),
('688a3f17-1cc5-432c-a65a-29d844f54638', NULL, 'text', 'APPROVED', NULL, 'T', '2017-12-01 00:00:00', '2017-12-06 00:00:00', 0, 1, 0, '2017-12-01 18:51:00', '2017-12-08 12:43:22', '919900001201', '', '', '0', '', 'ewrtryt', NULL, NULL, 'fdg', 'fvdb', 6),
('2b0668e7-3ad6-4514-9bd8-df3500b98f9d', NULL, 'image/jpeg', 'APPROVED', NULL, 'T', '2017-11-09 00:00:00', '2017-11-10 00:00:00', 0, 22, 0, '2017-12-01 19:29:19', '2017-12-01 19:29:19', 'Kenya shilpa', '2b0668e7-3ad6-4514-9bd8-df3500b98f9d/content/2b0668e73ad645149bd8df3500b98f9d.jpg', '', '10590', '2b0668e7-3ad6-4514-9bd8-df3500b98f9d/thumbnails/040c2a8033614cca92ca2de421b2e1a4.png', 'day1 ad', NULL, NULL, NULL, 'http://localhost:8001/#/create-ads', 732),
('9c0952f8-ed1c-4c1b-adfd-cf0ab8c717b5', NULL, 'text', 'APPROVED', NULL, 'T', '2017-12-01 00:00:00', '2017-12-02 00:00:00', 0, 12, 0, '2017-12-01 19:41:43', '2017-12-08 15:33:09', '919900001201', '', '', '0', '', 'sdfghjkjgfdsa aaaaa', NULL, NULL, 'asdfghjk', 'ASDFGHJK', 72),
('d3ec2abc-a6d1-4ba6-a98a-874f69788dda', NULL, 'text', 'REJECTED', 'Rejected by Bushfire Admin', 'F', '2017-12-01 00:00:00', '2017-12-15 00:00:00', 0, 20, 0, '2017-12-01 19:44:49', '2017-12-08 12:43:08', '919900001201', '', '', '0', '', 'aaaaaaaaaaaaaaa', NULL, NULL, 'asdfgh', 'asdfghjkh', 120),
('8bb2edc7-75e4-4c08-a24a-fedefef919a6', NULL, 'text', 'REJECTED', 'Rejected by Bushfire Admin', 'F', '2017-12-07 00:00:00', '2017-12-13 00:00:00', 0, 122, 0, '2017-12-07 18:27:54', '2017-12-08 15:33:03', '919900001201', '', '', '0', '', 'new year eve', NULL, NULL, 'test', 'test', 732),
('002fda15-5d1d-4b1f-bb9b-f608bbfa9db1', NULL, 'text', 'REJECTED', 'Rejected by Bushfire Admin', 'F', '2017-12-07 00:00:00', '2017-12-22 00:00:00', 0, 200, 0, '2017-12-07 18:47:56', '2017-12-08 15:32:59', '919900001201', '', '', '0', '', 'dec 123', NULL, NULL, 'saafdg', 'dfgdhgf', 1200),
('228294a4-4633-489a-b421-4fe7e13bdda8', NULL, 'text', 'REJECTED', 'Rejected by Bushfire Admin', 'F', '2017-12-08 00:00:00', '2017-12-09 00:00:00', 0, 200, 0, '2017-12-08 12:45:07', '2017-12-08 15:32:55', '919900001201', '', '', '0', '', 'test1', NULL, NULL, 'jhjg', 'jhg', 1200),
('377b9c39-25a2-40d6-bd6b-7a19075c72f4', NULL, 'text', 'REJECTED', 'Rejected by Bushfire Admin', 'F', '2017-12-01 00:00:00', '2017-12-30 00:00:00', 0, 11, 0, '2017-12-08 15:31:51', '2017-12-08 15:32:47', '919900001201', '', '', '0', '', 'aaaaaaaaaaaaaaaaaaaaa', NULL, NULL, 'asadsaf', 'sfadfd', 66),
('710c72cb-3393-41c4-aa4a-03db8ae7fc7f', NULL, 'image/jpeg', 'APPROVED', NULL, 'T', '2017-12-08 00:00:00', '2017-12-29 00:00:00', 0, 22, 0, '2017-12-08 15:34:27', '2017-12-18 12:07:27', '91123123456456', '710c72cb-3393-41c4-aa4a-03db8ae7fc7f/content/710c72cb339341c4aa4a03db8ae7fc7f.jpg', '', '33337', '710c72cb-3393-41c4-aa4a-03db8ae7fc7f/thumbnails/0c24b02f615d4d35b86ba2f2910aca2c.png', 'approve add new year', NULL, NULL, 'sdfsdf', 'fdsf', 110),
('a7425923-57f3-404c-a80a-06b7c3f8b78f', NULL, 'text', 'APPROVED', NULL, 'F', '2017-12-08 00:00:00', '2017-12-29 00:00:00', 0, 111, 0, '2017-12-08 15:43:40', '2017-12-14 01:03:53', '91456565878123', '', '', '0', '', 'friday release', NULL, NULL, 'test', 'test', 666),
('6b8ee1b1-acb9-4e3f-8125-541fc135c9c3', NULL, 'text', 'APPROVED', NULL, 'T', '2017-12-08 00:00:00', '2017-12-27 00:00:00', 0, 111, 0, '2017-12-08 16:01:23', '2017-12-18 13:09:28', '91456565878123', '', '', '0', '', 'chirstmasss', NULL, NULL, 'sdsafdsf', 'sfdsfdsg', 666),
('867fe386-ebba-462f-8854-af76d56a1875', NULL, 'text', 'REJECTED', 'Rejected by Bushfire Admin', 'F', '2017-12-08 00:00:00', '2017-12-16 00:00:00', 0, 22, 0, '2017-12-08 16:45:04', '2017-12-14 01:07:58', '91456565878123', '', '', '0', '', 'hey1', NULL, NULL, 'sdsdfdsf', 'sdsfds', 110),
('4c27db81-2a84-4b1d-9595-030e918960b5', NULL, 'text', 'APPROVED', NULL, 'T', '2017-12-15 00:00:00', '2017-12-27 00:00:00', 0, 22, 0, '2017-12-08 16:45:35', '2017-12-08 16:46:11', '919900001201', '', '', '0', '', 'heyy22', NULL, NULL, 'fghjwert', 'sedtryuert', 132),
('cd9dbb8c-1393-4b56-a4b3-7d7e592c80d2', NULL, 'text', 'IN_PROGRESS', NULL, 'F', '2017-10-30 00:00:00', '2017-11-22 00:00:00', 0, 22, 0, '2017-12-08 17:36:34', '2017-12-08 17:36:34', '', '', '', '0', '', 'ghhfhgfg', NULL, NULL, 'hhjgh', 'gfghfgh', 132),
('deba7ae1-005b-4a22-becb-54e20f455df6', NULL, 'text', 'IN_PROGRESS', NULL, 'F', '2017-12-15 00:00:00', '2017-12-29 00:00:00', 0, 100, 0, '2017-12-15 17:58:15', '2017-12-15 17:58:15', '', '', '', '0', '', 'test ad', NULL, NULL, 'test', 'test', 600),
('e6120330-baad-491a-a034-d1186d57d4fd', NULL, 'text', 'APPROVED', NULL, 'T', '2017-12-20 00:00:00', '2018-01-25 00:00:00', 0, 123, 0, '2017-12-15 17:59:52', '2017-12-15 18:03:52', '919900001201', '', '', '0', '', 'devi devi', NULL, NULL, 'sfsdfdg', 'dsffgfhg', 738),
('9e849aa1-6026-4f2a-ab37-0602e9295f56', NULL, 'text', 'IN_PROGRESS', NULL, 'F', '2017-12-15 00:00:00', '2017-12-30 00:00:00', 0, 111, 0, '2017-12-15 18:16:31', '2017-12-15 18:16:31', '', '', '', '0', '', 'ad prob prob', NULL, NULL, 'wsdfgh', 'asdfgh', 666),
('c86229c8-9bff-4a71-9bc4-50e1fb68914a', NULL, 'image/jpeg', 'IN_PROGRESS', NULL, 'F', '2017-12-18 00:00:00', '2017-12-20 00:00:00', 0, 11, 0, '2017-12-18 16:50:59', '2017-12-18 16:50:59', '', 'c86229c8-9bff-4a71-9bc4-50e1fb68914a/content/c86229c89bff4a719bc450e1fb68914a.jpg', '', '33337', 'c86229c8-9bff-4a71-9bc4-50e1fb68914a/thumbnails/964f0f49652d4d3abbdb4a9ba5cb1438.png', 'test112', NULL, NULL, 'gfghf', 'hgfgfghfg', 275),
('e697910d-f89b-48cb-875c-2258e6cc6924', NULL, 'audio/mpeg', 'IN_PROGRESS', NULL, 'F', '2017-12-18 00:00:00', '2017-12-19 00:00:00', 0, 122, 0, '2017-12-18 16:52:10', '2017-12-18 16:52:10', '', 'e697910d-f89b-48cb-875c-2258e6cc6924/content/e697910df89b48cb875c2258e6cc6924.mp3', '307640.15625 seconds', '4940384', '', 'test audio', NULL, NULL, 'mhjh', 'jkhkjh', 854),
('e4b091bb-28d1-48dc-ae69-f6258dd9dc00', NULL, 'text', 'APPROVED', NULL, 'T', '2018-01-19 00:00:00', '2018-02-22 00:00:00', 0, 23, 0, '2018-01-19 16:34:33', '2018-01-19 16:35:00', '919900001201', '', '', '0', '', 'feb ad', NULL, NULL, 'test test ad', 'http://localhost:8001/#/create-ads', 138),
('a84db697-00d9-45da-b75e-31b17de90dde', NULL, 'image/jpeg', 'APPROVED', NULL, 'T', '2018-01-19 00:00:00', '2018-01-25 00:00:00', 0, 22, 0, '2018-01-19 16:36:20', '2018-01-19 16:36:32', '919900001201', 'a84db697-00d9-45da-b75e-31b17de90dde/content/a84db69700d945dab75e31b17de90dde.jpg', '', '33337', 'a84db697-00d9-45da-b75e-31b17de90dde/thumbnails/9b9a3d59440142c393f9b36a696b5dc4.png', 'test img', NULL, NULL, 'test', 'tetsts', 550),
('068f2ac3-6189-4318-954f-f52810b80428', NULL, 'image/jpeg', 'APPROVED', NULL, 'T', '2018-01-19 00:00:00', '2018-02-23 00:00:00', 0, 23, 0, '2018-01-19 18:10:59', '2018-01-19 18:11:12', '919900001201', '068f2ac3-6189-4318-954f-f52810b80428/content/068f2ac361894318954ff52810b80428.jpg', '', '33337', '068f2ac3-6189-4318-954f-f52810b80428/thumbnails/d8bc4649c277439bb0811d16ab28e212.png', 'multi values', NULL, NULL, 'asdfghjm', 'aasdfghjk', 575);

-- --------------------------------------------------------

--
-- Table structure for table `ad_process_age_group`
--

CREATE TABLE `ad_process_age_group` (
  `ad_process_age_group_id` varchar(50) NOT NULL,
  `ad_process_id` varchar(50) NOT NULL,
  `age_group_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ad_process_age_group`
--

INSERT INTO `ad_process_age_group` (`ad_process_age_group_id`, `ad_process_id`, `age_group_id`) VALUES
('01d76832-9847-4ce4-b8cb-56d62b5ddaab', '867fe386-ebba-462f-8854-af76d56a1875', '67204d54-7481-441d-a49a-898edd5218a3'),
('082e00d8-119f-4311-9436-cb145b591e10', '84889a1a-2d11-41c9-9540-78e3a261d53d', '67097bbf-78ce-4c92-bde9-91d436857bfd'),
('08ce998e-ee64-4f62-8410-0a4cb57945ea', '7cc50275-c1b6-4c5f-8f95-98d560d269cf', '4a1dbdba-bfe9-4f6c-9e80-43d1ccf7886f'),
('0a9d1f40-3e67-46a7-854d-8c06c62fb3d8', '377b9c39-25a2-40d6-bd6b-7a19075c72f4', '67097bbf-78ce-4c92-bde9-91d436857bfd'),
('0ac31747-d065-4387-a3d0-b55ac41097b6', '404800e0-2338-4f33-8eb1-efa55c208a67', 'ec6fa0cd-5e1c-47b4-8d26-33811469abd9'),
('0ae947f3-a378-434e-9f25-6eed92923237', '289a516b-92a4-4b99-8e11-abcd8ad3cb7e', 'd2020239-2689-4cdf-8c53-7bf480956c6e'),
('0be23352-5ceb-4e83-b451-5b897b64d4f2', 'e91f3ddc-2096-442f-a943-f74a11e8bf76', '8d71e6f3-73f8-40d2-a2c5-3eb32e725ca9'),
('0f16f6e4-5cab-4d69-8519-0ec9b69cc9ed', 'e77d7525-d8d5-4115-8f18-437185d9296d', '0261626e-5d8f-4a57-9afc-105a56955bcd'),
('15470499-edc6-4121-9067-cc44f9dde64d', '068f2ac3-6189-4318-954f-f52810b80428', '0261626e-5d8f-4a57-9afc-105a56955bcd'),
('1594e856-834e-4147-b8f0-796f5c821284', 'ad93c0eb-be7d-4d07-b383-a94239c3a5ca', '8d71e6f3-73f8-40d2-a2c5-3eb32e725ca9'),
('163d5691-d46c-4f3c-bd7a-d899b8aa5d89', '3d58d00e-fe8c-4315-a9f7-9ae695f13c80', '156bcba5-03d4-4b00-b3c0-b44974239fa4'),
('1879c682-47d5-4184-9060-889ff2f55025', '14d69f0e-3565-429e-bc85-9d16b363fa69', '8d71e6f3-73f8-40d2-a2c5-3eb32e725ca9'),
('1e178756-c45b-43bc-a2f8-6db1c21fe2cf', '22307959-b216-40b1-8191-2b02288149e7', 'ec6fa0cd-5e1c-47b4-8d26-33811469abd9'),
('22ba2ac9-8efa-4fa8-96f5-27a7489338fc', '3d58d00e-fe8c-4315-a9f7-9ae695f13c80', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('22d5a370-3b58-4aa0-a2f9-91671f38006a', 'cd9dbb8c-1393-4b56-a4b3-7d7e592c80d2', 'ec6fa0cd-5e1c-47b4-8d26-33811469abd9'),
('247ff263-5ea3-450c-a286-9ed60645f453', '3d58d00e-fe8c-4315-a9f7-9ae695f13c80', 'ec6fa0cd-5e1c-47b4-8d26-33811469abd9'),
('25b143a2-1e7a-48dd-8651-fb07fa4acb8b', '987fa07d-2772-4b9c-acdf-e65e9f55c318', '156bcba5-03d4-4b00-b3c0-b44974239fa4'),
('2638ec56-15bc-4a58-977f-e730ac441d68', '289a516b-92a4-4b99-8e11-abcd8ad3cb7e', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('2a34c5d9-7c5c-46d6-87d0-acf6325a0668', 'dc666b13-02a7-4acb-8892-3401d2c26313', '0261626e-5d8f-4a57-9afc-105a56955bcd'),
('2cb71721-028d-4167-b961-af60e784a769', '2a80aa89-1e29-4930-a2f2-d0e2bec8d9ae', 'ec6fa0cd-5e1c-47b4-8d26-33811469abd9'),
('2d6d48d0-ac6e-42d2-aa9d-1a1482523591', 'e91f3ddc-2096-442f-a943-f74a11e8bf76', '0261626e-5d8f-4a57-9afc-105a56955bcd'),
('309d5d75-e3cf-4c31-b77c-e53180533f66', '289a516b-92a4-4b99-8e11-abcd8ad3cb7e', '0261626e-5d8f-4a57-9afc-105a56955bcd'),
('316d3586-bb2e-446e-ad2b-4be7f14a6bed', '3d58d00e-fe8c-4315-a9f7-9ae695f13c80', '9d39994a-000f-4bf1-858c-a89012184dc3'),
('31d9d310-1c79-416e-a72a-30d3e2ccf47d', '9c0952f8-ed1c-4c1b-adfd-cf0ab8c717b5', '8d71e6f3-73f8-40d2-a2c5-3eb32e725ca9'),
('3332a4ed-3657-4a9d-b0ee-f163316b444a', '289a516b-92a4-4b99-8e11-abcd8ad3cb7e', 'ec6fa0cd-5e1c-47b4-8d26-33811469abd9'),
('364372d2-96da-4046-a98d-6694eb62ef9f', 'a38aeb7c-af0a-4ab8-b4c8-43536e74f292', '67097bbf-78ce-4c92-bde9-91d436857bfd'),
('3d4289d8-ef9a-459c-9f1b-3de09de22a3d', 'd3ec2abc-a6d1-4ba6-a98a-874f69788dda', '8d71e6f3-73f8-40d2-a2c5-3eb32e725ca9'),
('422a4b23-0f61-4e2a-b074-1f2e70a1c73d', '228294a4-4633-489a-b421-4fe7e13bdda8', '67204d54-7481-441d-a49a-898edd5218a3'),
('43372f4e-baa5-492a-ac9b-204b00bf1f50', '7cc50275-c1b6-4c5f-8f95-98d560d269cf', '8d71e6f3-73f8-40d2-a2c5-3eb32e725ca9'),
('43421e90-9cd7-460d-82b9-8f7a32c6dbfa', '289a516b-92a4-4b99-8e11-abcd8ad3cb7e', '50ec8a81-418d-47ee-b157-e2412d605915'),
('43713c99-6073-4fa9-9e66-533d576ede3b', '3d58d00e-fe8c-4315-a9f7-9ae695f13c80', '67204d54-7481-441d-a49a-898edd5218a3'),
('4500f543-4b48-4eaa-8339-75d72e17489b', '688a3f17-1cc5-432c-a65a-29d844f54638', '8d71e6f3-73f8-40d2-a2c5-3eb32e725ca9'),
('4539d96d-4a6f-49ed-9ab4-0206a8b9a668', 'c3b929c2-2637-43de-8ee5-e693afa7a76f', '50ec8a81-418d-47ee-b157-e2412d605915'),
('478662c0-4a61-4ecb-91c5-b07e018377a0', 'c3b929c2-2637-43de-8ee5-e693afa7a76f', '9d39994a-000f-4bf1-858c-a89012184dc3'),
('48c752a5-5352-4a06-846a-2c63a65fdbfd', '7cc50275-c1b6-4c5f-8f95-98d560d269cf', '67204d54-7481-441d-a49a-898edd5218a3'),
('51435660-7531-413c-9255-9cd3640d549b', '1543ec64-2fd1-4beb-92e6-86bbd32f4a4a', '5de825ba-4c95-41db-81ba-766270542cac'),
('517badf8-a27f-407e-98fa-d63b46223341', 'ba449d7a-615a-4b3c-8c7e-e34e7e49663b', '8d71e6f3-73f8-40d2-a2c5-3eb32e725ca9'),
('52dc906b-4cb2-4d3f-a63e-e25a46f17d98', 'e56e0324-7bfc-483f-b0b3-b4d8395c4658', 'ec6fa0cd-5e1c-47b4-8d26-33811469abd9'),
('550406d7-1d2c-42ba-8943-09786baef08e', '6ab4dea6-12f0-4c21-9f2b-9ad93bfb0fee', '0261626e-5d8f-4a57-9afc-105a56955bcd'),
('5582e421-3896-42a3-908c-2284dfe8a5cb', 'e91f3ddc-2096-442f-a943-f74a11e8bf76', 'ec6fa0cd-5e1c-47b4-8d26-33811469abd9'),
('592333b1-4da5-42f8-89fc-988546f362bb', 'a087f028-4f53-4b35-9dc1-da64fbca397d', 'ec6fa0cd-5e1c-47b4-8d26-33811469abd9'),
('5a71a1f2-a1da-4849-8ec4-bea9ba4fb1e9', '4ac35949-48db-4045-93b4-d1542e1c5bb0', '67204d54-7481-441d-a49a-898edd5218a3'),
('5c202fcc-735a-4750-96a3-c8263cc0a85a', '289a516b-92a4-4b99-8e11-abcd8ad3cb7e', '5de825ba-4c95-41db-81ba-766270542cac'),
('5dffcb4e-323f-441b-9d2e-18ae49cffa29', 'e6120330-baad-491a-a034-d1186d57d4fd', '67097bbf-78ce-4c92-bde9-91d436857bfd'),
('620afd6e-fa5e-4e20-baff-460f1fe8a4ce', 'c3b929c2-2637-43de-8ee5-e693afa7a76f', '67097bbf-78ce-4c92-bde9-91d436857bfd'),
('63a912ff-6a25-46ab-8a95-846af3b0838d', '3d58d00e-fe8c-4315-a9f7-9ae695f13c80', '0261626e-5d8f-4a57-9afc-105a56955bcd'),
('641b5b41-776b-4535-a4fa-0357af6120ce', '7ad832a3-1177-4e67-ad89-8356da8aadf6', 'd2020239-2689-4cdf-8c53-7bf480956c6e'),
('6561b5e1-6277-40f1-9d87-be5590260c03', 'c3b929c2-2637-43de-8ee5-e693afa7a76f', '0261626e-5d8f-4a57-9afc-105a56955bcd'),
('65be163b-e327-4f43-89a9-9bf6b3c3f13b', '289a516b-92a4-4b99-8e11-abcd8ad3cb7e', '156bcba5-03d4-4b00-b3c0-b44974239fa4'),
('666af1e8-43fd-42eb-8a7d-df4ced314e78', 'a087f028-4f53-4b35-9dc1-da64fbca397d', '4a1dbdba-bfe9-4f6c-9e80-43d1ccf7886f'),
('67ccd107-60ac-409e-9b49-c585f7c0996b', '3d58d00e-fe8c-4315-a9f7-9ae695f13c80', '50ec8a81-418d-47ee-b157-e2412d605915'),
('68b0d53f-a77c-40f8-972c-f50ed060db4a', '3d58d00e-fe8c-4315-a9f7-9ae695f13c80', '4d6d18b8-ff0a-4b6a-8114-1f612e20dca9'),
('691d7a15-4f88-47b5-a6a8-09d9e497d2c2', 'ad93c0eb-be7d-4d07-b383-a94239c3a5ca', '0261626e-5d8f-4a57-9afc-105a56955bcd'),
('6db238d6-55a9-4d52-a2b7-87c0a42d5023', 'a087f028-4f53-4b35-9dc1-da64fbca397d', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('6f1f0890-343f-424a-885f-3defe14899a3', '710c72cb-3393-41c4-aa4a-03db8ae7fc7f', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('712c29cd-25fe-48fd-b2f1-c9a94318c1dd', 'dc666b13-02a7-4acb-8892-3401d2c26313', '8d71e6f3-73f8-40d2-a2c5-3eb32e725ca9'),
('726fe293-177c-4ea4-8a19-60ff3a27aff6', '068f2ac3-6189-4318-954f-f52810b80428', '8d71e6f3-73f8-40d2-a2c5-3eb32e725ca9'),
('741cb149-eecc-4b1c-99c6-cb7cad1c0757', '5a516de6-ad95-4f30-8fb8-8891029ba719', '8d71e6f3-73f8-40d2-a2c5-3eb32e725ca9'),
('75a922bd-539c-4b5b-b006-e247f03b6c4b', '22307959-b216-40b1-8191-2b02288149e7', '0261626e-5d8f-4a57-9afc-105a56955bcd'),
('76f60723-3aa4-4b15-932b-e80013eca532', '2b0668e7-3ad6-4514-9bd8-df3500b98f9d', 'ec6fa0cd-5e1c-47b4-8d26-33811469abd9'),
('773aead9-fc2c-41d3-90aa-af5b11305934', 'a087f028-4f53-4b35-9dc1-da64fbca397d', '8d71e6f3-73f8-40d2-a2c5-3eb32e725ca9'),
('7745b598-90af-48b1-963c-3420e5aeda9d', 'a38aeb7c-af0a-4ab8-b4c8-43536e74f292', '8d71e6f3-73f8-40d2-a2c5-3eb32e725ca9'),
('792ae3d6-04d3-46d5-bfda-e3ca5ac87250', '9e849aa1-6026-4f2a-ab37-0602e9295f56', 'ec6fa0cd-5e1c-47b4-8d26-33811469abd9'),
('7cf0b89f-ae98-4e02-8be6-a35221788ff9', 'c3b929c2-2637-43de-8ee5-e693afa7a76f', '4d6d18b8-ff0a-4b6a-8114-1f612e20dca9'),
('7f8f03a4-9a92-4219-8e3c-12c84c58d5ec', '5a516de6-ad95-4f30-8fb8-8891029ba719', 'ec6fa0cd-5e1c-47b4-8d26-33811469abd9'),
('7fb28ef0-03ae-43a3-8d7c-7721e22d9e1d', '7cc50275-c1b6-4c5f-8f95-98d560d269cf', 'ec6fa0cd-5e1c-47b4-8d26-33811469abd9'),
('83570fa3-541e-4b9d-a8fa-aa9b4ecc83e2', '6b8ee1b1-acb9-4e3f-8125-541fc135c9c3', '67097bbf-78ce-4c92-bde9-91d436857bfd'),
('8434592a-6663-465d-9d7d-2a49fa9e74cf', '4ac35949-48db-4045-93b4-d1542e1c5bb0', '0261626e-5d8f-4a57-9afc-105a56955bcd'),
('85914a41-33d0-4bea-81c9-8ad91e886539', '6ab4dea6-12f0-4c21-9f2b-9ad93bfb0fee', '8d71e6f3-73f8-40d2-a2c5-3eb32e725ca9'),
('88357896-af1a-4043-bf54-70264f51dea2', '7ad832a3-1177-4e67-ad89-8356da8aadf6', '4d6d18b8-ff0a-4b6a-8114-1f612e20dca9'),
('8841b4bc-3f0a-4f5c-9c1a-2481d09758a1', 'a087f028-4f53-4b35-9dc1-da64fbca397d', '50ec8a81-418d-47ee-b157-e2412d605915'),
('88599b66-4986-443f-a340-89c42fa7ae6e', '5a516de6-ad95-4f30-8fb8-8891029ba719', '67097bbf-78ce-4c92-bde9-91d436857bfd'),
('8b24e465-8eea-45bf-8a50-f3d2d578bcbe', '404800e0-2338-4f33-8eb1-efa55c208a67', '0261626e-5d8f-4a57-9afc-105a56955bcd'),
('8c542ff6-68bf-43f9-ac98-3c36f9f56e70', 'a087f028-4f53-4b35-9dc1-da64fbca397d', '67097bbf-78ce-4c92-bde9-91d436857bfd'),
('8e25d119-43c2-4fcb-8b7a-b96e386a1a22', '7ad832a3-1177-4e67-ad89-8356da8aadf6', '9d39994a-000f-4bf1-858c-a89012184dc3'),
('8e2ba1f2-b129-43bb-83ed-c5eedde87ac7', '289a516b-92a4-4b99-8e11-abcd8ad3cb7e', 'bd945133-4c1d-4788-a094-c8244480c33f'),
('9231c8f0-d0d9-424c-bdb0-383c671d0d9d', '289a516b-92a4-4b99-8e11-abcd8ad3cb7e', '4d6d18b8-ff0a-4b6a-8114-1f612e20dca9'),
('930cc4df-7cd1-4d87-a766-6b972e6ac317', '002fda15-5d1d-4b1f-bb9b-f608bbfa9db1', '67204d54-7481-441d-a49a-898edd5218a3'),
('93f3542a-e6f6-4366-9fe5-7d6c656999d6', '289a516b-92a4-4b99-8e11-abcd8ad3cb7e', '9d39994a-000f-4bf1-858c-a89012184dc3'),
('9497f85a-677b-4ff7-8933-1622a2c79190', 'c3b929c2-2637-43de-8ee5-e693afa7a76f', '8d71e6f3-73f8-40d2-a2c5-3eb32e725ca9'),
('95a50dee-dfd4-4ea6-8f19-413276f8a533', 'a84db697-00d9-45da-b75e-31b17de90dde', 'ec6fa0cd-5e1c-47b4-8d26-33811469abd9'),
('9641d1b9-edf0-4bec-8b25-629f7ccd20ba', '3d58d00e-fe8c-4315-a9f7-9ae695f13c80', '67097bbf-78ce-4c92-bde9-91d436857bfd'),
('99df2faa-71dc-411a-8cf8-03934afed0e5', '22307959-b216-40b1-8191-2b02288149e7', '8d71e6f3-73f8-40d2-a2c5-3eb32e725ca9'),
('9a237dd9-5e78-4fa8-8323-499d393ef2e3', 'a087f028-4f53-4b35-9dc1-da64fbca397d', '156bcba5-03d4-4b00-b3c0-b44974239fa4'),
('9cf7ba7a-af4f-438f-8dd2-b59bc7437fe1', '1543ec64-2fd1-4beb-92e6-86bbd32f4a4a', '156bcba5-03d4-4b00-b3c0-b44974239fa4'),
('9e458380-82cf-42b7-b2cb-3ff5438036ef', 'a087f028-4f53-4b35-9dc1-da64fbca397d', '5de825ba-4c95-41db-81ba-766270542cac'),
('9f860cb8-77ef-4274-81d0-6e8ef7f70f3f', '289a516b-92a4-4b99-8e11-abcd8ad3cb7e', '67204d54-7481-441d-a49a-898edd5218a3'),
('a10bfdab-d181-4a2d-8512-f09517141174', 'a38aeb7c-af0a-4ab8-b4c8-43536e74f292', 'ec6fa0cd-5e1c-47b4-8d26-33811469abd9'),
('a2202492-cb14-420a-b71d-4ae91e274c17', 'e56e0324-7bfc-483f-b0b3-b4d8395c4658', '0261626e-5d8f-4a57-9afc-105a56955bcd'),
('a2308d8b-55b7-4869-ae2e-5fef1b914bf3', '068f2ac3-6189-4318-954f-f52810b80428', 'ec6fa0cd-5e1c-47b4-8d26-33811469abd9'),
('a4a35d93-545a-48a4-93c9-7e8befec6258', '7ad832a3-1177-4e67-ad89-8356da8aadf6', '156bcba5-03d4-4b00-b3c0-b44974239fa4'),
('a653ea3d-82cc-4ce7-9b04-2db48a362b05', '4ac35949-48db-4045-93b4-d1542e1c5bb0', '67097bbf-78ce-4c92-bde9-91d436857bfd'),
('a6a64fdf-0aea-45a7-afc4-0174ee8ae39a', 'a7425923-57f3-404c-a80a-06b7c3f8b78f', '50ec8a81-418d-47ee-b157-e2412d605915'),
('a7cc44fd-4b85-4e34-b6dd-297053b433b2', '3d58d00e-fe8c-4315-a9f7-9ae695f13c80', '8d71e6f3-73f8-40d2-a2c5-3eb32e725ca9'),
('ad77b9fd-f46d-4f98-b41d-df417b19c0d9', 'a087f028-4f53-4b35-9dc1-da64fbca397d', '0261626e-5d8f-4a57-9afc-105a56955bcd'),
('aee9882e-d1bb-4553-90d1-e38b03181bb1', 'f76e3686-0011-4967-8dc1-239ad5e948c4', '8d71e6f3-73f8-40d2-a2c5-3eb32e725ca9'),
('b04c6774-c1bd-4fb3-be2b-09f4e3610d12', '289a516b-92a4-4b99-8e11-abcd8ad3cb7e', '67097bbf-78ce-4c92-bde9-91d436857bfd'),
('b377bacb-1845-4949-9255-48d18407a408', '2b0668e7-3ad6-4514-9bd8-df3500b98f9d', '8d71e6f3-73f8-40d2-a2c5-3eb32e725ca9'),
('b4cde14d-a9ea-46aa-9641-f405e4416aaf', 'c3b929c2-2637-43de-8ee5-e693afa7a76f', '67204d54-7481-441d-a49a-898edd5218a3'),
('b4ec9400-af88-4044-ae30-2b90f81ad0dc', '289a516b-92a4-4b99-8e11-abcd8ad3cb7e', '4a1dbdba-bfe9-4f6c-9e80-43d1ccf7886f'),
('b88c1271-0e1f-40b2-8533-6c9c6aa7030c', 'deba7ae1-005b-4a22-becb-54e20f455df6', 'ec6fa0cd-5e1c-47b4-8d26-33811469abd9'),
('bb8d7d5d-463c-40e2-8252-02d3e93e770f', '068f2ac3-6189-4318-954f-f52810b80428', '67097bbf-78ce-4c92-bde9-91d436857bfd'),
('bbf387e4-222b-4ace-b207-26f60307f54f', 'c3b929c2-2637-43de-8ee5-e693afa7a76f', 'ec6fa0cd-5e1c-47b4-8d26-33811469abd9'),
('be5d74c1-e69d-423d-b27b-d536d82834ef', '2b0668e7-3ad6-4514-9bd8-df3500b98f9d', '0261626e-5d8f-4a57-9afc-105a56955bcd'),
('be855853-dfa6-4e0e-b8bf-dc4da1543013', '4ac35949-48db-4045-93b4-d1542e1c5bb0', '8d71e6f3-73f8-40d2-a2c5-3eb32e725ca9'),
('c1f28de0-4ddd-43e5-8a62-e99cc554d16a', '4ac35949-48db-4045-93b4-d1542e1c5bb0', 'ec6fa0cd-5e1c-47b4-8d26-33811469abd9'),
('c3167fe1-809d-4e61-8b17-193389ab81b1', '4c27db81-2a84-4b1d-9595-030e918960b5', '67097bbf-78ce-4c92-bde9-91d436857bfd'),
('c58ee9cf-0847-4186-b02c-f0f22d2875f1', '289a516b-92a4-4b99-8e11-abcd8ad3cb7e', '8d71e6f3-73f8-40d2-a2c5-3eb32e725ca9'),
('c5f1834b-d857-4e5d-a60c-fed4ca8261ba', '521651bd-1f19-4683-8fff-6f3dfe86499b', '8d71e6f3-73f8-40d2-a2c5-3eb32e725ca9'),
('c7d00336-2a92-4d42-86e9-d8e738c489ab', 'e697910d-f89b-48cb-875c-2258e6cc6924', '0261626e-5d8f-4a57-9afc-105a56955bcd'),
('c7dbaa73-6ffd-4c34-8e93-c9a322b7b688', '7ad832a3-1177-4e67-ad89-8356da8aadf6', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('ca732cb1-bb2a-4f9f-b02c-fa77468745a9', 'e56e0324-7bfc-483f-b0b3-b4d8395c4658', '8d71e6f3-73f8-40d2-a2c5-3eb32e725ca9'),
('ca801f6b-e1bc-4c3b-97d7-5ab28008a1ae', '7cc50275-c1b6-4c5f-8f95-98d560d269cf', '50ec8a81-418d-47ee-b157-e2412d605915'),
('cd5a0664-d7ea-4627-be4a-e95a7d31803a', '404800e0-2338-4f33-8eb1-efa55c208a67', '8d71e6f3-73f8-40d2-a2c5-3eb32e725ca9'),
('d1abb39d-e8f1-4760-8550-1b6f9ad75d4e', 'c86229c8-9bff-4a71-9bc4-50e1fb68914a', '8d71e6f3-73f8-40d2-a2c5-3eb32e725ca9'),
('d24c0ab2-566b-4a3c-93d5-f77fbebe8fb9', 'a38aeb7c-af0a-4ab8-b4c8-43536e74f292', '0261626e-5d8f-4a57-9afc-105a56955bcd'),
('d29e1b68-df40-4ba8-ba16-ed1584bc1db9', 'e4b091bb-28d1-48dc-ae69-f6258dd9dc00', '67097bbf-78ce-4c92-bde9-91d436857bfd'),
('d681fb4c-9dd9-4738-be4d-8e67948fd4e0', 'dc666b13-02a7-4acb-8892-3401d2c26313', '67097bbf-78ce-4c92-bde9-91d436857bfd'),
('da70973b-11cb-49c9-ae0c-eba46f27ecab', 'f76e3686-0011-4967-8dc1-239ad5e948c4', 'ec6fa0cd-5e1c-47b4-8d26-33811469abd9'),
('dba6de23-480f-4f78-8141-34f2d9c6e65a', '7ad832a3-1177-4e67-ad89-8356da8aadf6', '4a1dbdba-bfe9-4f6c-9e80-43d1ccf7886f'),
('e0e70604-0a77-4d3b-aed4-42c93140f3b2', 'f76e3686-0011-4967-8dc1-239ad5e948c4', '0261626e-5d8f-4a57-9afc-105a56955bcd'),
('e2978cf7-147a-4545-a0ac-0517f34c81e2', 'f76e3686-0011-4967-8dc1-239ad5e948c4', '67204d54-7481-441d-a49a-898edd5218a3'),
('e5a44af1-150e-4a3f-ab37-ced9824285f5', 'a087f028-4f53-4b35-9dc1-da64fbca397d', '67204d54-7481-441d-a49a-898edd5218a3'),
('e5e17d5d-86a8-4c92-a360-90798ea95d17', 'a087f028-4f53-4b35-9dc1-da64fbca397d', '4d6d18b8-ff0a-4b6a-8114-1f612e20dca9'),
('e8f102d3-960b-48fe-84e6-217ab1d6b6fe', 'ba449d7a-615a-4b3c-8c7e-e34e7e49663b', '0261626e-5d8f-4a57-9afc-105a56955bcd'),
('e9a1e273-e87c-4205-8c4f-80382768ba92', 'a087f028-4f53-4b35-9dc1-da64fbca397d', '9d39994a-000f-4bf1-858c-a89012184dc3'),
('e9c7f3af-c029-4df2-9ebc-ac16c6f22c15', 'a087f028-4f53-4b35-9dc1-da64fbca397d', 'd2020239-2689-4cdf-8c53-7bf480956c6e'),
('ed0bbeba-f585-4b3a-95e2-16ad60fa5810', '5a516de6-ad95-4f30-8fb8-8891029ba719', '0261626e-5d8f-4a57-9afc-105a56955bcd'),
('ee35c426-72a9-49ac-9d51-b164e1ee2f5a', '8bb2edc7-75e4-4c08-a24a-fedefef919a6', '67204d54-7481-441d-a49a-898edd5218a3'),
('f2bbc4d4-5e29-4294-b662-83096942e643', '987fa07d-2772-4b9c-acdf-e65e9f55c318', '5de825ba-4c95-41db-81ba-766270542cac'),
('f3437d7d-74b3-42b1-bced-c54323db2dda', '3d58d00e-fe8c-4315-a9f7-9ae695f13c80', '4a1dbdba-bfe9-4f6c-9e80-43d1ccf7886f');

-- --------------------------------------------------------

--
-- Table structure for table `ad_process_category`
--

CREATE TABLE `ad_process_category` (
  `ad_process_category_id` varchar(50) NOT NULL,
  `ad_process_id` varchar(50) NOT NULL,
  `category_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ad_process_category`
--

INSERT INTO `ad_process_category` (`ad_process_category_id`, `ad_process_id`, `category_id`) VALUES
('0001dee8-18ef-4607-b90c-dcfcf9c54fbb', 'c3b929c2-2637-43de-8ee5-e693afa7a76f', 'df2305f7-4bf1-445b-9b9d-1e87a2baadc6'),
('070840d6-7c4a-4dd9-ba96-8994dd4b2568', '7ad832a3-1177-4e67-ad89-8356da8aadf6', '5c76b059-2150-4508-8181-b7cb13569128'),
('0bdf3093-867d-42d1-9b41-581aa9822018', '7cc50275-c1b6-4c5f-8f95-98d560d269cf', '15d63c5e-6638-4b9e-90bb-1ae6da20ec5b'),
('0be953fb-f257-4db7-a455-4b62fa4b43cd', 'c86229c8-9bff-4a71-9bc4-50e1fb68914a', '0c32093d-fe09-41fb-a672-c48068a44a1f'),
('11041517-2772-4e4c-baa9-d861a3c3b2ba', '4ac35949-48db-4045-93b4-d1542e1c5bb0', 'e2497a04-a2ce-4d39-ae42-b718d15fcb97'),
('1119540b-73a3-4405-bdc0-7e5e514c7a07', '068f2ac3-6189-4318-954f-f52810b80428', '3a273f95-7616-4a2c-b098-189009af3547'),
('14583169-31ba-423c-aadf-03295253b6b5', '688a3f17-1cc5-432c-a65a-29d844f54638', '3a273f95-7616-4a2c-b098-189009af3547'),
('14c6f811-4456-42e0-bcd4-e271de0d9277', 'a38aeb7c-af0a-4ab8-b4c8-43536e74f292', '15d63c5e-6638-4b9e-90bb-1ae6da20ec5b'),
('1632335d-668b-4a28-adfe-3e391b497bde', 'e77d7525-d8d5-4115-8f18-437185d9296d', '3a273f95-7616-4a2c-b098-189009af3547'),
('16f52859-6c1d-46c3-b4ab-1ec4ce440fb4', 'dc666b13-02a7-4acb-8892-3401d2c26313', '4a9207e6-581f-4130-82d8-a78c15f0cb12'),
('1728d96f-8b08-4eba-a9af-f24293614807', '9e849aa1-6026-4f2a-ab37-0602e9295f56', '82db2499-66ac-4626-9a4d-805b73d37d80'),
('1b76e3d8-a05c-4b2a-8216-99950aaf53f8', 'e4b091bb-28d1-48dc-ae69-f6258dd9dc00', 'e2497a04-a2ce-4d39-ae42-b718d15fcb97'),
('2329f6cb-aa9b-4c2c-868a-f7e83fd76d94', 'dc666b13-02a7-4acb-8892-3401d2c26313', 'aae19cb0-8ca5-458d-9d52-c6f7a1471a45'),
('24e93c15-3730-4428-b524-fc8e8ccf2185', '4ac35949-48db-4045-93b4-d1542e1c5bb0', '71180ac7-4637-46c1-ac63-1a19fbdbc2d0'),
('272ca253-be14-4fb1-bf13-d8cfe1f401e2', 'dc666b13-02a7-4acb-8892-3401d2c26313', '82db2499-66ac-4626-9a4d-805b73d37d80'),
('282fcf8d-79fe-4565-96ad-12dc7dff8c48', '289a516b-92a4-4b99-8e11-abcd8ad3cb7e', '8b54acae-99f2-4f0c-b1a1-66af1a27fd74'),
('29fb12f2-75ea-4cbf-9dcd-339cae0d299a', '2b0668e7-3ad6-4514-9bd8-df3500b98f9d', '3a273f95-7616-4a2c-b098-189009af3547'),
('3267ec40-b757-4855-b2b7-fc76623398d3', 'dc666b13-02a7-4acb-8892-3401d2c26313', '71180ac7-4637-46c1-ac63-1a19fbdbc2d0'),
('3c0baa2d-eed8-4c21-9351-b4957475194f', 'e56e0324-7bfc-483f-b0b3-b4d8395c4658', '0c32093d-fe09-41fb-a672-c48068a44a1f'),
('3e8646f7-e701-4876-a761-f0ec0b4cb973', 'dc666b13-02a7-4acb-8892-3401d2c26313', '15d63c5e-6638-4b9e-90bb-1ae6da20ec5b'),
('4553e634-86cb-4782-a47c-a584fbe289ff', '3d58d00e-fe8c-4315-a9f7-9ae695f13c80', '8b54acae-99f2-4f0c-b1a1-66af1a27fd74'),
('4abd3469-a74b-415f-9e06-12d4e2e04aa5', '6ab4dea6-12f0-4c21-9f2b-9ad93bfb0fee', 'e2497a04-a2ce-4d39-ae42-b718d15fcb97'),
('4cc95f72-e59f-4810-a334-846d5fc9245b', 'c3b929c2-2637-43de-8ee5-e693afa7a76f', 'aae19cb0-8ca5-458d-9d52-c6f7a1471a45'),
('4d9c33ce-8fa1-41de-a14e-7ec78b351d41', 'f76e3686-0011-4967-8dc1-239ad5e948c4', 'e2497a04-a2ce-4d39-ae42-b718d15fcb97'),
('52513791-93de-4b48-8df0-b895c623f89a', 'c3b929c2-2637-43de-8ee5-e693afa7a76f', '3a273f95-7616-4a2c-b098-189009af3547'),
('55c0a9f8-51b7-44d8-bef7-612d94b5c244', 'c86229c8-9bff-4a71-9bc4-50e1fb68914a', '3a273f95-7616-4a2c-b098-189009af3547'),
('56ac40eb-897a-442b-8964-3cccdd18026f', 'a7425923-57f3-404c-a80a-06b7c3f8b78f', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('5ad3f0dd-69b0-468f-8818-9ca7294a458a', '9e849aa1-6026-4f2a-ab37-0602e9295f56', 'e2497a04-a2ce-4d39-ae42-b718d15fcb97'),
('5cb2c050-3797-4fb0-bbcc-e48dcd58475b', 'c3b929c2-2637-43de-8ee5-e693afa7a76f', '15d63c5e-6638-4b9e-90bb-1ae6da20ec5b'),
('5d2a4a07-cddc-4532-a918-6527f5f748f9', 'c3b929c2-2637-43de-8ee5-e693afa7a76f', '71180ac7-4637-46c1-ac63-1a19fbdbc2d0'),
('5e62e6da-cf07-4ef6-8429-9035d7c25603', '404800e0-2338-4f33-8eb1-efa55c208a67', '3a273f95-7616-4a2c-b098-189009af3547'),
('5ee8a718-fb15-4671-ab8e-78922047cc89', '7cc50275-c1b6-4c5f-8f95-98d560d269cf', '0c32093d-fe09-41fb-a672-c48068a44a1f'),
('62278585-485c-425b-975a-06ccec837276', '4ac35949-48db-4045-93b4-d1542e1c5bb0', '3a273f95-7616-4a2c-b098-189009af3547'),
('62659aed-f5a2-4cb5-82f0-eed6d43592bf', '068f2ac3-6189-4318-954f-f52810b80428', 'e2497a04-a2ce-4d39-ae42-b718d15fcb97'),
('6404b96c-74b3-44c0-b763-10a101cd330e', 'ad93c0eb-be7d-4d07-b383-a94239c3a5ca', '3a273f95-7616-4a2c-b098-189009af3547'),
('645e8d91-c7cc-40e2-a085-baaf2a13a6b5', '002fda15-5d1d-4b1f-bb9b-f608bbfa9db1', '82db2499-66ac-4626-9a4d-805b73d37d80'),
('652a3106-4214-4654-af88-aa420dc0ad33', '4ac35949-48db-4045-93b4-d1542e1c5bb0', '0c32093d-fe09-41fb-a672-c48068a44a1f'),
('65e2e08d-b21a-43fb-b2f5-c4c8dd88641b', 'dc666b13-02a7-4acb-8892-3401d2c26313', '31cb2d4a-bcac-4322-91d4-a89728c8dbe2'),
('68ced967-9a78-48c6-b021-7cbd7db11637', '5a516de6-ad95-4f30-8fb8-8891029ba719', '71180ac7-4637-46c1-ac63-1a19fbdbc2d0'),
('6c056e26-bfca-4998-bd1c-ddcf05b68c1d', '7ad832a3-1177-4e67-ad89-8356da8aadf6', 'df2305f7-4bf1-445b-9b9d-1e87a2baadc6'),
('707fede7-4aea-4428-b436-c0c8b289b967', 'deba7ae1-005b-4a22-becb-54e20f455df6', 'e2497a04-a2ce-4d39-ae42-b718d15fcb97'),
('74b15e70-fcff-4b6e-8a6f-3eea9a8e7ed9', '867fe386-ebba-462f-8854-af76d56a1875', '82db2499-66ac-4626-9a4d-805b73d37d80'),
('7a853b0b-f5ba-49b9-9361-b6c05e150efe', 'f76e3686-0011-4967-8dc1-239ad5e948c4', '15d63c5e-6638-4b9e-90bb-1ae6da20ec5b'),
('7af719dc-64d8-4316-8dc5-064bb75bddf4', 'f76e3686-0011-4967-8dc1-239ad5e948c4', '3a273f95-7616-4a2c-b098-189009af3547'),
('7af950c3-eefe-493b-9575-3e835ad079bd', 'e697910d-f89b-48cb-875c-2258e6cc6924', '3a273f95-7616-4a2c-b098-189009af3547'),
('7ba84463-151a-40fb-9545-bcf5526271ff', '9c0952f8-ed1c-4c1b-adfd-cf0ab8c717b5', '0c32093d-fe09-41fb-a672-c48068a44a1f'),
('7d29d573-104e-46f9-8da5-eb457b7e19ac', '987fa07d-2772-4b9c-acdf-e65e9f55c318', '4a9207e6-581f-4130-82d8-a78c15f0cb12'),
('7e20add9-2fee-46c3-a16e-6fd9b92ecc9c', '3d58d00e-fe8c-4315-a9f7-9ae695f13c80', '4a9207e6-581f-4130-82d8-a78c15f0cb12'),
('81bef46e-4827-4d80-9b80-dc6a3c39285c', '4ac35949-48db-4045-93b4-d1542e1c5bb0', '82db2499-66ac-4626-9a4d-805b73d37d80'),
('82e614cd-9b83-4bfe-ba34-1f345be320de', 'ba449d7a-615a-4b3c-8c7e-e34e7e49663b', 'e2497a04-a2ce-4d39-ae42-b718d15fcb97'),
('8514c6f4-3a59-48a3-8fb9-f20c8d1c8267', '289a516b-92a4-4b99-8e11-abcd8ad3cb7e', 'aae19cb0-8ca5-458d-9d52-c6f7a1471a45'),
('85324c36-bbcc-4f31-a007-0523a2387d18', 'c3b929c2-2637-43de-8ee5-e693afa7a76f', '5c76b059-2150-4508-8181-b7cb13569128'),
('88a09d5b-b4ff-4ca4-94ed-5b88319dc47c', 'e6120330-baad-491a-a034-d1186d57d4fd', '0c32093d-fe09-41fb-a672-c48068a44a1f'),
('91e60d86-c0e2-4e46-9410-7f6a3065ab87', '6b8ee1b1-acb9-4e3f-8125-541fc135c9c3', '0c32093d-fe09-41fb-a672-c48068a44a1f'),
('9294cc1f-2ec0-4cd0-b1a8-a832a74d53a2', 'a38aeb7c-af0a-4ab8-b4c8-43536e74f292', '0c32093d-fe09-41fb-a672-c48068a44a1f'),
('95eccdff-d26c-4dfd-959d-8d492628d649', 'c3b929c2-2637-43de-8ee5-e693afa7a76f', '0c32093d-fe09-41fb-a672-c48068a44a1f'),
('9ff63890-f3d6-43ad-b65d-6738552deb0d', '5a516de6-ad95-4f30-8fb8-8891029ba719', '82db2499-66ac-4626-9a4d-805b73d37d80'),
('a062136b-10aa-4327-a644-e60c5faf7050', '7ad832a3-1177-4e67-ad89-8356da8aadf6', '71180ac7-4637-46c1-ac63-1a19fbdbc2d0'),
('a12c4ff1-e73f-4bf4-9fcc-646979881511', '5a516de6-ad95-4f30-8fb8-8891029ba719', '5c76b059-2150-4508-8181-b7cb13569128'),
('a174ec1d-eb5e-41d1-a6a9-bae0a99f277e', 'c3b929c2-2637-43de-8ee5-e693afa7a76f', 'e2497a04-a2ce-4d39-ae42-b718d15fcb97'),
('a8eb6663-e653-49a9-8802-623cbbc9ab3a', '7ad832a3-1177-4e67-ad89-8356da8aadf6', '4a9207e6-581f-4130-82d8-a78c15f0cb12'),
('a96fda54-2084-4097-a670-a8e15d63f2b3', 'a087f028-4f53-4b35-9dc1-da64fbca397d', '4a9207e6-581f-4130-82d8-a78c15f0cb12'),
('abae3c05-d954-4057-ad6e-24d8053a24a9', '22307959-b216-40b1-8191-2b02288149e7', '3a273f95-7616-4a2c-b098-189009af3547'),
('adfe2fa8-28e7-4585-92fa-7f3f73df3982', '5a516de6-ad95-4f30-8fb8-8891029ba719', '15d63c5e-6638-4b9e-90bb-1ae6da20ec5b'),
('af43c67b-eec9-4dc8-8e7d-68ced5b592f1', '377b9c39-25a2-40d6-bd6b-7a19075c72f4', 'e2497a04-a2ce-4d39-ae42-b718d15fcb97'),
('af45d89c-445c-4c05-b991-426e74598d1b', '7ad832a3-1177-4e67-ad89-8356da8aadf6', '82db2499-66ac-4626-9a4d-805b73d37d80'),
('b0274bc9-7ad8-446c-8f22-af8fc283d4ec', '289a516b-92a4-4b99-8e11-abcd8ad3cb7e', '71180ac7-4637-46c1-ac63-1a19fbdbc2d0'),
('b2704650-43e3-4e1c-8ae1-95806c9ae666', '3d58d00e-fe8c-4315-a9f7-9ae695f13c80', '5c76b059-2150-4508-8181-b7cb13569128'),
('b3812d43-f20b-4887-9af9-64e91ad3eb27', '228294a4-4633-489a-b421-4fe7e13bdda8', '0c32093d-fe09-41fb-a672-c48068a44a1f'),
('b56147b0-1f0d-4dd4-93be-8561f27bb25f', '5a516de6-ad95-4f30-8fb8-8891029ba719', '31cb2d4a-bcac-4322-91d4-a89728c8dbe2'),
('b9108ab4-4fc4-4b1c-b7f8-c17d1d78f3a5', '710c72cb-3393-41c4-aa4a-03db8ae7fc7f', 'fe2b649f-2cc4-424c-af71-0095e5823b05'),
('ba00e6d6-3acc-4f54-b1ac-4e1b37cfdebd', 'dc666b13-02a7-4acb-8892-3401d2c26313', '5c76b059-2150-4508-8181-b7cb13569128'),
('c03e8fdb-d294-4299-9f7b-96afd5da313f', 'e56e0324-7bfc-483f-b0b3-b4d8395c4658', '3a273f95-7616-4a2c-b098-189009af3547'),
('c1435d71-a3a4-4f50-880a-f133281fc253', '289a516b-92a4-4b99-8e11-abcd8ad3cb7e', '4a9207e6-581f-4130-82d8-a78c15f0cb12'),
('c52ccb58-502f-4e7e-b7e7-8aee33367712', '1543ec64-2fd1-4beb-92e6-86bbd32f4a4a', '4a9207e6-581f-4130-82d8-a78c15f0cb12'),
('c860ab80-43f7-4d5b-9653-82062759b3b8', 'a84db697-00d9-45da-b75e-31b17de90dde', '0c32093d-fe09-41fb-a672-c48068a44a1f'),
('c8ccfeee-18a9-4614-9c09-2e2af7545bc4', 'cd9dbb8c-1393-4b56-a4b3-7d7e592c80d2', '15d63c5e-6638-4b9e-90bb-1ae6da20ec5b'),
('ca038c99-1054-462f-8965-8c241fc4302b', '3d58d00e-fe8c-4315-a9f7-9ae695f13c80', 'aae19cb0-8ca5-458d-9d52-c6f7a1471a45'),
('ce181552-2db3-4559-a29d-7f4e20f6e7c6', '6ab4dea6-12f0-4c21-9f2b-9ad93bfb0fee', '3a273f95-7616-4a2c-b098-189009af3547'),
('cf281946-f198-4598-a633-cbb77e119a33', '4ac35949-48db-4045-93b4-d1542e1c5bb0', '15d63c5e-6638-4b9e-90bb-1ae6da20ec5b'),
('d083592b-3de8-4fa4-813b-39d955903cbc', '4c27db81-2a84-4b1d-9595-030e918960b5', '0c32093d-fe09-41fb-a672-c48068a44a1f'),
('d5521dc5-c7bf-4b6e-a914-119a0242810f', 'c3b929c2-2637-43de-8ee5-e693afa7a76f', '4a9207e6-581f-4130-82d8-a78c15f0cb12'),
('d5aa9cde-f4b1-4925-b8bb-cda5269ec7f8', '84889a1a-2d11-41c9-9540-78e3a261d53d', '15d63c5e-6638-4b9e-90bb-1ae6da20ec5b'),
('d858205e-e1fe-4007-b310-2c37f78f9437', 'a087f028-4f53-4b35-9dc1-da64fbca397d', 'aae19cb0-8ca5-458d-9d52-c6f7a1471a45'),
('e12a5804-e7f0-4632-8bc4-00eb25df2f09', 'c3b929c2-2637-43de-8ee5-e693afa7a76f', '31cb2d4a-bcac-4322-91d4-a89728c8dbe2'),
('e15a401f-6792-429f-b94d-94b6d743610f', 'f76e3686-0011-4967-8dc1-239ad5e948c4', '71180ac7-4637-46c1-ac63-1a19fbdbc2d0'),
('e78e2f28-823a-4270-89a3-f2718c3c7d9a', 'd3ec2abc-a6d1-4ba6-a98a-874f69788dda', 'e2497a04-a2ce-4d39-ae42-b718d15fcb97'),
('ea7dcdd2-6dc6-472e-9c87-0abf1083a5db', '9e849aa1-6026-4f2a-ab37-0602e9295f56', '0c32093d-fe09-41fb-a672-c48068a44a1f'),
('ed271cd5-a42d-4a95-9c9e-be0d38f6e733', '2a80aa89-1e29-4930-a2f2-d0e2bec8d9ae', '0c32093d-fe09-41fb-a672-c48068a44a1f'),
('ee151729-e390-4fa9-b902-7ca012fa3c1f', '068f2ac3-6189-4318-954f-f52810b80428', '15d63c5e-6638-4b9e-90bb-1ae6da20ec5b'),
('f017f4f4-eac5-4adb-b8b1-6796118fad7f', '521651bd-1f19-4683-8fff-6f3dfe86499b', 'e2497a04-a2ce-4d39-ae42-b718d15fcb97'),
('f0bb988f-3704-4c43-a2a3-7641f0b52eb5', '8bb2edc7-75e4-4c08-a24a-fedefef919a6', '82db2499-66ac-4626-9a4d-805b73d37d80'),
('f0d66a38-ce23-4fea-a266-b8ba5af29e29', '4c27db81-2a84-4b1d-9595-030e918960b5', 'aae19cb0-8ca5-458d-9d52-c6f7a1471a45'),
('f32509e7-a385-46e3-9d30-825130e89b4b', 'f76e3686-0011-4967-8dc1-239ad5e948c4', '0c32093d-fe09-41fb-a672-c48068a44a1f'),
('f4860afe-6596-4cb0-91eb-a9f211c0b705', '14d69f0e-3565-429e-bc85-9d16b363fa69', 'e2497a04-a2ce-4d39-ae42-b718d15fcb97'),
('f4931f96-fa96-4aa6-9b35-8fb0c88810a1', 'e91f3ddc-2096-442f-a943-f74a11e8bf76', '3a273f95-7616-4a2c-b098-189009af3547'),
('f62de4e7-e099-4844-84b6-0756881eec08', 'ba449d7a-615a-4b3c-8c7e-e34e7e49663b', '3a273f95-7616-4a2c-b098-189009af3547'),
('fdfeacaf-92d6-49e7-a1d8-75ea1bdc5a73', 'ad93c0eb-be7d-4d07-b383-a94239c3a5ca', 'e2497a04-a2ce-4d39-ae42-b718d15fcb97');

-- --------------------------------------------------------

--
-- Table structure for table `ad_process_gender`
--

CREATE TABLE `ad_process_gender` (
  `ad_process_gender_id` varchar(50) NOT NULL,
  `ad_process_id` varchar(50) NOT NULL,
  `gender_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ad_process_gender`
--

INSERT INTO `ad_process_gender` (`ad_process_gender_id`, `ad_process_id`, `gender_id`) VALUES
('08e822be-92be-4af0-a844-dfc3251de327', 'deba7ae1-005b-4a22-becb-54e20f455df6', '6829c2fa-7912-4c61-a747-a730e8bd9188'),
('0973de02-4135-4b16-a722-3f90b08689e6', 'a84db697-00d9-45da-b75e-31b17de90dde', '6829c2fa-7912-4c61-a747-a730e8bd9188'),
('09a00eb8-5b8b-481a-914b-3e1456ed6ebd', 'fc199407-cdf4-48ea-80b0-cc803052f0e4', '6829c2fa-7912-4c61-a747-a730e8bd9188'),
('0b542688-e544-49f1-b469-5cd6dd8723fd', '4ac35949-48db-4045-93b4-d1542e1c5bb0', '46d631d6-7bfd-49b5-8c62-3b66b012db97'),
('0c917b5c-024b-43d3-b568-43d5b2c6b624', 'c3b929c2-2637-43de-8ee5-e693afa7a76f', '6829c2fa-7912-4c61-a747-a730e8bd9188'),
('0cd31791-fcd1-465f-b800-e03106870f3c', '7cc50275-c1b6-4c5f-8f95-98d560d269cf', '46d631d6-7bfd-49b5-8c62-3b66b012db97'),
('165a1e73-18c7-4a70-b966-f0623378bff9', '2b0668e7-3ad6-4514-9bd8-df3500b98f9d', '6829c2fa-7912-4c61-a747-a730e8bd9188'),
('1af00226-5e52-4ece-ad7a-ca25b0504a78', 'c3b929c2-2637-43de-8ee5-e693afa7a76f', '46d631d6-7bfd-49b5-8c62-3b66b012db97'),
('1feb3996-53f3-443e-81f0-c0800820ff14', 'dc666b13-02a7-4acb-8892-3401d2c26313', '46d631d6-7bfd-49b5-8c62-3b66b012db97'),
('21d4c1b5-6f52-4b29-b7ea-df2fa68ee4a7', '404800e0-2338-4f33-8eb1-efa55c208a67', '6829c2fa-7912-4c61-a747-a730e8bd9188'),
('22d7ec83-9be4-4ccd-9fff-18cdb80b2c2e', '289a516b-92a4-4b99-8e11-abcd8ad3cb7e', '46d631d6-7bfd-49b5-8c62-3b66b012db97'),
('22d95c43-49fd-454d-b8fc-61754a301f51', 'e91f3ddc-2096-442f-a943-f74a11e8bf76', '6829c2fa-7912-4c61-a747-a730e8bd9188'),
('22e954e4-ef46-4c30-bd39-5190d78ce915', '867fe386-ebba-462f-8854-af76d56a1875', '6829c2fa-7912-4c61-a747-a730e8bd9188'),
('26631630-3910-42c8-a586-4adbcc481d05', '6ab4dea6-12f0-4c21-9f2b-9ad93bfb0fee', '46d631d6-7bfd-49b5-8c62-3b66b012db97'),
('2bfceed2-b418-4f6c-8709-0c5a8d0b280f', 'a38aeb7c-af0a-4ab8-b4c8-43536e74f292', '6829c2fa-7912-4c61-a747-a730e8bd9188'),
('2d173458-d123-45f8-aade-23b133577f5c', '1543ec64-2fd1-4beb-92e6-86bbd32f4a4a', '46d631d6-7bfd-49b5-8c62-3b66b012db97'),
('2f25eb4e-5f56-4765-acd9-eaa545ea3e23', 'e77d7525-d8d5-4115-8f18-437185d9296d', '46d631d6-7bfd-49b5-8c62-3b66b012db97'),
('2fb9dfe3-f4b5-44b3-a6b4-63598024bd11', '22307959-b216-40b1-8191-2b02288149e7', '6829c2fa-7912-4c61-a747-a730e8bd9188'),
('3557917d-44c0-4801-b764-0bc90d16c589', '710c72cb-3393-41c4-aa4a-03db8ae7fc7f', '6829c2fa-7912-4c61-a747-a730e8bd9188'),
('365df8b2-bc6f-4ec5-8b1c-bb563db99ced', '404800e0-2338-4f33-8eb1-efa55c208a67', '46d631d6-7bfd-49b5-8c62-3b66b012db97'),
('3b3c0e8e-95e4-4ef9-81d2-993d1bff21e0', '228294a4-4633-489a-b421-4fe7e13bdda8', '46d631d6-7bfd-49b5-8c62-3b66b012db97'),
('3e714bae-f9b2-4a9f-9638-7e15446680dd', 'ad93c0eb-be7d-4d07-b383-a94239c3a5ca', '6829c2fa-7912-4c61-a747-a730e8bd9188'),
('3f25ead1-a04d-48b8-a503-8e3b650e4d03', 'ba449d7a-615a-4b3c-8c7e-e34e7e49663b', '46d631d6-7bfd-49b5-8c62-3b66b012db97'),
('3fd6716c-0c9c-40d4-b1a5-7e9a2910e8b9', 'a38aeb7c-af0a-4ab8-b4c8-43536e74f292', '46d631d6-7bfd-49b5-8c62-3b66b012db97'),
('42053410-57d3-47eb-beb0-2c3416a2f5d9', 'd3ec2abc-a6d1-4ba6-a98a-874f69788dda', '6829c2fa-7912-4c61-a747-a730e8bd9188'),
('45366c6e-e9cf-4083-8943-58fcfae22bda', 'e56e0324-7bfc-483f-b0b3-b4d8395c4658', '46d631d6-7bfd-49b5-8c62-3b66b012db97'),
('454ff711-755f-4174-8f91-8eeb8a649f64', 'e4b091bb-28d1-48dc-ae69-f6258dd9dc00', '46d631d6-7bfd-49b5-8c62-3b66b012db97'),
('4d0b4fff-ada1-4d91-858f-bc17a601a1c5', 'cd9dbb8c-1393-4b56-a4b3-7d7e592c80d2', '46d631d6-7bfd-49b5-8c62-3b66b012db97'),
('5364ecb9-5a67-4ef1-993f-570f93bc8fb7', 'a087f028-4f53-4b35-9dc1-da64fbca397d', '6829c2fa-7912-4c61-a747-a730e8bd9188'),
('567ab10c-ff95-41e5-8ba2-c08235247a6a', '688a3f17-1cc5-432c-a65a-29d844f54638', '46d631d6-7bfd-49b5-8c62-3b66b012db97'),
('56cb8a60-d0d8-4cc4-a082-4922472bc112', 'e56e0324-7bfc-483f-b0b3-b4d8395c4658', '6829c2fa-7912-4c61-a747-a730e8bd9188'),
('59851a55-212e-4d93-b99b-b021d0fe7694', '14d69f0e-3565-429e-bc85-9d16b363fa69', '46d631d6-7bfd-49b5-8c62-3b66b012db97'),
('64722059-962d-49dd-83a3-9a7d67d33a25', '521651bd-1f19-4683-8fff-6f3dfe86499b', '46d631d6-7bfd-49b5-8c62-3b66b012db97'),
('65672974-581c-461f-810e-75d58b9123d3', '8bb2edc7-75e4-4c08-a24a-fedefef919a6', '46d631d6-7bfd-49b5-8c62-3b66b012db97'),
('660faa13-6079-4bfb-aa52-ee2f03a38008', '987fa07d-2772-4b9c-acdf-e65e9f55c318', '46d631d6-7bfd-49b5-8c62-3b66b012db97'),
('6b9efb6b-c2ad-4593-a819-950b1a22d103', '2a80aa89-1e29-4930-a2f2-d0e2bec8d9ae', '6829c2fa-7912-4c61-a747-a730e8bd9188'),
('6e3f8c3c-e7da-4343-86e9-951ec5402af4', '6b8ee1b1-acb9-4e3f-8125-541fc135c9c3', '6829c2fa-7912-4c61-a747-a730e8bd9188'),
('6e84c5a1-651d-4410-8cea-789a6413effe', '7cc50275-c1b6-4c5f-8f95-98d560d269cf', '6829c2fa-7912-4c61-a747-a730e8bd9188'),
('748e1d17-7958-4ef8-919a-b03bd2b05cc1', '84889a1a-2d11-41c9-9540-78e3a261d53d', '46d631d6-7bfd-49b5-8c62-3b66b012db97'),
('78764555-798d-4501-a360-9784c28aec52', 'fc199407-cdf4-48ea-80b0-cc803052f0e4', '46d631d6-7bfd-49b5-8c62-3b66b012db97'),
('7e92e7d9-43c8-41fa-81b6-3d6d9e4b0817', '9c0952f8-ed1c-4c1b-adfd-cf0ab8c717b5', '46d631d6-7bfd-49b5-8c62-3b66b012db97'),
('8375e9d5-fb94-4a6a-9487-668699a5f6c3', 'a087f028-4f53-4b35-9dc1-da64fbca397d', '46d631d6-7bfd-49b5-8c62-3b66b012db97'),
('874636bd-a39e-4048-b1ad-faf2ae9c9623', '4ac35949-48db-4045-93b4-d1542e1c5bb0', '6829c2fa-7912-4c61-a747-a730e8bd9188'),
('89f7e552-57cb-4c4d-b991-cbbb1318f19e', '289a516b-92a4-4b99-8e11-abcd8ad3cb7e', '6829c2fa-7912-4c61-a747-a730e8bd9188'),
('8d9dc892-8189-4fbb-a9fe-5736506b6428', '4c27db81-2a84-4b1d-9595-030e918960b5', '6829c2fa-7912-4c61-a747-a730e8bd9188'),
('91eb3511-499a-414d-af7b-5afdcbba02ec', 'e91f3ddc-2096-442f-a943-f74a11e8bf76', '46d631d6-7bfd-49b5-8c62-3b66b012db97'),
('943f2b24-e3ee-434b-a7bd-4d67c685bd48', 'c86229c8-9bff-4a71-9bc4-50e1fb68914a', '46d631d6-7bfd-49b5-8c62-3b66b012db97'),
('9c43cfd6-8dd7-4d55-97bc-afba4415dd55', 'dc666b13-02a7-4acb-8892-3401d2c26313', '6829c2fa-7912-4c61-a747-a730e8bd9188'),
('9c7cc94d-d1ee-49c5-9b65-572adbf1b0c3', '6ab4dea6-12f0-4c21-9f2b-9ad93bfb0fee', '6829c2fa-7912-4c61-a747-a730e8bd9188'),
('9d3b5e67-8ac1-47b6-8835-fea557de130d', '5a516de6-ad95-4f30-8fb8-8891029ba719', '6829c2fa-7912-4c61-a747-a730e8bd9188'),
('9d9d3cb7-8a9c-44fb-b57d-3d6bfe99da59', '9e849aa1-6026-4f2a-ab37-0602e9295f56', '46d631d6-7bfd-49b5-8c62-3b66b012db97'),
('9f3009b4-c9ba-4645-a0e5-f339fbc2515f', '1543ec64-2fd1-4beb-92e6-86bbd32f4a4a', '6829c2fa-7912-4c61-a747-a730e8bd9188'),
('acb0e28b-7675-4dba-b4c0-98ad25afb1f5', 'a7425923-57f3-404c-a80a-06b7c3f8b78f', '6829c2fa-7912-4c61-a747-a730e8bd9188'),
('b151b5a3-2a52-4343-86bd-c6a8c9454fdc', '7ad832a3-1177-4e67-ad89-8356da8aadf6', '6829c2fa-7912-4c61-a747-a730e8bd9188'),
('bb46d088-4599-4022-ac58-7e6bac325c1e', '068f2ac3-6189-4318-954f-f52810b80428', '46d631d6-7bfd-49b5-8c62-3b66b012db97'),
('bf6ef6ae-a858-45d4-8d97-4200498e944b', '2b0668e7-3ad6-4514-9bd8-df3500b98f9d', '46d631d6-7bfd-49b5-8c62-3b66b012db97'),
('bf911edd-b373-44f1-8153-b3f429090eb4', 'f76e3686-0011-4967-8dc1-239ad5e948c4', '6829c2fa-7912-4c61-a747-a730e8bd9188'),
('d4e7a59f-4a7e-4c91-be4a-ec127c8723dd', '377b9c39-25a2-40d6-bd6b-7a19075c72f4', '6829c2fa-7912-4c61-a747-a730e8bd9188'),
('d8407765-3a73-4d8f-a142-b7e28a9cefb5', '22307959-b216-40b1-8191-2b02288149e7', '46d631d6-7bfd-49b5-8c62-3b66b012db97'),
('dba194fd-5332-43eb-8451-344be8587083', '987fa07d-2772-4b9c-acdf-e65e9f55c318', '6829c2fa-7912-4c61-a747-a730e8bd9188'),
('dcd58892-ef18-4f04-914c-c4ba23222559', '002fda15-5d1d-4b1f-bb9b-f608bbfa9db1', '46d631d6-7bfd-49b5-8c62-3b66b012db97'),
('ddf7d9a3-9782-44e4-ba58-0bd5c063d968', '7ad832a3-1177-4e67-ad89-8356da8aadf6', '46d631d6-7bfd-49b5-8c62-3b66b012db97'),
('e400d9c5-f924-40ac-896a-1c2025850fbd', 'e697910d-f89b-48cb-875c-2258e6cc6924', '46d631d6-7bfd-49b5-8c62-3b66b012db97'),
('e5adc4df-6634-4a9d-bb96-2de2cacc1cb1', 'ad93c0eb-be7d-4d07-b383-a94239c3a5ca', '46d631d6-7bfd-49b5-8c62-3b66b012db97'),
('e7e8a49d-06df-4c3f-8059-589f23bafe1f', 'e6120330-baad-491a-a034-d1186d57d4fd', '6829c2fa-7912-4c61-a747-a730e8bd9188'),
('eb3de970-efae-4af3-a231-2db59ce9625a', 'f76e3686-0011-4967-8dc1-239ad5e948c4', '46d631d6-7bfd-49b5-8c62-3b66b012db97'),
('ed74417e-dbf8-4c9e-942b-d567c23255ea', 'ba449d7a-615a-4b3c-8c7e-e34e7e49663b', '6829c2fa-7912-4c61-a747-a730e8bd9188'),
('ee826a4e-2afd-4045-b984-aa569ea0bdc0', '3d58d00e-fe8c-4315-a9f7-9ae695f13c80', '46d631d6-7bfd-49b5-8c62-3b66b012db97'),
('f8d28a45-f57d-4c88-b187-42f4cc15fc1e', '068f2ac3-6189-4318-954f-f52810b80428', '6829c2fa-7912-4c61-a747-a730e8bd9188'),
('fec7e12c-1d13-4084-ad0c-66537f8ae410', '3d58d00e-fe8c-4315-a9f7-9ae695f13c80', '6829c2fa-7912-4c61-a747-a730e8bd9188');

-- --------------------------------------------------------

--
-- Table structure for table `agency_advertisement`
--

CREATE TABLE `agency_advertisement` (
  `agency_advertisement_id` varchar(50) NOT NULL,
  `agency_id` varchar(50) NOT NULL,
  `advertisement_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `agency_advertisement`
--

INSERT INTO `agency_advertisement` (`agency_advertisement_id`, `agency_id`, `advertisement_id`) VALUES
('0331d01d-ee3d-44c7-ba73-1bf53aef4cb0', '919632357734', '987fa07d-2772-4b9c-acdf-e65e9f55c318'),
('0710c8a8-876b-4bbb-94aa-01b92e8862b4', '91456565878123', 'e4b091bb-28d1-48dc-ae69-f6258dd9dc00'),
('07d5e861-98de-4828-8cf5-eb81904be224', '254708956980', '2b0668e7-3ad6-4514-9bd8-df3500b98f9d'),
('09e40521-0a99-4457-b8f5-60eb29ca5626', '91918867528736', 'a087f028-4f53-4b35-9dc1-da64fbca397d'),
('14bbb5fb-e9e1-4368-90aa-ffe4fa41a0ee', '919629108196', 'f76e3686-0011-4967-8dc1-239ad5e948c4'),
('2798c3ba-2efa-41a4-b054-5f71e2fe07c7', '919629108196', '14d69f0e-3565-429e-bc85-9d16b363fa69'),
('2a34cf9e-4f3d-49a7-b4ae-2b2d1ac1f171', '91123123456456', '8bb2edc7-75e4-4c08-a24a-fedefef919a6'),
('34a8e205-e72f-43c7-a6da-90ae80880ebc', '91123123456456', '688a3f17-1cc5-432c-a65a-29d844f54638'),
('34fb50e9-28b1-4c87-96c4-d2904f8f1fb0', '91456565878123', 'a7425923-57f3-404c-a80a-06b7c3f8b78f'),
('35f5174d-7462-422f-9efc-97784fb4e14e', '91123123456456', '228294a4-4633-489a-b421-4fe7e13bdda8'),
('36ab0241-23b9-46b2-a03b-f2d8ec1c42bc', '919629108196', '5a516de6-ad95-4f30-8fb8-8891029ba719'),
('3a4cbf75-00b6-4fbc-bf8f-77d6835c4887', '919629108196', 'c3b929c2-2637-43de-8ee5-e693afa7a76f'),
('3b5ec8b8-b125-40c3-9f94-9353c8ce9b73', '91456565878123', 'a84db697-00d9-45da-b75e-31b17de90dde'),
('3fe366ee-939c-44be-b5c8-47a8258387ae', '919629108196', 'a38aeb7c-af0a-4ab8-b4c8-43536e74f292'),
('43dbcc56-3455-482d-88c4-f4a2109407a4', '91123123456456', 'e77d7525-d8d5-4115-8f18-437185d9296d'),
('4f6ee86a-54ea-476a-bc27-3def9f64ede2', '918151913750', 'e91f3ddc-2096-442f-a943-f74a11e8bf76'),
('50122f90-eca9-4ba9-9647-e20ff3ea6218', '919629108196', '2a80aa89-1e29-4930-a2f2-d0e2bec8d9ae'),
('510dc483-165b-4269-b846-2e338c22a542', '919629108196', 'e56e0324-7bfc-483f-b0b3-b4d8395c4658'),
('51fb26c6-1f39-417b-9d84-91e819d81707', '919629108196', 'ad93c0eb-be7d-4d07-b383-a94239c3a5ca'),
('53952158-9367-4f74-8b19-d36122874327', '91123123456456', 'deba7ae1-005b-4a22-becb-54e20f455df6'),
('53a7f92e-3a97-4387-b0a3-8bdea329edf6', '91123123456456', 'c86229c8-9bff-4a71-9bc4-50e1fb68914a'),
('55107435-f648-4983-b19e-284db356baaa', '919629108196', '7ad832a3-1177-4e67-ad89-8356da8aadf6'),
('55857748-c556-4f79-8aa4-06010f6d30bc', '91918867528736', '3d58d00e-fe8c-4315-a9f7-9ae695f13c80'),
('5ecfcb6d-7201-42eb-919a-508da2aee005', '919629108196', 'dc666b13-02a7-4acb-8892-3401d2c26313'),
('5f926eaa-69ba-48ea-a536-92a520144456', '919629108196', '84889a1a-2d11-41c9-9540-78e3a261d53d'),
('7847dff2-5449-4b5c-a9e3-a158bed57c1f', '9165534534534534', '377b9c39-25a2-40d6-bd6b-7a19075c72f4'),
('7b049f1c-3a04-4396-a980-58683352379b', '918151913750', '404800e0-2338-4f33-8eb1-efa55c208a67'),
('818565b8-e2b3-40ab-8ca7-ed18e3fe5d6e', '91123123456456', '521651bd-1f19-4683-8fff-6f3dfe86499b'),
('8b160bd2-2799-4654-a34b-6a76e9c97ed3', '91456565878123', '4c27db81-2a84-4b1d-9595-030e918960b5'),
('8e9b0e0c-42d1-4fc2-855c-4fae1839ebfd', '91918867528736', '289a516b-92a4-4b99-8e11-abcd8ad3cb7e'),
('965b9dbc-8800-474f-b32f-0a6ca12c1550', '919629108196', '7cc50275-c1b6-4c5f-8f95-98d560d269cf'),
('b8e8f1f6-1a7f-4af5-908d-7697c5466c4f', '91123123456456', '002fda15-5d1d-4b1f-bb9b-f608bbfa9db1'),
('b9c621aa-6442-4c2b-b2b3-6ef94a74bff4', '91123123456456', 'e6120330-baad-491a-a034-d1186d57d4fd'),
('c53aa374-9ffb-4d46-873c-82a36f99e212', '91456565878123', '867fe386-ebba-462f-8854-af76d56a1875'),
('c6c4a9bc-d07f-4242-8983-49827937ef93', '919629108196', '4ac35949-48db-4045-93b4-d1542e1c5bb0'),
('cacc38b7-6156-4337-b02e-bae5e975c6bd', '91456565878123', '068f2ac3-6189-4318-954f-f52810b80428'),
('d805d233-7837-44e1-8b3e-6b1416933d09', '91123123456456', 'd3ec2abc-a6d1-4ba6-a98a-874f69788dda'),
('e6f6ed7c-5350-453c-96b5-79d6fe94a95f', '91123123456456', 'e697910d-f89b-48cb-875c-2258e6cc6924'),
('e775f363-2ca1-4f41-b3c8-ecead3c10109', '91123123456456', '9c0952f8-ed1c-4c1b-adfd-cf0ab8c717b5'),
('ef5fa31d-fafb-4158-846a-11188ddd957d', '91123123456456', '710c72cb-3393-41c4-aa4a-03db8ae7fc7f'),
('ef9268aa-86c0-42eb-92c1-2416645c5bfa', '918151913750', '22307959-b216-40b1-8191-2b02288149e7'),
('f0199139-dd83-4fae-96cb-81ace525e734', '91456565878123', '6b8ee1b1-acb9-4e3f-8125-541fc135c9c3'),
('f3d11edf-6175-448a-b1dc-6fc6aa60412d', '919629108196', '6ab4dea6-12f0-4c21-9f2b-9ad93bfb0fee'),
('fadde102-8363-4d50-9a98-f348ae2c06ba', '919632357734', '1543ec64-2fd1-4beb-92e6-86bbd32f4a4a'),
('fcefbd36-cf1b-44b2-9093-9cfb4f3bac21', '91456565878123', '9e849aa1-6026-4f2a-ab37-0602e9295f56'),
('fd1e6d62-55b4-41da-a78b-8d8db60a9319', '91123123456456', 'cd9dbb8c-1393-4b56-a4b3-7d7e592c80d2');

-- --------------------------------------------------------

--
-- Table structure for table `age_group`
--

CREATE TABLE `age_group` (
  `age_group_id` varchar(50) NOT NULL,
  `age_group_min` int(11) NOT NULL,
  `age_group_max` int(11) NOT NULL,
  `age_group_description` varchar(250) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_user_id` varchar(50) NOT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `isactive` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `age_group`
--

INSERT INTO `age_group` (`age_group_id`, `age_group_min`, `age_group_max`, `age_group_description`, `created_date`, `modified_user_id`, `modified_date`, `isactive`) VALUES
('0261626e-5d8f-4a57-9afc-105a56955bcd', 0, 5, '0-5', '2017-05-25 13:12:50', '919900001201', '2017-10-04 13:34:58', 1),
('156bcba5-03d4-4b00-b3c0-b44974239fa4', 21, 25, '21-25', '2017-07-28 18:34:40', '919900001201', '2017-07-28 13:04:40', 1),
('4a1dbdba-bfe9-4f6c-9e80-43d1ccf7886f', 10, 13, '10-13', '2017-10-04 18:11:01', '919900001201', '2017-10-04 12:41:01', 1),
('4d6d18b8-ff0a-4b6a-8114-1f612e20dca9', 10, 15, '10-15', '2017-08-08 16:47:50', '919900001201', '2017-08-08 11:17:50', 1),
('50ec8a81-418d-47ee-b157-e2412d605915', 8, 13, '8-13', '2017-08-08 12:50:57', '919900001201', '2017-08-10 06:17:38', 1),
('5de825ba-4c95-41db-81ba-766270542cac', 25, 30, '25-30', '2017-10-04 18:09:57', '919900001201', '2017-10-04 12:39:57', 1),
('67097bbf-78ce-4c92-bde9-91d436857bfd', 6, 11, '6-11', '2017-08-08 11:49:06', '919900001201', '2017-08-10 06:17:57', 1),
('67204d54-7481-441d-a49a-898edd5218a3', 6, 12, '6-12', '2017-09-26 17:10:30', '919900001201', '2017-09-26 11:40:30', 1),
('89a54a33-2982-4985-930a-5b52e29e44d8', 41, 45, '41-45', '2017-05-23 17:14:56', '123456', '2017-08-10 10:02:48', 1),
('8a9d2567-a07f-4c69-a910-2adb20b4afb7', 56, 60, '56-60', '2017-07-31 17:31:20', '919900001201', '2017-07-31 12:10:22', 1),
('8d71e6f3-73f8-40d2-a2c5-3eb32e725ca9', 5, 10, '  5-10 ', '2017-05-23 17:03:08', '919900001201', '2017-07-31 11:57:18', 1),
('9d39994a-000f-4bf1-858c-a89012184dc3', 11, 15, '11-15', '2017-05-23 17:03:31', '123456', '2017-05-23 11:33:31', 1),
('a5961401-4745-4871-9467-b7c1eda4a7f0', 16, 20, '16-20', '2017-05-23 17:04:00', '123456', '2017-05-23 11:34:00', 1),
('ad8246fd-71ca-45ab-9977-c55c01d84743', 31, 35, '31-35', '2017-05-23 17:14:31', '123456', '2017-05-23 11:44:31', 1),
('afb46247-20a6-4e9c-9415-a890822369f9', 70, 75, '70-75', '2017-09-26 18:30:45', '919900001201', '2017-09-26 13:00:45', 1),
('ba7a2207-6516-4ad7-8ad0-bc224ff58afc', 75, 80, '75-80', '2017-09-27 15:55:54', '919900001201', '2017-09-27 10:25:54', 1),
('bd945133-4c1d-4788-a094-c8244480c33f', 35, 40, '35-40', '2017-05-23 17:14:45', '123456', '2017-05-23 11:44:45', 1),
('c4c342d9-1c9b-4169-b43e-44d583068b69', 1, 9, '01-09', '2017-09-27 15:31:30', '919900001201', '2017-11-20 14:21:23', 0),
('cfc2a11e-52f3-43de-95ab-e86b68a0a747', 50, 55, '50-55', '2017-07-28 17:39:04', '919900001201', '2017-07-31 12:00:46', 1),
('d2020239-2689-4cdf-8c53-7bf480956c6e', 26, 30, '26-30', '2017-05-23 17:14:02', '123456', '2017-05-23 11:44:02', 1),
('ec6fa0cd-5e1c-47b4-8d26-33811469abd9', 6, 10, '6-10', '2017-08-08 16:49:24', '919900001201', '2017-08-08 11:19:24', 1),
('fb2978f1-5a8d-4a83-bab3-21f2253ea8ec', 46, 50, '46-50', '2017-05-23 17:15:12', '123456', '2017-05-23 11:45:12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `business_channel_approval`
--

CREATE TABLE `business_channel_approval` (
  `business_channel_approval_id` varchar(50) NOT NULL,
  `channel_id` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_user_id` varchar(50) NOT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` varchar(50) NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `category_created_user_id` varchar(50) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_user_id` varchar(50) NOT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `isactive` tinyint(1) NOT NULL,
  `category_image` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `category_created_user_id`, `created_date`, `modified_user_id`, `modified_date`, `isactive`, `category_image`) VALUES
('0056fb4f-f9c8-4d69-94cd-d314d35fc880', 'Travel and Leisure', '123456', '2017-05-23 17:16:18', '123456', '2017-07-12 12:27:52', 1, 'category/a40f3c13a4c44845929d98df20f29012.jpg'),
('0724033a-f1a0-4283-95b0-15b293a90008', 'freestyle', '919900001201', '2017-07-31 16:26:09', '919900001201', '2017-11-17 07:15:14', 0, 'category/e074b5c56f3f45ff90f3d580e66ced11.jpg'),
('0c32093d-fe09-41fb-a672-c48068a44a1f', 'Backend Test', '919623257734', '2017-07-28 15:06:53', '919623257734', '2017-09-25 12:30:36', 1, 'category/0c32093dfe0941fba672c48068a44a1f.jpg'),
('15d63c5e-6638-4b9e-90bb-1ae6da20ec5b', 'calendar event', '9632357734', '2017-09-25 18:04:39', '9632357734', '2017-10-05 10:21:29', 1, 'category/30f93f3f66db4295a496317ce961e0d1.jpg'),
('2076ee4e-2d97-43fe-adfc-43549026df94', 'test cate7', '919900001201', '2017-10-05 12:39:44', '919900001201', '2017-10-05 07:09:44', 1, ''),
('25ecd496-80a7-4f3c-8a7b-59192a31a85e', 'test cate', '919900001201', '2017-10-05 12:02:49', '919900001201', '2017-10-05 06:32:49', 1, ''),
('272f956d-110d-4d20-8894-bee840fc1333', 'Sports', '123456', '2017-05-23 17:17:46', '123456', '2017-07-12 12:28:56', 1, 'category/980d4752ad2f4916b369e8dc1f819e5f.jpg'),
('31cb2d4a-bcac-4322-91d4-a89728c8dbe2', 'Electronics', '123456', '2017-05-23 17:17:20', '123456', '2017-07-12 12:31:58', 1, 'category/b4a2b733e8c347229451fc3ffe30f3c7.jpg'),
('3a273f95-7616-4a2c-b098-189009af3547', '\"Testing flowers..\"', '254700894563', '2017-10-05 11:35:07', '254700894563', '2017-11-14 09:19:47', 1, 'category/2d35c5c22b39454b9edae98a3acfeab4.jpg'),
('3a2f0ac7-08d6-4957-9b31-aa8fbacc58fb', 'test cate8', '919900001201', '2017-10-05 12:41:41', '919900001201', '2017-10-05 07:11:41', 1, ''),
('3d712750-6408-4b47-ac59-621979218b13', 'test cate5', '919900001201', '2017-10-05 12:30:36', '919900001201', '2017-10-05 07:00:36', 1, ''),
('3eab2840-3d74-439b-8195-b3e33f3c1d25', 'test cate3', '919900001201', '2017-10-05 12:25:13', '919900001201', '2017-10-05 06:55:13', 1, ''),
('3fa2aca6-35fa-4945-bf6c-f3ad54bf12c3', 'some image', '919900001201', '2017-10-05 13:11:14', '919900001201', '2017-10-05 07:41:14', 1, ''),
('430e343a-f112-4c9e-896a-f6af89fd3fa9', 'a', '919900001201', '2017-11-08 17:44:08', '919900001201', '2017-11-17 10:43:38', 0, 'category/430e343af1124c9e896af6af89fd3fa9.png'),
('437dbff4-5734-4f79-bcf0-c47a4bfd4acf', 'Wild Life', '919964213456', '2017-07-12 13:24:47', '919964213456', '2017-07-12 12:42:07', 1, 'category/8ec0d043b1a442bd9fa8fe6b1f5b8cd8.jpg'),
('4a9207e6-581f-4130-82d8-a78c15f0cb12', 'Food', '123456', '2017-05-23 17:16:37', '123456', '2017-07-12 12:36:31', 1, 'category/67bf76b9aaac4620846a5129c8a7c834.jpg'),
('4eb47991-f6a3-401f-85d5-44296f5583e7', 'Test', '919900001201', '2017-11-20 19:47:11', '919900001201', '2017-11-20 14:17:11', 1, 'category/4eb47991f6a3401f85d544296f5583e7.jpg'),
('5c76b059-2150-4508-8181-b7cb13569128', 'Fashion', '254798523654', '2017-05-31 16:31:38', '254798523654', '2017-07-12 12:38:25', 1, 'category/acdad581b0ce41a48e38c29b55bdcf46.jpg'),
('60ed68ce-a91c-4bf3-b7e8-8d16678e7b2a', 'Luxury', '123456', '2017-05-23 17:17:56', '123456', '2017-07-12 12:40:57', 1, 'category/f560ccc8c72542029663fa16e1a0a444.jpg'),
('71180ac7-4637-46c1-ac63-1a19fbdbc2d0', 'Cat', '919900001201', '2017-10-04 18:10:49', '919900001201', '2017-11-20 14:20:10', 0, ''),
('81a54574-3562-4479-8930-948becbb29e5', 'test jhgjhg 123', '919900001201', '2017-10-05 15:11:05', '919900001201', '2017-10-05 09:41:05', 1, 'category/81a54574356244798930948becbb29e5.jpg'),
('82db2499-66ac-4626-9a4d-805b73d37d80', 'Comics', '919900001201', '2017-11-06 16:49:30', '919900001201', '2017-11-07 05:01:03', 1, 'category/82db249966ac46269a4d805b73d37d80.png'),
('86d8e5c9-f060-406d-b914-7396d860ad01', 'Testing Category line', '919900001201', '2017-10-10 14:16:12', '919900001201', '2017-10-10 08:46:12', 1, 'category/86d8e5c9f060406db9147396d860ad01.jpg'),
('8b54acae-99f2-4f0c-b1a1-66af1a27fd74', 'Festival', '919900001201', '2017-11-17 16:14:03', '919900001201', '2017-11-17 10:44:03', 1, 'category/8b54acae99f24f0cb1a166af1a27fd74.jpg'),
('9087e119-1e7e-45cf-99a0-1b35421290ec', 'Travel Trekking', '919900001201', '2017-07-28 13:07:18', '919900001201', '2017-07-31 12:09:29', 0, 'category/9087e1191e7e45cf99a01b35421290ec.png'),
('929b8d96-2e1d-459b-94fc-d36f78ff8613', 'test cate4', '919900001201', '2017-10-05 12:26:19', '919900001201', '2017-10-05 06:56:19', 1, ''),
('a7c5e131-1ca2-4ee2-a7fa-79708af5dfd3', 'test cat2', '919900001201', '2017-10-05 12:12:11', '919900001201', '2017-10-05 06:42:11', 1, ''),
('aae19cb0-8ca5-458d-9d52-c6f7a1471a45', 'Health', '123456', '2017-05-23 17:18:26', '123456', '2017-07-12 12:34:14', 1, 'category/e33520dc194d4f5bb78b3c2f216f8a8a.jpg'),
('af77206a-6915-4016-a338-1b6dcf5470ad', 'my new category', '919900001201', '2017-10-05 15:15:56', '919900001201', '2017-10-05 09:45:56', 1, 'category/af77206a69154016a3381b6dcf5470ad.jpg'),
('b891aa9f-547a-4f48-958e-cc219561f4d3', 'Its just for testing . we will delete it later.hhk', '919623257734', '2017-07-28 15:15:55', '919623257734', '2017-07-31 12:09:03', 0, 'category/b891aa9f547a4f48958ecc219561f4d3.jpg'),
('c17ebb5d-84de-498a-a90c-f15d9acaeb71', 'Contacts', '919900001201', '2017-11-16 19:08:56', '919900001201', '2017-11-16 13:40:40', 1, 'category/3ad0a61ece2d45288cb06907c2f98936.png'),
('cbb09157-8a25-4f11-9198-15211de7c551', 'Sale test', '919900001201', '2017-10-04 17:25:12', '919900001201', '2017-11-17 07:14:36', 1, 'category/3dfebe3a9511405b93bf172ac4affb61.jpg'),
('d5fff639-0eee-4bab-be15-72565f908c88', 'test cate6', '919900001201', '2017-10-05 12:33:56', '919900001201', '2017-10-05 07:03:56', 1, ''),
('d9cac201-3de9-4915-800f-1d1305454be9', 'Tuesday fun ', '919623257734', '2017-07-28 15:08:25', '919623257734', '2017-09-26 13:02:41', 1, ''),
('dd5ee611-4f3c-4942-96e2-a752ef589fff', 'test my category', '919900001201', '2017-07-28 15:13:44', '919900001201', '2017-07-31 12:09:19', 0, ''),
('df2305f7-4bf1-445b-9b9d-1e87a2baadc6', 'Infrastructure', '123456', '2017-05-23 17:18:31', '123456', '2017-07-12 12:43:27', 1, 'category/def75cd4533b4a9682da5170589c6396.jpg'),
('e2497a04-a2ce-4d39-ae42-b718d15fcb97', '\"testing image upload\"', '254700894563', '2017-10-04 17:48:45', '254700894563', '2017-11-20 14:19:44', 1, 'category/cb7d89b2855345ad8ef99115d7299e4a.jpg'),
('eb7b0030-7de7-4d12-a346-0f0fd2a54f5c', 'some cte wit image', '919900001201', '2017-10-05 13:10:27', '919900001201', '2017-10-05 07:40:27', 1, ''),
('f0f70b26-2053-4686-bc3b-48e4f67cf835', 'inactive category', '919900001201', '2017-07-28 15:14:34', '919900001201', '2017-07-28 09:44:34', 0, ''),
('f49612b2-37b6-4f89-966a-16af1600440e', 'Its just for testing . we will delete it', '919623257734', '2017-07-28 15:09:23', '919623257734', '2017-07-28 09:39:23', 0, ''),
('fc918903-a5f8-4d31-9d6a-d40298846324', 'Dance Dance', '919900001201', '2017-07-28 17:39:35', '919900001201', '2017-07-31 10:50:04', 0, ''),
('fcfe1690-f261-4ccf-a7d3-ada5340f74dc', 'Plastic items', '919900001201', '2017-11-07 10:31:44', '919900001201', '2017-11-07 05:01:44', 1, 'category/fcfe1690f2614ccfa7d3ada5340f74dc.png'),
('fdcbb313-dc74-4388-9d5d-381f4e03c51a', 'test cat1', '919900001201', '2017-10-05 12:11:13', '919900001201', '2017-10-05 06:41:13', 1, ''),
('fe2b649f-2cc4-424c-af71-0095e5823b05', 'Life Style', '123456', '2017-05-23 17:16:33', '123456', '2017-07-12 12:40:02', 1, 'category/a8d6250d658b47c38e4b07eab792a9cb.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `channels`
--

CREATE TABLE `channels` (
  `channel_id` varchar(50) NOT NULL,
  `channel_created_user_id` varchar(50) NOT NULL,
  `channel_title` varchar(50) NOT NULL,
  `channel_profile_image_path` text NOT NULL,
  `channel_description` longtext NOT NULL,
  `channel_prefer_gender` varchar(5) DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `modified_user_id` varchar(50) NOT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `isactive` tinyint(1) NOT NULL,
  `category_id` varchar(50) NOT NULL,
  `start_date` timestamp NULL DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `channels`
--

INSERT INTO `channels` (`channel_id`, `channel_created_user_id`, `channel_title`, `channel_profile_image_path`, `channel_description`, `channel_prefer_gender`, `created_date`, `modified_user_id`, `modified_date`, `isactive`, `category_id`, `start_date`, `end_date`) VALUES
('00a042bf-765e-42e9-b586-5e34cfb3abce', '9198745698785', 'Genelia', '', 'PJ channel', NULL, '2018-02-02 15:32:46', '9198745698785', '2018-02-02 10:02:46', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('03f3f166-c138-4065-b070-2f07921020fa', '919632357734', 'November 21', '03f3f166-c138-4065-b070-2f07921020fa/profile/8440240d74ba4689800b8d89749fc891.png', 'Let the joy in your heart overflow and water everyone you meet.', NULL, '2017-11-21 12:06:54', '919632357734', '2017-11-21 06:36:54', 1, '8b54acae-99f2-4f0c-b1a1-66af1a27fd74', NULL, NULL),
('055b21ff-4160-4900-be76-235bb25e384d', '9112300012300', 'abc abc', '055b21ff-4160-4900-be76-235bb25e384d/profile/3e871a7407ba483aa9952cc5d438f00b.png', 'test etst hghghj hghjg jhgjhg ', NULL, '2017-12-29 17:43:41', '9112300012300', '2017-12-29 12:13:41', 1, '60ed68ce-a91c-4bf3-b7e8-8d16678e7b2a', '2017-12-29 00:00:00', '2017-12-30 00:00:00'),
('0d468b4e-2f8f-4b42-b5dc-2a2a54061683', '9112300012300', 'test12345', '', 'test', NULL, '2017-11-17 18:01:08', '9112300012300', '2017-11-17 12:31:08', 1, '31cb2d4a-bcac-4322-91d4-a89728c8dbe2', NULL, NULL),
('13dab5c8-ae95-4794-ab71-063bf0117cd8', '254780859859', 'Shilpa', '', 'User channel', NULL, '2018-02-22 13:09:46', '254780859859', '2018-02-22 07:39:46', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('16486658-61bd-41a5-9273-a87a55907912', '919988665544', 'test12', '16486658-61bd-41a5-9273-a87a55907912/profile/01aabf656202462b9e2a5eef741bc1f1.png', 'test', NULL, '2017-11-20 17:07:47', '919988665544', '2017-11-20 11:37:47', 1, 'df2305f7-4bf1-445b-9b9d-1e87a2baadc6', NULL, NULL),
('1659e5e0-51d3-46d2-b7df-737a9c64843b', '919988776655', 'loosuuu kokuuu', '1659e5e0-51d3-46d2-b7df-737a9c64843b/profile/0d6e51d3810240c8b4c2d95ff4b7594a.png', 'content', NULL, '2017-11-20 16:24:34', '919988776655', '2017-11-20 10:54:34', 1, 'aae19cb0-8ca5-458d-9d52-c6f7a1471a45', NULL, NULL),
('19a3d480-feca-4686-8bec-b5683a1ae8a7', '918151913742', 'Naveenraj 3', '19a3d480-feca-4686-8bec-b5683a1ae8a7/profile/ab411ddd3d974b15b056a93345b645b0.png', 'User channel', NULL, '2017-11-20 14:36:01', '918151913742', '2017-12-20 10:15:22', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('241432c9-61d7-4b5e-8a08-ceb2e278229c', '919632357734', 'shilpa kenya', '241432c9-61d7-4b5e-8a08-ceb2e278229c/profile/394f166a20f94d6bac7900cb1367249e.png', 'testing', NULL, '2017-12-26 16:37:50', '919632357734', '2017-12-26 11:07:50', 1, '3a273f95-7616-4a2c-b098-189009af3547', NULL, NULL),
('28981074-1d4d-4939-94a5-4a8cf0fa6b4f', '91876785675', '6thpj wwww name1', '28981074-1d4d-4939-94a5-4a8cf0fa6b4f/profile/2c6f78294b90493a9872b06d38eca1e7.png', 'This is a channel for PJ', NULL, '2018-02-12 18:13:52', '91876785675', '2018-02-21 07:12:00', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('29128c3f-26ed-419c-8ecc-aea6b7cd9766', '919988665544', 'zcsdssdfdsfdsfdsfsdfsdfsdfsdfsdfsdffwwewewrewrerrw', '29128c3f-26ed-419c-8ecc-aea6b7cd9766/profile/cac685ebb0f94d248b263e2cc8a65aff.png', 'sdfdsffssdfsdfsfd', NULL, '2017-11-20 18:44:35', '919988665544', '2017-11-20 13:14:35', 1, '82db2499-66ac-4626-9a4d-805b73d37d80', NULL, NULL),
('2cbd1987-f380-4032-abf4-8ab9f02bfb16', '919632357737', 'shilpa', '', 'PJ channel', NULL, '2018-01-11 15:15:51', '919632357737', '2018-01-11 09:45:51', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('326b35d3-f345-42f9-8b19-4607e25fcd8e', '91789654123', 'test123pj', '', 'PJ channel', NULL, '2018-02-08 17:06:49', '91789654123', '2018-02-08 11:36:49', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('32bc7c0a-cb79-48be-9e59-b986ee3c78e4', '918892452332', 'Sadiq', '', 'User channel', NULL, '2017-12-18 15:52:01', '918892452332', '2017-12-18 10:22:01', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('3397d6de-d7af-47e6-94f6-e8772af25380', '3456576578687', 'raja', '', 'PJ channel', NULL, '2018-01-05 19:34:51', '3456576578687', '2018-01-05 14:04:51', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('33e38ebb-3b50-41b7-9243-511005bf1774', '917894654666', 'Genelia', '', 'PJ channel', NULL, '2018-02-02 13:26:29', '917894654666', '2018-02-02 07:56:29', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('360cebb5-530f-427c-8f3f-93d3e320ab78', '91123456780', 'pongal festival', '', 'PJ channel', NULL, '2018-01-04 17:48:02', '91123456780', '2018-01-04 12:18:02', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('38069f36-b271-4de9-8227-5edd7276a07d', '911234567890', 'test@name', '', 'jhgfgjfgf', NULL, '2017-11-16 19:56:05', '911234567890', '2017-11-20 06:59:54', 1, '0724033a-f1a0-4283-95b0-15b293a90008', NULL, NULL),
('3a78c0ee-f931-4816-9618-117beaca72a9', '097678678777', 'Atul', '', 'PJ channel', NULL, '2018-01-05 13:07:09', '097678678777', '2018-01-05 07:37:09', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('3bdc8e63-f2ed-41e9-840e-0bccf9a5fc0f', '918523651236', 'Shruthi', '', 'User channel', NULL, '2018-01-16 11:52:02', '918523651236', '2018-01-16 06:22:02', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('3cacfc06-e8d5-4588-b37f-92d9fa0162d6', '997656567', 'abhiii', '', 'PJ channel', NULL, '2018-01-04 18:55:57', '997656567', '2018-01-04 13:25:57', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('3cc415c0-b3ed-4918-a606-e869eecba300', '91852147963', 'TestPj_4', '', 'PJ channel', NULL, '2018-01-11 10:05:02', '91852147963', '2018-01-11 04:35:02', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('3db5ca1e-cc0d-4104-a275-955d2261d193', '9112300012300', 'chanel with image', '', 'hgjhf cfgdfgd jhghjg jhg jhg ', NULL, '2017-11-17 16:43:12', '9112300012300', '2017-11-17 11:13:12', 1, 'aae19cb0-8ca5-458d-9d52-c6f7a1471a45', NULL, NULL),
('439b4525-f668-4c1b-ad6a-80c23196aaaa', '918181818181', 'Eightone', '', 'User channel', NULL, '2017-12-28 19:36:07', '918181818181', '2017-12-28 14:06:07', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('483b2a70-93fc-4343-86dc-1d9eba3f78fa', '9857474747488', 'Naveen', '', 'PJ channel', NULL, '2018-01-05 15:13:36', '9857474747488', '2018-01-05 09:43:36', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('4b6339be-a7c5-4e74-bc1e-239a518dec9c', '918151913750', 'Naveen50', '', 'User channel', NULL, '2017-11-17 16:35:40', '918151913750', '2017-11-17 11:05:40', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('4bce4ae4-3451-497b-8817-f4ac42c49460', '9112300012300', 'test1 channel', '', 'some dummy content here', NULL, '2017-11-17 15:21:16', '9112300012300', '2017-11-17 09:51:16', 1, 'fc918903-a5f8-4d31-9d6a-d40298846324', NULL, NULL),
('50d846e8-366f-4a94-9753-b18b7a8bc4da', '9112300012300', 'pongal', '50d846e8-366f-4a94-9753-b18b7a8bc4da/profile/ce938c5a9f6a49eeb0c3e12197053ad4.png', 'pongal', NULL, '2018-01-04 15:14:18', '9112300012300', '2018-01-04 09:44:18', 1, '5c76b059-2150-4508-8181-b7cb13569128', '2018-01-03 00:00:00', '2018-01-18 00:00:00'),
('51cd92e4-c62c-4fcc-882f-c0942d5cddf3', '91712345678', 'Test PJ _g1', '', 'PJ channel', NULL, '2018-01-09 11:53:43', '91712345678', '2018-01-09 06:23:43', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('53933e18-98e1-4526-9544-61d8302a1112', '918183005820', 'Shruthi', '', 'User channel', NULL, '2018-01-22 11:29:31', '918183005820', '2018-01-22 05:59:31', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('55981906-d119-4759-abda-e0e9542f0d5f', '91987156843', 'TestPj_5', '', 'PJ channel', NULL, '2018-01-15 09:52:45', '91987156843', '2018-01-15 04:22:45', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('562893b7-7619-4f6f-be77-9beb62cf740c', '911234567890', 'devi', '562893b7-7619-4f6f-be77-9beb62cf740c/profile/91dd76633d734d9d80fd90a339d259d9.png', 'devi', NULL, '2017-12-26 18:33:32', '911234567890', '2017-12-26 13:03:32', 1, '5c76b059-2150-4508-8181-b7cb13569128', NULL, NULL),
('59635d64-3643-4b49-9f0e-3ce0f37ca522', '9112300012300', 'tetsssss1111', '', 'jgjhgh hghjgjhg hjgjhg ', NULL, '2017-11-17 16:46:34', '9112300012300', '2017-11-17 11:16:34', 1, '8b54acae-99f2-4f0c-b1a1-66af1a27fd74', NULL, NULL),
('5c1ef7df-8594-4d55-988a-fbf6eb5e41e6', '911234567890', 'test@name', '', 'This is a channel for Virat Kohli', NULL, '2017-11-16 20:01:54', '911234567890', '2017-11-20 06:59:54', 1, '89a54a33-2982-4985-930a-5b52e29e44d8', NULL, NULL),
('5edd618b-b93a-4bb2-b7b3-d3b33c1863d4', '919439398575', 'Chandan', '', 'User channel', NULL, '2017-11-20 18:54:35', '919439398575', '2017-11-20 13:24:35', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('5f42bb12-c914-48e4-8ed9-bd08d71cde12', '9878678687786', 'userred', '', 'PJ channel', NULL, '2018-01-05 19:08:08', '9878678687786', '2018-01-05 13:38:08', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('64078f75-b407-40b6-8231-a54171f78806', '911234567890', 'test@name', '', '22222222222222222222', NULL, '2017-11-16 19:59:15', '911234567890', '2017-11-20 06:59:54', 1, '0724033a-f1a0-4283-95b0-15b293a90008', NULL, NULL),
('641b98ef-6d76-448f-a986-b7031325100d', '91123456789123', 'ghg', '641b98ef-6d76-448f-a986-b7031325100d/profile/acc64573bd124fcc82244705fa1e5a7e.png', 'hghhg', NULL, '2017-11-20 16:14:30', '91123456789123', '2017-11-20 10:44:30', 1, '82db2499-66ac-4626-9a4d-805b73d37d80', NULL, NULL),
('643ebad4-26d5-4ba9-9290-4a8d3ee2de2d', '918105447982', '917708102496', '643ebad4-26d5-4ba9-9290-4a8d3ee2de2d/profile/2b2573c5a8fc438ab3b5dfbb10d8fbdc.png', 'User channel', NULL, '2017-11-17 11:53:50', '918105447982', '2018-02-06 06:39:00', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('64554422-655b-4ced-b640-fa4d85dcb221', '918632357734', 'shilpa', '', 'User channel', NULL, '2017-12-22 12:59:58', '918632357734', '2017-12-22 07:29:58', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('661952f8-57d7-4d5f-b697-406bcc2e0fa3', '254708596536', 'Mani kenya', '', 'User channel', NULL, '2017-11-17 12:11:06', '254708596536', '2017-11-17 06:41:06', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('6670e6d4-2692-48e9-ac61-ce13fde7e4f1', '917894592836', 'TestPj_7', '', 'PJ channel', NULL, '2018-01-17 11:15:49', '917894592836', '2018-01-17 05:45:49', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('68299658-1f56-4cb1-971b-5ebd7773aec2', '9155545455454', 'nazriya', '', 'PJ channel', NULL, '2018-02-02 14:25:59', '9155545455454', '2018-02-02 08:55:59', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('6d64ffe3-fc23-496c-9660-60fbe6cf5722', '944568787', 'KjChannel', '6d64ffe3-fc23-496c-9660-60fbe6cf5722/profile/0512a7e8f1c84569b88a70ece0cefc1f.png', 'This is a channel for pKohli', NULL, '2018-01-17 17:43:24', '944568787', '2018-02-19 11:31:01', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('6d9e24e8-820b-4320-be94-94012619b7c6', '91159789123', 'TestPj_5', '', 'PJ channel', NULL, '2018-01-12 09:31:10', '91159789123', '2018-01-12 04:01:10', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('6dd178b5-e0ca-434a-8a95-97207435bb68', '98877853434', 'devi1', '', 'PJ channel', NULL, '2018-01-05 19:02:10', '98877853434', '2018-01-05 13:32:10', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('76fba5bd-eae6-4f36-a275-f5cc80afbbdd', '919035299524', 'Shilpa', '', 'Life may not be the party', NULL, '2017-11-17 15:17:58', '919035299524', '2017-11-17 11:01:21', 1, '60ed68ce-a91c-4bf3-b7e8-8d16678e7b2a', NULL, NULL),
('7c597a7a-2bea-49ff-9300-1db3e01707fb', '911234567890', 'test@name', '', 'dfsg', NULL, '2017-11-17 12:48:39', '911234567890', '2017-11-20 06:59:54', 1, '0724033a-f1a0-4283-95b0-15b293a90008', NULL, NULL),
('7cd3fe7b-c5c6-45e0-b41e-cfedc923f7e5', '918585858585', 'Eight five', '', 'User channel', NULL, '2017-12-28 12:01:42', '918585858585', '2017-12-28 06:31:42', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('7ce6959e-6997-4eef-8042-4fa645265ece', '91654789321', 'user1', '', 'PJ channel', NULL, '2018-01-05 17:33:52', '91654789321', '2018-01-05 12:03:52', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('8109e664-9fe7-4f79-9575-fdf4219a085b', '918888888888', 'Sadiq 8888888888', '', 'User channel', NULL, '2017-12-20 20:34:35', '918888888888', '2017-12-20 15:04:35', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('820f0869-12b3-4bc3-b2da-6120e277b0ce', '9754545454', 'jkhkjhk', '', 'PJ channel', NULL, '2018-01-17 17:41:58', '9754545454', '2018-01-17 12:11:58', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('83730dc8-b2af-44af-b24e-15b08f89f669', '911234567890', 'tes35454', '83730dc8-b2af-44af-b24e-15b08f89f669/profile/7fe66b38a3e2432abe06342721817c49.png', 'test', NULL, '2017-12-26 18:23:36', '911234567890', '2017-12-26 12:53:36', 1, '5c76b059-2150-4508-8181-b7cb13569128', NULL, NULL),
('8a472886-d9de-4f84-9e74-3916650ed19f', '91741258963', 'TestPj_3', '', 'PJ channel', NULL, '2018-01-10 10:19:27', '91741258963', '2018-01-10 04:49:27', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('8ce708c3-c391-49f2-a323-a84804420380', '919988776655', 'test311', '8ce708c3-c391-49f2-a323-a84804420380/profile/9e9f3011df1d4cdfa51f670ccd5ec8d9.png', 'test311', NULL, '2017-11-20 18:33:18', '919988776655', '2017-11-20 13:03:18', 1, 'b891aa9f-547a-4f48-958e-cc219561f4d3', NULL, NULL),
('8f7ea8b7-c5b5-48f0-bbda-491fef0867ce', '919632357735', 'Shilpa', '', 'User channel', NULL, '2018-02-22 13:08:56', '919632357735', '2018-02-22 07:38:56', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('9ac22c90-1837-471c-98bc-cb82ca898136', '919632357734', 'Shilpa', '', 'User channel for today', NULL, '2017-11-16 19:43:10', '919632357734', '2017-11-20 14:26:18', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('a087a24c-5e7b-40d0-8e41-9cdc106d0adb', '254708985698', 'Jaffar', '', 'User channel', NULL, '2018-02-22 13:16:53', '254708985698', '2018-02-22 07:46:53', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('a09abc52-3c57-4627-aa2a-ac8c61ac6d1f', '911234567890', 'Sportsss', '', 'This is a channel for Virat Kohli', NULL, '2017-12-26 18:30:39', '911234567890', '2017-12-26 13:00:39', 1, '89a54a33-2982-4985-930a-5b52e29e44d8', '2017-12-11 00:00:00', '2017-12-30 00:00:00'),
('a0e6aef5-f5f7-4850-bb39-8c1562fde029', '254708989808', 'Atul', '', 'User channel', NULL, '2018-02-22 13:11:27', '254708989808', '2018-02-22 07:41:27', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('a297d136-7366-4724-8701-352a4bd049b0', '911234567890', 'chk date', 'a297d136-7366-4724-8701-352a4bd049b0/profile/0808bda1f57048ea91c65d1bd3ed98cf.png', 'date check', NULL, '2017-12-26 18:35:11', '911234567890', '2017-12-26 13:05:11', 1, 'df2305f7-4bf1-445b-9b9d-1e87a2baadc6', '2017-12-26 00:00:00', '2017-12-27 00:00:00'),
('a2b5b70b-5821-4473-bae7-b24667b3a93d', '919999999999', 'NineNine', '', 'User channel', NULL, '2018-01-19 12:10:57', '919999999999', '2018-01-19 06:40:57', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('a3e2f44b-df5a-4d43-b34b-7024e3bed50f', '8965675675767', 'Chandan', '', 'PJ channel', NULL, '2018-01-05 15:33:44', '8965675675767', '2018-01-05 10:03:44', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('a57d30ad-a731-49df-a66b-8592075d3ba7', '911234567890', 'tuesday name', 'a57d30ad-a731-49df-a66b-8592075d3ba7/profile/b158ae56248c4962add9a8abe1674144.png', 'test desc', NULL, '2017-12-26 14:44:54', '911234567890', '2017-12-26 09:14:54', 1, 'af77206a-6915-4016-a338-1b6dcf5470ad', NULL, NULL),
('a6eb710a-bf2d-49eb-9b96-049a08c9b816', '918867231902', 'Shruuu', '', 'User channel', NULL, '2018-02-21 16:56:57', '918867231902', '2018-02-21 11:26:57', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('aa44bd23-03bf-44da-960a-a83b114e5f58', '919494949494', 'Ninefour', '', 'User channel', NULL, '2017-12-27 17:25:04', '919494949494', '2017-12-27 11:55:04', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('aab17628-679c-4a01-aa9d-fbde30d26633', '918867528736', 'ShilpaGowda', '', 'User channel', NULL, '2018-02-22 13:14:51', '918867528736', '2018-02-22 07:44:51', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('ab081fe2-0d24-4be8-902f-5df1b9cba010', '919035564107', 'Chai that', '', 'User channel', NULL, '2018-02-01 15:31:59', '919035564107', '2018-02-01 10:01:59', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('af75ee50-7384-4beb-923f-ae6017ba03d5', '3355566677877', 'rani', '', 'PJ channel', NULL, '2018-01-05 19:38:03', '3355566677877', '2018-01-05 14:08:03', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('aff07c9c-5a6d-4f5d-a834-7f8db6b07e00', '917123456789', 'TestPJ123789', '', 'PJ channel', NULL, '2018-01-09 12:11:00', '917123456789', '2018-01-09 06:41:00', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('b171f000-983f-45d5-98b2-d0405e65bbed', '91812345678', 'TestPJ123', '', 'PJ channel', NULL, '2018-01-08 14:46:51', '91812345678', '2018-01-08 09:16:51', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('b25d0f0e-3a85-4b6b-903a-6fd49ba60816', '9112300012300', 'diwali glitters', 'b25d0f0e-3a85-4b6b-903a-6fd49ba60816/profile/3d0961aa4b114f20a459ab45396f174b.png', 'diwali glitters', NULL, '2017-11-17 18:12:53', '9112300012300', '2017-11-17 12:42:53', 1, '5c76b059-2150-4508-8181-b7cb13569128', NULL, NULL),
('b4e717cd-6a28-4f9a-807c-23cf8aaf7342', '919900601813', 'supriya', '', 'Test channel', NULL, '2017-11-17 16:01:03', '919900601813', '2017-11-20 06:58:51', 1, '4a9207e6-581f-4130-82d8-a78c15f0cb12', NULL, NULL),
('b5b6e969-4a40-4ef1-811d-d9bfa5df278f', '911234567890', 'shruthika', '', 'This is a channel for Virat Kohli ', NULL, '2017-12-28 11:22:16', '911234567890', '2017-12-28 05:52:16', 1, '89a54a33-2982-4985-930a-5b52e29e44d8', '2017-12-11 00:00:00', '2017-12-30 00:00:00'),
('b5e910e8-e954-437a-b5f5-50b2b333c6fc', '919988007711', 'asdsda', 'b5e910e8-e954-437a-b5f5-50b2b333c6fc/profile/7aa5fd7fce0a4a63adef82afa6d9300d.png', 'asdasdda', NULL, '2017-11-20 18:42:10', '919988007711', '2017-11-20 13:12:10', 1, 'b891aa9f-547a-4f48-958e-cc219561f4d3', NULL, NULL),
('b75a675a-1de5-4861-82da-f2f74668ca2b', '55876543', 'helooo', '', 'PJ channel', NULL, '2018-01-22 19:09:13', '55876543', '2018-01-22 13:39:13', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('b789109d-b6ba-4119-9b37-5cc06ad1dba2', '889665675576', 'Shree', '', 'PJ channel', NULL, '2018-01-05 19:26:45', '889665675576', '2018-01-05 13:56:45', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('ba209dc4-ccf9-4feb-ab67-b641782ccb75', '911234567890', 'test@name', 'ba209dc4-ccf9-4feb-ab67-b641782ccb75/profile/f04f90fd6cda4ddd9d8bc3e7c7b4fe4a.png', 'test content', NULL, '2017-11-16 18:51:32', '911234567890', '2017-11-20 06:59:54', 1, 'fe2b649f-2cc4-424c-af71-0095e5823b05', NULL, NULL),
('ba2e99b4-50cd-40ae-b022-edc4481527ce', '918123456789', 'Test PJ', '', 'PJ channel', NULL, '2018-01-08 13:48:34', '918123456789', '2018-01-08 08:18:34', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('bab2059f-4771-435d-bc72-68c3dfa3c034', '919988665544', 'test new', 'bab2059f-4771-435d-bc72-68c3dfa3c034/profile/b520dcdfd8df4de681f6bb7b45a646a8.png', 'test new', NULL, '2017-11-21 11:53:23', '919988665544', '2017-11-21 06:23:23', 1, '15d63c5e-6638-4b9e-90bb-1ae6da20ec5b', NULL, NULL),
('bb3fa05b-1905-47fc-99c5-6fb9bbdeef7c', '919898667544', 'Diff', '', 'User channel', NULL, '2018-02-02 15:52:39', '919898667544', '2018-02-02 10:22:39', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('bfac94df-2063-496c-871c-3618c446a199', '919528096314', 'Ashsbbbnnmmlllkkjhvg', '', 'User channel', NULL, '2017-11-17 12:12:12', '919528096314', '2017-11-17 07:38:45', 1, '5c76b059-2150-4508-8181-b7cb13569128', NULL, NULL),
('c149f7d4-a2b0-4e15-a8de-065677e8ad3a', '911234567890', '1st Contract channel', 'c149f7d4-a2b0-4e15-a8de-065677e8ad3a/profile/fd535ce80d014354afc6e8b0b7d0d2f5.png', 'This is about channels', NULL, '2017-12-26 13:02:36', '911234567890', '2017-12-26 07:32:36', 1, '8b54acae-99f2-4f0c-b1a1-66af1a27fd74', NULL, NULL),
('c14b4ea8-ae9c-445b-baed-8db9e919f53d', '944658787', 'KjChannel', 'c14b4ea8-ae9c-445b-baed-8db9e919f53d/profile/565ecb8fb351430a8de5040bd544f00e.png', 'This is a channel for pKohli', NULL, '2018-01-17 17:41:59', '944658787', '2018-02-19 11:37:23', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('c160d505-998c-41a9-8b54-431d6492d912', '911234567890', 'test@name', '', 'test', NULL, '2017-11-17 15:42:41', '911234567890', '2017-11-20 06:59:54', 1, 'fc918903-a5f8-4d31-9d6a-d40298846324', NULL, NULL),
('c2c8054b-0b16-4779-a507-bc1b041412f3', '917760464258', 'Shuklaqrg', '', 'User channel', NULL, '2017-12-13 12:25:56', '917760464258', '2017-12-13 06:55:56', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('c47791b9-a9fe-4f23-97ad-ec0c8d389063', '78646464646', 'vijayyyy', '', 'PJ channel', NULL, '2018-01-04 18:57:30', '78646464646', '2018-01-04 13:27:30', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('c510bbdb-30e3-4005-b318-eeb597288d2c', '919897969594', 'Test', '', 'User channel', NULL, '2017-12-13 12:51:26', '919897969594', '2017-12-13 07:21:26', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('c602bfbd-8832-40cb-a82e-af827e51c1bc', '918877114477', 'Aatul', '', 'User channel', NULL, '2018-02-22 13:04:26', '918877114477', '2018-02-22 07:34:26', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('c8f38a20-f4ec-44da-b2c2-b1d4b5cfd59d', '9112300012300', 'dhgfdhfhd22222222', '', 'nbhjm', NULL, '2017-11-17 16:48:56', '9112300012300', '2017-11-17 11:18:56', 1, '4a9207e6-581f-4130-82d8-a78c15f0cb12', NULL, NULL),
('c996dc58-b162-4da2-9eb9-47cf272c3602', '919573270949', 'Java', '', 'User channel', NULL, '2017-11-16 19:13:36', '919573270949', '2017-11-16 13:43:36', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('ca208078-034f-47dd-86c1-ca921609360d', '919113837130', 'Geetha', '', 'User channel', NULL, '2018-01-23 16:02:22', '919113837130', '2018-01-23 10:32:22', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('cb87678b-3afd-47d1-857f-8e207f6f0b18', '911234567890', 'test@name', '', 'jhdgfds dsf sf gfd g', NULL, '2017-11-16 19:57:05', '911234567890', '2017-11-20 06:59:54', 1, 'f0f70b26-2053-4686-bc3b-48e4f67cf835', NULL, NULL),
('cd75db88-df76-4dd1-bd70-9a523230ba98', '911234567890', 'test@name', 'cd75db88-df76-4dd1-bd70-9a523230ba98/profile/c99a33656f5744a28a06057d6ced66f2.png', 'This is a channel for Virat Kohli', NULL, '2017-11-16 20:02:16', '911234567890', '2017-11-20 06:59:54', 1, '89a54a33-2982-4985-930a-5b52e29e44d8', NULL, NULL),
('cfc8f902-e546-4f25-bc5c-8898965e4210', '917539812466', 'TestPj_6', '', 'PJ channel', NULL, '2018-01-16 09:56:59', '917539812466', '2018-01-16 04:26:59', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('cfcd1361-3720-4b49-b4a0-0b36281113ca', '8986786767768', 'Amruthesh', '', 'PJ channel', NULL, '2018-01-05 18:46:34', '8986786767768', '2018-01-05 13:16:34', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('d2f94f97-1a7c-422d-84a8-8db5675b5f82', '918787878787', 'Eightseven', '', 'User channel', NULL, '2017-12-28 11:51:43', '918787878787', '2017-12-28 06:21:43', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('d4540d46-b613-4297-8f5b-87689628ecd9', '887656756', 'Devi', '', 'PJ channel', NULL, '2018-01-05 19:38:34', '887656756', '2018-01-05 14:08:34', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('d51c2942-0033-430a-9ec9-f964f8c3ac6c', '919999988888', 'Dev Testing', '', 'User channel', NULL, '2017-12-28 12:02:28', '919999988888', '2017-12-28 06:32:28', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('d5303748-1944-4a0d-aba6-c0234ad40f03', '919738849769', 'Jaffar Sadiq SH', '', 'User channel', NULL, '2017-12-15 11:52:09', '919738849769', '2018-01-09 14:50:04', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('d8f83541-7749-4795-a963-9fbd73eeadbf', '9112300012300', 'test123456789', 'd8f83541-7749-4795-a963-9fbd73eeadbf/profile/ac7e4d5cd65543b8857bdcee6852ce12.png', 'hey its mangoooo time', NULL, '2017-11-17 18:14:54', '9112300012300', '2017-11-17 12:44:54', 1, 'f49612b2-37b6-4f89-966a-16af1600440e', NULL, NULL),
('da8c7371-050a-40a4-a034-010cb40daf91', '919988776655', 'pista green', 'da8c7371-050a-40a4-a034-010cb40daf91/profile/abf8ffc650434811a9b657f41f9cdc7b.png', 'pista green pista green pista green', NULL, '2017-12-28 14:46:53', '919988776655', '2017-12-28 09:16:53', 1, 'df2305f7-4bf1-445b-9b9d-1e87a2baadc6', '2017-12-28 00:00:00', '2017-12-28 00:00:00'),
('ddaa36cf-5bcf-4672-acbd-d24e5bb0de4a', '9165566', 'dfghjklk', 'ddaa36cf-5bcf-4672-acbd-d24e5bb0de4a/profile/af8c10bccb294cae83f719c681f0cf72.png', 'fghjkljfghjkl', NULL, '2017-12-28 18:59:50', '9165566', '2017-12-28 13:29:50', 1, 'fe2b649f-2cc4-424c-af71-0095e5823b05', '2017-12-28 00:00:00', '2017-12-30 00:00:00'),
('ddfb6f97-56c7-4644-81b8-f2455756166c', '9112300012300', 'test my new channel', 'ddfb6f97-56c7-4644-81b8-f2455756166c/profile/a67e3476755c487abb18dd36a2d08bef.png', 'test my new channel', NULL, '2017-12-28 11:27:56', '9112300012300', '2017-12-28 05:57:56', 1, 'df2305f7-4bf1-445b-9b9d-1e87a2baadc6', '2017-12-28 00:00:00', '2018-01-10 00:00:00'),
('df1df4f0-2de3-4040-9bbf-b92e8d4fc5f6', '919988665544', 'test', 'df1df4f0-2de3-4040-9bbf-b92e8d4fc5f6/profile/92eafcebe2374477a5d0d11c65a17d9c.png', 'test', NULL, '2017-11-20 17:05:53', '919988665544', '2017-11-20 11:35:53', 1, 'b891aa9f-547a-4f48-958e-cc219561f4d3', NULL, NULL),
('e091aad4-0da5-4954-8059-4a333cc388ce', '91154632589', 'TestPj_8', '', 'PJ channel', NULL, '2018-01-18 09:44:28', '91154632589', '2018-01-18 04:14:28', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('e7fee8e5-bdaa-4bf4-aa06-462446e058ae', '9112300012300', 'test 123', 'e7fee8e5-bdaa-4bf4-aa06-462446e058ae/profile/de7ef15fe4c74a9ab80031a0be94dec4.png', 'test desc', NULL, '2017-12-26 14:47:18', '9112300012300', '2017-12-26 09:17:18', 1, 'fcfe1690-f261-4ccf-a7d3-ada5340f74dc', NULL, NULL),
('e898bd16-0531-416c-b45d-4f8fe1ca09d7', '919439857565', 'Shoiab', '', 'User channel', NULL, '2017-11-17 17:33:22', '919439857565', '2017-11-17 12:03:22', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('e8b15c33-e018-4f72-8850-265af6262348', '919890874323', 'shilpaqapj1@compass.in', '', 'PJ channel', NULL, '2018-01-22 13:46:03', '919890874323', '2018-01-22 08:16:03', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('e992f360-d32b-4f4a-840c-3c3e9fcb0163', '99786785657', 'shree', '', 'PJ channel', NULL, '2018-01-05 19:39:53', '99786785657', '2018-01-05 14:09:53', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('eddce392-6d22-42d8-b791-7430053627af', '918892152332', 'Fufjjv', '', 'User channel', NULL, '2018-01-19 18:24:52', '918892152332', '2018-01-19 12:54:52', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('eeab2bcd-7e61-4d2e-8b90-de7818c00af5', '919696969696', 'My name is 9696', '', 'User channel', NULL, '2017-12-27 16:23:48', '919696969696', '2017-12-27 10:53:48', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('eeb12891-f466-4d1d-bfa9-71c05c8d060d', '907336345534', 'Dont give up', 'eeb12891-f466-4d1d-bfa9-71c05c8d060d/profile/478e3c2d3f88409faec70ca54c3ad300.png', 'dont give up//// its not too lateee', NULL, '2018-01-18 19:00:42', '907336345534', '2018-01-18 13:30:42', 1, 'aae19cb0-8ca5-458d-9d52-c6f7a1471a45', '2018-01-18 00:00:00', '2018-02-03 00:00:00'),
('f0c1e428-6161-4f10-ac77-924605016cd5', '919988776655', 'teest', 'f0c1e428-6161-4f10-ac77-924605016cd5/profile/51aa1198afbf4ae4a16d56fa231b6314.png', 'test', NULL, '2017-11-20 16:30:32', '919988776655', '2017-11-20 11:00:32', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('f43a2e72-9087-4840-a992-3d0e2c3b150d', '918151913741', 'Naveenraj Xavier', '', 'User channel', NULL, '2017-11-16 18:49:40', '918151913741', '2017-11-16 13:19:40', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('f58bc7fb-c311-4b30-97a5-3078182d337d', '918151913743', 'Naveenraj 3??', '', 'User channel', NULL, '2017-11-16 18:59:35', '918151913743', '2017-11-16 13:43:43', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('fd5a858f-a55d-4ee9-84f7-c829b8ef3477', '9178889956', 'elango123', 'fd5a858f-a55d-4ee9-84f7-c829b8ef3477/profile/e8cb7f86ffaa47a8a079f52cf11b6284.png', 'This is a channel for PJ', NULL, '2018-02-21 12:50:35', '9178889956', '2018-02-21 07:20:52', 1, 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', NULL, NULL),
('fefc77cb-b1b2-4f7d-a0ce-b8ca2a6e1ece', '911234567890', 'shruthika sports', '', 'This is a channel for Virat Kohli ', NULL, '2017-12-28 11:23:22', '911234567890', '2017-12-28 05:53:22', 1, '89a54a33-2982-4985-930a-5b52e29e44d8', '2017-12-11 00:00:00', '2017-12-30 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `channel_age_group`
--

CREATE TABLE `channel_age_group` (
  `channel_age_group_id` varchar(50) NOT NULL,
  `channel_id` varchar(50) NOT NULL,
  `age_group_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `channel_age_group`
--

INSERT INTO `channel_age_group` (`channel_age_group_id`, `channel_id`, `age_group_id`) VALUES
('0059cdb0-4433-4fa3-8b1a-192ccb40d37f', '3cacfc06-e8d5-4588-b37f-92d9fa0162d6', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('01bb1ea0-386b-446f-90d5-c9093459f61c', '1659e5e0-51d3-46d2-b7df-737a9c64843b', 'cfc2a11e-52f3-43de-95ab-e86b68a0a747'),
('0780ceb8-f40c-4dba-a05d-00bfc3932cf8', 'f0c1e428-6161-4f10-ac77-924605016cd5', '156bcba5-03d4-4b00-b3c0-b44974239fa4'),
('081a074c-78a9-4ce1-97d9-f63322917a7a', 'c602bfbd-8832-40cb-a82e-af827e51c1bc', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('0b18c8e2-e231-4e90-84d7-f829a54c089f', '055b21ff-4160-4900-be76-235bb25e384d', 'ad8246fd-71ca-45ab-9977-c55c01d84743'),
('0c333987-1b12-4933-9b6b-daee4530f97d', 'a09abc52-3c57-4627-aa2a-ac8c61ac6d1f', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('126ea7df-21f4-4c37-8f38-edee800f7fd2', 'eeb12891-f466-4d1d-bfa9-71c05c8d060d', '5de825ba-4c95-41db-81ba-766270542cac'),
('13fc2069-f61b-44d8-8636-3123afd55b2a', 'e7fee8e5-bdaa-4bf4-aa06-462446e058ae', 'fb2978f1-5a8d-4a83-bab3-21f2253ea8ec'),
('17ec0ac6-635e-4984-940a-95ed432e0854', '4bce4ae4-3451-497b-8817-f4ac42c49460', 'ad8246fd-71ca-45ab-9977-c55c01d84743'),
('18068611-102c-4892-8577-6e824a9d172e', 'f58bc7fb-c311-4b30-97a5-3078182d337d', '156bcba5-03d4-4b00-b3c0-b44974239fa4'),
('19c6a464-acf5-4b93-837d-1b8f789af993', 'cfc8f902-e546-4f25-bc5c-8898965e4210', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('1a285f1f-9721-44c7-88f1-9f3ebeda5847', '8a472886-d9de-4f84-9e74-3916650ed19f', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('1a827c83-7629-4ccc-bb79-d8914b5b854c', '6d64ffe3-fc23-496c-9660-60fbe6cf5722', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('1aca7a23-0cac-4d68-a7f9-f107cef19314', '16486658-61bd-41a5-9273-a87a55907912', 'cfc2a11e-52f3-43de-95ab-e86b68a0a747'),
('1f49d140-67d9-4571-8a04-9c6b0f950eac', 'b4e717cd-6a28-4f9a-807c-23cf8aaf7342', '9d39994a-000f-4bf1-858c-a89012184dc3'),
('25c71963-6f20-4de6-b245-1f813febf663', '3cc415c0-b3ed-4918-a606-e869eecba300', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('29c08348-d78e-4e82-8738-5970f0fa94a4', 'c510bbdb-30e3-4005-b318-eeb597288d2c', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('2f0ba2c1-8446-4d17-bdd7-96e1898df15f', '6dd178b5-e0ca-434a-8a95-97207435bb68', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('35316a56-30ce-4178-b75d-7ff63c825023', 'aff07c9c-5a6d-4f5d-a834-7f8db6b07e00', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('35cac87e-907a-4234-a28b-8b09a7d04f3a', 'b789109d-b6ba-4119-9b37-5cc06ad1dba2', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('3bc254e9-8014-4a91-8fd6-7089a0724c83', 'c2c8054b-0b16-4779-a507-bc1b041412f3', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('3f307298-eb60-4774-ae45-2ac368a9a842', '64554422-655b-4ced-b640-fa4d85dcb221', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('413c95e5-f0b3-4475-9efa-fba0897c6289', 'a087a24c-5e7b-40d0-8e41-9cdc106d0adb', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('427a2c0f-db05-4ade-ba7e-9676a3c23fb8', '3db5ca1e-cc0d-4104-a275-955d2261d193', 'bd945133-4c1d-4788-a094-c8244480c33f'),
('42a8e289-6e77-4fbf-8931-c7f7d25c6213', '8109e664-9fe7-4f79-9575-fdf4219a085b', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('44f6dc14-f0f3-468d-8659-81208b557c06', 'ab081fe2-0d24-4be8-902f-5df1b9cba010', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('456f0623-4473-4637-8ea2-215ca34f4589', 'fefc77cb-b1b2-4f7d-a0ce-b8ca2a6e1ece', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('4ad3c427-0e99-4388-87d7-b3fb17fa4c4c', 'd5303748-1944-4a0d-aba6-c0234ad40f03', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('4af3362d-9e14-456b-805d-928d95dd48c4', '3bdc8e63-f2ed-41e9-840e-0bccf9a5fc0f', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('4c874d7c-f3d7-4700-881c-39678ad791b1', '3397d6de-d7af-47e6-94f6-e8772af25380', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('503234c9-2921-41a2-b159-127d800444a2', 'a6eb710a-bf2d-49eb-9b96-049a08c9b816', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('51c68c7b-2c73-4906-8e0c-7530515143ea', 'b171f000-983f-45d5-98b2-d0405e65bbed', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('528578b6-21e1-4e06-bc6b-46096f0e0ec5', '562893b7-7619-4f6f-be77-9beb62cf740c', '9d39994a-000f-4bf1-858c-a89012184dc3'),
('55e93afc-00f0-4d9e-b096-9e831de35326', 'df1df4f0-2de3-4040-9bbf-b92e8d4fc5f6', '89a54a33-2982-4985-930a-5b52e29e44d8'),
('562c76d6-caf3-4b34-8067-bb64e22e8c8f', 'cfcd1361-3720-4b49-b4a0-0b36281113ca', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('56565660-b3c1-4946-a72b-704ba8a4bc96', 'd51c2942-0033-430a-9ec9-f964f8c3ac6c', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('57a9022e-ab98-4147-81f4-d014e2f536d0', '13dab5c8-ae95-4794-ab71-063bf0117cd8', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('58d82fd3-c586-4a80-aae2-dea63840d7a3', 'ba209dc4-ccf9-4feb-ab67-b641782ccb75', 'bd945133-4c1d-4788-a094-c8244480c33f'),
('5b3d5903-ef36-4e06-b8f1-326a7dea62db', 'c14b4ea8-ae9c-445b-baed-8db9e919f53d', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('5f7b2af3-be54-42ba-b14b-decb3728c7c3', 'ba2e99b4-50cd-40ae-b022-edc4481527ce', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('62039ac1-ffbd-468e-a94a-e66a2e6b62ea', '5c1ef7df-8594-4d55-988a-fbf6eb5e41e6', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('6561d59c-605b-4cc1-a252-eafa5a638528', 'e898bd16-0531-416c-b45d-4f8fe1ca09d7', '156bcba5-03d4-4b00-b3c0-b44974239fa4'),
('65fd9b3f-f257-4460-babf-f4df66385ce8', '51cd92e4-c62c-4fcc-882f-c0942d5cddf3', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('65ffd08d-51de-41ee-a425-63a6ed506b76', '5edd618b-b93a-4bb2-b7b3-d3b33c1863d4', '156bcba5-03d4-4b00-b3c0-b44974239fa4'),
('66850ab2-630e-40d7-ba90-239f78b135d1', 'a2b5b70b-5821-4473-bae7-b24667b3a93d', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('6a564553-83f8-44be-9c5b-758e4da360af', 'ddaa36cf-5bcf-4672-acbd-d24e5bb0de4a', '5de825ba-4c95-41db-81ba-766270542cac'),
('6c82dbe2-6153-4729-8a7b-eae08c665c94', 'da8c7371-050a-40a4-a034-010cb40daf91', '156bcba5-03d4-4b00-b3c0-b44974239fa4'),
('732e2909-626e-4be3-80fe-7f8c5702063e', 'c149f7d4-a2b0-4e15-a8de-065677e8ad3a', '5de825ba-4c95-41db-81ba-766270542cac'),
('7397e4a2-d035-4282-8764-aa913fdaaee4', 'd2f94f97-1a7c-422d-84a8-8db5675b5f82', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('73f92d7a-9854-4655-ab79-ae5386b14fe9', '55981906-d119-4759-abda-e0e9542f0d5f', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('74fd20fb-574c-44c8-a2a9-0133ca6fd8f7', '03f3f166-c138-4065-b070-2f07921020fa', 'ad8246fd-71ca-45ab-9977-c55c01d84743'),
('75e66be7-de31-480a-9228-d16e10894340', '59635d64-3643-4b49-9f0e-3ce0f37ca522', '9d39994a-000f-4bf1-858c-a89012184dc3'),
('792f7811-d36a-4fbc-99b1-312623e338a4', 'af75ee50-7384-4beb-923f-ae6017ba03d5', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('7d7dd1c5-d962-4ba9-97ca-82a8127fbd22', 'cd75db88-df76-4dd1-bd70-9a523230ba98', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('7ef35a51-4329-4270-a73e-4c990f00f252', 'b75a675a-1de5-4861-82da-f2f74668ca2b', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('7f8c7e52-2a21-474e-be35-32e59735dea9', '439b4525-f668-4c1b-ad6a-80c23196aaaa', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('805e0062-d6ef-41a0-8daa-126890e3a0f0', '241432c9-61d7-4b5e-8a08-ceb2e278229c', 'ec6fa0cd-5e1c-47b4-8d26-33811469abd9'),
('82e47881-db9c-4770-b93b-5e9116021482', '83730dc8-b2af-44af-b24e-15b08f89f669', 'cfc2a11e-52f3-43de-95ab-e86b68a0a747'),
('83834333-68b5-48f3-9556-1d162698bf47', 'fd5a858f-a55d-4ee9-84f7-c829b8ef3477', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('86386158-81a6-442b-9140-1fc00abe2c70', '326b35d3-f345-42f9-8b19-4607e25fcd8e', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('87cf611b-2ed0-4af5-9bc4-5dd310288a66', 'e8b15c33-e018-4f72-8850-265af6262348', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('87d195c5-4047-4729-a57f-f4e526dd7c90', '820f0869-12b3-4bc3-b2da-6120e277b0ce', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('87df6a25-c066-41bc-b12a-96f612220956', 'd8f83541-7749-4795-a963-9fbd73eeadbf', '89a54a33-2982-4985-930a-5b52e29e44d8'),
('8a44a761-b2c8-49e1-8f8a-7c9ef2cc7143', '19a3d480-feca-4686-8bec-b5683a1ae8a7', '156bcba5-03d4-4b00-b3c0-b44974239fa4'),
('8cf7011f-1570-484c-990c-4abfe1184925', 'a297d136-7366-4724-8701-352a4bd049b0', '9d39994a-000f-4bf1-858c-a89012184dc3'),
('932c5e34-8331-40be-a588-4a5442fd9e1e', 'c8f38a20-f4ec-44da-b2c2-b1d4b5cfd59d', 'ad8246fd-71ca-45ab-9977-c55c01d84743'),
('93413fb7-024f-432a-a927-3bdf316078a1', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('94cfe673-eb33-4a08-b329-4c03705e2253', '4b6339be-a7c5-4e74-bc1e-239a518dec9c', '156bcba5-03d4-4b00-b3c0-b44974239fa4'),
('970f4b72-77e5-45fe-897e-81e26be0558c', 'eeab2bcd-7e61-4d2e-8b90-de7818c00af5', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('9ad175b1-38b8-4a7c-af95-585e9f6104d7', '8f7ea8b7-c5b5-48f0-bbda-491fef0867ce', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('9b9956f0-eb92-41d5-b537-dc5d2baa6fdf', '0d468b4e-2f8f-4b42-b5dc-2a2a54061683', '156bcba5-03d4-4b00-b3c0-b44974239fa4'),
('9c8cd08f-ce79-49de-97b3-46b552032701', '2cbd1987-f380-4032-abf4-8ab9f02bfb16', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('9ed6c8eb-df46-40f1-a0b2-b4d962713647', '7ce6959e-6997-4eef-8042-4fa645265ece', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('a0d01a63-806d-4a97-b254-ec883a399f25', 'a0e6aef5-f5f7-4850-bb39-8c1562fde029', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('a6c4b926-eb08-41b9-942f-7b2dee9a72f2', '7c597a7a-2bea-49ff-9300-1db3e01707fb', '5de825ba-4c95-41db-81ba-766270542cac'),
('a73dc99a-d731-4dc0-a49a-4cddb2a52a6a', '53933e18-98e1-4526-9544-61d8302a1112', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('b020e556-c99a-4f85-978b-9e4282b00263', 'e091aad4-0da5-4954-8059-4a333cc388ce', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('b0a8d612-d770-44a7-b85c-abfddcfc6fec', 'bab2059f-4771-435d-bc72-68c3dfa3c034', 'bd945133-4c1d-4788-a094-c8244480c33f'),
('b280c5c3-c365-4538-bdb7-455e56ee440a', 'c996dc58-b162-4da2-9eb9-47cf272c3602', '156bcba5-03d4-4b00-b3c0-b44974239fa4'),
('b332bb8d-3e1d-48a3-8685-2ab45400a04c', '9ac22c90-1837-471c-98bc-cb82ca898136', '156bcba5-03d4-4b00-b3c0-b44974239fa4'),
('b9129595-38b9-4ac6-a013-fb8fdd27edd7', 'b5e910e8-e954-437a-b5f5-50b2b333c6fc', 'fb2978f1-5a8d-4a83-bab3-21f2253ea8ec'),
('ba9b28e3-29da-4ccd-870e-bf094948dcb9', '28981074-1d4d-4939-94a5-4a8cf0fa6b4f', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('bc864ed8-21cc-448b-85bc-720e30d9a3c8', '76fba5bd-eae6-4f36-a275-f5cc80afbbdd', 'bd945133-4c1d-4788-a094-c8244480c33f'),
('c45d2ed5-945f-447f-9cdb-fb1fed172b23', '3a78c0ee-f931-4816-9618-117beaca72a9', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('c4936f9a-26f0-465a-ab98-2e69f6cac1c7', 'a3e2f44b-df5a-4d43-b34b-7024e3bed50f', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('c55fc0ae-e314-43f3-9962-d261b31ff290', '6d9e24e8-820b-4320-be94-94012619b7c6', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('c6bc697a-a0a3-4a68-8785-c00b499218c6', '6670e6d4-2692-48e9-ac61-ce13fde7e4f1', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('c79055d1-63a2-467a-8739-fdc1cf8f4c8c', 'a57d30ad-a731-49df-a66b-8592075d3ba7', 'ad8246fd-71ca-45ab-9977-c55c01d84743'),
('cd187f35-8108-497f-9030-73e8c0ba765d', '360cebb5-530f-427c-8f3f-93d3e320ab78', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('cd7ac7af-3bc3-4e5a-b901-32a89015cd19', 'bfac94df-2063-496c-871c-3618c446a199', '156bcba5-03d4-4b00-b3c0-b44974239fa4'),
('cd9dab66-216d-4b67-b853-77e8ba776d11', '29128c3f-26ed-419c-8ecc-aea6b7cd9766', '8a9d2567-a07f-4c69-a910-2adb20b4afb7'),
('ce9eea7e-1648-473c-be33-38940ded4f0f', 'aa44bd23-03bf-44da-960a-a83b114e5f58', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('cea729f4-68d1-46d6-abb7-2c091fcd95f7', '5f42bb12-c914-48e4-8ed9-bd08d71cde12', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('d011ff46-2304-4b3c-a308-1544e7a94932', 'c160d505-998c-41a9-8b54-431d6492d912', '4a1dbdba-bfe9-4f6c-9e80-43d1ccf7886f'),
('d2b0da6a-4b8b-47ed-ac5d-e92f3d4a66e0', '33e38ebb-3b50-41b7-9243-511005bf1774', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('d52acad3-33e1-4dd4-8844-66c105002b8e', 'c47791b9-a9fe-4f23-97ad-ec0c8d389063', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('d6064d20-fe64-4dee-8ea2-aecbd010140a', 'aab17628-679c-4a01-aa9d-fbde30d26633', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('d72d5521-ccbb-4ee3-a597-7cef470c0c34', 'd4540d46-b613-4297-8f5b-87689628ecd9', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('dba6442c-df01-4a5f-ad0f-a48b91dd3b1b', 'ddfb6f97-56c7-4644-81b8-f2455756166c', 'd2020239-2689-4cdf-8c53-7bf480956c6e'),
('dbc48ada-0aca-4357-831f-7876f9d7d654', '483b2a70-93fc-4343-86dc-1d9eba3f78fa', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('e53aa2c3-e646-4f51-b590-330ddafa32af', '643ebad4-26d5-4ba9-9290-4a8d3ee2de2d', '156bcba5-03d4-4b00-b3c0-b44974239fa4'),
('e5c731b7-0dfd-47f2-9eeb-330db9fc79f4', 'ca208078-034f-47dd-86c1-ca921609360d', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('e5d68570-2afa-4274-aece-623c75448342', '38069f36-b271-4de9-8227-5edd7276a07d', 'fb2978f1-5a8d-4a83-bab3-21f2253ea8ec'),
('e7c4e513-2690-469c-a1e6-3db51aa6b0f3', 'cb87678b-3afd-47d1-857f-8e207f6f0b18', '5de825ba-4c95-41db-81ba-766270542cac'),
('ed5d4317-f42e-482e-a702-3ed3e14b6c4d', 'f43a2e72-9087-4840-a992-3d0e2c3b150d', '5de825ba-4c95-41db-81ba-766270542cac'),
('f186e75c-23c8-466b-9822-497d4c614167', '64078f75-b407-40b6-8231-a54171f78806', 'cfc2a11e-52f3-43de-95ab-e86b68a0a747'),
('f18fab24-95f9-4268-98d8-3ff2281c7b5a', 'b25d0f0e-3a85-4b6b-903a-6fd49ba60816', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('f3aedb84-8de0-4b64-8a3e-5efa0d41f1e8', '00a042bf-765e-42e9-b586-5e34cfb3abce', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('f3d338be-3a74-4f23-a0ee-0cadfb49bd49', '7cd3fe7b-c5c6-45e0-b41e-cfedc923f7e5', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('f45db76c-8d71-43de-a4dd-140e44c50c59', '8ce708c3-c391-49f2-a323-a84804420380', '8a9d2567-a07f-4c69-a910-2adb20b4afb7'),
('f8597215-bb54-42b7-b9e6-b31f9adb3bfe', '50d846e8-366f-4a94-9753-b18b7a8bc4da', 'd2020239-2689-4cdf-8c53-7bf480956c6e'),
('f88ee648-eac2-44e3-95a1-d089dc9ac1af', '641b98ef-6d76-448f-a986-b7031325100d', '89a54a33-2982-4985-930a-5b52e29e44d8'),
('f8afbc77-6dd9-4c34-8686-b52704fb0ea8', 'b5b6e969-4a40-4ef1-811d-d9bfa5df278f', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('f9062177-5469-40a4-810c-3d1091ddd902', 'eddce392-6d22-42d8-b791-7430053627af', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('fa37cde4-2079-4899-83af-a7e7c98eb235', 'e992f360-d32b-4f4a-840c-3c3e9fcb0163', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('fb01f8e4-ec4e-4a10-8d85-5dfe90e6d196', 'bb3fa05b-1905-47fc-99c5-6fb9bbdeef7c', 'a5961401-4745-4871-9467-b7c1eda4a7f0'),
('fbee5af7-239d-49be-bae1-a2fa308b66c4', '661952f8-57d7-4d5f-b697-406bcc2e0fa3', '156bcba5-03d4-4b00-b3c0-b44974239fa4'),
('fec81f04-6dda-4bd2-9aa4-9d8035d87b5c', '68299658-1f56-4cb1-971b-5ebd7773aec2', 'a5961401-4745-4871-9467-b7c1eda4a7f0');

-- --------------------------------------------------------

--
-- Table structure for table `channel_category`
--

CREATE TABLE `channel_category` (
  `channel_category_id` varchar(50) NOT NULL,
  `channel_id` varchar(50) DEFAULT NULL,
  `category_id` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `channel_category`
--

INSERT INTO `channel_category` (`channel_category_id`, `channel_id`, `category_id`) VALUES
('00cc244e-2188-428d-ad1e-4754ebcd7a37', '4b6339be-a7c5-4e74-bc1e-239a518dec9c', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('01309e4d-f16c-4a86-b979-ad776a2a12ec', 'c149f7d4-a2b0-4e15-a8de-065677e8ad3a', '8b54acae-99f2-4f0c-b1a1-66af1a27fd74'),
('02b3c38d-23cf-4043-bbb0-380f601d7566', '64554422-655b-4ced-b640-fa4d85dcb221', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('05a1dca3-b214-4135-a10b-b4264702715d', 'b75a675a-1de5-4861-82da-f2f74668ca2b', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('0a61a2ae-57aa-4ac3-911b-ba68f3952c12', '3cacfc06-e8d5-4588-b37f-92d9fa0162d6', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('0c53007f-f71a-45e4-805b-157ec5b2b924', '19a3d480-feca-4686-8bec-b5683a1ae8a7', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('0e355fad-ef59-4187-9322-0256ed38dfc3', '661952f8-57d7-4d5f-b697-406bcc2e0fa3', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('0e3ec35c-1bbb-4a55-86c0-d7b108968c71', 'ab081fe2-0d24-4be8-902f-5df1b9cba010', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('0f6df4ae-1d89-4fb9-9ed8-4bdb680cd422', '483b2a70-93fc-4343-86dc-1d9eba3f78fa', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('0fbb6971-e33e-46fe-ac5b-021c46bb6a81', '55981906-d119-4759-abda-e0e9542f0d5f', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('10debac6-723b-44aa-8105-90db84ab28c7', '6670e6d4-2692-48e9-ac61-ce13fde7e4f1', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('12020515-27ee-43ae-9d75-9d715edb084c', 'bab2059f-4771-435d-bc72-68c3dfa3c034', '15d63c5e-6638-4b9e-90bb-1ae6da20ec5b'),
('12f3d0b8-f3f6-4db8-b4d9-7b612b1b691c', '59635d64-3643-4b49-9f0e-3ce0f37ca522', '8b54acae-99f2-4f0c-b1a1-66af1a27fd74'),
('13afe7d8-6d63-4836-a3e9-1168e84c8cf5', 'a2b5b70b-5821-4473-bae7-b24667b3a93d', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('14aa1787-d9c7-4f8b-bd35-8647790e5598', 'c47791b9-a9fe-4f23-97ad-ec0c8d389063', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('158bcdfe-8924-435c-a65c-6a1c98ee00be', 'e091aad4-0da5-4954-8059-4a333cc388ce', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('15abf7f6-e96e-4fd4-ad94-185da6fcfb13', '820f0869-12b3-4bc3-b2da-6120e277b0ce', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('1b65c26c-52af-43b2-a45e-a41c92571d1f', 'c14b4ea8-ae9c-445b-baed-8db9e919f53d', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('1c2dc949-8f22-409e-ad9e-ab46af78d02e', 'fd5a858f-a55d-4ee9-84f7-c829b8ef3477', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('20454d98-98cb-4f95-b434-9e5ec032f7c5', '50d846e8-366f-4a94-9753-b18b7a8bc4da', '5c76b059-2150-4508-8181-b7cb13569128'),
('224749c9-d51f-49ec-a8c4-0bc396c026ef', '13dab5c8-ae95-4794-ab71-063bf0117cd8', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('231a0f3e-f229-4363-b9c7-0f7a13ff275c', 'cfc8f902-e546-4f25-bc5c-8898965e4210', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('24b3d58e-1495-4a71-aa40-9462e92b571e', 'e992f360-d32b-4f4a-840c-3c3e9fcb0163', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('2bd8475d-628f-4b19-b489-1ad038ee0614', 'f58bc7fb-c311-4b30-97a5-3078182d337d', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('2d0f1ab3-40dd-4e75-8ec3-248297679eda', '5c1ef7df-8594-4d55-988a-fbf6eb5e41e6', '89a54a33-2982-4985-930a-5b52e29e44d8'),
('2dbba40c-9a2f-451f-9b51-424062c89d8a', 'd51c2942-0033-430a-9ec9-f964f8c3ac6c', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('2fbea450-d37b-4706-ab2a-f4c19cefe5cb', 'b5e910e8-e954-437a-b5f5-50b2b333c6fc', 'b891aa9f-547a-4f48-958e-cc219561f4d3'),
('30e0c9db-ed99-4ce6-ab3b-2d6b47cad91d', '2cbd1987-f380-4032-abf4-8ab9f02bfb16', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('33d7055a-7a86-487f-b57d-0e0dd2962378', 'ba209dc4-ccf9-4feb-ab67-b641782ccb75', 'fe2b649f-2cc4-424c-af71-0095e5823b05'),
('33f206f7-cd0b-4096-8292-db85566a7f48', 'ca208078-034f-47dd-86c1-ca921609360d', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('3d6d8eac-d980-4fb5-9e10-cd95f0101216', 'd2f94f97-1a7c-422d-84a8-8db5675b5f82', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('3eefd903-e77a-439f-abb2-4eb86fb32f21', '6dd178b5-e0ca-434a-8a95-97207435bb68', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('40104e2c-d122-4f22-8d21-6b19f1856550', '8109e664-9fe7-4f79-9575-fdf4219a085b', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('41c77149-69bc-4544-84f1-d9b52e3d5544', '7cd3fe7b-c5c6-45e0-b41e-cfedc923f7e5', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('45376c58-58a1-425e-9ffe-1ee43c538028', 'c510bbdb-30e3-4005-b318-eeb597288d2c', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('4813d8fc-ed9c-4dcd-94a7-e82f8a52b102', '7c597a7a-2bea-49ff-9300-1db3e01707fb', '0724033a-f1a0-4283-95b0-15b293a90008'),
('4a8fb6c0-5044-45e4-958b-5071c77d25a5', '6d9e24e8-820b-4320-be94-94012619b7c6', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('4b188aee-1005-4ef1-ad71-366615655ebd', '1659e5e0-51d3-46d2-b7df-737a9c64843b', 'aae19cb0-8ca5-458d-9d52-c6f7a1471a45'),
('4b3ac198-17b8-462a-b66a-b808af9c6e2c', 'eeb12891-f466-4d1d-bfa9-71c05c8d060d', 'aae19cb0-8ca5-458d-9d52-c6f7a1471a45'),
('4c42e08c-82f8-4a53-a856-8cbf71b72033', '16486658-61bd-41a5-9273-a87a55907912', 'df2305f7-4bf1-445b-9b9d-1e87a2baadc6'),
('4f0eeb89-b5b8-471f-8b3b-a41dc1dcb4e7', '8ce708c3-c391-49f2-a323-a84804420380', 'b891aa9f-547a-4f48-958e-cc219561f4d3'),
('4fa6e5e6-8425-4ae6-b005-16bd6191164d', 'a297d136-7366-4724-8701-352a4bd049b0', 'df2305f7-4bf1-445b-9b9d-1e87a2baadc6'),
('51d46753-8f44-48c5-83ea-e3b8c17e0e37', '360cebb5-530f-427c-8f3f-93d3e320ab78', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('54674a46-da60-4326-89f7-94660d513d43', 'cfcd1361-3720-4b49-b4a0-0b36281113ca', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('565ca8b1-1ae2-45b3-be0e-0b2e189a835e', 'b171f000-983f-45d5-98b2-d0405e65bbed', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('5954b145-dd3b-4342-a41a-e312a4b7dd75', '33e38ebb-3b50-41b7-9243-511005bf1774', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('5f93fcb9-f018-41d1-a367-8a1ed6c837f2', '28981074-1d4d-4939-94a5-4a8cf0fa6b4f', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('62905c71-569d-49ff-99d7-1e2d3bc9dfdc', 'b5b6e969-4a40-4ef1-811d-d9bfa5df278f', '89a54a33-2982-4985-930a-5b52e29e44d8'),
('6493c115-848a-4d69-a6b2-825052cd58b5', 'ba2e99b4-50cd-40ae-b022-edc4481527ce', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('64e5b30e-340a-4031-986f-c80381813cf6', '8a472886-d9de-4f84-9e74-3916650ed19f', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('65df0ef6-74f4-4deb-bc33-3d4d64d4bcf1', 'c8f38a20-f4ec-44da-b2c2-b1d4b5cfd59d', '4a9207e6-581f-4130-82d8-a78c15f0cb12'),
('67d67109-0d45-49bf-9841-76cf05e29ac6', 'a0e6aef5-f5f7-4850-bb39-8c1562fde029', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('6920867f-64fc-461f-a17b-52190a449f35', 'eddce392-6d22-42d8-b791-7430053627af', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('6b0c0f67-50f7-4502-a552-5bffc4868303', 'e8b15c33-e018-4f72-8850-265af6262348', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('6ba51dcb-7fe6-42dc-80d7-6daf5de360b2', 'da8c7371-050a-40a4-a034-010cb40daf91', 'df2305f7-4bf1-445b-9b9d-1e87a2baadc6'),
('6ed5edfd-eef7-4703-a339-de6c5e6c7855', 'aa44bd23-03bf-44da-960a-a83b114e5f58', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('6fe96d82-9916-4fdb-9eed-8bb98e29d37b', '643ebad4-26d5-4ba9-9290-4a8d3ee2de2d', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('704c246e-dc73-4906-8fab-ac47884d2ec0', '4bce4ae4-3451-497b-8817-f4ac42c49460', 'fc918903-a5f8-4d31-9d6a-d40298846324'),
('7181e8e3-60ef-4c68-9ce8-7877e9542033', '68299658-1f56-4cb1-971b-5ebd7773aec2', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('723d7ce9-9846-41da-b87a-c382e63df8ed', 'a087a24c-5e7b-40d0-8e41-9cdc106d0adb', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('724418e9-9a56-4fe2-b2c9-4394e79987e1', '51cd92e4-c62c-4fcc-882f-c0942d5cddf3', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('740cb54b-c1a2-468c-a8b9-11f72e3dad8d', 'df1df4f0-2de3-4040-9bbf-b92e8d4fc5f6', 'b891aa9f-547a-4f48-958e-cc219561f4d3'),
('758aab39-c012-4106-b877-5efbdbe788c4', 'a6eb710a-bf2d-49eb-9b96-049a08c9b816', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('7788a706-1206-479f-b491-e6a3454df18e', '29128c3f-26ed-419c-8ecc-aea6b7cd9766', '82db2499-66ac-4626-9a4d-805b73d37d80'),
('7991c610-76ac-4966-9b4a-309a7392b4d1', 'bb3fa05b-1905-47fc-99c5-6fb9bbdeef7c', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('7a331c97-9e16-489b-a69b-8002672f7fe3', 'eeab2bcd-7e61-4d2e-8b90-de7818c00af5', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('7d9ce1b3-84a2-43a3-9776-fc15be621c1b', '562893b7-7619-4f6f-be77-9beb62cf740c', '5c76b059-2150-4508-8181-b7cb13569128'),
('85c17475-ef48-4ad7-86c0-a3dc29548315', '6d64ffe3-fc23-496c-9660-60fbe6cf5722', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('877ca378-47ed-4bac-8a5f-eb1fba8397ee', 'e7fee8e5-bdaa-4bf4-aa06-462446e058ae', 'fcfe1690-f261-4ccf-a7d3-ada5340f74dc'),
('8c0dc61a-98bb-4d59-ab09-aabce3854aa1', 'b25d0f0e-3a85-4b6b-903a-6fd49ba60816', '5c76b059-2150-4508-8181-b7cb13569128'),
('8c4acdee-78bc-4c18-8504-f62b0a78941c', 'bfac94df-2063-496c-871c-3618c446a199', '5c76b059-2150-4508-8181-b7cb13569128'),
('9ab56395-d18f-4eef-a01d-cb3361e5a01d', '00a042bf-765e-42e9-b586-5e34cfb3abce', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('9ca0ac35-2f3b-4b48-b7e8-daf331348957', 'c996dc58-b162-4da2-9eb9-47cf272c3602', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('a4abf2e2-f05b-4dc1-b008-3c73d75fdbb4', 'd5303748-1944-4a0d-aba6-c0234ad40f03', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('a4d78ed8-667a-4b87-961d-6500f20e1c12', 'a09abc52-3c57-4627-aa2a-ac8c61ac6d1f', '89a54a33-2982-4985-930a-5b52e29e44d8'),
('a5e49b8c-af96-4842-a9af-06f155401227', '055b21ff-4160-4900-be76-235bb25e384d', '60ed68ce-a91c-4bf3-b7e8-8d16678e7b2a'),
('a6e595ba-6282-486d-9fb7-9ced46c2d0a1', '64078f75-b407-40b6-8231-a54171f78806', '0724033a-f1a0-4283-95b0-15b293a90008'),
('ac8a3ae3-f9d3-4b8c-9ba0-c7463f5e4d08', 'cb87678b-3afd-47d1-857f-8e207f6f0b18', 'f0f70b26-2053-4686-bc3b-48e4f67cf835'),
('aed6612a-823f-4bc7-a636-5c823d701ef2', '439b4525-f668-4c1b-ad6a-80c23196aaaa', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('b25903f0-0323-474f-9943-9d1723aebf01', 'c602bfbd-8832-40cb-a82e-af827e51c1bc', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('b95665ee-80d4-4bcb-a20b-85573046ddeb', 'ddaa36cf-5bcf-4672-acbd-d24e5bb0de4a', 'fe2b649f-2cc4-424c-af71-0095e5823b05'),
('b970d626-7e49-4b99-92c3-08284a556ba9', 'b4e717cd-6a28-4f9a-807c-23cf8aaf7342', '4a9207e6-581f-4130-82d8-a78c15f0cb12'),
('bb38fea0-7fe2-47ec-8ccc-b2487f5f18c7', '0d468b4e-2f8f-4b42-b5dc-2a2a54061683', '31cb2d4a-bcac-4322-91d4-a89728c8dbe2'),
('bfae088a-11d2-4bd1-8b00-4d22d0803b49', '8f7ea8b7-c5b5-48f0-bbda-491fef0867ce', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('c0ede70e-a1e8-40e4-a71b-92f083959ce9', '326b35d3-f345-42f9-8b19-4607e25fcd8e', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('c2d0a356-1c02-4cd6-8a12-30ffc3eb84ab', 'cd75db88-df76-4dd1-bd70-9a523230ba98', '89a54a33-2982-4985-930a-5b52e29e44d8'),
('c3cd5a8a-80af-4872-b9cf-4aaab108c098', 'ddfb6f97-56c7-4644-81b8-f2455756166c', 'df2305f7-4bf1-445b-9b9d-1e87a2baadc6'),
('c48fa606-530b-43f9-970c-e789c46d042b', '5edd618b-b93a-4bb2-b7b3-d3b33c1863d4', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('c70a3d01-82d5-4f69-a6f5-ae5ec757546d', 'aff07c9c-5a6d-4f5d-a834-7f8db6b07e00', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('c7b03364-f9ea-46d2-b0b6-e7b2b5fd1866', '9ac22c90-1837-471c-98bc-cb82ca898136', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('c831fc5b-0830-4ce8-8c38-ed317bb696f3', 'b789109d-b6ba-4119-9b37-5cc06ad1dba2', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('c888aa24-9f5b-4cd2-855d-7197045d6ddc', '3397d6de-d7af-47e6-94f6-e8772af25380', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('ca57f5e0-6515-448c-8a00-ec9bdc48ccea', '76fba5bd-eae6-4f36-a275-f5cc80afbbdd', '60ed68ce-a91c-4bf3-b7e8-8d16678e7b2a'),
('cc29cb33-468b-4744-8f8b-671e1c28ef7b', '53933e18-98e1-4526-9544-61d8302a1112', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('cf2b31f7-b234-41b6-a1dc-3f07ff548bad', 'a3e2f44b-df5a-4d43-b34b-7024e3bed50f', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('d24618d5-2e21-46a3-99f5-c82cfb189e33', '83730dc8-b2af-44af-b24e-15b08f89f669', '5c76b059-2150-4508-8181-b7cb13569128'),
('d26791be-77e6-4b21-939a-374b33b96cf9', 'fefc77cb-b1b2-4f7d-a0ce-b8ca2a6e1ece', '89a54a33-2982-4985-930a-5b52e29e44d8'),
('d2c37d64-4053-4ade-a291-23b2f1f2ac87', '7ce6959e-6997-4eef-8042-4fa645265ece', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('d451ae28-141c-4a22-839f-a93b53e9436f', '3a78c0ee-f931-4816-9618-117beaca72a9', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('d9082dce-69f1-4958-b1de-ea0ca3fda05c', '3bdc8e63-f2ed-41e9-840e-0bccf9a5fc0f', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('dc632a24-f744-42a1-9a44-42b6380f486a', '241432c9-61d7-4b5e-8a08-ceb2e278229c', '3a273f95-7616-4a2c-b098-189009af3547'),
('dcd9b30f-e020-4785-ba18-c091ae98631f', 'e898bd16-0531-416c-b45d-4f8fe1ca09d7', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('dd396927-7c5d-4447-a72d-ffe454de83c5', '641b98ef-6d76-448f-a986-b7031325100d', '82db2499-66ac-4626-9a4d-805b73d37d80'),
('dedaaaa2-77a0-41b6-9563-e834c9840290', 'c160d505-998c-41a9-8b54-431d6492d912', 'fc918903-a5f8-4d31-9d6a-d40298846324'),
('dee347da-8b9b-44d6-b5e0-38de61bfd79a', 'd8f83541-7749-4795-a963-9fbd73eeadbf', 'f49612b2-37b6-4f89-966a-16af1600440e'),
('df3fdb96-b179-49e7-baf6-c8fde5f44e73', 'aab17628-679c-4a01-aa9d-fbde30d26633', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('e19220ca-407c-4048-b145-b4a2e363258f', 'c2c8054b-0b16-4779-a507-bc1b041412f3', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('e30fef6b-0ed8-4b8a-b355-4b10e9a5bf56', '38069f36-b271-4de9-8227-5edd7276a07d', '0724033a-f1a0-4283-95b0-15b293a90008'),
('e6646d5b-e6de-4c3e-90d3-0c8256f63fe5', '3db5ca1e-cc0d-4104-a275-955d2261d193', 'aae19cb0-8ca5-458d-9d52-c6f7a1471a45'),
('e8a1952a-895d-4934-8bf7-b9fa3ab0206e', 'f0c1e428-6161-4f10-ac77-924605016cd5', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('eb07af70-094e-4abb-9a42-8fa1e73c2eee', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('f1107105-a410-4cf1-a2a8-089513e6b03e', '3cc415c0-b3ed-4918-a606-e869eecba300', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('f2006eb0-0b40-4460-b9a5-d91e442ffc94', 'f43a2e72-9087-4840-a992-3d0e2c3b150d', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('f5ef1a43-cdc0-401f-887e-eea106d56cdc', 'a57d30ad-a731-49df-a66b-8592075d3ba7', 'af77206a-6915-4016-a338-1b6dcf5470ad'),
('f8156188-9467-4218-a74d-0ffd35ddaef1', '5f42bb12-c914-48e4-8ed9-bd08d71cde12', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('f9f585b9-a9c3-441a-a500-8e5c598f07b7', 'd4540d46-b613-4297-8f5b-87689628ecd9', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71'),
('fb6bbab1-1a56-4d75-968a-d1ef483c71ee', '03f3f166-c138-4065-b070-2f07921020fa', '8b54acae-99f2-4f0c-b1a1-66af1a27fd74'),
('ff634c0e-39c3-4289-afc4-e538a2eef097', 'af75ee50-7384-4beb-923f-ae6017ba03d5', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71');

-- --------------------------------------------------------

--
-- Table structure for table `channel_content`
--

CREATE TABLE `channel_content` (
  `channel_content_id` varchar(50) NOT NULL,
  `channel_id` varchar(50) DEFAULT NULL,
  `content_id` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `channel_content`
--

INSERT INTO `channel_content` (`channel_content_id`, `channel_id`, `content_id`) VALUES
('01f69fe3-7506-45c2-8777-0dc36f85e009', '6670e6d4-2692-48e9-ac61-ce13fde7e4f1', '2d1a8d16-05b7-4858-baea-2305d8250c8c'),
('02ee4eff-1138-4934-8f3a-8b8c5e99f4b1', '643ebad4-26d5-4ba9-9290-4a8d3ee2de2d', '9a0941ca-a615-424f-82cb-a75b2a233fb2'),
('04be3a1a-8dba-4cd2-8b86-3fcfaea11dfa', '6d9e24e8-820b-4320-be94-94012619b7c6', 'ac00f1a3-d044-4513-b020-69133803d123'),
('052f0672-f221-4a40-867f-fdfd2d838164', '51cd92e4-c62c-4fcc-882f-c0942d5cddf3', 'af202296-814a-4774-b93d-0cf569dfa068'),
('0534cf6e-3b5c-44ed-8706-0d6bc198f89c', '76fba5bd-eae6-4f36-a275-f5cc80afbbdd', 'f6bb64c1-fd8a-41f8-9127-d51641860fc2'),
('0543b978-003a-4ee4-979e-e39d388e6522', '76fba5bd-eae6-4f36-a275-f5cc80afbbdd', '2ccdd546-f496-4325-8a83-8169a5bdc352'),
('06d950db-9f81-433a-a0b6-c8d22c0e5627', '8a472886-d9de-4f84-9e74-3916650ed19f', 'f6bde20e-6ada-4467-8098-1501435329d5'),
('0707ae21-b1ef-468f-a2a3-4961786d4741', 'e992f360-d32b-4f4a-840c-3c3e9fcb0163', '7ef23efb-69bf-4bd6-afbe-0a5c3e75cdfb'),
('0a351a36-0268-432b-8c49-3815de18f756', 'cfc8f902-e546-4f25-bc5c-8898965e4210', 'd9351233-a483-4e8e-9181-795bfe229def'),
('0d94af1f-b7c2-42c2-945d-cf584ce2f88e', '4bce4ae4-3451-497b-8817-f4ac42c49460', '28aa3efd-329d-40aa-b99c-2d67c06c4b11'),
('0e0fc4c7-a90f-4655-8413-0ff048aff513', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '71e53da6-2bcb-46ac-8062-a5d972e51e5f'),
('0ff61b87-f0df-45f9-bc7a-86d1db882c81', '76fba5bd-eae6-4f36-a275-f5cc80afbbdd', '371511c9-445f-4e17-8301-15f142cb0b5e'),
('104d6a70-ffe9-45a7-bda8-e4a5bbb3a628', 'b171f000-983f-45d5-98b2-d0405e65bbed', '68a24c54-aa43-4193-9c50-ba4cb023271b'),
('105612e2-745b-49e6-a122-5c23ca49a2f3', 'b171f000-983f-45d5-98b2-d0405e65bbed', '64fefa2a-9443-45fb-b016-bfa810ef7c3e'),
('1070966a-6e65-48db-b36a-6088506b91ff', 'eeb12891-f466-4d1d-bfa9-71c05c8d060d', '4b7b224f-8c50-4281-bf55-9a56e8f6df93'),
('10e593bb-22c2-4040-b334-2ec1e98c97c0', 'f43a2e72-9087-4840-a992-3d0e2c3b150d', 'ac8f8928-f3a0-46a8-8c24-be9a5f99fe54'),
('1101f9e2-88f0-4338-bf08-2ec8e86f042b', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '2016674d-dd1f-4284-9cdc-99a2df18f757'),
('11e7dd0f-3f8c-44e9-bee4-65b67a2f9a21', 'e091aad4-0da5-4954-8059-4a333cc388ce', 'f99ce6a4-a514-4423-8d23-5a2f4f616f20'),
('12628b61-d01a-484f-80af-f6b514f93ead', '3cc415c0-b3ed-4918-a606-e869eecba300', '64f633b2-52f4-4b0d-8545-4464358c7af7'),
('127382cf-2220-49e6-abab-78ebe9f7e4d1', '76fba5bd-eae6-4f36-a275-f5cc80afbbdd', 'c8f9279d-a385-47fc-b7cc-ff7fc91b8e93'),
('1459cccb-6c51-45aa-be91-da7245b36c86', '64554422-655b-4ced-b640-fa4d85dcb221', '2d00ca0d-1091-4edf-b62e-0f3cdf43025f'),
('17c166fe-02e3-4db1-9077-8122ce3f7870', '8a472886-d9de-4f84-9e74-3916650ed19f', '58bd3a90-d181-4c24-afca-b0fefac9384c'),
('17c1e6c6-f63c-4656-86b9-749835ae0086', 'b171f000-983f-45d5-98b2-d0405e65bbed', 'd6718b7d-9fe7-49a7-acd2-595ae9d70842'),
('192deb6a-b4ef-4cde-94c0-516ad8dd1e2a', 'cfc8f902-e546-4f25-bc5c-8898965e4210', 'a0f73c54-15c7-45e9-83fb-4cddc074ef95'),
('1a7839b8-16f3-4366-a7eb-e01b2616a2c4', '8a472886-d9de-4f84-9e74-3916650ed19f', 'e8c144d5-ed24-4c22-a4e3-994da9c34993'),
('1c0cabce-e98c-4496-be9b-ac01495b100b', '643ebad4-26d5-4ba9-9290-4a8d3ee2de2d', '1fa43ac6-a3f5-487a-9259-35ee4aa7d0c1'),
('1c9852bc-158c-4aec-a3ea-7140b5006727', 'f43a2e72-9087-4840-a992-3d0e2c3b150d', '3c41205c-367a-47a1-962a-f52889061bde'),
('1dbd8999-3f89-4400-acaf-c6d6f9c96f6a', '3cc415c0-b3ed-4918-a606-e869eecba300', '20ca295b-b49e-4515-8fda-09f904293b37'),
('1df161b8-524d-4506-aafc-d61831956227', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '8c80e0c7-88b6-4a03-8d6c-58c6da3ed32a'),
('1e344542-4423-4c18-8473-f0c5da01831b', '6d9e24e8-820b-4320-be94-94012619b7c6', '5d59f3ec-3a8e-432e-9fd4-8a16a83b6392'),
('1f2b8b37-0481-44df-86bc-fe31e0c4646a', 'e091aad4-0da5-4954-8059-4a333cc388ce', 'c2c4f462-ac4b-4cb4-b80a-be82da8dbd65'),
('1f53ed99-f921-46b1-8c8d-c91c2da10686', 'e992f360-d32b-4f4a-840c-3c3e9fcb0163', 'b1ae1616-8821-4435-953e-f2be836c2d39'),
('200162f7-0214-442e-b22c-cb60fbff1a43', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4', 'bce9d372-f621-466f-9ff0-d4d1688883e2'),
('22265537-ac1f-4ec5-bff3-8443d3ba4c3e', 'f43a2e72-9087-4840-a992-3d0e2c3b150d', '89cb33bb-28a1-4a43-8e6b-e524dbaf7e53'),
('2297dadf-301c-4bfe-9d4c-39d5d24f4f11', 'e091aad4-0da5-4954-8059-4a333cc388ce', '6cc5a93d-3d21-4f41-ac93-fe6483517898'),
('22a953ce-2790-42a5-a5fc-c9046774f5f3', 'bfac94df-2063-496c-871c-3618c446a199', '1084830f-332f-4eac-afc6-e0f42e952d7e'),
('233c586e-9388-4c26-ab15-3844191b8d71', 'b171f000-983f-45d5-98b2-d0405e65bbed', '3c190e4d-d2b2-40fa-9186-01686ce6668a'),
('2377014d-5369-4708-9ad8-2d4ee84f0908', '643ebad4-26d5-4ba9-9290-4a8d3ee2de2d', '3b709af5-e50d-4e67-b4e8-d7feb668d2d8'),
('238890ff-2f8b-44e3-9121-ab8b5310d0ac', '643ebad4-26d5-4ba9-9290-4a8d3ee2de2d', 'f719262c-5c2a-4911-bf66-e06bd53095a1'),
('23cf05a5-9add-4878-a924-55fdc4b19661', 'e992f360-d32b-4f4a-840c-3c3e9fcb0163', 'efaa4234-5c4b-44e2-bbf8-d4c593158e28'),
('23e6fdaa-8efe-402b-b376-be6b869f8cb8', 'e091aad4-0da5-4954-8059-4a333cc388ce', '706c8081-713b-4804-886a-f7aa6efb2649'),
('2437561d-e0a6-4bf1-a19b-7b48927d9e09', '64554422-655b-4ced-b640-fa4d85dcb221', '0349d105-e67b-4c3c-b887-1b1969124673'),
('243bec6a-bc5a-434c-89d9-63e5a2d9ebc7', 'f43a2e72-9087-4840-a992-3d0e2c3b150d', '44526186-270f-413c-a1e9-cfc7e0333e2d'),
('245a49d4-7008-4b0b-ba04-331f19ac9703', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '22d35311-ec41-4aec-aa09-6b03166c1387'),
('24a29443-3e87-4a78-b697-ef688fe4aa30', 'cfc8f902-e546-4f25-bc5c-8898965e4210', 'ccd85295-6268-4c93-83fb-6e65c3a0dfad'),
('24cd1f9a-42b5-4123-806c-f59a9ec0691b', 'd5303748-1944-4a0d-aba6-c0234ad40f03', 'b4480cbc-8853-4943-b6d1-5228ccc32c03'),
('2618437b-d041-44ce-b674-039ae4e3ac89', 'f43a2e72-9087-4840-a992-3d0e2c3b150d', '4078c088-2e95-4711-b1e2-fd581ed47fe6'),
('26e837c0-7346-4fe8-ae90-81f3e7c4223c', 'f43a2e72-9087-4840-a992-3d0e2c3b150d', '09312597-3c06-4168-8c68-128b24bd63c4'),
('276a79bc-a261-42c0-a82b-210da0218a5a', '8a472886-d9de-4f84-9e74-3916650ed19f', '8953db24-986e-44e8-8b0c-3f52aba5db00'),
('280f8b9d-80fd-4d4d-89b4-41810501aa67', '6d9e24e8-820b-4320-be94-94012619b7c6', 'd6e4fe41-3965-439d-99ad-bfc404c5a436'),
('292244a6-126b-4d29-9229-622db4a94674', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '382eb76b-a8fe-49f1-914c-730317a9c0b8'),
('293f9461-d217-413d-a836-eca5ec9ccdeb', NULL, '2d10e9c3-b851-4cb8-8207-bf0715e1b729'),
('295b097a-600e-4870-b047-5e6da9f31fd2', 'f43a2e72-9087-4840-a992-3d0e2c3b150d', '4a5523a5-1601-4d39-bbf7-a9ff4132b53b'),
('29de3851-5c4b-4d26-8225-d5943d837212', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4', '54e9bdd1-2c35-41dc-aa89-c3a65d40280d'),
('2b2cb803-0f09-4feb-a9af-2a2b24d772fa', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '3110f5e7-4070-474e-bd1d-8a826f7f01ae'),
('2c3fab2b-de25-4d7b-9937-4a970bba6e52', '8a472886-d9de-4f84-9e74-3916650ed19f', '3c7b90bd-aead-48fd-b4ad-8ab36c4df33d'),
('2d09c645-e1d5-4182-9cf7-a988e6e68026', 'e091aad4-0da5-4954-8059-4a333cc388ce', '593fbe60-00df-4e30-a7c5-19efecf83153'),
('2eb0bdb2-9f1d-417d-b2bd-34a3011517d9', '55981906-d119-4759-abda-e0e9542f0d5f', '1b361238-7753-4bf7-afd2-bc9a545516e0'),
('2f4be0f9-7036-419f-af50-a1bc2d0a948d', 'f43a2e72-9087-4840-a992-3d0e2c3b150d', '2ddb1ca3-05b4-45e8-918f-6019790f24e5'),
('3030091d-8b29-428a-836e-c51f51aee8fd', 'ab081fe2-0d24-4be8-902f-5df1b9cba010', 'a53f5189-395c-4def-a444-0975c5bf97bd'),
('3097df80-c55c-47f7-8462-ad0799f9ef35', 'd8f83541-7749-4795-a963-9fbd73eeadbf', 'f4fce630-a2bd-4707-8828-842c78471a28'),
('30f6ca42-cfa1-456f-aadc-34dc8b18103e', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '1da245a0-48ee-421f-a653-67216b328f90'),
('3283c10e-1ed6-46e5-9390-7fceadf51992', '8a472886-d9de-4f84-9e74-3916650ed19f', '7c8eb3ce-fa6e-4e4e-88c2-71500aad53a4'),
('330fa44e-0f3e-495c-8e02-34a8693c7164', '55981906-d119-4759-abda-e0e9542f0d5f', '93467de8-756a-434c-8fdb-d9456deb1eb1'),
('33f38cd9-bcaf-42f7-ad45-8065a8e7855c', '3cc415c0-b3ed-4918-a606-e869eecba300', 'e64086a1-79a6-4b98-b465-095dd3b88105'),
('33fb32d9-e916-41ee-b919-aad0c0c7171d', 'bfac94df-2063-496c-871c-3618c446a199', 'fa1a69d5-f3eb-4ead-89fb-e23c88cbabd5'),
('346d0138-7098-4961-a870-e315025552ae', 'd51c2942-0033-430a-9ec9-f964f8c3ac6c', '34e51fa5-b24f-4404-9939-1043223ef5db'),
('351bc443-389b-433c-8ab2-16f9498bb217', '3cc415c0-b3ed-4918-a606-e869eecba300', '6251f631-9061-440a-9efa-3c7b84cdc734'),
('36ed9ffd-8297-46ae-988a-68b788ff4d8c', '3cc415c0-b3ed-4918-a606-e869eecba300', '217bceb5-3c40-41d5-bbaa-c04d48e16369'),
('3742e20b-b522-4e9f-9343-f89505e9ac21', '55981906-d119-4759-abda-e0e9542f0d5f', '5e03e991-28d2-4206-ac3d-10858379a49a'),
('38455f11-dd2b-448f-a7c1-c8cb8bab6f52', NULL, '19df55d9-b885-474d-9558-3fec8d561540'),
('38d79b27-a6fa-42fc-b898-39fd481d1192', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4', 'a4f7fc73-df21-4e72-87b8-4749c0d502cb'),
('39c0fc2e-b9d3-4e8d-8b62-2ae7388d7a40', '55981906-d119-4759-abda-e0e9542f0d5f', '417961bc-be7a-4203-acb7-5c4649ba73ab'),
('3adeaa80-352b-4020-b07d-ee43b0b067ca', '643ebad4-26d5-4ba9-9290-4a8d3ee2de2d', '35e23e3d-78d3-484d-9559-d1cc04c4cd8c'),
('3badf15e-ae15-40f0-9750-da9d56e95017', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '08390a19-2313-43cf-a9e9-96eaa63b5d4d'),
('3beb63ba-4dfc-4dde-bfb3-a4c7de615506', 'cfc8f902-e546-4f25-bc5c-8898965e4210', 'a2186fbe-d3d1-47db-b452-b5b952d348f6'),
('3c372ef9-8aa0-4665-92df-1fa2303fded1', 'f43a2e72-9087-4840-a992-3d0e2c3b150d', 'bf7b90b6-0a37-430a-90a2-c527f7b0a445'),
('3cfff174-de86-44b0-88db-0492c4161b7d', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4', '21d6a2a0-cf7b-4ce9-b329-480a405849c1'),
('3d4e8a5a-f194-4824-a83a-a8f4e07a85cb', 'f43a2e72-9087-4840-a992-3d0e2c3b150d', '8ccce5fa-b902-4497-b99f-db603c190db5'),
('3d5c55ca-2eff-4038-8bac-69fea9acee0e', '3cc415c0-b3ed-4918-a606-e869eecba300', 'e13445e0-d94e-48cf-8e76-3057580e9c34'),
('3f17a08b-b80c-4a7e-8c1c-92889b10e259', '3cc415c0-b3ed-4918-a606-e869eecba300', '3018fae3-33a1-4145-8f33-dbae2d6129d8'),
('3f406811-5b65-4261-b3c2-e09313074ec9', '6d9e24e8-820b-4320-be94-94012619b7c6', 'be87f5c7-6b2e-4cb7-9f74-bd4e1cabaa20'),
('403f859e-9ebd-407c-bad9-04058f83f6cb', 'f43a2e72-9087-4840-a992-3d0e2c3b150d', '42fab386-43dc-4a36-8de1-945487819268'),
('40793ea8-dabc-4c78-a684-2e6e8250b676', 'b4e717cd-6a28-4f9a-807c-23cf8aaf7342', '79d2b3e2-bac6-4542-a17d-3e4764c3012d'),
('44395199-9687-4dda-b8ed-8a6dc0c49edf', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '5a69c1cf-034c-4a6c-93c4-d28a53909080'),
('44bb2f96-4573-41fa-bae2-edd9bf81e9e1', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '5441f08e-c596-424a-a4ac-8f161464e911'),
('45792ab2-1a51-4bc1-8036-49b101e2efda', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4', '710c51c1-0084-4f30-a4f2-d9d3af55d30d'),
('458ebe9f-e0da-4fa7-a8bf-d51c7749c97d', 'cfc8f902-e546-4f25-bc5c-8898965e4210', 'd0d26b98-feeb-472e-b436-d979f4d66efd'),
('4592bec3-8e41-41ae-aab0-935187c41fe8', NULL, '0c12765c-a189-4955-aa76-990045971d2b'),
('48925854-7692-4aaf-9fd8-8e64f734d25f', '76fba5bd-eae6-4f36-a275-f5cc80afbbdd', '19e488fc-d0dd-4cb0-9063-771fd5233872'),
('4a032d81-23ed-4e16-9192-06dc637cacd2', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '1837fc4c-c42f-4282-a921-5eb2b0a12f21'),
('4a52f233-97ad-4108-8b6c-947673520fff', '3cc415c0-b3ed-4918-a606-e869eecba300', '10ec37b2-ed12-40ab-af89-3f1ef4399098'),
('4ccbcbf9-ecc8-4f50-861e-3d35166bea93', '51cd92e4-c62c-4fcc-882f-c0942d5cddf3', '24644ad3-36b5-4d03-b144-3b8c436e3e1d'),
('4cdbfaa3-9bbb-4379-9596-46c7274595af', '51cd92e4-c62c-4fcc-882f-c0942d5cddf3', 'b49ce7ca-43db-41a4-a987-b3bb045b4062'),
('4d941391-d1ad-4919-ab25-b5ac9fec447c', 'cfc8f902-e546-4f25-bc5c-8898965e4210', 'd47c5300-9285-4f99-b35e-7f758e9140c2'),
('4ebf49f8-ecfc-4a6a-a839-cc4fe9fa6133', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4', 'bc169ec3-dc5a-4a54-bc69-2f7c5cd661fe'),
('4ffce53d-c891-4eaa-9835-d1651e32091e', 'cfc8f902-e546-4f25-bc5c-8898965e4210', 'c66e5987-5f13-4ab0-aa56-8b6a70c3b4e9'),
('50434a1b-778f-44bf-99e8-655ec0b1b8b1', '55981906-d119-4759-abda-e0e9542f0d5f', '797d3b3c-7219-4ee4-9f92-3148d64c6bfe'),
('50d89388-d0b2-4f2e-a0c5-53d87279da0d', '51cd92e4-c62c-4fcc-882f-c0942d5cddf3', 'f7bdd3d6-3f95-4750-800e-80762b3a6a58'),
('510b1993-d1fa-46ca-8fa2-67604ea46e3c', '8a472886-d9de-4f84-9e74-3916650ed19f', '6c07b940-6820-4438-bb07-44f16c140764'),
('5213f5d1-b598-4fbe-b6ba-34345121d731', '8a472886-d9de-4f84-9e74-3916650ed19f', '765a1d69-be57-46ad-bf67-3d7e99869853'),
('52b2871a-c3fe-4b90-8891-d2209d47c0b8', '8a472886-d9de-4f84-9e74-3916650ed19f', 'f5657bd7-49b1-421f-bb03-52b424c8edf8'),
('52c8f09c-2e9d-4cca-a830-ea55b0a9a18e', '76fba5bd-eae6-4f36-a275-f5cc80afbbdd', '462cffdc-712b-4d88-8acf-e4e1d8a906be'),
('542eb493-5acb-4160-913b-422cd4bfed46', 'cfc8f902-e546-4f25-bc5c-8898965e4210', 'cc86b59f-e8f0-4dbd-9975-2aa8b6b538eb'),
('54711465-f2ce-4eb8-b610-1c8d0328de90', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '42c3685b-e267-40b2-a99c-4af3ba44f14f'),
('547668c8-9012-49fa-9fec-0c35b6e09862', 'b171f000-983f-45d5-98b2-d0405e65bbed', 'c592e389-61f3-4c40-8c7f-52c30f4d40de'),
('59083a17-c367-4fd6-be1f-325e829543e3', 'f43a2e72-9087-4840-a992-3d0e2c3b150d', '435f3f6b-9b78-4169-af49-d8ba2afdab8a'),
('5e4b4fb0-6592-4802-a6ee-7b26d0d79f49', 'aff07c9c-5a6d-4f5d-a834-7f8db6b07e00', '1ad9ee11-cb40-4753-a454-7d3941beb423'),
('5e603c12-da21-4807-8541-a094a54c644e', 'bfac94df-2063-496c-871c-3618c446a199', '188cc903-d0c7-459f-86f5-f5e11e184464'),
('5eaa9c90-6d4a-4120-9717-2d494737afd6', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '209b6b15-61f1-45f6-9f9e-6caf921f8031'),
('5f0ea118-17a3-4eae-b095-d8d009cbda7b', '3cc415c0-b3ed-4918-a606-e869eecba300', '29fca088-7e06-48d4-8c6f-f9e8684829d2'),
('5f6e1fc9-971f-4911-b97d-6ed97ff31f29', 'e992f360-d32b-4f4a-840c-3c3e9fcb0163', '8793db82-6615-4501-9f69-9bb71c18682f'),
('603280e8-5331-4f4f-8555-58e301087ab2', 'd5303748-1944-4a0d-aba6-c0234ad40f03', '1c5fabde-ab3e-4182-a18a-1eb621089640'),
('6109185a-40cf-448b-a86b-1f82372f1f65', 'cfc8f902-e546-4f25-bc5c-8898965e4210', 'aafb0d64-6174-4ce5-9f6f-edc0ed477c5b'),
('611c6985-d461-4c7a-b525-64273de74e23', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4', '16134798-6f1a-4b16-b097-f92b9d73f710'),
('6159cf96-6562-45fe-b34a-177ddca2c830', '643ebad4-26d5-4ba9-9290-4a8d3ee2de2d', '52928ea1-6c27-4839-ac9c-0ac76a5b8d1e'),
('61f022c8-a9bb-479e-8432-b80b47b7f8f2', '6670e6d4-2692-48e9-ac61-ce13fde7e4f1', '187f6a08-74d6-4899-af36-3150db394d9f'),
('63c266d2-805c-4275-b2c5-d3f0af5596bd', 'f43a2e72-9087-4840-a992-3d0e2c3b150d', 'e7724eec-5479-4d17-a848-5e028e9a1121'),
('6446a648-b628-4e59-8172-50d33317ec32', '8a472886-d9de-4f84-9e74-3916650ed19f', 'a662379b-05e2-4bdb-b5a7-8f43a823a98b'),
('65ed9733-a045-448d-a34f-3fb19788e02b', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '3118ff78-f2a4-406b-a88e-c28d82b9685c'),
('67aeb6da-dedd-40d1-bf8b-f8e253d6176d', '643ebad4-26d5-4ba9-9290-4a8d3ee2de2d', 'ccc81664-71a6-4143-a518-ef08ec18aa5a'),
('68e60dea-45a7-488c-ac3c-a652faabacd0', '6d9e24e8-820b-4320-be94-94012619b7c6', '8d62dcf7-e590-44e6-b917-14c436a4d8ed'),
('69096859-3838-4c1e-a25a-2346b6b5e4b9', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4', '784cc7f9-4b5b-4e30-8491-b16a5e531a14'),
('6a1bdd82-4a04-4567-a6cd-f9db288a9e74', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '7917d097-0be8-4b2c-b383-9d2707554ffc'),
('6a56aa42-0a4c-4bee-a5e0-736475b6d512', 'cfc8f902-e546-4f25-bc5c-8898965e4210', 'b4605473-db0d-48fa-9dcb-bbd0f2190693'),
('6af8e888-9a7a-4e2c-ae5f-68ebed6b5e61', '8a472886-d9de-4f84-9e74-3916650ed19f', 'cf19e9d1-d32e-41f2-ae1e-b17cc016958b'),
('6bbf119c-c10f-4fb3-af69-572e87d6678e', '3cc415c0-b3ed-4918-a606-e869eecba300', 'ab3f2fc2-c9c4-4c6a-a3bc-92bad39fb8e7'),
('6bf2f7d4-b6ec-42f7-a9ad-1a3a202819b5', '6d9e24e8-820b-4320-be94-94012619b7c6', 'c188adff-86f2-4370-803f-e823ec98c8ca'),
('6c714ff0-e69b-456c-bc9d-811818f57c46', '3cc415c0-b3ed-4918-a606-e869eecba300', 'b56cfde3-463a-47f4-bfd7-75464617b5e5'),
('6da1819e-31dd-45c2-bcda-103fbf83a6d6', '6670e6d4-2692-48e9-ac61-ce13fde7e4f1', '7b004ec9-2d56-4845-8e63-5c1847effa97'),
('6ead4b45-26b9-4390-87a4-8564a07149b1', 'f43a2e72-9087-4840-a992-3d0e2c3b150d', 'd28a385c-ffa5-4435-a0a8-c7da6fad2693'),
('6fd6787b-cbee-45e1-894e-6ddcd291146d', 'cfc8f902-e546-4f25-bc5c-8898965e4210', 'f3733ac7-d129-42ee-9c59-54c80e24c199'),
('70ac8a9e-4f0b-49ab-af59-0ed3b20f5f74', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4', 'd91efd6f-b55a-4c1e-a96f-34b3698bac72'),
('70d589f1-d07b-409b-ba39-758ae409053c', '51cd92e4-c62c-4fcc-882f-c0942d5cddf3', 'f97f63fc-d2dd-4908-a39a-4a612ae716c6'),
('70ea4a91-e8ee-4713-878b-6c91b224fc4c', '6d9e24e8-820b-4320-be94-94012619b7c6', 'df89b6b7-ecdd-4f9c-a500-83168c76f8c8'),
('7388271d-57c8-4a3c-b688-77714a56cd6f', 'e091aad4-0da5-4954-8059-4a333cc388ce', '7e2d8d6c-d3d1-407a-a742-5f0a38a34034'),
('7413c7cd-835d-4180-ad9c-ccc8f0837e1c', '76fba5bd-eae6-4f36-a275-f5cc80afbbdd', 'ef91642e-09f9-4643-9736-fce94dfdf247'),
('7483f0d7-85a7-4133-92c0-f5edc4665e8d', 'cfc8f902-e546-4f25-bc5c-8898965e4210', 'd8d2ef08-5911-44d2-af4e-c5b849419b58'),
('7549b28e-e5d4-43ca-8947-9b977b7b8711', '6670e6d4-2692-48e9-ac61-ce13fde7e4f1', '3980d6d7-a055-4320-ae67-cc4a526c562a'),
('76992b00-b127-444f-b7d5-292fbbb99c4a', '76fba5bd-eae6-4f36-a275-f5cc80afbbdd', 'bc66b40d-7d19-40f4-b166-916bbf3f453c'),
('76f9f8a4-46dc-4b39-996a-c23c62739c6a', 'd5303748-1944-4a0d-aba6-c0234ad40f03', '46d48aa1-8b76-4732-9e1b-192190f94acb'),
('778eed89-e88a-4f5f-8128-64d5a845970a', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '458fe25b-12b7-4425-89d6-4b8ccd3f1228'),
('7836675b-c411-46a0-b695-e2bcbe6a98f0', 'cfc8f902-e546-4f25-bc5c-8898965e4210', 'b8d003b4-07d6-41d3-a900-23093d8745c9'),
('78518307-b9e9-4e74-8565-fd86dca1d98d', '6d9e24e8-820b-4320-be94-94012619b7c6', '5cc8ce53-3c68-41d5-95e5-1aaae7e5d6d9'),
('7886a9ea-ebe2-4c9a-b1ad-2745c1a54681', '8a472886-d9de-4f84-9e74-3916650ed19f', 'e8eb26ac-f3a5-4fc2-a899-59f10172a467'),
('789e33c1-c425-4119-ba39-034530e0ce9f', 'ba209dc4-ccf9-4feb-ab67-b641782ccb75', 'f65cbe84-1505-4cd1-8d26-bee2f0de315a'),
('795051e3-fc25-4489-b381-9abba7c8910d', '3cc415c0-b3ed-4918-a606-e869eecba300', '5fd2c231-21de-4e46-a953-843188385ce6'),
('79516bc7-cbd7-46a3-924b-07b662ec04d7', 'cfc8f902-e546-4f25-bc5c-8898965e4210', 'c390caec-d6c2-4059-8c73-86ca306dee25'),
('7d4b6d77-9713-43a5-9a55-bfebdfd72e6d', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4', 'de9d36a9-0fe0-4b8e-9935-a6f5a84a71cf'),
('7d56c4d0-41c0-4906-9ae2-95da93c202a4', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '322a2882-e607-4b27-be0e-6c3aa4cb8216'),
('7e88b764-17ff-42d9-8a20-d0a46b0a58d1', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '1a91107a-fdb2-4e37-a620-645ea666ff6c'),
('7ef1586a-01c1-44df-9f2f-a8f861cdfd5b', 'e091aad4-0da5-4954-8059-4a333cc388ce', 'b3b8959b-65c9-4ed3-9a11-e7e93d8bd850'),
('7fb3060e-e137-4ea7-82ef-f67b73d259fc', 'cfc8f902-e546-4f25-bc5c-8898965e4210', 'b9199102-f53b-4fe3-9e13-8992f58fff3e'),
('7fb860bd-3942-4b7e-9c80-c554e6f735ed', NULL, 'e0fd4954-04cc-40cf-9ce3-b95305c6f634'),
('818fbf24-4f83-455c-81ab-84ca58e4d1fa', '51cd92e4-c62c-4fcc-882f-c0942d5cddf3', '76273835-3ba8-4fd1-818f-b4111577c9a6'),
('82132ef8-702f-4271-98b4-34dfb26f00d4', 'f43a2e72-9087-4840-a992-3d0e2c3b150d', '68c72f52-0d9b-471f-963c-e4b078ba97fe'),
('829c4e1d-3fb1-4460-8e57-dd670ab90727', 'cfc8f902-e546-4f25-bc5c-8898965e4210', 'b44e563a-986a-4bfa-938e-11f48e7e1580'),
('8371c027-5745-42a9-a0e9-5f125f09b978', '55981906-d119-4759-abda-e0e9542f0d5f', 'e7fb8941-94ec-40dd-bbf3-4e318d838ea5'),
('83875c61-947b-4969-84f3-8fc0af1a3e8f', '76fba5bd-eae6-4f36-a275-f5cc80afbbdd', '08ab6f21-9822-47eb-b0a4-d3ecdb247e2a'),
('85628a1f-c0a6-469f-ab98-4a6921270def', 'f43a2e72-9087-4840-a992-3d0e2c3b150d', '3c21eb87-fdf8-4581-b21e-fdf6a9c70ea9'),
('85eb3ac0-165a-47d4-9e1b-7d6a3cb72c3e', 'f43a2e72-9087-4840-a992-3d0e2c3b150d', '5974d517-c057-40ae-9ae5-bef417574f5d'),
('86b2347a-a500-4757-9f00-14389b502a8d', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4', '5f68742c-0e59-4c68-83b0-408e26833041'),
('8701f366-d96b-4a8c-86b2-934704eadff7', '3cc415c0-b3ed-4918-a606-e869eecba300', 'fa7fb744-1346-4076-b8ab-45110ea91df1'),
('87b57755-00c4-46cb-adb8-7ed9531f8399', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '71e6d7f6-4aef-4948-941c-ac56bc534b5f'),
('87fee74e-3262-4cad-a4ed-e870dd7f7eb8', 'b171f000-983f-45d5-98b2-d0405e65bbed', '1f9f5cc3-9077-43d6-85d3-c174de6bac53'),
('8a5d2320-1f81-4911-a0e7-d99b974ed5e7', '51cd92e4-c62c-4fcc-882f-c0942d5cddf3', 'ae046332-f545-4ed4-8408-0ba5cfcf0973'),
('8b6c9a0e-c072-441f-bb4e-dd6bbe54c28e', '3cc415c0-b3ed-4918-a606-e869eecba300', '778a94d5-3cf1-403b-8d3e-4bdb371b24ff'),
('8bff33f4-4117-4f4d-adf9-6e3bfe3be51a', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '36d45744-59f8-4d0c-9633-5b644e268610'),
('8d243093-2bb7-4a46-a989-99ac9cfa7bf9', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4', 'e73fa937-e118-4088-98b6-a72bdf68b037'),
('8d36662e-f0d9-49cd-9cf2-06e169d6c5cc', '3cc415c0-b3ed-4918-a606-e869eecba300', 'ddad7e46-53c9-42cd-a235-6d5fbb5b0caa'),
('8d48c1a9-f702-4339-be65-20d7f99c8c3b', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4', 'f6baa846-ce3b-4a5b-9671-e042180a898b'),
('8df20f71-1a6e-4954-b454-b3992ddf8edb', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4', 'e95eb987-0831-43f7-906e-a2abc014df9c'),
('8e51e5ca-adcd-424f-a0c3-389eb734127a', 'cfc8f902-e546-4f25-bc5c-8898965e4210', 'fb52c73a-a67d-4629-8b9e-6de5ea5e62d2'),
('8eb7042b-564b-47d3-a2b3-4ac3e335f442', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4', '92d22934-06d0-42b4-b454-881461823dd9'),
('8f6ace14-3ec3-48af-a8b2-45ae8de54ef5', '6d9e24e8-820b-4320-be94-94012619b7c6', '1c2e7864-d2b0-48ac-b870-542883d16c50'),
('9202fc58-e8da-4247-ad27-532aca459cf7', 'cfc8f902-e546-4f25-bc5c-8898965e4210', 'd0c6d240-54a1-47d4-853b-63a52874ae4a'),
('930e25de-8800-4b4e-b987-0946aa773d31', '8a472886-d9de-4f84-9e74-3916650ed19f', '23e85974-7825-4fd1-ad49-dc65a8f35abe'),
('944f7c67-9630-4694-a0b7-2b639a8c4447', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '7f4decbe-a8d3-4351-9737-f0836a6398dd'),
('959a625a-b373-42a6-8f15-c9ffbf465956', 'bfac94df-2063-496c-871c-3618c446a199', 'f24fc7ef-b76e-4740-87a4-8035802b1620'),
('95a2f074-1e8a-430b-b417-401e19592bf6', '55981906-d119-4759-abda-e0e9542f0d5f', '43644989-e280-47a1-94d1-d884c4d7e2e1'),
('9701fbfd-79c0-4516-b948-f42f05d1ab6b', 'bfac94df-2063-496c-871c-3618c446a199', '6af64dfb-0407-4431-84df-d9a9bb6775fc'),
('984c00d4-efbd-4203-889e-1abe5d577cb5', 'e091aad4-0da5-4954-8059-4a333cc388ce', 'db7a1a52-3474-4518-ae7b-cedf88edc11a'),
('9867196b-fee8-4892-b8a6-20f1d2ebe290', '3cc415c0-b3ed-4918-a606-e869eecba300', '5aee0681-036b-422f-8b83-cd6410d45334'),
('9aee0349-a989-439e-8f87-8120a1da356c', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4', '75ec8475-eab4-4469-832c-b6745eb1dfbd'),
('9be053b4-471e-464a-acdf-cd2b038f11e6', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '65032c08-f86f-4969-8c2c-9b02e0c7cebc'),
('9c94d21b-59e2-4f44-b289-aaab9e4f9fc9', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '7bc524d0-6a09-4c44-9ef8-bb40768ed428'),
('9cc1562b-1568-46f7-83c1-25273475f163', 'f43a2e72-9087-4840-a992-3d0e2c3b150d', '2ff4f4e8-4ed0-4159-90c2-a96e7985d038'),
('9cf53e85-5ecd-401d-96a7-3d9159b7986b', '643ebad4-26d5-4ba9-9290-4a8d3ee2de2d', '9f9d6b4d-55d3-4048-a3e6-7848ef741726'),
('9d14bb8d-56e3-4b13-bbf2-e0e394095964', 'cfc8f902-e546-4f25-bc5c-8898965e4210', 'd10bcc97-6bc8-40d1-a6fc-a619de0c65ba'),
('9f4eba83-0480-4307-89ca-9854a9a9bb2e', 'cfc8f902-e546-4f25-bc5c-8898965e4210', 'a747dabe-37c6-4fdb-ae36-df2dfe5fee23'),
('9fd071c7-dc95-4ca0-95c8-66e674474724', '3cc415c0-b3ed-4918-a606-e869eecba300', 'f9733ab6-68f4-4374-b144-85de970cb6a0'),
('a0141c72-d8c0-44ed-9415-8ecca322ec95', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '06fc7e7d-5288-4c85-b5a1-d4eb955f68a2'),
('a2c60403-adfd-4913-a2ff-291420172049', '6670e6d4-2692-48e9-ac61-ce13fde7e4f1', '61601d42-10f6-4f42-a767-48cfd6d0b5e1'),
('a2ed5536-935d-4aff-bb6f-91a0a1eb8fef', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '06f8f457-fd6e-4e80-8bdf-c23c9948cb05'),
('a345632e-bafb-4f03-ad55-de8fd2ec9c2a', 'd8f83541-7749-4795-a963-9fbd73eeadbf', '423504fe-14ba-4876-9b61-2a7e254e8841'),
('a35ea011-d406-4b43-bb84-1eab1f2a66ae', 'cfc8f902-e546-4f25-bc5c-8898965e4210', 'bb219477-4b1d-43cc-8e74-4733646b3708'),
('a3c8e626-16c7-45af-9bd7-8477da0ac73c', 'f43a2e72-9087-4840-a992-3d0e2c3b150d', '93b34e67-f2cd-4315-b3e8-73a3bbb9174c'),
('a400e55c-c6fd-44e7-8fd1-5454c10a6a54', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4', '4149e52e-3a6e-4a51-8171-25d79668ef47'),
('a43ec5ca-d81c-47db-9e2c-c1836a97a1c4', 'cfc8f902-e546-4f25-bc5c-8898965e4210', 'd2bf2350-b393-4b67-ad9b-c6fdcec33895'),
('a4f86e9c-82f4-4880-af32-7bb465ce9d9c', 'cfc8f902-e546-4f25-bc5c-8898965e4210', 'c077ff20-e891-4097-86a6-1bf36f962712'),
('a520f7a5-47d5-4655-ade0-ee20b4539179', '6670e6d4-2692-48e9-ac61-ce13fde7e4f1', 'f7192615-3cad-451d-bf04-949bcf7883aa'),
('a5ba6147-9d89-458b-8cba-0624317f0642', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4', 'd4877e58-c307-484f-a874-24b011043002'),
('a6a9277e-2ddf-4a57-b895-bf4ca435d62b', '643ebad4-26d5-4ba9-9290-4a8d3ee2de2d', 'ffc0e5ac-4a75-4c32-b198-0f2f1982c420'),
('a7bf382f-9516-44cf-9328-89856381d208', '3cc415c0-b3ed-4918-a606-e869eecba300', '7d93a734-5603-48ec-8d17-83cff1a31be7'),
('aa9cfeec-ca95-4d32-b21d-a12e3c45b914', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '9e6ca4d8-7e8f-4426-94ed-961c9ad6344d'),
('ab080f18-cc3b-4dbc-8efd-1d283fca9d3c', NULL, 'e1c53842-dec3-458e-9eda-2c2d69488a7c'),
('ab3d8665-6373-49b0-b9a8-b26b6bc42104', '643ebad4-26d5-4ba9-9290-4a8d3ee2de2d', '191b8961-0225-4ec4-80ec-e4804222e7a2'),
('adca5b5d-c74e-40bb-bd07-330ea896156f', '643ebad4-26d5-4ba9-9290-4a8d3ee2de2d', 'b8642307-a8ff-4fad-b423-4686d0237f70'),
('ae31b8f6-baa4-4965-aac6-62fb39c1959b', '8a472886-d9de-4f84-9e74-3916650ed19f', 'a014470c-7cd3-49fd-bc79-95edd3ce08c1'),
('ae961a9e-4317-49da-a0f8-39a81c1f7f24', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '66b58934-78c9-4baf-a797-3c65e1e0ffab'),
('aee56b39-b943-4a19-9fca-5d4d4daa94ee', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '6a863b4b-6685-403d-9bf9-b1065da4d967'),
('b177d28a-c948-4122-863e-8624801b2ff1', '643ebad4-26d5-4ba9-9290-4a8d3ee2de2d', '8ea76aaa-518e-4050-8d64-853bca89985a'),
('b1d74437-6aa4-4aa7-87fa-2df11c0d5ef9', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '8a3ea8b2-3be0-4e52-941a-6c528efe4e50'),
('b1f71adb-7b53-4efe-89cd-b28af4ec28f3', '3cc415c0-b3ed-4918-a606-e869eecba300', '899ab10a-26da-4ff2-9c67-164cb0efb49f'),
('b273da3f-eef3-4f04-bd73-90b24d75e944', 'b171f000-983f-45d5-98b2-d0405e65bbed', '1da56773-0c9e-40d7-9deb-8b24969d5f2f'),
('b33275aa-7002-417e-bb9d-ec5a2d91d732', 'b171f000-983f-45d5-98b2-d0405e65bbed', '1f89bf82-9631-49d2-8441-a2b25026bc85'),
('b3a25157-2742-44e5-b5dd-f3593d4f83d3', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '62af163e-dccc-422a-86ed-61a72eb34e3e'),
('b783196f-da29-48b2-9f55-b90d9eb47e9a', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4', 'f84e1bc7-80a9-4b9a-a84f-0e95baae0ec6'),
('b7997ff2-56a4-4974-8e9a-6cedad59fcf9', '2cbd1987-f380-4032-abf4-8ab9f02bfb16', '9a05f1db-41b1-442a-8c94-405389abcc19'),
('b7e787f9-d206-4366-8492-de519bebd085', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '980c19f9-e359-4398-99c4-3703687788f4'),
('b93adaea-0d01-48f3-bb93-66f2b381ce1c', 'b171f000-983f-45d5-98b2-d0405e65bbed', 'c36856b0-8fd9-4bd9-a73f-d0461b50e9dd'),
('bc6b0855-09f8-4f22-8ea7-07819bb6b1e3', '3cc415c0-b3ed-4918-a606-e869eecba300', '127fcdb5-e001-4e87-8a5d-8a43a631d63e'),
('bcef46bd-8512-4c1b-abe3-98740569db7c', '3cc415c0-b3ed-4918-a606-e869eecba300', '87fb6e71-3636-4ff5-b1ec-f4217116f65c'),
('bd00910d-ed9a-4b66-9c49-794897c42225', 'b4e717cd-6a28-4f9a-807c-23cf8aaf7342', '76814dc8-2452-4b28-87f9-f2674a987c66'),
('be0074ee-c75e-4151-aa75-84d2bb0d87ef', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '62fc614d-55ea-403f-af9a-f5c2f1246793'),
('be3cb4ad-a0f2-44f1-b8d9-d4487c259417', '76fba5bd-eae6-4f36-a275-f5cc80afbbdd', '81663718-237d-4297-8a4d-af4e3545e514'),
('bee40f77-1744-493e-b4b7-9346b3c223a0', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '6c8ae6d4-b880-4b63-8036-f556fee26836'),
('c0d52c0a-c5e4-4bfe-8bd1-9722a8618a1d', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '7a4de1e4-63cc-4fae-950e-c989eb77aac3'),
('c160cd66-4f01-4366-bf6d-9fc596e2f19f', 'cfc8f902-e546-4f25-bc5c-8898965e4210', 'cc72577e-7ee9-4b48-8554-801d9a9e7c84'),
('c1a4ab2c-974b-406f-96da-f7792fb2e335', '643ebad4-26d5-4ba9-9290-4a8d3ee2de2d', '59534722-7747-48ed-8c66-313eec553133'),
('c1e3cb54-a636-4b92-a9bd-6bd85614ac80', '6670e6d4-2692-48e9-ac61-ce13fde7e4f1', '32de9606-d0f5-417e-9e6f-47094da0865b'),
('c30b3fb9-558d-4200-97e4-49f4e36b25ab', '6d9e24e8-820b-4320-be94-94012619b7c6', 'c728cb44-e325-4097-87e5-c7633321f65f'),
('c311df73-5551-43c2-81fb-fe2541a5ef7c', '51cd92e4-c62c-4fcc-882f-c0942d5cddf3', '276afc24-7d9a-4d77-a917-18db08980aa0'),
('c336069d-09ce-462a-80ce-7fece43c1c2f', 'cfc8f902-e546-4f25-bc5c-8898965e4210', 'f2f36ea6-9ac0-41b4-a2de-17b1f437662a'),
('c33f44f4-a5a9-49dc-8840-c194aad6dc56', '6d9e24e8-820b-4320-be94-94012619b7c6', '66b1ef00-30fd-4127-98e1-bc1662d408f3'),
('c3a43a99-72bf-49c3-bc7f-9cb31da09a38', 'f43a2e72-9087-4840-a992-3d0e2c3b150d', '25ce488d-067b-475a-a655-1323434f29f0'),
('c40e2dcb-f75b-40bb-b05f-55766d68ddef', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '3314041a-b89c-4440-b8ce-7eb3e383ea48'),
('c42a03e8-8a48-4ea8-b63c-5de56101fdbe', 'cfc8f902-e546-4f25-bc5c-8898965e4210', 'bba8f794-6dfd-447a-9e25-e41b2bbf536f'),
('c438c525-6bfd-40b8-bc4b-ab0decbebe6e', 'bfac94df-2063-496c-871c-3618c446a199', '43fd912d-302e-4de2-94e0-fb2c7a48661e'),
('c69249bc-1885-4c22-8d56-a9712a5b18f9', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4', '74898d83-e230-4d33-b8f3-894c8362c380'),
('c92b2aa7-46c0-4bdf-b615-5c200efb1ea2', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '57f86566-bd2f-4298-a0ca-ea8d83e7e863'),
('c96aa1c7-22c6-4601-8af2-3cf2d94e98fc', '76fba5bd-eae6-4f36-a275-f5cc80afbbdd', 'f1867632-b625-405d-aa29-cdd7448d4577'),
('ca12089a-d52c-45fb-8c19-5432a709f0fd', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '6e46ab13-f151-440a-8672-b9c1e23619f3'),
('cae0b735-2e84-4c7d-b754-86963e4137b8', '3cc415c0-b3ed-4918-a606-e869eecba300', 'e6cf9a9e-b836-4daa-8e2a-11a6dbbcb607'),
('cb2ea694-3e0f-41c3-8356-46520912c7c6', 'cfc8f902-e546-4f25-bc5c-8898965e4210', 'b1a86e1d-fc87-43b0-b2b7-ea3f369ab792'),
('ccf2b889-70b1-4585-8db9-4d4dff92ab38', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '46510701-63aa-4bbe-9748-3ccb1d3c98d6'),
('cd15b045-ed6b-4528-b587-2a3d7ba8db9a', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4', '9a9b7680-a029-462e-9ab0-149fcd87cbc9'),
('cd92a11e-b0f7-4824-b9a0-f25063e051dc', 'd8f83541-7749-4795-a963-9fbd73eeadbf', '384f3798-be8f-4abe-99e9-e13503d51866'),
('ce940297-09c5-4d2b-ab11-73223a085ea2', 'cfc8f902-e546-4f25-bc5c-8898965e4210', 'fc6948c7-8e7c-4846-ac58-b7e067c75564'),
('ceda4ede-72fa-432a-b975-9459fc28babd', 'b171f000-983f-45d5-98b2-d0405e65bbed', 'd425c7c5-d755-4142-8eb0-cdf3a35c3b7b'),
('cedacb13-c4c5-4762-b602-429748fb211e', 'e992f360-d32b-4f4a-840c-3c3e9fcb0163', '9f83cd39-b087-4918-a549-456bed0af699'),
('cfa99936-6648-4f4b-b203-9cf62e90fc44', 'f43a2e72-9087-4840-a992-3d0e2c3b150d', 'a80d8590-a270-43e2-933f-bed14683e04d'),
('cfc1fcef-0fca-405f-a4a6-9e04bdd1d92c', '3cc415c0-b3ed-4918-a606-e869eecba300', '3a9b13d3-cf43-4a68-95c2-aafae410a1df'),
('d1677d24-779e-410d-acd9-652c6f5586c2', '6d9e24e8-820b-4320-be94-94012619b7c6', '83ea1996-d028-4cdd-b706-4212f9cc9177'),
('d34610c9-1683-43a6-85bd-3bb2473d3fe6', '643ebad4-26d5-4ba9-9290-4a8d3ee2de2d', 'bb223745-ff57-47aa-b329-cad16fdc10a9'),
('d5e0f611-6922-4e1e-9577-407d0557fd07', 'bfac94df-2063-496c-871c-3618c446a199', 'a7ef6fb4-2e7e-40c0-be67-da7d81e6f6e0'),
('d67fd115-f8e5-4be3-a08d-049647f00ee0', '3cc415c0-b3ed-4918-a606-e869eecba300', '7388e2c9-1f95-4223-b354-4c8de185afba'),
('d6f64cac-cf98-4153-a7da-f480b37f70e7', 'ba209dc4-ccf9-4feb-ab67-b641782ccb75', '60cf6d36-ab54-4720-a31f-c4d244c46bba'),
('d75fc88f-63c5-4fe6-8da2-31306d184575', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '740c1c19-0b65-473c-b54c-eb7dde58e235'),
('db638b50-e40a-4df4-8ee4-cd850a7c8585', NULL, '07879ac9-b009-4b66-b9f8-870569430095'),
('dba1d605-eb28-4749-9f55-2fb78fc389eb', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '91f9e253-c663-47d3-af93-fb8bd74a5e71'),
('dbacfbc5-0cb1-4d65-8e31-5ee459601318', 'e992f360-d32b-4f4a-840c-3c3e9fcb0163', '0c59a217-02a8-4432-b55f-4e0e92b14d49'),
('dd26ff29-8f4c-4dec-86d3-42dae6bda2ce', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '5873013e-0222-40d1-a585-b6e994b1ef25'),
('dd9cf6be-5570-4759-8632-436717610b0e', 'd8f83541-7749-4795-a963-9fbd73eeadbf', 'cbf71745-8d1e-452e-8b22-3e7e2457d074'),
('dde6f920-5b5b-4504-96ef-db17f3842da9', '6670e6d4-2692-48e9-ac61-ce13fde7e4f1', '69682f8e-7989-4f3f-92ce-4d64159e6e3c'),
('de6a4615-2c2b-4e32-9c7a-df9ed97c0792', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '3abe066f-c2fb-4721-b6d0-7daea46e0046'),
('def10ac0-2e81-4070-87b6-dbb5f4e74f8a', 'e992f360-d32b-4f4a-840c-3c3e9fcb0163', '0a57c38f-2352-4078-9026-f0a759ab0b71'),
('df513bb3-5d53-4cfc-ab74-d2dfde286612', '3cc415c0-b3ed-4918-a606-e869eecba300', '970b2525-546a-475d-bd07-117e2ec232d7'),
('e0e86897-2c9a-45b5-9b47-9c2c26643b42', 'd5303748-1944-4a0d-aba6-c0234ad40f03', '1a157db7-c61d-4dcf-8225-92b23e1ee55d'),
('e28191ef-1675-4f63-9515-f0f0b409b3a1', 'cfc8f902-e546-4f25-bc5c-8898965e4210', 'cbf1aca2-6151-4e41-9019-a387cea9bcca'),
('e33dd349-514d-45a7-99b5-ef6a5a8e639e', 'f43a2e72-9087-4840-a992-3d0e2c3b150d', '70d49999-a4b7-4ef6-8510-cdcd1ed46bd7'),
('e586c243-b379-4b61-be5c-9c831c7bb0f3', '8a472886-d9de-4f84-9e74-3916650ed19f', 'b9a54998-a588-4eb2-8376-37d26d3fb1ff'),
('e5f69299-3980-4902-9811-ecdc8212d70e', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '7e09aad1-a97b-43df-abd6-7bc1bd1e0e4c'),
('e63ebe54-cd69-4f86-a3b1-d677291b182c', NULL, '5b7f415b-c182-44be-9f5c-46d119ab2aa7'),
('e65e5df2-3c53-44c8-a8fc-06cb8f527b46', 'e992f360-d32b-4f4a-840c-3c3e9fcb0163', '7150d619-69b3-473a-9cf1-13522ea1a0c9'),
('e6e4f478-56ac-447d-96ca-3576c8455085', '8a472886-d9de-4f84-9e74-3916650ed19f', '88e5d79f-1319-4b22-8539-84cb92e48fb6'),
('e815ac47-bddc-4a06-a17f-eeba4dbca7e0', '8a472886-d9de-4f84-9e74-3916650ed19f', 'cd500697-3638-4ec7-8cfd-70cba51c665d'),
('e8301a7c-c1b1-4470-ab61-08b64f7e78c7', '28981074-1d4d-4939-94a5-4a8cf0fa6b4f', '053befe2-225a-4da3-8f6d-587287461611'),
('e841569f-13e3-4caf-b167-b5e19ea53472', 'bfac94df-2063-496c-871c-3618c446a199', '92dfca3d-1a45-4e52-9246-c79567225b48'),
('e9229f90-455e-4901-a8b0-241b36469983', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '60283652-16aa-4b1b-842c-484423e2ccb4'),
('e93b3e65-d6d3-4084-9273-9ea2e98f17a2', '8a472886-d9de-4f84-9e74-3916650ed19f', '49a0b11d-4b51-4d26-a4ea-0fddcf1f7c45'),
('e9567b34-f398-46fc-9026-33e767bc46f4', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '23f2490f-f6cc-4178-adda-5442748da3ed'),
('eab249ed-85d8-4ab6-8ab1-59b4118210a3', 'f43a2e72-9087-4840-a992-3d0e2c3b150d', 'e97b8308-c66d-4791-942e-c4b78fce49e0'),
('ec9c7a0c-a24d-4f6a-9e6a-76bd06a542b0', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4', '82645ffb-0ce5-49d5-afaa-4d2ccf655215'),
('ee7821e4-3c24-4cfa-b51a-a01a9b216e18', 'b4e717cd-6a28-4f9a-807c-23cf8aaf7342', '75e1baad-b046-47b7-ba77-6e9199287640'),
('ef78b63d-510c-4060-a59d-6f995a88f97b', '55981906-d119-4759-abda-e0e9542f0d5f', '0260d5e5-7231-4c0b-a83c-73bff4aa4522'),
('f06f47dc-cd9e-4946-9059-f8d8ae13f7d3', '55981906-d119-4759-abda-e0e9542f0d5f', '298f662f-73ce-4a7a-9439-172da1ff907b'),
('f27ed288-6c33-4e55-9cec-7d2769097465', 'f43a2e72-9087-4840-a992-3d0e2c3b150d', '2cd2a269-4957-472e-9501-fbfad5009a93'),
('f535d8b8-7fc3-4dc3-9253-6b523c9eca42', 'f43a2e72-9087-4840-a992-3d0e2c3b150d', '48c0428f-0b19-47b5-a2fd-d9bd67b6123c'),
('f593bd13-a1b7-4e53-b5ac-6384b9195a79', 'e091aad4-0da5-4954-8059-4a333cc388ce', '43586c94-414f-45ce-beb2-17ca138f3d13'),
('f5a2c975-61b1-47c1-ad17-fd25c38ea52c', 'cfc8f902-e546-4f25-bc5c-8898965e4210', 'fa720abb-0d68-483a-8d57-f1ee70176004'),
('f5b62237-39a4-458d-8c26-47e18348f480', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '25147cc3-8972-4c92-9a02-1466bf69edba'),
('f6ff34b0-8fe0-43ae-ac90-9977c640c8db', '03f3f166-c138-4065-b070-2f07921020fa', 'd5b511bd-241f-4d5c-9fc2-945e4dc4c935'),
('f86613b1-7faa-4c54-a411-97172aa48e23', 'f58bc7fb-c311-4b30-97a5-3078182d337d', '21bd7bc7-6181-4081-8807-73e4a91f82fc'),
('f8dd4207-d652-43bd-b652-fb6f0c537197', 'b171f000-983f-45d5-98b2-d0405e65bbed', '12d858de-4f3d-475f-b963-024c07abb41a'),
('f94d26fc-da18-48df-861a-a6d31733b26d', 'cfc8f902-e546-4f25-bc5c-8898965e4210', 'e9b5b286-71eb-40de-8bbf-e5278e822afd'),
('f9727462-0fa2-46a2-88c8-2b9981e87e6c', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '7be533be-c6f8-4b46-8fa0-afd3248927ec'),
('fad07c14-3690-44ca-8bac-08241f49bfcf', 'f43a2e72-9087-4840-a992-3d0e2c3b150d', '03048c59-7134-4d89-8df9-5b747a722535'),
('fb8f12b0-a514-430c-be18-b72ba5f70c5e', '3cc415c0-b3ed-4918-a606-e869eecba300', '86e694f1-75cb-4ecd-9259-99449524c328'),
('fd142fe5-74be-4641-9b49-d9754c38ef30', 'cfc8f902-e546-4f25-bc5c-8898965e4210', '77bd51e3-1137-446e-898a-8bcbc753b654'),
('fe10ab94-5801-4074-a38d-15bf86f50f23', 'e091aad4-0da5-4954-8059-4a333cc388ce', '46a09c07-e0ba-43e7-8204-8d9d253a8ead');

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE `content` (
  `content_id` varchar(50) NOT NULL,
  `content_user_id` varchar(50) DEFAULT NULL,
  `content_path` text,
  `content_thumbnail_path` text,
  `content_size` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `isactive` tinyint(1) DEFAULT NULL,
  `content_duration` varchar(50) DEFAULT NULL,
  `content_type` varchar(50) DEFAULT NULL,
  `modified_user_id` varchar(50) DEFAULT NULL,
  `content_title` varchar(50) DEFAULT NULL,
  `content_description` text,
  `content_text` longtext,
  `content_path_hls` text,
  `status_code` int(1) DEFAULT NULL,
  `status_desc` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`content_id`, `content_user_id`, `content_path`, `content_thumbnail_path`, `content_size`, `created_date`, `modified_date`, `isactive`, `content_duration`, `content_type`, `modified_user_id`, `content_title`, `content_description`, `content_text`, `content_path_hls`, `status_code`, `status_desc`) VALUES
('0260d5e5-7231-4c0b-a83c-73bff4aa4522', '91987369456', '55981906-d119-4759-abda-e0e9542f0d5f/content/0260d5e572314c0ba83c73bff4aa4522.jpg', '55981906-d119-4759-abda-e0e9542f0d5f/thumbnails/4382a1a56f654c9b9915aa3a6b1232d3.png', 6067626, '2018-01-15 17:58:33', '2018-01-15 12:28:33', 1, '', 'image/jpeg', '91987369456', 'bigImg', 'bigImg', '', '', 0, 'DBPERSISTCOMPLETE'),
('03048c59-7134-4d89-8df9-5b747a722535', '918151913741', 'f43a2e72-9087-4840-a992-3d0e2c3b150d/content/03048c5971344d898df95b747a722535.mp3', '', 3301504, '2017-12-14 18:58:05', '2017-12-14 13:28:05', 1, '205047.296875 seconds', 'audio/mpeg', '918151913741', 'idaya en nenjil #Nivin #dhanush', 'audio spritual effects', '', '', 0, 'DBPERSISTCOMPLETE'),
('0349d105-e67b-4c3c-b887-1b1969124673', '918632357734', '', '', 0, '2017-12-22 13:00:49', '2017-12-22 07:30:49', 1, '', 'text', '918632357734', '#user for channels', 'user for channels', 'channels', '', 0, 'DBPERSISTCOMPLETE'),
('053befe2-225a-4da3-8f6d-587287461611', '91876785675', '28981074-1d4d-4939-94a5-4a8cf0fa6b4f/content/053befe2225a4da38f6d587287461611.png', '28981074-1d4d-4939-94a5-4a8cf0fa6b4f/thumbnails/1b4db4657eb74d1ba506732c663af496.png', 106173, '2018-02-12 18:16:18', '2018-02-12 12:46:18', 1, '', 'image/png', '91876785675', 'some random image', 'some image', '', '', 0, 'DBPERSISTCOMPLETE'),
('06f8f457-fd6e-4e80-8bdf-c23c9948cb05', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/06f8f457fd6e4e808bdfc23c9948cb05.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/7c785cfe5a054c20a1b1cbf3d7b46dec.png', 2107842, '2018-01-16 11:19:58', '2018-01-16 05:49:58', 1, '13.5 seconds', 'video/mp4', '911578934645', 'jhgjhg', 'kjhgjhk', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/06f8f457fd6e4e808bdfc23c9948cb05.m3u8', 0, 'DBPERSISTCOMPLETE'),
('06fc7e7d-5288-4c85-b5a1-d4eb955f68a2', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/06fc7e7d52884c85b5a1d4eb955f68a2.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/ed8ae2da3214427a985db1db29b4932e.png', 2107842, '2018-01-16 13:40:21', '2018-01-16 08:10:21', 1, '13.5 seconds', 'video/mp4', '911578934645', 'lkkjl', 'lkjljk', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/06fc7e7d52884c85b5a1d4eb955f68a2.m3u8', 0, 'DBPERSISTCOMPLETE'),
('07879ac9-b009-4b66-b9f8-870569430095', '097678678777', '3a78c0ee-f931-4816-9618-117beaca72a9/content/07879ac9b0094b66b9f8870569430095.jpg', '3a78c0ee-f931-4816-9618-117beaca72a9/thumbnails/ac79ab787ac94f33942caf8a3644ab83.png', 241467, '2018-01-05 14:37:27', '2018-01-05 09:07:27', 1, '', 'image/jpeg', '097678678777', 'my project', 'project here...', '', '', 0, 'DBPERSISTCOMPLETE'),
('08390a19-2313-43cf-a9e9-96eaa63b5d4d', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/08390a19231343cfa9e996eaa63b5d4d.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/b7057a4d9d64419fb78eeeb638052b0a.png', 2107842, '2018-01-16 13:41:35', '2018-01-16 08:11:35', 1, '13.5 seconds', 'video/mp4', '911578934645', 'sasasadsda', '', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/08390a19231343cfa9e996eaa63b5d4d.m3u8', 0, 'DBPERSISTCOMPLETE'),
('08ab6f21-9822-47eb-b0a4-d3ecdb247e2a', '919035299524', '', '', 0, '2017-11-17 15:45:36', '2017-11-17 10:15:36', 1, '', 'text', '919035299524', 'New Party', 'New Party', 'new', NULL, NULL, NULL),
('09312597-3c06-4168-8c68-128b24bd63c4', '918151913741', '', '', 0, '2017-12-19 17:43:52', '2017-12-19 12:15:26', 1, '', 'text', '918151913741', '#topic  #me@ #desk1w', 'go', 'hf', '', 0, 'DBPERSISTCOMPLETE'),
('0a57c38f-2352-4078-9026-f0a759ab0b71', '99786785657', 'e992f360-d32b-4f4a-840c-3c3e9fcb0163/content/0a57c38f235240789026f0a759ab0b71.jpg', 'e992f360-d32b-4f4a-840c-3c3e9fcb0163/thumbnails/f0182bf9fdb442c8b8c36bd094e20604.png', 141755, '2018-01-23 18:04:12', '2018-01-23 12:34:12', 1, '', 'image/jpeg', '99786785657', 'roses', 'roesss sssss', '', '', 0, 'DBPERSISTCOMPLETE'),
('0c12765c-a189-4955-aa76-990045971d2b', '8965675675767', 'null/content/0c12765ca1894955aa76990045971d2b.jpg', 'null/thumbnails/e47f961dfdd340fa827c2cd35fae6fc5.png', 141755, '2018-01-05 15:46:54', '2018-01-05 10:16:54', 1, '', 'image/jpeg', '8965675675767', 'my flowrs', 'flowers', '', '', 0, 'DBPERSISTCOMPLETE'),
('0c212d81-a2ae-48b7-94f2-438dfec2c2a2', '918151913741', '', '', 0, '2017-12-08 16:57:49', '2017-12-08 11:27:49', 1, '', '', '918151913741', 'nivin', 'nivi', '', '', 5, 'LOCALSTORECOMPLETE'),
('0c59a217-02a8-4432-b55f-4e0e92b14d49', '99786785657', 'e992f360-d32b-4f4a-840c-3c3e9fcb0163/content/0c59a21702a84432b55f4e0e92b14d49.jpg', 'e992f360-d32b-4f4a-840c-3c3e9fcb0163/thumbnails/ae3e788c24e24e7182e747a985c313da.png', 141755, '2018-01-05 19:59:12', '2018-01-05 14:29:12', 1, '', 'image/jpeg', '99786785657', 'pink', 'pink sddsf', '', '', 0, 'DBPERSISTCOMPLETE'),
('1084830f-332f-4eac-afc6-e0f42e952d7e', '919528096314', '', '', 0, '2017-11-17 12:54:09', '2017-11-17 08:33:58', 1, '', 'text', '919528096314', 'aaa', 'ahqjq', 'qhw', NULL, NULL, NULL),
('10ec37b2-ed12-40ab-af89-3f1ef4399098', '919638527417', '3cc415c0-b3ed-4918-a606-e869eecba300/content/10ec37b2ed1240abaf893f1ef4399098.mp4', '3cc415c0-b3ed-4918-a606-e869eecba300/thumbnails/20139307cc9c407fb9ba94ec4515b4e6.png', 441879, '2018-01-11 10:33:37', '2018-01-11 05:33:14', 0, '5.29 seconds', 'video/mp4', '919638527417', 'v3', 'v3', '', '3cc415c0-b3ed-4918-a606-e869eecba300/content/hls/10ec37b2ed1240abaf893f1ef4399098.m3u8', 0, 'DBPERSISTCOMPLETE'),
('117dc504-a37f-4744-a7ea-fd6dbec74632', '919638527417', '', '', 0, '2018-01-11 10:35:50', '2018-01-11 05:05:50', 1, '', '', '919638527417', 'v4', 'v4', '', '', 5, 'LOCALSTORECOMPLETE'),
('127fcdb5-e001-4e87-8a5d-8a43a631d63e', '919638527417', '3cc415c0-b3ed-4918-a606-e869eecba300/content/127fcdb5e0014e878a5d8a43a631d63e.mp4', '3cc415c0-b3ed-4918-a606-e869eecba300/thumbnails/f6a927cffd744240a38957ce3418b8a9.png', 441879, '2018-01-11 11:21:15', '2018-01-11 05:51:15', 1, '5.29 seconds', 'video/mp4', '919638527417', 'testv3', 'testv3', '', '3cc415c0-b3ed-4918-a606-e869eecba300/content/hls/127fcdb5e0014e878a5d8a43a631d63e.m3u8', 0, 'DBPERSISTCOMPLETE'),
('12d858de-4f3d-475f-b963-024c07abb41a', '91812345679', '', '', 0, '2018-01-08 16:38:25', '2018-01-08 11:08:25', 1, '', 'text', '91812345679', 'oiuiouo', 'oiuiouoiuiouoiuoiuiou', 'oiuiouoiuiouoiuoiuiou', '', 0, 'DBPERSISTCOMPLETE'),
('16134798-6f1a-4b16-b097-f92b9d73f710', '918892452332', '', '', 0, '2017-12-27 21:30:43', '2017-12-27 16:00:43', 1, '', 'text', '918892452332', 'ysykdhoss', 'hfajgsjgsjhsjy', 'jgsjgsjgdkhd', '', 0, 'DBPERSISTCOMPLETE'),
('1837fc4c-c42f-4282-a921-5eb2b0a12f21', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/1837fc4cc42f4282a9215eb2b0a12f21.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/799d26ad851c436d85374de507e2944a.png', 2107842, '2018-01-16 11:16:37', '2018-01-16 05:46:37', 1, '13.5 seconds', 'video/mp4', '911578934645', 'kljlkj', 'lkjlkjl', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/1837fc4cc42f4282a9215eb2b0a12f21.m3u8', 0, 'DBPERSISTCOMPLETE'),
('187f6a08-74d6-4899-af36-3150db394d9f', '917894592836', '6670e6d4-2692-48e9-ac61-ce13fde7e4f1/content/187f6a0874d64899af363150db394d9f.mp4', '6670e6d4-2692-48e9-ac61-ce13fde7e4f1/thumbnails/6a2b4964e3354419b89bbf3842803cda.png', 2107842, '2018-01-17 12:51:51', '2018-01-17 07:21:51', 1, '13.5 seconds', 'video/mp4', '917894592836', 'PJ video 1', 'PJ video 1', '', '6670e6d4-2692-48e9-ac61-ce13fde7e4f1/content/hls/187f6a0874d64899af363150db394d9f.m3u8', 0, 'DBPERSISTCOMPLETE'),
('188cc903-d0c7-459f-86f5-f5e11e184464', '919528096314', 'bfac94df-2063-496c-871c-3618c446a199/content/188cc903d0c7459f86f5f5e11e184464.', 'bfac94df-2063-496c-871c-3618c446a199/thumbnails/90183f6e22434e65bf9e83db2f8d90db.png', 22561, '2017-11-17 12:54:41', '2017-11-17 07:24:41', 1, '', 'image/jpeg', '919528096314', 'vabahab', 'vabaab', '', NULL, NULL, NULL),
('191b8961-0225-4ec4-80ec-e4804222e7a2', '918105447982', '643ebad4-26d5-4ba9-9290-4a8d3ee2de2d/content/191b896102254ec480ece4804222e7a2.JPG', '643ebad4-26d5-4ba9-9290-4a8d3ee2de2d/thumbnails/612781bf18ce4bffaf019b1e970af261.png', 3253337, '2018-02-06 12:27:37', '2018-02-06 06:57:37', 1, '', 'image/jpeg', '918105447982', 'Image resolution check', 'test', '', '', 0, 'DBPERSISTCOMPLETE'),
('19df55d9-b885-474d-9558-3fec8d561540', '91654789321', 'null/content/19df55d9b885474d95583fec8d561540.jpg', 'null/thumbnails/4d4d14f316fa443195661cf136b795a2.png', 128245, '2018-01-05 17:36:07', '2018-01-05 12:06:07', 1, '', 'image/jpeg', '91654789321', 'blue', 'clue', '', '', 0, 'DBPERSISTCOMPLETE'),
('19e488fc-d0dd-4cb0-9063-771fd5233872', '919035299524', '76fba5bd-eae6-4f36-a275-f5cc80afbbdd/content/19e488fcd0dd4cb09063771fd5233872.', '76fba5bd-eae6-4f36-a275-f5cc80afbbdd/thumbnails/c51943e9666842fa9d23c4bff6952bba.png', 37834, '2017-11-17 16:07:00', '2017-11-17 10:37:00', 1, '', 'image/jpeg', '919035299524', 'July 13', 'calenar', '', NULL, NULL, NULL),
('1a157db7-c61d-4dcf-8225-92b23e1ee55d', '919738849769', '', '', 0, '2017-12-21 19:22:08', '2017-12-21 13:52:08', 1, '', '', '919738849769', 'udkfkfkfj', 'mckcjfj', '', '', 0, 'DBPERSISTCOMPLETE'),
('1a91107a-fdb2-4e37-a620-645ea666ff6c', '917539812466', '', '', 0, '2018-01-16 17:47:38', '2018-01-16 12:17:38', 1, '', 'text', '917539812466', 'hh', 'hjhj', 'hjhj', '', 0, 'DBPERSISTCOMPLETE'),
('1ad9ee11-cb40-4753-a454-7d3941beb423', '99786785657', 'e992f360-d32b-4f4a-840c-3c3e9fcb0163/content/1ad9ee11cb404753a4547d3941beb423.jpg', 'e992f360-d32b-4f4a-840c-3c3e9fcb0163/thumbnails/1e6f6865233f49a9b3588e65e5c9b87a.png', 128245, '2018-01-05 19:48:14', '2018-01-05 14:18:14', 1, '', 'image/jpeg', '99786785657', 'nature', 'nate', '', '', 0, 'DBPERSISTCOMPLETE'),
('1b361238-7753-4bf7-afd2-bc9a545516e0', '91987156843', '55981906-d119-4759-abda-e0e9542f0d5f/content/1b36123877534bf7afd2bc9a545516e0.jpg', '55981906-d119-4759-abda-e0e9542f0d5f/thumbnails/e616ce1ea1f54b0293de9a09aa331109.png', 6067626, '2018-01-15 18:02:53', '2018-01-15 12:32:53', 1, '', 'image/jpeg', '91987156843', '6MB', '6MB', '', '', 0, 'DBPERSISTCOMPLETE'),
('1c2e7864-d2b0-48ac-b870-542883d16c50', '91357123789', '', '', 0, '2018-01-12 09:38:11', '2018-01-12 04:08:11', 1, '', 'text', '91357123789', '01 Test Data 1', '01 Test Data 1 Desc Goes Here', '01 Test Data 1 Desc Goes Here', '', 0, 'DBPERSISTCOMPLETE'),
('1c5fabde-ab3e-4182-a18a-1eb621089640', '919738849769', '', '', 0, '2017-12-17 02:57:00', '2017-12-16 21:27:00', 1, '', 'text', '919738849769', 'aaaa', 'aaaaa', 'aaaaaa', '', 0, 'DBPERSISTCOMPLETE'),
('1da245a0-48ee-421f-a653-67216b328f90', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/1da245a048ee421fa65367216b328f90.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/5bd593a9cdd8472a8998d894536628eb.png', 2107842, '2018-01-16 11:28:01', '2018-01-16 05:58:01', 1, '13.5 seconds', 'video/mp4', '911578934645', 'kj', 'kjhkj', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/1da245a048ee421fa65367216b328f90.m3u8', 0, 'DBPERSISTCOMPLETE'),
('1da56773-0c9e-40d7-9deb-8b24969d5f2f', '91812345678', 'b171f000-983f-45d5-98b2-d0405e65bbed/content/1da567730c9e40d79deb8b24969d5f2f.mp3', '', 80602, '2018-01-08 17:08:00', '2018-01-08 11:38:00', 1, '2011.427734375 seconds', 'audio/mpeg', '91812345678', 'Test Audio', 'Test Audio', '', '', 0, 'DBPERSISTCOMPLETE'),
('1f507c8f-ec98-4606-80e6-4b020f200876', '911578934645', '', '', 0, '2018-01-16 15:04:25', '2018-01-16 09:34:25', 1, '', '', '911578934645', 'hgfghfh', '', '', '', 5, 'LOCALSTORECOMPLETE'),
('1f89bf82-9631-49d2-8441-a2b25026bc85', '91812345678', '', '', 0, '2018-01-08 15:24:13', '2018-01-08 09:54:13', 1, '', 'text', '91812345678', 'Test1333', '1234', '1234', '', 0, 'DBPERSISTCOMPLETE'),
('1f9f5cc3-9077-43d6-85d3-c174de6bac53', '91812345679', 'b171f000-983f-45d5-98b2-d0405e65bbed/content/1f9f5cc3907743d685d3c174de6bac53.mp4', 'b171f000-983f-45d5-98b2-d0405e65bbed/thumbnails/e365aaa8d9e3442eb4b5296f3e34f6b2.png', 441879, '2018-01-08 16:34:58', '2018-01-08 11:04:58', 1, '5.29 seconds', 'video/mp4', '91812345679', 'pjsecondcontent', 'images', '', 'b171f000-983f-45d5-98b2-d0405e65bbed/content/hls/1f9f5cc3907743d685d3c174de6bac53.m3u8', 0, 'DBPERSISTCOMPLETE'),
('1fa43ac6-a3f5-487a-9259-35ee4aa7d0c1', '918105447982', '643ebad4-26d5-4ba9-9290-4a8d3ee2de2d/content/1fa43ac6a3f5487a925935ee4aa7d0c1.JPG', '643ebad4-26d5-4ba9-9290-4a8d3ee2de2d/thumbnails/f8e8c0bdcf2143c497f5f90bff18f875.png', 29167, '2017-11-17 12:43:11', '2017-11-17 07:13:11', 1, '', 'image/jpeg', '918105447982', 'Black', 'sfjgls;fg\nsfgsfg\nfsgfsg', '', NULL, NULL, NULL),
('2016674d-dd1f-4284-9cdc-99a2df18f757', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/2016674ddd1f42849cdc99a2df18f757.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/cba95ff898cf4abca21fc2219124cb54.png', 2107842, '2018-01-16 14:00:34', '2018-01-16 08:30:34', 1, '13.5 seconds', 'video/mp4', '911578934645', 'jj', '', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/2016674ddd1f42849cdc99a2df18f757.m3u8', 0, 'DBPERSISTCOMPLETE'),
('209b6b15-61f1-45f6-9f9e-6caf921f8031', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/209b6b1561f145f69f9e6caf921f8031.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/0ad5c4a92ec940aa873cc6920938506f.png', 2107842, '2018-01-16 11:21:39', '2018-01-16 05:51:39', 1, '13.5 seconds', 'video/mp4', '911578934645', 'hjgjhg', 'fghgfh', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/209b6b1561f145f69f9e6caf921f8031.m3u8', 0, 'DBPERSISTCOMPLETE'),
('20ca295b-b49e-4515-8fda-09f904293b37', '919638527417', '3cc415c0-b3ed-4918-a606-e869eecba300/content/20ca295bb49e45158fda09f904293b37.mp3', '', 30343, '2018-01-11 10:14:30', '2018-01-11 06:15:46', 1, '1880.8155517578125 seconds', 'audio/mpeg', '919638527417', 'AudioTitle1 edit', 'AudioTitle1 Description goes here edit', 'AudioTitle1 Description goes here edit', '', 0, 'DBPERSISTCOMPLETE'),
('217bceb5-3c40-41d5-bbaa-c04d48e16369', '919638527417', '', '', 0, '2018-01-11 11:37:13', '2018-01-11 06:07:13', 1, '', 'text', '919638527417', 't13', 't13', 't13', '', 0, 'DBPERSISTCOMPLETE'),
('21bd7bc7-6181-4081-8807-73e4a91f82fc', '918151913743', 'f58bc7fb-c311-4b30-97a5-3078182d337d/content/21bd7bc761814081880773e4a91f82fc.png', 'f58bc7fb-c311-4b30-97a5-3078182d337d/thumbnails/8351c3ff9e4f4615b015aab58b1e956d.png', 50078, '2017-11-16 19:31:47', '2017-11-16 14:01:47', 1, '', 'image/png', '918151913743', 'Test', 'Test', '', NULL, NULL, NULL),
('21d6a2a0-cf7b-4ce9-b329-480a405849c1', '918892452332', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4/content/21d6a2a0cf7b4ce9b329480a405849c1.', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4/thumbnails/a67a721736924f998dbd6fd851dd47e5.png', 95598, '2017-12-20 19:21:47', '2017-12-20 13:51:47', 1, '', 'image/jpeg', '918892452332', 'iijiiiiiiii', 'iiiiiiiiiiii', '', '', 0, 'DBPERSISTCOMPLETE'),
('22d35311-ec41-4aec-aa09-6b03166c1387', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/22d35311ec414aecaa096b03166c1387.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/d50d06f2ad11408d92dcb795ddde3ca5.png', 2107842, '2018-01-16 15:11:35', '2018-01-16 09:41:35', 1, '13.5 seconds', 'video/mp4', '911578934645', 'NL11', '', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/22d35311ec414aecaa096b03166c1387.m3u8', 0, 'DBPERSISTCOMPLETE'),
('23e85974-7825-4fd1-ad49-dc65a8f35abe', '91963852741', '', '', 0, '2018-01-10 14:00:40', '2018-01-10 08:30:40', 1, '', 'text', '91963852741', '4 edit', '4 desc goes here', '4 desc goes here', '', 0, 'DBPERSISTCOMPLETE'),
('23f2490f-f6cc-4178-adda-5442748da3ed', '911578934645', '', '', 0, '2018-01-16 10:50:44', '2018-01-16 05:20:44', 1, '', 'text', '911578934645', 'jhg', 'jhg', 'jhg', '', 0, 'DBPERSISTCOMPLETE'),
('24644ad3-36b5-4d03-b144-3b8c436e3e1d', '91712345698', '', '', 0, '2018-01-09 16:30:05', '2018-01-09 11:00:05', 1, '', 'text', '91712345698', 'kjhkjhkjh', 'kjhkjhkjhjkhkjhk', 'kjhkjhkjhjkhkjhk', '', 0, 'DBPERSISTCOMPLETE'),
('25147cc3-8972-4c92-9a02-1466bf69edba', '917539812466', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/25147cc389724c929a021466bf69edba.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/7724afe3d23d403ba6f4763fa8c2bb1b.png', 2107842, '2018-01-16 17:54:47', '2018-01-16 12:24:47', 1, '13.5 seconds', 'video/mp4', '917539812466', 'hjhjh', 'jkjkjk', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/25147cc389724c929a021466bf69edba.m3u8', 0, 'DBPERSISTCOMPLETE'),
('25ce488d-067b-475a-a655-1323434f29f0', '918151913741', 'f43a2e72-9087-4840-a992-3d0e2c3b150d/content/25ce488d067b475aa6551323434f29f0.', 'f43a2e72-9087-4840-a992-3d0e2c3b150d/thumbnails/665d4a45e1d84e239072fc9b05a0f952.png', 49136, '2017-12-14 18:53:33', '2017-12-19 11:14:51', 1, '', 'image/jpeg', '918151913741', 'yy#Nivin #Kuthab ', 'kuthab nice place ti go', 'null', '', 0, 'DBPERSISTCOMPLETE'),
('276afc24-7d9a-4d77-a917-18db08980aa0', '91712345698', '51cd92e4-c62c-4fcc-882f-c0942d5cddf3/content/276afc247d9a4d77a91718db08980aa0.mp4', '51cd92e4-c62c-4fcc-882f-c0942d5cddf3/thumbnails/b26ff943ad704ac5becdf00bc9158992.png', 441879, '2018-01-09 16:12:09', '2018-01-09 10:42:09', 1, '5.29 seconds', 'video/mp4', '91712345698', 'vvvvvvvv', 'vdddddddddddddd', '', '51cd92e4-c62c-4fcc-882f-c0942d5cddf3/content/hls/276afc247d9a4d77a91718db08980aa0.m3u8', 0, 'DBPERSISTCOMPLETE'),
('28aa3efd-329d-40aa-b99c-2d67c06c4b11', '9112300012300', '4bce4ae4-3451-497b-8817-f4ac42c49460/content/28aa3efd329d40aab99c2d67c06c4b11.mp3', '', 20897, '2017-11-17 16:40:13', '2017-11-17 11:10:13', 1, '1306.1219482421875 seconds', 'audio/mpeg', '9112300012300', 'iph', 'iphhhhh', '', NULL, NULL, NULL),
('298f662f-73ce-4a7a-9439-172da1ff907b', '91987369456', '55981906-d119-4759-abda-e0e9542f0d5f/content/298f662f73ce4a7a9439172da1ff907b.mp4', '55981906-d119-4759-abda-e0e9542f0d5f/thumbnails/9425b9292a9d481c9f90eae406eef5aa.png', 441879, '2018-01-15 17:07:32', '2018-01-15 11:37:32', 1, '5.29 seconds', 'video/mp4', '91987369456', 'jhgjh', 'kjhkj', '', '55981906-d119-4759-abda-e0e9542f0d5f/content/hls/298f662f73ce4a7a9439172da1ff907b.m3u8', 0, 'DBPERSISTCOMPLETE'),
('29fca088-7e06-48d4-8c6f-f9e8684829d2', '919638527417', '3cc415c0-b3ed-4918-a606-e869eecba300/content/29fca0887e0648d48c6ff9e8684829d2.jpg', '3cc415c0-b3ed-4918-a606-e869eecba300/thumbnails/9f02cc748fef43ab974e5de785e13d24.png', 128183, '2018-01-11 10:13:46', '2018-01-11 04:43:46', 1, '', 'image/jpeg', '919638527417', 'ImageTitle1', 'ImageTitle1 Description goes here', '', '', 0, 'DBPERSISTCOMPLETE'),
('2ccdd546-f496-4325-8a83-8169a5bdc352', '919035299524', '76fba5bd-eae6-4f36-a275-f5cc80afbbdd/content/2ccdd546f49643258a838169a5bdc352.ogg', '', 76425, '2017-11-17 16:43:49', '2017-11-17 11:13:49', 1, '', 'audio/vorbis', '919035299524', 'audio', 'audio', '', NULL, NULL, NULL),
('2cd2a269-4957-472e-9501-fbfad5009a93', '918151913741', '', '', 0, '2017-12-14 20:24:11', '2017-12-14 14:54:11', 1, '', 'text', '918151913741', '#Nivin1', 'nivin1', 'b', '', 0, 'DBPERSISTCOMPLETE'),
('2d00ca0d-1091-4edf-b62e-0f3cdf43025f', '918632357734', '', '', 0, '2017-12-22 13:02:02', '2017-12-22 07:32:02', 1, '', 'text', '918632357734', ' #article', 'article', 'article', '', 0, 'DBPERSISTCOMPLETE'),
('2d10e9c3-b851-4cb8-8207-bf0715e1b729', '8965675675767', 'null/content/2d10e9c3b8514cb88207bf0715e1b729.mp3', '', 20897, '2018-01-05 15:45:50', '2018-01-05 10:15:50', 1, '1306.1219482421875 seconds', 'audio/mpeg', '8965675675767', 'love musiqqq', 'musiqq here', '', '', 0, 'DBPERSISTCOMPLETE'),
('2d1a8d16-05b7-4858-baea-2305d8250c8c', '917894592836', '6670e6d4-2692-48e9-ac61-ce13fde7e4f1/content/2d1a8d1605b74858baea2305d8250c8c.mp4', '6670e6d4-2692-48e9-ac61-ce13fde7e4f1/thumbnails/c41b4d4fec4d416e8303a57879aa93d6.png', 441879, '2018-01-17 18:59:32', '2018-01-17 13:29:32', 1, '5.29 seconds', 'video/mp4', '917894592836', 'atvideo1', 'atvideo1', '', '6670e6d4-2692-48e9-ac61-ce13fde7e4f1/content/hls/2d1a8d1605b74858baea2305d8250c8c.m3u8', 0, 'DBPERSISTCOMPLETE'),
('2ddb1ca3-05b4-45e8-918f-6019790f24e5', '918151913741', '', '', 0, '2017-12-14 20:26:37', '2017-12-14 14:56:37', 1, '', 'text', '918151913741', '#Nivin #suzuki #maruti ', 'h', 't', '', 0, 'DBPERSISTCOMPLETE'),
('2ff4f4e8-4ed0-4159-90c2-a96e7985d038', '918151913741', 'f43a2e72-9087-4840-a992-3d0e2c3b150d/content/2ff4f4e84ed0415990c2a96e7985d038.mp4', 'f43a2e72-9087-4840-a992-3d0e2c3b150d/thumbnails/e4b6ca33678c44c7847b6f1faa2b002a.png', 14325314, '2017-11-17 16:28:11', '2017-11-17 11:00:23', 0, '81.5 seconds', 'video/mp4', '918151913741', 'fight', 'fighttttt', '', NULL, NULL, NULL),
('3018fae3-33a1-4145-8f33-dbae2d6129d8', '919638527417', '3cc415c0-b3ed-4918-a606-e869eecba300/content/3018fae333a141458f33dbae2d6129d8.mp4', '3cc415c0-b3ed-4918-a606-e869eecba300/thumbnails/bb2d61ade1f04f1a8a28800f2a45ba9a.png', 441879, '2018-01-11 10:32:20', '2018-01-11 05:02:20', 1, '5.29 seconds', 'video/mp4', '919638527417', 'VideoTitle2', 'VideoTitle2 desc goes here', '', '3cc415c0-b3ed-4918-a606-e869eecba300/content/hls/3018fae333a141458f33dbae2d6129d8.m3u8', 0, 'DBPERSISTCOMPLETE'),
('3110f5e7-4070-474e-bd1d-8a826f7f01ae', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/3110f5e74070474ebd1d8a826f7f01ae.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/89c6513a83e649da91a682b08fd64c23.png', 2107842, '2018-01-16 15:43:08', '2018-01-16 10:13:08', 1, '13.5 seconds', 'video/mp4', '911578934645', 'NL21', '', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/3110f5e74070474ebd1d8a826f7f01ae.m3u8', 0, 'DBPERSISTCOMPLETE'),
('3118ff78-f2a4-406b-a88e-c28d82b9685c', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/3118ff78f2a4406ba88ec28d82b9685c.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/98b9adb3892049368d3225be7799f480.png', 2107842, '2018-01-16 11:26:13', '2018-01-16 05:56:13', 1, '13.5 seconds', 'video/mp4', '911578934645', 'lkjlk', 'lkjlk', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/3118ff78f2a4406ba88ec28d82b9685c.m3u8', 0, 'DBPERSISTCOMPLETE'),
('322a2882-e607-4b27-be0e-6c3aa4cb8216', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/322a2882e6074b27be0e6c3aa4cb8216.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/5b03ebc1c68e4aef93c3445a2a4e556b.png', 2107842, '2018-01-16 13:41:19', '2018-01-16 08:11:19', 1, '13.5 seconds', 'video/mp4', '911578934645', 'kljlk', 'lkjlkj', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/322a2882e6074b27be0e6c3aa4cb8216.m3u8', 0, 'DBPERSISTCOMPLETE'),
('32de9606-d0f5-417e-9e6f-47094da0865b', '917894592836', '6670e6d4-2692-48e9-ac61-ce13fde7e4f1/content/32de9606d0f5417e9e6f47094da0865b.mp4', '6670e6d4-2692-48e9-ac61-ce13fde7e4f1/thumbnails/31a6cf21971f40f2b933bfa50a2e7fe1.png', 441879, '2018-01-17 19:06:01', '2018-01-17 13:36:01', 1, '5.29 seconds', 'video/mp4', '917894592836', 'avideo3', 'avideo3', '', '6670e6d4-2692-48e9-ac61-ce13fde7e4f1/content/hls/32de9606d0f5417e9e6f47094da0865b.m3u8', 0, 'DBPERSISTCOMPLETE'),
('3314041a-b89c-4440-b8ce-7eb3e383ea48', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/3314041ab89c4440b8ce7eb3e383ea48.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/28b44210dc3f439ab5b8c05c7800b3b3.png', 2107842, '2018-01-16 13:15:14', '2018-01-16 07:45:14', 1, '13.5 seconds', 'video/mp4', '911578934645', 'kljlk', 'lkjlk', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/3314041ab89c4440b8ce7eb3e383ea48.m3u8', 0, 'DBPERSISTCOMPLETE'),
('34e51fa5-b24f-4404-9939-1043223ef5db', '919999988888', 'd51c2942-0033-430a-9ec9-f964f8c3ac6c/content/34e51fa5b24f440499391043223ef5db.', 'd51c2942-0033-430a-9ec9-f964f8c3ac6c/thumbnails/e90b8df38a5b497a9db3f181ec389821.png', 21137, '2017-12-28 17:32:33', '2017-12-28 12:03:46', 1, '', 'image/jpeg', '919999988888', 'apple', 'apple', 'null', '', 0, 'DBPERSISTCOMPLETE'),
('35e23e3d-78d3-484d-9559-d1cc04c4cd8c', '918105447982', '643ebad4-26d5-4ba9-9290-4a8d3ee2de2d/content/35e23e3d78d3484d9559d1cc04c4cd8c.JPG', '643ebad4-26d5-4ba9-9290-4a8d3ee2de2d/thumbnails/936d43d79896457e84d2c641afe288fc.png', 4235454, '2017-12-18 16:28:55', '2017-12-18 10:58:55', 1, '', 'image/jpeg', '918105447982', 'groups', 'dfgdfg', '', '', 0, 'DBPERSISTCOMPLETE'),
('36d45744-59f8-4d0c-9633-5b644e268610', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/36d4574459f84d0c96335b644e268610.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/84bd478a34fe4c329f570362af223a26.png', 2107842, '2018-01-16 16:05:37', '2018-01-16 10:35:37', 1, '13.5 seconds', 'video/mp4', '911578934645', 'vgfggf', '', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/36d4574459f84d0c96335b644e268610.m3u8', 0, 'DBPERSISTCOMPLETE'),
('371511c9-445f-4e17-8301-15f142cb0b5e', '919035299524', '76fba5bd-eae6-4f36-a275-f5cc80afbbdd/content/371511c9445f4e17830115f142cb0b5e.mp4', '76fba5bd-eae6-4f36-a275-f5cc80afbbdd/thumbnails/55627727a7394f608d6f2a7d919fccf4.png', 1337678, '2017-11-17 16:17:34', '2017-11-17 10:47:34', 1, '11.21 seconds', 'video/mp4', '919035299524', 'tedt', 'test\n', '', NULL, NULL, NULL),
('382eb76b-a8fe-49f1-914c-730317a9c0b8', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/382eb76ba8fe49f1914c730317a9c0b8.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/ed81dab1cc2b4db8ab463c61d995a3f0.png', 2107842, '2018-01-16 16:01:05', '2018-01-16 10:31:05', 1, '13.5 seconds', 'video/mp4', '911578934645', 'hjghgjh', 'mnbmn', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/382eb76ba8fe49f1914c730317a9c0b8.m3u8', 0, 'DBPERSISTCOMPLETE'),
('384f3798-be8f-4abe-99e9-e13503d51866', '9112300012300', 'd8f83541-7749-4795-a963-9fbd73eeadbf/content/384f3798be8f4abe99e9e13503d51866.jpg', 'd8f83541-7749-4795-a963-9fbd73eeadbf/thumbnails/d1916e069ddf41f28473e321d77bc173.png', 128245, '2017-12-14 17:54:54', '2017-12-14 12:24:54', 1, '', 'image/jpeg', '9112300012300', 'nature', 'nature', '', '', 0, 'DBPERSISTCOMPLETE'),
('3980d6d7-a055-4320-ae67-cc4a526c562a', '914852697123', '6670e6d4-2692-48e9-ac61-ce13fde7e4f1/content/3980d6d7a0554320ae67cc4a526c562a.mp4', '6670e6d4-2692-48e9-ac61-ce13fde7e4f1/thumbnails/6ee48bf3dc80493d9b048a30f5c6ab66.png', 2107842, '2018-01-17 13:13:51', '2018-01-17 07:43:51', 1, '13.5 seconds', 'video/mp4', '914852697123', 'TV1', 'TV1', '', '6670e6d4-2692-48e9-ac61-ce13fde7e4f1/content/hls/3980d6d7a0554320ae67cc4a526c562a.m3u8', 0, 'DBPERSISTCOMPLETE'),
('3a9b13d3-cf43-4a68-95c2-aafae410a1df', '919638527417', '3cc415c0-b3ed-4918-a606-e869eecba300/content/3a9b13d3cf434a6895c2aafae410a1df.mp4', '3cc415c0-b3ed-4918-a606-e869eecba300/thumbnails/1a60bc5290e74be6b1abdeb55cb0553e.png', 441879, '2018-01-11 11:09:41', '2018-01-11 05:39:41', 1, '5.29 seconds', 'video/mp4', '919638527417', 'v2', 'v2', '', '3cc415c0-b3ed-4918-a606-e869eecba300/content/hls/3a9b13d3cf434a6895c2aafae410a1df.m3u8', 0, 'DBPERSISTCOMPLETE'),
('3abe066f-c2fb-4721-b6d0-7daea46e0046', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/3abe066fc2fb4721b6d07daea46e0046.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/a310de0af9bb4325a6f3723691592c28.png', 2107842, '2018-01-16 16:02:08', '2018-01-16 10:32:08', 1, '13.5 seconds', 'video/mp4', '911578934645', 'reter', 'trt', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/3abe066fc2fb4721b6d07daea46e0046.m3u8', 0, 'DBPERSISTCOMPLETE'),
('3b709af5-e50d-4e67-b4e8-d7feb668d2d8', '918105447982', '', '', 0, '2017-12-19 14:56:21', '2017-12-19 09:26:21', 1, '', 'text', '918105447982', 'groups 6', 'Schaffer', 'Fgfgfgf', '', 0, 'DBPERSISTCOMPLETE'),
('3c190e4d-d2b2-40fa-9186-01686ce6668a', '91812345678', '', '', 0, '2018-01-08 15:27:57', '2018-01-08 09:57:57', 1, '', 'text', '91812345678', 'testoiuiou', 'lkjlkjlkj', 'lkjlkjlkj', '', 0, 'DBPERSISTCOMPLETE'),
('3c21eb87-fdf8-4581-b21e-fdf6a9c70ea9', '918151913741', '', '', 0, '2017-12-19 13:04:05', '2017-12-19 07:34:05', 1, '', 'text', '918151913741', 'grp test', 'g', 'f', '', 0, 'DBPERSISTCOMPLETE'),
('3c41205c-367a-47a1-962a-f52889061bde', '918151913741', '', '', 0, '2017-12-14 17:48:11', '2017-12-14 12:40:48', 1, '', 'text', '918151913741', '#Nivin #mohanlal', 'Desc', 'havvsvss', '', 0, 'DBPERSISTCOMPLETE'),
('3c7b90bd-aead-48fd-b4ad-8ab36c4df33d', '91963852741', '', '', 0, '2018-01-10 13:59:25', '2018-01-10 08:29:25', 1, '', 'text', '91963852741', '4', '4', '4', '', 0, 'DBPERSISTCOMPLETE'),
('4078c088-2e95-4711-b1e2-fd581ed47fe6', '918151913741', '', '', 0, '2017-12-14 20:51:37', '2017-12-14 15:21:37', 1, '', 'text', '918151913741', '#weregards', 'weare', 'y', '', 0, 'DBPERSISTCOMPLETE'),
('4149e52e-3a6e-4a51-8171-25d79668ef47', '918892452332', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4/content/4149e52e3a6e4a51817125d79668ef47.', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4/thumbnails/f414abdc393c48d295c437a3d3dd8663.png', 40145, '2017-12-20 18:49:16', '2017-12-20 13:19:16', 1, '', 'image/jpeg', '918892452332', 'ioioioi', 'ioioioio\n', '', '', 0, 'DBPERSISTCOMPLETE'),
('417961bc-be7a-4203-acb7-5c4649ba73ab', '91987369456', '55981906-d119-4759-abda-e0e9542f0d5f/content/417961bcbe7a4203acb75c4649ba73ab.mp4', '55981906-d119-4759-abda-e0e9542f0d5f/thumbnails/d9497246fbed403a9e30775e230a7207.png', 441879, '2018-01-15 13:45:50', '2018-01-15 08:15:50', 1, '5.29 seconds', 'video/mp4', '91987369456', 'test2', '', '', '55981906-d119-4759-abda-e0e9542f0d5f/content/hls/417961bcbe7a4203acb75c4649ba73ab.m3u8', 0, 'DBPERSISTCOMPLETE'),
('423504fe-14ba-4876-9b61-2a7e254e8841', '9112300012300', 'd8f83541-7749-4795-a963-9fbd73eeadbf/content/423504fe14ba48769b612a7e254e8841.mp4', 'd8f83541-7749-4795-a963-9fbd73eeadbf/thumbnails/9886361e249642da92910dc1c6050eda.png', 240727, '2017-12-14 17:55:24', '2017-12-14 12:25:24', 1, '5.62 seconds', 'video/mp4', '9112300012300', 'play vieo', 'play vieo', '', 'd8f83541-7749-4795-a963-9fbd73eeadbf/content/hls/423504fe14ba48769b612a7e254e8841.m3u8', 0, 'DBPERSISTCOMPLETE'),
('42c3685b-e267-40b2-a99c-4af3ba44f14f', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/42c3685be26740b2a99c4af3ba44f14f.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/479e2065bb244109a86c01fefdffe2e3.png', 2107842, '2018-01-16 15:46:36', '2018-01-16 10:16:36', 1, '13.5 seconds', 'video/mp4', '911578934645', 'kjhjkhk', '', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/42c3685be26740b2a99c4af3ba44f14f.m3u8', 0, 'DBPERSISTCOMPLETE'),
('42fab386-43dc-4a36-8de1-945487819268', '918151913741', 'f43a2e72-9087-4840-a992-3d0e2c3b150d/content/42fab38643dc4a368de1945487819268.', 'f43a2e72-9087-4840-a992-3d0e2c3b150d/thumbnails/04e586887b9244dca878269a0bbbd1a2.png', 52457, '2017-12-14 18:34:43', '2017-12-14 13:04:43', 1, '', 'image/jpeg', '918151913741', '#car #maruti #suzuki', 'car hitten', '', '', 0, 'DBPERSISTCOMPLETE'),
('43586c94-414f-45ce-beb2-17ca138f3d13', '91154632589', '', '', 0, '2018-01-18 19:28:55', '2018-01-18 13:58:55', 1, '', 'text', '91154632589', 'aaa', 'aaa', 'aaa', '', 0, 'DBPERSISTCOMPLETE'),
('435f3f6b-9b78-4169-af49-d8ba2afdab8a', '918151913741', '', '', 0, '2017-12-14 20:50:45', '2017-12-14 15:20:45', 1, '', 'text', '918151913741', '#we ', 'g', 'g', '', 0, 'DBPERSISTCOMPLETE'),
('43644989-e280-47a1-94d1-d884c4d7e2e1', '91987369456', '55981906-d119-4759-abda-e0e9542f0d5f/content/43644989e28047a194d1d884c4d7e2e1.mp4', '55981906-d119-4759-abda-e0e9542f0d5f/thumbnails/2eddc7d35a074a38a031c2d2860d5fd5.png', 2107842, '2018-01-15 13:42:57', '2018-01-15 08:12:57', 1, '13.5 seconds', 'video/mp4', '91987369456', '111111pjsecondcontent', 'images', '', '55981906-d119-4759-abda-e0e9542f0d5f/content/hls/43644989e28047a194d1d884c4d7e2e1.m3u8', 0, 'DBPERSISTCOMPLETE'),
('43fd912d-302e-4de2-94e0-fb2c7a48661e', '919528096314', '', '', 0, '2017-11-17 12:12:32', '2017-11-17 07:24:03', 0, '', 'text', '919528096314', 'gznaajaba', NULL, 'agaha', NULL, NULL, NULL),
('44526186-270f-413c-a1e9-cfc7e0333e2d', '918151913741', '', '', 0, '2017-12-19 14:08:40', '2017-12-19 10:52:22', 1, '', 'text', '918151913741', '#topic #good#pen', 'ho', 'n', '', 0, 'DBPERSISTCOMPLETE'),
('458fe25b-12b7-4425-89d6-4b8ccd3f1228', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/458fe25b12b7442589d64b8ccd3f1228.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/f233cd555d4f4094907d44354275e0fc.png', 2107842, '2018-01-16 11:26:57', '2018-01-16 05:56:57', 1, '13.5 seconds', 'video/mp4', '911578934645', 'kljlk', 'lkjl', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/458fe25b12b7442589d64b8ccd3f1228.m3u8', 0, 'DBPERSISTCOMPLETE'),
('462cffdc-712b-4d88-8acf-e4e1d8a906be', '919035299524', '76fba5bd-eae6-4f36-a275-f5cc80afbbdd/content/462cffdc712b4d888acfe4e1d8a906be.mp3', '', 80666, '2017-11-17 16:43:14', '2017-11-17 11:13:14', 1, '5041.64404296875 seconds', 'audio/mpeg', '919035299524', 'audio', 'audio', '', NULL, NULL, NULL),
('46510701-63aa-4bbe-9748-3ccb1d3c98d6', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/4651070163aa4bbe97483ccb1d3c98d6.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/77160eec6c3a4438b39d7d25265a4de9.png', 2107842, '2018-01-16 14:22:34', '2018-01-16 08:52:34', 1, '13.5 seconds', 'video/mp4', '911578934645', 'kjlkj', '', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/4651070163aa4bbe97483ccb1d3c98d6.m3u8', 0, 'DBPERSISTCOMPLETE'),
('46a09c07-e0ba-43e7-8204-8d9d253a8ead', '9114893256', 'e091aad4-0da5-4954-8059-4a333cc388ce/content/46a09c07e0ba43e782048d9d253a8ead.mp4', 'e091aad4-0da5-4954-8059-4a333cc388ce/thumbnails/10dac71c759a48e197beddd086b221e7.png', 2107842, '2018-01-18 15:21:11', '2018-01-18 09:51:11', 1, '13.5 seconds', 'video/mp4', '9114893256', 'TSV11', 'kjhk', '', 'e091aad4-0da5-4954-8059-4a333cc388ce/content/hls/46a09c07e0ba43e782048d9d253a8ead.m3u8', 0, 'DBPERSISTCOMPLETE'),
('46d48aa1-8b76-4732-9e1b-192190f94acb', '919738849769', '', '', 0, '2017-12-15 20:12:54', '2017-12-15 14:42:54', 1, '', 'text', '919738849769', 'dummy', 'dummy', 'mummy', '', 0, 'DBPERSISTCOMPLETE'),
('48c0428f-0b19-47b5-a2fd-d9bd67b6123c', '918151913741', 'f43a2e72-9087-4840-a992-3d0e2c3b150d/content/48c0428f0b1947b5a2fdd9bd67b6123c.mp4', 'f43a2e72-9087-4840-a992-3d0e2c3b150d/thumbnails/28dff40142ee46f0b6cefe5f7847b7df.png', 246826, '2017-11-17 16:21:52', '2017-12-14 12:44:16', 1, '16.21 seconds', 'video/mp4', '918151913741', 'funny #funny #fun', 'description ', 'null', NULL, NULL, NULL),
('49a0b11d-4b51-4d26-a4ea-0fddcf1f7c45', '91963852741', '', '', 0, '2018-01-10 11:07:13', '2018-01-10 05:37:13', 1, '', 'text', '91963852741', '8', '8', '8', '', 0, 'DBPERSISTCOMPLETE'),
('4a5523a5-1601-4d39-bbf7-a9ff4132b53b', '918151913741', 'f43a2e72-9087-4840-a992-3d0e2c3b150d/content/4a5523a516014d39bbf7a9ff4132b53b.', 'f43a2e72-9087-4840-a992-3d0e2c3b150d/thumbnails/bddd9a774f1a432180778e3d7ff17ba7.png', 25380, '2017-11-17 15:40:17', '2017-12-14 12:19:17', 1, '', 'image/jpeg', '918151913741', 'cartoon #Filim #Nivin ', 'dezc', 'null', NULL, NULL, NULL),
('4b7b224f-8c50-4281-bf55-9a56e8f6df93', '907336345534', '', '', 0, '2018-01-18 19:01:04', '2018-01-18 13:31:04', 1, '', 'text', '907336345534', 'come on', NULL, 'come on hehehe', '', 0, 'DBPERSISTCOMPLETE'),
('52928ea1-6c27-4839-ac9c-0ac76a5b8d1e', '918105447982', '643ebad4-26d5-4ba9-9290-4a8d3ee2de2d/content/52928ea16c274839ac9c0ac76a5b8d1e.JPG', '643ebad4-26d5-4ba9-9290-4a8d3ee2de2d/thumbnails/520eddc8df804f8b9756d3eb77c4d6f3.png', 8112955, '2018-02-06 12:29:06', '2018-02-06 06:59:06', 1, '', 'image/jpeg', '918105447982', 'Test reolution', 'sdfvsv', '', '', 0, 'DBPERSISTCOMPLETE'),
('5441f08e-c596-424a-a4ac-8f161464e911', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/5441f08ec596424aa4ac8f161464e911.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/8dfff3c03a404f9cbea761ad29c9a2e8.png', 2107842, '2018-01-16 13:48:15', '2018-01-16 08:18:15', 1, '13.5 seconds', 'video/mp4', '911578934645', 'lkjlkj', 'lkjlkj', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/5441f08ec596424aa4ac8f161464e911.m3u8', 0, 'DBPERSISTCOMPLETE'),
('54e9bdd1-2c35-41dc-aa89-c3a65d40280d', '918892452332', '', '', 0, '2017-12-27 20:22:41', '2017-12-27 14:52:41', 1, '', 'text', '918892452332', 'uuuuu', 'uuuuuuu', 'qqqqqq', '', 0, 'DBPERSISTCOMPLETE'),
('57f86566-bd2f-4298-a0ca-ea8d83e7e863', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/57f86566bd2f4298a0caea8d83e7e863.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/2dcec44358b849bb984788611e166f59.png', 2107842, '2018-01-16 15:11:04', '2018-01-16 09:41:04', 1, '13.5 seconds', 'video/mp4', '911578934645', 'kjhkhk', 'kjhkjh', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/57f86566bd2f4298a0caea8d83e7e863.m3u8', 0, 'DBPERSISTCOMPLETE'),
('5873013e-0222-40d1-a585-b6e994b1ef25', '911578934645', '', '', 0, '2018-01-16 10:51:12', '2018-01-16 05:21:12', 1, '', 'text', '911578934645', 'lkjlkj', 'lkjlkj', 'lkjlkj', '', 0, 'DBPERSISTCOMPLETE'),
('58bd3a90-d181-4c24-afca-b0fefac9384c', '91963852741', '', '', 0, '2018-01-10 10:50:16', '2018-01-10 10:11:39', 0, '', 'text', '91963852741', '42 New123', '4 new', '4 new', '', 0, 'DBPERSISTCOMPLETE'),
('593fbe60-00df-4e30-a7c5-19efecf83153', '91154632589', 'e091aad4-0da5-4954-8059-4a333cc388ce/content/593fbe6000df4e30a7c519efecf83153.jpg', 'e091aad4-0da5-4954-8059-4a333cc388ce/thumbnails/a8b6dcf7d4bf4b6da9f4779064062a9a.png', 6067626, '2018-01-18 10:54:06', '2018-01-18 05:24:06', 1, '', 'image/jpeg', '91154632589', 'TPJ1', 'khgfghfh', '', '', 0, 'DBPERSISTCOMPLETE'),
('59534722-7747-48ed-8c66-313eec553133', '918105447982', '643ebad4-26d5-4ba9-9290-4a8d3ee2de2d/content/59534722774748ed8c66313eec553133.JPG', '643ebad4-26d5-4ba9-9290-4a8d3ee2de2d/thumbnails/db2bd1e786c44c7fbec18031e3771933.png', 526774, '2017-12-18 18:24:42', '2017-12-18 12:54:42', 1, '', 'image/jpeg', '918105447982', 'groups 3', 'gfgfg', '', '', 0, 'DBPERSISTCOMPLETE'),
('5974d517-c057-40ae-9ae5-bef417574f5d', '918151913741', '', '', 0, '2017-12-14 18:50:39', '2017-12-14 13:26:46', 1, '', 'text', '918151913741', '#Nivin sir #funnny', 't', 'h', '', 0, 'DBPERSISTCOMPLETE'),
('5a69c1cf-034c-4a6c-93c4-d28a53909080', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/5a69c1cf034c4a6c93c4d28a53909080.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/231987ad6ce9434d94d5662b55510a30.png', 2107842, '2018-01-16 15:44:34', '2018-01-16 10:14:34', 1, '13.5 seconds', 'video/mp4', '911578934645', 'NL22', '', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/5a69c1cf034c4a6c93c4d28a53909080.m3u8', 0, 'DBPERSISTCOMPLETE'),
('5aee0681-036b-422f-8b83-cd6410d45334', '919638527417', '3cc415c0-b3ed-4918-a606-e869eecba300/content/5aee0681036b422f8b83cd6410d45334.mp4', '3cc415c0-b3ed-4918-a606-e869eecba300/thumbnails/ccef100cc34e4c908a984cb24144bda4.png', 441879, '2018-01-11 11:23:12', '2018-01-11 05:53:12', 1, '5.29 seconds', 'video/mp4', '919638527417', 'testv4', 'testv4', '', '3cc415c0-b3ed-4918-a606-e869eecba300/content/hls/5aee0681036b422f8b83cd6410d45334.m3u8', 0, 'DBPERSISTCOMPLETE'),
('5b7f415b-c182-44be-9f5c-46d119ab2aa7', '8965675675767', 'null/content/5b7f415bc18244be9f5c46d119ab2aa7.jpg', 'null/thumbnails/028eb6d0f24544b8b7a111b2c3146df0.png', 128245, '2018-01-05 15:55:29', '2018-01-05 10:25:29', 1, '', 'image/jpeg', '8965675675767', 'nature', 'love  naturee', '', '', 0, 'DBPERSISTCOMPLETE'),
('5cc8ce53-3c68-41d5-95e5-1aaae7e5d6d9', '91357123789', '', '', 0, '2018-01-12 09:40:31', '2018-01-12 04:10:31', 1, '', 'text', '91357123789', 'Test 1', 'Test1', 'Test1', '', 0, 'DBPERSISTCOMPLETE'),
('5d59f3ec-3a8e-432e-9fd4-8a16a83b6392', '91357123789', '', '', 0, '2018-01-12 09:44:46', '2018-01-12 04:14:46', 1, '', 'text', '91357123789', '0001 Test 1', '0001 Test 1 Desc', '0001 Test 1 Desc', '', 0, 'DBPERSISTCOMPLETE'),
('5e03e991-28d2-4206-ac3d-10858379a49a', '91987369456', '55981906-d119-4759-abda-e0e9542f0d5f/content/5e03e99128d24206ac3d10858379a49a.mp4', '55981906-d119-4759-abda-e0e9542f0d5f/thumbnails/8810dea7cc0445eea819989d845b3b13.png', 441879, '2018-01-15 10:06:09', '2018-01-15 04:37:45', 0, '5.29 seconds', 'video/mp4', '91987369456', 'kjkjlk', 'lkjlkjl', '', '55981906-d119-4759-abda-e0e9542f0d5f/content/hls/5e03e99128d24206ac3d10858379a49a.m3u8', 0, 'DBPERSISTCOMPLETE'),
('5f68742c-0e59-4c68-83b0-408e26833041', '918892452332', '', '', 0, '2017-12-27 21:44:43', '2017-12-27 16:14:43', 1, '', 'text', '918892452332', 'nnnnnnnnnnnn', 'nnnnnnnnnnn', 'nnnnnnnnnnnnn', '', 0, 'DBPERSISTCOMPLETE'),
('5fd2c231-21de-4e46-a953-843188385ce6', '919638527417', '3cc415c0-b3ed-4918-a606-e869eecba300/content/5fd2c23121de4e46a953843188385ce6.mp4', '3cc415c0-b3ed-4918-a606-e869eecba300/thumbnails/373d9b369ce84e6789337775888c232c.png', 441879, '2018-01-11 11:28:36', '2018-01-11 05:58:36', 1, '5.29 seconds', 'video/mp4', '919638527417', 'v14', '', '', '3cc415c0-b3ed-4918-a606-e869eecba300/content/hls/5fd2c23121de4e46a953843188385ce6.m3u8', 0, 'DBPERSISTCOMPLETE'),
('60283652-16aa-4b1b-842c-484423e2ccb4', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/6028365216aa4b1b842c484423e2ccb4.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/fd8f04009d40492a93985f69752cb836.png', 2107842, '2018-01-16 15:38:59', '2018-01-16 10:08:59', 1, '13.5 seconds', 'video/mp4', '911578934645', 'NL20', 'NL20', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/6028365216aa4b1b842c484423e2ccb4.m3u8', 0, 'DBPERSISTCOMPLETE'),
('60cf6d36-ab54-4720-a31f-c4d244c46bba', '911234567890', 'ba209dc4-ccf9-4feb-ab67-b641782ccb75/content/60cf6d36ab544720a31fc4d244c46bba.jpg', 'ba209dc4-ccf9-4feb-ab67-b641782ccb75/thumbnails/dc9df60834c04d878ee8c4353ba516f0.png', 97715, '2017-11-16 19:50:50', '2017-11-16 14:20:50', 1, '', 'image/jpeg', '911234567890', 'test1', 'test1', '', NULL, NULL, NULL),
('61601d42-10f6-4f42-a767-48cfd6d0b5e1', '917894592836', '6670e6d4-2692-48e9-ac61-ce13fde7e4f1/content/61601d4210f64f42a76748cfd6d0b5e1.mp4', '6670e6d4-2692-48e9-ac61-ce13fde7e4f1/thumbnails/7d60c2b1d45642c498a3bb564d2c5b7f.png', 441879, '2018-01-17 14:27:11', '2018-01-17 08:57:11', 1, '5.29 seconds', 'video/mp4', '917894592836', 'atvideo', 'atvideo', '', '6670e6d4-2692-48e9-ac61-ce13fde7e4f1/content/hls/61601d4210f64f42a76748cfd6d0b5e1.m3u8', 0, 'DBPERSISTCOMPLETE'),
('6251f631-9061-440a-9efa-3c7b84cdc734', '919638527417', '3cc415c0-b3ed-4918-a606-e869eecba300/content/6251f6319061440a9efa3c7b84cdc734.mp4', '3cc415c0-b3ed-4918-a606-e869eecba300/thumbnails/036afcaf9002429fafd3e46095b1cd22.png', 441879, '2018-01-11 11:35:56', '2018-01-11 06:05:56', 1, '5.29 seconds', 'video/mp4', '919638527417', 'v15', '', '', '3cc415c0-b3ed-4918-a606-e869eecba300/content/hls/6251f6319061440a9efa3c7b84cdc734.m3u8', 0, 'DBPERSISTCOMPLETE'),
('62af163e-dccc-422a-86ed-61a72eb34e3e', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/62af163edccc422a86ed61a72eb34e3e.jpg', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/053ea12c045148d68e6bc1da9a0b99f9.png', 6067626, '2018-01-16 11:06:57', '2018-01-16 05:36:57', 1, '', 'image/jpeg', '911578934645', 'kjlkj', 'lkjl', '', '', 0, 'DBPERSISTCOMPLETE'),
('62fc614d-55ea-403f-af9a-f5c2f1246793', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/62fc614d55ea403faf9af5c2f1246793.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/ac5581a9055048bb90ab3ea13b6e2be3.png', 2107842, '2018-01-16 12:58:34', '2018-01-16 07:28:34', 1, '13.5 seconds', 'video/mp4', '911578934645', 'latest', 'kljlkjlkjl', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/62fc614d55ea403faf9af5c2f1246793.m3u8', 0, 'DBPERSISTCOMPLETE'),
('64f633b2-52f4-4b0d-8545-4464358c7af7', '919638527417', '', '', 0, '2018-01-11 11:37:53', '2018-01-11 07:39:42', 1, '', 'text', '919638527417', 't15', 't15', 't15', '', 0, 'DBPERSISTCOMPLETE'),
('64fefa2a-9443-45fb-b016-bfa810ef7c3e', '91812345679', '', '', 0, '2018-01-08 16:37:43', '2018-01-08 11:07:43', 1, '', 'text', '91812345679', 'pjsecondcontent', 'images', 'some text', '', 0, 'DBPERSISTCOMPLETE'),
('65032c08-f86f-4969-8c2c-9b02e0c7cebc', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/65032c08f86f49698c2c9b02e0c7cebc.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/54aa1e5de0b9465b8ab8976d997783ba.png', 2107842, '2018-01-16 16:04:27', '2018-01-16 10:34:27', 1, '13.5 seconds', 'video/mp4', '911578934645', 'hjhj', '', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/65032c08f86f49698c2c9b02e0c7cebc.m3u8', 0, 'DBPERSISTCOMPLETE'),
('66b1ef00-30fd-4127-98e1-bc1662d408f3', '91357123789', '6d9e24e8-820b-4320-be94-94012619b7c6/content/66b1ef0030fd412798e1bc1662d408f3.mp4', '6d9e24e8-820b-4320-be94-94012619b7c6/thumbnails/7320e10b53ee42bab9566898ed454170.png', 441879, '2018-01-12 09:40:13', '2018-01-12 04:10:13', 1, '5.29 seconds', 'video/mp4', '91357123789', '01 Video Data 1', '01 Video Data 1 Desc Goes Here', '', '6d9e24e8-820b-4320-be94-94012619b7c6/content/hls/66b1ef0030fd412798e1bc1662d408f3.m3u8', 0, 'DBPERSISTCOMPLETE'),
('66b58934-78c9-4baf-a797-3c65e1e0ffab', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/66b5893478c94bafa7973c65e1e0ffab.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/7f4ee7bae99046cabb89d15dbd23ab58.png', 2107842, '2018-01-16 16:26:26', '2018-01-16 10:56:26', 1, '13.5 seconds', 'video/mp4', '911578934645', 'ghggh', 'hjhh', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/66b5893478c94bafa7973c65e1e0ffab.m3u8', 0, 'DBPERSISTCOMPLETE'),
('68a24c54-aa43-4193-9c50-ba4cb023271b', '91812345679', 'b171f000-983f-45d5-98b2-d0405e65bbed/content/68a24c54aa4341939c50ba4cb023271b.mp4', 'b171f000-983f-45d5-98b2-d0405e65bbed/thumbnails/2c5d70758dc2418e908f30a8e1683015.png', 2107842, '2018-01-15 13:34:42', '2018-01-15 08:04:42', 1, '13.5 seconds', 'video/mp4', '91812345679', 'pjsecondcontent', 'images', '', 'b171f000-983f-45d5-98b2-d0405e65bbed/content/hls/68a24c54aa4341939c50ba4cb023271b.m3u8', 0, 'DBPERSISTCOMPLETE'),
('69682f8e-7989-4f3f-92ce-4d64159e6e3c', '914852697123', '6670e6d4-2692-48e9-ac61-ce13fde7e4f1/content/69682f8e79894f3f92ce4d64159e6e3c.mp4', '6670e6d4-2692-48e9-ac61-ce13fde7e4f1/thumbnails/3da495bf055a4b0588e114c66ccb18f8.png', 441879, '2018-01-17 14:29:18', '2018-01-17 08:59:18', 1, '5.29 seconds', 'video/mp4', '914852697123', 'atstringervideo', 'atstringervideo', '', '6670e6d4-2692-48e9-ac61-ce13fde7e4f1/content/hls/69682f8e79894f3f92ce4d64159e6e3c.m3u8', 0, 'DBPERSISTCOMPLETE'),
('6a863b4b-6685-403d-9bf9-b1065da4d967', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/6a863b4b6685403d9bf9b1065da4d967.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/94b162a29f534f4ab253bc9c2013fee8.png', 2107842, '2018-01-16 13:49:20', '2018-01-16 08:19:20', 1, '13.5 seconds', 'video/mp4', '911578934645', 'jkhkj', 'kjhkj', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/6a863b4b6685403d9bf9b1065da4d967.m3u8', 0, 'DBPERSISTCOMPLETE'),
('6af64dfb-0407-4431-84df-d9a9bb6775fc', '919528096314', '', '', 0, '2017-11-17 12:37:08', '2017-11-17 07:23:48', 0, '', 'text', '919528096314', 'title', NULL, 'content', NULL, NULL, NULL),
('6c07b940-6820-4438-bb07-44f16c140764', '91963852741', '', '', 0, '2018-01-10 10:35:54', '2018-01-10 05:05:54', 1, '', 'text', '91963852741', 'kjhkjh', 'kkhkjhkjh', 'kkhkjhkjh', '', 0, 'DBPERSISTCOMPLETE'),
('6c8ae6d4-b880-4b63-8036-f556fee26836', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/6c8ae6d4b8804b638036f556fee26836.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/208af8c218e54ae68ae94dd0138f556d.png', 2107842, '2018-01-16 11:14:26', '2018-01-16 05:44:26', 1, '13.5 seconds', 'video/mp4', '911578934645', 'lkjlk', 'lkjlkj', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/6c8ae6d4b8804b638036f556fee26836.m3u8', 0, 'DBPERSISTCOMPLETE'),
('6cc5a93d-3d21-4f41-ac93-fe6483517898', '91154632589', '', '', 0, '2018-01-19 11:24:41', '2018-01-19 05:54:41', 1, '', 'text', '91154632589', 'pjtextupload', 'pjtextupload', 'pjtextupload', '', 0, 'DBPERSISTCOMPLETE'),
('6e46ab13-f151-440a-8672-b9c1e23619f3', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/6e46ab13f151440a8672b9c1e23619f3.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/20899df61cb146c6a584ec2be4fab8ec.png', 2107842, '2018-01-16 14:54:53', '2018-01-16 09:24:53', 1, '13.5 seconds', 'video/mp4', '911578934645', 'NL7', '', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/6e46ab13f151440a8672b9c1e23619f3.m3u8', 0, 'DBPERSISTCOMPLETE'),
('706c8081-713b-4804-886a-f7aa6efb2649', '9114893256', 'e091aad4-0da5-4954-8059-4a333cc388ce/content/706c8081713b4804886af7aa6efb2649.jpg', 'e091aad4-0da5-4954-8059-4a333cc388ce/thumbnails/e677e105a5c5405b9619f00c572529bc.png', 6067626, '2018-01-18 11:30:52', '2018-01-18 06:00:52', 1, '', 'image/jpeg', '9114893256', 'TS11_1', 'hggfhf', '', '', 0, 'DBPERSISTCOMPLETE'),
('70d49999-a4b7-4ef6-8510-cdcd1ed46bd7', '918151913741', '', '', 0, '2017-12-15 12:06:38', '2017-12-19 14:17:28', 1, '', 'text', '918151913741', '#werega #holy #hello #hello ??', 'y ??', 'good', '', 0, 'DBPERSISTCOMPLETE'),
('710c51c1-0084-4f30-a4f2-d9d3af55d30d', '918892452332', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4/content/710c51c100844f30a4f2d9d3af55d30d.', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4/thumbnails/c2b4f28899664a69a3f73b19962f7aee.png', 5799, '2017-12-20 18:47:11', '2017-12-20 13:17:11', 1, '', 'image/jpeg', '918892452332', 'iiiiiiiii', 'iiiiiiiiii', '', '', 0, 'DBPERSISTCOMPLETE'),
('7150d619-69b3-473a-9cf1-13522ea1a0c9', '984874674763', '', '', 0, '2018-01-05 20:37:11', '2018-01-05 15:07:11', 1, '', 'text', '984874674763', 'CreatedBy Manikanta', 'Text content ', 'this is for testing text type while retriveing', '', 0, 'DBPERSISTCOMPLETE'),
('71e53da6-2bcb-46ac-8062-a5d972e51e5f', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/71e53da62bcb46ac8062a5d972e51e5f.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/75d01509fade41e58df2215d47568a3f.png', 2107842, '2018-01-16 16:01:41', '2018-01-16 10:31:41', 1, '13.5 seconds', 'video/mp4', '911578934645', 'jhbgjh', '', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/71e53da62bcb46ac8062a5d972e51e5f.m3u8', 0, 'DBPERSISTCOMPLETE');
INSERT INTO `content` (`content_id`, `content_user_id`, `content_path`, `content_thumbnail_path`, `content_size`, `created_date`, `modified_date`, `isactive`, `content_duration`, `content_type`, `modified_user_id`, `content_title`, `content_description`, `content_text`, `content_path_hls`, `status_code`, `status_desc`) VALUES
('71e6d7f6-4aef-4948-941c-ac56bc534b5f', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/71e6d7f64aef4948941cac56bc534b5f.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/61ed229c0dce4d3392bfe304e8d190a1.png', 2107842, '2018-01-16 13:26:34', '2018-01-16 07:56:34', 1, '13.5 seconds', 'video/mp4', '911578934645', 'kjl', 'lk', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/71e6d7f64aef4948941cac56bc534b5f.m3u8', 0, 'DBPERSISTCOMPLETE'),
('7388e2c9-1f95-4223-b354-4c8de185afba', '919638527417', '', '', 0, '2018-01-11 11:36:41', '2018-01-11 06:06:41', 1, '', 'text', '919638527417', 't11', 't11', 't11', '', 0, 'DBPERSISTCOMPLETE'),
('740c1c19-0b65-473c-b54c-eb7dde58e235', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/740c1c190b65473cb54ceb7dde58e235.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/fccb4c24e0224071a015926542cd15a5.png', 2107842, '2018-01-16 14:44:32', '2018-01-16 09:14:32', 1, '13.5 seconds', 'video/mp4', '911578934645', 'NL3', '', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/740c1c190b65473cb54ceb7dde58e235.m3u8', 0, 'DBPERSISTCOMPLETE'),
('74898d83-e230-4d33-b8f3-894c8362c380', '918892452332', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4/content/74898d83e2304d33b8f3894c8362c380.', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4/thumbnails/ebfae40609614e45a6d1f284e4d79b04.png', 55703, '2017-12-20 16:33:00', '2017-12-20 11:03:00', 1, '', 'image/jpeg', '918892452332', 'hhhhhh', 'hhhh', '', '', 0, 'DBPERSISTCOMPLETE'),
('75e1baad-b046-47b7-ba77-6e9199287640', '919900601813', 'b4e717cd-6a28-4f9a-807c-23cf8aaf7342/content/75e1baadb04647b7ba776e9199287640.JPG', 'b4e717cd-6a28-4f9a-807c-23cf8aaf7342/thumbnails/49074e4287384589a641f7d9ddd3a402.png', 5130677, '2017-11-17 16:21:06', '2018-01-22 11:43:24', 0, '', 'image/jpeg', '919900601813', 'test image', 'test image', 'test image', NULL, NULL, NULL),
('75ec8475-eab4-4469-832c-b6745eb1dfbd', '918892452332', '', '', 0, '2017-12-27 18:40:45', '2017-12-27 13:10:45', 1, '', 'text', '918892452332', 'gdn x', 'vdbd dnd', 'bxjdbdb', '', 0, 'DBPERSISTCOMPLETE'),
('76273835-3ba8-4fd1-818f-b4111577c9a6', '91712345698', '', '', 0, '2018-01-09 15:36:21', '2018-01-09 10:06:21', 1, '', 'text', '91712345698', 'Title goes here', 'Description goes here', 'Description goes here', '', 0, 'DBPERSISTCOMPLETE'),
('765a1d69-be57-46ad-bf67-3d7e99869853', '91963852741', '', '', 0, '2018-01-10 11:02:17', '2018-01-10 05:32:17', 1, '', 'text', '91963852741', '5', '5', '5', '', 0, 'DBPERSISTCOMPLETE'),
('76814dc8-2452-4b28-87f9-f2674a987c66', '919900601813', '', '', 0, '2017-11-17 16:02:04', '2017-11-17 10:52:56', 0, '', 'text', '919900601813', 'Test title', NULL, 'Test Description', NULL, NULL, NULL),
('778a94d5-3cf1-403b-8d3e-4bdb371b24ff', '919638527417', '3cc415c0-b3ed-4918-a606-e869eecba300/content/778a94d53cf1403b8d3e4bdb371b24ff.mp4', '3cc415c0-b3ed-4918-a606-e869eecba300/thumbnails/c6aa7d210b034a0196a5ac8d1a78dc72.png', 441879, '2018-01-11 11:11:05', '2018-01-11 05:41:05', 1, '5.29 seconds', 'video/mp4', '919638527417', 'v1111', 'v1111111', '', '3cc415c0-b3ed-4918-a606-e869eecba300/content/hls/778a94d53cf1403b8d3e4bdb371b24ff.m3u8', 0, 'DBPERSISTCOMPLETE'),
('77bd51e3-1137-446e-898a-8bcbc753b654', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/77bd51e31137446e898a8bcbc753b654.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/cdec7b41c3b648b7910d24c611acb657.png', 2107842, '2018-01-16 15:07:10', '2018-01-16 09:37:10', 1, '13.5 seconds', 'video/mp4', '911578934645', 'kjhkjkjh', 'jhhj', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/77bd51e31137446e898a8bcbc753b654.m3u8', 0, 'DBPERSISTCOMPLETE'),
('784cc7f9-4b5b-4e30-8491-b16a5e531a14', '918892452332', '', '', 0, '2017-12-27 22:06:00', '2017-12-27 16:36:20', 1, '', '', '918892452332', 'oooooooo', 'oooooooo', 'oooooooo', '', 0, 'DBPERSISTCOMPLETE'),
('7917d097-0be8-4b2c-b383-9d2707554ffc', '911578934645', '', '', 0, '2018-01-16 11:17:30', '2018-01-16 05:47:30', 1, '', 'text', '911578934645', 'kljl', 'lkjl', 'lkjl', '', 0, 'DBPERSISTCOMPLETE'),
('797d3b3c-7219-4ee4-9f92-3148d64c6bfe', '91987369456', '55981906-d119-4759-abda-e0e9542f0d5f/content/797d3b3c72194ee49f923148d64c6bfe.mp4', '55981906-d119-4759-abda-e0e9542f0d5f/thumbnails/0a8a61973f1a4cea88f0b6685694bb02.png', 441879, '2018-01-15 16:59:44', '2018-01-15 11:29:44', 1, '5.29 seconds', 'video/mp4', '91987369456', 'jhgjhg', 'kjhgkjhk', '', '55981906-d119-4759-abda-e0e9542f0d5f/content/hls/797d3b3c72194ee49f923148d64c6bfe.m3u8', 0, 'DBPERSISTCOMPLETE'),
('79d2b3e2-bac6-4542-a17d-3e4764c3012d', '919900601813', '', '', 0, '2017-11-17 16:24:54', '2017-12-01 11:08:42', 0, '', 'text', '919900601813', 'txt', NULL, 'txt', NULL, NULL, NULL),
('7a4de1e4-63cc-4fae-950e-c989eb77aac3', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/7a4de1e463cc4fae950ec989eb77aac3.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/b9f0bd490e2b4716b5ba6f41912d8d5e.png', 2107842, '2018-01-16 14:56:51', '2018-01-16 09:26:51', 1, '13.5 seconds', 'video/mp4', '911578934645', 'NL8', '', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/7a4de1e463cc4fae950ec989eb77aac3.m3u8', 0, 'DBPERSISTCOMPLETE'),
('7b004ec9-2d56-4845-8e63-5c1847effa97', '914852697123', '6670e6d4-2692-48e9-ac61-ce13fde7e4f1/content/7b004ec92d5648458e635c1847effa97.jpg', '6670e6d4-2692-48e9-ac61-ce13fde7e4f1/thumbnails/7d8f52141f274657a2be69205861343f.png', 6067626, '2018-01-17 13:11:44', '2018-01-17 07:41:44', 1, '', 'image/jpeg', '914852697123', 'TI2', 'hj', '', '', 0, 'DBPERSISTCOMPLETE'),
('7bc524d0-6a09-4c44-9ef8-bb40768ed428', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/7bc524d06a094c449ef8bb40768ed428.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/b6d96b617c604004af83d95cb7b8403b.png', 2107842, '2018-01-16 13:23:06', '2018-01-16 07:53:06', 1, '13.5 seconds', 'video/mp4', '911578934645', 'jhgj', 'kj', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/7bc524d06a094c449ef8bb40768ed428.m3u8', 0, 'DBPERSISTCOMPLETE'),
('7be533be-c6f8-4b46-8fa0-afd3248927ec', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/7be533bec6f84b468fa0afd3248927ec.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/c0078c5b05ed464d94df9b03fdaecd27.png', 2107842, '2018-01-16 15:10:32', '2018-01-16 09:40:32', 1, '13.5 seconds', 'video/mp4', '911578934645', 'kjkhhkjh', 'jhjh', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/7be533bec6f84b468fa0afd3248927ec.m3u8', 0, 'DBPERSISTCOMPLETE'),
('7c8eb3ce-fa6e-4e4e-88c2-71500aad53a4', '91963852741', '', '', 0, '2018-01-10 11:03:18', '2018-01-10 05:33:18', 1, '', 'text', '91963852741', '7', '7', '7', '', 0, 'DBPERSISTCOMPLETE'),
('7d93a734-5603-48ec-8d17-83cff1a31be7', '919638527417', '3cc415c0-b3ed-4918-a606-e869eecba300/content/7d93a734560348ec8d1783cff1a31be7.mp4', '3cc415c0-b3ed-4918-a606-e869eecba300/thumbnails/f21ee43c55664a1b9583fc9d33396aef.png', 441879, '2018-01-11 11:26:54', '2018-01-11 05:56:54', 1, '5.29 seconds', 'video/mp4', '919638527417', 'v12', '', '', '3cc415c0-b3ed-4918-a606-e869eecba300/content/hls/7d93a734560348ec8d1783cff1a31be7.m3u8', 0, 'DBPERSISTCOMPLETE'),
('7e09aad1-a97b-43df-abd6-7bc1bd1e0e4c', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/7e09aad1a97b43dfabd67bc1bd1e0e4c.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/b23bb399284f470d83f2b11891224065.png', 2107842, '2018-01-16 16:26:52', '2018-01-16 10:56:52', 1, '13.5 seconds', 'video/mp4', '911578934645', 'hjhjhj', 'jjjkjk', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/7e09aad1a97b43dfabd67bc1bd1e0e4c.m3u8', 0, 'DBPERSISTCOMPLETE'),
('7e2d8d6c-d3d1-407a-a742-5f0a38a34034', '9114893256', 'e091aad4-0da5-4954-8059-4a333cc388ce/content/7e2d8d6cd3d1407aa7425f0a38a34034.jpeg', 'e091aad4-0da5-4954-8059-4a333cc388ce/thumbnails/3e0d13dd04c044ff844b844f17ef92ea.png', 7899, '2018-01-22 13:17:05', '2018-01-22 07:47:05', 1, '', 'image/jpeg', '9114893256', 'jkjjkj', 'gjgjgjg', '', '', 0, 'DBPERSISTCOMPLETE'),
('7ef23efb-69bf-4bd6-afbe-0a5c3e75cdfb', '99786785657', 'e992f360-d32b-4f4a-840c-3c3e9fcb0163/content/7ef23efb69bf4bd6afbe0a5c3e75cdfb.wav', '', 314396, '2018-01-23 17:36:48', '2018-01-23 12:06:48', 1, '', 'audio/x-wav', '99786785657', 'birdd sound', 'birdd sound', '', '', 0, 'DBPERSISTCOMPLETE'),
('7f4decbe-a8d3-4351-9737-f0836a6398dd', '911578934645', '', '', 0, '2018-01-16 11:15:43', '2018-01-16 05:45:43', 1, '', 'text', '911578934645', 'lkjl', 'lkjl', 'lkjl', '', 0, 'DBPERSISTCOMPLETE'),
('81663718-237d-4297-8a4d-af4e3545e514', '919035299524', '76fba5bd-eae6-4f36-a275-f5cc80afbbdd/content/81663718237d42978a4daf4e3545e514.mp4', '76fba5bd-eae6-4f36-a275-f5cc80afbbdd/thumbnails/d293171b610847feba7c4b90c6d3d318.png', 12192911, '2017-11-17 16:21:05', '2017-11-17 10:51:05', 1, '146.17 seconds', 'video/mp4', '919035299524', 'beach', 'beach', '', NULL, NULL, NULL),
('82645ffb-0ce5-49d5-afaa-4d2ccf655215', '918892452332', '', '', 0, '2017-12-27 21:55:00', '2017-12-27 16:25:00', 1, '', '', '918892452332', 'tkksgj', 'yidkysjgsjgsg', '', '', 0, 'DBPERSISTCOMPLETE'),
('83ea1996-d028-4cdd-b706-4212f9cc9177', '91159789123', '', '', 0, '2018-01-12 09:42:24', '2018-01-12 04:13:39', 0, '', 'text', '91159789123', '0001 Test 1', '0001 Test 1', '0001 Test 1', '', 0, 'DBPERSISTCOMPLETE'),
('86e694f1-75cb-4ecd-9259-99449524c328', '919638527417', '3cc415c0-b3ed-4918-a606-e869eecba300/content/86e694f175cb4ecd925999449524c328.mp4', '3cc415c0-b3ed-4918-a606-e869eecba300/thumbnails/b6cd1ced9e5243dea67db116ce748a3c.png', 441879, '2018-01-11 10:15:14', '2018-01-11 06:13:48', 1, '5.29 seconds', 'video/mp4', '919638527417', 'VideoTitle1 edit', 'VideoTitle1 Description goes here edit', 'VideoTitle1 Description goes here edit', '3cc415c0-b3ed-4918-a606-e869eecba300/content/hls/86e694f175cb4ecd925999449524c328.m3u8', 0, 'DBPERSISTCOMPLETE'),
('8793db82-6615-4501-9f69-9bb71c18682f', '99786785657', '', '', 0, '2018-01-05 19:57:42', '2018-01-05 14:27:42', 1, '', 'text', '99786785657', 'sample backend content', 'test content', 'test content', '', 0, 'DBPERSISTCOMPLETE'),
('87fb6e71-3636-4ff5-b1ec-f4217116f65c', '919638527417', '', '', 0, '2018-01-11 10:28:49', '2018-01-11 05:33:04', 0, '', 'text', '919638527417', 'TestDelete', 'TestDelete Desc goes here', 'TestDelete Desc goes here', '', 0, 'DBPERSISTCOMPLETE'),
('88e5d79f-1319-4b22-8539-84cb92e48fb6', '91963852741', '8a472886-d9de-4f84-9e74-3916650ed19f/content/88e5d79f13194b22853984cb92e48fb6.jpg', '8a472886-d9de-4f84-9e74-3916650ed19f/thumbnails/826ee6a846a64277a70e935ddb870571.png', 128183, '2018-01-10 15:54:47', '2018-01-10 10:24:47', 1, '', 'image/jpeg', '91963852741', 'Image Title', 'Image Title Desc goes here', '', '', 0, 'DBPERSISTCOMPLETE'),
('8953db24-986e-44e8-8b0c-3f52aba5db00', '91963852741', '', '', 0, '2018-01-10 10:35:41', '2018-01-10 05:05:41', 1, '', 'text', '91963852741', 'jhgjhg', 'jhggjhg', 'jhggjhg', '', 0, 'DBPERSISTCOMPLETE'),
('899ab10a-26da-4ff2-9c67-164cb0efb49f', '919638527417', '3cc415c0-b3ed-4918-a606-e869eecba300/content/899ab10a26da4ff29c67164cb0efb49f.mp4', '3cc415c0-b3ed-4918-a606-e869eecba300/thumbnails/9521053e93154c68a049ce3bca1a52c0.png', 441879, '2018-01-11 11:24:51', '2018-01-11 05:54:51', 1, '5.29 seconds', 'video/mp4', '919638527417', 'v11', '', '', '3cc415c0-b3ed-4918-a606-e869eecba300/content/hls/899ab10a26da4ff29c67164cb0efb49f.m3u8', 0, 'DBPERSISTCOMPLETE'),
('89cb33bb-28a1-4a43-8e6b-e524dbaf7e53', '918151913741', '', '', 0, '2017-12-14 17:41:40', '2017-12-14 12:11:40', 1, '', 'text', '918151913741', '#Nivin #Filim', 'desc', 'contact', '', 0, 'DBPERSISTCOMPLETE'),
('8a3ea8b2-3be0-4e52-941a-6c528efe4e50', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/8a3ea8b23be04e52941a6c528efe4e50.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/0558d5803e174b529c5230ceafdd6983.png', 2107842, '2018-01-16 15:13:57', '2018-01-16 09:43:57', 1, '13.5 seconds', 'video/mp4', '911578934645', 'NL12', 'NL12', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/8a3ea8b23be04e52941a6c528efe4e50.m3u8', 0, 'DBPERSISTCOMPLETE'),
('8c80e0c7-88b6-4a03-8d6c-58c6da3ed32a', '911578934645', '', '', 0, '2018-01-16 16:24:05', '2018-01-16 10:54:05', 1, '', 'text', '911578934645', 'ghghh', 'ghghgh', 'ghghgh', '', 0, 'DBPERSISTCOMPLETE'),
('8ccce5fa-b902-4497-b99f-db603c190db5', '918151913741', '', '', 0, '2017-12-19 14:11:28', '2017-12-19 09:34:17', 0, '', 'text', '918151913741', 'h', 'v', 'h', '', 0, 'DBPERSISTCOMPLETE'),
('8d62dcf7-e590-44e6-b917-14c436a4d8ed', '91357123789', '', '', 0, '2018-01-12 09:40:42', '2018-01-12 04:10:42', 1, '', 'text', '91357123789', 'Test 2', 'test 2', 'test 2', '', 0, 'DBPERSISTCOMPLETE'),
('8ea76aaa-518e-4050-8d64-853bca89985a', '918105447982', '643ebad4-26d5-4ba9-9290-4a8d3ee2de2d/content/8ea76aaa518e40508d64853bca89985a.JPG', '643ebad4-26d5-4ba9-9290-4a8d3ee2de2d/thumbnails/fe2f5ca5e60e4a6a8bcbef9d7a0376f6.png', 185750, '2017-12-19 12:32:56', '2017-12-19 07:03:14', 1, '', 'image/jpeg', '918105447982', 'groups 5', 'fgfg', 'fgfg', '', 0, 'DBPERSISTCOMPLETE'),
('91f9e253-c663-47d3-af93-fb8bd74a5e71', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/91f9e253c66347d3af93fb8bd74a5e71.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/06e41534fc76423681ca7d7cfad068b4.png', 2107842, '2018-01-16 15:24:24', '2018-01-16 09:54:24', 1, '13.5 seconds', 'video/mp4', '911578934645', 'NL16', '', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/91f9e253c66347d3af93fb8bd74a5e71.m3u8', 0, 'DBPERSISTCOMPLETE'),
('92d22934-06d0-42b4-b454-881461823dd9', '918892452332', '', '', 0, '2017-12-27 21:49:42', '2017-12-27 16:19:42', 1, '', 'text', '918892452332', 'adfh', 'hjjb', 'sgfsd', '', 0, 'DBPERSISTCOMPLETE'),
('92dfca3d-1a45-4e52-9246-c79567225b48', '919528096314', 'bfac94df-2063-496c-871c-3618c446a199/content/92dfca3d1a454e529246c79567225b48.mp4', 'bfac94df-2063-496c-871c-3618c446a199/thumbnails/0f9324441c9e4166afe454b98eb5072e.png', 2387873, '2017-11-17 12:35:33', '2017-11-17 07:23:52', 0, '23.27 seconds', 'video/mp4', '919528096314', 'bahjs', NULL, '', NULL, NULL, NULL),
('93467de8-756a-434c-8fdb-d9456deb1eb1', '91987369456', '55981906-d119-4759-abda-e0e9542f0d5f/content/93467de8756a434c8fdbd9456deb1eb1.mp4', '55981906-d119-4759-abda-e0e9542f0d5f/thumbnails/35aab68f0aae4912a91e0df3823f74e7.png', 2107842, '2018-01-15 17:57:46', '2018-01-15 12:27:46', 1, '13.5 seconds', 'video/mp4', '91987369456', 'jkhkjhkjhkj', 'hhhhhhh', '', '55981906-d119-4759-abda-e0e9542f0d5f/content/hls/93467de8756a434c8fdbd9456deb1eb1.m3u8', 0, 'DBPERSISTCOMPLETE'),
('93b34e67-f2cd-4315-b3e8-73a3bbb9174c', '918151913741', 'f43a2e72-9087-4840-a992-3d0e2c3b150d/content/93b34e67f2cd4315b3e873a3bbb9174c.mp4', 'f43a2e72-9087-4840-a992-3d0e2c3b150d/thumbnails/54799a5899a04dacbd7e9a1002b1b718.png', 53467, '2017-12-14 18:52:15', '2017-12-19 10:47:06', 1, '0.54 seconds', 'video/mp4', '918151913741', '#Nivin #suzuki ', 'title', 'null', 'f43a2e72-9087-4840-a992-3d0e2c3b150d/content/hls/93b34e67f2cd4315b3e873a3bbb9174c.m3u8', 0, 'DBPERSISTCOMPLETE'),
('970b2525-546a-475d-bd07-117e2ec232d7', '919638527417', '', '', 0, '2018-01-11 10:13:02', '2018-01-11 04:43:02', 1, '', 'text', '919638527417', 'TextTitle1', 'TextTitle1 Description goes here', 'TextTitle1 Description goes here', '', 0, 'DBPERSISTCOMPLETE'),
('980c19f9-e359-4398-99c4-3703687788f4', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/980c19f9e359439899c43703687788f4.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/dde8fd6fb55e49238ddace67d4d40d9b.png', 2107842, '2018-01-16 14:25:04', '2018-01-16 08:55:04', 1, '13.5 seconds', 'video/mp4', '911578934645', 'New 1', '', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/980c19f9e359439899c43703687788f4.m3u8', 0, 'DBPERSISTCOMPLETE'),
('9a05f1db-41b1-442a-8c94-405389abcc19', '919449398577', '', '', 0, '2018-01-11 15:27:37', '2018-01-11 10:02:13', 0, '', 'text', '919449398577', 'test data for today', 'data', 'data', '', 0, 'DBPERSISTCOMPLETE'),
('9a0941ca-a615-424f-82cb-a75b2a233fb2', '918105447982', '', '', 0, '2017-12-19 14:58:25', '2017-12-19 09:33:31', 1, '', '', '918105447982', 'groups 7', 'Gfgfg', 'Wytyt', '', 0, 'DBPERSISTCOMPLETE'),
('9a9b7680-a029-462e-9ab0-149fcd87cbc9', '918892452332', '', '', 0, '2017-12-27 21:22:20', '2017-12-27 15:52:20', 1, '', '', '918892452332', 'asdasd', 'asdasd', '', '', 0, 'DBPERSISTCOMPLETE'),
('9e6ca4d8-7e8f-4426-94ed-961c9ad6344d', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/9e6ca4d87e8f442694ed961c9ad6344d.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/1d866519488942df8ce55d6718340b86.png', 2107842, '2018-01-16 14:41:57', '2018-01-16 09:11:57', 1, '13.5 seconds', 'video/mp4', '911578934645', 'nl2', '', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/9e6ca4d87e8f442694ed961c9ad6344d.m3u8', 0, 'DBPERSISTCOMPLETE'),
('9f83cd39-b087-4918-a549-456bed0af699', '91984632598', '', '', 0, '2018-01-22 14:01:01', '2018-01-22 08:31:01', 1, '', 'text', '91984632598', 'monday bla vla', 'monday bla vla', 'monday bla vla', '', 0, 'DBPERSISTCOMPLETE'),
('9f9d6b4d-55d3-4048-a3e6-7848ef741726', '918105447982', '643ebad4-26d5-4ba9-9290-4a8d3ee2de2d/content/9f9d6b4d55d34048a3e67848ef741726.JPG', '643ebad4-26d5-4ba9-9290-4a8d3ee2de2d/thumbnails/5112fd869f24423594a75dd33940a4f3.png', 5395061, '2017-11-17 11:56:09', '2017-11-17 06:26:09', 1, '', 'image/jpeg', '918105447982', '1st content', 'test', '', NULL, NULL, NULL),
('a014470c-7cd3-49fd-bc79-95edd3ce08c1', '91963852741', '', '', 0, '2018-01-10 10:53:58', '2018-01-10 05:23:58', 1, '', 'text', '91963852741', '6', '6', '6', '', 0, 'DBPERSISTCOMPLETE'),
('a0172067-c8eb-4141-bcfa-48786d4f83eb', '918151913741', '', '', 0, '2017-12-08 16:59:39', '2017-12-08 11:29:39', 1, '', '', '918151913741', 'g', 'h', '', '', 5, 'LOCALSTORECOMPLETE'),
('a0f73c54-15c7-45e9-83fb-4cddc074ef95', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/a0f73c5415c745e983fb4cddc074ef95.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/e227693f277c49d1b0dec7a7f14fd934.png', 2107842, '2018-01-16 16:54:18', '2018-01-16 11:24:18', 1, '13.5 seconds', 'video/mp4', '911578934645', 'hjhjhjh', 'hjhjhj', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/a0f73c5415c745e983fb4cddc074ef95.m3u8', 0, 'DBPERSISTCOMPLETE'),
('a2186fbe-d3d1-47db-b452-b5b952d348f6', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/a2186fbed3d147dbb452b5b952d348f6.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/31302e2da79843edbd56eb8c40e86c31.png', 2107842, '2018-01-16 17:45:41', '2018-01-16 12:15:41', 1, '13.5 seconds', 'video/mp4', '911578934645', 'NL23', 'nl23', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/a2186fbed3d147dbb452b5b952d348f6.m3u8', 0, 'DBPERSISTCOMPLETE'),
('a4f7fc73-df21-4e72-87b8-4749c0d502cb', '918892452332', '', '', 0, '2017-12-27 21:26:37', '2017-12-27 15:57:37', 1, '', '', '918892452332', 'rrrrrrrrr', 'rrrrrrrrrr', 'ffffffffffff', '', 0, 'DBPERSISTCOMPLETE'),
('a53f5189-395c-4def-a444-0975c5bf97bd', '919035564107', '', '', 0, '2018-02-02 17:09:14', '2018-02-02 11:39:14', 1, '', 'text', '919035564107', 'h,&;&;!&/&;7/64& hdjrjfjddjhddjjrjdjdj ', 'fhjfjdjddj fidjjd', 'fjnfjdjdjd', '', 0, 'DBPERSISTCOMPLETE'),
('a662379b-05e2-4bdb-b5a7-8f43a823a98b', '91963852741', '8a472886-d9de-4f84-9e74-3916650ed19f/content/a662379b05e24bdbb5a78f43a823a98b.mp3', '', 80602, '2018-01-10 15:58:15', '2018-01-10 10:28:15', 1, '2011.427734375 seconds', 'audio/mpeg', '91963852741', 'Audio Title', 'Audio Title Desc', '', '', 0, 'DBPERSISTCOMPLETE'),
('a747dabe-37c6-4fdb-ae36-df2dfe5fee23', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/a747dabe37c64fdbae36df2dfe5fee23.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/d342bad1a8e3491c8e3d680f857519ab.png', 2107842, '2018-01-16 15:08:05', '2018-01-16 09:38:05', 1, '13.5 seconds', 'video/mp4', '911578934645', 'jhjhj', '', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/a747dabe37c64fdbae36df2dfe5fee23.m3u8', 0, 'DBPERSISTCOMPLETE'),
('a7ef6fb4-2e7e-40c0-be67-da7d81e6f6e0', '919528096314', 'bfac94df-2063-496c-871c-3618c446a199/content/a7ef6fb42e7e40c0be67da7d81e6f6e0.', 'bfac94df-2063-496c-871c-3618c446a199/thumbnails/9742c6ad7c1e4d70ae3fb5eb3e6af104.png', 21962, '2017-11-17 12:34:22', '2017-11-17 07:23:59', 0, '', 'image/jpeg', '919528096314', 'vabab', NULL, '', NULL, NULL, NULL),
('a80d8590-a270-43e2-933f-bed14683e04d', '918151913741', '', '', 0, '2017-12-19 16:21:54', '2017-12-19 14:16:06', 1, '', 'text', '918151913741', '#topic ??', 'g', 'h', '', 0, 'DBPERSISTCOMPLETE'),
('aafb0d64-6174-4ce5-9f6f-edc0ed477c5b', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/aafb0d6461744ce59f6fedc0ed477c5b.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/5a4420b980b848e28717bca779a123dd.png', 2107842, '2018-01-16 11:07:37', '2018-01-16 05:37:37', 1, '13.5 seconds', 'video/mp4', '911578934645', 'lkjlk', 'lkjlkj', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/aafb0d6461744ce59f6fedc0ed477c5b.m3u8', 0, 'DBPERSISTCOMPLETE'),
('ab3f2fc2-c9c4-4c6a-a3bc-92bad39fb8e7', '919638527417', '', '', 0, '2018-01-11 11:06:41', '2018-01-11 05:36:41', 1, '', 'text', '919638527417', 't1', 't1', 't1', '', 0, 'DBPERSISTCOMPLETE'),
('ac00f1a3-d044-4513-b020-69133803d123', '91357123789', '6d9e24e8-820b-4320-be94-94012619b7c6/content/ac00f1a3d0444513b02069133803d123.jpg', '6d9e24e8-820b-4320-be94-94012619b7c6/thumbnails/5c38db955ac24ad6aeaa640579305a61.png', 128183, '2018-01-12 09:38:44', '2018-01-12 11:16:09', 1, '', 'image/jpeg', '91357123789', '01 Image Data 1 Edit', '01 Image Data 1 Desc Goes Here Edit', '01 Image Data 1 Desc Goes Here Edit', '', 0, 'DBPERSISTCOMPLETE'),
('ac8f8928-f3a0-46a8-8c24-be9a5f99fe54', '918151913741', 'f43a2e72-9087-4840-a992-3d0e2c3b150d/content/ac8f8928f3a046a88c24be9a5f99fe54.mp4', 'f43a2e72-9087-4840-a992-3d0e2c3b150d/thumbnails/a5c6ec01705842a5be9d41d2c04d4bc9.png', 477631, '2017-12-08 17:08:34', '2017-12-14 12:13:13', 1, '8.5 seconds', 'video/mp4', '918151913741', '#Nivin #fun', 'dukkar', 'null', 'f43a2e72-9087-4840-a992-3d0e2c3b150d/content/hls/ac8f8928f3a046a88c24be9a5f99fe54.m3u8', 0, 'DBPERSISTCOMPLETE'),
('ae046332-f545-4ed4-8408-0ba5cfcf0973', '91712345698', '', '', 0, '2018-01-09 15:55:04', '2018-01-09 10:25:04', 1, '', 'text', '91712345698', 'Title goes here', 'Description goes here', 'Description goes here', '', 0, 'DBPERSISTCOMPLETE'),
('af202296-814a-4774-b93d-0cf569dfa068', '91712345698', '', '', 0, '2018-01-09 16:16:53', '2018-01-09 10:46:53', 1, '', 'text', '91712345698', 'ytyut', 'uyttuyt', 'uyttuyt', '', 0, 'DBPERSISTCOMPLETE'),
('b1a86e1d-fc87-43b0-b2b7-ea3f369ab792', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/b1a86e1dfc8743b0b2b7ea3f369ab792.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/eefc6487b56b4c8ca84a00eb14401e43.png', 2107842, '2018-01-16 13:54:41', '2018-01-16 08:24:41', 1, '13.5 seconds', 'video/mp4', '911578934645', 'kjk', 'kjhkj', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/b1a86e1dfc8743b0b2b7ea3f369ab792.m3u8', 0, 'DBPERSISTCOMPLETE'),
('b1ae1616-8821-4435-953e-f2be836c2d39', '548765432654', '', '', 0, '2018-01-05 20:42:00', '2018-01-05 15:12:00', 1, '', 'text', '548765432654', 'CreatedBy Manikanta', 'Text content 2 ', 'this is for testing text type while retriveing', '', 0, 'DBPERSISTCOMPLETE'),
('b3b8959b-65c9-4ed3-9a11-e7e93d8bd850', '91154632589', 'e091aad4-0da5-4954-8059-4a333cc388ce/content/b3b8959b65c94ed39a11e7e93d8bd850.mp4', 'e091aad4-0da5-4954-8059-4a333cc388ce/thumbnails/ed01968c4e8f4c5d94b8d65371fddf15.png', 441879, '2018-01-18 18:44:16', '2018-01-18 13:14:16', 1, '5.29 seconds', 'video/mp4', '91154632589', 'srisri1008pj', 'srisri1008pj', '', 'e091aad4-0da5-4954-8059-4a333cc388ce/content/hls/b3b8959b65c94ed39a11e7e93d8bd850.m3u8', 0, 'DBPERSISTCOMPLETE'),
('b4480cbc-8853-4943-b6d1-5228ccc32c03', '919738849769', '', '', 0, '2017-12-18 15:04:18', '2017-12-18 09:34:18', 1, '', 'text', '919738849769', 't', 'h', 'h', '', 0, 'DBPERSISTCOMPLETE'),
('b44e563a-986a-4bfa-938e-11f48e7e1580', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/b44e563a986a4bfa938e11f48e7e1580.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/505eb11609ce41cebf6b9ec73174fa32.png', 2107842, '2018-01-16 13:55:32', '2018-01-16 08:25:32', 1, '13.5 seconds', 'video/mp4', '911578934645', 'kjl', '', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/b44e563a986a4bfa938e11f48e7e1580.m3u8', 0, 'DBPERSISTCOMPLETE'),
('b4605473-db0d-48fa-9dcb-bbd0f2190693', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/b4605473db0d48fa9dcbbbd0f2190693.jpg', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/146a9fd3e3e74e8e879b195143c28a2e.png', 6067626, '2018-01-16 11:02:13', '2018-01-16 05:32:13', 1, '', 'image/jpeg', '911578934645', 'klj', 'jkj', '', '', 0, 'DBPERSISTCOMPLETE'),
('b49ce7ca-43db-41a4-a987-b3bb045b4062', '91712345698', '', '', 0, '2018-01-09 12:25:59', '2018-01-09 06:55:59', 1, '', 'text', '91712345698', 'Text1', 'Text 1 Description goes here', 'Text 1 Description goes here', '', 0, 'DBPERSISTCOMPLETE'),
('b56cfde3-463a-47f4-bfd7-75464617b5e5', '919638527417', '3cc415c0-b3ed-4918-a606-e869eecba300/content/b56cfde3463a47f4bfd775464617b5e5.mp4', '3cc415c0-b3ed-4918-a606-e869eecba300/thumbnails/dc40e000017f42febbe97cd95d20b4cb.png', 441879, '2018-01-11 11:27:52', '2018-01-11 05:57:52', 1, '5.29 seconds', 'video/mp4', '919638527417', 'v13', '', '', '3cc415c0-b3ed-4918-a606-e869eecba300/content/hls/b56cfde3463a47f4bfd775464617b5e5.m3u8', 0, 'DBPERSISTCOMPLETE'),
('b8642307-a8ff-4fad-b423-4686d0237f70', '918105447982', '643ebad4-26d5-4ba9-9290-4a8d3ee2de2d/content/b8642307a8ff4fadb4234686d0237f70.mp3', '', 26280, '2017-11-17 18:52:52', '2017-11-17 13:22:52', 1, '', 'audio/mp4', '918105447982', 'Audio testing 2', 'Test 2', '', NULL, NULL, NULL),
('b8d003b4-07d6-41d3-a900-23093d8745c9', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/b8d003b407d641d3a90023093d8745c9.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/d2ba31744d4347b28eb2dfdaf7c0b042.png', 2107842, '2018-01-16 15:17:46', '2018-01-16 09:47:46', 1, '13.5 seconds', 'video/mp4', '911578934645', 'NL13', '', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/b8d003b407d641d3a90023093d8745c9.m3u8', 0, 'DBPERSISTCOMPLETE'),
('b9199102-f53b-4fe3-9e13-8992f58fff3e', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/b9199102f53b4fe39e138992f58fff3e.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/6f7b8305ed9c470994d587978ed32cb9.png', 2107842, '2018-01-16 11:08:39', '2018-01-16 05:38:39', 1, '13.5 seconds', 'video/mp4', '911578934645', 'kjhk', 'kjhkj', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/b9199102f53b4fe39e138992f58fff3e.m3u8', 0, 'DBPERSISTCOMPLETE'),
('b9a54998-a588-4eb2-8376-37d26d3fb1ff', '91963852741', '', '', 0, '2018-01-10 14:06:41', '2018-01-10 08:36:41', 1, '', 'text', '91963852741', '44EDIT', '44EDIT DESC', '44EDIT DESC', '', 0, 'DBPERSISTCOMPLETE'),
('bb219477-4b1d-43cc-8e74-4733646b3708', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/bb2194774b1d43cc8e744733646b3708.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/3b933bd85a34400c983e4dff70384877.png', 2107842, '2018-01-16 15:33:40', '2018-01-16 10:03:40', 1, '13.5 seconds', 'video/mp4', '911578934645', 'NL17', 'NL17', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/bb2194774b1d43cc8e744733646b3708.m3u8', 0, 'DBPERSISTCOMPLETE'),
('bb223745-ff57-47aa-b329-cad16fdc10a9', '918105447982', '643ebad4-26d5-4ba9-9290-4a8d3ee2de2d/content/bb223745ff5747aab329cad16fdc10a9.mp3', '', 29591, '2017-11-20 12:02:57', '2017-11-20 06:32:57', 1, '', 'audio/mp4', '918105447982', 'Audio 3', 'testing 3', '', NULL, NULL, NULL),
('bba8f794-6dfd-447a-9e25-e41b2bbf536f', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/bba8f7946dfd447a9e25e41b2bbf536f.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/e62dfc709672436e82a3671961fabc62.png', 2107842, '2018-01-16 11:05:35', '2018-01-16 05:35:35', 1, '13.5 seconds', 'video/mp4', '911578934645', 'kjhk', '', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/bba8f7946dfd447a9e25e41b2bbf536f.m3u8', 0, 'DBPERSISTCOMPLETE'),
('bc169ec3-dc5a-4a54-bc69-2f7c5cd661fe', '918892452332', '', '', 0, '2017-12-21 16:00:05', '2017-12-21 10:30:05', 1, '', '', '918892452332', 'sgehj', 'gdheh', '', '', 0, 'DBPERSISTCOMPLETE'),
('bc66b40d-7d19-40f4-b166-916bbf3f453c', '919035299524', '', '', 0, '2017-11-17 16:05:35', '2017-11-17 10:35:35', 1, '', 'text', '919035299524', 'test', 'test', 'test', NULL, NULL, NULL),
('bce9d372-f621-466f-9ff0-d4d1688883e2', '918892452332', '', '', 0, '2017-12-27 19:48:50', '2017-12-27 14:18:50', 1, '', 'text', '918892452332', 'ggggg', 'gggggggg', 'ggggggg', '', 0, 'DBPERSISTCOMPLETE'),
('be87f5c7-6b2e-4cb7-9f74-bd4e1cabaa20', '91159789123', '', '', 0, '2018-01-12 17:14:30', '2018-01-12 11:44:30', 1, '', 'text', '91159789123', 'testPJCONTENT', 'kjhkjhkj', 'kjhkjhkj', '', 0, 'DBPERSISTCOMPLETE'),
('bf7b90b6-0a37-430a-90a2-c527f7b0a445', '918151913741', '', '', 0, '2017-12-14 20:24:46', '2017-12-14 14:54:46', 1, '', 'text', '918151913741', '#Nivinf', 'j', 't', '', 0, 'DBPERSISTCOMPLETE'),
('c077ff20-e891-4097-86a6-1bf36f962712', '911578934645', '', '', 0, '2018-01-16 16:20:37', '2018-01-16 10:50:37', 1, '', 'text', '911578934645', 'hjhjhj', 'ggffgfg', 'ggffgfg', '', 0, 'DBPERSISTCOMPLETE'),
('c188adff-86f2-4370-803f-e823ec98c8ca', '91357123789', '6d9e24e8-820b-4320-be94-94012619b7c6/content/c188adff86f24370803fe823ec98c8ca.jpg', '6d9e24e8-820b-4320-be94-94012619b7c6/thumbnails/9105def2e3c9437390698dcd41ee2838.png', 128183, '2018-01-12 16:46:35', '2018-01-12 11:16:35', 1, '', 'image/jpeg', '91357123789', 'Test after edit', 'Test after edit', '', '', 0, 'DBPERSISTCOMPLETE'),
('c2c4f462-ac4b-4cb4-b80a-be82da8dbd65', '9114893256', '', '', 0, '2018-01-19 11:18:35', '2018-01-19 05:48:35', 1, '', 'text', '9114893256', 'some text', 'some text', 'some text', '', 0, 'DBPERSISTCOMPLETE'),
('c36856b0-8fd9-4bd9-a73f-d0461b50e9dd', '91812345679', 'b171f000-983f-45d5-98b2-d0405e65bbed/content/c36856b08fd94bd9a73fd0461b50e9dd.mp3', '', 80602, '2018-01-08 17:12:47', '2018-01-08 11:42:47', 1, '2011.427734375 seconds', 'audio/mpeg', '91812345679', 'tyreytrytytry', 'jhghjgjhgjhgjhg', '', '', 0, 'DBPERSISTCOMPLETE'),
('c390caec-d6c2-4059-8c73-86ca306dee25', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/c390caecd6c240598c7386ca306dee25.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/46b037b76466499cb51d360d4da9e49f.png', 2107842, '2018-01-16 14:47:14', '2018-01-16 09:17:14', 1, '13.5 seconds', 'video/mp4', '911578934645', 'NL5', '', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/c390caecd6c240598c7386ca306dee25.m3u8', 0, 'DBPERSISTCOMPLETE'),
('c592e389-61f3-4c40-8c7f-52c30f4d40de', '91812345679', 'b171f000-983f-45d5-98b2-d0405e65bbed/content/c592e38961f34c408c7f52c30f4d40de.mp4', 'b171f000-983f-45d5-98b2-d0405e65bbed/thumbnails/6ac4370b639b49fabf1a113e6c3c9d87.png', 441879, '2018-01-16 15:47:05', '2018-01-16 10:17:05', 1, '5.29 seconds', 'video/mp4', '91812345679', 'pjsomecontent', 'images', '', 'b171f000-983f-45d5-98b2-d0405e65bbed/content/hls/c592e38961f34c408c7f52c30f4d40de.m3u8', 0, 'DBPERSISTCOMPLETE'),
('c66e5987-5f13-4ab0-aa56-8b6a70c3b4e9', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/c66e59875f134ab0aa568b6a70c3b4e9.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/6178482fe9374809973671bd235b51f0.png', 2107842, '2018-01-16 15:20:23', '2018-01-16 09:50:23', 1, '13.5 seconds', 'video/mp4', '911578934645', 'NL15', '', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/c66e59875f134ab0aa568b6a70c3b4e9.m3u8', 0, 'DBPERSISTCOMPLETE'),
('c728cb44-e325-4097-87e5-c7633321f65f', '91357123789', '6d9e24e8-820b-4320-be94-94012619b7c6/content/c728cb44e325409787e5c7633321f65f.mp4', '6d9e24e8-820b-4320-be94-94012619b7c6/thumbnails/5a2f13f4441048d9bc7b8d97ece1f0ea.png', 441879, '2018-01-12 16:59:20', '2018-01-12 11:29:20', 1, '5.29 seconds', 'video/mp4', '91357123789', 'jhghjhgjhgjh', 'jhgjhgjhggj', '', '6d9e24e8-820b-4320-be94-94012619b7c6/content/hls/c728cb44e325409787e5c7633321f65f.m3u8', 0, 'DBPERSISTCOMPLETE'),
('c8f9279d-a385-47fc-b7cc-ff7fc91b8e93', '919035299524', '76fba5bd-eae6-4f36-a275-f5cc80afbbdd/content/c8f9279da38547fcb7ccff7fc91b8e93.mp3', '', 7413824, '2017-11-17 16:15:47', '2017-11-17 10:45:47', 1, '324830.40625 seconds', 'audio/mpeg', '919035299524', 'Audio', 'Audio test', '', NULL, NULL, NULL),
('cbf1aca2-6151-4e41-9019-a387cea9bcca', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/cbf1aca261514e419019a387cea9bcca.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/44d3dfb0d1d84844bd37a220ffccc1fc.png', 2107842, '2018-01-16 16:21:00', '2018-01-16 10:51:00', 1, '13.5 seconds', 'video/mp4', '911578934645', 'gghgh', '', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/cbf1aca261514e419019a387cea9bcca.m3u8', 0, 'DBPERSISTCOMPLETE'),
('cbf71745-8d1e-452e-8b22-3e7e2457d074', '9112300012300', 'd8f83541-7749-4795-a963-9fbd73eeadbf/content/cbf717458d1e452e8b223e7e2457d074.mp3', '', 20897, '2017-12-14 17:55:56', '2017-12-14 12:25:56', 1, '1306.1219482421875 seconds', 'audio/mpeg', '9112300012300', 'sing sing ding dong bell', 'sing sing ding dong bell', '', '', 0, 'DBPERSISTCOMPLETE'),
('cc72577e-7ee9-4b48-8554-801d9a9e7c84', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/cc72577e7ee94b488554801d9a9e7c84.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/e9c45b2a286f446dad70e7e752b730b3.png', 2107842, '2018-01-16 15:46:55', '2018-01-16 10:16:55', 1, '13.5 seconds', 'video/mp4', '911578934645', 'kjhkjg', '', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/cc72577e7ee94b488554801d9a9e7c84.m3u8', 0, 'DBPERSISTCOMPLETE'),
('cc86b59f-e8f0-4dbd-9975-2aa8b6b538eb', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/cc86b59fe8f04dbd99752aa8b6b538eb.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/1e6f6d0499e74357b8068704ff1e7f40.png', 2107842, '2018-01-16 11:10:23', '2018-01-16 05:40:23', 1, '13.5 seconds', 'video/mp4', '911578934645', 'kjkljl', 'lkjlkj', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/cc86b59fe8f04dbd99752aa8b6b538eb.m3u8', 0, 'DBPERSISTCOMPLETE'),
('ccc81664-71a6-4143-a518-ef08ec18aa5a', '918105447982', '643ebad4-26d5-4ba9-9290-4a8d3ee2de2d/content/ccc8166471a64143a518ef08ec18aa5a.JPG', '643ebad4-26d5-4ba9-9290-4a8d3ee2de2d/thumbnails/502b1562bc78476e9f5a6966b5aec3d6.png', 165127, '2017-12-18 18:26:21', '2017-12-18 13:03:48', 1, '', 'image/jpeg', '918105447982', 'groups 4', 'sfgfgf', 'sfgfgf', '', 0, 'DBPERSISTCOMPLETE'),
('ccd85295-6268-4c93-83fb-6e65c3a0dfad', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/ccd8529562684c9383fb6e65c3a0dfad.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/ff46cc6f03a64931a10ad7a6678eb35c.png', 2107842, '2018-01-16 13:22:07', '2018-01-16 07:52:07', 1, '13.5 seconds', 'video/mp4', '911578934645', 'hjgjhg', 'jhgjh', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/ccd8529562684c9383fb6e65c3a0dfad.m3u8', 0, 'DBPERSISTCOMPLETE'),
('cd500697-3638-4ec7-8cfd-70cba51c665d', '91963852741', '', '', 0, '2018-01-10 10:45:12', '2018-01-10 05:15:12', 1, '', 'text', '91963852741', '2', '2', '2', '', 0, 'DBPERSISTCOMPLETE'),
('cf19e9d1-d32e-41f2-ae1e-b17cc016958b', '91963852741', '', '', 0, '2018-01-10 10:38:20', '2018-01-10 05:08:20', 1, '', 'text', '91963852741', 'lkjl', 'klk', 'klk', '', 0, 'DBPERSISTCOMPLETE'),
('d0c6d240-54a1-47d4-853b-63a52874ae4a', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/d0c6d24054a147d4853b63a52874ae4a.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/16a9f23d3240495097e16838ac8e73cc.png', 2107842, '2018-01-16 14:57:44', '2018-01-16 09:27:44', 1, '13.5 seconds', 'video/mp4', '911578934645', 'NL9', '', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/d0c6d24054a147d4853b63a52874ae4a.m3u8', 0, 'DBPERSISTCOMPLETE'),
('d0d26b98-feeb-472e-b436-d979f4d66efd', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/d0d26b98feeb472eb436d979f4d66efd.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/e7c9464688984d3da302a89b9a5bd018.png', 2107842, '2018-01-16 11:28:59', '2018-01-16 09:30:52', 0, '13.5 seconds', 'video/mp4', '911578934645', 'lkjlkj', 'lkjlk', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/d0d26b98feeb472eb436d979f4d66efd.m3u8', 0, 'DBPERSISTCOMPLETE'),
('d10bcc97-6bc8-40d1-a6fc-a619de0c65ba', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/d10bcc976bc840d1a6fca619de0c65ba.jpg', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/b85929d330e94ee490692645d1cdb7df.png', 6067626, '2018-01-16 11:04:47', '2018-01-16 05:34:47', 1, '', 'image/jpeg', '911578934645', '6', '6', '', '', 0, 'DBPERSISTCOMPLETE'),
('d28a385c-ffa5-4435-a0a8-c7da6fad2693', '918151913741', 'f43a2e72-9087-4840-a992-3d0e2c3b150d/content/d28a385cffa54435a0a8c7da6fad2693.', 'f43a2e72-9087-4840-a992-3d0e2c3b150d/thumbnails/4b91e8d426494491af235bdb156381f9.png', 31693, '2018-02-02 17:07:05', '2018-02-02 11:37:05', 1, '', 'image/jpeg', '918151913741', 'b', 'yfh', '', '', 0, 'DBPERSISTCOMPLETE'),
('d2bf2350-b393-4b67-ad9b-c6fdcec33895', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/d2bf2350b3934b67ad9bc6fdcec33895.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/f6f82ab822ba48d9ac0cb4608e346af8.png', 2107842, '2018-01-16 14:50:15', '2018-01-16 09:20:15', 1, '13.5 seconds', 'video/mp4', '911578934645', 'NL6', 'NL6', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/d2bf2350b3934b67ad9bc6fdcec33895.m3u8', 0, 'DBPERSISTCOMPLETE'),
('d425c7c5-d755-4142-8eb0-cdf3a35c3b7b', '91812345679', '', '', 0, '2018-01-08 16:39:35', '2018-01-08 11:09:35', 1, '', 'text', '91812345679', 'oiuoiu', 'oiuoiuoiu', 'oiuoiuoiu', '', 0, 'DBPERSISTCOMPLETE'),
('d47c5300-9285-4f99-b35e-7f758e9140c2', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/d47c530092854f99b35e7f758e9140c2.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/03027130dbed40f0bac5780406eacab3.png', 2107842, '2018-01-16 16:26:33', '2018-01-16 10:56:33', 1, '13.5 seconds', 'video/mp4', '911578934645', 'ghghghgh', 'hjhhj', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/d47c530092854f99b35e7f758e9140c2.m3u8', 0, 'DBPERSISTCOMPLETE'),
('d4877e58-c307-484f-a874-24b011043002', '918892452332', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4/content/d4877e58c307484fa87424b011043002.mp4', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4/thumbnails/948d46bf18d64246a75a33c562a97b49.png', 30018, '2017-12-20 19:01:26', '2017-12-20 13:31:26', 1, '1.62 seconds', 'video/mp4', '918892452332', 'vvvvvvv', 'vvvvvvd', '', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4/content/hls/d4877e58c307484fa87424b011043002.m3u8', 0, 'DBPERSISTCOMPLETE'),
('d5b511bd-241f-4d5c-9fc2-945e4dc4c935', '919632357734', '03f3f166-c138-4065-b070-2f07921020fa/content/d5b511bd241f4d5c9fc2945e4dc4c935.mp4', '03f3f166-c138-4065-b070-2f07921020fa/thumbnails/ee8a49463b754bc68ed3210136890083.png', 240727, '2017-11-21 13:07:09', '2017-11-21 07:37:09', 1, '5.62 seconds', 'video/mp4', '919632357734', 'video', 'video content', '', NULL, NULL, NULL),
('d6718b7d-9fe7-49a7-acd2-595ae9d70842', '91812345679', 'b171f000-983f-45d5-98b2-d0405e65bbed/content/d6718b7d9fe749a7acd2595ae9d70842.mp4', 'b171f000-983f-45d5-98b2-d0405e65bbed/thumbnails/756d1321cce849e1b023e327260b6772.png', 441879, '2018-01-16 15:46:52', '2018-01-16 10:16:52', 1, '5.29 seconds', 'video/mp4', '91812345679', 'pjsomecontent', 'images', '', 'b171f000-983f-45d5-98b2-d0405e65bbed/content/hls/d6718b7d9fe749a7acd2595ae9d70842.m3u8', 0, 'DBPERSISTCOMPLETE'),
('d6e4fe41-3965-439d-99ad-bfc404c5a436', '91357123789', '', '', 0, '2018-01-12 09:40:51', '2018-01-12 04:10:51', 1, '', 'text', '91357123789', 'test 3', 'Test3', 'Test3', '', 0, 'DBPERSISTCOMPLETE'),
('d8d2ef08-5911-44d2-af4e-c5b849419b58', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/d8d2ef08591144d2af4ec5b849419b58.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/751f2a285e174ce6a568f9bd15f9bf3f.png', 2107842, '2018-01-16 11:00:54', '2018-01-16 05:30:54', 1, '13.5 seconds', 'video/mp4', '911578934645', 'hhh', 'hhh', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/d8d2ef08591144d2af4ec5b849419b58.m3u8', 0, 'DBPERSISTCOMPLETE'),
('d91efd6f-b55a-4c1e-a96f-34b3698bac72', '918892452332', '', '', 0, '2017-12-28 01:17:01', '2017-12-27 19:47:01', 1, '', '', '918892452332', 'gxhxkcoxg', 'igzkgxkgx', '', '', 0, 'DBPERSISTCOMPLETE'),
('d9351233-a483-4e8e-9181-795bfe229def', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/d9351233a4834e8e9181795bfe229def.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/8450a528d899437ba6633687f4982382.png', 2107842, '2018-01-16 16:22:08', '2018-01-16 10:52:08', 1, '13.5 seconds', 'video/mp4', '911578934645', 'ghghgh', '', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/d9351233a4834e8e9181795bfe229def.m3u8', 0, 'DBPERSISTCOMPLETE'),
('db7a1a52-3474-4518-ae7b-cedf88edc11a', '91154632589', '', '', 0, '2018-01-18 15:41:51', '2018-01-18 10:11:51', 1, '', 'text', '91154632589', 'sleepy', 'sleepyyy day', 'sleepyyy day', '', 0, 'DBPERSISTCOMPLETE'),
('ddad7e46-53c9-42cd-a235-6d5fbb5b0caa', '919638527417', '3cc415c0-b3ed-4918-a606-e869eecba300/content/ddad7e4653c942cda2356d5fbb5b0caa.mp3', '', 32418, '2018-01-11 11:13:45', '2018-01-11 05:43:45', 1, '2011.427734375 seconds', 'audio/mpeg', '919638527417', 'a111111111', '', '', '', 0, 'DBPERSISTCOMPLETE'),
('de9d36a9-0fe0-4b8e-9935-a6f5a84a71cf', '918892452332', '', '', 0, '2017-12-28 01:03:34', '2017-12-27 19:43:52', 1, '', '', '918892452332', 'rtrtrtrt', 'rtrtrtrt', 'fjfjfjfjfuf', '', 0, 'DBPERSISTCOMPLETE'),
('df89b6b7-ecdd-4f9c-a500-83168c76f8c8', '91357123789', '6d9e24e8-820b-4320-be94-94012619b7c6/content/df89b6b7ecdd4f9ca50083168c76f8c8.mp3', '', 80602, '2018-01-12 09:39:31', '2018-01-12 04:09:31', 1, '2011.427734375 seconds', 'audio/mpeg', '91357123789', '01 Audio Data 1', '01 Audio Data 1 Desc Goes here', '', '', 0, 'DBPERSISTCOMPLETE'),
('e0fd4954-04cc-40cf-9ce3-b95305c6f634', '097678678777', '', '', 0, '2018-01-05 14:35:03', '2018-01-05 09:05:03', 1, '', 'text', '097678678777', 'test', 'test1', 'test1', '', 0, 'DBPERSISTCOMPLETE'),
('e13445e0-d94e-48cf-8e76-3057580e9c34', '919638527417', '3cc415c0-b3ed-4918-a606-e869eecba300/content/e13445e0d94e48cf8e763057580e9c34.mp3', '', 32418, '2018-01-11 11:20:30', '2018-01-11 05:50:30', 1, '2011.427734375 seconds', 'audio/mpeg', '919638527417', 'a2', '', '', '', 0, 'DBPERSISTCOMPLETE'),
('e1c53842-dec3-458e-9eda-2c2d69488a7c', '91654789321', '7ce6959e-6997-4eef-8042-4fa645265ece/content/e1c53842dec3458e9eda2c2d69488a7c.jpg', '7ce6959e-6997-4eef-8042-4fa645265ece/thumbnails/4109ce5d6cf7455d85f08d1c063854b6.png', 97715, '2018-01-05 18:06:38', '2018-01-05 12:36:38', 1, '', 'image/jpeg', '91654789321', 'hey fish', 'hey fishhhh', '', '', 0, 'DBPERSISTCOMPLETE'),
('e64086a1-79a6-4b98-b465-095dd3b88105', '919638527417', '3cc415c0-b3ed-4918-a606-e869eecba300/content/e64086a179a64b98b465095dd3b88105.mp3', '', 39950, '2018-01-11 11:07:33', '2018-01-11 05:37:33', 1, '2481.633544921875 seconds', 'audio/mpeg', '919638527417', 'a1', 'a1', '', '', 0, 'DBPERSISTCOMPLETE'),
('e6cf9a9e-b836-4daa-8e2a-11a6dbbcb607', '919638527417', '3cc415c0-b3ed-4918-a606-e869eecba300/content/e6cf9a9eb8364daa8e2a11a6dbbcb607.jpg', '3cc415c0-b3ed-4918-a606-e869eecba300/thumbnails/2914fb9802814059905aa4dceb875bd1.png', 128183, '2018-01-11 11:07:02', '2018-01-11 05:37:02', 1, '', 'image/jpeg', '919638527417', 'i1', 'i1', '', '', 0, 'DBPERSISTCOMPLETE'),
('e73fa937-e118-4088-98b6-a72bdf68b037', '918892452332', '', '', 0, '2017-12-27 21:29:42', '2017-12-27 15:59:42', 1, '', 'text', '918892452332', 'gxjus', 'jfzkgzkgs', 'jgzkhzkhd', '', 0, 'DBPERSISTCOMPLETE'),
('e7724eec-5479-4d17-a848-5e028e9a1121', '918151913741', 'f43a2e72-9087-4840-a992-3d0e2c3b150d/content/e7724eec54794d17a8485e028e9a1121.mp3', '', 8142719, '2017-12-08 17:03:09', '2017-12-08 11:33:09', 1, '257767.546875 seconds', 'audio/mpeg', '918151913741', 'aval', 'hc', '', '', 0, 'DBPERSISTCOMPLETE'),
('e7fb8941-94ec-40dd-bbf3-4e318d838ea5', '91987369456', '55981906-d119-4759-abda-e0e9542f0d5f/content/e7fb894194ec40ddbbf34e318d838ea5.mp4', '55981906-d119-4759-abda-e0e9542f0d5f/thumbnails/1999d4ee38fb49e89cc312ebe59524b6.png', 441879, '2018-01-15 10:14:49', '2018-01-15 07:18:39', 0, '5.29 seconds', 'video/mp4', '91987369456', 'kjhkjh', 'kjhkjhkj', '', '55981906-d119-4759-abda-e0e9542f0d5f/content/hls/e7fb894194ec40ddbbf34e318d838ea5.m3u8', 0, 'DBPERSISTCOMPLETE'),
('e8c144d5-ed24-4c22-a4e3-994da9c34993', '91963852741', '', '', 0, '2018-01-10 10:48:30', '2018-01-10 11:53:14', 0, '', 'text', '91963852741', '3', '3', '3', '', 0, 'DBPERSISTCOMPLETE'),
('e8eb26ac-f3a5-4fc2-a899-59f10172a467', '91963852741', '', '', 0, '2018-01-10 10:44:41', '2018-01-10 05:14:41', 1, '', 'text', '91963852741', '1', '1', '1', '', 0, 'DBPERSISTCOMPLETE'),
('e95eb987-0831-43f7-906e-a2abc014df9c', '918892452332', '', '', 0, '2017-12-27 21:28:20', '2017-12-27 15:58:20', 1, '', 'text', '918892452332', 'llllllklkk', 'lllllllllk', 'klllllllllll', '', 0, 'DBPERSISTCOMPLETE'),
('e97b8308-c66d-4791-942e-c4b78fce49e0', '918151913741', '', '', 0, '2017-12-14 20:52:16', '2017-12-14 15:22:16', 1, '', 'text', '918151913741', '#we you', 'y', 't', '', 0, 'DBPERSISTCOMPLETE'),
('e9b5b286-71eb-40de-8bbf-e5278e822afd', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/e9b5b28671eb40de8bbfe5278e822afd.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/18544295551d44ec95ffc4b10ce0e15f.png', 2107842, '2018-01-16 14:24:16', '2018-01-16 08:54:16', 1, '13.5 seconds', 'video/mp4', '911578934645', 'NL1', 'kjhk', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/e9b5b28671eb40de8bbfe5278e822afd.m3u8', 0, 'DBPERSISTCOMPLETE'),
('ef91642e-09f9-4643-9736-fce94dfdf247', '919035299524', '76fba5bd-eae6-4f36-a275-f5cc80afbbdd/content/ef91642e09f946439736fce94dfdf247.mp4', '76fba5bd-eae6-4f36-a275-f5cc80afbbdd/thumbnails/3f897bbc55a04458aa6d4ce6aa315d96.png', 4925974, '2017-11-17 16:10:15', '2017-11-17 10:40:15', 1, '67.5 seconds', 'video/mp4', '919035299524', 'Husband', 'hi', '', NULL, NULL, NULL),
('efaa4234-5c4b-44e2-bbf8-d4c593158e28', '91984632598', 'e992f360-d32b-4f4a-840c-3c3e9fcb0163/content/efaa42345c4b44e2bbf8d4c593158e28.jpg', 'e992f360-d32b-4f4a-840c-3c3e9fcb0163/thumbnails/c4aa4e01a7584cd5a3014aab732d2c3d.png', 9287, '2018-01-22 14:01:34', '2018-01-22 08:31:34', 1, '', 'image/jpeg', '91984632598', 'gren ', 'grennn', '', '', 0, 'DBPERSISTCOMPLETE'),
('f1867632-b625-405d-aa29-cdd7448d4577', '919035299524', '76fba5bd-eae6-4f36-a275-f5cc80afbbdd/content/f1867632b625405daa29cdd7448d4577.jpg', '76fba5bd-eae6-4f36-a275-f5cc80afbbdd/thumbnails/a5c65e75831c471e88088fb08ae6fc53.png', 8961, '2017-11-17 15:46:55', '2017-11-17 10:16:55', 1, '', 'image/jpeg', '919035299524', 'skype', 'skype', '', NULL, NULL, NULL),
('f24fc7ef-b76e-4740-87a4-8035802b1620', '919528096314', 'bfac94df-2063-496c-871c-3618c446a199/content/f24fc7efb76e474087a48035802b1620.aac', '', 4361987, '2017-11-17 12:34:42', '2017-11-17 07:23:55', 0, '', 'audio/x-aac', '919528096314', 'vBab', NULL, '', NULL, NULL, NULL),
('f2f36ea6-9ac0-41b4-a2de-17b1f437662a', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/f2f36ea69ac041b4a2de17b1f437662a.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/a8201124f386476ba3704ff30076685c.png', 2107842, '2018-01-16 16:05:18', '2018-01-16 10:35:18', 1, '13.5 seconds', 'video/mp4', '911578934645', 'hgghgh', '', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/f2f36ea69ac041b4a2de17b1f437662a.m3u8', 0, 'DBPERSISTCOMPLETE'),
('f3733ac7-d129-42ee-9c59-54c80e24c199', '911578934645', '', '', 0, '2018-01-16 11:18:01', '2018-01-16 05:48:01', 1, '', 'text', '911578934645', 'test16', 'hjgjg', 'hjgjg', '', 0, 'DBPERSISTCOMPLETE'),
('f4fce630-a2bd-4707-8828-842c78471a28', '9112300012300', '', '', 0, '2017-12-14 16:55:47', '2017-12-14 11:25:47', 1, '', 'text', '9112300012300', 'helloooo helo', NULL, 'he d f g s g s g s g', '', 0, 'DBPERSISTCOMPLETE'),
('f5657bd7-49b1-421f-bb03-52b424c8edf8', '91963852741', '', '', 0, '2018-01-10 10:38:40', '2018-01-10 05:08:40', 1, '', 'text', '91963852741', 'jj', 'jh', 'jh', '', 0, 'DBPERSISTCOMPLETE'),
('f65cbe84-1505-4cd1-8d26-bee2f0de315a', '911234567890', 'ba209dc4-ccf9-4feb-ab67-b641782ccb75/content/f65cbe8415054cd18d26bee2f0de315a.mp4', 'ba209dc4-ccf9-4feb-ab67-b641782ccb75/thumbnails/59aae7e1263c4dcabb7d751e6320e411.png', 240727, '2017-11-16 19:54:43', '2017-11-16 14:24:43', 1, '5.62 seconds', 'video/mp4', '911234567890', 'test channel create', 'gvgfjgfjhfjhf', '', NULL, NULL, NULL),
('f6baa846-ce3b-4a5b-9671-e042180a898b', '918892452332', '', '', 0, '2017-12-18 15:54:56', '2017-12-18 10:24:56', 1, '', '', '918892452332', 'new content title one', 'new description one', '', '', 0, 'DBPERSISTCOMPLETE'),
('f6bb64c1-fd8a-41f8-9127-d51641860fc2', '919035299524', '76fba5bd-eae6-4f36-a275-f5cc80afbbdd/content/f6bb64c1fd8a41f89127d51641860fc2.mp4', '76fba5bd-eae6-4f36-a275-f5cc80afbbdd/thumbnails/f08e524dc4484b33b0c4fc9b30375bc8.png', 4925974, '2017-11-17 16:22:55', '2017-11-30 13:03:52', 0, '67.5 seconds', 'video/mp4', '919035299524', 'Husband and wife', 'husband and wife\n', '', NULL, NULL, NULL),
('f6bde20e-6ada-4467-8098-1501435329d5', '91963852741', '8a472886-d9de-4f84-9e74-3916650ed19f/content/f6bde20e6ada446780981501435329d5.mp4', '8a472886-d9de-4f84-9e74-3916650ed19f/thumbnails/c4216856d4c2402d80fa0d0417b84e8a.png', 441879, '2018-01-10 15:59:15', '2018-01-10 10:29:15', 1, '5.29 seconds', 'video/mp4', '91963852741', 'Video Title', 'Video Title Desc', '', '8a472886-d9de-4f84-9e74-3916650ed19f/content/hls/f6bde20e6ada446780981501435329d5.m3u8', 0, 'DBPERSISTCOMPLETE');
INSERT INTO `content` (`content_id`, `content_user_id`, `content_path`, `content_thumbnail_path`, `content_size`, `created_date`, `modified_date`, `isactive`, `content_duration`, `content_type`, `modified_user_id`, `content_title`, `content_description`, `content_text`, `content_path_hls`, `status_code`, `status_desc`) VALUES
('f7192615-3cad-451d-bf04-949bcf7883aa', '914852697123', '6670e6d4-2692-48e9-ac61-ce13fde7e4f1/content/f71926153cad451dbf04949bcf7883aa.jpg', '6670e6d4-2692-48e9-ac61-ce13fde7e4f1/thumbnails/9402fea156ed4051a29de44288d38a86.png', 6067626, '2018-01-17 11:37:15', '2018-01-17 06:07:15', 1, '', 'image/jpeg', '914852697123', 'Test Image 1', 'Test Image 1', '', '', 0, 'DBPERSISTCOMPLETE'),
('f719262c-5c2a-4911-bf66-e06bd53095a1', '918105447982', '643ebad4-26d5-4ba9-9290-4a8d3ee2de2d/content/f719262c5c2a4911bf66e06bd53095a1.JPG', '643ebad4-26d5-4ba9-9290-4a8d3ee2de2d/thumbnails/286ebb7e4ba34ba0a6f477fa96414b67.png', 710052, '2017-12-18 18:19:44', '2017-12-18 12:50:33', 1, '', 'image/jpeg', '918105447982', 'groups 2', 'dgdfgdfg', 'dgdfgdfg', '', 0, 'DBPERSISTCOMPLETE'),
('f7bdd3d6-3f95-4750-800e-80762b3a6a58', '91712345698', '51cd92e4-c62c-4fcc-882f-c0942d5cddf3/content/f7bdd3d63f954750800e80762b3a6a58.mp3', '', 80602, '2018-01-09 12:30:54', '2018-01-09 07:00:54', 1, '2011.427734375 seconds', 'audio/mpeg', '91712345698', 'Test Audio', 'Test Audio goes here', '', '', 0, 'DBPERSISTCOMPLETE'),
('f84e1bc7-80a9-4b9a-a84f-0e95baae0ec6', '918892452332', '', '', 0, '2017-12-20 18:51:55', '2017-12-20 13:21:55', 1, '', 'text', '918892452332', '#jafferSadiq content', 'ghagshdhagg', 'hauahsisjshsj', '', 0, 'DBPERSISTCOMPLETE'),
('f9733ab6-68f4-4374-b144-85de970cb6a0', '919638527417', '3cc415c0-b3ed-4918-a606-e869eecba300/content/f9733ab668f44374b14485de970cb6a0.mp4', '3cc415c0-b3ed-4918-a606-e869eecba300/thumbnails/83dc37f3cb944496b48bc389a362a7f2.png', 441879, '2018-01-11 11:12:17', '2018-01-11 05:42:17', 1, '5.29 seconds', 'video/mp4', '919638527417', 'vvv', '', '', '3cc415c0-b3ed-4918-a606-e869eecba300/content/hls/f9733ab668f44374b14485de970cb6a0.m3u8', 0, 'DBPERSISTCOMPLETE'),
('f97f63fc-d2dd-4908-a39a-4a612ae716c6', '91712345698', '51cd92e4-c62c-4fcc-882f-c0942d5cddf3/content/f97f63fcd2dd4908a39a4a612ae716c6.jpg', '51cd92e4-c62c-4fcc-882f-c0942d5cddf3/thumbnails/f8175406f5704251b984ecb7dce7d4ac.png', 128183, '2018-01-09 12:30:06', '2018-01-09 07:00:06', 1, '', 'image/jpeg', '91712345698', 'Test Image', 'Test Image Desc goes here', '', '', 0, 'DBPERSISTCOMPLETE'),
('f99ce6a4-a514-4423-8d23-5a2f4f616f20', '855642123138', 'e091aad4-0da5-4954-8059-4a333cc388ce/content/f99ce6a4a51444238d235a2f4f616f20.mp4', 'e091aad4-0da5-4954-8059-4a333cc388ce/thumbnails/e0ff5017fd03497fb2ca05794cb1067f.png', 441879, '2018-01-18 18:35:14', '2018-01-18 13:05:14', 1, '5.29 seconds', 'video/mp4', '855642123138', 'srisri', 'srisri', '', 'e091aad4-0da5-4954-8059-4a333cc388ce/content/hls/f99ce6a4a51444238d235a2f4f616f20.m3u8', 0, 'DBPERSISTCOMPLETE'),
('fa1a69d5-f3eb-4ead-89fb-e23c88cbabd5', '919528096314', '', '', 0, '2017-11-17 12:53:36', '2017-11-17 07:23:45', 0, '', 'text', '919528096314', 'bqjq', 'yqhqiwmz.,', 'bNssb', NULL, NULL, NULL),
('fa720abb-0d68-483a-8d57-f1ee70176004', '911578934645', '', '', 0, '2018-01-16 10:49:07', '2018-01-16 05:19:07', 1, '', 'text', '911578934645', 'kk', 'lkj', 'lkj', '', 0, 'DBPERSISTCOMPLETE'),
('fa7fb744-1346-4076-b8ab-45110ea91df1', '919638527417', '3cc415c0-b3ed-4918-a606-e869eecba300/content/fa7fb74413464076b8ab45110ea91df1.mp4', '3cc415c0-b3ed-4918-a606-e869eecba300/thumbnails/5af4569ddc86402b93f1bb3a2af2a885.png', 441879, '2018-01-11 11:08:05', '2018-01-11 05:38:05', 1, '5.29 seconds', 'video/mp4', '919638527417', 'v1', 'v1', '', '3cc415c0-b3ed-4918-a606-e869eecba300/content/hls/fa7fb74413464076b8ab45110ea91df1.m3u8', 0, 'DBPERSISTCOMPLETE'),
('fb52c73a-a67d-4629-8b9e-6de5ea5e62d2', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/fb52c73aa67d46298b9e6de5ea5e62d2.jpg', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/40d3a13c40104bb082154188956e552b.png', 6067626, '2018-01-16 11:18:28', '2018-01-16 05:48:28', 1, '', 'image/jpeg', '911578934645', 'test17', 'jkhgjkh', '', '', 0, 'DBPERSISTCOMPLETE'),
('fc6948c7-8e7c-4846-ac58-b7e067c75564', '911578934645', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/fc6948c78e7c4846ac58b7e067c75564.mp4', 'cfc8f902-e546-4f25-bc5c-8898965e4210/thumbnails/a6a73f4992434ae58ec3902912dec043.png', 2107842, '2018-01-16 15:03:11', '2018-01-16 09:33:11', 1, '13.5 seconds', 'video/mp4', '911578934645', 'hgfhjg', ';lk;lkjhghjgjh', '', 'cfc8f902-e546-4f25-bc5c-8898965e4210/content/hls/fc6948c78e7c4846ac58b7e067c75564.m3u8', 0, 'DBPERSISTCOMPLETE'),
('ffc0e5ac-4a75-4c32-b198-0f2f1982c420', '918105447982', '643ebad4-26d5-4ba9-9290-4a8d3ee2de2d/content/ffc0e5ac4a754c32b1980f2f1982c420.mp3', '', 31163, '2017-11-17 18:05:28', '2017-11-17 12:35:28', 1, '', 'audio/mp4', '918105447982', 'Audio Testing', 'test', '', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `content_publish`
--

CREATE TABLE `content_publish` (
  `content_id` varchar(50) NOT NULL,
  `publisher_user_id` varchar(45) DEFAULT NULL,
  `published_date` datetime DEFAULT NULL,
  `isPublished` tinyint(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `content_publish`
--

INSERT INTO `content_publish` (`content_id`, `publisher_user_id`, `published_date`, `isPublished`) VALUES
('0260d5e5-7231-4c0b-a83c-73bff4aa4522', '91987156843', '2018-01-15 12:30:19', 1),
('09312597-3c06-4168-8c68-128b24bd63c4', '99786785657', '2018-01-23 12:21:39', 1),
('187f6a08-74d6-4899-af36-3150db394d9f', '917894592836', '2018-01-17 07:39:14', 1),
('1ad9ee11-cb40-4753-a454-7d3941beb423', '095757577744', '0000-00-00 00:00:00', 1),
('1b361238-7753-4bf7-afd2-bc9a545516e0', '91987156843', '2018-01-15 12:33:06', 1),
('2d00ca0d-1091-4edf-b62e-0f3cdf43025f', '91154632589', '2018-01-23 11:11:51', 1),
('2d1a8d16-05b7-4858-baea-2305d8250c8c', '917894592836', '2018-01-17 13:30:07', 0),
('32de9606-d0f5-417e-9e6f-47094da0865b', '917894592836', '2018-01-17 13:37:03', 1),
('3c21eb87-fdf8-4581-b21e-fdf6a9c70ea9', '99786785657', '2018-01-22 11:23:49', 1),
('44526186-270f-413c-a1e9-cfc7e0333e2d', '99786785657', '2018-01-22 11:32:16', 1),
('46a09c07-e0ba-43e7-8204-8d9d253a8ead', '91154632589', '2018-01-18 12:17:32', 0),
('593fbe60-00df-4e30-a7c5-19efecf83153', '91154632589', '2018-01-18 05:25:21', 1),
('5d59f3ec-3a8e-432e-9fd4-8a16a83b6392', '91159789123', '2018-01-12 07:49:34', 1),
('64f633b2-52f4-4b0d-8545-4464358c7af7', '919638527417', '0000-00-00 00:00:00', 1),
('6cc5a93d-3d21-4f41-ac93-fe6483517898', '91154632589', '2018-01-19 05:55:07', 1),
('9a0941ca-a615-424f-82cb-a75b2a233fb2', '99786785657', '2018-02-01 10:40:45', 1),
('9f83cd39-b087-4918-a549-456bed0af699', '9198745698785', '2018-02-05 07:38:07', 1),
(':contentId', '99786785657', '2018-01-22 11:13:37', 1),
('af202296-814a-4774-b93d-0cf569dfa068', '91159789123', '2018-01-12 11:39:46', 1),
('be87f5c7-6b2e-4cb7-9f74-bd4e1cabaa20', '91159789123', '2018-01-12 11:53:24', 0),
('c2c4f462-ac4b-4cb4-b80a-be82da8dbd65', '91154632589', '2018-01-19 05:54:03', 1),
('c728cb44-e325-4097-87e5-c7633321f65f', '91159789123', '2018-01-12 11:43:59', 0),
('efaa4234-5c4b-44e2-bbf8-d4c593158e28', '99786785657', '2018-01-29 10:01:34', 1),
('f7192615-3cad-451d-bf04-949bcf7883aa', '917894592836', '2018-01-17 07:39:46', 0),
('f99ce6a4-a514-4423-8d23-5a2f4f616f20', '91154632589', '2018-01-18 13:16:51', 0);

-- --------------------------------------------------------

--
-- Table structure for table `content_views`
--

CREATE TABLE `content_views` (
  `view_id` varchar(50) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `content_id` varchar(50) NOT NULL,
  `created_date` datetime NOT NULL,
  `isactive` tinyint(1) NOT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `content_views`
--

INSERT INTO `content_views` (`view_id`, `user_id`, `content_id`, `created_date`, `isactive`, `modified_date`) VALUES
('70e85d63-c193-4310-a794-f13c5c4439e3', '919164476296', '08ab6f21-9822-47eb-b0a4-d3ecdb247e2a', '2017-12-08 07:15:06', 1, '2017-12-08 07:15:06'),
('6f877d9e-a588-4d61-a9a6-834230eb0cb7', '918151913741', 'ac8f8928-f3a0-46a8-8c24-be9a5f99fe54', '2017-12-08 11:39:04', 1, '2017-12-08 11:39:04'),
('1b6a1e61-f05f-4b59-851c-d50de5a981e8', '918151913741', 'ac8f8928-f3a0-46a8-8c24-be9a5f99fe54', '2017-12-08 11:39:04', 1, '2017-12-08 11:39:04'),
('89e172b5-e5fd-49bc-847b-d8fc3e549dae', '918892452332', '21bd7bc7-6181-4081-8807-73e4a91f82fc', '2017-12-18 10:33:13', 1, '2017-12-18 10:33:13'),
('bd2c8323-6b9b-4cfc-b2cd-c149f22ec381', '918105447982', '35e23e3d-78d3-484d-9559-d1cc04c4cd8c', '2017-12-18 10:59:19', 1, '2017-12-18 10:59:19'),
('04753792-37f0-4860-87e7-1fda10df3ffe', '918105447982', '35e23e3d-78d3-484d-9559-d1cc04c4cd8c', '2017-12-18 11:04:34', 1, '2017-12-18 11:04:34'),
('8f39d36f-fcb2-4264-a639-2d3eb23098ec', '918105447982', '35e23e3d-78d3-484d-9559-d1cc04c4cd8c', '2017-12-18 11:04:40', 1, '2017-12-18 11:04:40'),
('de6fdd40-919e-4c6f-93c5-0c12abfd9976', '918105447982', '35e23e3d-78d3-484d-9559-d1cc04c4cd8c', '2017-12-18 11:09:36', 1, '2017-12-18 11:09:36'),
('06f23805-8ccd-4e00-b022-1242c2ae88df', '918105447982', '35e23e3d-78d3-484d-9559-d1cc04c4cd8c', '2017-12-18 11:09:54', 1, '2017-12-18 11:09:54'),
('d1dda124-fcb0-440e-8d65-106f76b88a69', '918105447982', '35e23e3d-78d3-484d-9559-d1cc04c4cd8c', '2017-12-18 11:14:56', 1, '2017-12-18 11:14:56'),
('d6e721b8-42a5-4be5-a34e-9d1735c41ac3', '918151913741', '2ddb1ca3-05b4-45e8-918f-6019790f24e5', '2017-12-18 12:09:41', 1, '2017-12-18 12:09:41'),
('4bdf6520-d753-4547-8b72-5bb3e60c5e7f', '918105447982', '35e23e3d-78d3-484d-9559-d1cc04c4cd8c', '2017-12-18 12:47:57', 1, '2017-12-18 12:47:57'),
('7c92d5da-d0cd-413d-9c19-4b67d041d8d3', '918105447982', '35e23e3d-78d3-484d-9559-d1cc04c4cd8c', '2017-12-18 12:48:07', 1, '2017-12-18 12:48:07'),
('89ffcf4c-fae5-4602-8219-8a147f917367', '918105447982', 'f719262c-5c2a-4911-bf66-e06bd53095a1', '2017-12-18 12:49:48', 1, '2017-12-18 12:49:48'),
('c0ed839d-9613-4e03-a9d3-7976c7ac733a', '918105447982', 'f719262c-5c2a-4911-bf66-e06bd53095a1', '2017-12-18 12:50:35', 1, '2017-12-18 12:50:35'),
('5ceaa473-bf9c-47ba-a141-f02bda0ab797', '918105447982', 'f719262c-5c2a-4911-bf66-e06bd53095a1', '2017-12-18 12:50:51', 1, '2017-12-18 12:50:51'),
('60a67c66-bc18-4add-bfee-4a20ead10ce2', '918105447982', 'f719262c-5c2a-4911-bf66-e06bd53095a1', '2017-12-18 12:52:22', 1, '2017-12-18 12:52:22'),
('c571c12c-771f-4ff6-aa98-c68ffe0830a7', '918105447982', 'f719262c-5c2a-4911-bf66-e06bd53095a1', '2017-12-18 12:53:19', 1, '2017-12-18 12:53:19'),
('40151938-edd3-439e-b050-5ed66fa6adaa', '918105447982', 'f719262c-5c2a-4911-bf66-e06bd53095a1', '2017-12-18 12:53:59', 1, '2017-12-18 12:53:59'),
('240143c7-aae7-46a4-b364-6900e3c8198b', '918105447982', '59534722-7747-48ed-8c66-313eec553133', '2017-12-18 12:54:48', 1, '2017-12-18 12:54:48'),
('2125ac81-ad45-43b7-acc9-294084dcc6e0', '918151913741', '70d49999-a4b7-4ef6-8510-cdcd1ed46bd7', '2017-12-18 12:55:31', 1, '2017-12-18 12:55:31'),
('e71c2068-fa2a-4abc-8fa7-b1ad92ee154d', '918105447982', '59534722-7747-48ed-8c66-313eec553133', '2017-12-18 12:55:35', 1, '2017-12-18 12:55:35'),
('cbfd251b-e515-4353-b1d5-14d7dce93a16', '918151913741', '25ce488d-067b-475a-a655-1323434f29f0', '2017-12-18 12:55:49', 1, '2017-12-18 12:55:49'),
('e99bad81-8add-4e0d-8cce-75dd48fc342d', '918151913741', '2ddb1ca3-05b4-45e8-918f-6019790f24e5', '2017-12-18 12:56:04', 1, '2017-12-18 12:56:04'),
('5f70f94e-417d-4d11-b62e-d41fb22da3e2', '918105447982', 'ccc81664-71a6-4143-a518-ef08ec18aa5a', '2017-12-18 12:56:52', 1, '2017-12-18 12:56:52'),
('8298015f-7d86-427e-9ae7-2298b1d2e279', '918105447982', 'ccc81664-71a6-4143-a518-ef08ec18aa5a', '2017-12-18 12:59:09', 1, '2017-12-18 12:59:09'),
('9e8241ef-798e-42a9-aea2-cc3d8df597d7', '918105447982', 'ccc81664-71a6-4143-a518-ef08ec18aa5a', '2017-12-18 13:01:08', 1, '2017-12-18 13:01:08'),
('082676d3-493f-4378-82a0-d49e816238fb', '918105447982', 'ccc81664-71a6-4143-a518-ef08ec18aa5a', '2017-12-18 13:01:29', 1, '2017-12-18 13:01:29'),
('3bf518d9-3c67-4e08-8f63-a4f8e8bb533f', '918105447982', 'ccc81664-71a6-4143-a518-ef08ec18aa5a', '2017-12-18 13:02:59', 1, '2017-12-18 13:02:59'),
('0bd50728-509b-4d09-9c99-2a47bb874876', '918105447982', 'ccc81664-71a6-4143-a518-ef08ec18aa5a', '2017-12-18 13:03:19', 1, '2017-12-18 13:03:19'),
('478a2da5-e681-49bc-8e29-08efde631dd2', '918105447982', 'ccc81664-71a6-4143-a518-ef08ec18aa5a', '2017-12-18 13:03:33', 1, '2017-12-18 13:03:33'),
('72f463a1-69e7-4b41-aff3-5309dd4c3608', '918105447982', 'ccc81664-71a6-4143-a518-ef08ec18aa5a', '2017-12-18 13:03:42', 1, '2017-12-18 13:03:42'),
('f22dd097-0cc8-449e-94bb-e3d55c97e0af', '918105447982', 'ccc81664-71a6-4143-a518-ef08ec18aa5a', '2017-12-18 13:03:49', 1, '2017-12-18 13:03:49'),
('a87c4d5e-5ef9-4b88-b348-89a569078ace', '918105447982', 'ccc81664-71a6-4143-a518-ef08ec18aa5a', '2017-12-18 13:03:59', 1, '2017-12-18 13:03:59'),
('34a4d3a8-4106-41e3-b674-1682eb75cb49', '918105447982', 'ccc81664-71a6-4143-a518-ef08ec18aa5a', '2017-12-18 13:04:06', 1, '2017-12-18 13:04:06'),
('eee7823d-6a23-4983-84a2-be99cb37b24d', '918105447982', 'ccc81664-71a6-4143-a518-ef08ec18aa5a', '2017-12-18 13:04:20', 1, '2017-12-18 13:04:20'),
('00e1d5bc-327b-430e-99f6-17ac1d23b888', '918151913741', 'e97b8308-c66d-4791-942e-c4b78fce49e0', '2017-12-18 13:13:27', 1, '2017-12-18 13:13:27'),
('5b843ed4-c295-4735-8e5c-a5245b050ab2', '918105447982', 'ccc81664-71a6-4143-a518-ef08ec18aa5a', '2017-12-18 13:33:11', 1, '2017-12-18 13:33:11'),
('005e6e49-2e69-41e6-a830-d573c2de7876', '918105447982', 'ccc81664-71a6-4143-a518-ef08ec18aa5a', '2017-12-18 13:46:20', 1, '2017-12-18 13:46:20'),
('bb474c9a-6230-41d0-b562-37a865422479', '918105447982', '8ea76aaa-518e-4050-8d64-853bca89985a', '2017-12-19 07:03:03', 1, '2017-12-19 07:03:03'),
('320c975c-32a9-40d3-b08e-28c3ce8e324e', '918105447982', '8ea76aaa-518e-4050-8d64-853bca89985a', '2017-12-19 07:03:17', 1, '2017-12-19 07:03:17'),
('42c03e60-f461-46c0-8be0-9f1721c9a633', '918151913741', '70d49999-a4b7-4ef6-8510-cdcd1ed46bd7', '2017-12-19 07:03:43', 1, '2017-12-19 07:03:43'),
('7c7487f5-3224-47ba-8a83-8334fd7589bd', '918151913741', 'e97b8308-c66d-4791-942e-c4b78fce49e0', '2017-12-19 07:03:48', 1, '2017-12-19 07:03:48'),
('7b8d84a0-e3e4-4b78-be9d-bda8d36d5cc1', '918151913741', '70d49999-a4b7-4ef6-8510-cdcd1ed46bd7', '2017-12-19 07:27:33', 1, '2017-12-19 07:27:33'),
('8a4874bf-4a00-4d14-a559-fcc2b6ac7d41', '918151913741', '25ce488d-067b-475a-a655-1323434f29f0', '2017-12-19 07:29:58', 1, '2017-12-19 07:29:58'),
('bb7799a8-4cd6-42d0-bb2d-133f47d543d6', '918151913741', 'e97b8308-c66d-4791-942e-c4b78fce49e0', '2017-12-19 07:33:39', 1, '2017-12-19 07:33:39'),
('e733ca2f-f85d-4901-aabe-1c1cb6f089bd', '918151913741', '3c21eb87-fdf8-4581-b21e-fdf6a9c70ea9', '2017-12-19 07:34:07', 1, '2017-12-19 07:34:07'),
('2197573d-2721-4a78-8c9e-125f47b02b81', '918151913741', '3c21eb87-fdf8-4581-b21e-fdf6a9c70ea9', '2017-12-19 07:35:37', 1, '2017-12-19 07:35:37'),
('d3e0a4cb-6b9d-4cd2-aaf0-ef046a603980', '918151913741', '3c21eb87-fdf8-4581-b21e-fdf6a9c70ea9', '2017-12-19 08:33:57', 1, '2017-12-19 08:33:57'),
('17dab4f4-de97-4fd5-8f76-7f985d50211d', '918151913741', '3c21eb87-fdf8-4581-b21e-fdf6a9c70ea9', '2017-12-19 08:34:22', 1, '2017-12-19 08:34:22'),
('2043ced6-457a-47fc-bd19-2bc918d1812b', '918151913741', '25ce488d-067b-475a-a655-1323434f29f0', '2017-12-19 08:34:45', 1, '2017-12-19 08:34:45'),
('9db2fbbe-6a16-45c1-809d-a9997f886ba9', '918151913741', '3c21eb87-fdf8-4581-b21e-fdf6a9c70ea9', '2017-12-19 08:36:48', 1, '2017-12-19 08:36:48'),
('17d0d62a-2072-4a93-8b4a-31e9cf277ab5', '918151913741', '44526186-270f-413c-a1e9-cfc7e0333e2d', '2017-12-19 08:38:54', 1, '2017-12-19 08:38:54'),
('b6e74476-2997-461f-be8e-bef47c13c96a', '918151913741', '44526186-270f-413c-a1e9-cfc7e0333e2d', '2017-12-19 08:39:10', 1, '2017-12-19 08:39:10'),
('c847e69f-7b9d-491e-b476-5e5ce104ef9d', '918151913741', '44526186-270f-413c-a1e9-cfc7e0333e2d', '2017-12-19 08:40:54', 1, '2017-12-19 08:40:54'),
('c49cb13e-9166-4d44-af4e-2a9bcb803b25', '918151913741', '8ccce5fa-b902-4497-b99f-db603c190db5', '2017-12-19 08:42:12', 1, '2017-12-19 08:42:12'),
('bd3d29ee-8e93-46b0-a169-1005e5291d10', '918151913741', '8ccce5fa-b902-4497-b99f-db603c190db5', '2017-12-19 08:48:41', 1, '2017-12-19 08:48:41'),
('c60ffe91-3b05-48ca-bc14-3fef5b6fd3d6', '918151913741', '8ccce5fa-b902-4497-b99f-db603c190db5', '2017-12-19 08:49:27', 1, '2017-12-19 08:49:27'),
('3b078efb-b9ee-438b-ba9b-f6d805d788c7', '918151913741', '8ccce5fa-b902-4497-b99f-db603c190db5', '2017-12-19 08:50:10', 1, '2017-12-19 08:50:10'),
('8b3b9fbd-9ade-4803-b19c-111e2d114a4e', '918151913741', '8ccce5fa-b902-4497-b99f-db603c190db5', '2017-12-19 08:51:25', 1, '2017-12-19 08:51:25'),
('c5c49a80-9901-49f7-92d9-183fc42d1a38', '918151913741', '25ce488d-067b-475a-a655-1323434f29f0', '2017-12-19 09:16:50', 1, '2017-12-19 09:16:50'),
('78a1309a-9000-4ce7-b35a-3a2708441fd0', '918151913741', '8ccce5fa-b902-4497-b99f-db603c190db5', '2017-12-19 09:20:41', 1, '2017-12-19 09:20:41'),
('d84053c7-bbb7-4c01-b8d7-93ee66a51dfa', '918151913741', '44526186-270f-413c-a1e9-cfc7e0333e2d', '2017-12-19 09:20:43', 1, '2017-12-19 09:20:43'),
('46e8ad53-f59f-4706-9123-1cb9c472ebbc', '918105447982', '3b709af5-e50d-4e67-b4e8-d7feb668d2d8', '2017-12-19 09:26:25', 1, '2017-12-19 09:26:25'),
('4e5586ab-dd7e-4b26-9401-95bbe6f31ac5', '918105447982', '3b709af5-e50d-4e67-b4e8-d7feb668d2d8', '2017-12-19 09:26:39', 1, '2017-12-19 09:26:39'),
('d0344479-2f16-43d5-bf93-f5bde97ef426', '918105447982', '3b709af5-e50d-4e67-b4e8-d7feb668d2d8', '2017-12-19 09:26:52', 1, '2017-12-19 09:26:52'),
('d6931d31-410f-420e-b69d-9b44695fcfba', '918105447982', '3b709af5-e50d-4e67-b4e8-d7feb668d2d8', '2017-12-19 09:27:36', 1, '2017-12-19 09:27:36'),
('cb8d0f67-4769-48d1-980e-ab6c450f0065', '918105447982', '3b709af5-e50d-4e67-b4e8-d7feb668d2d8', '2017-12-19 09:28:38', 1, '2017-12-19 09:28:38'),
('964dce41-ec82-4dad-851a-331315f069f6', '918151913741', '8ccce5fa-b902-4497-b99f-db603c190db5', '2017-12-19 09:32:48', 1, '2017-12-19 09:32:48'),
('8d524d96-6169-4618-be7e-4ce60e4c3877', '918151913741', '8ccce5fa-b902-4497-b99f-db603c190db5', '2017-12-19 09:33:15', 1, '2017-12-19 09:33:15'),
('2fe1d5d3-3c94-475e-9103-dadcb4c6fb5e', '918151913741', '8ccce5fa-b902-4497-b99f-db603c190db5', '2017-12-19 09:33:22', 1, '2017-12-19 09:33:22'),
('605d5368-ff92-4076-b447-7ef11af98e7a', '918151913741', '8ccce5fa-b902-4497-b99f-db603c190db5', '2017-12-19 09:33:32', 1, '2017-12-19 09:33:32'),
('3c313160-38c4-42f9-b6a3-5574bbb4c47e', '918151913741', '8ccce5fa-b902-4497-b99f-db603c190db5', '2017-12-19 09:33:45', 1, '2017-12-19 09:33:45'),
('a3ab542c-66fa-4551-9d77-6748b40c4e22', '918151913741', '8ccce5fa-b902-4497-b99f-db603c190db5', '2017-12-19 09:33:48', 1, '2017-12-19 09:33:48'),
('d59ef901-835c-4818-84ac-da26dcf00915', '918151913741', '8ccce5fa-b902-4497-b99f-db603c190db5', '2017-12-19 09:34:02', 1, '2017-12-19 09:34:02'),
('fe954de0-c800-4876-a191-321b654e6d00', '918151913741', '8ccce5fa-b902-4497-b99f-db603c190db5', '2017-12-19 09:34:05', 1, '2017-12-19 09:34:05'),
('a5358aa5-7311-43f7-8719-f6518ea42371', '918151913741', '44526186-270f-413c-a1e9-cfc7e0333e2d', '2017-12-19 09:34:19', 1, '2017-12-19 09:34:19'),
('478a330c-d3e0-4a98-bed0-81431987cdfd', '918151913741', '44526186-270f-413c-a1e9-cfc7e0333e2d', '2017-12-19 09:34:21', 1, '2017-12-19 09:34:21'),
('6fa161e7-ed09-413d-943b-21937d527eff', '918151913741', '44526186-270f-413c-a1e9-cfc7e0333e2d', '2017-12-19 09:34:33', 1, '2017-12-19 09:34:33'),
('5c84dff1-caa0-468c-88d1-93e97b50343a', '918151913741', '44526186-270f-413c-a1e9-cfc7e0333e2d', '2017-12-19 09:34:37', 1, '2017-12-19 09:34:37'),
('c4c69e4b-63ae-42ca-90a4-257ae544657c', '918151913741', '44526186-270f-413c-a1e9-cfc7e0333e2d', '2017-12-19 10:37:34', 1, '2017-12-19 10:37:34'),
('b24861cc-0400-442b-85bb-19b32a7f24f6', '918151913741', '44526186-270f-413c-a1e9-cfc7e0333e2d', '2017-12-19 10:37:51', 1, '2017-12-19 10:37:51'),
('29b06484-1780-40c6-a296-6b6fae4b6af2', '918151913741', '44526186-270f-413c-a1e9-cfc7e0333e2d', '2017-12-19 10:44:11', 1, '2017-12-19 10:44:11'),
('f2a3161c-3309-4ae5-8a74-655cbde4adab', '918151913741', '44526186-270f-413c-a1e9-cfc7e0333e2d', '2017-12-19 10:44:26', 1, '2017-12-19 10:44:26'),
('5943521f-d54f-48f1-b58d-44076abbd9ef', '918151913741', '44526186-270f-413c-a1e9-cfc7e0333e2d', '2017-12-19 10:45:24', 1, '2017-12-19 10:45:24'),
('4bb3fc95-8434-455a-af3c-cc3e48eeddea', '918151913741', '44526186-270f-413c-a1e9-cfc7e0333e2d', '2017-12-19 10:45:28', 1, '2017-12-19 10:45:28'),
('53fd59ec-1c84-4ef3-8e76-26b1e16f1cb7', '918151913741', '44526186-270f-413c-a1e9-cfc7e0333e2d', '2017-12-19 10:45:32', 1, '2017-12-19 10:45:32'),
('56b6b644-507a-4022-8a48-3f5dbab67191', '918151913741', '44526186-270f-413c-a1e9-cfc7e0333e2d', '2017-12-19 10:46:16', 1, '2017-12-19 10:46:16'),
('fad6b3cc-9312-4227-abb1-782e6eb542e0', '918151913741', '44526186-270f-413c-a1e9-cfc7e0333e2d', '2017-12-19 10:46:40', 1, '2017-12-19 10:46:40'),
('4396b7f3-0fa0-41ea-a86e-c7c8ea6d4b29', '918151913741', '2ddb1ca3-05b4-45e8-918f-6019790f24e5', '2017-12-19 10:47:48', 1, '2017-12-19 10:47:48'),
('fc6443c6-5966-4493-8a09-b9099fd91609', '918151913741', '44526186-270f-413c-a1e9-cfc7e0333e2d', '2017-12-19 10:48:06', 1, '2017-12-19 10:48:06'),
('b1f8d000-e27e-45e8-8189-996b952c4bc3', '918151913741', '44526186-270f-413c-a1e9-cfc7e0333e2d', '2017-12-19 10:48:20', 1, '2017-12-19 10:48:20'),
('c6b7adde-e172-4b91-8fed-bd8cfb6c13cb', '918151913741', '70d49999-a4b7-4ef6-8510-cdcd1ed46bd7', '2017-12-19 10:48:45', 1, '2017-12-19 10:48:45'),
('71393c73-c31c-4eb4-aee9-6135df56ee06', '918151913741', '70d49999-a4b7-4ef6-8510-cdcd1ed46bd7', '2017-12-19 10:49:03', 1, '2017-12-19 10:49:03'),
('5c3caca2-dc71-4c64-ae96-33784d5bb71a', '918151913741', '70d49999-a4b7-4ef6-8510-cdcd1ed46bd7', '2017-12-19 10:49:29', 1, '2017-12-19 10:49:29'),
('327012d2-7c9b-4825-a796-8ebc669a5cd1', '918151913741', '44526186-270f-413c-a1e9-cfc7e0333e2d', '2017-12-19 10:49:32', 1, '2017-12-19 10:49:32'),
('633eae4d-d64d-41bb-92bb-6cf58abde846', '918151913741', '44526186-270f-413c-a1e9-cfc7e0333e2d', '2017-12-19 10:50:12', 1, '2017-12-19 10:50:12'),
('06fcfddc-1132-4655-878a-985e26307432', '918151913741', '44526186-270f-413c-a1e9-cfc7e0333e2d', '2017-12-19 10:50:32', 1, '2017-12-19 10:50:32'),
('afbb84dc-8828-476f-9cb2-06b0597011d7', '918151913741', '44526186-270f-413c-a1e9-cfc7e0333e2d', '2017-12-19 10:51:17', 1, '2017-12-19 10:51:17'),
('304b31e1-bf32-4ede-8030-d0a3a5289074', '918151913741', 'a80d8590-a270-43e2-933f-bed14683e04d', '2017-12-19 10:51:55', 1, '2017-12-19 10:51:55'),
('0925dbe4-f2f5-400c-88c8-752fef40ebb7', '918151913741', '44526186-270f-413c-a1e9-cfc7e0333e2d', '2017-12-19 10:52:09', 1, '2017-12-19 10:52:09'),
('7179139b-5249-4778-9481-07ad990209a7', '918151913741', '44526186-270f-413c-a1e9-cfc7e0333e2d', '2017-12-19 10:52:22', 1, '2017-12-19 10:52:22'),
('9e11ec3b-cda5-4c99-a8c3-3bce3ff996da', '918151913741', '70d49999-a4b7-4ef6-8510-cdcd1ed46bd7', '2017-12-19 10:53:37', 1, '2017-12-19 10:53:37'),
('0fa20cd9-27ce-4f9e-b418-2d4f90fde924', '918151913741', '25ce488d-067b-475a-a655-1323434f29f0', '2017-12-19 11:09:02', 1, '2017-12-19 11:09:02'),
('971abfb1-20e9-4faf-bbfd-501bf7f991aa', '918151913741', '42fab386-43dc-4a36-8de1-945487819268', '2017-12-19 11:11:46', 1, '2017-12-19 11:11:46'),
('9c2b27da-d1c2-4ac1-92b1-ec11b6e254ca', '918151913741', '2ddb1ca3-05b4-45e8-918f-6019790f24e5', '2017-12-19 11:13:06', 1, '2017-12-19 11:13:06'),
('f097ee14-7dbe-4088-b3f3-2f0e37cbf137', '918151913741', '25ce488d-067b-475a-a655-1323434f29f0', '2017-12-19 11:13:26', 1, '2017-12-19 11:13:26'),
('4a6e4c47-4a86-40dc-bb71-6845250c331b', '918151913741', '25ce488d-067b-475a-a655-1323434f29f0', '2017-12-19 11:14:51', 1, '2017-12-19 11:14:51'),
('c6ba35af-f263-4c00-90df-a26e9f34974d', '918151913741', '60cf6d36-ab54-4720-a31f-c4d244c46bba', '2017-12-19 11:21:23', 1, '2017-12-19 11:21:23'),
('c202b895-7dd4-4b8d-a825-c4b2b53e5133', '918151913741', 'a80d8590-a270-43e2-933f-bed14683e04d', '2017-12-19 11:21:34', 1, '2017-12-19 11:21:34'),
('6bd7ae57-b46b-4f30-88d3-ee501a0a003b', '918151913741', '44526186-270f-413c-a1e9-cfc7e0333e2d', '2017-12-19 11:21:40', 1, '2017-12-19 11:21:40'),
('e40b0b6d-47c4-4e7b-8d19-c57cc37166d0', '918151913741', '93b34e67-f2cd-4315-b3e8-73a3bbb9174c', '2017-12-19 11:21:58', 1, '2017-12-19 11:21:58'),
('10dff1a2-01e7-4eec-9922-2a1ef352b5ea', '918151913741', '93b34e67-f2cd-4315-b3e8-73a3bbb9174c', '2017-12-19 11:21:58', 1, '2017-12-19 11:21:58'),
('c2da0cd3-32d0-4094-80e1-751f989ff9a9', '918151913741', '3c21eb87-fdf8-4581-b21e-fdf6a9c70ea9', '2017-12-19 11:29:47', 1, '2017-12-19 11:29:47'),
('96b078bc-56ea-4878-b494-76348cfe5c23', '918151913741', '44526186-270f-413c-a1e9-cfc7e0333e2d', '2017-12-19 11:34:00', 1, '2017-12-19 11:34:00'),
('ad323c1e-3a4a-4945-8f5c-a02818fb4e78', '918151913741', '25ce488d-067b-475a-a655-1323434f29f0', '2017-12-19 11:34:06', 1, '2017-12-19 11:34:06'),
('4d6a6f05-fdbd-4103-a7a1-71f4caa213ce', '918151913741', 'a80d8590-a270-43e2-933f-bed14683e04d', '2017-12-19 12:10:34', 1, '2017-12-19 12:10:34'),
('a8eb4139-adb9-4939-bb24-e1699f7da210', '918151913741', '44526186-270f-413c-a1e9-cfc7e0333e2d', '2017-12-19 12:12:06', 1, '2017-12-19 12:12:06'),
('463d2482-5df4-4375-a4b7-0e67710cae3b', '918151913741', '25ce488d-067b-475a-a655-1323434f29f0', '2017-12-19 12:12:29', 1, '2017-12-19 12:12:29'),
('12ac34de-f646-4249-ac00-9bb41ea833cc', '918151913741', '09312597-3c06-4168-8c68-128b24bd63c4', '2017-12-19 12:13:55', 1, '2017-12-19 12:13:55'),
('2cc3f373-8735-4af6-89e0-6a54b10a6ff5', '918151913741', '09312597-3c06-4168-8c68-128b24bd63c4', '2017-12-19 12:14:30', 1, '2017-12-19 12:14:30'),
('64d773c4-115e-4642-a441-f3c0602c1724', '918151913741', '09312597-3c06-4168-8c68-128b24bd63c4', '2017-12-19 12:14:53', 1, '2017-12-19 12:14:53'),
('64a31de8-5bda-448a-976a-9b3a93367b8d', '918151913741', '09312597-3c06-4168-8c68-128b24bd63c4', '2017-12-19 12:15:01', 1, '2017-12-19 12:15:01'),
('ec41c918-de6a-4617-838f-18c2f746a6c5', '918151913741', '09312597-3c06-4168-8c68-128b24bd63c4', '2017-12-19 12:15:27', 1, '2017-12-19 12:15:27'),
('ceed8fb2-a308-4205-b088-86a287604646', '918151913741', '3c21eb87-fdf8-4581-b21e-fdf6a9c70ea9', '2017-12-19 12:15:37', 1, '2017-12-19 12:15:37'),
('5c501370-f97e-45b2-bc8c-909106f67037', '918151913741', 'a80d8590-a270-43e2-933f-bed14683e04d', '2017-12-19 12:15:45', 1, '2017-12-19 12:15:45'),
('eba1681b-8e1e-42c9-b9e9-16fa95cf67c9', '918151913741', '44526186-270f-413c-a1e9-cfc7e0333e2d', '2017-12-19 12:17:09', 1, '2017-12-19 12:17:09'),
('7d1e267e-cfcd-4e47-900b-847447c57599', '918151913741', 'a80d8590-a270-43e2-933f-bed14683e04d', '2017-12-19 12:20:17', 1, '2017-12-19 12:20:17'),
('cbbe7c28-abb9-47da-849a-a512431cbd88', '918105447982', 'f719262c-5c2a-4911-bf66-e06bd53095a1', '2017-12-19 12:40:05', 1, '2017-12-19 12:40:05'),
('a536e087-c2d1-4fbb-9ea7-cf6b62c27ca9', '918105447982', 'f719262c-5c2a-4911-bf66-e06bd53095a1', '2017-12-19 12:40:09', 1, '2017-12-19 12:40:09'),
('3f40bdb5-a1ff-4b42-8c7f-8b0524b184cd', '918105447982', 'f719262c-5c2a-4911-bf66-e06bd53095a1', '2017-12-19 12:40:17', 1, '2017-12-19 12:40:17'),
('bf071b6c-cb32-45db-9656-bb81d40bd02b', '918151913741', '44526186-270f-413c-a1e9-cfc7e0333e2d', '2017-12-19 12:40:31', 1, '2017-12-19 12:40:31'),
('784d1878-1197-427e-8d67-8315ebf7e162', '918105447982', '3b709af5-e50d-4e67-b4e8-d7feb668d2d8', '2017-12-19 12:40:44', 1, '2017-12-19 12:40:44'),
('4188099b-2eb6-47fe-a29f-0935abcfb7f5', '918151913741', '44526186-270f-413c-a1e9-cfc7e0333e2d', '2017-12-19 12:40:46', 1, '2017-12-19 12:40:46'),
('e5c5cffb-0dbf-4d7b-afcf-a66b826f6022', '918105447982', '3b709af5-e50d-4e67-b4e8-d7feb668d2d8', '2017-12-19 12:40:48', 1, '2017-12-19 12:40:48'),
('5e134d6c-32dc-444e-a354-74e03c45845a', '918105447982', '3b709af5-e50d-4e67-b4e8-d7feb668d2d8', '2017-12-19 12:40:52', 1, '2017-12-19 12:40:52'),
('46e13608-c700-477f-8e14-6070310a21d8', '918151913741', '44526186-270f-413c-a1e9-cfc7e0333e2d', '2017-12-19 12:40:57', 1, '2017-12-19 12:40:57'),
('971181d6-3389-43ea-92fc-c4bc8777ca91', '918105447982', '35e23e3d-78d3-484d-9559-d1cc04c4cd8c', '2017-12-19 12:41:16', 1, '2017-12-19 12:41:16'),
('85e6851f-36e8-4fce-a8f2-3f4753626bdf', '918105447982', '35e23e3d-78d3-484d-9559-d1cc04c4cd8c', '2017-12-19 12:41:20', 1, '2017-12-19 12:41:20'),
('d8384df4-c0a6-4c60-a2f4-4253af8373ca', '918105447982', '35e23e3d-78d3-484d-9559-d1cc04c4cd8c', '2017-12-19 12:41:27', 1, '2017-12-19 12:41:27'),
('6d4bcb67-e1c3-471e-9990-5e94bddbb2eb', '918105447982', '35e23e3d-78d3-484d-9559-d1cc04c4cd8c', '2017-12-19 12:41:34', 1, '2017-12-19 12:41:34'),
('4887e12e-b1c1-4363-a37e-03f28506da3f', '918105447982', '3b709af5-e50d-4e67-b4e8-d7feb668d2d8', '2017-12-19 12:42:18', 1, '2017-12-19 12:42:18'),
('6a96abd8-b19c-4578-8a90-f927bab00d64', '918105447982', '3b709af5-e50d-4e67-b4e8-d7feb668d2d8', '2017-12-19 12:42:27', 1, '2017-12-19 12:42:27'),
('5390062b-a569-439c-babb-989d36de5b86', '918151913741', '60cf6d36-ab54-4720-a31f-c4d244c46bba', '2017-12-19 12:50:53', 1, '2017-12-19 12:50:53'),
('2394ce3e-79d4-44da-99b8-a4d29de6db03', '918151913741', '09312597-3c06-4168-8c68-128b24bd63c4', '2017-12-19 12:51:49', 1, '2017-12-19 12:51:49'),
('e8eec303-3a6b-40a4-973f-5c9eead2e241', '918151913741', '44526186-270f-413c-a1e9-cfc7e0333e2d', '2017-12-19 13:36:01', 1, '2017-12-19 13:36:01'),
('44b4c8ba-b7e4-465e-b0e0-f93caae2e8e5', '918151913741', 'a80d8590-a270-43e2-933f-bed14683e04d', '2017-12-19 13:36:27', 1, '2017-12-19 13:36:27'),
('a5c91a68-a1c0-4585-87b2-69651c44b4f6', '918151913741', '09312597-3c06-4168-8c68-128b24bd63c4', '2017-12-19 13:45:44', 1, '2017-12-19 13:45:44'),
('10fa95bd-e776-4137-9a4c-635b27885059', '918151913741', 'a80d8590-a270-43e2-933f-bed14683e04d', '2017-12-19 13:57:18', 1, '2017-12-19 13:57:18'),
('5b1774f3-76d9-43a8-ad05-a5cbc455bf82', '918151913741', '09312597-3c06-4168-8c68-128b24bd63c4', '2017-12-19 14:03:40', 1, '2017-12-19 14:03:40'),
('9b86278f-dabd-4dbf-b19d-4fdfe9e6af6b', '918151913741', '09312597-3c06-4168-8c68-128b24bd63c4', '2017-12-19 14:04:40', 1, '2017-12-19 14:04:40'),
('8dd8202c-415f-4995-b6f7-02152664692d', '918151913741', '09312597-3c06-4168-8c68-128b24bd63c4', '2017-12-19 14:04:52', 1, '2017-12-19 14:04:52'),
('d95373ce-49c4-45e4-a0db-8e056b86693d', '918151913741', '44526186-270f-413c-a1e9-cfc7e0333e2d', '2017-12-19 14:07:30', 1, '2017-12-19 14:07:30'),
('da756ec7-9e43-4660-8d03-6cdfcd52f89f', '918151913741', 'a80d8590-a270-43e2-933f-bed14683e04d', '2017-12-19 14:15:53', 1, '2017-12-19 14:15:53'),
('ba00d967-e817-444e-8dd5-3385a01d33a4', '918151913741', 'a80d8590-a270-43e2-933f-bed14683e04d', '2017-12-19 14:16:06', 1, '2017-12-19 14:16:06'),
('8da93bca-9139-4c17-97f3-d2d01fd13cfa', '918151913741', '70d49999-a4b7-4ef6-8510-cdcd1ed46bd7', '2017-12-19 14:16:21', 1, '2017-12-19 14:16:21'),
('0a57d4af-4105-4285-ba20-f7f23202af06', '918151913741', '70d49999-a4b7-4ef6-8510-cdcd1ed46bd7', '2017-12-19 14:16:31', 1, '2017-12-19 14:16:31'),
('e4c339d0-dfdf-4288-975e-ee99dabe93a3', '918151913741', '70d49999-a4b7-4ef6-8510-cdcd1ed46bd7', '2017-12-19 14:17:28', 1, '2017-12-19 14:17:28'),
('a22d6456-1f93-4e91-9fb1-4e6a8a7e4f58', '918151913741', 'a80d8590-a270-43e2-933f-bed14683e04d', '2017-12-19 14:31:12', 1, '2017-12-19 14:31:12'),
('496dbbca-2f58-4ce5-b21d-91f5ec118b4b', '918151913741', 'a80d8590-a270-43e2-933f-bed14683e04d', '2017-12-19 14:31:43', 1, '2017-12-19 14:31:43'),
('b3244ee4-1982-44ea-b164-20b4a02ac357', '918151913741', 'a80d8590-a270-43e2-933f-bed14683e04d', '2017-12-20 06:36:13', 1, '2017-12-20 06:36:13'),
('ce6784d6-2594-4cc2-beec-0750347cd588', '918151913741', 'a80d8590-a270-43e2-933f-bed14683e04d', '2017-12-20 07:00:45', 1, '2017-12-20 07:00:45'),
('637258a5-f7ef-400b-91f8-5d9740d3d44e', '918151913741', 'a80d8590-a270-43e2-933f-bed14683e04d', '2017-12-20 07:00:45', 1, '2017-12-20 07:00:45'),
('19b98d1e-3108-4b39-9825-53b7559fee57', '918151913741', '60cf6d36-ab54-4720-a31f-c4d244c46bba', '2017-12-20 07:21:11', 1, '2017-12-20 07:21:11'),
('d39e53a4-22ad-4dab-9a69-841cc9d947c3', '918151913741', 'a80d8590-a270-43e2-933f-bed14683e04d', '2017-12-20 07:27:13', 1, '2017-12-20 07:27:13'),
('8d051294-0c71-4794-bc7e-72af4f18bb04', '918105447982', '8ea76aaa-518e-4050-8d64-853bca89985a', '2017-12-20 10:11:20', 1, '2017-12-20 10:11:20'),
('af7abc85-b796-41e7-8dcc-19687011c91d', '918105447982', '8ea76aaa-518e-4050-8d64-853bca89985a', '2017-12-20 10:12:30', 1, '2017-12-20 10:12:30'),
('ad0e15f6-2917-4c37-b5aa-fbe019b20ca3', '918105447982', '8ea76aaa-518e-4050-8d64-853bca89985a', '2017-12-20 10:12:40', 1, '2017-12-20 10:12:40'),
('1a989561-fd0e-4247-9e43-4348a6ccf07f', '918105447982', '8ea76aaa-518e-4050-8d64-853bca89985a', '2017-12-20 10:43:01', 1, '2017-12-20 10:43:01'),
('05e329f1-baec-4941-98b3-47e765ec82a4', '918105447982', '8ea76aaa-518e-4050-8d64-853bca89985a', '2017-12-20 10:43:10', 1, '2017-12-20 10:43:10'),
('5a663e7a-8935-4565-8380-2329a4ce3122', '918105447982', '8ea76aaa-518e-4050-8d64-853bca89985a', '2017-12-20 10:43:20', 1, '2017-12-20 10:43:20'),
('a68cf7f5-dc1f-4cd1-b7c7-f743d657e27f', '918105447982', '8ea76aaa-518e-4050-8d64-853bca89985a', '2017-12-20 10:44:09', 1, '2017-12-20 10:44:09'),
('c7708d0c-8d26-4e79-b7ec-92fd9e22d689', '918105447982', '8ea76aaa-518e-4050-8d64-853bca89985a', '2017-12-20 10:44:20', 1, '2017-12-20 10:44:20'),
('f33c89c3-164c-4157-bc92-1a291a37daf7', '918105447982', '8ea76aaa-518e-4050-8d64-853bca89985a', '2017-12-20 11:07:32', 1, '2017-12-20 11:07:32'),
('9f6d612b-fce3-4a8c-b4ae-79a5ee839128', '918105447982', '8ea76aaa-518e-4050-8d64-853bca89985a', '2017-12-20 11:11:27', 1, '2017-12-20 11:11:27'),
('4eb2d9f9-7391-4714-aa49-c65296ec93ca', '918105447982', '8ea76aaa-518e-4050-8d64-853bca89985a', '2017-12-20 11:13:58', 1, '2017-12-20 11:13:58'),
('4cf6380b-c66e-4a02-9133-4fa4fd0ce75b', '918105447982', '8ea76aaa-518e-4050-8d64-853bca89985a', '2017-12-20 11:14:14', 1, '2017-12-20 11:14:14'),
('c0f0a2fa-7d68-4840-8a4d-5ec0ede5fe99', '918892452332', '74898d83-e230-4d33-b8f3-894c8362c380', '2017-12-20 12:02:44', 1, '2017-12-20 12:02:44'),
('159d6dc4-3f63-4e08-ac2e-aa1867e77d86', '918105447982', '3b709af5-e50d-4e67-b4e8-d7feb668d2d8', '2017-12-20 12:50:36', 1, '2017-12-20 12:50:36'),
('5fd869f8-3408-4fb3-80f0-d2f62bef42ad', '918105447982', '3b709af5-e50d-4e67-b4e8-d7feb668d2d8', '2017-12-20 12:51:58', 1, '2017-12-20 12:51:58'),
('0644251e-a2a8-45b6-a3f8-9e2b29d94715', '918892452332', '710c51c1-0084-4f30-a4f2-d9d3af55d30d', '2017-12-20 13:17:48', 1, '2017-12-20 13:17:48'),
('f1000865-e01d-41ec-bc03-9548ffa71e90', '918892452332', '710c51c1-0084-4f30-a4f2-d9d3af55d30d', '2017-12-20 13:17:54', 1, '2017-12-20 13:17:54'),
('c775c716-9353-47c5-a10d-10dead6d1af5', '918892452332', '74898d83-e230-4d33-b8f3-894c8362c380', '2017-12-20 13:22:02', 1, '2017-12-20 13:22:02'),
('9147b8b0-2e1e-409e-9ef5-072a331eb614', '918892452332', '21d6a2a0-cf7b-4ce9-b329-480a405849c1', '2017-12-20 15:45:44', 1, '2017-12-20 15:45:44'),
('7db70765-5efe-4919-8197-8ae56748a456', '918105447982', '74898d83-e230-4d33-b8f3-894c8362c380', '2017-12-21 08:27:27', 1, '2017-12-21 08:27:27'),
('ba102ddf-4f9c-4f09-926c-fa2b70c8a156', '918892452332', 'f84e1bc7-80a9-4b9a-a84f-0e95baae0ec6', '2017-12-21 09:23:26', 1, '2017-12-21 09:23:26'),
('64cf622e-df6c-4643-a03d-9b3277b3100d', '918151913741', '25ce488d-067b-475a-a655-1323434f29f0', '2017-12-21 09:37:49', 1, '2017-12-21 09:37:49'),
('0dd67095-be23-4ab3-8dbc-b6f64fee9423', '918151913741', '1c5fabde-ab3e-4182-a18a-1eb621089640', '2017-12-21 10:59:10', 1, '2017-12-21 10:59:10'),
('1042dc9c-40c8-4c7e-8008-8a1994d1582c', '918151913741', '2cd2a269-4957-472e-9501-fbfad5009a93', '2017-12-21 11:40:23', 1, '2017-12-21 11:40:23'),
('c6aa3535-8c48-499e-ab41-919b49d76198', '918632357734', '0349d105-e67b-4c3c-b887-1b1969124673', '2017-12-22 07:31:09', 1, '2017-12-22 07:31:09'),
('f91c974d-43ae-4421-9f34-5ce1b4879368', '918632357734', '0349d105-e67b-4c3c-b887-1b1969124673', '2017-12-22 07:31:14', 1, '2017-12-22 07:31:14'),
('0e405ac7-165a-494a-98c6-84104ca7d547', '918632357734', '2d00ca0d-1091-4edf-b62e-0f3cdf43025f', '2017-12-22 08:46:11', 1, '2017-12-22 08:46:11'),
('bc5f2728-858e-4c63-a50c-1eba786d4577', '918892452332', '75ec8475-eab4-4469-832c-b6745eb1dfbd', '2017-12-27 13:10:47', 1, '2017-12-27 13:10:47'),
('bb375deb-4fde-42cb-a178-8bb036ababa0', '918892452332', '75ec8475-eab4-4469-832c-b6745eb1dfbd', '2017-12-27 14:18:12', 1, '2017-12-27 14:18:12'),
('81490793-6385-4dc0-99ce-ff409ec67090', '918892452332', 'bce9d372-f621-466f-9ff0-d4d1688883e2', '2017-12-27 14:18:59', 1, '2017-12-27 14:18:59'),
('06a36801-ef75-4c73-9fd4-b591cd50eb87', '918892452332', 'bce9d372-f621-466f-9ff0-d4d1688883e2', '2017-12-27 14:20:18', 1, '2017-12-27 14:20:18'),
('dd98f781-2365-4b2d-b038-2d737d7e76ae', '918892452332', '54e9bdd1-2c35-41dc-aa89-c3a65d40280d', '2017-12-27 14:56:32', 1, '2017-12-27 14:56:32'),
('aa0cc970-aa83-4228-a489-3a4f0646cd73', '918892452332', 'e95eb987-0831-43f7-906e-a2abc014df9c', '2017-12-27 15:58:22', 1, '2017-12-27 15:58:22'),
('439d9d7a-7418-4aed-b278-4cad31fa7ec9', '918892452332', 'e95eb987-0831-43f7-906e-a2abc014df9c', '2017-12-27 15:58:31', 1, '2017-12-27 15:58:31'),
('cd0e850f-7a2f-4bed-a0e2-264356f4a509', '918892452332', 'e95eb987-0831-43f7-906e-a2abc014df9c', '2017-12-27 15:58:34', 1, '2017-12-27 15:58:34'),
('2864e95d-c91b-4441-9172-848bc758e5cc', '918892452332', 'e73fa937-e118-4088-98b6-a72bdf68b037', '2017-12-27 15:59:43', 1, '2017-12-27 15:59:43'),
('3c044a2b-aeee-4119-9a33-9f3906bddf75', '918892452332', '16134798-6f1a-4b16-b097-f92b9d73f710', '2017-12-27 16:01:14', 1, '2017-12-27 16:01:14'),
('1cdaa66c-5a20-45cb-800c-9e626560040a', '918892452332', '16134798-6f1a-4b16-b097-f92b9d73f710', '2017-12-27 16:01:26', 1, '2017-12-27 16:01:26'),
('8b091b89-9dd7-4734-9e49-a922dfdd01f2', '918892452332', '5f68742c-0e59-4c68-83b0-408e26833041', '2017-12-27 16:14:52', 1, '2017-12-27 16:14:52'),
('52243f5b-729f-479d-8ebd-a86e67dfbbf6', '918892452332', '5f68742c-0e59-4c68-83b0-408e26833041', '2017-12-27 16:16:24', 1, '2017-12-27 16:16:24'),
('88fa250f-3f51-4bd3-bfa7-c6aa5228a213', '919999988888', '34e51fa5-b24f-4404-9939-1043223ef5db', '2017-12-28 12:02:38', 1, '2017-12-28 12:02:38'),
('9cc91f4e-d7bf-4606-9a75-8317b3b9ab44', '919999988888', '34e51fa5-b24f-4404-9939-1043223ef5db', '2017-12-28 12:03:31', 1, '2017-12-28 12:03:31'),
('ee87df7e-a761-4f88-95e2-44c093989179', '919999988888', '34e51fa5-b24f-4404-9939-1043223ef5db', '2017-12-28 12:03:33', 1, '2017-12-28 12:03:33'),
('bb7db482-d089-4352-b48f-0ad119ad4eec', '919999988888', '34e51fa5-b24f-4404-9939-1043223ef5db', '2017-12-28 12:03:46', 1, '2017-12-28 12:03:46'),
('4eaa3e3c-016d-466a-bf46-217e7fba9481', '919999988888', '34e51fa5-b24f-4404-9939-1043223ef5db', '2017-12-28 12:03:50', 1, '2017-12-28 12:03:50'),
('4136c00c-a9db-4720-8d19-73d241c579f5', '254703576893', '08ab6f21-9822-47eb-b0a4-d3ecdb247e2a', '2018-01-03 14:25:12', 1, '2018-01-03 14:25:12'),
('d0658e17-ff8e-4c63-a078-045ea43e3b20', '919573270948', 'b4480cbc-8853-4943-b6d1-5228ccc32c03', '2018-01-08 15:32:44', 1, '2018-01-08 15:32:44'),
('5d0bb6f0-fa98-46f2-b4cb-d2415b332d83', '919573270948', '21bd7bc7-6181-4081-8807-73e4a91f82fc', '2018-01-09 07:08:28', 1, '2018-01-09 07:08:28'),
('d5dc9ee4-a1d2-4200-a7d5-f43e6fea7881', '919573270948', '21bd7bc7-6181-4081-8807-73e4a91f82fc', '2018-01-09 07:12:06', 1, '2018-01-09 07:12:06'),
('cde7af49-c0d4-49c2-8b29-0cecc63870eb', '918105447982', '64f633b2-52f4-4b0d-8545-4464358c7af7', '2018-01-11 08:53:27', 1, '2018-01-11 08:53:27'),
('f51d4a8c-8209-40fd-9c31-3c9dfbbfef1e', '918105447982', '1ad9ee11-cb40-4753-a454-7d3941beb423', '2018-01-11 08:53:30', 1, '2018-01-11 08:53:30'),
('89e03d0b-4cbe-48a0-8866-764a3a553318', '918105447982', '1ad9ee11-cb40-4753-a454-7d3941beb423', '2018-01-11 09:06:11', 1, '2018-01-11 09:06:11'),
('5adf243c-d97a-4ae8-92f8-81b6dffeaa76', '918105447982', '64f633b2-52f4-4b0d-8545-4464358c7af7', '2018-01-11 09:06:31', 1, '2018-01-11 09:06:31'),
('c51d1588-7eb8-44fc-b860-3a414ad08689', '918105447982', '1ad9ee11-cb40-4753-a454-7d3941beb423', '2018-01-11 09:27:14', 1, '2018-01-11 09:27:14'),
('a5d9bc90-2120-4e46-8f07-0c85083487ea', '918105447982', '64f633b2-52f4-4b0d-8545-4464358c7af7', '2018-01-11 09:27:21', 1, '2018-01-11 09:27:21'),
('5e53590a-b340-4457-8548-500201cf643a', '918105447982', '25ce488d-067b-475a-a655-1323434f29f0', '2018-01-11 10:09:16', 1, '2018-01-11 10:09:16'),
('27f9f291-36f8-4253-aa71-05a0d4cf6f43', '918105447982', '25ce488d-067b-475a-a655-1323434f29f0', '2018-01-11 10:09:43', 1, '2018-01-11 10:09:43'),
('f8b57f1c-4323-4717-b16e-ef14c712d55d', '918105447982', '25ce488d-067b-475a-a655-1323434f29f0', '2018-01-11 10:11:04', 1, '2018-01-11 10:11:04'),
('02ef4d4e-040a-4ce7-be89-63587d1d6751', '918105447982', '25ce488d-067b-475a-a655-1323434f29f0', '2018-01-11 13:03:53', 1, '2018-01-11 13:03:53'),
('d4037d99-a3a6-478f-97de-25513418064d', '918105447982', '64f633b2-52f4-4b0d-8545-4464358c7af7', '2018-01-11 13:04:35', 1, '2018-01-11 13:04:35'),
('fb5460ce-8dad-4821-9849-c5124b5f761e', '918105447982', 'f719262c-5c2a-4911-bf66-e06bd53095a1', '2018-01-11 13:25:01', 1, '2018-01-11 13:25:01'),
('a3cb31c8-72ad-4754-b5a9-26e6bad07e43', '918105447982', '1ad9ee11-cb40-4753-a454-7d3941beb423', '2018-01-11 13:28:19', 1, '2018-01-11 13:28:19'),
('ab8e679b-c776-4db7-9c03-6558b79bb951', '918105447982', '1ad9ee11-cb40-4753-a454-7d3941beb423', '2018-01-11 13:28:31', 1, '2018-01-11 13:28:31'),
('946fddc7-4bd2-4788-afe0-7f6cc8091dc3', '918105447982', '1ad9ee11-cb40-4753-a454-7d3941beb423', '2018-01-11 13:28:38', 1, '2018-01-11 13:28:38'),
('78a929c3-14ab-49e2-ac4b-4ca9cff7207c', '918105447982', '64f633b2-52f4-4b0d-8545-4464358c7af7', '2018-01-11 13:28:43', 1, '2018-01-11 13:28:43'),
('1e8e1f52-9d4c-4c99-86b7-891338884980', '918105447982', '64f633b2-52f4-4b0d-8545-4464358c7af7', '2018-01-11 13:28:49', 1, '2018-01-11 13:28:49'),
('d653b5a8-3782-48d3-bf43-cb18272ce55c', '918151913741', '1ad9ee11-cb40-4753-a454-7d3941beb423', '2018-01-11 13:28:49', 1, '2018-01-11 13:28:49'),
('a5a0d82c-f6cd-477b-9eab-bf7c083bb2c6', '918105447982', '1ad9ee11-cb40-4753-a454-7d3941beb423', '2018-01-11 13:28:51', 1, '2018-01-11 13:28:51'),
('6444afd7-c728-4de7-8265-f1793641a30e', '918151913741', '1ad9ee11-cb40-4753-a454-7d3941beb423', '2018-01-11 13:29:18', 1, '2018-01-11 13:29:18'),
('106e6579-d4f4-4e74-be68-c4c5eb9a3eb5', '918151913741', '1ad9ee11-cb40-4753-a454-7d3941beb423', '2018-01-11 13:29:24', 1, '2018-01-11 13:29:24'),
('608c3f04-ed84-4eac-b7cf-f8bbe5cee41d', '918151913741', '09312597-3c06-4168-8c68-128b24bd63c4', '2018-01-11 13:29:33', 1, '2018-01-11 13:29:33'),
('415103a8-ca9f-4dec-b5d7-769583959768', '918151913741', '64f633b2-52f4-4b0d-8545-4464358c7af7', '2018-01-11 13:29:51', 1, '2018-01-11 13:29:51'),
('66c6f475-2c7a-4229-a627-26fbf3f5f8f9', '918151913741', '64f633b2-52f4-4b0d-8545-4464358c7af7', '2018-01-11 13:30:05', 1, '2018-01-11 13:30:05'),
('71e43121-abce-4812-bf9c-eb3e1c5683c1', '918105447982', '1ad9ee11-cb40-4753-a454-7d3941beb423', '2018-01-11 13:30:26', 1, '2018-01-11 13:30:26'),
('e3dce062-ef1c-4fbd-b4f1-b3485dc08a67', '918105447982', '1ad9ee11-cb40-4753-a454-7d3941beb423', '2018-01-11 13:31:51', 1, '2018-01-11 13:31:51'),
('0f17b18b-af19-46b8-93e0-db0f6029e5de', '918151913741', 'f719262c-5c2a-4911-bf66-e06bd53095a1', '2018-01-11 13:39:16', 1, '2018-01-11 13:39:16'),
('cd578dd2-fd81-4f39-a9aa-4d2b30af6e83', '918151913741', '74898d83-e230-4d33-b8f3-894c8362c380', '2018-01-11 13:44:02', 1, '2018-01-11 13:44:02'),
('1c2354c4-5599-48d8-a1d4-9046ed673f29', '918151913741', 'e95eb987-0831-43f7-906e-a2abc014df9c', '2018-01-11 13:44:09', 1, '2018-01-11 13:44:09'),
('3e7d5117-85c4-4600-ad21-663fc2a9a125', '918151913741', 'f719262c-5c2a-4911-bf66-e06bd53095a1', '2018-01-11 13:44:16', 1, '2018-01-11 13:44:16'),
('e0910b31-0578-43dc-b4d0-fc99dbfc62b7', '918151913741', '8ea76aaa-518e-4050-8d64-853bca89985a', '2018-01-11 13:44:31', 1, '2018-01-11 13:44:31'),
('6a430896-2157-455e-8d75-51158ce37ea0', '918151913741', '1ad9ee11-cb40-4753-a454-7d3941beb423', '2018-01-11 13:44:42', 1, '2018-01-11 13:44:42'),
('2df18c4c-710a-45e8-8a0d-cbe2fad8c33b', '918892452332', '1ad9ee11-cb40-4753-a454-7d3941beb423', '2018-01-12 07:35:04', 1, '2018-01-12 07:35:04'),
('0996d83f-e571-4708-9104-fb6047d3a6d4', '918892452332', '64f633b2-52f4-4b0d-8545-4464358c7af7', '2018-01-12 07:37:07', 1, '2018-01-12 07:37:07'),
('400195cf-9888-41ce-9abf-1e7568296211', '918892452332', '92d22934-06d0-42b4-b454-881461823dd9', '2018-01-16 12:46:06', 1, '2018-01-16 12:46:06'),
('c5472ec4-3df3-4768-9b0e-c98ffbf65e6a', '918892452332', 'f7192615-3cad-451d-bf04-949bcf7883aa', '2018-01-17 10:20:08', 1, '2018-01-17 10:20:08'),
('9db392df-37e3-482c-8f59-7a44365cf987', '918892452332', '593fbe60-00df-4e30-a7c5-19efecf83153', '2018-01-18 07:26:59', 1, '2018-01-18 07:26:59'),
('19c24271-1db9-4745-980c-79e2bed4e15b', '918862452332', '593fbe60-00df-4e30-a7c5-19efecf83153', '2018-01-19 05:07:15', 1, '2018-01-19 05:07:15'),
('b9e874f4-f9b3-4ad8-a4fe-b5078a270d2d', '918183005820', '6cc5a93d-3d21-4f41-ac93-fe6483517898', '2018-01-19 08:53:34', 1, '2018-01-19 08:53:34'),
('e00b12f9-9e10-4ce0-9c47-4e3321b864d3', '918183005820', '6cc5a93d-3d21-4f41-ac93-fe6483517898', '2018-01-19 08:54:27', 1, '2018-01-19 08:54:27'),
('9e99c879-6e2a-4aac-94e9-5e2e2d883c18', '918183005820', '21bd7bc7-6181-4081-8807-73e4a91f82fc', '2018-01-19 08:54:45', 1, '2018-01-19 08:54:45'),
('10bb4626-1aaf-43e8-8483-16330fd86499', '918892452332', '6cc5a93d-3d21-4f41-ac93-fe6483517898', '2018-01-22 12:22:37', 1, '2018-01-22 12:22:37'),
('a3cb85b0-cd14-47e0-a3c1-2e6de824eef2', '918151913741', 'f7192615-3cad-451d-bf04-949bcf7883aa', '2018-02-01 06:37:06', 1, '2018-02-01 06:37:06'),
('81eb83a1-deb3-4b79-8aed-e4f7a4c20f61', '918151913741', 'f7192615-3cad-451d-bf04-949bcf7883aa', '2018-02-01 06:42:13', 1, '2018-02-01 06:42:13'),
('a6fbe80b-f873-41a7-bbde-2df2dbaa128b', '919035564107', 'a80d8590-a270-43e2-933f-bed14683e04d', '2018-02-01 10:18:30', 1, '2018-02-01 10:18:30'),
('f7fe3657-4847-4389-9f2a-80114fe360f6', '919035564107', 'a80d8590-a270-43e2-933f-bed14683e04d', '2018-02-01 10:18:36', 1, '2018-02-01 10:18:36'),
('617db934-7a91-4535-9f4a-6566c38833af', '919035564107', '44526186-270f-413c-a1e9-cfc7e0333e2d', '2018-02-01 10:32:52', 1, '2018-02-01 10:32:52'),
('463a166c-b865-4dc3-8df9-7e0aecfdfcd2', '919035564107', 'a80d8590-a270-43e2-933f-bed14683e04d', '2018-02-01 10:32:55', 1, '2018-02-01 10:32:55'),
('fedb77ff-917b-4c19-8a84-c7e394d38ccb', '919035564107', '44526186-270f-413c-a1e9-cfc7e0333e2d', '2018-02-01 10:35:31', 1, '2018-02-01 10:35:31'),
('a5485455-1cb8-43a6-b880-15c1182abb27', '919035564107', '44526186-270f-413c-a1e9-cfc7e0333e2d', '2018-02-01 10:36:07', 1, '2018-02-01 10:36:07'),
('cdbb73a8-1113-47fd-8ebc-3f6975dbf792', '919035564107', '8ea76aaa-518e-4050-8d64-853bca89985a', '2018-02-01 10:36:21', 1, '2018-02-01 10:36:21'),
('413a86bb-9ea6-463a-9d5e-eb626f646e16', '919035564107', 'ccc81664-71a6-4143-a518-ef08ec18aa5a', '2018-02-01 10:36:31', 1, '2018-02-01 10:36:31'),
('c56ebc36-3a45-4041-92ed-d44b02e4bb0b', '919035564107', 'ccc81664-71a6-4143-a518-ef08ec18aa5a', '2018-02-01 10:36:43', 1, '2018-02-01 10:36:43'),
('e6ae6c4e-de12-4f7f-83bf-8ef47cc55e87', '919035564107', '35e23e3d-78d3-484d-9559-d1cc04c4cd8c', '2018-02-01 10:36:54', 1, '2018-02-01 10:36:54'),
('d35241da-0709-45f1-b9ff-635fcb437af0', '919035564107', '1a91107a-fdb2-4e37-a620-645ea666ff6c', '2018-02-01 10:38:19', 1, '2018-02-01 10:38:19'),
('dd7735d1-6584-4060-abfa-c28ca324dc1e', '919035564107', 'ccc81664-71a6-4143-a518-ef08ec18aa5a', '2018-02-01 10:40:10', 1, '2018-02-01 10:40:10'),
('020937f3-ac46-4216-9c59-19a72f8e33be', '919035564107', 'ccc81664-71a6-4143-a518-ef08ec18aa5a', '2018-02-01 10:40:12', 1, '2018-02-01 10:40:12'),
('4e5fbc5d-79ad-4dd0-b50d-b6589962d2fd', '919035564107', '44526186-270f-413c-a1e9-cfc7e0333e2d', '2018-02-01 11:29:32', 1, '2018-02-01 11:29:32'),
('f1507941-1a17-4530-a6f1-fc2ae762e3c6', '919035564107', '44526186-270f-413c-a1e9-cfc7e0333e2d', '2018-02-01 11:29:42', 1, '2018-02-01 11:29:42'),
('1511a3e9-827d-4b79-b04c-b6e91a47762e', '918151913741', '3c21eb87-fdf8-4581-b21e-fdf6a9c70ea9', '2018-02-01 11:29:52', 1, '2018-02-01 11:29:52'),
('bdc6430c-4f8b-4251-b8e7-aaa6f5f94bb6', '919035564107', '1a91107a-fdb2-4e37-a620-645ea666ff6c', '2018-02-01 11:55:47', 1, '2018-02-01 11:55:47'),
('255e68f4-d242-4ac9-9837-4ba6d7a0659b', '919035564107', 'efaa4234-5c4b-44e2-bbf8-d4c593158e28', '2018-02-01 12:32:26', 1, '2018-02-01 12:32:26'),
('07690ed9-8e75-4750-bda7-83d12b2dd78b', '918151913741', '93b34e67-f2cd-4315-b3e8-73a3bbb9174c', '2018-02-01 14:31:33', 1, '2018-02-01 14:31:33'),
('d3bcd231-db7f-459e-a7e4-339bd6dfd543', '918151913741', '93b34e67-f2cd-4315-b3e8-73a3bbb9174c', '2018-02-01 14:31:33', 1, '2018-02-01 14:31:33'),
('7ef638f0-8db8-4c13-ad0d-bcb402f2ee2c', '918151913741', '93b34e67-f2cd-4315-b3e8-73a3bbb9174c', '2018-02-01 14:31:34', 1, '2018-02-01 14:31:34'),
('742416cb-3be8-4ecd-a31b-b89df58a8ed7', '918151913741', '93b34e67-f2cd-4315-b3e8-73a3bbb9174c', '2018-02-01 14:31:34', 1, '2018-02-01 14:31:34'),
('fbbb8402-2610-4c42-917a-ff838e98a14d', '918151913741', 'efaa4234-5c4b-44e2-bbf8-d4c593158e28', '2018-02-01 14:32:04', 1, '2018-02-01 14:32:04'),
('595a18a6-1054-4fda-9712-ffbf78614f95', '918151913741', '6cc5a93d-3d21-4f41-ac93-fe6483517898', '2018-02-01 14:32:06', 1, '2018-02-01 14:32:06'),
('30f7076f-aaed-4a3f-9d34-9e47f02444ec', '918151913741', '1ad9ee11-cb40-4753-a454-7d3941beb423', '2018-02-01 14:32:17', 1, '2018-02-01 14:32:17'),
('3c623a20-291b-4ccd-afd7-4c7714c2a941', '918151913741', 'efaa4234-5c4b-44e2-bbf8-d4c593158e28', '2018-02-02 06:35:18', 1, '2018-02-02 06:35:18'),
('3a9d3aee-9e53-4efa-af55-5ee4a3cac12a', '918151913741', '3c21eb87-fdf8-4581-b21e-fdf6a9c70ea9', '2018-02-02 06:35:23', 1, '2018-02-02 06:35:23'),
('a0386266-eaef-47fe-ba87-c44b09310cf1', '918151913741', 'af202296-814a-4774-b93d-0cf569dfa068', '2018-02-02 06:35:26', 1, '2018-02-02 06:35:26'),
('90e46b6d-09f2-4647-b74e-d09f5c3739a5', '918151913741', 'efaa4234-5c4b-44e2-bbf8-d4c593158e28', '2018-02-02 06:38:45', 1, '2018-02-02 06:38:45'),
('cb4c6bf3-a0c2-4d8b-a50e-dc8d07b670bb', '918151913741', '593fbe60-00df-4e30-a7c5-19efecf83153', '2018-02-02 06:38:47', 1, '2018-02-02 06:38:47'),
('3485012a-9c8a-48eb-a5ba-97cda4c6684c', '919035564107', 'efaa4234-5c4b-44e2-bbf8-d4c593158e28', '2018-02-02 07:05:22', 1, '2018-02-02 07:05:22'),
('68b5b346-193e-47ed-b27d-a17221678463', '918151913741', '0260d5e5-7231-4c0b-a83c-73bff4aa4522', '2018-02-02 07:07:20', 1, '2018-02-02 07:07:20'),
('dd28d64b-f252-4e19-a5f2-971922ae042c', '918151913741', 'efaa4234-5c4b-44e2-bbf8-d4c593158e28', '2018-02-02 07:07:24', 1, '2018-02-02 07:07:24'),
('758c2c3f-df6e-4f36-a83c-966ac134c70a', '919035564107', 'efaa4234-5c4b-44e2-bbf8-d4c593158e28', '2018-02-02 07:14:42', 1, '2018-02-02 07:14:42'),
('70fbdcfd-3859-41ca-9281-11e42b5d645d', '919035564107', '6cc5a93d-3d21-4f41-ac93-fe6483517898', '2018-02-02 07:14:51', 1, '2018-02-02 07:14:51'),
('25d4bb91-820e-49ce-be0a-90dde0fc523d', '919035564107', '1b361238-7753-4bf7-afd2-bc9a545516e0', '2018-02-02 07:15:00', 1, '2018-02-02 07:15:00'),
('d49c799b-175b-4ec0-99d6-22d6741ec55d', '919035564107', 'c2c4f462-ac4b-4cb4-b80a-be82da8dbd65', '2018-02-02 07:15:29', 1, '2018-02-02 07:15:29'),
('b8038c5f-009d-4351-8185-77ffff5c9993', '919035564107', '44526186-270f-413c-a1e9-cfc7e0333e2d', '2018-02-02 07:15:47', 1, '2018-02-02 07:15:47'),
('cf1c977b-fad3-4db6-9fd0-8556ccaaa8b7', '919035564107', '44526186-270f-413c-a1e9-cfc7e0333e2d', '2018-02-02 07:15:56', 1, '2018-02-02 07:15:56'),
('86d67fff-699a-4420-84d4-90a4d79557e9', '919035564107', 'efaa4234-5c4b-44e2-bbf8-d4c593158e28', '2018-02-02 08:00:22', 1, '2018-02-02 08:00:22'),
('49f70b1b-7aa5-4af2-be35-30ea3f709519', '918151913741', '70d49999-a4b7-4ef6-8510-cdcd1ed46bd7', '2018-02-02 08:23:47', 1, '2018-02-02 08:23:47'),
('f25d76c8-fec7-4938-8c46-9e5c516410ed', '918151913741', 'f719262c-5c2a-4911-bf66-e06bd53095a1', '2018-02-02 08:23:53', 1, '2018-02-02 08:23:53'),
('ef84cbe9-2926-45c8-9167-26892f9218af', '918151913741', '593fbe60-00df-4e30-a7c5-19efecf83153', '2018-02-02 08:24:12', 1, '2018-02-02 08:24:12'),
('adebf23c-d801-45be-bb80-dad476dd2466', '918151913741', 'efaa4234-5c4b-44e2-bbf8-d4c593158e28', '2018-02-02 08:35:40', 1, '2018-02-02 08:35:40'),
('5cbd5ec8-8b31-452f-b007-db7a4eccad9e', '919035564107', 'a80d8590-a270-43e2-933f-bed14683e04d', '2018-02-02 09:04:26', 1, '2018-02-02 09:04:26'),
('cd5f3098-b447-4eab-b0c9-6b96f9276f92', '918151913741', '24644ad3-36b5-4d03-b144-3b8c436e3e1d', '2018-02-02 09:52:25', 1, '2018-02-02 09:52:25'),
('106598e3-cf82-448c-935d-af002b31bbc1', '918151913741', '24644ad3-36b5-4d03-b144-3b8c436e3e1d', '2018-02-02 09:54:19', 1, '2018-02-02 09:54:19'),
('5a3a604c-c58e-438a-9ae6-30d474a64d55', '919035564107', 'af202296-814a-4774-b93d-0cf569dfa068', '2018-02-02 10:21:40', 1, '2018-02-02 10:21:40'),
('25522290-4d2d-48eb-bb73-de986bf0eefa', '919035564107', '593fbe60-00df-4e30-a7c5-19efecf83153', '2018-02-02 10:21:48', 1, '2018-02-02 10:21:48'),
('ea8e6646-874f-40af-b432-b4bb8a07990a', '918151913741', 'efaa4234-5c4b-44e2-bbf8-d4c593158e28', '2018-02-02 10:57:41', 1, '2018-02-02 10:57:41'),
('c84e7891-3a3e-4c84-b7a7-3283c0c979a5', '918151913741', 'efaa4234-5c4b-44e2-bbf8-d4c593158e28', '2018-02-02 11:11:46', 1, '2018-02-02 11:11:46'),
('5c992e5d-ef32-4aa1-9061-13b4f90ce03e', '918151913741', 'efaa4234-5c4b-44e2-bbf8-d4c593158e28', '2018-02-02 11:13:44', 1, '2018-02-02 11:13:44'),
('47de0326-b8f1-4604-9cc7-9bbce5f75cac', '918151913741', 'efaa4234-5c4b-44e2-bbf8-d4c593158e28', '2018-02-02 11:13:49', 1, '2018-02-02 11:13:49'),
('50ea9f67-10e7-42f0-adfa-3b1ecaf9ec3c', '918151913741', 'c2c4f462-ac4b-4cb4-b80a-be82da8dbd65', '2018-02-02 11:25:30', 1, '2018-02-02 11:25:30'),
('e6e9c3ec-70ec-4e35-bf12-f5f318f16a91', '918151913741', '6cc5a93d-3d21-4f41-ac93-fe6483517898', '2018-02-02 11:25:32', 1, '2018-02-02 11:25:32'),
('cf389b84-9a04-458b-b9e0-9ba4deb224b3', '918151913741', 'c2c4f462-ac4b-4cb4-b80a-be82da8dbd65', '2018-02-02 11:32:40', 1, '2018-02-02 11:32:40'),
('20eae117-7f80-496e-9db9-22c90116ed52', '918151913741', '1ad9ee11-cb40-4753-a454-7d3941beb423', '2018-02-02 11:33:03', 1, '2018-02-02 11:33:03'),
('abcd2653-fab3-4c05-9fd3-48beb3586860', '918151913741', '1ad9ee11-cb40-4753-a454-7d3941beb423', '2018-02-02 11:33:37', 1, '2018-02-02 11:33:37'),
('479e0d31-571f-43cd-a5f5-92a85603e2aa', '919035564107', 'a80d8590-a270-43e2-933f-bed14683e04d', '2018-02-02 11:39:32', 1, '2018-02-02 11:39:32'),
('b38e921e-a7c9-40ef-affe-959f2f0d298d', '919035564107', '34e51fa5-b24f-4404-9939-1043223ef5db', '2018-02-02 11:39:39', 1, '2018-02-02 11:39:39'),
('16236e67-d9d3-42ff-b97f-b0cb771a1a25', '919035564107', '44526186-270f-413c-a1e9-cfc7e0333e2d', '2018-02-02 11:39:50', 1, '2018-02-02 11:39:50'),
('aae4f077-f6b1-45cc-a896-72a866d9c277', '919035564107', 'a80d8590-a270-43e2-933f-bed14683e04d', '2018-02-02 11:39:52', 1, '2018-02-02 11:39:52'),
('ffecfd9f-22d8-4fe2-934c-1960a17511c6', '919035564107', 'ccc81664-71a6-4143-a518-ef08ec18aa5a', '2018-02-02 11:42:11', 1, '2018-02-02 11:42:11'),
('a7ccc7d4-a599-484a-98b3-142573d6bc71', '918151913741', '44526186-270f-413c-a1e9-cfc7e0333e2d', '2018-02-02 11:53:30', 1, '2018-02-02 11:53:30'),
('1ab35e28-e79c-4af9-806c-20d0a206fefb', '919898667544', 'efaa4234-5c4b-44e2-bbf8-d4c593158e28', '2018-02-02 12:14:46', 1, '2018-02-02 12:14:46'),
('fd486f5f-fda1-47a7-a067-5f709b9b5a4a', '918105447982', 'efaa4234-5c4b-44e2-bbf8-d4c593158e28', '2018-02-02 12:26:02', 1, '2018-02-02 12:26:02'),
('259e9696-efa8-42f2-863c-4f734d4d9a7d', '918105447982', 'efaa4234-5c4b-44e2-bbf8-d4c593158e28', '2018-02-02 12:30:50', 1, '2018-02-02 12:30:50'),
('9abee617-f5cb-4338-a4a9-be4986b33773', '918105447982', 'efaa4234-5c4b-44e2-bbf8-d4c593158e28', '2018-02-02 12:32:08', 1, '2018-02-02 12:32:08'),
('85f8e04f-9e34-4bac-9849-f9aa58ceed79', '918105447982', 'efaa4234-5c4b-44e2-bbf8-d4c593158e28', '2018-02-02 12:33:16', 1, '2018-02-02 12:33:16'),
('151e95ff-a7c5-4419-a53f-4c83970c68ac', '918105447982', 'efaa4234-5c4b-44e2-bbf8-d4c593158e28', '2018-02-02 12:33:36', 1, '2018-02-02 12:33:36'),
('4deedeff-b6c9-4c9e-9808-c8e170183323', '919035564107', 'a80d8590-a270-43e2-933f-bed14683e04d', '2018-02-02 12:34:03', 1, '2018-02-02 12:34:03'),
('1bfe0b13-bcf8-4c5d-8aeb-6feec2c0a2c5', '919035564107', '44526186-270f-413c-a1e9-cfc7e0333e2d', '2018-02-02 12:34:05', 1, '2018-02-02 12:34:05'),
('1f0db676-9cca-4786-9f3c-d7d187527a17', '918151913741', '44526186-270f-413c-a1e9-cfc7e0333e2d', '2018-02-05 12:09:54', 1, '2018-02-05 12:09:54'),
('5cd2b6a8-3d46-4f16-95b1-891bf1eedc8e', '918105447982', '52928ea1-6c27-4839-ac9c-0ac76a5b8d1e', '2018-02-06 07:35:49', 1, '2018-02-06 07:35:49'),
('3629f541-eee1-4ce3-8d8c-09723e9de752', '918105447982', '52928ea1-6c27-4839-ac9c-0ac76a5b8d1e', '2018-02-06 07:36:04', 1, '2018-02-06 07:36:04'),
('b434f0cc-3558-4028-8242-48d42b0f5721', '918105447982', '52928ea1-6c27-4839-ac9c-0ac76a5b8d1e', '2018-02-06 07:36:59', 1, '2018-02-06 07:36:59');

-- --------------------------------------------------------

--
-- Table structure for table `email_reminder`
--

CREATE TABLE `email_reminder` (
  `email_reminder_id` varchar(45) NOT NULL,
  `channel_id` varchar(45) NOT NULL,
  `created_date` datetime NOT NULL,
  `mail_type` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `email_reminder`
--

INSERT INTO `email_reminder` (`email_reminder_id`, `channel_id`, `created_date`, `mail_type`) VALUES
('140ab81a-ec45-4c05-86b8-0f50552bd53a', 'a09abc52-3c57-4627-aa2a-ac8c61ac6d1f', '2017-12-27 10:58:11', 'A'),
('15bb43de-c6b7-403b-984a-9e8f3e674f91', 'a09abc52-3c57-4627-aa2a-ac8c61ac6d1f', '2017-12-27 12:22:04', 'M'),
('2a5ed30c-0ec1-4644-b4c2-bc18004eb42d', 'a09abc52-3c57-4627-aa2a-ac8c61ac6d1f', '2017-12-27 10:57:11', 'M'),
('539a9db6-489c-4dea-8fa9-6de16414f236', 'a09abc52-3c57-4627-aa2a-ac8c61ac6d1f', '2017-12-27 11:13:37', 'M');

-- --------------------------------------------------------

--
-- Table structure for table `emoji_sticker`
--

CREATE TABLE `emoji_sticker` (
  `emoji_sticker_id` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `path` text,
  `thumbnail_path` text,
  `url` text,
  `width` bigint(20) DEFAULT NULL,
  `height` bigint(20) DEFAULT NULL,
  `size` bigint(20) DEFAULT NULL,
  `content_type` varchar(50) NOT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `import_datetime` datetime DEFAULT NULL,
  `imported_by_user_id` varchar(50) DEFAULT NULL,
  `modified_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified_user_id` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emoji_sticker`
--

INSERT INTO `emoji_sticker` (`emoji_sticker_id`, `title`, `type`, `path`, `thumbnail_path`, `url`, `width`, `height`, `size`, `content_type`, `is_active`, `import_datetime`, `imported_by_user_id`, `modified_datetime`, `modified_user_id`) VALUES
('03c40e8b-b06b-42f4-8762-4083b44fcd2e', 'emoji data 1 edit', 'emoji', '/home/compass/Channels/data/emojisticker/emoji/Emoji Cat1/Pickachu.jpeg', '', 'http://192.168.2.82:8080/channels/api/v1/emojisticker/emoji/Emoji%20Cat1/Pickachu.jpeg', 234, 215, 7899, 'image/jpeg', 1, '2018-01-23 08:43:18', '919900001201', '2018-01-24 06:31:09', '919900001201'),
('100427dd-d847-4d58-9dc8-5ad43d51c4a2', 'jjhhjhj', 'emoji', '/home/compass/Channels/data/emojisticker/emoji/emoji cat3/backgroundImage.jpg', '', 'http://192.168.2.82:8080/channels/api/v1/emojisticker/emoji/emoji%20cat3/backgroundImage.jpg', 1500, 1000, 73969, 'image/jpeg', 1, '2018-01-24 09:18:21', '919900001201', '2018-01-24 09:18:21', '919900001201'),
('202c68bc-13cf-4f74-b44b-8eb11a21aa06', 'Sticker data 4 for edit delete EDIT AGAIN', 'sticker', '/home/compass/Channels/data/emojisticker/sticker/Sticketr cat 2/Pickachu.jpeg', '', 'http://192.168.2.82:8080/channels/api/v1/emojisticker/sticker/Sticketr%20cat%202/Pickachu.jpeg', 234, 215, 7899, 'image/jpeg', 1, '2018-01-23 08:42:58', '919900001201', '2018-01-24 04:29:48', '919900001201'),
('2ccd1eb0-295c-4686-96ba-afc52250ec7d', 'Sticker data 3', 'sticker', '/home/compass/Channels/data/emojisticker/sticker/sticker cat3/Pickachu.jpeg', '', 'http://192.168.2.82:8080/channels/api/v1/emojisticker/sticker/sticker%20cat3/Pickachu.jpeg', 234, 215, 7899, 'image/jpeg', 1, '2018-01-23 08:42:39', '919900001201', '2018-01-23 08:42:39', '919900001201'),
('538e45bd-e04b-4adc-bfd7-07a378b4efe7', 'emoji data 2', 'emoji', '/home/compass/Channels/data/emojisticker/emoji/Emoji cat2/Pickachu.jpeg', '', 'http://192.168.2.82:8080/channels/api/v1/emojisticker/emoji/Emoji%20cat2/Pickachu.jpeg', 234, 215, 7899, 'image/jpeg', 1, '2018-01-23 08:43:32', '919900001201', '2018-01-23 08:43:32', '919900001201'),
('604ba1cd-406a-45c9-b967-1dd91f3ae24b', 'jjkjk', 'sticker', '/home/compass/Channels/data/emojisticker/sticker/sticker cat3/Pickachu.jpeg', '', 'http://192.168.2.82:8080/channels/api/v1/emojisticker/sticker/sticker%20cat3/Pickachu.jpeg', 234, 215, 7899, 'image/jpeg', 1, '2018-01-24 07:03:37', '919900001201', '2018-01-24 07:03:37', '919900001201'),
('6f401691-fb6c-45d5-8d0f-e52c9859b4cf', 'ghghgh', 'emoji', '/home/compass/Channels/data/emojisticker/emoji/hjghghghjh Edit/(play).png', '', 'http://192.168.2.82:8080/channels/api/v1/emojisticker/emoji/hjghghghjh%20Edit/(play).png', 14, 18, 40339, 'image/png', 1, '2018-01-30 09:22:08', '919900001201', '2018-01-30 09:22:08', '919900001201'),
('7b63057d-5bfe-4f2f-8dc6-e31550625f75', 'hghg', 'emoji', '/home/compass/Channels/data/emojisticker/emoji/Emoji cat2/(play).png', '', 'http://192.168.2.82:8080/channels/api/v1/emojisticker/emoji/Emoji%20cat2/(play).png', 14, 18, 40339, 'image/png', 1, '2018-01-30 08:31:09', '919900001201', '2018-01-30 08:31:09', '919900001201'),
('90329fd9-3b76-4b6c-9556-78b7c9882c6f', 'Sticker data 1', 'sticker', '/home/compass/Channels/data/emojisticker/sticker/Sticket cat 1/Pickachu.jpeg', '', 'http://192.168.2.82:8080/channels/api/v1/emojisticker/sticker/Sticket%20cat%201/Pickachu.jpeg', 234, 215, 7899, 'image/jpeg', 1, '2018-01-23 08:42:09', '919900001201', '2018-01-23 08:42:09', '919900001201'),
('9a3381b4-a109-406c-9a5d-8eba2b6d1fb7', 'upload', 'sticker', '/home/compass/Channels/data/emojisticker/sticker/sticker cat3/Pickachu.jpeg', '', 'http://192.168.2.82:8080/channels/api/v1/emojisticker/sticker/sticker%20cat3/Pickachu.jpeg', 234, 215, 7899, 'image/jpeg', 1, '2018-01-24 09:12:44', '919900001201', '2018-01-24 09:12:44', '919900001201'),
('9d242872-1401-4f67-bc8f-7b3b5fdfefc6', 'emoji data 3', 'emoji', '/home/compass/Channels/data/emojisticker/emoji/emoji cat3/Pickachu.jpeg', '', 'http://192.168.2.82:8080/channels/api/v1/emojisticker/emoji/emoji%20cat3/Pickachu.jpeg', 234, 215, 7899, 'image/jpeg', 1, '2018-01-23 08:43:46', '919900001201', '2018-01-23 08:43:46', '919900001201'),
('a88de433-ad0b-467a-a3e1-ef28a37afb82', 'emoji data 4 edit delete', 'emoji', '/home/compass/Channels/data/emojisticker/emoji/Emoji Cat1/Pickachu.jpeg', '', 'http://192.168.2.82:8080/channels/api/v1/emojisticker/emoji/Emoji%20Cat1/Pickachu.jpeg', 234, 215, 7899, 'image/jpeg', 1, '2018-01-23 08:44:04', '919900001201', '2018-01-23 08:44:04', '919900001201'),
('adc77c4c-f5c2-43af-941e-bf11c31bed83', 'emoji Cat With Space - data1', 'emoji', '/home/compass/Channels/data/emojisticker/emoji/emoji Cat With Space/Pickachu.jpeg', '', 'http://192.168.2.82:8080/channels/api/v1/emojisticker/emoji/emoji%20Cat%20With%20Space/Pickachu.jpeg', 234, 215, 7899, 'image/jpeg', 1, '2018-01-24 10:18:26', '919900001201', '2018-01-24 10:18:26', '919900001201'),
('dbc6824f-7f98-467f-9e87-65db88a65deb', 'Sticker data 2 edit', 'sticker', '/home/compass/Channels/data/emojisticker/sticker/Sticketr cat 2/Pickachu.jpeg', '', 'http://192.168.2.82:8080/channels/api/v1/emojisticker/sticker/Sticketr%20cat%202/Pickachu.jpeg', 234, 215, 7899, 'image/jpeg', 1, '2018-01-23 08:42:24', '919900001201', '2018-01-24 06:31:25', '919900001201'),
('dc62c4c7-6565-4b5f-95d4-4b7f33cdbbcb', 'emojiCatWithoutSpace-Data1', 'emoji', '/home/compass/Channels/data/emojisticker/emoji/emojiCatWithoutSpace/Pickachu.jpeg', '', 'http://192.168.2.82:8080/channels/api/v1/emojisticker/emoji/emojiCatWithoutSpace/Pickachu.jpeg', 234, 215, 7899, 'image/jpeg', 1, '2018-01-24 10:17:36', '919900001201', '2018-01-24 10:17:36', '919900001201'),
('ea7696d7-582e-4521-93d7-9ccf674583e8', 'test1213131', 'emoji', '/home/compass/Channels/data/emojisticker/emoji/Emoji Cat111 EDIT/Pickachu.jpeg', '', 'http://192.168.2.82:8080/channels/api/v1/emojisticker/emoji/Emoji%20Cat111%20EDIT/Pickachu.jpeg', 234, 215, 7899, 'image/jpeg', 1, '2018-01-24 10:13:16', '919900001201', '2018-01-24 10:13:16', '919900001201'),
('fc1af2f2-7c6d-43fe-ae25-ae9dac3db0a2', 'upload emoji', 'emoji', '/home/compass/Channels/data/emojisticker/emoji/emoji cat3/Pickachu.jpeg', '', 'http://192.168.2.82:8080/channels/api/v1/emojisticker/emoji/emoji%20cat3/Pickachu.jpeg', 234, 215, 7899, 'image/jpeg', 1, '2018-01-24 09:14:02', '919900001201', '2018-01-24 09:14:02', '919900001201');

-- --------------------------------------------------------

--
-- Table structure for table `emoji_sticker_category`
--

CREATE TABLE `emoji_sticker_category` (
  `category_id` varchar(50) NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `type` varchar(45) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_user_id` varchar(50) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_user_id` varchar(50) NOT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emoji_sticker_category`
--

INSERT INTO `emoji_sticker_category` (`category_id`, `category_name`, `type`, `is_active`, `created_user_id`, `created_date`, `modified_user_id`, `modified_date`) VALUES
('1aa9fcc8-5990-4c3b-9ae5-5b3f944ba545', 'sticker cat3', 'sticker', 1, '919900001201', '2018-01-23 08:39:47', '919900001201', '2018-01-23 08:39:47'),
('278d7ba2-3e62-4a2f-966b-c54a35c2da51', 'hjghghghjh Edit', 'emoji', 1, '919900001201', '2018-01-23 12:18:11', '919900001201', '2018-01-23 12:18:21'),
('40423268-a473-4221-a809-3293216b913a', 'Emoji Cat111 EDIT', 'emoji', 1, '919900001201', '2018-01-24 04:23:06', '919900001201', '2018-01-24 04:28:33'),
('4f2c647a-8d88-4d1b-b905-994e6aba3551', 'emoji cat3', 'emoji', 1, '919900001201', '2018-01-23 08:37:01', '919900001201', '2018-01-23 08:37:01'),
('5c97a5c6-64f4-4ff8-ae04-a18afe578206', 'Sticketr cat 2', 'sticker', 1, '919900001201', '2018-01-23 08:39:30', '919900001201', '2018-01-23 08:39:30'),
('5d6d0d3c-c6b6-4274-91dd-6989a41f5a34', 'Sticket cat 1', 'sticker', 1, '919900001201', '2018-01-23 08:39:08', '919900001201', '2018-01-23 08:39:08'),
('76a427de-3487-4b58-948a-7de408b61e98', 'emojiCatWithoutSpace', 'emoji', 1, '919900001201', '2018-01-24 10:16:53', '919900001201', '2018-01-24 10:16:53'),
('be8bc548-3b11-4f78-a8b5-958f6bdac51f', 'emoji Cat With Space', 'emoji', 1, '919900001201', '2018-01-24 10:17:11', '919900001201', '2018-01-24 10:17:11'),
('ca76c2df-c13f-4b23-9bb4-0a2e5cfae52f', 'Emoji Cat1', 'emoji', 1, '919900001201', '2018-01-23 08:36:39', '919900001201', '2018-01-23 08:36:39'),
('dd48a401-90db-4178-a26b-5f5fc722f2bc', '1111111111 edit again edit 1112 4-edit', 'emoji', 1, '919900001201', '2018-01-24 04:35:19', '919900001201', '2018-01-24 08:20:09'),
('fccf49e4-9524-41f6-9341-85169f1bbc9d', 'Emoji cat2', 'emoji', 1, '919900001201', '2018-01-23 08:36:51', '919900001201', '2018-01-23 08:36:51');

-- --------------------------------------------------------

--
-- Table structure for table `emoji_sticker_category_mapper`
--

CREATE TABLE `emoji_sticker_category_mapper` (
  `category_mapper_id` varchar(50) NOT NULL,
  `emoji_sticker_category_id` varchar(50) NOT NULL,
  `emoji_sticker_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emoji_sticker_category_mapper`
--

INSERT INTO `emoji_sticker_category_mapper` (`category_mapper_id`, `emoji_sticker_category_id`, `emoji_sticker_id`) VALUES
('0ae8f405-383a-4c16-9aa9-4fbe76e18cd3', '5c97a5c6-64f4-4ff8-ae04-a18afe578206', 'dbc6824f-7f98-467f-9e87-65db88a65deb'),
('1f330548-5771-414a-8d66-9aec22415915', 'ca76c2df-c13f-4b23-9bb4-0a2e5cfae52f', '03c40e8b-b06b-42f4-8762-4083b44fcd2e'),
('26d953c9-232b-4ec4-9347-fb2c55ce1097', 'fccf49e4-9524-41f6-9341-85169f1bbc9d', '7b63057d-5bfe-4f2f-8dc6-e31550625f75'),
('2eebbdf9-c2ef-4dcc-b8ee-01a180110d93', 'ca76c2df-c13f-4b23-9bb4-0a2e5cfae52f', 'a88de433-ad0b-467a-a3e1-ef28a37afb82'),
('35a4dcc2-91b8-4e96-bd40-9b648bc1bb80', '278d7ba2-3e62-4a2f-966b-c54a35c2da51', '6f401691-fb6c-45d5-8d0f-e52c9859b4cf'),
('42ab5ca7-7f46-4090-8a4a-b787d44a3c21', '1aa9fcc8-5990-4c3b-9ae5-5b3f944ba545', '9a3381b4-a109-406c-9a5d-8eba2b6d1fb7'),
('7a9bec9d-e4a7-4292-9750-bdd932b17805', 'fccf49e4-9524-41f6-9341-85169f1bbc9d', '538e45bd-e04b-4adc-bfd7-07a378b4efe7'),
('88e7daa1-851d-471f-9437-f70c5ffe6350', '4f2c647a-8d88-4d1b-b905-994e6aba3551', '100427dd-d847-4d58-9dc8-5ad43d51c4a2'),
('b55985c4-4eb5-4c16-b055-5f93cfe8f4c5', '4f2c647a-8d88-4d1b-b905-994e6aba3551', '9d242872-1401-4f67-bc8f-7b3b5fdfefc6'),
('b88816c3-d344-4be4-bbbe-25a5249b98a4', '5d6d0d3c-c6b6-4274-91dd-6989a41f5a34', '90329fd9-3b76-4b6c-9556-78b7c9882c6f'),
('b8ae0d86-22c1-414f-adbd-77981ae8a8ed', 'be8bc548-3b11-4f78-a8b5-958f6bdac51f', 'adc77c4c-f5c2-43af-941e-bf11c31bed83'),
('bddef40a-0de2-4574-a2f3-931b81886e8f', '40423268-a473-4221-a809-3293216b913a', 'ea7696d7-582e-4521-93d7-9ccf674583e8'),
('c20de4f7-3365-44f0-bac5-a7dc8fc682aa', '4f2c647a-8d88-4d1b-b905-994e6aba3551', 'fc1af2f2-7c6d-43fe-ae25-ae9dac3db0a2'),
('c465d4b4-7bad-4786-acec-25d379847646', '5c97a5c6-64f4-4ff8-ae04-a18afe578206', '202c68bc-13cf-4f74-b44b-8eb11a21aa06'),
('ca2f9614-0bbf-45bb-a17e-99d05a9b15b3', '76a427de-3487-4b58-948a-7de408b61e98', 'dc62c4c7-6565-4b5f-95d4-4b7f33cdbbcb'),
('df238da1-ff7c-490b-8331-3fab475a5845', '1aa9fcc8-5990-4c3b-9ae5-5b3f944ba545', '604ba1cd-406a-45c9-b967-1dd91f3ae24b'),
('e9d1c178-8267-4209-ad1f-2202db35e96e', '1aa9fcc8-5990-4c3b-9ae5-5b3f944ba545', '2ccd1eb0-295c-4686-96ba-afc52250ec7d');

-- --------------------------------------------------------

--
-- Table structure for table `gender`
--

CREATE TABLE `gender` (
  `gender_id` varchar(50) NOT NULL,
  `gender_name` varchar(6) NOT NULL,
  `created_user_id` varchar(50) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `isactive` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gender`
--

INSERT INTO `gender` (`gender_id`, `gender_name`, `created_user_id`, `created_date`, `modified_date`, `isactive`) VALUES
('46d631d6-7bfd-49b5-8c62-3b66b012db97', 'Male', '919900001201', '2017-11-08 15:01:09', '2017-11-08 09:31:09', 1),
('6829c2fa-7912-4c61-a747-a730e8bd9188', 'Female', '919900001201', '2017-11-08 15:01:19', '2017-11-08 09:31:19', 1);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `group_id` varchar(50) NOT NULL,
  `group_name` varchar(50) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_user_id` varchar(50) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_user_id` varchar(50) NOT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`group_id`, `group_name`, `is_active`, `created_user_id`, `created_date`, `modified_user_id`, `modified_date`) VALUES
('00869138-76a8-46b8-b851-45204fa3081d', 'for', 1, '918151913741', '2017-12-18 13:16:03', '918151913741', '2017-12-18 13:16:03'),
('052a417b-72f1-475d-a160-bfef41b879b7', 'fj', 1, '918151913741', '2017-12-19 07:28:33', '918151913741', '2017-12-20 06:37:10'),
('108fe61e-b6bf-4f9f-bad6-7728f6de5a5a', 'group three', 1, '919738849769', '2017-12-15 13:46:58', '919738849769', '2017-12-15 13:46:58'),
('18fcd347-7c11-402f-b047-5e17e0ce4292', 'edited', 1, '918892452332', '2017-12-27 15:47:36', '918892452332', '2017-12-27 19:30:45'),
('1da1c859-5b7b-4d68-95e2-9a1aa0d10e8a', 'if show', 1, '918151913741', '2017-12-18 13:34:58', '918151913741', '2017-12-18 13:34:58'),
('1f6fc39a-129f-4f31-b1de-c98665d4986d', 'my group one', 1, '919738849769', '2017-12-15 11:58:05', '919738849769', '2017-12-15 11:58:05'),
('39b00bee-cb1e-408f-9a70-47afe537ab1e', 'fresh group sharing content', 1, '918892452332', '2017-12-27 19:32:39', '918892452332', '2017-12-27 19:32:39'),
('3f6265c6-95e9-44bd-ae54-f64886a60064', 'fourth', 1, '918105447982', '2017-12-19 11:53:07', '918105447982', '2017-12-19 11:53:07'),
('4136b0a2-e38c-4862-ad87-8cbde5c6e74e', 'hid', 1, '918523651236', '2018-01-16 06:37:32', '918523651236', '2018-01-16 06:37:32'),
('5c57254e-1761-4428-8def-1c65e08441fe', 'group created second time while sharing content', 1, '919738849769', '2017-12-16 21:21:19', '919738849769', '2017-12-16 21:21:19'),
('62e63cd7-24c9-4267-9893-4c6d2df98303', 'ABCD', 1, '254703576893', '2017-12-15 10:15:45', '254703576893', '2017-12-15 10:15:45'),
('64094e84-f7e9-4cf3-8e31-a6b9ea2a87a9', 'gersgjvh', 1, '919738849769', '2017-12-18 10:19:35', '919738849769', '2017-12-18 10:19:35'),
('6686c21f-4a23-42d7-84dc-ff88496477b6', 'group five', 1, '919738849769', '2017-12-15 14:18:40', '919738849769', '2017-12-15 14:18:40'),
('71652852-ca05-4204-9f6b-542f53bd6e00', 'fresh group', 1, '918892452332', '2017-12-27 19:31:17', '918892452332', '2017-12-27 19:31:17'),
('7b565d22-5b70-438a-a4c2-6b6c8f501103', 'fd', 1, '918151913741', '2017-12-18 13:31:09', '918151913741', '2017-12-18 13:31:09'),
('7d8644b9-edbb-4f6d-893d-2479a55cf5a2', 'group two', 1, '918892452332', '2017-12-20 13:15:11', '918892452332', '2017-12-20 13:15:11'),
('7e7f6f2f-d83c-490c-ae6c-25a3bba1c43d', 'Mobility', 1, '918151913741', '2017-12-18 13:27:30', '918151913741', '2017-12-18 13:27:30'),
('80690814-12e2-4f5a-a689-a61c503d1738', 'ydkydkyddkyxky', 1, '919738849769', '2017-12-15 11:46:57', '919738849769', '2017-12-15 11:46:57'),
('816fd706-aa57-4117-b024-06fdd9243c43', 'ggggggg', 1, '918892452332', '2017-12-27 14:45:32', '918892452332', '2017-12-27 14:45:32'),
('87d51380-8df4-4738-bbdb-af50489d87f9', 'grp1', 1, '918151913741', '2017-12-19 07:04:20', '918151913741', '2017-12-19 07:04:20'),
('8e790259-7657-4c2c-9966-b9b9396c28b4', 'group new two', 1, '918892452332', '2017-12-27 14:42:42', '918892452332', '2017-12-27 14:42:42'),
('8f22e5b2-72cb-488a-8542-ff75d20f9abc', 'final group created', 1, '919738849769', '2017-12-16 21:26:31', '919738849769', '2017-12-16 21:26:31'),
('93927227-8f8c-4bfa-a302-c3dfd9eba9fa', 'group new one', 1, '918892452332', '2017-12-27 14:42:02', '918892452332', '2017-12-27 14:42:02'),
('a610842c-46ab-48c7-aa5b-804371e12547', 'second', 1, '918105447982', '2017-12-18 12:48:59', '918105447982', '2017-12-18 12:48:59'),
('af30e8b8-10c8-448e-ab13-efb8ada0e7ac', 'group created for manage', 1, '919738849769', '2017-12-16 21:27:47', '919738849769', '2017-12-16 21:27:47'),
('b2f40ecc-4487-4889-8169-9eb71eb7ff9b', 'first', 1, '918105447982', '2017-12-18 12:48:50', '918105447982', '2017-12-18 12:48:50'),
('be36dbe0-0ac2-40b1-bc6a-0ec1c45f5c33', 'asdghj', 1, '918892452332', '2017-12-21 10:29:37', '918892452332', '2017-12-21 10:29:37'),
('c30d0521-5818-470d-97ac-e51788fb79d3', 'group two', 1, '919738849769', '2017-12-15 12:54:49', '919738849769', '2017-12-15 12:54:49'),
('ce1baa75-93d7-47a0-ac69-8f44f7e0435e', 'group eight', 1, '919738849769', '2017-12-15 14:42:23', '919738849769', '2017-12-15 14:42:23'),
('cec84268-fa53-4a49-b0aa-dffc723ca27d', 'jgskgdg', 1, '919738849769', '2017-12-15 13:50:12', '919738849769', '2017-12-15 13:50:12'),
('d1ca6888-0502-4569-99ab-a9133d261f77', 'Last Year', 1, '919999988888', '2017-12-28 12:00:40', '919999988888', '2017-12-28 12:00:40'),
('da552638-1092-43c4-99df-a91e7ec0349b', 'group four', 1, '918892452332', '2017-12-27 14:43:09', '918892452332', '2017-12-27 14:43:09'),
('df9d1c49-d81e-4f58-9c65-0e461274ab20', 'new group one edited', 1, '918892452332', '2017-12-18 10:24:33', '918892452332', '2017-12-27 19:31:05'),
('e7050d18-c474-47a8-bad5-0e34f58f454b', 'third', 1, '918105447982', '2017-12-19 09:57:30', '918105447982', '2017-12-19 09:57:30'),
('ebf4605a-fcf6-4c97-ad62-cabba95fb712', 'group four', 1, '919738849769', '2017-12-15 14:15:45', '919738849769', '2017-12-15 14:15:45'),
('f173825e-7827-45f4-9b1e-72421899cbc1', 'group seven', 1, '919738849769', '2017-12-15 14:34:47', '919738849769', '2017-12-15 14:34:47'),
('fa1d0d25-d874-484e-84ad-33ea559b5603', 'group created while sharing content', 1, '919738849769', '2017-12-16 21:15:15', '919738849769', '2017-12-16 21:15:15');

-- --------------------------------------------------------

--
-- Table structure for table `group_content`
--

CREATE TABLE `group_content` (
  `group_content_id` varchar(45) NOT NULL,
  `group_id` varchar(45) DEFAULT NULL,
  `content_id` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `group_content`
--

INSERT INTO `group_content` (`group_content_id`, `group_id`, `content_id`) VALUES
('042b5ea2-3ef8-4be6-88ae-54c6e5391253', 'da552638-1092-43c4-99df-a91e7ec0349b', 'a4f7fc73-df21-4e72-87b8-4749c0d502cb'),
('0b542a31-2b96-4249-8b4e-29b43515499a', '93927227-8f8c-4bfa-a302-c3dfd9eba9fa', '16134798-6f1a-4b16-b097-f92b9d73f710'),
('0eee45aa-5423-4b11-a40e-3b1eadc39214', 'df9d1c49-d81e-4f58-9c65-0e461274ab20', '9a9b7680-a029-462e-9ab0-149fcd87cbc9'),
('189b8244-c053-4029-8713-6d008a146891', '816fd706-aa57-4117-b024-06fdd9243c43', 'e95eb987-0831-43f7-906e-a2abc014df9c'),
('194391f2-2e28-4acf-97c8-dabf25116df1', 'da552638-1092-43c4-99df-a91e7ec0349b', 'e95eb987-0831-43f7-906e-a2abc014df9c'),
('1bccb114-1cce-4b3c-b6ad-1c8b3a6a7fb2', '18fcd347-7c11-402f-b047-5e17e0ce4292', 'e95eb987-0831-43f7-906e-a2abc014df9c'),
('1d07c46f-28a9-4067-91d2-a09fc18e8635', '0', '70d49999-a4b7-4ef6-8510-cdcd1ed46bd7'),
('228f61d9-f804-4084-817e-e9c07ff04499', '8e790259-7657-4c2c-9966-b9b9396c28b4', 'd91efd6f-b55a-4c1e-a96f-34b3698bac72'),
('2afb0110-42c6-49a5-85ba-831ab63c4646', '8e790259-7657-4c2c-9966-b9b9396c28b4', '16134798-6f1a-4b16-b097-f92b9d73f710'),
('2c454bd6-8267-499f-888d-a7cf470bb550', '1da1c859-5b7b-4d68-95e2-9a1aa0d10e8a', '09312597-3c06-4168-8c68-128b24bd63c4'),
('329313a1-f0fa-47a3-8558-24e641deef6f', '18fcd347-7c11-402f-b047-5e17e0ce4292', 'd91efd6f-b55a-4c1e-a96f-34b3698bac72'),
('32d7dbab-9af3-4d43-b1fb-430c4ce140af', '1da1c859-5b7b-4d68-95e2-9a1aa0d10e8a', '25ce488d-067b-475a-a655-1323434f29f0'),
('3ae827a7-1b6f-493c-bbcb-30aff3a81f88', '816fd706-aa57-4117-b024-06fdd9243c43', 'de9d36a9-0fe0-4b8e-9935-a6f5a84a71cf'),
('3ee233b9-fbaa-403b-b514-3575fdc07189', 'da552638-1092-43c4-99df-a91e7ec0349b', '5f68742c-0e59-4c68-83b0-408e26833041'),
('3f113547-40e0-42b6-965c-ae70a147d872', '39b00bee-cb1e-408f-9a70-47afe537ab1e', 'd91efd6f-b55a-4c1e-a96f-34b3698bac72'),
('3fed5f80-d9c9-4ba1-8bd3-2dc1ff271380', '71652852-ca05-4204-9f6b-542f53bd6e00', 'de9d36a9-0fe0-4b8e-9935-a6f5a84a71cf'),
('42c0b9e0-be23-45f4-9af0-3a2963184e2c', 'e7050d18-c474-47a8-bad5-0e34f58f454b', '9a0941ca-a615-424f-82cb-a75b2a233fb2'),
('45b32b70-8a78-4bbe-877c-3726c69283cd', '18fcd347-7c11-402f-b047-5e17e0ce4292', '5f68742c-0e59-4c68-83b0-408e26833041'),
('4796db59-11f3-4aa2-895e-b7a51a0bbd02', '18fcd347-7c11-402f-b047-5e17e0ce4292', 'de9d36a9-0fe0-4b8e-9935-a6f5a84a71cf'),
('4b35b4b1-61af-4096-a345-b19f12692f88', '00869138-76a8-46b8-b851-45204fa3081d', '44526186-270f-413c-a1e9-cfc7e0333e2d'),
('5496f044-4e69-4bb1-926d-5604662f8c28', '0', '8ccce5fa-b902-4497-b99f-db603c190db5'),
('560104fc-c0d1-44bb-8581-520700c52443', 'b2f40ecc-4487-4889-8169-9eb71eb7ff9b', 'f719262c-5c2a-4911-bf66-e06bd53095a1'),
('5974bafe-e3ab-4ce2-97ec-2ff54dc3f175', '7d8644b9-edbb-4f6d-893d-2479a55cf5a2', '5f68742c-0e59-4c68-83b0-408e26833041'),
('5f1a5b53-3b36-4355-9170-ddab21fac713', 'b2f40ecc-4487-4889-8169-9eb71eb7ff9b', '3b709af5-e50d-4e67-b4e8-d7feb668d2d8'),
('63f21740-55f4-4ff9-9f8a-422d314ac414', 'a610842c-46ab-48c7-aa5b-804371e12547', 'ccc81664-71a6-4143-a518-ef08ec18aa5a'),
('72b22a62-9444-4762-a060-8609cb9824f8', '816fd706-aa57-4117-b024-06fdd9243c43', 'd91efd6f-b55a-4c1e-a96f-34b3698bac72'),
('72fa2c14-cf4a-4496-b40b-f53c8edd5dc0', '816fd706-aa57-4117-b024-06fdd9243c43', '16134798-6f1a-4b16-b097-f92b9d73f710'),
('75d6eea8-764d-41a1-a431-a74f83e8b5b4', 'be36dbe0-0ac2-40b1-bc6a-0ec1c45f5c33', '5f68742c-0e59-4c68-83b0-408e26833041'),
('7cbd0a28-b6d1-49a4-b95a-364943aa3e69', 'b2f40ecc-4487-4889-8169-9eb71eb7ff9b', '8ea76aaa-518e-4050-8d64-853bca89985a'),
('839dcd31-50f5-40b9-8228-07bd4f362f82', 'da552638-1092-43c4-99df-a91e7ec0349b', '16134798-6f1a-4b16-b097-f92b9d73f710'),
('83b579a6-322e-4ee2-80b4-37a48bcffc1e', '0', 'a80d8590-a270-43e2-933f-bed14683e04d'),
('8bef1a2b-cfa9-4a60-b5c0-bbe37cee29ee', '7b565d22-5b70-438a-a4c2-6b6c8f501103', '09312597-3c06-4168-8c68-128b24bd63c4'),
('8c1dfed8-f195-4253-81ea-5c03175a028f', '93927227-8f8c-4bfa-a302-c3dfd9eba9fa', '5f68742c-0e59-4c68-83b0-408e26833041'),
('8d80d5a2-b2b7-4b64-bfd3-da0dac055361', '0', 'a80d8590-a270-43e2-933f-bed14683e04d'),
('9678d575-b697-47d6-b2ab-087d209c53b7', 'a610842c-46ab-48c7-aa5b-804371e12547', 'f719262c-5c2a-4911-bf66-e06bd53095a1'),
('996612bc-15a5-4424-89cb-4810078b8d37', '87d51380-8df4-4738-bbdb-af50489d87f9', 'd28a385c-ffa5-4435-a0a8-c7da6fad2693'),
('a6a3e7dd-33c7-4366-81df-cc797935fc09', '8e790259-7657-4c2c-9966-b9b9396c28b4', '5f68742c-0e59-4c68-83b0-408e26833041'),
('a7b66f2a-f77b-4fce-b947-7b1661dd4739', 'df9d1c49-d81e-4f58-9c65-0e461274ab20', '74898d83-e230-4d33-b8f3-894c8362c380'),
('a851e4db-cade-4f3b-9542-cbe72ed27089', '0', '82645ffb-0ce5-49d5-afaa-4d2ccf655215'),
('aa63db25-cfaf-461a-b50b-ca199a13d9b0', 'a610842c-46ab-48c7-aa5b-804371e12547', '59534722-7747-48ed-8c66-313eec553133'),
('aa891bbd-fe6d-4baf-8961-76ed413812c1', '1da1c859-5b7b-4d68-95e2-9a1aa0d10e8a', '44526186-270f-413c-a1e9-cfc7e0333e2d'),
('acd41c10-f93c-4488-b022-ba8295230f76', 'a610842c-46ab-48c7-aa5b-804371e12547', '3b709af5-e50d-4e67-b4e8-d7feb668d2d8'),
('af3eab62-c328-4de7-8d67-14efe0dbfa72', '816fd706-aa57-4117-b024-06fdd9243c43', '5f68742c-0e59-4c68-83b0-408e26833041'),
('b1141b37-9980-44ef-901d-60b7141efa90', '0', '34e51fa5-b24f-4404-9939-1043223ef5db'),
('b64c87c0-297a-492e-8eb0-f58e6d1ef25d', 'da552638-1092-43c4-99df-a91e7ec0349b', 'd91efd6f-b55a-4c1e-a96f-34b3698bac72'),
('b7200d34-fd2b-4816-b1e9-7eaa5a9157bc', '816fd706-aa57-4117-b024-06fdd9243c43', 'a4f7fc73-df21-4e72-87b8-4749c0d502cb'),
('c9f7bf77-f213-4c75-a266-e44f683281b3', 'df9d1c49-d81e-4f58-9c65-0e461274ab20', '5f68742c-0e59-4c68-83b0-408e26833041'),
('d4cea3da-ecb8-4e94-973f-46eb7128f7f4', '93927227-8f8c-4bfa-a302-c3dfd9eba9fa', 'd91efd6f-b55a-4c1e-a96f-34b3698bac72'),
('d6203098-ecf2-46ea-b35b-b5368c8bcf59', 'a610842c-46ab-48c7-aa5b-804371e12547', '8ea76aaa-518e-4050-8d64-853bca89985a'),
('d66e8aff-a46c-43c2-a54f-e96a303236f4', '3f6265c6-95e9-44bd-ae54-f64886a60064', '9a0941ca-a615-424f-82cb-a75b2a233fb2'),
('d7ea7bae-0caa-468c-b51e-82651051a4c5', 'df9d1c49-d81e-4f58-9c65-0e461274ab20', 'f6baa846-ce3b-4a5b-9671-e042180a898b'),
('de851461-6ac6-4596-85a2-6c0300db8c8a', '052a417b-72f1-475d-a160-bfef41b879b7', 'd28a385c-ffa5-4435-a0a8-c7da6fad2693'),
('df64c7ed-b223-47c5-98c4-752686eb7d01', '0', '784cc7f9-4b5b-4e30-8491-b16a5e531a14'),
('e1274c02-9da5-41e6-9a66-7ea672a235fa', '0', '70d49999-a4b7-4ef6-8510-cdcd1ed46bd7'),
('e1f270b8-aa1a-45d0-bfa8-1ef53da8dcf2', 'be36dbe0-0ac2-40b1-bc6a-0ec1c45f5c33', 'bc169ec3-dc5a-4a54-bc69-2f7c5cd661fe'),
('ec705c72-5982-43f5-bcac-85957cd00afa', '0', '1a157db7-c61d-4dcf-8225-92b23e1ee55d'),
('fa81639e-dcc2-4a57-aeeb-f8f5f1f8fb77', '052a417b-72f1-475d-a160-bfef41b879b7', '09312597-3c06-4168-8c68-128b24bd63c4'),
('fd184a26-4056-498b-a772-96a67f8ede40', '18fcd347-7c11-402f-b047-5e17e0ce4292', '16134798-6f1a-4b16-b097-f92b9d73f710'),
('ff20ce97-e2d5-49a4-9e88-5e0a2717df83', '71652852-ca05-4204-9f6b-542f53bd6e00', 'd91efd6f-b55a-4c1e-a96f-34b3698bac72');

-- --------------------------------------------------------

--
-- Table structure for table `group_user`
--

CREATE TABLE `group_user` (
  `group_user_id` varchar(50) NOT NULL,
  `group_id` varchar(50) NOT NULL,
  `user_id` varchar(45) NOT NULL,
  `created_user_id` varchar(50) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `group_user`
--

INSERT INTO `group_user` (`group_user_id`, `group_id`, `user_id`, `created_user_id`, `created_date`) VALUES
('00733e9d-7d25-4533-8063-f3752506f834', '3f6265c6-95e9-44bd-ae54-f64886a60064', '918151913742', '918105447982', '2017-12-19 11:53:07'),
('02adc030-dfb7-48fb-9d0f-380d86e9516a', 'df9d1c49-d81e-4f58-9c65-0e461274ab20', '918105447982', '918892452332', '2017-12-18 10:24:33'),
('02b5159f-6e38-48c1-b710-86abb2b935a6', '816fd706-aa57-4117-b024-06fdd9243c43', '919632357734', '918892452332', '2017-12-27 14:45:32'),
('02d8c737-ed23-4800-b73a-d7663d27efcd', '4136b0a2-e38c-4862-ad87-8cbde5c6e74e', '917708102496', '918523651236', '2018-01-16 06:37:32'),
('050fbb73-698d-489f-a7ec-dc459ce823bb', '3f6265c6-95e9-44bd-ae54-f64886a60064', '918151913741', '918105447982', '2017-12-19 11:53:07'),
('062db1b5-cb7a-4ac0-a38e-20761517623d', 'b2f40ecc-4487-4889-8169-9eb71eb7ff9b', '918151913742', '918105447982', '2017-12-18 12:48:50'),
('065a6616-5a09-4bf1-9bfe-504e6295a41e', '71652852-ca05-4204-9f6b-542f53bd6e00', '918105447982', '918892452332', '2017-12-27 19:31:17'),
('06759939-f162-4c43-a92b-6295a252096e', 'e7050d18-c474-47a8-bad5-0e34f58f454b', '917019088381', '918105447982', '2017-12-19 09:57:30'),
('08288107-0458-4f59-929b-52208699280a', '93927227-8f8c-4bfa-a302-c3dfd9eba9fa', '918888888888', '918892452332', '2017-12-27 14:42:02'),
('08e62d32-bbf0-4f2d-b09c-361a64e1b818', '816fd706-aa57-4117-b024-06fdd9243c43', '918867528736', '918892452332', '2017-12-27 19:45:12'),
('09cd78de-51cd-4fc5-9605-c57b2736c69a', 'df9d1c49-d81e-4f58-9c65-0e461274ab20', '919738849769', '918892452332', '2017-12-18 10:24:33'),
('0a054d1d-572d-4ca5-b0bb-b2acc5c77f99', 'cec84268-fa53-4a49-b0aa-dffc723ca27d', '918867528736', '919738849769', '2017-12-15 13:50:12'),
('0cd07f15-690b-411f-9e4c-cb15c804a1f1', '8e790259-7657-4c2c-9966-b9b9396c28b4', '918867528736', '918892452332', '2017-12-27 14:42:42'),
('0e27dfa6-d78e-4642-baac-2b79b252edc6', '64094e84-f7e9-4cf3-8e31-a6b9ea2a87a9', '919738849769', '919738849769', '2017-12-18 10:19:35'),
('0f0d983f-c4cc-4da7-b712-1c146e39c021', 'f173825e-7827-45f4-9b1e-72421899cbc1', '918151913741', '919738849769', '2017-12-15 14:34:47'),
('0f3c6af7-dbce-447f-9e78-4673df296872', '8f22e5b2-72cb-488a-8542-ff75d20f9abc', '918151913741', '919738849769', '2017-12-16 21:26:31'),
('114d5455-0fb7-40f7-b457-7f37f039b891', '7e7f6f2f-d83c-490c-ae6c-25a3bba1c43d', '919738849769', '918151913741', '2017-12-18 13:27:30'),
('12e9b6b6-f143-420c-97c8-ba48cc7e6d6c', '1f6fc39a-129f-4f31-b1de-c98665d4986d', '918151913741', '919738849769', '2017-12-15 11:58:05'),
('152141ef-4273-4c0d-8362-9237e85f1acf', '80690814-12e2-4f5a-a689-a61c503d1738', '918151913741', '919738849769', '2017-12-15 11:46:57'),
('15959df7-97bb-4cf8-bfa9-4837628f2ae5', '5c57254e-1761-4428-8def-1c65e08441fe', '918867528736', '919738849769', '2017-12-16 21:21:19'),
('175d3101-9fd3-4143-82e6-0f4037936f42', '8e790259-7657-4c2c-9966-b9b9396c28b4', '918151913741', '918892452332', '2017-12-27 14:42:42'),
('1821f7a5-59b2-4b20-ae83-d3b30b0edc7f', '00869138-76a8-46b8-b851-45204fa3081d', '918151913741', '918151913741', '2017-12-18 13:16:03'),
('19541e86-5bd3-4b8f-9714-64365120bb89', '80690814-12e2-4f5a-a689-a61c503d1738', '919632357734', '919738849769', '2017-12-15 11:46:57'),
('1d05aa44-a67a-4f5e-b29f-64da3bdd4c52', '39b00bee-cb1e-408f-9a70-47afe537ab1e', '918867528736', '918892452332', '2017-12-27 19:32:39'),
('1d7b70ac-d29e-4215-9a26-00e6056d145b', 'b2f40ecc-4487-4889-8169-9eb71eb7ff9b', '918151913741', '918105447982', '2017-12-18 12:48:50'),
('1e39a33a-1f92-4bcd-bd36-3982acedc13f', 'fa1d0d25-d874-484e-84ad-33ea559b5603', '918867528736', '919738849769', '2017-12-16 21:15:15'),
('1f92bc29-f010-4871-a36c-6702c5a2bc9f', 'be36dbe0-0ac2-40b1-bc6a-0ec1c45f5c33', '918105447982', '918892452332', '2017-12-21 10:29:37'),
('20abb7fa-bab5-4a71-8d20-b694bbb1e43a', 'da552638-1092-43c4-99df-a91e7ec0349b', '919738849769', '918892452332', '2017-12-27 14:43:09'),
('22233453-d16c-42d9-a4b5-5769cbddc962', 'ce1baa75-93d7-47a0-ac69-8f44f7e0435e', '918867528736', '919738849769', '2017-12-15 14:42:23'),
('2321c056-354d-4025-b730-405bc9588383', '39b00bee-cb1e-408f-9a70-47afe537ab1e', '918105447982', '918892452332', '2017-12-27 19:32:39'),
('265b0589-274f-49a9-a02d-11875bc5eff5', '5c57254e-1761-4428-8def-1c65e08441fe', '918151913741', '919738849769', '2017-12-16 21:21:19'),
('2686a73e-1321-4b6d-b443-db1354a7d9ca', 'c30d0521-5818-470d-97ac-e51788fb79d3', '918151913741', '919738849769', '2017-12-15 12:54:49'),
('2758133c-7739-439d-b424-558b9a3a244d', '7d8644b9-edbb-4f6d-893d-2479a55cf5a2', '918151913741', '918892452332', '2017-12-20 13:15:11'),
('28131ee7-7dfb-4f5b-9fbf-f8f86a717599', '64094e84-f7e9-4cf3-8e31-a6b9ea2a87a9', '919632357734', '919738849769', '2017-12-18 10:19:35'),
('299472ff-8e89-44ad-99e7-164b575f59ab', '1da1c859-5b7b-4d68-95e2-9a1aa0d10e8a', '919738849769', '918151913741', '2017-12-18 13:34:58'),
('2ae8fce8-281d-408c-a089-94ae8d5a4c26', '18fcd347-7c11-402f-b047-5e17e0ce4292', '918867528736', '918892452332', '2017-12-27 15:47:36'),
('2b92bd5f-4d7e-4fa9-8de4-9af32d269332', '052a417b-72f1-475d-a160-bfef41b879b7', '918105447982', '918151913741', '2017-12-19 07:28:33'),
('2ea9f1c4-9fbc-41f5-9581-ac6950a27664', 'da552638-1092-43c4-99df-a91e7ec0349b', '918151913741', '918892452332', '2017-12-27 14:43:09'),
('2ffcfabe-dfed-4ffe-b118-9001d4ff1f6c', '7b565d22-5b70-438a-a4c2-6b6c8f501103', '918151913741', '918151913741', '2017-12-18 13:31:09'),
('318fdd65-6d38-4c7d-8adc-819a0a0057ce', '052a417b-72f1-475d-a160-bfef41b879b7', '918151913741', '918151913741', '2017-12-19 07:28:33'),
('343096dc-ac7f-4abf-a5a3-ac4bdf23bf4f', '108fe61e-b6bf-4f9f-bad6-7728f6de5a5a', '918105447982', '919738849769', '2017-12-15 13:46:58'),
('3526d2e4-c3ec-4752-915d-c107be24f1da', '5c57254e-1761-4428-8def-1c65e08441fe', '919632357734', '919738849769', '2017-12-16 21:21:19'),
('3602a792-0944-4dab-84a0-0cb64703794d', '6686c21f-4a23-42d7-84dc-ff88496477b6', '918867528736', '919738849769', '2017-12-15 14:18:40'),
('36fb89cb-2722-42b1-9aa7-8a19720d056f', '4136b0a2-e38c-4862-ad87-8cbde5c6e74e', '919738849769', '918523651236', '2018-01-16 06:37:32'),
('38a093bf-eed8-40c7-8261-35ecc55a9b43', 'd1ca6888-0502-4569-99ab-a9133d261f77', '918888888888', '919999988888', '2017-12-28 12:00:40'),
('3aaad2df-213b-4fa1-a3b3-c5d8c4f1ebf5', '7e7f6f2f-d83c-490c-ae6c-25a3bba1c43d', '919629108196', '918151913741', '2017-12-18 13:59:36'),
('3ca3ac76-7d82-4f73-a355-fe02464e2ec0', '8e790259-7657-4c2c-9966-b9b9396c28b4', '918105447982', '918892452332', '2017-12-27 14:42:42'),
('4207a2a7-78ab-4f29-8251-5c68f5d164f6', 'da552638-1092-43c4-99df-a91e7ec0349b', '918105447982', '918892452332', '2017-12-27 14:43:09'),
('42a246d2-eee1-4442-bb15-61f78bf6d472', 'b2f40ecc-4487-4889-8169-9eb71eb7ff9b', '917019088381', '918105447982', '2017-12-18 12:48:50'),
('44fb2098-9f4f-4461-b807-3c82970b8695', 'af30e8b8-10c8-448e-ab13-efb8ada0e7ac', '918105447982', '919738849769', '2017-12-16 21:27:47'),
('485976d5-5380-446a-943b-651dffaff3cc', '1da1c859-5b7b-4d68-95e2-9a1aa0d10e8a', '919629108196', '918151913741', '2017-12-18 13:34:58'),
('4ae26860-6427-48b1-8ccb-af57edd42f1f', '93927227-8f8c-4bfa-a302-c3dfd9eba9fa', '918151913741', '918892452332', '2017-12-27 14:42:02'),
('4afe500c-0be8-4457-b04e-bfce32bbc648', 'a610842c-46ab-48c7-aa5b-804371e12547', '918151913742', '918105447982', '2017-12-18 12:48:59'),
('4c97a8fd-8693-44c5-a2b4-fe58308445c8', 'fa1d0d25-d874-484e-84ad-33ea559b5603', '918151913741', '919738849769', '2017-12-16 21:15:15'),
('4cf76a09-950e-495b-9b25-1acd5d9f672c', '64094e84-f7e9-4cf3-8e31-a6b9ea2a87a9', '918151913741', '919738849769', '2017-12-18 10:19:35'),
('51423a82-f5ef-4f29-b14e-877f668cf832', '6686c21f-4a23-42d7-84dc-ff88496477b6', '918105447982', '919738849769', '2017-12-15 14:18:40'),
('52c78e84-2e98-488f-870c-ebd611eabcc7', '00869138-76a8-46b8-b851-45204fa3081d', '919738849769', '918151913741', '2017-12-19 07:10:10'),
('5771913c-1e4a-4ca4-8430-fbd475f899db', 'da552638-1092-43c4-99df-a91e7ec0349b', '918867528736', '918892452332', '2017-12-27 14:43:09'),
('581261fe-588b-44ea-83ae-9ef78f86e3ef', 'e7050d18-c474-47a8-bad5-0e34f58f454b', '918151913742', '918105447982', '2017-12-19 09:57:30'),
('5c20498a-2e36-428d-bff4-0a62dbfe73d1', '7d8644b9-edbb-4f6d-893d-2479a55cf5a2', '918867528736', '918892452332', '2017-12-20 13:15:11'),
('5e351b7f-b66e-45dc-8d31-416253a47756', 'ce1baa75-93d7-47a0-ac69-8f44f7e0435e', '918151913741', '919738849769', '2017-12-15 14:42:23'),
('5f658ce2-c815-4f40-b576-6017d2553035', 'df9d1c49-d81e-4f58-9c65-0e461274ab20', '919632357734', '918892452332', '2017-12-18 10:24:33'),
('6142a252-72d2-4730-b6f9-4a9693452402', 'f173825e-7827-45f4-9b1e-72421899cbc1', '919738849769', '919738849769', '2017-12-15 14:34:47'),
('62ebf5c7-d0c9-4255-9b15-e7f44153a9b1', 'f173825e-7827-45f4-9b1e-72421899cbc1', '918867528736', '919738849769', '2017-12-15 14:34:47'),
('636436df-3155-4d58-8931-b5476948b3e6', '80690814-12e2-4f5a-a689-a61c503d1738', '919738849769', '919738849769', '2017-12-15 11:46:57'),
('63d37274-0eb2-4b47-afbf-73989c0f1884', '108fe61e-b6bf-4f9f-bad6-7728f6de5a5a', '919632357734', '919738849769', '2017-12-15 13:46:58'),
('655e172a-68f9-41c6-baf2-1261388c0b24', '80690814-12e2-4f5a-a689-a61c503d1738', '918105447982', '919738849769', '2017-12-15 11:46:57'),
('65f2f8f4-e081-4394-8933-f694a5ce9a4c', '816fd706-aa57-4117-b024-06fdd9243c43', '919738849769', '918892452332', '2017-12-27 14:45:32'),
('6712acd2-2460-4600-99d9-cbed54b35da7', '816fd706-aa57-4117-b024-06fdd9243c43', '918888888888', '918892452332', '2017-12-27 14:45:32'),
('67b86c98-bac3-4582-978d-b0c839c67ce1', '1f6fc39a-129f-4f31-b1de-c98665d4986d', '918105447982', '919738849769', '2017-12-15 11:58:05'),
('69ac8020-2c01-4da4-a720-b3bb6190f588', '8e790259-7657-4c2c-9966-b9b9396c28b4', '918888888888', '918892452332', '2017-12-27 14:42:42'),
('6b93e3a2-43c5-4975-9112-9c9ba9b2a0a5', 'fa1d0d25-d874-484e-84ad-33ea559b5603', '918105447982', '919738849769', '2017-12-16 21:15:15'),
('6d693ebc-1e9e-400b-aec9-3de276cde2fe', '00869138-76a8-46b8-b851-45204fa3081d', '918105447982', '918151913741', '2017-12-19 07:06:01'),
('700aa4b1-4bc4-48fa-ba74-e1033ed3a09f', '6686c21f-4a23-42d7-84dc-ff88496477b6', '919738849769', '919738849769', '2017-12-15 14:18:40'),
('703aed07-6a81-4b89-88f1-0ad108386516', '64094e84-f7e9-4cf3-8e31-a6b9ea2a87a9', '918867528736', '919738849769', '2017-12-18 10:19:35'),
('704f2349-b5e5-46e0-961e-2f2c178c3c2e', 'ebf4605a-fcf6-4c97-ad62-cabba95fb712', '919738849769', '919738849769', '2017-12-15 14:15:45'),
('7b804257-b218-448b-b7ca-2afe49bcd347', 'be36dbe0-0ac2-40b1-bc6a-0ec1c45f5c33', '918151913741', '918892452332', '2017-12-21 10:29:37'),
('7cd6c640-fa84-4140-baf7-6b1f1d445d75', '7d8644b9-edbb-4f6d-893d-2479a55cf5a2', '919738849769', '918892452332', '2017-12-20 13:15:11'),
('7d7f6231-a8f1-4628-a347-5cf15e115a90', '87d51380-8df4-4738-bbdb-af50489d87f9', '918105447982', '918151913741', '2017-12-19 07:04:20'),
('7f2aa494-ddca-45a0-b867-5ebbe2b4291c', 'd1ca6888-0502-4569-99ab-a9133d261f77', '919738849769', '919999988888', '2017-12-28 12:00:40'),
('83055b9e-5a57-4386-b43e-28db8d1c033f', '8e790259-7657-4c2c-9966-b9b9396c28b4', '919738849769', '918892452332', '2017-12-27 14:42:42'),
('83820af3-9eb1-430d-bb24-eb87bb26c1e1', '00869138-76a8-46b8-b851-45204fa3081d', '918151913742', '918151913741', '2017-12-18 13:16:03'),
('851b0751-dae4-41c8-8722-1702dab9d4f6', 'ce1baa75-93d7-47a0-ac69-8f44f7e0435e', '919632357734', '919738849769', '2017-12-15 14:42:23'),
('88fade71-d7c3-46ab-bc76-591659c2519b', '71652852-ca05-4204-9f6b-542f53bd6e00', '918151913741', '918892452332', '2017-12-27 19:31:17'),
('89534e7e-a1fb-4dba-aca8-862e27a82b01', 'e7050d18-c474-47a8-bad5-0e34f58f454b', '918151913741', '918105447982', '2017-12-19 09:57:30'),
('896406df-6b34-408a-b290-21aba8217e52', 'a610842c-46ab-48c7-aa5b-804371e12547', '917019088381', '918105447982', '2017-12-18 12:48:59'),
('8cb71d6c-e392-40c5-a1fd-f4edc892d2fe', '7d8644b9-edbb-4f6d-893d-2479a55cf5a2', '918105447982', '918892452332', '2017-12-20 13:15:11'),
('8cc82cf6-c375-4839-bbc1-02cd88cc09f5', 'df9d1c49-d81e-4f58-9c65-0e461274ab20', '918151913741', '918892452332', '2017-12-18 10:24:33'),
('8dd38edc-5aac-44a4-9b49-c7cfda3c9b4b', '93927227-8f8c-4bfa-a302-c3dfd9eba9fa', '919632357734', '918892452332', '2017-12-27 14:42:02'),
('926a5673-22d3-4294-9ef2-1f6a00baf994', '87d51380-8df4-4738-bbdb-af50489d87f9', '918151913741', '918151913741', '2017-12-19 07:04:20'),
('93b24eb4-692c-412d-aa92-38ae07319403', '7d8644b9-edbb-4f6d-893d-2479a55cf5a2', '919632357734', '918892452332', '2017-12-20 13:15:11'),
('943f05ac-60be-4351-8b14-0b479e66474f', 'ebf4605a-fcf6-4c97-ad62-cabba95fb712', '918151913741', '919738849769', '2017-12-15 14:15:45'),
('95dc97d5-b4bb-49d8-925e-fd2086b28837', '6686c21f-4a23-42d7-84dc-ff88496477b6', '918151913741', '919738849769', '2017-12-15 14:18:40'),
('9640a183-e5f8-4bb5-8e91-07b2708846b8', 'cec84268-fa53-4a49-b0aa-dffc723ca27d', '918151913741', '919738849769', '2017-12-15 13:50:12'),
('969d4fe4-2f94-46e9-aac9-4610a21f07ce', '80690814-12e2-4f5a-a689-a61c503d1738', '918867528736', '919738849769', '2017-12-15 11:46:57'),
('973d0166-cf43-4e25-84f6-4700a4202186', 'ebf4605a-fcf6-4c97-ad62-cabba95fb712', '918867528736', '919738849769', '2017-12-15 14:15:45'),
('9a683a1c-015f-48a3-a9f0-184546bfb421', '8f22e5b2-72cb-488a-8542-ff75d20f9abc', '918867528736', '919738849769', '2017-12-16 21:26:31'),
('9f79f8b9-ec68-4c49-8236-5c045decd9bd', 'f173825e-7827-45f4-9b1e-72421899cbc1', '918105447982', '919738849769', '2017-12-15 14:34:47'),
('a070a487-a570-4463-bdf0-4bd8c7f3bca0', '108fe61e-b6bf-4f9f-bad6-7728f6de5a5a', '918867528736', '919738849769', '2017-12-15 13:46:58'),
('a0c59c47-3764-48e5-96a4-6cb95b7e040f', 'c30d0521-5818-470d-97ac-e51788fb79d3', '918105447982', '919738849769', '2017-12-15 12:54:49'),
('a1a5efc6-c600-46bc-86da-8d12ff065336', '7e7f6f2f-d83c-490c-ae6c-25a3bba1c43d', '918151913742', '918151913741', '2017-12-18 13:57:42'),
('a5e8b9c1-fb7b-43b4-a23b-3556d56e4047', '6686c21f-4a23-42d7-84dc-ff88496477b6', '919632357734', '919738849769', '2017-12-15 14:18:40'),
('a7e9204c-0ccf-414f-8a8c-2269a16d63a7', 'df9d1c49-d81e-4f58-9c65-0e461274ab20', '918867528736', '918892452332', '2017-12-18 10:24:33'),
('a8950c9c-82d5-47c5-9e2d-d16580f430b5', '62e63cd7-24c9-4267-9893-4c6d2df98303', '1234', '254703576893', '2017-12-15 10:15:45'),
('aa3df2f7-2861-4725-9554-4780f2dab886', '93927227-8f8c-4bfa-a302-c3dfd9eba9fa', '918867528736', '918892452332', '2017-12-27 14:42:02'),
('aa411101-f153-4118-94f8-5778e903f9a7', '7b565d22-5b70-438a-a4c2-6b6c8f501103', '918105447982', '918151913741', '2017-12-18 13:31:09'),
('b0b6d7ce-20ae-464d-9462-99e0f539fce4', 'fa1d0d25-d874-484e-84ad-33ea559b5603', '919738849769', '919738849769', '2017-12-16 21:15:15'),
('b0dcd57c-af83-4aba-ad16-72af215d2295', 'c30d0521-5818-470d-97ac-e51788fb79d3', '919738849769', '919738849769', '2017-12-15 12:54:49'),
('b0eb722c-b9d8-4802-9495-6b26ed7138a2', '39b00bee-cb1e-408f-9a70-47afe537ab1e', '918888888888', '918892452332', '2017-12-27 19:32:39'),
('b203be5f-30c7-4111-895c-efebfc67896e', 'af30e8b8-10c8-448e-ab13-efb8ada0e7ac', '919738849769', '919738849769', '2017-12-16 21:27:47'),
('bcdd7f4a-6344-485c-9279-f33d721d266f', 'ebf4605a-fcf6-4c97-ad62-cabba95fb712', '918105447982', '919738849769', '2017-12-15 14:15:45'),
('bce208be-f909-4d65-9548-9214da7f2ff2', 'ebf4605a-fcf6-4c97-ad62-cabba95fb712', '919632357734', '919738849769', '2017-12-15 14:15:45'),
('bd57d702-0e2a-44c4-a440-b5a62edbaa2e', '108fe61e-b6bf-4f9f-bad6-7728f6de5a5a', '919738849769', '919738849769', '2017-12-15 13:46:58'),
('bf898953-a429-4d05-8114-110a68b4f1b7', 'da552638-1092-43c4-99df-a91e7ec0349b', '919632357734', '918892452332', '2017-12-27 14:43:09'),
('c6448aa3-b2b3-4551-a09c-35fcb87c95ff', '1da1c859-5b7b-4d68-95e2-9a1aa0d10e8a', '918105447982', '918151913741', '2017-12-18 14:01:05'),
('c6f4e5bd-57fd-4bb1-a069-463e95706c10', 'cec84268-fa53-4a49-b0aa-dffc723ca27d', '919632357734', '919738849769', '2017-12-15 13:50:12'),
('c7051531-04c7-4b39-8002-819ab2a1858f', '5c57254e-1761-4428-8def-1c65e08441fe', '918105447982', '919738849769', '2017-12-16 21:21:19'),
('c7d32b5f-9168-461d-995c-6fc6b401f5ac', 'c30d0521-5818-470d-97ac-e51788fb79d3', '919632357734', '919738849769', '2017-12-15 12:54:49'),
('cabc693c-1e3d-47b4-9f61-056b0361a190', '64094e84-f7e9-4cf3-8e31-a6b9ea2a87a9', '918105447982', '919738849769', '2017-12-18 10:19:35'),
('cd63238d-1f6a-432c-9495-930d0ffe46d6', 'af30e8b8-10c8-448e-ab13-efb8ada0e7ac', '918151913741', '919738849769', '2017-12-16 21:27:47'),
('ce22125e-c62b-4a6b-832b-c9d4d6d82343', '3f6265c6-95e9-44bd-ae54-f64886a60064', '917019088381', '918105447982', '2017-12-19 11:53:07'),
('d0bcd492-cb83-49e9-9488-3e25a7f86410', 'fa1d0d25-d874-484e-84ad-33ea559b5603', '919632357734', '919738849769', '2017-12-16 21:15:15'),
('d1acece7-74ef-4dda-92eb-bf11647b2bdd', '5c57254e-1761-4428-8def-1c65e08441fe', '919738849769', '919738849769', '2017-12-16 21:21:19'),
('d1eb2010-96bb-464c-8baf-fbf88633db02', 'f173825e-7827-45f4-9b1e-72421899cbc1', '919632357734', '919738849769', '2017-12-15 14:34:47'),
('d72a1067-6bd1-4c12-be98-74a6a417b35b', '93927227-8f8c-4bfa-a302-c3dfd9eba9fa', '918105447982', '918892452332', '2017-12-27 14:42:02'),
('d7cfc981-81e4-4c3e-bed8-95805d358f49', 'af30e8b8-10c8-448e-ab13-efb8ada0e7ac', '918867528736', '919738849769', '2017-12-16 21:27:47'),
('d7d63501-54b5-4bd5-8dcd-e72f93397eb3', '8f22e5b2-72cb-488a-8542-ff75d20f9abc', '918105447982', '919738849769', '2017-12-16 21:26:31'),
('d7fba129-90a6-4908-ab22-3daf9d0c39ef', 'af30e8b8-10c8-448e-ab13-efb8ada0e7ac', '919632357734', '919738849769', '2017-12-16 21:27:47'),
('db70456e-ee41-485b-86fe-0197b88d73a7', 'ce1baa75-93d7-47a0-ac69-8f44f7e0435e', '919738849769', '919738849769', '2017-12-15 14:42:23'),
('dc6f7518-e041-455f-9bbd-055054184d37', '816fd706-aa57-4117-b024-06fdd9243c43', '918105447982', '918892452332', '2017-12-27 19:45:12'),
('dee7ac82-a47b-41ac-8f3c-8cc6edf96567', '18fcd347-7c11-402f-b047-5e17e0ce4292', '918888888888', '918892452332', '2017-12-27 19:30:45'),
('e552f34c-ca36-4b99-888e-e77e2c54841b', '108fe61e-b6bf-4f9f-bad6-7728f6de5a5a', '918151913741', '919738849769', '2017-12-15 13:46:58'),
('e6576a0b-4220-4a2d-9027-6cb9928a231e', '39b00bee-cb1e-408f-9a70-47afe537ab1e', '918151913741', '918892452332', '2017-12-27 19:32:39'),
('e8ee66e8-7773-402e-ad57-094b4375c05e', 'cec84268-fa53-4a49-b0aa-dffc723ca27d', '919738849769', '919738849769', '2017-12-15 13:50:12'),
('eb65cb81-3c49-4dbb-90c0-c2d526fb878d', '93927227-8f8c-4bfa-a302-c3dfd9eba9fa', '919738849769', '918892452332', '2017-12-27 14:42:02'),
('eef47395-67c4-4e2d-92a1-ae782be06ca1', '8f22e5b2-72cb-488a-8542-ff75d20f9abc', '919738849769', '919738849769', '2017-12-16 21:26:31'),
('ef475e67-2a0a-4ba9-be84-eca762ce1a41', '7e7f6f2f-d83c-490c-ae6c-25a3bba1c43d', '918105447982', '918151913741', '2017-12-18 13:27:30'),
('f4591bd2-e9d7-4509-b727-3856dbdc10d5', '8e790259-7657-4c2c-9966-b9b9396c28b4', '919632357734', '918892452332', '2017-12-27 14:42:42'),
('f5d0a6d2-17cb-403a-900f-4b812b0a7058', '8f22e5b2-72cb-488a-8542-ff75d20f9abc', '919632357734', '919738849769', '2017-12-16 21:26:31'),
('fbb690c1-1f83-427a-bd91-0046429f9b7d', 'c30d0521-5818-470d-97ac-e51788fb79d3', '918867528736', '919738849769', '2017-12-15 12:54:49'),
('fc443459-94e6-4841-ba33-578be53d0be4', 'ce1baa75-93d7-47a0-ac69-8f44f7e0435e', '918105447982', '919738849769', '2017-12-15 14:42:23'),
('fc48f848-9aeb-4612-b986-6ff6ca8eaec3', 'e7050d18-c474-47a8-bad5-0e34f58f454b', '919535883213', '918105447982', '2017-12-19 12:31:47'),
('fdb56d66-bfe5-41eb-880a-c047171a2113', '816fd706-aa57-4117-b024-06fdd9243c43', '918151913741', '918892452332', '2017-12-27 19:45:12'),
('fe060ab0-c401-4d9a-ad0e-ec651a2571b8', 'da552638-1092-43c4-99df-a91e7ec0349b', '918888888888', '918892452332', '2017-12-27 14:43:09'),
('fea780eb-9c8d-4a65-b3ba-4bd2a360a270', '7e7f6f2f-d83c-490c-ae6c-25a3bba1c43d', '918151913741', '918151913741', '2017-12-18 13:27:30');

-- --------------------------------------------------------

--
-- Table structure for table `hashtags`
--

CREATE TABLE `hashtags` (
  `hashtag_id` varchar(50) NOT NULL,
  `hashtag` varchar(100) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_user_id` varchar(50) NOT NULL,
  `modified_user_id` varchar(50) NOT NULL,
  `isactive` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hashtags`
--

INSERT INTO `hashtags` (`hashtag_id`, `hashtag`, `created_date`, `modified_date`, `created_user_id`, `modified_user_id`, `isactive`) VALUES
('00ea17ca-b135-4bad-8723-1ea93c39cf1c', 'maruti', '2017-12-14 13:04:43', '2017-12-14 13:04:43', '918151913741', '918151913741', 1),
('03b25e2b-061a-4303-b427-990d6763aaf0', 'werega', '2017-12-15 06:36:38', '2017-12-21 09:52:57', '918151913741', '918151913741', 0),
('082d4774-4250-4b6d-8b98-95934127ba76', 'good', '2017-12-19 10:45:23', '2017-12-19 10:45:23', '918151913741', '918151913741', 1),
('0d0ab6a4-c5aa-4371-8f45-6fe635eb733e', 'hello', '2017-12-19 10:49:03', '2017-12-19 10:49:03', '918151913741', '918151913741', 1),
('21fe49d5-24dc-4d16-8967-a1dc0b6684f5', 'weregards', '2017-12-14 15:21:37', '2017-12-14 15:21:37', '918151913741', '918151913741', 1),
('22099845-1872-4f4d-95cd-b53c1b76b93b', 'Nivin1', '2017-12-14 14:54:11', '2017-12-14 14:54:11', '918151913741', '918151913741', 1),
('2531f9f1-c3b5-4c85-a913-e0c364fe60d4', 'pen', '2017-12-19 10:46:16', '2017-12-19 10:46:16', '918151913741', '918151913741', 1),
('2a160e12-6bc5-4c2b-bdee-d12b0f70bdc8', 'we', '2017-12-14 15:20:45', '2017-12-14 15:20:45', '918151913741', '918151913741', 1),
('34600756-e33e-4822-b954-074c40a329fd', 'dhanush', '2017-12-14 13:28:05', '2017-12-14 13:28:05', '918151913741', '918151913741', 1),
('3f3f688a-6491-4035-bbb0-24b549d37a72', 'funnn', '2017-12-14 13:20:39', '2017-12-14 13:20:39', '918151913741', '918151913741', 1),
('490e5a52-d623-4aad-b6e8-bf59579aa6d8', 'user', '2017-12-22 07:30:49', '2017-12-22 07:30:49', '918632357734', '918632357734', 1),
('4d3cf26f-1af9-4cf5-877c-7fecbc9c6d29', 'Filim', '2017-12-14 12:11:40', '2017-12-14 12:11:40', '918151913741', '918151913741', 1),
('61948df7-d28f-43ee-b183-0c799fcd98a7', 'Nivin', '2017-12-14 12:11:40', '2017-12-14 12:11:40', '918151913741', '918151913741', 1),
('61d40542-5556-4528-886a-84b8edc68b18', 'Kuthab', '2017-12-14 13:23:33', '2017-12-14 13:23:33', '918151913741', '918151913741', 1),
('953d4102-cdd8-4d56-ae54-65f076d94624', 'topic', '2017-12-19 10:51:54', '2017-12-21 09:35:51', '918151913741', '918151913741', 0),
('9c5cca01-fcbd-477f-8cf5-8454e8c59842', 'suzuki', '2017-12-14 13:04:43', '2017-12-14 13:04:43', '918151913741', '918151913741', 1),
('9fc883df-03dc-4c90-81f3-73e88382b4f3', 'holy', '2017-12-15 06:36:38', '2017-12-15 06:36:38', '918151913741', '918151913741', 1),
('a592c4e1-67c6-4351-a593-ccdd226359b3', 'Nivinf', '2017-12-14 14:54:46', '2017-12-14 14:54:46', '918151913741', '918151913741', 1),
('b8d9074c-738d-41cd-94d5-9da870b9627f', 'topica', '2017-12-19 10:51:17', '2017-12-21 09:37:10', '918151913741', '918151913741', 0),
('d2353f73-bf56-47d8-add8-665391cbc3f8', 'jafferSadiq', '2017-12-20 13:21:55', '2017-12-26 06:41:49', '918892452332', '918892452332', 0),
('fb4fb08e-fb5a-4827-bd74-c170dd261b2d', 'article', '2017-12-22 07:32:02', '2017-12-22 07:32:02', '918632357734', '918632357734', 1),
('fbb192c8-f84a-4f38-865d-58ea3100e85d', 'car', '2017-12-14 13:04:43', '2017-12-14 13:04:43', '918151913741', '918151913741', 1);

-- --------------------------------------------------------

--
-- Table structure for table `hashtags_content`
--

CREATE TABLE `hashtags_content` (
  `hashtags_content_id` varchar(50) NOT NULL,
  `hashtag_id` varchar(50) NOT NULL,
  `content_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hashtags_content`
--

INSERT INTO `hashtags_content` (`hashtags_content_id`, `hashtag_id`, `content_id`) VALUES
('0d218f9d-36b2-4a49-8ce2-35918358f3d6', '9c5cca01-fcbd-477f-8cf5-8454e8c59842', '2ddb1ca3-05b4-45e8-918f-6019790f24e5'),
('12c7a8a8-233e-44e7-a4d6-4f392aa55b2a', '61948df7-d28f-43ee-b183-0c799fcd98a7', '89cb33bb-28a1-4a43-8e6b-e524dbaf7e53'),
('1a58598a-ac2d-43b2-b07d-9660ddb30c2a', '490e5a52-d623-4aad-b6e8-bf59579aa6d8', '0349d105-e67b-4c3c-b887-1b1969124673'),
('1a708029-0715-42eb-afe0-51ecdc107265', 'fb4fb08e-fb5a-4827-bd74-c170dd261b2d', '2d00ca0d-1091-4edf-b62e-0f3cdf43025f'),
('22ecbb22-31d3-48bd-9a16-946fb7cea93a', '953d4102-cdd8-4d56-ae54-65f076d94624', '44526186-270f-413c-a1e9-cfc7e0333e2d'),
('26a29c74-8725-4d97-8207-eb9b8f8842cc', 'a592c4e1-67c6-4351-a593-ccdd226359b3', 'bf7b90b6-0a37-430a-90a2-c527f7b0a445'),
('301e38da-e186-466d-bb0e-5a3ec61b2394', 'fbb192c8-f84a-4f38-865d-58ea3100e85d', '42fab386-43dc-4a36-8de1-945487819268'),
('32bf500b-8579-4055-82b5-5923078d6d4b', '9c5cca01-fcbd-477f-8cf5-8454e8c59842', '93b34e67-f2cd-4315-b3e8-73a3bbb9174c'),
('389b05e0-86e4-4cce-bbd8-c6f660ed86e7', '00ea17ca-b135-4bad-8723-1ea93c39cf1c', '42fab386-43dc-4a36-8de1-945487819268'),
('42d809b8-8ad3-433a-a47a-8a9ae0229e94', '953d4102-cdd8-4d56-ae54-65f076d94624', '09312597-3c06-4168-8c68-128b24bd63c4'),
('47487c6a-811a-47bd-9bf9-f046f32ad6e4', '2a160e12-6bc5-4c2b-bdee-d12b0f70bdc8', '435f3f6b-9b78-4169-af49-d8ba2afdab8a'),
('525d5494-221b-4c7c-8cab-36690a9f78d3', '9fc883df-03dc-4c90-81f3-73e88382b4f3', '70d49999-a4b7-4ef6-8510-cdcd1ed46bd7'),
('5676a73b-ce5e-445f-874f-70567bf09d71', '9c5cca01-fcbd-477f-8cf5-8454e8c59842', '42fab386-43dc-4a36-8de1-945487819268'),
('58300c57-6857-441b-a902-70b9c4c0dca9', '61948df7-d28f-43ee-b183-0c799fcd98a7', '03048c59-7134-4d89-8df9-5b747a722535'),
('5e268456-5347-4389-ad7b-b40695640e75', '03b25e2b-061a-4303-b427-990d6763aaf0', '70d49999-a4b7-4ef6-8510-cdcd1ed46bd7'),
('862b384f-1713-44cf-b8bc-ff661ab8575a', '21fe49d5-24dc-4d16-8967-a1dc0b6684f5', '4078c088-2e95-4711-b1e2-fd581ed47fe6'),
('8a17b77d-955e-4362-a526-1558622a77c4', '2531f9f1-c3b5-4c85-a913-e0c364fe60d4', '44526186-270f-413c-a1e9-cfc7e0333e2d'),
('8bacde84-ba2c-40d8-ab11-e4d1a8aaa776', '34600756-e33e-4822-b954-074c40a329fd', '03048c59-7134-4d89-8df9-5b747a722535'),
('94ebfb35-e4a9-4378-a72d-1085cc42622d', '2a160e12-6bc5-4c2b-bdee-d12b0f70bdc8', 'e97b8308-c66d-4791-942e-c4b78fce49e0'),
('acc89373-8624-40a6-9a29-f8f8fed3a72a', '082d4774-4250-4b6d-8b98-95934127ba76', '44526186-270f-413c-a1e9-cfc7e0333e2d'),
('afa2953b-2075-4713-a123-e8602a0fbee7', '61948df7-d28f-43ee-b183-0c799fcd98a7', '2ddb1ca3-05b4-45e8-918f-6019790f24e5'),
('b7ef66b4-c239-4188-b992-a74cc99fd864', '22099845-1872-4f4d-95cd-b53c1b76b93b', '2cd2a269-4957-472e-9501-fbfad5009a93'),
('b9baafa2-c4d9-45a0-9da7-6a65a9ff2006', '0d0ab6a4-c5aa-4371-8f45-6fe635eb733e', '70d49999-a4b7-4ef6-8510-cdcd1ed46bd7'),
('bb9535aa-70a2-4ec1-b594-a891bab6cb32', '953d4102-cdd8-4d56-ae54-65f076d94624', 'a80d8590-a270-43e2-933f-bed14683e04d'),
('bdbaea75-4ebb-4fd4-a5f2-d0436b060738', '0d0ab6a4-c5aa-4371-8f45-6fe635eb733e', '70d49999-a4b7-4ef6-8510-cdcd1ed46bd7'),
('c0df379b-fc26-4049-94f9-fd1c2bfe53c6', '61948df7-d28f-43ee-b183-0c799fcd98a7', '3c41205c-367a-47a1-962a-f52889061bde'),
('c5864359-fed4-4ebc-9d15-c7f80923e48b', '00ea17ca-b135-4bad-8723-1ea93c39cf1c', '2ddb1ca3-05b4-45e8-918f-6019790f24e5'),
('d9924c86-42d3-4c2d-b532-52d7d0949746', 'b8d9074c-738d-41cd-94d5-9da870b9627f', '44526186-270f-413c-a1e9-cfc7e0333e2d'),
('db049472-7d02-4e55-b855-01b14f620e9d', '61948df7-d28f-43ee-b183-0c799fcd98a7', '93b34e67-f2cd-4315-b3e8-73a3bbb9174c'),
('e12aa2e8-6355-42bb-ac94-0d46c3ec8d91', '61948df7-d28f-43ee-b183-0c799fcd98a7', '25ce488d-067b-475a-a655-1323434f29f0'),
('ed258c26-cd84-4d1b-be8c-a020c7e89c85', 'd2353f73-bf56-47d8-add8-665391cbc3f8', 'f84e1bc7-80a9-4b9a-a84f-0e95baae0ec6'),
('f526e409-0141-4cbd-b546-20a3b5fb1c68', '3f3f688a-6491-4035-bbb0-24b549d37a72', '5974d517-c057-40ae-9ae5-bef417574f5d'),
('f78bf701-89f5-4b58-a983-07191f4482e5', '61d40542-5556-4528-886a-84b8edc68b18', '25ce488d-067b-475a-a655-1323434f29f0'),
('f8e58455-9d71-46ec-9f6f-bd53b0bc55c7', '4d3cf26f-1af9-4cf5-877c-7fecbc9c6d29', '89cb33bb-28a1-4a43-8e6b-e524dbaf7e53'),
('fa2a40ed-fe18-426d-85f0-e6217039ca29', '082d4774-4250-4b6d-8b98-95934127ba76', '44526186-270f-413c-a1e9-cfc7e0333e2d'),
('fdf3b200-4108-4d89-92b2-471255373b0c', '61948df7-d28f-43ee-b183-0c799fcd98a7', '5974d517-c057-40ae-9ae5-bef417574f5d');

-- --------------------------------------------------------

--
-- Table structure for table `parental_control`
--

CREATE TABLE `parental_control` (
  `parental_control_id` varchar(50) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `password` varchar(200) DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `isactive` tinyint(1) NOT NULL,
  `verification_code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `parental_control_age_group`
--

CREATE TABLE `parental_control_age_group` (
  `parental_control_age_group_id` varchar(50) NOT NULL,
  `parental_control_id` varchar(50) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `age_group_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pj_stunner`
--

CREATE TABLE `pj_stunner` (
  `pj_stunner_id` varchar(50) NOT NULL,
  `pj_user_id` varchar(50) DEFAULT NULL,
  `stunner_user_id` varchar(50) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pj_stunner`
--

INSERT INTO `pj_stunner` (`pj_stunner_id`, `pj_user_id`, `stunner_user_id`, `created_date`, `modified_date`) VALUES
('030cba6b-ef4c-4ccf-b6d0-345975dccecf', '91154632589', '855642123138', '2018-01-18 13:03:40', '2018-01-18 13:03:40'),
('067ac809-dd78-4419-845f-276583d7c346', '91741258963', '91963852741', '2018-01-10 04:53:58', '2018-01-10 04:53:58'),
('2bee7e4b-629a-42ce-97ba-d905b0b80348', '91712345678', '917123456798', '2018-01-09 06:52:46', '2018-01-09 06:52:46'),
('3602bb28-feeb-445e-ae12-d6ccc7dfd85e', '99786785657', '91984632598', '2018-01-22 08:25:08', '2018-01-22 08:25:08'),
('44322436-cc57-4789-a78d-5f62b3803ade', '99786785657', '984874674763', '2018-01-05 15:04:49', '2018-01-05 15:04:49'),
('4493b02e-ae68-4696-bbb5-7fd2dfd74a65', '919632357737', '919449398566', '2018-01-11 09:54:40', '2018-01-11 09:54:40'),
('4dfa4325-1a50-41da-ab57-83aa1cb28075', '917539812466', '911578934645', '2018-01-16 04:31:24', '2018-01-16 04:31:24'),
('51ab94b3-73ab-4802-bd1f-8b8b0bcf7c5c', '91154632589', '91454872', '2018-01-18 10:34:00', '2018-01-18 10:34:00'),
('51d7db67-5735-4063-97b1-f290b18b4344', '919632357737', '919632357738', '2018-01-11 09:46:27', '2018-01-11 09:46:27'),
('5ca28bb3-7335-4819-95d1-23a0ae40b506', '917894592836', '91545454', '2018-01-17 11:44:25', '2018-01-17 11:44:25'),
('717942ae-828c-489e-bca8-16eb1c8d3c2b', '91159789123', '91357123789', '2018-01-12 04:05:15', '2018-01-12 04:05:15'),
('71f5a7b2-e6b6-4037-9a51-6960fa46ace3', '99786785657', '9932476437643', '2018-01-22 13:42:37', '2018-01-22 13:42:37'),
('81ad8c41-6ad9-4958-b2aa-4d611f9638d7', '91812345678', '91812345679', '2018-01-08 09:24:06', '2018-01-08 09:24:06'),
('8449b5a2-4a82-4941-87fa-5d6a5d4e9a2e', '91852147963', '919638527417', '2018-01-11 04:39:35', '2018-01-11 04:39:35'),
('8f1acca5-f700-4637-9fb2-8ec825895671', '917894592836', '9165465', '2018-01-17 11:40:41', '2018-01-17 11:40:41'),
('99302e7f-6161-4cd6-9109-f113d320a906', '8965675675767', '56894561234', '2018-01-05 10:29:00', '2018-01-05 10:29:00'),
('9ebb64f5-18eb-4a6e-b55a-ef9efd0dfc7f', '917894592836', '91455454', '2018-01-17 11:41:45', '2018-01-17 11:41:45'),
('b0fd30cd-64e7-4e6c-97c7-715c1695c85e', '917894592836', '914852697123', '2018-01-17 05:54:32', '2018-01-17 05:54:32'),
('c7fde96f-5045-4023-a034-369eff032501', '99786785657', '548765432654', '2018-01-08 07:52:46', '2018-01-08 07:52:46'),
('d70d2e47-545a-4214-8656-856fad883003', '91154632589', '9114893256', '2018-01-18 05:54:38', '2018-01-18 05:54:38'),
('da7b4ac5-76d7-4aaf-a367-7ffeffce2d3d', '917894592836', '91782156', '2018-01-17 12:06:19', '2018-01-17 12:06:19'),
('dc2b121b-b552-48fa-8cc8-877d2e7150d8', '097678678777', '918484848877', '2018-01-05 07:42:14', '2018-01-05 07:42:14'),
('deb8dca6-2162-4eb2-ba00-c0f06dc37e13', '919632357737', '919449398577', '2018-01-11 09:53:02', '2018-01-11 09:53:02'),
('ea50627e-837f-4e8a-8b55-326fba08f452', '91712345678', '91712345698', '2018-01-09 06:46:38', '2018-01-09 06:46:38'),
('f7e14f19-e768-484b-8737-5f38a58757b3', '91987156843', '91987369456', '2018-01-15 04:27:13', '2018-01-15 04:27:13');

-- --------------------------------------------------------

--
-- Table structure for table `range_rate_card`
--

CREATE TABLE `range_rate_card` (
  `id` varchar(50) NOT NULL,
  `rate_card_id` varchar(50) NOT NULL,
  `min_view` int(11) NOT NULL,
  `max_view` int(11) NOT NULL,
  `rate` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rate_card`
--

CREATE TABLE `rate_card` (
  `rate_card_id` varchar(50) NOT NULL,
  `content_type` varchar(45) NOT NULL,
  `no_of_views` int(11) NOT NULL,
  `amount_per_no_view` decimal(8,2) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `modify_by` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rate_card`
--

INSERT INTO `rate_card` (`rate_card_id`, `content_type`, `no_of_views`, `amount_per_no_view`, `created_date`, `modified_date`, `modify_by`) VALUES
('4e1c29d4-da6a-4f6c-9456-dd127d7e6fe9', 'Image', 2, '50.00', '2017-07-18 12:56:29', '2017-12-18 14:45:29', NULL),
('b0bf3b3a-40c2-4417-a686-5df8d87b0500', 'Text', 1, '6.00', '2017-07-18 12:56:57', '2017-12-06 16:13:38', NULL),
('cf609623-2782-4690-b0a0-d2e6c2fe1b14', 'Audio', 1, '7.00', '2017-07-18 12:57:07', '2017-12-07 12:17:53', NULL),
('f25f0c03-b643-4a92-a581-69edf16cc472', 'Video', 1, '4.00', '2017-07-18 12:56:46', '2017-07-18 12:56:46', 'Sobhan');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` varchar(50) NOT NULL,
  `role_name` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_user_id` varchar(50) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_user_id` varchar(50) NOT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `user_id` varchar(50) NOT NULL,
  `role_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `setting_id` varchar(45) NOT NULL,
  `name` varchar(45) NOT NULL,
  `value` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`setting_id`, `name`, `value`) VALUES
('34e31900-d5fa-4386-9b58-283b60280c3b', 'watchedTimer', '10'),
('9c8502ad-144a-4729-a0fc-d05fb226918d', 'adMaxViews', '201'),
('b49793d2-d1f8-43e5-ad65-35599a49036d', 'MailReminder', '3'),
('e3817735-cb3d-4435-8746-10530a98f5aa', 'adWaitingTime', '25');

-- --------------------------------------------------------

--
-- Table structure for table `social_activity_dislikes`
--

CREATE TABLE `social_activity_dislikes` (
  `social_activity_dislikes_id` varchar(45) NOT NULL,
  `content_id` varchar(50) NOT NULL,
  `user_id` varchar(45) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `isactive` tinyint(1) NOT NULL,
  `isdisliked` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `social_activity_dislikes`
--

INSERT INTO `social_activity_dislikes` (`social_activity_dislikes_id`, `content_id`, `user_id`, `created_date`, `modified_date`, `isactive`, `isdisliked`) VALUES
('bf330539-e68d-419b-99b4-a63a05d4f106', '003d6042-bfe6-47f9-bc5d-cc21374a9f5e', '254703576893', '2018-01-03 15:11:13', '2018-01-03 10:13:40', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `social_activity_likes`
--

CREATE TABLE `social_activity_likes` (
  `social_activity_likes_id` varchar(50) NOT NULL,
  `content_id` varchar(50) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `isactive` tinyint(1) NOT NULL,
  `isliked` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `social_activity_likes`
--

INSERT INTO `social_activity_likes` (`social_activity_likes_id`, `content_id`, `user_id`, `created_date`, `modified_date`, `isactive`, `isliked`) VALUES
('06e693ed-b516-4c02-b232-5c9cf2e8c06c', '75e1baad-b046-47b7-ba77-6e9199287640', '919900601813', '2017-11-17 16:35:01', '2017-11-17 11:07:28', 1, 1),
('222d5821-114a-41ec-b0b7-400dede12ca4', '003d6042-bfe6-47f9-bc5d-cc21374a9f5e', '254703576893', '2018-01-03 15:10:15', '2018-01-03 09:41:13', 1, 0),
('3fe8d4df-bb0a-42d8-b974-208867527b18', 'ccc81664-71a6-4143-a518-ef08ec18aa5a', '919035564107', '2018-02-01 16:06:39', '2018-02-01 10:36:39', 1, 1),
('430cbc12-3e91-4b7f-a9f4-72cd70c8f77e', '188cc903-d0c7-459f-86f5-f5e11e184464', '918151913750', '2017-11-17 16:37:17', '2017-11-17 11:07:18', 1, 0),
('4d757d51-abfa-4001-8769-82db096a0016', '9a0941ca-a615-424f-82cb-a75b2a233fb2', '918105447982', '2017-12-19 17:26:17', '2017-12-19 11:56:17', 1, 1),
('50efb2cc-6818-46cb-a964-6a0b4e6f9e94', '76814dc8-2452-4b28-87f9-f2674a987c66', '919900601813', '2017-11-17 16:18:28', '2017-11-17 10:50:00', 1, 1),
('50fa901a-082a-4b24-97b3-24a77a380ac5', 'de9d36a9-0fe0-4b8e-9935-a6f5a84a71cf', '918892452332', '2018-01-19 19:47:21', '2018-01-19 14:17:22', 1, 0),
('6c86e0cb-7303-4527-be85-1e6354be90ff', 'f1867632-b625-405d-aa29-cdd7448d4577', '919035299524', '2017-11-17 15:47:07', '2017-11-17 10:17:07', 1, 1),
('a1a4a23f-870e-4c61-994c-678fd1e2688a', '75e1baad-b046-47b7-ba77-6e9199287640', '919035299524', '2017-11-17 16:35:02', '2017-11-17 11:05:02', 1, 1),
('a24afa8e-2164-440c-8042-ddc60342ab55', '93b34e67-f2cd-4315-b3e8-73a3bbb9174c', '918151913741', '2017-12-19 16:17:35', '2017-12-19 10:47:35', 1, 1),
('b945ed38-f4e2-4922-8f81-49a6344c3e08', '1084830f-332f-4eac-afc6-e0f42e952d7e', '918151913750', '2017-11-17 17:16:57', '2017-11-17 11:46:57', 1, 1),
('be829770-ade8-4824-99fe-5a95bdb5f2cf', 'adc969d0-6a1a-4d3c-9ab6-f54ef1e0036d', '918151913741', '2017-12-13 19:10:22', '2017-12-13 13:40:22', 1, 1),
('dd079413-20d9-48ff-92ce-dffdf1f36aef', '24644ad3-36b5-4d03-b144-3b8c436e3e1d', '918151913741', '2018-02-02 15:22:28', '2018-02-02 09:52:56', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `social_content_comments`
--

CREATE TABLE `social_content_comments` (
  `comment_id` varchar(50) NOT NULL,
  `content_id` varchar(50) NOT NULL,
  `commenter_user_id` varchar(50) NOT NULL,
  `comment_desc` longtext NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `isactive` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `social_content_comments`
--

INSERT INTO `social_content_comments` (`comment_id`, `content_id`, `commenter_user_id`, `comment_desc`, `created_date`, `modified_date`, `isactive`) VALUES
('2385f8c3-fa93-43ba-8939-cadc93d67ae9', '1084830f-332f-4eac-afc6-e0f42e952d7e', '918151913750', 'good', '2017-11-17 17:17:10', '2017-11-17 11:47:10', 1),
('2d2a327d-5762-4f4f-90b3-b4ba25e6ccc1', 'f1867632-b625-405d-aa29-cdd7448d4577', '919035299524', 'Hi', '2017-11-17 15:47:14', '2017-11-17 10:17:14', 1),
('6cfb6c4c-ab48-44ab-ada7-569e320f0d92', '44526186-270f-413c-a1e9-cfc7e0333e2d', '918151913741', 'vxb', '2017-12-19 17:42:24', '2017-12-19 12:12:24', 1),
('6dbd7ecd-f650-4a9c-8034-a0164ed2ff60', '75e1baad-b046-47b7-ba77-6e9199287640', '919900601813', 'hi', '2017-11-17 16:47:50', '2017-11-17 11:17:50', 1),
('73cec6a4-62c9-4e3e-9ee4-e0a7a9752f24', '188cc903-d0c7-459f-86f5-f5e11e184464', '918151913750', 'helloo', '2017-11-17 16:37:37', '2017-11-17 11:07:37', 1),
('ad7beef7-b697-44d5-825c-02e476cd9d78', '1084830f-332f-4eac-afc6-e0f42e952d7e', '918151913750', 'fgh', '2017-11-17 17:04:53', '2017-11-17 11:34:53', 1),
('af3ceef4-75e3-498f-9d98-a85bb4a11cf5', '75e1baad-b046-47b7-ba77-6e9199287640', '919035299524', 'Which brand?', '2017-11-17 16:35:17', '2017-11-17 11:16:43', 0),
('b52be99c-22c0-4380-bbf1-04c5383bba54', '75e1baad-b046-47b7-ba77-6e9199287640', '919035299524', 'replay', '2017-11-17 16:46:55', '2017-11-17 11:16:55', 1),
('d4e30ee7-c942-42b1-bcd3-9cc54a93aeda', '75e1baad-b046-47b7-ba77-6e9199287640', '919035299524', 'reply', '2017-11-17 16:46:51', '2017-11-17 11:16:51', 1),
('ebe56669-0f2b-4535-9780-91f0838fa9ae', '79d2b3e2-bac6-4542-a17d-3e4764c3012d', '919035299524', 'aa', '2017-11-17 16:39:37', '2017-11-17 11:09:37', 1),
('f4ef2f43-dea4-48f7-b3be-eb030c87fa68', '75e1baad-b046-47b7-ba77-6e9199287640', '919900601813', 'hi', '2017-11-17 16:46:55', '2017-11-17 11:17:06', 0);

-- --------------------------------------------------------

--
-- Table structure for table `social_content_comments_level_1`
--

CREATE TABLE `social_content_comments_level_1` (
  `social_content_comments_level_1_id` varchar(50) NOT NULL,
  `comment_id` varchar(50) NOT NULL,
  `content_id` varchar(50) NOT NULL,
  `commenter_user_id` varchar(50) NOT NULL,
  `comment_desc` longtext NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `isactive` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `social_content_comments_level_1`
--

INSERT INTO `social_content_comments_level_1` (`social_content_comments_level_1_id`, `comment_id`, `content_id`, `commenter_user_id`, `comment_desc`, `created_date`, `modified_date`, `isactive`) VALUES
('171c600e-c86c-4983-8f37-10e7c88ee503', 'af3ceef4-75e3-498f-9d98-a85bb4a11cf5', '75e1baad-b046-47b7-ba77-6e9199287640', '919900601813', 'lenovo', '2017-11-17 16:46:21', '2017-11-17 11:16:21', 1),
('21a322b4-3604-43e6-85b3-3114b04f4be7', 'ad7beef7-b697-44d5-825c-02e476cd9d78', '1084830f-332f-4eac-afc6-e0f42e952d7e', '918105447982', 'Sffgfgsg', '2017-11-20 15:27:59', '2017-11-20 09:57:59', 1),
('2dfca723-a3e2-4e7d-be21-646ee7bf8ab7', 'd4e30ee7-c942-42b1-bcd3-9cc54a93aeda', '75e1baad-b046-47b7-ba77-6e9199287640', '919900601813', 'hi', '2017-11-17 16:47:20', '2017-11-17 11:17:35', 0),
('508cf1dc-dbc0-4c6f-ac24-3acb1abbc779', 'b52be99c-22c0-4380-bbf1-04c5383bba54', '75e1baad-b046-47b7-ba77-6e9199287640', '919900601813', 'hi', '2017-11-17 16:47:30', '2017-11-17 11:17:30', 1),
('7fe9c74c-a68d-4a15-9e28-919a1c428640', 'af3ceef4-75e3-498f-9d98-a85bb4a11cf5', '75e1baad-b046-47b7-ba77-6e9199287640', '919035299524', 'nice', '2017-11-17 16:46:15', '2017-11-17 11:16:15', 1),
('8eefbb74-c747-4068-a6e7-eec717b54b4f', 'ad7beef7-b697-44d5-825c-02e476cd9d78', '1084830f-332f-4eac-afc6-e0f42e952d7e', '918151913750', 'please', '2017-11-17 17:17:19', '2017-11-17 11:47:19', 1),
('fcd150ab-8177-409e-ba20-66f6fea359c0', 'b52be99c-22c0-4380-bbf1-04c5383bba54', '75e1baad-b046-47b7-ba77-6e9199287640', '919035299524', 'test', '2017-11-17 16:47:00', '2017-11-17 11:17:05', 0);

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `subscription_id` varchar(50) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `channel_id` varchar(50) NOT NULL,
  `category_id` varchar(50) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `isactive` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`subscription_id`, `user_id`, `channel_id`, `category_id`, `created_date`, `modified_date`, `isactive`) VALUES
('023b1aec-75f1-4a88-a2dd-5dc30cd8c26f', '918105447982', 'cb87678b-3afd-47d1-857f-8e207f6f0b18', 'f0f70b26-2053-4686-bc3b-48e4f67cf835', '2017-11-17 12:00:21', '2017-11-17 06:30:21', 1),
('07f0a029-a332-4102-a763-62af0d45ab40', '918892452332', 'd5303748-1944-4a0d-aba6-c0234ad40f03', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', '2017-12-21 20:40:49', '2018-01-16 18:17:17', 1),
('10223bee-3b08-4079-a754-bf93eead5902', '919900601813', '76fba5bd-eae6-4f36-a275-f5cc80afbbdd', '60ed68ce-a91c-4bf3-b7e8-8d16678e7b2a', '2017-11-17 16:49:02', '2017-11-17 11:19:02', 1),
('1ef7186d-759b-4d43-9588-45dea751b701', '919439398575', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', '2017-12-20 14:54:16', '2017-12-26 04:35:03', 0),
('267d3e71-0163-4ef1-be0e-bd5b8615cbb3', '918892452332', 'aa44bd23-03bf-44da-960a-a83b114e5f58', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', '2017-12-27 20:34:43', '2017-12-27 15:04:43', 0),
('2cbe0db4-5d34-4ace-a3f4-90832e6f0a2f', '918151913741', 'ba209dc4-ccf9-4feb-ab67-b641782ccb75', 'fe2b649f-2cc4-424c-af71-0095e5823b05', '2017-12-14 16:53:31', '2017-12-14 11:23:31', 1),
('37e502a0-43d7-4349-9bc6-23afc746eb06', '918151913742', '29128c3f-26ed-419c-8ecc-aea6b7cd9766', '82db2499-66ac-4626-9a4d-805b73d37d80', '2017-12-20 15:43:42', '2017-12-20 10:13:42', 0),
('3883e0e0-7413-4f16-ab1e-b57d7fe84eec', '918151913741', 'c8f38a20-f4ec-44da-b2c2-b1d4b5cfd59d', '4a9207e6-581f-4130-82d8-a78c15f0cb12', '2017-12-19 18:10:18', '2017-12-19 12:40:18', 0),
('3a57bf8b-8e66-418e-b85d-9016d0ea38d8', '918105447982', 'f58bc7fb-c311-4b30-97a5-3078182d337d', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', '2017-11-17 12:00:04', '2017-11-17 06:30:04', 1),
('44380579-dafc-4abf-9891-b876b7c1051f', '919439398575', '03f3f166-c138-4065-b070-2f07921020fa', '8b54acae-99f2-4f0c-b1a1-66af1a27fd74', '2017-11-21 12:07:17', '2017-11-21 06:37:17', 1),
('4a8c59c5-44de-456f-b84a-3c5ac6bbc690', '918105447982', 'c8f38a20-f4ec-44da-b2c2-b1d4b5cfd59d', '4a9207e6-581f-4130-82d8-a78c15f0cb12', '2017-12-21 15:31:09', '2017-12-21 10:01:09', 0),
('52cfc281-3b76-4d62-9994-68f86e06e470', '919900601813', 'bfac94df-2063-496c-871c-3618c446a199', '5c76b059-2150-4508-8181-b7cb13569128', '2017-11-17 16:27:27', '2017-11-17 10:57:27', 1),
('6187a996-17ab-4385-9ed2-05d999e5fb32', '918151913742', '641b98ef-6d76-448f-a986-b7031325100d', '82db2499-66ac-4626-9a4d-805b73d37d80', '2017-12-20 15:43:31', '2017-12-20 10:13:31', 0),
('6849b133-6072-4231-8cdb-05d320d652a7', '918151913741', '29128c3f-26ed-419c-8ecc-aea6b7cd9766', '82db2499-66ac-4626-9a4d-805b73d37d80', '2017-12-14 16:53:04', '2017-12-14 11:23:04', 1),
('79251eaa-cc89-4f04-8a17-a081be520306', '918151913742', 'bab2059f-4771-435d-bc72-68c3dfa3c034', '15d63c5e-6638-4b9e-90bb-1ae6da20ec5b', '2017-12-20 15:42:58', '2017-12-20 10:12:58', 1),
('7d498560-1ac7-4e3b-afdf-80af65be5417', '918105447982', '9ac22c90-1837-471c-98bc-cb82ca898136', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', '2017-11-17 12:00:08', '2017-11-17 06:30:08', 1),
('7df6b398-18b2-47d9-b150-22f688b1c377', '918888888888', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', '2017-12-20 21:58:50', '2017-12-21 12:45:17', 1),
('80097e78-bb58-40e8-91ea-f51a66904fa7', '919988776655', 'b4e717cd-6a28-4f9a-807c-23cf8aaf7342', '4a9207e6-581f-4130-82d8-a78c15f0cb12', '2017-11-20 17:52:54', '2017-11-20 12:22:54', 1),
('83ea01ae-8eb0-4025-a9af-cbebaf9ee0a4', '918151913741', '641b98ef-6d76-448f-a986-b7031325100d', '82db2499-66ac-4626-9a4d-805b73d37d80', '2017-12-14 16:53:01', '2017-12-14 11:23:01', 1),
('92e704fe-c4a4-4446-8083-0c6cf75eaafd', '919035299524', 'b4e717cd-6a28-4f9a-807c-23cf8aaf7342', '4a9207e6-581f-4130-82d8-a78c15f0cb12', '2017-11-17 16:48:57', '2017-11-17 11:18:57', 0),
('95bff9d3-ac9b-4ce4-b3c8-72a14d55612d', '918105447982', 'c510bbdb-30e3-4005-b318-eeb597288d2c', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', '2017-12-21 16:03:45', '2017-12-21 10:33:45', 1),
('a1447c3e-4c3d-4b65-bece-78a899872260', '919494949494', 'd2f94f97-1a7c-422d-84a8-8db5675b5f82', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', '2017-12-28 11:52:54', '2017-12-28 06:22:54', 1),
('a54325aa-0db6-4202-870f-7fbff9df73a1', '918105447982', '64078f75-b407-40b6-8231-a54171f78806', '0724033a-f1a0-4283-95b0-15b293a90008', '2017-11-17 12:00:15', '2017-11-17 06:30:15', 1),
('a6f44512-dde3-41a1-a9f6-45a5e219f3cc', '919738849769', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', '2017-12-21 19:45:25', '2017-12-21 14:15:25', 0),
('a744eaa2-77fd-4514-93ed-8bb1659b7222', '919999988888', '7cd3fe7b-c5c6-45e0-b41e-cfedc923f7e5', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', '2017-12-28 13:09:19', '2017-12-28 07:39:19', 0),
('a8636a06-d347-4fb1-ba4b-91d95f05f43e', '919632357734', 'b4e717cd-6a28-4f9a-807c-23cf8aaf7342', '4a9207e6-581f-4130-82d8-a78c15f0cb12', '2017-11-20 17:52:50', '2017-11-20 12:22:50', 1),
('ac64a09b-4ac2-44ec-8b58-3f3a86bbf57a', '918151913742', '03f3f166-c138-4065-b070-2f07921020fa', '8b54acae-99f2-4f0c-b1a1-66af1a27fd74', '2017-12-20 14:26:45', '2017-12-20 08:56:45', 1),
('ae58edad-2f51-4f57-8165-11476331954f', '918585858585', 'd51c2942-0033-430a-9ec9-f964f8c3ac6c', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', '2017-12-28 14:23:56', '2017-12-28 14:53:23', 1),
('b345169f-ed09-478b-894f-28c59cbe5bec', '918151913741', 'd5303748-1944-4a0d-aba6-c0234ad40f03', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', '2017-12-21 17:16:48', '2018-02-02 15:17:09', 0),
('b81f2aa6-7359-4f24-b527-085bcfbffea5', '918151913742', 'bfac94df-2063-496c-871c-3618c446a199', '5c76b059-2150-4508-8181-b7cb13569128', '2017-12-20 14:38:52', '2017-12-20 09:08:52', 0),
('b988d3a4-7bab-4f5c-a174-c689000ef711', '918151913742', 'b25d0f0e-3a85-4b6b-903a-6fd49ba60816', '5c76b059-2150-4508-8181-b7cb13569128', '2017-12-20 14:42:14', '2017-12-20 09:12:14', 0),
('bcf41def-25db-47a2-b2f6-f61617f5df9b', '918105447982', '29128c3f-26ed-419c-8ecc-aea6b7cd9766', '82db2499-66ac-4626-9a4d-805b73d37d80', '2017-12-19 15:07:53', '2017-12-19 09:37:53', 1),
('d8f5c6fb-6968-4a01-b9d0-f805829140a9', '918892452332', '3db5ca1e-cc0d-4104-a275-955d2261d193', 'aae19cb0-8ca5-458d-9d52-c6f7a1471a45', '2017-12-21 20:40:48', '2017-12-21 15:10:48', 0),
('da178bc8-667a-44ba-83fb-e158475c5d7b', '929632357734', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', '2017-12-21 08:51:05', '2017-12-21 12:45:17', 1),
('df350307-ea1a-4323-a35a-efceba02e9f10', '918892452332', '29128c3f-26ed-419c-8ecc-aea6b7cd9766', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', '2017-12-21 20:40:49', '2017-12-21 15:10:49', 0),
('df350307-ea1a-4323-a35a-efceba02e9f7', '918105447982', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', '2017-11-17 12:00:00', '2017-12-21 12:45:17', 1),
('df350307-ea1a-4323-a35a-efceba02e9f8', '917760464258', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', '2017-11-17 12:00:00', '2017-12-21 12:45:17', 1),
('df350307-ea1a-4323-a35a-efceba02e9f9', '918892452332', 'c996dc58-b162-4da2-9eb9-47cf272c3602', 'c17ebb5d-84de-498a-a90c-f15d9acaeb71', '2017-12-21 20:40:49', '2017-12-21 15:10:49', 0);

-- --------------------------------------------------------

--
-- Table structure for table `subscription_request`
--

CREATE TABLE `subscription_request` (
  `channel_requester_id` varchar(50) NOT NULL,
  `channel_id` varchar(50) NOT NULL,
  `requester_user_id` varchar(50) NOT NULL,
  `requested_on` datetime NOT NULL,
  `modified_user_id` varchar(50) NOT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subscription_request`
--

INSERT INTO `subscription_request` (`channel_requester_id`, `channel_id`, `requester_user_id`, `requested_on`, `modified_user_id`, `modified_date`, `is_active`) VALUES
('035a80b4-1a1b-4538-9ad3-48a8b9d9e299', 'd5303748-1944-4a0d-aba6-c0234ad40f03', '918892452332', '2018-01-16 12:47:07', '919738849769', '2018-01-16 12:47:17', 1),
('06afe751-1058-436c-9cc7-c1564d362927', 'bab2059f-4771-435d-bc72-68c3dfa3c034', '915828285828', '2018-01-23 10:33:32', '915828285828', '2018-01-23 10:33:32', 2),
('0dd5913b-e310-49ae-9331-993f677c5843', 'c996dc58-b162-4da2-9eb9-47cf272c3602', '918151913741', '2017-12-21 11:00:39', '918151913741', '2017-12-21 11:00:39', 2),
('13701ea1-f117-492e-a1f1-2e6314c29713', 'f58bc7fb-c311-4b30-97a5-3078182d337d', '918151913741', '2017-12-21 09:38:15', '918151913741', '2017-12-21 09:38:15', 2),
('1e52e05f-311e-43d9-ab50-6224271476d8', 'd51c2942-0033-430a-9ec9-f964f8c3ac6c', '918585858585', '2017-12-28 09:23:18', '919999988888', '2017-12-28 09:23:23', 1),
('2695d8b9-2949-4c39-9349-801205203a01', '661952f8-57d7-4d5f-b697-406bcc2e0fa3', '919494949494', '2017-12-27 14:50:00', '919494949494', '2017-12-27 14:50:00', 2),
('2ae54bba-d008-4ea6-a5d2-c7cd94d21547', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4', '918888888888', '2017-12-20 15:05:32', '918892452332', '2017-12-22 06:35:15', 3),
('2d3c75f3-ca2f-4be7-bb78-7dea61079ae3', 'ba209dc4-ccf9-4feb-ab67-b641782ccb75', '918892452332', '2018-01-23 08:42:59', '918892452332', '2018-01-23 08:42:59', 2),
('2eca6cbe-195a-403e-b9bb-6d5e079fa7cf', '6670e6d4-2692-48e9-ac61-ce13fde7e4f1', '918151913741', '2018-02-02 09:49:41', '918151913741', '2018-02-02 09:49:41', 2),
('3b8371a7-7f06-4b7d-9ff3-4cb39c8ab7e5', '5edd618b-b93a-4bb2-b7b3-d3b33c1863d4', '918151913741', '2017-12-21 11:40:11', '918151913741', '2017-12-21 11:40:11', 2),
('446fb754-4e13-4c86-b3bb-bbd54df68dd4', '641b98ef-6d76-448f-a986-b7031325100d', '918892452332', '2017-12-18 14:58:43', '918892452332', '2017-12-18 14:58:43', 2),
('4f7c3c75-d0fe-496c-be72-93908f39cf37', 'd2f94f97-1a7c-422d-84a8-8db5675b5f82', '919494949494', '2017-12-28 06:22:05', '918787878787', '2017-12-28 06:23:00', 3),
('6a62fc88-1311-4968-b0af-a8dc8a53bf1a', 'aa44bd23-03bf-44da-960a-a83b114e5f58', '918892452332', '2017-12-27 15:05:56', '919494949494', '2017-12-28 06:28:46', 3),
('6bc56bec-5127-4115-9a70-9475827ea795', 'bab2059f-4771-435d-bc72-68c3dfa3c034', '919738849769', '2017-12-17 11:02:19', '919738849769', '2017-12-17 11:02:19', 2),
('884821a8-a546-4d63-a1f9-8e4afe29d641', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4', '919738849769', '2017-12-19 09:33:59', '918892452332', '2017-12-27 15:04:47', 3),
('97c62452-c98a-46f9-977a-951e8524167c', '661952f8-57d7-4d5f-b697-406bcc2e0fa3', '918151913741', '2017-12-21 10:59:19', '918151913741', '2017-12-21 10:59:19', 2),
('a5ddd54a-e8b7-452d-a5f4-ea7538efa39d', 'c510bbdb-30e3-4005-b318-eeb597288d2c', '919738849769', '2017-12-19 09:41:06', '919738849769', '2017-12-19 09:41:06', 2),
('ae38f7bd-c243-4d8b-9eee-9e101963f04e', 'c996dc58-b162-4da2-9eb9-47cf272c3602', '918892452332', '2017-12-27 12:02:31', '918892452332', '2017-12-27 12:02:31', 2),
('b4c4c693-bf96-49d5-8f19-82eede429549', 'c8f38a20-f4ec-44da-b2c2-b1d4b5cfd59d', '918151913741', '2017-12-19 12:40:19', '918151913741', '2017-12-19 12:40:19', 2),
('b805f0b4-3af2-4e13-b018-f36c3d6c973f', 'd51c2942-0033-430a-9ec9-f964f8c3ac6c', '918892452332', '2018-01-23 08:43:41', '918892452332', '2018-01-23 08:43:41', 2),
('bbfcf391-fe29-4682-93c3-7660aab25960', 'c996dc58-b162-4da2-9eb9-47cf272c3602', '918892452332', '2017-12-20 14:40:23', '918892452332', '2017-12-21 14:19:33', 1),
('c54dfe06-df2c-4c06-929a-81655099a952', 'aff07c9c-5a6d-4f5d-a834-7f8db6b07e00', '918151913741', '2018-02-02 11:33:36', '918151913741', '2018-02-02 11:33:36', 2),
('d669c28c-f4eb-488d-857b-10a915166619', '5edd618b-b93a-4bb2-b7b3-d3b33c1863d4', '918892452332', '2017-12-20 14:40:16', '918892452332', '2017-12-20 14:40:16', 2),
('df453851-c18c-4e50-94bb-7612bd5e79e0', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4', '919738849769', '2018-01-16 12:48:55', '919738849769', '2018-01-16 12:48:55', 2),
('e1033d84-5bfd-42f2-9a1c-d70b14728705', '3db5ca1e-cc0d-4104-a275-955d2261d193', '918892452332', '2017-12-18 14:58:16', '918892452332', '2017-12-21 14:19:33', 1),
('e17edde0-534a-4a7f-95de-4e53ad62569a', '3bdc8e63-f2ed-41e9-840e-0bccf9a5fc0f', '919738849769', '2018-01-16 12:41:04', '919738849769', '2018-01-16 12:41:04', 2),
('ec5cf96c-4b16-4645-a4e9-9b524164495b', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4', '929632357734', '2017-12-18 14:57:15', '918892452332', '2017-12-27 15:04:51', 3),
('f206a16b-579b-4ed6-b39f-9e070dca471f', '4b6339be-a7c5-4e74-bc1e-239a518dec9c', '919494949494', '2017-12-27 14:50:29', '919494949494', '2017-12-27 14:50:29', 2),
('f2b63f11-c3c0-41ab-bf11-a2560e420d71', '29128c3f-26ed-419c-8ecc-aea6b7cd9766', '918892452332', '2017-12-18 14:58:45', '918892452332', '2017-12-21 12:31:20', 0),
('f2b63f11-c3c0-41ab-bf11-a2560e420d72', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4', '919439398575', '2017-12-18 14:58:45', '918892452332', '2017-12-27 15:04:50', 3),
('f6469674-0a78-41d9-90e5-42cdcddaef20', 'c996dc58-b162-4da2-9eb9-47cf272c3602', '918892452332', '2017-12-20 14:40:28', '918892452332', '2017-12-21 12:30:57', 0),
('f64d5f25-596c-43bb-b075-834acfd88d63', 'aa44bd23-03bf-44da-960a-a83b114e5f58', '918892452332', '2017-12-27 11:59:56', '919494949494', '2017-12-28 06:28:46', 3),
('fcfca3a0-00b6-4377-9b8d-d9d07473ef61', 'bfac94df-2063-496c-871c-3618c446a199', '918105447982', '2018-02-06 06:41:42', '918105447982', '2018-02-06 06:41:42', 2),
('fdd57f4f-c025-48db-822d-6f08bdf7552e', 'bfac94df-2063-496c-871c-3618c446a199', '918151913741', '2017-12-19 11:37:47', '918151913741', '2017-12-19 11:37:47', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_ad`
--

CREATE TABLE `user_ad` (
  `user_ad_id` varchar(50) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `ad_id` varchar(50) NOT NULL,
  `ad_run_date` datetime NOT NULL,
  `no_of_views` int(11) NOT NULL,
  `last_run_time` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_ad`
--

INSERT INTO `user_ad` (`user_ad_id`, `user_id`, `ad_id`, `ad_run_date`, `no_of_views`, `last_run_time`) VALUES
('01e3d34c-1b6b-47c9-9d88-87c9c6c11636', '919632357734', '0b494997-d157-4e42-b334-c794d19e4888', '2017-07-14 00:00:00', 1, 1500028889735),
('0511ce3e-852b-42d8-b46f-065b881e4289', '918151913741', '0b494997-d157-4e42-b334-c794d19e4888', '2017-07-12 00:00:00', 1, 1499855599885),
('0c8c7de6-e7b6-4f62-b08c-b2ffc8bc3f15', '918151913741', '57d30db8-b408-4bdb-aa56-372d2710b198', '2017-07-10 00:00:00', 1, 1499673784778),
('1329b50d-4839-4e91-8db8-a28ba7503f9e', '919510865123', '0b494997-d157-4e42-b334-c794d19e4888', '2017-07-14 00:00:00', 1, 1500021961056),
('32aecab6-1ba7-43f1-ae8b-8246afcd16ec', '918151913741', '2ef0fcfa-ba4b-4673-b25d-ac35763b931b', '2017-07-13 00:00:00', 1, 1499954888874),
('408f68d2-c31d-45b5-ba87-b27c153d7dd2', '918123502305', '2ef0fcfa-ba4b-4673-b25d-ac35763b931b', '2017-07-11 00:00:00', 1, 1499762329917),
('4f60197c-08f7-404d-879d-5f9670ad8ec8', '918151913741', '57d30db8-b408-4bdb-aa56-372d2710b198', '2017-07-13 00:00:00', 1, 1499956424311),
('57c14c91-bf0e-42f7-a514-5f13ebf3ee1b', '918151913741', '57d30db8-b408-4bdb-aa56-372d2710b198', '2017-07-14 00:00:00', 1, 1500016019777),
('5cac2e8c-24e0-4096-8939-0501a2b98f43', '918151913741', '2ef0fcfa-ba4b-4673-b25d-ac35763b931b', '2017-07-05 00:00:00', 1, 1499253839286),
('666ea270-f3c9-4dbc-b5be-999d8b23e4f4', '918105447982', '2ef0fcfa-ba4b-4673-b25d-ac35763b931b', '2017-07-06 00:00:00', 1, 1499346432101),
('67760f63-6ace-4dc8-b7f0-fc8fd1736caf', '918151913741', '0b494997-d157-4e42-b334-c794d19e4888', '2017-07-05 00:00:00', 1, 1499259790088),
('77dcf10d-f471-4d52-a3bd-3f27d9890764', '919535883213', '2ef0fcfa-ba4b-4673-b25d-ac35763b931b', '2017-07-14 00:00:00', 1, 1500020221680),
('7ffe3979-5918-4260-8585-c4b315158f7a', '918105447982', '2ef0fcfa-ba4b-4673-b25d-ac35763b931b', '2017-07-12 00:00:00', 1, 1499842125073),
('822905e4-6827-4564-9c33-e8e03beb8760', '918123502305', '57d30db8-b408-4bdb-aa56-372d2710b198', '2017-07-11 00:00:00', 1, 1499762348289),
('86bcb94b-c674-4ed3-a716-2ccf8dff9ec7', '918123502304', '0b494997-d157-4e42-b334-c794d19e4888', '2017-07-07 00:00:00', 1, 1499429644907),
('86f7e047-623a-4227-bbe0-f1ffa4cb64dd', '918123502304', '2ef0fcfa-ba4b-4673-b25d-ac35763b931b', '2017-07-10 00:00:00', 1, 1499671084274),
('876191dc-4a0a-4a67-95e0-aa0d6a9a117a', '919535883213', '0b494997-d157-4e42-b334-c794d19e4888', '2017-07-13 00:00:00', 1, 1499950650674),
('900bdd76-ef5b-44e8-84b0-203ae48dfebf', '918105447982', '0b494997-d157-4e42-b334-c794d19e4888', '2017-07-06 00:00:00', 1, 1499346428627),
('91ba518e-aee4-4f2c-b995-b148e84b239a', '918105447982', '57d30db8-b408-4bdb-aa56-372d2710b198', '2017-07-12 00:00:00', 1, 1499841465185),
('9256f8f7-c17e-4afe-b3cb-370cbfc6588a', '919535883213', '2ef0fcfa-ba4b-4673-b25d-ac35763b931b', '2017-07-13 00:00:00', 1, 1499951604652),
('9fb4de11-05f2-4b2c-bafc-207e1cc268e7', '918151913741', '0b494997-d157-4e42-b334-c794d19e4888', '2017-07-13 00:00:00', 1, 1499951196700),
('a097db72-87f4-4917-a6a2-bb5589e4f8b5', '919535883213', '0b494997-d157-4e42-b334-c794d19e4888', '2017-07-14 00:00:00', 1, 1500012181840),
('a197a12b-0050-4b12-81bb-b20889adb5b4', '918123502305', '0b494997-d157-4e42-b334-c794d19e4888', '2017-07-12 00:00:00', 1, 1499845505129),
('a9e0958a-cfa6-496f-82c7-f670eea01ac4', '918151913741', '2ef0fcfa-ba4b-4673-b25d-ac35763b931b', '2017-07-12 00:00:00', 1, 1499855600174),
('ae252f57-970b-4714-ae38-a16357c12552', '919986155231', '0b494997-d157-4e42-b334-c794d19e4888', '2017-07-14 00:00:00', 1, 1500021302827),
('af176684-3f65-4421-a34f-ba0ee7217fe3', '918151913741', '0b494997-d157-4e42-b334-c794d19e4888', '2017-07-06 00:00:00', 1, 1499321439243),
('b058d937-66cf-4253-9b81-6e76ca38bd96', '918151913741', '2ef0fcfa-ba4b-4673-b25d-ac35763b931b', '2017-07-14 00:00:00', 1, 1500015988569),
('b14fe94d-426d-49fc-a2f2-083f92fe6619', '918123502304', '2ef0fcfa-ba4b-4673-b25d-ac35763b931b', '2017-07-07 00:00:00', 1, 1499437194122),
('b1c24498-2186-478b-9894-ecbafe53bfc1', '918785696333', '57d30db8-b408-4bdb-aa56-372d2710b198', '2017-07-10 00:00:00', 1, 1499684687176),
('b1ff4c52-65c5-419e-98c7-0c9a39ee27b2', '919164476296', '0b494997-d157-4e42-b334-c794d19e4888', '2017-07-14 00:00:00', 1, 1500045125499),
('c5d91a80-aa4e-40f7-bb19-6c6b41b16069', '918105447982', '0b494997-d157-4e42-b334-c794d19e4888', '2017-07-12 00:00:00', 1, 1499842118867),
('c67112b0-21fe-432a-ab53-0d4284e41380', '918123502305', '57d30db8-b408-4bdb-aa56-372d2710b198', '2017-07-10 00:00:00', 1, 1499679546616),
('c6e0fab7-f212-4412-90de-8365ff1eee8f', '918151913741', '0b494997-d157-4e42-b334-c794d19e4888', '2017-07-14 00:00:00', 1, 1500025022809),
('caa32dab-181e-4681-a27c-8cf8b3d3eb2c', '919632357734', '2ef0fcfa-ba4b-4673-b25d-ac35763b931b', '2017-07-14 00:00:00', 1, 1500020132603),
('cb330302-0ac5-47a0-80ad-e2026b8457fb', '918123502304', '57d30db8-b408-4bdb-aa56-372d2710b198', '2017-07-10 00:00:00', 1, 1499671101416),
('d0a474e0-ff03-49c0-b5da-45978e17a3b9', '918151913741', '57d30db8-b408-4bdb-aa56-372d2710b198', '2017-07-07 00:00:00', 1, 1499436956696),
('d8f9aaa5-3282-4f4a-8602-4ee837c6f430', '918105447982', '57d30db8-b408-4bdb-aa56-372d2710b198', '2017-07-06 00:00:00', 1, 1499348402573),
('edce419f-190f-4f32-bd5f-a1b0bdd79d9e', '918151913741', '57d30db8-b408-4bdb-aa56-372d2710b198', '2017-07-05 00:00:00', 1, 1499248056058),
('ee3236ed-7c81-422a-9efa-7e02dc407ee2', '918151913741', '5e7a2fd8-a8cb-4fe2-aecb-9fb3749400c9', '2017-07-14 00:00:00', 1, 1500016031407),
('ee8350ad-4709-49a5-9e42-c266b5648f33', '918123502305', '0b494997-d157-4e42-b334-c794d19e4888', '2017-07-11 00:00:00', 1, 1499753542885),
('f342ceea-5528-4d66-8b9a-84bbd7fbe825', '918123502304', '0b494997-d157-4e42-b334-c794d19e4888', '2017-07-10 00:00:00', 1, 1499671097167),
('f43b311a-90be-44e2-91ef-9a757329f1e0', '919632357734', '0b494997-d157-4e42-b334-c794d19e4888', '2017-07-13 00:00:00', 1, 1499952504412),
('75db2e30-f7cc-401f-99fd-8ea8cb30942e', '917411361788', '0bc6f247-4713-4b60-99f8-25922972a123', '2017-07-21 00:00:00', 1, 1500634390524),
('76c68462-0d6e-49c4-8239-3ca1f5b630f8', '917411361788', '2e24aae3-d8de-4322-ab8a-14d187cd7ede', '2017-07-21 00:00:00', 1, 1500638568054),
('88898821-0a0a-42c6-bb6d-1c3fd844ecf6', '918123502305', '2e24aae3-d8de-4322-ab8a-14d187cd7ede', '2017-07-24 00:00:00', 1, 1500878740781),
('5dcf75f7-6a29-4279-8781-918d41ec6bd8', '919778474565', '0b494997-d157-4e42-b334-c794d19e4888', '2017-07-25 00:00:00', 1, 1500966761151),
('0812b993-2cd1-4683-b9d3-b188f7b7f9ff', '918123502305', '2e24aae3-d8de-4322-ab8a-14d187cd7ede', '2017-07-25 00:00:00', 1, 1500974641840),
('18aca008-ef63-4abc-b886-d29aa11ad1e4', '918105447982', '0b494997-d157-4e42-b334-c794d19e4888', '2017-07-25 00:00:00', 1, 1500974692535),
('efa9e6c0-a739-46dd-860f-c7f478bbbd67', '918123502302', '57d30db8-b408-4bdb-aa56-372d2710b198', '2017-07-26 00:00:00', 1, 1501073773301),
('1cf2bea7-c30f-4e32-8828-96d3cf65b173', '254708096536', '57d30db8-b408-4bdb-aa56-372d2710b198', '2017-07-27 00:00:00', 1, 1501145173445),
('73ae201c-a222-4c38-897b-24c8185b3ab0', '919535883213', '0bc6f247-4713-4b60-99f8-25922972a123', '2017-07-27 00:00:00', 1, 1501147145511),
('c4ab8cdf-be4e-44c9-a422-7c20cd06fa40', '919623257734', '2e24aae3-d8de-4322-ab8a-14d187cd7ede', '2017-07-27 00:00:00', 1, 1501151036650),
('9b54dbcc-a38d-4464-bc82-a27703590456', '917411361788', '345d623e-f1e5-463b-b5e5-f83b0ad179f1', '2017-07-27 00:00:00', 1, 1501162654652),
('34c3984e-b823-4e70-8322-121f0e7ab95d', '917411361788', 'd8cf1320-baf9-4908-b1ab-385613a1e232', '2017-07-27 00:00:00', 1, 1501162731438),
('921ea047-e143-469e-8ba9-6e80e6da2a33', '918867528736', '0bc6f247-4713-4b60-99f8-25922972a123', '2017-07-27 00:00:00', 1, 1501152846095),
('fbdc1977-9f4d-4668-91af-871e72774321', '919181519137', '652a4126-c559-4a17-b65f-9cdbb5c1d2f5', '2017-09-15 00:00:00', 1, 1505487006716),
('465b9856-32d9-43b4-ad8f-1d17fb73e008', '918105447982', 'dc666b13-02a7-4acb-8892-3401d2c26313', '2017-11-15 00:00:00', 1, 1510750962993),
('d4d9e04c-b433-4397-8c0f-58ec1f4842c5', '918105447982', 'dc666b13-02a7-4acb-8892-3401d2c26313', '2017-11-16 00:00:00', 1, 1510813059705),
('ed8a34b2-f100-4d74-9b44-b2b6f7d7f0b4', '919632357734', '7ad832a3-1177-4e67-ad89-8356da8aadf6', '2017-11-16 00:00:00', 1, 1510823385409),
('6bd82dc4-7866-4108-9699-92cff25f3430', '918867528736', '7ad832a3-1177-4e67-ad89-8356da8aadf6', '2017-11-16 00:00:00', 1, 1510815006609),
('292c4ed2-25f6-478a-83f8-83903bac8d1f', '919535883213', '7ad832a3-1177-4e67-ad89-8356da8aadf6', '2017-11-16 00:00:00', 1, 1510826925281),
('13cee43f-6e2c-43cf-bc3f-a83674554dc8', '919632357734', '7cc50275-c1b6-4c5f-8f95-98d560d269cf', '2017-11-16 00:00:00', 1, 1510825124470),
('c2c26ecf-41dd-4ede-a697-1f209a88f0ad', '918105447982', 'c3b929c2-2637-43de-8ee5-e693afa7a76f', '2017-11-16 00:00:00', 1, 1510831561230),
('972c8bf1-5370-410e-9bcf-1f0d97dc71ba', '919632357734', 'a087f028-4f53-4b35-9dc1-da64fbca397d', '2017-11-20 00:00:00', 1, 1511184186887),
('e2d3e347-3de3-4496-a271-3bb31114a38c', '919632357734', '289a516b-92a4-4b99-8e11-abcd8ad3cb7e', '2017-11-20 00:00:00', 1, 1511184201932),
('56119c07-8287-479f-af45-09f45490b9f2', '919988776655', '289a516b-92a4-4b99-8e11-abcd8ad3cb7e', '2017-11-20 00:00:00', 1, 1511184583023),
('e1678e05-8216-435c-ae21-76bba2248614', '919988776655', 'a087f028-4f53-4b35-9dc1-da64fbca397d', '2017-11-20 00:00:00', 1, 1511184588028),
('c363feaa-a0ab-4b30-8f60-69920d80feab', '919988776655', '3d58d00e-fe8c-4315-a9f7-9ae695f13c80', '2017-11-20 00:00:00', 1, 1511184578569),
('08d9ec73-32f9-4433-9580-ca62e64228d7', '919632357734', '3d58d00e-fe8c-4315-a9f7-9ae695f13c80', '2017-11-20 00:00:00', 1, 1511184216978),
('3fc066b1-c771-4a4e-82b7-1feaf9af61b7', '919632357734', '987fa07d-2772-4b9c-acdf-e65e9f55c318', '2017-11-20 00:00:00', 1, 1511184189777),
('9a86ba3b-d5d0-4623-aa3b-de7c3b00d851', '919632357734', '1543ec64-2fd1-4beb-92e6-86bbd32f4a4a', '2017-11-20 00:00:00', 1, 1511184189915),
('cfabd494-d0a0-4958-a751-1a81c193ae24', '918105447982', '289a516b-92a4-4b99-8e11-abcd8ad3cb7e', '2017-11-20 00:00:00', 1, 1511185923876),
('4b92f85b-e361-466e-b7a8-c08b50f162ca', '918105447982', '3d58d00e-fe8c-4315-a9f7-9ae695f13c80', '2017-11-20 00:00:00', 1, 1511185673749),
('9bdf1d95-ae8f-434a-8d98-e4cff4fb6e14', '918105447982', 'a087f028-4f53-4b35-9dc1-da64fbca397d', '2017-11-20 00:00:00', 1, 1511185870894),
('a07a19f5-5cb5-4caa-a5ca-05d09f92c825', '918105447982', '289a516b-92a4-4b99-8e11-abcd8ad3cb7e', '2017-11-21 00:00:00', 1, 1511255884470),
('6edc7ee5-2374-42e8-8c3c-35d31041ddaf', '918105447982', '3d58d00e-fe8c-4315-a9f7-9ae695f13c80', '2017-11-21 00:00:00', 1, 1511255877436),
('202d99c5-f2b7-42e3-9af3-360011b1042e', '918105447982', 'a087f028-4f53-4b35-9dc1-da64fbca397d', '2017-11-21 00:00:00', 1, 1511255879653),
('57e3b69b-d134-43c9-aecb-83bb92958609', '919439398575', '3d58d00e-fe8c-4315-a9f7-9ae695f13c80', '2017-11-21 00:00:00', 1, 1511246339969),
('3e16dc09-a799-4b0e-9bae-70c04dd3cb71', '919439398575', '289a516b-92a4-4b99-8e11-abcd8ad3cb7e', '2017-11-21 00:00:00', 1, 1511246339970);

-- --------------------------------------------------------

--
-- Table structure for table `user_channel`
--

CREATE TABLE `user_channel` (
  `user_channel_id` varchar(50) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `channel_id` varchar(50) NOT NULL,
  `type` char(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_channel`
--

INSERT INTO `user_channel` (`user_channel_id`, `user_id`, `channel_id`, `type`) VALUES
('03a84818-11f8-49d0-9988-eea8d3537983', '911234567890', 'a09abc52-3c57-4627-aa2a-ac8c61ac6d1f', 'PP'),
('04863b45-6534-4018-98ab-cfdb15abd20a', '9112300012300', '0d468b4e-2f8f-4b42-b5dc-2a2a54061683', 'PP'),
('0a7ceed3-ac34-4f53-9c36-7778836107e3', '919632357734', '9ac22c90-1837-471c-98bc-cb82ca898136', 'UC'),
('0a8735a4-46ac-4544-b530-4c9c39e542ae', '944658787', 'c14b4ea8-ae9c-445b-baed-8db9e919f53d', 'PJ'),
('0df5c924-4d2b-48d2-8bff-a0309e2cabef', '9178889956', 'fd5a858f-a55d-4ee9-84f7-c829b8ef3477', 'PJ'),
('1c184f80-c762-439a-8036-85ca9eec390b', '944568787', '6d64ffe3-fc23-496c-9660-60fbe6cf5722', 'PJ'),
('1d8f8aaa-699b-456a-a058-4a1880b32c04', '91123456789123', '641b98ef-6d76-448f-a986-b7031325100d', 'PS'),
('234ed68b-3a57-4a6e-aa6f-e3195ffd678f', '919988776655', '8ce708c3-c391-49f2-a323-a84804420380', 'PP'),
('2a34358f-12bb-416a-aaab-16fa4502f24c', '917894592836', '6670e6d4-2692-48e9-ac61-ce13fde7e4f1', 'PJ'),
('2b56bc14-70d8-4a5f-af8b-23258e0058a6', '918787878787', 'd2f94f97-1a7c-422d-84a8-8db5675b5f82', 'UC'),
('2c917d04-dff5-4241-9050-fa4afc92c420', '91876785675', '28981074-1d4d-4939-94a5-4a8cf0fa6b4f', 'PJ'),
('2ce63954-a731-49b5-a2f0-5cb973cd9d03', '91712345678', '51cd92e4-c62c-4fcc-882f-c0942d5cddf3', 'PJ'),
('2e479a48-4182-40b1-b5f4-5df7a02a255c', '91154632589', 'e091aad4-0da5-4954-8059-4a333cc388ce', 'PJ'),
('2e9356bd-c50a-4073-9be1-af3fd942d13c', '919632357734', '241432c9-61d7-4b5e-8a08-ceb2e278229c', 'PP'),
('30327d31-c54e-4849-b8ba-12cdeab54d55', '919898667544', 'bb3fa05b-1905-47fc-99c5-6fb9bbdeef7c', 'UC'),
('31e9f6fb-cadf-4c07-b78a-554fb5db609a', '9112300012300', '055b21ff-4160-4900-be76-235bb25e384d', 'PP'),
('32a5728d-40a0-4b99-8220-77dd527d1848', '254708596536', '661952f8-57d7-4d5f-b697-406bcc2e0fa3', 'UC'),
('32aff359-8403-41e3-ac70-d565a39a79d6', '9112300012300', '59635d64-3643-4b49-9f0e-3ce0f37ca522', 'PP'),
('351703cf-5815-4c5b-ad45-5b86cb36d430', '918867231902', 'a6eb710a-bf2d-49eb-9b96-049a08c9b816', 'UC'),
('376233ad-87aa-45a1-9bab-bb78acb32d71', '919035564107', 'ab081fe2-0d24-4be8-902f-5df1b9cba010', 'UC'),
('3b387671-18b1-476d-9a55-da20b78aea7e', '917123456789', 'aff07c9c-5a6d-4f5d-a834-7f8db6b07e00', 'PJ'),
('3c529746-68d5-45ec-9062-946291b79bfe', '918523651236', '3bdc8e63-f2ed-41e9-840e-0bccf9a5fc0f', 'UC'),
('3ca788c1-3e98-4acc-b422-da74235e17e7', '917539812466', 'cfc8f902-e546-4f25-bc5c-8898965e4210', 'PJ'),
('3e4d7709-b1d6-4599-8ee8-a75669bc3f8f', '254708985698', 'a087a24c-5e7b-40d0-8e41-9cdc106d0adb', 'UC'),
('40a23a9c-9a1b-4776-9dd6-d4c6b65637b4', '91741258963', '8a472886-d9de-4f84-9e74-3916650ed19f', 'PJ'),
('411d9156-d5e4-41b8-8387-c8bec097b0c9', '9165566', 'ddaa36cf-5bcf-4672-acbd-d24e5bb0de4a', 'PP'),
('4341bf08-6114-4356-8379-c0909d2d6fc5', '9155545455454', '68299658-1f56-4cb1-971b-5ebd7773aec2', 'PJ'),
('46078008-245d-47ad-97b3-1b168a1271bd', '919988776655', 'f0c1e428-6161-4f10-ac77-924605016cd5', 'PP'),
('4831bfc3-c853-4b46-9c79-4e3ac71fffaa', '3355566677877', 'af75ee50-7384-4beb-923f-ae6017ba03d5', 'PJ'),
('4f39f9ec-91b4-4509-b6d0-590073da4f60', '919988665544', 'bab2059f-4771-435d-bc72-68c3dfa3c034', 'PP'),
('51af0ba2-8d30-4d13-b6f0-9c1068743eaa', '918877114477', 'c602bfbd-8832-40cb-a82e-af827e51c1bc', 'UC'),
('522455e1-f60f-40db-8fb3-637271463903', '919632357737', '2cbd1987-f380-4032-abf4-8ab9f02bfb16', 'PJ'),
('56c15020-ea5e-4cab-8b81-45b1be64f838', '9112300012300', 'b25d0f0e-3a85-4b6b-903a-6fd49ba60816', 'PP'),
('56c587c5-0c5d-47c8-afd9-a900612c671f', '918585858585', '7cd3fe7b-c5c6-45e0-b41e-cfedc923f7e5', 'UC'),
('56c6b67a-2f6b-458e-86b1-b38294590137', '907336345534', 'eeb12891-f466-4d1d-bfa9-71c05c8d060d', 'PP'),
('572c7db8-1769-431d-b7d4-86abbf7daf3b', '918892152332', 'eddce392-6d22-42d8-b791-7430053627af', 'UC'),
('5735cebd-913b-4c26-8ae2-e2a0ca83f03f', '919573270949', 'c996dc58-b162-4da2-9eb9-47cf272c3602', 'UC'),
('5753010c-b4f5-4e06-be1e-f5adce6543a0', '9198745698785', '00a042bf-765e-42e9-b586-5e34cfb3abce', 'PJ'),
('579effd9-0ee3-4354-94cc-f7603e3c178e', '9857474747488', '483b2a70-93fc-4343-86dc-1d9eba3f78fa', 'PJ'),
('5823bea7-d354-488f-8f5e-7e3a311655ba', '917894654666', '33e38ebb-3b50-41b7-9243-511005bf1774', 'PJ'),
('58269b0a-17c1-4bbe-83c0-c2f4cfeed190', '918151913742', '19a3d480-feca-4686-8bec-b5683a1ae8a7', 'UC'),
('5a89c353-1d56-4268-ae0e-682f909385b4', '919439857565', 'e898bd16-0531-416c-b45d-4f8fe1ca09d7', 'UC'),
('5bed3417-c444-4381-a2da-0f83ce1e66fb', '918181818181', '439b4525-f668-4c1b-ad6a-80c23196aaaa', 'UC'),
('5e098a4f-e5ec-447f-ad7e-20e06aae6deb', '911234567890', 'cb87678b-3afd-47d1-857f-8e207f6f0b18', 'PP'),
('5e9e5a3d-386e-41a8-a015-c442a65a0943', '9878678687786', '5f42bb12-c914-48e4-8ed9-bd08d71cde12', 'PJ'),
('5eb5caab-8e8e-43d4-933f-69d96939e0de', '91987156843', '55981906-d119-4759-abda-e0e9542f0d5f', 'PJ'),
('60355d52-e41d-41e5-bf5f-5080bf96df6b', '9112300012300', 'd8f83541-7749-4795-a963-9fbd73eeadbf', 'PP'),
('60d42a25-9c05-4589-862a-448ab43219da', '911234567890', 'a57d30ad-a731-49df-a66b-8592075d3ba7', 'PP'),
('616b5608-a036-465d-a9d3-ccd8c21a3e3e', '911234567890', '38069f36-b271-4de9-8227-5edd7276a07d', 'PP'),
('645c0ccd-176c-43d5-8041-27c362aa193b', '911234567890', '83730dc8-b2af-44af-b24e-15b08f89f669', 'PP'),
('698a7295-5baa-4c81-9ce3-ceded3957535', '918105447982', '643ebad4-26d5-4ba9-9290-4a8d3ee2de2d', 'UC'),
('6a521c6a-ae9c-42b6-985f-1b82b20ed10e', '919900601813', 'b4e717cd-6a28-4f9a-807c-23cf8aaf7342', 'PP'),
('6a6d76e6-e801-4a8f-9e6a-9b73818ee52d', '9112300012300', 'ddfb6f97-56c7-4644-81b8-f2455756166c', 'PP'),
('6bd21b15-47d4-46c5-b7f8-ac002c040a6b', '91123456780', '360cebb5-530f-427c-8f3f-93d3e320ab78', 'PJ'),
('6c822d5c-5dbf-4c4b-bd20-57d63a710b71', '919528096314', 'bfac94df-2063-496c-871c-3618c446a199', 'UC'),
('6d44dcf0-62d9-4fd0-ad02-4f4acecfb59d', '91852147963', '3cc415c0-b3ed-4918-a606-e869eecba300', 'PJ'),
('70319b27-91a1-4ae8-8eb4-b7ae1f7b592b', '919890874323', 'e8b15c33-e018-4f72-8850-265af6262348', 'PJ'),
('7322ec8d-f146-4245-9520-4a053ec5b0e1', '997656567', '3cacfc06-e8d5-4588-b37f-92d9fa0162d6', 'PJ'),
('73f84d05-eb7d-48c7-a83f-941c38a54071', '911234567890', 'cd75db88-df76-4dd1-bd70-9a523230ba98', 'PP'),
('74b49e16-60e1-4595-8a39-db0c5d371c52', '919738849769', 'd5303748-1944-4a0d-aba6-c0234ad40f03', 'UC'),
('75b65ad1-16bc-451d-9f50-4644f0d45652', '917760464258', 'c2c8054b-0b16-4779-a507-bc1b041412f3', 'UC'),
('7a293079-0e56-4f18-bf8a-2688280557ac', '911234567890', 'ba209dc4-ccf9-4feb-ab67-b641782ccb75', 'PP'),
('7a797a68-5135-4833-a57c-f82ab948df7e', '918867528736', 'aab17628-679c-4a01-aa9d-fbde30d26633', 'UC'),
('7b1904ee-d4e5-4577-86ca-01cb3eca5a07', '3456576578687', '3397d6de-d7af-47e6-94f6-e8772af25380', 'PJ'),
('80cde2bd-4047-4e95-a904-a6565ce64e1d', '918123456789', 'ba2e99b4-50cd-40ae-b022-edc4481527ce', 'PJ'),
('85f530f6-6e28-4f72-9b0a-84bfc5a4c4da', '919999999999', 'a2b5b70b-5821-4473-bae7-b24667b3a93d', 'UC'),
('89e115c8-e356-4807-bf67-1f06e692618d', '9112300012300', '50d846e8-366f-4a94-9753-b18b7a8bc4da', 'PP'),
('8adf676b-705a-4df8-88f5-0acb0931a9e8', '919439398575', '5edd618b-b93a-4bb2-b7b3-d3b33c1863d4', 'UC'),
('8cdbed05-bdb4-4d69-ab68-a3f28f5a4837', '919632357735', '8f7ea8b7-c5b5-48f0-bbda-491fef0867ce', 'UC'),
('8da4cbeb-ba7d-48de-b99f-5c395dbe8fee', '91789654123', '326b35d3-f345-42f9-8b19-4607e25fcd8e', 'PJ'),
('8df61a6f-bf28-467b-867d-2ebf2077405f', '097678678777', '3a78c0ee-f931-4816-9618-117beaca72a9', 'PJ'),
('8f244bea-308e-4498-a3c4-ace479ee8709', '919696969696', 'eeab2bcd-7e61-4d2e-8b90-de7818c00af5', 'UC'),
('8f86377d-ff2b-48ab-a1f2-7110713215c7', '9112300012300', 'c8f38a20-f4ec-44da-b2c2-b1d4b5cfd59d', 'PP'),
('9021e7d5-51a3-4592-8707-d2a7963a8d34', '919999988888', 'd51c2942-0033-430a-9ec9-f964f8c3ac6c', 'UC'),
('917a9797-332b-4c23-9b68-40d2cd9c314c', '919988776655', '1659e5e0-51d3-46d2-b7df-737a9c64843b', 'PP'),
('93922f56-28fd-41fb-800f-82b588c704a7', '9112300012300', 'e7fee8e5-bdaa-4bf4-aa06-462446e058ae', 'PP'),
('95dbc96c-ec81-4e4e-baa2-b33c4cdff5dd', '911234567890', 'a297d136-7366-4724-8701-352a4bd049b0', 'PP'),
('9965d33c-dab1-48ac-8a6b-5ed686cd743c', '919494949494', 'aa44bd23-03bf-44da-960a-a83b114e5f58', 'UC'),
('9a5885bd-df18-4457-8763-ba74b5f53cd9', '919988665544', '29128c3f-26ed-419c-8ecc-aea6b7cd9766', 'PS'),
('9ca45733-7f6e-48f1-a8cd-e7cfaca6129b', '8986786767768', 'cfcd1361-3720-4b49-b4a0-0b36281113ca', 'PJ'),
('9d719d52-bca7-450e-8b5a-1d70c302a997', '98877853434', '6dd178b5-e0ca-434a-8a95-97207435bb68', 'PJ'),
('9e60d6ff-6aaf-4729-af17-ea89b808d577', '9112300012300', '3db5ca1e-cc0d-4104-a275-955d2261d193', 'PP'),
('a01f5e63-00a6-4fbd-8362-ca7a58ab9704', '911234567890', 'c160d505-998c-41a9-8b54-431d6492d912', 'PP'),
('a66d72d3-8747-4488-ac30-75561370ed0f', '91654789321', '7ce6959e-6997-4eef-8042-4fa645265ece', 'PJ'),
('ab39850e-d71b-40a0-897c-b6ac77599838', '919113837130', 'ca208078-034f-47dd-86c1-ca921609360d', 'UC'),
('aba110ae-2032-4a18-918a-ca2209335cdc', '919897969594', 'c510bbdb-30e3-4005-b318-eeb597288d2c', 'UC'),
('ac045a06-eb39-47e3-ba86-5ab437873d35', '918151913743', 'f58bc7fb-c311-4b30-97a5-3078182d337d', 'UC'),
('b67e8adb-3591-4ad1-985e-8c86d05717c3', '911234567890', '562893b7-7619-4f6f-be77-9beb62cf740c', 'PP'),
('bedb96b6-e048-49c5-96dd-f0a60abfa8cd', '919632357734', '03f3f166-c138-4065-b070-2f07921020fa', 'PP'),
('c0b05010-481e-4031-9760-2097f03f8f4a', '919035299524', '76fba5bd-eae6-4f36-a275-f5cc80afbbdd', 'PP'),
('c15172cb-62a4-4d4c-8de8-e3d810a7c3c8', '918151913750', '4b6339be-a7c5-4e74-bc1e-239a518dec9c', 'UC'),
('c17c4cba-2ed4-42a5-b6c1-fa7a898c4f51', '919988776655', 'da8c7371-050a-40a4-a034-010cb40daf91', 'PP'),
('c19cec91-ab3a-4df3-8e31-64e3a1b84ea6', '99786785657', 'e992f360-d32b-4f4a-840c-3c3e9fcb0163', 'PJ'),
('c424ada3-2ffe-442c-b569-6d5c376f7ee6', '911234567890', 'b5b6e969-4a40-4ef1-811d-d9bfa5df278f', 'PP'),
('c4619752-ad06-48fa-9110-979b4ef65dec', '911234567890', '64078f75-b407-40b6-8231-a54171f78806', 'PP'),
('c6566dcd-df57-46d5-afdb-237175a72d6b', '911234567890', 'c149f7d4-a2b0-4e15-a8de-065677e8ad3a', 'PP'),
('c861d2d8-cdb0-4788-83be-f8e11d46a9d7', '887656756', 'd4540d46-b613-4297-8f5b-87689628ecd9', 'PJ'),
('c91b0ee6-0ea2-44b9-9bde-9d4ce586d342', '91159789123', '6d9e24e8-820b-4320-be94-94012619b7c6', 'PJ'),
('cc94bdd0-4309-4c1f-ad3f-be76e068f588', '919988665544', 'df1df4f0-2de3-4040-9bbf-b92e8d4fc5f6', 'PP'),
('d07e47b6-6ea5-428c-8e0c-65b033fd0568', '78646464646', 'c47791b9-a9fe-4f23-97ad-ec0c8d389063', 'PJ'),
('d0c2e47b-6844-4c2b-ab2c-d8c53c475b60', '9754545454', '820f0869-12b3-4bc3-b2da-6120e277b0ce', 'PJ'),
('d4972f83-ef6e-4545-b253-b4fb2e439c21', '918151913741', 'f43a2e72-9087-4840-a992-3d0e2c3b150d', 'UC'),
('d745f7bc-48fc-4293-93ae-27402b533dc6', '889665675576', 'b789109d-b6ba-4119-9b37-5cc06ad1dba2', 'PJ'),
('d78624b6-ac4d-4f93-8d81-3e037d7119c4', '918632357734', '64554422-655b-4ced-b640-fa4d85dcb221', 'UC'),
('dd3b01b0-820f-44cb-bfab-16ccbc3b403b', '919988007711', 'b5e910e8-e954-437a-b5f5-50b2b333c6fc', 'PS'),
('df6b6049-24c2-430a-8d02-4db436a2a463', '254708989808', 'a0e6aef5-f5f7-4850-bb39-8c1562fde029', 'UC'),
('dfc14905-25d3-4476-86d4-8f43ec19a643', '919988665544', '16486658-61bd-41a5-9273-a87a55907912', 'PP'),
('e02a20f6-1899-460d-9e2d-ae3fa4056257', '918892452332', '32bc7c0a-cb79-48be-9e59-b986ee3c78e4', 'UC'),
('e2d98990-a53e-4cdc-87f3-ec815ff18fca', '911234567890', '7c597a7a-2bea-49ff-9300-1db3e01707fb', 'PP'),
('e4c4dffb-96c3-4d1a-9a98-3e98695ed679', '254780859859', '13dab5c8-ae95-4794-ab71-063bf0117cd8', 'UC'),
('e8f036d2-0799-48a9-8f1d-65ddf91a2073', '918183005820', '53933e18-98e1-4526-9544-61d8302a1112', 'UC'),
('e9704304-e190-4169-82ef-92cf22a49318', '91812345678', 'b171f000-983f-45d5-98b2-d0405e65bbed', 'PJ'),
('ec53a29a-ab66-4be0-9670-cdad67bdb3d5', '918888888888', '8109e664-9fe7-4f79-9575-fdf4219a085b', 'UC'),
('ed91be72-378a-4490-8494-a39bd3a01805', '9112300012300', '4bce4ae4-3451-497b-8817-f4ac42c49460', 'PP'),
('ed99ebf7-f93d-41d8-9d31-7c9215b3f1b7', '8965675675767', 'a3e2f44b-df5a-4d43-b34b-7024e3bed50f', 'PJ'),
('ee292330-9fb7-4cbd-b39c-ccdd608c3ed4', '911234567890', 'fefc77cb-b1b2-4f7d-a0ce-b8ca2a6e1ece', 'PP'),
('fb025873-a1c5-4b7a-b4d3-0ef92aaedf18', '55876543', 'b75a675a-1de5-4861-82da-f2f74668ca2b', 'PJ'),
('fd493833-d052-4590-ae11-f2ba9214fcd1', '911234567890', '5c1ef7df-8594-4d55-988a-fbf6eb5e41e6', 'PP');

-- --------------------------------------------------------

--
-- Table structure for table `user_comments`
--

CREATE TABLE `user_comments` (
  `user_comment_id` varchar(50) NOT NULL,
  `channel_id` varchar(50) NOT NULL,
  `content_id` varchar(50) NOT NULL,
  `commenter_user_id` varchar(50) NOT NULL,
  `commenter_comment` longtext,
  `created_date` datetime NOT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `isactive` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_comments`
--

INSERT INTO `user_comments` (`user_comment_id`, `channel_id`, `content_id`, `commenter_user_id`, `commenter_comment`, `created_date`, `modified_date`, `isactive`) VALUES
('0b318ef9-f2fd-49f3-a446-c05d05eda54d', 'b4e717cd-6a28-4f9a-807c-23cf8aaf7342', '75e1baad-b046-47b7-ba77-6e9199287640', '919900601813', 'test', '2017-11-17 16:33:36', '2018-01-22 11:43:24', 0),
('3c7fbab0-e6a6-43f2-9a87-af9a11f7b3e8', 'b4e717cd-6a28-4f9a-807c-23cf8aaf7342', '79d2b3e2-bac6-4542-a17d-3e4764c3012d', '919035299524', 'child abuse', '2017-11-17 16:33:57', '2017-12-01 12:45:40', 0),
('4e8acb98-8449-4c1c-bf9d-ef68b9ee3c6c', '76fba5bd-eae6-4f36-a275-f5cc80afbbdd', 'f1867632-b625-405d-aa29-cdd7448d4577', '919035299524', '', '2017-11-17 15:47:52', '2017-11-17 10:17:52', 1),
('8b4a76d4-5209-4964-a1d9-b2e66a2a007f', 'f43a2e72-9087-4840-a992-3d0e2c3b150d', '4a5523a5-1601-4d39-bbf7-a9ff4132b53b', '918151913741', '', '2017-11-17 15:40:27', '2017-11-17 10:10:27', 1),
('a4d5e087-4876-4521-a9f1-93084b63acd6', '76fba5bd-eae6-4f36-a275-f5cc80afbbdd', 'f6bb64c1-fd8a-41f8-9127-d51641860fc2', '918151913742', '', '2017-11-20 14:37:46', '2017-12-01 12:45:40', 0),
('d42c6e4f-c720-4067-915c-b1a00a3ff6f0', 'b4e717cd-6a28-4f9a-807c-23cf8aaf7342', '79d2b3e2-bac6-4542-a17d-3e4764c3012d', '919035299524', 'child abuse', '2017-11-17 16:33:28', '2018-01-17 11:31:09', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_comments_category`
--

CREATE TABLE `user_comments_category` (
  `user_comments_category_id` varchar(50) NOT NULL,
  `user_comments_category_desc` longtext NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `isactive` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_comments_category`
--

INSERT INTO `user_comments_category` (`user_comments_category_id`, `user_comments_category_desc`, `created_date`, `modified_date`, `isactive`) VALUES
('24129099-3933-4033-bcb0-47c576a48866', 'Other...', '2017-11-02 12:22:04', '2017-11-15 09:38:51', 0),
('3e9565d0-9359-419c-9528-5b54ce1b1967', 'no intreseted', '2017-11-17 16:34:21', '2017-11-17 11:04:37', 0),
('588f1ffb-ad87-4d8e-bffa-70ef652f6171', 'test report', '2017-11-10 19:06:09', '2017-11-10 13:36:14', 0),
('597ec9a0-1a35-4c69-bb94-ef821de72da0', 'Other...', '2017-11-15 15:09:12', '2017-11-15 09:47:54', 0),
('6ce135ee-ea3f-4dbe-a281-15146c3db9a7', 'Social threat', '2017-11-10 19:05:54', '2017-11-10 13:35:54', 1),
('7bf77f0e-6afa-46cf-998f-16037d3e132f', 'Above 18', '2017-11-02 12:20:34', '2017-11-20 14:23:29', 1),
('8b450e82-88df-40f1-af59-5f25dfd4bf10', 'Above 18++', '2017-11-15 15:17:19', '2017-11-16 12:59:28', 1),
('969512db-f1c4-4445-93f1-abbd5f01f1e5', 'Against the Nation', '2017-11-02 12:21:34', '2017-11-20 14:23:46', 1),
('a5f95a7c-a295-4725-a24c-2c493fe0c5aa', 'Improper content', '2017-11-10 15:46:07', '2017-11-10 13:12:28', 0),
('a7fb8f8a-1df7-42c2-be8c-ace8dbd0e48f', 'not relevant', '2017-11-10 15:47:23', '2017-11-10 13:12:00', 0),
('a910258d-d60d-4213-9f20-27a4914e1448', 'Child Abuse', '2017-11-02 12:17:19', '2017-11-02 06:47:19', 1),
('b5db69e5-400d-4006-a30b-e96cc4111a84', 'Other...', '2017-11-15 15:18:06', '2017-11-16 12:55:06', 0),
('b6328302-3e1f-42a9-8656-9489ad48cd5a', 'Religious Content', '2017-11-02 12:20:00', '2017-11-02 06:50:00', 1),
('dbb529c5-9039-45b7-a5ca-ed9346d6144a', 'Against the Nation', '2017-11-15 15:09:04', '2017-11-15 09:39:04', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_comments_transaction`
--

CREATE TABLE `user_comments_transaction` (
  `user_comments_transaction_id` varchar(50) NOT NULL,
  `user_comment_id` varchar(50) NOT NULL,
  `user_comments_category_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_comments_transaction`
--

INSERT INTO `user_comments_transaction` (`user_comments_transaction_id`, `user_comment_id`, `user_comments_category_id`) VALUES
('4fa22959-bd90-4020-b4a8-118392aba7c3', '0b318ef9-f2fd-49f3-a446-c05d05eda54d', 'b6328302-3e1f-42a9-8656-9489ad48cd5a'),
('578e8e48-b9a7-4faa-8638-5a68ca46d84c', '3c7fbab0-e6a6-43f2-9a87-af9a11f7b3e8', 'a910258d-d60d-4213-9f20-27a4914e1448'),
('79e6a560-8dd8-40aa-a9f8-6bf51737f920', 'a4d5e087-4876-4521-a9f1-93084b63acd6', '8b450e82-88df-40f1-af59-5f25dfd4bf10'),
('975efefe-6e73-49fa-8d2c-dc9e7b05d9fa', '8b4a76d4-5209-4964-a1d9-b2e66a2a007f', 'b6328302-3e1f-42a9-8656-9489ad48cd5a'),
('9fcd750a-78e6-4749-87bb-30b072152e8a', 'a4d5e087-4876-4521-a9f1-93084b63acd6', 'dbb529c5-9039-45b7-a5ca-ed9346d6144a'),
('b1e95b3c-1876-41a1-8e44-0a8d5e20595a', '8b4a76d4-5209-4964-a1d9-b2e66a2a007f', '8b450e82-88df-40f1-af59-5f25dfd4bf10'),
('b7c99356-ad88-4e83-b188-418eb3d2a927', 'd42c6e4f-c720-4067-915c-b1a00a3ff6f0', 'a910258d-d60d-4213-9f20-27a4914e1448'),
('d169c623-2817-48d4-8745-e087b3846b5e', '8b4a76d4-5209-4964-a1d9-b2e66a2a007f', 'dbb529c5-9039-45b7-a5ca-ed9346d6144a'),
('f7b784f2-8592-411f-b42f-d89495fd6e02', '4e8acb98-8449-4c1c-bf9d-ef68b9ee3c6c', 'a910258d-d60d-4213-9f20-27a4914e1448');

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `user_id` varchar(191) NOT NULL DEFAULT '',
  `user_name` varchar(45) NOT NULL,
  `created_date` datetime NOT NULL,
  `vcard` mediumtext NOT NULL,
  `token` mediumtext NOT NULL,
  `updated_date` datetime NOT NULL,
  `nickname` varchar(45) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `gender` varchar(6) DEFAULT NULL,
  `dob` varchar(45) DEFAULT NULL,
  `mobileNumber` varchar(45) NOT NULL,
  `image_url` mediumtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`user_id`, `user_name`, `created_date`, `vcard`, `token`, `updated_date`, `nickname`, `status`, `email`, `gender`, `dob`, `mobileNumber`, `image_url`) VALUES
('095757577744', 'Devi', '2018-01-05 07:38:52', '{\"user_id\":\"095757577744\",\"user_name\":\"Devi\",\"nickName\":\"Devi\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJEZXZpIiwiaXNzIjoiaHR0cDovL2Rldi5idXNoZmlyZS5sYW4vc3RyaW5nZXIiLCJpYXQiOjE1MTUxMzc5MzIsImV4cCI6MTUxODc2NjczMiwibmJmIjoxNTE1MTM3OTMyLCJqdGkiOiJkWXVKRGs1UDY3R2JJa2t6In0.3Ui8aOM8dbMLoRPoUtz1yI6vzJ2zOkHjJFKMSgo93L4\",\"status\":null,\"email\":\"devi@gmail.com\",\"mobileNumber\":\"095757577744\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-05 07:38:52\",\"roles\":\"\\\"Stringer\\\"\",\"permissions\":[]}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJEZXZpIiwiaXNzIjoiaHR0cDovL2Rldi5idXNoZmlyZS5sYW4vc3RyaW5nZXIiLCJpYXQiOjE1MTUxMzc5MzIsImV4cCI6MTUxODc2NjczMiwibmJmIjoxNTE1MTM3OTMyLCJqdGkiOiJkWXVKRGs1UDY3R2JJa2t6In0.3Ui8aOM8dbMLoRPoUtz1yI6vzJ2zOkHjJFKMSgo93L4', '0000-00-00 00:00:00', 'Devi', NULL, 'devi@gmail.com', NULL, NULL, '095757577744', NULL),
('097678678777', 'Atul', '2018-01-05 09:03:13', '{\"user_id\":\"097678678777\",\"user_name\":\"Atul\",\"nickName\":\"Atul\",\"token\":[\"[\\\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJBdHVsIiwiaXNzIjoiaHR0cDovL2Rldi5idXNoZmlyZS5sYW4vcGoiLCJpYXQiOjE1MTUxMzc4MjksImV4cCI6MTUxODc2NjYyOSwibmJmIjoxNTE1MTM3ODI5LCJqdGkiOiIzakU5ODFlTUxFb0tSeXN2In0.jC16zZbH_rIA-UzMReKlaqMNiYc-14booc5KFok4DBc\\\"]\"],\"status\":null,\"email\":\"atul@gmail.com\",\"mobileNumber\":\"097678678777\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-05 09:03:13\",\"roles\":[\"\\\"Platform Jockey\\\"\"],\"permissions\":[],\"access\":\"1111\"}', '[\"[\\\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJBdHVsIiwiaXNzIjoiaHR0cDovL2Rldi5idXNoZmlyZS5sYW4vcGoiLCJpYXQiOjE1MTUxMzc4MjksImV4cCI6MTUxODc2NjYyOSwibmJmIjoxNTE1MTM3ODI5LCJqdGkiOiIzakU5ODFlTUxFb0tSeXN2In0.jC16zZbH_rIA-UzMReKlaqMNiYc-14booc5KFok4DBc\\\"]\"]', '0000-00-00 00:00:00', 'Atul', NULL, 'atul@gmail.com', NULL, NULL, '097678678777', NULL),
('19035564107', ' ', '2018-02-01 12:56:25', '{\"user_id\":\"19035564107\",\"user_name\":null,\"nickName\":null,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiIxOTAzNTU2NDEwNyIsImlzcyI6Imh0dHA6Ly8xOTIuMTY4LjIuODIvL2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTE3NDg5Nzg1LCJleHAiOjE1MjExMTg1ODUsIm5iZiI6MTUxNzQ4OTc4NSwianRpIjoibmwwM0Y2NzY5OFFTSVdOTCJ9.20SgAhNOrZcc4XbCTUn4xL_70qH4QjAN1RGucdDLza4\",\"mobileNumber\":\"19035564107\",\"status\":null,\"email\":null,\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-02-01 12:56:25\",\"roles\":[],\"permissions\":[],\"access\":null}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiIxOTAzNTU2NDEwNyIsImlzcyI6Imh0dHA6Ly8xOTIuMTY4LjIuODIvL2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTE3NDg5Nzg1LCJleHAiOjE1MjExMTg1ODUsIm5iZiI6MTUxNzQ4OTc4NSwianRpIjoibmwwM0Y2NzY5OFFTSVdOTCJ9.20SgAhNOrZcc4XbCTUn4xL_70qH4QjAN1RGucdDLza4', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, '19035564107', NULL),
('254708596536', 'Mani kenya', '2017-11-17 06:39:28', '{\"gender\":\"Male\",\"nickName\":\"Mani kenya\",\"dob\":\"17\\/11\\/2002\",\"mobileNumber\":\"254708596536\",\"name\":\"Mani kenya\",\"userName\":\"Mani kenya\",\"email\":\"mani@gmail.com\",\"status\":\"I am in BushFire\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiIyNTQ3MDg1OTY1MzYiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjM3L2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTEwOTAwNzY4LCJleHAiOjE1MTQ1Mjk1NjgsIm5iZiI6MTUxMDkwMDc2OCwianRpIjoieUNvaUgwdGxoNzhkNnZrSSJ9.rgx7h__aY_Ge--LrTGI01Eo-Ovgok7b4rTf6ezDVjGw', '2017-11-17 12:11:06', 'Mani kenya', 'I am in BushFire', 'mani@gmail.com', 'Male', '17/11/2002', '254708596536', ''),
('254708985698', 'Jaffar', '2018-02-22 07:46:22', '{\"gender\":\"Male\",\"nickName\":\"Jaffar\",\"dob\":\"22\\/02\\/2018\",\"mobileNumber\":\"254708985698\",\"name\":\"Jaffar\",\"userName\":\"Jaffar\",\"email\":\"jaffar@gmail.com\",\"status\":\"I am on BushFire\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiIyNTQ3MDg5ODU2OTgiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjgyL2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTE5Mjg1NzI4LCJleHAiOjE1MjI5MTQ1MjgsIm5iZiI6MTUxOTI4NTcyOCwianRpIjoiNlJRd0dZbTQ4NEozZGlIeCJ9.Le4ENNGI7lR675pMcLDFtZ7WVIzKzfQ05CTW0HzcBqk', '2018-02-22 13:18:55', 'Jaffar', 'I am on BushFire', 'jaffar@gmail.com', 'Male', '22/02/2018', '254708985698', ''),
('254708989808', 'Atul', '2018-02-22 07:41:06', '{\"gender\":\"Male\",\"nickName\":\"Atul\",\"dob\":\"22\\/02\\/2018\",\"mobileNumber\":\"254708989808\",\"name\":\"Atul\",\"userName\":\"Atul\",\"email\":\"atul@gmail.com\",\"status\":\"I am on BushFire\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiIyNTQ3MDg5ODk4MDgiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjgyL2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTE5Mjg1MjY2LCJleHAiOjE1MjI5MTQwNjYsIm5iZiI6MTUxOTI4NTI2NiwianRpIjoiUHZaZmIwR2F5RHgzc29wbSJ9.3x7gF1hYYkh5DVOl7j8z2agHDDQqN6h3Jzlx48teSZY', '2018-02-22 13:11:27', 'Atul', 'I am on BushFire', 'atul@gmail.com', 'Male', '22/02/2018', '254708989808', ''),
('254780859859', 'Shilpa', '2018-02-22 07:39:12', '{\"gender\":\"Male\",\"nickName\":\"Shilpa\",\"dob\":\"22\\/02\\/2018\",\"mobileNumber\":\"254780859859\",\"name\":\"Shilpa\",\"userName\":\"Shilpa\",\"email\":\"shilpa@gmail.com\",\"status\":\"I am on BushFire\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiIyNTQ3ODA4NTk4NTkiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjgyL2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTE5Mjg1MTUyLCJleHAiOjE1MjI5MTM5NTIsIm5iZiI6MTUxOTI4NTE1MiwianRpIjoiNG1xRlFqWXJNTFVCclFBbCJ9.eXudhgqAeYFD0Rl7HHAYXMbt8yVj1_oOv4PKiDqTbLo', '2018-02-22 13:09:46', 'Shilpa', 'I am on BushFire', 'shilpa@gmail.com', 'Male', '22/02/2018', '254780859859', ''),
('3355566677877', 'rani', '2018-01-05 14:08:03', '{\"user_id\":\"3355566677877\",\"user_name\":\"rani\",\"nickName\":\"rani\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJyYW5pIiwiaXNzIjoiaHR0cDovL2Rldi5idXNoZmlyZS5sYW4vcGoiLCJpYXQiOjE1MTUxNjEyODMsImV4cCI6MTUxODc5MDA4MywibmJmIjoxNTE1MTYxMjgzLCJqdGkiOiJCT1RTM0xob0tIYm9QVUdzIn0.wZP70R28rcYXk_sW6rA3ojmCg5OnbthzRjaPzUJxY9Q\",\"status\":null,\"email\":\"rani@gmail.com\",\"mobileNumber\":\"3355566677877\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-05 14:08:03\",\"roles\":[\"PLATFORMJOCKEY\"],\"permissions\":[],\"access\":\"1111\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJyYW5pIiwiaXNzIjoiaHR0cDovL2Rldi5idXNoZmlyZS5sYW4vcGoiLCJpYXQiOjE1MTUxNjEyODMsImV4cCI6MTUxODc5MDA4MywibmJmIjoxNTE1MTYxMjgzLCJqdGkiOiJCT1RTM0xob0tIYm9QVUdzIn0.wZP70R28rcYXk_sW6rA3ojmCg5OnbthzRjaPzUJxY9Q', '0000-00-00 00:00:00', 'rani', NULL, 'rani@gmail.com', NULL, NULL, '3355566677877', NULL),
('3456576578687', 'raja', '2018-01-05 14:07:30', '{\"user_id\":\"3456576578687\",\"user_name\":\"raja\",\"nickName\":\"raja\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJyYWphIiwiaXNzIjoiaHR0cDovL2Rldi5idXNoZmlyZS5sYW4vcGoiLCJpYXQiOjE1MTUxNjEwOTEsImV4cCI6MTUxODc4OTg5MSwibmJmIjoxNTE1MTYxMDkxLCJqdGkiOiIwQWJFU21tU1JsSXBINWxRIn0._w7SLb8X0nMVTyy35grWfi7d6zB8eF3SURNR3U04awQ\",\"status\":null,\"email\":\"raja@gmail.com\",\"mobileNumber\":\"3456576578687\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-05 14:07:30\",\"roles\":[\"PLATFORMJOCKEY\"],\"permissions\":[],\"access\":\"1111\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJyYWphIiwiaXNzIjoiaHR0cDovL2Rldi5idXNoZmlyZS5sYW4vcGoiLCJpYXQiOjE1MTUxNjEwOTEsImV4cCI6MTUxODc4OTg5MSwibmJmIjoxNTE1MTYxMDkxLCJqdGkiOiIwQWJFU21tU1JsSXBINWxRIn0._w7SLb8X0nMVTyy35grWfi7d6zB8eF3SURNR3U04awQ', '0000-00-00 00:00:00', 'raja', NULL, 'raja@gmail.com', NULL, NULL, '3456576578687', NULL),
('548765432654', 'Mousi', '2018-01-05 15:11:01', '{\"user_id\":\"548765432654\",\"user_name\":\"Mousi\",\"nickName\":\"Mousi\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJNb3VzaSIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3N0cmluZ2VyIiwiaWF0IjoxNTE1MTY1MDYxLCJleHAiOjE1MTg3OTM4NjEsIm5iZiI6MTUxNTE2NTA2MSwianRpIjoiNzZDdjczaXowODlJNkJXNyJ9.0Y4WpI0aTP5s_NNhXNNP9EqgVijG3soNp-06Pj5rJ_E\",\"status\":null,\"email\":\"mousitha@gmail.com\",\"mobileNumber\":\"548765432654\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-05 15:11:01\",\"roles\":[\"STRINGER\"],\"permissions\":[]}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJNb3VzaSIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3N0cmluZ2VyIiwiaWF0IjoxNTE1MTY1MDYxLCJleHAiOjE1MTg3OTM4NjEsIm5iZiI6MTUxNTE2NTA2MSwianRpIjoiNzZDdjczaXowODlJNkJXNyJ9.0Y4WpI0aTP5s_NNhXNNP9EqgVijG3soNp-06Pj5rJ_E', '0000-00-00 00:00:00', 'Mousi', NULL, 'mousitha@gmail.com', NULL, NULL, '548765432654', NULL),
('56894561234', 'shilpaaaa', '2018-01-05 10:29:00', '{\"user_id\":\"56894561234\",\"user_name\":\"shilpaaaa\",\"nickName\":\"shilpaaaa\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJzaGlscGFhYWEiLCJpc3MiOiJodHRwOi8vZGV2LmJ1c2hmaXJlLmxhbi9zdHJpbmdlciIsImlhdCI6MTUxNTE0ODE0MCwiZXhwIjoxNTE4Nzc2OTQwLCJuYmYiOjE1MTUxNDgxNDAsImp0aSI6InA2VGhDeWd2MDRMNU84V0oifQ.5PYLNUabaDNvt5mWxZ3mJJuksLOpZ15fJP4XAn_CO_U\",\"status\":null,\"email\":\"shilpasri@compass.in\",\"mobileNumber\":\"56894561234\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-05 10:29:00\",\"roles\":[\"\\\"Stringer\\\"\"],\"permissions\":[]}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJzaGlscGFhYWEiLCJpc3MiOiJodHRwOi8vZGV2LmJ1c2hmaXJlLmxhbi9zdHJpbmdlciIsImlhdCI6MTUxNTE0ODE0MCwiZXhwIjoxNTE4Nzc2OTQwLCJuYmYiOjE1MTUxNDgxNDAsImp0aSI6InA2VGhDeWd2MDRMNU84V0oifQ.5PYLNUabaDNvt5mWxZ3mJJuksLOpZ15fJP4XAn_CO_U', '0000-00-00 00:00:00', 'shilpaaaa', NULL, 'shilpasri@compass.in', NULL, NULL, '56894561234', NULL),
('855642123138', 'srisri', '2018-01-18 13:03:40', '{\"user_id\":\"855642123138\",\"user_name\":\"srisri\",\"nickName\":\"srisri\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJzcmlzcmkiLCJpc3MiOiJodHRwOi8vZGV2LmJ1c2hmaXJlLmxhbi9zdHJpbmdlciIsImlhdCI6MTUxNjI4MDYyMCwiZXhwIjoxNzM0MDIwNjIwLCJuYmYiOjE1MTYyODA2MjAsImp0aSI6IktyMEd1VlFFTDExRVlzcGkifQ.lPWUYh_MpmZ5tQ7Wep2DfTHaJ7SC-i8Al5G1WDFAxeg\",\"status\":null,\"email\":\"srisri@gmail.com\",\"mobileNumber\":\"855642123138\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-18 13:03:40\",\"roles\":[\"STRINGER\"],\"permissions\":[]}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJzcmlzcmkiLCJpc3MiOiJodHRwOi8vZGV2LmJ1c2hmaXJlLmxhbi9zdHJpbmdlciIsImlhdCI6MTUxNjI4MDYyMCwiZXhwIjoxNzM0MDIwNjIwLCJuYmYiOjE1MTYyODA2MjAsImp0aSI6IktyMEd1VlFFTDExRVlzcGkifQ.lPWUYh_MpmZ5tQ7Wep2DfTHaJ7SC-i8Al5G1WDFAxeg', '0000-00-00 00:00:00', 'srisri', NULL, 'srisri@gmail.com', NULL, NULL, '855642123138', NULL),
('887656756', 'Devi', '2018-01-05 14:08:34', '{\"user_id\":\"887656756\",\"user_name\":\"Devi\",\"nickName\":\"Devi\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJEZXZpIiwiaXNzIjoiaHR0cDovL2Rldi5idXNoZmlyZS5sYW4vcGoiLCJpYXQiOjE1MTUxNjEzMTQsImV4cCI6MTUxODc5MDExNCwibmJmIjoxNTE1MTYxMzE0LCJqdGkiOiIzc1RGenJ5WkdmckFzNTc1In0.DnYMfJZWdiS9uOGc-7eIvN5GQJySObXodhkb6aF5H74\",\"status\":null,\"email\":\"devi.p@compassitesinc.com\",\"mobileNumber\":\"887656756\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-05 14:08:34\",\"roles\":[\"PLATFORMJOCKEY\"],\"permissions\":[],\"access\":\"1111\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJEZXZpIiwiaXNzIjoiaHR0cDovL2Rldi5idXNoZmlyZS5sYW4vcGoiLCJpYXQiOjE1MTUxNjEzMTQsImV4cCI6MTUxODc5MDExNCwibmJmIjoxNTE1MTYxMzE0LCJqdGkiOiIzc1RGenJ5WkdmckFzNTc1In0.DnYMfJZWdiS9uOGc-7eIvN5GQJySObXodhkb6aF5H74', '0000-00-00 00:00:00', 'Devi', NULL, 'devi.p@compassitesinc.com', NULL, NULL, '887656756', NULL),
('889665675576', 'Shree', '2018-01-05 13:56:45', '{\"user_id\":\"889665675576\",\"user_name\":\"Shree\",\"nickName\":\"Shree\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJTaHJlZSIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3BqIiwiaWF0IjoxNTE1MTYwNjA1LCJleHAiOjE1MTg3ODk0MDUsIm5iZiI6MTUxNTE2MDYwNSwianRpIjoiSEpQTkpNcUZhSnZzZWo0RiJ9.Ho_n8ytjXg4NQWJ9cRbvDiDiRxObkfXOC42iQReBMx0\",\"status\":null,\"email\":\"sshree@gmail.com\",\"mobileNumber\":\"889665675576\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-05 13:56:45\",\"roles\":[\"PLATFORMJOCKEY\"],\"permissions\":[],\"access\":\"1111\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJTaHJlZSIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3BqIiwiaWF0IjoxNTE1MTYwNjA1LCJleHAiOjE1MTg3ODk0MDUsIm5iZiI6MTUxNTE2MDYwNSwianRpIjoiSEpQTkpNcUZhSnZzZWo0RiJ9.Ho_n8ytjXg4NQWJ9cRbvDiDiRxObkfXOC42iQReBMx0', '0000-00-00 00:00:00', 'Shree', NULL, 'sshree@gmail.com', NULL, NULL, '889665675576', NULL),
('8965675675767', 'Chandan', '2018-01-05 10:03:44', '{\"user_id\":\"8965675675767\",\"user_name\":\"Chandan\",\"nickName\":\"Chandan\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJDaGFuZGFuIiwiaXNzIjoiaHR0cDovL2Rldi5idXNoZmlyZS5sYW4vcGoiLCJpYXQiOjE1MTUxNDY2MjQsImV4cCI6MTUxODc3NTQyNCwibmJmIjoxNTE1MTQ2NjI0LCJqdGkiOiJQSVJKUlZ1aHdUQkhtUWsxIn0.gc28uJ6TqI-nFUPCmR2_CwooUykpSZESl5UPr595Dvk\",\"status\":null,\"email\":\"chandan@gmail.com\",\"mobileNumber\":\"8965675675767\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-05 10:03:44\",\"roles\":[\"\\\"Platform Jockey\\\"\"],\"permissions\":[],\"access\":\"1111\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJDaGFuZGFuIiwiaXNzIjoiaHR0cDovL2Rldi5idXNoZmlyZS5sYW4vcGoiLCJpYXQiOjE1MTUxNDY2MjQsImV4cCI6MTUxODc3NTQyNCwibmJmIjoxNTE1MTQ2NjI0LCJqdGkiOiJQSVJKUlZ1aHdUQkhtUWsxIn0.gc28uJ6TqI-nFUPCmR2_CwooUykpSZESl5UPr595Dvk', '0000-00-00 00:00:00', 'Chandan', NULL, 'chandan@gmail.com', NULL, NULL, '8965675675767', NULL),
('8986786767768', 'Amruthesh', '2018-01-05 13:31:30', '{\"user_id\":\"8986786767768\",\"user_name\":\"Amruthesh\",\"nickName\":\"Amruthesh\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJBbXJ1dGhlc2giLCJpc3MiOiJodHRwOi8vZGV2LmJ1c2hmaXJlLmxhbi9waiIsImlhdCI6MTUxNTE1ODE5NCwiZXhwIjoxNTE4Nzg2OTk0LCJuYmYiOjE1MTUxNTgxOTQsImp0aSI6IlM4UWJCaXBSWlZpQ05CdXEifQ.bgz1kc0sneHpk_xYW3g57lMvk9QCbZOTM6gMlUJd21w\",\"status\":null,\"email\":\"amruthesh1@gmail.com\",\"mobileNumber\":\"8986786767768\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-05 13:31:30\",\"roles\":[\"PLATFORMJOCKEY\"],\"permissions\":[],\"access\":\"1111\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJBbXJ1dGhlc2giLCJpc3MiOiJodHRwOi8vZGV2LmJ1c2hmaXJlLmxhbi9waiIsImlhdCI6MTUxNTE1ODE5NCwiZXhwIjoxNTE4Nzg2OTk0LCJuYmYiOjE1MTUxNTgxOTQsImp0aSI6IlM4UWJCaXBSWlZpQ05CdXEifQ.bgz1kc0sneHpk_xYW3g57lMvk9QCbZOTM6gMlUJd21w', '0000-00-00 00:00:00', 'Amruthesh', NULL, 'amruthesh1@gmail.com', NULL, NULL, '8986786767768', NULL),
('907336345534', 'todayShree', '2018-01-18 13:29:27', '{\"user_id\":\"907336345534\",\"user_name\":\"todayShree\",\"nickName\":\"todayShree\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MDczMzYzNDU1MzQiLCJpc3MiOiJodHRwOi8vZGV2LmJ1c2hmaXJlLmxhbi9hcGkvdjEvdXNlci9sb2dpbiIsImlhdCI6MTUxNjI4MjE2NywiZXhwIjoxNzM0MDIyMTY3LCJuYmYiOjE1MTYyODIxNjcsImp0aSI6IlBxd3p3YUpUUnhQRWZkQjQifQ.gV3DDARbT7NOFZolilELKwTVo2CAZVTk8SU-vRrmz5s\",\"status\":null,\"email\":\"shreetoday@gmail.com\",\"mobileNumber\":\"907336345534\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-18 13:29:27\",\"roles\":[],\"permissions\":[],\"access\":[],\"webAdmin\":1}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MDczMzYzNDU1MzQiLCJpc3MiOiJodHRwOi8vZGV2LmJ1c2hmaXJlLmxhbi9hcGkvdjEvdXNlci9sb2dpbiIsImlhdCI6MTUxNjI4MjE2NywiZXhwIjoxNzM0MDIyMTY3LCJuYmYiOjE1MTYyODIxNjcsImp0aSI6IlBxd3p3YUpUUnhQRWZkQjQifQ.gV3DDARbT7NOFZolilELKwTVo2CAZVTk8SU-vRrmz5s', '0000-00-00 00:00:00', 'todayShree', NULL, 'shreetoday@gmail.com', NULL, NULL, '907336345534', NULL),
('907678876876', 'Mani', '2018-01-05 07:06:16', '{\"user_id\":\"907678876876\",\"user_name\":\"Mani\",\"nickName\":\"Mani\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJNYW5pIiwiaXNzIjoiaHR0cDovL2Rldi5idXNoZmlyZS5sYW4vcGoiLCJpYXQiOjE1MTUxMzU5NzYsImV4cCI6MTUxODc2NDc3NiwibmJmIjoxNTE1MTM1OTc2LCJqdGkiOiIwam9hcm9LenNLS0FTa1JaIn0.okK5AMfghn38s_8593Ul8pV-xMo3zYWk-SzpjP-SZQQ\",\"status\":null,\"email\":\"mani@gmail.com\",\"mobileNumber\":\"907678876876\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-05 07:06:16\",\"roles\":\"\\\"Platform Jockey\\\"\",\"permissions\":[],\"access\":\"1111\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJNYW5pIiwiaXNzIjoiaHR0cDovL2Rldi5idXNoZmlyZS5sYW4vcGoiLCJpYXQiOjE1MTUxMzU5NzYsImV4cCI6MTUxODc2NDc3NiwibmJmIjoxNTE1MTM1OTc2LCJqdGkiOiIwam9hcm9LenNLS0FTa1JaIn0.okK5AMfghn38s_8593Ul8pV-xMo3zYWk-SzpjP-SZQQ', '0000-00-00 00:00:00', 'Mani', NULL, 'mani@gmail.com', NULL, NULL, '907678876876', NULL),
('909457847574', 'Balaa', '2018-01-05 06:49:57', '{\"user_id\":\"909457847574\",\"user_name\":\"Balaa\",\"nickName\":\"Balaa\",\"token\":[\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJCYWxhIiwiaXNzIjoiaHR0cDovL2Rldi5idXNoZmlyZS5sYW4vcGoiLCJpYXQiOjE1MTUxMzQ5NzgsImV4cCI6MTUxODc2Mzc3OCwibmJmIjoxNTE1MTM0OTc4LCJqdGkiOiI1QXExMTNHY2pwbUFuT1MzIn0.-JcrgpWL_oYjWfjYWvGhMohhw2qU5eRFi-lSHM9wZ9Y\"],\"status\":null,\"email\":\"bala@gmail.com\",\"mobileNumber\":\"909457847574\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-05 06:49:57\",\"roles\":\"\",\"permissions\":[],\"access\":\"1111\"}', '[\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJCYWxhIiwiaXNzIjoiaHR0cDovL2Rldi5idXNoZmlyZS5sYW4vcGoiLCJpYXQiOjE1MTUxMzQ5NzgsImV4cCI6MTUxODc2Mzc3OCwibmJmIjoxNTE1MTM0OTc4LCJqdGkiOiI1QXExMTNHY2pwbUFuT1MzIn0.-JcrgpWL_oYjWfjYWvGhMohhw2qU5eRFi-lSHM9wZ9Y\"]', '0000-00-00 00:00:00', 'Balaa', NULL, 'bala@gmail.com', NULL, NULL, '909457847574', NULL),
('9112300012300', 'Raja', '2017-12-14 11:20:02', '{\"nickName\":\"Raja\",\"status\":null,\"email\":\"test1@gmail.com\",\"mobileNumber\":\"9112300012300\",\"gender\":null,\"dob\":null}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTEyMzAwMDEyMzAwIiwiaXNzIjoiaHR0cDovL2Rldi5idXNoZmlyZS5sYW4vYXBpL3YxL3VzZXIvbG9naW4iLCJpYXQiOjE1MTMyNTA0MDIsImV4cCI6MTUxNjg3OTIwMiwibmJmIjoxNTEzMjUwNDAyLCJqdGkiOiJoT3ZqSmh4RjY3WlF3dWVLIn0.tOwaKJG2aOiKoCniWl3SPYNxYjtmrpB-X2d9UQ19buw', '0000-00-00 00:00:00', 'Raja', NULL, 'test1@gmail.com', NULL, NULL, '9112300012300', NULL),
('91123123456456', 'Devi Sri', '2017-12-01 11:18:13', '{\"nickName\":\"Devi Sri\",\"status\":null,\"email\":\"devi.p@compassitesinc.com\",\"mobileNumber\":\"91123123456456\",\"gender\":null,\"dob\":null}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJEZXZpIFNyaSIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL2FwaS92MS91c2VyL2xvZ2luIiwiaWF0IjoxNTEyMTI3MDkzLCJleHAiOjE1MTU3NTU4OTMsIm5iZiI6MTUxMjEyNzA5MywianRpIjoiajd2QWhPa013S0hJU3c3WCJ9.-qua4KqKN8JXy_AM9ju21c3x9Gt8n2kdVenfRcKE30I', '0000-00-00 00:00:00', 'Devi Sri', NULL, 'devi.p@compassitesinc.com', NULL, NULL, '91123123456456', NULL),
('911234567890', 'test@name', '2017-11-16 13:21:08', '{\"gender\":\"Male\",\"nickName\":\"test@name\",\"dob\":\"06\\/07\\/1997\",\"mobileNumber\":\"911234567890\",\"name\":\"test@name\",\"userName\":\"test@name\",\"email\":\"ok@ok.com\",\"status\":\"At the movies\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTEyMzQ1Njc4OTAiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjM3L2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTExMTYxMjgzLCJleHAiOjE1MTQ3OTAwODMsIm5iZiI6MTUxMTE2MTI4MywianRpIjoiMHpUNVRIUktPaGxDUWFKMSJ9.WXMb30Y1et0wJHSqjbhG71XXMO7tzsjA9i7Pz0-nEkU', '2017-11-20 12:31:39', 'test@name', 'At the movies', 'ok@ok.com', 'Male', '06/07/1997', '911234567890', ''),
('911234567891', ' ', '2017-11-20 07:01:54', '{\"nickName\":null,\"status\":null,\"email\":null,\"mobileNumber\":\"911234567891\",\"gender\":null,\"dob\":null,\"image\":null}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTEyMzQ1Njc4OTEiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjM3L2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTExMTYxMzE0LCJleHAiOjE1MTQ3OTAxMTQsIm5iZiI6MTUxMTE2MTMxNCwianRpIjoiamU3VktRREZIUjY2bXFzTSJ9.NZUObZiWPTY01idVt8hvs_o2tgfWh71eUNvcYZV85ks', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, '911234567891', NULL),
('91123456789123', 'xxxxxxxxxx', '2017-11-20 10:29:40', '{\"nickName\":\"xxxxxxxxxx\",\"status\":null,\"email\":\"test123@gmail.com\",\"mobileNumber\":\"91123456789123\",\"gender\":null,\"dob\":null}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ4eHh4eHh4eHh4IiwiaXNzIjoiaHR0cDovL2J1c2hmaXJlLmxhbi9hZG1pbi9hZGQiLCJpYXQiOjE1MTExNzM3ODAsImV4cCI6MTUxNDgwMjU4MCwibmJmIjoxNTExMTczNzgwLCJqdGkiOiJtYld3cjEzNkFsSUtNZWhqIn0.RLieRovrc_PFot1asitc-6-KvtcKyAGTDrZjzYSZDU4', '0000-00-00 00:00:00', 'xxxxxxxxxx', NULL, 'test123@gmail.com', NULL, NULL, '91123456789123', NULL),
('9114893256', 'TestStringer_8', '2018-01-18 05:54:38', '{\"user_id\":\"9114893256\",\"user_name\":\"TestStringer_8\",\"nickName\":\"TestStringer_8\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJUZXN0U3RyaW5nZXJfOCIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3N0cmluZ2VyIiwiaWF0IjoxNTE2MjU0ODc4LCJleHAiOjE3MzM5OTQ4NzgsIm5iZiI6MTUxNjI1NDg3OCwianRpIjoiSE13OVg4S2hVZlA5QVZPeiJ9.MsC_9nyzDf_KLbF9yKbJ0cuCGQV0--d5brRtGsaCsW4\",\"status\":null,\"email\":\"t6@s6.com\",\"mobileNumber\":\"9114893256\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-18 05:54:38\",\"roles\":[\"STRINGER\"],\"permissions\":[]}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJUZXN0U3RyaW5nZXJfOCIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3N0cmluZ2VyIiwiaWF0IjoxNTE2MjU0ODc4LCJleHAiOjE3MzM5OTQ4NzgsIm5iZiI6MTUxNjI1NDg3OCwianRpIjoiSE13OVg4S2hVZlA5QVZPeiJ9.MsC_9nyzDf_KLbF9yKbJ0cuCGQV0--d5brRtGsaCsW4', '0000-00-00 00:00:00', 'TestStringer_8', NULL, 't6@s6.com', NULL, NULL, '9114893256', NULL),
('91154632589', 'TestPj_8', '2018-01-18 04:14:28', '{\"user_id\":\"91154632589\",\"user_name\":\"TestPj_8\",\"nickName\":\"TestPj_8\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJUZXN0UGpfOCIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3BqIiwiaWF0IjoxNTE2MjQ4ODY4LCJleHAiOjE3MzM5ODg4NjgsIm5iZiI6MTUxNjI0ODg2OCwianRpIjoiQ2dBc2dON3FzaXI5MzZ0ZCJ9.rDypDOVRbzxU43xKmhfrZAFzgS-BTniOX2q6RV__7mY\",\"status\":null,\"email\":\"t6@p6.com\",\"mobileNumber\":\"91154632589\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-18 04:14:28\",\"roles\":[\"PLATFORMJOCKEY\"],\"permissions\":[],\"access\":\"1111\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJUZXN0UGpfOCIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3BqIiwiaWF0IjoxNTE2MjQ4ODY4LCJleHAiOjE3MzM5ODg4NjgsIm5iZiI6MTUxNjI0ODg2OCwianRpIjoiQ2dBc2dON3FzaXI5MzZ0ZCJ9.rDypDOVRbzxU43xKmhfrZAFzgS-BTniOX2q6RV__7mY', '0000-00-00 00:00:00', 'TestPj_8', NULL, 't6@p6.com', NULL, NULL, '91154632589', NULL),
('911578934645', 'TestStringer_6', '2018-01-16 04:31:24', '{\"user_id\":\"911578934645\",\"user_name\":\"TestStringer_6\",\"nickName\":\"TestStringer_6\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJUZXN0U3RyaW5nZXJfNiIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3N0cmluZ2VyIiwiaWF0IjoxNTE2MDc3MDg0LCJleHAiOjE1MTk3MDU4ODQsIm5iZiI6MTUxNjA3NzA4NCwianRpIjoiTUdTMUlKVDRsU0llWk1idyJ9.XjIEw6FxIPkk1HQOxnoZP55Go1gQqlsRrj_tT7W-6EY\",\"status\":null,\"email\":\"t4@s4.com\",\"mobileNumber\":\"911578934645\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-16 04:31:24\",\"roles\":[\"STRINGER\"],\"permissions\":[]}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJUZXN0U3RyaW5nZXJfNiIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3N0cmluZ2VyIiwiaWF0IjoxNTE2MDc3MDg0LCJleHAiOjE1MTk3MDU4ODQsIm5iZiI6MTUxNjA3NzA4NCwianRpIjoiTUdTMUlKVDRsU0llWk1idyJ9.XjIEw6FxIPkk1HQOxnoZP55Go1gQqlsRrj_tT7W-6EY', '0000-00-00 00:00:00', 'TestStringer_6', NULL, 't4@s4.com', NULL, NULL, '911578934645', NULL),
('91159789123', 'TestPj_5', '2018-01-17 07:49:14', '{\"user_id\":\"91159789123\",\"user_name\":\"TestPj_5\",\"nickName\":\"TestPj_5\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJUZXN0UGpfNSIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3BqIiwiaWF0IjoxNTE1NzI5NjcwLCJleHAiOjE1MTkzNTg0NzAsIm5iZiI6MTUxNTcyOTY3MCwianRpIjoiRUxzOWVQSmdUTmk3Q0pEZCJ9.kUkf0n-YAgRnrc-IA5Ilxhrekj13ijFNPh42FO_dGgA\",\"status\":null,\"email\":\"t2@p2.com\",\"mobileNumber\":\"91159789123\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-17 07:49:14\",\"roles\":[\"PLATFORMJOCKEY\"],\"permissions\":[],\"access\":\"1111\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJUZXN0UGpfNSIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3BqIiwiaWF0IjoxNTE1NzI5NjcwLCJleHAiOjE1MTkzNTg0NzAsIm5iZiI6MTUxNTcyOTY3MCwianRpIjoiRUxzOWVQSmdUTmk3Q0pEZCJ9.kUkf0n-YAgRnrc-IA5Ilxhrekj13ijFNPh42FO_dGgA', '0000-00-00 00:00:00', 'TestPj_5', NULL, 't2@p2.com', NULL, NULL, '91159789123', NULL),
('9123232345456', 'Sathish', '2017-12-08 09:52:42', '{\"user_id\":\"9123232345456\",\"user_name\":\"Sathish\",\"nickName\":\"Sathish\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJTYXRoaXNoIiwiaXNzIjoiaHR0cDovL2Rldi5idXNoZmlyZS5sYW4vbG9naW4iLCJpYXQiOjE1MTI3MjY3NjIsImV4cCI6MTUxNjM1NTU2MiwibmJmIjoxNTEyNzI2NzYyLCJqdGkiOiJSc2lQWFhicThYVTh0OVgxIn0.bSNWgJNxJf4Jwy8FGCu3Ed7SaM2S8MKV_dt1J49rr0Y\",\"status\":null,\"email\":\"sat@gmail.com\",\"mobileNumber\":\"9123232345456\",\"gender\":null,\"dob\":null,\"webAdmin\":1,\"created_date\":\"2017-12-08 09:52:42\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJTYXRoaXNoIiwiaXNzIjoiaHR0cDovL2Rldi5idXNoZmlyZS5sYW4vbG9naW4iLCJpYXQiOjE1MTI3MjY3NjIsImV4cCI6MTUxNjM1NTU2MiwibmJmIjoxNTEyNzI2NzYyLCJqdGkiOiJSc2lQWFhicThYVTh0OVgxIn0.bSNWgJNxJf4Jwy8FGCu3Ed7SaM2S8MKV_dt1J49rr0Y', '0000-00-00 00:00:00', 'Sathish', NULL, 'sat@gmail.com', NULL, NULL, '9123232345456', NULL),
('91326549841498411', 'PJ11111191 edit', '2018-03-19 15:25:24', '{\"user_id\":\"91326549841498411\",\"user_name\":\"PJ11111191 edit\",\"nickName\":\"PJ11111191 edit\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJQSjExMTExMTkxIiwiaXNzIjoiaHR0cDovL2J1c2hmaXJlLmFwcC9waiIsImlhdCI6MTUyMTQ3MzEwOCwiZXhwIjoxNzM5MjEzMTA4LCJuYmYiOjE1MjE0NzMxMDgsImp0aSI6ImkxRm1kNFJJMnlxSjRIMzgifQ.zTg1govAxaFQ1RscAtSxaZLm2_ss_dnhktTUnN1lP0o\",\"status\":null,\"email\":\"jhghjg@kjhkj.com\",\"mobileNumber\":\"91326549841498411\",\"gender\":null,\"dob\":null,\"image_url\":\"\\/home\\/vagrant\\/code\\/bushfire-webadmin\\/public\\/assets\\/img\\/profiles\\/ki4wqgrnbeautiful-natural-scenery-05-hd-pictures-166228.jpg\",\"created_date\":\"2018-03-19 15:25:24\",\"roles\":[\"PLATFORMJOCKEY\"],\"permissions\":[],\"access\":\"1111\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJQSjExMTExMTkxIiwiaXNzIjoiaHR0cDovL2J1c2hmaXJlLmFwcC9waiIsImlhdCI6MTUyMTQ3MzEwOCwiZXhwIjoxNzM5MjEzMTA4LCJuYmYiOjE1MjE0NzMxMDgsImp0aSI6ImkxRm1kNFJJMnlxSjRIMzgifQ.zTg1govAxaFQ1RscAtSxaZLm2_ss_dnhktTUnN1lP0o', '0000-00-00 00:00:00', 'PJ11111191 edit', NULL, 'jhghjg@kjhkj.com', NULL, NULL, '91326549841498411', '/home/vagrant/code/bushfire-webadmin/public/assets/img/profiles/ki4wqgrnbeautiful-natural-scenery-05-hd-pictures-166228.jpg'),
('91357123789', 'TestStringer_5', '2018-01-12 04:05:15', '{\"user_id\":\"91357123789\",\"user_name\":\"TestStringer_5\",\"nickName\":\"TestStringer_5\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJUZXN0U3RyaW5nZXJfNSIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3N0cmluZ2VyIiwiaWF0IjoxNTE1NzI5OTE1LCJleHAiOjE1MTkzNTg3MTUsIm5iZiI6MTUxNTcyOTkxNSwianRpIjoia1FCTlFOYk1TRzI0dEpIRiJ9.beZ5UdwrMnoGZ_E1eDIabqoUA1jiwe9eYLNntw22qjg\",\"status\":null,\"email\":\"t2@s2.com\",\"mobileNumber\":\"91357123789\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-12 04:05:15\",\"roles\":[\"STRINGER\"],\"permissions\":[]}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJUZXN0U3RyaW5nZXJfNSIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3N0cmluZ2VyIiwiaWF0IjoxNTE1NzI5OTE1LCJleHAiOjE1MTkzNTg3MTUsIm5iZiI6MTUxNTcyOTkxNSwianRpIjoia1FCTlFOYk1TRzI0dEpIRiJ9.beZ5UdwrMnoGZ_E1eDIabqoUA1jiwe9eYLNntw22qjg', '0000-00-00 00:00:00', 'TestStringer_5', NULL, 't2@s2.com', NULL, NULL, '91357123789', NULL),
('91454872', 'hummmmmmm', '2018-01-18 10:34:00', '{\"user_id\":\"91454872\",\"user_name\":\"hummmmmmm\",\"nickName\":\"hummmmmmm\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJodW1tbW1tbW0iLCJpc3MiOiJodHRwOi8vZGV2LmJ1c2hmaXJlLmxhbi9zdHJpbmdlciIsImlhdCI6MTUxNjI3MTY0MCwiZXhwIjoxNzM0MDExNjQwLCJuYmYiOjE1MTYyNzE2NDAsImp0aSI6IjFpMDJDQW1EZzF1YmtSdkkifQ.tOFuwUmUlJm0J-y4wDvvHnGk590GTnUhcW2gCuBubU0\",\"status\":null,\"email\":\"hgfh@kjhkj.com\",\"mobileNumber\":\"91454872\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-18 10:34:00\",\"roles\":[\"STRINGER\"],\"permissions\":[]}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJodW1tbW1tbW0iLCJpc3MiOiJodHRwOi8vZGV2LmJ1c2hmaXJlLmxhbi9zdHJpbmdlciIsImlhdCI6MTUxNjI3MTY0MCwiZXhwIjoxNzM0MDExNjQwLCJuYmYiOjE1MTYyNzE2NDAsImp0aSI6IjFpMDJDQW1EZzF1YmtSdkkifQ.tOFuwUmUlJm0J-y4wDvvHnGk590GTnUhcW2gCuBubU0', '0000-00-00 00:00:00', 'hummmmmmm', NULL, 'hgfh@kjhkj.com', NULL, NULL, '91454872', NULL),
('91456565878123', 'Devi', '2018-01-19 11:03:37', '{\"user_id\":\"91456565878123\",\"user_name\":\"Devi\",\"nickName\":\"Devi\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJEZXZpIiwiaXNzIjoiaHR0cDovL2Rldi5idXNoZmlyZS5sYW4vYXBpL3YxL3VzZXIvbG9naW4iLCJpYXQiOjE1MTYzNTk4MTcsImV4cCI6MTczNDA5OTgxNywibmJmIjoxNTE2MzU5ODE3LCJqdGkiOiJYSlRMcEpuTVFqUEN6SDVXIn0.PWb_dAMfAe0eRUnsFG_Fyag9INPC_QrRvQBnx_mpMzo\",\"status\":null,\"email\":\"devijanaki91@gmail.com\",\"mobileNumber\":\"91456565878123\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-19 11:03:37\",\"roles\":[],\"permissions\":[],\"access\":[],\"webAdmin\":1}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJEZXZpIiwiaXNzIjoiaHR0cDovL2Rldi5idXNoZmlyZS5sYW4vYXBpL3YxL3VzZXIvbG9naW4iLCJpYXQiOjE1MTYzNTk4MTcsImV4cCI6MTczNDA5OTgxNywibmJmIjoxNTE2MzU5ODE3LCJqdGkiOiJYSlRMcEpuTVFqUEN6SDVXIn0.PWb_dAMfAe0eRUnsFG_Fyag9INPC_QrRvQBnx_mpMzo', '0000-00-00 00:00:00', 'Devi', NULL, 'devijanaki91@gmail.com', NULL, NULL, '91456565878123', NULL),
('914567894666', 'testpj2', '2018-02-12 07:01:42', '{\"user_id\":\"914567894666\",\"user_name\":\"testpj2\",\"nickName\":\"testpj2\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ0ZXN0cGoyIiwiaXNzIjoiaHR0cDovL2Rldi5idXNoZmlyZS5sYW4vcGoiLCJpYXQiOjE1MTg0MTg5MDIsImV4cCI6MTczNjE1ODkwMiwibmJmIjoxNTE4NDE4OTAyLCJqdGkiOiJqaE5xUEVIMnB0Mko2YWswIn0.osur9Is1wgbsF5thVW9M48HTrSlA2k4TvC-r4NlMDX0\",\"status\":null,\"email\":\"testpj2@gmail.com\",\"mobileNumber\":\"914567894666\",\"gender\":null,\"dob\":null,\"image_url\":\"\\/var\\/www\\/chat\\/bushfire_webadmin\\/public\\/assets\\/img\\/profiles\\/evdu0gf4download.jpg\",\"created_date\":\"2018-02-12 07:01:42\",\"roles\":[\"PLATFORMJOCKEY\"],\"permissions\":[],\"access\":\"1111\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ0ZXN0cGoyIiwiaXNzIjoiaHR0cDovL2Rldi5idXNoZmlyZS5sYW4vcGoiLCJpYXQiOjE1MTg0MTg5MDIsImV4cCI6MTczNjE1ODkwMiwibmJmIjoxNTE4NDE4OTAyLCJqdGkiOiJqaE5xUEVIMnB0Mko2YWswIn0.osur9Is1wgbsF5thVW9M48HTrSlA2k4TvC-r4NlMDX0', '0000-00-00 00:00:00', 'testpj2', NULL, 'testpj2@gmail.com', NULL, NULL, '914567894666', '/var/www/chat/bushfire_webadmin/public/assets/img/profiles/evdu0gf4download.jpg'),
('9145879989898', '5thpj willings', '2018-02-12 12:40:57', '{\"user_id\":\"9145879989898\",\"user_name\":\"5thpj willings\",\"nickName\":\"5thpj willings\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI1dGhwaiB3aWxsaW5ncyIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3BqIiwiaWF0IjoxNTE4NDM5MjU3LCJleHAiOjE3MzYxNzkyNTcsIm5iZiI6MTUxODQzOTI1NywianRpIjoidmt4WTZGOWd2TWYzUlJlUyJ9.OSBouAF_fKuCVjAyHOP15fdmO86rJF9ppVIiUqzA2MI\",\"status\":null,\"email\":\"5thpj@gmail.com\",\"mobileNumber\":\"9145879989898\",\"gender\":null,\"dob\":null,\"image_url\":\"\\/var\\/www\\/chat\\/bushfire_webadmin\\/public\\/assets\\/img\\/profiles\\/slauxxzgtamil.png\",\"created_date\":\"2018-02-12 12:40:57\",\"roles\":[\"PLATFORMJOCKEY\"],\"permissions\":[],\"access\":\"1111\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI1dGhwaiB3aWxsaW5ncyIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3BqIiwiaWF0IjoxNTE4NDM5MjU3LCJleHAiOjE3MzYxNzkyNTcsIm5iZiI6MTUxODQzOTI1NywianRpIjoidmt4WTZGOWd2TWYzUlJlUyJ9.OSBouAF_fKuCVjAyHOP15fdmO86rJF9ppVIiUqzA2MI', '0000-00-00 00:00:00', '5thpj willings', NULL, '5thpj@gmail.com', NULL, NULL, '9145879989898', '/var/www/chat/bushfire_webadmin/public/assets/img/profiles/slauxxzgtamil.png'),
('914852697123', 'TestStringer_7', '2018-01-17 05:54:32', '{\"user_id\":\"914852697123\",\"user_name\":\"TestStringer_7\",\"nickName\":\"TestStringer_7\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJUZXN0U3RyaW5nZXJfNyIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3N0cmluZ2VyIiwiaWF0IjoxNTE2MTY4NDcyLCJleHAiOjE1MTk3OTcyNzIsIm5iZiI6MTUxNjE2ODQ3MiwianRpIjoiSXIxZW9RU01LWFVhT3JsRiJ9.DHzphGSTQ_u8LL_MNs3BgGyGHQkJRZw-v-G_ghbRExE\",\"status\":null,\"email\":\"t5@s5.com\",\"mobileNumber\":\"914852697123\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-17 05:54:32\",\"roles\":[\"STRINGER\"],\"permissions\":[]}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJUZXN0U3RyaW5nZXJfNyIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3N0cmluZ2VyIiwiaWF0IjoxNTE2MTY4NDcyLCJleHAiOjE1MTk3OTcyNzIsIm5iZiI6MTUxNjE2ODQ3MiwianRpIjoiSXIxZW9RU01LWFVhT3JsRiJ9.DHzphGSTQ_u8LL_MNs3BgGyGHQkJRZw-v-G_ghbRExE', '0000-00-00 00:00:00', 'TestStringer_7', NULL, 't5@s5.com', NULL, NULL, '914852697123', NULL),
('915456455455', 'testpj3', '2018-02-12 07:02:38', '{\"user_id\":\"915456455455\",\"user_name\":\"testpj3\",\"nickName\":\"testpj3\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ0ZXN0cGozIiwiaXNzIjoiaHR0cDovL2Rldi5idXNoZmlyZS5sYW4vcGoiLCJpYXQiOjE1MTg0MTg5NTgsImV4cCI6MTczNjE1ODk1OCwibmJmIjoxNTE4NDE4OTU4LCJqdGkiOiI5VUs4R055RlNvR08zT05GIn0.C0Il3ecUHCBIK1kuLjaaB3vL8xQz99YfNIhdEFUBZPc\",\"status\":null,\"email\":\"testpj3@gmail.com\",\"mobileNumber\":\"915456455455\",\"gender\":null,\"dob\":null,\"image_url\":\"\\/var\\/www\\/chat\\/bushfire_webadmin\\/public\\/assets\\/img\\/profiles\\/qaglax2adownload.jpg\",\"created_date\":\"2018-02-12 07:02:38\",\"roles\":[\"PLATFORMJOCKEY\"],\"permissions\":[],\"access\":\"1111\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ0ZXN0cGozIiwiaXNzIjoiaHR0cDovL2Rldi5idXNoZmlyZS5sYW4vcGoiLCJpYXQiOjE1MTg0MTg5NTgsImV4cCI6MTczNjE1ODk1OCwibmJmIjoxNTE4NDE4OTU4LCJqdGkiOiI5VUs4R055RlNvR08zT05GIn0.C0Il3ecUHCBIK1kuLjaaB3vL8xQz99YfNIhdEFUBZPc', '0000-00-00 00:00:00', 'testpj3', NULL, 'testpj3@gmail.com', NULL, NULL, '915456455455', '/var/www/chat/bushfire_webadmin/public/assets/img/profiles/qaglax2adownload.jpg'),
('91546563131326', 'testpj4', '2018-02-12 07:04:51', '{\"user_id\":\"91546563131326\",\"user_name\":\"testpj4\",\"nickName\":\"testpj4\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ0ZXN0cGo0IiwiaXNzIjoiaHR0cDovL2Rldi5idXNoZmlyZS5sYW4vcGoiLCJpYXQiOjE1MTg0MTkwOTEsImV4cCI6MTczNjE1OTA5MSwibmJmIjoxNTE4NDE5MDkxLCJqdGkiOiIyN0dhMjhVaWtPUHRZSlJuIn0.jqAd5Ich4CDirUozeS3Mb7-rnddlMTuBOEe-WyeDSFA\",\"status\":null,\"email\":\"testpj4@gmail.com\",\"mobileNumber\":\"91546563131326\",\"gender\":null,\"dob\":null,\"image_url\":\"\\/var\\/www\\/chat\\/bushfire_webadmin\\/public\\/assets\\/img\\/profiles\\/5oxh0jkcdownload.jpg\",\"created_date\":\"2018-02-12 07:04:51\",\"roles\":[\"PLATFORMJOCKEY\"],\"permissions\":[],\"access\":\"1111\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ0ZXN0cGo0IiwiaXNzIjoiaHR0cDovL2Rldi5idXNoZmlyZS5sYW4vcGoiLCJpYXQiOjE1MTg0MTkwOTEsImV4cCI6MTczNjE1OTA5MSwibmJmIjoxNTE4NDE5MDkxLCJqdGkiOiIyN0dhMjhVaWtPUHRZSlJuIn0.jqAd5Ich4CDirUozeS3Mb7-rnddlMTuBOEe-WyeDSFA', '0000-00-00 00:00:00', 'testpj4', NULL, 'testpj4@gmail.com', NULL, NULL, '91546563131326', '/var/www/chat/bushfire_webadmin/public/assets/img/profiles/5oxh0jkcdownload.jpg'),
('915828285828', 'Geetha', '2018-01-19 09:00:16', '{\"gender\":\"Male\",\"nickName\":\"Geetha\",\"dob\":\"19\\/01\\/1996\",\"mobileNumber\":\"915828285828\",\"name\":\"Geetha\",\"userName\":\"Geetha\",\"email\":\"gyyg@gmail.com\",\"status\":\"I am on BushFire\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTU4MjgyODU4MjgiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjgyL2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTE2MzU1MTg3LCJleHAiOjE1MTk5ODM5ODcsIm5iZiI6MTUxNjM1NTE4NywianRpIjoicHVNMWI2QWtFdmhXMEhVQSJ9.raaQRtEFVIqQJNkcfHY2HHAiTogXgarfF_IfWNt1Ifc', '2018-01-19 15:22:22', 'Geetha', 'I am on BushFire', 'gyyg@gmail.com', 'Male', '19/01/1996', '915828285828', ''),
('91654789321', 'user1', '2018-01-05 13:14:36', '{\"user_id\":\"91654789321\",\"user_name\":\"user1\",\"nickName\":\"user1\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1c2VyMSIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3BqIiwiaWF0IjoxNTE1MTUzODMyLCJleHAiOjE1MTg3ODI2MzIsIm5iZiI6MTUxNTE1MzgzMiwianRpIjoibzA2Vm01eTF1WHFubmhpRSJ9.8wp1sW78mN6qAM1_2Jr-DrrSxN4j0eNHizv0NwLDTUE\",\"status\":null,\"email\":\"user1@gmail.com\",\"mobileNumber\":\"91654789321\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-05 13:14:36\",\"roles\":[\"PLATFORMJOCKEY\"],\"permissions\":[],\"access\":\"1111\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1c2VyMSIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3BqIiwiaWF0IjoxNTE1MTUzODMyLCJleHAiOjE1MTg3ODI2MzIsIm5iZiI6MTUxNTE1MzgzMiwianRpIjoibzA2Vm01eTF1WHFubmhpRSJ9.8wp1sW78mN6qAM1_2Jr-DrrSxN4j0eNHizv0NwLDTUE', '0000-00-00 00:00:00', 'user1', NULL, 'user1@gmail.com', NULL, NULL, '91654789321', NULL),
('9165534534534534', 'radha', '2017-12-08 10:01:31', '{\"nickName\":\"radha\",\"status\":null,\"email\":\"radhatest@gmail.com\",\"mobileNumber\":\"9165534534534534\",\"gender\":null,\"dob\":null}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJyYWRoYSIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL2FwaS92MS91c2VyL2xvZ2luIiwiaWF0IjoxNTEyNzI3MjkxLCJleHAiOjE1MTYzNTYwOTEsIm5iZiI6MTUxMjcyNzI5MSwianRpIjoiTnZMT21CWlhIalpkTVBhOSJ9.GgYuRzoH9XLSjFBbEVECqmtXiCR4hAQO7De7tJoWzW8', '0000-00-00 00:00:00', 'radha', NULL, 'radhatest@gmail.com', NULL, NULL, '9165534534534534', NULL),
('9165813246798', 'TestBA', '2018-03-19 10:36:40', '{\"user_id\":\"9165813246798\",\"user_name\":\"TestBA\",\"nickName\":\"TestBA\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJUZXN0QkEiLCJpc3MiOiJodHRwOi8vYnVzaGZpcmUuYXBwL2FkbWluL2FkZCIsImlhdCI6MTUyMTQ1NTgwMCwiZXhwIjoxNzM5MTk1ODAwLCJuYmYiOjE1MjE0NTU4MDAsImp0aSI6InZpNUVoUHpDelUwWTVSb2sifQ.pyzcIAbdroTXsl20fvHvQQauT6nM1XGKuBKidkMt0Co\",\"status\":null,\"email\":\"aa@bb1233.com\",\"mobileNumber\":\"9165813246798\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-03-19 10:36:40\",\"roles\":[],\"permissions\":[],\"access\":[]}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJUZXN0QkEiLCJpc3MiOiJodHRwOi8vYnVzaGZpcmUuYXBwL2FkbWluL2FkZCIsImlhdCI6MTUyMTQ1NTgwMCwiZXhwIjoxNzM5MTk1ODAwLCJuYmYiOjE1MjE0NTU4MDAsImp0aSI6InZpNUVoUHpDelUwWTVSb2sifQ.pyzcIAbdroTXsl20fvHvQQauT6nM1XGKuBKidkMt0Co', '0000-00-00 00:00:00', 'TestBA', NULL, 'aa@bb1233.com', NULL, NULL, '9165813246798', NULL),
('917019088381', 'Vijay 2', '2017-11-20 13:59:10', '{\"gender\":\"Male\",\"nickName\":\"Vijay 2\",\"dob\":\"20\\/11\\/2009\",\"mobileNumber\":\"917019088381\",\"name\":\"Vijay 2\",\"userName\":\"Vijay 2\",\"email\":\"a@b.com\",\"status\":\"I am in BushFire\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTcwMTkwODgzODEiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjgyL2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTE1NDgwNzEyLCJleHAiOjE1MTkxMDk1MTIsIm5iZiI6MTUxNTQ4MDcxMiwianRpIjoiaXlrdmtvaklsc3M4VWdNMSJ9.vnYS08uF6wf72jyDoeBLVUa78eSO7-M7z0ZZrS5E1vM', '2018-01-09 12:21:56', 'Vijay 2', 'I am in BushFire', 'a@b.com', 'Male', '20/11/2009', '917019088381', NULL),
('91712345678', 'Test PJ _g1', '2018-01-09 06:23:43', '{\"user_id\":\"91712345678\",\"user_name\":\"Test PJ _g1\",\"nickName\":\"Test PJ _g1\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJUZXN0IFBKIF9nMSIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3BqIiwiaWF0IjoxNTE1NDc5MDIzLCJleHAiOjE1MTkxMDc4MjMsIm5iZiI6MTUxNTQ3OTAyMywianRpIjoiNVNXSFlGcUdza0NNY3JIbSJ9.3fBtAEe25HJ8bX_Kcj5-iRVgCPr4xHRSc-3r9fVp5wo\",\"status\":null,\"email\":\"test_pj_g_1@test.com\",\"mobileNumber\":\"91712345678\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-09 06:23:43\",\"roles\":[\"PLATFORMJOCKEY\"],\"permissions\":[],\"access\":\"1111\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJUZXN0IFBKIF9nMSIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3BqIiwiaWF0IjoxNTE1NDc5MDIzLCJleHAiOjE1MTkxMDc4MjMsIm5iZiI6MTUxNTQ3OTAyMywianRpIjoiNVNXSFlGcUdza0NNY3JIbSJ9.3fBtAEe25HJ8bX_Kcj5-iRVgCPr4xHRSc-3r9fVp5wo', '0000-00-00 00:00:00', 'Test PJ _g1', NULL, 'test_pj_g_1@test.com', NULL, NULL, '91712345678', NULL),
('917123456789', 'TestPJ123789', '2018-01-09 06:41:00', '{\"user_id\":\"917123456789\",\"user_name\":\"TestPJ123789\",\"nickName\":\"TestPJ123789\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJUZXN0UEoxMjM3ODkiLCJpc3MiOiJodHRwOi8vZGV2LmJ1c2hmaXJlLmxhbi9waiIsImlhdCI6MTUxNTQ4MDA2MCwiZXhwIjoxNTE5MTA4ODYwLCJuYmYiOjE1MTU0ODAwNjAsImp0aSI6IkFXSGpyakd4SEJYUDV5WDEifQ.Egnb1A-uwe2xT1_xu04yQ8_7uaFsdakL4Mn6B9Q0xHY\",\"status\":null,\"email\":\"aaa@bbbb1.com\",\"mobileNumber\":\"917123456789\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-09 06:41:00\",\"roles\":[\"PLATFORMJOCKEY\"],\"permissions\":[],\"access\":\"1111\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJUZXN0UEoxMjM3ODkiLCJpc3MiOiJodHRwOi8vZGV2LmJ1c2hmaXJlLmxhbi9waiIsImlhdCI6MTUxNTQ4MDA2MCwiZXhwIjoxNTE5MTA4ODYwLCJuYmYiOjE1MTU0ODAwNjAsImp0aSI6IkFXSGpyakd4SEJYUDV5WDEifQ.Egnb1A-uwe2xT1_xu04yQ8_7uaFsdakL4Mn6B9Q0xHY', '0000-00-00 00:00:00', 'TestPJ123789', NULL, 'aaa@bbbb1.com', NULL, NULL, '917123456789', NULL),
('91712345698', 'Test Stringer _g1', '2018-01-09 06:46:38', '{\"user_id\":\"91712345698\",\"user_name\":\"Test Stringer _g1\",\"nickName\":\"Test Stringer _g1\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJUZXN0IFN0cmluZ2VyIF9nMSIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3N0cmluZ2VyIiwiaWF0IjoxNTE1NDgwMzk4LCJleHAiOjE1MTkxMDkxOTgsIm5iZiI6MTUxNTQ4MDM5OCwianRpIjoiVFVIMkxYVDA3QVJVQ280UiJ9.cQBqOajBpVtIvQrAbtFbCkMT4wzlVNT_HnmIu_TWaww\",\"status\":null,\"email\":\"test_stringer_g_1@test.com\",\"mobileNumber\":\"91712345698\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-09 06:46:38\",\"roles\":[\"STRINGER\"],\"permissions\":[]}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJUZXN0IFN0cmluZ2VyIF9nMSIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3N0cmluZ2VyIiwiaWF0IjoxNTE1NDgwMzk4LCJleHAiOjE1MTkxMDkxOTgsIm5iZiI6MTUxNTQ4MDM5OCwianRpIjoiVFVIMkxYVDA3QVJVQ280UiJ9.cQBqOajBpVtIvQrAbtFbCkMT4wzlVNT_HnmIu_TWaww', '0000-00-00 00:00:00', 'Test Stringer _g1', NULL, 'test_stringer_g_1@test.com', NULL, NULL, '91712345698', NULL),
('91741258963', 'TestPj_3', '2018-01-10 04:49:27', '{\"user_id\":\"91741258963\",\"user_name\":\"TestPj_3\",\"nickName\":\"TestPj_3\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJUZXN0UGpfMyIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3BqIiwiaWF0IjoxNTE1NTU5NzY3LCJleHAiOjE1MTkxODg1NjcsIm5iZiI6MTUxNTU1OTc2NywianRpIjoicVNoWnRXSVdzSmF1NlRVNyJ9.zFhXrodhUCpOxPxN9nMOjvWNZqPNcvTx-XVx_xTSiYQ\",\"status\":null,\"email\":\"t@p.com\",\"mobileNumber\":\"91741258963\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-10 04:49:27\",\"roles\":[\"PLATFORMJOCKEY\"],\"permissions\":[],\"access\":\"1111\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJUZXN0UGpfMyIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3BqIiwiaWF0IjoxNTE1NTU5NzY3LCJleHAiOjE1MTkxODg1NjcsIm5iZiI6MTUxNTU1OTc2NywianRpIjoicVNoWnRXSVdzSmF1NlRVNyJ9.zFhXrodhUCpOxPxN9nMOjvWNZqPNcvTx-XVx_xTSiYQ', '0000-00-00 00:00:00', 'TestPj_3', NULL, 't@p.com', NULL, NULL, '91741258963', NULL),
('917539812466', 'TestPj_6', '2018-01-16 04:26:59', '{\"user_id\":\"917539812466\",\"user_name\":\"TestPj_6\",\"nickName\":\"TestPj_6\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJUZXN0UGpfNiIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3BqIiwiaWF0IjoxNTE2MDc2ODE5LCJleHAiOjE1MTk3MDU2MTksIm5iZiI6MTUxNjA3NjgxOSwianRpIjoiNjh6Ymc4b1FWUURxTFBhdCJ9.7-hHGST5NgfIMZF99yfp3rIpgYxEdUGVNv0QgEAwSqs\",\"status\":null,\"email\":\"t4@p4.com\",\"mobileNumber\":\"917539812466\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-16 04:26:59\",\"roles\":[\"PLATFORMJOCKEY\"],\"permissions\":[],\"access\":\"1111\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJUZXN0UGpfNiIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3BqIiwiaWF0IjoxNTE2MDc2ODE5LCJleHAiOjE1MTk3MDU2MTksIm5iZiI6MTUxNjA3NjgxOSwianRpIjoiNjh6Ymc4b1FWUURxTFBhdCJ9.7-hHGST5NgfIMZF99yfp3rIpgYxEdUGVNv0QgEAwSqs', '0000-00-00 00:00:00', 'TestPj_6', NULL, 't4@p4.com', NULL, NULL, '917539812466', NULL),
('917708102496', ' ', '2018-01-10 10:16:34', '{\"nickName\":\"Geetha\",\"image\":[],\"name\":\"Geetha\",\"mobileNumber\":\"917708102496\",\"status\":\"At the movies\",\"email\":\"asd@asd.com\",\"gender\":\"Female\",\"dob\":\"10\\/01\\/1990\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTc3MDgxMDI0OTYiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjgyL2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTE1OTk1MzcyLCJleHAiOjE1MTk2MjQxNzIsIm5iZiI6MTUxNTk5NTM3MiwianRpIjoiY0NsQ3lCdldYMFcxQWpDRCJ9.MP61aTp5z5VxB4BD8SzBnRV7sNLzNN8yo5SViLY2Qoc', '2018-01-15 05:49:32', NULL, NULL, NULL, NULL, NULL, '917708102496', NULL),
('917760464258', 'Shuklaqrg', '2017-12-13 06:52:52', '{\"gender\":\"Female\",\"nickName\":\"Shukla\",\"dob\":\"13\\/12\\/1990\",\"mobileNumber\":\"917760464258\",\"name\":\"Shukla\",\"userName\":\"Shukla\",\"email\":\"srishti@shukla.com\",\"status\":\"At the movies\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTc3NjA0NjQyNTgiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjgyL2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTEzMTQ3OTcyLCJleHAiOjE1MTY3NzY3NzIsIm5iZiI6MTUxMzE0Nzk3MiwianRpIjoidlFxQ2VBa2JXZEVRSGtFWiJ9.KOpnNfnGVf8PsZSGwqYYvERl_kBgqYxjceY8oEtkRb4', '2017-12-13 12:26:19', 'Shuklaqrg', 'At the movies', 'srishti@shukla.com', 'Male', '13/12/1990', '917760464258', ''),
('9178889956', 'elango12356poipoi', '2018-03-19 15:24:32', '{\"user_id\":\"9178889956\",\"user_name\":\"elango12356poipoi\",\"nickName\":\"elango12356poipoi\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJlbGFuZ28iLCJpc3MiOiJodHRwOi8vZGV2LmJ1c2hmaXJlLmxhbi9waiIsImlhdCI6MTUxOTE5NzYzMSwiZXhwIjoxNzM2OTM3NjMxLCJuYmYiOjE1MTkxOTc2MzEsImp0aSI6ImExTTZDeW1JcFQyOXh6YWcifQ.cVu7ocVt9KiKEAkOFWHEn8jLpuSwrFkGu6ZQzem45k0\",\"status\":null,\"email\":\"elango@gmail.com\",\"mobileNumber\":\"9178889956\",\"gender\":null,\"dob\":null,\"image_url\":\"\\/home\\/vagrant\\/code\\/bushfire-webadmin\\/public\\/assets\\/img\\/profiles\\/dep5wsrvdownload.jpg\",\"created_date\":\"2018-03-19 15:24:32\",\"roles\":[\"PLATFORMJOCKEY\"],\"permissions\":[],\"access\":\"1111\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJlbGFuZ28iLCJpc3MiOiJodHRwOi8vZGV2LmJ1c2hmaXJlLmxhbi9waiIsImlhdCI6MTUxOTE5NzYzMSwiZXhwIjoxNzM2OTM3NjMxLCJuYmYiOjE1MTkxOTc2MzEsImp0aSI6ImExTTZDeW1JcFQyOXh6YWcifQ.cVu7ocVt9KiKEAkOFWHEn8jLpuSwrFkGu6ZQzem45k0', '0000-00-00 00:00:00', 'elango12356poipoi', NULL, 'elango@gmail.com', NULL, NULL, '9178889956', '/home/vagrant/code/bushfire-webadmin/public/assets/img/profiles/dep5wsrvdownload.jpg'),
('917894592836', 'TestPj_7', '2018-01-17 14:36:40', '{\"user_id\":\"917894592836\",\"user_name\":\"TestPj_7\",\"nickName\":\"TestPj_7\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJUZXN0UGpfNyIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3BqIiwiaWF0IjoxNTE2MTY3OTQ5LCJleHAiOjE1MTk3OTY3NDksIm5iZiI6MTUxNjE2Nzk0OSwianRpIjoiMmF2NW90TkNaVVZ0VFBhbSJ9.WEIV1r1RzBuPmhjQ4JAVxMcuOB8iIfS8gEGjlAe9WyA\",\"status\":null,\"email\":\"t5@p5.com\",\"mobileNumber\":\"917894592836\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-17 14:36:40\",\"roles\":[\"PLATFORMJOCKEY\"],\"permissions\":[],\"access\":\"1111\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJUZXN0UGpfNyIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3BqIiwiaWF0IjoxNTE2MTY3OTQ5LCJleHAiOjE1MTk3OTY3NDksIm5iZiI6MTUxNjE2Nzk0OSwianRpIjoiMmF2NW90TkNaVVZ0VFBhbSJ9.WEIV1r1RzBuPmhjQ4JAVxMcuOB8iIfS8gEGjlAe9WyA', '0000-00-00 00:00:00', 'TestPj_7', NULL, 't5@p5.com', NULL, NULL, '917894592836', NULL),
('917894654799', 'testpj1', '2018-02-12 07:00:14', '{\"user_id\":\"917894654799\",\"user_name\":\"testpj1\",\"nickName\":\"testpj1\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ0ZXN0cGoxIiwiaXNzIjoiaHR0cDovL2Rldi5idXNoZmlyZS5sYW4vcGoiLCJpYXQiOjE1MTg0MTg4MTQsImV4cCI6MTczNjE1ODgxNCwibmJmIjoxNTE4NDE4ODE0LCJqdGkiOiJqRDcyM3FxRXAyYXJFWHdCIn0.R6VpftZi-rN2nMUD5Egwt9zQA4easUT9AblGgRr8S_s\",\"status\":null,\"email\":\"testpj1@gmail.com\",\"mobileNumber\":\"917894654799\",\"gender\":null,\"dob\":null,\"image_url\":\"\\/var\\/www\\/chat\\/bushfire_webadmin\\/public\\/assets\\/img\\/profiles\\/mi542m63download.jpg\",\"created_date\":\"2018-02-12 07:00:14\",\"roles\":[\"PLATFORMJOCKEY\"],\"permissions\":[],\"access\":\"1111\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ0ZXN0cGoxIiwiaXNzIjoiaHR0cDovL2Rldi5idXNoZmlyZS5sYW4vcGoiLCJpYXQiOjE1MTg0MTg4MTQsImV4cCI6MTczNjE1ODgxNCwibmJmIjoxNTE4NDE4ODE0LCJqdGkiOiJqRDcyM3FxRXAyYXJFWHdCIn0.R6VpftZi-rN2nMUD5Egwt9zQA4easUT9AblGgRr8S_s', '0000-00-00 00:00:00', 'testpj1', NULL, 'testpj1@gmail.com', NULL, NULL, '917894654799', '/var/www/chat/bushfire_webadmin/public/assets/img/profiles/mi542m63download.jpg');
INSERT INTO `user_details` (`user_id`, `user_name`, `created_date`, `vcard`, `token`, `updated_date`, `nickname`, `status`, `email`, `gender`, `dob`, `mobileNumber`, `image_url`) VALUES
('91789654123', 'test123pj', '2018-02-08 11:36:49', '{\"user_id\":\"91789654123\",\"user_name\":\"test123pj\",\"nickName\":\"test123pj\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ0ZXN0MTIzcGoiLCJpc3MiOiJodHRwOi8vZGV2LmJ1c2hmaXJlLmxhbi9waiIsImlhdCI6MTUxODA4OTgwOSwiZXhwIjoxNzM1ODI5ODA5LCJuYmYiOjE1MTgwODk4MDksImp0aSI6IlpDNmYwSWVTa2lydVYzb24ifQ.Dys6go4WxPVEBVpY2k89eDZtn_3tPq2T-cLIz6in1mU\",\"status\":null,\"email\":\"test123pj@gmail.com\",\"mobileNumber\":\"91789654123\",\"gender\":null,\"dob\":null,\"image_url\":\"\\/var\\/www\\/chat\\/bushfire_webadmin\\/public\\/assets\\/img\\/profiles\\/d79gpyu4download.jpg\",\"created_date\":\"2018-02-08 11:36:49\",\"roles\":[\"PLATFORMJOCKEY\"],\"permissions\":[],\"access\":\"1111\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ0ZXN0MTIzcGoiLCJpc3MiOiJodHRwOi8vZGV2LmJ1c2hmaXJlLmxhbi9waiIsImlhdCI6MTUxODA4OTgwOSwiZXhwIjoxNzM1ODI5ODA5LCJuYmYiOjE1MTgwODk4MDksImp0aSI6IlpDNmYwSWVTa2lydVYzb24ifQ.Dys6go4WxPVEBVpY2k89eDZtn_3tPq2T-cLIz6in1mU', '0000-00-00 00:00:00', 'test123pj', NULL, 'test123pj@gmail.com', NULL, NULL, '91789654123', '/var/www/chat/bushfire_webadmin/public/assets/img/profiles/d79gpyu4download.jpg'),
('918105447982', '917708102496', '2017-11-17 06:20:49', '{\"gender\":\"Female\",\"nickName\":\"917708102496\",\"dob\":\"10\\/01\\/1990\",\"mobileNumber\":\"918105447982\",\"name\":\"917708102496\",\"userName\":\"917708102496\",\"email\":\"asd@asd.com\",\"status\":\"At the movies\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTgxMDU0NDc5ODIiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjgyLy9hcGkvdjEvdXNlci9nZXRwYXNzd29yZCIsImlhdCI6MTUxNzg5OTEzNywiZXhwIjoxNTIxNTI3OTM3LCJuYmYiOjE1MTc4OTkxMzcsImp0aSI6ImRTZFdKaVljRTRhS05tYnoifQ.xvxIcPK4bs4-dQZkTMiiIxKXOjLVCRs6RqgSqSUgRA0', '2018-02-06 12:09:00', '917708102496', 'At the movies', 'asd@asd.com', 'Female', '10/01/1990', '918105447982', NULL),
('91812345678', 'TestPJ123', '2018-01-09 06:22:01', '{\"user_id\":\"91812345678\",\"user_name\":\"TestPJ123\",\"nickName\":\"TestPJ123\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJUZXN0UEoxMjMiLCJpc3MiOiJodHRwOi8vZGV2LmJ1c2hmaXJlLmxhbi9waiIsImlhdCI6MTUxNTQwMzAxMSwiZXhwIjoxNTE5MDMxODExLCJuYmYiOjE1MTU0MDMwMTEsImp0aSI6Ilc4Qmw0M0YyeEUzb3lYam8ifQ.SLRQL8XPMaE-gQG3ILwh1LBM5yToPcq2O8Vfx5D6HFo\",\"status\":null,\"email\":\"aaa@bbb1.com\",\"mobileNumber\":\"91812345678\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-09 06:22:01\",\"roles\":[\"PLATFORMJOCKEY\"],\"permissions\":[],\"access\":\"1111\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJUZXN0UEoxMjMiLCJpc3MiOiJodHRwOi8vZGV2LmJ1c2hmaXJlLmxhbi9waiIsImlhdCI6MTUxNTQwMzAxMSwiZXhwIjoxNTE5MDMxODExLCJuYmYiOjE1MTU0MDMwMTEsImp0aSI6Ilc4Qmw0M0YyeEUzb3lYam8ifQ.SLRQL8XPMaE-gQG3ILwh1LBM5yToPcq2O8Vfx5D6HFo', '0000-00-00 00:00:00', 'TestPJ123', NULL, 'aaa@bbb1.com', NULL, NULL, '91812345678', NULL),
('918123456789', 'Test PJ', '2018-01-08 09:15:11', '{\"user_id\":\"918123456789\",\"user_name\":\"Test PJ\",\"nickName\":\"Test PJ\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJUZXN0IFBKIiwiaXNzIjoiaHR0cDovL2Rldi5idXNoZmlyZS5sYW4vcGoiLCJpYXQiOjE1MTU0MDI5MTEsImV4cCI6MTUxOTAzMTcxMSwibmJmIjoxNTE1NDAyOTExLCJqdGkiOiJiWHNWS0FTdVUzd1phcnl1In0.7-rtZ4NqCT4NUiisM_BwwiLmxuqAkMXrdngefgcLQXE\",\"status\":null,\"email\":\"aaa@bbb.com\",\"mobileNumber\":\"918123456789\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-08 09:15:11\",\"roles\":[\"PLATFORMJOCKEY\"],\"permissions\":[],\"access\":\"1111\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJUZXN0IFBKIiwiaXNzIjoiaHR0cDovL2Rldi5idXNoZmlyZS5sYW4vcGoiLCJpYXQiOjE1MTU0MDI5MTEsImV4cCI6MTUxOTAzMTcxMSwibmJmIjoxNTE1NDAyOTExLCJqdGkiOiJiWHNWS0FTdVUzd1phcnl1In0.7-rtZ4NqCT4NUiisM_BwwiLmxuqAkMXrdngefgcLQXE', '0000-00-00 00:00:00', 'Test PJ', NULL, 'aaa@bbb.com', NULL, NULL, '918123456789', NULL),
('91812345679', 'TestSTringer123', '2018-01-09 06:21:05', '{\"user_id\":\"91812345679\",\"user_name\":\"TestSTringer123\",\"nickName\":\"TestSTringer123\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJUZXN0U1RyaW5nZXIxMjMiLCJpc3MiOiJodHRwOi8vZGV2LmJ1c2hmaXJlLmxhbi9zdHJpbmdlciIsImlhdCI6MTUxNTQwMzQ0NiwiZXhwIjoxNTE5MDMyMjQ2LCJuYmYiOjE1MTU0MDM0NDYsImp0aSI6ImhqT1FyaTNFR214aHhoSUIifQ.7MLc72GtzoHjZYRk0mzklfgwub8KZCVI0Xy0_QD8Sw0\",\"status\":null,\"email\":\"aaa@bbb2.com\",\"mobileNumber\":\"91812345679\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-09 06:21:05\",\"roles\":[\"STRINGER\"],\"permissions\":[]}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJUZXN0U1RyaW5nZXIxMjMiLCJpc3MiOiJodHRwOi8vZGV2LmJ1c2hmaXJlLmxhbi9zdHJpbmdlciIsImlhdCI6MTUxNTQwMzQ0NiwiZXhwIjoxNTE5MDMyMjQ2LCJuYmYiOjE1MTU0MDM0NDYsImp0aSI6ImhqT1FyaTNFR214aHhoSUIifQ.7MLc72GtzoHjZYRk0mzklfgwub8KZCVI0Xy0_QD8Sw0', '0000-00-00 00:00:00', 'TestSTringer123', NULL, 'aaa@bbb2.com', NULL, NULL, '91812345679', NULL),
('918151913707', ' ', '2017-12-21 06:29:43', '{\"nickName\":null,\"status\":null,\"email\":null,\"mobileNumber\":\"918151913707\",\"gender\":null,\"dob\":null,\"image\":null}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTgxNTE5MTM3MDciLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjgyL2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTEzODM3NzgzLCJleHAiOjE1MTc0NjY1ODMsIm5iZiI6MTUxMzgzNzc4MywianRpIjoiV0ttYnVaYzcxenBtN3hiYiJ9.z8GcRxgkDWBWhH4swxoaMpJglm6eQRMQargEhJlWXLI', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, '918151913707', NULL),
('918151913741', 'Naveenraj Xavier', '2017-11-16 13:21:28', '{\"gender\":\"Male\",\"nickName\":\"Naveenraj Xavier\",\"dob\":\"11\\/01\\/2016\",\"mobileNumber\":\"918151913741\",\"name\":\"Naveenraj Xavier\",\"userName\":\"Naveenraj Xavier\",\"email\":\"naveenrajxavier@gmail.com\",\"status\":\"At the movies\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTgxNTE5MTM3NDEiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjgyL2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTE4NjA3MjQ0LCJleHAiOjE1MjIyMzYwNDQsIm5iZiI6MTUxODYwNzI0NCwianRpIjoiZUxodnNabDRVOWxWQWpUOSJ9.fKCx4NBxfATQPCdOPLZe_ZwRMN7_diD56OTRnFe7FF0', '2018-02-14 16:50:49', 'Naveenraj Xavier', 'At the movies', 'naveenrajxavier@gmail.com', 'Male', '11/01/2016', '918151913741', 'https://contustestbucket.s3.amazonaws.com/dbe063fa-5724-4154-bc8c-5cd0862f1b35_1495455117.jpg'),
('918151913742', 'Naveenraj 2', '2017-11-16 13:21:57', '{\"gender\":\"Male\",\"nickName\":\"Naveenraj 2\",\"dob\":\"06\\/09\\/1993\",\"mobileNumber\":\"918151913742\",\"name\":\"Naveenraj 2\",\"userName\":\"Naveenraj 2\",\"email\":\"naveenrajxavier@gmail.com\",\"status\":\"I am in BushFire\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTgxNTE5MTM3NDIiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjgyL2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTEzNjgwMTQzLCJleHAiOjE1MTczMDg5NDMsIm5iZiI6MTUxMzY4MDE0MywianRpIjoienRCeTlxR1VWMEZvUFd2OSJ9.sqZR6iwp0sJhC4E9D5ejxn5gU73O6xPxV93h6KEgPgE', '2017-12-19 16:12:27', 'Naveenraj 2', 'I am in BushFire', 'naveenrajxavier@gmail.com', 'Male', '06/09/1993', '918151913742', 'https://contustestbucket.s3.amazonaws.com/5218486e-b270-4645-95c1-8236c642f4d1_1499923073.jpg'),
('918151913743', 'Naveenraj 3??', '2017-11-16 13:26:50', '{\"gender\":\"Male\",\"nickName\":\"Naveenraj 3??\",\"dob\":\"16\\/11\\/2005\",\"mobileNumber\":\"918151913743\",\"name\":\"Naveenraj 3??\",\"userName\":\"Naveenraj 3??\",\"email\":\"naveen@anna.com\",\"status\":\"I am in BushFire\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTgxNTE5MTM3NDMiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjM3L2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTEwODQwNzI3LCJleHAiOjE1MTQ0Njk1MjcsIm5iZiI6MTUxMDg0MDcyNywianRpIjoiaVVUaTAxcFhwcXN0NXQwNyJ9.Sd_SGyBNHaCn8H0XdrLixawdRf8rrsJQsxbApxGEQfg', '2017-11-16 19:28:52', 'Naveenraj 3??', 'I am in BushFire', 'naveen@anna.com', 'Male', '16/11/2005', '918151913743', ''),
('918151913748', 'Naveen1', '2017-12-21 06:27:52', '{\"nickName\":\"Naveen1\",\"image\":\"https:\\/\\/contustestbucket.s3.amazonaws.com\\/6c6f60db-7351-4ede-ae77-3e70cb7d4dd3_1495108156.jpg\",\"name\":\"Naveen1\",\"mobileNumber\":\"918151913748\",\"status\":\"I am in BushFire\",\"email\":\"na1@gmail.com\",\"gender\":\"Male\",\"dob\":\"17\\/05\\/2017\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTgxNTE5MTM3NDgiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjgyL2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTEzODM3NjcyLCJleHAiOjE1MTc0NjY0NzIsIm5iZiI6MTUxMzgzNzY3MiwianRpIjoiYlc0UE56Tk1jZGhkejdabyJ9.VVd_LAnDcu3esvGsqAJitc4UsRjm-9-JP3WVVpHzQdM', '0000-00-00 00:00:00', 'Naveen1', 'I am in BushFire', 'na1@gmail.com', 'Male', '17/05/2017', '918151913748', 'https://contustestbucket.s3.amazonaws.com/6c6f60db-7351-4ede-ae77-3e70cb7d4dd3_1495108156.jpg'),
('918151913750', 'Naveen50', '2017-11-17 11:03:39', '{\"gender\":\"Male\",\"nickName\":\"Naveen50\",\"dob\":\"17\\/11\\/2003\",\"mobileNumber\":\"918151913750\",\"name\":\"Naveen50\",\"userName\":\"Naveen50\",\"email\":\"naveen50@gmail.com\",\"status\":\"I am in BushFire\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTgxNTE5MTM3NTAiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjM3L2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTEwOTE2NjE5LCJleHAiOjE1MTQ1NDU0MTksIm5iZiI6MTUxMDkxNjYxOSwianRpIjoiWmZWSkNZWldDblpKaUw1aiJ9.LH3pnfO1o7_GEnBXl1OIBxC6WVzr8LwJU6Bm6OWWoS0', '2017-11-17 16:35:40', 'Naveen50', 'I am in BushFire', 'naveen50@gmail.com', 'Male', '17/11/2003', '918151913750', ''),
('918151913751', ' ', '2017-11-17 11:11:47', '{\"nickName\":null,\"status\":null,\"email\":null,\"mobileNumber\":\"918151913751\",\"gender\":null,\"dob\":null,\"image\":null}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTgxNTE5MTM3NTEiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjM3L2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTEwOTE3MTA3LCJleHAiOjE1MTQ1NDU5MDcsIm5iZiI6MTUxMDkxNzEwNywianRpIjoianhPWkJwbUtwRWp6bUZaVSJ9.im9xWkmDC8BX4QfUZlXkknbBzf5Jtd7Z2M_CQa_jo_o', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, '918151913751', NULL),
('918181818181', 'Eightone', '2017-12-28 14:02:10', '{\"gender\":\"Male\",\"nickName\":\"Eightone\",\"dob\":\"28\\/12\\/1993\",\"mobileNumber\":\"918181818181\",\"name\":\"Eightone\",\"userName\":\"Eightone\",\"email\":\"eightone@gmail.com\",\"status\":\"I am on BushFire\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTgxODE4MTgxODEiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjgyL2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTE0NDY5NzMwLCJleHAiOjE1MTgwOTg1MzAsIm5iZiI6MTUxNDQ2OTczMCwianRpIjoiNGt2elR6eGlyOGJ5ZENINSJ9.iU5hOa2vSSHmt6_lrqnC3cRj4c7MMMnrOZWnzJTyxL0', '2017-12-28 19:36:07', 'Eightone', 'I am on BushFire', 'eightone@gmail.com', 'Male', '28/12/1993', '918181818181', ''),
('918183005820', 'Shruthi', '2018-01-10 07:48:00', '{\"gender\":\"Female\",\"nickName\":\"Shruthi\",\"dob\":\"16\\/01\\/1996\",\"mobileNumber\":\"918183005820\",\"name\":\"Shruthi\",\"userName\":\"Shruthi\",\"email\":\"abc@gmail.com\",\"status\":\"At the movies\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTgxODMwMDU4MjAiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjgyL2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTE5MjkwMzMwLCJleHAiOjE1MjI5MTkxMzAsIm5iZiI6MTUxOTI5MDMzMCwianRpIjoiWjNRT3ZyV2FtQml4UnFBVyJ9.mmN1mEdr4kYblltGlKFRWwDNMnIPabeoxyXXawLVhy4', '2018-02-22 14:35:36', 'Shruthi', 'At the movies', 'abc@gmail.com', 'Female', '16/01/1996', '918183005820', ''),
('918484848877', 'shalu', '2018-01-05 07:42:14', '{\"user_id\":\"918484848877\",\"user_name\":\"shalu\",\"nickName\":\"shalu\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJzaGFsdSIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3N0cmluZ2VyIiwiaWF0IjoxNTE1MTM4MTM0LCJleHAiOjE1MTg3NjY5MzQsIm5iZiI6MTUxNTEzODEzNCwianRpIjoiTWMyZGtCN3B1a3gxenRLaCJ9.edK3DHMO_xQ5tTG9rU7DFLBK_wFm4bvkb3yg1TjhAqo\",\"status\":null,\"email\":\"shalu@gmail.com\",\"mobileNumber\":\"918484848877\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-05 07:42:14\",\"roles\":\"\\\"Stringer\\\"\",\"permissions\":[]}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJzaGFsdSIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3N0cmluZ2VyIiwiaWF0IjoxNTE1MTM4MTM0LCJleHAiOjE1MTg3NjY5MzQsIm5iZiI6MTUxNTEzODEzNCwianRpIjoiTWMyZGtCN3B1a3gxenRLaCJ9.edK3DHMO_xQ5tTG9rU7DFLBK_wFm4bvkb3yg1TjhAqo', '0000-00-00 00:00:00', 'shalu', NULL, 'shalu@gmail.com', NULL, NULL, '918484848877', NULL),
('91852147963', 'TestPj_4', '2018-01-11 04:35:02', '{\"user_id\":\"91852147963\",\"user_name\":\"TestPj_4\",\"nickName\":\"TestPj_4\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJUZXN0UGpfNCIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3BqIiwiaWF0IjoxNTE1NjQ1MzAyLCJleHAiOjE1MTkyNzQxMDIsIm5iZiI6MTUxNTY0NTMwMiwianRpIjoiSEY2UHJhUXMwaVphYnZPUyJ9.9T0POQfUasB6vjUzNof2zBXl-yPTdGFTcZrMqZtXm3A\",\"status\":null,\"email\":\"t1@p1.com\",\"mobileNumber\":\"91852147963\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-11 04:35:02\",\"roles\":[\"PLATFORMJOCKEY\"],\"permissions\":[],\"access\":\"1111\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJUZXN0UGpfNCIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3BqIiwiaWF0IjoxNTE1NjQ1MzAyLCJleHAiOjE1MTkyNzQxMDIsIm5iZiI6MTUxNTY0NTMwMiwianRpIjoiSEY2UHJhUXMwaVphYnZPUyJ9.9T0POQfUasB6vjUzNof2zBXl-yPTdGFTcZrMqZtXm3A', '0000-00-00 00:00:00', 'TestPj_4', NULL, 't1@p1.com', NULL, NULL, '91852147963', NULL),
('918523651236', 'Shruthi', '2018-01-16 06:20:56', '{\"gender\":\"Female\",\"nickName\":\"Shruthi\",\"dob\":\"19\\/01\\/1998\",\"mobileNumber\":\"918523651236\",\"name\":\"Shruthi\",\"userName\":\"Shruthi\",\"email\":\"abc@gmail.com\",\"status\":\"I am on BushFire\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTg1MjM2NTEyMzYiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjgyL2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTE2MDgzNjU2LCJleHAiOjE1MTk3MTI0NTYsIm5iZiI6MTUxNjA4MzY1NiwianRpIjoiVkNjbEgzalgyWVNmdGFXayJ9.mCxMa1j-4eO4z7cSM6ORZWiRAvrewpVegth78oeJG68', '2018-01-16 11:52:02', 'Shruthi', 'I am on BushFire', 'abc@gmail.com', 'Female', '19/01/1998', '918523651236', ''),
('918563215236', ' ', '2018-01-10 10:13:26', '{\"nickName\":null,\"status\":null,\"email\":null,\"mobileNumber\":\"918563215236\",\"gender\":null,\"dob\":null,\"image\":null}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTg1NjMyMTUyMzYiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjgyL2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTE1NTc5MjA2LCJleHAiOjE1MTkyMDgwMDYsIm5iZiI6MTUxNTU3OTIwNiwianRpIjoicDRhTXhEejR0Q3JhSmVmWSJ9.qoQeTpPUZ1hmGoX6NlnAlVegHUY5KQJD-Kfws96iHj8', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, '918563215236', NULL),
('918585858585', 'Eight five', '2017-12-28 06:31:05', '{\"gender\":\"Male\",\"nickName\":\"Eight five\",\"dob\":\"28\\/12\\/1987\",\"mobileNumber\":\"918585858585\",\"name\":\"Eight five\",\"userName\":\"Eight five\",\"email\":\"eightfive@gmail.com\",\"status\":\"I am on BushFire\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTg1ODU4NTg1ODUiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjgyL2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTE0NDQyNjY1LCJleHAiOjE1MTgwNzE0NjUsIm5iZiI6MTUxNDQ0MjY2NSwianRpIjoic3JoSWliVEtZdnhPSDVpWCJ9.zD_c3rN4d54qH96SZJtVSt9v6c1HYJ55fSpflPnF7tc', '2017-12-28 12:01:42', 'Eight five', 'I am on BushFire', 'eightfive@gmail.com', 'Male', '28/12/1987', '918585858585', ''),
('918632357734', 'shilpa', '2017-12-22 07:29:34', '{\"gender\":\"Female\",\"nickName\":\"shilpa\",\"dob\":\"22\\/12\\/2017\",\"mobileNumber\":\"918632357734\",\"name\":\"shilpa\",\"userName\":\"shilpa\",\"email\":\"shilpa@gmail.com\",\"status\":\"I am on BushFire\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTg2MzIzNTc3MzQiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjgyL2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTEzOTI3Nzc0LCJleHAiOjE1MTc1NTY1NzQsIm5iZiI6MTUxMzkyNzc3NCwianRpIjoibG81UThvVk1jMEZ5YkdaSyJ9.Ec30voc6VZhMsTr6ju0B66DT7PKG4ReEqcTEMxGXAiw', '2017-12-22 12:59:58', 'shilpa', 'I am on BushFire', 'shilpa@gmail.com', 'Female', '22/12/2017', '918632357734', NULL),
('91876785675', '6thpj wwww name1', '2018-02-21 07:12:00', '{\"user_id\":\"91876785675\",\"user_name\":\"6thpj wwww name1\",\"nickName\":\"6thpj wwww name1\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI2dGhwaiB3d3d3d3ciLCJpc3MiOiJodHRwOi8vZGV2LmJ1c2hmaXJlLmxhbi9waiIsImlhdCI6MTUxODQzOTQyOCwiZXhwIjoxNzM2MTc5NDI4LCJuYmYiOjE1MTg0Mzk0MjgsImp0aSI6InhHV2VHWWJHS1NrNTFjcncifQ.LVEXehu1Kfj0akcNW0f34hgJEsDwoSO-1zfrMEXQbxg\",\"status\":null,\"email\":\"6thpj6thpj@gmail.com\",\"mobileNumber\":\"91876785675\",\"gender\":null,\"dob\":null,\"image_url\":\"\\/var\\/www\\/chat\\/bushfire_webadmin\\/public\\/assets\\/img\\/profiles\\/tg2ex8iidownload.jpg\",\"created_date\":\"2018-02-21 07:12:00\",\"roles\":[\"PLATFORMJOCKEY\"],\"permissions\":[],\"access\":\"1111\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI2dGhwaiB3d3d3d3ciLCJpc3MiOiJodHRwOi8vZGV2LmJ1c2hmaXJlLmxhbi9waiIsImlhdCI6MTUxODQzOTQyOCwiZXhwIjoxNzM2MTc5NDI4LCJuYmYiOjE1MTg0Mzk0MjgsImp0aSI6InhHV2VHWWJHS1NrNTFjcncifQ.LVEXehu1Kfj0akcNW0f34hgJEsDwoSO-1zfrMEXQbxg', '0000-00-00 00:00:00', '6thpj wwww name1', NULL, '6thpj6thpj@gmail.com', NULL, NULL, '91876785675', '/var/www/chat/bushfire_webadmin/public/assets/img/profiles/tg2ex8iidownload.jpg'),
('918787878787', 'Eightseven', '2017-12-28 06:20:42', '{\"gender\":\"Male\",\"nickName\":\"Eightseven\",\"dob\":\"02\\/12\\/1986\",\"mobileNumber\":\"918787878787\",\"name\":\"Eightseven\",\"userName\":\"Eightseven\",\"email\":\"Eightseven@gmail.com\",\"status\":\"I am on BushFire\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTg3ODc4Nzg3ODciLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjgyL2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTE0NDQyMDQyLCJleHAiOjE1MTgwNzA4NDIsIm5iZiI6MTUxNDQ0MjA0MiwianRpIjoiR1AyQUNZTFRDUldCN24ydCJ9.ARZH0I5CjoagzD8cqIhbf3JCrsbjXPLSMo3o474UHas', '2017-12-28 11:51:43', 'Eightseven', 'I am on BushFire', 'Eightseven@gmail.com', 'Male', '02/12/1986', '918787878787', ''),
('918862452332', 'Jaffar', '2018-01-19 05:05:15', '{\"gender\":\"Male\",\"nickName\":\"Jaffar\",\"dob\":\"19\\/01\\/1990\",\"mobileNumber\":\"918862452332\",\"name\":\"Jaffar\",\"userName\":\"Jaffar\",\"email\":\"jrsadik7@gmail.com\",\"status\":\"I am on BushFire\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTg4NjI0NTIzMzIiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjgyL2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTE2MzM4MzE1LCJleHAiOjE1MTk5NjcxMTUsIm5iZiI6MTUxNjMzODMxNSwianRpIjoiRGxiMmJDMW01VnI1cEVvVyJ9.Lqeq4BhRj9xcqV11cZql9eyawqXwDfLdA1_733q2fQA', '2018-01-19 10:36:44', 'Jaffar', 'I am on BushFire', 'jrsadik7@gmail.com', 'Male', '19/01/1990', '918862452332', ''),
('918867231902', 'Shruuu', '2018-02-21 11:26:08', '{\"gender\":\"Male\",\"nickName\":\"Shruuu\",\"dob\":\"13\\/09\\/2003\",\"mobileNumber\":\"918867231902\",\"name\":\"Shruuu\",\"userName\":\"Shruuu\",\"email\":\"sjvjv@gj.com\",\"status\":\"I am on BushFire\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTg4NjcyMzE5MDIiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjgyL2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTE5MjEyMzY4LCJleHAiOjE1MjI4NDExNjgsIm5iZiI6MTUxOTIxMjM2OCwianRpIjoiNEZjVkdLNnR4RnlIUGxrSCJ9.IED7zgS6gnLvKb7TGXiuApcTdxRPyKNIKeeS5OUX_1U', '2018-02-21 16:56:57', 'Shruuu', 'I am on BushFire', 'sjvjv@gj.com', 'Male', '13/09/2003', '918867231902', ''),
('918867528736', 'ShilpaGowda', '2017-11-21 06:36:06', '{\"gender\":\"Male\",\"nickName\":\"ShilpaGowda\",\"dob\":\"16\\/11\\/1994\",\"mobileNumber\":\"918867528736\",\"name\":\"ShilpaGowda\",\"userName\":\"ShilpaGowda\",\"email\":\"test@gmqil.com\",\"status\":\"Available\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTg4Njc1Mjg3MzYiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjgyL2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTE5Mjg1NDg1LCJleHAiOjE1MjI5MTQyODUsIm5iZiI6MTUxOTI4NTQ4NSwianRpIjoib3V4WWM4Q0FKMlF3V0J5bSJ9.8d2EhA6WDI1vD05M3RLNe6YA7Kggy0eCwy8kRFhHYbc', '2018-02-22 13:14:51', 'ShilpaGowda', 'Available', 'test@gmqil.com', 'Male', '16/11/1994', '918867528736', 'https://contustestbucket.s3.amazonaws.com/ece49a5b-13a9-435e-882a-f8751e55ac31_1495536307.jpg'),
('918877114477', 'Aatul', '2018-02-22 07:34:00', '{\"gender\":\"Male\",\"nickName\":\"Aatul\",\"dob\":\"22\\/02\\/2044\",\"mobileNumber\":\"918877114477\",\"name\":\"Aatul\",\"userName\":\"Aatul\",\"email\":\"aatul@baby.com\",\"status\":\"I am on BushFire\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTg4NzcxMTQ0NzciLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjgyL2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTE5Mjg0ODQwLCJleHAiOjE1MjI5MTM2NDAsIm5iZiI6MTUxOTI4NDg0MCwianRpIjoiRUZKdVdFZUhWbGVqRzZHdiJ9.JTh33qfAKsfWtQr6MNef0YxT4YriWX_cszWJrEIUWFQ', '2018-02-22 13:04:26', 'Aatul', 'I am on BushFire', 'aatul@baby.com', 'Male', '22/02/2044', '918877114477', ''),
('918888888888', 'Sadiq 8888888888', '2017-12-20 15:03:48', '{\"gender\":\"Male\",\"nickName\":\"Sadiq 8888888888\",\"dob\":\"20\\/12\\/1989\",\"mobileNumber\":\"918888888888\",\"name\":\"Sadiq 8888888888\",\"userName\":\"Sadiq 8888888888\",\"email\":\"asd@asd.com\",\"status\":\"I am on BushFire\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTg4ODg4ODg4ODgiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjgyL2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTEzNzgyMjI4LCJleHAiOjE1MTc0MTEwMjgsIm5iZiI6MTUxMzc4MjIyOCwianRpIjoiZ1IxbmlvWFp0Vkh3eDRHdCJ9.6xe3nNA5eS2MMF_hqS6MNGGGx90tPWoEHv628SEkBbo', '2017-12-20 20:34:35', 'Sadiq 8888888888', 'I am on BushFire', 'asd@asd.com', 'Male', '20/12/1989', '918888888888', ''),
('918892152332', 'Fufjjv', '2018-01-10 06:56:27', '{\"gender\":\"Male\",\"nickName\":\"Fufjjv\",\"dob\":\"13\\/08\\/2004\",\"mobileNumber\":\"918892152332\",\"name\":\"Fufjjv\",\"userName\":\"Fufjjv\",\"email\":\"hdfhjgkh@gjgj.jgjg\",\"status\":\"I am on BushFire\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTg4OTIxNTIzMzIiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjgyL2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTE2MzY2NDIzLCJleHAiOjE1MTk5OTUyMjMsIm5iZiI6MTUxNjM2NjQyMywianRpIjoiZE13cHNxY1hWWjJIOVBjbiJ9.v9tgA7_aPyK4Gnqojy53IkMYXlryFK1DwmXvKxZ3pIE', '2018-01-19 19:19:42', 'Fufjjv', 'I am on BushFire', 'hdfhjgkh@gjgj.jgjg', 'Male', '13/08/2004', '918892152332', ''),
('918892452332', 'Sadiq', '2017-12-18 10:21:11', '{\"gender\":\"Male\",\"nickName\":\"Sadiq\",\"dob\":\"18\\/12\\/1988\",\"mobileNumber\":\"918892452332\",\"name\":\"Sadiq\",\"userName\":\"Sadiq\",\"email\":\"sadiq@fmail.com\",\"status\":\"I am on BushFire\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTg4OTI0NTIzMzIiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjgyL2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTE5MjgzNjM5LCJleHAiOjE1MjI5MTI0MzksIm5iZiI6MTUxOTI4MzYzOSwianRpIjoiUFBPejhJTWZjS2dkZk5INCJ9.qcdHQ76QA2bObpW-nBb0j4I2iQu39KL2uipuR81hosU', '2018-02-22 12:44:27', 'Sadiq', 'I am on BushFire', 'sadiq@fmail.com', 'Male', '18/12/1988', '918892452332', ''),
('919035299524', 'Shilpa', '2017-11-17 09:45:29', '{\"gender\":\"Male\",\"nickName\":\"Shilpa\",\"dob\":\"17\\/11\\/2004\",\"mobileNumber\":\"919035299524\",\"name\":\"Shilpa\",\"userName\":\"Shilpa\",\"email\":\"shilpa@gmail.com\",\"status\":\"I am in BushFire\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTkwMzUyOTk1MjQiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjM3L2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTEwOTEzNjQwLCJleHAiOjE1MTQ1NDI0NDAsIm5iZiI6MTUxMDkxMzY0MCwianRpIjoia1pueXRyQ3g5Q0xYbzJBViJ9.t20SvWePEl8qM3gjG4KhrnduEkNQIwwnsb5UV_sG8Eg', '2017-11-17 15:44:43', 'Shilpa', 'I am in BushFire', 'shilpa@gmail.com', 'Male', '17/11/2004', '919035299524', 'https://bushfire.s3.amazonaws.com/fc9c9e21-d992-4d8d-9eb8-28d9fff4c5d1_1510913670.jpg'),
('919035564107', 'Chai that', '2018-02-01 10:01:17', '{\"gender\":\"Female\",\"nickName\":\"Chai that\",\"dob\":\"03\\/05\\/1991\",\"mobileNumber\":\"919035564107\",\"name\":\"Chai that\",\"userName\":\"Chai that\",\"email\":\"chai@gmail.com\",\"status\":\"I am on BushFire\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTkwMzU1NjQxMDciLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjgyLy9hcGkvdjEvdXNlci9nZXRwYXNzd29yZCIsImlhdCI6MTUxNzU3MDcyMCwiZXhwIjoxNTIxMTk5NTIwLCJuYmYiOjE1MTc1NzA3MjAsImp0aSI6IkIyTXZYbTBwRWx2MDVoMXAifQ.37aJKiqUfxZaUhRnaHmurlvGpZ_VTJuyvMBntICCM8g', '2018-02-02 16:55:28', 'Chai that', 'I am on BushFire', 'chai@gmail.com', 'Female', '03/05/1991', '919035564107', NULL),
('919113837130', 'Geetha', '2018-01-23 10:31:21', '{\"gender\":\"Male\",\"nickName\":\"Geetha\",\"dob\":\"23\\/01\\/2018\",\"mobileNumber\":\"919113837130\",\"name\":\"Geetha\",\"userName\":\"Geetha\",\"email\":\"shhs@ghh.com\",\"status\":\"I am on BushFire\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTkxMTM4MzcxMzAiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjgyL2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTE2NzAzNDgxLCJleHAiOjE1MjAzMzIyODEsIm5iZiI6MTUxNjcwMzQ4MSwianRpIjoiMmd1WXVSTDF2YUVlYUl6ciJ9.w8nHwrL5m_zDcGcLapNM05ERQ9tI0SFXUtZRMBhaarw', '2018-01-23 16:02:22', 'Geetha', 'I am on BushFire', 'shhs@ghh.com', 'Male', '23/01/2018', '919113837130', ''),
('91918867528736', 'zeeshan', '2017-11-20 08:59:19', '{\"nickName\":\"zeeshan\",\"status\":null,\"email\":\"test@gmail.com\",\"mobileNumber\":\"91918867528736\",\"gender\":null,\"dob\":null}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ6ZWVzaGFuIiwiaXNzIjoiaHR0cDovL2J1c2hmaXJlLmxhbi9hcGkvdjEvdXNlci9sb2dpbiIsImlhdCI6MTUxMTE2ODM1OSwiZXhwIjoxNTE0Nzk3MTU5LCJuYmYiOjE1MTExNjgzNTksImp0aSI6IlZ2eG41Q29MYzZWenRoQmcifQ.9hTDY3UAmCbGyHCvXEV8Bjglxyd2rYkVGBZX7TMiMms', '0000-00-00 00:00:00', 'zeeshan', NULL, 'test@gmail.com', NULL, NULL, '91918867528736', NULL),
('919439398575', 'Chandan', '2017-11-20 13:24:06', '{\"gender\":\"Male\",\"nickName\":\"Chandan\",\"dob\":\"20\\/11\\/1993\",\"mobileNumber\":\"919439398575\",\"name\":\"Chandan\",\"userName\":\"Chandan\",\"email\":\"chandan@gmail.com\",\"status\":\"I am in BushFire\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTk0MzkzOTg1NzUiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjM3L2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTExMTg0MjQ2LCJleHAiOjE1MTQ4MTMwNDYsIm5iZiI6MTUxMTE4NDI0NiwianRpIjoiY3owbFVpend2WDFMOG9LSSJ9.LtgriqfH8asnklyyPvxuHPqT0i9XeNbVL0XPPl52kaY', '2017-11-20 18:54:35', 'Chandan', 'I am in BushFire', 'chandan@gmail.com', 'Male', '20/11/1993', '919439398575', 'https://contustestbucket.s3.amazonaws.com/5218486e-b270-4645-95c1-8236c642f4d1_1499923073.jpg'),
('919439857565', 'Shoiab', '2017-11-17 12:02:49', '{\"gender\":\"Male\",\"nickName\":\"Shoiab\",\"dob\":\"17\\/11\\/2007\",\"mobileNumber\":\"919439857565\",\"name\":\"Shoiab\",\"userName\":\"Shoiab\",\"email\":\"test@gmail.com\",\"status\":\"I am in BushFire\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTk0Mzk4NTc1NjUiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjM3L2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTEwOTIwMTY5LCJleHAiOjE1MTQ1NDg5NjksIm5iZiI6MTUxMDkyMDE2OSwianRpIjoiUzZNSnc4NlY0elR2NWF0ViJ9.Qy1fJ0YVU22btK9jLGoHGiLMXjAjrYx1UKlmFjZu_FQ', '2017-11-17 17:33:22', 'Shoiab', 'I am in BushFire', 'test@gmail.com', 'Male', '17/11/2007', '919439857565', ''),
('919449398577', 'compasstringer@compass.in', '2018-01-11 09:53:02', '{\"user_id\":\"919449398577\",\"user_name\":\"compasstringer@compass.in\",\"nickName\":\"compasstringer@compass.in\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJjb21wYXNzdHJpbmdlckBjb21wYXNzLmluIiwiaXNzIjoiaHR0cDovL2Rldi5idXNoZmlyZS5sYW4vc3RyaW5nZXIiLCJpYXQiOjE1MTU2NjQzODIsImV4cCI6MTUxOTI5MzE4MiwibmJmIjoxNTE1NjY0MzgyLCJqdGkiOiJSMW1uNFlTTnpxaG54RmgzIn0.pr6Mh6GPalLH96t5xK2vxpQJDO9ADm76Jr6sw3kSM2U\",\"status\":null,\"email\":\"compasstringer@compass.in\",\"mobileNumber\":\"919449398577\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-11 09:53:02\",\"roles\":[\"STRINGER\"],\"permissions\":[]}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJjb21wYXNzdHJpbmdlckBjb21wYXNzLmluIiwiaXNzIjoiaHR0cDovL2Rldi5idXNoZmlyZS5sYW4vc3RyaW5nZXIiLCJpYXQiOjE1MTU2NjQzODIsImV4cCI6MTUxOTI5MzE4MiwibmJmIjoxNTE1NjY0MzgyLCJqdGkiOiJSMW1uNFlTTnpxaG54RmgzIn0.pr6Mh6GPalLH96t5xK2vxpQJDO9ADm76Jr6sw3kSM2U', '0000-00-00 00:00:00', 'compasstringer@compass.in', NULL, 'compasstringer@compass.in', NULL, NULL, '919449398577', NULL),
('919494949494', 'Ninefour', '2017-12-27 11:54:24', '{\"gender\":\"Male\",\"nickName\":\"Ninefour\",\"dob\":\"27\\/12\\/1999\",\"mobileNumber\":\"919494949494\",\"name\":\"Ninefour\",\"userName\":\"Ninefour\",\"email\":\"ninefour@gmail.com\",\"status\":\"I am on BushFire\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTk0OTQ5NDk0OTQiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjgyL2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTE0Mzc1NjY0LCJleHAiOjE1MTgwMDQ0NjQsIm5iZiI6MTUxNDM3NTY2NCwianRpIjoiSTVDZzg3bHd0Ylc4eExzayJ9.6ttQD4LMJznwIv9BWL4E0kblLuqctrhra3RgUE8VgOU', '2017-12-27 17:25:04', 'Ninefour', 'I am on BushFire', 'ninefour@gmail.com', 'Male', '27/12/1999', '919494949494', ''),
('919528096314', 'Ashs', '2017-11-17 06:40:02', '{\"gender\":\"Male\",\"nickName\":\"Ashs\",\"dob\":\"17\\/11\\/2017\",\"mobileNumber\":\"919528096314\",\"name\":\"Ashs\",\"userName\":\"Ashs\",\"email\":\"gaga@bsa.com\",\"status\":\"I am in BushFire\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTk1MjgwOTYzMTQiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjM3L2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTEwOTAwODAyLCJleHAiOjE1MTQ1Mjk2MDIsIm5iZiI6MTUxMDkwMDgwMiwianRpIjoiSTlaOFJuaGNGcjlrdnZBdSJ9.HNye3mGmzh2TDfK3q1NfVl9EEkl-ZcbMnGLols3DQGc', '2017-11-17 12:12:12', 'Ashs', 'I am in BushFire', 'gaga@bsa.com', 'Male', '17/11/2017', '919528096314', ''),
('919573270948', 'Manikanta', '2018-01-08 15:31:09', '{\"gender\":\"Male\",\"nickName\":\"Manikanta\",\"dob\":\"08\\/01\\/1995\",\"mobileNumber\":\"919573270948\",\"name\":\"Manikanta\",\"userName\":\"Manikanta\",\"email\":\"test@gmail.com\",\"status\":\"I am on BushFire\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTk1NzMyNzA5NDgiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjgyL2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTE1NDc5MzA0LCJleHAiOjE1MTkxMDgxMDQsIm5iZiI6MTUxNTQ3OTMwNCwianRpIjoiQjdVcEtGaEFkTHNTN1BmcCJ9.SUWF5V57yAFjhtNpWcyXBy-HqcEV6JWpYeOqfPYh_sE', '2018-01-09 12:07:29', 'Manikanta', 'I am on BushFire', 'test@gmail.com', 'Male', '08/01/1995', '919573270948', ''),
('919573270949', 'Java', '2017-11-16 13:43:00', '{\"gender\":\"Male\",\"nickName\":\"Java\",\"dob\":\"16\\/11\\/2005\",\"mobileNumber\":\"919573270949\",\"name\":\"Java\",\"userName\":\"Java\",\"email\":\"java@compass.in\",\"status\":\"I am in BushFire\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTk1NzMyNzA5NDkiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjM3L2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTEwODM5NzgwLCJleHAiOjE1MTQ0Njg1ODAsIm5iZiI6MTUxMDgzOTc4MCwianRpIjoiTVc0YWpCTDdndlhwdEFYMyJ9.eel4e0oHu_Fx8SXN6qmh0G347BUoP0LbuPIn47aEMPE', '2017-11-16 19:13:36', 'Java', 'I am in BushFire', 'java@compass.in', 'Male', '16/11/2005', '919573270949', ''),
('919629108196', 'Radhakrishan S', '2017-11-17 09:59:46', '{\"nickName\":\"Radhakrishan S\",\"image\":[],\"name\":\"Radhakrishan S\",\"mobileNumber\":\"919629108196\",\"status\":\"I am in BushFire\",\"email\":\"radhakrishnan.s@compassitesinc.com\",\"gender\":\"Male\",\"dob\":\"27\\/07\\/1990\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJSYWRoYWtyaXNobmFuIFMiLCJpc3MiOiJodHRwOi8vYnVzaGZpcmUubGFuL2FwaS92MS91c2VyL2xvZ2luIiwiaWF0IjoxNTEwOTEyNzg2LCJleHAiOjE1MTQ1NDE1ODYsIm5iZiI6MTUxMDkxMjc4NiwianRpIjoiZkY5T2dTN0t0M2wzZ1B4ayJ9.tVbh8WxDhdpiT77n0ddbccpja1lb08hYu8fNthV6tvM', '0000-00-00 00:00:00', 'Radhakrishan S', 'I am in BushFire', 'radhakrishnan.s@compassitesinc.com', 'Male', '27/07/1990', '919629108196', NULL),
('919632357734', 'Shilpa', '2017-11-16 13:30:31', '{\"gender\":\"Male\",\"nickName\":\"Shilpa\",\"dob\":\"20\\/11\\/1993\",\"mobileNumber\":\"919632357734\",\"name\":\"Shilpa\",\"userName\":\"Shilpa\",\"email\":\"shilpagowda36@gmail.com\",\"status\":\"Sleeping\\u2026\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTk2MzIzNTc3MzQiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjM3L2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTExMTgwMzI4LCJleHAiOjE1MTQ4MDkxMjgsIm5iZiI6MTUxMTE4MDMyOCwianRpIjoiY240RkNHUEJyZWprSzhKbyJ9.n20o0sYziKVfELbykw2ZTdWmZ3x327RpxnnfmDcCnDg', '2017-11-20 18:16:31', 'Shilpa', 'Sleeping…', 'shilpagowda36@gmail.com', 'Male', '20/11/1993', '919632357734', 'https://contustestbucket.s3.amazonaws.com/5c4f845d-023a-475c-9003-86e648afd35c_1495631259.jpg'),
('919632357735', 'Shilpa', '2018-02-22 07:38:37', '{\"gender\":\"Male\",\"nickName\":\"Shilpa\",\"dob\":\"22\\/02\\/2018\",\"mobileNumber\":\"919632357735\",\"name\":\"Shilpa\",\"userName\":\"Shilpa\",\"email\":\"shilpa@gmail.vom\",\"status\":\"I am on BushFire\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTk2MzIzNTc3MzUiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjgyL2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTE5Mjg1NjY3LCJleHAiOjE1MjI5MTQ0NjcsIm5iZiI6MTUxOTI4NTY2NywianRpIjoiS0s0WDQ1MlRoTW52d2c2SCJ9.cukM2VyKvl3Jb8T0CtptACHUz-Yph8l6nwiCA-QuO3I', '2018-02-22 13:18:26', 'Shilpa', 'I am on BushFire', 'shilpa@gmail.vom', 'Male', '22/02/2018', '919632357735', ''),
('919632357736', 'shilpa', '2017-11-20 06:40:32', '{\"nickName\":\"shilpa\",\"status\":null,\"email\":\"test@gmail.com\",\"mobileNumber\":\"919632357736\",\"gender\":null,\"dob\":null}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJzaGlscGEiLCJpc3MiOiJodHRwOi8vYnVzaGZpcmUubGFuL2FkbWluL2FkZCIsImlhdCI6MTUxMTE2MDAzMiwiZXhwIjoxNTE0Nzg4ODMyLCJuYmYiOjE1MTExNjAwMzIsImp0aSI6InRPQXREWW5LOFN2ZHV0QmcifQ.T7IOX2e7Wbnyv2GSY0sQL6ZK9wuBJKJW2YsIZCgrhbo', '0000-00-00 00:00:00', 'shilpa', NULL, 'test@gmail.com', NULL, NULL, '919632357736', NULL),
('919632357737', 'shilpa', '2018-01-11 09:45:51', '{\"user_id\":\"919632357737\",\"user_name\":\"shilpa\",\"nickName\":\"shilpa\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJzaGlscGEiLCJpc3MiOiJodHRwOi8vZGV2LmJ1c2hmaXJlLmxhbi9waiIsImlhdCI6MTUxNTY2Mzk1MSwiZXhwIjoxNTE5MjkyNzUxLCJuYmYiOjE1MTU2NjM5NTEsImp0aSI6IlI0cW1FTUZpV09wcmtsT2cifQ.2jYJFDmiLzi_71ztp86E43a2PQIbfMIX6o835gLuc5Y\",\"status\":null,\"email\":\"shilpa1@compass.in\",\"mobileNumber\":\"919632357737\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-11 09:45:51\",\"roles\":[\"PLATFORMJOCKEY\"],\"permissions\":[],\"access\":\"1111\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJzaGlscGEiLCJpc3MiOiJodHRwOi8vZGV2LmJ1c2hmaXJlLmxhbi9waiIsImlhdCI6MTUxNTY2Mzk1MSwiZXhwIjoxNTE5MjkyNzUxLCJuYmYiOjE1MTU2NjM5NTEsImp0aSI6IlI0cW1FTUZpV09wcmtsT2cifQ.2jYJFDmiLzi_71ztp86E43a2PQIbfMIX6o835gLuc5Y', '0000-00-00 00:00:00', 'shilpa', NULL, 'shilpa1@compass.in', NULL, NULL, '919632357737', NULL),
('919632357738', 'shilpa', '2018-01-11 09:46:27', '{\"user_id\":\"919632357738\",\"user_name\":\"shilpa\",\"nickName\":\"shilpa\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJzaGlscGEiLCJpc3MiOiJodHRwOi8vZGV2LmJ1c2hmaXJlLmxhbi9zdHJpbmdlciIsImlhdCI6MTUxNTY2Mzk4NywiZXhwIjoxNTE5MjkyNzg3LCJuYmYiOjE1MTU2NjM5ODcsImp0aSI6Ino0djdETFhpc2pFUGVRSUUifQ.oo2MHv0e60xs5gd8qJg7GshlCmIM1UwKe6MdAHg6rio\",\"status\":null,\"email\":\"shilpa1@compass.in\",\"mobileNumber\":\"919632357738\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-11 09:46:27\",\"roles\":[\"STRINGER\"],\"permissions\":[]}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJzaGlscGEiLCJpc3MiOiJodHRwOi8vZGV2LmJ1c2hmaXJlLmxhbi9zdHJpbmdlciIsImlhdCI6MTUxNTY2Mzk4NywiZXhwIjoxNTE5MjkyNzg3LCJuYmYiOjE1MTU2NjM5ODcsImp0aSI6Ino0djdETFhpc2pFUGVRSUUifQ.oo2MHv0e60xs5gd8qJg7GshlCmIM1UwKe6MdAHg6rio', '0000-00-00 00:00:00', 'shilpa', NULL, 'shilpa1@compass.in', NULL, NULL, '919632357738', NULL),
('91963852741', 'TestStringer_3', '2018-01-10 04:53:58', '{\"user_id\":\"91963852741\",\"user_name\":\"TestStringer_3\",\"nickName\":\"TestStringer_3\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJUZXN0U3RyaW5nZXJfMyIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3N0cmluZ2VyIiwiaWF0IjoxNTE1NTYwMDM4LCJleHAiOjE1MTkxODg4MzgsIm5iZiI6MTUxNTU2MDAzOCwianRpIjoiSkZYNzlTM2o1RDZnbEJiRCJ9.mPslopxvZQWN2wg5Luc_Eq8cTravKJUolFCvQJdJ4t4\",\"status\":null,\"email\":\"t@s.com\",\"mobileNumber\":\"91963852741\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-10 04:53:58\",\"roles\":[\"STRINGER\"],\"permissions\":[]}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJUZXN0U3RyaW5nZXJfMyIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3N0cmluZ2VyIiwiaWF0IjoxNTE1NTYwMDM4LCJleHAiOjE1MTkxODg4MzgsIm5iZiI6MTUxNTU2MDAzOCwianRpIjoiSkZYNzlTM2o1RDZnbEJiRCJ9.mPslopxvZQWN2wg5Luc_Eq8cTravKJUolFCvQJdJ4t4', '0000-00-00 00:00:00', 'TestStringer_3', NULL, 't@s.com', NULL, NULL, '91963852741', NULL),
('919638527417', 'TestStringer_4', '2018-01-11 04:38:57', '{\"user_id\":\"919638527417\",\"user_name\":\"TestStringer_4\",\"nickName\":\"TestStringer_4\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJUZXN0U3RyaW5nZXJfNCIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3N0cmluZ2VyIiwiaWF0IjoxNTE1NjQ1NTM3LCJleHAiOjE1MTkyNzQzMzcsIm5iZiI6MTUxNTY0NTUzNywianRpIjoiYmZ3dDltRUl3aklaZkFURCJ9.vOErm3hmWA1GLtNu-i8DnHyderbVpbt1kbfh0sPhucY\",\"status\":null,\"email\":\"t1@s1.com\",\"mobileNumber\":\"919638527417\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-11 04:38:57\",\"roles\":[\"STRINGER\"],\"permissions\":[]}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJUZXN0U3RyaW5nZXJfNCIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3N0cmluZ2VyIiwiaWF0IjoxNTE1NjQ1NTM3LCJleHAiOjE1MTkyNzQzMzcsIm5iZiI6MTUxNTY0NTUzNywianRpIjoiYmZ3dDltRUl3aklaZkFURCJ9.vOErm3hmWA1GLtNu-i8DnHyderbVpbt1kbfh0sPhucY', '0000-00-00 00:00:00', 'TestStringer_4', NULL, 't1@s1.com', NULL, NULL, '919638527417', NULL),
('919696969696', 'My name is 9696', '2017-12-27 10:53:03', '{\"gender\":\"Male\",\"nickName\":\"My name is 9696\",\"dob\":\"27\\/12\\/1992\",\"mobileNumber\":\"919696969696\",\"name\":\"My name is 9696\",\"userName\":\"My name is 9696\",\"email\":\"ninesix@ninesix.com\",\"status\":\"I am on BushFire\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTk2OTY5Njk2OTYiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjgyL2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTE0MzcxOTgzLCJleHAiOjE1MTgwMDA3ODMsIm5iZiI6MTUxNDM3MTk4MywianRpIjoiTXZrRVJNam1JNU9pZ2hzNiJ9.BgDvUCC8kffoHsGxqUnwbZ8Axy9gibxzdvD3d9Qc5mw', '2017-12-27 16:23:48', 'My name is 9696', 'I am on BushFire', 'ninesix@ninesix.com', 'Male', '27/12/1992', '919696969696', ''),
('919738849769', 'Jaffar Sadiq SH', '2017-12-13 06:21:44', '{\"gender\":\"Male\",\"nickName\":\"Jaffar Sadiq SH\",\"dob\":\"09\\/01\\/1988\",\"mobileNumber\":\"919738849769\",\"name\":\"Jaffar Sadiq SH\",\"userName\":\"Jaffar Sadiq SH\",\"email\":\"jrsadik7@gmail.com\",\"status\":\"At the movies\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTk3Mzg4NDk3NjkiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjgyL2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTE2MzM5Mzk4LCJleHAiOjE1MTk5NjgxOTgsIm5iZiI6MTUxNjMzOTM5OCwianRpIjoiZktPaFY0TEl4YmNUME1TciJ9.DSFqsFXbbC5tojdrrUgKJfXwQgWzGIIXcAO371hXqio', '2018-01-19 10:54:31', 'Jaffar Sadiq SH', 'At the movies', 'jrsadik7@gmail.com', 'Male', '09/01/1988', '919738849769', 'https://bushfire.s3.amazonaws.com/736c983e-d952-4dfa-9e58-26e6d8270b99_1515509499.jpg'),
('919740760586', ' ', '2018-01-17 08:14:03', '{\"nickName\":null,\"status\":null,\"email\":null,\"mobileNumber\":\"919740760586\",\"gender\":null,\"dob\":null,\"image\":null}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTk3NDA3NjA1ODYiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjgyL2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTE2MTc2ODQzLCJleHAiOjE1MTk4MDU2NDMsIm5iZiI6MTUxNjE3Njg0MywianRpIjoiZ2NNWEpCSllsMXBpVE1JRCJ9.nx9JBzG7W3iUrBisjh4ueRGovo5dLlCQxoLdd9PKxqw', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, '919740760586', NULL),
('91984632598', 'sathya', '2018-01-22 08:25:08', '{\"user_id\":\"91984632598\",\"user_name\":\"sathya\",\"nickName\":\"sathya\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJzYXRoeWEiLCJpc3MiOiJodHRwOi8vZGV2LmJ1c2hmaXJlLmxhbi9zdHJpbmdlciIsImlhdCI6MTUxNjYwOTUwOCwiZXhwIjoxNzM0MzQ5NTA4LCJuYmYiOjE1MTY2MDk1MDgsImp0aSI6IjcyekxFSGNPcWhoRGo4UU8ifQ.y8tPwr6j5hD8a-b8P2CIX01wmc_5_zzOh6Ebu14oVqE\",\"status\":null,\"email\":\"sathya@gmail.com\",\"mobileNumber\":\"91984632598\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-22 08:25:08\",\"roles\":[\"STRINGER\"],\"permissions\":[]}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJzYXRoeWEiLCJpc3MiOiJodHRwOi8vZGV2LmJ1c2hmaXJlLmxhbi9zdHJpbmdlciIsImlhdCI6MTUxNjYwOTUwOCwiZXhwIjoxNzM0MzQ5NTA4LCJuYmYiOjE1MTY2MDk1MDgsImp0aSI6IjcyekxFSGNPcWhoRGo4UU8ifQ.y8tPwr6j5hD8a-b8P2CIX01wmc_5_zzOh6Ebu14oVqE', '0000-00-00 00:00:00', 'sathya', NULL, 'sathya@gmail.com', NULL, NULL, '91984632598', NULL),
('91987156843', 'TestPj_5', '2018-01-15 04:22:45', '{\"user_id\":\"91987156843\",\"user_name\":\"TestPj_5\",\"nickName\":\"TestPj_5\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJUZXN0UGpfNSIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3BqIiwiaWF0IjoxNTE1OTkwMTY1LCJleHAiOjE1MTk2MTg5NjUsIm5iZiI6MTUxNTk5MDE2NSwianRpIjoiN3JxUHVIUE5DbXR2dmpuTyJ9.rrsoIQfLZh4I9C-b9yeZCSnIBjP3iWPzuD3e2JakbPg\",\"status\":null,\"email\":\"t3@p3.com\",\"mobileNumber\":\"91987156843\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-15 04:22:45\",\"roles\":[\"PLATFORMJOCKEY\"],\"permissions\":[],\"access\":\"1111\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJUZXN0UGpfNSIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3BqIiwiaWF0IjoxNTE1OTkwMTY1LCJleHAiOjE1MTk2MTg5NjUsIm5iZiI6MTUxNTk5MDE2NSwianRpIjoiN3JxUHVIUE5DbXR2dmpuTyJ9.rrsoIQfLZh4I9C-b9yeZCSnIBjP3iWPzuD3e2JakbPg', '0000-00-00 00:00:00', 'TestPj_5', NULL, 't3@p3.com', NULL, NULL, '91987156843', NULL),
('91987369456', 'TestStringer_5', '2018-01-15 04:27:13', '{\"user_id\":\"91987369456\",\"user_name\":\"TestStringer_5\",\"nickName\":\"TestStringer_5\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJUZXN0U3RyaW5nZXJfNSIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3N0cmluZ2VyIiwiaWF0IjoxNTE1OTkwNDMzLCJleHAiOjE1MTk2MTkyMzMsIm5iZiI6MTUxNTk5MDQzMywianRpIjoiU3haMUUyRnRHUmY3d3RSMSJ9.PKs8DG2kDnJO0aRB2gqlgpkx0nvWrSaCJg2B1PcpkJQ\",\"status\":null,\"email\":\"t3@s3.com\",\"mobileNumber\":\"91987369456\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-15 04:27:13\",\"roles\":[\"STRINGER\"],\"permissions\":[]}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJUZXN0U3RyaW5nZXJfNSIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3N0cmluZ2VyIiwiaWF0IjoxNTE1OTkwNDMzLCJleHAiOjE1MTk2MTkyMzMsIm5iZiI6MTUxNTk5MDQzMywianRpIjoiU3haMUUyRnRHUmY3d3RSMSJ9.PKs8DG2kDnJO0aRB2gqlgpkx0nvWrSaCJg2B1PcpkJQ', '0000-00-00 00:00:00', 'TestStringer_5', NULL, 't3@s3.com', NULL, NULL, '91987369456', NULL),
('9198745698785', 'Genelia', '2018-02-02 10:03:10', '{\"user_id\":\"9198745698785\",\"user_name\":\"Genelia\",\"nickName\":\"Genelia\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJHZW5lbGlhIiwiaXNzIjoiaHR0cDovL2Rldi5idXNoZmlyZS5sYW4vcGoiLCJpYXQiOjE1MTc1NjU3NjYsImV4cCI6MTczNTMwNTc2NiwibmJmIjoxNTE3NTY1NzY2LCJqdGkiOiJjb3UyWGMxUlR0UlJuMTB1In0.DzW4YEFf1zbEobTaslXwQqHrVxBUuQDWHvjzBXnF6kU\",\"status\":null,\"email\":\"genelia@gmail.com\",\"mobileNumber\":\"9198745698785\",\"gender\":null,\"dob\":null,\"image_url\":\"\\/var\\/www\\/chat\\/bushfire_webadmin\\/public\\/assets\\/img\\/profiles\\/ckja6edvgenelia-actress-photos-83.jpg\",\"created_date\":\"2018-02-02 10:03:10\",\"roles\":[\"PLATFORMJOCKEY\"],\"permissions\":[],\"access\":\"1111\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJHZW5lbGlhIiwiaXNzIjoiaHR0cDovL2Rldi5idXNoZmlyZS5sYW4vcGoiLCJpYXQiOjE1MTc1NjU3NjYsImV4cCI6MTczNTMwNTc2NiwibmJmIjoxNTE3NTY1NzY2LCJqdGkiOiJjb3UyWGMxUlR0UlJuMTB1In0.DzW4YEFf1zbEobTaslXwQqHrVxBUuQDWHvjzBXnF6kU', '0000-00-00 00:00:00', 'Genelia', NULL, 'genelia@gmail.com', NULL, NULL, '9198745698785', '/var/www/chat/bushfire_webadmin/public/assets/img/profiles/ckja6edvgenelia-actress-photos-83.jpg'),
('919897969594', 'Test', '2017-12-13 07:20:39', '{\"gender\":\"Male\",\"nickName\":\"Test\",\"dob\":\"13\\/12\\/1996\",\"mobileNumber\":\"919897969594\",\"name\":\"Test\",\"userName\":\"Test\",\"email\":\"test@yopmail.com\",\"status\":\"I am on BushFire\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTk4OTc5Njk1OTQiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjgyL2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTEzMTQ5NjM5LCJleHAiOjE1MTY3Nzg0MzksIm5iZiI6MTUxMzE0OTYzOSwianRpIjoicXNHUFB6TmdIUTdoWWcwaCJ9.9qJ0AM347wCieXfIkbZXzYIJ-5U-D5L6w6LEG3e-pyI', '2017-12-13 12:51:26', 'Test', 'I am on BushFire', 'test@yopmail.com', 'Male', '13/12/1996', '919897969594', ''),
('919898667544', 'Diff', '2018-02-02 10:22:20', '{\"gender\":\"Female\",\"nickName\":\"Diff\",\"dob\":\"02\\/02\\/2018\",\"mobileNumber\":\"919898667544\",\"name\":\"Diff\",\"userName\":\"Diff\",\"email\":\"ehh@dhf.in\",\"status\":\"I am on BushFire\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTk4OTg2Njc1NDQiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjgyLy9hcGkvdjEvdXNlci9nZXRwYXNzd29yZCIsImlhdCI6MTUxNzU2Njk0MCwiZXhwIjoxNTIxMTk1NzQwLCJuYmYiOjE1MTc1NjY5NDAsImp0aSI6ImloZ2FmZHRjS3lRUmZMcTAifQ.13t7H1S3HXt2THjdkDZNHcQ-vsOQGdvy4BWnAmAmo10', '2018-02-02 15:52:39', 'Diff', 'I am on BushFire', 'ehh@dhf.in', 'Female', '02/02/2018', '919898667544', NULL),
('919900001201', 'superadmin1', '2018-03-19 21:12:37', '{\"user_id\":\"919900001201\",\"user_name\":\"superadmin1\",\"nickName\":\"superadmin1\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJzdXBlcmFkbWluMSIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL2xvZ2luIiwiaWF0IjoxNTE1MTYwNTEzLCJleHAiOjE1MTg3ODkzMTMsIm5iZiI6MTUxNTE2MDUxMywianRpIjoibkkyRVdCMUhCa2dwTTZMeCJ9.mZ_TI_a2_mehBXvT9Ne3FySFC8fk58WuTOZM1-GJ53k\",\"status\":null,\"email\":\"superadmin@compass.in\",\"mobileNumber\":\"919900001201\",\"gender\":null,\"dob\":null,\"created_date\":\"2018-03-19 21:12:37\",\"webAdmin\":1}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJzdXBlcmFkbWluMSIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL2xvZ2luIiwiaWF0IjoxNTE1MTYwNTEzLCJleHAiOjE1MTg3ODkzMTMsIm5iZiI6MTUxNTE2MDUxMywianRpIjoibkkyRVdCMUhCa2dwTTZMeCJ9.mZ_TI_a2_mehBXvT9Ne3FySFC8fk58WuTOZM1-GJ53k', '0000-00-00 00:00:00', 'superadmin1', NULL, 'superadmin@compass.in', NULL, NULL, '919900001201', NULL),
('919900601813', 'supriya', '2017-11-17 10:29:04', '{\"gender\":\"Female\",\"nickName\":\"supriya\",\"dob\":\"17\\/11\\/1996\",\"mobileNumber\":\"919900601813\",\"name\":\"supriya\",\"userName\":\"supriya\",\"email\":\"supriya@gmail.com\",\"status\":\"I am in BushFire\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTk5MDA2MDE4MTMiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjM3L2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTExMTYzMzEwLCJleHAiOjE1MTQ3OTIxMTAsIm5iZiI6MTUxMTE2MzMxMCwianRpIjoiMmVLd2dJNlVqZEZ6OUJvdiJ9.Y0oArjNqu2pgHm4TNUk0kQTuIt4qZQ4i3tLe0L7xFqM', '2017-11-20 13:05:15', 'supriya', 'I am in BushFire', 'supriya@gmail.com', 'Female', '17/11/1996', '919900601813', ''),
('919988007711', 'test333', '2017-11-20 13:11:09', '{\"user_id\":\"919988007711\",\"user_name\":\"test333\",\"nickName\":\"test333\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ0ZXN0MzMzIiwiaXNzIjoiaHR0cDovL2J1c2hmaXJlLmxhbi9hZG1pbi9hZGQiLCJpYXQiOjE1MTExODM0NjksImV4cCI6MTUxNDgxMjI2OSwibmJmIjoxNTExMTgzNDY5LCJqdGkiOiJoQWtTMGo4Z1l6dGFLWEJtIn0.7HlF2s6f2VXU4A58uQlkM5Zx4idzQFUbi5D-FT9cHl8\",\"status\":null,\"email\":\"test311@gmail.com\",\"mobileNumber\":\"919988007711\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2017-11-20 13:11:09\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ0ZXN0MzMzIiwiaXNzIjoiaHR0cDovL2J1c2hmaXJlLmxhbi9hZG1pbi9hZGQiLCJpYXQiOjE1MTExODM0NjksImV4cCI6MTUxNDgxMjI2OSwibmJmIjoxNTExMTgzNDY5LCJqdGkiOiJoQWtTMGo4Z1l6dGFLWEJtIn0.7HlF2s6f2VXU4A58uQlkM5Zx4idzQFUbi5D-FT9cHl8', '0000-00-00 00:00:00', 'test333', NULL, 'test311@gmail.com', NULL, NULL, '919988007711', NULL),
('919988665544', 'Test123', '2017-11-20 06:39:55', '{\"nickName\":\"Test123\",\"status\":null,\"email\":\"test123@gmail.com\",\"mobileNumber\":\"919988665544\",\"gender\":null,\"dob\":null}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJUZXN0MTIzIiwiaXNzIjoiaHR0cDovL2J1c2hmaXJlLmxhbi9hZG1pbi9hZGQiLCJpYXQiOjE1MTExNTk5OTUsImV4cCI6MTUxNDc4ODc5NSwibmJmIjoxNTExMTU5OTk1LCJqdGkiOiJuTDgzaERmYWtPUUJWcGpOIn0.qvNURp65v-Dk2UO4wM7_HSdhmi2JscXl4QXTAfnoQoA', '0000-00-00 00:00:00', 'Test123', NULL, 'test123@gmail.com', NULL, NULL, '919988665544', NULL),
('919988776654', ' ', '2017-12-13 07:15:03', '{\"nickName\":null,\"status\":null,\"email\":null,\"mobileNumber\":\"919988776654\",\"gender\":null,\"dob\":null,\"image\":null}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTk5ODg3NzY2NTQiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjgyL2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTEzMTQ5MzAzLCJleHAiOjE1MTY3NzgxMDMsIm5iZiI6MTUxMzE0OTMwMywianRpIjoiMnFvaHE3eHJBcTc2bFBPZCJ9.atcbo_aUva-VuxOlGiZig6PXoeQPoW8u4XCrSqcGEUA', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, '919988776654', NULL),
('919988776655', 'test311', '2017-11-20 06:45:11', '{\"nickName\":null,\"status\":null,\"email\":null,\"mobileNumber\":\"919988776655\",\"gender\":null,\"dob\":null,\"image\":null}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTk5ODg3NzY2NTUiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjM3L2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTExMTgwNDY5LCJleHAiOjE1MTQ4MDkyNjksIm5iZiI6MTUxMTE4MDQ2OSwianRpIjoiV0tETGVJbnNqMFFoTWlDQyJ9.wjW26r5E_iVu_6sGKlfOrqCjvM6kgMQ8Itboia8Hp3Y', '2017-11-20 12:21:09', 'test311', NULL, 'test311@gmail.com', NULL, NULL, '919988776655', NULL),
('919999988888', 'Dev Testing', '2017-12-28 06:31:09', '{\"gender\":\"Male\",\"nickName\":\"Dev Testing\",\"dob\":\"10\\/12\\/1992\",\"mobileNumber\":\"919999988888\",\"name\":\"Dev Testing\",\"userName\":\"Dev Testing\",\"email\":\"devTesting@yahoo.com\",\"status\":\"I am on BushFire\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTk5OTk5ODg4ODgiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjgyL2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTE0NDQyNjY5LCJleHAiOjE1MTgwNzE0NjksIm5iZiI6MTUxNDQ0MjY2OSwianRpIjoiUWY2UzJFM2dRdTBZUWNyMyJ9.tn3o6GC-QxUUw8B-h3go19fqtO-qg4O76spfKcCqBGQ', '2017-12-28 12:02:28', 'Dev Testing', 'I am on BushFire', 'devTesting@yahoo.com', 'Male', '10/12/1992', '919999988888', '');
INSERT INTO `user_details` (`user_id`, `user_name`, `created_date`, `vcard`, `token`, `updated_date`, `nickname`, `status`, `email`, `gender`, `dob`, `mobileNumber`, `image_url`) VALUES
('919999999999', 'NineNine', '2018-01-19 06:23:12', '{\"gender\":\"Male\",\"nickName\":\"NineNine\",\"dob\":\"19\\/01\\/1984\",\"mobileNumber\":\"919999999999\",\"name\":\"NineNine\",\"userName\":\"NineNine\",\"email\":\"nine@nine.com\",\"status\":\"I am on BushFire\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5MTk5OTk5OTk5OTkiLCJpc3MiOiJodHRwOi8vMTkyLjE2OC4yLjgyL2FwaS92MS91c2VyL2dldHBhc3N3b3JkIiwiaWF0IjoxNTE2MzQ0MDM1LCJleHAiOjE1MTk5NzI4MzUsIm5iZiI6MTUxNjM0NDAzNSwianRpIjoiMTZQaHFnTHhNMHM3UG5EcSJ9.JAupAsKUuQXBUyr0ZP7T_sva9TZM0AR-kKvT814Qfk0', '2018-01-19 12:10:57', 'NineNine', 'I am on BushFire', 'nine@nine.com', 'Male', '19/01/1984', '919999999999', ''),
('929632357734', 'Shilpa', '2017-11-20 06:20:47', '{\"nickName\":\"Shilpa\",\"status\":null,\"email\":\"test@gmail.com\",\"mobileNumber\":\"929632357734\",\"gender\":null,\"dob\":null}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJTaGlscGEiLCJpc3MiOiJodHRwOi8vYnVzaGZpcmUubGFuL2FkbWluL2FkZCIsImlhdCI6MTUxMTE1ODg0NywiZXhwIjoxNTE0Nzg3NjQ3LCJuYmYiOjE1MTExNTg4NDcsImp0aSI6InhDZU1BVGlHdnZUZHBqSGkifQ.lJmYgHU-dNuDqBgtdHP_cxysZS-w3KbvOEv-T1NNE2g', '0000-00-00 00:00:00', 'Shilpa', NULL, 'test@gmail.com', NULL, NULL, '929632357734', NULL),
('93767565675', 'shruthika', '2018-01-05 07:24:51', '{\"user_id\":\"93767565675\",\"user_name\":\"shruthika\",\"nickName\":\"shruthika\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJzaHJ1dGhpa2EiLCJpc3MiOiJodHRwOi8vZGV2LmJ1c2hmaXJlLmxhbi9waiIsImlhdCI6MTUxNTEzNzA5MSwiZXhwIjoxNTE4NzY1ODkxLCJuYmYiOjE1MTUxMzcwOTEsImp0aSI6Ild0SFNsR3ZEdnp2ZEJnVFEifQ.j-lEN_7IqDnpIiTtw_tNGc69rPvegndJuQeNIhR-A-c\",\"status\":null,\"email\":\"shruthika@gmail.com\",\"mobileNumber\":\"93767565675\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-05 07:24:51\",\"roles\":\"\\\"Platform Jockey\\\"\",\"permissions\":[],\"access\":\"1111\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJzaHJ1dGhpa2EiLCJpc3MiOiJodHRwOi8vZGV2LmJ1c2hmaXJlLmxhbi9waiIsImlhdCI6MTUxNTEzNzA5MSwiZXhwIjoxNTE4NzY1ODkxLCJuYmYiOjE1MTUxMzcwOTEsImp0aSI6Ild0SFNsR3ZEdnp2ZEJnVFEifQ.j-lEN_7IqDnpIiTtw_tNGc69rPvegndJuQeNIhR-A-c', '0000-00-00 00:00:00', 'shruthika', NULL, 'shruthika@gmail.com', NULL, NULL, '93767565675', NULL),
('944658787', 'jkkk', '2018-01-17 12:11:59', '{\"user_id\":\"944658787\",\"user_name\":\"jkkk\",\"nickName\":\"jkkk\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJqa2trIiwiaXNzIjoiaHR0cDovL2Rldi5idXNoZmlyZS5sYW4vcGoiLCJpYXQiOjE1MTYxOTExMTksImV4cCI6MTczMzkzMTExOSwibmJmIjoxNTE2MTkxMTE5LCJqdGkiOiJUNFRWNHo4eU5kWHB2YldPIn0.n7yb7SDzpdqNJH4bZmJbApBMJfjeh38mWYQeUGsJSDo\",\"status\":null,\"email\":\"gggg1@pppp.com\",\"mobileNumber\":\"944658787\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-17 12:11:59\",\"roles\":[\"PLATFORMJOCKEY\"],\"permissions\":[],\"access\":\"1111\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJqa2trIiwiaXNzIjoiaHR0cDovL2Rldi5idXNoZmlyZS5sYW4vcGoiLCJpYXQiOjE1MTYxOTExMTksImV4cCI6MTczMzkzMTExOSwibmJmIjoxNTE2MTkxMTE5LCJqdGkiOiJUNFRWNHo4eU5kWHB2YldPIn0.n7yb7SDzpdqNJH4bZmJbApBMJfjeh38mWYQeUGsJSDo', '0000-00-00 00:00:00', 'jkkk', NULL, 'gggg1@pppp.com', NULL, NULL, '944658787', NULL),
('984874674763', 'stringer', '2018-01-05 15:04:49', '{\"user_id\":\"984874674763\",\"user_name\":\"stringer\",\"nickName\":\"stringer\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJzdHJpbmdlciIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3N0cmluZ2VyIiwiaWF0IjoxNTE1MTY0Njg5LCJleHAiOjE1MTg3OTM0ODksIm5iZiI6MTUxNTE2NDY4OSwianRpIjoiZkZRcGM2U3ByVzBYRktrNCJ9.iJxNZNctiHI43Drd6zlfPLu1PHz46mVKyhTnkvYIMFQ\",\"status\":null,\"email\":\"stringer@gmail.com\",\"mobileNumber\":\"984874674763\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-05 15:04:49\",\"roles\":[\"STRINGER\"],\"permissions\":[]}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJzdHJpbmdlciIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3N0cmluZ2VyIiwiaWF0IjoxNTE1MTY0Njg5LCJleHAiOjE1MTg3OTM0ODksIm5iZiI6MTUxNTE2NDY4OSwianRpIjoiZkZRcGM2U3ByVzBYRktrNCJ9.iJxNZNctiHI43Drd6zlfPLu1PHz46mVKyhTnkvYIMFQ', '0000-00-00 00:00:00', 'stringer', NULL, 'stringer@gmail.com', NULL, NULL, '984874674763', NULL),
('9857474747488', 'Naveen', '2018-01-05 09:49:40', '{\"user_id\":\"9857474747488\",\"user_name\":\"Naveen\",\"nickName\":\"Naveen\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJOYXZlZW4iLCJpc3MiOiJodHRwOi8vZGV2LmJ1c2hmaXJlLmxhbi9waiIsImlhdCI6MTUxNTE0NTc4MCwiZXhwIjoxNTE4Nzc0NTgwLCJuYmYiOjE1MTUxNDU3ODAsImp0aSI6Ink3cXpkYU1DeUtoSWNrcTQifQ.I1T7bqVXoZppEjn5RjKkBuLusw59Olu6EgwNuEdqOzw\",\"status\":null,\"email\":\"naveee@gmail.com\",\"mobileNumber\":\"9857474747488\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-05 09:49:40\",\"roles\":[\"\\\"Platform Jockey\\\"\"],\"permissions\":[],\"access\":\"1111\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJOYXZlZW4iLCJpc3MiOiJodHRwOi8vZGV2LmJ1c2hmaXJlLmxhbi9waiIsImlhdCI6MTUxNTE0NTc4MCwiZXhwIjoxNTE4Nzc0NTgwLCJuYmYiOjE1MTUxNDU3ODAsImp0aSI6Ink3cXpkYU1DeUtoSWNrcTQifQ.I1T7bqVXoZppEjn5RjKkBuLusw59Olu6EgwNuEdqOzw', '0000-00-00 00:00:00', 'Naveen', NULL, 'naveee@gmail.com', NULL, NULL, '9857474747488', NULL),
('98877853434', 'devi1', '2018-01-05 13:32:10', '{\"user_id\":\"98877853434\",\"user_name\":\"devi1\",\"nickName\":\"devi1\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJkZXZpMSIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3BqIiwiaWF0IjoxNTE1MTU5MTMwLCJleHAiOjE1MTg3ODc5MzAsIm5iZiI6MTUxNTE1OTEzMCwianRpIjoic3FwSG1yZUVwSE1CS3hxMCJ9.Er07tU4cSIvzYuhPa-ql1oQ40jZp3UxRTEMOEdUnP64\",\"status\":null,\"email\":\"devi123@gmail.com\",\"mobileNumber\":\"98877853434\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-05 13:32:10\",\"roles\":[\"PLATFORMJOCKEY\"],\"permissions\":[],\"access\":\"1111\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJkZXZpMSIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3BqIiwiaWF0IjoxNTE1MTU5MTMwLCJleHAiOjE1MTg3ODc5MzAsIm5iZiI6MTUxNTE1OTEzMCwianRpIjoic3FwSG1yZUVwSE1CS3hxMCJ9.Er07tU4cSIvzYuhPa-ql1oQ40jZp3UxRTEMOEdUnP64', '0000-00-00 00:00:00', 'devi1', NULL, 'devi123@gmail.com', NULL, NULL, '98877853434', NULL),
('99786785657', 'shree', '2018-01-05 14:09:53', '{\"user_id\":\"99786785657\",\"user_name\":\"shree\",\"nickName\":\"shree\",\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJzaHJlZSIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3BqIiwiaWF0IjoxNTE1MTYxMzkzLCJleHAiOjE1MTg3OTAxOTMsIm5iZiI6MTUxNTE2MTM5MywianRpIjoid0dObUdZbjQxY0Y4ZEsycyJ9.NSPhgDRKhE6F2-xhzO87M1jatCyeKjOgZq_0lVbuQD8\",\"status\":null,\"email\":\"shree@gmail.com\",\"mobileNumber\":\"99786785657\",\"gender\":null,\"dob\":null,\"image_url\":null,\"created_date\":\"2018-01-05 14:09:53\",\"roles\":[\"PLATFORMJOCKEY\"],\"permissions\":[],\"access\":\"1111\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJzaHJlZSIsImlzcyI6Imh0dHA6Ly9kZXYuYnVzaGZpcmUubGFuL3BqIiwiaWF0IjoxNTE1MTYxMzkzLCJleHAiOjE1MTg3OTAxOTMsIm5iZiI6MTUxNTE2MTM5MywianRpIjoid0dObUdZbjQxY0Y4ZEsycyJ9.NSPhgDRKhE6F2-xhzO87M1jatCyeKjOgZq_0lVbuQD8', '0000-00-00 00:00:00', 'shree', NULL, 'shree@gmail.com', NULL, NULL, '99786785657', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ad_process_age_group`
--
ALTER TABLE `ad_process_age_group`
  ADD PRIMARY KEY (`ad_process_age_group_id`);

--
-- Indexes for table `ad_process_category`
--
ALTER TABLE `ad_process_category`
  ADD PRIMARY KEY (`ad_process_category_id`);

--
-- Indexes for table `ad_process_gender`
--
ALTER TABLE `ad_process_gender`
  ADD PRIMARY KEY (`ad_process_gender_id`);

--
-- Indexes for table `agency_advertisement`
--
ALTER TABLE `agency_advertisement`
  ADD PRIMARY KEY (`agency_advertisement_id`);

--
-- Indexes for table `age_group`
--
ALTER TABLE `age_group`
  ADD PRIMARY KEY (`age_group_id`),
  ADD UNIQUE KEY `age_group_id_UNIQUE` (`age_group_id`);

--
-- Indexes for table `business_channel_approval`
--
ALTER TABLE `business_channel_approval`
  ADD PRIMARY KEY (`business_channel_approval_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_id_UNIQUE` (`category_id`);

--
-- Indexes for table `channels`
--
ALTER TABLE `channels`
  ADD PRIMARY KEY (`channel_id`),
  ADD UNIQUE KEY `channel_id_UNIQUE` (`channel_id`);

--
-- Indexes for table `channel_age_group`
--
ALTER TABLE `channel_age_group`
  ADD PRIMARY KEY (`channel_age_group_id`);

--
-- Indexes for table `channel_category`
--
ALTER TABLE `channel_category`
  ADD PRIMARY KEY (`channel_category_id`);

--
-- Indexes for table `channel_content`
--
ALTER TABLE `channel_content`
  ADD PRIMARY KEY (`channel_content_id`);

--
-- Indexes for table `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`content_id`);

--
-- Indexes for table `content_publish`
--
ALTER TABLE `content_publish`
  ADD PRIMARY KEY (`content_id`);

--
-- Indexes for table `email_reminder`
--
ALTER TABLE `email_reminder`
  ADD PRIMARY KEY (`email_reminder_id`);

--
-- Indexes for table `emoji_sticker`
--
ALTER TABLE `emoji_sticker`
  ADD PRIMARY KEY (`emoji_sticker_id`);

--
-- Indexes for table `emoji_sticker_category`
--
ALTER TABLE `emoji_sticker_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `emoji_sticker_category_mapper`
--
ALTER TABLE `emoji_sticker_category_mapper`
  ADD PRIMARY KEY (`category_mapper_id`);

--
-- Indexes for table `gender`
--
ALTER TABLE `gender`
  ADD PRIMARY KEY (`gender_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`group_id`),
  ADD UNIQUE KEY `uq_groups` (`group_name`,`created_user_id`);

--
-- Indexes for table `group_content`
--
ALTER TABLE `group_content`
  ADD PRIMARY KEY (`group_content_id`);

--
-- Indexes for table `group_user`
--
ALTER TABLE `group_user`
  ADD PRIMARY KEY (`group_user_id`);

--
-- Indexes for table `hashtags`
--
ALTER TABLE `hashtags`
  ADD PRIMARY KEY (`hashtag_id`);

--
-- Indexes for table `hashtags_content`
--
ALTER TABLE `hashtags_content`
  ADD PRIMARY KEY (`hashtags_content_id`);

--
-- Indexes for table `parental_control`
--
ALTER TABLE `parental_control`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `parental_control_age_group`
--
ALTER TABLE `parental_control_age_group`
  ADD PRIMARY KEY (`parental_control_age_group_id`);

--
-- Indexes for table `pj_stunner`
--
ALTER TABLE `pj_stunner`
  ADD PRIMARY KEY (`pj_stunner_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `roles_name_UNIQUE` (`role_name`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_user_role_id_FOREIGN` (`role_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indexes for table `social_activity_dislikes`
--
ALTER TABLE `social_activity_dislikes`
  ADD PRIMARY KEY (`social_activity_dislikes_id`);

--
-- Indexes for table `social_activity_likes`
--
ALTER TABLE `social_activity_likes`
  ADD PRIMARY KEY (`social_activity_likes_id`);

--
-- Indexes for table `social_content_comments`
--
ALTER TABLE `social_content_comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `social_content_comments_level_1`
--
ALTER TABLE `social_content_comments_level_1`
  ADD PRIMARY KEY (`social_content_comments_level_1_id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`subscription_id`);

--
-- Indexes for table `subscription_request`
--
ALTER TABLE `subscription_request`
  ADD PRIMARY KEY (`channel_requester_id`);

--
-- Indexes for table `user_channel`
--
ALTER TABLE `user_channel`
  ADD PRIMARY KEY (`user_channel_id`);

--
-- Indexes for table `user_comments`
--
ALTER TABLE `user_comments`
  ADD PRIMARY KEY (`user_comment_id`);

--
-- Indexes for table `user_comments_category`
--
ALTER TABLE `user_comments_category`
  ADD PRIMARY KEY (`user_comments_category_id`);

--
-- Indexes for table `user_comments_transaction`
--
ALTER TABLE `user_comments_transaction`
  ADD PRIMARY KEY (`user_comments_transaction_id`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`user_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_FOREIGN` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
