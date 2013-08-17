<?
function bb($text){
	$text = preg_replace('|\[b\](.+)\[\/b\]|s','<b>$1</b>',$text);
	$text = preg_replace('|\[u\](.+)\[\/u\]|s','<u>$1</u>',$text);
	$text = preg_replace('|\[i\](.+)\[\/i\]|s','<i>$1</i>',$text);
	$text = preg_replace('|\[color=(.+)\](.+)\[\/color\]|s','<font color="$1">$2</font>',$text);
	$text = preg_replace('|\[url=(.+)\](.+)\[\/url\]|s','<a href="$1">$2</a>',$text);
	return $text;
	}

function unbb($text){
	$text = str_replace('[b]','',$text);
	$text = str_replace('[/b]','',$text);
	$text = str_replace('[u]','',$text);
	$text = str_replace('[/u]','',$text);
	$text = str_replace('[i]','',$text);
	$text = str_replace('[/i]','',$text);
	$text = preg_replace('|\[color=(.*)\](.*)\[/color\]|sU','$2',$text);
	$text = preg_replace('|\[url=(.+)\](.+)\[/url\]|sU','',$text);
	return $text;
	}