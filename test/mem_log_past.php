<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 07.10.13
 * Time: 21:45
 * To change this template use File | Settings | File Templates.
 */

       /**
        * memory usage
        * @param $size
        *
        * @return string
        */
       function chpu_Bytes($size) {
              $filesize = array(" ����", " ���������", " ��������", " ��������", " ���������", " ��������", " ��������", " ���������", " ���������");
              return $size ? round($size / pow(1024, ($i = floor(log($size, 1024)))), 3) . $filesize[$i] : '0 ����';
       }

       // �������� ������� ������ �������� ����� ������ ���������
       $AllocMem = round(memory_get_peak_usage(true));

       // ���� ������ 3M�, �� ��������.
       if ($AllocMem>3*1024*1024)
       {
         $dtm=date("Y-m-d");

       // ���� � ����� ����

       $fn = __DIR__."/../logs/mem-".$dtm.".log";
       $txt="
       ���������� ������: ".chpu_Bytes($AllocMem)."
       ������: ".$_SERVER['SCRIPT_FILENAME']."
       ������: ".$_SERVER["REQUEST_URI"]."\n";
       file_put_contents($fn,$txt,FILE_APPEND);
       }