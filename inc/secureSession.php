<?php
       /**
        * Created by JetBrains PhpStorm.
        * User: Jurii
        * Date: 20.06.13
        * Time: 21:57
        * To change this template use File | Settings | File Templates.
        *
        * ������ ������ �� ��������
        * ���������� �������� ������ �� �������� ������ � PHP �������� ��������� ��������� session.use_only_cookies
        * ����������������� ����� php.ini � �������� on.
        * ��� �������� �������� �������������� ������ � URL-������ �������.
        * � ������� ����������� ���������� ���������� $_SESSION['starttime'] ����������� ������ ����������.
        * ���� ���������� �� ������, �� ������������ �������������.
        * ��� ��������� ������� ��� �������������� ����� ������ � ��� ���������������, ����� �������� ���.
        * ����� ����������� � ���, ��� ������������� ��������� �������� ����� ������� �������.
        * ������ ������� ������������� ����� ����������� ���������� ��������
        * ������ � ���������� ��������� ����������. ������� �������������� ������� ������������� ������� �� �������������.
        *
        */
       /**
        * �������� ���������� ������
        * Example
        * if (is_session_started() === false) session_start();
        */
       function isSessionStarted(): bool {

              if (PHP_SAPI !== 'cli') {
                     if (PHP_VERSION_ID >= 50400) {
                            return session_status() === PHP_SESSION_ACTIVE;
                     }
                     return session_id() !== '';
              }
              return false;
       }


       /**
        * @param bool $is_user_activity
        * @param null $prefix
        * ����� ������
        *
        * @return bool
        */
       function startSession($is_user_activity = true, $prefix = NULL) {

              $session_lifetime = 300; // ������� ���������� ���������� ������������ (� ��������)
              $id_lifetime      = 60;  // ����� ����� �������������� ������
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
              if (isSessionStarted() === false) {
                     session_start();
              }

              // ������ �� ����������:
              return true;

              $t = time();
              if ($session_lifetime) {
                     // ���� ������� ���������� ���������� ������������ �����,
                     // ��������� �����, ��������� � ������� ��������� ���������� ������������
                     // (����� ���������� �������, ����� ���� ��������� ���������� ���������� lastactivity)
                     if (isset($_SESSION['lastactivity'], $_SESSION['logged']) && isset($_SESSION['logged']) === true
                         && $t - $_SESSION['lastactivity'] >= $session_lifetime) {
                            // ���� �����, ��������� � ������� ��������� ���������� ������������,
                            // ������ �������� ���������� ����������, ������ ������ �������, � ����� ��������� �����
                            destroySession();
                            return false;

                     }
                     if ($is_user_activity) {
                            $_SESSION['lastactivity'] = $t;
                     }
              }
              if ($id_lifetime) {
                     // ���� ����� ����� �������������� ������ ������,
                     // ��������� �����, ��������� � ������� �������� ������ ��� ��������� �����������
                     // (����� ���������� �������, ����� ���� ��������� ���������� ���������� starttime)
                     if (isset($_SESSION['starttime'])) {
                            if ($t - $_SESSION['starttime'] >= $id_lifetime) {
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

              if (isSessionStarted()) {
                     session_unset();
                     /** @noinspection SummerTimeUnsafeTimeManipulationInspection */
                     setcookie(session_name(), session_id(), time() - (60 * 60 * 24));
                     session_destroy();
              }
       }
