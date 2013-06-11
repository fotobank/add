<?php

require_once ('zn_ftp.php');

try
{

	$ftp = new ZN_FTP("example.com", "ftpuser", "ftppass");						// ������������ ����������
	$ftp = new ZN_FTP("example.com", "ftpuser", "ftppass", "/public_html");		// ���� ������������ ��� ������������� �����
	$ftp = new ZN_FTP("example.com", "ftpuser", "ftppass", "/", 10021);			// ������������� ftp ���� 10021
	$ftp = new ZN_FTP("example.com", "ftpuser", "ftppass", "/", 21, true);		// ���������� ����� ����� ssl
	$ftp->connect();															// ����� ����������
	$ftp->close();																// ������� ����������

	if (!$ftp->is_file("index.php") and !$ftp->is_dir("index.php"))
	{
		echo "����� ��� ����� �� ����������";
	}

	$files_and_dirs = $ftp->ls("lib");											// �������� ����� � �������� � ����� "/public_html/lib"
	$jpg_files = $ftp->ls("/public_html/images", "file", "jpg");				// �������� jpg ����� � ����� "/public_html/images"
	$dir = $ftp->ls("/public_html", "dir");										// �������� ����� � ����� "/public_html"

	echo $ftp->get("css/default.css");											// �������� /public_html/css/default.css
	$ftp->put(".htaccess", "Deny from all");									// �������� ������ � .htaccess

	$ftp->mkdir("/public_html/arhiv");											// ������� ����� arhiv
	$ftp->cp("css", "arhiv");													// ���������� /public_html/css /public_html/arhiv/css
	$ftp->cp("index.php", "/public_html/index_old.php");						// ���������� index.php � index_old.php
	$ftp->mv("css_bad", "arhiv");												// ��������� /public_html/css_bad /public_html/arhiv
	$ftp->rm("/public_html/tmp");												// ������� ����� tmp
	$ftp->chmod("cache", 0777);													// ���������� ���������� ����� 777 �� ����� cache 
	$ftp->mv("arhiv/css", ".");													// ��������� ����� css � /public_html

	echo $ftp->size("/public_html/upload");										// �������� ������ ����� upload � ������

	$ftp->upload($_FILES['image']['tmp_name'], "/upload/" . $_FILES['image']['name'], true); // ��������� ���� � �����
	$ftp->upload_dir("/home/user/icons", "/www/images/icons");					// �������� �����

	$ftp->set_path("/www");														// ������� ����� ��� chroot
	$ftp->chroot_enable();														// �������� chroot
	echo $ftp->get("/log/error.log");											// ������ ������ �.�. �� ��������� �������� �����
	$ftp->chroot_disable();														// ��������� chroot

	$ftp->download("/log/access.log");											// ������� ���� access.log
	$ftp->download("/log/error.log", "/home/user/error.log");					// ������� ���� error.log � ��������� �����
	$ftp->download_dir("/www", "/arhiv/site/" . date("Y-m-d", time()));			// ������� ����� ������ �����

	$dirs_and_files = array
		(
		'/www/img',
		'/log/access.log',
		'favicon.ico',
		'/www/upload'
	);
	$ftp->zip($dirs_and_files, "main.zip");										// ������� ����� � ����� zip-������� (���� ��������)
	$ftp->zip("/log", null, "/arhiv/" . date("Y-m-d", time()) . ".zip");		// ������� ���� � zip-�����
}
catch (Exception $e)
{
	echo $e->getMessage();
}
?>
