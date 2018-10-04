<?php
       /**
        * Created by PhpStorm.
        * User: Jurii
        * Date: 04.10.2018
        * Time: 23:41
        */

       namespace Framework\Zip\CreateZip;
       use function is_dir;
       use ZipArchive;

       /**
        * Class CreateZip
        *
        * @package Framework\Zip\CreateZip
        */
       class CreateZip {

              public $error = ''; //error holder
              protected $file_folder = 'files/'; // папка для загрузки файлов


              public function __construct() {

                     // Проверка расширения ZIP
                     if (\extension_loaded('zip')) {
                            // Проверка выбранных файлов
                            if (isset($_POST['files'], $_POST['create_zip']) && \count($_POST['files']) > 0) {
                                   if(!is_dir($this->file_folder) && !mkdir($this->file_folder, 0777) && !is_dir($this->file_folder)) {
                                          throw new \RuntimeException(sprintf('Directory "%s" was not created', $this->file_folder));
                                   }
                                   $this->downloadZip();
                            } else {
                                   $this->error .= '* Выберите, пожалуйста, файлы `галочками`.<br/>';
                            }
                     } else {
                            $this->error .= '* На данном сервере не установлено расширение PHP ZIP<br/>';
                     }
              }


              /**
               *
               */
              protected function downloadZip() {

                     $zip      = new ZipArchive();
                     $zip_name = time().'.zip';

                     // Открытие zip-файла для загрузки файлов
                     if ($zip->open($zip_name, ZIPARCHIVE::CREATE) !== true) {
                            $this->error .= '* Ошибка при создании ZIP-архива<br/>';
                     }
                     foreach ($_POST['files'] as $file) {
                            require_once __DIR__.'/downloadZip.php';
                            // Добавление файлов в zip
                            $zip->addFile($this->file_folder.$file);
                     }
                     $zip->close();
                     if (file_exists($zip_name)) {
                            // передача zip
                            header('Content-type: application/zip');
                            header('Content-Disposition: attachment; filename="'.$zip_name.'"');
                            readfile($zip_name);
                            // удалить существующий zip-файл в temp-пути
                            unlink($zip_name);
                     }
              }

       }
