CREATE DATABASE conference;
USE conference;

CREATE TABLE `sponsor_type` (
	`class` VARCHAR(8) NOT NULL,
	`email_limit` INT NOT NULL,
	`cost` INT NOT NULL,
	PRIMARY KEY (`class`)
);

CREATE TABLE `sponsor_company` (
	`company_name` VARCHAR(30) NOT NULL,
	`emails_sent` INT,
	`class` VARCHAR(8) NOT NULL,
	PRIMARY KEY (`company_name`),
	FOREIGN KEY (`class`) REFERENCES sponsor_type(`class`)
);

CREATE TABLE `advertisement` (
	`job_title` VARCHAR(50) NOT NULL,
	`company_name` VARCHAR(30),
	`city` VARCHAR(30),
	`province` CHAR(2),
	`pay` INT,
	PRIMARY KEY (`job_title`, `company_name`)
);

CREATE TABLE `attendee` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`fname` VARCHAR(30) NOT NULL,
	`lname` VARCHAR(30) NOT NULL,
	`price` INT,
	PRIMARY KEY (`id`)
);

CREATE TABLE `hotel_rooms` (
	`room_number` INT NOT NULL,
	`beds` INT,
	`occupants` INT,
	PRIMARY KEY (`room_number`)
);

CREATE TABLE `student` (
	`id` INT NOT NULL,
	`room_number` INT,
	PRIMARY KEY (`id`),
	FOREIGN KEY (`id`) REFERENCES attendee(`id`) ON UPDATE CASCADE,
	FOREIGN KEY (`room_number`) REFERENCES hotel_rooms(`room_number`)
);

CREATE TABLE `professional` (
	`id` INT NOT NULL,
	PRIMARY KEY (`id`),
	FOREIGN KEY (`id`) REFERENCES attendee(`id`) ON UPDATE CASCADE
);

CREATE TABLE `sponsor` (
	`id` INT NOT NULL,
	`company_name` VARCHAR(30) NOT NULL,
	PRIMARY KEY (`id`),
	FOREIGN KEY (`id`) REFERENCES attendee(`id`) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY (`company_name`) REFERENCES sponsor_company(`company_name`) ON UPDATE CASCADE ON DELETE CASCADE  
);

CREATE TABLE `session` (
	`name` VARCHAR(30),
	`room` INT NOT NULL,
	`start_time` DATETIME NOT NULL,
	`end_time` DATETIME NOT NULL,
	INDEX (`start_time`),
	PRIMARY KEY (`room`,`start_time`)
);

CREATE TABLE `is_spoken_by` (
	`speaker_id` INT NOT NULL,
	`room` INT NOT NULL,
	`start_time` DATETIME NOT NULL,
	PRIMARY KEY (`room`, `start_time`, `speaker_id`), 
	FOREIGN KEY (`speaker_id`) REFERENCES attendee(`id`) ON UPDATE CASCADE,
	FOREIGN KEY (`room`) REFERENCES session(`room`) ON UPDATE CASCADE,
	FOREIGN KEY (`start_time`) REFERENCES session(`start_time`) ON UPDATE CASCADE
);

CREATE TABLE `committee_members` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`fname` VARCHAR(30) NOT NULL,
	`lname` VARCHAR(30) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `subcommittees` (
	`name` VARCHAR(30) NOT NULL,
	`chair` INT NOT NULL,
	PRIMARY KEY (`name`), 
	FOREIGN KEY (`chair`) REFERENCES committee_members(`id`)
);

CREATE TABLE `is_committee_member_of` (
	`id` INT NOT NULL,
	`name` VARCHAR(30) NOT NULL,
	PRIMARY KEY (`id`, name), 
	FOREIGN KEY (`id`) REFERENCES committee_members(`id`),
	FOREIGN KEY (`name`) REFERENCES subcommittees(`name`)
);
