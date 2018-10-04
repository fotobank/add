#
# Table structure for table `sessions`
#

CREATE TABLE sessions (
  sesskey varchar(255) default NULL,
  expiry bigint(11) unsigned NOT NULL default '0',
  user_id int(11) unsigned NOT NULL default '0'
) TYPE=MyISAM;

#
# Table structure for table `szusermgnt`
#

CREATE TABLE szusermgnt (
  pwd_remind_header varchar(100) NOT NULL default '',
  pwd_remind_body text NOT NULL,
  new_account_header varchar(100) NOT NULL default '',
  new_account_body text NOT NULL,
  mail_sender_name varchar(50) NOT NULL default '',
  mail_sender_email varchar(50) NOT NULL default ''
) TYPE=MyISAM;

#
# Dumping data for table `szusermgnt`
#

INSERT INTO szusermgnt (pwd_remind_header, pwd_remind_body, new_account_header, new_account_body, mail_sender_name, mail_sender_email) VALUES ('New Password!', 'your account:\r\nusername: [USERNAME]\r\npassword: [PASSWORD]', 'New Account!', 'your account:\r\nusername: [USERNAME]\r\npassword: [PASSWORD]', 'Admin', 'admin@admin.com');
# --------------------------------------------------------

#
# Table structure for table `user_levels`
#

CREATE TABLE `user_levels` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `level` tinyint(2) unsigned NOT NULL default '0',
  `level_name` varchar(30) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `level` (`level`,`level_name`)
) TYPE=MyISAM AUTO_INCREMENT=5 ;

#
# Dumping data for table `user_levels`
#

INSERT INTO `user_levels` VALUES (1, 1, 'Normal User');
INSERT INTO `user_levels` VALUES (2, 5, 'Power User');
INSERT INTO `user_levels` VALUES (3, 10, 'Administrator');
# --------------------------------------------------------

#
# Table structure for table `users`
#

CREATE TABLE users (
  id int(11) unsigned NOT NULL auto_increment,
  register_date bigint(14) unsigned NOT NULL default '0',
  last_logged_in bigint(14) unsigned NOT NULL default '0',
  username varchar(12) default NULL,
  password varchar(32) default NULL,
  email varchar(50) default NULL,
  level tinyint(1) unsigned NOT NULL default '1',
  active tinyint(1) unsigned NOT NULL default '1',
  PRIMARY KEY  (id),
  UNIQUE KEY email (email)
) TYPE=MyISAM;

#
# Dumping data for table `users`
#

INSERT INTO users (id, register_date, last_logged_in, username, password, email, level, active) VALUES (1, 0, 20030616164122, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@admin.com', 3, 1);
INSERT INTO users (id, register_date, last_logged_in, username, password, email, level, active) VALUES (2, 20030616131006, 0, 'standard', 'c00f0c4675b91fb8b918e4079a0b1bac', 'standard@standard.com', 2, 1);

    