<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 24.07.13
 * Time: 18:41
 * To change this template use File | Settings | File Templates.
 */

class autoPrev {

  var $directory = ''; //название папки с изображениями
  var $file_parts=array();
  var $ext='';
  var $title='';
  var $nomargin='';
  var $dir_handle='';
  var $thumb='';
  var $dirList=array();
  var $albumList='';
  var $height=170; // размер превьюшек фотографий
  var $widthAlbum=170; // размер превьюшек альбома
  var $startUrlThumb='';


  /**
	*
 	*/
  function __destruct() {
  }


  /**
	* @param $dirIn
	*/
  private function selectDir($dirIn)
  {
	 $skip = array('.', '..');
	 $files = scandir('.'.$dirIn);
	 foreach($files as $file)
		{
		  if(!in_array($file, $skip)) $this->dirList[] = $dirIn.$file.'/';
	   }
  }


  /**
	* печать шапки альбомов
	* @param     $dirIn
	* @param int $width
	* @param     $sortWidth
	* @return string
	*/

  public function printAlbum($dirIn, $width=170, $sortWidth)
  {
	 $this->widthAlbum = $width;
	 $this->selectDir($dirIn);
	 $widthGroup = count($this->dirList)*($width+40);
	 $this->albumList .= "<div id='container'>";
	 $this->albumList .= "<div class='group' style='width: ".$widthGroup."px;'>";
	 foreach ($this->dirList as $key => $dir)
		{
		  $classAlbum = 'stack twisted';
		  if($key == 0)
			 {
		      $classAlbum = 'stack rotated-left';
				$this->startUrlThumb = $dir;
			 }

		  if(end($this->dirList)===$dir)
			 {
			 $classAlbum = 'stack rotated';
		    }
        $file = $this->randomName($dir, $sortWidth);
		  if(!$file)
			 {
				$sortWidth = ($sortWidth)?false:true;
				$file = $this->randomName($dir, $sortWidth);
			 }
		  if(!$file)
			 {
				?>
				<script type='text/javascript'>
				  dhtmlx.message.expire = 6000; // время жизни сообщения
				  dhtmlx.message({ type: 'error', text: 'Ошибка!<br>в одной из папок отсутствует матерьял'});
				</script>
				<?
			 }
  
		  $this->albumList .= "<div id='album".$key."' class='$classAlbum' style='width: ".$this->widthAlbum."px;'>";
		  $this->albumList .= "<img src='".$dir.$file."' ";
		  $this->albumList .= "onclick=\"ajaxPostQ('/inc/ajaxUslugi.php', '#thumb',  'url=$dir'+'&galery=".$this->galery($dir)."'+'&height=".$this->height."');\" >";
		  $this->albumList .= "</div>";

		  $this->albumList .= "<script type='text/javascript'> ";
		  $this->albumList .= "$('#album".$key."').badger('".$this->galery($dir)."'); </script>";

		}
	 $this->albumList .= "</div></div>";
	 echo $this->albumList;
  }



  /**
	* рандом выбор файла из папки
	* @param $url
	* @param $sortWidth
	*
	* @return string
	*/
  private function randomName($url, $sortWidth = false)
  {

  $i = 0;
	 $randomFileName = '';
	 if ($handle = opendir('.'.$url))
		{
		  while (false !== ($file = readdir($handle)))
			 {
				// Пропускаем ссылки на текущую и родительскую
				// директории
				if ($file == "." || $file == "..")
				    continue;

				$size = getimagesize ('.'.$url.$file);
				if($sortWidth)
				  {
				  if($size[0] < $size[1])
				    continue;
				  } else {
				  if($size[0] > $size[1])
					 continue;
				  }
				if($size['mime'] !== 'image/jpeg')
				     continue;
				// Случайно выбираем файл
				if (mt_rand(1, ++$i) == 1)
				  {
					 $randomFileName = $file;
              }
			 }
		  closedir($handle);
		}
	 return $randomFileName;
  }



  /**
	* название галереи из названия папки
	*
	* @param $url
	*
	* @return mixed
	*/
  private function galery($url)
  {
	 $dirNam = explode('/',$url);
	 return $dirNam[count($dirNam)-2];
  }


