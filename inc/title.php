    <?PHP
	$act_url= $_SERVER['PHP_SELF'];
//�������
if ($act_url=='/index.php') {
echo "
	<title>���� � ���������� � ������ Creative line studio</title>
<meta name='description' content=
'Creative line studio ���������������� ���� � ����������� � ������'>
<meta name='keywords' content=
'����,�����,������,�,������'>"
//��������
	;}elseif ($act_url=='/fotobanck.php') { 
	echo "
	<title>����-���� ������� ������ ���������� Creative line studio</title>
<meta name='description' content=
'������� ���� ������ Creative line studio'>
<meta name='keywords' content=
'������,�������,����,�,������'>"
//������	
	;}elseif ($act_url=='/uslugi.php') { 
	echo "
		<title>������ ��������� � ����� ��������� � ������ Creative line studio</title>
<meta name='description' content=
'������ ������������������ ��������� � �������������� � ������ Creative line studio'>
<meta name='keywords' content=
'��������,�������������,����,�����,�,������'>"
//����	
	;}elseif ($act_url=='/ceny.php') {
	echo "
	<title>���� �� ������ ��������� � �������������� � ������ Creative line studio</title>
<meta name='description' content=
'������ ������������������ ��������� � ��������������, ���� � ������������ � ������ Creative line studio'>
<meta name='keywords' content=
'����,������,����������,�����������,��������,�������������,����,�����,�,������'>"
//��������	
	;}elseif ($act_url=='/kontakty.php') {
	echo "
	<title>�������� Creative line studio</title>
<meta name='description' content=
'�������� ������������������ ��������� � ��������������, ���� � ������������ � ������ Creative line studio'>
<meta name='keywords' content=
'��������,����,������,����������,�����������,��������,�������������,����,�����,�,������'>"
//��������	
	;}elseif ($act_url=='/gb.php') {
	echo "
	<title>�������� Creative line studio</title>
<meta name='description' content=
'������ �������� Creative line studio'>
<meta name='keywords' content=
'��������,����,������,����������,�����������,��������,�������������,����,�����,�,������'>"
//����� �����������
	;}elseif ($act_url=='/registr.php') {
	echo "
	<title>����������� Creative line studio</title>"
	;}
?>