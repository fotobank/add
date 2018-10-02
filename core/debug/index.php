<?php
// �������� ��� ��� ������� � ���������� ������
    require_once("PHPDebug.php");
    $debug = new PHPDebug();

    // ������� ��������� �� �������
    $debug->debug("����� ������� ��������� �� �������");

    // ����� ��������� �� �������
    $x = 3;
    $y = 5;
    $z = $x/$y;
    $debug->debug("���������� Z: ", $z);

    // ��������������
    $debug->debug("������� ��������������", null, WARN);

    // ����������
    $debug->debug("������� �������������� ���������", null, INFO);

    // ������
    $debug->debug("������� ��������� �� ������",null, ERROR);

    // ������� ������ � �������
    $fruits = array("�����", "������", "��������", "������");
    $fruits = array_reverse($fruits);
    $debug->debug("������ �������:", $fruits);

    // ������� ������ �� �������
    $book               = new stdClass;
    $book->title        = "����� ������ � ���-�� �� ��������";
    $book->author       = "�. K. �������";
    $book->publisher    = "Arthur A. Levine Books";
    $book->amazon_link  = "http://www.amazon.com/dp/0439136369/";
    $debug->debug("������: ", $book);