  /**
	* первоначальный вывод превьюшек
	* @return string
	*/
  public function printStart()
  {
	 $startThumb = '';
	 if(isset($this->dirList[0]))
		{
		  $galery = $this->galery($this->startUrlThumb);
        $startThumb = "<script type='text/javascript'> $(function(){ ajaxPostQ('/inc/ajaxUslugi.php', '#thumb',
                       'url=".$this->startUrlThumb."'+'&galery=".$galery."'+'&height=".$this->height."')});</script>";
		}
	 echo $startThumb;
  }


  /**
	* открытие папки
	* @param $dir
	*
	* @return resource|string
	*/
  private function readDir($dir){
	  $dir = './..'.$dir;
	 return (($openDir = @opendir($dir))?$openDir:die("Внимание! Существует ошибка в каталоге или каталог не задан!"));
  }


  public function startPrettyPhoto() {

	 $thumb = "<script type='text/javascript'>";
	 $thumb .= "$(window).load(function(){ $(\".gallery:first a[rel^='prettyPhoto']\").prettyPhoto({animation_speed:'fast',slideshow:6000,hideflash:true }); }); </script>";
	 echo $thumb;
  }

  /**
	* @param        $url
	* @param        $galery
	* @param string $minHeight
	*
	* @return string
	*/
  public function printPrev($url,$galery, $minHeight = '175') {
	 $this->directory = $url;
	 $allowed_types=array('jpg','jpeg','gif','png');  //разрешеные типы изображений
//пробуем открыть папку
	 $this->dir_handle = $this->readDir($this->directory);

	 $this->thumb .= "<div class='gallery' id='am-container' style='width:1200px;'>";
	 $i=0;
	 while ($file = readdir($this->dir_handle))         //поиск по файлам
		{
		  if($file=='.' || $file == '..') continue;      //пропустить ссылки на другие папки

		  $file_parts = explode('.',$file);              //разделить имя файла и поместить его в массив
		  $ext = strtolower(array_pop($file_parts));     //последний элеменет - это расширение

		  $title = implode('.',$file_parts);
		  $title = htmlspecialchars($title);


		  if(in_array($ext,$allowed_types))
			 {
				if(($i+1)%4==0) $this->nomargin='nomargin';
				$this->thumb .= "
            <img rel='prettyPhoto[".$galery."]' class='album_usl_img' src='".$this->directory.$file."' alt='".$galery."' title='".$title."'
            onclick=\"$('.am-wrapper').prettyPhoto({animation_speed:'fast',slideshow:6000,hideflash:true });\" >";
				$i++;

			 }
		}
	 $this->thumb .= "</div>";

	 $this->thumb .= "<script type='text/javascript'>";
	 $this->thumb .= "$(function() {";
	 $this->thumb .= "var \$container = $('#am-container'),";
	 $this->thumb .= "\$imgs = \$container.children('img').hide(),";
	 $this->thumb .= "totalImgs = \$imgs.length,";
	 $this->thumb .= "cnt = 0;";
	 $this->thumb .= "\$imgs.each(function(i) {";
	 $this->thumb .= "var \$img	= $(this);";
	 $this->thumb .= "$('<img/>').load(function() {";
	 $this->thumb .= "++cnt;";
	 $this->thumb .= "if( cnt === totalImgs ) {";
	 $this->thumb .= "\$imgs.show();";
	 $this->thumb .= "\$container.montage({";
// Если вы используете проценты (или не устанавливаете ширину совсем)
// для ширину контейнера, то данную опцию надо установить в значение true.
// Таким образом установится свойство overflow-y для body
// в значение 'scroll'
	 $this->thumb .= "liquid : true,";
// Расстоянием между изображениями в px
//	 $this->thumb .= "margin : 1,";
// Минимальная ширина изображения
	 $this->thumb .= "minw : 100,";
// Минимальная высота изображения
//	$this->thumb .= "minh : 20,";
// Максимальная высота изображения
//	$this->thumb .= "maxh : 50,";
// Изменение высоты каждой строки.
// Данная опция имеет более высокий приоритет, чем fixedHeight
	$this->thumb .= "alternateHeight : true,";
// Высота будет случайной величиной в диапазоне между 'min' и 'max':
	$this->thumb .= "alternateHeightRange : { min : ".$minHeight.", max	: 450 },";
// Данная опция имеет приоритет над опцией minsize.
// Все изображения имеют данную высоту:
//	$this->thumb .= "fixedHeight : 220,";
// Использование данной опции делает недействительными значения опций minw и minh.
// Выбор высоты осуществляется по самому маленькому изображению,
// когда данная опция имеет значение true:
//	$this->thumb .= "minsize : true,";
// Если значение опции true, в конце контейнера не будет пробелов.
// Последнее изображение будет заполнять все оставшееся пространство:
	$this->thumb .= "margin : 5, padding : 5,";
	$this->thumb .= "fillLastRow : true";
	$this->thumb .= "});}}).attr('src',\$img.attr('src'));});});</script>";

//	 $this->thumb .= "<script type='text/javascript'>";
//	 $this->thumb .= "$(window).load(function(){ $(\".gallery:first a[rel^='prettyPhoto']\").prettyPhoto({animation_speed:'fast',slideshow:6000,hideflash:true }); });";
//	 $this->thumb .= "</script>";


	 closedir($this->dir_handle);
	 return $this->thumb;
  }
}