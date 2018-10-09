<?php
       /**
        * Created by PhpStorm.
        * User: Jurii
        * Date: 04.10.2018
        * Time: 23:41
        */

       namespace Framework\Zip\CreateZip;
       namespace Framework\Zip\CreateZipRuntimeException;
       use function is_dir, count;
       use ZipArchive;

       /**
        * Class CreateZip
        *
        * @package Framework\Zip\CreateZip
        */
       class CreateZip {

              public $error = ''; //error holder
              protected $file_folder = 'files/'; // ����� ��� �������� ������


              public function __construct() {

                     // �������� ���������� ZIP
                     if (\extension_loaded('zip')) {
                            // �������� ��������� ������
                            if (isset($_POST['files'], $_POST['create_zip']) && count($_POST['files']) > 0) {
                                   if(!is_dir($this->file_folder) && !mkdir($this->file_folder, 0777) && !is_dir($this->file_folder)) {
                                          throw new CreateZipRuntimeException(sprintf('Directory "%s" was not created', $this->file_folder));
                                   }
                                   $this->downloadZip();
                            } else {
                                   $this->error .= '* ��������, ����������, ����� `���������`.<br/>';
                            }
                     } else {
                            $this->error .= '* �� ������ ������� �� ����������� ���������� PHP ZIP<br/>';
                     }
              }


              /**
               *
               */
              protected function downloadZip() :void {

                     $zip      = new ZipArchive();
                     $zip_name = time().'.zip';

                     // �������� zip-����� ��� �������� ������
                     if ($zip->open($zip_name, ZIPARCHIVE::CREATE) !== true) {
                            $this->error .= '* ������ ��� �������� ZIP-������<br/>';
                     }
                     foreach ($_POST['files'] as $file) {
                            require_once __DIR__.'/../../../../inc/downloadZip.php';
                            // ���������� ������ � zip
                            $zip->addFile($this->file_folder.$file);
                     }
                     $zip->close();
                     if (file_exists($zip_name)) {
                            // �������� zip
                            header('Content-type: application/zip');
                            header('Content-Disposition: attachment; filename="'.$zip_name.'"');
                            readfile($zip_name);
                            unlink($zip_name);
                     }
              }

       }
