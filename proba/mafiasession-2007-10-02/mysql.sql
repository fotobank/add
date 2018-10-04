-- MYSQL
CREATE TABLE `_session` (
  `id_session` int(11) NOT NULL auto_increment,
  `remote_addr` bigint(12) NOT NULL,
  `request_uri` varchar(128) NOT NULL,
  `keytime` bigint(20) NOT NULL,
  `keepalive` int(11) NOT NULL,
  PRIMARY KEY  (`id_session`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1

CREATE TABLE `login` (
`id_login` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`login` VARCHAR( 20 ) NOT NULL ,
`senhamd5` VARCHAR( 32 ) NOT NULL ,
`senhasha1` VARCHAR( 40 ) NOT NULL
) ENGINE = MYISAM DEFAULT CHARSET=latin1;

INSERT INTO login ( `login` , `senhamd5` , `senhasha1` )
VALUES ('mafiasession', MD5( 'mafiasession' ) , SHA1( 'mafiasession' )
);