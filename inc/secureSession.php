<?php
       /**
        * Created by JetBrains PhpStorm.
        * User: Jurii
        * Date: 20.06.13
        * Time: 21:57
        * To change this template use File | Settings | File Templates.
        */
       /**
        * �������� ���������� ������
        * Example
        * if (is_session_started() === false) session_start();
        */
       function is_session_started(): bool {

              if (PHP_SAPI !== 'cli') {
                     if (PHP_VERSION_ID >= 50400) {
                            return session_status() === PHP_SESSION_ACTIVE;
                     }
                     return session_id() !== '';
              }
              return false;
       }


       /**
        * @param bool $isUserActivity
        * @param null $prefix
        * ����� ������
        *
        * @return bool
        */
       function startSession($isUserActivity = true, $prefix = NULL) {

              $sessionLifetime = 300; // ������� ���������� ���������� ������������ (� ��������)
              $idLifetime      = 60;  // ����� ����� �������������� ������
              /*if (session_id()) {
                     return true;
              }*/
              // ���� � ���������� ������� ������� ������������,
              // ������������� ���������� ��� ������, ���������� ���� �������,
              // ����� ������������� ����� ��� ���� ������������� ��� (��������, SID)
              session_name('SID'.($prefix ? '_'.$prefix : ''));
              // ������������� ����� ����� ���� �� �������� �������� (�������������� ��� ����� �� ������� �������)
              ini_set('session.cookie_lifetime', 0);
              // �������� ������
              if (is_session_started() === false) {
                     session_start();
              }

              $t = time();
              if ($sessionLifetime) {
                     // ���� ������� ���������� ���������� ������������ �����,
                     // ��������� �����, ��������� � ������� ��������� ���������� ������������
                     // (����� ���������� �������, ����� ���� ��������� ���������� ���������� lastactivity)
                     if (isset($_SESSION['lastactivity'], $_SESSION['logged']) && isset($_SESSION['logged']) === true
                         && $t - $_SESSION['lastactivity'] >= $sessionLifetime) {
                            // ���� �����, ��������� � ������� ��������� ���������� ������������,
                            // ������ �������� ���������� ����������, ������ ������ �������, � ����� ��������� �����
                            destroySession();
                            return false;

                     }
                     if ($isUserActivity) {
                            $_SESSION['lastactivity'] = $t;
                     }
              }
              if ($idLifetime) {
                     // ���� ����� ����� �������������� ������ ������,
                     // ��������� �����, ��������� � ������� �������� ������ ��� ��������� �����������
                     // (����� ���������� �������, ����� ���� ��������� ���������� ���������� starttime)
                     if (isset($_SESSION['starttime'])) {
                            if ($t - $_SESSION['starttime'] >= $idLifetime) {
                                   // ����� ����� �������������� ������ �������
                                   // ���������� ����� �������������
                                   //	 session_write_close();
                                   session_regenerate_id(true);
                                   $_SESSION['starttime'] = $t;
                            }
                     } else {
                            // ���� �� ��������, ���� ������ ������ ��� �������
                            // ������������� ����� ��������� �������������� ������ � ������� �����
                            $_SESSION['starttime'] = $t;
                     }
              }

              return true;
       }

       /**
        * ����������� ������
        */
       function destroySession() {

              if (is_session_started()) {
                     session_unset();
                     /** @noinspection SummerTimeUnsafeTimeManipulationInspection */
                     setcookie(session_name(), session_id(), time() - (60 * 60 * 24));
                     session_destroy();
              }
       }
