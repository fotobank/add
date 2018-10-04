<?php
/*------------------------------------------------------------------------------------------

This file is part of auto google site maps creation by lee johnstone
this file was orginaly made by a third party site please read below for there license.

YOU MAY NOT
(1) Remove or modify this copyright notice.
(2) Distribute this code as your own
(3) Use this code in commercial projects
    
YOU MAY
(1) Use this code or any modified version of it on your website.
(2) Use this code as part of another product.

u may not remove this notice
please read our copyright license here
http://www.freakcms.com/licensing.php
or contact us here
http://www.toy17s.com/index.php?page=Contact-us
--------------------------------------------------------------------------------------------

this file grabs the sitemap after the user requests it.

-------------------------------------------------------------------------------------------*/

// Copyright (C) 2005 Ilya S. Lyubinskiy. All rights reserved.
// Technical support: http://www.php-development.ru/
//
// YOU MAY NOT
// (1) Remove or modify this copyright notice.
// (2) Distribute this code, any part or any modified version of it.
//     Instead, you may link to the homepage of this code:
//     http://www.php-development.ru/javascripts/smart-forms.php.
//
// YOU MAY
// (1) Use this code or any modified version of it on your website.
// (2) Use this code as part of another product.
//
// NO WARRANTY
// This code is provided "as is" without warranty of any kind, either
// expressed or implied, including, but not limited to, the implied warranties
// of merchantability and fitness for a particular purpose. You expressly
// acknowledge and agree that use of this code is at your own risk.



set_time_limit(0);
error_reporting(E_ALL);
ini_set("log_errors", 0);
ini_set("display_errors", 1);

