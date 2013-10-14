<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 14.10.13
 * Time: 15:27
 * To change this template use File | Settings | File Templates.
 */


class uploadImgThumb {

       // ������������� ����������
       private $uploaded = false;
       private $name;
       private $type;
       private $size;
       private $tmp;
       private $error;
       private $thumbImage;
       private $message;


       private $newThumbName = true; // ��� ��������� �����
       private $upload_dir = true; // ����� ��� ��������
       private $maxThumbSize = true; // max ������ �������� ��������
       private $report = true; // ����� ������
       private $mkdir = true; // ������� ����� (��� ����������)
       private $quality = 80; // �������� ��������
       private $maxFileSize = 15000000; // max ��� ��������
       private $minImageSize = 10; // min ��� ��������
       private $_FILESname = true; // ��� ������������ ����� � ������� $_FILES





       /**
        * @param $array
        *
        * @return bool
        */
       public function set($array) {

              global $_FILES;

              foreach($array as $var => $data) {
                     if(isset($this->$var)) {
                     $this->$var = $data;
                     }
              }
              if(!isset($this->_FILESname)) {
                     dump_r($this->_FILESname);
                     dump_r("�� ������ ��� ��� ����� '\$_FILES' � ���������� '_FILESname'");
                     return false;
              }
              $this->error = ($_FILES[$this->_FILESname]['error'] != 0) ? $_FILES[$this->_FILESname]['error'] : NULL;
              if ($this->error != 0) {
                     $this->message = $this->error;
                     $this->result_report();
                     return false;
              } else {
                     $this->name = $_FILES[$this->_FILESname]['name'];
                     $this->type = $_FILES[$this->_FILESname]['type'];
                     $this->size = $_FILES[$this->_FILESname]['size'];
                     $this->tmp  = $_FILES[$this->_FILESname]['tmp_name'];
                     $this->upload();
                     return true;
              }
       }


       /**
        * Function to Check the uploaded file
        *
        * @return bool
        */
       private function validate() {

              if ($this->type != 'image/jpeg' && $this->type != 'image/gif' && $this->type != 'image/png') {
                     $this->message  = '�������������  ������ �����!';
                     $this->uploaded = false;

                     return false;
              }
              if ($this->size > $this->maxFileSize) {
                     $this->message  = '���� ������� �������!';
                     $this->uploaded = false;

                     return false;
              }
              $size = getimagesize($this->tmp);
              if ($size[0] < $this->minImageSize || $size[1] < $this->minImageSize) {
                     $this->message  = '���� ������� ���������!';
                     $this->uploaded = false;

                     return false;
              } else {
                     $this->uploaded = true;

                     return true;
              }
       }


       /**
        * @return bool
        */
       private function upload_dir() {

              $this->uploaded = true;
              if (!is_dir($this->upload_dir)) {
                     if ($this->mkdir) {
                            if (!mkdir($this->upload_dir)) {
                                   $this->uploaded = false;
                            } else {
                                   if (!chmod($this->upload_dir, 0777)) $this->uploaded = false;
                            }
                     } else {
                            $this->uploaded = false;
                     }
              }
              // � ��� ���� �������?
              if (!is_dir($this->upload_dir)) {
                     $this->error .= '<li><strong>'.$this->upload_dir.'</strong> �� ����� ����� � ������!</li>';
                     $this->uploaded = false;
              }
              // � ��� ���� ����� �� ������ � �������?
              if (is_dir($this->upload_dir) && !is_writable($this->upload_dir)) {
                     $this->error .= '<li><strong>'.$this->upload_dir.'</strong> � �������� �� ���������� ���������� �� ������!</li>';
                     $this->uploaded = false;
              }
              if (!$this->uploaded) {
                     $this->error .= '<li><strong></strong> ��� ��� �� ���� ������� ����� ��� ��������!</li>';

                     return false;
              } else {
                     return true;
              }
       }


       /**
        * Function to resieze image
        *
        * @return bool
        */
       public function resize() {

              $oryginalWidth  = (int)$_POST['w'];
              $oryginalHeight = (int)$_POST['h'];
              if ($oryginalWidth > $oryginalHeight) {
                     $thumbWidth  = $this->maxThumbSize;
                     $thumbHeight = intval($this->maxThumbSize * ($oryginalHeight / $oryginalWidth));
              } else if ($oryginalWidth < $oryginalHeight) {
                     $thumbWidth  = intval($this->maxThumbSize * ($oryginalWidth / $oryginalHeight));
                     $thumbHeight = $this->maxThumbSize;
              } else {
                     $thumbWidth  = $this->maxThumbSize;
                     $thumbHeight = $this->maxThumbSize;
              }
              $this->thumbImage = imagecreatetruecolor($thumbWidth, $thumbHeight);
              if ($this->type == 'image/gif') {
                     $sourceImage = imagecreatefromgif($this->tmp);
              } else if ($this->type == 'image/jpeg') {
                     $sourceImage = imagecreatefromjpeg($this->tmp);
              } else {
                     $sourceImage = imagecreatefrompng($this->tmp);
              }
              if (imagecopyresampled($this->thumbImage, $sourceImage, 0, 0, (int)$_POST['x1'], (int)$_POST['y1'],
                     $thumbWidth, $thumbHeight, $oryginalWidth, $oryginalHeight)
              ) {
                     $this->uploaded = true;

                     return true;
              } else {
                     $this->uploaded = false;

                     return false;
              }
       }



       // ��������� ��������� ������
       function result_report() {

              if (isset($this->error)) {
                     echo '<ul>';
                     echo $this->error;
                     echo '</ul>';
              }
              if ($this->uploaded == true) {
                     echo '<ul>';
                     echo $this->message;
                     echo '</ul>';
              }
       }


       /**
        * Function to upload image
        *
        * @return bool
        */
       public function upload() {

              $this->uploaded = true;
              $this->upload_dir();
              $this->validate();
              $this->resize();
              if ($this->type == 'image/gif') {
                     if (!imagegif($this->thumbImage, $this->upload_dir.$this->newThumbName)) $this->uploaded = false;
              } else if ($this->type == 'image/jpeg') {
                     if (!imagejpeg($this->thumbImage, $this->upload_dir.$this->newThumbName, $this->quality)) $this->uploaded = false;
              } else {
                     if (!imagepng($this->thumbImage, $this->upload_dir.$this->newThumbName)) $this->uploaded = false;
              }
              if ($this->uploaded) $this->message = '���� ������� ��������!';
              if ($this->report) $this->result_report();
       }

}