-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 16, 2026 at 05:19 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tracen_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `characters`
--

CREATE TABLE `characters` (
  `id` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `b_spd` int(11) DEFAULT NULL,
  `b_sta` int(11) DEFAULT NULL,
  `b_pow` int(11) DEFAULT NULL,
  `b_gut` int(11) DEFAULT NULL,
  `b_wit` int(11) DEFAULT NULL,
  `bon_spd` int(11) DEFAULT NULL,
  `bon_sta` int(11) DEFAULT NULL,
  `bon_pow` int(11) DEFAULT NULL,
  `bon_gut` int(11) DEFAULT NULL,
  `bon_wit` int(11) DEFAULT NULL,
  `apt_turf` varchar(1) DEFAULT NULL,
  `apt_dirt` varchar(1) DEFAULT NULL,
  `apt_short` varchar(1) DEFAULT NULL,
  `apt_mile` varchar(1) DEFAULT NULL,
  `apt_medium` varchar(1) DEFAULT NULL,
  `apt_long` varchar(1) DEFAULT NULL,
  `apt_runner` varchar(1) DEFAULT NULL,
  `apt_leader` varchar(1) DEFAULT NULL,
  `apt_betweener` varchar(1) DEFAULT NULL,
  `apt_chaser` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `characters`
--

INSERT INTO `characters` (`id`, `name`, `image_url`, `b_spd`, `b_sta`, `b_pow`, `b_gut`, `b_wit`, `bon_spd`, `bon_sta`, `bon_pow`, `bon_gut`, `bon_wit`, `apt_turf`, `apt_dirt`, `apt_short`, `apt_mile`, `apt_medium`, `apt_long`, `apt_runner`, `apt_leader`, `apt_betweener`, `apt_chaser`) VALUES
('100101', 'Special Week', 'assets/images/characters/chara_stand_1001_100101.png', 85, 110, 95, 95, 115, 0, 20, 0, 0, 10, 'A', 'G', 'G', 'C', 'A', 'A', 'F', 'A', 'A', 'G'),
('100102', 'Special Week (Alt)', 'assets/images/characters/chara_stand_1001_100102.png', 102, 100, 98, 92, 108, 0, 10, 20, 0, 0, 'A', 'G', 'G', 'C', 'A', 'A', 'F', 'A', 'A', 'G'),
('100103', 'Special Week (Commander)', 'assets/images/characters/chara_stand_1001_100103.png', 110, 108, 93, 116, 123, 14, 0, 0, 8, 8, 'A', 'G', 'G', 'C', 'A', 'A', 'C', 'A', 'A', 'G'),
('100201', 'Silence Suzuka', 'assets/images/characters/chara_stand_1002_100201.png', 120, 85, 90, 90, 90, 20, 0, 0, 0, 10, 'A', 'G', 'G', 'A', 'A', 'E', 'A', 'B', 'F', 'G'),
('100301', 'Tokai Teio', 'assets/images/characters/chara_stand_1003_100301.png', 110, 80, 95, 95, 95, 20, 0, 0, 0, 10, 'A', 'G', 'G', 'A', 'A', 'E', 'G', 'A', 'B', 'F'),
('100302', 'Tokai Teio (Alt)', 'assets/images/characters/chara_stand_1003_100302.png', 105, 85, 95, 95, 95, 0, 10, 20, 0, 0, 'A', 'G', 'G', 'A', 'A', 'E', 'G', 'A', 'B', 'F'),
('100401', 'Maruzensky', 'assets/images/characters/chara_stand_1004_100401.png', 110, 90, 95, 95, 85, 10, 0, 0, 0, 20, 'A', 'B', 'B', 'A', 'B', 'G', 'A', 'B', 'F', 'G'),
('100402', 'Maruzensky (Alt)', 'assets/images/characters/chara_stand_1004_100402.png', 115, 90, 100, 95, 100, 10, 0, 20, 0, 0, 'A', 'B', 'B', 'A', 'B', 'G', 'A', 'B', 'F', 'G'),
('100501', 'Fuji Kiseki', 'assets/images/characters/chara_stand_1005_100501.png', 100, 85, 100, 95, 95, 20, 0, 10, 0, 0, 'A', 'G', 'G', 'A', 'B', 'G', 'G', 'A', 'B', 'G'),
('100502', 'Fuji Kiseki (Alt)', 'assets/images/characters/chara_stand_1005_100502.png', 105, 80, 105, 90, 90, 20, 0, 10, 0, 0, 'A', 'G', 'G', 'A', 'B', 'G', 'G', 'A', 'B', 'G'),
('100601', 'Oguri Cap', 'assets/images/characters/chara_stand_1006_100601.png', 100, 90, 105, 95, 85, 0, 0, 20, 0, 10, 'A', 'B', 'G', 'A', 'A', 'B', 'G', 'A', 'A', 'F'),
('100701', 'Gold Ship', 'assets/images/characters/chara_stand_1007_100701.png', 90, 110, 100, 100, 80, 0, 20, 0, 10, 0, 'A', 'G', 'G', 'G', 'A', 'A', 'G', 'C', 'B', 'A'),
('100702', 'Gold Ship (Summer)', 'assets/images/characters/chara_stand_1007_100702.png', 96, 113, 137, 89, 115, 0, 0, 20, 0, 10, 'A', 'G', 'G', 'C', 'A', 'A', 'G', 'B', 'B', 'A'),
('100801', 'Vodka', 'assets/images/characters/chara_stand_1008_100801.png', 100, 85, 105, 95, 90, 0, 0, 20, 10, 0, 'A', 'G', 'G', 'A', 'A', 'F', 'G', 'B', 'A', 'G'),
('100901', 'Daiwa Scarlet', 'assets/images/characters/chara_stand_1009_100901.png', 100, 95, 95, 90, 95, 10, 0, 0, 10, 0, 'A', 'G', 'G', 'A', 'A', 'F', 'A', 'A', 'F', 'G'),
('101001', 'Taiki Shuttle', 'assets/images/characters/chara_stand_1010_101001.png', 110, 90, 105, 90, 80, 0, 0, 20, 0, 10, 'A', 'B', 'A', 'A', 'E', 'G', 'A', 'A', 'E', 'G'),
('101002', 'Taiki Shuttle (Camping)', 'assets/images/characters/chara_stand_1010_101002.png', 113, 113, 101, 99, 124, 0, 15, 0, 15, 0, 'A', 'B', 'A', 'A', 'E', 'G', 'A', 'A', 'F', 'G'),
('101101', 'Grass Wonder', 'assets/images/characters/chara_stand_1011_101101.png', 90, 100, 95, 95, 95, 0, 0, 0, 20, 10, 'A', 'G', 'G', 'A', 'A', 'B', 'G', 'B', 'A', 'B'),
('101102', 'Grass Wonder (Alt)', 'assets/images/characters/chara_stand_1011_101102.png', 95, 95, 100, 95, 90, 10, 0, 20, 0, 0, 'A', 'G', 'G', 'A', 'A', 'B', 'G', 'B', 'A', 'B'),
('101201', 'Hishi Amazon', 'assets/images/characters/chara_stand_1012_101201.png', 95, 95, 105, 95, 85, 0, 0, 20, 10, 0, 'A', 'G', 'G', 'A', 'A', 'B', 'G', 'B', 'A', 'B'),
('101301', 'Mejiro McQueen', 'assets/images/characters/chara_stand_1013_101301.png', 90, 115, 90, 100, 80, 0, 20, 0, 0, 10, 'A', 'G', 'G', 'G', 'A', 'A', 'B', 'A', 'E', 'F'),
('101302', 'Mejiro McQueen (Alt)', 'assets/images/characters/chara_stand_1013_101302.png', 90, 110, 95, 105, 80, 0, 10, 0, 20, 0, 'A', 'G', 'G', 'G', 'A', 'A', 'B', 'A', 'E', 'F'),
('101303', 'Mejiro McQueen (Summer)', 'assets/images/characters/chara_stand_1013_101303.png', 92, 120, 93, 110, 135, 0, 0, 0, 10, 20, 'A', 'G', 'G', 'G', 'A', 'A', 'B', 'A', 'E', 'F'),
('101401', 'El Condor Pasa', 'assets/images/characters/chara_stand_1014_101401.png', 95, 95, 100, 90, 95, 0, 0, 10, 0, 20, 'A', 'B', 'F', 'A', 'A', 'E', 'B', 'A', 'B', 'G'),
('101402', 'El Condor Pasa (Alt)', 'assets/images/characters/chara_stand_1014_101402.png', 100, 90, 95, 100, 90, 0, 10, 0, 20, 0, 'A', 'B', 'F', 'A', 'A', 'E', 'B', 'A', 'B', 'G'),
('101501', 'TM Opera O', 'assets/images/characters/chara_stand_1015_101501.png', 90, 105, 95, 100, 85, 0, 0, 0, 20, 10, 'A', 'G', 'G', 'F', 'A', 'A', 'B', 'A', 'B', 'F'),
('101601', 'Narita Brian', 'assets/images/characters/chara_stand_1016_101601.png', 105, 95, 100, 85, 90, 10, 0, 20, 0, 0, 'A', 'G', 'G', 'F', 'A', 'A', 'G', 'B', 'A', 'F'),
('101701', 'Symboli Rudolf', 'assets/images/characters/chara_stand_1017_101701.png', 90, 105, 95, 95, 90, 0, 20, 0, 0, 10, 'A', 'G', 'G', 'E', 'A', 'A', 'G', 'A', 'A', 'G'),
('101801', 'Air Groove', 'assets/images/characters/chara_stand_1018_101801.png', 105, 90, 100, 90, 90, 10, 0, 0, 0, 20, 'A', 'G', 'G', 'A', 'A', 'G', 'F', 'A', 'A', 'G'),
('101802', 'Air Groove (Alt)', 'assets/images/characters/chara_stand_1018_101802.png', 100, 95, 95, 95, 90, 0, 10, 20, 0, 0, 'A', 'G', 'G', 'A', 'A', 'G', 'F', 'A', 'A', 'G'),
('101901', 'Agnes Digital', 'assets/images/characters/chara_stand_1019_101901.png', 95, 90, 100, 85, 100, 0, 0, 10, 0, 20, 'A', 'A', 'G', 'A', 'A', 'G', 'F', 'A', 'A', 'G'),
('102001', 'Seiun Sky', 'assets/images/characters/chara_stand_1020_102001.png', 95, 105, 85, 90, 100, 0, 10, 0, 0, 20, 'A', 'G', 'G', 'E', 'A', 'A', 'A', 'C', 'G', 'G'),
('102002', 'Seiun Sky (Alt)', 'assets/images/characters/chara_stand_1020_102002.png', 90, 110, 85, 90, 105, 0, 10, 0, 0, 20, 'A', 'G', 'G', 'E', 'A', 'A', 'A', 'C', 'G', 'G'),
('102202', 'Fine Motion (Wedding)', 'assets/images/characters/chara_stand_1022_102202.png', 112, 100, 93, 106, 139, 0, 0, 15, 0, 15, 'A', 'G', 'G', 'A', 'A', 'G', 'B', 'A', 'E', 'G'),
('102301', 'Biwa Hayahide', 'assets/images/characters/chara_stand_1023_102301.png', 90, 95, 95, 90, 110, 0, 0, 0, 10, 20, 'A', 'G', 'G', 'F', 'A', 'A', 'G', 'A', 'B', 'F'),
('102401', 'Mayano Top Gun', 'assets/images/characters/chara_stand_1024_102401.png', 95, 105, 90, 95, 90, 0, 10, 0, 10, 0, 'A', 'E', 'G', 'B', 'A', 'A', 'A', 'A', 'B', 'B'),
('102402', 'Mayano Top Gun (Alt)', 'assets/images/characters/chara_stand_1024_102402.png', 95, 100, 95, 95, 90, 0, 0, 10, 20, 0, 'A', 'E', 'G', 'B', 'A', 'A', 'A', 'A', 'B', 'B'),
('102601', 'Mihono Bourbon', 'assets/images/characters/chara_stand_1026_102601.png', 115, 90, 95, 95, 80, 0, 10, 20, 0, 0, 'A', 'G', 'G', 'B', 'A', 'G', 'A', 'B', 'G', 'G'),
('102701', 'Mejiro Ryan', 'assets/images/characters/chara_stand_1027_102701.png', 90, 100, 105, 95, 85, 0, 0, 20, 10, 0, 'A', 'G', 'G', 'G', 'A', 'B', 'F', 'A', 'A', 'F'),
('102801', 'Hishi Akebono', 'assets/images/characters/chara_stand_1028_102801.png', 95, 90, 115, 100, 70, 0, 10, 20, 0, 0, 'A', 'B', 'A', 'A', 'G', 'G', 'B', 'A', 'G', 'G'),
('103001', 'Rice Shower', 'assets/images/characters/chara_stand_1030_103001.png', 85, 115, 90, 95, 90, 0, 10, 0, 20, 0, 'A', 'G', 'G', 'G', 'A', 'A', 'F', 'A', 'B', 'G'),
('103101', 'Ines Fujin', 'assets/images/characters/chara_stand_1031_103101.png', 105, 100, 95, 90, 80, 10, 0, 0, 20, 0, 'A', 'G', 'G', 'A', 'A', 'F', 'A', 'B', 'F', 'G'),
('103201', 'Agnes Tachyon', 'assets/images/characters/chara_stand_1032_103201.png', 95, 90, 95, 90, 110, 0, 0, 0, 0, 20, 'A', 'G', 'G', 'A', 'A', 'G', 'F', 'A', 'A', 'G'),
('103301', 'Admire Vega', 'assets/images/characters/chara_stand_1033_103301.png', 100, 85, 100, 90, 95, 10, 0, 0, 0, 20, 'A', 'G', 'G', 'F', 'A', 'A', 'G', 'C', 'B', 'A'),
('103401', 'Inari One', 'assets/images/characters/chara_stand_1034_103401.png', 85, 105, 105, 110, 75, 0, 0, 15, 15, 0, 'A', 'A', 'G', 'G', 'A', 'A', 'G', 'B', 'A', 'A'),
('103601', 'Air Shakur', 'assets/images/characters/chara_stand_1036_103601.png', 90, 106, 92, 125, 137, 0, 0, 0, 10, 20, 'A', 'G', 'G', 'F', 'A', 'A', 'G', 'E', 'A', 'A'),
('103701', 'Eishin Flash', 'assets/images/characters/chara_stand_1037_103701.png', 100, 90, 95, 90, 95, 10, 0, 0, 0, 20, 'A', 'G', 'G', 'F', 'A', 'A', 'G', 'A', 'A', 'F'),
('103801', 'Curren Chan', 'assets/images/characters/chara_stand_1038_103801.png', 125, 75, 105, 95, 80, 10, 0, 20, 0, 0, 'A', 'G', 'A', 'B', 'G', 'G', 'A', 'A', 'F', 'G'),
('103802', 'Curren Chan (Wedding)', 'assets/images/characters/chara_stand_1038_103802.png', 135, 78, 116, 92, 129, 10, 0, 10, 0, 10, 'A', 'G', 'A', 'D', 'G', 'G', 'B', 'A', 'G', 'G'),
('104001', 'Gold City', 'assets/images/characters/chara_stand_1040_104001.png', 100, 95, 95, 85, 100, 0, 0, 10, 0, 20, 'A', 'G', 'G', 'A', 'A', 'C', 'F', 'B', 'A', 'E'),
('104401', 'Sweep Tosho', 'assets/images/characters/chara_stand_1044_104401.png', 113, 100, 121, 93, 123, 0, 0, 20, 0, 10, 'A', 'G', 'G', 'A', 'A', 'G', 'G', 'G', 'A', 'A'),
('104501', 'Super Creek', 'assets/images/characters/chara_stand_1045_104501.png', 85, 110, 90, 95, 95, 0, 10, 0, 0, 20, 'A', 'G', 'G', 'E', 'A', 'A', 'G', 'A', 'B', 'G'),
('104502', 'Super Creek (Alt)', 'assets/images/characters/chara_stand_1045_104502.png', 85, 115, 90, 90, 95, 0, 10, 0, 0, 20, 'A', 'G', 'G', 'E', 'A', 'A', 'G', 'A', 'B', 'G'),
('104601', 'Smart Falcon', 'assets/images/characters/chara_stand_1046_104601.png', 115, 80, 100, 95, 85, 20, 0, 10, 0, 0, 'E', 'A', 'A', 'A', 'E', 'G', 'A', 'B', 'G', 'G'),
('105001', 'Narita Taishin', 'assets/images/characters/chara_stand_1050_105001.png', 100, 80, 95, 95, 105, 0, 0, 10, 0, 20, 'A', 'G', 'G', 'D', 'A', 'B', 'G', 'F', 'B', 'A'),
('105101', 'Nishino Flower', 'assets/images/characters/chara_stand_1051_105101.png', 110, 75, 95, 90, 110, 15, 0, 0, 0, 15, 'A', 'G', 'A', 'A', 'G', 'G', 'G', 'A', 'B', 'G'),
('105202', 'Haru Urara (Alt)', 'assets/images/characters/chara_stand_1052_105202.png', 117, 85, 115, 129, 104, 0, 0, 15, 15, 0, 'G', 'A', 'A', 'B', 'G', 'G', 'G', 'G', 'A', 'A'),
('105301', 'Bamboo Memory', 'assets/images/characters/chara_stand_1053_105301.png', 95, 80, 110, 100, 85, 10, 0, 20, 0, 0, 'A', 'G', 'A', 'A', 'E', 'G', 'G', 'B', 'A', 'B'),
('105602', 'Matikanefukukitaru', 'assets/images/characters/chara_stand_1056_105602.png', 85, 100, 95, 100, 90, 0, 0, 0, 10, 20, 'A', 'G', 'G', 'F', 'A', 'A', 'G', 'B', 'A', 'C'),
('105801', 'Meisho Doto', 'assets/images/characters/chara_stand_1058_105801.png', 85, 105, 100, 95, 90, 0, 10, 10, 10, 0, 'A', 'G', 'G', 'F', 'A', 'A', 'G', 'A', 'A', 'F'),
('105902', 'Mejiro Dober', 'assets/images/characters/chara_stand_1059_105902.png', 90, 95, 95, 80, 110, 0, 0, 10, 0, 20, 'A', 'G', 'G', 'A', 'A', 'E', 'G', 'A', 'A', 'F'),
('106002', 'Nice Nature', 'assets/images/characters/chara_stand_1060_106002.png', 80, 100, 90, 105, 95, 0, 0, 0, 20, 10, 'A', 'G', 'G', 'G', 'A', 'A', 'G', 'B', 'A', 'C'),
('106102', 'King Halo', 'assets/images/characters/chara_stand_1061_106102.png', 100, 85, 100, 90, 95, 10, 0, 10, 0, 10, 'A', 'G', 'A', 'B', 'B', 'C', 'G', 'B', 'B', 'A'),
('106201', 'Matikane Tannhauser', 'assets/images/characters/chara_stand_1062_106201.png', 85, 105, 95, 100, 90, 0, 10, 0, 20, 0, 'A', 'G', 'G', 'G', 'A', 'A', 'G', 'A', 'A', 'F'),
('106401', 'Mejiro Palmer', 'assets/images/characters/chara_stand_1064_106401.png', 95, 115, 85, 110, 75, 0, 10, 0, 20, 0, 'A', 'G', 'G', 'F', 'A', 'A', 'A', 'F', 'E', 'G'),
('106701', 'Satono Diamond', 'assets/images/characters/chara_stand_1067_106701.png', 91, 135, 110, 98, 116, 0, 15, 0, 0, 15, 'A', 'G', 'G', 'F', 'A', 'A', 'G', 'E', 'A', 'F'),
('106801', 'Kitasan Black', 'assets/images/characters/chara_stand_1068_106801.png', 123, 115, 93, 115, 104, 20, 10, 0, 0, 0, 'A', 'G', 'G', 'F', 'A', 'A', 'A', 'E', 'F', 'G'),
('107201', 'Yaeno Muteki', 'assets/images/characters/chara_stand_1072_107201.png', 100, 85, 110, 90, 85, 10, 0, 20, 0, 0, 'A', 'G', 'G', 'B', 'A', 'E', 'G', 'A', 'A', 'F'),
('107401', 'Mejiro Bright', 'assets/images/characters/chara_stand_1074_107401.png', 80, 120, 90, 100, 80, 0, 10, 0, 20, 0, 'A', 'G', 'G', 'G', 'B', 'A', 'G', 'C', 'A', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `trainees`
--

CREATE TABLE `trainees` (
  `id` int(11) NOT NULL,
  `character_id` varchar(10) NOT NULL,
  `final_rank` varchar(10) DEFAULT NULL,
  `rating_score` int(11) DEFAULT NULL,
  `stat_speed` int(11) DEFAULT 0,
  `stat_stamina` int(11) DEFAULT 0,
  `stat_power` int(11) DEFAULT 0,
  `stat_guts` int(11) DEFAULT 0,
  `stat_wit` int(11) DEFAULT 0,
  `notes` text DEFAULT NULL,
  `logged_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainees`
--

INSERT INTO `trainees` (`id`, `character_id`, `final_rank`, `rating_score`, `stat_speed`, `stat_stamina`, `stat_power`, `stat_guts`, `stat_wit`, `notes`, `logged_at`) VALUES
(2, '103801', 'UG', 19897, 1353, 1002, 1273, 873, 1283, '', '2026-07-16 14:33:52'),
(3, '100402', 'A+', 14110, 1203, 628, 972, 529, 927, '', '2026-07-16 14:34:44'),
(4, '100901', 'S+', 16441, 1183, 982, 922, 672, 1193, '', '2026-07-16 14:35:55'),
(5, '103701', 'SS', 17794, 1238, 918, 1162, 829, 1189, '', '2026-07-16 14:36:28'),
(6, '101901', 'SS', 18212, 1123, 1082, 1283, 789, 1173, '', '2026-07-16 15:06:00'),
(7, '100401', 'UG', 19880, 1300, 1003, 1289, 982, 1293, '', '2026-07-16 15:08:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `characters`
--
ALTER TABLE `characters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trainees`
--
ALTER TABLE `trainees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `character_id` (`character_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `trainees`
--
ALTER TABLE `trainees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `trainees`
--
ALTER TABLE `trainees`
  ADD CONSTRAINT `trainees_ibfk_1` FOREIGN KEY (`character_id`) REFERENCES `characters` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
