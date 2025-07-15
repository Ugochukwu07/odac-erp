CREATE TABLE `pt_admin_activity_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(255) NOT NULL,
  `admin_mobile` varchar(20) NOT NULL,
  `activity_type` varchar(100) NOT NULL,
  `activity_description` text NOT NULL,
  `target_id` int(11) DEFAULT NULL,
  `target_table` varchar(100) DEFAULT NULL,
  `ip_address` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8; 