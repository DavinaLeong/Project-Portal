-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.7.9 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping data for table project_portal_db.platform: 0 rows
/*!40000 ALTER TABLE `platform` DISABLE KEYS */;
INSERT IGNORE INTO `platform` (`platform_id`, `platform_name`, `platform_icon`, `platform_description`, `date_added`, `last_updated`, `platform_status`) VALUES
	(1, 'Acer Predator', 'fa-desktop', 'Main desktop computer', '2017-02-01 12:05:36', '2017-02-01 12:19:36', 'Publish'),
	(2, 'Lenovo Laptop 20378', 'fa-laptop', 'Lenovo Work Laptop', '2017-02-01 13:03:24', '2017-02-01 13:03:24', 'Publish'),
	(3, 'Surface Pro', 'fa-tablet', 'Microsoft table Surface Pro', '2017-02-01 13:14:34', '2017-02-01 13:14:34', 'Publish');
/*!40000 ALTER TABLE `platform` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
