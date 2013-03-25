    <?PHP
	$act_url= $_SERVER['PHP_SELF'];
//Главная
if ($act_url=='/index.php') {
echo "
	<title>Фото и видесъёмка в Одессе Creative line studio</title>
<meta name='description' content=
'Creative line studio Проффесиональная фото и видеосъёмка в одессе'>
<meta name='keywords' content=
'фото,видео,съёмка,в,Одессе'>"
//Фотобанк
	;}elseif ($act_url=='/fotobanck.php') { 
	echo "
	<title>Фото-банк Скачать купить фотогарфии Creative line studio</title>
<meta name='description' content=
'Скачать фото работы Creative line studio'>
<meta name='keywords' content=
'купить,скачать,фото,в,Одессе'>"
//Услуги	
	;}elseif ($act_url=='/uslugi.php') { 
	echo "
		<title>Услуги фотографа и видео оператора в Одессе Creative line studio</title>
<meta name='description' content=
'Услуги Проффессионального фотографа и видеооператора в Одессе Creative line studio'>
<meta name='keywords' content=
'фотограф,видеооператор,фото,видео,в,Одессе'>"
//Цены	
	;}elseif ($act_url=='/ceny.php') {
	echo "
	<title>Цены на услуги фотографа и видеооператора в Одессе Creative line studio</title>
<meta name='description' content=
'Услуги Проффессионального фотографа и видеооператора, фото и видеомонтажа в Одессе Creative line studio'>
<meta name='keywords' content=
'цены,услуги,фотомонтаж,видеомонтаж,фотограф,видеооператор,фото,видео,в,Одессе'>"
//Контакты	
	;}elseif ($act_url=='/kontakty.php') {
	echo "
	<title>Контакты Creative line studio</title>
<meta name='description' content=
'Контакты Проффессионального фотографа и видеооператора, фото и видеомонтажа в Одессе Creative line studio'>
<meta name='keywords' content=
'контакты,цены,услуги,фотомонтаж,видеомонтаж,фотограф,видеооператор,фото,видео,в,Одессе'>"
//Гостевая	
	;}elseif ($act_url=='/gb.php') {
	echo "
	<title>Гостевая Creative line studio</title>
<meta name='description' content=
'Отзывы клиентов Creative line studio'>
<meta name='keywords' content=
'контакты,цены,услуги,фотомонтаж,видеомонтаж,фотограф,видеооператор,фото,видео,в,Одессе'>"
//Форма регистрации
	;}elseif ($act_url=='/registr.php') {
	echo "
	<title>Регистрация Creative line studio</title>"
	;}
?>