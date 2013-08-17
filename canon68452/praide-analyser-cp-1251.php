<?php 
/**
 * ������ �������� ������������.
 */
ob_start();

/**
 * �������� �������� ���
 * @param $a
 */
function  handle_info($a){
        $a = explode("\n", trim(strip_tags($a)));
        $a = preg_replace("/^(www\.)?([\w\-\.]+):?([\d]+)?\/?([\s\S]*)?/i", "$2", strtolower($a[0]));
        return $a;
}

/**
 * �������� ���������� � ������ ������� �� �������
 * 
 * @param string $query ����� ������� ��� URL �����������
 * @return array $a
 *         $a[0][1] - ����� ��������� �������
 *         $a[0][2] - ����� ��������� ������
 *         $a[1]    - ������ ��������� �������
 */
function top_10($query) {
    $url = "http://yandex.ru/yandsearch?text=".urlencode($query);
    $txt = file_get_contents($url);
    $txt = cleanInput(iconv('utf-8', 'cp1251', $txt));
  //�������� ������ ��������
	 $txt = preg_replace("/(\s){2,}/",' ',$txt);
    echo "����� �������";
    echo nl2br(htmlspecialchars(print_r($txt, true)));
    $brief = get_brief($txt);
    if (!is_array($brief)) {
        return false;
    }
    // �������� ������ ������ yandex top 10
    preg_match("/\<ol[\s\S]*?\>[\s\S]*?\<\/ol[\s\S]*?\>/", $txt, $results);
    // �� ������ ������ ������ ������
    preg_match_all("/\<li[\s\S]*?\>[\s\S]*?\<div class=\"info\">([\s\S]*?)\<\/div\>[\s\S]*?\<\/li[\s\S]*?\>/", $results[0], $results);
    $results[1] = array_map("handle_info", $results[1]);
    return array($brief, $results[1]);
}
/**
 * �������� ���������� � ������ Google �� �������
 * 
 * @param string $query ����� ������� ��� URL �����������
 * @return array
 */
function top_10_g($query) {
    $url = "http://www.google.com/search?hl=ru&q=".urlencode($query);
    $txt = file_get_contents($url);
    $brief = get_brief_g($txt);
    if (!is_array($brief)) {
        return false;
    }
    return array($brief, false);
}
/**
 * �������� ������� ���������� � ����� ����������� ������ � Yandex
 * 
 * @param string $text ����� ��������
 * @return array $a  $a[1] - ����� �������, $a[2] - ����� ������
 */
function    get_brief($text){
    preg_match("/\<title\>[\s\S]+?:[\s\S]+?(\d+)[\s\S]+?\<\/title\>/i", $text, $ref);
    $ref[1] = (@$ref[1]) ? $ref[1] : 0 ;
    return $ref;
}
/**
 * �������� ������� ���������� � ����� ����������� ������ � Google
 * 
 * @param string $text ����� ��������
 * @return array $a  $a[1] - ����� �������
 */
function    get_brief_g($text){
    $exp = "/\<div id=ssb\>\<div id=prs>\<b\>[\s\S]*?\<\/b\>\<\/div>\<p\>[\s\S]*?\<b\>[\d]*?\<\/b\> - \<b\>[\d]*?\<\/b\>[\s\S]*?\<b\>([\d\s]*?)\<\/b\>[\s\S]*?\<\/p\><\/div\>/i";
    if (!preg_match($exp, $text, $ref)) {
        return false;
    }
    $ref[1] = (isset($ref[1]))?(int)str_replace("&nbsp;", "", $ref[1]):0;
    return $ref;
}

?> 