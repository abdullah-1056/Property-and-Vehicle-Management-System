drop DATABASE rent

CREATE DATABASE rent
    DEFAULT CHARACTER SET = 'utf8mb4';

    use rent;
-- Table structure for table `owner`
CREATE TABLE `owner` (
  `owner_id` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
  `nid` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone_no` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  PRIMARY KEY (`owner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `property`
CREATE TABLE `property` (
  `property_id` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
  `owner_id` int(10) UNSIGNED ZEROFILL NOT NULL,
  `rent` decimal(10,2) NOT NULL,
  `leasing_date` date NOT NULL,
  `type` varchar(255) NOT NULL,
  `location` text NOT NULL,
  PRIMARY KEY (`property_id`),
  FOREIGN KEY (`owner_id`) REFERENCES `owner`(`owner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `vehicle`
CREATE TABLE `vehicle` (
  `vehicle_id` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
  `owner_id` int(10) UNSIGNED ZEROFILL NOT NULL,
  `lic_no` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `rent` decimal(10,2) NOT NULL,
  PRIMARY KEY (`vehicle_id`),
  FOREIGN KEY (`owner_id`) REFERENCES `owner`(`owner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `customer`
CREATE TABLE `customer` (
  `cust_id` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
  `nid` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone_no` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  PRIMARY KEY (`cust_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `transaction`
CREATE TABLE `transaction` (
  `transaction_id` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `bill` decimal(10,2) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `reservation`
CREATE TABLE `reservation` (
  `reserve_id` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
  `rent_date` date NOT NULL,
  `bill` decimal(10,2) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `cust_id` int(10) UNSIGNED ZEROFILL NOT NULL,
  `owner_id` int(10) UNSIGNED ZEROFILL NOT NULL,
  `transaction_id` int(10) UNSIGNED ZEROFILL NOT NULL,
  `property_id` int(10) UNSIGNED ZEROFILL DEFAULT NULL,
  `vehicle_id` int(10) UNSIGNED ZEROFILL DEFAULT NULL,
  PRIMARY KEY (`reserve_id`),
  FOREIGN KEY (`cust_id`) REFERENCES `customer`(`cust_id`),
  FOREIGN KEY (`owner_id`) REFERENCES `owner`(`owner_id`),
  FOREIGN KEY (`transaction_id`) REFERENCES `transaction`(`transaction_id`),
  FOREIGN KEY (`property_id`) REFERENCES `property`(`property_id`),
  FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle`(`vehicle_id`),
  CHECK ((`property_id` IS NOT NULL AND `vehicle_id` IS NULL) OR 
         (`vehicle_id` IS NOT NULL AND `property_id` IS NULL))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Truncate the reservation table