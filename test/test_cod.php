<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 17.10.13
 * Time: 17:23
 * To change this template use File | Settings | File Templates.
 */


# ����� ��� ������������. ��������� ������ ����.
$dir = './../';

# �������-�������� "����������" ����.
function check($text){
         # ������ � ��������������� ��������� ��� ������.
         $array = array('.$_', '= $_', ', $_', '"$_', "'\$_", ',$_', 'eval(', 'exec(', 'proc_open(', 'system(');
        # ��������� ����������
        $i = 0; $bug = NULL;
       # ������� ����� ������� � ����� ������ �����������.
       foreach($array as $search){ $i++;
       # ���� ������� ����, ��� �������� ���������� ���������� � ����������.
       if(stripos($text, $search) !== false) $bug[$i] = $search; }
       # � ���� ���������� ���, �� ������� "false".
       return (!empty($bug)) ? $bug : false; }



# ������� ��� ������������ ��������� ������� � �����.
function open_dir($name){
                          # �������� �����, ��������� ���������� ��� �������� � ��� ����������
                          $open = opendir($name); $info = NULL;
# ������ �����
while($data = readdir($open)){
# ��������� ������, ������� ����� ���� ����� �����
if($data !== '.' && $data !== '..'){
         # ����������� �������� ���� � �����
         $real_name = $name.'/'.$data;
# ���� ��� ������� �� ����, � �����, �� �������� ������ ��� � ������
if(is_dir($real_name)){ open_dir($real_name); }
# � ���� �� ����, �� ���������� � �������
else if(is_file($real_name)){
         # ��� ������ ��� ����� ������ �����������, ��� ��� ���� - php-��������
         $new_name = str_replace(array('.php', '.phtm'), '.iscode', $real_name);
# ���� ����� ����������� � ������ ����� � ��� ��������� ��������� - ������������� ����.<br>
if($real_name !== $new_name){
         # ������ �����
         $text = file_get_contents($real_name);
             # ��������� ����� "�������" ����
             $check = check($text);
# ���� ��������� �������������, �� ������� �� �����
if($check){ echo $real_name.' -> ('.count($check)." moment(s))\n<br>";
# � ���� ������� ������ "�������", ������� ���� �������.
foreach($check as $vtag){ echo '=> |'.$vtag.'|'; } echo "\n<br>"; } } } } } }

       # ������ ������ ��� ��������� ��������� ��� ����� �����.
       open_dir($dir);
?><br>