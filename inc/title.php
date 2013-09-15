<?PHP
$act_url = $_SERVER['PHP_SELF'];
//Главная
if ($act_url == '/index.php') {
			$title       = "Фото и видесъёмка в Одессе Creative line studio";
			$description = 'Creative line studio Проффесиональная фото и видеосъёмка в одессе';
			$keywords    = "фото,видео,съёмка,в,Одессе";
			//Фотобанк
} elseif ($act_url == '/fotobanck_adw.php') {
			$title       = "Фото-банк Скачать купить фотогарфии Creative line studio";
			$description = "Скачать фото работы Creative line studio";
			$keywords    = "купить,скачать,фото,в,Одессе";
			//Услуги
} elseif ($act_url == '/uslugi.php') {
			$title       = "Услуги фотографа и видео оператора в Одессе Creative line studio";
			$description = "Услуги Проффессионального фотографа и видеооператора в Одессе Creative line studio";
			$keywords    = "фотограф,видеооператор,фото,видео,в,Одессе";
			//Цены
} elseif ($act_url == '/ceny.php') {
			$title       = "Цены на услуги фотографа и видеооператора в Одессе Creative line studio";
			$description = "Услуги Проффессионального фотографа и видеооператора, фото и видеомонтажа в Одессе Creative line studio";
			$keywords    = "цены,услуги,фотомонтаж,видеомонтаж,фотограф,видеооператор,фото,видео,в,Одессе";
			//Контакты
} elseif ($act_url == '/kontakty.php') {
			$title       = "Контакты Creative line studio";
			$description = "Контакты Проффессионального фотографа и видеооператора, фото и видеомонтажа в Одессе Creative line studio";
			$keywords    = "контакты,цены,услуги,фотомонтаж,видеомонтаж,фотограф,видеооператор,фото,видео,в,Одессе";
			//Гостевая
} elseif ($act_url == '/gb/index.php') {
			$title       = "Гостевая Creative line studio";
			$description = "Отзывы клиентов Creative line studio";
			$keywords    = "контакты,цены,услуги,фотомонтаж,видеомонтаж,фотограф,видеооператор,фото,видео,в,Одессе";
			//Форма регистрации
} elseif ($act_url == '/registr.php') {
			$title       = "Регистрация на сайте Creative line studio";
			$description = "Регистрация необходима для голосования и покупки фотографий в фотобанке";
			$keywords    = "регистрация,логин,пароль,голосование,фотобанк,бонус,акция";
			//Страница пользователя
} elseif ($act_url == '/page.php') {
			$title       = "Страница пользователя на сайте Creative line studio";
			$description = "Управление, изменение и удаление учетной записи пользователя, скачивание выбранных фотографий, страница доступна после регистрации";
			$keywords    = "управление, изменение, удаление,  учетная, запись, скачивание, фотография";
} else {
			$title       = "Фото и видесъёмка в Одессе Creative line studio";
			$description = "Creative line studio Проффесиональная фото и видеосъёмка в Одессе";
			$keywords    = "фото,видео,съёмка,в,Одессе";
}