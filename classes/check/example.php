<?php

       try {
              require_once __DIR__.'/../../vendor/autoload.php';
       }
       catch (\RuntimeException $e) {
              if (\check_Session::getInstance()->has('DUMP_R')) {
                     dump_r($e->getMessage());
              }
       }



// ��� ������ ������ ���� ������� ����� ��������� ����-������ � ������� (����� echo).
// �� �� ������ ������� session_start ��� ����� ��������..
// �� ������ ��������� ������ ����� ����� ��������� (call session_set_cookie_params or session_name).

// ������ ��� ���������� �������� ������
check_Session::getInstance()->set('example', 123);

// ������ ��� �������� �������� �� ������ �� �����
$value = check_Session::getInstance()->get('example');

// ������, ��� ��������� ������������� �����
$exists = check_Session::getInstance()->has('example');

// ������ ��� �������� �������� �� ������ �� �����
check_Session::getInstance()->del('example');

