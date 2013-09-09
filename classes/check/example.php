<?php

   require_once (__DIR__.'/../autoload.php');
	autoload::getInstance();



// ��� ������ ������ ���� ������� ����� ��������� ����-������ � ������� (����� echo).
// �� �� ������ ������� session_start ��� ����� ��������..
// �� ������ ��������� ������ ����� ����� ��������� (call session_set_cookie_params or session_name).

// ������ ��� ���������� �������� ������
check_Session::getInstance()->set('example', 123);

// ������ ��� �������� �������� �� ������ �� ��������
$value = check_Session::getInstance()->get('example');

// ������, ��� ��������� ������������� �����
$exists = check_Session::getInstance()->has('example');

// ������ ��� �������� �������� �� ������ �� �����
check_Session::getInstance()->del('example');

