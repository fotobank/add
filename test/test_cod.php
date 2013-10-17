<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 17.10.13
 * Time: 17:23
 * To change this template use File | Settings | File Templates.
 */


# Папка для сканирования. Жалателен полный путь.
$dir = './../';

# Функция-посковик "остенького" кода.
function check($text){
         # Массив с подготовленными участками для поиска.
         $array = array('.$_', '= $_', ', $_', '"$_', "'\$_", ',$_', 'eval(', 'exec(', 'proc_open(', 'system(');
        # Заготовка переменных
        $i = 0; $bug = NULL;
       # Перебор ячеек массива с целью поиска уязвимостей.
       foreach($array as $search){ $i++;
       # Ищем участок кода, при успешном нахождении записываем в переменную.
       if(stripos($text, $search) !== false) $bug[$i] = $search; }
       # А если совпадений нет, то передаём "false".
       return (!empty($bug)) ? $bug : false; }



# Функция для рекурсивного просмотра попапок в папке.
function open_dir($name){
                          # Открытие папки, поготовка переменной для хранения в ней результата
                          $open = opendir($name); $info = NULL;
# Чтение папки
while($data = readdir($open)){
# Отсеиваем ссылки, которые ведут выше нашей папки
if($data !== '.' && $data !== '..'){
         # Искуственно получаем путь к файлу
         $real_name = $name.'/'.$data;
# Если нам попался не файл, а папка, то вызываем фунцию для её чтения
if(is_dir($real_name)){ open_dir($real_name); }
# А если же файл, то приступаем к анализу
else if(is_file($real_name)){
         # Для начала нам нужно имееть уверенность, что наш файл - php-сценарий
         $new_name = str_replace(array('.php', '.phtm'), '.iscode', $real_name);
# Если после манипуляции с именем файла у нас появились изменения - просматриваем файл.<br>
if($real_name !== $new_name){
         # Чтение файла
         $text = file_get_contents($real_name);
             # Запускаем поиск "острого" кода
             $check = check($text);
# Если результат положительный, то выводим на экран
if($check){ echo $real_name.' -> ('.count($check)." moment(s))\n<br>";
# А ниже выводим список "острого", которое было найдено.
foreach($check as $vtag){ echo '=> |'.$vtag.'|'; } echo "\n<br>"; } } } } } }

       # Запуск фунции для просмотра каталогов для нашей папки.
       open_dir($dir);
?><br>