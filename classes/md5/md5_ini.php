<?php
/**
 * Created by PhpStorm.
 * User: Jurii
 * Date: 12.04.14
 * Time: 11:41
 */
       $ini = go::has('md5_loader') ? NULL : array(
              'pws'          => 'Protected_Site_Sec', // секретная строка
              //    "text_string"  => "ТЕСТ", // текст водяного знака
              'vz'           => 'img/vz.png', // картинка водяного знака
              'vzm'          => 'img/vzm.png', // multi картинка водяного знака
              'font'         => __DIR__.'/arialbd.ttf', // применяемый шрифт
              'text_padding' => 10, // смещение от края
              'hotspot'      => 2, // расположение текста в углах квадрата (1-9)
              'font_size'    => 16, // размер шрифта водяного знака
              'iv_len'       => 24, // сложность шифра
              'rgbtext'      => 'FFFFFF', // цвет текста
              'rgbtsdw'      => '000000', // цвет тени
              'process'      => 'show=>security/protected.gif', // "jump=>security/protected.php"
              // или картинка "jump=>security/protected.gif" - выводится при незаконной закачке
       );