class AutoMaps {
	

var $output;
var $exculde;
var $external;
var $ext;
var $result;
var $roots;
var $urls;
var $maxpages;
var	$host     = 0;
var	$index    = Array();
var	$titles   = Array();
var	$texts    = false;
var	$int_pages = Array();
var	$int_loads = Array();
var	$ext_pages = Array();
var	$ext_loads = Array();
var $SITE_MAP = 'sitemap.xml';
var $URL_HOST_APPEND = 1;
var $URL_HOST_STRIP =  2;
var $URL_QUERY_NOESCAPE= 0;
var $URL_QUERY_ESCAPE = 1;
var $INDEX_HOST_APPEND=1;
var $INDEX_HOST_STRIP=2;

private function enclose($start, $end1, $end2){
  return "$start((?:[^$end1]|$end1(?!$end2))*)$end1$end2";
}

private function parse($html, &$title, &$text, &$anchors){
  $pstring1 = "'[^']*'";
  $pstring2 = '"[^"]*"';
  $pnstring = "[^'\">]";
  $pintag   = "(?:$pstring1|$pstring2|$pnstring)*";
  $pattrs   = "(?:\\s$pintag){0,1}";
  $pcomment = $this->enclose("<!--", "-", "->");
  $pscript  = $this->enclose("<script$pattrs>", "<", "\\/script>");
  $pstyle   = $this->enclose("<style$pattrs>", "<", "\\/style>");
  $pexclude = "(?:$pcomment|$pscript|$pstyle)";
  $ptitle   = $this->enclose("<title$pattrs>", "<", "\\/title>");
  $panchor  = "<a(?:\\s$pintag){0,1}>";
  $phref    = "href\\s*=[\\s'\"]*([^\\s'\">]*)";
  $html = preg_replace("/$pexclude/iX", " ", $html);
  if ($title !== false)
    $title = preg_match("/$ptitle/iX", $html, $title) ? $title[1] : '';
  if ($text !== false){
    $text = preg_replace("/<$pintag>/iX",   " ", $html);
    $text = preg_replace("/\\s+|&nbsp;/iX", " ", $text);
  }
  if ($anchors !== false){
    preg_match_all("/$panchor/iX", $html, $anchors);
    $anchors = $anchors[0];
    reset($anchors);
    while (list($i, $x) = each($anchors))
      $anchors[$i] = preg_match("/$phref/iX", $x, $x) ? $x[1] : '';
    $anchors = array_unique($anchors);
  }
}

private function url_parse($url){
  $error_reporting = error_reporting(E_ERROR | E_PARSE);
  $url = parse_url($url);
  error_reporting($error_reporting);
  return $url;
}

private function url_scheme($url, $scheme = 'http'){
  if(!($url = $this->url_parse($url))) return $scheme;
  return isset($url['scheme']) ? $url['scheme'] : $scheme;
}

private function url_host($url, $lower = true, $www = 0){
  if(!($url = $this->url_parse($url))) return '';
  $url = $lower ? strtolower($url['host']) : $url['host'];
  if ($www == $this->URL_HOST_APPEND && strpos($url, 'www.') !== 0) return 'www.' . $url;
  if ($www == $this->URL_HOST_STRIP  && strpos($url, 'www.') === 0) return substr($url, 4);
  return $url;
}

private function url_path($url){
  if(!($url = $this->url_parse($url))) return '';
  $url = isset($url['path']) ? explode('/', $url['path']) : Array();
  if (reset($url) === '') array_shift($url);
  if (end  ($url) === '' || strpos(end($url), '.') !== false) array_pop($url);
  return implode('/', $url);
}

private function url_file($url, $convert = Array()){
  if(!($url = $this->url_parse($url))) return '';
  $url = isset($url['path']) ? end(explode('/', $url['path'])) : '';
  $url = (strpos($url, '.') !== false) ? $url : '';
  foreach ($convert as $i => $x) $url = preg_replace($i, $x, $url);
  return $url;
}

private function url_ext($url, $convert = Array()){
  if(!($url = $this->url_parse($url))) return '';
  $url = isset($url['path']) ? end(explode('/', $url['path'])) : '';
  $url = (strpos($url, '.') !== false) ? end(explode('.', $url)) : '';
  foreach ($convert as $i => $x) $url = preg_replace($i, $x, $url);
  return $url;
}

private function url_query($url, $escape = 0, $exclude = Array()){
  if(!($url = $this->url_parse($url))) return '';
  if (!isset($url['query'])) return '';
  $url = preg_split('/(&(?!amp;)|&amp;)/', $url['query']);
  foreach ($url as $i => $x){
    $x = explode('=', $x);
    if (in_array($x[0], $exclude)) unset($url[$i]);
  }
  return implode($escape ? '&amp;' : '&', $url);
}

private function url_concat($base, $rel){
  $scheme = $this->url_scheme($base);
  $host   = $this->url_host  ($base);
  $path   = $this->url_path  ($base);

  if ($rel{0} == '/')
       return "$scheme://$host$rel";
  else if ($path === '')
            return "$scheme://$host/$rel";
       else return "$scheme://$host/$path/$rel";
}
private function url_normalize($url,
                       $scheme  = 'http',
                       $www     = 0,
                       $convert = Array(),
                       $escape  = 0,
                       $exclude = Array()){
  										$scheme = $this->url_scheme($url, $scheme);
  										$host   = $this->url_host  ($url, true, $www);
  										$path   = $this->url_path  ($url);
  										$file   = $this->url_file  ($url, $convert);
  										$query  = $this->url_query ($url, $escape, $exclude);
if ($scheme === '' || $host === '') return '';
  if ($path === '') return "$scheme://$host/$file"       . ($query ? "?$query" : "");
  else return "$scheme://$host/$path/$file" . ($query ? "?$query" : "");
}

private function index($roots, &$urls, $max, $www, $convert, $exclude, &$titles, &$texts, $ext_parse, $extensions){
  $time   = microtime(true);
  $parsed = 0;
  foreach ($urls as $i => $url)
    $urls[$i] = $this->url_normalize($url, 'http', $www, $convert, $this->URL_QUERY_NOESCAPE, $exclude);
  for ($ind = 0; $ind < count($urls); $ind++){
    if (trim($urls[$ind]) === ''){
      unset($urls[$ind]);
      continue;
    }
    $in_root = false;
    foreach ($roots as $i => $root)
      $in_root = $in_root || strpos($urls[$ind], $root) === 0;
    if (!$in_root){
      if (!$ext_parse) continue;
      if ($titles === false && $texts === false) continue;
    }
    if (!in_array($this->url_ext($urls[$ind]), $extensions)) continue;
    $error_reporting = error_reporting(E_ERROR | E_PARSE);
    $html = file_get_contents($urls[$ind]);
    error_reporting($error_reporting);
    if ($html === false) continue;
    $parsed++;
    $title = $titles !== false;
    $text  = $texts  !== false;
    $this->parse($html, $title, $text, $anchors);
    if ($titles !== false) $titles[$ind] = $title;
    if ($texts  !== false) $texts [$ind] = $text;
    if (!$in_root || $max < count($urls)) continue;
    foreach ($anchors as $i => $x) {
      $x = preg_replace("/#.*/X", "", $x);
      if ($x == '' || preg_match("/^(\\w)+:(?!\/\/)/X", $x)) continue;
      if (!preg_match("/^(\\w)+:\/\//X", $x)) $x = $this->url_concat($urls[$ind], $x);
      $x = $this->url_normalize($x, 'http', $www, $convert, $this->URL_QUERY_NOESCAPE, $exclude);
      if (!in_array($x, $urls) && (count($urls) < $max)) $urls[] = $x;
    }
  }
  return Array("time" => microtime(true)-$time, "parsed" => $parsed);
}
private function separate($roots, $urls,
                  &$int_pages, &$int_loads, &$ext_pages, &$ext_loads,
                  $extensions){
  foreach ($urls as $i => $url){
    if (trim($url) === '') continue;
    $in_root = false;
    foreach ($roots as $j => $root)
      $in_root = $in_root || strpos($url, $root) === 0;
    if ($in_root){
      if (in_array($this->url_ext($url), $extensions))
           $int_pages[$i] = $url;
      else $int_loads[$i] = $url;
    }else{
if (in_array($this->url_ext($url), $extensions))
           $ext_pages[$i] = $url;
      else $ext_loads[$i] = $url;
    }
  }
}
private function Finish(){
$sitemapheader = '<?xml version="1.0" encoding="UTF-8"?>
	<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
	http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
	unlink($this->SITE_MAP);
	$sitemapper = fopen($this->SITE_MAP,"w+");
	fwrite($sitemapper, $sitemapheader);
	asort($this->int_pages);
	$a = 0;
	foreach ($this->int_pages as $i => $x){
if(stristr($x,"./")==false){
	$a++;
	$sitemaplinks = '<url>
	<loc>'.$x.'</loc>
	<lastmod>'.date("Y-m-d").'</lastmod>
	<changefreq>'.$this->changefreq().'</changefreq>
	<priority>'.$this->Priority().'</priority>
	</url>';
if(file_exists($this->SITE_MAP)){
	fwrite($sitemapper,$sitemaplinks);
  }
 }
}
	$this->output .= '
		<table>
		<tr>
		  <td>Domain:</td>
		  <td><a href="'.$_POST['url'].'" target="_blank">'.$_POST['url'].'</a></td>
		</tr>
		<tr>
		  <td>Execution time:</td>
		  <td>'.number_format($this->result['time'], 2, '.', '').' secs</td>
		</tr>
		<tr>
		  <td>URLs &nbsp;parsed:</td>
		  <td>'.$this->result['parsed'].'</td>
		</tr>
		<tr>
		  <td>URLs extracted:</td>
		  <td>'.$a.'</td>
		</tr>
		</table>';
	fwrite($sitemapper,"</urlset>");
	fclose($sitemapper);
	echo $this->output;
	return;
	}
private function Priority(){
	$items  = Array(
		'1'=>'0.1',
		'2'=>'0.2',
		'3'=>'0.3',
		'4'=>'0.4',
		'5'=>'0.5',
		'6'=>'0.6',
		'7'=>'0.7',
		'8'=>'0.8',
		'9'=>'0.9'
);
	$numberOfItems = 9; 
	$randItems = array_rand($items, $numberOfItems);
for ($i = 0; $i < 1; $i++) {
    $item = $items[$randItems[$i]];
	}
	return $item;
}
private function changefreq(){
	$items = Array(
		'1'=>'never',
		'2'=>'yearly',
		'3'=>'monthly',
		'4'=>'weekly',
		'5'=>'daily',
		'6'=>'hourly',
		'7'=>'always'
);
	$numberOfItems = 7; 
	$randItems = array_rand($items, $numberOfItems);
for ($i = 0; $i < 1; $i++) {
    $item = $items[$randItems[$i]];
	}
	return $item;
}
public function AutoMap(){

if ($this->url_host($_POST['url']) ==     'freakcms.com' ||
    $this->url_host($_POST['url']) == 'www.freakcms.com')
	unset($_POST['external']);
	$this->roots    = Array($_POST['url'],
                  $this->url_normalize($_POST['url'], 'http', $this->URL_HOST_APPEND),
                  $this->url_normalize($_POST['url'], 'http', $this->URL_HOST_STRIP));
	$this->urls     = Array($_POST['url']);
	$this->maxpages = (integer)$_POST['maxpages'];
if (($_SERVER['SERVER_NAME'] == 'localhost') || ($_SERVER['SERVER_NAME'] == 'php-development.ru') || ($_SERVER['SERVER_NAME'] == 'www.php-development.ru'))
if ($this->maxpages > 32) $this->maxpages = 32;
	$this->exclude  = preg_split('/\\s+/', $_POST['ses']);
	$this->external = isset($_POST['external']);
	$this->ext      = preg_split('/\\s+/', $_POST['ext']);
	$this->ext[]    = '';
	$this->result  = $this->index($this->roots, $this->urls, $this->maxpages, $this->host, $this->index, $this->exclude, $this->titles,$this->texts, $this->external, $this->ext);
	$this->separate($this->roots, $this->urls, $this->int_pages, $this->int_loads, $this->ext_pages, $this->ext_loads, $this->ext);
	$this->Finish();
return;
}	
public function GetMap(){
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: public", false);
		header("Content-Description: File Transfer");
		header("Content-Type: application/xml");
		header("Accept-Ranges: bytes");
		header("Content-Disposition: attachment; filename=$this->SITE_MAP;");
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: " . filesize($this->SITE_MAP));
		@readfile($this->SITE_MAP);
	return;
}
}