<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 20.06.13
 * Time: 21:57
 * To change this template use File | Settings | File Templates.
 */

  /**
	* @param bool $isUserActivity
	* @param null $prefix
	* ����� ������
	* @return bool
	*/
  function startSession($isUserActivity=true, $prefix=NULL) {
	 $sessionLifetime = 600; // ������� ���������� ���������� ������������ (� ��������)
	 $idLifetime = 60;  // ����� ����� �������������� ������

	 if ( session_id() ) return true;
	 // ���� � ���������� ������� ������� ������������,
	 // ������������� ���������� ��� ������, ���������� ���� �������,
	 // ����� ������������� ����� ��� ���� ������������� ��� (��������, SID)
	 session_name('SID'.($prefix ? '_'.$prefix : ''));
	 // ������������� ����� ����� ���� �� �������� �������� (�������������� ��� ����� �� ������� �������)
	 ini_set('session.cookie_lifetime', 0);
	 if (!session_start())
		{
		  session_regenerate_id(true);
		}
	 else
		{
		  return false;
		}

	 $t = time();

	 if ( $sessionLifetime ) {
		// ���� ������� ���������� ���������� ������������ �����,
		// ��������� �����, ��������� � ������� ��������� ���������� ������������
		// (����� ���������� �������, ����� ���� ��������� ���������� ���������� lastactivity)
		if ( isset($_SESSION['lastactivity']) && isset($_SESSION['logged']) && isset($_SESSION['logged']) == true && $t-$_SESSION['lastactivity'] >= $sessionLifetime ) {
		  // ���� �����, ��������� � ������� ��������� ���������� ������������,
		  // ������ �������� ���������� ����������, ������ ������ �������, � ����� ��������� �����
		  destroySession();
		  return false;
		}
		else {
		  // ���� ������� ��� �� ��������,
		  // � ���� ������ ������ ��� ��������� ���������� ������������,
		  // ��������� ���������� lastactivity ��������� �������� �������,
		  // ��������� ��� ����� ����� ������ ��� �� sessionLifetime ������
		  if ( $isUserActivity ) $_SESSION['lastactivity'] = $t;
		}
	 }

	 if ( $idLifetime ) {
		// ���� ����� ����� �������������� ������ ������,
		// ��������� �����, ��������� � ������� �������� ������ ��� ��������� �����������
		// (����� ���������� �������, ����� ���� ��������� ���������� ���������� starttime)
		if ( isset($_SESSION['starttime']) ) {
		  if ( $t-$_SESSION['starttime'] >= $idLifetime ) {
			 // ����� ����� �������������� ������ �������
			 // ���������� ����� �������������
		//	 session_write_close();
			 session_regenerate_id(true);
			 $_SESSION['starttime'] = $t;
		  }
		}
		else {
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
	 if ( session_id() ) {
		session_unset();
		setcookie(session_name(), session_id(), time()-60*60*24);
		session_destroy();
	 }
  }