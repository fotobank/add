<?php
/**
 *
 * HTML5 Image uploader with Jcrop
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2012, Script Tutorials
 * http://www.script-tutorials.com/
 */


  class uploadImg {

	 public $files = array();
	 public $error = NULL;
	 public $file_names = array();
	 public $directory = NULL;
	 public $uploaded = false;
	 public $uploaded_files = array();
	 public $file_new_name = NULL;
	 public  $results = NULL;
    private $mime_types = array();
	 private  $iHeight;
	 private  $iWidth;
	 private  $iJpgQuality;
	 public  $sResultFileName = NULL;
	 public  $maxFifeSize;



	 function __constructor($files, $directory, $iHeight , $iWidth , $mime_types = array()) {
		$this->mime_types = ($mime_types)?$mime_types:$mime_types = array('image/pjpeg', 'image/jpeg', 'image/gif', 'image/png', 'image/x-png', 'application/x-tar',
																								'application/zip', 'application/msword', 'application/vnd.ms-excel', 'application/vnd.ms-powerpoint',
																								'application/mspowerpoint', 'application/x-shockwave-flash', 'text/plain', 'text/richtext',
																								'application/pdf'); // Типы файлов, которые будет разрешено
		$this -> directory($directory);
		$this -> files($files);
		$this -> maxFifeSize = 15000 * 1024;
		$this -> iHeight = 90;
		$this -> iWidth = 90;
		$this -> iJpgQuality = 90;
	// 	$this -> upload($mime_types);
	 }



	 function upload($mime_types) {
		if(!$this -> error) {
		  for ($i = 0; $i < count($this -> files['tmp_name']); $i++) {
			 if (in_array($this -> files['type'][$i], $mime_types)) {
				$this -> file_new_name = $this -> file_name_control($this -> files['name'][$i]);
				move_uploaded_file($this -> files['tmp_name'][$i], $this -> directory.'/'.$this -> file_new_name);
				$this -> uploaded_files[] = $this -> file_new_name;
				$this -> results .= '<li><strong>'.$this -> files['name'][$i].'</strong> Просмотр файлов, <strong>'.$this -> file_new_name.'</strong> загруженное имя<br />(~'.round($this -> files['size'][$i] / 1024, 2).' kb). Тип файла : '.$this -> file_extension($this -> files['name'][$i]).'</li>';
			 }else{
				echo $this -> files['type'][$i];
				$this -> results .= '<li>'.$this -> files['name'][$i].' Просмотр файлов, из-за несовместимости типов файлов добавлена!</li>';
			 }
		  }
		  $this -> uploaded = true;
		}
	 }



	 // загрузить результат отчета
	 function result_report() {
		if(isset($this -> error)) {
		  echo '<ul>';
		  echo $this -> error;
		  echo '</ul>';
		}
		if ($this -> uploaded == true) {
		  echo '<ul>';
		  echo $this -> results;
		  echo '</ul>';
		}
	 }


	 // информация о файле
	 function files($files) {
		if ($files) {
		  for ($i = 0; $i < count($files); $i++) {
			 if ($files['name'][$i]) {
				$this -> files['tmp_name'][] = $files['tmp_name'][$i];
				$this -> files['name'][] = $files['name'][$i];
				$this -> files['type'][] = $files['type'][$i];
				$this -> files['size'][] = $files['size'][$i];
			 }
		  }
		}
	 }


  function directory($directory) {
	 // У вас есть каталог?
	 if (!is_dir($directory)) {
		$this -> error .= '<li><strong>'.$directory.'</strong> Не нашел папку с именем!</li>';
	 }
	 // У вас есть права на запись в каталог?
	 if (is_dir($directory) && !is_writable($directory)) {
		$this -> error .= '<li><strong>'.$directory.'</strong> В каталоге не существует разрешение на запись!</li>';
	 }
	 $this -> directory = $directory;
  }


  function bad_character_rewrite($text){
	 $first = array("\\", "/", ":", ";", "~", "|", "(", ")", "\"", "#", "*", "$", "@", "%", "[", "]", "{", "}", "<", ">", "`", "'", ",", " ");
	 $last = array("_", "_", "_", "_", "_", "_", "", "_", "_", "_", "_", "_", "_", "_", "_", "_", "_", "_", "_", "_", "_", "", "_", "_");
	 $text_rewrite = str_replace($first, $last, $text);
	 return $text_rewrite;
  }


  function file_extension($file_name) {
	 $file_extension = strtolower(substr(strrchr($file_name, '.'), 1));
	 return $file_extension;
  }


  function file_name_control($file_name) {
	 $file_name = $this -> bad_character_rewrite($file_name);
	 if (!file_exists($this -> directory.'/'.$file_name)) {
		return $file_name;
	 }else{
		return rand(000000001,999999999).'_'.rand(000000001,999999999).'_'.$file_name;
	 }
  }


function uploadImageFile() { // Note: GD library is required for this function
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $iWidth = $iHeight = 200; // desired image result dimensions
        $iJpgQuality = 90;

        if ($_FILES) {

            // if no errors and size less than 250kb
            if (! $_FILES['image_file']['error'] && $_FILES['image_file']['size'] < $this->maxFifeSize) {
                if (is_uploaded_file($_FILES['image_file']['tmp_name'])) {

                    // new unique filename
         //           $sTempFileName = $_SERVER['HTTP_HOST'].'/inc/cropUploader/cache/'.md5(time().rand());
						   $ext         = strtolower(substr($_FILES['img']['name'], 1 + strrpos($_FILES['img']['name'], ".")));
						   $nm          = $_POST['nm'];
						  $id_new_news = go\DB\query('insert into `news` (img) VALUES (?string)', array($nm), 'id');
						  $img = 'news-'.$id_new_news.'.'.$ext;
						$sTempFileName = $_SERVER['DOCUMENT_ROOT'].'/tmp/'.$img;
                    // move uploaded file into cache folder
                    move_uploaded_file($_FILES['image_file']['tmp_name'], $sTempFileName);

                    // change file permission to 644
                    @chmod($sTempFileName, 0644);

                    if (file_exists($sTempFileName) && filesize($sTempFileName) > 0) {
                        $aSize = getimagesize($sTempFileName); // try to obtain image info
                        if (!$aSize) {
                            @unlink($sTempFileName);
                            return;
                        }

                        // check for image type
                        switch($aSize[2]) {
                            case IMAGETYPE_JPEG:
                                $sExt = '.jpg';

                                // create a new image from file 
                                $vImg = @imagecreatefromjpeg($sTempFileName);
                                break;
                            /*case IMAGETYPE_GIF:
                                $sExt = '.gif';

                                // create a new image from file 
                                $vImg = @imagecreatefromgif($sTempFileName);
                                break;*/
                            case IMAGETYPE_PNG:
                                $sExt = '.png';

                                // create a new image from file 
                                $vImg = @imagecreatefrompng($sTempFileName);
                                break;
                            default:
                                @unlink($sTempFileName);
                                return;
                        }

                        // create a new true color image
                        $vDstImg = @imagecreatetruecolor( $iWidth, $iHeight );

                        // copy and resize part of an image with resampling
                        imagecopyresampled($vDstImg, $vImg, 0, 0, (int)$_POST['x1'], (int)$_POST['y1'], $iWidth, $iHeight, (int)$_POST['w'], (int)$_POST['h']);

                        // define a result image filename
							   $this->sResultFileName = $sTempFileName . $sExt;

                        // output image to file
                        imagejpeg($vDstImg, $this->sResultFileName, $iJpgQuality);
                        @unlink($sTempFileName);

                        return $this->sResultFileName;
                    }
                }
            }
        }
    }
}

}

//$sImage = uploadImageFile();
//echo '<img src="'.$sImage.'" />';