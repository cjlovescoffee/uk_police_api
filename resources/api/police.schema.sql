DROP TABLE IF EXISTS `searches`;
DROP TABLE IF EXISTS `neighbourhoods`;
DROP TABLE IF EXISTS `forces`;
CREATE TABLE `forces` (
`id` VARCHAR(255) NOT NULL,
`name`  VARCHAR(255) NOT NULL,
PRIMARY KEY (`id`)
);
CREATE TABLE `neighbourhoods` (
`id` VARCHAR(255) NOT NULL,
`name` VARCHAR(255) NOT NULL,
`force` VARCHAR(255) NOT NULL,
`latitude` DECIMAL(10, 8) NOT NULL,
`longitude` DECIMAL(11, 8) NOT NULL,
PRIMARY KEY (`id`, `force`),
FOREIGN KEY (`force`) REFERENCES `forces`(`id`)
);
CREATE TABLE `searches` (
`id` INT NOT NULL AUTO_INCREMENT,
`force` VARCHAR(255) NOT NULL,
`type` VARCHAR(255) NOT NULL,
`involved_person` TINYINT(1) NOT NULL,
`datetime` DATETIME NOT NULL,
`latitude` DECIMAL(10, 8) NOT NULL,
`longitude` DECIMAL(11, 8) NOT NULL,
`location_id` INT NOT NULL,
`location_name` VARCHAR(255) NOT NULL,
`gender` VARCHAR(255) NOT NULL,
`age_range` VARCHAR(255) NOT NULL,
`self_defined_ethnicity` VARCHAR(255) NOT NULL,
`officer_defined_ethnicity` VARCHAR(255) NOT NULL,
`legislation` VARCHAR(255) NOT NULL,
`object_of_search` VARCHAR(255) NOT NULL,
`removal_of_more_than_outer_clothing` TINYINT(1) NOT NULL,
PRIMARY KEY (`id`),
FOREIGN KEY (`force`) REFERENCES `forces`(`id`)
);
