<?php
/**
 * Created by PhpStorm.
 * User: Jurii
 * Date: 12.04.14
 * Time: 11:41
 */
       $ini = go::has('md5_loader') ? NULL : array(
              'pws'          => 'Protected_Site_Sec', // ��������� ������
              //    "text_string"  => "����", // ����� �������� �����
              'vz'           => 'img/vz.png', // �������� �������� �����
              'vzm'          => 'img/vzm.png', // multi �������� �������� �����
              'font'         => __DIR__.'/arialbd.ttf', // ����������� �����
              'text_padding' => 10, // �������� �� ����
              'hotspot'      => 2, // ������������ ������ � ����� �������� (1-9)
              'font_size'    => 16, // ������ ������ �������� �����
              'iv_len'       => 24, // ��������� �����
              'rgbtext'      => 'FFFFFF', // ���� ������
              'rgbtsdw'      => '000000', // ���� ����
              'process'      => 'show=>security/protected.gif', // "jump=>security/protected.php"
              // ��� �������� "jump=>security/protected.gif" - ��������� ��� ���������� �������
       );
