<?php
			/**
				* Created by JetBrains PhpStorm.
				* User: Jurii
				* Date: 16.06.13
				* Time: 17:35
				* To change this template use File | Settings | File Templates.
				*/

       if ($_SERVER['PHP_SELF'] === '/gb/index.php') {
              chdir('../');
       }
			require_once __DIR__.'/alex/fotobank/Framework/Boot/config.php';
			$session = check_Session::getInstance();

			$link    = new link_Obfuscator($session->get('referralSeed'));
			// print "actual referral Seed:". $_SESSION['referralSeed'] ."<br />\n";
			$session->set('referralSeed', $link->seed);
			if (!isset($_GET['key']) and !isset($_GET['user']) and !isset($_GET['acc']) and !isset($_POST['idZakaz']))	{
						err_exit('� ��� ��� ���� ������� �� ������ ��������!');
			}
			if (!$session->has('logged') and (!isset($_POST['idZakaz']))) // ��������� �������� ������ �� idZakaz
			{
						err_exit('������� ���� ����� � ������. �������� ������ �� ������ �������� ��������!');
			}
			// ������� �� FTP ����� ������
			if (isset($_POST['idZakaz'])) {
						$session = check_Session::getInstance();
						$session->set('referralSeed', $link->seed);
						$newLink         = '/inc/sobrZakaz.php';
						$idZakaz         = trim($_POST['idZakaz']);
						$newLinkObscured = $link->obfuscate(preg_replace('/(&|\?)go=(\w)+/', '', $newLink));
						// echo $newLinkObscured."<br>";
						main_redir($newLinkObscured.'&idZakaz='.$idZakaz);
			}
			// �����  ������
			if (isset($_GET['key'])) {
						$session = check_Session::getInstance();
						$session->set('referralSeed', $link->seed);
						$newLink         = '/printZakaz.php';
						$key             = trim($_GET['key']);
						$newLinkObscured = $link->obfuscate(preg_replace('/(&|\?)go=(\w)+/', '', $newLink));
						main_redir($newLinkObscured.'&key='.$key);
			}
			// �������� ������������
			if (isset($_GET['user']) and $_GET['user'] == $session->get('userVer')) {
						$session = check_Session::getInstance();
						$session->set('referralSeed', $link->seed);
						$newLink         = '/page.php';
						$newLinkObscured = $link->obfuscate(preg_replace('/(&|\?)go=(\w)+/', '', $newLink));
						$session->del('userVer');
						unset($_GET['user']);
						main_redir($newLinkObscured);
			}
			// ���������� �����
			if (isset($_GET['acc']) and $_GET['acc'] == $session->get('accVer')) {
						$session = check_Session::getInstance();
						$session->set('referralSeed', $link->seed);
						$newLink         = '/inc/accInv.php';
						$newLinkObscured = $link->obfuscate(preg_replace('/(&|\?)go=(\w)+/', '', $newLink));
						unset($_GET['acc']);
						main_redir($newLinkObscured);
			}
			err_exit('���� �� �������� �� ��������. ����������� ��� ��������� ������ ��������, �������������� �� ��������������� ���������.');
