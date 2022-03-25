This is the version controlled api request to test. 
You can make a request to save the version name and timestamp in the database and also you can pull the version api request.

Configuration
-----
You can update the database connection and webiste url in the config.php file.

Create Database
-----
Run below query to create the database and table to store the data.

CREATE DATABASE IF NOT EXISTS `version_controlled` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `version_controlled`;

-- Dumping structure for table version_controlled.version
CREATE TABLE IF NOT EXISTS `version` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;
