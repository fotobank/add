<?php
  /**
	* ������� �����
	*
	* Created by JetBrains PhpStorm.
	* User: Jurii
	* Date: 06.06.13
	* Time: 1:36
	* To change this template use File | Settings | File Templates.
	*/

  include __DIR__.'/../alex/fotobank/Framework/Boot/config.php';

  $error_processor = Error_Processor::getInstance();
  include __DIR__.'/lib/zn_ftp/zn_ftp.php';


if ($link->referralSeed) {
if($link->check($_SERVER['SCRIPT_NAME'].'?go='.trim(isset($_GET['go'])?$_GET['go']:''))){
  // �������� ����������� �������
  //	print "<br>checked link: ${_SERVER['REQUEST_URI']}<br />\n";

if (isset($_GET['idZakaz']))
{
  $data       = go\DB\query('select * from `print` where `id` = ?i', array($_GET['idZakaz']), 'row');
  $photo_data = go\DB\query('select * from `order_print` where `id_print` = ?i', array($data['id']), 'assoc');
if (!$photo_data)
  {
	 ?>
	 <script type='text/javascript'>
		dhtmlx.message.expire = 6000; // ����� ����� ���������
		dhtmlx.message({ type: 'error', text: '����� �� ������ � ���� ������!'});
	 </script>
  <?
  }
else
{
  $FTP_HOST_FROM = get_param('ftp_host', 0);
  $FTP_USER_FROM = get_param('ftp_user', 0);
  $FTP_PSWD_FROM = get_param('ftp_pass', 0);
  if ($data['id_dost'] == '��������� �� ������ (� ������)')
	 {
		$param_index = go\DB\query('SELECT `param_index` FROM `nastr` WHERE `param_value` = ?string',
		  array($data['adr_studii']),'el');
		$FTP_HOST_TO = get_param('ftp_pecat_host', $param_index);
		$FTP_USER_TO = get_param('ftp_pecat_user', $param_index);
		$FTP_PSWD_TO = get_param('ftp_pecat_pass', $param_index);
		$zakaz       = '/';
	 }
  else
	 {
		$FTP_HOST_TO = $FTP_HOST_FROM;
		$FTP_USER_TO = $FTP_USER_FROM;
		$FTP_PSWD_TO = $FTP_PSWD_FROM;
		$zakaz       = '/zakaz/';
	 }
  $ramka = ($data['ramka'] == 1) ? '����� �����' : '��� �����';
  if ($data['mat_gl'] == '���������')
	 {
		$bumaga = '������';
	 }
  elseif ($data['mat_gl'] == '�������')
	 {
		$bumaga = '���';
	 }
  if ($data['id_nal'] == '���������� ������� �����')
	 {
		$dolg  = '���';
		$pecat = '����� ��������';
	 }
  else
	 {
		$dolg  = $data['summ'].' ��';
		$pecat = '�� �������� �� ��������';
	 }
  $koll = 0;
  foreach ($photo_data as $foto)
	 {
		$koll += $foto['koll'];
	 }
  $name_dir1
				 =
	'�'.$data['id'].' �����. '.$data['name'].' '.$data['subname'].' �����-'.$data['format'].' '.$koll.'��. ����-'.$dolg;
  $name_dir2 = $bumaga.'_'.$data['format'].'_'.$ramka.' ('.$pecat.')';
  $to        = $zakaz.$name_dir1.'/'.$name_dir2.'/';
if ($FTP_HOST_FROM && $FTP_USER_FROM && $FTP_PSWD_FROM)
  {
	 $ftp = new ZN_FTP($FTP_HOST_TO, $FTP_USER_TO, $FTP_PSWD_TO);
	 $ftp->set_path($zakaz);
	 if ($ftp->is_dir($name_dir1) == false)
		{
		  $ftp->mkdir($name_dir1);
		}
	 $ftp->set_path($zakaz.$name_dir1.'/');
	 if ($ftp->is_dir($name_dir2) == false)
		{
		  $ftp->mkdir($name_dir2);
		}
	 foreach ($photo_data as $foto)
		{
		  $from = go\DB\query('select p.ftp_path
															 FROM order_print  o, photos  p
															 WHERE o.id_print = ?i
															 AND o.id_photo = p.id
															 AND o.id_photo = ?i',
			 array($foto['id_print'], $foto['id_photo']),
			 'el');
		  $ftp->set_path($to);
		  $foldKoll = '�� '.$foto['koll'].'��';
		  if ($ftp->is_dir($foldKoll) == false)
			 {
				$ftp->mkdir($foldKoll);
			 } // ������� ����� ���-�� ����������
		  $file
						=
			$FTP_HOST_FROM.$from; // ���������� ���� �� ������������ ����� ������� � www ���������� (��������� �� ����)
		  $fileFrom = "ftp://".$FTP_USER_FROM.":".$FTP_PSWD_FROM."@".$file; // ���� - ��������
		  $fileTo   = $to.$foldKoll; // ���������� ���� �� ���������� �� ������ ���, ���� ����� ���������� ����
		  // ��������
		  $ftp->upload($fileFrom, $fileTo);
		  ?>
		  <script type='text/javascript'>
			 humane.timeout = 6000;
			 humane.success("����� ����������� � ������.");
		  </script>
		<?
		}
  }
else
{
  ?>
  <script type='text/javascript'>
	 dhtmlx.message.expire = 6000; // ����� ����� ���������
	 dhtmlx.message({ type: 'error', text: '���������� ��������� ��� ����������� � FTP'});
  </script>
<?
}
}
}

} else {
 // print "link invalid: ${_SERVER['REQUEST_URI']} \n";
   include (__DIR__.'/../error_.php');
}
}  else include (__DIR__.'/../error_.php');
