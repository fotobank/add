 <?php 
$config = array(); // ���������, ��� ���������� $config ��� ������ 
$config['server'] = "localhost"; //������ MySQL. ������ ��� localhost 
$config['login'] ="canon632"; //������������ MySQL 
$config['passw'] = "fianit8546"; //������ �� ������������ MySQL 
$config['name_db'] = "creative_ls"; //�������� ����� �� 
$dbuser = "canon632";
$dbpass ="fianit8546";
$connect = mysql_connect($config['server'], $config['login'], $config['passw']) or die("Error!"); // ������������ � MySQL ���, � ������ ������, ���������� ���������� ���� 
mysql_select_db($config['name_db'], $connect) or die("Error!"); // �������� ��  ���, � ������ ������, ���������� ���������� ���� 
?> 