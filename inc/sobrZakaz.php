<?php
  /**
	* Собрать заказ
	*
	* Created by JetBrains PhpStorm.
	* User: Jurii
	* Date: 06.06.13
	* Time: 1:36
	* To change this template use File | Settings | File Templates.
	*/

  set_time_limit(0);
 // error_reporting(E_ALL);
 // ini_set('display_errors', 1);
  error_reporting(0);
  ignore_user_abort(1);
  include (__DIR__.'/config.php');
  include (__DIR__.'/func.php');
  include (__DIR__.'/lib_mail.php');
  include (__DIR__.'/lib_ouf.php');
  include (__DIR__.'/lib_errors.php');
  $error_processor = Error_Processor::getInstance();
  include (__DIR__.'/lib/zn_ftp/zn_ftp.php');



if (isset($_POST['idZakaz']))
{
  $data       = $db->query('select * from `print` where `id` = ?i', array($_POST['idZakaz']), 'row');
  $photo_data = $db->query('select * from `order_print` where `id_print` = ?i', array($data['id']), 'assoc');
if (!$photo_data)
  {
	 ?>
	 <script type='text/javascript'>
		dhtmlx.message.expire = 6000; // время жизни сообщения
		dhtmlx.message({ type: 'error', text: 'Заказ не найден в базе данных!'});
	 </script>
  <?
  }
else
{
  $FTP_HOST_FROM = get_param('ftp_host', 0);
  $FTP_USER_FROM = get_param('ftp_user', 0);
  $FTP_PSWD_FROM = get_param('ftp_pass', 0);
  if ($data['id_dost'] == 'Самовывоз из студии (в Одессе)')
	 {
		$param_index = $db->query('SELECT `param_index` FROM `nastr` WHERE `param_value` = ?string',
		  array($data['adr_studii']),
		  'el');
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
  $ramka = ($data['ramka'] == 1) ? 'белая рамка' : 'без рамки';
  if ($data['mat_gl'] == 'глянцевая')
	 {
		$bumaga = 'Глянец';
	 }
  elseif ($data['mat_gl'] == 'матовая')
	 {
		$bumaga = 'Мат';
	 }
  if ($data['id_nal'] == 'пополнение баланса сайта')
	 {
		$dolg  = 'нет';
		$pecat = 'можно печатать';
	 }
  else
	 {
		$dolg  = $data['summ'].' гр';
		$pecat = 'не печатать до рассчета';
	 }
  $koll = 0;
  foreach ($photo_data as $foto)
	 {
		$koll += $foto['koll'];
	 }
  $name_dir1
				 =
	'№'.$data['id'].' Получ. '.$data['name'].' '.$data['subname'].' Всего-'.$data['format'].' '.$koll.'шт. Долг-'.$dolg;
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
		  $from = $db->query('select p.ftp_path
															 FROM order_print  o, photos  p
															 WHERE o.id_print = ?i
															 AND o.id_photo = p.id
															 AND o.id_photo = ?i',
			 array($foto['id_print'], $foto['id_photo']),
			 'el');
		  $ftp->set_path($to);
		  $foldKoll = 'По '.$foto['koll'].'шт';
		  if ($ftp->is_dir($foldKoll) == false)
			 {
				$ftp->mkdir($foldKoll);
			 } // создаем папку кол-во фотографий
		  $file
						=
			$FTP_HOST_FROM.$from; // Абсолютный путь до скачиваемого файла начиная с www директории (доступной из веба)
		  $fileFrom = "ftp://".$FTP_USER_FROM.":".$FTP_PSWD_FROM."@".$file; // файл - источник
		  $fileTo   = $to.$foldKoll; // Асболютный путь до директории на втором фтп, куда будем закачивать файл
		  // Копируем
		  $ftp->upload($fileFrom, $fileTo);
		  ?>
		  <script type='text/javascript'>
			 humane.timeout = 6000;
			 humane.success("Заказ подготовлен к печати.");
		  </script>
		<?
		}
  }
else
{
  ?>
  <script type='text/javascript'>
	 dhtmlx.message.expire = 6000; // время жизни сообщения
	 dhtmlx.message({ type: 'error', text: 'Недоступны параметры для подключения к FTP'});
  </script>
<?
}
}
}
