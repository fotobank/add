<?php

require('checkSession.php');

// ��� ������ ������ ���� ������� ����� ��������� ����-������ � ������� (����� echo).
// �� �� ������ ������� session_start ��� ����� ��������..
// �� ������ ��������� ������ ����� ����� ��������� (call session_set_cookie_params or session_name).

// ������ ��� ���������� �������� ������
checkSession::getInstance()->set('example', 123);

// ������ ��� �������� �������� �� ������ �� ��������
$value = checkSession::getInstance()->get('example');

// ������, ��� ��������� ������������� �����
$exists = checkSession::getInstance()->has('example');

// ������ ��� �������� �������� �� ������ �� �����
checkSession::getInstance()->del('example');

