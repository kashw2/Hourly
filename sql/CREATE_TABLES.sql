CREATE TABLE IF NOT EXISTS `accounts` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`username` varchar(45) NOT NULL,
`email` varchar(45) NOT NULL,
`password` varchar(45) NOT NULL,
`company` varchar(45) DEFAULT NULL,
`positionid` int(11) DEFAULT NULL,
PRIMARY KEY (`id`),
UNIQUE KEY `email_UNIQUE` (`email`),
UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `companies` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(45) NOT NULL,
`ceo` varchar(45) NOT NULL,
`liability` varchar(45) NOT NULL,
`state` varchar(45) NOT NULL,
`businessaddress` varchar(45) NOT NULL,
`parentcompany` varchar(45) DEFAULT NULL,
`registrarfirstname` varchar(45) NOT NULL,
`registrarlastname` varchar(45) NOT NULL,
`registrarcompanyposition` varchar(45) NOT NULL,
`registrarph` varchar(45) DEFAULT NULL,
`registraremail` varchar(45) NOT NULL,
`creationdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
UNIQUE KEY `id_UNIQUE` (`id`),
UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `days` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`dayname` varchar(45) DEFAULT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `leave` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`employeeid` int(11) NOT NULL,
`start` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
`end` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
`reason` varchar(45) NOT NULL,
`details` varchar(45) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `locations` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`location` varchar(45) DEFAULT NULL,
PRIMARY KEY (`id`),
UNIQUE KEY `id_UNIQUE` (`id`),
UNIQUE KEY `location_UNIQUE` (`location`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `news` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`author` varchar(45) NOT NULL,
`date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
`title` varchar(45) NOT NULL,
`content` mediumtext,
PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `positions` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`position` varchar(45) DEFAULT NULL,
`admin` tinyint(4) NOT NULL,
PRIMARY KEY (`id`),
UNIQUE KEY `position_UNIQUE` (`position`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `roster` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`employeeid` int(11) DEFAULT NULL,
`shiftid` int(11) DEFAULT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `sessions` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`userid` int(10) unsigned NOT NULL,
`token` varchar(100) NOT NULL,
PRIMARY KEY (`id`),
UNIQUE KEY `userid_UNIQUE` (`userid`),
UNIQUE KEY `token_UNIQUE` (`token`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `shifts` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`dayid` int(11) DEFAULT NULL,
`start` datetime DEFAULT CURRENT_TIMESTAMP,
`end` datetime DEFAULT CURRENT_TIMESTAMP,
`location` varchar(45) DEFAULT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
