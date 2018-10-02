#
# MySQL database dump
# Created by MySQL_Backup class, ver. 1.0.0
#
# Host: localhost
# Generated: Jul 13, 2013 at 20:26
# MySQL version: 5.5.23-log
# PHP version: 5.3.10
#
# Database: `creative_ls`
#


#
# Table structure for table `accordions`
#

DROP TABLE IF EXISTS `accordions`;
CREATE TABLE `accordions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_album` int(11) NOT NULL COMMENT 'Номер альбома',
  `accordion_nm` varchar(64) NOT NULL COMMENT 'Имя кнопки',
  `collapse_numer` int(11) NOT NULL COMMENT 'Номер раздела акордеона',
  `collapse_nm` varchar(64) NOT NULL COMMENT 'Имя раздела',
  `collapse` text NOT NULL COMMENT 'Содержание раздела',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=cp1251;

#
# Dumping data for table `accordions`
#

INSERT INTO accordions VALUES ('1', '1', 'Условия и скидки!', '1', 'Заказ фотографий:', 'Фотографии, представленные в данном альбоме прошли предварительную ручную обработку и полностью подготовлены к печати в размере 13x18см 300Dpi в городских минилабах с применением стандартного профиля. Внимание! В целях экономии места на сервере и защиты контента превьюшки, представленные на странице, сильно сжаты и предназначены только для общего представления о фотографии (местность, время, кадрировка, закрытые глаза, номер кадра и т.д ). При покупке фотографии на Ваш email,указанный при регистрации, придет ссылка для скачивания файла фотографии в разрешении <code>13x18см 300Dpi</code> без <code>IP</code> - защиты и <code>водяного знака</code>. Выкупленные фотографии Вы имеете право распечатывать в любом количестве. Для использования фотографий в рекламных или коммерческих целях свяжитесь с фотографом.');
INSERT INTO accordions VALUES ('2', '1', 'Условия и скидки!', '2', 'Рейтинговая система голосования:', 'На сайте действует системе оценки фотографий посетителями. Вы можете проголосовать за понравившуюся Вам фотографию, повысив ее рейтинг. Пять лучших фотографий, набравших максимальное количество баллов, размещаются в шапке альбома на призовых местах.');
INSERT INTO accordions VALUES ('3', '1', 'Условия и скидки!', '3', 'Действующие на альбом акции и скидки:', 'Фотографии, набравшие больше 5 звездочек в рейтинге, распечатаваются для владельцев бесплатно.');
INSERT INTO accordions VALUES ('27', '670', 'Важно!', '1', 'default', '');
INSERT INTO accordions VALUES ('28', '670', 'Важно!', '2', 'default', '');
INSERT INTO accordions VALUES ('29', '670', 'Важно!', '3', 'default', '');
INSERT INTO accordions VALUES ('42', '734', 'Важно!', '2', 'default', '');
INSERT INTO accordions VALUES ('41', '734', 'Важно!', '1', 'default', '');
INSERT INTO accordions VALUES ('43', '734', 'Важно!', '3', 'default', '');
INSERT INTO accordions VALUES ('45', '736', '!-Важно-!', '1', 'default', '');
INSERT INTO accordions VALUES ('46', '736', '!-Важно-!', '2', 'default', '');
INSERT INTO accordions VALUES ('47', '736', '!-Важно-!', '3', 'default', '');
INSERT INTO accordions VALUES ('48', '737', 'Условия и скидки!', '1', 'default', '');
INSERT INTO accordions VALUES ('49', '737', 'Условия и скидки!', '2', 'default', '');
INSERT INTO accordions VALUES ('50', '737', 'Условия и скидки!', '3', 'default', '');


#
# Table structure for table `account_inv`
#

DROP TABLE IF EXISTS `account_inv`;
CREATE TABLE `account_inv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL COMMENT 'Номер пользователя',
  `merchant_id` varchar(64) NOT NULL COMMENT ' id мерчанта',
  `amount` float(8,2) NOT NULL DEFAULT '0.00' COMMENT 'Сумма пополнения',
  `sys` enum('card','liqpay','easypay') NOT NULL DEFAULT 'card' COMMENT 'Система оплаты',
  `currency` varchar(64) NOT NULL COMMENT 'Валюта',
  `description` varchar(512) NOT NULL COMMENT 'Описание',
  `status` varchar(64) NOT NULL COMMENT 'статус транзакции',
  `code` varchar(64) NOT NULL COMMENT 'код ошибки (если есть ошибка)',
  `transaction_id` varchar(64) NOT NULL COMMENT 'id транзакции в системе LiqPay',
  `pay_way` varchar(64) NOT NULL COMMENT 'способ которым оплатит покупатель(если не указывать то он сам выбирает, с карты или с телефона(liqpay, card))',
  `sender_phone` varchar(64) NOT NULL COMMENT 'телефон оплативший заказ',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=107 DEFAULT CHARSET=cp1251 COMMENT='Пополнение счета на сайте';

#
# Dumping data for table `account_inv`
#

INSERT INTO account_inv VALUES ('100', '29', 'i3213059147', '0.02', 'liqpay', 'UAH', 'photo', 'failure', '', '26627060', 'card', '+380949477070');
INSERT INTO account_inv VALUES ('101', '29', 'i3213059147', '0.02', 'liqpay', 'UAH', 'photo', 'failure', '', '26627080', 'card', '+380949477070');
INSERT INTO account_inv VALUES ('102', '29', 'i3213059147', '1.00', 'liqpay', 'UAH', 'photo', 'failure', '', '26627163', 'card', '+380949477070');
INSERT INTO account_inv VALUES ('105', '29', '', '0.00', 'card', '', '', 'failure', '', '', '', '');
INSERT INTO account_inv VALUES ('106', '29', '', '0.00', 'card', '', '', '', '', '', '', '');


#
# Table structure for table `actions`
#

DROP TABLE IF EXISTS `actions`;
CREATE TABLE `actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL COMMENT 'Номер пользователя',
  `ip` varchar(64) NOT NULL COMMENT 'Ip последнего захода',
  `brauzer` varchar(256) NOT NULL COMMENT 'браузер пользователя',
  `user_event` enum('вход','выход','подписка','отписка','покупка фотографий','сообщение в контакте','сообщение в гостевой','пополнение счета') NOT NULL COMMENT 'Событие юзера (подписка,отписка, покупка фотографий,сообщение в контакте,сообщение в гостевой)',
  `time_event` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Время  события',
  `id_album` int(11) NOT NULL COMMENT 'Номер альбома',
  `id_subs` int(11) NOT NULL COMMENT 'id акции',
  `id_account_inv` int(11) NOT NULL COMMENT 'id пополнения счета',
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  KEY `time_event` (`time_event`),
  KEY `user_event` (`user_event`,`id_album`),
  KEY `id_subs` (`id_subs`),
  KEY `id_account_inv` (`id_account_inv`)
) ENGINE=MyISAM AUTO_INCREMENT=225 DEFAULT CHARSET=cp1251 COMMENT='действия пользователей';

#
# Dumping data for table `actions`
#

INSERT INTO actions VALUES ('149', '29', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36', 'пополнение счета', '2013-06-10 23:43:45', '0', '0', '100');
INSERT INTO actions VALUES ('168', '29', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36', 'пополнение счета', '2013-06-10 23:54:12', '0', '0', '102');
INSERT INTO actions VALUES ('169', '29', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:21.0) Gecko/20100101 Firefox/21.0', 'вход', '2013-06-10 23:56:08', '0', '0', '0');
INSERT INTO actions VALUES ('170', '29', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:21.0) Gecko/20100101 Firefox/21.0', 'пополнение счета', '2013-06-10 23:56:11', '0', '0', '103');
INSERT INTO actions VALUES ('167', '29', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36', 'пополнение счета', '2013-06-10 23:46:24', '0', '0', '101');
INSERT INTO actions VALUES ('171', '29', '79.140.10.148', 'Mozilla/5.0 (Windows NT 6.1; rv:21.0) Gecko/20100101 Firefox/21.0', 'вход', '2013-06-11 02:09:12', '0', '0', '0');
INSERT INTO actions VALUES ('172', '29', '79.140.10.148', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36', 'вход', '2013-06-11 02:34:07', '0', '0', '0');
INSERT INTO actions VALUES ('173', '29', '79.140.10.148', 'Mozilla/5.0 (Windows NT 6.1; rv:21.0) Gecko/20100101 Firefox/21.0', 'пополнение счета', '2013-06-11 03:47:28', '0', '0', '106');
INSERT INTO actions VALUES ('174', '29', '79.140.10.148', '', 'выход', '2013-06-11 03:49:00', '0', '0', '0');
INSERT INTO actions VALUES ('175', '29', '79.140.10.148', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36', 'вход', '2013-06-11 03:51:17', '0', '0', '0');
INSERT INTO actions VALUES ('176', '29', '37.203.24.160', 'Mozilla/5.0 (Windows NT 6.1; rv:21.0) Gecko/20100101 Firefox/21.0', 'вход', '2013-06-11 21:54:55', '0', '0', '0');
INSERT INTO actions VALUES ('177', '29', '37.203.24.160', 'Mozilla/5.0 (Windows NT 6.1; rv:21.0) Gecko/20100101 Firefox/21.0', 'подписка', '2013-06-11 22:32:08', '670', '0', '0');
INSERT INTO actions VALUES ('178', '29', '37.203.24.160', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36', 'вход', '2013-06-12 15:31:29', '0', '0', '0');
INSERT INTO actions VALUES ('179', '29', '37.203.24.160', 'Mozilla/5.0 (Windows NT 6.1; rv:21.0) Gecko/20100101 Firefox/21.0', 'подписка', '2013-06-12 23:17:46', '732', '0', '0');
INSERT INTO actions VALUES ('180', '29', '37.203.24.160', 'Opera/9.80 (Windows NT 6.1) Presto/2.12.388 Version/12.15', 'вход', '2013-06-13 12:01:09', '0', '0', '0');
INSERT INTO actions VALUES ('181', '29', '37.203.24.160', 'Mozilla/5.0 (Windows NT 6.1; rv:21.0) Gecko/20100101 Firefox/21.0', 'вход', '2013-06-13 12:03:00', '0', '0', '0');
INSERT INTO actions VALUES ('182', '29', '37.203.24.160', '', 'выход', '2013-06-13 12:05:58', '0', '0', '0');
INSERT INTO actions VALUES ('183', '53', '92.113.82.66', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36', 'вход', '2013-06-13 22:04:16', '0', '0', '0');
INSERT INTO actions VALUES ('184', '49', '178.92.104.6', 'Mozilla/5.0 (Windows NT 5.1; rv:21.0) Gecko/20100101 Firefox/21.0', 'вход', '2013-06-15 22:05:59', '0', '0', '0');
INSERT INTO actions VALUES ('185', '49', '94.179.117.44', 'Mozilla/5.0 (Windows NT 5.1; rv:21.0) Gecko/20100101 Firefox/21.0', 'вход', '2013-06-17 15:15:12', '0', '0', '0');
INSERT INTO actions VALUES ('186', '45', '37.54.81.126', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:21.0) Gecko/20100101 Firefox/21.0', 'вход', '2013-06-17 16:54:56', '0', '0', '0');
INSERT INTO actions VALUES ('187', '49', '94.179.117.44', 'Mozilla/5.0 (Windows NT 5.1; rv:21.0) Gecko/20100101 Firefox/21.0', 'вход', '2013-06-18 13:38:30', '0', '0', '0');
INSERT INTO actions VALUES ('188', '29', '188.115.131.173', 'Mozilla/5.0 (Windows NT 6.1; rv:21.0) Gecko/20100101 Firefox/21.0', 'вход', '2013-06-21 04:03:33', '0', '0', '0');
INSERT INTO actions VALUES ('189', '29', '188.115.131.173', 'Mozilla/5.0 (Windows NT 6.1; rv:21.0) Gecko/20100101 Firefox/21.0', 'вход', '2013-06-21 04:07:02', '0', '0', '0');
INSERT INTO actions VALUES ('190', '29', '188.115.131.173', 'Mozilla/5.0 (Windows NT 6.1; rv:21.0) Gecko/20100101 Firefox/21.0', 'вход', '2013-06-21 04:13:05', '0', '0', '0');
INSERT INTO actions VALUES ('191', '29', '188.115.131.173', '', 'выход', '2013-06-21 04:19:35', '0', '0', '0');
INSERT INTO actions VALUES ('192', '29', '212.178.14.221', 'Mozilla/5.0 (Windows NT 6.1; rv:21.0) Gecko/20100101 Firefox/21.0', 'вход', '2013-06-26 22:00:50', '0', '0', '0');
INSERT INTO actions VALUES ('193', '29', '212.178.6.15', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:21.0) Gecko/20100101 Firefox/21.0', 'вход', '2013-06-30 20:02:28', '0', '0', '0');
INSERT INTO actions VALUES ('194', '29', '212.178.6.15', '', 'выход', '2013-06-30 20:07:09', '0', '0', '0');
INSERT INTO actions VALUES ('195', '29', '212.178.6.15', 'Mozilla/5.0 (Windows NT 6.1; rv:22.0) Gecko/20100101 Firefox/22.0', 'вход', '2013-06-30 22:08:16', '0', '0', '0');
INSERT INTO actions VALUES ('196', '29', '212.178.6.15', 'Mozilla/5.0 (Windows NT 6.1; rv:22.0) Gecko/20100101 Firefox/22.0', 'вход', '2013-07-01 15:45:49', '0', '0', '0');
INSERT INTO actions VALUES ('197', '29', '130.0.47.26', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36', 'вход', '2013-07-03 18:39:43', '0', '0', '0');
INSERT INTO actions VALUES ('198', '49', '94.179.205.242', 'Mozilla/5.0 (Windows NT 5.1; rv:22.0) Gecko/20100101 Firefox/22.0', 'вход', '2013-07-06 08:16:39', '0', '0', '0');
INSERT INTO actions VALUES ('199', '29', '188.115.129.226', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36', 'вход', '2013-07-08 11:38:21', '0', '0', '0');
INSERT INTO actions VALUES ('200', '29', '188.115.129.226', '', 'выход', '2013-07-08 11:38:39', '0', '0', '0');
INSERT INTO actions VALUES ('201', '29', '188.115.129.226', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36', 'вход', '2013-07-09 06:44:01', '0', '0', '0');
INSERT INTO actions VALUES ('202', '29', '31.31.110.209', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:22.0) Gecko/20100101 Firefox/22.0', 'вход', '2013-07-10 19:58:11', '0', '0', '0');
INSERT INTO actions VALUES ('203', '29', '31.31.110.209', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:22.0) Gecko/20100101 Firefox/22.0', 'вход', '2013-07-11 09:48:05', '0', '0', '0');
INSERT INTO actions VALUES ('204', '29', '31.31.110.209', '', 'выход', '2013-07-11 09:49:20', '0', '0', '0');
INSERT INTO actions VALUES ('205', '60', '31.31.110.209', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:22.0) Gecko/20100101 Firefox/22.0', 'вход', '2013-07-11 10:25:39', '0', '0', '0');
INSERT INTO actions VALUES ('206', '60', '31.31.110.209', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36', 'вход', '2013-07-11 10:34:06', '0', '0', '0');
INSERT INTO actions VALUES ('207', '60', '31.31.110.209', '', 'выход', '2013-07-11 10:36:30', '0', '0', '0');
INSERT INTO actions VALUES ('208', '60', '31.31.110.209', '', 'выход', '2013-07-11 11:02:46', '0', '0', '0');
INSERT INTO actions VALUES ('209', '29', '31.31.110.209', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:22.0) Gecko/20100101 Firefox/22.0', 'вход', '2013-07-11 12:08:07', '0', '0', '0');
INSERT INTO actions VALUES ('210', '29', '31.31.110.209', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36', 'вход', '2013-07-11 18:07:17', '0', '0', '0');
INSERT INTO actions VALUES ('211', '29', '31.31.110.209', '', 'выход', '2013-07-11 18:34:55', '0', '0', '0');
INSERT INTO actions VALUES ('212', '29', '31.31.110.209', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36', 'вход', '2013-07-11 18:35:06', '0', '0', '0');
INSERT INTO actions VALUES ('213', '29', '31.31.110.209', '', 'выход', '2013-07-11 22:41:03', '0', '0', '0');
INSERT INTO actions VALUES ('214', '60', '31.31.110.209', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36', 'вход', '2013-07-11 22:41:14', '0', '0', '0');
INSERT INTO actions VALUES ('215', '60', '31.31.110.209', '', 'выход', '2013-07-11 22:41:56', '0', '0', '0');
INSERT INTO actions VALUES ('216', '29', '31.31.110.209', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36', 'вход', '2013-07-11 22:42:16', '0', '0', '0');
INSERT INTO actions VALUES ('217', '29', '31.31.110.209', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:22.0) Gecko/20100101 Firefox/22.0', 'вход', '2013-07-11 23:21:28', '0', '0', '0');
INSERT INTO actions VALUES ('218', '29', '31.31.110.209', '', 'выход', '2013-07-12 00:07:06', '0', '0', '0');
INSERT INTO actions VALUES ('219', '29', '31.31.110.209', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36', 'вход', '2013-07-12 00:39:46', '0', '0', '0');
INSERT INTO actions VALUES ('220', '29', '31.31.110.209', '', 'выход', '2013-07-12 02:32:16', '0', '0', '0');
INSERT INTO actions VALUES ('221', '29', '31.31.110.209', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36', 'вход', '2013-07-12 02:32:59', '0', '0', '0');
INSERT INTO actions VALUES ('222', '29', '31.31.110.209', '', 'выход', '2013-07-12 02:33:42', '0', '0', '0');
INSERT INTO actions VALUES ('223', '29', '31.31.110.209', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36', 'вход', '2013-07-12 02:40:41', '0', '0', '0');
INSERT INTO actions VALUES ('224', '29', '31.31.110.209', '', 'выход', '2013-07-12 02:40:48', '0', '0', '0');


#
# Table structure for table `albums`
#

DROP TABLE IF EXISTS `albums`;
CREATE TABLE `albums` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_category` int(11) NOT NULL DEFAULT '1' COMMENT 'К какой категории относится',
  `on_off` enum('on','off') NOT NULL DEFAULT 'off' COMMENT 'включить показ  альбома',
  `event` enum('on','off') NOT NULL DEFAULT 'off' COMMENT 'Событие заливки альбома на сайт (включить показ фотографий в альбоме)',
  `nm` varchar(64) NOT NULL DEFAULT '' COMMENT 'Имя альбома',
  `img` varchar(64) NOT NULL DEFAULT '' COMMENT 'Картинка заголовка альбома',
  `order_field` int(11) NOT NULL DEFAULT '0' COMMENT 'Порядковый номер  альбома ',
  `descr` varchar(512) NOT NULL COMMENT 'Текст слева под альбомом',
  `price` float(8,2) NOT NULL DEFAULT '10.00' COMMENT 'Цена файла фотографии',
  `pass` varchar(64) NOT NULL DEFAULT '' COMMENT 'Пароль на альбом',
  `ftp_folder` varchar(64) NOT NULL DEFAULT '/fotoarhiv/' COMMENT 'Папка альбома на FTP',
  `quality` int(11) NOT NULL DEFAULT '80' COMMENT 'Качество jpg',
  `foto_folder` varchar(64) NOT NULL DEFAULT '/images2/' COMMENT 'Рабочая папка на сервере',
  `watermark` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Водяной знак',
  `ip_marker` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Ip защита',
  `sharping` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Резкость',
  `vote_price` float(8,2) NOT NULL DEFAULT '0.01' COMMENT 'Цена голосования',
  `vote_time` int(10) NOT NULL DEFAULT '60' COMMENT 'время между голосованием',
  `vote_time_on` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'включить временное голосование',
  `pecat_A4` float(8,2) NOT NULL DEFAULT '30.00' COMMENT 'Цена A4',
  `pecat` float(8,2) NOT NULL DEFAULT '2.00' COMMENT 'Цена 13x18 и 9x12',
  PRIMARY KEY (`id`),
  KEY `ind1` (`id_category`)
) ENGINE=MyISAM AUTO_INCREMENT=738 DEFAULT CHARSET=cp1251;

#
# Dumping data for table `albums`
#

INSERT INTO albums VALUES ('670', '3', 'on', 'off', 'День рождения 08.06.13', 'id670.jpg', '725', '																																																																																																																																																																																																										', '10.00', '', '/fotoarhiv/svadba/02/', '80', '/images2/', '0', '0', '0', '0.27', '60', '1', '40.00', '12.00');
INSERT INTO albums VALUES ('736', '3', 'on', 'on', 'День рождения 18.05.13', 'id736.jpg', '736', 'День рождения 18.05.13', '8.15', '', '/fotoarhiv/deti/18.05.2013/', '80', '/images2/', '1', '0', '1', '0.01', '60', '1', '40.00', '10.00');
INSERT INTO albums VALUES ('734', '7', 'on', 'on', 'Кубок Яковенко 2013/1', 'id734.jpg', '734', 'Гости Одессы', '10.00', '', '/fotoarhiv/gimnastika/Jakovenko2013gosti/', '80', '/images2/', '1', '0', '1', '0.10', '60', '0', '40.00', '12.00');
INSERT INTO albums VALUES ('737', '7', 'on', 'on', 'Кубок Яковенко 2013/2', 'id737.jpg', '737', '', '10.00', '', '/fotoarhiv/gimnastika/Jakovenko2013/', '80', '/images2/', '1', '1', '0', '0.10', '60', '0', '40.00', '12.00');


#
# Table structure for table `categories`
#

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_num` int(11) NOT NULL DEFAULT '0',
  `nm` varchar(64) NOT NULL,
  `txt` text NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `txt` (`txt`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=cp1251;

#
# Dumping data for table `categories`
#

INSERT INTO categories VALUES ('7', '7', 'Художественная гимнастика', '');
INSERT INTO categories VALUES ('2', '2', 'Юбилеи', '');
INSERT INTO categories VALUES ('4', '4', 'Школы', '');
INSERT INTO categories VALUES ('5', '5', 'Детсад №135', '');
INSERT INTO categories VALUES ('6', '6', 'Детсад №224', '');
INSERT INTO categories VALUES ('3', '3', 'Дети', '');
INSERT INTO categories VALUES ('1', '1', 'Свадьбы', '');


#
# Table structure for table `content`
#

DROP TABLE IF EXISTS `content`;
CREATE TABLE `content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `txt` text NOT NULL COMMENT 'Содержание',
  `namecont` varchar(32) NOT NULL COMMENT 'Заголовок контента страниц',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=cp1251;

#
# Dumping data for table `content`
#

INSERT INTO content VALUES ('1', '', '1.Главная');
INSERT INTO content VALUES ('2', '<br><br><br>   

<p>\"Покупайте лотереи сберегательного банка!... А не будут брать - отключим газ!\"</p>


<!--

<style type=\"text/css\">

body
{
   
   margin: 0;
   background-color: #110011;
   color: #DCDCDC;
}
</style>
<style type=\"text/css\">

h5
{
   font-family: Arial;
   font-size: 19px;
   font-weight: normal;
   font-style: normal;
   text-decoration: none;
   color: #000000;
   margin: 0 0 0 0;
   padding: 0 0 0 0;
   display: inline;
}
</style>

<style type=\"text/css\">
#Table1
{
   border: 0px #C0C0C0 none;
   background-color: transparent;
   border-spacing: 0px;
}
#Table1 td
{
   padding: 0px 0px 0px 0px;
}
#Table1 td div
{
   white-space: nowrap;
}
#Table2
{
   border: 0px #C0C0C0 none;
   background-color: #FFA500;
   border-spacing: 1px;
}
#Table2 td
{
   padding: 3px 3px 3px 3px;
}
#Table2 td div
{
   white-space: nowrap;
}
#Table4
{
   border: 0px #C0C0C0 none;
   background-color: #FFA500;
   border-spacing: 1px;
}
#Table4 td
{
   padding: 3px 3px 3px 3px;
}
#Table4 td div
{
   white-space: nowrap;
}
#Table5
{
   border: 0px #C0C0C0 none;
   background-color: #FFA500;
   border-spacing: 0px;
}
#Table5 td
{
   padding: 6px 6px 6px 6px;
}
#Table5 td div
{
   white-space: nowrap;
}
#Table6
{
   border: 0px #C0C0C0 none;
   background-color: #FFA500;
   border-spacing: 1px;
}
#Table6 td
{
   padding: 3px 3px 3px 3px;
}
#Table6 td div
{
   white-space: nowrap;
}
#Table3
{
   border: 1px #C0C0C0 dotted;
   background-color: #FFA500;
   border-spacing: 0px;
}
#Table3 td
{
   padding: 0px 0px 0px 0px;
}
#Table3 td div
{
   white-space: nowrap;
}
</style>


<body>
<div id=\"container\">
<table style=\"position:absolute;left:234px;top:125px;width:736px;height:902px;z-index:0;\" cellpadding=\"0\" cellspacing=\"0\" id=\"Table1\">
<tr>
<td colspan=\"2\" style=\"background-color:transparent;text-align:center;vertical-align:middle;height:26px;\">
<div><span style=\"color:#F5F5F5;font-family:Arial;font-size:21px;\">Прайс-лист по фотосъемке:</span></div>
</td>
</tr>
<tr>
<td colspan=\"2\" style=\"background-color:transparent;text-align:center;vertical-align:middle;height:24px;\">
<div><span style=\"color:#FF4500;font-family:Arial;font-size:15px;\"><strong>Акция - при заказе фото и видео СКИДКА 400гр.   на съемку свадьбы в Воскресенье </strong></span></div>
</td>
</tr>
<tr>
<td style=\"background-color:#FFD700;text-align:center;vertical-align:middle;width:586px;height:28px;\">
<div><h5>Услуги</h5><span style=\"color:#000000;font-family:Arial;font-size:19px;\"><strong>  </strong></span><span style=\"color:#000000;font-family:Arial;font-size:13px;\"><strong>( желтым цветом выделенны различия)</strong></span></div>
</td>
<td style=\"background-color:#FFD700;text-align:center;vertical-align:middle;height:28px;\">
<div><h5>Стоимость</h5></div>
</td>
</tr>
<tr>
<td style=\"background-color:transparent;text-align:left;vertical-align:middle;width:586px;height:248px;\">
<div><span style=\"color:#F5F5F5;font-family:Arial;font-size:16px;\"><strong><br></strong></span></div>
<div><span style=\"color:#F5F5F5;font-family:Arial;font-size:16px;\"><strong>                                           Пакет услуг \"</strong></span><span style=\"color:#00FF7F;font-family:Arial;font-size:21px;\"><em>Стандарт</em></span><span style=\"color:#F5F5F5;font-family:Arial;font-size:16px;\"><strong>\"</strong></span></div>
<div><span style=\"color:#F5F5F5;font-family:Arial;font-size:15px;\">- репортажная и постановочная съемка свадьбы в RAW формате</span></div>
<div><span style=\"color:#F5F5F5;font-family:Arial;font-size:15px;\">  ( до тортика, но не позже 24.00 )</span></div>
<div><span style=\"color:#F5F5F5;font-family:Arial;font-size:15px;\">- обработка фотографий ( цвет, кадрировка )</span></div>
<div><span style=\"color:#F5F5F5;font-family:Arial;font-size:15px;\">- ретущь выбранных заказчиком фотографий  -  8 гр. каждая</span></div>
<div><span style=\"color:#F5F5F5;font-family:Arial;font-size:15px;\">- печать контролек  на листах А4 -  беспатно,  в  виде фотокниги  + 400 гр.</span></div>
<div><span style=\"color:#F5F5F5;font-family:Arial;font-size:15px;\">- 8 гр. за фото в услугах фотобанка в течении  6 месяцев</span></div>
<div><span style=\"color:#F5F5F5;font-family:Arial;font-size:15px;\">- запись на диск при 80% заказе от отснятого количества фотографий</span></div>
<div><span style=\"color:#F5F5F5;font-family:Arial;font-size:15px;\">- минимальный заказ ~ 350-500 фотографий - свадьба 35-70 человек </span></div>
<div><span style=\"color:#F5F5F5;font-family:Arial;font-size:15px;\">   (зависит от количества гостей)</span></div>
<div><span style=\"color:#F5F5F5;font-family:Arial;font-size:15px;\">- скидка на ФОТОКНИГУ - 200 гр.</span></div>
</td>
<td style=\"background-color:transparent;text-align:center;vertical-align:middle;height:248px;\">
<div><span style=\"color:#F5F5F5;font-family:Arial;font-size:13px;\"><strong> 800 Гр. + 8 Гр.</strong></span></div>
<div><span style=\"color:#F5F5F5;font-family:Arial;font-size:13px;\"><strong>каждая фотография</strong></span></div>
</td>
</tr>
<tr>
<td style=\"background-color:transparent;text-align:left;vertical-align:top;width:586px;height:180px;\">
<div><span style=\"color:#F5F5F5;font-family:Arial;font-size:17px;\"><strong>                                   </strong></span></div>
<div><span style=\"color:#F5F5F5;font-family:Arial;font-size:17px;\"><strong>                                   Пакет услуг \"</strong></span><span style=\"color:#00FF7F;font-family:Arial;font-size:21px;\"><em>Диск-mini</em></span><span style=\"color:#F5F5F5;font-family:Arial;font-size:17px;\"><strong>\"</strong></span></div>
<div><span style=\"color:#F5F5F5;font-family:Arial;font-size:15px;\">- постановочная и репортажная съемка  в RAW формате свадебной прогулки</span></div>
<div><span style=\"color:#F5F5F5;font-family:Arial;font-size:15px;\">   ( до 3х часов )</span></div>
<div><span style=\"color:#F5F5F5;font-family:Arial;font-size:15px;\">- обработка фотографий ( цвет и кадрировка  ) и подготовка к печати</span></div>
<div><span style=\"color:#F5F5F5;font-family:Arial;font-size:15px;\">- запись на диск + оформление обложки</span></div>
<div><span style=\"color:#F5F5F5;font-family:Arial;font-size:15px;\">- 4 гр. за фото  услуги фотобанка  в течении  1 месяца  после выполнения работы</span></div>
<div><span style=\"color:#F5F5F5;font-family:Arial;font-size:15px;\">- скидка на ФОТОКНИГУ - 150 гр.</span></div>
</td>
<td style=\"background-color:transparent;text-align:center;vertical-align:middle;height:180px;\">
<div><span style=\"color:#F5F5F5;font-family:Arial;font-size:13px;\"><strong> 2 400 гр.</strong></span></div>
</td>
</tr>
<tr>
<td style=\"background-color:transparent;text-align:left;vertical-align:top;width:586px;height:66px;\">
<div><span style=\"color:#F5F5F5;font-family:Arial;font-size:17px;\"><strong>                                   Пакет услуг \"</strong></span><span style=\"color:#00FF7F;font-family:Arial;font-size:21px;\"><em>Диск-mini</em></span><span style=\"color:#F5F5F5;font-family:Arial;font-size:17px;\"><strong>\"</strong></span></div>
</td>
<td style=\"background-color:transparent;text-align:left;vertical-align:top;height:66px;\">
<div><span style=\"color:#000000;font-family:Arial;font-size:13px;\"> </span></div>
</td>
</tr>
<tr>
<td style=\"background-color:transparent;text-align:left;vertical-align:top;width:586px;height:66px;\">
<div><span style=\"color:#000000;font-family:Arial;font-size:13px;\"> </span><span style=\"color:#F5F5F5;font-family:Arial;font-size:17px;\"><strong>                                   Пакет услуг \"</strong></span><span style=\"color:#00FF7F;font-family:Arial;font-size:21px;\"><em>Диск-mini</em></span><span style=\"color:#F5F5F5;font-family:Arial;font-size:17px;\"><strong>\"</strong></spa
n></div>
</td>
<td style=\"background-color:transparent;text-align:left;vertical-align:top;height:66px;\">
<div><span style=\"color:#000000;font-family:Arial;font-size:13px;\"> </span></div>
</td>
</tr>
<tr>
<td style=\"background-color:transparent;text-align:left;vertical-align:top;width:586px;height:66px;\">
<div><span style=\"color:#000000;font-family:Arial;font-size:13px;\"> </span><span style=\"color:#F5F5F5;font-family:Arial;font-size:17px;\"><strong>                                   Пакет услуг \"</strong></span><span style=\"color:#00FF7F;font-family:Arial;font-size:21px;\"><em>Диск-mini</em></span><span style=\"color:#F5F5F5;font-family:Arial;font-size:17px;\"><strong>\"</strong></spa
n></div>
</td>
<td style=\"background-color:transparent;text-align:left;vertical-align:top;height:66px;\">
<div><span style=\"color:#000000;font-family:Arial;font-size:13px;\"> </span></div>
</td>
</tr>
<tr>
<td style=\"background-color:transparent;text-align:left;vertical-align:top;width:586px;height:66px;\">
<div><span style=\"color:#000000;font-family:Arial;font-size:13px;\"> </span><span style=\"color:#F5F5F5;font-family:Arial;font-size:17px;\"><strong>                                   Пакет услуг \"</strong></span><span style=\"color:#00FF7F;font-family:Arial;font-size:21px;\"><em>Диск-mini</em></span><span style=\"color:#F5F5F5;font-family:Arial;font-size:17px;\"><strong>\"</strong></spa
n></div>
</td>
<td style=\"background-color:transparent;text-align:left;vertical-align:top;height:66px;\">
<div><span style=\"color:#000000;font-family:Arial;font-size:13px;\"> </span></div>
</td>
</tr>
<tr>
<td style=\"background-color:transparent;text-align:left;vertical-align:top;width:586px;height:66px;\">
<div><span style=\"color:#000000;font-family:Arial;font-size:13px;\"> </span><span style=\"color:#F5F5F5;font-family:Arial;font-size:17px;\"><strong>                                   Пакет услуг \"</strong></span><span style=\"color:#00FF7F;font-family:Arial;font-size:21px;\"><em>Диск-mini</em></span><span style=\"color:#F5F5F5;font-family:Arial;font-size:17px;\"><strong>\"</strong></spa
n></div>
</td>
<td style=\"background-color:transparent;text-align:left;vertical-align:top;height:66px;\">
<div><span style=\"color:#000000;font-family:Arial;font-size:13px;\"> </span></div>
</td>
</tr>
<tr>
<td style=\"background-color:transparent;text-align:left;vertical-align:top;width:586px;height:66px;\">
<div><span style=\"color:#000000;font-family:Arial;font-size:13px;\"> </span><span style=\"color:#F5F5F5;font-family:Arial;font-size:17px;\"><strong>                                   Пакет услуг \"</strong></span><span style=\"color:#00FF7F;font-family:Arial;font-size:21px;\"><em>Диск-mini</em></span><span style=\"color:#F5F5F5;font-family:Arial;font-size:17px;\"><strong>\"</strong></spa
n></div>
</td>
<td style=\"background-color:transparent;text-align:left;vertical-align:top;height:66px;\">
<div><span style=\"color:#000000;font-family:Arial;font-size:13px;\"> </span></div>
</td>
</tr>
</table>
<table style=\"position:absolute;left:32px;top:127px;width:176px;height:207px;z-index:1;\" cellpadding=\"3\" cellspacing=\"1\" id=\"Table2\">
<tr>
<td style=\"background-color:transparent;text-align:center;vertical-align:middle;height:38px;\">
<div><span style=\"color:#000000;font-family:Arial;font-size:13px;letter-spacing:0px;\"><strong>ПРАЙС - ЛИСТЫ</strong></span></div>
</td>
</tr>
<tr>
<td style=\"background-color:#000040;text-align:left;vertical-align:top;height:154px;\">
<div><span style=\"color:#F5F5F5;font-family:Arial;font-size:13px;\"><br></span></div>
<div><span style=\"color:#FFD700;font-family:Arial;font-size:13px;\">></span><span style=\"color:#F5F5F5;font-family:Arial;font-size:13px;\"> </span><span style=\"color:#FFD700;font-family:Arial;font-size:13px;\"><a href=\"#\" onmouseup=\"ShowObject(\'Table1\', 0);return false;\" onblur=\"ShowObject(\'Table2\', 1);return false;\">sdffsdfsdf</a></span></div>
<div><span style=\"color:#FFD700;font-family:Arial;font-size:13px;\">></span><span style=\"color:#F5F5F5;font-family:Arial;font-size:13px;\"> <a href=\"#\" onmouseup=\"ShowObject(\'Table1\', 1);return false;\">sdfsdfsdfs</a></span></div>
<div><span style=\"color:#FFD700;font-family:Arial;font-size:13px;\">></span><span style=\"color:#F5F5F5;font-family:Arial;font-size:13px;\"> sdfsdfsdf</span></div>
<div><span style=\"color:#FFD700;font-family:Arial;font-size:13px;\">></span><span style=\"color:#F5F5F5;font-family:Arial;font-size:13px;\"> sdfsddfs</span></div>
</td>
</tr>
</table>
<table style=\"position:absolute;left:1001px;top:127px;width:176px;height:207px;z-index:2;\" cellpadding=\"3\" cellspacing=\"1\" id=\"Table4\">
<tr>
<td style=\"background-color:transparent;text-align:center;vertical-align:middle;height:38px;\">
<div><span style=\"color:#000000;font-family:Arial;font-size:13px;letter-spacing:0px;\"><strong>ПРАЙС - ЛИСТЫ</strong></span></div>
</td>
</tr>
<tr>
<td style=\"background-color:#000040;text-align:left;vertical-align:top;height:154px;\">
<div><span style=\"color:#F5F5F5;font-family:Arial;font-size:13px;\"><br></span></div>
<div><span style=\"color:#FFD700;font-family:Arial;font-size:13px;\">></span><span style=\"color:#F5F5F5;font-family:Arial;font-size:13px;\"> </span><span style=\"color:#FFD700;font-family:Arial;font-size:13px;\"><a href=\"#\" onmouseup=\"ShowObject(\'Table1\', 0);return false;\" onblur=\"ShowObject(\'Table2\', 1);return false;\">sdffsdfsdf</a></span></div>
<div><span style=\"color:#FFD700;font-family:Arial;font-size:13px;\">></span><span style=\"color:#F5F5F5;font-family:Arial;font-size:13px;\"> <a href=\"#\" onmouseup=\"ShowObject(\'Table1\', 1);return false;\">sdfsdfsdfs</a></span></div>
<div><span style=\"color:#FFD700;font-family:Arial;font-size:13px;\">></span><span style=\"color:#F5F5F5;font-family:Arial;font-size:13px;\"> sdfsdfsdf</span></div>
<div><span style=\"color:#FFD700;font-family:Arial;font-size:13px;\">></span><span style=\"color:#F5F5F5;font-family:Arial;font-size:13px;\"> sdfsddfs</span></div>
</td>
</tr>
</table>
<table style=\"position:absolute;left:22px;top:127px;width:196px;height:290px;z-index:3;\" cellpadding=\"6\" cellspacing=\"0\" id=\"Table5\">
<tr>
<td style=\"background-color:transparent;text-align:center;vertical-align:middle;height:24px;\">
<div><span style=\"color:#000000;font-family:Arial;font-size:13px;letter-spacing:0px;\"><strong>ПРАЙС - ЛИСТЫ</strong></span></div>
</td>
</tr>
<tr>
<td style=\"background-color:#1A001A;text-align:left;vertical-align:top;height:242px;\">
<div><span style=\"color:#F5F5F5;font-family:Arial;font-size:13px;\"><br></span></div>
<div><span style=\"color:#FFD700;font-family:Arial;font-size:13px;\">></span><span style=\"color:#F5F5F5;font-family:Arial;font-size:13px;\"> прайс на видеосъёмку</span></div>
<div><span style=\"color:#FFD700;font-family:Arial;font-size:13px;\">></span><span style=\"color:#F5F5F5;font-family:Arial;font-size:13px;\"> <a href=\"#\" onmouseup=\"ShowObject(\'Table1\', 1);return false;\">sdfsdfsdfs</a></span></div>
<div><span style=\"color:#FFD700;font-family:Arial;font-size:13px;\">></span><span style=\"color:#F5F5F5;font-family:Arial;font-size:13px;\"> sdfsdfsdf</span></div>
<div><span style=\"color:#FFD700;font-family:Arial;font-size:13px;\">></span><span style=\"color:#F5F5F5;font-family:Arial;font-size:13px;\"> sdfsddfs</span></div>
</td>
</tr>
</table>
<table style=\"position:absolute;left:1001px;top:589px;width:176px;height:207px;z-index:4;\" cellpadding=\"3\" cellspacing=\"1\" id=\"Table6\">
<tr>
<td style=\"background-color:transparent;text-align:center;vertical-align:middle;height:38px;\">
<div><span style=\"color:#000000;font-family:Arial;font-size:13px;letter-spacing:0px;\"><strong>ПРАЙС - ЛИСТЫ</strong></span></div>
</td>
</tr>
<tr>
<td style=\"background-color:#000040;text-align:left;vertical-align:top;height:154px;\">
<div><span style=\"color:#F5F5F5;font-family:Arial;font-size:13px;\"><br></span></div>
<div><span style=\"color:#FFD700;font-family:Arial;font-size:13px;\">></span><span style=\"color:#F5F5F5;font-family:Arial;font-size:13px;\"> </span><span style=\"color:#FFD700;font-family:Arial;font-size:13px;\"><a href=\"#\" onmouseup=\"ShowObject(\'Table1\', 0);return false;\" onblur=\"ShowObject(\'Table2\', 1);return false;\">sdffsdfsdf</a></span></div>
<div><span style=\"color:#FFD700;font-family:Arial;font-size:13px;\">></span><span style=\"color:#F5F5F5;font-family:Arial;font-size:13px;\"> <a href=\"#\" onmouseup=\"ShowObject(\'Table1\', 1);return false;\">sdfsdfsdfs</a></span></div>
<div><span style=\"color:#FFD700;font-family:Arial;font-size:13px;\">></span><span style=\"color:#F5F5F5;font-family:Arial;font-size:13px;\"> sdfsdfsdf</span></div>
<div><span style=\"color:#FFD700;font-family:Arial;font-size:13px;\">></span><span style=\"color:#F5F5F5;font-family:Arial;font-size:13px;\"> sdfsddfs</span></div>
</td>
</tr>
</table>
<table style=\"position:absolute;left:23px;top:589px;width:196px;height:289px;z-index:5;\" cellpadding=\"0\" cellspacing=\"0\" id=\"Table3\">
<tr>
<td style=\"background-color:transparent;text-align:center;vertical-align:middle;height:39px;\">
<div><span style=\"color:#000000;font-family:Arial;font-size:13px;letter-spacing:0px;\"><strong>ПРАЙС - ЛИСТЫ</strong></span></div>
</td>
</tr>
<tr>
<td style=\"background-color:#1A001A;text-align:left;vertical-align:top;height:248px;\">
<div><span style=\"color:#F5F5F5;font-family:Arial;font-size:13px;\"><br></span></div>
<div><span style=\"color:#FFD700;font-family:Arial;font-size:13px;\">></span><span style=\"color:#F5F5F5;font-family:Arial;font-size:13px;\"> </span><span style=\"color:#FFD700;font-family:Arial;font-size:13px;\"><a href=\"#\" onmouseup=\"ShowObject(\'Table1\', 0);return false;\" onblur=\"ShowObject(\'Table2\', 1);return false;\">sdffsdfsdf</a></span></div>
<div><span style=\"color:#FFD700;font-family:Arial;font-size:13px;\">></span><span style=\"color:#F5F5F5;font-family:Arial;font-size:13px;\"> <a href=\"#\" onmouseup=\"ShowObject(\'Table1\', 1);return false;\">sdfsdfsdfs</a></span></div>
<div><span style=\"color:#FFD700;font-family:Arial;font-size:13px;\">></span><span style=\"color:#F5F5F5;font-family:Arial;font-size:13px;\"> sdfsdfsdf</span></div>
<div><span style=\"color:#FFD700;font-family:Arial;font-size:13px;\">></span><span style=\"color:#F5F5F5;font-family:Arial;font-size:13px;\"> sdfsddfs</span></div>
</td>
</tr>
</table>
</div>
-->', '2.Фотобанк');
INSERT INTO content VALUES ('3', '', '3.Цены');
INSERT INTO content VALUES ('4', '<script type=\"text/javascript\" language=\"JavaScript\">// <![CDATA[
var h=(new Date()).getHours();
if (h > 23 || h < 7) document.write(\"Что-то припозднились вы сегодня.\") ;
if (h > 6 && h < 12) document.write(\"Кто ходит в гости по утрам...\");
if (h > 11 && h < 19) document.write(\"Милости просим, гости дорогие.\");
if (h > 18 && h < 24) document. write(\"Добрый вечер!\");
// ]]></script>
', '4.Контакты');
INSERT INTO content VALUES ('5', '<a href=\"../folder_for_prototype/sv_11.08_a2.php\"><img src=\"../folder_for_prototype/foto/svadbi/11.08.12/14.jpg\" width=\"393\" height=\"290\" /></a> 

<a href=\"../folder_for_prototype/avto_skript.php\"><img src=\"../folder_for_prototype/foto/svadbi/11.08.12/13.jpg\" width=\"393\" height=\"290\" /></a> 

<a href=\"../folder_for_prototype/avto_skript2.php\"><img src=\"../folder_for_prototype/foto/svadbi/11.08.12/12.jpg\" width=\"393\" height=\"290\" /></a> 

<a href=\"../folder_for_prototype/foto/svadbi/05/03.php\"><img src=\"../folder_for_prototype/foto/svadbi/04/07_Портреты.jpg\" width=\"393\" height=\"290\" /></a> 



', '5.Фото-свадьбы');
INSERT INTO content VALUES ('6', '<p><strong>&nbsp;ОБНОВИТЕ СТРАНИЧКУ</strong>, чтоб увидеть новую цитату. vbvbn&nbsp; bvnb<br /><br /></p>
<p>&nbsp;</p>', '6.Фото-дети');
INSERT INTO content VALUES ('7', '<table id=\"1\" style=\"width: 1200px; height: 299px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\" align=\"center\"><caption>&nbsp;</caption>
<tbody>
<tr style=\"background-color: #d2d500; height: 30px;\" align=\"center\" valign=\"middle\">
<td>hjkhjkhjkhjkjk</td>
<th scope=\"row\" align=\"center\">hjkjkjkhkjkhjk</th>
<td align=\"center\">hjkkjkhkjk</td>
</tr>
<tr style=\"height: 500px;\">
<td><!--Левая колонка--><br />
<div class=\"l_colonka\"><br />
<div class=\"small_menu\"><!--<div class =\"small_head\"><p class =\"toptext_00\">Меню:</p></div>--> <!--Меню слева--><dl id=\"menu\"><dt><a href=\"../myfotos/foto.php\"> <strong>Видео</strong> </a></dt><dt><a href=\"../index.php\"> <strong>Фото</strong> </a></dt><dt><a href=\"../index.php\"> <strong>Фотокниги</strong> </a></dt><dt><a href=\"../index.php\"> <strong>Слайд шоу</strong> </a></dt><dt><a href=\"../index.php\"> <strong>Коллажи</strong> </a></dt><dt><a href=\"../videoarhiv\"> <strong>Прайс-лист по фотосъемке</strong> </a></dt><dt><a href=\"../prays-list_po_videosem\"> <strong>Love Story</strong> </a></dt><dt><a href=\"../love_story\"> <strong>Прайс-лист по видеосъемке</strong> </a></dt><dt><a href=\"../video_love_story\"> <strong>Видео Love Story</strong> </a></dt><dt><a href=\"../fk/demo.php\"> <strong>Гид по фотобанку </strong> </a></dt><dt><a href=\"http://ktonanovenkogo.ru/wp-content/uploads/style.html\"> <strong>Видеоуроки</strong> </a></dt></dl></div>
<br />
<div class=\"contact\"><br />
<div class=\"small_head\"><br />
<p class=\"toptext_00\">Контакты:</p>
</div>
<p class=\"text_contact\">Видеооператор</p>
<p class=\"text_contact\">тел. 094-94-77-070</p>
<p class=\"text_contact\"><a href=\"mailto:jurii@aleks.od.ua\">video@aleks.od.ua</a></p>
<p class=\"text_contact\">Фотограф</p>
<p class=\"text_contact\">тел. 703-01-67</p>
<p class=\"text_contact\"><a href=\"mailto:anna@aleks.od.ua\">foto@aleks.od.ua</a></p>
</div>
</div>
</td>
<td style=\"width: 700px;\" valign=\"top\">
<p style=\"margin-left: 30px;\">НовостиАтрибуты и значения: background-color: &ndash; определяет цвет фона. margin:0 auto &ndash; определяет центрирование блока. width: &ndash; определяет ширину в пикселях или в процентах. height: &ndash; определяет высоту. float:left &ndash; определяет обтекание слева. border-right: &ndash; определяет свойства правой границы. clear:both &ndash; отменяет обтекание с обеих сторон. padding-left: &ndash; определяет внутренний отступ слева. margin-top: &ndash; определяет внешний отступ сверху. margin-left: &ndash; определяет внешний отступ слева. min-width: &ndash; определяет минимальную ширину. max-width: &ndash; определяет <sup>максимальную</sup> <sub>ширину.</sub></p>
</td>
<td align=\"right\" valign=\"top\">
<h2 style=\"text-align: left;\">НОВОСТИ<span style=\"font-size: large; font-family: verdana,geneva;\"><br /></span></h2>
<p style=\"text-align: left;\">Атрибуты и значения: background-color: &ndash; определяет цвет фона. margin:0 auto &ndash; определяет центрирование блока. width: &ndash; определяет ширину в пикселях или в процентах. height: &ndash; определяет высоту. float:left &ndash; определяет обтекание слева. border-right: &ndash; определяет свойства правой границы. clear:both &ndash; отменяет обтекание с обеих сторон. padding-left: &ndash; определяет внутренний отступ слева. margin-top: &ndash; определяет внешний отступ сверху. margin-left: &ndash; определяет внешний отступ слева. min-width: &ndash; определяет минимальную ширину. max-width: &ndash; определяет максимальную ширину.</p>
<p class=\"news_title\">&nbsp;</p>
</td>
</tr>
</tbody>
</table>', '7.Фото-банкеты');
INSERT INTO content VALUES ('8', '<p><strong>Hello world!! gfhgfgh hgвыаыв<br /></strong></p>
<p><strong>орлрол </strong></p>
<!-- AddThis Button BEGIN -->
<div class=\"addthis_toolbox addthis_default_style addthis_32x32_style\"><a class=\"addthis_button_preferred_1\"></a> <a class=\"addthis_button_preferred_2\"></a> <a class=\"addthis_button_preferred_3\"></a> <a class=\"addthis_button_preferred_4\"></a> <a class=\"addthis_button_compact\"></a> <a class=\"addthis_counter addthis_bubble_style\"></a></div>
<script type=\"text/javascript\">// <![CDATA[
var addthis_config = {\"data_track_addressbar\":true};
// ]]></script>
<script src=\"http://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5130b3ac183d6054\" type=\"text/javascript\"></script>
<!-- AddThis Button END -->
<p><span id=\"share42\"> <a style=\"display: inline-block; vertical-align: bottom; width: 32px; height: 32px; margin: 0 6px 6px 0; padding: 0; outline: none; background: url(http://literball.com/js/icons.png) -0px 0 no-repeat;\" title=\"Поделиться в Facebook\" onclick=\"window.open(\'http://www.facebook.com/sharer.php?u=VIDEO_URL&t=VIDEO_TITLE\', \'_blank\', \'scrollbars=0, resizable=1, menubar=0, left=200, top=200, width=550, height=440, toolbar=0, status=0\');return false\" rel=\"nofollow\" href=\"#\" target=\"_blank\"></a> <a style=\"display: inline-block; vertical-align: bottom; width: 32px; height: 32px; margin: 0 6px 6px 0; padding: 0; outline: none; background: url(http://literball.com/js/icons.png) -32px 0 no-repeat;\" title=\"Добавить в Одноклассники\" onclick=\"window.open(\'http://www.odnoklassniki.ru/dk?st.cmd=addShare&st._surl=VIDEO_URL&title=VIDEO_TITLE\', \'_blank\', \'scrollbars=0, resizable=1, menubar=0, left=200, top=200, width=550, height=440, toolbar=0, status=0\');return false\" rel=\"nofollow\" href=\"#\" target=\"_blank\"></a> <a style=\"display: inline-block; vertical-align: bottom; width: 32px; height: 32px; margin: 0 6px 6px 0; padding: 0; outline: none; background: url(http://literball.com/js/icons.png) -64px 0 no-repeat;\" title=\"Добавить в Twitter\" onclick=\"window.open(\'http://twitter.com/share?text=VIDEO_TITLE&url=VIDEO_URL\', \'_blank\', \'scrollbars=0, resizable=1, menubar=0, left=200, top=200, width=550, height=440, toolbar=0, status=0\');return false\" rel=\"nofollow\" href=\"#\" target=\"_blank\"></a> <a style=\"display: inline-block; vertical-align: bottom; width: 32px; height: 32px; margin: 0 6px 6px 0; padding: 0; outline: none; background: url(http://literball.com/js/icons.png) -96px 0 no-repeat;\" title=\"Поделиться В Контакте\" onclick=\"window.open(\'http://vk.com/share.php?url=VIDEO_URL&title=VIDEO_TITLE\', \'_blank\', \'scrollbars=0, resizable=1, menubar=0, left=200, top=200, width=554, height=421, toolbar=0, status=0\');return false\" rel=\"nofollow\" href=\"#\" target=\"_blank\"></a> </span></p>', '8.Фотокниги');
INSERT INTO content VALUES ('9', '[list=1]
[*]Item 1
[list=1]
[*]Sub item 1
[*]Sub item 2
[/list]
[/list]
kl;yuil;=9pxuihyuiuyi:D
[url=http://www.google.com]Search something[/url]

[email]dfg@fgh.hjk[/email]', '9.Фото-выпускники');
INSERT INTO content VALUES ('10', '', '10.Фото-разное');
INSERT INTO content VALUES ('11', '<center>
Свадебная прогулка в парке.
<br><br>
<iframe width=\"640\" height=\"360\" src=\"http://www.youtube.com/embed/dCSYge7x7mQ?rel=0\" frameborder=\"0\" allowfullscreen></iframe><br><br><br><br><br>

Невеста Рафаэлла.
<br><br>
<iframe width=\"640\" height=\"360\" src=\"http://www.youtube.com/embed/ciWi4JcbWNw?rel=0\" frameborder=\"0\" allowfullscreen></iframe><br><br><br><br><br>


Путешествие из Ильичевска в Одессу.
<br><br>
<iframe width=\"640\" height=\"360\" src=\"http://www.youtube.com/embed/Wr7Y3jrQ6gc?rel=0\" frameborder=\"0\" allowfullscreen></iframe><br><br><br><br><br>

Романтичесская прогулка.
<br><br>
<iframe width=\"640\" height=\"360\" src=\"http://www.youtube.com/embed/15HsXscr8aU?rel=0\" frameborder=\"0\" allowfullscreen></iframe><br><br><br><br><br>

Невеста Оксана.
<br><br>
<iframe width=\"640\" height=\"360\" src=\"http://www.youtube.com/embed/neScekWAZ7w?rel=0\" frameborder=\"0\" allowfullscreen></iframe>
<br><br><br><br><br>
Свадьба Жени и Андрея.
<br><br>
<iframe width=\"640\" height=\"360\" src=\"http://www.youtube.com/embed/waJNGpUhbLk?rel=0\" frameborder=\"0\" allowfullscreen></iframe><br><br><br><br><br>

Заключительный клип свадебного фильма.
<br><br>
<iframe width=\"640\" height=\"360\" src=\"http://www.youtube.com/embed/G6-7rboF8Dc?rel=0\" frameborder=\"0\" allowfullscreen></iframe><br><br><br><br><br>


Игра ВА-БАНК или где взять деньги на свадьбу.  :)  Шуточный фильм, показанный в день свадьбы.
<br><br>
<iframe width=\"640\" height=\"360\" src=\"http://www.youtube.com/embed/rlMrCRe81OQ?rel=0\" frameborder=\"0\" allowfullscreen></iframe><br><br><br><br><br>

Свадебная прогулка Deja-vu.
<br><br>
<iframe width=\"640\" height=\"360\" src=\"http://www.youtube.com/embed/sqgb0b-tV3o?rel=0\" frameborder=\"0\" allowfullscreen></iframe><br><br><br><br><br>

Романтичесское свидание на море.
<br><br>
<iframe width=\"640\" height=\"360\" src=\"http://www.youtube.com/embed/7Z5DGeJbqrc?rel=0\" frameborder=\"0\" allowfullscreen></iframe>
</center>', '11.Видео-свадьбы');
INSERT INTO content VALUES ('12', '<p style=\"text-align: center;\">&nbsp;<object style=\"float: left;\" width=\"276\" height=\"158\" data=\"http://31.31.105.95/videostation/player/cbplayer/player.swf?config=http%3A%2F%2F31.31.105.95%2Fvideostation%2Fplayer%2Fcbplayer%2Fembed_player.php%3Fvid%3D960%26autoplay%3Dyes\" type=\"application/x-shockwave-flash\"><param name=\"src\" value=\"http://31.31.105.95/videostation/player/cbplayer/player.swf?config=http%3A%2F%2F31.31.105.95%2Fvideostation%2Fplayer%2Fcbplayer%2Fembed_player.php%3Fvid%3D960%26autoplay%3Dyes\" /><param name=\"allowscriptaccess\" value=\"always\" /><param name=\"allowfullscreen\" value=\"true\" /></object></p>
<p><object style=\"display: block; margin-left: auto; margin-right: auto;\" width=\"660\" height=\"408\" data=\"http://192.168.1.232/videostation/player/cbplayer/player.swf?config=http%3A%2F%2F192.168.1.232%2Fvideostation%2Fplayer%2Fcbplayer%2Fembed_player.php%3Fvid%3D960%26autoplay%3Dyes\" type=\"application/x-shockwave-flash\"><param name=\"src\" value=\"http://192.168.1.232/videostation/player/cbplayer/player.swf?config=http%3A%2F%2F192.168.1.232%2Fvideostation%2Fplayer%2Fcbplayer%2Fembed_player.php%3Fvid%3D960%26autoplay%3Dyes\" /><param name=\"allowscriptaccess\" value=\"always\" /><param name=\"allowfullscreen\" value=\"true\" /></object></p>', '12.Видео-дети');
INSERT INTO content VALUES ('13', '<center>
Открытый урок
<br>
<iframe width=\"640\" height=\"360\" src=\"http://www.youtube.com/embed/J5u_IEey2J4?rel=0\" frameborder=\"0\" allowfullscreen></iframe><br><br><br><br>

Интервью
<br>
<iframe width=\"640\" height=\"360\" src=\"http://www.youtube.com/embed/XMgk2sbbZA4?rel=0\" 
frameborder=\"0\" allowfullscreen></iframe><br><br><br><br>

Клип для мамы
<br>
<iframe width=\"640\" height=\"360\" src=\"http://www.youtube.com/embed/TMbd6t_KboE?rel=0\" frameborder=\"0\" allowfullscreen></iframe>

</center>', '13.Видео-выпускники');
INSERT INTO content VALUES ('14', '<p>Видеосъемка концертов, спектаклей и постановок осуществляется в зависимости от поставленной заказчиком задачи одной или двумя - тремя камерами. В формате CD (DVD) или FullHD. Чем отличаются между собой форматы и разницу между однокамерной  и двукамерной съемкой Вы можете посмотреть ниже.</p>
<center>
<br><br> Для сравнения:<br> Балет \"Золушка\" в \"CD\" формате, однокамерная съемка.

<br><br>

<iframe width=\"640\" height=\"360\" src=\"http://www.youtube.com/embed/-9DCLZn9uAI?rel=0\" frameborder=\"0\" allowfullscreen></iframe>

<br><br><br><br><br> \"Золушка\" в формате \"HD\", однокамерная съемка. <br><br>

<iframe width=\"1280\" height=\"720\" src=\"http://www.youtube.com/embed/-9DCLZn9uAI?rel=0\" frameborder=\"0\" allowfullscreen></iframe>

<br><br><br><br><br>

Tomas Nevergreen. Концерт. Двухкамерная съёмка в \"CD\" формате.<br><br>
<iframe width=\"640\" height=\"360\" src=\"http://www.youtube.com/embed/cLagdI0G7dI?rel=0\" frameborder=\"0\" allowfullscreen></iframe>
<br><br><br><br><br><br>


Tomas Nevergreen. Концерт. Двухкамерная съёмка в \"HD\" формате.<br><br>
<iframe width=\"1280\" height=\"720\" src=\"http://www.youtube.com/embed/cLagdI0G7dI?rel=0\" frameborder=\"0\" al<br><br>lowfullscreen></iframe>


</center>', '14.Видео-разное');
INSERT INTO content VALUES ('16', '', '16.Видео-банкеты');
INSERT INTO content VALUES ('15', '<center>
Монтаж видеокипа из предоставленных заказчиком фотографий.
<br><br>
<iframe width=\"640\" height=\"360\" src=\"http://www.youtube.com/embed/DbJspiIoJ1k?rel=0\" frameborder=\"0\" allowfullscreen></iframe>
</center>', '15.Видео-слайдшоу');
INSERT INTO content VALUES ('17', '
<center><p><span style=\"font-size:18px\" > Образцы работ, снятые нашей студией.</span></p></center>
<br>', '17.Услуги до иконок');
INSERT INTO content VALUES ('18', '
<p><span style=\"color: #ccc; font-size:14px\">Совет: если у Вас не воспроизводится видео в браузере попробуйте
отключить ADBLOCK или воспользуйтесь другим браузером. Вы также можете просмотреть
эти матерьялы напрямую на YouTube.</span></p>	', '18.Услуги после иконок');


#
# Table structure for table `download_photo`
#

DROP TABLE IF EXISTS `download_photo`;
CREATE TABLE `download_photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL DEFAULT '0',
  `id_order` int(11) NOT NULL DEFAULT '0',
  `id_order_item` int(11) NOT NULL DEFAULT '0',
  `id_photo` int(11) NOT NULL DEFAULT '0',
  `dt_start` int(11) NOT NULL DEFAULT '0',
  `downloads` int(11) NOT NULL DEFAULT '0',
  `download_key` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_photo` (`id_photo`),
  KEY `dt_start` (`dt_start`),
  KEY `download_key` (`download_key`)
) ENGINE=MyISAM AUTO_INCREMENT=353 DEFAULT CHARSET=cp1251 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

#
# Dumping data for table `download_photo`
#

INSERT INTO download_photo VALUES ('89', '17', '63', '90', '2919', '1360402309', '0', '2285da77253fc2b823b78122669c48b1');
INSERT INTO download_photo VALUES ('88', '17', '63', '89', '2920', '1360402309', '0', '5388b8772aa74ecd57673ddb677b0693');
INSERT INTO download_photo VALUES ('87', '17', '62', '88', '2908', '1360402078', '0', 'fdef7f2d227e9030eff9f367a911cbff');
INSERT INTO download_photo VALUES ('86', '17', '62', '87', '2922', '1360402078', '0', 'bc0e722df4b923599534429660165012');
INSERT INTO download_photo VALUES ('85', '17', '62', '86', '2923', '1360402078', '0', 'b5018b30a8c9c661e8964dabc30bd00c');
INSERT INTO download_photo VALUES ('84', '17', '62', '85', '2924', '1360402078', '0', '6fb8bcf6f24b5281889e67efe8766894');
INSERT INTO download_photo VALUES ('83', '17', '62', '84', '2925', '1360402078', '0', '235f497fe5f7a988a7351578554dec4f');
INSERT INTO download_photo VALUES ('82', '17', '61', '83', '2899', '1360395734', '0', '0adbb0f50413c4c254e43d7d3419a96e');
INSERT INTO download_photo VALUES ('81', '17', '61', '82', '2924', '1360395734', '0', 'e8705a94c342bf8367ea50dcbdefc83b');
INSERT INTO download_photo VALUES ('80', '17', '61', '81', '2879', '1360395734', '0', '9999e294683943cefe084317fbe3329f');
INSERT INTO download_photo VALUES ('79', '17', '61', '80', '2881', '1360395734', '0', '0d624c101b4612b765ea81272c6e2994');
INSERT INTO download_photo VALUES ('78', '17', '61', '79', '2882', '1360395734', '0', '728f6766c125009741c5f697f3a7c2e2');
INSERT INTO download_photo VALUES ('77', '25', '60', '78', '2882', '1360395609', '0', '1b391b40630a73637ac9b16944c25d30');
INSERT INTO download_photo VALUES ('76', '25', '60', '77', '2878', '1360395609', '0', '546235ee12d91152ad26652aa0c2a8db');
INSERT INTO download_photo VALUES ('75', '25', '60', '76', '2887', '1360395609', '0', '3b46ce2f23b129a450ec6bbbf4572cf8');
INSERT INTO download_photo VALUES ('74', '25', '60', '75', '2888', '1360395609', '0', 'e2ae01de8c105d251ab2e7b1f800fa57');
INSERT INTO download_photo VALUES ('71', '25', '60', '72', '2890', '1360395609', '0', 'cb9e237a02e8be7a6074d54c38f43b70');
INSERT INTO download_photo VALUES ('72', '25', '60', '73', '2892', '1360395609', '0', '30a427b30a0454e8ed3fcdc98d0cedf1');
INSERT INTO download_photo VALUES ('73', '25', '60', '74', '2895', '1360395609', '0', 'e00c72f0adb2811a6031f55dd5f1180b');
INSERT INTO download_photo VALUES ('90', '17', '63', '91', '2918', '1360402309', '0', '8e5fe915023db9c07b7ef8bfdf37ac33');
INSERT INTO download_photo VALUES ('91', '17', '63', '92', '2917', '1360402309', '0', 'c4d16033796d9b2c1f8dcbc704040f37');
INSERT INTO download_photo VALUES ('92', '17', '63', '93', '2916', '1360402309', '0', '9b17be22b49519d9f90574b07278ecde');
INSERT INTO download_photo VALUES ('93', '17', '63', '94', '2915', '1360402309', '0', '6b93a6f84e52ae2842f1214fc198bdfa');
INSERT INTO download_photo VALUES ('94', '17', '63', '95', '2914', '1360402309', '0', 'ec25f0955c8a66891e8a5de9ffdb235d');
INSERT INTO download_photo VALUES ('95', '17', '63', '96', '2913', '1360402309', '0', '4187514639df4a147adf023cd3ffcae4');
INSERT INTO download_photo VALUES ('96', '17', '63', '97', '2912', '1360402309', '0', '3273a0a9a161094fec3bbdb0b1b12a2b');
INSERT INTO download_photo VALUES ('97', '17', '63', '98', '2911', '1360402309', '0', 'da80cb1856227fbeda3d61f664d58600');
INSERT INTO download_photo VALUES ('98', '17', '63', '99', '2910', '1360402309', '0', 'ac924adab63f348b0f8dbb8a5046ce86');
INSERT INTO download_photo VALUES ('99', '17', '63', '100', '2909', '1360402309', '0', '9da15bbb26f8ea06d22c3f5919025767');
INSERT INTO download_photo VALUES ('100', '17', '63', '101', '2895', '1360402309', '0', 'e691c635d9138409d5e0a313ad9a45e1');
INSERT INTO download_photo VALUES ('101', '25', '64', '102', '2933', '1360528321', '0', '425db0b9816cb7f5a8d3e10bab088cfc');
INSERT INTO download_photo VALUES ('102', '25', '64', '103', '2932', '1360528321', '0', '3a74617027bdef4c811abde850807228');
INSERT INTO download_photo VALUES ('103', '25', '64', '104', '2931', '1360528321', '0', '6d0724465effe3c767a25a28a2538634');
INSERT INTO download_photo VALUES ('104', '18', '65', '105', '2935', '1360529827', '0', '45e7ebfab46d9b40a64a3ad40979da09');
INSERT INTO download_photo VALUES ('105', '18', '65', '106', '2934', '1360529827', '0', '3594ff2197426515e7d3ca595864a4a9');
INSERT INTO download_photo VALUES ('106', '18', '66', '107', '2944', '1360531478', '0', 'ce7dd1bd56e5b4ce5ad962c595e3dcb2');
INSERT INTO download_photo VALUES ('107', '18', '66', '108', '2943', '1360531478', '0', 'cc8a68448722c345d03f0fda85fbe1ca');
INSERT INTO download_photo VALUES ('108', '18', '66', '109', '2942', '1360531478', '0', 'd7f410c53dc8b7d58cd533c64cc79eee');
INSERT INTO download_photo VALUES ('109', '20', '67', '110', '2948', '1360531961', '0', '916c9969a29b34edc1a21f92dbe47cae');
INSERT INTO download_photo VALUES ('110', '20', '67', '111', '2947', '1360531961', '0', '83605ff7012e3ce19884e2d857f681b5');
INSERT INTO download_photo VALUES ('111', '20', '67', '112', '2946', '1360531961', '0', 'aa3ed8d18b3d550ea9287fe62d6deeac');
INSERT INTO download_photo VALUES ('112', '25', '68', '113', '4753', '1361809470', '0', '1a91b52bf4c5de3ff58115227583d454');
INSERT INTO download_photo VALUES ('113', '25', '68', '114', '4756', '1361809470', '0', 'c6e49c9fe03d592cd85061f455214fb1');
INSERT INTO download_photo VALUES ('114', '20', '72', '115', '5285', '1364239576', '0', '272edb609f0c469db4ddf69ef7a575dc');
INSERT INTO download_photo VALUES ('115', '20', '72', '116', '5287', '1364239576', '0', '55364799aba61d768fdf943421a49816');
INSERT INTO download_photo VALUES ('116', '20', '72', '117', '5288', '1364239576', '0', '3ba57398ee08932fe74a9c0ac512906e');
INSERT INTO download_photo VALUES ('117', '20', '73', '118', '5352', '1364262634', '0', 'dfe63866f374529c65ff0422ef59d69b');
INSERT INTO download_photo VALUES ('118', '20', '73', '119', '5268', '1364262634', '0', '2f61c1a317e578e8d7a86a306471902e');
INSERT INTO download_photo VALUES ('119', '20', '74', '120', '5267', '1364262700', '0', '9dcef6786d8a74798712e8533173e857');
INSERT INTO download_photo VALUES ('120', '20', '74', '121', '5266', '1364262700', '0', 'b4502c51e69d44a14e7f3922686a00c8');
INSERT INTO download_photo VALUES ('121', '20', '75', '122', '5351', '1364397878', '0', '314a41e820bb6ba550f06826862f0b62');
INSERT INTO download_photo VALUES ('122', '20', '75', '123', '5323', '1364397878', '0', '3ed323852451f0768308f7838689b9c4');
INSERT INTO download_photo VALUES ('123', '20', '76', '124', '5267', '1364397926', '0', '943124a3dcf8953fdbe5160f3ec39d8e');
INSERT INTO download_photo VALUES ('124', '20', '77', '125', '5275', '1364397950', '0', '8e007845df19775537decf6245fa7fdd');
INSERT INTO download_photo VALUES ('125', '29', '82', '126', '5956', '1367678563', '0', '633');
INSERT INTO download_photo VALUES ('126', '29', '82', '127', '5982', '1367678563', '0', '14');
INSERT INTO download_photo VALUES ('134', '29', '86', '135', '5986', '1367926173', '0', '12');
INSERT INTO download_photo VALUES ('133', '29', '86', '134', '6011', '1367926173', '0', '27');
INSERT INTO download_photo VALUES ('129', '29', '84', '130', '5956', '1367679052', '0', '9');
INSERT INTO download_photo VALUES ('130', '29', '84', '131', '5973', '1367679052', '0', '86');
INSERT INTO download_photo VALUES ('131', '29', '85', '132', '5972', '1367682174', '0', '985');
INSERT INTO download_photo VALUES ('132', '29', '85', '133', '6166', '1367682174', '0', '0');
INSERT INTO download_photo VALUES ('135', '29', '87', '136', '6021', '1368042392', '0', '4');
INSERT INTO download_photo VALUES ('136', '29', '87', '137', '6023', '1368042392', '0', '92');
INSERT INTO download_photo VALUES ('137', '29', '87', '138', '6025', '1368042392', '0', '2');
INSERT INTO download_photo VALUES ('138', '29', '88', '139', '6003', '1368042955', '0', '995');
INSERT INTO download_photo VALUES ('182', '29', '155', '183', '5986', '1368445889', '0', 'ca9ddc0d3dac07f44eb68190561e62ff');
INSERT INTO download_photo VALUES ('140', '29', '90', '141', '5983', '1368043307', '0', '0');
INSERT INTO download_photo VALUES ('141', '29', '91', '142', '5986', '1368043396', '0', '0');
INSERT INTO download_photo VALUES ('142', '29', '92', '143', '5990', '1368043459', '0', '0');
INSERT INTO download_photo VALUES ('143', '29', '93', '144', '5990', '1368043736', '0', '0');
INSERT INTO download_photo VALUES ('144', '29', '94', '145', '5986', '1368043832', '0', '3355');
INSERT INTO download_photo VALUES ('145', '29', '95', '146', '6004', '1368043940', '0', '8352593');
INSERT INTO download_photo VALUES ('146', '29', '96', '147', '5986', '1368044412', '0', '7736');
INSERT INTO download_photo VALUES ('147', '29', '97', '148', '5983', '1368044442', '0', '14');
INSERT INTO download_photo VALUES ('148', '29', '98', '149', '5990', '1368044499', '0', '6');
INSERT INTO download_photo VALUES ('149', '29', '99', '150', '5982', '1368047723', '0', '85005');
INSERT INTO download_photo VALUES ('150', '29', '99', '151', '5983', '1368047723', '0', '0');
INSERT INTO download_photo VALUES ('151', '29', '99', '152', '5990', '1368047723', '0', '0');
INSERT INTO download_photo VALUES ('152', '29', '99', '153', '5991', '1368047723', '0', '674');
INSERT INTO download_photo VALUES ('153', '29', '99', '154', '5993', '1368047723', '0', '0');
INSERT INTO download_photo VALUES ('154', '29', '99', '155', '6011', '1368047723', '0', '97300');
INSERT INTO download_photo VALUES ('155', '29', '99', '156', '6012', '1368047723', '0', '42479');
INSERT INTO download_photo VALUES ('156', '29', '99', '157', '6014', '1368047723', '0', '0');
INSERT INTO download_photo VALUES ('157', '29', '99', '158', '5986', '1368047723', '0', '65');
INSERT INTO download_photo VALUES ('158', '29', '0', '159', '5990', '1368048616', '0', '4133');
INSERT INTO download_photo VALUES ('159', '29', '100', '160', '6492', '1368048764', '0', '14');
INSERT INTO download_photo VALUES ('160', '29', '103', '161', '5990', '1368050129', '3', 'c21d8306d638ad35cef741a29cc85959');
INSERT INTO download_photo VALUES ('161', '29', '104', '162', '5986', '1368052419', '1', 'ee007415bc46bd752c18c3bc48fd51f3');
INSERT INTO download_photo VALUES ('162', '29', '105', '163', '5990', '1368084632', '1', 'eb00415f3f5ee51a0bdd1650633d4d1c');
INSERT INTO download_photo VALUES ('163', '29', '105', '164', '5986', '1368084632', '1', 'f865cd775b6ae0f0de79ad44af6875e7');
INSERT INTO download_photo VALUES ('164', '29', '105', '165', '6032', '1368084632', '0', '5d6c162621839722c7a2313ed7911581');
INSERT INTO download_photo VALUES ('165', '29', '105', '166', '6101', '1368084632', '0', '0c7fe6b7b5db153a0fa2499922256404');
INSERT INTO download_photo VALUES ('166', '29', '151', '167', '6492', '1368103965', '0', '5794238baff7fe44e4bb0e4f9d49f185');
INSERT INTO download_photo VALUES ('167', '29', '151', '168', '5990', '1368103965', '0', '66f145b60dd395803dc2beb3f2810f9b');
INSERT INTO download_photo VALUES ('168', '29', '151', '169', '6158', '1368103965', '0', 'e7abc004749f6457a1a99aa3ba625be3');
INSERT INTO download_photo VALUES ('169', '29', '151', '170', '6159', '1368103965', '0', '2f57c032f9365d8838f36d04e544359c');
INSERT INTO download_photo VALUES ('170', '29', '151', '171', '6160', '1368103965', '0', '1b10bfa6f0c98a992a19020351f636a7');
INSERT INTO download_photo VALUES ('171', '29', '152', '172', '6004', '1368104916', '0', '8f98de5403698e59e8b94ae08c07307a');
INSERT INTO download_photo VALUES ('172', '29', '153', '173', '6010', '1368120789', '0', 'f801d9e2bf5907ec4eaab696277d0c8e');
INSERT INTO download_photo VALUES ('173', '29', '153', '174', '5982', '1368120789', '0', 'b9d95669ca01f5e99008c72acdc89d1c');
INSERT INTO download_photo VALUES ('174', '29', '153', '175', '5990', '1368120789', '0', '04e8d3eee433012fd0d227a96b16b8c1');
INSERT INTO download_photo VALUES ('175', '29', '153', '176', '5986', '1368120789', '0', '840a3b93e52b9fb478f8d9bdda2c8bbc');
INSERT INTO download_photo VALUES ('176', '29', '153', '177', '6011', '1368120789', '0', '9de53dbdccf1901ad6ee0a5fe1845e04');
INSERT INTO download_photo VALUES ('177', '29', '154', '178', '5986', '1368134795', '0', 'cfe8bff8162847e21dee0eaf68dfb9bd');
INSERT INTO download_photo VALUES ('178', '29', '154', '179', '6021', '1368134795', '0', 'cf983989fb76b89d592ac10f9e76fb0e');
INSERT INTO download_photo VALUES ('179', '29', '154', '180', '6023', '1368134795', '0', 'd6ad71ee4c92350056cece8cc6090efc');
INSERT INTO download_photo VALUES ('180', '29', '154', '181', '6025', '1368134795', '0', 'abcae4c932c05dac2be61217a26c303c');
INSERT INTO download_photo VALUES ('181', '29', '154', '182', '6026', '1368134795', '0', 'feea74e1471d6e7b91db5cd9d0c86840');
INSERT INTO download_photo VALUES ('183', '29', '156', '184', '6006', '1368447408', '1', '7eac00ee516047edb477af424055e92a');
INSERT INTO download_photo VALUES ('184', '29', '156', '185', '6007', '1368447408', '1', 'd224bac8cce3e6ab84b20c427de2123f');
INSERT INTO download_photo VALUES ('185', '29', '156', '186', '6008', '1368447408', '1', '6d9b6ce3c356d122b89f52eee879bf67');
INSERT INTO download_photo VALUES ('186', '29', '157', '187', '6006', '1368469512', '0', '85815b62f5295abc63b0c2db4e74af08');
INSERT INTO download_photo VALUES ('187', '29', '157', '188', '6008', '1368469512', '0', 'a00591f6ad0437ebbcc1c16b9b1bf86d');
INSERT INTO download_photo VALUES ('188', '29', '168', '189', '6012', '1368471789', '0', '51c642d40d00556082d3fe3e5a74e5c3');
INSERT INTO download_photo VALUES ('189', '29', '168', '190', '6013', '1368471789', '0', 'e55b447d739283ce9c6178d87082be70');
INSERT INTO download_photo VALUES ('190', '29', '168', '191', '6014', '1368471789', '0', '9c40d4ee2cca8cbe0e24189e747e11ff');
INSERT INTO download_photo VALUES ('191', '29', '168', '192', '6020', '1368471789', '0', '3fd4ce4a86719d713cde763cea3a95a1');
INSERT INTO download_photo VALUES ('192', '29', '168', '193', '6021', '1368471789', '1', '1bb27dbc403b9dd256b0328559aaad57');
INSERT INTO download_photo VALUES ('193', '29', '169', '194', '5986', '1368473114', '0', 'ed7fd5baea6d21d8e3ad94eed8e9ca1a');
INSERT INTO download_photo VALUES ('194', '29', '169', '195', '5990', '1368473114', '0', 'c0dafa82aeba204c209d48d08f29f791');
INSERT INTO download_photo VALUES ('195', '29', '169', '196', '5991', '1368473114', '0', '4bed12b14841dbb47e3dcad578564954');
INSERT INTO download_photo VALUES ('196', '29', '171', '197', '5986', '1368473441', '0', '37f72929c295a1d4aa44c165ac62de93');
INSERT INTO download_photo VALUES ('197', '29', '172', '198', '5986', '1368812447', '0', 'a7dc611427fa374701435a713aa26ea5');
INSERT INTO download_photo VALUES ('198', '29', '172', '199', '5990', '1368812447', '0', '584a4701d9163fc9ad744dbc0df8fcaa');
INSERT INTO download_photo VALUES ('199', '29', '172', '200', '6045', '1368812447', '0', '7fad2c6c82c5c2c63810108e442fe133');
INSERT INTO download_photo VALUES ('200', '29', '172', '201', '6046', '1368812447', '0', '171b269c1925f6b86a0e391b4f716d12');
INSERT INTO download_photo VALUES ('201', '29', '172', '202', '6047', '1368812447', '1', '831cd5bdbaf1140b53faeb8f863a5f20');
INSERT INTO download_photo VALUES ('202', '29', '172', '203', '6048', '1368812447', '0', 'b93703543dc1cf8cfc6224c5064286f4');
INSERT INTO download_photo VALUES ('203', '29', '172', '204', '6053', '1368812447', '0', '553a55acad790765cdcc59ca8842b437');
INSERT INTO download_photo VALUES ('204', '29', '172', '205', '6055', '1368812447', '0', '0b7c2a74dc4242ca6cec6b15c299451a');
INSERT INTO download_photo VALUES ('205', '29', '172', '206', '6056', '1368812447', '0', '3a395fa2f11f97978a7f6398903b4d14');
INSERT INTO download_photo VALUES ('206', '29', '172', '207', '6059', '1368812447', '0', '9cc86d067f97ec162b7d8c92deb2a087');
INSERT INTO download_photo VALUES ('207', '29', '172', '208', '6060', '1368812447', '0', '3b7f6273a301474b4fbb2c4f1edb05a3');
INSERT INTO download_photo VALUES ('208', '29', '172', '209', '6061', '1368812447', '0', '718c8397ccfc310a4fd52e7eb4a4f5f3');
INSERT INTO download_photo VALUES ('209', '29', '172', '210', '6063', '1368812447', '0', 'd13df99d68819639f65748818ff5fd79');
INSERT INTO download_photo VALUES ('210', '29', '172', '211', '6065', '1368812447', '0', '34476fdb6ebd3e8d8f76eae308708551');
INSERT INTO download_photo VALUES ('211', '29', '172', '212', '6072', '1368812447', '0', 'a7c0f0f31f3840e9cb8719dd421c02e5');
INSERT INTO download_photo VALUES ('212', '29', '172', '213', '6073', '1368812447', '0', '1c36f84fd64226d37af80995d7e95542');
INSERT INTO download_photo VALUES ('213', '29', '172', '214', '6075', '1368812447', '0', '3a7294d37ebd5490e4b999cc90a3a291');
INSERT INTO download_photo VALUES ('214', '29', '172', '215', '6076', '1368812447', '0', '6767b987e24b2318cddaeb16807a593f');
INSERT INTO download_photo VALUES ('215', '29', '172', '216', '6080', '1368812447', '0', '62fbc4e5148f6d50d92f45672081e087');
INSERT INTO download_photo VALUES ('216', '29', '172', '217', '6083', '1368812447', '0', '34427b967de4580bf65f7669aaf5bc36');
INSERT INTO download_photo VALUES ('217', '29', '172', '218', '0', '1368812447', '0', '0583f1080a2445d53cee6ff59fd348e2');
INSERT INTO download_photo VALUES ('218', '29', '172', '219', '0', '1368812447', '0', '8a47d83d1ceed002aa2edf31206cf862');
INSERT INTO download_photo VALUES ('219', '29', '172', '220', '0', '1368812447', '0', '94a8d575793597346cb0bff26f2e4a1b');
INSERT INTO download_photo VALUES ('220', '29', '173', '221', '6006', '1368812963', '0', '109969b83f05884aa0fe286fc526b6ad');
INSERT INTO download_photo VALUES ('221', '29', '173', '222', '6007', '1368812963', '0', '597097b9e3c273b072ea10f34c03f876');
INSERT INTO download_photo VALUES ('222', '29', '173', '223', '6008', '1368812963', '0', '03eb3e809073d682a97e69d273f33b9d');
INSERT INTO download_photo VALUES ('223', '29', '173', '224', '6009', '1368812963', '1', 'ab7eb5dbe4ca9e008f0c1058d582757b');
INSERT INTO download_photo VALUES ('224', '29', '173', '225', '6010', '1368812963', '0', '84804ed72f2ac132df2f578eb00b5916');
INSERT INTO download_photo VALUES ('225', '29', '173', '226', '6012', '1368812963', '1', '0a3889a1182e333981e4dd7df6463b8a');
INSERT INTO download_photo VALUES ('226', '29', '173', '227', '6013', '1368812963', '0', '1553e4310a83a9d79a9be45816acc44d');
INSERT INTO download_photo VALUES ('227', '29', '173', '228', '6014', '1368812963', '0', '90aa26d5dccd970bbc52d38a80762229');
INSERT INTO download_photo VALUES ('228', '29', '173', '229', '6083', '1368812963', '0', '149266db05c638fd0e179833aa869a03');
INSERT INTO download_photo VALUES ('229', '29', '173', '230', '6084', '1368812963', '0', '5e35c9b163befa7e502de4f1bc181d67');
INSERT INTO download_photo VALUES ('230', '29', '173', '231', '0', '1368812963', '0', '159334eb5bb58a24eef6fedf8919a76a');
INSERT INTO download_photo VALUES ('231', '29', '173', '232', '0', '1368812963', '0', 'd0625e8c7b72477a7dfb584a2778b32c');
INSERT INTO download_photo VALUES ('232', '29', '173', '233', '0', '1368812963', '0', '91e0dbe60bb39a4eda4205b7ace76f61');
INSERT INTO download_photo VALUES ('233', '29', '13', '234', '6005', '1369392247', '1', '4dfa4f0dc5d56c05321d69a5daf3eb6a');
INSERT INTO download_photo VALUES ('234', '29', '13', '235', '6006', '1369392247', '0', 'abf4e44175912f28285a8e90a8bb1312');
INSERT INTO download_photo VALUES ('235', '29', '13', '236', '6007', '1369392247', '0', '6747da2bb7d7a0f27ddb7d8c75c31d01');
INSERT INTO download_photo VALUES ('236', '29', '13', '237', '6008', '1369392247', '0', '45bdeaabcf5563308dba168ab9d5ca2e');
INSERT INTO download_photo VALUES ('237', '29', '13', '238', '0', '1369392247', '0', 'ed79aeed5ea469e6e8671680a22c6b29');
INSERT INTO download_photo VALUES ('238', '29', '13', '239', '0', '1369392247', '0', '454198f3c514ba890a6bf5747ebbee6a');
INSERT INTO download_photo VALUES ('239', '29', '13', '240', '0', '1369392247', '0', 'ca8f96f93fd33bb13aaad30e0ecab259');
INSERT INTO download_photo VALUES ('240', '29', '15', '241', '6006', '1369393916', '0', '69e177670da2112c50fbdd597beb4201');
INSERT INTO download_photo VALUES ('241', '29', '15', '242', '0', '1369393916', '0', '91c73cfe5d5842391e59317b83b98644');
INSERT INTO download_photo VALUES ('242', '29', '15', '243', '0', '1369393916', '0', '981d1ba75e3c3a9f322413e33ee83dd8');
INSERT INTO download_photo VALUES ('243', '29', '15', '244', '0', '1369393916', '0', '5c8ea8eee84312fbfa70bf36f39b256e');
INSERT INTO download_photo VALUES ('244', '29', '17', '245', '5990', '1369394337', '0', 'fb76964c13df5752d1cc3ec2794e854b');
INSERT INTO download_photo VALUES ('245', '29', '17', '246', '0', '1369394337', '0', 'c1fa8269364881bf10abd4a636a0cabd');
INSERT INTO download_photo VALUES ('246', '29', '17', '247', '0', '1369394337', '0', '6fce608ef6f2733dd24bc3151ca10ed0');
INSERT INTO download_photo VALUES ('247', '29', '17', '248', '0', '1369394337', '0', '9ba4fdba278d8b977f9a04bc4c31dd91');
INSERT INTO download_photo VALUES ('248', '29', '17', '249', '5986', '1369394337', '0', '649cc4ca1c9acfb9474a0e958f3a5c13');
INSERT INTO download_photo VALUES ('249', '29', '18', '250', '5986', '1369394569', '0', '175c8b037f60bd8858fcd386457e1d07');
INSERT INTO download_photo VALUES ('250', '29', '18', '251', '0', '1369394569', '0', '7c7a79d9f1df66c8a3aac7dce30280c4');
INSERT INTO download_photo VALUES ('251', '29', '18', '252', '0', '1369394569', '0', '1dcd4324fb3281acc80e7fa4e733eca5');
INSERT INTO download_photo VALUES ('252', '29', '18', '253', '0', '1369394569', '0', '45f0c8a8195888940edea347e181dbce');
INSERT INTO download_photo VALUES ('253', '29', '28', '254', '5986', '1369397585', '0', 'a16996fbeedcedb853b27fa1ceceb6ad');
INSERT INTO download_photo VALUES ('254', '29', '28', '255', '0', '1369397585', '0', '2ae1c686fbede5f42a45e50a401e31c8');
INSERT INTO download_photo VALUES ('255', '29', '28', '256', '0', '1369397585', '0', '423eb50b085822edc506401b8e69f6e4');
INSERT INTO download_photo VALUES ('256', '29', '28', '257', '0', '1369397585', '0', 'a7ff946fcae8841d8c09787818def8d1');
INSERT INTO download_photo VALUES ('257', '29', '30', '258', '5986', '1369397952', '0', '245232e212b17c22a73be618dc5640cf');
INSERT INTO download_photo VALUES ('258', '29', '30', '259', '0', '1369397952', '0', '8b761bb4540f5828781178ea39f9624d');
INSERT INTO download_photo VALUES ('259', '29', '30', '260', '0', '1369397952', '0', '802a98117aae8173e9770e46fb57e445');
INSERT INTO download_photo VALUES ('260', '29', '30', '261', '0', '1369397952', '0', '514e5dade0ea704fecc7bffcdc9975d4');
INSERT INTO download_photo VALUES ('261', '29', '37', '262', '5986', '1369398286', '0', '50e9071b506ac3bb1d9d57d7d08c9de2');
INSERT INTO download_photo VALUES ('262', '29', '37', '263', '0', '1369398286', '0', 'f414d6861b0c2ba17708e74b8e6429b1');
INSERT INTO download_photo VALUES ('263', '29', '37', '264', '0', '1369398286', '0', '883d6f7429cdca54ce84ace7ef465355');
INSERT INTO download_photo VALUES ('264', '29', '37', '265', '0', '1369398286', '0', '5d5e539218074602e02ee1eb541fb611');
INSERT INTO download_photo VALUES ('265', '29', '37', '266', '5990', '1369398286', '0', '4d0d428cc62d401d7a74ae11bb9d606f');
INSERT INTO download_photo VALUES ('266', '29', '39', '267', '5986', '1369398376', '0', '6e1ab24414f6782f7ec3fbd87575b576');
INSERT INTO download_photo VALUES ('267', '29', '39', '268', '0', '1369398376', '0', 'e3620a2fb349c10e68c82d268f12e023');
INSERT INTO download_photo VALUES ('268', '29', '39', '269', '0', '1369398376', '0', 'cf869487209f8a3bdd59b1e385f3a636');
INSERT INTO download_photo VALUES ('269', '29', '39', '270', '0', '1369398376', '0', '76744788b14cdf9cc543d7eb9d078440');
INSERT INTO download_photo VALUES ('270', '29', '39', '271', '5990', '1369398376', '0', '36618efca1a7f3644a0c14bb0a06e71f');
INSERT INTO download_photo VALUES ('271', '29', '42', '272', '5983', '1369403195', '0', 'f2c06a18f229572dede66fd51b667659');
INSERT INTO download_photo VALUES ('272', '29', '42', '273', '0', '1369403195', '0', 'e8cb8fb6895d2afb748724278225f23c');
INSERT INTO download_photo VALUES ('273', '29', '42', '274', '0', '1369403195', '0', 'c30988a54400d1660d345b9b895fb9ab');
INSERT INTO download_photo VALUES ('274', '29', '42', '275', '0', '1369403195', '0', '4ed4c1a5ecb52c5a3b94af6bd0d76f71');
INSERT INTO download_photo VALUES ('275', '29', '43', '276', '5983', '1369403222', '0', 'fda06ce7ff95a4ca6d139cf5a1e85080');
INSERT INTO download_photo VALUES ('276', '29', '43', '277', '0', '1369403222', '0', 'c7feed08aab5dcef5bf43b939d1c3e49');
INSERT INTO download_photo VALUES ('277', '29', '43', '278', '0', '1369403222', '0', 'da871dd75e3c0c72beaeebbe100273a4');
INSERT INTO download_photo VALUES ('278', '29', '43', '279', '0', '1369403222', '0', '267e144ac899503af396f6abb457b851');
INSERT INTO download_photo VALUES ('279', '29', '44', '280', '5986', '1369403975', '0', '717cd5084404f11bb766b2292ab6764b');
INSERT INTO download_photo VALUES ('280', '29', '44', '281', '0', '1369403975', '0', '076fb924e6fac6076b9b36e2ac162e32');
INSERT INTO download_photo VALUES ('281', '29', '44', '282', '0', '1369403975', '0', 'e0a2192532ba91639cb850d828e66fd7');
INSERT INTO download_photo VALUES ('282', '29', '44', '283', '0', '1369403975', '0', 'c932acf1d89e63f82c4a62d1e2087c28');
INSERT INTO download_photo VALUES ('283', '29', '45', '284', '5986', '1369404001', '0', 'eec9cd131bb48b7dd329e67a2a5c96cc');
INSERT INTO download_photo VALUES ('284', '29', '45', '285', '0', '1369404001', '0', 'ac2cb651c8b11c233211fba2991981a6');
INSERT INTO download_photo VALUES ('285', '29', '45', '286', '0', '1369404001', '0', 'd564cd5c5ac162fdf13adc7cdf5e2a7d');
INSERT INTO download_photo VALUES ('286', '29', '45', '287', '0', '1369404001', '0', 'd67f6eea7c5d8d2e34c5055759228f69');
INSERT INTO download_photo VALUES ('287', '29', '46', '288', '5986', '1369404620', '0', '68ca44b91c2f9cd271314f6e24d80190');
INSERT INTO download_photo VALUES ('288', '29', '46', '289', '0', '1369404620', '0', 'e4d7fee77dbeb54f7d43a6aa31e77fb1');
INSERT INTO download_photo VALUES ('289', '29', '46', '290', '0', '1369404620', '0', '46dddb1321c63b4af07926d5d8957cb1');
INSERT INTO download_photo VALUES ('290', '29', '46', '291', '0', '1369404620', '0', '0193e99fe29a62dca86500b7e49bf1e5');
INSERT INTO download_photo VALUES ('291', '29', '47', '292', '5986', '1369404838', '0', '23201e6750b94d419d63fff8a3d0b0f9');
INSERT INTO download_photo VALUES ('292', '29', '47', '293', '0', '1369404838', '0', '57aecbe96d8f10b14f266cccfb1b0867');
INSERT INTO download_photo VALUES ('293', '29', '47', '294', '0', '1369404838', '0', 'b10aae40e4f98bbdecb3c60f19f6d57a');
INSERT INTO download_photo VALUES ('294', '29', '47', '295', '0', '1369404838', '0', '8361951495d82a931c72fd244b00d9bc');
INSERT INTO download_photo VALUES ('295', '29', '48', '296', '5983', '1369404867', '0', '3ee0511eacd9a498fc545416f79e434f');
INSERT INTO download_photo VALUES ('296', '29', '48', '297', '0', '1369404867', '0', 'd9d4380530b624ea8580cca4767a2396');
INSERT INTO download_photo VALUES ('297', '29', '48', '298', '0', '1369404867', '0', 'b0fd74952909d7b720be62c55c1d60a5');
INSERT INTO download_photo VALUES ('298', '29', '48', '299', '0', '1369404867', '0', 'cce823b6af2711791d3e154609817ab6');
INSERT INTO download_photo VALUES ('299', '29', '49', '300', '5983', '1369404983', '0', '537f096508307df07259131846630330');
INSERT INTO download_photo VALUES ('300', '29', '49', '301', '0', '1369404983', '0', 'e615f38ab6a9a59c2b5705be909691bd');
INSERT INTO download_photo VALUES ('301', '29', '49', '302', '0', '1369404983', '0', '4ff7d48153741650339ed07c80a77ad6');
INSERT INTO download_photo VALUES ('302', '29', '49', '303', '0', '1369404983', '0', 'ac7f34e3834d27f97444f6dedf648915');
INSERT INTO download_photo VALUES ('303', '29', '50', '304', '5986', '1369405348', '0', '9c9477dab1aa9de6e00e410d4c00b9ff');
INSERT INTO download_photo VALUES ('304', '29', '50', '305', '0', '1369405348', '0', 'd4b9267b53b71dc46c9a4add8cfa6399');
INSERT INTO download_photo VALUES ('305', '29', '50', '306', '0', '1369405348', '0', 'b1b5f2a577be58905115e23a3144e240');
INSERT INTO download_photo VALUES ('306', '29', '50', '307', '0', '1369405348', '0', '0ec59c68c5f747016d6dce91f6200342');
INSERT INTO download_photo VALUES ('307', '29', '51', '308', '5986', '1369405574', '0', '5de76a44e88dad592252331b54fba5a5');
INSERT INTO download_photo VALUES ('308', '29', '51', '309', '0', '1369405574', '0', 'cb224046b8a3753532007b8c7841e7cb');
INSERT INTO download_photo VALUES ('309', '29', '51', '310', '0', '1369405574', '0', '222f46375eb708eba1903ccbca2ed694');
INSERT INTO download_photo VALUES ('310', '29', '51', '311', '0', '1369405574', '0', 'ff475cffe0536d78194020cb8815c0cd');
INSERT INTO download_photo VALUES ('311', '29', '52', '312', '5986', '1369405682', '0', 'fbb3b4a26f6b07db2f8c4c0173f48523');
INSERT INTO download_photo VALUES ('312', '29', '52', '313', '0', '1369405682', '0', 'b13b95d32025cffa332f62708b3d363c');
INSERT INTO download_photo VALUES ('313', '29', '52', '314', '0', '1369405682', '0', '391a93a9e6c823bd7dd68b31b5d6305c');
INSERT INTO download_photo VALUES ('314', '29', '52', '315', '0', '1369405682', '0', 'dd6b125a52b36ce3e476ce898e052920');
INSERT INTO download_photo VALUES ('315', '29', '53', '316', '5982', '1369405907', '0', '02d0905fa3c43ac0f954410f27ca44be');
INSERT INTO download_photo VALUES ('316', '29', '53', '317', '0', '1369405907', '0', 'e9a4da61a3c61144006d79655787af43');
INSERT INTO download_photo VALUES ('317', '29', '53', '318', '0', '1369405907', '0', '2ab4580f38eddb04f2f4f0c6dc9bd023');
INSERT INTO download_photo VALUES ('318', '29', '53', '319', '0', '1369405907', '0', 'c1d61243da86c22d002b43049a8bed1e');
INSERT INTO download_photo VALUES ('319', '29', '54', '320', '5986', '1369426295', '0', 'a9a8ffce1a4b84faa742bbac8cd33395');
INSERT INTO download_photo VALUES ('320', '29', '54', '321', '5990', '1369426295', '0', '854d85775d8d52d1747a5f9180b44617');
INSERT INTO download_photo VALUES ('321', '29', '54', '322', '0', '1369426295', '0', '9a58d16f66b112b5dcc5b1aeb640cc0f');
INSERT INTO download_photo VALUES ('322', '29', '54', '323', '0', '1369426295', '0', '49df301e8ab444268f3ddbe37e92c228');
INSERT INTO download_photo VALUES ('323', '29', '54', '324', '0', '1369426295', '0', 'fd3ab8bb8bf4bf8b4b5b8256e70210c1');
INSERT INTO download_photo VALUES ('324', '29', '55', '325', '5990', '1369426760', '0', '6b6893e9b55a9d737daa1fc757caee71');
INSERT INTO download_photo VALUES ('325', '29', '55', '326', '0', '1369426760', '0', '375d5a92bd37d4018910eb6f14a8f68b');
INSERT INTO download_photo VALUES ('326', '29', '55', '327', '0', '1369426760', '0', '450fa707eeac58bac1a09bc58a719eda');
INSERT INTO download_photo VALUES ('327', '29', '55', '328', '0', '1369426760', '0', 'c7a4215fea8b994c87ff374ef28c0cf4');
INSERT INTO download_photo VALUES ('328', '29', '56', '329', '5990', '1369427107', '0', 'b24cebd38f6f8c926454939cb55d0bdf');
INSERT INTO download_photo VALUES ('329', '29', '56', '330', '0', '1369427107', '0', '58a733a8209bef82f3f68f3d792378f9');
INSERT INTO download_photo VALUES ('330', '29', '56', '331', '0', '1369427107', '0', 'd28981448099dfa1c2bf46528b4e0456');
INSERT INTO download_photo VALUES ('331', '29', '56', '332', '0', '1369427107', '0', 'b12f1919c7f081f9848192b1bec8bfa0');
INSERT INTO download_photo VALUES ('332', '29', '57', '333', '5990', '1369427472', '0', '7f5f78a8f02f3cd7bfeda69ff463e140');
INSERT INTO download_photo VALUES ('333', '29', '57', '334', '0', '1369427472', '0', 'ed77730065d3d6e20dfc9ea20cc886d8');
INSERT INTO download_photo VALUES ('334', '29', '57', '335', '0', '1369427472', '0', '14f7320ed6aad7297cc40dd8aa101762');
INSERT INTO download_photo VALUES ('335', '29', '57', '336', '0', '1369427472', '0', '6b7de024a36c7978e2a8d72ee8c1125c');
INSERT INTO download_photo VALUES ('336', '29', '58', '337', '5986', '1369427605', '0', 'ca8cb8a614d8a3c66229565edd8707aa');
INSERT INTO download_photo VALUES ('337', '29', '58', '338', '0', '1369427605', '0', '17329007c37521c00e5d6005cd6ce03e');
INSERT INTO download_photo VALUES ('338', '29', '58', '339', '0', '1369427605', '0', 'b66cddfd2c5e818845c6ef06b33675b9');
INSERT INTO download_photo VALUES ('339', '29', '58', '340', '0', '1369427605', '0', '576c5542fcf3457adac54a1fc9577159');
INSERT INTO download_photo VALUES ('340', '29', '59', '341', '5990', '1369462898', '0', '1fadd2b34e21d916c6b4d59b3bbef757');
INSERT INTO download_photo VALUES ('341', '29', '60', '342', '6106', '1369464337', '0', 'db75404d2d16f6490db870961e8eeb42');
INSERT INTO download_photo VALUES ('342', '29', '61', '343', '5986', '1369464536', '0', '8c813901f11c3db3287f03ff375e591c');
INSERT INTO download_photo VALUES ('343', '29', '62', '344', '5983', '1369466365', '0', '7cd28a87030594e51a3e1a558535b321');
INSERT INTO download_photo VALUES ('344', '29', '63', '345', '5990', '1369466547', '0', '1d809c160b8ff72a56ef6ac6f662dbcb');
INSERT INTO download_photo VALUES ('345', '29', '64', '346', '5983', '1369466717', '0', 'f2a5ea675e3b57b5e172a11f54a27557');
INSERT INTO download_photo VALUES ('346', '29', '64', '347', '5986', '1369466717', '0', '99e5a378336a370a997e8648a2e33b34');
INSERT INTO download_photo VALUES ('347', '29', '64', '348', '5990', '1369466717', '0', '5137aff9c3e8f803f729efdfbb86296c');
INSERT INTO download_photo VALUES ('348', '29', '64', '349', '5991', '1369466717', '0', 'e45b1fc0ebafd4936f802a6c83df2e95');
INSERT INTO download_photo VALUES ('349', '29', '65', '350', '5983', '2013', '0', 'bf554728f7fe02cafb4c05abf4c5a1ab');
INSERT INTO download_photo VALUES ('350', '29', '65', '351', '5986', '2013', '0', '846dc8d1c00679747fe5d7a8e6e8f322');
INSERT INTO download_photo VALUES ('351', '29', '65', '352', '5990', '2013', '0', 'c6dc28dcda818352529c6a762c41b79a');
INSERT INTO download_photo VALUES ('352', '29', '188', '353', '5995', '1370992691', '1', 'bd32780a4bbc577b48547b2f45e9cd52');


#
# Table structure for table `nastr`
#

DROP TABLE IF EXISTS `nastr`;
CREATE TABLE `nastr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `param_index` varchar(64) NOT NULL,
  `param_name` varchar(64) NOT NULL,
  `param_value` varchar(64) NOT NULL,
  `param_descr` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `param_name` (`param_name`)
) ENGINE=MyISAM AUTO_INCREMENT=1117 DEFAULT CHARSET=cp1251 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

#
# Dumping data for table `nastr`
#

INSERT INTO nastr VALUES ('1', '0', 'ftp_host', 'fotosait.no-ip.org', 'FTP-хост фотобанка:');
INSERT INTO nastr VALUES ('2', '0', 'ftp_user', 'add', 'FTP-пользователь фотобанка:');
INSERT INTO nastr VALUES ('3', '0', 'ftp_pass', 'Foto_arhiv_27', 'FTP-пароль фотобанка:');
INSERT INTO nastr VALUES ('4', '1', 'nm_pocta', 'Новая  почта', 'Название почтового отделения №1:');
INSERT INTO nastr VALUES ('5', '1', 'http_pocta', 'http://novaposhta.ua/frontend/calculator/ru', 'Электронный адресс почтового отделения № 1:');
INSERT INTO nastr VALUES ('14', '2', 'dostavka', 'Самовывоз из студии (в Одессе)', 'Доставка №2');
INSERT INTO nastr VALUES ('15', '3', 'dostavka', 'Самовывоз из почтового отделения Вашего города', 'Доставка №3');
INSERT INTO nastr VALUES ('16', '4', 'dostavka', 'Доставка до двери почтовой службой (кроме Одессы)', 'Доставка №4');
INSERT INTO nastr VALUES ('6', '2', 'nm_pocta', 'Укрпочта', 'Название почтового отделения №2:');
INSERT INTO nastr VALUES ('7', '2', 'http_pocta', 'http://services.ukrposhta.com/CalcUtil/PostalMails.aspx', 'Электронный адресс почтового отделения № 2:');
INSERT INTO nastr VALUES ('20', '1', 'adr_pecat', 'Одесса, ул.Ленина 48', 'Адресс студии печати №1:');
INSERT INTO nastr VALUES ('21', '1', 'ftp_pecat_host', '91.90.9.27', 'FTP-хост студии №1:');
INSERT INTO nastr VALUES ('22', '1', 'ftp_pecat_user', 'Alekseeva', 'FTP-пользователь студии №1:');
INSERT INTO nastr VALUES ('23', '1', 'ftp_pecat_pass', 'Alekseeva', 'FTP-пароль студии №1:');
INSERT INTO nastr VALUES ('9', '1', 'oplata', 'пополнение баланса сайта', 'Вид оплаты №1');
INSERT INTO nastr VALUES ('10', '2', 'oplata', 'наложенный платеж', 'Вид оплаты №2');
INSERT INTO nastr VALUES ('13', '1', 'dostavka', 'Передать тренеру команды (в Одессе при полной предоплате)', 'Доставка №1');
INSERT INTO nastr VALUES ('12', '3', 'oplata', 'другое', 'Вид оплаты №4');
INSERT INTO nastr VALUES ('18', '6', 'dostavka', 'другое', 'Доставка №6');
INSERT INTO nastr VALUES ('24', '2', 'adr_pecat', 'Одесса, ул.Пушкинская (напротив цума)', 'Адресс студии печати №2:');
INSERT INTO nastr VALUES ('25', '2', 'ftp_pecat_host', '94.158.147.163', 'FTP-хост студии №2:');
INSERT INTO nastr VALUES ('26', '2', 'ftp_pecat_user', 'Alexeeva', 'FTP-пользователь студии №2:');
INSERT INTO nastr VALUES ('27', '2', 'ftp_pecat_pass', 'alex2013', 'FTP-пароль студии №2:');
INSERT INTO nastr VALUES ('17', '5', 'dostavka', 'Самовывоз от фотографа', 'Доставка №5');


#
# Table structure for table `order_items`
#

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_order` int(11) NOT NULL DEFAULT '0',
  `id_photo` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_order` (`id_order`)
) ENGINE=MyISAM AUTO_INCREMENT=354 DEFAULT CHARSET=cp1251;

#
# Dumping data for table `order_items`
#

INSERT INTO order_items VALUES ('89', '63', '2920');
INSERT INTO order_items VALUES ('88', '62', '2908');
INSERT INTO order_items VALUES ('87', '62', '2922');
INSERT INTO order_items VALUES ('86', '62', '2923');
INSERT INTO order_items VALUES ('85', '62', '2924');
INSERT INTO order_items VALUES ('84', '62', '2925');
INSERT INTO order_items VALUES ('83', '61', '2899');
INSERT INTO order_items VALUES ('82', '61', '2924');
INSERT INTO order_items VALUES ('81', '61', '2879');
INSERT INTO order_items VALUES ('93', '63', '2916');
INSERT INTO order_items VALUES ('92', '63', '2917');
INSERT INTO order_items VALUES ('91', '63', '2918');
INSERT INTO order_items VALUES ('90', '63', '2919');
INSERT INTO order_items VALUES ('80', '61', '2881');
INSERT INTO order_items VALUES ('79', '61', '2882');
INSERT INTO order_items VALUES ('78', '60', '2882');
INSERT INTO order_items VALUES ('77', '60', '2878');
INSERT INTO order_items VALUES ('76', '60', '2887');
INSERT INTO order_items VALUES ('75', '60', '2888');
INSERT INTO order_items VALUES ('74', '60', '2895');
INSERT INTO order_items VALUES ('73', '60', '2892');
INSERT INTO order_items VALUES ('72', '60', '2890');
INSERT INTO order_items VALUES ('94', '63', '2915');
INSERT INTO order_items VALUES ('95', '63', '2914');
INSERT INTO order_items VALUES ('96', '63', '2913');
INSERT INTO order_items VALUES ('97', '63', '2912');
INSERT INTO order_items VALUES ('98', '63', '2911');
INSERT INTO order_items VALUES ('99', '63', '2910');
INSERT INTO order_items VALUES ('100', '63', '2909');
INSERT INTO order_items VALUES ('101', '63', '2895');
INSERT INTO order_items VALUES ('102', '64', '2933');
INSERT INTO order_items VALUES ('103', '64', '2932');
INSERT INTO order_items VALUES ('104', '64', '2931');
INSERT INTO order_items VALUES ('105', '65', '2935');
INSERT INTO order_items VALUES ('106', '65', '2934');
INSERT INTO order_items VALUES ('107', '66', '2944');
INSERT INTO order_items VALUES ('108', '66', '2943');
INSERT INTO order_items VALUES ('109', '66', '2942');
INSERT INTO order_items VALUES ('110', '67', '2948');
INSERT INTO order_items VALUES ('111', '67', '2947');
INSERT INTO order_items VALUES ('112', '67', '2946');
INSERT INTO order_items VALUES ('113', '68', '4753');
INSERT INTO order_items VALUES ('114', '68', '4756');
INSERT INTO order_items VALUES ('115', '72', '5285');
INSERT INTO order_items VALUES ('116', '72', '5287');
INSERT INTO order_items VALUES ('117', '72', '5288');
INSERT INTO order_items VALUES ('118', '73', '5352');
INSERT INTO order_items VALUES ('119', '73', '5268');
INSERT INTO order_items VALUES ('120', '74', '5267');
INSERT INTO order_items VALUES ('121', '74', '5266');
INSERT INTO order_items VALUES ('122', '75', '5351');
INSERT INTO order_items VALUES ('123', '75', '5323');
INSERT INTO order_items VALUES ('124', '76', '5267');
INSERT INTO order_items VALUES ('125', '77', '5275');
INSERT INTO order_items VALUES ('126', '82', '5956');
INSERT INTO order_items VALUES ('127', '82', '5982');
INSERT INTO order_items VALUES ('135', '86', '5986');
INSERT INTO order_items VALUES ('134', '86', '6011');
INSERT INTO order_items VALUES ('130', '84', '5956');
INSERT INTO order_items VALUES ('131', '84', '5973');
INSERT INTO order_items VALUES ('132', '85', '5972');
INSERT INTO order_items VALUES ('133', '85', '6166');
INSERT INTO order_items VALUES ('136', '87', '6021');
INSERT INTO order_items VALUES ('137', '87', '6023');
INSERT INTO order_items VALUES ('138', '87', '6025');
INSERT INTO order_items VALUES ('139', '88', '6003');
INSERT INTO order_items VALUES ('183', '155', '5986');
INSERT INTO order_items VALUES ('141', '90', '5983');
INSERT INTO order_items VALUES ('142', '91', '5986');
INSERT INTO order_items VALUES ('143', '92', '5990');
INSERT INTO order_items VALUES ('144', '93', '5990');
INSERT INTO order_items VALUES ('145', '94', '5986');
INSERT INTO order_items VALUES ('146', '95', '6004');
INSERT INTO order_items VALUES ('147', '96', '5986');
INSERT INTO order_items VALUES ('148', '97', '5983');
INSERT INTO order_items VALUES ('149', '98', '5990');
INSERT INTO order_items VALUES ('150', '99', '5982');
INSERT INTO order_items VALUES ('151', '99', '5983');
INSERT INTO order_items VALUES ('152', '99', '5990');
INSERT INTO order_items VALUES ('153', '99', '5991');
INSERT INTO order_items VALUES ('154', '99', '5993');
INSERT INTO order_items VALUES ('155', '99', '6011');
INSERT INTO order_items VALUES ('156', '99', '6012');
INSERT INTO order_items VALUES ('157', '99', '6014');
INSERT INTO order_items VALUES ('158', '99', '5986');
INSERT INTO order_items VALUES ('159', '0', '5990');
INSERT INTO order_items VALUES ('160', '100', '6492');
INSERT INTO order_items VALUES ('161', '103', '5990');
INSERT INTO order_items VALUES ('162', '104', '5986');
INSERT INTO order_items VALUES ('163', '105', '5990');
INSERT INTO order_items VALUES ('164', '105', '5986');
INSERT INTO order_items VALUES ('165', '105', '6032');
INSERT INTO order_items VALUES ('166', '105', '6101');
INSERT INTO order_items VALUES ('167', '151', '6492');
INSERT INTO order_items VALUES ('168', '151', '5990');
INSERT INTO order_items VALUES ('169', '151', '6158');
INSERT INTO order_items VALUES ('170', '151', '6159');
INSERT INTO order_items VALUES ('171', '151', '6160');
INSERT INTO order_items VALUES ('172', '152', '6004');
INSERT INTO order_items VALUES ('173', '153', '6010');
INSERT INTO order_items VALUES ('174', '153', '5982');
INSERT INTO order_items VALUES ('175', '153', '5990');
INSERT INTO order_items VALUES ('176', '153', '5986');
INSERT INTO order_items VALUES ('177', '153', '6011');
INSERT INTO order_items VALUES ('178', '154', '5986');
INSERT INTO order_items VALUES ('179', '154', '6021');
INSERT INTO order_items VALUES ('180', '154', '6023');
INSERT INTO order_items VALUES ('181', '154', '6025');
INSERT INTO order_items VALUES ('182', '154', '6026');
INSERT INTO order_items VALUES ('184', '156', '6006');
INSERT INTO order_items VALUES ('185', '156', '6007');
INSERT INTO order_items VALUES ('186', '156', '6008');
INSERT INTO order_items VALUES ('187', '157', '6006');
INSERT INTO order_items VALUES ('188', '157', '6008');
INSERT INTO order_items VALUES ('189', '168', '6012');
INSERT INTO order_items VALUES ('190', '168', '6013');
INSERT INTO order_items VALUES ('191', '168', '6014');
INSERT INTO order_items VALUES ('192', '168', '6020');
INSERT INTO order_items VALUES ('193', '168', '6021');
INSERT INTO order_items VALUES ('194', '169', '5986');
INSERT INTO order_items VALUES ('195', '169', '5990');
INSERT INTO order_items VALUES ('196', '169', '5991');
INSERT INTO order_items VALUES ('197', '171', '5986');
INSERT INTO order_items VALUES ('198', '172', '5986');
INSERT INTO order_items VALUES ('199', '172', '5990');
INSERT INTO order_items VALUES ('200', '172', '6045');
INSERT INTO order_items VALUES ('201', '172', '6046');
INSERT INTO order_items VALUES ('202', '172', '6047');
INSERT INTO order_items VALUES ('203', '172', '6048');
INSERT INTO order_items VALUES ('204', '172', '6053');
INSERT INTO order_items VALUES ('205', '172', '6055');
INSERT INTO order_items VALUES ('206', '172', '6056');
INSERT INTO order_items VALUES ('207', '172', '6059');
INSERT INTO order_items VALUES ('208', '172', '6060');
INSERT INTO order_items VALUES ('209', '172', '6061');
INSERT INTO order_items VALUES ('210', '172', '6063');
INSERT INTO order_items VALUES ('211', '172', '6065');
INSERT INTO order_items VALUES ('212', '172', '6072');
INSERT INTO order_items VALUES ('213', '172', '6073');
INSERT INTO order_items VALUES ('214', '172', '6075');
INSERT INTO order_items VALUES ('215', '172', '6076');
INSERT INTO order_items VALUES ('216', '172', '6080');
INSERT INTO order_items VALUES ('217', '172', '6083');
INSERT INTO order_items VALUES ('218', '172', '0');
INSERT INTO order_items VALUES ('219', '172', '0');
INSERT INTO order_items VALUES ('220', '172', '0');
INSERT INTO order_items VALUES ('221', '173', '6006');
INSERT INTO order_items VALUES ('222', '173', '6007');
INSERT INTO order_items VALUES ('223', '173', '6008');
INSERT INTO order_items VALUES ('224', '173', '6009');
INSERT INTO order_items VALUES ('225', '173', '6010');
INSERT INTO order_items VALUES ('226', '173', '6012');
INSERT INTO order_items VALUES ('227', '173', '6013');
INSERT INTO order_items VALUES ('228', '173', '6014');
INSERT INTO order_items VALUES ('229', '173', '6083');
INSERT INTO order_items VALUES ('230', '173', '6084');
INSERT INTO order_items VALUES ('231', '173', '0');
INSERT INTO order_items VALUES ('232', '173', '0');
INSERT INTO order_items VALUES ('233', '173', '0');
INSERT INTO order_items VALUES ('234', '13', '6005');
INSERT INTO order_items VALUES ('235', '13', '6006');
INSERT INTO order_items VALUES ('236', '13', '6007');
INSERT INTO order_items VALUES ('237', '13', '6008');
INSERT INTO order_items VALUES ('238', '13', '0');
INSERT INTO order_items VALUES ('239', '13', '0');
INSERT INTO order_items VALUES ('240', '13', '0');
INSERT INTO order_items VALUES ('241', '15', '6006');
INSERT INTO order_items VALUES ('242', '15', '0');
INSERT INTO order_items VALUES ('243', '15', '0');
INSERT INTO order_items VALUES ('244', '15', '0');
INSERT INTO order_items VALUES ('245', '17', '5990');
INSERT INTO order_items VALUES ('246', '17', '0');
INSERT INTO order_items VALUES ('247', '17', '0');
INSERT INTO order_items VALUES ('248', '17', '0');
INSERT INTO order_items VALUES ('249', '17', '5986');
INSERT INTO order_items VALUES ('250', '18', '5986');
INSERT INTO order_items VALUES ('251', '18', '0');
INSERT INTO order_items VALUES ('252', '18', '0');
INSERT INTO order_items VALUES ('253', '18', '0');
INSERT INTO order_items VALUES ('254', '28', '5986');
INSERT INTO order_items VALUES ('255', '28', '0');
INSERT INTO order_items VALUES ('256', '28', '0');
INSERT INTO order_items VALUES ('257', '28', '0');
INSERT INTO order_items VALUES ('258', '30', '5986');
INSERT INTO order_items VALUES ('259', '30', '0');
INSERT INTO order_items VALUES ('260', '30', '0');
INSERT INTO order_items VALUES ('261', '30', '0');
INSERT INTO order_items VALUES ('262', '37', '5986');
INSERT INTO order_items VALUES ('263', '37', '0');
INSERT INTO order_items VALUES ('264', '37', '0');
INSERT INTO order_items VALUES ('265', '37', '0');
INSERT INTO order_items VALUES ('266', '37', '5990');
INSERT INTO order_items VALUES ('267', '39', '5986');
INSERT INTO order_items VALUES ('268', '39', '0');
INSERT INTO order_items VALUES ('269', '39', '0');
INSERT INTO order_items VALUES ('270', '39', '0');
INSERT INTO order_items VALUES ('271', '39', '5990');
INSERT INTO order_items VALUES ('272', '42', '5983');
INSERT INTO order_items VALUES ('273', '42', '0');
INSERT INTO order_items VALUES ('274', '42', '0');
INSERT INTO order_items VALUES ('275', '42', '0');
INSERT INTO order_items VALUES ('276', '43', '5983');
INSERT INTO order_items VALUES ('277', '43', '0');
INSERT INTO order_items VALUES ('278', '43', '0');
INSERT INTO order_items VALUES ('279', '43', '0');
INSERT INTO order_items VALUES ('280', '44', '5986');
INSERT INTO order_items VALUES ('281', '44', '0');
INSERT INTO order_items VALUES ('282', '44', '0');
INSERT INTO order_items VALUES ('283', '44', '0');
INSERT INTO order_items VALUES ('284', '45', '5986');
INSERT INTO order_items VALUES ('285', '45', '0');
INSERT INTO order_items VALUES ('286', '45', '0');
INSERT INTO order_items VALUES ('287', '45', '0');
INSERT INTO order_items VALUES ('288', '46', '5986');
INSERT INTO order_items VALUES ('289', '46', '0');
INSERT INTO order_items VALUES ('290', '46', '0');
INSERT INTO order_items VALUES ('291', '46', '0');
INSERT INTO order_items VALUES ('292', '47', '5986');
INSERT INTO order_items VALUES ('293', '47', '0');
INSERT INTO order_items VALUES ('294', '47', '0');
INSERT INTO order_items VALUES ('295', '47', '0');
INSERT INTO order_items VALUES ('296', '48', '5983');
INSERT INTO order_items VALUES ('297', '48', '0');
INSERT INTO order_items VALUES ('298', '48', '0');
INSERT INTO order_items VALUES ('299', '48', '0');
INSERT INTO order_items VALUES ('300', '49', '5983');
INSERT INTO order_items VALUES ('301', '49', '0');
INSERT INTO order_items VALUES ('302', '49', '0');
INSERT INTO order_items VALUES ('303', '49', '0');
INSERT INTO order_items VALUES ('304', '50', '5986');
INSERT INTO order_items VALUES ('305', '50', '0');
INSERT INTO order_items VALUES ('306', '50', '0');
INSERT INTO order_items VALUES ('307', '50', '0');
INSERT INTO order_items VALUES ('308', '51', '5986');
INSERT INTO order_items VALUES ('309', '51', '0');
INSERT INTO order_items VALUES ('310', '51', '0');
INSERT INTO order_items VALUES ('311', '51', '0');
INSERT INTO order_items VALUES ('312', '52', '5986');
INSERT INTO order_items VALUES ('313', '52', '0');
INSERT INTO order_items VALUES ('314', '52', '0');
INSERT INTO order_items VALUES ('315', '52', '0');
INSERT INTO order_items VALUES ('316', '53', '5982');
INSERT INTO order_items VALUES ('317', '53', '0');
INSERT INTO order_items VALUES ('318', '53', '0');
INSERT INTO order_items VALUES ('319', '53', '0');
INSERT INTO order_items VALUES ('320', '54', '5986');
INSERT INTO order_items VALUES ('321', '54', '5990');
INSERT INTO order_items VALUES ('322', '54', '0');
INSERT INTO order_items VALUES ('323', '54', '0');
INSERT INTO order_items VALUES ('324', '54', '0');
INSERT INTO order_items VALUES ('325', '55', '5990');
INSERT INTO order_items VALUES ('326', '55', '0');
INSERT INTO order_items VALUES ('327', '55', '0');
INSERT INTO order_items VALUES ('328', '55', '0');
INSERT INTO order_items VALUES ('329', '56', '5990');
INSERT INTO order_items VALUES ('330', '56', '0');
INSERT INTO order_items VALUES ('331', '56', '0');
INSERT INTO order_items VALUES ('332', '56', '0');
INSERT INTO order_items VALUES ('333', '57', '5990');
INSERT INTO order_items VALUES ('334', '57', '0');
INSERT INTO order_items VALUES ('335', '57', '0');
INSERT INTO order_items VALUES ('336', '57', '0');
INSERT INTO order_items VALUES ('337', '58', '5986');
INSERT INTO order_items VALUES ('338', '58', '0');
INSERT INTO order_items VALUES ('339', '58', '0');
INSERT INTO order_items VALUES ('340', '58', '0');
INSERT INTO order_items VALUES ('341', '59', '5990');
INSERT INTO order_items VALUES ('342', '60', '6106');
INSERT INTO order_items VALUES ('343', '61', '5986');
INSERT INTO order_items VALUES ('344', '62', '5983');
INSERT INTO order_items VALUES ('345', '63', '5990');
INSERT INTO order_items VALUES ('346', '64', '5983');
INSERT INTO order_items VALUES ('347', '64', '5986');
INSERT INTO order_items VALUES ('348', '64', '5990');
INSERT INTO order_items VALUES ('349', '64', '5991');
INSERT INTO order_items VALUES ('350', '65', '5983');
INSERT INTO order_items VALUES ('351', '65', '5986');
INSERT INTO order_items VALUES ('352', '65', '5990');
INSERT INTO order_items VALUES ('353', '188', '5995');


#
# Table structure for table `order_print`
#

DROP TABLE IF EXISTS `order_print`;
CREATE TABLE `order_print` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_print` int(11) NOT NULL,
  `id_photo` int(11) NOT NULL,
  `koll` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id_order` (`id_print`)
) ENGINE=MyISAM AUTO_INCREMENT=207 DEFAULT CHARSET=cp1251 COMMENT='Заказы на печать';

#
# Dumping data for table `order_print`
#

INSERT INTO order_print VALUES ('192', '116', '6008', '2');
INSERT INTO order_print VALUES ('191', '116', '6006', '1');
INSERT INTO order_print VALUES ('190', '115', '5983', '1');
INSERT INTO order_print VALUES ('189', '114', '5983', '1');
INSERT INTO order_print VALUES ('188', '113', '5990', '1');
INSERT INTO order_print VALUES ('187', '112', '6028', '1');
INSERT INTO order_print VALUES ('186', '111', '5986', '1');
INSERT INTO order_print VALUES ('185', '110', '5986', '2');
INSERT INTO order_print VALUES ('184', '109', '5982', '1');
INSERT INTO order_print VALUES ('183', '108', '5986', '1');
INSERT INTO order_print VALUES ('182', '107', '5986', '1');
INSERT INTO order_print VALUES ('181', '106', '6008', '1');
INSERT INTO order_print VALUES ('180', '106', '6007', '1');
INSERT INTO order_print VALUES ('179', '106', '6006', '1');
INSERT INTO order_print VALUES ('178', '106', '6005', '1');
INSERT INTO order_print VALUES ('177', '106', '6004', '1');
INSERT INTO order_print VALUES ('176', '106', '6003', '1');
INSERT INTO order_print VALUES ('175', '106', '5995', '1');
INSERT INTO order_print VALUES ('174', '106', '5993', '1');
INSERT INTO order_print VALUES ('173', '106', '5991', '1');
INSERT INTO order_print VALUES ('172', '106', '5990', '1');
INSERT INTO order_print VALUES ('171', '106', '5986', '1');
INSERT INTO order_print VALUES ('170', '106', '5983', '1');
INSERT INTO order_print VALUES ('169', '105', '6100', '2');
INSERT INTO order_print VALUES ('168', '105', '6098', '1');
INSERT INTO order_print VALUES ('167', '105', '6097', '3');
INSERT INTO order_print VALUES ('166', '104', '5993', '1');
INSERT INTO order_print VALUES ('165', '103', '5986', '1');
INSERT INTO order_print VALUES ('164', '102', '6055', '2');
INSERT INTO order_print VALUES ('163', '102', '6053', '1');
INSERT INTO order_print VALUES ('162', '102', '6048', '6');
INSERT INTO order_print VALUES ('161', '102', '6047', '4');
INSERT INTO order_print VALUES ('160', '102', '6046', '1');
INSERT INTO order_print VALUES ('159', '102', '6039', '3');
INSERT INTO order_print VALUES ('158', '102', '6038', '2');
INSERT INTO order_print VALUES ('157', '102', '6037', '4');
INSERT INTO order_print VALUES ('156', '102', '6033', '1');
INSERT INTO order_print VALUES ('155', '102', '6031', '1');
INSERT INTO order_print VALUES ('154', '102', '6028', '2');
INSERT INTO order_print VALUES ('153', '102', '6026', '1');
INSERT INTO order_print VALUES ('152', '101', '6028', '4');
INSERT INTO order_print VALUES ('151', '101', '6026', '2');
INSERT INTO order_print VALUES ('150', '100', '5995', '1');
INSERT INTO order_print VALUES ('149', '100', '5993', '2');
INSERT INTO order_print VALUES ('148', '100', '5991', '3');
INSERT INTO order_print VALUES ('147', '100', '5990', '4');
INSERT INTO order_print VALUES ('146', '100', '5986', '5');
INSERT INTO order_print VALUES ('145', '99', '6020', '1');
INSERT INTO order_print VALUES ('144', '99', '6017', '1');
INSERT INTO order_print VALUES ('143', '99', '6014', '1');
INSERT INTO order_print VALUES ('142', '99', '6013', '2');
INSERT INTO order_print VALUES ('141', '98', '5990', '1');
INSERT INTO order_print VALUES ('140', '97', '5986', '1');
INSERT INTO order_print VALUES ('139', '96', '5986', '1');
INSERT INTO order_print VALUES ('138', '96', '5990', '1');
INSERT INTO order_print VALUES ('137', '95', '5990', '1');
INSERT INTO order_print VALUES ('136', '94', '5990', '1');
INSERT INTO order_print VALUES ('135', '93', '5990', '1');
INSERT INTO order_print VALUES ('134', '92', '6097', '2');
INSERT INTO order_print VALUES ('133', '92', '5986', '1');
INSERT INTO order_print VALUES ('132', '91', '5986', '1');
INSERT INTO order_print VALUES ('131', '90', '5986', '1');
INSERT INTO order_print VALUES ('130', '89', '5990', '1');
INSERT INTO order_print VALUES ('129', '88', '5990', '1');
INSERT INTO order_print VALUES ('128', '87', '5990', '1');
INSERT INTO order_print VALUES ('127', '86', '5982', '1');
INSERT INTO order_print VALUES ('126', '85', '5982', '1');
INSERT INTO order_print VALUES ('125', '84', '5986', '1');
INSERT INTO order_print VALUES ('124', '84', '5990', '1');
INSERT INTO order_print VALUES ('123', '83', '5986', '1');
INSERT INTO order_print VALUES ('122', '83', '5983', '1');
INSERT INTO order_print VALUES ('121', '82', '5983', '1');
INSERT INTO order_print VALUES ('120', '82', '5982', '1');
INSERT INTO order_print VALUES ('119', '81', '5990', '1');
INSERT INTO order_print VALUES ('118', '81', '5986', '1');
INSERT INTO order_print VALUES ('117', '80', '5983', '1');
INSERT INTO order_print VALUES ('193', '117', '6087', '1');
INSERT INTO order_print VALUES ('194', '117', '6088', '1');
INSERT INTO order_print VALUES ('195', '117', '6092', '1');
INSERT INTO order_print VALUES ('196', '117', '6094', '1');
INSERT INTO order_print VALUES ('197', '117', '6164', '1');
INSERT INTO order_print VALUES ('198', '118', '6118', '2');
INSERT INTO order_print VALUES ('199', '119', '6038', '1');
INSERT INTO order_print VALUES ('200', '120', '5995', '1');
INSERT INTO order_print VALUES ('201', '121', '6010', '3');
INSERT INTO order_print VALUES ('202', '122', '6359', '1');
INSERT INTO order_print VALUES ('203', '123', '6005', '2');
INSERT INTO order_print VALUES ('204', '124', '5990', '1');
INSERT INTO order_print VALUES ('205', '125', '7380', '2');
INSERT INTO order_print VALUES ('206', '126', '7268', '1');


#
# Table structure for table `orders`
#

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL DEFAULT '0',
  `dt` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=194 DEFAULT CHARSET=cp1251;

#
# Dumping data for table `orders`
#

INSERT INTO orders VALUES ('66', '18', '1360531478', '0');
INSERT INTO orders VALUES ('65', '18', '1360529827', '0');
INSERT INTO orders VALUES ('64', '25', '1360528321', '0');
INSERT INTO orders VALUES ('63', '17', '1360402309', '0');
INSERT INTO orders VALUES ('62', '17', '1360402078', '0');
INSERT INTO orders VALUES ('61', '17', '1360395734', '0');
INSERT INTO orders VALUES ('60', '25', '1360395609', '0');
INSERT INTO orders VALUES ('67', '20', '1360531961', '0');
INSERT INTO orders VALUES ('68', '25', '1361809470', '0');
INSERT INTO orders VALUES ('72', '20', '1364239576', '0');
INSERT INTO orders VALUES ('73', '20', '1364262634', '0');
INSERT INTO orders VALUES ('74', '20', '1364262700', '0');
INSERT INTO orders VALUES ('75', '20', '1364397878', '0');
INSERT INTO orders VALUES ('76', '20', '1364397926', '0');
INSERT INTO orders VALUES ('77', '20', '1364397950', '0');
INSERT INTO orders VALUES ('82', '29', '1367678563', '0');
INSERT INTO orders VALUES ('86', '29', '1367926173', '0');
INSERT INTO orders VALUES ('84', '29', '1367679052', '0');
INSERT INTO orders VALUES ('85', '29', '1367682174', '0');
INSERT INTO orders VALUES ('87', '29', '1368042392', '0');
INSERT INTO orders VALUES ('88', '29', '1368042955', '0');
INSERT INTO orders VALUES ('155', '29', '1368445889', '0');
INSERT INTO orders VALUES ('90', '29', '1368043307', '0');
INSERT INTO orders VALUES ('91', '29', '1368043396', '0');
INSERT INTO orders VALUES ('92', '29', '1368043459', '0');
INSERT INTO orders VALUES ('93', '29', '1368043736', '0');
INSERT INTO orders VALUES ('94', '29', '1368043832', '0');
INSERT INTO orders VALUES ('95', '29', '1368043940', '0');
INSERT INTO orders VALUES ('96', '29', '1368044412', '0');
INSERT INTO orders VALUES ('97', '29', '1368044442', '0');
INSERT INTO orders VALUES ('98', '29', '1368044499', '0');
INSERT INTO orders VALUES ('99', '29', '1368047723', '0');
INSERT INTO orders VALUES ('100', '29', '1368048764', '0');
INSERT INTO orders VALUES ('101', '29', '1368049019', '0');
INSERT INTO orders VALUES ('102', '29', '1368049024', '0');
INSERT INTO orders VALUES ('103', '29', '1368050129', '0');
INSERT INTO orders VALUES ('104', '29', '1368052419', '0');
INSERT INTO orders VALUES ('105', '29', '1368084632', '0');
INSERT INTO orders VALUES ('151', '29', '1368103965', '0');
INSERT INTO orders VALUES ('152', '29', '1368104916', '0');
INSERT INTO orders VALUES ('153', '29', '1368120789', '0');
INSERT INTO orders VALUES ('154', '29', '1368134795', '0');
INSERT INTO orders VALUES ('156', '29', '1368447408', '0');
INSERT INTO orders VALUES ('157', '29', '1368469512', '0');
INSERT INTO orders VALUES ('168', '29', '1368471789', '0');
INSERT INTO orders VALUES ('169', '29', '1368473113', '0');
INSERT INTO orders VALUES ('170', '29', '1368473296', '0');
INSERT INTO orders VALUES ('171', '29', '1368473413', '0');
INSERT INTO orders VALUES ('172', '29', '1368812427', '0');
INSERT INTO orders VALUES ('173', '29', '1368812963', '0');
INSERT INTO orders VALUES ('188', '29', '1370992691', '0');


#
# Table structure for table `photos`
#

DROP TABLE IF EXISTS `photos`;
CREATE TABLE `photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_album` int(11) NOT NULL,
  `nm` varchar(64) NOT NULL,
  `img` varchar(64) NOT NULL,
  `votes` int(11) NOT NULL DEFAULT '0',
  `price` float(8,2) NOT NULL DEFAULT '0.00',
  `pecat` float(8,2) NOT NULL DEFAULT '0.00',
  `pecat_A4` float(8,2) NOT NULL DEFAULT '0.00',
  `ftp_path` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_album` (`id_album`),
  KEY `ind1` (`votes`)
) ENGINE=MyISAM AUTO_INCREMENT=9818 DEFAULT CHARSET=cp1251 COMMENT='Фотографии';

#
# Dumping data for table `photos`
#

INSERT INTO photos VALUES ('6174', '670', '00010', 'id6174.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00010.JPG');
INSERT INTO photos VALUES ('6172', '670', '00008', 'id6172.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00008.JPG');
INSERT INTO photos VALUES ('6173', '670', '00009', 'id6173.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00009.JPG');
INSERT INTO photos VALUES ('6169', '670', '00005', 'id6169.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00005.JPG');
INSERT INTO photos VALUES ('6170', '670', '00006', 'id6170.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00006.JPG');
INSERT INTO photos VALUES ('6171', '670', '00007', 'id6171.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00007.JPG');
INSERT INTO photos VALUES ('6168', '670', '00004', 'id6168.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00004.JPG');
INSERT INTO photos VALUES ('6167', '670', '00003', 'id6167.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00003.JPG');
INSERT INTO photos VALUES ('6166', '670', '00002', 'id6166.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00002.JPG');
INSERT INTO photos VALUES ('6165', '670', '00001', 'id6165.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00001.JPG');
INSERT INTO photos VALUES ('6163', '670', '00036', 'id6163.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00036.JPG');
INSERT INTO photos VALUES ('6164', '670', '00000', 'id6164.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00000.JPG');
INSERT INTO photos VALUES ('6284', '670', '00009', 'id6284.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00009.JPG');
INSERT INTO photos VALUES ('6155', '670', '00028', 'id6155.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00028.JPG');
INSERT INTO photos VALUES ('6285', '670', '00010', 'id6285.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00010.JPG');
INSERT INTO photos VALUES ('6362', '670', '00013', 'id6362.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00013.JPG');
INSERT INTO photos VALUES ('6158', '670', '00031', 'id6158.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00031.JPG');
INSERT INTO photos VALUES ('6159', '670', '00032', 'id6159.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00032.JPG');
INSERT INTO photos VALUES ('6160', '670', '00033', 'id6160.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00033.JPG');
INSERT INTO photos VALUES ('6161', '670', '00034', 'id6161.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00034.JPG');
INSERT INTO photos VALUES ('6162', '670', '00035', 'id6162.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00035.JPG');
INSERT INTO photos VALUES ('6283', '670', '00008', 'id6283.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00008.JPG');
INSERT INTO photos VALUES ('6152', '670', '00025', 'id6152.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00025.JPG');
INSERT INTO photos VALUES ('6151', '670', '00024', 'id6151.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00024.JPG');
INSERT INTO photos VALUES ('6150', '670', '00023', 'id6150.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00023.JPG');
INSERT INTO photos VALUES ('6149', '670', '00022', 'id6149.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00022.JPG');
INSERT INTO photos VALUES ('6361', '670', '00012', 'id6361.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00012.JPG');
INSERT INTO photos VALUES ('6147', '670', '00020', 'id6147.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00020.JPG');
INSERT INTO photos VALUES ('6146', '670', '00019', 'id6146.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00019.JPG');
INSERT INTO photos VALUES ('6145', '670', '00018', 'id6145.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00018.JPG');
INSERT INTO photos VALUES ('6144', '670', '00017', 'id6144.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00017.JPG');
INSERT INTO photos VALUES ('6143', '670', '00016', 'id6143.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00016.JPG');
INSERT INTO photos VALUES ('6142', '670', '00015', 'id6142.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00015.JPG');
INSERT INTO photos VALUES ('6141', '670', '00014', 'id6141.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00014.JPG');
INSERT INTO photos VALUES ('6138', '670', '00011', 'id6138.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00011.JPG');
INSERT INTO photos VALUES ('6139', '670', '00012', 'id6139.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00012.JPG');
INSERT INTO photos VALUES ('6135', '670', '00008', 'id6135.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00008.JPG');
INSERT INTO photos VALUES ('6136', '670', '00009', 'id6136.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00009.JPG');
INSERT INTO photos VALUES ('6137', '670', '00010', 'id6137.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00010.JPG');
INSERT INTO photos VALUES ('6133', '670', '00006', 'id6133.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00006.JPG');
INSERT INTO photos VALUES ('6132', '670', '00005', 'id6132.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00005.JPG');
INSERT INTO photos VALUES ('6131', '670', '00004', 'id6131.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00004.JPG');
INSERT INTO photos VALUES ('6130', '670', '00003', 'id6130.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00003.JPG');
INSERT INTO photos VALUES ('6129', '670', '00002', 'id6129.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00002.JPG');
INSERT INTO photos VALUES ('6128', '670', '00001', 'id6128.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00001.JPG');
INSERT INTO photos VALUES ('6127', '670', '00000', 'id6127.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00000.JPG');
INSERT INTO photos VALUES ('6126', '670', '00036', 'id6126.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00036.JPG');
INSERT INTO photos VALUES ('6125', '670', '00035', 'id6125.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00035.JPG');
INSERT INTO photos VALUES ('6124', '670', '00034', 'id6124.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00034.JPG');
INSERT INTO photos VALUES ('6123', '670', '00033', 'id6123.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00033.JPG');
INSERT INTO photos VALUES ('6122', '670', '00032', 'id6122.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00032.JPG');
INSERT INTO photos VALUES ('6121', '670', '00031', 'id6121.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00031.JPG');
INSERT INTO photos VALUES ('6120', '670', '00030', 'id6120.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00030.JPG');
INSERT INTO photos VALUES ('6119', '670', '00029', 'id6119.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00029.JPG');
INSERT INTO photos VALUES ('6118', '670', '00028', 'id6118.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00028.JPG');
INSERT INTO photos VALUES ('6117', '670', '00027', 'id6117.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00027.JPG');
INSERT INTO photos VALUES ('6116', '670', '00026', 'id6116.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00026.JPG');
INSERT INTO photos VALUES ('6115', '670', '00025', 'id6115.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00025.JPG');
INSERT INTO photos VALUES ('6114', '670', '00024', 'id6114.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00024.JPG');
INSERT INTO photos VALUES ('6113', '670', '00023', 'id6113.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00023.JPG');
INSERT INTO photos VALUES ('6112', '670', '00022', 'id6112.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00022.JPG');
INSERT INTO photos VALUES ('6111', '670', '00021', 'id6111.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00021.JPG');
INSERT INTO photos VALUES ('6083', '670', '00030', 'id6083.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00030.JPG');
INSERT INTO photos VALUES ('6084', '670', '00031', 'id6084.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00031.JPG');
INSERT INTO photos VALUES ('6085', '670', '00032', 'id6085.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00032.JPG');
INSERT INTO photos VALUES ('6086', '670', '00033', 'id6086.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00033.JPG');
INSERT INTO photos VALUES ('6087', '670', '00034', 'id6087.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00034.JPG');
INSERT INTO photos VALUES ('6088', '670', '00035', 'id6088.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00035.JPG');
INSERT INTO photos VALUES ('6092', '670', '00002', 'id6092.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00002.JPG');
INSERT INTO photos VALUES ('6094', '670', '00004', 'id6094.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00004.JPG');
INSERT INTO photos VALUES ('6095', '670', '00005', 'id6095.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00005.JPG');
INSERT INTO photos VALUES ('6096', '670', '00006', 'id6096.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00006.JPG');
INSERT INTO photos VALUES ('6097', '670', '00007', 'id6097.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00007.JPG');
INSERT INTO photos VALUES ('6098', '670', '00008', 'id6098.jpg', '1', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00008.JPG');
INSERT INTO photos VALUES ('6099', '670', '00009', 'id6099.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00009.JPG');
INSERT INTO photos VALUES ('6100', '670', '00010', 'id6100.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00010.JPG');
INSERT INTO photos VALUES ('6101', '670', '00011', 'id6101.jpg', '1', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00011.JPG');
INSERT INTO photos VALUES ('6102', '670', '00012', 'id6102.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00012.JPG');
INSERT INTO photos VALUES ('6103', '670', '00013', 'id6103.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00013.JPG');
INSERT INTO photos VALUES ('6105', '670', '00015', 'id6105.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00015.JPG');
INSERT INTO photos VALUES ('6106', '670', '00016', 'id6106.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00016.JPG');
INSERT INTO photos VALUES ('6107', '670', '00017', 'id6107.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00017.JPG');
INSERT INTO photos VALUES ('6108', '670', '00018', 'id6108.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00018.JPG');
INSERT INTO photos VALUES ('6109', '670', '00019', 'id6109.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00019.JPG');
INSERT INTO photos VALUES ('6110', '670', '00020', 'id6110.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00020.JPG');
INSERT INTO photos VALUES ('6358', '670', '00009', 'id6358.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00009.JPG');
INSERT INTO photos VALUES ('6354', '670', '00005', 'id6354.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00005.JPG');
INSERT INTO photos VALUES ('6080', '670', '00027', 'id6080.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00027.JPG');
INSERT INTO photos VALUES ('6355', '670', '00006', 'id6355.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00006.JPG');
INSERT INTO photos VALUES ('6356', '670', '00007', 'id6356.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00007.JPG');
INSERT INTO photos VALUES ('6076', '670', '00023', 'id6076.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00023.JPG');
INSERT INTO photos VALUES ('6075', '670', '00022', 'id6075.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00022.JPG');
INSERT INTO photos VALUES ('6073', '670', '00020', 'id6073.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00020.JPG');
INSERT INTO photos VALUES ('6072', '670', '00019', 'id6072.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00019.JPG');
INSERT INTO photos VALUES ('6379', '670', '00030', 'id6379.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00030.JPG');
INSERT INTO photos VALUES ('6374', '670', '00025', 'id6374.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00025.JPG');
INSERT INTO photos VALUES ('6376', '670', '00027', 'id6376.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00027.JPG');
INSERT INTO photos VALUES ('6065', '670', '00012', 'id6065.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00012.JPG');
INSERT INTO photos VALUES ('6063', '670', '00010', 'id6063.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00010.JPG');
INSERT INTO photos VALUES ('6061', '670', '00008', 'id6061.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00008.JPG');
INSERT INTO photos VALUES ('6055', '670', '00002', 'id6055.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00002.JPG');
INSERT INTO photos VALUES ('6056', '670', '00003', 'id6056.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00003.JPG');
INSERT INTO photos VALUES ('6359', '670', '00010', 'id6359.jpg', '5', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00010.JPG');
INSERT INTO photos VALUES ('6360', '670', '00011', 'id6360.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00011.JPG');
INSERT INTO photos VALUES ('6059', '670', '00006', 'id6059.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00006.JPG');
INSERT INTO photos VALUES ('6060', '670', '00007', 'id6060.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00007.JPG');
INSERT INTO photos VALUES ('6357', '670', '00008', 'id6357.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00008.JPG');
INSERT INTO photos VALUES ('6053', '670', '00000', 'id6053.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00000.JPG');
INSERT INTO photos VALUES ('6286', '670', '00011', 'id6286.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00011.JPG');
INSERT INTO photos VALUES ('6288', '670', '00013', 'id6288.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00013.JPG');
INSERT INTO photos VALUES ('6287', '670', '00012', 'id6287.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00012.JPG');
INSERT INTO photos VALUES ('6047', '670', '00031', 'id6047.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00031.JPG');
INSERT INTO photos VALUES ('6048', '670', '00032', 'id6048.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00032.JPG');
INSERT INTO photos VALUES ('6046', '670', '00030', 'id6046.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00030.JPG');
INSERT INTO photos VALUES ('6045', '670', '00029', 'id6045.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00029.JPG');
INSERT INTO photos VALUES ('6370', '670', '00021', 'id6370.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00021.JPG');
INSERT INTO photos VALUES ('6371', '670', '00022', 'id6371.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00022.JPG');
INSERT INTO photos VALUES ('6372', '670', '00023', 'id6372.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00023.JPG');
INSERT INTO photos VALUES ('6373', '670', '00024', 'id6373.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00024.JPG');
INSERT INTO photos VALUES ('6038', '670', '00022', 'id6038.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00022.JPG');
INSERT INTO photos VALUES ('6039', '670', '00023a', 'id6039.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00023.JPG');
INSERT INTO photos VALUES ('6037', '670', '00021', 'id6037.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00021.JPG');
INSERT INTO photos VALUES ('6031', '670', '00015', 'id6031.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00015.JPG');
INSERT INTO photos VALUES ('6033', '670', '00017', 'id6033.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00017.JPG');
INSERT INTO photos VALUES ('6352', '670', '00003', 'id6352.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00003.JPG');
INSERT INTO photos VALUES ('6353', '670', '00004', 'id6353.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00004.JPG');
INSERT INTO photos VALUES ('6028', '670', '00012', 'id6028.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00012.JPG');
INSERT INTO photos VALUES ('6363', '670', '00014', 'id6363.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00014.JPG');
INSERT INTO photos VALUES ('6364', '670', '00015', 'id6364.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00015.JPG');
INSERT INTO photos VALUES ('6025', '670', '00009', 'id6025.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00009.JPG');
INSERT INTO photos VALUES ('6026', '670', '00010', 'id6026.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00010.JPG');
INSERT INTO photos VALUES ('6023', '670', '00007', 'id6023.jpg', '2', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00007.JPG');
INSERT INTO photos VALUES ('6349', '670', '00000', 'id6349.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00000.JPG');
INSERT INTO photos VALUES ('6020', '670', '00004', 'id6020.jpg', '1', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00004.JPG');
INSERT INTO photos VALUES ('6021', '670', '00005', 'id6021.jpg', '3', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00005.JPG');
INSERT INTO photos VALUES ('6350', '670', '00001', 'id6350.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00001.JPG');
INSERT INTO photos VALUES ('6351', '670', '00002', 'id6351.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00002.JPG');
INSERT INTO photos VALUES ('6017', '670', '00001', 'id6017.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00001.JPG');
INSERT INTO photos VALUES ('6013', '670', '00034', 'id6013.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00034.JPG');
INSERT INTO photos VALUES ('6014', '670', '00035', 'id6014.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00035.JPG');
INSERT INTO photos VALUES ('6012', '670', '00033', 'id6012.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00033.JPG');
INSERT INTO photos VALUES ('6009', '670', '00030', 'id6009.jpg', '2', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00030.JPG');
INSERT INTO photos VALUES ('6010', '670', '00031', 'id6010.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00031.JPG');
INSERT INTO photos VALUES ('6007', '670', '00028', 'id6007.jpg', '1', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00028.JPG');
INSERT INTO photos VALUES ('6008', '670', '00029', 'id6008.jpg', '1', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00029.JPG');
INSERT INTO photos VALUES ('6006', '670', '00027', 'id6006.jpg', '1', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00027.JPG');
INSERT INTO photos VALUES ('6005', '670', '00026', 'id6005.jpg', '2', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00026.JPG');
INSERT INTO photos VALUES ('6004', '670', '00025', 'id6004.jpg', '2', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00025.JPG');
INSERT INTO photos VALUES ('6003', '670', '00024', 'id6003.jpg', '3', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00024.JPG');
INSERT INTO photos VALUES ('5995', '670', '00016', 'id5995.jpg', '1', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00016.JPG');
INSERT INTO photos VALUES ('6369', '670', '00020', 'id6369.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00020.JPG');
INSERT INTO photos VALUES ('5990', '670', '00011', 'id5990.jpg', '52', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00011.JPG');
INSERT INTO photos VALUES ('6368', '670', '00019', 'id6368.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00019.JPG');
INSERT INTO photos VALUES ('5983', '670', '00004', 'id5983.jpg', '4', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00004.JPG');
INSERT INTO photos VALUES ('6380', '670', '00031', 'id6380.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00031.JPG');
INSERT INTO photos VALUES ('6381', '670', '00032', 'id6381.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00032.JPG');
INSERT INTO photos VALUES ('6382', '670', '00033', 'id6382.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00033.JPG');
INSERT INTO photos VALUES ('6383', '670', '00034', 'id6383.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00034.JPG');
INSERT INTO photos VALUES ('6384', '670', '00035', 'id6384.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00035.JPG');
INSERT INTO photos VALUES ('6275', '670', '00000', 'id6275.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00000.JPG');
INSERT INTO photos VALUES ('6276', '670', '00001', 'id6276.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00001.JPG');
INSERT INTO photos VALUES ('6277', '670', '00002', 'id6277.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00002.JPG');
INSERT INTO photos VALUES ('6278', '670', '00003', 'id6278.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00003.JPG');
INSERT INTO photos VALUES ('6279', '670', '00004', 'id6279.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00004.JPG');
INSERT INTO photos VALUES ('6365', '670', '00016', 'id6365.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00016.JPG');
INSERT INTO photos VALUES ('6366', '670', '00017', 'id6366.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00017.JPG');
INSERT INTO photos VALUES ('6367', '670', '00018', 'id6367.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00018.JPG');
INSERT INTO photos VALUES ('6175', '670', '00011', 'id6175.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00011.JPG');
INSERT INTO photos VALUES ('6176', '670', '00012', 'id6176.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00012.JPG');
INSERT INTO photos VALUES ('6177', '670', '00013', 'id6177.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00013.JPG');
INSERT INTO photos VALUES ('6178', '670', '00014', 'id6178.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00014.JPG');
INSERT INTO photos VALUES ('6179', '670', '00015', 'id6179.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00015.JPG');
INSERT INTO photos VALUES ('6180', '670', '00016', 'id6180.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00016.JPG');
INSERT INTO photos VALUES ('6181', '670', '00017', 'id6181.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00017.JPG');
INSERT INTO photos VALUES ('6182', '670', '00018', 'id6182.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00018.JPG');
INSERT INTO photos VALUES ('6183', '670', '00019', 'id6183.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00019.JPG');
INSERT INTO photos VALUES ('6184', '670', '00020', 'id6184.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00020.JPG');
INSERT INTO photos VALUES ('6185', '670', '00021', 'id6185.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00021.JPG');
INSERT INTO photos VALUES ('6186', '670', '00022', 'id6186.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00022.JPG');
INSERT INTO photos VALUES ('6187', '670', '00023', 'id6187.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00023.JPG');
INSERT INTO photos VALUES ('6188', '670', '00024', 'id6188.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00024.JPG');
INSERT INTO photos VALUES ('6190', '670', '00026', 'id6190.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00026.JPG');
INSERT INTO photos VALUES ('6192', '670', '00028', 'id6192.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00028.JPG');
INSERT INTO photos VALUES ('6195', '670', '00031', 'id6195.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00031.JPG');
INSERT INTO photos VALUES ('6196', '670', '00032', 'id6196.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00032.JPG');
INSERT INTO photos VALUES ('6197', '670', '00033', 'id6197.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00033.JPG');
INSERT INTO photos VALUES ('6198', '670', '00034', 'id6198.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00034.JPG');
INSERT INTO photos VALUES ('6199', '670', '00035', 'id6199.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00035.JPG');
INSERT INTO photos VALUES ('6200', '670', '00036', 'id6200.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00036.JPG');
INSERT INTO photos VALUES ('6201', '670', '00000', 'id6201.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00000.JPG');
INSERT INTO photos VALUES ('6202', '670', '00001', 'id6202.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00001.JPG');
INSERT INTO photos VALUES ('6203', '670', '00002', 'id6203.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00002.JPG');
INSERT INTO photos VALUES ('6204', '670', '00003', 'id6204.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00003.JPG');
INSERT INTO photos VALUES ('6205', '670', '00004', 'id6205.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00004.JPG');
INSERT INTO photos VALUES ('6206', '670', '00005', 'id6206.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00005.JPG');
INSERT INTO photos VALUES ('6207', '670', '00006', 'id6207.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00006.JPG');
INSERT INTO photos VALUES ('6208', '670', '00007', 'id6208.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00007.JPG');
INSERT INTO photos VALUES ('6209', '670', '00008', 'id6209.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00008.JPG');
INSERT INTO photos VALUES ('6210', '670', '00009', 'id6210.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00009.JPG');
INSERT INTO photos VALUES ('6211', '670', '00010', 'id6211.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00010.JPG');
INSERT INTO photos VALUES ('6212', '670', '00011', 'id6212.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00011.JPG');
INSERT INTO photos VALUES ('6213', '670', '00012', 'id6213.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00012.JPG');
INSERT INTO photos VALUES ('6214', '670', '00013', 'id6214.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00013.JPG');
INSERT INTO photos VALUES ('6215', '670', '00014', 'id6215.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00014.JPG');
INSERT INTO photos VALUES ('6216', '670', '00015', 'id6216.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00015.JPG');
INSERT INTO photos VALUES ('6217', '670', '00016', 'id6217.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00016.JPG');
INSERT INTO photos VALUES ('6218', '670', '00017', 'id6218.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00017.JPG');
INSERT INTO photos VALUES ('6219', '670', '00018', 'id6219.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00018.JPG');
INSERT INTO photos VALUES ('6220', '670', '00019', 'id6220.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00019.JPG');
INSERT INTO photos VALUES ('6221', '670', '00020', 'id6221.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00020.JPG');
INSERT INTO photos VALUES ('6281', '670', '00006', 'id6281.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00006.JPG');
INSERT INTO photos VALUES ('6223', '670', '00022', 'id6223.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00022.JPG');
INSERT INTO photos VALUES ('6224', '670', '00023', 'id6224.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00023.JPG');
INSERT INTO photos VALUES ('6225', '670', '00024', 'id6225.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00024.JPG');
INSERT INTO photos VALUES ('6282', '670', '00007', 'id6282.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00007.JPG');
INSERT INTO photos VALUES ('6227', '670', '00026', 'id6227.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00026.JPG');
INSERT INTO photos VALUES ('6228', '670', '00027', 'id6228.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00027.JPG');
INSERT INTO photos VALUES ('6229', '670', '00028', 'id6229.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00028.JPG');
INSERT INTO photos VALUES ('6230', '670', '00029', 'id6230.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00029.JPG');
INSERT INTO photos VALUES ('6231', '670', '00030', 'id6231.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00030.JPG');
INSERT INTO photos VALUES ('6232', '670', '00031', 'id6232.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00031.JPG');
INSERT INTO photos VALUES ('6233', '670', '00032', 'id6233.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00032.JPG');
INSERT INTO photos VALUES ('6234', '670', '00033', 'id6234.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00033.JPG');
INSERT INTO photos VALUES ('6235', '670', '00034', 'id6235.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00034.JPG');
INSERT INTO photos VALUES ('6236', '670', '00035', 'id6236.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00035.JPG');
INSERT INTO photos VALUES ('6237', '670', '00036', 'id6237.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00036.JPG');
INSERT INTO photos VALUES ('6238', '670', '00000', 'id6238.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00000.JPG');
INSERT INTO photos VALUES ('6239', '670', '00001', 'id6239.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00001.JPG');
INSERT INTO photos VALUES ('6280', '670', '00005', 'id6280.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00005.JPG');
INSERT INTO photos VALUES ('6241', '670', '00003', 'id6241.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00003.JPG');
INSERT INTO photos VALUES ('6242', '670', '00004', 'id6242.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00004.JPG');
INSERT INTO photos VALUES ('6243', '670', '00005', 'id6243.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00005.JPG');
INSERT INTO photos VALUES ('6244', '670', '00006', 'id6244.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00006.JPG');
INSERT INTO photos VALUES ('6245', '670', '00007', 'id6245.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00007.JPG');
INSERT INTO photos VALUES ('6246', '670', '00008', 'id6246.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00008.JPG');
INSERT INTO photos VALUES ('6247', '670', '00009', 'id6247.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00009.JPG');
INSERT INTO photos VALUES ('6248', '670', '00010', 'id6248.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00010.JPG');
INSERT INTO photos VALUES ('6249', '670', '00011', 'id6249.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00011.JPG');
INSERT INTO photos VALUES ('6250', '670', '00012', 'id6250.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00012.JPG');
INSERT INTO photos VALUES ('6251', '670', '00013', 'id6251.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00013.JPG');
INSERT INTO photos VALUES ('6252', '670', '00014', 'id6252.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00014.JPG');
INSERT INTO photos VALUES ('6253', '670', '00015', 'id6253.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00015.JPG');
INSERT INTO photos VALUES ('6254', '670', '00016', 'id6254.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00016.JPG');
INSERT INTO photos VALUES ('6255', '670', '00017', 'id6255.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00017.JPG');
INSERT INTO photos VALUES ('6256', '670', '00018', 'id6256.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00018.JPG');
INSERT INTO photos VALUES ('6257', '670', '00019', 'id6257.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00019.JPG');
INSERT INTO photos VALUES ('6258', '670', '00020', 'id6258.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00020.JPG');
INSERT INTO photos VALUES ('6259', '670', '00021', 'id6259.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00021.JPG');
INSERT INTO photos VALUES ('6260', '670', '00022', 'id6260.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00022.JPG');
INSERT INTO photos VALUES ('6261', '670', '00023', 'id6261.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00023.JPG');
INSERT INTO photos VALUES ('6262', '670', '00024', 'id6262.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00024.JPG');
INSERT INTO photos VALUES ('6263', '670', '00025', 'id6263.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00025.JPG');
INSERT INTO photos VALUES ('6264', '670', '00026', 'id6264.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00026.JPG');
INSERT INTO photos VALUES ('6265', '670', '00027', 'id6265.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00027.JPG');
INSERT INTO photos VALUES ('6266', '670', '00028', 'id6266.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00028.JPG');
INSERT INTO photos VALUES ('6267', '670', '00029', 'id6267.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00029.JPG');
INSERT INTO photos VALUES ('6268', '670', '00030', 'id6268.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00030.JPG');
INSERT INTO photos VALUES ('6269', '670', '00031', 'id6269.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00031.JPG');
INSERT INTO photos VALUES ('6270', '670', '00032', 'id6270.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00032.JPG');
INSERT INTO photos VALUES ('6271', '670', '00033', 'id6271.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00033.JPG');
INSERT INTO photos VALUES ('6272', '670', '00034', 'id6272.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00034.JPG');
INSERT INTO photos VALUES ('6273', '670', '00035', 'id6273.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00035.JPG');
INSERT INTO photos VALUES ('6274', '670', '00036', 'id6274.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00036.JPG');
INSERT INTO photos VALUES ('6289', '670', '00014', 'id6289.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00014.JPG');
INSERT INTO photos VALUES ('6290', '670', '00015', 'id6290.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00015.JPG');
INSERT INTO photos VALUES ('6291', '670', '00016', 'id6291.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00016.JPG');
INSERT INTO photos VALUES ('6292', '670', '00017', 'id6292.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00017.JPG');
INSERT INTO photos VALUES ('6293', '670', '00018', 'id6293.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00018.JPG');
INSERT INTO photos VALUES ('6294', '670', '00019', 'id6294.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00019.JPG');
INSERT INTO photos VALUES ('6295', '670', '00020', 'id6295.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00020.JPG');
INSERT INTO photos VALUES ('6296', '670', '00021', 'id6296.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00021.JPG');
INSERT INTO photos VALUES ('6297', '670', '00022', 'id6297.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00022.JPG');
INSERT INTO photos VALUES ('6298', '670', '00023', 'id6298.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00023.JPG');
INSERT INTO photos VALUES ('6299', '670', '00024', 'id6299.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00024.JPG');
INSERT INTO photos VALUES ('6300', '670', '00025', 'id6300.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00025.JPG');
INSERT INTO photos VALUES ('6301', '670', '00026', 'id6301.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00026.JPG');
INSERT INTO photos VALUES ('6302', '670', '00027', 'id6302.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00027.JPG');
INSERT INTO photos VALUES ('6303', '670', '00028', 'id6303.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00028.JPG');
INSERT INTO photos VALUES ('6304', '670', '00029', 'id6304.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00029.JPG');
INSERT INTO photos VALUES ('6305', '670', '00030', 'id6305.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00030.JPG');
INSERT INTO photos VALUES ('6306', '670', '00031', 'id6306.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00031.JPG');
INSERT INTO photos VALUES ('6307', '670', '00032', 'id6307.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00032.JPG');
INSERT INTO photos VALUES ('6308', '670', '00033', 'id6308.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00033.JPG');
INSERT INTO photos VALUES ('6309', '670', '00034', 'id6309.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00034.JPG');
INSERT INTO photos VALUES ('6310', '670', '00035', 'id6310.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00035.JPG');
INSERT INTO photos VALUES ('6311', '670', '00036', 'id6311.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00036.JPG');
INSERT INTO photos VALUES ('6312', '670', '00000', 'id6312.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00000.JPG');
INSERT INTO photos VALUES ('6313', '670', '00001', 'id6313.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00001.JPG');
INSERT INTO photos VALUES ('6314', '670', '00002', 'id6314.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00002.JPG');
INSERT INTO photos VALUES ('6315', '670', '00003', 'id6315.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00003.JPG');
INSERT INTO photos VALUES ('6316', '670', '00004', 'id6316.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00004.JPG');
INSERT INTO photos VALUES ('6318', '670', '00006', 'id6318.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00006.JPG');
INSERT INTO photos VALUES ('6319', '670', '00007', 'id6319.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00007.JPG');
INSERT INTO photos VALUES ('6320', '670', '00008', 'id6320.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00008.JPG');
INSERT INTO photos VALUES ('6321', '670', '00009', 'id6321.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00009.JPG');
INSERT INTO photos VALUES ('6323', '670', '00011', 'id6323.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00011.JPG');
INSERT INTO photos VALUES ('6328', '670', '00016', 'id6328.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00016.JPG');
INSERT INTO photos VALUES ('6329', '670', '00017', 'id6329.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00017.JPG');
INSERT INTO photos VALUES ('6330', '670', '00018', 'id6330.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00018.JPG');
INSERT INTO photos VALUES ('6334', '670', '00022', 'id6334.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00022.JPG');
INSERT INTO photos VALUES ('6335', '670', '00023', 'id6335.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00023.JPG');
INSERT INTO photos VALUES ('6336', '670', '00024', 'id6336.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00024.JPG');
INSERT INTO photos VALUES ('6337', '670', '00025', 'id6337.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00025.JPG');
INSERT INTO photos VALUES ('6338', '670', '00026', 'id6338.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00026.JPG');
INSERT INTO photos VALUES ('6340', '670', '00028', 'id6340.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00028.JPG');
INSERT INTO photos VALUES ('6341', '670', '00029', 'id6341.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00029.JPG');
INSERT INTO photos VALUES ('6342', '670', '00030', 'id6342.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00030.JPG');
INSERT INTO photos VALUES ('6343', '670', '00031', 'id6343.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00031.JPG');
INSERT INTO photos VALUES ('6345', '670', '00033', 'id6345.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00033.JPG');
INSERT INTO photos VALUES ('6346', '670', '00034', 'id6346.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00034.JPG');
INSERT INTO photos VALUES ('6347', '670', '00035', 'id6347.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/svadba/02/00035.JPG');
INSERT INTO photos VALUES ('8740', '737', '0542', 'id8740.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0542.jpg');
INSERT INTO photos VALUES ('8739', '737', '0541', 'id8739.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0541.jpg');
INSERT INTO photos VALUES ('8738', '737', '0540', 'id8738.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0540.jpg');
INSERT INTO photos VALUES ('8737', '737', '0539', 'id8737.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0539.jpg');
INSERT INTO photos VALUES ('8736', '737', '0537', 'id8736.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0537.jpg');
INSERT INTO photos VALUES ('8735', '737', '0536', 'id8735.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0536.jpg');
INSERT INTO photos VALUES ('8734', '737', '0535', 'id8734.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0535.jpg');
INSERT INTO photos VALUES ('8451', '737', '0001', 'id8451.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0001.jpg');
INSERT INTO photos VALUES ('8450', '736', '528', 'id8450.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/528.jpg');
INSERT INTO photos VALUES ('8449', '736', '527', 'id8449.jpg', '7', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/527.jpg');
INSERT INTO photos VALUES ('8448', '736', '526', 'id8448.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/526.jpg');
INSERT INTO photos VALUES ('8447', '736', '521', 'id8447.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/521.jpg');
INSERT INTO photos VALUES ('8446', '736', '519', 'id8446.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/519.jpg');
INSERT INTO photos VALUES ('8445', '736', '518', 'id8445.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/518.jpg');
INSERT INTO photos VALUES ('8444', '736', '517', 'id8444.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/517.jpg');
INSERT INTO photos VALUES ('8443', '736', '516', 'id8443.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/516.jpg');
INSERT INTO photos VALUES ('8442', '736', '515', 'id8442.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/515.jpg');
INSERT INTO photos VALUES ('8441', '736', '514', 'id8441.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/514.jpg');
INSERT INTO photos VALUES ('8440', '736', '513', 'id8440.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/513.jpg');
INSERT INTO photos VALUES ('8439', '736', '512', 'id8439.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/512.jpg');
INSERT INTO photos VALUES ('8438', '736', '511', 'id8438.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/511.jpg');
INSERT INTO photos VALUES ('8437', '736', '510', 'id8437.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/510.jpg');
INSERT INTO photos VALUES ('8436', '736', '508', 'id8436.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/508.jpg');
INSERT INTO photos VALUES ('8435', '736', '507', 'id8435.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/507.jpg');
INSERT INTO photos VALUES ('8434', '736', '506', 'id8434.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/506.jpg');
INSERT INTO photos VALUES ('8433', '736', '505', 'id8433.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/505.jpg');
INSERT INTO photos VALUES ('8432', '736', '504', 'id8432.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/504.jpg');
INSERT INTO photos VALUES ('8431', '736', '503', 'id8431.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/503.jpg');
INSERT INTO photos VALUES ('8430', '736', '502', 'id8430.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/502.jpg');
INSERT INTO photos VALUES ('8429', '736', '501', 'id8429.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/501.jpg');
INSERT INTO photos VALUES ('8428', '736', '500', 'id8428.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/500.jpg');
INSERT INTO photos VALUES ('8427', '736', '499', 'id8427.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/499.jpg');
INSERT INTO photos VALUES ('8426', '736', '498', 'id8426.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/498.jpg');
INSERT INTO photos VALUES ('8425', '736', '497', 'id8425.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/497.jpg');
INSERT INTO photos VALUES ('8424', '736', '496', 'id8424.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/496.jpg');
INSERT INTO photos VALUES ('8423', '736', '495', 'id8423.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/495.jpg');
INSERT INTO photos VALUES ('8422', '736', '493', 'id8422.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/493.jpg');
INSERT INTO photos VALUES ('8421', '736', '492', 'id8421.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/492.jpg');
INSERT INTO photos VALUES ('8420', '736', '491', 'id8420.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/491.jpg');
INSERT INTO photos VALUES ('8419', '736', '490', 'id8419.jpg', '2', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/490.jpg');
INSERT INTO photos VALUES ('8418', '736', '489', 'id8418.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/489.jpg');
INSERT INTO photos VALUES ('8417', '736', '488', 'id8417.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/488.jpg');
INSERT INTO photos VALUES ('8416', '736', '486', 'id8416.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/486.jpg');
INSERT INTO photos VALUES ('8415', '736', '485', 'id8415.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/485.jpg');
INSERT INTO photos VALUES ('8414', '736', '484', 'id8414.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/484.jpg');
INSERT INTO photos VALUES ('8413', '736', '483', 'id8413.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/483.jpg');
INSERT INTO photos VALUES ('8412', '736', '482', 'id8412.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/482.jpg');
INSERT INTO photos VALUES ('8411', '736', '481', 'id8411.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/481.jpg');
INSERT INTO photos VALUES ('8410', '736', '480', 'id8410.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/480.jpg');
INSERT INTO photos VALUES ('8409', '736', '479', 'id8409.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/479.jpg');
INSERT INTO photos VALUES ('8408', '736', '478', 'id8408.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/478.jpg');
INSERT INTO photos VALUES ('8407', '736', '477', 'id8407.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/477.jpg');
INSERT INTO photos VALUES ('8406', '736', '476', 'id8406.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/476.jpg');
INSERT INTO photos VALUES ('8405', '736', '475', 'id8405.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/475.jpg');
INSERT INTO photos VALUES ('8404', '736', '473', 'id8404.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/473.jpg');
INSERT INTO photos VALUES ('8403', '736', '471', 'id8403.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/471.jpg');
INSERT INTO photos VALUES ('8402', '736', '469', 'id8402.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/469.jpg');
INSERT INTO photos VALUES ('8401', '736', '468', 'id8401.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/468.jpg');
INSERT INTO photos VALUES ('8400', '736', '467', 'id8400.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/467.jpg');
INSERT INTO photos VALUES ('8399', '736', '466', 'id8399.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/466.jpg');
INSERT INTO photos VALUES ('8398', '736', '465', 'id8398.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/465.jpg');
INSERT INTO photos VALUES ('8397', '736', '464', 'id8397.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/464.jpg');
INSERT INTO photos VALUES ('8396', '736', '463', 'id8396.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/463.jpg');
INSERT INTO photos VALUES ('8395', '736', '462', 'id8395.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/462.jpg');
INSERT INTO photos VALUES ('8394', '736', '461', 'id8394.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/461.jpg');
INSERT INTO photos VALUES ('8393', '736', '460', 'id8393.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/460.jpg');
INSERT INTO photos VALUES ('8392', '736', '459', 'id8392.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/459.jpg');
INSERT INTO photos VALUES ('8391', '736', '458', 'id8391.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/458.jpg');
INSERT INTO photos VALUES ('8390', '736', '457', 'id8390.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/457.jpg');
INSERT INTO photos VALUES ('8389', '736', '456', 'id8389.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/456.jpg');
INSERT INTO photos VALUES ('8388', '736', '455', 'id8388.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/455.jpg');
INSERT INTO photos VALUES ('8387', '736', '454', 'id8387.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/454.jpg');
INSERT INTO photos VALUES ('8386', '736', '452', 'id8386.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/452.jpg');
INSERT INTO photos VALUES ('8385', '736', '450', 'id8385.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/450.jpg');
INSERT INTO photos VALUES ('8384', '736', '449', 'id8384.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/449.jpg');
INSERT INTO photos VALUES ('8383', '736', '448', 'id8383.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/448.jpg');
INSERT INTO photos VALUES ('8382', '736', '447', 'id8382.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/447.jpg');
INSERT INTO photos VALUES ('8381', '736', '446', 'id8381.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/446.jpg');
INSERT INTO photos VALUES ('8380', '736', '445', 'id8380.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/445.jpg');
INSERT INTO photos VALUES ('8379', '736', '444', 'id8379.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/444.jpg');
INSERT INTO photos VALUES ('8378', '736', '443', 'id8378.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/443.jpg');
INSERT INTO photos VALUES ('8377', '736', '442', 'id8377.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/442.jpg');
INSERT INTO photos VALUES ('8376', '736', '441', 'id8376.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/441.jpg');
INSERT INTO photos VALUES ('8375', '736', '440', 'id8375.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/440.jpg');
INSERT INTO photos VALUES ('8374', '736', '437', 'id8374.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/437.jpg');
INSERT INTO photos VALUES ('8373', '736', '436', 'id8373.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/436.jpg');
INSERT INTO photos VALUES ('8372', '736', '435', 'id8372.jpg', '8', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/435.jpg');
INSERT INTO photos VALUES ('8371', '736', '434', 'id8371.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/434.jpg');
INSERT INTO photos VALUES ('8370', '736', '433', 'id8370.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/433.jpg');
INSERT INTO photos VALUES ('8369', '736', '432', 'id8369.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/432.jpg');
INSERT INTO photos VALUES ('8368', '736', '431', 'id8368.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/431.jpg');
INSERT INTO photos VALUES ('8367', '736', '430', 'id8367.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/430.jpg');
INSERT INTO photos VALUES ('8366', '736', '429', 'id8366.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/429.jpg');
INSERT INTO photos VALUES ('8365', '736', '428', 'id8365.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/428.jpg');
INSERT INTO photos VALUES ('8364', '736', '426', 'id8364.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/426.jpg');
INSERT INTO photos VALUES ('8363', '736', '425', 'id8363.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/425.jpg');
INSERT INTO photos VALUES ('8362', '736', '424', 'id8362.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/424.jpg');
INSERT INTO photos VALUES ('8361', '736', '423', 'id8361.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/423.jpg');
INSERT INTO photos VALUES ('8360', '736', '422', 'id8360.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/422.jpg');
INSERT INTO photos VALUES ('8359', '736', '421', 'id8359.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/421.jpg');
INSERT INTO photos VALUES ('8358', '736', '420', 'id8358.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/420.jpg');
INSERT INTO photos VALUES ('8357', '736', '419', 'id8357.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/419.jpg');
INSERT INTO photos VALUES ('8356', '736', '418', 'id8356.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/418.jpg');
INSERT INTO photos VALUES ('8355', '736', '417', 'id8355.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/417.jpg');
INSERT INTO photos VALUES ('8354', '736', '416', 'id8354.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/416.jpg');
INSERT INTO photos VALUES ('8353', '736', '415', 'id8353.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/415.jpg');
INSERT INTO photos VALUES ('8352', '736', '414', 'id8352.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/414.jpg');
INSERT INTO photos VALUES ('8351', '736', '413', 'id8351.jpg', '6', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/413.jpg');
INSERT INTO photos VALUES ('8350', '736', '412', 'id8350.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/412.jpg');
INSERT INTO photos VALUES ('8349', '736', '411', 'id8349.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/411.jpg');
INSERT INTO photos VALUES ('8348', '736', '410', 'id8348.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/410.jpg');
INSERT INTO photos VALUES ('8347', '736', '409', 'id8347.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/409.jpg');
INSERT INTO photos VALUES ('8346', '736', '408', 'id8346.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/408.jpg');
INSERT INTO photos VALUES ('8345', '736', '407', 'id8345.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/407.jpg');
INSERT INTO photos VALUES ('8344', '736', '406', 'id8344.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/406.jpg');
INSERT INTO photos VALUES ('8343', '736', '405', 'id8343.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/405.jpg');
INSERT INTO photos VALUES ('8342', '736', '404', 'id8342.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/404.jpg');
INSERT INTO photos VALUES ('8341', '736', '403', 'id8341.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/403.jpg');
INSERT INTO photos VALUES ('8340', '736', '401', 'id8340.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/401.jpg');
INSERT INTO photos VALUES ('8339', '736', '400', 'id8339.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/400.jpg');
INSERT INTO photos VALUES ('8338', '736', '399', 'id8338.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/399.jpg');
INSERT INTO photos VALUES ('8337', '736', '398', 'id8337.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/398.jpg');
INSERT INTO photos VALUES ('8336', '736', '397', 'id8336.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/397.jpg');
INSERT INTO photos VALUES ('8335', '736', '396', 'id8335.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/396.jpg');
INSERT INTO photos VALUES ('8334', '736', '395', 'id8334.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/395.jpg');
INSERT INTO photos VALUES ('8333', '736', '394', 'id8333.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/394.jpg');
INSERT INTO photos VALUES ('8332', '736', '393', 'id8332.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/393.jpg');
INSERT INTO photos VALUES ('8331', '736', '392', 'id8331.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/392.jpg');
INSERT INTO photos VALUES ('8330', '736', '391', 'id8330.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/391.jpg');
INSERT INTO photos VALUES ('8329', '736', '390', 'id8329.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/390.jpg');
INSERT INTO photos VALUES ('8328', '736', '389', 'id8328.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/389.jpg');
INSERT INTO photos VALUES ('8327', '736', '388', 'id8327.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/388.jpg');
INSERT INTO photos VALUES ('8326', '736', '387', 'id8326.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/387.jpg');
INSERT INTO photos VALUES ('8325', '736', '385', 'id8325.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/385.jpg');
INSERT INTO photos VALUES ('8324', '736', '384', 'id8324.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/384.jpg');
INSERT INTO photos VALUES ('8323', '736', '383', 'id8323.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/383.jpg');
INSERT INTO photos VALUES ('8322', '736', '382', 'id8322.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/382.jpg');
INSERT INTO photos VALUES ('8321', '736', '381', 'id8321.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/381.jpg');
INSERT INTO photos VALUES ('8320', '736', '379', 'id8320.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/379.jpg');
INSERT INTO photos VALUES ('8319', '736', '378', 'id8319.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/378.jpg');
INSERT INTO photos VALUES ('8318', '736', '377', 'id8318.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/377.jpg');
INSERT INTO photos VALUES ('8317', '736', '376', 'id8317.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/376.jpg');
INSERT INTO photos VALUES ('8316', '736', '375', 'id8316.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/375.jpg');
INSERT INTO photos VALUES ('8315', '736', '371', 'id8315.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/371.jpg');
INSERT INTO photos VALUES ('8314', '736', '370', 'id8314.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/370.jpg');
INSERT INTO photos VALUES ('8313', '736', '369', 'id8313.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/369.jpg');
INSERT INTO photos VALUES ('8312', '736', '368', 'id8312.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/368.jpg');
INSERT INTO photos VALUES ('8311', '736', '367', 'id8311.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/367.jpg');
INSERT INTO photos VALUES ('8310', '736', '366', 'id8310.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/366.jpg');
INSERT INTO photos VALUES ('8309', '736', '365', 'id8309.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/365.jpg');
INSERT INTO photos VALUES ('8308', '736', '363', 'id8308.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/363.jpg');
INSERT INTO photos VALUES ('8307', '736', '361', 'id8307.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/361.jpg');
INSERT INTO photos VALUES ('8306', '736', '360', 'id8306.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/360.jpg');
INSERT INTO photos VALUES ('8305', '736', '359', 'id8305.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/359.jpg');
INSERT INTO photos VALUES ('8304', '736', '357', 'id8304.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/357.jpg');
INSERT INTO photos VALUES ('8303', '736', '355', 'id8303.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/355.jpg');
INSERT INTO photos VALUES ('8302', '736', '352', 'id8302.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/352.jpg');
INSERT INTO photos VALUES ('8301', '736', '351', 'id8301.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/351.jpg');
INSERT INTO photos VALUES ('8300', '736', '350', 'id8300.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/350.jpg');
INSERT INTO photos VALUES ('8299', '736', '349', 'id8299.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/349.jpg');
INSERT INTO photos VALUES ('8298', '736', '348', 'id8298.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/348.jpg');
INSERT INTO photos VALUES ('8297', '736', '347', 'id8297.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/347.jpg');
INSERT INTO photos VALUES ('8296', '736', '346', 'id8296.jpg', '10', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/346.jpg');
INSERT INTO photos VALUES ('8295', '736', '345', 'id8295.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/345.jpg');
INSERT INTO photos VALUES ('8294', '736', '343', 'id8294.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/343.jpg');
INSERT INTO photos VALUES ('8293', '736', '342', 'id8293.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/342.jpg');
INSERT INTO photos VALUES ('8292', '736', '341', 'id8292.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/341.jpg');
INSERT INTO photos VALUES ('8291', '736', '340', 'id8291.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/340.jpg');
INSERT INTO photos VALUES ('8290', '736', '339', 'id8290.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/339.jpg');
INSERT INTO photos VALUES ('8289', '736', '337', 'id8289.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/337.jpg');
INSERT INTO photos VALUES ('8288', '736', '336', 'id8288.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/336.jpg');
INSERT INTO photos VALUES ('8287', '736', '335', 'id8287.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/335.jpg');
INSERT INTO photos VALUES ('8286', '736', '334', 'id8286.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/334.jpg');
INSERT INTO photos VALUES ('8285', '736', '333', 'id8285.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/333.jpg');
INSERT INTO photos VALUES ('8284', '736', '332', 'id8284.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/332.jpg');
INSERT INTO photos VALUES ('8283', '736', '331', 'id8283.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/331.jpg');
INSERT INTO photos VALUES ('8282', '736', '330', 'id8282.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/330.jpg');
INSERT INTO photos VALUES ('8281', '736', '329', 'id8281.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/329.jpg');
INSERT INTO photos VALUES ('8280', '736', '328', 'id8280.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/328.jpg');
INSERT INTO photos VALUES ('8279', '736', '326', 'id8279.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/326.jpg');
INSERT INTO photos VALUES ('8278', '736', '324', 'id8278.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/324.jpg');
INSERT INTO photos VALUES ('8277', '736', '323', 'id8277.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/323.jpg');
INSERT INTO photos VALUES ('8276', '736', '322', 'id8276.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/322.jpg');
INSERT INTO photos VALUES ('8275', '736', '321', 'id8275.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/321.jpg');
INSERT INTO photos VALUES ('8274', '736', '320', 'id8274.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/320.jpg');
INSERT INTO photos VALUES ('8273', '736', '319', 'id8273.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/319.jpg');
INSERT INTO photos VALUES ('8272', '736', '317', 'id8272.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/317.jpg');
INSERT INTO photos VALUES ('8271', '736', '316', 'id8271.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/316.jpg');
INSERT INTO photos VALUES ('8270', '736', '315', 'id8270.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/315.jpg');
INSERT INTO photos VALUES ('8269', '736', '314', 'id8269.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/314.jpg');
INSERT INTO photos VALUES ('8268', '736', '313', 'id8268.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/313.jpg');
INSERT INTO photos VALUES ('8267', '736', '312', 'id8267.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/312.jpg');
INSERT INTO photos VALUES ('8266', '736', '311', 'id8266.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/311.jpg');
INSERT INTO photos VALUES ('8265', '736', '310', 'id8265.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/310.jpg');
INSERT INTO photos VALUES ('8264', '736', '309', 'id8264.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/309.jpg');
INSERT INTO photos VALUES ('8263', '736', '308', 'id8263.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/308.jpg');
INSERT INTO photos VALUES ('8262', '736', '306', 'id8262.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/306.jpg');
INSERT INTO photos VALUES ('8261', '736', '305', 'id8261.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/305.jpg');
INSERT INTO photos VALUES ('8260', '736', '304', 'id8260.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/304.jpg');
INSERT INTO photos VALUES ('8259', '736', '300', 'id8259.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/300.jpg');
INSERT INTO photos VALUES ('8258', '736', '299', 'id8258.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/299.jpg');
INSERT INTO photos VALUES ('8257', '736', '298', 'id8257.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/298.jpg');
INSERT INTO photos VALUES ('8256', '736', '297', 'id8256.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/297.jpg');
INSERT INTO photos VALUES ('8255', '736', '296', 'id8255.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/296.jpg');
INSERT INTO photos VALUES ('8254', '736', '295', 'id8254.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/295.jpg');
INSERT INTO photos VALUES ('8253', '736', '294', 'id8253.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/294.jpg');
INSERT INTO photos VALUES ('8252', '736', '290', 'id8252.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/290.jpg');
INSERT INTO photos VALUES ('8251', '736', '289', 'id8251.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/289.jpg');
INSERT INTO photos VALUES ('8250', '736', '288', 'id8250.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/288.jpg');
INSERT INTO photos VALUES ('8249', '736', '286', 'id8249.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/286.jpg');
INSERT INTO photos VALUES ('8248', '736', '285', 'id8248.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/285.jpg');
INSERT INTO photos VALUES ('8247', '736', '283', 'id8247.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/283.jpg');
INSERT INTO photos VALUES ('8246', '736', '282', 'id8246.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/282.jpg');
INSERT INTO photos VALUES ('8245', '736', '281', 'id8245.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/281.jpg');
INSERT INTO photos VALUES ('8244', '736', '280', 'id8244.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/280.jpg');
INSERT INTO photos VALUES ('8243', '736', '279', 'id8243.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/279.jpg');
INSERT INTO photos VALUES ('8242', '736', '278', 'id8242.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/278.jpg');
INSERT INTO photos VALUES ('8241', '736', '275', 'id8241.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/275.jpg');
INSERT INTO photos VALUES ('8240', '736', '271', 'id8240.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/271.jpg');
INSERT INTO photos VALUES ('8239', '736', '269', 'id8239.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/269.jpg');
INSERT INTO photos VALUES ('8238', '736', '268', 'id8238.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/268.jpg');
INSERT INTO photos VALUES ('8237', '736', '267', 'id8237.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/267.jpg');
INSERT INTO photos VALUES ('8236', '736', '266', 'id8236.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/266.jpg');
INSERT INTO photos VALUES ('8235', '736', '265', 'id8235.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/265.jpg');
INSERT INTO photos VALUES ('8234', '736', '264', 'id8234.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/264.jpg');
INSERT INTO photos VALUES ('8233', '736', '263', 'id8233.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/263.jpg');
INSERT INTO photos VALUES ('8232', '736', '262', 'id8232.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/262.jpg');
INSERT INTO photos VALUES ('8231', '736', '261', 'id8231.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/261.jpg');
INSERT INTO photos VALUES ('8230', '736', '260', 'id8230.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/260.jpg');
INSERT INTO photos VALUES ('8229', '736', '258', 'id8229.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/258.jpg');
INSERT INTO photos VALUES ('8228', '736', '257', 'id8228.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/257.jpg');
INSERT INTO photos VALUES ('8227', '736', '256', 'id8227.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/256.jpg');
INSERT INTO photos VALUES ('8226', '736', '255', 'id8226.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/255.jpg');
INSERT INTO photos VALUES ('8225', '736', '254', 'id8225.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/254.jpg');
INSERT INTO photos VALUES ('8224', '736', '253', 'id8224.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/253.jpg');
INSERT INTO photos VALUES ('8223', '736', '252', 'id8223.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/252.jpg');
INSERT INTO photos VALUES ('8222', '736', '251', 'id8222.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/251.jpg');
INSERT INTO photos VALUES ('8221', '736', '250', 'id8221.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/250.jpg');
INSERT INTO photos VALUES ('8220', '736', '249', 'id8220.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/249.jpg');
INSERT INTO photos VALUES ('8219', '736', '248', 'id8219.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/248.jpg');
INSERT INTO photos VALUES ('8218', '736', '247', 'id8218.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/247.jpg');
INSERT INTO photos VALUES ('8217', '736', '243', 'id8217.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/243.jpg');
INSERT INTO photos VALUES ('8216', '736', '242', 'id8216.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/242.jpg');
INSERT INTO photos VALUES ('8215', '736', '240', 'id8215.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/240.jpg');
INSERT INTO photos VALUES ('8214', '736', '239', 'id8214.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/239.jpg');
INSERT INTO photos VALUES ('8213', '736', '237', 'id8213.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/237.jpg');
INSERT INTO photos VALUES ('8212', '736', '236', 'id8212.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/236.jpg');
INSERT INTO photos VALUES ('8211', '736', '235', 'id8211.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/235.jpg');
INSERT INTO photos VALUES ('8210', '736', '230', 'id8210.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/230.jpg');
INSERT INTO photos VALUES ('8209', '736', '229', 'id8209.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/229.jpg');
INSERT INTO photos VALUES ('8208', '736', '227', 'id8208.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/227.jpg');
INSERT INTO photos VALUES ('8207', '736', '226', 'id8207.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/226.jpg');
INSERT INTO photos VALUES ('8206', '736', '225', 'id8206.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/225.jpg');
INSERT INTO photos VALUES ('8205', '736', '224', 'id8205.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/224.jpg');
INSERT INTO photos VALUES ('8204', '736', '223', 'id8204.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/223.jpg');
INSERT INTO photos VALUES ('8203', '736', '222', 'id8203.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/222.jpg');
INSERT INTO photos VALUES ('8202', '736', '221', 'id8202.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/221.jpg');
INSERT INTO photos VALUES ('8201', '736', '220', 'id8201.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/220.jpg');
INSERT INTO photos VALUES ('8200', '736', '219', 'id8200.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/219.jpg');
INSERT INTO photos VALUES ('8199', '736', '218', 'id8199.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/218.jpg');
INSERT INTO photos VALUES ('8198', '736', '217', 'id8198.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/217.jpg');
INSERT INTO photos VALUES ('8197', '736', '216', 'id8197.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/216.jpg');
INSERT INTO photos VALUES ('8196', '736', '214', 'id8196.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/214.jpg');
INSERT INTO photos VALUES ('8195', '736', '213', 'id8195.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/213.jpg');
INSERT INTO photos VALUES ('8194', '736', '212', 'id8194.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/212.jpg');
INSERT INTO photos VALUES ('8193', '736', '211', 'id8193.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/211.jpg');
INSERT INTO photos VALUES ('8192', '736', '210', 'id8192.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/210.jpg');
INSERT INTO photos VALUES ('8191', '736', '208', 'id8191.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/208.jpg');
INSERT INTO photos VALUES ('8190', '736', '207', 'id8190.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/207.jpg');
INSERT INTO photos VALUES ('8189', '736', '206', 'id8189.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/206.jpg');
INSERT INTO photos VALUES ('8188', '736', '205', 'id8188.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/205.jpg');
INSERT INTO photos VALUES ('8187', '736', '204', 'id8187.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/204.jpg');
INSERT INTO photos VALUES ('8186', '736', '203', 'id8186.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/203.jpg');
INSERT INTO photos VALUES ('8185', '736', '202', 'id8185.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/202.jpg');
INSERT INTO photos VALUES ('8184', '736', '201', 'id8184.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/201.jpg');
INSERT INTO photos VALUES ('8183', '736', '199', 'id8183.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/199.jpg');
INSERT INTO photos VALUES ('8182', '736', '198', 'id8182.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/198.jpg');
INSERT INTO photos VALUES ('8181', '736', '197', 'id8181.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/197.jpg');
INSERT INTO photos VALUES ('8180', '736', '196', 'id8180.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/196.jpg');
INSERT INTO photos VALUES ('8179', '736', '195', 'id8179.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/195.jpg');
INSERT INTO photos VALUES ('8178', '736', '194', 'id8178.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/194.jpg');
INSERT INTO photos VALUES ('8177', '736', '193', 'id8177.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/193.jpg');
INSERT INTO photos VALUES ('8176', '736', '192', 'id8176.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/192.jpg');
INSERT INTO photos VALUES ('8175', '736', '191', 'id8175.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/191.jpg');
INSERT INTO photos VALUES ('8174', '736', '190', 'id8174.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/190.jpg');
INSERT INTO photos VALUES ('8173', '736', '189', 'id8173.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/189.jpg');
INSERT INTO photos VALUES ('8172', '736', '188', 'id8172.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/188.jpg');
INSERT INTO photos VALUES ('8171', '736', '187', 'id8171.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/187.jpg');
INSERT INTO photos VALUES ('8170', '736', '185', 'id8170.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/185.jpg');
INSERT INTO photos VALUES ('8169', '736', '184', 'id8169.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/184.jpg');
INSERT INTO photos VALUES ('8168', '736', '183', 'id8168.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/183.jpg');
INSERT INTO photos VALUES ('8167', '736', '182', 'id8167.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/182.jpg');
INSERT INTO photos VALUES ('8166', '736', '181', 'id8166.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/181.jpg');
INSERT INTO photos VALUES ('8165', '736', '180', 'id8165.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/180.jpg');
INSERT INTO photos VALUES ('8164', '736', '179', 'id8164.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/179.jpg');
INSERT INTO photos VALUES ('8163', '736', '176', 'id8163.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/176.jpg');
INSERT INTO photos VALUES ('8162', '736', '175', 'id8162.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/175.jpg');
INSERT INTO photos VALUES ('8161', '736', '174', 'id8161.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/174.jpg');
INSERT INTO photos VALUES ('8160', '736', '173', 'id8160.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/173.jpg');
INSERT INTO photos VALUES ('8159', '736', '172', 'id8159.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/172.jpg');
INSERT INTO photos VALUES ('8158', '736', '171', 'id8158.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/171.jpg');
INSERT INTO photos VALUES ('8157', '736', '170', 'id8157.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/170.jpg');
INSERT INTO photos VALUES ('8156', '736', '169', 'id8156.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/169.jpg');
INSERT INTO photos VALUES ('8155', '736', '168', 'id8155.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/168.jpg');
INSERT INTO photos VALUES ('8154', '736', '167', 'id8154.jpg', '5', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/167.jpg');
INSERT INTO photos VALUES ('8153', '736', '166', 'id8153.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/166.jpg');
INSERT INTO photos VALUES ('8152', '736', '165', 'id8152.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/165.jpg');
INSERT INTO photos VALUES ('8151', '736', '164', 'id8151.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/164.jpg');
INSERT INTO photos VALUES ('8150', '736', '163', 'id8150.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/163.jpg');
INSERT INTO photos VALUES ('8149', '736', '162', 'id8149.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/162.jpg');
INSERT INTO photos VALUES ('8148', '736', '161', 'id8148.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/161.jpg');
INSERT INTO photos VALUES ('8147', '736', '159', 'id8147.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/159.jpg');
INSERT INTO photos VALUES ('8146', '736', '158', 'id8146.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/158.jpg');
INSERT INTO photos VALUES ('8145', '736', '157', 'id8145.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/157.jpg');
INSERT INTO photos VALUES ('8144', '736', '156', 'id8144.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/156.jpg');
INSERT INTO photos VALUES ('8143', '736', '155', 'id8143.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/155.jpg');
INSERT INTO photos VALUES ('8142', '736', '154', 'id8142.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/154.jpg');
INSERT INTO photos VALUES ('8141', '736', '153', 'id8141.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/153.jpg');
INSERT INTO photos VALUES ('8140', '736', '152', 'id8140.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/152.jpg');
INSERT INTO photos VALUES ('8139', '736', '151', 'id8139.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/151.jpg');
INSERT INTO photos VALUES ('8138', '736', '150', 'id8138.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/150.jpg');
INSERT INTO photos VALUES ('8137', '736', '149', 'id8137.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/149.jpg');
INSERT INTO photos VALUES ('8136', '736', '148', 'id8136.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/148.jpg');
INSERT INTO photos VALUES ('8135', '736', '147', 'id8135.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/147.jpg');
INSERT INTO photos VALUES ('8134', '736', '146', 'id8134.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/146.jpg');
INSERT INTO photos VALUES ('8133', '736', '145', 'id8133.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/145.jpg');
INSERT INTO photos VALUES ('8132', '736', '144', 'id8132.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/144.jpg');
INSERT INTO photos VALUES ('8131', '736', '143', 'id8131.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/143.jpg');
INSERT INTO photos VALUES ('8130', '736', '142', 'id8130.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/142.jpg');
INSERT INTO photos VALUES ('8129', '736', '141', 'id8129.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/141.jpg');
INSERT INTO photos VALUES ('8128', '736', '140', 'id8128.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/140.jpg');
INSERT INTO photos VALUES ('8127', '736', '139', 'id8127.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/139.jpg');
INSERT INTO photos VALUES ('8126', '736', '138', 'id8126.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/138.jpg');
INSERT INTO photos VALUES ('8125', '736', '136', 'id8125.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/136.jpg');
INSERT INTO photos VALUES ('8124', '736', '135', 'id8124.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/135.jpg');
INSERT INTO photos VALUES ('8123', '736', '134', 'id8123.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/134.jpg');
INSERT INTO photos VALUES ('8122', '736', '133', 'id8122.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/133.jpg');
INSERT INTO photos VALUES ('8121', '736', '132', 'id8121.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/132.jpg');
INSERT INTO photos VALUES ('8120', '736', '131', 'id8120.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/131.jpg');
INSERT INTO photos VALUES ('8119', '736', '130', 'id8119.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/130.jpg');
INSERT INTO photos VALUES ('8118', '736', '129', 'id8118.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/129.jpg');
INSERT INTO photos VALUES ('8117', '736', '128', 'id8117.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/128.jpg');
INSERT INTO photos VALUES ('8116', '736', '127', 'id8116.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/127.jpg');
INSERT INTO photos VALUES ('8115', '736', '126', 'id8115.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/126.jpg');
INSERT INTO photos VALUES ('8114', '736', '125', 'id8114.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/125.jpg');
INSERT INTO photos VALUES ('8113', '736', '124', 'id8113.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/124.jpg');
INSERT INTO photos VALUES ('8112', '736', '123', 'id8112.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/123.jpg');
INSERT INTO photos VALUES ('8111', '736', '122', 'id8111.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/122.jpg');
INSERT INTO photos VALUES ('8110', '736', '121', 'id8110.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/121.jpg');
INSERT INTO photos VALUES ('8109', '736', '120', 'id8109.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/120.jpg');
INSERT INTO photos VALUES ('8108', '736', '118', 'id8108.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/118.jpg');
INSERT INTO photos VALUES ('8107', '736', '117', 'id8107.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/117.jpg');
INSERT INTO photos VALUES ('8106', '736', '115', 'id8106.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/115.jpg');
INSERT INTO photos VALUES ('8105', '736', '113', 'id8105.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/113.jpg');
INSERT INTO photos VALUES ('8104', '736', '112', 'id8104.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/112.jpg');
INSERT INTO photos VALUES ('8103', '736', '111', 'id8103.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/111.jpg');
INSERT INTO photos VALUES ('8102', '736', '110', 'id8102.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/110.jpg');
INSERT INTO photos VALUES ('8101', '736', '109', 'id8101.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/109.jpg');
INSERT INTO photos VALUES ('8100', '736', '108', 'id8100.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/108.jpg');
INSERT INTO photos VALUES ('8099', '736', '107', 'id8099.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/107.jpg');
INSERT INTO photos VALUES ('8098', '736', '105', 'id8098.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/105.jpg');
INSERT INTO photos VALUES ('8097', '736', '104', 'id8097.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/104.jpg');
INSERT INTO photos VALUES ('8096', '736', '103', 'id8096.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/103.jpg');
INSERT INTO photos VALUES ('8095', '736', '102', 'id8095.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/102.jpg');
INSERT INTO photos VALUES ('8094', '736', '101', 'id8094.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/101.jpg');
INSERT INTO photos VALUES ('8093', '736', '100', 'id8093.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/100.jpg');
INSERT INTO photos VALUES ('8092', '736', '099', 'id8092.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/099.jpg');
INSERT INTO photos VALUES ('8091', '736', '098', 'id8091.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/098.jpg');
INSERT INTO photos VALUES ('8090', '736', '097', 'id8090.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/097.jpg');
INSERT INTO photos VALUES ('8089', '736', '096', 'id8089.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/096.jpg');
INSERT INTO photos VALUES ('8088', '736', '095', 'id8088.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/095.jpg');
INSERT INTO photos VALUES ('8087', '736', '094', 'id8087.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/094.jpg');
INSERT INTO photos VALUES ('8086', '736', '093', 'id8086.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/093.jpg');
INSERT INTO photos VALUES ('8085', '736', '092', 'id8085.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/092.jpg');
INSERT INTO photos VALUES ('8084', '736', '091', 'id8084.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/091.jpg');
INSERT INTO photos VALUES ('8083', '736', '090', 'id8083.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/090.jpg');
INSERT INTO photos VALUES ('8082', '736', '089', 'id8082.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/089.jpg');
INSERT INTO photos VALUES ('8081', '736', '088', 'id8081.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/088.jpg');
INSERT INTO photos VALUES ('8080', '736', '087', 'id8080.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/087.jpg');
INSERT INTO photos VALUES ('8079', '736', '086', 'id8079.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/086.jpg');
INSERT INTO photos VALUES ('8078', '736', '085', 'id8078.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/085.jpg');
INSERT INTO photos VALUES ('8077', '736', '084', 'id8077.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/084.jpg');
INSERT INTO photos VALUES ('8076', '736', '083', 'id8076.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/083.jpg');
INSERT INTO photos VALUES ('8075', '736', '082', 'id8075.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/082.jpg');
INSERT INTO photos VALUES ('8074', '736', '081', 'id8074.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/081.jpg');
INSERT INTO photos VALUES ('8073', '736', '080', 'id8073.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/080.jpg');
INSERT INTO photos VALUES ('8072', '736', '079', 'id8072.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/079.jpg');
INSERT INTO photos VALUES ('8071', '736', '078', 'id8071.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/078.jpg');
INSERT INTO photos VALUES ('8070', '736', '077', 'id8070.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/077.jpg');
INSERT INTO photos VALUES ('8069', '736', '076', 'id8069.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/076.jpg');
INSERT INTO photos VALUES ('8068', '736', '075', 'id8068.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/075.jpg');
INSERT INTO photos VALUES ('8067', '736', '074', 'id8067.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/074.jpg');
INSERT INTO photos VALUES ('8066', '736', '073', 'id8066.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/073.jpg');
INSERT INTO photos VALUES ('8065', '736', '072', 'id8065.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/072.jpg');
INSERT INTO photos VALUES ('8064', '736', '071', 'id8064.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/071.jpg');
INSERT INTO photos VALUES ('8063', '736', '070', 'id8063.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/070.jpg');
INSERT INTO photos VALUES ('8062', '736', '069', 'id8062.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/069.jpg');
INSERT INTO photos VALUES ('8061', '736', '068', 'id8061.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/068.jpg');
INSERT INTO photos VALUES ('8060', '736', '067', 'id8060.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/067.jpg');
INSERT INTO photos VALUES ('8059', '736', '066', 'id8059.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/066.jpg');
INSERT INTO photos VALUES ('8058', '736', '065', 'id8058.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/065.jpg');
INSERT INTO photos VALUES ('8057', '736', '064', 'id8057.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/064.jpg');
INSERT INTO photos VALUES ('8056', '736', '063', 'id8056.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/063.jpg');
INSERT INTO photos VALUES ('8055', '736', '062', 'id8055.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/062.jpg');
INSERT INTO photos VALUES ('8054', '736', '061', 'id8054.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/061.jpg');
INSERT INTO photos VALUES ('8053', '736', '060', 'id8053.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/060.jpg');
INSERT INTO photos VALUES ('8052', '736', '059', 'id8052.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/059.jpg');
INSERT INTO photos VALUES ('8051', '736', '058', 'id8051.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/058.jpg');
INSERT INTO photos VALUES ('8050', '736', '057', 'id8050.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/057.jpg');
INSERT INTO photos VALUES ('8049', '736', '056', 'id8049.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/056.jpg');
INSERT INTO photos VALUES ('8048', '736', '055', 'id8048.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/055.jpg');
INSERT INTO photos VALUES ('8047', '736', '054', 'id8047.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/054.jpg');
INSERT INTO photos VALUES ('8046', '736', '053', 'id8046.jpg', '1', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/053.jpg');
INSERT INTO photos VALUES ('8045', '736', '051', 'id8045.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/051.jpg');
INSERT INTO photos VALUES ('8044', '736', '050', 'id8044.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/050.jpg');
INSERT INTO photos VALUES ('8043', '736', '049', 'id8043.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/049.jpg');
INSERT INTO photos VALUES ('8042', '736', '048', 'id8042.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/048.jpg');
INSERT INTO photos VALUES ('8041', '736', '046', 'id8041.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/046.jpg');
INSERT INTO photos VALUES ('8040', '736', '045', 'id8040.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/045.jpg');
INSERT INTO photos VALUES ('8039', '736', '044', 'id8039.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/044.jpg');
INSERT INTO photos VALUES ('8038', '736', '043', 'id8038.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/043.jpg');
INSERT INTO photos VALUES ('8037', '736', '042', 'id8037.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/042.jpg');
INSERT INTO photos VALUES ('8036', '736', '041', 'id8036.jpg', '1', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/041.jpg');
INSERT INTO photos VALUES ('8035', '736', '040', 'id8035.jpg', '4', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/040.jpg');
INSERT INTO photos VALUES ('8034', '736', '039', 'id8034.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/039.jpg');
INSERT INTO photos VALUES ('8033', '736', '038', 'id8033.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/038.jpg');
INSERT INTO photos VALUES ('8032', '736', '037', 'id8032.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/037.jpg');
INSERT INTO photos VALUES ('8031', '736', '036', 'id8031.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/036.jpg');
INSERT INTO photos VALUES ('8030', '736', '035', 'id8030.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/035.jpg');
INSERT INTO photos VALUES ('8029', '736', '034', 'id8029.jpg', '3', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/034.jpg');
INSERT INTO photos VALUES ('8028', '736', '033', 'id8028.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/033.jpg');
INSERT INTO photos VALUES ('8027', '736', '032', 'id8027.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/032.jpg');
INSERT INTO photos VALUES ('8026', '736', '031', 'id8026.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/031.jpg');
INSERT INTO photos VALUES ('8025', '736', '030', 'id8025.jpg', '3', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/030.jpg');
INSERT INTO photos VALUES ('8024', '736', '029', 'id8024.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/029.jpg');
INSERT INTO photos VALUES ('8023', '736', '028', 'id8023.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/028.jpg');
INSERT INTO photos VALUES ('8022', '736', '027', 'id8022.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/027.jpg');
INSERT INTO photos VALUES ('8021', '736', '026', 'id8021.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/026.jpg');
INSERT INTO photos VALUES ('8020', '736', '025', 'id8020.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/025.jpg');
INSERT INTO photos VALUES ('8019', '736', '024', 'id8019.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/024.jpg');
INSERT INTO photos VALUES ('8018', '736', '023', 'id8018.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/023.jpg');
INSERT INTO photos VALUES ('8017', '736', '022', 'id8017.jpg', '2', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/022.jpg');
INSERT INTO photos VALUES ('8016', '736', '021', 'id8016.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/021.jpg');
INSERT INTO photos VALUES ('8015', '736', '020', 'id8015.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/020.jpg');
INSERT INTO photos VALUES ('8014', '736', '019', 'id8014.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/019.jpg');
INSERT INTO photos VALUES ('8013', '736', '018', 'id8013.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/018.jpg');
INSERT INTO photos VALUES ('8012', '736', '017', 'id8012.jpg', '1', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/017.jpg');
INSERT INTO photos VALUES ('8011', '736', '016', 'id8011.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/016.jpg');
INSERT INTO photos VALUES ('8010', '736', '014', 'id8010.jpg', '4', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/014.jpg');
INSERT INTO photos VALUES ('8009', '736', '013', 'id8009.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/013.jpg');
INSERT INTO photos VALUES ('8008', '736', '012', 'id8008.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/012.jpg');
INSERT INTO photos VALUES ('8007', '736', '011', 'id8007.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/011.jpg');
INSERT INTO photos VALUES ('8006', '736', '009', 'id8006.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/009.jpg');
INSERT INTO photos VALUES ('8005', '736', '008', 'id8005.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/008.jpg');
INSERT INTO photos VALUES ('8004', '736', '007', 'id8004.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/007.jpg');
INSERT INTO photos VALUES ('8003', '736', '004', 'id8003.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/004.jpg');
INSERT INTO photos VALUES ('8002', '736', '003', 'id8002.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/003.jpg');
INSERT INTO photos VALUES ('8001', '736', '001', 'id8001.jpg', '0', '8.15', '10.00', '40.00', '/fotoarhiv/deti/18.05.2013/001.jpg');
INSERT INTO photos VALUES ('8733', '737', '0534', 'id8733.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0534.jpg');
INSERT INTO photos VALUES ('8732', '737', '0533', 'id8732.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0533.jpg');
INSERT INTO photos VALUES ('8731', '737', '0532', 'id8731.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0532.jpg');
INSERT INTO photos VALUES ('8730', '737', '0531', 'id8730.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0531.jpg');
INSERT INTO photos VALUES ('8729', '737', '0530', 'id8729.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0530.jpg');
INSERT INTO photos VALUES ('8728', '737', '0529', 'id8728.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0529.jpg');
INSERT INTO photos VALUES ('8727', '737', '0528', 'id8727.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0528.jpg');
INSERT INTO photos VALUES ('8726', '737', '0527', 'id8726.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0527.jpg');
INSERT INTO photos VALUES ('8725', '737', '0526', 'id8725.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0526.jpg');
INSERT INTO photos VALUES ('8724', '737', '0525', 'id8724.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0525.jpg');
INSERT INTO photos VALUES ('8723', '737', '0502', 'id8723.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0502.jpg');
INSERT INTO photos VALUES ('8722', '737', '0501', 'id8722.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0501.jpg');
INSERT INTO photos VALUES ('8721', '737', '0500', 'id8721.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0500.jpg');
INSERT INTO photos VALUES ('8720', '737', '0498', 'id8720.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0498.jpg');
INSERT INTO photos VALUES ('8719', '737', '0497', 'id8719.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0497.jpg');
INSERT INTO photos VALUES ('8718', '737', '0496', 'id8718.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0496.jpg');
INSERT INTO photos VALUES ('8717', '737', '0495', 'id8717.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0495.jpg');
INSERT INTO photos VALUES ('8716', '737', '0492', 'id8716.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0492.jpg');
INSERT INTO photos VALUES ('8715', '737', '0491', 'id8715.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0491.jpg');
INSERT INTO photos VALUES ('8714', '737', '0490', 'id8714.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0490.jpg');
INSERT INTO photos VALUES ('8713', '737', '0488', 'id8713.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0488.jpg');
INSERT INTO photos VALUES ('8712', '737', '0486', 'id8712.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0486.jpg');
INSERT INTO photos VALUES ('8711', '737', '0484', 'id8711.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0484.jpg');
INSERT INTO photos VALUES ('8710', '737', '0482', 'id8710.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0482.jpg');
INSERT INTO photos VALUES ('8709', '737', '0481', 'id8709.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0481.jpg');
INSERT INTO photos VALUES ('8708', '737', '0479', 'id8708.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0479.jpg');
INSERT INTO photos VALUES ('8707', '737', '0478', 'id8707.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0478.jpg');
INSERT INTO photos VALUES ('8706', '737', '0477', 'id8706.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0477.jpg');
INSERT INTO photos VALUES ('8705', '737', '0475', 'id8705.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0475.jpg');
INSERT INTO photos VALUES ('8704', '737', '0473', 'id8704.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0473.jpg');
INSERT INTO photos VALUES ('8703', '737', '0470', 'id8703.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0470.jpg');
INSERT INTO photos VALUES ('8702', '737', '0469', 'id8702.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0469.jpg');
INSERT INTO photos VALUES ('8701', '737', '0468', 'id8701.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0468.jpg');
INSERT INTO photos VALUES ('8700', '737', '0466', 'id8700.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0466.jpg');
INSERT INTO photos VALUES ('8699', '737', '0465', 'id8699.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0465.jpg');
INSERT INTO photos VALUES ('8698', '737', '0461', 'id8698.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0461.jpg');
INSERT INTO photos VALUES ('8697', '737', '0460', 'id8697.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0460.jpg');
INSERT INTO photos VALUES ('8696', '737', '0458', 'id8696.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0458.jpg');
INSERT INTO photos VALUES ('8695', '737', '0455', 'id8695.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0455.jpg');
INSERT INTO photos VALUES ('8694', '737', '0454', 'id8694.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0454.jpg');
INSERT INTO photos VALUES ('8693', '737', '0453', 'id8693.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0453.jpg');
INSERT INTO photos VALUES ('8692', '737', '0452', 'id8692.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0452.jpg');
INSERT INTO photos VALUES ('8691', '737', '0451', 'id8691.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0451.jpg');
INSERT INTO photos VALUES ('8690', '737', '0450', 'id8690.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0450.jpg');
INSERT INTO photos VALUES ('8689', '737', '0449', 'id8689.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0449.jpg');
INSERT INTO photos VALUES ('8688', '737', '0448', 'id8688.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0448.jpg');
INSERT INTO photos VALUES ('8687', '737', '0447', 'id8687.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0447.jpg');
INSERT INTO photos VALUES ('8686', '737', '0446', 'id8686.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0446.jpg');
INSERT INTO photos VALUES ('8685', '737', '0445', 'id8685.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0445.jpg');
INSERT INTO photos VALUES ('8684', '737', '0444', 'id8684.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0444.jpg');
INSERT INTO photos VALUES ('8683', '737', '0443', 'id8683.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0443.jpg');
INSERT INTO photos VALUES ('8682', '737', '0442', 'id8682.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0442.jpg');
INSERT INTO photos VALUES ('8681', '737', '0441', 'id8681.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0441.jpg');
INSERT INTO photos VALUES ('8680', '737', '0440', 'id8680.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0440.jpg');
INSERT INTO photos VALUES ('8679', '737', '0438', 'id8679.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0438.jpg');
INSERT INTO photos VALUES ('8678', '737', '0436', 'id8678.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0436.jpg');
INSERT INTO photos VALUES ('8677', '737', '0435', 'id8677.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0435.jpg');
INSERT INTO photos VALUES ('8676', '737', '0434', 'id8676.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0434.jpg');
INSERT INTO photos VALUES ('8675', '737', '0433', 'id8675.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0433.jpg');
INSERT INTO photos VALUES ('8674', '737', '0432', 'id8674.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0432.jpg');
INSERT INTO photos VALUES ('8673', '737', '0429', 'id8673.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0429.jpg');
INSERT INTO photos VALUES ('8672', '737', '0427', 'id8672.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0427.jpg');
INSERT INTO photos VALUES ('8671', '737', '0426', 'id8671.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0426.jpg');
INSERT INTO photos VALUES ('8670', '737', '0425', 'id8670.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0425.jpg');
INSERT INTO photos VALUES ('8669', '737', '0424', 'id8669.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0424.jpg');
INSERT INTO photos VALUES ('8668', '737', '0422', 'id8668.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0422.jpg');
INSERT INTO photos VALUES ('8667', '737', '0418', 'id8667.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0418.jpg');
INSERT INTO photos VALUES ('8666', '737', '0417', 'id8666.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0417.jpg');
INSERT INTO photos VALUES ('8665', '737', '0415', 'id8665.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0415.jpg');
INSERT INTO photos VALUES ('8664', '737', '0414', 'id8664.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0414.jpg');
INSERT INTO photos VALUES ('8663', '737', '0412', 'id8663.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0412.jpg');
INSERT INTO photos VALUES ('8662', '737', '0411', 'id8662.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0411.jpg');
INSERT INTO photos VALUES ('8661', '737', '0409', 'id8661.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0409.jpg');
INSERT INTO photos VALUES ('8660', '737', '0407', 'id8660.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0407.jpg');
INSERT INTO photos VALUES ('8659', '737', '0405', 'id8659.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0405.jpg');
INSERT INTO photos VALUES ('8658', '737', '0404', 'id8658.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0404.jpg');
INSERT INTO photos VALUES ('8657', '737', '0403', 'id8657.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0403.jpg');
INSERT INTO photos VALUES ('8656', '737', '0369', 'id8656.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0369.jpg');
INSERT INTO photos VALUES ('8655', '737', '0368', 'id8655.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0368.jpg');
INSERT INTO photos VALUES ('8654', '737', '0344', 'id8654.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0344.jpg');
INSERT INTO photos VALUES ('8653', '737', '0343', 'id8653.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0343.jpg');
INSERT INTO photos VALUES ('8652', '737', '0342', 'id8652.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0342.jpg');
INSERT INTO photos VALUES ('8651', '737', '0341', 'id8651.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0341.jpg');
INSERT INTO photos VALUES ('8650', '737', '0339', 'id8650.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0339.jpg');
INSERT INTO photos VALUES ('8649', '737', '0337', 'id8649.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0337.jpg');
INSERT INTO photos VALUES ('8648', '737', '0335', 'id8648.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0335.jpg');
INSERT INTO photos VALUES ('8647', '737', '0334', 'id8647.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0334.jpg');
INSERT INTO photos VALUES ('8646', '737', '0309', 'id8646.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0309.jpg');
INSERT INTO photos VALUES ('8645', '737', '0307', 'id8645.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0307.jpg');
INSERT INTO photos VALUES ('8644', '737', '0306', 'id8644.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0306.jpg');
INSERT INTO photos VALUES ('8643', '737', '0305', 'id8643.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0305.jpg');
INSERT INTO photos VALUES ('8642', '737', '0304', 'id8642.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0304.jpg');
INSERT INTO photos VALUES ('8641', '737', '0303', 'id8641.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0303.jpg');
INSERT INTO photos VALUES ('8640', '737', '0302', 'id8640.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0302.jpg');
INSERT INTO photos VALUES ('8639', '737', '0301', 'id8639.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0301.jpg');
INSERT INTO photos VALUES ('8638', '737', '0299', 'id8638.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0299.jpg');
INSERT INTO photos VALUES ('8637', '737', '0298', 'id8637.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0298.jpg');
INSERT INTO photos VALUES ('8636', '737', '0297', 'id8636.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0297.jpg');
INSERT INTO photos VALUES ('8635', '737', '0294', 'id8635.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0294.jpg');
INSERT INTO photos VALUES ('8634', '737', '0292', 'id8634.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0292.jpg');
INSERT INTO photos VALUES ('8633', '737', '0291', 'id8633.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0291.jpg');
INSERT INTO photos VALUES ('8632', '737', '0290', 'id8632.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0290.jpg');
INSERT INTO photos VALUES ('8631', '737', '0289', 'id8631.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0289.jpg');
INSERT INTO photos VALUES ('8630', '737', '0288', 'id8630.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0288.jpg');
INSERT INTO photos VALUES ('8629', '737', '0287', 'id8629.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0287.jpg');
INSERT INTO photos VALUES ('8628', '737', '0286', 'id8628.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0286.jpg');
INSERT INTO photos VALUES ('8627', '737', '0285', 'id8627.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0285.jpg');
INSERT INTO photos VALUES ('8626', '737', '0284', 'id8626.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0284.jpg');
INSERT INTO photos VALUES ('8625', '737', '0281', 'id8625.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0281.jpg');
INSERT INTO photos VALUES ('8624', '737', '0280', 'id8624.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0280.jpg');
INSERT INTO photos VALUES ('8623', '737', '0279', 'id8623.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0279.jpg');
INSERT INTO photos VALUES ('8622', '737', '0278', 'id8622.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0278.jpg');
INSERT INTO photos VALUES ('8621', '737', '0277', 'id8621.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0277.jpg');
INSERT INTO photos VALUES ('8620', '737', '0275', 'id8620.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0275.jpg');
INSERT INTO photos VALUES ('8619', '737', '0274', 'id8619.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0274.jpg');
INSERT INTO photos VALUES ('8618', '737', '0273', 'id8618.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0273.jpg');
INSERT INTO photos VALUES ('8617', '737', '0272', 'id8617.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0272.jpg');
INSERT INTO photos VALUES ('8616', '737', '0269', 'id8616.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0269.jpg');
INSERT INTO photos VALUES ('8615', '737', '0268', 'id8615.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0268.jpg');
INSERT INTO photos VALUES ('8614', '737', '0267', 'id8614.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0267.jpg');
INSERT INTO photos VALUES ('8613', '737', '0266', 'id8613.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0266.jpg');
INSERT INTO photos VALUES ('8612', '737', '0264', 'id8612.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0264.jpg');
INSERT INTO photos VALUES ('8611', '737', '0262', 'id8611.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0262.jpg');
INSERT INTO photos VALUES ('8610', '737', '0261', 'id8610.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0261.jpg');
INSERT INTO photos VALUES ('8609', '737', '0260', 'id8609.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0260.jpg');
INSERT INTO photos VALUES ('8608', '737', '0258', 'id8608.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0258.jpg');
INSERT INTO photos VALUES ('8607', '737', '0257', 'id8607.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0257.jpg');
INSERT INTO photos VALUES ('8606', '737', '0256', 'id8606.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0256.jpg');
INSERT INTO photos VALUES ('8605', '737', '0255', 'id8605.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0255.jpg');
INSERT INTO photos VALUES ('8604', '737', '0254', 'id8604.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0254.jpg');
INSERT INTO photos VALUES ('8603', '737', '0253', 'id8603.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0253.jpg');
INSERT INTO photos VALUES ('8602', '737', '0252', 'id8602.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0252.jpg');
INSERT INTO photos VALUES ('8601', '737', '0251', 'id8601.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0251.jpg');
INSERT INTO photos VALUES ('8600', '737', '0249', 'id8600.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0249.jpg');
INSERT INTO photos VALUES ('8599', '737', '0248', 'id8599.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0248.jpg');
INSERT INTO photos VALUES ('8598', '737', '0247', 'id8598.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0247.jpg');
INSERT INTO photos VALUES ('8597', '737', '0246', 'id8597.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0246.jpg');
INSERT INTO photos VALUES ('8596', '737', '0245', 'id8596.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0245.jpg');
INSERT INTO photos VALUES ('8595', '737', '0244', 'id8595.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0244.jpg');
INSERT INTO photos VALUES ('8594', '737', '0243', 'id8594.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0243.jpg');
INSERT INTO photos VALUES ('8593', '737', '0241', 'id8593.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0241.jpg');
INSERT INTO photos VALUES ('8592', '737', '0239', 'id8592.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0239.jpg');
INSERT INTO photos VALUES ('8591', '737', '0236', 'id8591.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0236.jpg');
INSERT INTO photos VALUES ('8590', '737', '0235', 'id8590.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0235.jpg');
INSERT INTO photos VALUES ('8589', '737', '0234', 'id8589.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0234.jpg');
INSERT INTO photos VALUES ('8588', '737', '0233', 'id8588.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0233.jpg');
INSERT INTO photos VALUES ('8587', '737', '0231', 'id8587.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0231.jpg');
INSERT INTO photos VALUES ('8586', '737', '0228', 'id8586.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0228.jpg');
INSERT INTO photos VALUES ('8585', '737', '0227', 'id8585.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0227.jpg');
INSERT INTO photos VALUES ('8584', '737', '0225', 'id8584.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0225.jpg');
INSERT INTO photos VALUES ('8583', '737', '0224', 'id8583.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0224.jpg');
INSERT INTO photos VALUES ('8582', '737', '0223', 'id8582.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0223.jpg');
INSERT INTO photos VALUES ('8581', '737', '0221', 'id8581.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0221.jpg');
INSERT INTO photos VALUES ('8580', '737', '0220', 'id8580.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0220.jpg');
INSERT INTO photos VALUES ('8579', '737', '0219', 'id8579.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0219.jpg');
INSERT INTO photos VALUES ('8578', '737', '0218', 'id8578.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0218.jpg');
INSERT INTO photos VALUES ('8577', '737', '0217', 'id8577.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0217.jpg');
INSERT INTO photos VALUES ('8576', '737', '0216', 'id8576.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0216.jpg');
INSERT INTO photos VALUES ('8575', '737', '0215', 'id8575.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0215.jpg');
INSERT INTO photos VALUES ('8574', '737', '0212', 'id8574.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0212.jpg');
INSERT INTO photos VALUES ('8573', '737', '0211', 'id8573.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0211.jpg');
INSERT INTO photos VALUES ('8572', '737', '0210', 'id8572.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0210.jpg');
INSERT INTO photos VALUES ('8571', '737', '0209', 'id8571.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0209.jpg');
INSERT INTO photos VALUES ('8570', '737', '0207', 'id8570.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0207.jpg');
INSERT INTO photos VALUES ('8569', '737', '0206', 'id8569.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0206.jpg');
INSERT INTO photos VALUES ('8568', '737', '0205', 'id8568.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0205.jpg');
INSERT INTO photos VALUES ('8567', '737', '0204', 'id8567.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0204.jpg');
INSERT INTO photos VALUES ('8566', '737', '0203', 'id8566.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0203.jpg');
INSERT INTO photos VALUES ('8565', '737', '0202', 'id8565.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0202.jpg');
INSERT INTO photos VALUES ('8564', '737', '0201', 'id8564.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0201.jpg');
INSERT INTO photos VALUES ('8563', '737', '0200', 'id8563.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0200.jpg');
INSERT INTO photos VALUES ('8562', '737', '0199', 'id8562.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0199.jpg');
INSERT INTO photos VALUES ('8561', '737', '0198', 'id8561.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0198.jpg');
INSERT INTO photos VALUES ('8560', '737', '0197', 'id8560.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0197.jpg');
INSERT INTO photos VALUES ('8559', '737', '0196', 'id8559.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0196.jpg');
INSERT INTO photos VALUES ('8558', '737', '0195', 'id8558.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0195.jpg');
INSERT INTO photos VALUES ('8557', '737', '0193', 'id8557.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0193.jpg');
INSERT INTO photos VALUES ('8556', '737', '0192', 'id8556.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0192.jpg');
INSERT INTO photos VALUES ('8555', '737', '0174', 'id8555.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0174.jpg');
INSERT INTO photos VALUES ('8554', '737', '0173', 'id8554.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0173.jpg');
INSERT INTO photos VALUES ('8553', '737', '0171', 'id8553.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0171.jpg');
INSERT INTO photos VALUES ('8552', '737', '0170', 'id8552.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0170.jpg');
INSERT INTO photos VALUES ('8551', '737', '0168', 'id8551.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0168.jpg');
INSERT INTO photos VALUES ('8550', '737', '0167', 'id8550.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0167.jpg');
INSERT INTO photos VALUES ('8549', '737', '0166', 'id8549.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0166.jpg');
INSERT INTO photos VALUES ('8548', '737', '0165', 'id8548.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0165.jpg');
INSERT INTO photos VALUES ('8547', '737', '0164', 'id8547.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0164.jpg');
INSERT INTO photos VALUES ('8546', '737', '0161', 'id8546.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0161.jpg');
INSERT INTO photos VALUES ('8545', '737', '0160', 'id8545.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0160.jpg');
INSERT INTO photos VALUES ('8544', '737', '0158', 'id8544.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0158.jpg');
INSERT INTO photos VALUES ('8543', '737', '0156', 'id8543.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0156.jpg');
INSERT INTO photos VALUES ('8542', '737', '0155', 'id8542.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0155.jpg');
INSERT INTO photos VALUES ('8541', '737', '0153', 'id8541.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0153.jpg');
INSERT INTO photos VALUES ('8540', '737', '0152', 'id8540.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0152.jpg');
INSERT INTO photos VALUES ('8539', '737', '0151', 'id8539.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0151.jpg');
INSERT INTO photos VALUES ('8538', '737', '0150', 'id8538.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0150.jpg');
INSERT INTO photos VALUES ('8537', '737', '0148', 'id8537.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0148.jpg');
INSERT INTO photos VALUES ('8536', '737', '0147', 'id8536.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0147.jpg');
INSERT INTO photos VALUES ('8535', '737', '0146', 'id8535.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0146.jpg');
INSERT INTO photos VALUES ('8534', '737', '0144', 'id8534.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0144.jpg');
INSERT INTO photos VALUES ('8533', '737', '0143', 'id8533.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0143.jpg');
INSERT INTO photos VALUES ('8532', '737', '0142', 'id8532.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0142.jpg');
INSERT INTO photos VALUES ('8531', '737', '0141', 'id8531.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0141.jpg');
INSERT INTO photos VALUES ('8530', '737', '0140', 'id8530.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0140.jpg');
INSERT INTO photos VALUES ('8529', '737', '0139', 'id8529.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0139.jpg');
INSERT INTO photos VALUES ('8528', '737', '0136', 'id8528.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0136.jpg');
INSERT INTO photos VALUES ('8527', '737', '0134', 'id8527.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0134.jpg');
INSERT INTO photos VALUES ('8526', '737', '0133', 'id8526.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0133.jpg');
INSERT INTO photos VALUES ('8525', '737', '0132', 'id8525.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0132.jpg');
INSERT INTO photos VALUES ('8524', '737', '0131', 'id8524.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0131.jpg');
INSERT INTO photos VALUES ('8523', '737', '0130', 'id8523.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0130.jpg');
INSERT INTO photos VALUES ('8522', '737', '0129', 'id8522.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0129.jpg');
INSERT INTO photos VALUES ('8521', '737', '0126', 'id8521.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0126.jpg');
INSERT INTO photos VALUES ('8520', '737', '0123', 'id8520.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0123.jpg');
INSERT INTO photos VALUES ('8519', '737', '0121', 'id8519.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0121.jpg');
INSERT INTO photos VALUES ('8518', '737', '0117', 'id8518.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0117.jpg');
INSERT INTO photos VALUES ('8517', '737', '0114', 'id8517.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0114.jpg');
INSERT INTO photos VALUES ('8516', '737', '0112', 'id8516.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0112.jpg');
INSERT INTO photos VALUES ('8515', '737', '0111', 'id8515.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0111.jpg');
INSERT INTO photos VALUES ('8514', '737', '0110', 'id8514.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0110.jpg');
INSERT INTO photos VALUES ('8513', '737', '0109', 'id8513.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0109.jpg');
INSERT INTO photos VALUES ('8512', '737', '0107', 'id8512.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0107.jpg');
INSERT INTO photos VALUES ('8511', '737', '0106', 'id8511.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0106.jpg');
INSERT INTO photos VALUES ('8510', '737', '0103', 'id8510.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0103.jpg');
INSERT INTO photos VALUES ('8509', '737', '0102', 'id8509.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0102.jpg');
INSERT INTO photos VALUES ('8508', '737', '0072', 'id8508.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0072.jpg');
INSERT INTO photos VALUES ('8507', '737', '0071', 'id8507.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0071.jpg');
INSERT INTO photos VALUES ('8506', '737', '0070', 'id8506.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0070.jpg');
INSERT INTO photos VALUES ('8505', '737', '0068', 'id8505.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0068.jpg');
INSERT INTO photos VALUES ('8504', '737', '0066', 'id8504.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0066.jpg');
INSERT INTO photos VALUES ('8503', '737', '0065', 'id8503.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0065.jpg');
INSERT INTO photos VALUES ('8502', '737', '0064', 'id8502.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0064.jpg');
INSERT INTO photos VALUES ('8501', '737', '0063', 'id8501.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0063.jpg');
INSERT INTO photos VALUES ('8500', '737', '0062', 'id8500.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0062.jpg');
INSERT INTO photos VALUES ('8499', '737', '0061', 'id8499.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0061.jpg');
INSERT INTO photos VALUES ('8498', '737', '0059', 'id8498.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0059.jpg');
INSERT INTO photos VALUES ('8497', '737', '0058', 'id8497.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0058.jpg');
INSERT INTO photos VALUES ('8496', '737', '0056', 'id8496.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0056.jpg');
INSERT INTO photos VALUES ('8495', '737', '0054', 'id8495.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0054.jpg');
INSERT INTO photos VALUES ('8494', '737', '0052', 'id8494.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0052.jpg');
INSERT INTO photos VALUES ('8493', '737', '0051', 'id8493.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0051.jpg');
INSERT INTO photos VALUES ('8492', '737', '0050', 'id8492.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0050.jpg');
INSERT INTO photos VALUES ('8491', '737', '0049', 'id8491.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0049.jpg');
INSERT INTO photos VALUES ('8490', '737', '0047', 'id8490.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0047.jpg');
INSERT INTO photos VALUES ('8489', '737', '0046', 'id8489.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0046.jpg');
INSERT INTO photos VALUES ('8488', '737', '0045', 'id8488.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0045.jpg');
INSERT INTO photos VALUES ('8487', '737', '0044', 'id8487.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0044.jpg');
INSERT INTO photos VALUES ('8486', '737', '0042', 'id8486.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0042.jpg');
INSERT INTO photos VALUES ('8485', '737', '0041', 'id8485.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0041.jpg');
INSERT INTO photos VALUES ('8484', '737', '0040', 'id8484.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0040.jpg');
INSERT INTO photos VALUES ('8483', '737', '0039', 'id8483.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0039.jpg');
INSERT INTO photos VALUES ('8482', '737', '0038', 'id8482.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0038.jpg');
INSERT INTO photos VALUES ('8481', '737', '0037', 'id8481.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0037.jpg');
INSERT INTO photos VALUES ('8480', '737', '0036', 'id8480.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0036.jpg');
INSERT INTO photos VALUES ('8479', '737', '0035', 'id8479.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0035.jpg');
INSERT INTO photos VALUES ('8478', '737', '0034', 'id8478.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0034.jpg');
INSERT INTO photos VALUES ('8477', '737', '0033', 'id8477.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0033.jpg');
INSERT INTO photos VALUES ('8476', '737', '0032', 'id8476.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0032.jpg');
INSERT INTO photos VALUES ('8475', '737', '0031', 'id8475.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0031.jpg');
INSERT INTO photos VALUES ('8474', '737', '0030', 'id8474.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0030.jpg');
INSERT INTO photos VALUES ('8473', '737', '0029', 'id8473.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0029.jpg');
INSERT INTO photos VALUES ('8472', '737', '0028', 'id8472.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0028.jpg');
INSERT INTO photos VALUES ('8471', '737', '0027', 'id8471.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0027.jpg');
INSERT INTO photos VALUES ('8470', '737', '0026', 'id8470.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0026.jpg');
INSERT INTO photos VALUES ('8469', '737', '0025', 'id8469.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0025.jpg');
INSERT INTO photos VALUES ('8468', '737', '0024', 'id8468.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0024.jpg');
INSERT INTO photos VALUES ('8467', '737', '0023', 'id8467.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0023.jpg');
INSERT INTO photos VALUES ('8466', '737', '0022', 'id8466.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0022.jpg');
INSERT INTO photos VALUES ('8465', '737', '0021', 'id8465.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0021.jpg');
INSERT INTO photos VALUES ('8464', '737', '0018', 'id8464.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0018.jpg');
INSERT INTO photos VALUES ('8463', '737', '0016', 'id8463.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0016.jpg');
INSERT INTO photos VALUES ('8462', '737', '0015', 'id8462.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0015.jpg');
INSERT INTO photos VALUES ('8461', '737', '0014', 'id8461.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0014.jpg');
INSERT INTO photos VALUES ('8460', '737', '0013', 'id8460.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0013.jpg');
INSERT INTO photos VALUES ('8459', '737', '0012', 'id8459.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0012.jpg');
INSERT INTO photos VALUES ('8458', '737', '0010', 'id8458.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0010.jpg');
INSERT INTO photos VALUES ('8457', '737', '0009', 'id8457.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0009.jpg');
INSERT INTO photos VALUES ('8456', '737', '0008', 'id8456.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0008.jpg');
INSERT INTO photos VALUES ('8455', '737', '0006', 'id8455.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0006.jpg');
INSERT INTO photos VALUES ('8454', '737', '0004', 'id8454.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0004.jpg');
INSERT INTO photos VALUES ('8453', '737', '0003', 'id8453.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0003.jpg');
INSERT INTO photos VALUES ('8452', '737', '0002', 'id8452.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0002.jpg');
INSERT INTO photos VALUES ('7249', '734', '0073', 'id7249.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0073.jpg');
INSERT INTO photos VALUES ('7250', '734', '0074', 'id7250.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0074.jpg');
INSERT INTO photos VALUES ('7251', '734', '0075', 'id7251.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0075.jpg');
INSERT INTO photos VALUES ('7252', '734', '0076', 'id7252.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0076.jpg');
INSERT INTO photos VALUES ('7253', '734', '0077', 'id7253.jpg', '1', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0077.jpg');
INSERT INTO photos VALUES ('7254', '734', '0078', 'id7254.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0078.jpg');
INSERT INTO photos VALUES ('7255', '734', '0079', 'id7255.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0079.jpg');
INSERT INTO photos VALUES ('7256', '734', '0080', 'id7256.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0080.jpg');
INSERT INTO photos VALUES ('7257', '734', '0081', 'id7257.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0081.jpg');
INSERT INTO photos VALUES ('7258', '734', '0082', 'id7258.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0082.jpg');
INSERT INTO photos VALUES ('7259', '734', '0085', 'id7259.jpg', '1', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0085.jpg');
INSERT INTO photos VALUES ('7260', '734', '0086', 'id7260.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0086.jpg');
INSERT INTO photos VALUES ('7261', '734', '0087', 'id7261.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0087.jpg');
INSERT INTO photos VALUES ('7262', '734', '0088', 'id7262.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0088.jpg');
INSERT INTO photos VALUES ('7263', '734', '0089', 'id7263.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0089.jpg');
INSERT INTO photos VALUES ('7264', '734', '0090', 'id7264.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0090.jpg');
INSERT INTO photos VALUES ('7265', '734', '0092', 'id7265.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0092.jpg');
INSERT INTO photos VALUES ('7266', '734', '0095', 'id7266.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0095.jpg');
INSERT INTO photos VALUES ('7267', '734', '0097', 'id7267.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0097.jpg');
INSERT INTO photos VALUES ('7268', '734', '0099', 'id7268.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0099.jpg');
INSERT INTO photos VALUES ('7269', '734', '0101', 'id7269.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0101.jpg');
INSERT INTO photos VALUES ('7270', '734', '0178', 'id7270.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0178.jpg');
INSERT INTO photos VALUES ('7271', '734', '0179', 'id7271.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0179.jpg');
INSERT INTO photos VALUES ('7272', '734', '0180', 'id7272.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0180.jpg');
INSERT INTO photos VALUES ('7273', '734', '0181', 'id7273.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0181.jpg');
INSERT INTO photos VALUES ('7274', '734', '0183', 'id7274.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0183.jpg');
INSERT INTO photos VALUES ('7275', '734', '0184', 'id7275.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0184.jpg');
INSERT INTO photos VALUES ('7276', '734', '0185', 'id7276.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0185.jpg');
INSERT INTO photos VALUES ('7277', '734', '0189', 'id7277.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0189.jpg');
INSERT INTO photos VALUES ('7278', '734', '0190', 'id7278.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0190.jpg');
INSERT INTO photos VALUES ('7279', '734', '0311', 'id7279.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0311.jpg');
INSERT INTO photos VALUES ('7280', '734', '0312', 'id7280.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0312.jpg');
INSERT INTO photos VALUES ('7281', '734', '0313', 'id7281.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0313.jpg');
INSERT INTO photos VALUES ('7282', '734', '0314', 'id7282.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0314.jpg');
INSERT INTO photos VALUES ('7283', '734', '0315', 'id7283.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0315.jpg');
INSERT INTO photos VALUES ('7284', '734', '0317', 'id7284.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0317.jpg');
INSERT INTO photos VALUES ('7285', '734', '0318', 'id7285.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0318.jpg');
INSERT INTO photos VALUES ('7286', '734', '0320', 'id7286.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0320.jpg');
INSERT INTO photos VALUES ('7287', '734', '0321', 'id7287.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0321.jpg');
INSERT INTO photos VALUES ('7288', '734', '0322', 'id7288.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0322.jpg');
INSERT INTO photos VALUES ('7289', '734', '0323', 'id7289.jpg', '3', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0323.jpg');
INSERT INTO photos VALUES ('7290', '734', '0324', 'id7290.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0324.jpg');
INSERT INTO photos VALUES ('7291', '734', '0326', 'id7291.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0326.jpg');
INSERT INTO photos VALUES ('7292', '734', '0327', 'id7292.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0327.jpg');
INSERT INTO photos VALUES ('7293', '734', '0328', 'id7293.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0328.jpg');
INSERT INTO photos VALUES ('7294', '734', '0329', 'id7294.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0329.jpg');
INSERT INTO photos VALUES ('7295', '734', '0330', 'id7295.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0330.jpg');
INSERT INTO photos VALUES ('7296', '734', '0332', 'id7296.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0332.jpg');
INSERT INTO photos VALUES ('7297', '734', '0345', 'id7297.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0345.jpg');
INSERT INTO photos VALUES ('7298', '734', '0346', 'id7298.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0346.jpg');
INSERT INTO photos VALUES ('7299', '734', '0347', 'id7299.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0347.jpg');
INSERT INTO photos VALUES ('7300', '734', '0348', 'id7300.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0348.jpg');
INSERT INTO photos VALUES ('7301', '734', '0349', 'id7301.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0349.jpg');
INSERT INTO photos VALUES ('7302', '734', '0351', 'id7302.jpg', '1', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0351.jpg');
INSERT INTO photos VALUES ('7303', '734', '0352', 'id7303.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0352.jpg');
INSERT INTO photos VALUES ('7304', '734', '0353', 'id7304.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0353.jpg');
INSERT INTO photos VALUES ('7305', '734', '0354', 'id7305.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0354.jpg');
INSERT INTO photos VALUES ('7306', '734', '0355', 'id7306.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0355.jpg');
INSERT INTO photos VALUES ('7307', '734', '0356', 'id7307.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0356.jpg');
INSERT INTO photos VALUES ('7308', '734', '0357', 'id7308.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0357.jpg');
INSERT INTO photos VALUES ('7309', '734', '0358', 'id7309.jpg', '12', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0358.jpg');
INSERT INTO photos VALUES ('7310', '734', '0359', 'id7310.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0359.jpg');
INSERT INTO photos VALUES ('7311', '734', '0360', 'id7311.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0360.jpg');
INSERT INTO photos VALUES ('7312', '734', '0361', 'id7312.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0361.jpg');
INSERT INTO photos VALUES ('7313', '734', '0362', 'id7313.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0362.jpg');
INSERT INTO photos VALUES ('7314', '734', '0363', 'id7314.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0363.jpg');
INSERT INTO photos VALUES ('7315', '734', '0364', 'id7315.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0364.jpg');
INSERT INTO photos VALUES ('7316', '734', '0365', 'id7316.jpg', '6', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0365.jpg');
INSERT INTO photos VALUES ('7317', '734', '0366', 'id7317.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0366.jpg');
INSERT INTO photos VALUES ('7318', '734', '0367', 'id7318.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0367.jpg');
INSERT INTO photos VALUES ('7319', '734', '0370', 'id7319.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0370.jpg');
INSERT INTO photos VALUES ('7320', '734', '0374', 'id7320.jpg', '1', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0374.jpg');
INSERT INTO photos VALUES ('7321', '734', '0375', 'id7321.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0375.jpg');
INSERT INTO photos VALUES ('7322', '734', '0376', 'id7322.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0376.jpg');
INSERT INTO photos VALUES ('7323', '734', '0377', 'id7323.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0377.jpg');
INSERT INTO photos VALUES ('7324', '734', '0379', 'id7324.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0379.jpg');
INSERT INTO photos VALUES ('7325', '734', '0381', 'id7325.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0381.jpg');
INSERT INTO photos VALUES ('7326', '734', '0382', 'id7326.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0382.jpg');
INSERT INTO photos VALUES ('7327', '734', '0383', 'id7327.jpg', '11', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0383.jpg');
INSERT INTO photos VALUES ('7328', '734', '0384', 'id7328.jpg', '16', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0384.jpg');
INSERT INTO photos VALUES ('7329', '734', '0385', 'id7329.jpg', '10', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0385.jpg');
INSERT INTO photos VALUES ('7330', '734', '0387', 'id7330.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0387.jpg');
INSERT INTO photos VALUES ('7331', '734', '0389', 'id7331.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0389.jpg');
INSERT INTO photos VALUES ('7332', '734', '0391', 'id7332.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0391.jpg');
INSERT INTO photos VALUES ('7333', '734', '0392', 'id7333.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0392.jpg');
INSERT INTO photos VALUES ('7334', '734', '0393', 'id7334.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0393.jpg');
INSERT INTO photos VALUES ('7335', '734', '0394', 'id7335.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0394.jpg');
INSERT INTO photos VALUES ('7336', '734', '0397', 'id7336.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0397.jpg');
INSERT INTO photos VALUES ('7337', '734', '0399', 'id7337.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0399.jpg');
INSERT INTO photos VALUES ('7338', '734', '0401', 'id7338.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0401.jpg');
INSERT INTO photos VALUES ('7339', '734', '0504', 'id7339.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0504.jpg');
INSERT INTO photos VALUES ('7340', '734', '0505', 'id7340.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0505.jpg');
INSERT INTO photos VALUES ('7341', '734', '0506', 'id7341.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0506.jpg');
INSERT INTO photos VALUES ('7342', '734', '0507', 'id7342.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0507.jpg');
INSERT INTO photos VALUES ('7343', '734', '0508', 'id7343.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0508.jpg');
INSERT INTO photos VALUES ('7344', '734', '0509', 'id7344.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0509.jpg');
INSERT INTO photos VALUES ('7345', '734', '0510', 'id7345.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0510.jpg');
INSERT INTO photos VALUES ('7346', '734', '0511', 'id7346.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0511.jpg');
INSERT INTO photos VALUES ('7347', '734', '0512', 'id7347.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0512.jpg');
INSERT INTO photos VALUES ('7348', '734', '0513', 'id7348.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0513.jpg');
INSERT INTO photos VALUES ('7349', '734', '0514', 'id7349.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0514.jpg');
INSERT INTO photos VALUES ('7350', '734', '0515', 'id7350.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0515.jpg');
INSERT INTO photos VALUES ('7351', '734', '0516', 'id7351.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0516.jpg');
INSERT INTO photos VALUES ('7352', '734', '0517', 'id7352.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0517.jpg');
INSERT INTO photos VALUES ('7353', '734', '0519', 'id7353.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0519.jpg');
INSERT INTO photos VALUES ('7354', '734', '0520', 'id7354.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0520.jpg');
INSERT INTO photos VALUES ('7355', '734', '0521', 'id7355.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0521.jpg');
INSERT INTO photos VALUES ('7356', '734', '0522', 'id7356.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0522.jpg');
INSERT INTO photos VALUES ('7357', '734', '0523', 'id7357.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0523.jpg');
INSERT INTO photos VALUES ('7358', '734', '0524', 'id7358.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0524.jpg');
INSERT INTO photos VALUES ('7359', '734', '0579', 'id7359.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0579.jpg');
INSERT INTO photos VALUES ('7360', '734', '0580', 'id7360.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0580.jpg');
INSERT INTO photos VALUES ('7361', '734', '0581', 'id7361.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0581.jpg');
INSERT INTO photos VALUES ('7362', '734', '0582', 'id7362.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0582.jpg');
INSERT INTO photos VALUES ('7363', '734', '0584', 'id7363.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0584.jpg');
INSERT INTO photos VALUES ('7364', '734', '0585', 'id7364.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0585.jpg');
INSERT INTO photos VALUES ('7365', '734', '0586', 'id7365.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0586.jpg');
INSERT INTO photos VALUES ('7366', '734', '0589', 'id7366.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0589.jpg');
INSERT INTO photos VALUES ('7367', '734', '0591', 'id7367.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0591.jpg');
INSERT INTO photos VALUES ('7368', '734', '0592', 'id7368.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0592.jpg');
INSERT INTO photos VALUES ('7369', '734', '0593', 'id7369.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0593.jpg');
INSERT INTO photos VALUES ('7370', '734', '0594', 'id7370.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0594.jpg');
INSERT INTO photos VALUES ('7371', '734', '0595', 'id7371.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0595.jpg');
INSERT INTO photos VALUES ('7372', '734', '0596', 'id7372.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0596.jpg');
INSERT INTO photos VALUES ('7373', '734', '0598', 'id7373.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0598.jpg');
INSERT INTO photos VALUES ('7374', '734', '0599', 'id7374.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0599.jpg');
INSERT INTO photos VALUES ('7375', '734', '0601', 'id7375.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0601.jpg');
INSERT INTO photos VALUES ('7376', '734', '0602', 'id7376.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0602.jpg');
INSERT INTO photos VALUES ('7377', '734', '0603', 'id7377.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0603.jpg');
INSERT INTO photos VALUES ('7378', '734', '0643', 'id7378.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0643.jpg');
INSERT INTO photos VALUES ('7379', '734', '0644', 'id7379.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0644.jpg');
INSERT INTO photos VALUES ('7380', '734', '0646', 'id7380.jpg', '8', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0646.jpg');
INSERT INTO photos VALUES ('7381', '734', '0648', 'id7381.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0648.jpg');
INSERT INTO photos VALUES ('7382', '734', '0691', 'id7382.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0691.jpg');
INSERT INTO photos VALUES ('7383', '734', '0693', 'id7383.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0693.jpg');
INSERT INTO photos VALUES ('7384', '734', '0694', 'id7384.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0694.jpg');
INSERT INTO photos VALUES ('7385', '734', '0695', 'id7385.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0695.jpg');
INSERT INTO photos VALUES ('7386', '734', '0696', 'id7386.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0696.jpg');
INSERT INTO photos VALUES ('7387', '734', '0697', 'id7387.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0697.jpg');
INSERT INTO photos VALUES ('7388', '734', '0698', 'id7388.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0698.jpg');
INSERT INTO photos VALUES ('7389', '734', '0699', 'id7389.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0699.jpg');
INSERT INTO photos VALUES ('7390', '734', '0701', 'id7390.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0701.jpg');
INSERT INTO photos VALUES ('7391', '734', '0703', 'id7391.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0703.jpg');
INSERT INTO photos VALUES ('7392', '734', '0704', 'id7392.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0704.jpg');
INSERT INTO photos VALUES ('7393', '734', '0705', 'id7393.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0705.jpg');
INSERT INTO photos VALUES ('7394', '734', '0706', 'id7394.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0706.jpg');
INSERT INTO photos VALUES ('7395', '734', '0707', 'id7395.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0707.jpg');
INSERT INTO photos VALUES ('7396', '734', '0708', 'id7396.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0708.jpg');
INSERT INTO photos VALUES ('7397', '734', '0786', 'id7397.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0786.jpg');
INSERT INTO photos VALUES ('7398', '734', '0787', 'id7398.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0787.jpg');
INSERT INTO photos VALUES ('7399', '734', '0788', 'id7399.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0788.jpg');
INSERT INTO photos VALUES ('7400', '734', '0790', 'id7400.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0790.jpg');
INSERT INTO photos VALUES ('7401', '734', '0793', 'id7401.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0793.jpg');
INSERT INTO photos VALUES ('7402', '734', '0794', 'id7402.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0794.jpg');
INSERT INTO photos VALUES ('7403', '734', '0795', 'id7403.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0795.jpg');
INSERT INTO photos VALUES ('7404', '734', '0796', 'id7404.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0796.jpg');
INSERT INTO photos VALUES ('7405', '734', '0797', 'id7405.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0797.jpg');
INSERT INTO photos VALUES ('7406', '734', '0801', 'id7406.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0801.jpg');
INSERT INTO photos VALUES ('7407', '734', '0802', 'id7407.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0802.jpg');
INSERT INTO photos VALUES ('7408', '734', '0803', 'id7408.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0803.jpg');
INSERT INTO photos VALUES ('7409', '734', '0804', 'id7409.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0804.jpg');
INSERT INTO photos VALUES ('7410', '734', '0806', 'id7410.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0806.jpg');
INSERT INTO photos VALUES ('7411', '734', '0807', 'id7411.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0807.jpg');
INSERT INTO photos VALUES ('7412', '734', '0808', 'id7412.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0808.jpg');
INSERT INTO photos VALUES ('7413', '734', '0809', 'id7413.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0809.jpg');
INSERT INTO photos VALUES ('7414', '734', '0811', 'id7414.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0811.jpg');
INSERT INTO photos VALUES ('7415', '734', '0812', 'id7415.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0812.jpg');
INSERT INTO photos VALUES ('7416', '734', '0814', 'id7416.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0814.jpg');
INSERT INTO photos VALUES ('7417', '734', '0815', 'id7417.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0815.jpg');
INSERT INTO photos VALUES ('7418', '734', '0816', 'id7418.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0816.jpg');
INSERT INTO photos VALUES ('7419', '734', '0817', 'id7419.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0817.jpg');
INSERT INTO photos VALUES ('7420', '734', '0818', 'id7420.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0818.jpg');
INSERT INTO photos VALUES ('7421', '734', '0819', 'id7421.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0819.jpg');
INSERT INTO photos VALUES ('7422', '734', '0820', 'id7422.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0820.jpg');
INSERT INTO photos VALUES ('7423', '734', '0822', 'id7423.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0822.jpg');
INSERT INTO photos VALUES ('7424', '734', '0824', 'id7424.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0824.jpg');
INSERT INTO photos VALUES ('7425', '734', '0826', 'id7425.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0826.jpg');
INSERT INTO photos VALUES ('7426', '734', '0827', 'id7426.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0827.jpg');
INSERT INTO photos VALUES ('7427', '734', '0828', 'id7427.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0828.jpg');
INSERT INTO photos VALUES ('7428', '734', '0830', 'id7428.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0830.jpg');
INSERT INTO photos VALUES ('7429', '734', '0834', 'id7429.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0834.jpg');
INSERT INTO photos VALUES ('7430', '734', '0836', 'id7430.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0836.jpg');
INSERT INTO photos VALUES ('7431', '734', '0837', 'id7431.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0837.jpg');
INSERT INTO photos VALUES ('7432', '734', '0840', 'id7432.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0840.jpg');
INSERT INTO photos VALUES ('7433', '734', '0841', 'id7433.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0841.jpg');
INSERT INTO photos VALUES ('7434', '734', '0842', 'id7434.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0842.jpg');
INSERT INTO photos VALUES ('7435', '734', '0843', 'id7435.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0843.jpg');
INSERT INTO photos VALUES ('7436', '734', '0844', 'id7436.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0844.jpg');
INSERT INTO photos VALUES ('7437', '734', '0845', 'id7437.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0845.jpg');
INSERT INTO photos VALUES ('7438', '734', '0846', 'id7438.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0846.jpg');
INSERT INTO photos VALUES ('7439', '734', '0847', 'id7439.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0847.jpg');
INSERT INTO photos VALUES ('7440', '734', '0848', 'id7440.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0848.jpg');
INSERT INTO photos VALUES ('7441', '734', '0849', 'id7441.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0849.jpg');
INSERT INTO photos VALUES ('7442', '734', '0948', 'id7442.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0948.jpg');
INSERT INTO photos VALUES ('7443', '734', '0950', 'id7443.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0950.jpg');
INSERT INTO photos VALUES ('7444', '734', '0952', 'id7444.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0952.jpg');
INSERT INTO photos VALUES ('7445', '734', '0953', 'id7445.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0953.jpg');
INSERT INTO photos VALUES ('7446', '734', '0955', 'id7446.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0955.jpg');
INSERT INTO photos VALUES ('7447', '734', '0956', 'id7447.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0956.jpg');
INSERT INTO photos VALUES ('7448', '734', '0957', 'id7448.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0957.jpg');
INSERT INTO photos VALUES ('7449', '734', '0959', 'id7449.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0959.jpg');
INSERT INTO photos VALUES ('7450', '734', '0960', 'id7450.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0960.jpg');
INSERT INTO photos VALUES ('7451', '734', '0961', 'id7451.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0961.jpg');
INSERT INTO photos VALUES ('7452', '734', '0962', 'id7452.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0962.jpg');
INSERT INTO photos VALUES ('7453', '734', '0963', 'id7453.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0963.jpg');
INSERT INTO photos VALUES ('7454', '734', '0964', 'id7454.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0964.jpg');
INSERT INTO photos VALUES ('7455', '734', '0965', 'id7455.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0965.jpg');
INSERT INTO photos VALUES ('7456', '734', '0966', 'id7456.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0966.jpg');
INSERT INTO photos VALUES ('7457', '734', '0967', 'id7457.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0967.jpg');
INSERT INTO photos VALUES ('7458', '734', '0968', 'id7458.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0968.jpg');
INSERT INTO photos VALUES ('7459', '734', '0970', 'id7459.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0970.jpg');
INSERT INTO photos VALUES ('7460', '734', '0972', 'id7460.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0972.jpg');
INSERT INTO photos VALUES ('7461', '734', '0973', 'id7461.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0973.jpg');
INSERT INTO photos VALUES ('7462', '734', '0974', 'id7462.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0974.jpg');
INSERT INTO photos VALUES ('7463', '734', '0975', 'id7463.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0975.jpg');
INSERT INTO photos VALUES ('7464', '734', '0977', 'id7464.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0977.jpg');
INSERT INTO photos VALUES ('7465', '734', '0978', 'id7465.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0978.jpg');
INSERT INTO photos VALUES ('7466', '734', '0979', 'id7466.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/0979.jpg');
INSERT INTO photos VALUES ('7467', '734', '1271', 'id7467.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1271.jpg');
INSERT INTO photos VALUES ('7468', '734', '1272', 'id7468.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1272.jpg');
INSERT INTO photos VALUES ('7469', '734', '1273', 'id7469.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1273.jpg');
INSERT INTO photos VALUES ('7470', '734', '1274', 'id7470.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1274.jpg');
INSERT INTO photos VALUES ('7471', '734', '1275', 'id7471.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1275.jpg');
INSERT INTO photos VALUES ('7472', '734', '1276', 'id7472.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1276.jpg');
INSERT INTO photos VALUES ('7473', '734', '1277', 'id7473.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1277.jpg');
INSERT INTO photos VALUES ('7474', '734', '1278', 'id7474.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1278.jpg');
INSERT INTO photos VALUES ('7475', '734', '1279', 'id7475.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1279.jpg');
INSERT INTO photos VALUES ('7476', '734', '1280', 'id7476.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1280.jpg');
INSERT INTO photos VALUES ('7477', '734', '1281', 'id7477.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1281.jpg');
INSERT INTO photos VALUES ('7478', '734', '1283', 'id7478.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1283.jpg');
INSERT INTO photos VALUES ('7479', '734', '1284', 'id7479.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1284.jpg');
INSERT INTO photos VALUES ('7480', '734', '1285', 'id7480.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1285.jpg');
INSERT INTO photos VALUES ('7481', '734', '1286', 'id7481.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1286.jpg');
INSERT INTO photos VALUES ('7482', '734', '1287', 'id7482.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1287.jpg');
INSERT INTO photos VALUES ('7483', '734', '1289', 'id7483.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1289.jpg');
INSERT INTO photos VALUES ('7484', '734', '1292', 'id7484.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1292.jpg');
INSERT INTO photos VALUES ('7485', '734', '1293', 'id7485.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1293.jpg');
INSERT INTO photos VALUES ('7486', '734', '1294', 'id7486.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1294.jpg');
INSERT INTO photos VALUES ('7487', '734', '1297', 'id7487.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1297.jpg');
INSERT INTO photos VALUES ('7488', '734', '1298', 'id7488.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1298.jpg');
INSERT INTO photos VALUES ('7489', '734', '1299', 'id7489.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1299.jpg');
INSERT INTO photos VALUES ('7490', '734', '1300', 'id7490.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1300.jpg');
INSERT INTO photos VALUES ('7491', '734', '1301', 'id7491.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1301.jpg');
INSERT INTO photos VALUES ('7492', '734', '1303', 'id7492.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1303.jpg');
INSERT INTO photos VALUES ('7493', '734', '1304', 'id7493.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1304.jpg');
INSERT INTO photos VALUES ('7494', '734', '1306', 'id7494.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1306.jpg');
INSERT INTO photos VALUES ('7495', '734', '1307', 'id7495.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1307.jpg');
INSERT INTO photos VALUES ('7496', '734', '1309', 'id7496.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1309.jpg');
INSERT INTO photos VALUES ('7497', '734', '1310', 'id7497.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1310.jpg');
INSERT INTO photos VALUES ('7498', '734', '1311', 'id7498.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1311.jpg');
INSERT INTO photos VALUES ('7499', '734', '1312', 'id7499.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1312.jpg');
INSERT INTO photos VALUES ('7500', '734', '1313', 'id7500.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1313.jpg');
INSERT INTO photos VALUES ('7501', '734', '1314', 'id7501.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1314.jpg');
INSERT INTO photos VALUES ('7502', '734', '1315', 'id7502.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1315.jpg');
INSERT INTO photos VALUES ('7503', '734', '1316', 'id7503.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1316.jpg');
INSERT INTO photos VALUES ('7504', '734', '1318', 'id7504.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1318.jpg');
INSERT INTO photos VALUES ('7505', '734', '1319', 'id7505.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1319.jpg');
INSERT INTO photos VALUES ('7506', '734', '1321', 'id7506.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1321.jpg');
INSERT INTO photos VALUES ('7507', '734', '1322', 'id7507.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1322.jpg');
INSERT INTO photos VALUES ('7508', '734', '1323', 'id7508.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1323.jpg');
INSERT INTO photos VALUES ('7509', '734', '1324', 'id7509.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1324.jpg');
INSERT INTO photos VALUES ('7510', '734', '1325', 'id7510.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1325.jpg');
INSERT INTO photos VALUES ('7511', '734', '1326', 'id7511.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1326.jpg');
INSERT INTO photos VALUES ('7512', '734', '1327', 'id7512.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1327.jpg');
INSERT INTO photos VALUES ('7513', '734', '1328', 'id7513.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1328.jpg');
INSERT INTO photos VALUES ('7514', '734', '1329', 'id7514.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1329.jpg');
INSERT INTO photos VALUES ('7515', '734', '1330', 'id7515.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1330.jpg');
INSERT INTO photos VALUES ('7516', '734', '1331', 'id7516.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1331.jpg');
INSERT INTO photos VALUES ('7517', '734', '1332', 'id7517.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1332.jpg');
INSERT INTO photos VALUES ('7518', '734', '1336', 'id7518.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1336.jpg');
INSERT INTO photos VALUES ('7519', '734', '1337', 'id7519.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1337.jpg');
INSERT INTO photos VALUES ('7520', '734', '1340', 'id7520.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1340.jpg');
INSERT INTO photos VALUES ('7521', '734', '1341', 'id7521.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1341.jpg');
INSERT INTO photos VALUES ('7522', '734', '1374', 'id7522.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1374.jpg');
INSERT INTO photos VALUES ('7523', '734', '1377', 'id7523.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1377.jpg');
INSERT INTO photos VALUES ('7524', '734', '1378', 'id7524.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1378.jpg');
INSERT INTO photos VALUES ('7525', '734', '1379', 'id7525.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1379.jpg');
INSERT INTO photos VALUES ('7526', '734', '1381', 'id7526.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1381.jpg');
INSERT INTO photos VALUES ('7527', '734', '1382', 'id7527.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1382.jpg');
INSERT INTO photos VALUES ('7528', '734', '1383', 'id7528.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1383.jpg');
INSERT INTO photos VALUES ('7529', '734', '1388', 'id7529.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1388.jpg');
INSERT INTO photos VALUES ('7530', '734', '1389', 'id7530.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1389.jpg');
INSERT INTO photos VALUES ('7531', '734', '1390', 'id7531.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1390.jpg');
INSERT INTO photos VALUES ('7532', '734', '1391', 'id7532.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1391.jpg');
INSERT INTO photos VALUES ('7533', '734', '1392', 'id7533.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1392.jpg');
INSERT INTO photos VALUES ('7534', '734', '1395', 'id7534.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1395.jpg');
INSERT INTO photos VALUES ('7535', '734', '1396', 'id7535.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1396.jpg');
INSERT INTO photos VALUES ('7536', '734', '1398', 'id7536.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1398.jpg');
INSERT INTO photos VALUES ('7537', '734', '1404', 'id7537.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1404.jpg');
INSERT INTO photos VALUES ('7538', '734', '1405', 'id7538.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1405.jpg');
INSERT INTO photos VALUES ('7539', '734', '1406', 'id7539.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1406.jpg');
INSERT INTO photos VALUES ('7540', '734', '1407', 'id7540.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1407.jpg');
INSERT INTO photos VALUES ('7541', '734', '1408', 'id7541.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1408.jpg');
INSERT INTO photos VALUES ('7542', '734', '1409', 'id7542.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1409.jpg');
INSERT INTO photos VALUES ('7543', '734', '1410', 'id7543.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1410.jpg');
INSERT INTO photos VALUES ('7544', '734', '1411', 'id7544.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1411.jpg');
INSERT INTO photos VALUES ('7545', '734', '1413', 'id7545.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1413.jpg');
INSERT INTO photos VALUES ('7546', '734', '1415', 'id7546.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1415.jpg');
INSERT INTO photos VALUES ('7547', '734', '1416', 'id7547.jpg', '6', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1416.jpg');
INSERT INTO photos VALUES ('7548', '734', '1419', 'id7548.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1419.jpg');
INSERT INTO photos VALUES ('7549', '734', '1420', 'id7549.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1420.jpg');
INSERT INTO photos VALUES ('7550', '734', '1422', 'id7550.jpg', '7', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1422.jpg');
INSERT INTO photos VALUES ('7551', '734', '1423', 'id7551.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1423.jpg');
INSERT INTO photos VALUES ('7552', '734', '1424', 'id7552.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1424.jpg');
INSERT INTO photos VALUES ('7553', '734', '1425', 'id7553.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1425.jpg');
INSERT INTO photos VALUES ('7554', '734', '1426', 'id7554.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1426.jpg');
INSERT INTO photos VALUES ('7555', '734', '1427', 'id7555.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1427.jpg');
INSERT INTO photos VALUES ('7556', '734', '1428', 'id7556.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1428.jpg');
INSERT INTO photos VALUES ('7557', '734', '1429', 'id7557.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1429.jpg');
INSERT INTO photos VALUES ('7558', '734', '1431', 'id7558.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1431.jpg');
INSERT INTO photos VALUES ('7559', '734', '1433', 'id7559.jpg', '6', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1433.jpg');
INSERT INTO photos VALUES ('7560', '734', '1434', 'id7560.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1434.jpg');
INSERT INTO photos VALUES ('7561', '734', '1435', 'id7561.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1435.jpg');
INSERT INTO photos VALUES ('7562', '734', '1437', 'id7562.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1437.jpg');
INSERT INTO photos VALUES ('7563', '734', '1438', 'id7563.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1438.jpg');
INSERT INTO photos VALUES ('7564', '734', '1439', 'id7564.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1439.jpg');
INSERT INTO photos VALUES ('7565', '734', '1440', 'id7565.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1440.jpg');
INSERT INTO photos VALUES ('7566', '734', '1441', 'id7566.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1441.jpg');
INSERT INTO photos VALUES ('7567', '734', '1442', 'id7567.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1442.jpg');
INSERT INTO photos VALUES ('7568', '734', '1443', 'id7568.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1443.jpg');
INSERT INTO photos VALUES ('7569', '734', '1444', 'id7569.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1444.jpg');
INSERT INTO photos VALUES ('7570', '734', '1445', 'id7570.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1445.jpg');
INSERT INTO photos VALUES ('7571', '734', '1446', 'id7571.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1446.jpg');
INSERT INTO photos VALUES ('7572', '734', '1447', 'id7572.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1447.jpg');
INSERT INTO photos VALUES ('7573', '734', '1448', 'id7573.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1448.jpg');
INSERT INTO photos VALUES ('7574', '734', '1482', 'id7574.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1482.jpg');
INSERT INTO photos VALUES ('7575', '734', '1483', 'id7575.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1483.jpg');
INSERT INTO photos VALUES ('7576', '734', '1486', 'id7576.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1486.jpg');
INSERT INTO photos VALUES ('7577', '734', '1487', 'id7577.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1487.jpg');
INSERT INTO photos VALUES ('7578', '734', '1607', 'id7578.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1607.jpg');
INSERT INTO photos VALUES ('7579', '734', '1608', 'id7579.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1608.jpg');
INSERT INTO photos VALUES ('7580', '734', '1609', 'id7580.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1609.jpg');
INSERT INTO photos VALUES ('7581', '734', '1625', 'id7581.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1625.jpg');
INSERT INTO photos VALUES ('7582', '734', '1626', 'id7582.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1626.jpg');
INSERT INTO photos VALUES ('7583', '734', '1627', 'id7583.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1627.jpg');
INSERT INTO photos VALUES ('7584', '734', '1629', 'id7584.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1629.jpg');
INSERT INTO photos VALUES ('7585', '734', '1648', 'id7585.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1648.jpg');
INSERT INTO photos VALUES ('7586', '734', '1662', 'id7586.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1662.jpg');
INSERT INTO photos VALUES ('7587', '734', '1688', 'id7587.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1688.jpg');
INSERT INTO photos VALUES ('7588', '734', '1703', 'id7588.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1703.jpg');
INSERT INTO photos VALUES ('7589', '734', '1704', 'id7589.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1704.jpg');
INSERT INTO photos VALUES ('7590', '734', '1705', 'id7590.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1705.jpg');
INSERT INTO photos VALUES ('7591', '734', '1706', 'id7591.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1706.jpg');
INSERT INTO photos VALUES ('7592', '734', '1707', 'id7592.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1707.jpg');
INSERT INTO photos VALUES ('7593', '734', '1708', 'id7593.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1708.jpg');
INSERT INTO photos VALUES ('7594', '734', '1709', 'id7594.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1709.jpg');
INSERT INTO photos VALUES ('7595', '734', '1710', 'id7595.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1710.jpg');
INSERT INTO photos VALUES ('7596', '734', '1711', 'id7596.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1711.jpg');
INSERT INTO photos VALUES ('7597', '734', '1713', 'id7597.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1713.jpg');
INSERT INTO photos VALUES ('7598', '734', '1714', 'id7598.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1714.jpg');
INSERT INTO photos VALUES ('7599', '734', '1715', 'id7599.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1715.jpg');
INSERT INTO photos VALUES ('7600', '734', '1716', 'id7600.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1716.jpg');
INSERT INTO photos VALUES ('7601', '734', '1717', 'id7601.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1717.jpg');
INSERT INTO photos VALUES ('7602', '734', '1718', 'id7602.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1718.jpg');
INSERT INTO photos VALUES ('7603', '734', '1719', 'id7603.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1719.jpg');
INSERT INTO photos VALUES ('7604', '734', '1722', 'id7604.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1722.jpg');
INSERT INTO photos VALUES ('7605', '734', '1723', 'id7605.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1723.jpg');
INSERT INTO photos VALUES ('7606', '734', '1725', 'id7606.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1725.jpg');
INSERT INTO photos VALUES ('7607', '734', '1726', 'id7607.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1726.jpg');
INSERT INTO photos VALUES ('7608', '734', '1728', 'id7608.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1728.jpg');
INSERT INTO photos VALUES ('7609', '734', '1731', 'id7609.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1731.jpg');
INSERT INTO photos VALUES ('7610', '734', '1732', 'id7610.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1732.jpg');
INSERT INTO photos VALUES ('7611', '734', '1736', 'id7611.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1736.jpg');
INSERT INTO photos VALUES ('7612', '734', '1737', 'id7612.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1737.jpg');
INSERT INTO photos VALUES ('7613', '734', '1738', 'id7613.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1738.jpg');
INSERT INTO photos VALUES ('7614', '734', '1739', 'id7614.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1739.jpg');
INSERT INTO photos VALUES ('7615', '734', '1741', 'id7615.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1741.jpg');
INSERT INTO photos VALUES ('7616', '734', '1742', 'id7616.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1742.jpg');
INSERT INTO photos VALUES ('7617', '734', '1744', 'id7617.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1744.jpg');
INSERT INTO photos VALUES ('7618', '734', '1745', 'id7618.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1745.jpg');
INSERT INTO photos VALUES ('7619', '734', '1747', 'id7619.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1747.jpg');
INSERT INTO photos VALUES ('7620', '734', '1748', 'id7620.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1748.jpg');
INSERT INTO photos VALUES ('7621', '734', '1749', 'id7621.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1749.jpg');
INSERT INTO photos VALUES ('7622', '734', '1750', 'id7622.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1750.jpg');
INSERT INTO photos VALUES ('7623', '734', '1751', 'id7623.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1751.jpg');
INSERT INTO photos VALUES ('7624', '734', '1752', 'id7624.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1752.jpg');
INSERT INTO photos VALUES ('7625', '734', '1753', 'id7625.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1753.jpg');
INSERT INTO photos VALUES ('7626', '734', '1754', 'id7626.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1754.jpg');
INSERT INTO photos VALUES ('7627', '734', '1755', 'id7627.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1755.jpg');
INSERT INTO photos VALUES ('7628', '734', '1758', 'id7628.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1758.jpg');
INSERT INTO photos VALUES ('7629', '734', '1760', 'id7629.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1760.jpg');
INSERT INTO photos VALUES ('7630', '734', '1762', 'id7630.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1762.jpg');
INSERT INTO photos VALUES ('7631', '734', '1763', 'id7631.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1763.jpg');
INSERT INTO photos VALUES ('7632', '734', '1764', 'id7632.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1764.jpg');
INSERT INTO photos VALUES ('7633', '734', '1765', 'id7633.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1765.jpg');
INSERT INTO photos VALUES ('7634', '734', '1768', 'id7634.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1768.jpg');
INSERT INTO photos VALUES ('7635', '734', '1769', 'id7635.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1769.jpg');
INSERT INTO photos VALUES ('7636', '734', '1770', 'id7636.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1770.jpg');
INSERT INTO photos VALUES ('7637', '734', '1772', 'id7637.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1772.jpg');
INSERT INTO photos VALUES ('7638', '734', '1773', 'id7638.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1773.jpg');
INSERT INTO photos VALUES ('7639', '734', '1774', 'id7639.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1774.jpg');
INSERT INTO photos VALUES ('7640', '734', '1775', 'id7640.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1775.jpg');
INSERT INTO photos VALUES ('7641', '734', '1776', 'id7641.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1776.jpg');
INSERT INTO photos VALUES ('7642', '734', '1777', 'id7642.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1777.jpg');
INSERT INTO photos VALUES ('7643', '734', '1778', 'id7643.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1778.jpg');
INSERT INTO photos VALUES ('7644', '734', '1780', 'id7644.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1780.jpg');
INSERT INTO photos VALUES ('7645', '734', '1781', 'id7645.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1781.jpg');
INSERT INTO photos VALUES ('7646', '734', '1783', 'id7646.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1783.jpg');
INSERT INTO photos VALUES ('7647', '734', '1851', 'id7647.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1851.jpg');
INSERT INTO photos VALUES ('7648', '734', '1852', 'id7648.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1852.jpg');
INSERT INTO photos VALUES ('7649', '734', '1853', 'id7649.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1853.jpg');
INSERT INTO photos VALUES ('7650', '734', '1854', 'id7650.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1854.jpg');
INSERT INTO photos VALUES ('7651', '734', '1855', 'id7651.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1855.jpg');
INSERT INTO photos VALUES ('7652', '734', '1856', 'id7652.jpg', '6', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1856.jpg');
INSERT INTO photos VALUES ('7653', '734', '1857', 'id7653.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1857.jpg');
INSERT INTO photos VALUES ('7654', '734', '1858', 'id7654.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1858.jpg');
INSERT INTO photos VALUES ('7655', '734', '1860', 'id7655.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1860.jpg');
INSERT INTO photos VALUES ('7656', '734', '1861', 'id7656.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1861.jpg');
INSERT INTO photos VALUES ('7657', '734', '1862', 'id7657.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1862.jpg');
INSERT INTO photos VALUES ('7658', '734', '1863', 'id7658.jpg', '4', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1863.jpg');
INSERT INTO photos VALUES ('7659', '734', '1864', 'id7659.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1864.jpg');
INSERT INTO photos VALUES ('7660', '734', '1865', 'id7660.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1865.jpg');
INSERT INTO photos VALUES ('7661', '734', '1867', 'id7661.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1867.jpg');
INSERT INTO photos VALUES ('7662', '734', '1871', 'id7662.jpg', '9', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1871.jpg');
INSERT INTO photos VALUES ('7663', '734', '1906', 'id7663.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1906.jpg');
INSERT INTO photos VALUES ('7664', '734', '1907', 'id7664.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1907.jpg');
INSERT INTO photos VALUES ('7665', '734', '1908', 'id7665.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1908.jpg');
INSERT INTO photos VALUES ('7666', '734', '1911', 'id7666.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1911.jpg');
INSERT INTO photos VALUES ('7667', '734', '1912', 'id7667.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1912.jpg');
INSERT INTO photos VALUES ('7668', '734', '1917', 'id7668.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1917.jpg');
INSERT INTO photos VALUES ('7669', '734', '1918', 'id7669.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1918.jpg');
INSERT INTO photos VALUES ('7670', '734', '1919', 'id7670.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1919.jpg');
INSERT INTO photos VALUES ('7671', '734', '1920', 'id7671.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1920.jpg');
INSERT INTO photos VALUES ('7672', '734', '1921', 'id7672.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1921.jpg');
INSERT INTO photos VALUES ('7673', '734', '1922', 'id7673.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1922.jpg');
INSERT INTO photos VALUES ('7674', '734', '1923', 'id7674.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1923.jpg');
INSERT INTO photos VALUES ('7675', '734', '1924', 'id7675.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1924.jpg');
INSERT INTO photos VALUES ('7676', '734', '1925', 'id7676.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1925.jpg');
INSERT INTO photos VALUES ('7677', '734', '1926', 'id7677.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1926.jpg');
INSERT INTO photos VALUES ('7678', '734', '1927', 'id7678.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1927.jpg');
INSERT INTO photos VALUES ('7679', '734', '1929', 'id7679.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1929.jpg');
INSERT INTO photos VALUES ('7680', '734', '1930', 'id7680.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1930.jpg');
INSERT INTO photos VALUES ('7681', '734', '1931', 'id7681.jpg', '6', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1931.jpg');
INSERT INTO photos VALUES ('7682', '734', '1932', 'id7682.jpg', '6', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1932.jpg');
INSERT INTO photos VALUES ('7683', '734', '1933', 'id7683.jpg', '8', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1933.jpg');
INSERT INTO photos VALUES ('7684', '734', '1934', 'id7684.jpg', '12', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1934.jpg');
INSERT INTO photos VALUES ('7685', '734', '1935', 'id7685.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1935.jpg');
INSERT INTO photos VALUES ('7686', '734', '1936', 'id7686.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1936.jpg');
INSERT INTO photos VALUES ('7687', '734', '1937', 'id7687.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1937.jpg');
INSERT INTO photos VALUES ('7688', '734', '1938', 'id7688.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1938.jpg');
INSERT INTO photos VALUES ('7689', '734', '1940', 'id7689.jpg', '10', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1940.jpg');
INSERT INTO photos VALUES ('7690', '734', '1941', 'id7690.jpg', '9', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1941.jpg');
INSERT INTO photos VALUES ('7691', '734', '1942', 'id7691.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1942.jpg');
INSERT INTO photos VALUES ('7692', '734', '1943', 'id7692.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1943.jpg');
INSERT INTO photos VALUES ('7693', '734', '1946', 'id7693.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1946.jpg');
INSERT INTO photos VALUES ('7694', '734', '1949', 'id7694.jpg', '7', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1949.jpg');
INSERT INTO photos VALUES ('7695', '734', '1950', 'id7695.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1950.jpg');
INSERT INTO photos VALUES ('7696', '734', '1951', 'id7696.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/1951.jpg');
INSERT INTO photos VALUES ('7697', '734', '2022', 'id7697.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2022.jpg');
INSERT INTO photos VALUES ('7698', '734', '2023', 'id7698.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2023.jpg');
INSERT INTO photos VALUES ('7699', '734', '2024', 'id7699.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2024.jpg');
INSERT INTO photos VALUES ('7700', '734', '2025', 'id7700.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2025.jpg');
INSERT INTO photos VALUES ('7701', '734', '2027', 'id7701.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2027.jpg');
INSERT INTO photos VALUES ('7702', '734', '2028', 'id7702.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2028.jpg');
INSERT INTO photos VALUES ('7703', '734', '2029', 'id7703.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2029.jpg');
INSERT INTO photos VALUES ('7704', '734', '2030', 'id7704.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2030.jpg');
INSERT INTO photos VALUES ('7705', '734', '2033', 'id7705.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2033.jpg');
INSERT INTO photos VALUES ('7706', '734', '2034', 'id7706.jpg', '7', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2034.jpg');
INSERT INTO photos VALUES ('7707', '734', '2036', 'id7707.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2036.jpg');
INSERT INTO photos VALUES ('7708', '734', '2037', 'id7708.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2037.jpg');
INSERT INTO photos VALUES ('7709', '734', '2105', 'id7709.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2105.jpg');
INSERT INTO photos VALUES ('7710', '734', '2137', 'id7710.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2137.jpg');
INSERT INTO photos VALUES ('7711', '734', '2138', 'id7711.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2138.jpg');
INSERT INTO photos VALUES ('7712', '734', '2139', 'id7712.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2139.jpg');
INSERT INTO photos VALUES ('7713', '734', '2140', 'id7713.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2140.jpg');
INSERT INTO photos VALUES ('7714', '734', '2141', 'id7714.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2141.jpg');
INSERT INTO photos VALUES ('7715', '734', '2144', 'id7715.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2144.jpg');
INSERT INTO photos VALUES ('7716', '734', '2145', 'id7716.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2145.jpg');
INSERT INTO photos VALUES ('7717', '734', '2147', 'id7717.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2147.jpg');
INSERT INTO photos VALUES ('7718', '734', '2149', 'id7718.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2149.jpg');
INSERT INTO photos VALUES ('7719', '734', '2152', 'id7719.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2152.jpg');
INSERT INTO photos VALUES ('7720', '734', '2153', 'id7720.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2153.jpg');
INSERT INTO photos VALUES ('7721', '734', '2154', 'id7721.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2154.jpg');
INSERT INTO photos VALUES ('7722', '734', '2155', 'id7722.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2155.jpg');
INSERT INTO photos VALUES ('7723', '734', '2177', 'id7723.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2177.jpg');
INSERT INTO photos VALUES ('7724', '734', '2179', 'id7724.jpg', '3', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2179.jpg');
INSERT INTO photos VALUES ('7725', '734', '2180', 'id7725.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2180.jpg');
INSERT INTO photos VALUES ('7726', '734', '2181', 'id7726.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2181.jpg');
INSERT INTO photos VALUES ('7727', '734', '2182', 'id7727.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2182.jpg');
INSERT INTO photos VALUES ('7728', '734', '2183', 'id7728.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2183.jpg');
INSERT INTO photos VALUES ('7729', '734', '2185', 'id7729.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2185.jpg');
INSERT INTO photos VALUES ('7730', '734', '2186', 'id7730.jpg', '7', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2186.jpg');
INSERT INTO photos VALUES ('7731', '734', '2187', 'id7731.jpg', '5', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2187.jpg');
INSERT INTO photos VALUES ('7732', '734', '2188', 'id7732.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2188.jpg');
INSERT INTO photos VALUES ('7733', '734', '2189', 'id7733.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2189.jpg');
INSERT INTO photos VALUES ('7734', '734', '2190', 'id7734.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2190.jpg');
INSERT INTO photos VALUES ('7735', '734', '2191', 'id7735.jpg', '2', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2191.jpg');
INSERT INTO photos VALUES ('7736', '734', '2192', 'id7736.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2192.jpg');
INSERT INTO photos VALUES ('7737', '734', '2230', 'id7737.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2230.jpg');
INSERT INTO photos VALUES ('7738', '734', '2231', 'id7738.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2231.jpg');
INSERT INTO photos VALUES ('7739', '734', '2232', 'id7739.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2232.jpg');
INSERT INTO photos VALUES ('7740', '734', '2234', 'id7740.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2234.jpg');
INSERT INTO photos VALUES ('7741', '734', '2235', 'id7741.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2235.jpg');
INSERT INTO photos VALUES ('7742', '734', '2237', 'id7742.jpg', '1', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2237.jpg');
INSERT INTO photos VALUES ('7743', '734', '2307', 'id7743.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2307.jpg');
INSERT INTO photos VALUES ('7744', '734', '2308', 'id7744.jpg', '1', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2308.jpg');
INSERT INTO photos VALUES ('7745', '734', '2334', 'id7745.jpg', '1', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2334.jpg');
INSERT INTO photos VALUES ('7746', '734', '2336', 'id7746.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2336.jpg');
INSERT INTO photos VALUES ('7747', '734', '2337', 'id7747.jpg', '3', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2337.jpg');
INSERT INTO photos VALUES ('7748', '734', '2338', 'id7748.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2338.jpg');
INSERT INTO photos VALUES ('7749', '734', '2339', 'id7749.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2339.jpg');
INSERT INTO photos VALUES ('7750', '734', '2340', 'id7750.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2340.jpg');
INSERT INTO photos VALUES ('7751', '734', '2341', 'id7751.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2341.jpg');
INSERT INTO photos VALUES ('7752', '734', '2365', 'id7752.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2365.jpg');
INSERT INTO photos VALUES ('7753', '734', '2370', 'id7753.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2370.jpg');
INSERT INTO photos VALUES ('7754', '734', '2372', 'id7754.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2372.jpg');
INSERT INTO photos VALUES ('7755', '734', '2374', 'id7755.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2374.jpg');
INSERT INTO photos VALUES ('7756', '734', '2375', 'id7756.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2375.jpg');
INSERT INTO photos VALUES ('7757', '734', '2376', 'id7757.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2376.jpg');
INSERT INTO photos VALUES ('7758', '734', '2377', 'id7758.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2377.jpg');
INSERT INTO photos VALUES ('7759', '734', '2378', 'id7759.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2378.jpg');
INSERT INTO photos VALUES ('7760', '734', '2383', 'id7760.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2383.jpg');
INSERT INTO photos VALUES ('7761', '734', '2384', 'id7761.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2384.jpg');
INSERT INTO photos VALUES ('7762', '734', '2385', 'id7762.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2385.jpg');
INSERT INTO photos VALUES ('7763', '734', '2386', 'id7763.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2386.jpg');
INSERT INTO photos VALUES ('7764', '734', '2388', 'id7764.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2388.jpg');
INSERT INTO photos VALUES ('7765', '734', '2389', 'id7765.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2389.jpg');
INSERT INTO photos VALUES ('7766', '734', '2390', 'id7766.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2390.jpg');
INSERT INTO photos VALUES ('7767', '734', '2392', 'id7767.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2392.jpg');
INSERT INTO photos VALUES ('7768', '734', '2393', 'id7768.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2393.jpg');
INSERT INTO photos VALUES ('7769', '734', '2394', 'id7769.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2394.jpg');
INSERT INTO photos VALUES ('7770', '734', '2395', 'id7770.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2395.jpg');
INSERT INTO photos VALUES ('7771', '734', '2396', 'id7771.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2396.jpg');
INSERT INTO photos VALUES ('7772', '734', '2397', 'id7772.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2397.jpg');
INSERT INTO photos VALUES ('7773', '734', '2398', 'id7773.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2398.jpg');
INSERT INTO photos VALUES ('7774', '734', '2399', 'id7774.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2399.jpg');
INSERT INTO photos VALUES ('7775', '734', '2400', 'id7775.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2400.jpg');
INSERT INTO photos VALUES ('7776', '734', '2401', 'id7776.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2401.jpg');
INSERT INTO photos VALUES ('7777', '734', '2403', 'id7777.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2403.jpg');
INSERT INTO photos VALUES ('7778', '734', '2404', 'id7778.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2404.jpg');
INSERT INTO photos VALUES ('7779', '734', '2405', 'id7779.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2405.jpg');
INSERT INTO photos VALUES ('7780', '734', '2406', 'id7780.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2406.jpg');
INSERT INTO photos VALUES ('7781', '734', '2407', 'id7781.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2407.jpg');
INSERT INTO photos VALUES ('7782', '734', '2408', 'id7782.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2408.jpg');
INSERT INTO photos VALUES ('7783', '734', '2411', 'id7783.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2411.jpg');
INSERT INTO photos VALUES ('7784', '734', '2412', 'id7784.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2412.jpg');
INSERT INTO photos VALUES ('7785', '734', '2413', 'id7785.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2413.jpg');
INSERT INTO photos VALUES ('7786', '734', '2415', 'id7786.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2415.jpg');
INSERT INTO photos VALUES ('7787', '734', '2416', 'id7787.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2416.jpg');
INSERT INTO photos VALUES ('7788', '734', '2418', 'id7788.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2418.jpg');
INSERT INTO photos VALUES ('7789', '734', '2420', 'id7789.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2420.jpg');
INSERT INTO photos VALUES ('7790', '734', '2421', 'id7790.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2421.jpg');
INSERT INTO photos VALUES ('7791', '734', '2422', 'id7791.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2422.jpg');
INSERT INTO photos VALUES ('7792', '734', '2423', 'id7792.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2423.jpg');
INSERT INTO photos VALUES ('7793', '734', '2424', 'id7793.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2424.jpg');
INSERT INTO photos VALUES ('7794', '734', '2425', 'id7794.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2425.jpg');
INSERT INTO photos VALUES ('7795', '734', '2426', 'id7795.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2426.jpg');
INSERT INTO photos VALUES ('7796', '734', '2427', 'id7796.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2427.jpg');
INSERT INTO photos VALUES ('7797', '734', '2428', 'id7797.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2428.jpg');
INSERT INTO photos VALUES ('7798', '734', '2429', 'id7798.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2429.jpg');
INSERT INTO photos VALUES ('7799', '734', '2430', 'id7799.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2430.jpg');
INSERT INTO photos VALUES ('7800', '734', '2432', 'id7800.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2432.jpg');
INSERT INTO photos VALUES ('7801', '734', '2433', 'id7801.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2433.jpg');
INSERT INTO photos VALUES ('7802', '734', '2434', 'id7802.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2434.jpg');
INSERT INTO photos VALUES ('7803', '734', '2435', 'id7803.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2435.jpg');
INSERT INTO photos VALUES ('7804', '734', '2437', 'id7804.jpg', '8', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2437.jpg');
INSERT INTO photos VALUES ('7805', '734', '2438', 'id7805.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2438.jpg');
INSERT INTO photos VALUES ('7806', '734', '2439', 'id7806.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2439.jpg');
INSERT INTO photos VALUES ('7807', '734', '2440', 'id7807.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2440.jpg');
INSERT INTO photos VALUES ('7808', '734', '2441', 'id7808.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2441.jpg');
INSERT INTO photos VALUES ('7809', '734', '2442', 'id7809.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2442.jpg');
INSERT INTO photos VALUES ('7810', '734', '2444', 'id7810.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2444.jpg');
INSERT INTO photos VALUES ('7811', '734', '2445', 'id7811.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2445.jpg');
INSERT INTO photos VALUES ('7812', '734', '2446', 'id7812.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2446.jpg');
INSERT INTO photos VALUES ('7813', '734', '2447', 'id7813.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2447.jpg');
INSERT INTO photos VALUES ('7814', '734', '2448', 'id7814.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2448.jpg');
INSERT INTO photos VALUES ('7815', '734', '2449', 'id7815.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2449.jpg');
INSERT INTO photos VALUES ('7816', '734', '2450', 'id7816.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2450.jpg');
INSERT INTO photos VALUES ('7817', '734', '2453', 'id7817.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2453.jpg');
INSERT INTO photos VALUES ('7818', '734', '2455', 'id7818.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2455.jpg');
INSERT INTO photos VALUES ('7819', '734', '2457', 'id7819.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2457.jpg');
INSERT INTO photos VALUES ('7820', '734', '2458', 'id7820.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2458.jpg');
INSERT INTO photos VALUES ('7821', '734', '2459', 'id7821.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2459.jpg');
INSERT INTO photos VALUES ('7822', '734', '2462', 'id7822.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2462.jpg');
INSERT INTO photos VALUES ('7823', '734', '2463', 'id7823.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2463.jpg');
INSERT INTO photos VALUES ('7824', '734', '2464', 'id7824.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2464.jpg');
INSERT INTO photos VALUES ('7825', '734', '2466', 'id7825.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2466.jpg');
INSERT INTO photos VALUES ('7826', '734', '2470', 'id7826.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2470.jpg');
INSERT INTO photos VALUES ('7827', '734', '2471', 'id7827.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2471.jpg');
INSERT INTO photos VALUES ('7828', '734', '2472', 'id7828.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2472.jpg');
INSERT INTO photos VALUES ('7829', '734', '2474', 'id7829.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2474.jpg');
INSERT INTO photos VALUES ('7830', '734', '2475', 'id7830.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2475.jpg');
INSERT INTO photos VALUES ('7831', '734', '2476', 'id7831.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2476.jpg');
INSERT INTO photos VALUES ('7832', '734', '2477', 'id7832.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2477.jpg');
INSERT INTO photos VALUES ('7833', '734', '2516', 'id7833.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2516.jpg');
INSERT INTO photos VALUES ('7834', '734', '2517', 'id7834.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2517.jpg');
INSERT INTO photos VALUES ('7835', '734', '2520', 'id7835.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2520.jpg');
INSERT INTO photos VALUES ('7836', '734', '2521', 'id7836.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2521.jpg');
INSERT INTO photos VALUES ('7837', '734', '2522', 'id7837.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2522.jpg');
INSERT INTO photos VALUES ('7838', '734', '2523', 'id7838.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2523.jpg');
INSERT INTO photos VALUES ('7839', '734', '2524', 'id7839.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2524.jpg');
INSERT INTO photos VALUES ('7840', '734', '2527', 'id7840.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2527.jpg');
INSERT INTO photos VALUES ('7841', '734', '2528', 'id7841.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2528.jpg');
INSERT INTO photos VALUES ('7842', '734', '2530', 'id7842.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2530.jpg');
INSERT INTO photos VALUES ('7843', '734', '2531', 'id7843.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2531.jpg');
INSERT INTO photos VALUES ('7844', '734', '2532', 'id7844.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2532.jpg');
INSERT INTO photos VALUES ('7845', '734', '2533', 'id7845.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2533.jpg');
INSERT INTO photos VALUES ('7846', '734', '2534', 'id7846.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2534.jpg');
INSERT INTO photos VALUES ('7847', '734', '2536', 'id7847.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2536.jpg');
INSERT INTO photos VALUES ('7848', '734', '2537', 'id7848.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2537.jpg');
INSERT INTO photos VALUES ('7849', '734', '2538', 'id7849.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2538.jpg');
INSERT INTO photos VALUES ('7850', '734', '2539', 'id7850.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2539.jpg');
INSERT INTO photos VALUES ('7851', '734', '2540', 'id7851.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2540.jpg');
INSERT INTO photos VALUES ('7852', '734', '2541', 'id7852.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2541.jpg');
INSERT INTO photos VALUES ('7853', '734', '2543', 'id7853.jpg', '6', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2543.jpg');
INSERT INTO photos VALUES ('7854', '734', '2544', 'id7854.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2544.jpg');
INSERT INTO photos VALUES ('7855', '734', '2569', 'id7855.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2569.jpg');
INSERT INTO photos VALUES ('7856', '734', '2570', 'id7856.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2570.jpg');
INSERT INTO photos VALUES ('7857', '734', '2571', 'id7857.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2571.jpg');
INSERT INTO photos VALUES ('7858', '734', '2573', 'id7858.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2573.jpg');
INSERT INTO photos VALUES ('7859', '734', '2575', 'id7859.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2575.jpg');
INSERT INTO photos VALUES ('7860', '734', '2576', 'id7860.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2576.jpg');
INSERT INTO photos VALUES ('7861', '734', '2577', 'id7861.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2577.jpg');
INSERT INTO photos VALUES ('7862', '734', '2579', 'id7862.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2579.jpg');
INSERT INTO photos VALUES ('7863', '734', '2580', 'id7863.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2580.jpg');
INSERT INTO photos VALUES ('7864', '734', '2584', 'id7864.jpg', '3', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2584.jpg');
INSERT INTO photos VALUES ('7865', '734', '2585', 'id7865.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2585.jpg');
INSERT INTO photos VALUES ('7866', '734', '2586', 'id7866.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2586.jpg');
INSERT INTO photos VALUES ('7867', '734', '2587', 'id7867.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2587.jpg');
INSERT INTO photos VALUES ('7868', '734', '2588', 'id7868.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2588.jpg');
INSERT INTO photos VALUES ('7869', '734', '2589', 'id7869.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2589.jpg');
INSERT INTO photos VALUES ('7870', '734', '2590', 'id7870.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2590.jpg');
INSERT INTO photos VALUES ('7871', '734', '2592', 'id7871.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2592.jpg');
INSERT INTO photos VALUES ('7872', '734', '2593', 'id7872.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2593.jpg');
INSERT INTO photos VALUES ('7873', '734', '2594', 'id7873.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2594.jpg');
INSERT INTO photos VALUES ('7874', '734', '2600', 'id7874.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2600.jpg');
INSERT INTO photos VALUES ('7875', '734', '2601', 'id7875.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2601.jpg');
INSERT INTO photos VALUES ('7876', '734', '2608', 'id7876.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2608.jpg');
INSERT INTO photos VALUES ('7877', '734', '2610', 'id7877.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2610.jpg');
INSERT INTO photos VALUES ('7878', '734', '2637', 'id7878.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2637.jpg');
INSERT INTO photos VALUES ('7879', '734', '2638', 'id7879.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2638.jpg');
INSERT INTO photos VALUES ('7880', '734', '2650', 'id7880.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2650.jpg');
INSERT INTO photos VALUES ('7881', '734', '2651', 'id7881.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2651.jpg');
INSERT INTO photos VALUES ('7882', '734', '2652', 'id7882.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2652.jpg');
INSERT INTO photos VALUES ('7883', '734', '2653', 'id7883.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2653.jpg');
INSERT INTO photos VALUES ('7884', '734', '2654', 'id7884.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2654.jpg');
INSERT INTO photos VALUES ('7885', '734', '2658', 'id7885.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2658.jpg');
INSERT INTO photos VALUES ('7886', '734', '2659', 'id7886.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2659.jpg');
INSERT INTO photos VALUES ('7887', '734', '2660', 'id7887.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2660.jpg');
INSERT INTO photos VALUES ('7888', '734', '2661', 'id7888.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2661.jpg');
INSERT INTO photos VALUES ('7889', '734', '2668', 'id7889.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2668.jpg');
INSERT INTO photos VALUES ('7890', '734', '2669', 'id7890.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2669.jpg');
INSERT INTO photos VALUES ('7891', '734', '2671', 'id7891.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2671.jpg');
INSERT INTO photos VALUES ('7892', '734', '2675', 'id7892.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2675.jpg');
INSERT INTO photos VALUES ('7893', '734', '2678', 'id7893.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2678.jpg');
INSERT INTO photos VALUES ('7894', '734', '2713', 'id7894.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2713.jpg');
INSERT INTO photos VALUES ('7895', '734', '2714', 'id7895.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2714.jpg');
INSERT INTO photos VALUES ('7896', '734', '2715', 'id7896.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2715.jpg');
INSERT INTO photos VALUES ('7897', '734', '2716', 'id7897.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2716.jpg');
INSERT INTO photos VALUES ('7898', '734', '2718', 'id7898.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2718.jpg');
INSERT INTO photos VALUES ('7899', '734', '2720', 'id7899.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2720.jpg');
INSERT INTO photos VALUES ('7900', '734', '2721', 'id7900.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2721.jpg');
INSERT INTO photos VALUES ('7901', '734', '2722', 'id7901.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2722.jpg');
INSERT INTO photos VALUES ('7902', '734', '2723', 'id7902.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2723.jpg');
INSERT INTO photos VALUES ('7903', '734', '2727', 'id7903.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2727.jpg');
INSERT INTO photos VALUES ('7904', '734', '2728', 'id7904.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2728.jpg');
INSERT INTO photos VALUES ('7905', '734', '2729', 'id7905.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2729.jpg');
INSERT INTO photos VALUES ('7906', '734', '2730', 'id7906.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2730.jpg');
INSERT INTO photos VALUES ('7907', '734', '2735', 'id7907.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2735.jpg');
INSERT INTO photos VALUES ('7908', '734', '2737', 'id7908.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2737.jpg');
INSERT INTO photos VALUES ('7909', '734', '2739', 'id7909.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2739.jpg');
INSERT INTO photos VALUES ('7910', '734', '2783', 'id7910.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2783.jpg');
INSERT INTO photos VALUES ('7911', '734', '2786', 'id7911.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2786.jpg');
INSERT INTO photos VALUES ('7912', '734', '2788', 'id7912.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2788.jpg');
INSERT INTO photos VALUES ('7913', '734', '2789', 'id7913.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2789.jpg');
INSERT INTO photos VALUES ('7914', '734', '2790', 'id7914.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2790.jpg');
INSERT INTO photos VALUES ('7915', '734', '2791', 'id7915.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2791.jpg');
INSERT INTO photos VALUES ('7916', '734', '2792', 'id7916.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2792.jpg');
INSERT INTO photos VALUES ('7917', '734', '2795', 'id7917.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2795.jpg');
INSERT INTO photos VALUES ('7918', '734', '2796', 'id7918.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2796.jpg');
INSERT INTO photos VALUES ('7919', '734', '2798', 'id7919.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2798.jpg');
INSERT INTO photos VALUES ('7920', '734', '2800', 'id7920.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2800.jpg');
INSERT INTO photos VALUES ('7921', '734', '2803', 'id7921.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2803.jpg');
INSERT INTO photos VALUES ('7922', '734', '2804', 'id7922.jpg', '9', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2804.jpg');
INSERT INTO photos VALUES ('7923', '734', '2805', 'id7923.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2805.jpg');
INSERT INTO photos VALUES ('7924', '734', '2806', 'id7924.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2806.jpg');
INSERT INTO photos VALUES ('7925', '734', '2811', 'id7925.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2811.jpg');
INSERT INTO photos VALUES ('7926', '734', '2812', 'id7926.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2812.jpg');
INSERT INTO photos VALUES ('7927', '734', '2813', 'id7927.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2813.jpg');
INSERT INTO photos VALUES ('7928', '734', '2829', 'id7928.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2829.jpg');
INSERT INTO photos VALUES ('7929', '734', '2830', 'id7929.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2830.jpg');
INSERT INTO photos VALUES ('7930', '734', '2831', 'id7930.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2831.jpg');
INSERT INTO photos VALUES ('7931', '734', '2832', 'id7931.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2832.jpg');
INSERT INTO photos VALUES ('7932', '734', '2833', 'id7932.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2833.jpg');
INSERT INTO photos VALUES ('7933', '734', '2836', 'id7933.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2836.jpg');
INSERT INTO photos VALUES ('7934', '734', '2837', 'id7934.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2837.jpg');
INSERT INTO photos VALUES ('7935', '734', '2838', 'id7935.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2838.jpg');
INSERT INTO photos VALUES ('7936', '734', '2840', 'id7936.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2840.jpg');
INSERT INTO photos VALUES ('7937', '734', '2842', 'id7937.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2842.jpg');
INSERT INTO photos VALUES ('7938', '734', '2843', 'id7938.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2843.jpg');
INSERT INTO photos VALUES ('7939', '734', '2844', 'id7939.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2844.jpg');
INSERT INTO photos VALUES ('7940', '734', '2845', 'id7940.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2845.jpg');
INSERT INTO photos VALUES ('7941', '734', '2846', 'id7941.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2846.jpg');
INSERT INTO photos VALUES ('7942', '734', '2847', 'id7942.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2847.jpg');
INSERT INTO photos VALUES ('7943', '734', '2848', 'id7943.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2848.jpg');
INSERT INTO photos VALUES ('7944', '734', '2849', 'id7944.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2849.jpg');
INSERT INTO photos VALUES ('7945', '734', '2850', 'id7945.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2850.jpg');
INSERT INTO photos VALUES ('7946', '734', '2851', 'id7946.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2851.jpg');
INSERT INTO photos VALUES ('7947', '734', '2852', 'id7947.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2852.jpg');
INSERT INTO photos VALUES ('7948', '734', '2854', 'id7948.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2854.jpg');
INSERT INTO photos VALUES ('7949', '734', '2856', 'id7949.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2856.jpg');
INSERT INTO photos VALUES ('7950', '734', '2857', 'id7950.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2857.jpg');
INSERT INTO photos VALUES ('7951', '734', '2858', 'id7951.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2858.jpg');
INSERT INTO photos VALUES ('7952', '734', '2860', 'id7952.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2860.jpg');
INSERT INTO photos VALUES ('7953', '734', '2861', 'id7953.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2861.jpg');
INSERT INTO photos VALUES ('7954', '734', '2862', 'id7954.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2862.jpg');
INSERT INTO photos VALUES ('7955', '734', '2863', 'id7955.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2863.jpg');
INSERT INTO photos VALUES ('7956', '734', '2880', 'id7956.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2880.jpg');
INSERT INTO photos VALUES ('7957', '734', '2881', 'id7957.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2881.jpg');
INSERT INTO photos VALUES ('7958', '734', '2882', 'id7958.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2882.jpg');
INSERT INTO photos VALUES ('7959', '734', '2886', 'id7959.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2886.jpg');
INSERT INTO photos VALUES ('7960', '734', '2892', 'id7960.jpg', '7', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2892.jpg');
INSERT INTO photos VALUES ('7961', '734', '2916', 'id7961.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2916.jpg');
INSERT INTO photos VALUES ('7962', '734', '2918', 'id7962.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2918.jpg');
INSERT INTO photos VALUES ('7963', '734', '2920', 'id7963.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2920.jpg');
INSERT INTO photos VALUES ('7964', '734', '2922', 'id7964.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2922.jpg');
INSERT INTO photos VALUES ('7965', '734', '2923', 'id7965.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2923.jpg');
INSERT INTO photos VALUES ('7966', '734', '2924', 'id7966.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2924.jpg');
INSERT INTO photos VALUES ('7967', '734', '2925', 'id7967.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2925.jpg');
INSERT INTO photos VALUES ('7968', '734', '2928', 'id7968.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2928.jpg');
INSERT INTO photos VALUES ('7969', '734', '2929', 'id7969.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2929.jpg');
INSERT INTO photos VALUES ('7970', '734', '2930', 'id7970.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2930.jpg');
INSERT INTO photos VALUES ('7971', '734', '2943', 'id7971.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2943.jpg');
INSERT INTO photos VALUES ('7972', '734', '2944', 'id7972.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2944.jpg');
INSERT INTO photos VALUES ('7973', '734', '2946', 'id7973.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2946.jpg');
INSERT INTO photos VALUES ('7974', '734', '2947', 'id7974.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2947.jpg');
INSERT INTO photos VALUES ('7975', '734', '2951', 'id7975.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2951.jpg');
INSERT INTO photos VALUES ('7976', '734', '2953', 'id7976.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2953.jpg');
INSERT INTO photos VALUES ('7977', '734', '2956', 'id7977.jpg', '2', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2956.jpg');
INSERT INTO photos VALUES ('7978', '734', '2960', 'id7978.jpg', '1', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2960.jpg');
INSERT INTO photos VALUES ('7979', '734', '2964', 'id7979.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2964.jpg');
INSERT INTO photos VALUES ('7980', '734', '2965', 'id7980.jpg', '1', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2965.jpg');
INSERT INTO photos VALUES ('7981', '734', '2967', 'id7981.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2967.jpg');
INSERT INTO photos VALUES ('7982', '734', '2978', 'id7982.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2978.jpg');
INSERT INTO photos VALUES ('7983', '734', '2987', 'id7983.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2987.jpg');
INSERT INTO photos VALUES ('7984', '734', '2988', 'id7984.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2988.jpg');
INSERT INTO photos VALUES ('7985', '734', '2989', 'id7985.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2989.jpg');
INSERT INTO photos VALUES ('7986', '734', '2990', 'id7986.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2990.jpg');
INSERT INTO photos VALUES ('7987', '734', '2992', 'id7987.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2992.jpg');
INSERT INTO photos VALUES ('7988', '734', '2993', 'id7988.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2993.jpg');
INSERT INTO photos VALUES ('7989', '734', '2995', 'id7989.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2995.jpg');
INSERT INTO photos VALUES ('7990', '734', '2996', 'id7990.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2996.jpg');
INSERT INTO photos VALUES ('7991', '734', '2997', 'id7991.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2997.jpg');
INSERT INTO photos VALUES ('7992', '734', '2998', 'id7992.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/2998.jpg');
INSERT INTO photos VALUES ('7993', '734', '3001', 'id7993.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/3001.jpg');
INSERT INTO photos VALUES ('7994', '734', '3003', 'id7994.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/3003.jpg');
INSERT INTO photos VALUES ('7995', '734', '3004', 'id7995.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/3004.jpg');
INSERT INTO photos VALUES ('7996', '734', '3006', 'id7996.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/3006.jpg');
INSERT INTO photos VALUES ('7997', '734', '3008', 'id7997.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/3008.jpg');
INSERT INTO photos VALUES ('7998', '734', '3043', 'id7998.jpg', '3', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/3043.jpg');
INSERT INTO photos VALUES ('7999', '734', '3047', 'id7999.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/3047.jpg');
INSERT INTO photos VALUES ('8000', '734', '3053', 'id8000.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013gosti/3053.jpg');
INSERT INTO photos VALUES ('8741', '737', '0544', 'id8741.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0544.jpg');
INSERT INTO photos VALUES ('8742', '737', '0546', 'id8742.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0546.jpg');
INSERT INTO photos VALUES ('8743', '737', '0547', 'id8743.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0547.jpg');
INSERT INTO photos VALUES ('8744', '737', '0548', 'id8744.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0548.jpg');
INSERT INTO photos VALUES ('8745', '737', '0549', 'id8745.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0549.jpg');
INSERT INTO photos VALUES ('8746', '737', '0550', 'id8746.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0550.jpg');
INSERT INTO photos VALUES ('8747', '737', '0551', 'id8747.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0551.jpg');
INSERT INTO photos VALUES ('8748', '737', '0552', 'id8748.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0552.jpg');
INSERT INTO photos VALUES ('8749', '737', '0553', 'id8749.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0553.jpg');
INSERT INTO photos VALUES ('8750', '737', '0554', 'id8750.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0554.jpg');
INSERT INTO photos VALUES ('8751', '737', '0555', 'id8751.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0555.jpg');
INSERT INTO photos VALUES ('8752', '737', '0556', 'id8752.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0556.jpg');
INSERT INTO photos VALUES ('8753', '737', '0557', 'id8753.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0557.jpg');
INSERT INTO photos VALUES ('8754', '737', '0558', 'id8754.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0558.jpg');
INSERT INTO photos VALUES ('8755', '737', '0560', 'id8755.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0560.jpg');
INSERT INTO photos VALUES ('8756', '737', '0562', 'id8756.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0562.jpg');
INSERT INTO photos VALUES ('8757', '737', '0563', 'id8757.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0563.jpg');
INSERT INTO photos VALUES ('8758', '737', '0564', 'id8758.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0564.jpg');
INSERT INTO photos VALUES ('8759', '737', '0565', 'id8759.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0565.jpg');
INSERT INTO photos VALUES ('8760', '737', '0567', 'id8760.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0567.jpg');
INSERT INTO photos VALUES ('8761', '737', '0568', 'id8761.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0568.jpg');
INSERT INTO photos VALUES ('8762', '737', '0572', 'id8762.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0572.jpg');
INSERT INTO photos VALUES ('8763', '737', '0573', 'id8763.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0573.jpg');
INSERT INTO photos VALUES ('8764', '737', '0574', 'id8764.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0574.jpg');
INSERT INTO photos VALUES ('8765', '737', '0575', 'id8765.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0575.jpg');
INSERT INTO photos VALUES ('8766', '737', '0576', 'id8766.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0576.jpg');
INSERT INTO photos VALUES ('8767', '737', '0577', 'id8767.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0577.jpg');
INSERT INTO photos VALUES ('8768', '737', '0578', 'id8768.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0578.jpg');
INSERT INTO photos VALUES ('8769', '737', '0605', 'id8769.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0605.jpg');
INSERT INTO photos VALUES ('8770', '737', '0606', 'id8770.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0606.jpg');
INSERT INTO photos VALUES ('8771', '737', '0607', 'id8771.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0607.jpg');
INSERT INTO photos VALUES ('8772', '737', '0608', 'id8772.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0608.jpg');
INSERT INTO photos VALUES ('8773', '737', '0609', 'id8773.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0609.jpg');
INSERT INTO photos VALUES ('8774', '737', '0610', 'id8774.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0610.jpg');
INSERT INTO photos VALUES ('8775', '737', '0611', 'id8775.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0611.jpg');
INSERT INTO photos VALUES ('8776', '737', '0612', 'id8776.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0612.jpg');
INSERT INTO photos VALUES ('8777', '737', '0614', 'id8777.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0614.jpg');
INSERT INTO photos VALUES ('8778', '737', '0615', 'id8778.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0615.jpg');
INSERT INTO photos VALUES ('8779', '737', '0616', 'id8779.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0616.jpg');
INSERT INTO photos VALUES ('8780', '737', '0618', 'id8780.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0618.jpg');
INSERT INTO photos VALUES ('8781', '737', '0619', 'id8781.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0619.jpg');
INSERT INTO photos VALUES ('8782', '737', '0620', 'id8782.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0620.jpg');
INSERT INTO photos VALUES ('8783', '737', '0622', 'id8783.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0622.jpg');
INSERT INTO photos VALUES ('8784', '737', '0624', 'id8784.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0624.jpg');
INSERT INTO photos VALUES ('8785', '737', '0625', 'id8785.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0625.jpg');
INSERT INTO photos VALUES ('8786', '737', '0628', 'id8786.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0628.jpg');
INSERT INTO photos VALUES ('8787', '737', '0630', 'id8787.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0630.jpg');
INSERT INTO photos VALUES ('8788', '737', '0631', 'id8788.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0631.jpg');
INSERT INTO photos VALUES ('8789', '737', '0634', 'id8789.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0634.jpg');
INSERT INTO photos VALUES ('8790', '737', '0635', 'id8790.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0635.jpg');
INSERT INTO photos VALUES ('8791', '737', '0636', 'id8791.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0636.jpg');
INSERT INTO photos VALUES ('8792', '737', '0637', 'id8792.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0637.jpg');
INSERT INTO photos VALUES ('8793', '737', '0639', 'id8793.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0639.jpg');
INSERT INTO photos VALUES ('8794', '737', '0640', 'id8794.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0640.jpg');
INSERT INTO photos VALUES ('8795', '737', '0641', 'id8795.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0641.jpg');
INSERT INTO photos VALUES ('8796', '737', '0642', 'id8796.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0642.jpg');
INSERT INTO photos VALUES ('8797', '737', '0649', 'id8797.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0649.jpg');
INSERT INTO photos VALUES ('8798', '737', '0650', 'id8798.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0650.jpg');
INSERT INTO photos VALUES ('8799', '737', '0651', 'id8799.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0651.jpg');
INSERT INTO photos VALUES ('8800', '737', '0652', 'id8800.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0652.jpg');
INSERT INTO photos VALUES ('8801', '737', '0653', 'id8801.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0653.jpg');
INSERT INTO photos VALUES ('8802', '737', '0655', 'id8802.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0655.jpg');
INSERT INTO photos VALUES ('8803', '737', '0656', 'id8803.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0656.jpg');
INSERT INTO photos VALUES ('8804', '737', '0659', 'id8804.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0659.jpg');
INSERT INTO photos VALUES ('8805', '737', '0662', 'id8805.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0662.jpg');
INSERT INTO photos VALUES ('8806', '737', '0663', 'id8806.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0663.jpg');
INSERT INTO photos VALUES ('8807', '737', '0665', 'id8807.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0665.jpg');
INSERT INTO photos VALUES ('8808', '737', '0666', 'id8808.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0666.jpg');
INSERT INTO photos VALUES ('8809', '737', '0670', 'id8809.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0670.jpg');
INSERT INTO photos VALUES ('8810', '737', '0671', 'id8810.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0671.jpg');
INSERT INTO photos VALUES ('8811', '737', '0672', 'id8811.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0672.jpg');
INSERT INTO photos VALUES ('8812', '737', '0676', 'id8812.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0676.jpg');
INSERT INTO photos VALUES ('8813', '737', '0677', 'id8813.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0677.jpg');
INSERT INTO photos VALUES ('8814', '737', '0678', 'id8814.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0678.jpg');
INSERT INTO photos VALUES ('8815', '737', '0679', 'id8815.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0679.jpg');
INSERT INTO photos VALUES ('8816', '737', '0681', 'id8816.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0681.jpg');
INSERT INTO photos VALUES ('8817', '737', '0682', 'id8817.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0682.jpg');
INSERT INTO photos VALUES ('8818', '737', '0683', 'id8818.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0683.jpg');
INSERT INTO photos VALUES ('8819', '737', '0684', 'id8819.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0684.jpg');
INSERT INTO photos VALUES ('8820', '737', '0685', 'id8820.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0685.jpg');
INSERT INTO photos VALUES ('8821', '737', '0686', 'id8821.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0686.jpg');
INSERT INTO photos VALUES ('8822', '737', '0687', 'id8822.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0687.jpg');
INSERT INTO photos VALUES ('8823', '737', '0688', 'id8823.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0688.jpg');
INSERT INTO photos VALUES ('8824', '737', '0689', 'id8824.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0689.jpg');
INSERT INTO photos VALUES ('8825', '737', '0690', 'id8825.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0690.jpg');
INSERT INTO photos VALUES ('8826', '737', '0710', 'id8826.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0710.jpg');
INSERT INTO photos VALUES ('8827', '737', '0711', 'id8827.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0711.jpg');
INSERT INTO photos VALUES ('8828', '737', '0712', 'id8828.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0712.jpg');
INSERT INTO photos VALUES ('8829', '737', '0713', 'id8829.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0713.jpg');
INSERT INTO photos VALUES ('8830', '737', '0715', 'id8830.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0715.jpg');
INSERT INTO photos VALUES ('8831', '737', '0716', 'id8831.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0716.jpg');
INSERT INTO photos VALUES ('8832', '737', '0718', 'id8832.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0718.jpg');
INSERT INTO photos VALUES ('8833', '737', '0719', 'id8833.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0719.jpg');
INSERT INTO photos VALUES ('8834', '737', '0720', 'id8834.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0720.jpg');
INSERT INTO photos VALUES ('8835', '737', '0721', 'id8835.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0721.jpg');
INSERT INTO photos VALUES ('8836', '737', '0722', 'id8836.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0722.jpg');
INSERT INTO photos VALUES ('8837', '737', '0723', 'id8837.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0723.jpg');
INSERT INTO photos VALUES ('8838', '737', '0727', 'id8838.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0727.jpg');
INSERT INTO photos VALUES ('8839', '737', '0729', 'id8839.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0729.jpg');
INSERT INTO photos VALUES ('8840', '737', '0730', 'id8840.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0730.jpg');
INSERT INTO photos VALUES ('8841', '737', '0731', 'id8841.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0731.jpg');
INSERT INTO photos VALUES ('8842', '737', '0732', 'id8842.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0732.jpg');
INSERT INTO photos VALUES ('8843', '737', '0735', 'id8843.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0735.jpg');
INSERT INTO photos VALUES ('8844', '737', '0736', 'id8844.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0736.jpg');
INSERT INTO photos VALUES ('8845', '737', '0737', 'id8845.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0737.jpg');
INSERT INTO photos VALUES ('8846', '737', '0738', 'id8846.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0738.jpg');
INSERT INTO photos VALUES ('8847', '737', '0739', 'id8847.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0739.jpg');
INSERT INTO photos VALUES ('8848', '737', '0740', 'id8848.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0740.jpg');
INSERT INTO photos VALUES ('8849', '737', '0741', 'id8849.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0741.jpg');
INSERT INTO photos VALUES ('8850', '737', '0742', 'id8850.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0742.jpg');
INSERT INTO photos VALUES ('8851', '737', '0743', 'id8851.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0743.jpg');
INSERT INTO photos VALUES ('8852', '737', '0744', 'id8852.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0744.jpg');
INSERT INTO photos VALUES ('8853', '737', '0745', 'id8853.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0745.jpg');
INSERT INTO photos VALUES ('8854', '737', '0746', 'id8854.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0746.jpg');
INSERT INTO photos VALUES ('8855', '737', '0749', 'id8855.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0749.jpg');
INSERT INTO photos VALUES ('8856', '737', '0751', 'id8856.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0751.jpg');
INSERT INTO photos VALUES ('8857', '737', '0752', 'id8857.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0752.jpg');
INSERT INTO photos VALUES ('8858', '737', '0753', 'id8858.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0753.jpg');
INSERT INTO photos VALUES ('8859', '737', '0755', 'id8859.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0755.jpg');
INSERT INTO photos VALUES ('8860', '737', '0756', 'id8860.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0756.jpg');
INSERT INTO photos VALUES ('8861', '737', '0758', 'id8861.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0758.jpg');
INSERT INTO photos VALUES ('8862', '737', '0760', 'id8862.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0760.jpg');
INSERT INTO photos VALUES ('8863', '737', '0762', 'id8863.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0762.jpg');
INSERT INTO photos VALUES ('8864', '737', '0763', 'id8864.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0763.jpg');
INSERT INTO photos VALUES ('8865', '737', '0764', 'id8865.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0764.jpg');
INSERT INTO photos VALUES ('8866', '737', '0765', 'id8866.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0765.jpg');
INSERT INTO photos VALUES ('8867', '737', '0766', 'id8867.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0766.jpg');
INSERT INTO photos VALUES ('8868', '737', '0767', 'id8868.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0767.jpg');
INSERT INTO photos VALUES ('8869', '737', '0768', 'id8869.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0768.jpg');
INSERT INTO photos VALUES ('8870', '737', '0769', 'id8870.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0769.jpg');
INSERT INTO photos VALUES ('8871', '737', '0770', 'id8871.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0770.jpg');
INSERT INTO photos VALUES ('8872', '737', '0771', 'id8872.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0771.jpg');
INSERT INTO photos VALUES ('8873', '737', '0772', 'id8873.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0772.jpg');
INSERT INTO photos VALUES ('8874', '737', '0774', 'id8874.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0774.jpg');
INSERT INTO photos VALUES ('8875', '737', '0775', 'id8875.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0775.jpg');
INSERT INTO photos VALUES ('8876', '737', '0776', 'id8876.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0776.jpg');
INSERT INTO photos VALUES ('8877', '737', '0777', 'id8877.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0777.jpg');
INSERT INTO photos VALUES ('8878', '737', '0779', 'id8878.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0779.jpg');
INSERT INTO photos VALUES ('8879', '737', '0780', 'id8879.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0780.jpg');
INSERT INTO photos VALUES ('8880', '737', '0784', 'id8880.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0784.jpg');
INSERT INTO photos VALUES ('8881', '737', '0785', 'id8881.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0785.jpg');
INSERT INTO photos VALUES ('8882', '737', '0851', 'id8882.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0851.jpg');
INSERT INTO photos VALUES ('8883', '737', '0852', 'id8883.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0852.jpg');
INSERT INTO photos VALUES ('8884', '737', '0853', 'id8884.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0853.jpg');
INSERT INTO photos VALUES ('8885', '737', '0855', 'id8885.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0855.jpg');
INSERT INTO photos VALUES ('8886', '737', '0856', 'id8886.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0856.jpg');
INSERT INTO photos VALUES ('8887', '737', '0859', 'id8887.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0859.jpg');
INSERT INTO photos VALUES ('8888', '737', '0861', 'id8888.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0861.jpg');
INSERT INTO photos VALUES ('8889', '737', '0862', 'id8889.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0862.jpg');
INSERT INTO photos VALUES ('8890', '737', '0863', 'id8890.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0863.jpg');
INSERT INTO photos VALUES ('8891', '737', '0865', 'id8891.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0865.jpg');
INSERT INTO photos VALUES ('8892', '737', '0866', 'id8892.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0866.jpg');
INSERT INTO photos VALUES ('8893', '737', '0867', 'id8893.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0867.jpg');
INSERT INTO photos VALUES ('8894', '737', '0869', 'id8894.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0869.jpg');
INSERT INTO photos VALUES ('8895', '737', '0872', 'id8895.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0872.jpg');
INSERT INTO photos VALUES ('8896', '737', '0874', 'id8896.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0874.jpg');
INSERT INTO photos VALUES ('8897', '737', '0875', 'id8897.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0875.jpg');
INSERT INTO photos VALUES ('8898', '737', '0876', 'id8898.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0876.jpg');
INSERT INTO photos VALUES ('8899', '737', '0877', 'id8899.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0877.jpg');
INSERT INTO photos VALUES ('8900', '737', '0878', 'id8900.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0878.jpg');
INSERT INTO photos VALUES ('8901', '737', '0879', 'id8901.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0879.jpg');
INSERT INTO photos VALUES ('8902', '737', '0880', 'id8902.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0880.jpg');
INSERT INTO photos VALUES ('8903', '737', '0882', 'id8903.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0882.jpg');
INSERT INTO photos VALUES ('8904', '737', '0883', 'id8904.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0883.jpg');
INSERT INTO photos VALUES ('8905', '737', '0884', 'id8905.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0884.jpg');
INSERT INTO photos VALUES ('8906', '737', '0885', 'id8906.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0885.jpg');
INSERT INTO photos VALUES ('8907', '737', '0887', 'id8907.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0887.jpg');
INSERT INTO photos VALUES ('8908', '737', '0888', 'id8908.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0888.jpg');
INSERT INTO photos VALUES ('8909', '737', '0889', 'id8909.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0889.jpg');
INSERT INTO photos VALUES ('8910', '737', '0890', 'id8910.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0890.jpg');
INSERT INTO photos VALUES ('8911', '737', '0891', 'id8911.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0891.jpg');
INSERT INTO photos VALUES ('8912', '737', '0892', 'id8912.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0892.jpg');
INSERT INTO photos VALUES ('8913', '737', '0893', 'id8913.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0893.jpg');
INSERT INTO photos VALUES ('8914', '737', '0894', 'id8914.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0894.jpg');
INSERT INTO photos VALUES ('8915', '737', '0895', 'id8915.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0895.jpg');
INSERT INTO photos VALUES ('8916', '737', '0897', 'id8916.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0897.jpg');
INSERT INTO photos VALUES ('8917', '737', '0898', 'id8917.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0898.jpg');
INSERT INTO photos VALUES ('8918', '737', '0899', 'id8918.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0899.jpg');
INSERT INTO photos VALUES ('8919', '737', '0900', 'id8919.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0900.jpg');
INSERT INTO photos VALUES ('8920', '737', '0901', 'id8920.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0901.jpg');
INSERT INTO photos VALUES ('8921', '737', '0904', 'id8921.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0904.jpg');
INSERT INTO photos VALUES ('8922', '737', '0905', 'id8922.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0905.jpg');
INSERT INTO photos VALUES ('8923', '737', '0906', 'id8923.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0906.jpg');
INSERT INTO photos VALUES ('8924', '737', '0907', 'id8924.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0907.jpg');
INSERT INTO photos VALUES ('8925', '737', '0908', 'id8925.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0908.jpg');
INSERT INTO photos VALUES ('8926', '737', '0909', 'id8926.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0909.jpg');
INSERT INTO photos VALUES ('8927', '737', '0910', 'id8927.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0910.jpg');
INSERT INTO photos VALUES ('8928', '737', '0912', 'id8928.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0912.jpg');
INSERT INTO photos VALUES ('8929', '737', '0913', 'id8929.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0913.jpg');
INSERT INTO photos VALUES ('8930', '737', '0914', 'id8930.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0914.jpg');
INSERT INTO photos VALUES ('8931', '737', '0916', 'id8931.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0916.jpg');
INSERT INTO photos VALUES ('8932', '737', '0917', 'id8932.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0917.jpg');
INSERT INTO photos VALUES ('8933', '737', '0919', 'id8933.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0919.jpg');
INSERT INTO photos VALUES ('8934', '737', '0920', 'id8934.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0920.jpg');
INSERT INTO photos VALUES ('8935', '737', '0921', 'id8935.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0921.jpg');
INSERT INTO photos VALUES ('8936', '737', '0923', 'id8936.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0923.jpg');
INSERT INTO photos VALUES ('8937', '737', '0924', 'id8937.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0924.jpg');
INSERT INTO photos VALUES ('8938', '737', '0929', 'id8938.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0929.jpg');
INSERT INTO photos VALUES ('8939', '737', '0930', 'id8939.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0930.jpg');
INSERT INTO photos VALUES ('8940', '737', '0931', 'id8940.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0931.jpg');
INSERT INTO photos VALUES ('8941', '737', '0932', 'id8941.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0932.jpg');
INSERT INTO photos VALUES ('8942', '737', '0933', 'id8942.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0933.jpg');
INSERT INTO photos VALUES ('8943', '737', '0934', 'id8943.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0934.jpg');
INSERT INTO photos VALUES ('8944', '737', '0935', 'id8944.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0935.jpg');
INSERT INTO photos VALUES ('8945', '737', '0938', 'id8945.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0938.jpg');
INSERT INTO photos VALUES ('8946', '737', '0939', 'id8946.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0939.jpg');
INSERT INTO photos VALUES ('8947', '737', '0941', 'id8947.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0941.jpg');
INSERT INTO photos VALUES ('8948', '737', '0943', 'id8948.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0943.jpg');
INSERT INTO photos VALUES ('8949', '737', '0944', 'id8949.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0944.jpg');
INSERT INTO photos VALUES ('8950', '737', '0945', 'id8950.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0945.jpg');
INSERT INTO photos VALUES ('8951', '737', '0946', 'id8951.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0946.jpg');
INSERT INTO photos VALUES ('8952', '737', '0980', 'id8952.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0980.jpg');
INSERT INTO photos VALUES ('8953', '737', '0981', 'id8953.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0981.jpg');
INSERT INTO photos VALUES ('8954', '737', '0982', 'id8954.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0982.jpg');
INSERT INTO photos VALUES ('8955', '737', '0985', 'id8955.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0985.jpg');
INSERT INTO photos VALUES ('8956', '737', '0986', 'id8956.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0986.jpg');
INSERT INTO photos VALUES ('8957', '737', '0988', 'id8957.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0988.jpg');
INSERT INTO photos VALUES ('8958', '737', '0989', 'id8958.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0989.jpg');
INSERT INTO photos VALUES ('8959', '737', '0990', 'id8959.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0990.jpg');
INSERT INTO photos VALUES ('8960', '737', '0991', 'id8960.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0991.jpg');
INSERT INTO photos VALUES ('8961', '737', '0992', 'id8961.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0992.jpg');
INSERT INTO photos VALUES ('8962', '737', '0993', 'id8962.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0993.jpg');
INSERT INTO photos VALUES ('8963', '737', '0995', 'id8963.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0995.jpg');
INSERT INTO photos VALUES ('8964', '737', '0998', 'id8964.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/0998.jpg');
INSERT INTO photos VALUES ('8965', '737', '1000', 'id8965.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1000.jpg');
INSERT INTO photos VALUES ('8966', '737', '1003', 'id8966.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1003.jpg');
INSERT INTO photos VALUES ('8967', '737', '1004', 'id8967.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1004.jpg');
INSERT INTO photos VALUES ('8968', '737', '1005', 'id8968.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1005.jpg');
INSERT INTO photos VALUES ('8969', '737', '1006', 'id8969.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1006.jpg');
INSERT INTO photos VALUES ('8970', '737', '1007', 'id8970.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1007.jpg');
INSERT INTO photos VALUES ('8971', '737', '1008', 'id8971.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1008.jpg');
INSERT INTO photos VALUES ('8972', '737', '1011', 'id8972.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1011.jpg');
INSERT INTO photos VALUES ('8973', '737', '1012', 'id8973.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1012.jpg');
INSERT INTO photos VALUES ('8974', '737', '1013', 'id8974.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1013.jpg');
INSERT INTO photos VALUES ('8975', '737', '1014', 'id8975.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1014.jpg');
INSERT INTO photos VALUES ('8976', '737', '1015', 'id8976.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1015.jpg');
INSERT INTO photos VALUES ('8977', '737', '1016', 'id8977.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1016.jpg');
INSERT INTO photos VALUES ('8978', '737', '1017', 'id8978.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1017.jpg');
INSERT INTO photos VALUES ('8979', '737', '1018', 'id8979.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1018.jpg');
INSERT INTO photos VALUES ('8980', '737', '1019', 'id8980.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1019.jpg');
INSERT INTO photos VALUES ('8981', '737', '1020', 'id8981.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1020.jpg');
INSERT INTO photos VALUES ('8982', '737', '1021', 'id8982.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1021.jpg');
INSERT INTO photos VALUES ('8983', '737', '1022', 'id8983.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1022.jpg');
INSERT INTO photos VALUES ('8984', '737', '1023', 'id8984.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1023.jpg');
INSERT INTO photos VALUES ('8985', '737', '1025', 'id8985.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1025.jpg');
INSERT INTO photos VALUES ('8986', '737', '1028', 'id8986.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1028.jpg');
INSERT INTO photos VALUES ('8987', '737', '1031', 'id8987.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1031.jpg');
INSERT INTO photos VALUES ('8988', '737', '1034', 'id8988.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1034.jpg');
INSERT INTO photos VALUES ('8989', '737', '1035', 'id8989.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1035.jpg');
INSERT INTO photos VALUES ('8990', '737', '1037', 'id8990.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1037.jpg');
INSERT INTO photos VALUES ('8991', '737', '1038', 'id8991.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1038.jpg');
INSERT INTO photos VALUES ('8992', '737', '1039', 'id8992.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1039.jpg');
INSERT INTO photos VALUES ('8993', '737', '1040', 'id8993.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1040.jpg');
INSERT INTO photos VALUES ('8994', '737', '1042', 'id8994.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1042.jpg');
INSERT INTO photos VALUES ('8995', '737', '1043', 'id8995.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1043.jpg');
INSERT INTO photos VALUES ('8996', '737', '1044', 'id8996.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1044.jpg');
INSERT INTO photos VALUES ('8997', '737', '1045', 'id8997.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1045.jpg');
INSERT INTO photos VALUES ('8998', '737', '1047', 'id8998.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1047.jpg');
INSERT INTO photos VALUES ('8999', '737', '1048', 'id8999.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1048.jpg');
INSERT INTO photos VALUES ('9000', '737', '1049', 'id9000.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1049.jpg');
INSERT INTO photos VALUES ('9001', '737', '1051', 'id9001.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1051.jpg');
INSERT INTO photos VALUES ('9002', '737', '1052', 'id9002.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1052.jpg');
INSERT INTO photos VALUES ('9003', '737', '1053', 'id9003.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1053.jpg');
INSERT INTO photos VALUES ('9004', '737', '1054', 'id9004.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1054.jpg');
INSERT INTO photos VALUES ('9005', '737', '1055', 'id9005.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1055.jpg');
INSERT INTO photos VALUES ('9006', '737', '1057', 'id9006.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1057.jpg');
INSERT INTO photos VALUES ('9007', '737', '1058', 'id9007.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1058.jpg');
INSERT INTO photos VALUES ('9008', '737', '1059', 'id9008.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1059.jpg');
INSERT INTO photos VALUES ('9009', '737', '1061', 'id9009.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1061.jpg');
INSERT INTO photos VALUES ('9010', '737', '1062', 'id9010.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1062.jpg');
INSERT INTO photos VALUES ('9011', '737', '1065', 'id9011.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1065.jpg');
INSERT INTO photos VALUES ('9012', '737', '1066', 'id9012.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1066.jpg');
INSERT INTO photos VALUES ('9013', '737', '1067', 'id9013.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1067.jpg');
INSERT INTO photos VALUES ('9014', '737', '1068', 'id9014.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1068.jpg');
INSERT INTO photos VALUES ('9015', '737', '1069', 'id9015.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1069.jpg');
INSERT INTO photos VALUES ('9016', '737', '1070', 'id9016.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1070.jpg');
INSERT INTO photos VALUES ('9017', '737', '1071', 'id9017.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1071.jpg');
INSERT INTO photos VALUES ('9018', '737', '1072', 'id9018.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1072.jpg');
INSERT INTO photos VALUES ('9019', '737', '1073', 'id9019.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1073.jpg');
INSERT INTO photos VALUES ('9020', '737', '1074', 'id9020.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1074.jpg');
INSERT INTO photos VALUES ('9021', '737', '1075', 'id9021.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1075.jpg');
INSERT INTO photos VALUES ('9022', '737', '1080', 'id9022.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1080.jpg');
INSERT INTO photos VALUES ('9023', '737', '1081', 'id9023.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1081.jpg');
INSERT INTO photos VALUES ('9024', '737', '1082', 'id9024.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1082.jpg');
INSERT INTO photos VALUES ('9025', '737', '1083', 'id9025.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1083.jpg');
INSERT INTO photos VALUES ('9026', '737', '1085', 'id9026.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1085.jpg');
INSERT INTO photos VALUES ('9027', '737', '1086', 'id9027.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1086.jpg');
INSERT INTO photos VALUES ('9028', '737', '1087', 'id9028.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1087.jpg');
INSERT INTO photos VALUES ('9029', '737', '1089', 'id9029.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1089.jpg');
INSERT INTO photos VALUES ('9030', '737', '1091', 'id9030.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1091.jpg');
INSERT INTO photos VALUES ('9031', '737', '1092', 'id9031.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1092.jpg');
INSERT INTO photos VALUES ('9032', '737', '1093', 'id9032.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1093.jpg');
INSERT INTO photos VALUES ('9033', '737', '1094', 'id9033.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1094.jpg');
INSERT INTO photos VALUES ('9034', '737', '1096', 'id9034.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1096.jpg');
INSERT INTO photos VALUES ('9035', '737', '1097', 'id9035.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1097.jpg');
INSERT INTO photos VALUES ('9036', '737', '1098', 'id9036.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1098.jpg');
INSERT INTO photos VALUES ('9037', '737', '1099', 'id9037.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1099.jpg');
INSERT INTO photos VALUES ('9038', '737', '1100', 'id9038.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1100.jpg');
INSERT INTO photos VALUES ('9039', '737', '1102', 'id9039.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1102.jpg');
INSERT INTO photos VALUES ('9040', '737', '1105', 'id9040.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1105.jpg');
INSERT INTO photos VALUES ('9041', '737', '1106', 'id9041.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1106.jpg');
INSERT INTO photos VALUES ('9042', '737', '1107', 'id9042.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1107.jpg');
INSERT INTO photos VALUES ('9043', '737', '1109', 'id9043.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1109.jpg');
INSERT INTO photos VALUES ('9044', '737', '1111', 'id9044.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1111.jpg');
INSERT INTO photos VALUES ('9045', '737', '1113', 'id9045.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1113.jpg');
INSERT INTO photos VALUES ('9046', '737', '1115', 'id9046.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1115.jpg');
INSERT INTO photos VALUES ('9047', '737', '1119', 'id9047.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1119.jpg');
INSERT INTO photos VALUES ('9048', '737', '1120', 'id9048.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1120.jpg');
INSERT INTO photos VALUES ('9049', '737', '1121', 'id9049.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1121.jpg');
INSERT INTO photos VALUES ('9050', '737', '1123', 'id9050.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1123.jpg');
INSERT INTO photos VALUES ('9051', '737', '1125', 'id9051.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1125.jpg');
INSERT INTO photos VALUES ('9052', '737', '1126', 'id9052.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1126.jpg');
INSERT INTO photos VALUES ('9053', '737', '1127', 'id9053.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1127.jpg');
INSERT INTO photos VALUES ('9054', '737', '1128', 'id9054.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1128.jpg');
INSERT INTO photos VALUES ('9055', '737', '1129', 'id9055.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1129.jpg');
INSERT INTO photos VALUES ('9056', '737', '1130', 'id9056.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1130.jpg');
INSERT INTO photos VALUES ('9057', '737', '1133', 'id9057.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1133.jpg');
INSERT INTO photos VALUES ('9058', '737', '1136', 'id9058.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1136.jpg');
INSERT INTO photos VALUES ('9059', '737', '1137', 'id9059.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1137.jpg');
INSERT INTO photos VALUES ('9060', '737', '1138', 'id9060.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1138.jpg');
INSERT INTO photos VALUES ('9061', '737', '1139', 'id9061.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1139.jpg');
INSERT INTO photos VALUES ('9062', '737', '1140', 'id9062.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1140.jpg');
INSERT INTO photos VALUES ('9063', '737', '1142', 'id9063.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1142.jpg');
INSERT INTO photos VALUES ('9064', '737', '1143', 'id9064.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1143.jpg');
INSERT INTO photos VALUES ('9065', '737', '1146', 'id9065.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1146.jpg');
INSERT INTO photos VALUES ('9066', '737', '1149', 'id9066.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1149.jpg');
INSERT INTO photos VALUES ('9067', '737', '1150', 'id9067.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1150.jpg');
INSERT INTO photos VALUES ('9068', '737', '1151', 'id9068.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1151.jpg');
INSERT INTO photos VALUES ('9069', '737', '1153', 'id9069.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1153.jpg');
INSERT INTO photos VALUES ('9070', '737', '1155', 'id9070.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1155.jpg');
INSERT INTO photos VALUES ('9071', '737', '1158', 'id9071.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1158.jpg');
INSERT INTO photos VALUES ('9072', '737', '1159', 'id9072.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1159.jpg');
INSERT INTO photos VALUES ('9073', '737', '1160', 'id9073.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1160.jpg');
INSERT INTO photos VALUES ('9074', '737', '1164', 'id9074.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1164.jpg');
INSERT INTO photos VALUES ('9075', '737', '1165', 'id9075.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1165.jpg');
INSERT INTO photos VALUES ('9076', '737', '1166', 'id9076.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1166.jpg');
INSERT INTO photos VALUES ('9077', '737', '1167', 'id9077.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1167.jpg');
INSERT INTO photos VALUES ('9078', '737', '1168', 'id9078.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1168.jpg');
INSERT INTO photos VALUES ('9079', '737', '1169', 'id9079.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1169.jpg');
INSERT INTO photos VALUES ('9080', '737', '1170', 'id9080.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1170.jpg');
INSERT INTO photos VALUES ('9081', '737', '1172', 'id9081.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1172.jpg');
INSERT INTO photos VALUES ('9082', '737', '1175', 'id9082.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1175.jpg');
INSERT INTO photos VALUES ('9083', '737', '1176', 'id9083.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1176.jpg');
INSERT INTO photos VALUES ('9084', '737', '1177', 'id9084.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1177.jpg');
INSERT INTO photos VALUES ('9085', '737', '1178', 'id9085.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1178.jpg');
INSERT INTO photos VALUES ('9086', '737', '1179', 'id9086.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1179.jpg');
INSERT INTO photos VALUES ('9087', '737', '1180', 'id9087.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1180.jpg');
INSERT INTO photos VALUES ('9088', '737', '1181', 'id9088.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1181.jpg');
INSERT INTO photos VALUES ('9089', '737', '1183', 'id9089.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1183.jpg');
INSERT INTO photos VALUES ('9090', '737', '1184', 'id9090.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1184.jpg');
INSERT INTO photos VALUES ('9091', '737', '1187', 'id9091.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1187.jpg');
INSERT INTO photos VALUES ('9092', '737', '1189', 'id9092.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1189.jpg');
INSERT INTO photos VALUES ('9093', '737', '1191', 'id9093.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1191.jpg');
INSERT INTO photos VALUES ('9094', '737', '1192', 'id9094.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1192.jpg');
INSERT INTO photos VALUES ('9095', '737', '1193', 'id9095.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1193.jpg');
INSERT INTO photos VALUES ('9096', '737', '1194', 'id9096.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1194.jpg');
INSERT INTO photos VALUES ('9097', '737', '1200', 'id9097.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1200.jpg');
INSERT INTO photos VALUES ('9098', '737', '1201', 'id9098.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1201.jpg');
INSERT INTO photos VALUES ('9099', '737', '1202', 'id9099.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1202.jpg');
INSERT INTO photos VALUES ('9100', '737', '1203', 'id9100.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1203.jpg');
INSERT INTO photos VALUES ('9101', '737', '1204', 'id9101.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1204.jpg');
INSERT INTO photos VALUES ('9102', '737', '1205', 'id9102.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1205.jpg');
INSERT INTO photos VALUES ('9103', '737', '1206', 'id9103.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1206.jpg');
INSERT INTO photos VALUES ('9104', '737', '1209', 'id9104.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1209.jpg');
INSERT INTO photos VALUES ('9105', '737', '1210', 'id9105.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1210.jpg');
INSERT INTO photos VALUES ('9106', '737', '1213', 'id9106.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1213.jpg');
INSERT INTO photos VALUES ('9107', '737', '1214', 'id9107.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1214.jpg');
INSERT INTO photos VALUES ('9108', '737', '1215', 'id9108.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1215.jpg');
INSERT INTO photos VALUES ('9109', '737', '1216', 'id9109.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1216.jpg');
INSERT INTO photos VALUES ('9110', '737', '1217', 'id9110.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1217.jpg');
INSERT INTO photos VALUES ('9111', '737', '1218', 'id9111.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1218.jpg');
INSERT INTO photos VALUES ('9112', '737', '1219', 'id9112.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1219.jpg');
INSERT INTO photos VALUES ('9113', '737', '1220', 'id9113.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1220.jpg');
INSERT INTO photos VALUES ('9114', '737', '1221', 'id9114.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1221.jpg');
INSERT INTO photos VALUES ('9115', '737', '1222', 'id9115.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1222.jpg');
INSERT INTO photos VALUES ('9116', '737', '1223', 'id9116.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1223.jpg');
INSERT INTO photos VALUES ('9117', '737', '1227', 'id9117.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1227.jpg');
INSERT INTO photos VALUES ('9118', '737', '1228', 'id9118.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1228.jpg');
INSERT INTO photos VALUES ('9119', '737', '1229', 'id9119.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1229.jpg');
INSERT INTO photos VALUES ('9120', '737', '1230', 'id9120.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1230.jpg');
INSERT INTO photos VALUES ('9121', '737', '1231', 'id9121.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1231.jpg');
INSERT INTO photos VALUES ('9122', '737', '1233', 'id9122.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1233.jpg');
INSERT INTO photos VALUES ('9123', '737', '1236', 'id9123.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1236.jpg');
INSERT INTO photos VALUES ('9124', '737', '1237', 'id9124.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1237.jpg');
INSERT INTO photos VALUES ('9125', '737', '1238', 'id9125.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1238.jpg');
INSERT INTO photos VALUES ('9126', '737', '1239', 'id9126.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1239.jpg');
INSERT INTO photos VALUES ('9127', '737', '1240', 'id9127.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1240.jpg');
INSERT INTO photos VALUES ('9128', '737', '1241', 'id9128.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1241.jpg');
INSERT INTO photos VALUES ('9129', '737', '1242', 'id9129.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1242.jpg');
INSERT INTO photos VALUES ('9130', '737', '1244', 'id9130.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1244.jpg');
INSERT INTO photos VALUES ('9131', '737', '1245', 'id9131.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1245.jpg');
INSERT INTO photos VALUES ('9132', '737', '1246', 'id9132.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1246.jpg');
INSERT INTO photos VALUES ('9133', '737', '1248', 'id9133.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1248.jpg');
INSERT INTO photos VALUES ('9134', '737', '1249', 'id9134.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1249.jpg');
INSERT INTO photos VALUES ('9135', '737', '1250', 'id9135.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1250.jpg');
INSERT INTO photos VALUES ('9136', '737', '1251', 'id9136.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1251.jpg');
INSERT INTO photos VALUES ('9137', '737', '1252', 'id9137.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1252.jpg');
INSERT INTO photos VALUES ('9138', '737', '1255', 'id9138.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1255.jpg');
INSERT INTO photos VALUES ('9139', '737', '1257', 'id9139.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1257.jpg');
INSERT INTO photos VALUES ('9140', '737', '1259', 'id9140.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1259.jpg');
INSERT INTO photos VALUES ('9141', '737', '1260', 'id9141.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1260.jpg');
INSERT INTO photos VALUES ('9142', '737', '1263', 'id9142.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1263.jpg');
INSERT INTO photos VALUES ('9143', '737', '1264', 'id9143.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1264.jpg');
INSERT INTO photos VALUES ('9144', '737', '1265', 'id9144.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1265.jpg');
INSERT INTO photos VALUES ('9145', '737', '1266', 'id9145.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1266.jpg');
INSERT INTO photos VALUES ('9146', '737', '1267', 'id9146.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1267.jpg');
INSERT INTO photos VALUES ('9147', '737', '1269', 'id9147.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1269.jpg');
INSERT INTO photos VALUES ('9148', '737', '1270', 'id9148.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1270.jpg');
INSERT INTO photos VALUES ('9149', '737', '1342', 'id9149.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1342.jpg');
INSERT INTO photos VALUES ('9150', '737', '1344', 'id9150.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1344.jpg');
INSERT INTO photos VALUES ('9151', '737', '1345', 'id9151.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1345.jpg');
INSERT INTO photos VALUES ('9152', '737', '1346', 'id9152.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1346.jpg');
INSERT INTO photos VALUES ('9153', '737', '1347', 'id9153.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1347.jpg');
INSERT INTO photos VALUES ('9154', '737', '1348', 'id9154.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1348.jpg');
INSERT INTO photos VALUES ('9155', '737', '1350', 'id9155.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1350.jpg');
INSERT INTO photos VALUES ('9156', '737', '1352', 'id9156.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1352.jpg');
INSERT INTO photos VALUES ('9157', '737', '1353', 'id9157.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1353.jpg');
INSERT INTO photos VALUES ('9158', '737', '1354', 'id9158.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1354.jpg');
INSERT INTO photos VALUES ('9159', '737', '1355', 'id9159.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1355.jpg');
INSERT INTO photos VALUES ('9160', '737', '1356', 'id9160.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1356.jpg');
INSERT INTO photos VALUES ('9161', '737', '1357', 'id9161.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1357.jpg');
INSERT INTO photos VALUES ('9162', '737', '1358', 'id9162.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1358.jpg');
INSERT INTO photos VALUES ('9163', '737', '1360', 'id9163.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1360.jpg');
INSERT INTO photos VALUES ('9164', '737', '1361', 'id9164.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1361.jpg');
INSERT INTO photos VALUES ('9165', '737', '1362', 'id9165.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1362.jpg');
INSERT INTO photos VALUES ('9166', '737', '1363', 'id9166.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1363.jpg');
INSERT INTO photos VALUES ('9167', '737', '1366', 'id9167.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1366.jpg');
INSERT INTO photos VALUES ('9168', '737', '1367', 'id9168.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1367.jpg');
INSERT INTO photos VALUES ('9169', '737', '1368', 'id9169.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1368.jpg');
INSERT INTO photos VALUES ('9170', '737', '1371', 'id9170.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1371.jpg');
INSERT INTO photos VALUES ('9171', '737', '1372', 'id9171.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1372.jpg');
INSERT INTO photos VALUES ('9172', '737', '1373', 'id9172.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1373.jpg');
INSERT INTO photos VALUES ('9173', '737', '1399', 'id9173.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1399.jpg');
INSERT INTO photos VALUES ('9174', '737', '1400', 'id9174.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1400.jpg');
INSERT INTO photos VALUES ('9175', '737', '1402', 'id9175.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1402.jpg');
INSERT INTO photos VALUES ('9176', '737', '1403', 'id9176.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1403.jpg');
INSERT INTO photos VALUES ('9177', '737', '1450', 'id9177.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1450.jpg');
INSERT INTO photos VALUES ('9178', '737', '1453', 'id9178.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1453.jpg');
INSERT INTO photos VALUES ('9179', '737', '1454', 'id9179.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1454.jpg');
INSERT INTO photos VALUES ('9180', '737', '1457', 'id9180.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1457.jpg');
INSERT INTO photos VALUES ('9181', '737', '1459', 'id9181.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1459.jpg');
INSERT INTO photos VALUES ('9182', '737', '1460', 'id9182.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1460.jpg');
INSERT INTO photos VALUES ('9183', '737', '1462', 'id9183.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1462.jpg');
INSERT INTO photos VALUES ('9184', '737', '1463', 'id9184.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1463.jpg');
INSERT INTO photos VALUES ('9185', '737', '1464', 'id9185.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1464.jpg');
INSERT INTO photos VALUES ('9186', '737', '1466', 'id9186.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1466.jpg');
INSERT INTO photos VALUES ('9187', '737', '1468', 'id9187.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1468.jpg');
INSERT INTO photos VALUES ('9188', '737', '1470', 'id9188.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1470.jpg');
INSERT INTO photos VALUES ('9189', '737', '1471', 'id9189.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1471.jpg');
INSERT INTO photos VALUES ('9190', '737', '1472', 'id9190.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1472.jpg');
INSERT INTO photos VALUES ('9191', '737', '1473', 'id9191.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1473.jpg');
INSERT INTO photos VALUES ('9192', '737', '1474', 'id9192.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1474.jpg');
INSERT INTO photos VALUES ('9193', '737', '1478', 'id9193.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1478.jpg');
INSERT INTO photos VALUES ('9194', '737', '1481', 'id9194.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1481.jpg');
INSERT INTO photos VALUES ('9195', '737', '1497', 'id9195.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1497.jpg');
INSERT INTO photos VALUES ('9196', '737', '1498', 'id9196.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1498.jpg');
INSERT INTO photos VALUES ('9197', '737', '1499', 'id9197.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1499.jpg');
INSERT INTO photos VALUES ('9198', '737', '1500', 'id9198.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1500.jpg');
INSERT INTO photos VALUES ('9199', '737', '1501', 'id9199.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1501.jpg');
INSERT INTO photos VALUES ('9200', '737', '1503', 'id9200.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1503.jpg');
INSERT INTO photos VALUES ('9201', '737', '1504', 'id9201.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1504.jpg');
INSERT INTO photos VALUES ('9202', '737', '1505', 'id9202.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1505.jpg');
INSERT INTO photos VALUES ('9203', '737', '1506', 'id9203.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1506.jpg');
INSERT INTO photos VALUES ('9204', '737', '1509', 'id9204.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1509.jpg');
INSERT INTO photos VALUES ('9205', '737', '1510', 'id9205.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1510.jpg');
INSERT INTO photos VALUES ('9206', '737', '1513', 'id9206.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1513.jpg');
INSERT INTO photos VALUES ('9207', '737', '1515', 'id9207.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1515.jpg');
INSERT INTO photos VALUES ('9208', '737', '1516', 'id9208.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1516.jpg');
INSERT INTO photos VALUES ('9209', '737', '1517', 'id9209.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1517.jpg');
INSERT INTO photos VALUES ('9210', '737', '1518', 'id9210.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1518.jpg');
INSERT INTO photos VALUES ('9211', '737', '1519', 'id9211.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1519.jpg');
INSERT INTO photos VALUES ('9212', '737', '1520', 'id9212.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1520.jpg');
INSERT INTO photos VALUES ('9213', '737', '1521', 'id9213.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1521.jpg');
INSERT INTO photos VALUES ('9214', '737', '1522', 'id9214.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1522.jpg');
INSERT INTO photos VALUES ('9215', '737', '1523', 'id9215.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1523.jpg');
INSERT INTO photos VALUES ('9216', '737', '1525', 'id9216.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1525.jpg');
INSERT INTO photos VALUES ('9217', '737', '1527', 'id9217.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1527.jpg');
INSERT INTO photos VALUES ('9218', '737', '1528', 'id9218.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1528.jpg');
INSERT INTO photos VALUES ('9219', '737', '1530', 'id9219.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1530.jpg');
INSERT INTO photos VALUES ('9220', '737', '1532', 'id9220.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1532.jpg');
INSERT INTO photos VALUES ('9221', '737', '1533', 'id9221.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1533.jpg');
INSERT INTO photos VALUES ('9222', '737', '1535', 'id9222.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1535.jpg');
INSERT INTO photos VALUES ('9223', '737', '1536', 'id9223.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1536.jpg');
INSERT INTO photos VALUES ('9224', '737', '1538', 'id9224.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1538.jpg');
INSERT INTO photos VALUES ('9225', '737', '1540', 'id9225.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1540.jpg');
INSERT INTO photos VALUES ('9226', '737', '1542', 'id9226.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1542.jpg');
INSERT INTO photos VALUES ('9227', '737', '1543', 'id9227.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1543.jpg');
INSERT INTO photos VALUES ('9228', '737', '1545', 'id9228.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1545.jpg');
INSERT INTO photos VALUES ('9229', '737', '1546', 'id9229.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1546.jpg');
INSERT INTO photos VALUES ('9230', '737', '1548', 'id9230.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1548.jpg');
INSERT INTO photos VALUES ('9231', '737', '1549', 'id9231.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1549.jpg');
INSERT INTO photos VALUES ('9232', '737', '1550', 'id9232.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1550.jpg');
INSERT INTO photos VALUES ('9233', '737', '1551', 'id9233.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1551.jpg');
INSERT INTO photos VALUES ('9234', '737', '1552', 'id9234.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1552.jpg');
INSERT INTO photos VALUES ('9235', '737', '1553', 'id9235.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1553.jpg');
INSERT INTO photos VALUES ('9236', '737', '1555', 'id9236.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1555.jpg');
INSERT INTO photos VALUES ('9237', '737', '1557', 'id9237.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1557.jpg');
INSERT INTO photos VALUES ('9238', '737', '1558', 'id9238.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1558.jpg');
INSERT INTO photos VALUES ('9239', '737', '1559', 'id9239.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1559.jpg');
INSERT INTO photos VALUES ('9240', '737', '1560', 'id9240.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1560.jpg');
INSERT INTO photos VALUES ('9241', '737', '1561', 'id9241.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1561.jpg');
INSERT INTO photos VALUES ('9242', '737', '1562', 'id9242.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1562.jpg');
INSERT INTO photos VALUES ('9243', '737', '1563', 'id9243.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1563.jpg');
INSERT INTO photos VALUES ('9244', '737', '1564', 'id9244.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1564.jpg');
INSERT INTO photos VALUES ('9245', '737', '1565', 'id9245.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1565.jpg');
INSERT INTO photos VALUES ('9246', '737', '1568', 'id9246.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1568.jpg');
INSERT INTO photos VALUES ('9247', '737', '1569', 'id9247.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1569.jpg');
INSERT INTO photos VALUES ('9248', '737', '1570', 'id9248.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1570.jpg');
INSERT INTO photos VALUES ('9249', '737', '1571', 'id9249.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1571.jpg');
INSERT INTO photos VALUES ('9250', '737', '1572', 'id9250.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1572.jpg');
INSERT INTO photos VALUES ('9251', '737', '1573', 'id9251.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1573.jpg');
INSERT INTO photos VALUES ('9252', '737', '1574', 'id9252.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1574.jpg');
INSERT INTO photos VALUES ('9253', '737', '1575', 'id9253.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1575.jpg');
INSERT INTO photos VALUES ('9254', '737', '1576', 'id9254.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1576.jpg');
INSERT INTO photos VALUES ('9255', '737', '1577', 'id9255.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1577.jpg');
INSERT INTO photos VALUES ('9256', '737', '1578', 'id9256.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1578.jpg');
INSERT INTO photos VALUES ('9257', '737', '1579', 'id9257.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1579.jpg');
INSERT INTO photos VALUES ('9258', '737', '1580', 'id9258.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1580.jpg');
INSERT INTO photos VALUES ('9259', '737', '1581', 'id9259.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1581.jpg');
INSERT INTO photos VALUES ('9260', '737', '1582', 'id9260.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1582.jpg');
INSERT INTO photos VALUES ('9261', '737', '1585', 'id9261.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1585.jpg');
INSERT INTO photos VALUES ('9262', '737', '1588', 'id9262.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1588.jpg');
INSERT INTO photos VALUES ('9263', '737', '1591', 'id9263.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1591.jpg');
INSERT INTO photos VALUES ('9264', '737', '1594', 'id9264.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1594.jpg');
INSERT INTO photos VALUES ('9265', '737', '1595', 'id9265.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1595.jpg');
INSERT INTO photos VALUES ('9266', '737', '1596', 'id9266.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1596.jpg');
INSERT INTO photos VALUES ('9267', '737', '1597', 'id9267.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1597.jpg');
INSERT INTO photos VALUES ('9268', '737', '1598', 'id9268.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1598.jpg');
INSERT INTO photos VALUES ('9269', '737', '1601', 'id9269.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1601.jpg');
INSERT INTO photos VALUES ('9270', '737', '1602', 'id9270.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1602.jpg');
INSERT INTO photos VALUES ('9271', '737', '1603', 'id9271.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1603.jpg');
INSERT INTO photos VALUES ('9272', '737', '1604', 'id9272.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1604.jpg');
INSERT INTO photos VALUES ('9273', '737', '1605', 'id9273.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1605.jpg');
INSERT INTO photos VALUES ('9274', '737', '1610', 'id9274.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1610.jpg');
INSERT INTO photos VALUES ('9275', '737', '1611', 'id9275.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1611.jpg');
INSERT INTO photos VALUES ('9276', '737', '1612', 'id9276.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1612.jpg');
INSERT INTO photos VALUES ('9277', '737', '1613', 'id9277.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1613.jpg');
INSERT INTO photos VALUES ('9278', '737', '1614', 'id9278.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1614.jpg');
INSERT INTO photos VALUES ('9279', '737', '1616', 'id9279.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1616.jpg');
INSERT INTO photos VALUES ('9280', '737', '1617', 'id9280.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1617.jpg');
INSERT INTO photos VALUES ('9281', '737', '1618', 'id9281.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1618.jpg');
INSERT INTO photos VALUES ('9282', '737', '1621', 'id9282.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1621.jpg');
INSERT INTO photos VALUES ('9283', '737', '1624', 'id9283.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1624.jpg');
INSERT INTO photos VALUES ('9284', '737', '1628', 'id9284.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1628.jpg');
INSERT INTO photos VALUES ('9285', '737', '1630', 'id9285.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1630.jpg');
INSERT INTO photos VALUES ('9286', '737', '1631', 'id9286.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1631.jpg');
INSERT INTO photos VALUES ('9287', '737', '1632', 'id9287.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1632.jpg');
INSERT INTO photos VALUES ('9288', '737', '1633', 'id9288.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1633.jpg');
INSERT INTO photos VALUES ('9289', '737', '1634', 'id9289.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1634.jpg');
INSERT INTO photos VALUES ('9290', '737', '1635', 'id9290.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1635.jpg');
INSERT INTO photos VALUES ('9291', '737', '1638', 'id9291.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1638.jpg');
INSERT INTO photos VALUES ('9292', '737', '1639', 'id9292.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1639.jpg');
INSERT INTO photos VALUES ('9293', '737', '1643', 'id9293.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1643.jpg');
INSERT INTO photos VALUES ('9294', '737', '1644', 'id9294.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1644.jpg');
INSERT INTO photos VALUES ('9295', '737', '1645', 'id9295.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1645.jpg');
INSERT INTO photos VALUES ('9296', '737', '1652', 'id9296.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1652.jpg');
INSERT INTO photos VALUES ('9297', '737', '1653', 'id9297.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1653.jpg');
INSERT INTO photos VALUES ('9298', '737', '1654', 'id9298.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1654.jpg');
INSERT INTO photos VALUES ('9299', '737', '1655', 'id9299.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1655.jpg');
INSERT INTO photos VALUES ('9300', '737', '1657', 'id9300.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1657.jpg');
INSERT INTO photos VALUES ('9301', '737', '1658', 'id9301.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1658.jpg');
INSERT INTO photos VALUES ('9302', '737', '1659', 'id9302.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1659.jpg');
INSERT INTO photos VALUES ('9303', '737', '1663', 'id9303.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1663.jpg');
INSERT INTO photos VALUES ('9304', '737', '1664', 'id9304.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1664.jpg');
INSERT INTO photos VALUES ('9305', '737', '1666', 'id9305.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1666.jpg');
INSERT INTO photos VALUES ('9306', '737', '1667', 'id9306.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1667.jpg');
INSERT INTO photos VALUES ('9307', '737', '1668', 'id9307.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1668.jpg');
INSERT INTO photos VALUES ('9308', '737', '1669', 'id9308.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1669.jpg');
INSERT INTO photos VALUES ('9309', '737', '1671', 'id9309.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1671.jpg');
INSERT INTO photos VALUES ('9310', '737', '1672', 'id9310.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1672.jpg');
INSERT INTO photos VALUES ('9311', '737', '1676', 'id9311.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1676.jpg');
INSERT INTO photos VALUES ('9312', '737', '1677', 'id9312.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1677.jpg');
INSERT INTO photos VALUES ('9313', '737', '1678', 'id9313.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1678.jpg');
INSERT INTO photos VALUES ('9314', '737', '1679', 'id9314.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1679.jpg');
INSERT INTO photos VALUES ('9315', '737', '1680', 'id9315.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1680.jpg');
INSERT INTO photos VALUES ('9316', '737', '1681', 'id9316.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1681.jpg');
INSERT INTO photos VALUES ('9317', '737', '1682', 'id9317.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1682.jpg');
INSERT INTO photos VALUES ('9318', '737', '1685', 'id9318.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1685.jpg');
INSERT INTO photos VALUES ('9319', '737', '1686', 'id9319.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1686.jpg');
INSERT INTO photos VALUES ('9320', '737', '1690', 'id9320.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1690.jpg');
INSERT INTO photos VALUES ('9321', '737', '1693', 'id9321.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1693.jpg');
INSERT INTO photos VALUES ('9322', '737', '1694', 'id9322.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1694.jpg');
INSERT INTO photos VALUES ('9323', '737', '1696', 'id9323.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1696.jpg');
INSERT INTO photos VALUES ('9324', '737', '1697', 'id9324.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1697.jpg');
INSERT INTO photos VALUES ('9325', '737', '1698', 'id9325.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1698.jpg');
INSERT INTO photos VALUES ('9326', '737', '1699', 'id9326.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1699.jpg');
INSERT INTO photos VALUES ('9327', '737', '1701', 'id9327.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1701.jpg');
INSERT INTO photos VALUES ('9328', '737', '1702', 'id9328.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1702.jpg');
INSERT INTO photos VALUES ('9329', '737', '1785', 'id9329.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1785.jpg');
INSERT INTO photos VALUES ('9330', '737', '1786', 'id9330.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1786.jpg');
INSERT INTO photos VALUES ('9331', '737', '1788', 'id9331.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1788.jpg');
INSERT INTO photos VALUES ('9332', '737', '1789', 'id9332.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1789.jpg');
INSERT INTO photos VALUES ('9333', '737', '1790', 'id9333.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1790.jpg');
INSERT INTO photos VALUES ('9334', '737', '1791', 'id9334.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1791.jpg');
INSERT INTO photos VALUES ('9335', '737', '1792', 'id9335.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1792.jpg');
INSERT INTO photos VALUES ('9336', '737', '1793', 'id9336.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1793.jpg');
INSERT INTO photos VALUES ('9337', '737', '1794', 'id9337.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1794.jpg');
INSERT INTO photos VALUES ('9338', '737', '1795', 'id9338.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1795.jpg');
INSERT INTO photos VALUES ('9339', '737', '1798', 'id9339.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1798.jpg');
INSERT INTO photos VALUES ('9340', '737', '1799', 'id9340.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1799.jpg');
INSERT INTO photos VALUES ('9341', '737', '1800', 'id9341.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1800.jpg');
INSERT INTO photos VALUES ('9342', '737', '1801', 'id9342.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1801.jpg');
INSERT INTO photos VALUES ('9343', '737', '1803', 'id9343.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1803.jpg');
INSERT INTO photos VALUES ('9344', '737', '1804', 'id9344.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1804.jpg');
INSERT INTO photos VALUES ('9345', '737', '1805', 'id9345.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1805.jpg');
INSERT INTO photos VALUES ('9346', '737', '1806', 'id9346.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1806.jpg');
INSERT INTO photos VALUES ('9347', '737', '1807', 'id9347.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1807.jpg');
INSERT INTO photos VALUES ('9348', '737', '1809', 'id9348.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1809.jpg');
INSERT INTO photos VALUES ('9349', '737', '1810', 'id9349.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1810.jpg');
INSERT INTO photos VALUES ('9350', '737', '1811', 'id9350.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1811.jpg');
INSERT INTO photos VALUES ('9351', '737', '1812', 'id9351.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1812.jpg');
INSERT INTO photos VALUES ('9352', '737', '1813', 'id9352.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1813.jpg');
INSERT INTO photos VALUES ('9353', '737', '1814', 'id9353.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1814.jpg');
INSERT INTO photos VALUES ('9354', '737', '1815', 'id9354.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1815.jpg');
INSERT INTO photos VALUES ('9355', '737', '1816', 'id9355.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1816.jpg');
INSERT INTO photos VALUES ('9356', '737', '1817', 'id9356.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1817.jpg');
INSERT INTO photos VALUES ('9357', '737', '1818', 'id9357.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1818.jpg');
INSERT INTO photos VALUES ('9358', '737', '1819', 'id9358.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1819.jpg');
INSERT INTO photos VALUES ('9359', '737', '1820', 'id9359.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1820.jpg');
INSERT INTO photos VALUES ('9360', '737', '1821', 'id9360.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1821.jpg');
INSERT INTO photos VALUES ('9361', '737', '1822', 'id9361.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1822.jpg');
INSERT INTO photos VALUES ('9362', '737', '1824', 'id9362.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1824.jpg');
INSERT INTO photos VALUES ('9363', '737', '1826', 'id9363.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1826.jpg');
INSERT INTO photos VALUES ('9364', '737', '1828', 'id9364.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1828.jpg');
INSERT INTO photos VALUES ('9365', '737', '1829', 'id9365.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1829.jpg');
INSERT INTO photos VALUES ('9366', '737', '1830', 'id9366.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1830.jpg');
INSERT INTO photos VALUES ('9367', '737', '1833', 'id9367.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1833.jpg');
INSERT INTO photos VALUES ('9368', '737', '1834', 'id9368.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1834.jpg');
INSERT INTO photos VALUES ('9369', '737', '1835', 'id9369.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1835.jpg');
INSERT INTO photos VALUES ('9370', '737', '1836', 'id9370.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1836.jpg');
INSERT INTO photos VALUES ('9371', '737', '1837', 'id9371.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1837.jpg');
INSERT INTO photos VALUES ('9372', '737', '1838', 'id9372.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1838.jpg');
INSERT INTO photos VALUES ('9373', '737', '1840', 'id9373.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1840.jpg');
INSERT INTO photos VALUES ('9374', '737', '1841', 'id9374.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1841.jpg');
INSERT INTO photos VALUES ('9375', '737', '1842', 'id9375.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1842.jpg');
INSERT INTO photos VALUES ('9376', '737', '1844', 'id9376.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1844.jpg');
INSERT INTO photos VALUES ('9377', '737', '1845', 'id9377.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1845.jpg');
INSERT INTO photos VALUES ('9378', '737', '1846', 'id9378.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1846.jpg');
INSERT INTO photos VALUES ('9379', '737', '1847', 'id9379.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1847.jpg');
INSERT INTO photos VALUES ('9380', '737', '1848', 'id9380.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1848.jpg');
INSERT INTO photos VALUES ('9381', '737', '1849', 'id9381.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1849.jpg');
INSERT INTO photos VALUES ('9382', '737', '1850', 'id9382.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1850.jpg');
INSERT INTO photos VALUES ('9383', '737', '1874', 'id9383.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1874.jpg');
INSERT INTO photos VALUES ('9384', '737', '1875', 'id9384.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1875.jpg');
INSERT INTO photos VALUES ('9385', '737', '1876', 'id9385.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1876.jpg');
INSERT INTO photos VALUES ('9386', '737', '1877', 'id9386.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1877.jpg');
INSERT INTO photos VALUES ('9387', '737', '1878', 'id9387.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1878.jpg');
INSERT INTO photos VALUES ('9388', '737', '1879', 'id9388.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1879.jpg');
INSERT INTO photos VALUES ('9389', '737', '1880', 'id9389.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1880.jpg');
INSERT INTO photos VALUES ('9390', '737', '1881', 'id9390.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1881.jpg');
INSERT INTO photos VALUES ('9391', '737', '1882', 'id9391.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1882.jpg');
INSERT INTO photos VALUES ('9392', '737', '1883', 'id9392.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1883.jpg');
INSERT INTO photos VALUES ('9393', '737', '1885', 'id9393.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1885.jpg');
INSERT INTO photos VALUES ('9394', '737', '1886', 'id9394.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1886.jpg');
INSERT INTO photos VALUES ('9395', '737', '1887', 'id9395.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1887.jpg');
INSERT INTO photos VALUES ('9396', '737', '1888', 'id9396.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1888.jpg');
INSERT INTO photos VALUES ('9397', '737', '1889', 'id9397.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1889.jpg');
INSERT INTO photos VALUES ('9398', '737', '1890', 'id9398.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1890.jpg');
INSERT INTO photos VALUES ('9399', '737', '1892', 'id9399.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1892.jpg');
INSERT INTO photos VALUES ('9400', '737', '1893', 'id9400.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1893.jpg');
INSERT INTO photos VALUES ('9401', '737', '1894', 'id9401.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1894.jpg');
INSERT INTO photos VALUES ('9402', '737', '1895', 'id9402.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1895.jpg');
INSERT INTO photos VALUES ('9403', '737', '1898', 'id9403.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1898.jpg');
INSERT INTO photos VALUES ('9404', '737', '1899', 'id9404.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1899.jpg');
INSERT INTO photos VALUES ('9405', '737', '1903', 'id9405.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1903.jpg');
INSERT INTO photos VALUES ('9406', '737', '1905', 'id9406.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1905.jpg');
INSERT INTO photos VALUES ('9407', '737', '1953', 'id9407.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1953.jpg');
INSERT INTO photos VALUES ('9408', '737', '1954', 'id9408.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1954.jpg');
INSERT INTO photos VALUES ('9409', '737', '1955', 'id9409.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1955.jpg');
INSERT INTO photos VALUES ('9410', '737', '1956', 'id9410.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1956.jpg');
INSERT INTO photos VALUES ('9411', '737', '1957', 'id9411.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1957.jpg');
INSERT INTO photos VALUES ('9412', '737', '1960', 'id9412.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1960.jpg');
INSERT INTO photos VALUES ('9413', '737', '1961', 'id9413.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1961.jpg');
INSERT INTO photos VALUES ('9414', '737', '1962', 'id9414.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1962.jpg');
INSERT INTO photos VALUES ('9415', '737', '1964', 'id9415.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1964.jpg');
INSERT INTO photos VALUES ('9416', '737', '1965', 'id9416.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1965.jpg');
INSERT INTO photos VALUES ('9417', '737', '1966', 'id9417.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1966.jpg');
INSERT INTO photos VALUES ('9418', '737', '1967', 'id9418.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1967.jpg');
INSERT INTO photos VALUES ('9419', '737', '1968', 'id9419.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1968.jpg');
INSERT INTO photos VALUES ('9420', '737', '1970', 'id9420.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1970.jpg');
INSERT INTO photos VALUES ('9421', '737', '1971', 'id9421.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1971.jpg');
INSERT INTO photos VALUES ('9422', '737', '1972', 'id9422.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1972.jpg');
INSERT INTO photos VALUES ('9423', '737', '1974', 'id9423.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1974.jpg');
INSERT INTO photos VALUES ('9424', '737', '1975', 'id9424.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1975.jpg');
INSERT INTO photos VALUES ('9425', '737', '1976', 'id9425.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1976.jpg');
INSERT INTO photos VALUES ('9426', '737', '1977', 'id9426.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1977.jpg');
INSERT INTO photos VALUES ('9427', '737', '1979', 'id9427.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1979.jpg');
INSERT INTO photos VALUES ('9428', '737', '1980', 'id9428.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1980.jpg');
INSERT INTO photos VALUES ('9429', '737', '1982', 'id9429.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1982.jpg');
INSERT INTO photos VALUES ('9430', '737', '1983', 'id9430.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1983.jpg');
INSERT INTO photos VALUES ('9431', '737', '1985', 'id9431.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1985.jpg');
INSERT INTO photos VALUES ('9432', '737', '1986', 'id9432.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1986.jpg');
INSERT INTO photos VALUES ('9433', '737', '1987', 'id9433.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1987.jpg');
INSERT INTO photos VALUES ('9434', '737', '1988', 'id9434.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1988.jpg');
INSERT INTO photos VALUES ('9435', '737', '1989', 'id9435.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1989.jpg');
INSERT INTO photos VALUES ('9436', '737', '1990', 'id9436.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1990.jpg');
INSERT INTO photos VALUES ('9437', '737', '1992', 'id9437.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1992.jpg');
INSERT INTO photos VALUES ('9438', '737', '1993', 'id9438.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1993.jpg');
INSERT INTO photos VALUES ('9439', '737', '1994', 'id9439.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1994.jpg');
INSERT INTO photos VALUES ('9440', '737', '1995', 'id9440.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1995.jpg');
INSERT INTO photos VALUES ('9441', '737', '1997', 'id9441.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1997.jpg');
INSERT INTO photos VALUES ('9442', '737', '1998', 'id9442.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1998.jpg');
INSERT INTO photos VALUES ('9443', '737', '1999', 'id9443.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/1999.jpg');
INSERT INTO photos VALUES ('9444', '737', '2000', 'id9444.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2000.jpg');
INSERT INTO photos VALUES ('9445', '737', '2001', 'id9445.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2001.jpg');
INSERT INTO photos VALUES ('9446', '737', '2002', 'id9446.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2002.jpg');
INSERT INTO photos VALUES ('9447', '737', '2004', 'id9447.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2004.jpg');
INSERT INTO photos VALUES ('9448', '737', '2005', 'id9448.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2005.jpg');
INSERT INTO photos VALUES ('9449', '737', '2006', 'id9449.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2006.jpg');
INSERT INTO photos VALUES ('9450', '737', '2007', 'id9450.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2007.jpg');
INSERT INTO photos VALUES ('9451', '737', '2008', 'id9451.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2008.jpg');
INSERT INTO photos VALUES ('9452', '737', '2009', 'id9452.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2009.jpg');
INSERT INTO photos VALUES ('9453', '737', '2010', 'id9453.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2010.jpg');
INSERT INTO photos VALUES ('9454', '737', '2011', 'id9454.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2011.jpg');
INSERT INTO photos VALUES ('9455', '737', '2012', 'id9455.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2012.jpg');
INSERT INTO photos VALUES ('9456', '737', '2013', 'id9456.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2013.jpg');
INSERT INTO photos VALUES ('9457', '737', '2014', 'id9457.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2014.jpg');
INSERT INTO photos VALUES ('9458', '737', '2016', 'id9458.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2016.jpg');
INSERT INTO photos VALUES ('9459', '737', '2020', 'id9459.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2020.jpg');
INSERT INTO photos VALUES ('9460', '737', '2021', 'id9460.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2021.jpg');
INSERT INTO photos VALUES ('9461', '737', '2040', 'id9461.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2040.jpg');
INSERT INTO photos VALUES ('9462', '737', '2041', 'id9462.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2041.jpg');
INSERT INTO photos VALUES ('9463', '737', '2042', 'id9463.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2042.jpg');
INSERT INTO photos VALUES ('9464', '737', '2043', 'id9464.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2043.jpg');
INSERT INTO photos VALUES ('9465', '737', '2045', 'id9465.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2045.jpg');
INSERT INTO photos VALUES ('9466', '737', '2046', 'id9466.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2046.jpg');
INSERT INTO photos VALUES ('9467', '737', '2047', 'id9467.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2047.jpg');
INSERT INTO photos VALUES ('9468', '737', '2048', 'id9468.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2048.jpg');
INSERT INTO photos VALUES ('9469', '737', '2049', 'id9469.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2049.jpg');
INSERT INTO photos VALUES ('9470', '737', '2050', 'id9470.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2050.jpg');
INSERT INTO photos VALUES ('9471', '737', '2051', 'id9471.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2051.jpg');
INSERT INTO photos VALUES ('9472', '737', '2054', 'id9472.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2054.jpg');
INSERT INTO photos VALUES ('9473', '737', '2056', 'id9473.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2056.jpg');
INSERT INTO photos VALUES ('9474', '737', '2057', 'id9474.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2057.jpg');
INSERT INTO photos VALUES ('9475', '737', '2058', 'id9475.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2058.jpg');
INSERT INTO photos VALUES ('9476', '737', '2059', 'id9476.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2059.jpg');
INSERT INTO photos VALUES ('9477', '737', '2060', 'id9477.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2060.jpg');
INSERT INTO photos VALUES ('9478', '737', '2061', 'id9478.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2061.jpg');
INSERT INTO photos VALUES ('9479', '737', '2063', 'id9479.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2063.jpg');
INSERT INTO photos VALUES ('9480', '737', '2066', 'id9480.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2066.jpg');
INSERT INTO photos VALUES ('9481', '737', '2067', 'id9481.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2067.jpg');
INSERT INTO photos VALUES ('9482', '737', '2068', 'id9482.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2068.jpg');
INSERT INTO photos VALUES ('9483', '737', '2069', 'id9483.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2069.jpg');
INSERT INTO photos VALUES ('9484', '737', '2070', 'id9484.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2070.jpg');
INSERT INTO photos VALUES ('9485', '737', '2071', 'id9485.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2071.jpg');
INSERT INTO photos VALUES ('9486', '737', '2073', 'id9486.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2073.jpg');
INSERT INTO photos VALUES ('9487', '737', '2074', 'id9487.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2074.jpg');
INSERT INTO photos VALUES ('9488', '737', '2075', 'id9488.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2075.jpg');
INSERT INTO photos VALUES ('9489', '737', '2076', 'id9489.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2076.jpg');
INSERT INTO photos VALUES ('9490', '737', '2078', 'id9490.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2078.jpg');
INSERT INTO photos VALUES ('9491', '737', '2079', 'id9491.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2079.jpg');
INSERT INTO photos VALUES ('9492', '737', '2080', 'id9492.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2080.jpg');
INSERT INTO photos VALUES ('9493', '737', '2081', 'id9493.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2081.jpg');
INSERT INTO photos VALUES ('9494', '737', '2082', 'id9494.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2082.jpg');
INSERT INTO photos VALUES ('9495', '737', '2083', 'id9495.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2083.jpg');
INSERT INTO photos VALUES ('9496', '737', '2084', 'id9496.jpg', '16', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2084.jpg');
INSERT INTO photos VALUES ('9497', '737', '2085', 'id9497.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2085.jpg');
INSERT INTO photos VALUES ('9498', '737', '2088', 'id9498.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2088.jpg');
INSERT INTO photos VALUES ('9499', '737', '2089', 'id9499.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2089.jpg');
INSERT INTO photos VALUES ('9500', '737', '2090', 'id9500.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2090.jpg');
INSERT INTO photos VALUES ('9501', '737', '2091', 'id9501.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2091.jpg');
INSERT INTO photos VALUES ('9502', '737', '2092', 'id9502.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2092.jpg');
INSERT INTO photos VALUES ('9503', '737', '2093', 'id9503.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2093.jpg');
INSERT INTO photos VALUES ('9504', '737', '2094', 'id9504.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2094.jpg');
INSERT INTO photos VALUES ('9505', '737', '2096', 'id9505.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2096.jpg');
INSERT INTO photos VALUES ('9506', '737', '2100', 'id9506.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2100.jpg');
INSERT INTO photos VALUES ('9507', '737', '2101', 'id9507.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2101.jpg');
INSERT INTO photos VALUES ('9508', '737', '2102', 'id9508.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2102.jpg');
INSERT INTO photos VALUES ('9509', '737', '2103', 'id9509.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2103.jpg');
INSERT INTO photos VALUES ('9510', '737', '2104', 'id9510.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2104.jpg');
INSERT INTO photos VALUES ('9511', '737', '2106', 'id9511.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2106.jpg');
INSERT INTO photos VALUES ('9512', '737', '2107', 'id9512.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2107.jpg');
INSERT INTO photos VALUES ('9513', '737', '2108', 'id9513.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2108.jpg');
INSERT INTO photos VALUES ('9514', '737', '2109', 'id9514.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2109.jpg');
INSERT INTO photos VALUES ('9515', '737', '2112', 'id9515.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2112.jpg');
INSERT INTO photos VALUES ('9516', '737', '2113', 'id9516.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2113.jpg');
INSERT INTO photos VALUES ('9517', '737', '2114', 'id9517.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2114.jpg');
INSERT INTO photos VALUES ('9518', '737', '2115', 'id9518.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2115.jpg');
INSERT INTO photos VALUES ('9519', '737', '2116', 'id9519.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2116.jpg');
INSERT INTO photos VALUES ('9520', '737', '2117', 'id9520.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2117.jpg');
INSERT INTO photos VALUES ('9521', '737', '2118', 'id9521.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2118.jpg');
INSERT INTO photos VALUES ('9522', '737', '2119', 'id9522.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2119.jpg');
INSERT INTO photos VALUES ('9523', '737', '2121', 'id9523.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2121.jpg');
INSERT INTO photos VALUES ('9524', '737', '2122', 'id9524.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2122.jpg');
INSERT INTO photos VALUES ('9525', '737', '2123', 'id9525.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2123.jpg');
INSERT INTO photos VALUES ('9526', '737', '2124', 'id9526.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2124.jpg');
INSERT INTO photos VALUES ('9527', '737', '2125', 'id9527.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2125.jpg');
INSERT INTO photos VALUES ('9528', '737', '2126', 'id9528.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2126.jpg');
INSERT INTO photos VALUES ('9529', '737', '2127', 'id9529.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2127.jpg');
INSERT INTO photos VALUES ('9530', '737', '2128', 'id9530.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2128.jpg');
INSERT INTO photos VALUES ('9531', '737', '2129', 'id9531.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2129.jpg');
INSERT INTO photos VALUES ('9532', '737', '2130', 'id9532.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2130.jpg');
INSERT INTO photos VALUES ('9533', '737', '2131', 'id9533.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2131.jpg');
INSERT INTO photos VALUES ('9534', '737', '2132', 'id9534.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2132.jpg');
INSERT INTO photos VALUES ('9535', '737', '2133', 'id9535.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2133.jpg');
INSERT INTO photos VALUES ('9536', '737', '2134', 'id9536.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2134.jpg');
INSERT INTO photos VALUES ('9537', '737', '2135', 'id9537.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2135.jpg');
INSERT INTO photos VALUES ('9538', '737', '2136', 'id9538.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2136.jpg');
INSERT INTO photos VALUES ('9539', '737', '2156', 'id9539.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2156.jpg');
INSERT INTO photos VALUES ('9540', '737', '2157', 'id9540.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2157.jpg');
INSERT INTO photos VALUES ('9541', '737', '2158', 'id9541.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2158.jpg');
INSERT INTO photos VALUES ('9542', '737', '2159', 'id9542.jpg', '12', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2159.jpg');
INSERT INTO photos VALUES ('9543', '737', '2160', 'id9543.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2160.jpg');
INSERT INTO photos VALUES ('9544', '737', '2161', 'id9544.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2161.jpg');
INSERT INTO photos VALUES ('9545', '737', '2162', 'id9545.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2162.jpg');
INSERT INTO photos VALUES ('9546', '737', '2163', 'id9546.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2163.jpg');
INSERT INTO photos VALUES ('9547', '737', '2164', 'id9547.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2164.jpg');
INSERT INTO photos VALUES ('9548', '737', '2167', 'id9548.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2167.jpg');
INSERT INTO photos VALUES ('9549', '737', '2168', 'id9549.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2168.jpg');
INSERT INTO photos VALUES ('9550', '737', '2169', 'id9550.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2169.jpg');
INSERT INTO photos VALUES ('9551', '737', '2170', 'id9551.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2170.jpg');
INSERT INTO photos VALUES ('9552', '737', '2171', 'id9552.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2171.jpg');
INSERT INTO photos VALUES ('9553', '737', '2172', 'id9553.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2172.jpg');
INSERT INTO photos VALUES ('9554', '737', '2173', 'id9554.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2173.jpg');
INSERT INTO photos VALUES ('9555', '737', '2174', 'id9555.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2174.jpg');
INSERT INTO photos VALUES ('9556', '737', '2175', 'id9556.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2175.jpg');
INSERT INTO photos VALUES ('9557', '737', '2195', 'id9557.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2195.jpg');
INSERT INTO photos VALUES ('9558', '737', '2196', 'id9558.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2196.jpg');
INSERT INTO photos VALUES ('9559', '737', '2197', 'id9559.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2197.jpg');
INSERT INTO photos VALUES ('9560', '737', '2198', 'id9560.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2198.jpg');
INSERT INTO photos VALUES ('9561', '737', '2199', 'id9561.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2199.jpg');
INSERT INTO photos VALUES ('9562', '737', '2201', 'id9562.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2201.jpg');
INSERT INTO photos VALUES ('9563', '737', '2202', 'id9563.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2202.jpg');
INSERT INTO photos VALUES ('9564', '737', '2203', 'id9564.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2203.jpg');
INSERT INTO photos VALUES ('9565', '737', '2204', 'id9565.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2204.jpg');
INSERT INTO photos VALUES ('9566', '737', '2205', 'id9566.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2205.jpg');
INSERT INTO photos VALUES ('9567', '737', '2206', 'id9567.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2206.jpg');
INSERT INTO photos VALUES ('9568', '737', '2207', 'id9568.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2207.jpg');
INSERT INTO photos VALUES ('9569', '737', '2208', 'id9569.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2208.jpg');
INSERT INTO photos VALUES ('9570', '737', '2209', 'id9570.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2209.jpg');
INSERT INTO photos VALUES ('9571', '737', '2210', 'id9571.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2210.jpg');
INSERT INTO photos VALUES ('9572', '737', '2211', 'id9572.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2211.jpg');
INSERT INTO photos VALUES ('9573', '737', '2212', 'id9573.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2212.jpg');
INSERT INTO photos VALUES ('9574', '737', '2213', 'id9574.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2213.jpg');
INSERT INTO photos VALUES ('9575', '737', '2214', 'id9575.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2214.jpg');
INSERT INTO photos VALUES ('9576', '737', '2215', 'id9576.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2215.jpg');
INSERT INTO photos VALUES ('9577', '737', '2216', 'id9577.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2216.jpg');
INSERT INTO photos VALUES ('9578', '737', '2217', 'id9578.jpg', '9', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2217.jpg');
INSERT INTO photos VALUES ('9579', '737', '2218', 'id9579.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2218.jpg');
INSERT INTO photos VALUES ('9580', '737', '2219', 'id9580.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2219.jpg');
INSERT INTO photos VALUES ('9581', '737', '2220', 'id9581.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2220.jpg');
INSERT INTO photos VALUES ('9582', '737', '2221', 'id9582.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2221.jpg');
INSERT INTO photos VALUES ('9583', '737', '2222', 'id9583.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2222.jpg');
INSERT INTO photos VALUES ('9584', '737', '2223', 'id9584.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2223.jpg');
INSERT INTO photos VALUES ('9585', '737', '2224', 'id9585.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2224.jpg');
INSERT INTO photos VALUES ('9586', '737', '2225', 'id9586.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2225.jpg');
INSERT INTO photos VALUES ('9587', '737', '2226', 'id9587.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2226.jpg');
INSERT INTO photos VALUES ('9588', '737', '2227', 'id9588.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2227.jpg');
INSERT INTO photos VALUES ('9589', '737', '2239', 'id9589.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2239.jpg');
INSERT INTO photos VALUES ('9590', '737', '2240', 'id9590.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2240.jpg');
INSERT INTO photos VALUES ('9591', '737', '2241', 'id9591.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2241.jpg');
INSERT INTO photos VALUES ('9592', '737', '2243', 'id9592.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2243.jpg');
INSERT INTO photos VALUES ('9593', '737', '2249', 'id9593.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2249.jpg');
INSERT INTO photos VALUES ('9594', '737', '2250', 'id9594.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2250.jpg');
INSERT INTO photos VALUES ('9595', '737', '2251', 'id9595.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2251.jpg');
INSERT INTO photos VALUES ('9596', '737', '2252', 'id9596.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2252.jpg');
INSERT INTO photos VALUES ('9597', '737', '2253', 'id9597.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2253.jpg');
INSERT INTO photos VALUES ('9598', '737', '2254', 'id9598.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2254.jpg');
INSERT INTO photos VALUES ('9599', '737', '2256', 'id9599.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2256.jpg');
INSERT INTO photos VALUES ('9600', '737', '2257', 'id9600.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2257.jpg');
INSERT INTO photos VALUES ('9601', '737', '2259', 'id9601.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2259.jpg');
INSERT INTO photos VALUES ('9602', '737', '2260', 'id9602.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2260.jpg');
INSERT INTO photos VALUES ('9603', '737', '2261', 'id9603.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2261.jpg');
INSERT INTO photos VALUES ('9604', '737', '2262', 'id9604.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2262.jpg');
INSERT INTO photos VALUES ('9605', '737', '2263', 'id9605.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2263.jpg');
INSERT INTO photos VALUES ('9606', '737', '2268', 'id9606.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2268.jpg');
INSERT INTO photos VALUES ('9607', '737', '2269', 'id9607.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2269.jpg');
INSERT INTO photos VALUES ('9608', '737', '2271', 'id9608.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2271.jpg');
INSERT INTO photos VALUES ('9609', '737', '2272', 'id9609.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2272.jpg');
INSERT INTO photos VALUES ('9610', '737', '2273', 'id9610.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2273.jpg');
INSERT INTO photos VALUES ('9611', '737', '2274', 'id9611.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2274.jpg');
INSERT INTO photos VALUES ('9612', '737', '2276', 'id9612.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2276.jpg');
INSERT INTO photos VALUES ('9613', '737', '2277', 'id9613.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2277.jpg');
INSERT INTO photos VALUES ('9614', '737', '2279', 'id9614.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2279.jpg');
INSERT INTO photos VALUES ('9615', '737', '2280', 'id9615.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2280.jpg');
INSERT INTO photos VALUES ('9616', '737', '2282', 'id9616.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2282.jpg');
INSERT INTO photos VALUES ('9617', '737', '2284', 'id9617.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2284.jpg');
INSERT INTO photos VALUES ('9618', '737', '2288', 'id9618.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2288.jpg');
INSERT INTO photos VALUES ('9619', '737', '2289', 'id9619.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2289.jpg');
INSERT INTO photos VALUES ('9620', '737', '2291', 'id9620.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2291.jpg');
INSERT INTO photos VALUES ('9621', '737', '2292', 'id9621.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2292.jpg');
INSERT INTO photos VALUES ('9622', '737', '2293', 'id9622.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2293.jpg');
INSERT INTO photos VALUES ('9623', '737', '2294', 'id9623.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2294.jpg');
INSERT INTO photos VALUES ('9624', '737', '2295', 'id9624.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2295.jpg');
INSERT INTO photos VALUES ('9625', '737', '2296', 'id9625.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2296.jpg');
INSERT INTO photos VALUES ('9626', '737', '2299', 'id9626.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2299.jpg');
INSERT INTO photos VALUES ('9627', '737', '2300', 'id9627.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2300.jpg');
INSERT INTO photos VALUES ('9628', '737', '2301', 'id9628.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2301.jpg');
INSERT INTO photos VALUES ('9629', '737', '2302', 'id9629.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2302.jpg');
INSERT INTO photos VALUES ('9630', '737', '2305', 'id9630.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2305.jpg');
INSERT INTO photos VALUES ('9631', '737', '2306', 'id9631.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2306.jpg');
INSERT INTO photos VALUES ('9632', '737', '2310', 'id9632.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2310.jpg');
INSERT INTO photos VALUES ('9633', '737', '2313', 'id9633.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2313.jpg');
INSERT INTO photos VALUES ('9634', '737', '2314', 'id9634.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2314.jpg');
INSERT INTO photos VALUES ('9635', '737', '2317', 'id9635.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2317.jpg');
INSERT INTO photos VALUES ('9636', '737', '2318', 'id9636.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2318.jpg');
INSERT INTO photos VALUES ('9637', '737', '2319', 'id9637.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2319.jpg');
INSERT INTO photos VALUES ('9638', '737', '2324', 'id9638.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2324.jpg');
INSERT INTO photos VALUES ('9639', '737', '2327', 'id9639.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2327.jpg');
INSERT INTO photos VALUES ('9640', '737', '2330', 'id9640.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2330.jpg');
INSERT INTO photos VALUES ('9641', '737', '2331', 'id9641.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2331.jpg');
INSERT INTO photos VALUES ('9642', '737', '2332', 'id9642.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2332.jpg');
INSERT INTO photos VALUES ('9643', '737', '2333', 'id9643.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2333.jpg');
INSERT INTO photos VALUES ('9644', '737', '2342', 'id9644.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2342.jpg');
INSERT INTO photos VALUES ('9645', '737', '2343', 'id9645.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2343.jpg');
INSERT INTO photos VALUES ('9646', '737', '2344', 'id9646.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2344.jpg');
INSERT INTO photos VALUES ('9647', '737', '2345', 'id9647.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2345.jpg');
INSERT INTO photos VALUES ('9648', '737', '2349', 'id9648.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2349.jpg');
INSERT INTO photos VALUES ('9649', '737', '2350', 'id9649.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2350.jpg');
INSERT INTO photos VALUES ('9650', '737', '2351', 'id9650.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2351.jpg');
INSERT INTO photos VALUES ('9651', '737', '2360', 'id9651.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2360.jpg');
INSERT INTO photos VALUES ('9652', '737', '2451', 'id9652.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2451.jpg');
INSERT INTO photos VALUES ('9653', '737', '2452', 'id9653.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2452.jpg');
INSERT INTO photos VALUES ('9654', '737', '2479', 'id9654.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2479.jpg');
INSERT INTO photos VALUES ('9655', '737', '2480', 'id9655.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2480.jpg');
INSERT INTO photos VALUES ('9656', '737', '2481', 'id9656.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2481.jpg');
INSERT INTO photos VALUES ('9657', '737', '2482', 'id9657.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2482.jpg');
INSERT INTO photos VALUES ('9658', '737', '2483', 'id9658.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2483.jpg');
INSERT INTO photos VALUES ('9659', '737', '2484', 'id9659.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2484.jpg');
INSERT INTO photos VALUES ('9660', '737', '2489', 'id9660.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2489.jpg');
INSERT INTO photos VALUES ('9661', '737', '2490', 'id9661.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2490.jpg');
INSERT INTO photos VALUES ('9662', '737', '2492', 'id9662.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2492.jpg');
INSERT INTO photos VALUES ('9663', '737', '2494', 'id9663.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2494.jpg');
INSERT INTO photos VALUES ('9664', '737', '2495', 'id9664.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2495.jpg');
INSERT INTO photos VALUES ('9665', '737', '2496', 'id9665.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2496.jpg');
INSERT INTO photos VALUES ('9666', '737', '2497', 'id9666.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2497.jpg');
INSERT INTO photos VALUES ('9667', '737', '2498', 'id9667.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2498.jpg');
INSERT INTO photos VALUES ('9668', '737', '2499', 'id9668.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2499.jpg');
INSERT INTO photos VALUES ('9669', '737', '2500', 'id9669.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2500.jpg');
INSERT INTO photos VALUES ('9670', '737', '2501', 'id9670.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2501.jpg');
INSERT INTO photos VALUES ('9671', '737', '2502', 'id9671.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2502.jpg');
INSERT INTO photos VALUES ('9672', '737', '2504', 'id9672.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2504.jpg');
INSERT INTO photos VALUES ('9673', '737', '2505', 'id9673.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2505.jpg');
INSERT INTO photos VALUES ('9674', '737', '2506', 'id9674.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2506.jpg');
INSERT INTO photos VALUES ('9675', '737', '2507', 'id9675.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2507.jpg');
INSERT INTO photos VALUES ('9676', '737', '2508', 'id9676.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2508.jpg');
INSERT INTO photos VALUES ('9677', '737', '2509', 'id9677.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2509.jpg');
INSERT INTO photos VALUES ('9678', '737', '2511', 'id9678.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2511.jpg');
INSERT INTO photos VALUES ('9679', '737', '2513', 'id9679.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2513.jpg');
INSERT INTO photos VALUES ('9680', '737', '2515', 'id9680.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2515.jpg');
INSERT INTO photos VALUES ('9681', '737', '2549', 'id9681.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2549.jpg');
INSERT INTO photos VALUES ('9682', '737', '2550', 'id9682.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2550.jpg');
INSERT INTO photos VALUES ('9683', '737', '2552', 'id9683.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2552.jpg');
INSERT INTO photos VALUES ('9684', '737', '2554', 'id9684.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2554.jpg');
INSERT INTO photos VALUES ('9685', '737', '2555', 'id9685.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2555.jpg');
INSERT INTO photos VALUES ('9686', '737', '2556', 'id9686.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2556.jpg');
INSERT INTO photos VALUES ('9687', '737', '2557', 'id9687.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2557.jpg');
INSERT INTO photos VALUES ('9688', '737', '2559', 'id9688.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2559.jpg');
INSERT INTO photos VALUES ('9689', '737', '2560', 'id9689.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2560.jpg');
INSERT INTO photos VALUES ('9690', '737', '2561', 'id9690.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2561.jpg');
INSERT INTO photos VALUES ('9691', '737', '2562', 'id9691.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2562.jpg');
INSERT INTO photos VALUES ('9692', '737', '2565', 'id9692.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2565.jpg');
INSERT INTO photos VALUES ('9693', '737', '2566', 'id9693.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2566.jpg');
INSERT INTO photos VALUES ('9694', '737', '2567', 'id9694.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2567.jpg');
INSERT INTO photos VALUES ('9695', '737', '2568', 'id9695.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2568.jpg');
INSERT INTO photos VALUES ('9696', '737', '2612', 'id9696.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2612.jpg');
INSERT INTO photos VALUES ('9697', '737', '2614', 'id9697.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2614.jpg');
INSERT INTO photos VALUES ('9698', '737', '2616', 'id9698.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2616.jpg');
INSERT INTO photos VALUES ('9699', '737', '2617', 'id9699.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2617.jpg');
INSERT INTO photos VALUES ('9700', '737', '2619', 'id9700.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2619.jpg');
INSERT INTO photos VALUES ('9701', '737', '2620', 'id9701.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2620.jpg');
INSERT INTO photos VALUES ('9702', '737', '2621', 'id9702.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2621.jpg');
INSERT INTO photos VALUES ('9703', '737', '2630', 'id9703.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2630.jpg');
INSERT INTO photos VALUES ('9704', '737', '2631', 'id9704.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2631.jpg');
INSERT INTO photos VALUES ('9705', '737', '2635', 'id9705.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2635.jpg');
INSERT INTO photos VALUES ('9706', '737', '2641', 'id9706.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2641.jpg');
INSERT INTO photos VALUES ('9707', '737', '2642', 'id9707.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2642.jpg');
INSERT INTO photos VALUES ('9708', '737', '2643', 'id9708.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2643.jpg');
INSERT INTO photos VALUES ('9709', '737', '2644', 'id9709.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2644.jpg');
INSERT INTO photos VALUES ('9710', '737', '2646', 'id9710.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2646.jpg');
INSERT INTO photos VALUES ('9711', '737', '2647', 'id9711.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2647.jpg');
INSERT INTO photos VALUES ('9712', '737', '2648', 'id9712.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2648.jpg');
INSERT INTO photos VALUES ('9713', '737', '2681', 'id9713.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2681.jpg');
INSERT INTO photos VALUES ('9714', '737', '2682', 'id9714.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2682.jpg');
INSERT INTO photos VALUES ('9715', '737', '2687', 'id9715.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2687.jpg');
INSERT INTO photos VALUES ('9716', '737', '2688', 'id9716.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2688.jpg');
INSERT INTO photos VALUES ('9717', '737', '2691', 'id9717.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2691.jpg');
INSERT INTO photos VALUES ('9718', '737', '2692', 'id9718.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2692.jpg');
INSERT INTO photos VALUES ('9719', '737', '2695', 'id9719.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2695.jpg');
INSERT INTO photos VALUES ('9720', '737', '2696', 'id9720.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2696.jpg');
INSERT INTO photos VALUES ('9721', '737', '2697', 'id9721.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2697.jpg');
INSERT INTO photos VALUES ('9722', '737', '2698', 'id9722.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2698.jpg');
INSERT INTO photos VALUES ('9723', '737', '2700', 'id9723.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2700.jpg');
INSERT INTO photos VALUES ('9724', '737', '2704', 'id9724.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2704.jpg');
INSERT INTO photos VALUES ('9725', '737', '2708', 'id9725.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2708.jpg');
INSERT INTO photos VALUES ('9726', '737', '2709', 'id9726.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2709.jpg');
INSERT INTO photos VALUES ('9727', '737', '2710', 'id9727.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2710.jpg');
INSERT INTO photos VALUES ('9728', '737', '2711', 'id9728.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2711.jpg');
INSERT INTO photos VALUES ('9729', '737', '2712', 'id9729.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2712.jpg');
INSERT INTO photos VALUES ('9730', '737', '2742', 'id9730.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2742.jpg');
INSERT INTO photos VALUES ('9731', '737', '2745', 'id9731.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2745.jpg');
INSERT INTO photos VALUES ('9732', '737', '2746', 'id9732.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2746.jpg');
INSERT INTO photos VALUES ('9733', '737', '2747', 'id9733.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2747.jpg');
INSERT INTO photos VALUES ('9734', '737', '2748', 'id9734.jpg', '17', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2748.jpg');
INSERT INTO photos VALUES ('9735', '737', '2750', 'id9735.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2750.jpg');
INSERT INTO photos VALUES ('9736', '737', '2751', 'id9736.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2751.jpg');
INSERT INTO photos VALUES ('9737', '737', '2752', 'id9737.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2752.jpg');
INSERT INTO photos VALUES ('9738', '737', '2755', 'id9738.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2755.jpg');
INSERT INTO photos VALUES ('9739', '737', '2756', 'id9739.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2756.jpg');
INSERT INTO photos VALUES ('9740', '737', '2757', 'id9740.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2757.jpg');
INSERT INTO photos VALUES ('9741', '737', '2758', 'id9741.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2758.jpg');
INSERT INTO photos VALUES ('9742', '737', '2762', 'id9742.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2762.jpg');
INSERT INTO photos VALUES ('9743', '737', '2764', 'id9743.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2764.jpg');
INSERT INTO photos VALUES ('9744', '737', '2771', 'id9744.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2771.jpg');
INSERT INTO photos VALUES ('9745', '737', '2773', 'id9745.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2773.jpg');
INSERT INTO photos VALUES ('9746', '737', '2775', 'id9746.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2775.jpg');
INSERT INTO photos VALUES ('9747', '737', '2776', 'id9747.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2776.jpg');
INSERT INTO photos VALUES ('9748', '737', '2778', 'id9748.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2778.jpg');
INSERT INTO photos VALUES ('9749', '737', '2779', 'id9749.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2779.jpg');
INSERT INTO photos VALUES ('9750', '737', '2780', 'id9750.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2780.jpg');
INSERT INTO photos VALUES ('9751', '737', '2809', 'id9751.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2809.jpg');
INSERT INTO photos VALUES ('9752', '737', '2810', 'id9752.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2810.jpg');
INSERT INTO photos VALUES ('9753', '737', '2818', 'id9753.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2818.jpg');
INSERT INTO photos VALUES ('9754', '737', '2819', 'id9754.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2819.jpg');
INSERT INTO photos VALUES ('9755', '737', '2820', 'id9755.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2820.jpg');
INSERT INTO photos VALUES ('9756', '737', '2821', 'id9756.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2821.jpg');
INSERT INTO photos VALUES ('9757', '737', '2822', 'id9757.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2822.jpg');
INSERT INTO photos VALUES ('9758', '737', '2823', 'id9758.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2823.jpg');
INSERT INTO photos VALUES ('9759', '737', '2824', 'id9759.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2824.jpg');
INSERT INTO photos VALUES ('9760', '737', '2825', 'id9760.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2825.jpg');
INSERT INTO photos VALUES ('9761', '737', '2826', 'id9761.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2826.jpg');
INSERT INTO photos VALUES ('9762', '737', '2827', 'id9762.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2827.jpg');
INSERT INTO photos VALUES ('9763', '737', '2828', 'id9763.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2828.jpg');
INSERT INTO photos VALUES ('9764', '737', '2834', 'id9764.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2834.jpg');
INSERT INTO photos VALUES ('9765', '737', '2864', 'id9765.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2864.jpg');
INSERT INTO photos VALUES ('9766', '737', '2866', 'id9766.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2866.jpg');
INSERT INTO photos VALUES ('9767', '737', '2868', 'id9767.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2868.jpg');
INSERT INTO photos VALUES ('9768', '737', '2871', 'id9768.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2871.jpg');
INSERT INTO photos VALUES ('9769', '737', '2873', 'id9769.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2873.jpg');
INSERT INTO photos VALUES ('9770', '737', '2877', 'id9770.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2877.jpg');
INSERT INTO photos VALUES ('9771', '737', '2878', 'id9771.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2878.jpg');
INSERT INTO photos VALUES ('9772', '737', '2879', 'id9772.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2879.jpg');
INSERT INTO photos VALUES ('9773', '737', '2896', 'id9773.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2896.jpg');
INSERT INTO photos VALUES ('9774', '737', '2900', 'id9774.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2900.jpg');
INSERT INTO photos VALUES ('9775', '737', '2902', 'id9775.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2902.jpg');
INSERT INTO photos VALUES ('9776', '737', '2903', 'id9776.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2903.jpg');
INSERT INTO photos VALUES ('9777', '737', '2908', 'id9777.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2908.jpg');
INSERT INTO photos VALUES ('9778', '737', '2909', 'id9778.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2909.jpg');
INSERT INTO photos VALUES ('9779', '737', '2913', 'id9779.jpg', '19', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2913.jpg');
INSERT INTO photos VALUES ('9780', '737', '2914', 'id9780.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2914.jpg');
INSERT INTO photos VALUES ('9781', '737', '2919', 'id9781.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2919.jpg');
INSERT INTO photos VALUES ('9782', '737', '2932', 'id9782.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2932.jpg');
INSERT INTO photos VALUES ('9783', '737', '2933', 'id9783.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2933.jpg');
INSERT INTO photos VALUES ('9784', '737', '2934', 'id9784.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2934.jpg');
INSERT INTO photos VALUES ('9785', '737', '2935', 'id9785.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2935.jpg');
INSERT INTO photos VALUES ('9786', '737', '2936', 'id9786.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2936.jpg');
INSERT INTO photos VALUES ('9787', '737', '2938', 'id9787.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2938.jpg');
INSERT INTO photos VALUES ('9788', '737', '2939', 'id9788.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2939.jpg');
INSERT INTO photos VALUES ('9789', '737', '2940', 'id9789.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2940.jpg');
INSERT INTO photos VALUES ('9790', '737', '2941', 'id9790.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2941.jpg');
INSERT INTO photos VALUES ('9791', '737', '2969', 'id9791.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2969.jpg');
INSERT INTO photos VALUES ('9792', '737', '2970', 'id9792.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2970.jpg');
INSERT INTO photos VALUES ('9793', '737', '2973', 'id9793.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2973.jpg');
INSERT INTO photos VALUES ('9794', '737', '2974', 'id9794.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2974.jpg');
INSERT INTO photos VALUES ('9795', '737', '2975', 'id9795.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2975.jpg');
INSERT INTO photos VALUES ('9796', '737', '2976', 'id9796.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2976.jpg');
INSERT INTO photos VALUES ('9797', '737', '2981', 'id9797.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2981.jpg');
INSERT INTO photos VALUES ('9798', '737', '2982', 'id9798.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2982.jpg');
INSERT INTO photos VALUES ('9799', '737', '2984', 'id9799.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2984.jpg');
INSERT INTO photos VALUES ('9800', '737', '2985', 'id9800.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2985.jpg');
INSERT INTO photos VALUES ('9801', '737', '2986', 'id9801.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/2986.jpg');
INSERT INTO photos VALUES ('9802', '737', '3014', 'id9802.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/3014.jpg');
INSERT INTO photos VALUES ('9803', '737', '3015', 'id9803.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/3015.jpg');
INSERT INTO photos VALUES ('9804', '737', '3020', 'id9804.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/3020.jpg');
INSERT INTO photos VALUES ('9805', '737', '3022', 'id9805.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/3022.jpg');
INSERT INTO photos VALUES ('9806', '737', '3023', 'id9806.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/3023.jpg');
INSERT INTO photos VALUES ('9807', '737', '3024', 'id9807.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/3024.jpg');
INSERT INTO photos VALUES ('9808', '737', '3028', 'id9808.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/3028.jpg');
INSERT INTO photos VALUES ('9809', '737', '3029', 'id9809.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/3029.jpg');
INSERT INTO photos VALUES ('9810', '737', '3030', 'id9810.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/3030.jpg');
INSERT INTO photos VALUES ('9811', '737', '3034', 'id9811.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/3034.jpg');
INSERT INTO photos VALUES ('9812', '737', '3036', 'id9812.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/3036.jpg');
INSERT INTO photos VALUES ('9813', '737', '3040', 'id9813.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/3040.jpg');
INSERT INTO photos VALUES ('9814', '737', '3042', 'id9814.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/3042.jpg');
INSERT INTO photos VALUES ('9815', '737', '3048', 'id9815.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/3048.jpg');
INSERT INTO photos VALUES ('9816', '737', '3050', 'id9816.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/3050.jpg');
INSERT INTO photos VALUES ('9817', '737', '3051', 'id9817.jpg', '0', '10.00', '12.00', '40.00', '/fotoarhiv/gimnastika/Jakovenko2013/3051.jpg');


#
# Table structure for table `print`
#

DROP TABLE IF EXISTS `print`;
CREATE TABLE `print` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL COMMENT 'номер пользователя',
  `name` varchar(64) NOT NULL COMMENT 'имя пользователя',
  `subname` varchar(64) NOT NULL COMMENT 'фамилия пользователя',
  `phone` varchar(64) NOT NULL COMMENT 'телефон пользователя',
  `email` varchar(64) NOT NULL COMMENT 'E-mail заказчика',
  `dt` int(11) NOT NULL COMMENT 'дата заказа',
  `adr_poluc` varchar(512) NOT NULL COMMENT 'адрес почтового отделения или получателя ( город и номер)',
  `adr_studii` varchar(512) NOT NULL COMMENT 'адрес печатной студии ',
  `nPocta` varchar(64) NOT NULL COMMENT 'название почтовой службы',
  `id_nal` varchar(64) NOT NULL COMMENT 'способ оплаты оплата наложенным платежем или через сайт',
  `id_dost` varchar(64) NOT NULL COMMENT 'способ доставки',
  `user_dost` varchar(512) NOT NULL COMMENT 'способ доставки выбранный пользователем',
  `user_opl` varchar(512) NOT NULL COMMENT 'способ оплаты выбранный пользователем',
  `ramka` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'белая рамка',
  `mat_gl` enum('матовая','глянцевая') NOT NULL DEFAULT 'глянцевая' COMMENT 'тип бумаги',
  `format` enum('10x15','13x18','20x30') NOT NULL DEFAULT '13x18' COMMENT 'формат бумаги',
  `comm` varchar(512) NOT NULL COMMENT 'Примечание пользователя',
  `summ` float(8,2) NOT NULL DEFAULT '0.00' COMMENT 'Сумма за фото с учетом всех скидок',
  `zakaz` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'подтверждение заказа',
  `otpr` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'дата отправки заказа почтой',
  `dekl` varchar(64) NOT NULL COMMENT 'номер почтовой декларации',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 - получение денег и закрытие счета',
  `key` varchar(64) NOT NULL COMMENT 'для подтверждения заказа',
  PRIMARY KEY (`id`),
  KEY `key` (`key`)
) ENGINE=MyISAM AUTO_INCREMENT=127 DEFAULT CHARSET=cp1251 COMMENT='Печать фотографий';

#
# Dumping data for table `print`
#

INSERT INTO print VALUES ('83', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '2013', '', 'Одесса, ул.Пушкинская (напротив цума)', 'выбрать|выбрать', 'пополнение баланса сайта', 'Самовывоз из студии (в Одессе)', '', '', '0', 'глянцевая', '13x18', '', '24.00', '0', '0000-00-00 00:00:00', '', '0', 'fd7fc2b3981d448fbb50ba180e18a0c4');
INSERT INTO print VALUES ('82', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '2013', '898', 'выбрать', 'Укрпочта|http://services.ukrposhta.com/CalcUtil/PostalMails.aspx', 'наложенный платеж', 'Самовывоз из почтового отделения Вашего города', '', '', '0', 'глянцевая', '13x18', 'гшш', '24.00', '0', '0000-00-00 00:00:00', '', '0', '57724a93e961c63d17e370b0cc0f7bbd');
INSERT INTO print VALUES ('80', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '2013', '', 'выбрать', 'Укрпочта|http://services.ukrposhta.com/CalcUtil/PostalMails.aspx', 'наложенный платеж', 'Самовывоз из почтового отделения Вашего города', '', '', '1', 'матовая', '20x30', '', '40.00', '0', '0000-00-00 00:00:00', '', '0', 'fc8a7346e91e62c25452e7f72b76908b');
INSERT INTO print VALUES ('81', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '2013', '', 'выбрать', 'Новая  почта|http://novaposhta.ua/frontend/calculator/ru', 'наложенный платеж', 'Самовывоз из почтового отделения Вашего города', '', '', '0', 'глянцевая', '13x18', '', '24.00', '0', '0000-00-00 00:00:00', '', '0', '32bf4f3a75e3a7051bee5f6144019b95');
INSERT INTO print VALUES ('84', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '0', '', 'выбрать', 'Новая  почта|http://novaposhta.ua/frontend/calculator/ru', 'наложенный платеж', 'Самовывоз из почтового отделения Вашего города', '', '', '0', 'глянцевая', '13x18', '', '24.00', '0', '0000-00-00 00:00:00', '', '0', 'd3f67b8da648899302eca600a2c7c25d');
INSERT INTO print VALUES ('85', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '0', '', 'выбрать', 'Новая  почта|http://novaposhta.ua/frontend/calculator/ru', 'наложенный платеж', 'Самовывоз из почтового отделения Вашего города', '', '', '0', 'глянцевая', '13x18', '', '12.00', '0', '0000-00-00 00:00:00', '', '0', '08a383258b776d98fa95b091385e242a');
INSERT INTO print VALUES ('86', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '1369476722', '', 'выбрать', 'Укрпочта|http://services.ukrposhta.com/CalcUtil/PostalMails.aspx', 'наложенный платеж', 'Самовывоз из почтового отделения Вашего города', '', '', '0', 'глянцевая', '13x18', '', '12.00', '0', '0000-00-00 00:00:00', '', '0', 'd5bd32cf208ea20b95aa76437ecf8f12');
INSERT INTO print VALUES ('87', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '1369477000', '', 'Одесса, ул.Пушкинская (напротив цума)', 'выбрать|выбрать', 'пополнение баланса сайта', 'Самовывоз из студии (в Одессе)', '', '', '0', 'глянцевая', '13x18', '', '12.00', '0', '0000-00-00 00:00:00', '', '0', '3eb68e844eafa0930c73877d9530c0fd');
INSERT INTO print VALUES ('88', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '1369477436', '', 'выбрать', 'Укрпочта|http://services.ukrposhta.com/CalcUtil/PostalMails.aspx', 'наложенный платеж', 'Самовывоз из почтового отделения Вашего города', '', '', '0', 'глянцевая', '13x18', '', '12.00', '0', '0000-00-00 00:00:00', '', '0', '6cc3bc0ffd11116b3cbf1e6b28045416');
INSERT INTO print VALUES ('89', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '1369477623', '', 'выбрать', 'Укрпочта|http://services.ukrposhta.com/CalcUtil/PostalMails.aspx', 'наложенный платеж', 'Самовывоз из почтового отделения Вашего города', '', '', '0', 'глянцевая', '13x18', '', '12.00', '0', '0000-00-00 00:00:00', '', '0', '9822530215418cd1f8c37537c2157d34');
INSERT INTO print VALUES ('90', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '1369477694', '', 'выбрать', 'Укрпочта|http://services.ukrposhta.com/CalcUtil/PostalMails.aspx', 'наложенный платеж', 'Самовывоз из почтового отделения Вашего города', '', '', '0', 'глянцевая', '13x18', '', '12.00', '0', '0000-00-00 00:00:00', '', '0', '6f914bf695ed67a58ab62f6f52410623');
INSERT INTO print VALUES ('91', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '1369477747', '', 'выбрать', 'Укрпочта|http://services.ukrposhta.com/CalcUtil/PostalMails.aspx', 'наложенный платеж', 'Самовывоз из почтового отделения Вашего города', '', '', '0', 'глянцевая', '13x18', '', '12.00', '0', '0000-00-00 00:00:00', '', '0', 'ca19ea3a2ab8e69d48905f78e6097dcd053edbef');
INSERT INTO print VALUES ('92', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '1369477747', '', 'Одесса, ул.Пушкинская (напротив цума)', 'выбрать|выбрать', 'пополнение баланса сайта', 'Самовывоз из студии (в Одессе)', '', '', '0', 'матовая', '20x30', '', '120.00', '1', '0000-00-00 00:00:00', '', '0', '060ac0492d04229806d3648ddcf53c083f3e0a6a');
INSERT INTO print VALUES ('93', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '1369507797', '', 'выбрать', 'Укрпочта|http://services.ukrposhta.com/CalcUtil/PostalMails.aspx', 'наложенный платеж', 'Самовывоз из почтового отделения Вашего города', '', '', '0', 'глянцевая', '13x18', '', '12.00', '1', '0000-00-00 00:00:00', '', '0', '695a4e7ef50b76aefc813c9071959688c640f11b');
INSERT INTO print VALUES ('94', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '1369507926', '', 'выбрать', 'Новая  почта|http://novaposhta.ua/frontend/calculator/ru', 'наложенный платеж', 'Самовывоз из почтового отделения Вашего города', '', '', '0', 'глянцевая', '13x18', '', '12.00', '1', '0000-00-00 00:00:00', '', '0', '1ebfdb27845bf41a30a2096ce694631913175cf3');
INSERT INTO print VALUES ('95', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '1369509361', '', 'выбрать', 'Укрпочта|http://services.ukrposhta.com/CalcUtil/PostalMails.aspx', 'наложенный платеж', 'Самовывоз из почтового отделения Вашего города', '', '', '0', 'глянцевая', '13x18', '', '12.00', '1', '0000-00-00 00:00:00', '', '0', '01fa22167fc278c7ee1cc3884983d0e60b51598e');
INSERT INTO print VALUES ('96', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '1369573835', 'l;\'l;\'', 'выбрать', 'Укрпочта|http://services.ukrposhta.com/CalcUtil/PostalMails.aspx', 'наложенный платеж', 'Самовывоз из почтового отделения Вашего города', '', '', '0', 'глянцевая', '13x18', '', '24.00', '1', '0000-00-00 00:00:00', '', '0', 'e7946c1349ff7409e8570739aaab8bfe8c50a09f');
INSERT INTO print VALUES ('97', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '1369649469', '', 'выбрать', 'Укрпочта|http://services.ukrposhta.com/CalcUtil/PostalMails.aspx', 'наложенный платеж', 'Самовывоз из почтового отделения Вашего города', '', '', '0', 'глянцевая', '13x18', '', '12.00', '1', '0000-00-00 00:00:00', '', '0', '6cb0a97640647af7a6d229e8e03b07611e9a9585');
INSERT INTO print VALUES ('98', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '1370092522', '', 'выбрать', 'Укрпочта|http://services.ukrposhta.com/CalcUtil/PostalMails.aspx', 'наложенный платеж', 'Самовывоз из почтового отделения Вашего города', '', '', '0', 'глянцевая', '13x18', '', '12.00', '1', '0000-00-00 00:00:00', '', '0', '14712391741981076c6539fcffa883771046be87');
INSERT INTO print VALUES ('99', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '1370179689', '', 'выбрать', 'Укрпочта|http://services.ukrposhta.com/CalcUtil/PostalMails.aspx', 'наложенный платеж', 'Самовывоз из почтового отделения Вашего города', '', '', '0', 'глянцевая', '13x18', '', '60.00', '1', '0000-00-00 00:00:00', '', '0', '1da7d723695da38fcdc1f233161d963ad34a03eb');
INSERT INTO print VALUES ('100', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '1370257240', '', 'Одесса, ул.Ленина 48', 'выбрать|выбрать', 'наложенный платеж', 'Самовывоз из студии (в Одессе)', '', '', '1', 'глянцевая', '13x18', '', '180.00', '1', '0000-00-00 00:00:00', '', '0', '066559338b2c4a7fe20ed74904caa8b4bd57b658');
INSERT INTO print VALUES ('101', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '1370266809', '', 'Одесса, ул.Пушкинская (напротив цума)', 'выбрать|выбрать', 'наложенный платеж', 'Самовывоз из студии (в Одессе)', '', '', '1', 'матовая', '20x30', '', '240.00', '1', '0000-00-00 00:00:00', '', '0', 'b9e943e883243cd30f1e19c581c719c02180d68b');
INSERT INTO print VALUES ('102', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '1370267304', '', 'Одесса, ул.Ленина 48', 'выбрать|выбрать', 'наложенный платеж', 'Самовывоз из студии (в Одессе)', '', '', '1', 'глянцевая', '13x18', '', '336.00', '1', '0000-00-00 00:00:00', '', '0', 'eb8fe843e7d7d78d5ebbe5bd15be2c2a6f02769a');
INSERT INTO print VALUES ('103', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '1370273729', '', 'Одесса, ул.Ленина 48', 'выбрать|выбрать', 'наложенный платеж', 'Самовывоз из студии (в Одессе)', '', '', '1', 'глянцевая', '13x18', '', '12.00', '1', '0000-00-00 00:00:00', '', '0', 'cb171cffba34fe42dd21b2c84ed39304c3a4e6a3');
INSERT INTO print VALUES ('104', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '1370288578', '', 'Одесса, ул.Пушкинская (напротив цума)', 'выбрать|выбрать', 'наложенный платеж', 'Самовывоз из студии (в Одессе)', '', '', '0', 'глянцевая', '13x18', '', '12.00', '1', '0000-00-00 00:00:00', '', '0', '76b681ba15039c4a1ba7ed93f4c554790e826f4b');
INSERT INTO print VALUES ('105', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '1370473647', '', 'Одесса, ул.Ленина 48', 'выбрать|выбрать', 'наложенный платеж', 'Самовывоз из студии (в Одессе)', '', '', '1', 'глянцевая', '13x18', '', '72.00', '1', '0000-00-00 00:00:00', '', '0', 'b76720d42ae9fa2458b25faaa09095ef4a7bf64e');
INSERT INTO print VALUES ('106', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '1370481645', '', 'Одесса, ул.Ленина 48', 'выбрать|выбрать', 'наложенный платеж', 'Самовывоз из студии (в Одессе)', '', '', '0', 'глянцевая', '13x18', '', '144.00', '1', '0000-00-00 00:00:00', '', '0', '737d654c41f57adc4a6326c489684d96b751d331');
INSERT INTO print VALUES ('107', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '1370572351', '', 'Одесса, ул.Ленина 48', 'Новая  почта|http://novaposhta.ua/frontend/calculator/ru', 'наложенный платеж', 'Самовывоз из студии (в Одессе)', '', '', '1', 'глянцевая', '13x18', '', '12.00', '1', '0000-00-00 00:00:00', '', '0', 'e9594525cc8d5e271b53703e059dba8a6f070d05');
INSERT INTO print VALUES ('108', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '1370618736', '', 'Одесса, ул.Ленина 48', 'выбрать|выбрать', 'наложенный платеж', 'Самовывоз из студии (в Одессе)', '', '', '0', 'глянцевая', '13x18', '', '12.00', '1', '0000-00-00 00:00:00', '', '0', '4652fc3f51077691fd62c69a8434efc25a3b52fa');
INSERT INTO print VALUES ('109', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '1370618953', '', 'Одесса, ул.Ленина 48', 'выбрать|выбрать', 'наложенный платеж', 'Самовывоз из студии (в Одессе)', '', '', '0', 'глянцевая', '13x18', '', '12.00', '1', '0000-00-00 00:00:00', '', '0', '174cc0d7033f17b52ccbdf7211c14751018f9845');
INSERT INTO print VALUES ('110', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '1370619386', '', 'Одесса, ул.Ленина 48', 'выбрать|выбрать', 'наложенный платеж', 'Самовывоз из студии (в Одессе)', '', '', '1', 'матовая', '13x18', '', '24.00', '1', '0000-00-00 00:00:00', '', '0', '1ced0a545b80aac0ab2e835b6d4bfb1ecc6b444e');
INSERT INTO print VALUES ('111', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '1370646046', '', 'Одесса, ул.Ленина 48', 'Новая  почта|http://novaposhta.ua/frontend/calculator/ru', 'наложенный платеж', 'Самовывоз из студии (в Одессе)', '', '', '0', 'глянцевая', '13x18', '', '12.00', '1', '0000-00-00 00:00:00', '', '0', '6597fce1cef9fb91ba89e379a34ac3c7074f2aff');
INSERT INTO print VALUES ('112', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '1370719583', '', 'Одесса, ул.Пушкинская (напротив цума)', 'выбрать|выбрать', 'пополнение баланса сайта', 'Самовывоз из студии (в Одессе)', '', '', '0', 'глянцевая', '13x18', '', '12.00', '0', '0000-00-00 00:00:00', '', '0', '992562ca7bd1d9a0e5fed70be38d1eaab7aacedf');
INSERT INTO print VALUES ('113', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '1370719839', '', 'выбрать', 'выбрать|выбрать', 'пополнение баланса сайта', 'Передать тренеру команды (в Одессе при полной предоплате)', '', '', '0', 'глянцевая', '13x18', '', '12.00', '0', '0000-00-00 00:00:00', '', '0', '83fe8c0ccd069189201f33d9f25293b598e6efe5');
INSERT INTO print VALUES ('114', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '1370719916', '', 'выбрать', 'выбрать|выбрать', 'пополнение баланса сайта', 'Самовывоз от фотографа', '', '', '0', 'глянцевая', '13x18', '', '12.00', '1', '0000-00-00 00:00:00', '', '0', 'c358e0199ec8a00607ff3caa3b4d41178b274a12');
INSERT INTO print VALUES ('115', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '1370724798', '', 'выбрать', 'Укрпочта|http://services.ukrposhta.com/CalcUtil/PostalMails.aspx', 'наложенный платеж', 'Самовывоз из почтового отделения Вашего города', '', '', '1', 'глянцевая', '10x15', '', '12.00', '1', '0000-00-00 00:00:00', '', '0', '7acb511f41b482bf106afb68ac70ae2ad53c05f8');
INSERT INTO print VALUES ('116', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '1370731534', '', 'Одесса, ул.Пушкинская (напротив цума)', 'Укрпочта|http://services.ukrposhta.com/CalcUtil/PostalMails.aspx', 'наложенный платеж', 'Самовывоз из студии (в Одессе)', '', '', '0', 'глянцевая', '20x30', '', '120.00', '0', '0000-00-00 00:00:00', '', '0', 'b7583da805a63344ac4d5f1a4ff44bc9777727fb');
INSERT INTO print VALUES ('117', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '1370906013', '', 'Одесса, ул.Ленина 48', 'выбрать|выбрать', 'пополнение баланса сайта', 'Самовывоз из студии (в Одессе)', '', '', '1', 'глянцевая', '13x18', '', '60.00', '0', '0000-00-00 00:00:00', '', '0', '0c69d2d02e90f7fef84059b324723568760b0d17');
INSERT INTO print VALUES ('118', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '1370977029', '', 'выбрать', 'Новая  почта|http://novaposhta.ua/frontend/calculator/ru', 'наложенный платеж', 'Самовывоз из почтового отделения Вашего города', '', '', '1', 'матовая', '13x18', '', '24.00', '1', '0000-00-00 00:00:00', '', '0', '843b3cdd0f030ca56882c33b3f432cc1e5b6a559');
INSERT INTO print VALUES ('119', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '1371039413', '', 'Одесса, ул.Ленина 48', 'выбрать|выбрать', 'наложенный платеж', 'Самовывоз из студии (в Одессе)', '', '', '1', 'матовая', '13x18', '', '12.00', '1', '0000-00-00 00:00:00', '', '0', '68ac2deba6a62d1772818b34a611178e6a4dee29');
INSERT INTO print VALUES ('120', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '1371040594', '', 'Одесса, ул.Ленина 48', 'выбрать|выбрать', 'наложенный платеж', 'Самовывоз из студии (в Одессе)', '', '', '1', 'глянцевая', '13x18', '', '12.00', '1', '0000-00-00 00:00:00', '', '0', '802aa464b4619c056fad56a44b26f5350ba57387');
INSERT INTO print VALUES ('121', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '1371040756', '', 'Одесса, ул.Ленина 48', 'выбрать|выбрать', 'наложенный платеж', 'Самовывоз из студии (в Одессе)', '', '', '0', 'глянцевая', '13x18', '', '36.00', '1', '0000-00-00 00:00:00', '', '0', '0df182db30316df70d14f89c9b5b735d828c02a6');
INSERT INTO print VALUES ('122', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '1371041513', '', 'Одесса, ул.Ленина 48', 'выбрать|выбрать', 'пополнение баланса сайта', 'Самовывоз из студии (в Одессе)', '', '', '0', 'глянцевая', '13x18', '', '12.00', '0', '0000-00-00 00:00:00', '', '0', '5fe4c4ef8c696107a4f8ad772227416c9073ac50');
INSERT INTO print VALUES ('123', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '1371041563', '', 'выбрать', 'Новая  почта|http://novaposhta.ua/frontend/calculator/ru', 'наложенный платеж', 'Самовывоз из почтового отделения Вашего города', '', '', '0', 'глянцевая', '13x18', '', '24.00', '1', '0000-00-00 00:00:00', '', '0', '2facd3f53cab2e42d50ee7a254782c8cbfcf86de');
INSERT INTO print VALUES ('124', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '1371041706', '', 'Одесса, ул.Ленина 48', 'выбрать|выбрать', 'наложенный платеж', 'Самовывоз из студии (в Одессе)', '', '', '0', 'глянцевая', '13x18', '', '12.00', '1', '0000-00-00 00:00:00', '', '0', '47cb54da3c8f33192ab987f5bd2e979138f424f5');
INSERT INTO print VALUES ('125', '29', 'test', 'test2', '77777', 'uf-3027@te.net.ua', '1371114292', '', 'Одесса, ул.Ленина 48', 'Новая  почта|http://novaposhta.ua/frontend/calculator/ru', 'наложенный платеж', 'Самовывоз из студии (в Одессе)', '', '', '1', 'матовая', '13x18', '', '24.00', '0', '0000-00-00 00:00:00', '', '0', 'f1d2009293690f1250d9d72ec338f35f4f8592fb');
INSERT INTO print VALUES ('126', '29', 'test', 'test2', '094-94-77-070', 'uf-3027@te.net.ua', '1372866026', '', 'Одесса, ул.Ленина 48', 'выбрать|выбрать', 'наложенный платеж', 'Самовывоз из студии (в Одессе)', '', '', '0', 'глянцевая', '13x18', '', '12.00', '1', '0000-00-00 00:00:00', '', '0', '5805d77ba2a8c3dbb07c1ba435bd085270ef5491');


#
# Table structure for table `subs`
#

DROP TABLE IF EXISTS `subs`;
CREATE TABLE `subs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nm` varchar(64) NOT NULL COMMENT 'Название акции',
  `time_in` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Вреня начала акции',
  `time_out` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Дата конца',
  `time_act` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Время выполнения для одноразовой акции ',
  `time` int(11) NOT NULL COMMENT 'Повторять через каждые time часов',
  `id_album_event` int(11) NOT NULL COMMENT 'Событие альбома для выполнения условия',
  `id_user_event` varchar(64) NOT NULL COMMENT 'Событие usera для выполнения условия',
  `mode` enum('выполнить один раз','выполнять один раз в день','повторять через каждые time часов','выполнять постоянно при каждом заходе','выполнять при наступлении события') NOT NULL COMMENT 'Выполнение одно или многоразовая',
  `spec` varchar(256) NOT NULL COMMENT 'Описание',
  `a1` int(11) NOT NULL COMMENT 'Первый количественный аргумент акции',
  `a2` int(11) NOT NULL COMMENT 'Второй количественный аргумент акции',
  `a3` int(11) NOT NULL COMMENT 'Третий количественный аргумент акции',
  `txt` varchar(64) NOT NULL COMMENT 'Описание зависимостей аргументов a1, a2, a3 в программе',
  `var` enum('E-mail рассылки','баланс пользователя','альбом','сообщения') NOT NULL COMMENT 'Привязка к компонентам сайта',
  `order` enum('выполнять только для подписанных','выполнять для всех') NOT NULL COMMENT 'Условие выполнения ',
  `status` enum('в процессе','выполнено') NOT NULL COMMENT 'Статус выполнения ',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=cp1251 COMMENT='Существующие акции для пользователей';

#
# Dumping data for table `subs`
#

INSERT INTO subs VALUES ('1', '10%', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0', '0', 'выполнить один раз', 'Скидки 10% при заказе от 1000 гривень', '1000', '10', '0', '', '', 'выполнять только для подписанных', 'в процессе');
INSERT INTO subs VALUES ('2', '1 гривня в день', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0', '0', 'выполнять один раз в день', 'Каждый день по 1 гривне, всем зашедшим на сайт', '1', '1', '0', '', '', 'выполнять только для подписанных', 'в процессе');
INSERT INTO subs VALUES ('3', 'Бесплатная доставка', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0', '0', 'выполнять постоянно при каждом заходе', 'При заказе фотографий от 1200 гривень - доставка бесплатная', '1200', '0', '0', '', 'E-mail рассылки', 'выполнять для всех', 'в процессе');
INSERT INTO subs VALUES ('4', 'Подписка на альбом', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0', '0', 'выполнить один раз', 'Подписка на альбом \'Тест\'', '0', '0', '0', '', 'E-mail рассылки', 'выполнять для всех', 'выполнено');


#
# Table structure for table `subs_album_on`
#

DROP TABLE IF EXISTS `subs_album_on`;
CREATE TABLE `subs_album_on` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_album` int(11) NOT NULL COMMENT 'номер альбома',
  `id_alb_subs` int(11) NOT NULL COMMENT 'подписка на акции',
  `time_alb_subs` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'время подписки',
  PRIMARY KEY (`id`),
  KEY `id_album` (`id_album`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 COMMENT='Подписка альбомов на акции';

#
# Dumping data for table `subs_album_on`
#



#
# Table structure for table `subs_user_on`
#

DROP TABLE IF EXISTS `subs_user_on`;
CREATE TABLE `subs_user_on` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL COMMENT 'Номер пользователя',
  `id_subs` int(11) NOT NULL COMMENT 'подписка на акции',
  `time_subs` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'время подписки',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=cp1251 COMMENT='подписка пользователей на акции ';

#
# Dumping data for table `subs_user_on`
#

INSERT INTO subs_user_on VALUES ('1', '29', '1', '2013-05-09 21:50:37');
INSERT INTO subs_user_on VALUES ('2', '29', '2', '2013-05-14 16:37:18');
INSERT INTO subs_user_on VALUES ('3', '18', '3', '2013-05-14 18:05:35');
INSERT INTO subs_user_on VALUES ('4', '18', '4', '2013-05-14 18:48:52');


#
# Table structure for table `users`
#

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `login` varchar(64) NOT NULL COMMENT 'логин',
  `pass` varchar(64) NOT NULL COMMENT 'пароль',
  `email` varchar(64) NOT NULL COMMENT 'почта',
  `skype` varchar(64) NOT NULL COMMENT 'скайп',
  `phone` varchar(64) NOT NULL COMMENT 'телефон',
  `block` tinyint(2) NOT NULL DEFAULT '1' COMMENT 'блокировка пользователя',
  `level` int(10) NOT NULL DEFAULT '1' COMMENT 'уровень доступа пользователя (категория)',
  `mail_me` varchar(64) NOT NULL DEFAULT 'on' COMMENT 'Разрешть администрации посылать уведомление пользователю',
  `timestamp` int(10) NOT NULL COMMENT 'Время регистрации',
  `us_name` varchar(64) NOT NULL COMMENT 'Имя',
  `us_surname` varchar(64) NOT NULL COMMENT 'Фамилия',
  `balans` float(8,2) NOT NULL DEFAULT '0.00' COMMENT 'денег на счету',
  `ip` varchar(64) NOT NULL COMMENT 'Ip регистрации ',
  `city` varchar(64) NOT NULL COMMENT 'Город проживания',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'статус подтверждения регистрации',
  PRIMARY KEY (`id`),
  KEY `login` (`login`,`email`)
) ENGINE=MyISAM AUTO_INCREMENT=61 DEFAULT CHARSET=cp1251 COMMENT='Пользователи';

#
# Dumping data for table `users`
#

INSERT INTO users VALUES ('45', 'yana', '75cf338d08b4a7782493077c861bb121', 'yanacach@ukr.net', '', '', '1', '1', 'on', '1367334933', 'yana', '', '0.00', '37.52.81.214', '', '1');
INSERT INTO users VALUES ('60', 'test2', '1bbd886460827015e5d605ed44252251', 'jurii@mail.ru', '', '', '1', '1', 'on', '1373527403', 'test', '', '0.00', '31.31.110.209', '', '1');
INSERT INTO users VALUES ('48', 'Voytesha', '11b3fc05ecc96325e98631a62b61b377', 'Voytesha@mail.ru', '', '', '1', '1', 'on', '1367824820', 'Елена', '', '0.00', '93.75.69.186', '', '1');
INSERT INTO users VALUES ('49', 'makar2013', '3ff10db727f2563e1b12ce27d59cf1c4', 'lyudmila.filippenko@yandex.ua', '', '', '1', '1', 'on', '1367868212', 'Людмила', '', '0.00', '94.179.144.125', '', '1');
INSERT INTO users VALUES ('50', 'arinazakorko', '62bac9c35e2c96719dbd1b20ad04f445', 'chepurina@ukr.net', '', '', '1', '1', 'on', '1367953209', 'zakorko arina', '', '0.00', '95.132.58.78', '', '1');
INSERT INTO users VALUES ('53', 'lajza12', 'ee690b4008cd5b6a8b6b035764173e24', 'y2497@yandex.ru', '', '', '1', '1', 'on', '1368529832', 'Татьяна', '', '0.00', '178.95.19.121', '', '1');
INSERT INTO users VALUES ('55', 'zoolisi', 'd2f16a25052a9f1fbc8fd0212e585701', 'zoolisi@mail.ru', '', '', '1', '1', 'on', '1368541909', 'Ирина', '', '0.00', '91.204.61.5', '', '1');
INSERT INTO users VALUES ('56', 'barbariska', '1bbd886460827015e5d605ed44252251', 'mutan@ukr.net', '', '', '1', '1', 'on', '1369122790', 'Наталья', '', '0.00', '89.209.82.199', '', '1');
INSERT INTO users VALUES ('59', 'doca', 'c16b3c001372c257d54f415e3a0c3ca1', 'natasha.stashek@mail.ru', '', '', '1', '1', 'on', '1370023476', 'dasha', '', '0.00', '178.212.192.3', '', '1');
INSERT INTO users VALUES ('29', 'test', '05a671c66aefea124cc08b76ea6d30bb', 'uf-3027@te.net.ua', '', '094-94-77-070', '1', '1', 'on', '1366696795', 'test', 'test2', '2.47', '31.31.116.22', 'Одесса', '1');


#
# Table structure for table `votes`
#

DROP TABLE IF EXISTS `votes`;
CREATE TABLE `votes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL DEFAULT '0',
  `id_photo` int(11) NOT NULL DEFAULT '0',
  `golos_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  KEY `id_photo` (`id_photo`),
  KEY `vote_time` (`golos_time`)
) ENGINE=MyISAM AUTO_INCREMENT=1061 DEFAULT CHARSET=cp1251 COMMENT='Голосование';

#
# Dumping data for table `votes`
#

INSERT INTO votes VALUES ('586', '29', '5990', '2013-05-07 14:51:12');
INSERT INTO votes VALUES ('585', '29', '5990', '2013-05-07 14:51:08');
INSERT INTO votes VALUES ('584', '29', '5986', '2013-05-07 14:51:02');
INSERT INTO votes VALUES ('583', '29', '5986', '2013-05-07 14:50:48');
INSERT INTO votes VALUES ('582', '29', '5982', '2013-05-07 14:50:23');
INSERT INTO votes VALUES ('581', '29', '5991', '2013-05-07 14:50:06');
INSERT INTO votes VALUES ('580', '29', '5991', '2013-05-07 14:50:05');
INSERT INTO votes VALUES ('579', '29', '5991', '2013-05-07 14:50:04');
INSERT INTO votes VALUES ('578', '29', '5982', '2013-05-07 14:49:44');
INSERT INTO votes VALUES ('539', '29', '5990', '2013-05-07 14:00:15');
INSERT INTO votes VALUES ('540', '29', '5990', '2013-05-07 14:00:22');
INSERT INTO votes VALUES ('541', '29', '5986', '2013-05-07 14:13:50');
INSERT INTO votes VALUES ('542', '29', '5990', '2013-05-07 14:20:44');
INSERT INTO votes VALUES ('543', '29', '5986', '2013-05-07 14:20:53');
INSERT INTO votes VALUES ('544', '29', '5990', '2013-05-07 14:21:30');
INSERT INTO votes VALUES ('545', '29', '5990', '2013-05-07 14:21:33');
INSERT INTO votes VALUES ('546', '29', '5982', '2013-05-07 14:27:18');
INSERT INTO votes VALUES ('547', '29', '5982', '2013-05-07 14:27:25');
INSERT INTO votes VALUES ('548', '29', '5982', '2013-05-07 14:27:59');
INSERT INTO votes VALUES ('549', '29', '5986', '2013-05-07 14:28:15');
INSERT INTO votes VALUES ('550', '29', '5986', '2013-05-07 14:28:19');
INSERT INTO votes VALUES ('551', '29', '6011', '2013-05-07 14:28:32');
INSERT INTO votes VALUES ('552', '29', '5991', '2013-05-07 14:29:02');
INSERT INTO votes VALUES ('553', '29', '5983', '2013-05-07 14:31:45');
INSERT INTO votes VALUES ('554', '29', '5983', '2013-05-07 14:31:49');
INSERT INTO votes VALUES ('555', '29', '5983', '2013-05-07 14:32:16');
INSERT INTO votes VALUES ('556', '29', '5986', '2013-05-07 14:32:20');
INSERT INTO votes VALUES ('557', '29', '5990', '2013-05-07 14:34:20');
INSERT INTO votes VALUES ('558', '29', '5990', '2013-05-07 14:34:33');
INSERT INTO votes VALUES ('559', '29', '5990', '2013-05-07 14:34:40');
INSERT INTO votes VALUES ('560', '29', '5986', '2013-05-07 14:34:48');
INSERT INTO votes VALUES ('561', '29', '5986', '2013-05-07 14:34:56');
INSERT INTO votes VALUES ('562', '29', '5986', '2013-05-07 14:36:08');
INSERT INTO votes VALUES ('563', '29', '5986', '2013-05-07 14:36:17');
INSERT INTO votes VALUES ('564', '29', '5990', '2013-05-07 14:37:04');
INSERT INTO votes VALUES ('565', '29', '6002', '2013-05-07 14:37:14');
INSERT INTO votes VALUES ('566', '29', '5990', '2013-05-07 14:39:17');
INSERT INTO votes VALUES ('567', '29', '6009', '2013-05-07 14:39:25');
INSERT INTO votes VALUES ('568', '29', '6003', '2013-05-07 14:39:37');
INSERT INTO votes VALUES ('569', '29', '6003', '2013-05-07 14:39:40');
INSERT INTO votes VALUES ('570', '29', '5991', '2013-05-07 14:40:14');
INSERT INTO votes VALUES ('571', '29', '5990', '2013-05-07 14:44:51');
INSERT INTO votes VALUES ('572', '29', '5990', '2013-05-07 14:45:16');
INSERT INTO votes VALUES ('573', '29', '5990', '2013-05-07 14:45:18');
INSERT INTO votes VALUES ('574', '29', '5990', '2013-05-07 14:45:20');
INSERT INTO votes VALUES ('575', '29', '5990', '2013-05-07 14:45:23');
INSERT INTO votes VALUES ('576', '29', '5990', '2013-05-07 14:45:25');
INSERT INTO votes VALUES ('577', '29', '5990', '2013-05-07 14:45:29');
INSERT INTO votes VALUES ('587', '29', '5986', '2013-05-07 15:25:33');
INSERT INTO votes VALUES ('588', '29', '5986', '2013-05-07 15:25:36');
INSERT INTO votes VALUES ('589', '29', '5990', '2013-05-07 15:25:57');
INSERT INTO votes VALUES ('590', '29', '5990', '2013-05-07 15:29:53');
INSERT INTO votes VALUES ('591', '29', '5990', '2013-05-07 15:41:14');
INSERT INTO votes VALUES ('592', '29', '5990', '2013-05-07 15:41:29');
INSERT INTO votes VALUES ('593', '29', '5986', '2013-05-07 15:42:00');
INSERT INTO votes VALUES ('594', '29', '5986', '2013-05-07 15:42:06');
INSERT INTO votes VALUES ('595', '29', '5986', '2013-05-07 15:42:30');
INSERT INTO votes VALUES ('596', '29', '5986', '2013-05-07 15:42:34');
INSERT INTO votes VALUES ('597', '29', '5990', '2013-05-07 15:43:27');
INSERT INTO votes VALUES ('598', '29', '5990', '2013-05-07 15:44:26');
INSERT INTO votes VALUES ('599', '29', '5990', '2013-05-07 15:47:28');
INSERT INTO votes VALUES ('600', '29', '5990', '2013-05-07 15:48:38');
INSERT INTO votes VALUES ('601', '29', '5990', '2013-05-07 15:48:46');
INSERT INTO votes VALUES ('602', '29', '5990', '2013-05-07 15:48:50');
INSERT INTO votes VALUES ('603', '29', '5990', '2013-05-07 15:49:22');
INSERT INTO votes VALUES ('604', '29', '5990', '2013-05-07 15:50:21');
INSERT INTO votes VALUES ('605', '29', '5990', '2013-05-07 15:50:26');
INSERT INTO votes VALUES ('606', '29', '5990', '2013-05-07 15:50:38');
INSERT INTO votes VALUES ('607', '29', '5990', '2013-05-07 15:50:43');
INSERT INTO votes VALUES ('608', '29', '5991', '2013-05-07 15:51:31');
INSERT INTO votes VALUES ('609', '29', '5990', '2013-05-07 16:12:13');
INSERT INTO votes VALUES ('610', '29', '5990', '2013-05-07 16:12:17');
INSERT INTO votes VALUES ('611', '29', '5990', '2013-05-07 16:18:12');
INSERT INTO votes VALUES ('612', '29', '5990', '2013-05-07 16:18:23');
INSERT INTO votes VALUES ('613', '29', '5990', '2013-05-07 16:18:58');
INSERT INTO votes VALUES ('614', '29', '5990', '2013-05-07 16:19:30');
INSERT INTO votes VALUES ('615', '29', '6101', '2013-05-07 16:26:01');
INSERT INTO votes VALUES ('616', '29', '6004', '2013-05-07 16:29:42');
INSERT INTO votes VALUES ('617', '29', '5982', '2013-05-07 16:58:24');
INSERT INTO votes VALUES ('618', '29', '6016', '2013-05-07 17:19:43');
INSERT INTO votes VALUES ('619', '29', '6020', '2013-05-07 17:21:14');
INSERT INTO votes VALUES ('620', '29', '6009', '2013-05-07 17:21:38');
INSERT INTO votes VALUES ('621', '29', '6021', '2013-05-07 17:22:03');
INSERT INTO votes VALUES ('622', '29', '6021', '2013-05-07 17:22:07');
INSERT INTO votes VALUES ('623', '29', '6021', '2013-05-07 17:22:10');
INSERT INTO votes VALUES ('624', '29', '6460', '2013-05-07 17:24:50');
INSERT INTO votes VALUES ('625', '29', '6470', '2013-05-07 17:25:55');
INSERT INTO votes VALUES ('626', '29', '6471', '2013-05-07 17:26:06');
INSERT INTO votes VALUES ('627', '29', '6472', '2013-05-07 17:26:10');
INSERT INTO votes VALUES ('628', '29', '6473', '2013-05-07 17:26:13');
INSERT INTO votes VALUES ('629', '29', '6474', '2013-05-07 17:26:16');
INSERT INTO votes VALUES ('630', '29', '6462', '2013-05-07 17:26:47');
INSERT INTO votes VALUES ('631', '29', '6469', '2013-05-07 17:28:14');
INSERT INTO votes VALUES ('632', '29', '6492', '2013-05-07 17:42:26');
INSERT INTO votes VALUES ('633', '29', '6483', '2013-05-07 17:43:20');
INSERT INTO votes VALUES ('634', '29', '6491', '2013-05-07 17:45:52');
INSERT INTO votes VALUES ('635', '29', '6492', '2013-05-07 17:46:14');
INSERT INTO votes VALUES ('636', '29', '6492', '2013-05-07 17:47:39');
INSERT INTO votes VALUES ('637', '29', '5986', '2013-05-07 17:48:05');
INSERT INTO votes VALUES ('638', '29', '5986', '2013-05-07 17:48:09');
INSERT INTO votes VALUES ('639', '29', '5986', '2013-05-07 17:48:12');
INSERT INTO votes VALUES ('640', '29', '5990', '2013-05-07 17:48:29');
INSERT INTO votes VALUES ('641', '29', '5990', '2013-05-07 17:48:32');
INSERT INTO votes VALUES ('642', '29', '6492', '2013-05-07 17:48:39');
INSERT INTO votes VALUES ('643', '29', '6492', '2013-05-07 17:48:44');
INSERT INTO votes VALUES ('644', '29', '6492', '2013-05-07 17:48:47');
INSERT INTO votes VALUES ('645', '29', '6492', '2013-05-07 17:48:51');
INSERT INTO votes VALUES ('646', '29', '6492', '2013-05-07 17:48:55');
INSERT INTO votes VALUES ('647', '29', '6492', '2013-05-07 17:48:58');
INSERT INTO votes VALUES ('648', '29', '6492', '2013-05-07 17:49:42');
INSERT INTO votes VALUES ('649', '29', '6492', '2013-05-07 17:49:47');
INSERT INTO votes VALUES ('650', '29', '6492', '2013-05-07 17:49:52');
INSERT INTO votes VALUES ('651', '29', '5990', '2013-05-07 17:50:19');
INSERT INTO votes VALUES ('652', '29', '5990', '2013-05-07 17:50:27');
INSERT INTO votes VALUES ('653', '29', '6476', '2013-05-07 17:50:55');
INSERT INTO votes VALUES ('654', '29', '6489', '2013-05-07 17:51:11');
INSERT INTO votes VALUES ('655', '29', '6490', '2013-05-07 17:51:15');
INSERT INTO votes VALUES ('656', '29', '6493', '2013-05-07 17:51:25');
INSERT INTO votes VALUES ('657', '29', '6484', '2013-05-07 17:51:53');
INSERT INTO votes VALUES ('658', '29', '6487', '2013-05-07 17:52:11');
INSERT INTO votes VALUES ('659', '29', '6477', '2013-05-07 17:52:32');
INSERT INTO votes VALUES ('660', '29', '6478', '2013-05-07 17:52:39');
INSERT INTO votes VALUES ('661', '29', '6479', '2013-05-07 17:52:43');
INSERT INTO votes VALUES ('662', '29', '6480', '2013-05-07 17:52:48');
INSERT INTO votes VALUES ('663', '29', '6481', '2013-05-07 17:52:55');
INSERT INTO votes VALUES ('664', '29', '6482', '2013-05-07 17:53:06');
INSERT INTO votes VALUES ('665', '29', '6485', '2013-05-07 17:53:16');
INSERT INTO votes VALUES ('666', '29', '6486', '2013-05-07 17:53:21');
INSERT INTO votes VALUES ('667', '29', '6496', '2013-05-07 17:53:36');
INSERT INTO votes VALUES ('668', '29', '6359', '2013-05-07 18:08:04');
INSERT INTO votes VALUES ('669', '29', '6359', '2013-05-07 18:08:27');
INSERT INTO votes VALUES ('670', '29', '6359', '2013-05-07 18:08:30');
INSERT INTO votes VALUES ('671', '29', '6359', '2013-05-07 18:08:32');
INSERT INTO votes VALUES ('672', '29', '6359', '2013-05-07 18:08:34');
INSERT INTO votes VALUES ('673', '29', '5990', '2013-05-07 18:09:06');
INSERT INTO votes VALUES ('674', '29', '6023', '2013-05-08 22:45:37');
INSERT INTO votes VALUES ('675', '29', '6023', '2013-05-08 22:45:40');
INSERT INTO votes VALUES ('676', '29', '6471', '2013-05-09 00:12:14');
INSERT INTO votes VALUES ('677', '29', '5986', '2013-05-09 01:33:31');
INSERT INTO votes VALUES ('678', '29', '5986', '2013-05-09 10:29:49');
INSERT INTO votes VALUES ('679', '29', '5990', '2013-05-09 10:30:59');
INSERT INTO votes VALUES ('680', '29', '6008', '2013-05-10 20:57:16');
INSERT INTO votes VALUES ('681', '29', '6098', '2013-05-12 15:23:02');
INSERT INTO votes VALUES ('682', '29', '5986', '2013-05-13 12:24:38');
INSERT INTO votes VALUES ('683', '29', '5986', '2013-05-20 01:12:43');
INSERT INTO votes VALUES ('684', '29', '5990', '2013-05-26 09:25:17');
INSERT INTO votes VALUES ('685', '29', '6005', '2013-06-09 00:51:59');
INSERT INTO votes VALUES ('686', '29', '5982', '2013-06-09 00:52:07');
INSERT INTO votes VALUES ('687', '29', '5983', '2013-06-09 00:52:22');
INSERT INTO votes VALUES ('688', '29', '6003', '2013-06-12 12:53:29');
INSERT INTO votes VALUES ('689', '29', '6004', '2013-06-12 12:53:52');
INSERT INTO votes VALUES ('690', '29', '5995', '2013-06-12 12:58:22');
INSERT INTO votes VALUES ('691', '29', '5990', '2013-06-12 13:19:24');
INSERT INTO votes VALUES ('692', '29', '6005', '2013-06-12 13:21:07');
INSERT INTO votes VALUES ('693', '29', '6006', '2013-06-12 13:25:31');
INSERT INTO votes VALUES ('694', '29', '6007', '2013-06-12 13:25:41');
INSERT INTO votes VALUES ('695', '29', '7978', '2013-06-13 10:33:32');
INSERT INTO votes VALUES ('696', '29', '7980', '2013-06-13 10:34:08');
INSERT INTO votes VALUES ('697', '29', '7977', '2013-06-13 10:34:15');
INSERT INTO votes VALUES ('698', '29', '7977', '2013-06-13 10:34:25');
INSERT INTO votes VALUES ('699', '29', '7998', '2013-06-13 10:34:40');
INSERT INTO votes VALUES ('700', '29', '7998', '2013-06-13 10:34:43');
INSERT INTO votes VALUES ('701', '29', '7998', '2013-06-13 10:34:45');
INSERT INTO votes VALUES ('702', '29', '7922', '2013-06-13 10:35:10');
INSERT INTO votes VALUES ('703', '29', '7922', '2013-06-13 10:35:14');
INSERT INTO votes VALUES ('704', '29', '7922', '2013-06-13 10:35:17');
INSERT INTO votes VALUES ('705', '29', '7960', '2013-06-13 10:35:30');
INSERT INTO votes VALUES ('706', '29', '7960', '2013-06-13 10:35:34');
INSERT INTO votes VALUES ('707', '29', '7960', '2013-06-13 10:35:36');
INSERT INTO votes VALUES ('708', '29', '7960', '2013-06-13 10:35:39');
INSERT INTO votes VALUES ('709', '29', '7960', '2013-06-13 10:35:41');
INSERT INTO votes VALUES ('710', '29', '7960', '2013-06-13 10:35:44');
INSERT INTO votes VALUES ('711', '29', '7960', '2013-06-13 10:35:47');
INSERT INTO votes VALUES ('712', '29', '7742', '2013-06-13 10:37:24');
INSERT INTO votes VALUES ('713', '29', '7745', '2013-06-13 10:37:37');
INSERT INTO votes VALUES ('714', '29', '7744', '2013-06-13 10:37:43');
INSERT INTO votes VALUES ('715', '29', '7380', '2013-06-13 10:38:22');
INSERT INTO votes VALUES ('716', '29', '7380', '2013-06-13 10:38:25');
INSERT INTO votes VALUES ('717', '29', '7380', '2013-06-13 12:03:51');
INSERT INTO votes VALUES ('718', '29', '7380', '2013-06-13 12:03:54');
INSERT INTO votes VALUES ('719', '29', '7380', '2013-06-13 12:04:06');
INSERT INTO votes VALUES ('720', '29', '7380', '2013-06-21 04:05:19');
INSERT INTO votes VALUES ('721', '29', '7380', '2013-06-21 04:05:23');
INSERT INTO votes VALUES ('722', '29', '7380', '2013-06-21 04:05:26');
INSERT INTO votes VALUES ('723', '29', '7922', '2013-06-21 04:05:54');
INSERT INTO votes VALUES ('724', '29', '7922', '2013-06-21 04:05:57');
INSERT INTO votes VALUES ('725', '29', '7922', '2013-06-21 04:06:19');
INSERT INTO votes VALUES ('726', '29', '7922', '2013-06-21 04:06:23');
INSERT INTO votes VALUES ('727', '29', '7922', '2013-06-21 04:06:31');
INSERT INTO votes VALUES ('728', '29', '8017', '2013-06-27 01:19:23');
INSERT INTO votes VALUES ('729', '29', '8017', '2013-06-27 01:19:27');
INSERT INTO votes VALUES ('730', '29', '8010', '2013-06-27 01:19:38');
INSERT INTO votes VALUES ('731', '29', '8010', '2013-06-27 01:19:41');
INSERT INTO votes VALUES ('732', '29', '8025', '2013-06-27 01:19:50');
INSERT INTO votes VALUES ('733', '29', '8025', '2013-06-27 01:19:53');
INSERT INTO votes VALUES ('734', '29', '8025', '2013-06-27 01:19:55');
INSERT INTO votes VALUES ('735', '29', '8029', '2013-06-27 01:20:07');
INSERT INTO votes VALUES ('736', '29', '8029', '2013-06-27 01:20:09');
INSERT INTO votes VALUES ('737', '29', '8029', '2013-06-27 01:20:12');
INSERT INTO votes VALUES ('738', '29', '8035', '2013-06-27 01:20:19');
INSERT INTO votes VALUES ('739', '29', '8035', '2013-06-27 01:20:24');
INSERT INTO votes VALUES ('740', '29', '8035', '2013-06-27 01:20:27');
INSERT INTO votes VALUES ('741', '29', '8035', '2013-06-27 01:20:29');
INSERT INTO votes VALUES ('742', '29', '8419', '2013-06-27 01:21:29');
INSERT INTO votes VALUES ('743', '29', '8419', '2013-06-27 01:21:32');
INSERT INTO votes VALUES ('744', '29', '8351', '2013-06-27 01:21:56');
INSERT INTO votes VALUES ('745', '29', '8351', '2013-06-27 01:21:59');
INSERT INTO votes VALUES ('746', '29', '8351', '2013-06-27 01:22:02');
INSERT INTO votes VALUES ('747', '29', '8351', '2013-06-27 01:22:04');
INSERT INTO votes VALUES ('748', '29', '8372', '2013-06-27 01:22:47');
INSERT INTO votes VALUES ('749', '29', '8372', '2013-06-27 01:22:49');
INSERT INTO votes VALUES ('750', '29', '8372', '2013-06-27 01:22:52');
INSERT INTO votes VALUES ('751', '29', '8010', '2013-06-27 01:23:11');
INSERT INTO votes VALUES ('752', '29', '8010', '2013-06-27 01:23:13');
INSERT INTO votes VALUES ('753', '29', '8296', '2013-06-27 01:24:05');
INSERT INTO votes VALUES ('754', '29', '8296', '2013-06-27 01:24:08');
INSERT INTO votes VALUES ('755', '29', '8296', '2013-06-27 01:24:10');
INSERT INTO votes VALUES ('756', '29', '8296', '2013-06-27 01:24:13');
INSERT INTO votes VALUES ('757', '29', '8296', '2013-06-27 01:24:15');
INSERT INTO votes VALUES ('758', '29', '8296', '2013-06-27 01:24:18');
INSERT INTO votes VALUES ('759', '29', '8296', '2013-06-27 01:24:20');
INSERT INTO votes VALUES ('760', '29', '8372', '2013-06-27 01:34:19');
INSERT INTO votes VALUES ('761', '29', '8372', '2013-06-27 01:34:22');
INSERT INTO votes VALUES ('762', '29', '8372', '2013-06-27 01:34:26');
INSERT INTO votes VALUES ('763', '29', '8351', '2013-06-27 01:34:34');
INSERT INTO votes VALUES ('764', '29', '8351', '2013-06-27 01:34:38');
INSERT INTO votes VALUES ('765', '29', '8449', '2013-06-27 01:35:35');
INSERT INTO votes VALUES ('766', '29', '8449', '2013-06-27 01:35:38');
INSERT INTO votes VALUES ('767', '29', '8449', '2013-06-27 01:35:41');
INSERT INTO votes VALUES ('768', '29', '8449', '2013-06-27 01:36:12');
INSERT INTO votes VALUES ('769', '29', '8449', '2013-06-27 01:36:15');
INSERT INTO votes VALUES ('770', '29', '8154', '2013-06-27 01:37:33');
INSERT INTO votes VALUES ('771', '29', '8154', '2013-06-27 01:37:36');
INSERT INTO votes VALUES ('772', '29', '8154', '2013-06-27 01:37:39');
INSERT INTO votes VALUES ('773', '29', '8154', '2013-06-27 01:37:41');
INSERT INTO votes VALUES ('774', '29', '8154', '2013-06-27 01:37:44');
INSERT INTO votes VALUES ('775', '29', '8449', '2013-06-27 01:38:03');
INSERT INTO votes VALUES ('776', '29', '8449', '2013-06-27 01:38:06');
INSERT INTO votes VALUES ('777', '29', '8372', '2013-06-27 01:38:15');
INSERT INTO votes VALUES ('778', '29', '8372', '2013-06-27 01:38:17');
INSERT INTO votes VALUES ('779', '29', '8296', '2013-06-27 01:38:40');
INSERT INTO votes VALUES ('780', '29', '8296', '2013-06-27 01:38:42');
INSERT INTO votes VALUES ('781', '29', '8296', '2013-06-27 01:38:46');
INSERT INTO votes VALUES ('782', '29', '7804', '2013-06-30 20:05:10');
INSERT INTO votes VALUES ('783', '29', '7804', '2013-06-30 20:05:11');
INSERT INTO votes VALUES ('784', '29', '7804', '2013-06-30 20:05:12');
INSERT INTO votes VALUES ('785', '29', '7804', '2013-06-30 20:05:13');
INSERT INTO votes VALUES ('786', '29', '7804', '2013-06-30 20:05:14');
INSERT INTO votes VALUES ('787', '29', '7804', '2013-06-30 20:05:15');
INSERT INTO votes VALUES ('788', '29', '7804', '2013-06-30 20:05:15');
INSERT INTO votes VALUES ('789', '29', '7804', '2013-06-30 20:05:16');
INSERT INTO votes VALUES ('790', '29', '7922', '2013-06-30 20:05:49');
INSERT INTO votes VALUES ('791', '29', '7302', '2013-06-30 22:08:43');
INSERT INTO votes VALUES ('792', '29', '7309', '2013-06-30 22:09:04');
INSERT INTO votes VALUES ('793', '29', '7309', '2013-06-30 22:09:04');
INSERT INTO votes VALUES ('794', '29', '7309', '2013-06-30 22:09:05');
INSERT INTO votes VALUES ('795', '29', '7309', '2013-06-30 22:09:07');
INSERT INTO votes VALUES ('796', '29', '7309', '2013-06-30 22:09:08');
INSERT INTO votes VALUES ('797', '29', '7309', '2013-06-30 22:09:08');
INSERT INTO votes VALUES ('798', '29', '7309', '2013-06-30 22:09:09');
INSERT INTO votes VALUES ('799', '29', '7309', '2013-06-30 22:09:10');
INSERT INTO votes VALUES ('800', '29', '7309', '2013-06-30 22:09:11');
INSERT INTO votes VALUES ('801', '29', '7309', '2013-06-30 22:09:12');
INSERT INTO votes VALUES ('802', '29', '7309', '2013-06-30 22:09:13');
INSERT INTO votes VALUES ('803', '29', '7309', '2013-06-30 22:09:14');
INSERT INTO votes VALUES ('804', '29', '7316', '2013-06-30 22:09:29');
INSERT INTO votes VALUES ('805', '29', '7316', '2013-06-30 22:09:29');
INSERT INTO votes VALUES ('806', '29', '7316', '2013-06-30 22:09:29');
INSERT INTO votes VALUES ('807', '29', '7316', '2013-06-30 22:09:30');
INSERT INTO votes VALUES ('808', '29', '7316', '2013-06-30 22:09:30');
INSERT INTO votes VALUES ('809', '29', '7316', '2013-06-30 22:09:30');
INSERT INTO votes VALUES ('810', '29', '7320', '2013-06-30 22:09:42');
INSERT INTO votes VALUES ('811', '29', '7327', '2013-06-30 22:09:52');
INSERT INTO votes VALUES ('812', '29', '7327', '2013-06-30 22:09:53');
INSERT INTO votes VALUES ('813', '29', '7327', '2013-06-30 22:09:53');
INSERT INTO votes VALUES ('814', '29', '7327', '2013-06-30 22:09:53');
INSERT INTO votes VALUES ('815', '29', '7327', '2013-06-30 22:09:54');
INSERT INTO votes VALUES ('816', '29', '7327', '2013-06-30 22:09:54');
INSERT INTO votes VALUES ('817', '29', '7327', '2013-06-30 22:09:54');
INSERT INTO votes VALUES ('818', '29', '7327', '2013-06-30 22:09:54');
INSERT INTO votes VALUES ('819', '29', '7327', '2013-06-30 22:09:54');
INSERT INTO votes VALUES ('820', '29', '7327', '2013-06-30 22:09:55');
INSERT INTO votes VALUES ('821', '29', '7327', '2013-06-30 22:09:55');
INSERT INTO votes VALUES ('822', '29', '7328', '2013-06-30 22:09:58');
INSERT INTO votes VALUES ('823', '29', '7328', '2013-06-30 22:09:59');
INSERT INTO votes VALUES ('824', '29', '7328', '2013-06-30 22:09:59');
INSERT INTO votes VALUES ('825', '29', '7328', '2013-06-30 22:09:59');
INSERT INTO votes VALUES ('826', '29', '7328', '2013-06-30 22:09:59');
INSERT INTO votes VALUES ('827', '29', '7328', '2013-06-30 22:09:59');
INSERT INTO votes VALUES ('828', '29', '7328', '2013-06-30 22:10:00');
INSERT INTO votes VALUES ('829', '29', '7328', '2013-06-30 22:10:00');
INSERT INTO votes VALUES ('830', '29', '7328', '2013-06-30 22:10:00');
INSERT INTO votes VALUES ('831', '29', '7328', '2013-06-30 22:10:00');
INSERT INTO votes VALUES ('832', '29', '7328', '2013-06-30 22:10:00');
INSERT INTO votes VALUES ('833', '29', '7328', '2013-06-30 22:10:00');
INSERT INTO votes VALUES ('834', '29', '7328', '2013-06-30 22:10:01');
INSERT INTO votes VALUES ('835', '29', '7328', '2013-06-30 22:10:01');
INSERT INTO votes VALUES ('836', '29', '7328', '2013-06-30 22:10:01');
INSERT INTO votes VALUES ('837', '29', '7328', '2013-06-30 22:10:01');
INSERT INTO votes VALUES ('838', '29', '7329', '2013-06-30 22:10:04');
INSERT INTO votes VALUES ('839', '29', '7329', '2013-06-30 22:10:05');
INSERT INTO votes VALUES ('840', '29', '7329', '2013-06-30 22:10:05');
INSERT INTO votes VALUES ('841', '29', '7329', '2013-06-30 22:10:05');
INSERT INTO votes VALUES ('842', '29', '7329', '2013-06-30 22:10:06');
INSERT INTO votes VALUES ('843', '29', '7329', '2013-06-30 22:10:06');
INSERT INTO votes VALUES ('844', '29', '7329', '2013-06-30 22:10:06');
INSERT INTO votes VALUES ('845', '29', '7329', '2013-06-30 22:10:06');
INSERT INTO votes VALUES ('846', '29', '7329', '2013-06-30 22:10:06');
INSERT INTO votes VALUES ('847', '29', '7329', '2013-06-30 22:10:06');
INSERT INTO votes VALUES ('848', '29', '7681', '2013-06-30 23:44:51');
INSERT INTO votes VALUES ('849', '29', '7681', '2013-06-30 23:44:52');
INSERT INTO votes VALUES ('850', '29', '7681', '2013-06-30 23:44:52');
INSERT INTO votes VALUES ('851', '29', '7681', '2013-06-30 23:44:53');
INSERT INTO votes VALUES ('852', '29', '7681', '2013-06-30 23:44:54');
INSERT INTO votes VALUES ('853', '29', '7681', '2013-06-30 23:44:57');
INSERT INTO votes VALUES ('854', '29', '7682', '2013-06-30 23:44:59');
INSERT INTO votes VALUES ('855', '29', '7682', '2013-06-30 23:44:59');
INSERT INTO votes VALUES ('856', '29', '7682', '2013-06-30 23:45:00');
INSERT INTO votes VALUES ('857', '29', '7682', '2013-06-30 23:45:00');
INSERT INTO votes VALUES ('858', '29', '7682', '2013-06-30 23:45:00');
INSERT INTO votes VALUES ('859', '29', '7682', '2013-06-30 23:45:01');
INSERT INTO votes VALUES ('860', '29', '7683', '2013-06-30 23:45:04');
INSERT INTO votes VALUES ('861', '29', '7683', '2013-06-30 23:45:04');
INSERT INTO votes VALUES ('862', '29', '7683', '2013-06-30 23:45:04');
INSERT INTO votes VALUES ('863', '29', '7683', '2013-06-30 23:45:04');
INSERT INTO votes VALUES ('864', '29', '7683', '2013-06-30 23:45:05');
INSERT INTO votes VALUES ('865', '29', '7683', '2013-06-30 23:45:05');
INSERT INTO votes VALUES ('866', '29', '7683', '2013-06-30 23:45:05');
INSERT INTO votes VALUES ('867', '29', '7684', '2013-06-30 23:45:08');
INSERT INTO votes VALUES ('868', '29', '7684', '2013-06-30 23:45:09');
INSERT INTO votes VALUES ('869', '29', '7684', '2013-06-30 23:45:09');
INSERT INTO votes VALUES ('870', '29', '7684', '2013-06-30 23:45:10');
INSERT INTO votes VALUES ('871', '29', '7684', '2013-06-30 23:45:10');
INSERT INTO votes VALUES ('872', '29', '7689', '2013-06-30 23:46:32');
INSERT INTO votes VALUES ('873', '29', '7689', '2013-06-30 23:46:32');
INSERT INTO votes VALUES ('874', '29', '7689', '2013-06-30 23:46:32');
INSERT INTO votes VALUES ('875', '29', '7689', '2013-06-30 23:46:33');
INSERT INTO votes VALUES ('876', '29', '7689', '2013-06-30 23:46:33');
INSERT INTO votes VALUES ('877', '29', '7689', '2013-06-30 23:46:33');
INSERT INTO votes VALUES ('878', '29', '7689', '2013-06-30 23:46:33');
INSERT INTO votes VALUES ('879', '29', '7689', '2013-06-30 23:46:34');
INSERT INTO votes VALUES ('880', '29', '7689', '2013-06-30 23:46:34');
INSERT INTO votes VALUES ('881', '29', '7689', '2013-06-30 23:46:34');
INSERT INTO votes VALUES ('882', '29', '7690', '2013-06-30 23:46:37');
INSERT INTO votes VALUES ('883', '29', '7690', '2013-06-30 23:46:37');
INSERT INTO votes VALUES ('884', '29', '7690', '2013-06-30 23:46:37');
INSERT INTO votes VALUES ('885', '29', '7690', '2013-06-30 23:46:37');
INSERT INTO votes VALUES ('886', '29', '7690', '2013-06-30 23:46:38');
INSERT INTO votes VALUES ('887', '29', '7690', '2013-06-30 23:46:38');
INSERT INTO votes VALUES ('888', '29', '7690', '2013-06-30 23:46:38');
INSERT INTO votes VALUES ('889', '29', '7690', '2013-06-30 23:46:38');
INSERT INTO votes VALUES ('890', '29', '7690', '2013-06-30 23:46:38');
INSERT INTO votes VALUES ('891', '29', '7706', '2013-06-30 23:47:12');
INSERT INTO votes VALUES ('892', '29', '7706', '2013-06-30 23:47:12');
INSERT INTO votes VALUES ('893', '29', '7706', '2013-06-30 23:47:13');
INSERT INTO votes VALUES ('894', '29', '7706', '2013-06-30 23:47:13');
INSERT INTO votes VALUES ('895', '29', '7706', '2013-06-30 23:47:13');
INSERT INTO votes VALUES ('896', '29', '7706', '2013-06-30 23:47:13');
INSERT INTO votes VALUES ('897', '29', '7706', '2013-06-30 23:47:13');
INSERT INTO votes VALUES ('898', '29', '7724', '2013-06-30 23:47:50');
INSERT INTO votes VALUES ('899', '29', '7724', '2013-06-30 23:47:50');
INSERT INTO votes VALUES ('900', '29', '7724', '2013-06-30 23:47:51');
INSERT INTO votes VALUES ('901', '29', '7730', '2013-07-01 00:00:05');
INSERT INTO votes VALUES ('902', '29', '7730', '2013-07-01 00:00:06');
INSERT INTO votes VALUES ('903', '29', '7730', '2013-07-01 00:00:06');
INSERT INTO votes VALUES ('904', '29', '7730', '2013-07-01 00:00:06');
INSERT INTO votes VALUES ('905', '29', '7730', '2013-07-01 00:00:07');
INSERT INTO votes VALUES ('906', '29', '7730', '2013-07-01 00:00:07');
INSERT INTO votes VALUES ('907', '29', '7730', '2013-07-01 00:00:07');
INSERT INTO votes VALUES ('908', '29', '7731', '2013-07-01 00:00:10');
INSERT INTO votes VALUES ('909', '29', '7731', '2013-07-01 00:00:10');
INSERT INTO votes VALUES ('910', '29', '7731', '2013-07-01 00:00:10');
INSERT INTO votes VALUES ('911', '29', '7731', '2013-07-01 00:00:10');
INSERT INTO votes VALUES ('912', '29', '7731', '2013-07-01 00:00:10');
INSERT INTO votes VALUES ('913', '29', '7735', '2013-07-01 00:00:49');
INSERT INTO votes VALUES ('914', '29', '7735', '2013-07-01 00:00:50');
INSERT INTO votes VALUES ('915', '29', '7683', '2013-07-01 00:06:16');
INSERT INTO votes VALUES ('916', '29', '7684', '2013-07-01 00:06:37');
INSERT INTO votes VALUES ('917', '29', '7684', '2013-07-01 00:06:38');
INSERT INTO votes VALUES ('918', '29', '7684', '2013-07-01 00:06:38');
INSERT INTO votes VALUES ('919', '29', '7684', '2013-07-01 00:06:38');
INSERT INTO votes VALUES ('920', '29', '7684', '2013-07-01 00:06:38');
INSERT INTO votes VALUES ('921', '29', '7684', '2013-07-01 00:06:38');
INSERT INTO votes VALUES ('922', '29', '7684', '2013-07-01 00:06:39');
INSERT INTO votes VALUES ('923', '29', '7694', '2013-07-01 00:08:29');
INSERT INTO votes VALUES ('924', '29', '7694', '2013-07-01 00:08:29');
INSERT INTO votes VALUES ('925', '29', '7694', '2013-07-01 00:08:30');
INSERT INTO votes VALUES ('926', '29', '7694', '2013-07-01 00:08:30');
INSERT INTO votes VALUES ('927', '29', '7694', '2013-07-01 00:08:30');
INSERT INTO votes VALUES ('928', '29', '7694', '2013-07-01 00:08:30');
INSERT INTO votes VALUES ('929', '29', '7694', '2013-07-01 00:08:30');
INSERT INTO votes VALUES ('930', '29', '7253', '2013-07-01 15:48:37');
INSERT INTO votes VALUES ('931', '29', '7550', '2013-07-01 15:49:23');
INSERT INTO votes VALUES ('932', '29', '7550', '2013-07-01 15:49:24');
INSERT INTO votes VALUES ('933', '29', '7550', '2013-07-01 15:49:25');
INSERT INTO votes VALUES ('934', '29', '7550', '2013-07-01 15:49:25');
INSERT INTO votes VALUES ('935', '29', '7550', '2013-07-01 15:49:26');
INSERT INTO votes VALUES ('936', '29', '7550', '2013-07-01 15:49:28');
INSERT INTO votes VALUES ('937', '29', '7550', '2013-07-01 15:49:29');
INSERT INTO votes VALUES ('938', '29', '7547', '2013-07-01 15:49:49');
INSERT INTO votes VALUES ('939', '29', '7547', '2013-07-01 15:49:49');
INSERT INTO votes VALUES ('940', '29', '7547', '2013-07-01 15:49:50');
INSERT INTO votes VALUES ('941', '29', '7547', '2013-07-01 15:49:50');
INSERT INTO votes VALUES ('942', '29', '7547', '2013-07-01 15:49:50');
INSERT INTO votes VALUES ('943', '29', '7547', '2013-07-01 15:49:50');
INSERT INTO votes VALUES ('944', '29', '7559', '2013-07-01 15:49:59');
INSERT INTO votes VALUES ('945', '29', '7559', '2013-07-01 15:49:59');
INSERT INTO votes VALUES ('946', '29', '7559', '2013-07-01 15:49:59');
INSERT INTO votes VALUES ('947', '29', '7559', '2013-07-01 15:49:59');
INSERT INTO votes VALUES ('948', '29', '7559', '2013-07-01 15:49:59');
INSERT INTO votes VALUES ('949', '29', '7559', '2013-07-01 15:50:00');
INSERT INTO votes VALUES ('950', '29', '7652', '2013-07-01 15:50:11');
INSERT INTO votes VALUES ('951', '29', '7652', '2013-07-01 15:50:11');
INSERT INTO votes VALUES ('952', '29', '7652', '2013-07-01 15:50:11');
INSERT INTO votes VALUES ('953', '29', '7652', '2013-07-01 15:50:12');
INSERT INTO votes VALUES ('954', '29', '7652', '2013-07-01 15:50:12');
INSERT INTO votes VALUES ('955', '29', '7652', '2013-07-01 15:50:12');
INSERT INTO votes VALUES ('956', '29', '7658', '2013-07-01 15:50:20');
INSERT INTO votes VALUES ('957', '29', '7658', '2013-07-01 15:50:20');
INSERT INTO votes VALUES ('958', '29', '7658', '2013-07-01 15:50:20');
INSERT INTO votes VALUES ('959', '29', '7658', '2013-07-01 15:50:21');
INSERT INTO votes VALUES ('960', '29', '7662', '2013-07-01 15:50:31');
INSERT INTO votes VALUES ('961', '29', '7662', '2013-07-01 15:50:31');
INSERT INTO votes VALUES ('962', '29', '7662', '2013-07-01 15:50:31');
INSERT INTO votes VALUES ('963', '29', '7662', '2013-07-01 15:50:32');
INSERT INTO votes VALUES ('964', '29', '7662', '2013-07-01 15:50:32');
INSERT INTO votes VALUES ('965', '29', '7662', '2013-07-01 15:50:32');
INSERT INTO votes VALUES ('966', '29', '7662', '2013-07-01 15:50:32');
INSERT INTO votes VALUES ('967', '29', '7662', '2013-07-01 15:50:32');
INSERT INTO votes VALUES ('968', '29', '7662', '2013-07-01 15:50:33');
INSERT INTO votes VALUES ('969', '29', '7747', '2013-07-01 15:50:59');
INSERT INTO votes VALUES ('970', '29', '7747', '2013-07-01 15:51:00');
INSERT INTO votes VALUES ('971', '29', '7747', '2013-07-01 15:51:01');
INSERT INTO votes VALUES ('972', '29', '7853', '2013-07-01 15:51:48');
INSERT INTO votes VALUES ('973', '29', '7853', '2013-07-01 15:51:48');
INSERT INTO votes VALUES ('974', '29', '7853', '2013-07-01 15:51:48');
INSERT INTO votes VALUES ('975', '29', '7853', '2013-07-01 15:51:49');
INSERT INTO votes VALUES ('976', '29', '7853', '2013-07-01 15:51:49');
INSERT INTO votes VALUES ('977', '29', '7853', '2013-07-01 15:51:50');
INSERT INTO votes VALUES ('978', '29', '7864', '2013-07-01 15:51:56');
INSERT INTO votes VALUES ('979', '29', '7864', '2013-07-01 15:51:56');
INSERT INTO votes VALUES ('980', '29', '7864', '2013-07-01 15:51:57');
INSERT INTO votes VALUES ('981', '29', '8012', '2013-07-01 22:15:49');
INSERT INTO votes VALUES ('982', '29', '8046', '2013-07-01 22:16:09');
INSERT INTO votes VALUES ('983', '29', '8036', '2013-07-01 22:16:52');
INSERT INTO votes VALUES ('984', '29', '7259', '2013-07-09 12:27:25');
INSERT INTO votes VALUES ('985', '29', '7289', '2013-07-09 19:00:19');
INSERT INTO votes VALUES ('986', '29', '7289', '2013-07-09 19:00:22');
INSERT INTO votes VALUES ('987', '29', '7289', '2013-07-09 19:00:24');
INSERT INTO votes VALUES ('988', '29', '9779', '2013-07-10 19:58:29');
INSERT INTO votes VALUES ('989', '29', '9779', '2013-07-10 19:58:30');
INSERT INTO votes VALUES ('990', '29', '9779', '2013-07-10 19:58:30');
INSERT INTO votes VALUES ('991', '29', '9779', '2013-07-10 19:58:30');
INSERT INTO votes VALUES ('992', '29', '9779', '2013-07-10 19:58:30');
INSERT INTO votes VALUES ('993', '29', '9779', '2013-07-10 19:58:31');
INSERT INTO votes VALUES ('994', '29', '9779', '2013-07-10 19:58:31');
INSERT INTO votes VALUES ('995', '29', '9779', '2013-07-10 19:58:31');
INSERT INTO votes VALUES ('996', '29', '9779', '2013-07-10 19:58:31');
INSERT INTO votes VALUES ('997', '29', '9779', '2013-07-10 19:58:31');
INSERT INTO votes VALUES ('998', '29', '9779', '2013-07-10 19:58:31');
INSERT INTO votes VALUES ('999', '29', '9779', '2013-07-10 19:58:32');
INSERT INTO votes VALUES ('1000', '29', '9779', '2013-07-10 19:58:32');
INSERT INTO votes VALUES ('1001', '29', '9779', '2013-07-10 19:58:32');
INSERT INTO votes VALUES ('1002', '29', '9779', '2013-07-10 19:58:32');
INSERT INTO votes VALUES ('1003', '29', '9779', '2013-07-10 19:58:32');
INSERT INTO votes VALUES ('1004', '29', '9779', '2013-07-10 19:58:33');
INSERT INTO votes VALUES ('1005', '29', '9779', '2013-07-10 19:58:33');
INSERT INTO votes VALUES ('1006', '29', '9779', '2013-07-10 19:58:33');
INSERT INTO votes VALUES ('1007', '29', '9578', '2013-07-10 19:59:29');
INSERT INTO votes VALUES ('1008', '29', '9578', '2013-07-10 19:59:30');
INSERT INTO votes VALUES ('1009', '29', '9578', '2013-07-10 19:59:30');
INSERT INTO votes VALUES ('1010', '29', '9578', '2013-07-10 19:59:30');
INSERT INTO votes VALUES ('1011', '29', '9578', '2013-07-10 19:59:30');
INSERT INTO votes VALUES ('1012', '29', '9578', '2013-07-10 19:59:30');
INSERT INTO votes VALUES ('1013', '29', '9578', '2013-07-10 19:59:32');
INSERT INTO votes VALUES ('1014', '29', '9578', '2013-07-10 19:59:32');
INSERT INTO votes VALUES ('1015', '29', '9578', '2013-07-10 19:59:32');
INSERT INTO votes VALUES ('1016', '29', '9496', '2013-07-10 20:00:27');
INSERT INTO votes VALUES ('1017', '29', '9496', '2013-07-10 20:00:27');
INSERT INTO votes VALUES ('1018', '29', '9496', '2013-07-10 20:00:28');
INSERT INTO votes VALUES ('1019', '29', '9496', '2013-07-10 20:00:28');
INSERT INTO votes VALUES ('1020', '29', '9496', '2013-07-10 20:00:28');
INSERT INTO votes VALUES ('1021', '29', '9496', '2013-07-10 20:00:28');
INSERT INTO votes VALUES ('1022', '29', '9496', '2013-07-10 20:00:28');
INSERT INTO votes VALUES ('1023', '29', '9496', '2013-07-10 20:00:28');
INSERT INTO votes VALUES ('1024', '29', '9496', '2013-07-10 20:00:29');
INSERT INTO votes VALUES ('1025', '29', '9496', '2013-07-10 20:00:29');
INSERT INTO votes VALUES ('1026', '29', '9496', '2013-07-10 20:00:29');
INSERT INTO votes VALUES ('1027', '29', '9496', '2013-07-10 20:00:29');
INSERT INTO votes VALUES ('1028', '29', '9496', '2013-07-10 20:00:29');
INSERT INTO votes VALUES ('1029', '29', '9496', '2013-07-10 20:00:30');
INSERT INTO votes VALUES ('1030', '29', '9496', '2013-07-10 20:00:30');
INSERT INTO votes VALUES ('1031', '29', '9496', '2013-07-10 20:00:30');
INSERT INTO votes VALUES ('1032', '29', '9542', '2013-07-10 20:01:29');
INSERT INTO votes VALUES ('1033', '29', '9542', '2013-07-10 20:01:29');
INSERT INTO votes VALUES ('1034', '29', '9542', '2013-07-10 20:01:29');
INSERT INTO votes VALUES ('1035', '29', '9542', '2013-07-10 20:01:29');
INSERT INTO votes VALUES ('1036', '29', '9542', '2013-07-10 20:01:29');
INSERT INTO votes VALUES ('1037', '29', '9542', '2013-07-10 20:01:29');
INSERT INTO votes VALUES ('1038', '29', '9542', '2013-07-10 20:01:29');
INSERT INTO votes VALUES ('1039', '29', '9542', '2013-07-10 20:01:29');
INSERT INTO votes VALUES ('1040', '29', '9542', '2013-07-10 20:01:30');
INSERT INTO votes VALUES ('1041', '29', '9542', '2013-07-10 20:01:30');
INSERT INTO votes VALUES ('1042', '29', '9542', '2013-07-10 20:01:30');
INSERT INTO votes VALUES ('1043', '29', '9542', '2013-07-10 20:01:30');
INSERT INTO votes VALUES ('1044', '29', '9734', '2013-07-10 20:03:10');
INSERT INTO votes VALUES ('1045', '29', '9734', '2013-07-10 20:03:11');
INSERT INTO votes VALUES ('1046', '29', '9734', '2013-07-10 20:03:11');
INSERT INTO votes VALUES ('1047', '29', '9734', '2013-07-10 20:03:11');
INSERT INTO votes VALUES ('1048', '29', '9734', '2013-07-10 20:03:12');
INSERT INTO votes VALUES ('1049', '29', '9734', '2013-07-10 20:03:12');
INSERT INTO votes VALUES ('1050', '29', '9734', '2013-07-10 20:03:13');
INSERT INTO votes VALUES ('1051', '29', '9734', '2013-07-10 20:03:13');
INSERT INTO votes VALUES ('1052', '29', '9734', '2013-07-10 20:03:13');
INSERT INTO votes VALUES ('1053', '29', '9734', '2013-07-10 20:03:14');
INSERT INTO votes VALUES ('1054', '29', '9734', '2013-07-10 20:03:14');
INSERT INTO votes VALUES ('1055', '29', '9734', '2013-07-10 20:03:15');
INSERT INTO votes VALUES ('1056', '29', '9734', '2013-07-10 20:03:15');
INSERT INTO votes VALUES ('1057', '29', '9734', '2013-07-10 20:03:16');
INSERT INTO votes VALUES ('1058', '29', '9734', '2013-07-10 20:03:16');
INSERT INTO votes VALUES ('1059', '29', '9734', '2013-07-10 20:03:17');
INSERT INTO votes VALUES ('1060', '29', '9734', '2013-07-10 20:03:17');