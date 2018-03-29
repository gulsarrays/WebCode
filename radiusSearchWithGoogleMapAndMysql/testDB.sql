-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 29, 2018 at 09:45 AM
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
-- Database: `DynamicGeoPolygon`
--

-- --------------------------------------------------------

--
-- Table structure for table `plant`
--

CREATE TABLE `plant` (
  `id` int(11) UNSIGNED NOT NULL,
  `plant_name` text NOT NULL,
  `lat` decimal(11,8) DEFAULT NULL,
  `lng` decimal(11,8) DEFAULT NULL,
  `type` enum('GROUNDMOUNT','ROOFTOP') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `plant`
--

INSERT INTO `plant` (`id`, `plant_name`, `lat`, `lng`, `type`) VALUES
(1, 'Gujarat( 1.1),(1.2)', '23.44000000', '73.20000000', 'GROUNDMOUNT'),
(2, 'Punjab 1', '31.94000000', '74.91000000', 'GROUNDMOUNT'),
(3, 'Rajasthan 1', '27.22000000', '74.25000000', 'GROUNDMOUNT'),
(4, 'Rajasthan( 2.1),(2.2)', '27.22000000', '74.18000000', 'GROUNDMOUNT'),
(5, 'Gujarat Rooftop 2.5 MW', '23.22000000', '72.65000000', 'ROOFTOP'),
(6, 'DLF Kolkata 148.68 kW', '22.58000000', '88.48000000', 'ROOFTOP'),
(7, 'DLF Chennai 467 kW', '13.00000000', '80.20000000', 'ROOFTOP'),
(8, 'DLF Noida  40.32 kW', '28.50000000', '77.40000000', 'ROOFTOP'),
(9, 'Punjab (2.1, 2.2, 2.3)', '0.00000000', '0.00000000', 'GROUNDMOUNT'),
(10, 'DLF Hyderabad_519kW', '17.25000000', '78.24000000', 'ROOFTOP'),
(11, 'Karnataka 1', '14.07000000', '76.67000000', 'GROUNDMOUNT'),
(12, 'Uttar Pradesh 1', '25.32000000', '79.81000000', 'GROUNDMOUNT'),
(13, 'Chhattisgarh(1.1).(1.2),(1.3)', '21.50000000', '81.30000000', 'GROUNDMOUNT'),
(14, 'Rajasthan 3.3', '26.80000000', '73.20000000', 'GROUNDMOUNT'),
(15, 'Rajasthan 3.2', '26.76000000', '73.20000000', 'GROUNDMOUNT'),
(16, 'Rajasthan 3.1', '26.76000000', '73.20000000', 'GROUNDMOUNT'),
(17, 'Indosolar 550 kW', '28.50000000', '77.50000000', 'ROOFTOP'),
(18, 'Trident Agra 53.55 kW', '27.20000000', '78.00000000', 'ROOFTOP'),
(19, 'IPTPS 3MW', '28.62000000', '77.24000000', 'GROUNDMOUNT'),
(20, 'Rajasthan 4', '30.47000000', '74.37000000', 'GROUNDMOUNT'),
(21, 'Gymkhana 56 KW', '28.60000000', '77.20000000', 'ROOFTOP'),
(22, 'TajSATS 178 kW', '28.55000000', '77.10000000', 'ROOFTOP'),
(23, 'DTC Depot Peerhagarhi', '28.60000000', '77.20000000', 'ROOFTOP'),
(24, 'JCBL_1MW', '30.70000000', '76.70000000', 'ROOFTOP'),
(25, 'Punjab 3.1', '30.47000000', '74.37000000', 'GROUNDMOUNT'),
(26, 'Punjab 3.2', '30.47000000', '74.37000000', 'GROUNDMOUNT'),
(27, 'DLF Gurgaon 246 kW', '28.50000000', '77.10000000', 'ROOFTOP'),
(28, 'YPCC 40 kW', '0.00000000', '0.00000000', 'ROOFTOP'),
(29, 'Trident Udaipur_119.7 kW', '24.60000000', '73.70000000', 'ROOFTOP'),
(30, 'Andhra Pradesh 1(4)', '14.51000000', '77.74000000', 'GROUNDMOUNT'),
(31, 'Karnataka 2', '14.06000000', '76.91000000', 'GROUNDMOUNT'),
(32, 'Oberoi Gurgaon_129.78 kW', '28.50000000', '77.10000000', 'ROOFTOP'),
(33, 'Oberoi Udaivilas_140.17 kW', '24.60000000', '73.70000000', 'ROOFTOP'),
(34, 'DLF Chandigarh 436.905 KW', '0.00000000', '0.00000000', 'ROOFTOP'),
(35, 'PEDA Bhagwant Singh & Kulwinder Kaur warehouse 0.550 MW', '30.40000000', '76.40000000', 'ROOFTOP'),
(36, 'PEDA BOSS Computers_1.250 MW', '30.40000000', '76.40000000', 'ROOFTOP'),
(37, 'PEDA Bhagwant Singh & Others_ 1.304 MW', '30.40000000', '76.40000000', 'ROOFTOP'),
(38, 'Test Consultant', '1.00000000', '1.00000000', 'ROOFTOP'),
(39, 'PEDA  CANAM Consultant_1.597 MW', '30.40000000', '76.40000000', 'ROOFTOP'),
(40, 'PEDA  C A Vegefruit Stores_0.598 MW', '30.40000000', '76.40000000', 'ROOFTOP'),
(41, 'PEDA PSAMB Ludhiana_0.762 MW', '30.40000000', '76.40000000', 'ROOFTOP'),
(42, 'PEDA PSAMB Mansa_0.630 MW', '30.40000000', '76.40000000', 'ROOFTOP'),
(43, 'PEDA Skyross Enterprises_1.253 MW', '30.40000000', '76.40000000', 'ROOFTOP'),
(44, 'Bihar 1', '27.10000000', '84.30000000', 'GROUNDMOUNT'),
(45, 'DTC Depot Rohini 2', '28.60000000', '77.20000000', 'ROOFTOP'),
(46, 'DTC Depot Rohini 4', '28.44000000', '77.07000000', 'ROOFTOP'),
(47, 'DTC Bawana Depot', '28.60000000', '77.20000000', 'ROOFTOP'),
(48, 'DTC Kanjhawala Depot I & II', '28.60000000', '77.20000000', 'ROOFTOP'),
(49, 'DTC GTK Depot', '28.60000000', '77.20000000', 'ROOFTOP'),
(50, 'Trident Gurgaon 396.9 KW', '28.50000000', '77.08000000', 'ROOFTOP'),
(51, 'G. B. Pant Institute', '28.60000000', '77.20000000', 'ROOFTOP'),
(52, 'Hans Raj College', '28.50000000', '77.10000000', 'ROOFTOP'),
(53, 'Zakir Hussain College', '28.50000000', '77.10000000', 'ROOFTOP'),
(54, 'Janki Devi College  Delhi', '28.50000000', '77.10000000', 'ROOFTOP'),
(55, 'Shyam Lal College', '28.50000000', '77.10000000', 'ROOFTOP'),
(56, 'DMRC Sultanpur depot', '28.60000000', '77.20000000', 'ROOFTOP'),
(57, 'DMRC Najafgarh Depot', '28.60000000', '77.20000000', 'ROOFTOP'),
(58, 'Vivekanand College  Delhi', '28.60000000', '77.20000000', 'ROOFTOP'),
(59, 'Bahadurkhera, Punjab (P4.1)', '30.17500000', '75.60000000', 'GROUNDMOUNT'),
(60, 'Korianwali, Punjab (P4.2)', '30.67000000', '74.14000000', 'GROUNDMOUNT'),
(61, 'Vanwala, Punjab (P4.3)', '30.01000000', '74.60000000', 'GROUNDMOUNT'),
(62, 'Badal, Punjab (P4.4)', '30.07000000', '74.67000000', 'GROUNDMOUNT'),
(63, 'Bahadurgarh Jandian Part-1, Punjab (P4.5.1)', '30.10000000', '74.70000000', 'GROUNDMOUNT'),
(64, 'Bahadurgarh Jandian Part-2, Punjab (P4.5.2)', '30.10000000', '74.70000000', 'GROUNDMOUNT'),
(65, 'Bhittiwala, Punjab (P4.6)', '30.00000000', '74.50000000', 'GROUNDMOUNT'),
(66, 'Dwarka Court', '28.50000000', '77.10000000', 'ROOFTOP'),
(67, 'Nagpur_Bhandara 2MW', '21.10000000', '79.60000000', 'GROUNDMOUNT'),
(68, 'Nagpur_Ambajari 5MW', '21.10000000', '79.00000000', 'GROUNDMOUNT'),
(69, 'DMRC Sarita Vihar Depot 1624 KW', '28.60000000', '77.20000000', 'ROOFTOP'),
(70, 'Karnataka3_40MW', '13.90000000', '76.60000000', 'GROUNDMOUNT'),
(71, 'Karnataka4_40MW', '13.90000000', '76.60000000', 'GROUNDMOUNT'),
(72, 'Karnataka5_50MW', '13.90000000', '76.60000000', 'GROUNDMOUNT'),
(73, 'DMRC Sukhdev Vihar Metro Station', '28.60000000', '77.20000000', 'ROOFTOP'),
(74, 'DMRC Okhla Vihar Metro Station', '28.60000000', '77.20000000', 'ROOFTOP'),
(75, 'DMRC Jasola Vihar Metro Station', '28.60000000', '77.20000000', 'ROOFTOP'),
(76, 'Punjab 2.3', '30.47000000', '74.49000000', 'GROUNDMOUNT'),
(77, 'Punjab 2.2', '30.47000000', '74.49000000', 'GROUNDMOUNT'),
(78, 'Punjab 2.1', '30.47000000', '74.49000000', 'GROUNDMOUNT'),
(79, 'Andhra Pradesh 2.1', '15.80000000', '78.00000000', 'GROUNDMOUNT'),
(80, 'Andhra Pradesh 2.2', '15.80000000', '78.00000000', 'GROUNDMOUNT'),
(81, 'Banda, Uttar Pradesh (UP2.2)', '25.50000000', '80.30000000', 'GROUNDMOUNT'),
(82, 'Banda, Uttar Pradesh (UP2.1)', '25.50000000', '80.30000000', 'GROUNDMOUNT'),
(83, 'Utkal University', '20.30000000', '85.80000000', 'ROOFTOP'),
(84, 'Uttar Pradesh (UP2.3)', '25.50000000', '80.30000000', 'GROUNDMOUNT'),
(85, 'Uttar Pradesh (UP2.4)', '25.50000000', '80.30000000', 'GROUNDMOUNT'),
(86, 'Uttar Pradesh (UP2.5)', '25.50000000', '80.30000000', 'GROUNDMOUNT'),
(87, 'DMRC Khyber Pass Metro Depot', '28.41000000', '77.13000000', 'ROOFTOP'),
(88, 'DMRC Shankar Vihar', '28.56000000', '77.14000000', 'ROOFTOP'),
(89, 'DMRC Amity noida', '28.50000000', '77.30000000', 'ROOFTOP'),
(90, 'DMRC Botanical garden', '28.56000000', '77.33000000', 'ROOFTOP'),
(91, 'DMRC Jamia Nagar', '28.56000000', '77.28000000', 'ROOFTOP'),
(92, 'DMRC Kalindi Kunj', '28.50000000', '77.30000000', 'ROOFTOP'),
(93, 'Okhla NSIC', '28.33000000', '77.15000000', 'ROOFTOP'),
(94, 'Kalkaji', '28.32000000', '77.15000000', 'ROOFTOP'),
(95, 'Shivaji Stadium', '28.37000000', '77.12000000', 'ROOFTOP'),
(96, 'New Delhi', '28.38000000', '77.13000000', 'ROOFTOP'),
(97, 'Aerocity', '28.32000000', '77.06000000', 'ROOFTOP'),
(98, 'Dhaula Kaun', '28.35000000', '77.09000000', 'ROOFTOP'),
(99, 'DJB_Haiderpur', '28.43000000', '77.08000000', 'ROOFTOP'),
(100, 'Railway_Agra_Cantt', '27.09000000', '77.59000000', 'ROOFTOP'),
(101, 'TG1.2_5x10MW Rachur_1', '16.73000000', '78.48000000', 'GROUNDMOUNT'),
(102, 'TG1.3_2x10MW Rachur_2', '16.80000000', '78.40000000', 'GROUNDMOUNT'),
(103, 'TG1.1_3x10MW Marchala', '16.69000000', '78.42000000', 'GROUNDMOUNT'),
(104, 'Gedcol_State_Museum', '20.14000000', '85.50000000', 'ROOFTOP'),
(105, 'Gedcol_Secretriat', '20.16000000', '85.49000000', 'ROOFTOP'),
(106, 'Gedcol_Jaydev_Bhawan', '20.16000000', '85.50000000', 'ROOFTOP'),
(107, 'Gedcol_Ramadevi_College', '20.17000000', '85.50000000', 'ROOFTOP'),
(108, 'RSS_Palam', '28.35000000', '77.08000000', 'ROOFTOP'),
(109, 'Andhra Pradesh 3', '0.00000000', '0.00000000', 'GROUNDMOUNT'),
(110, 'Test1', '39.73755400', '-77.46494300', 'ROOFTOP'),
(111, 'Test2', '38.73755400', '-77.46494300', 'ROOFTOP');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `plant`
--
ALTER TABLE `plant`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lat` (`lat`),
  ADD KEY `lng` (`lng`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `plant`
--
ALTER TABLE `plant`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
