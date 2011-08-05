CREATE TABLE `fruit_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL
) ENGINE='InnoDB';

CREATE TABLE `fruit` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `fruit_type_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  FOREIGN KEY (`fruit_type_id`) REFERENCES `fruit_type` (`id`)
) ENGINE='InnoDB';