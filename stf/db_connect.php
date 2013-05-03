 <?php 
$config = array(); // указываем, что переменная $config это массив 
$config['server'] = "localhost"; //сервер MySQL. Обычно это localhost 
$config['login'] ="canon632"; //пользователь MySQL 
$config['passw'] = "fianit8546"; //пароль от пользователя MySQL 
$config['name_db'] = "creative_ls"; //название нашей БД 
$dbuser = "canon632";
$dbpass ="fianit8546";
$connect = mysql_connect($config['server'], $config['login'], $config['passw']) or die("Error!"); // подключаемся к MySQL или, в случае ошибки, прекращаем выполнение кода 
mysql_select_db($config['name_db'], $connect) or die("Error!"); // выбираем БД  или, в случае ошибки, прекращаем выполнение кода 
?> 