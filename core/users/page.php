<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 17.06.13
 * Time: 11:25
 * To change this template use File | Settings | File Templates.
 */

   error_reporting(E_ALL);
   ini_set('display_errors', 1);
 // error_reporting(0);
  include (__DIR__.'/../../inc/head.php');

  if ($link->referralSeed) {
	 if(($link->check($_SERVER['SCRIPT_NAME'].'?go='.trim(isset($_GET['go'])?$_GET['go']:''))) || (isset($_GET['user']) and $_GET['user'] == $_SESSION['userForm'])){
	//	   print "<br>actual referral Seed:". $_SESSION['referralSeed'] ."<br />\n";
	//		print "checked link: ${_SERVER['REQUEST_URI']}<br />\n";
?>



		<script type='text/javascript'>
		  $(function() {
		  $('#phone').bind("change keyup input click", function() {
			 if (this.value.match(/[^0-9\(\)\-\+]/g)) {
				this.value = this.value.replace(/[^0-9\(\)\-\+]/g, '');
			 }
		  })
		  })
		</script>

<?
		require(__DIR__.'/../../core/users/form/formgenerator.php');
      // ������ ��������
		$_SESSION['userForm'] = genpass(20, 2);
		$link="/core/users/page.php?user=".$_SESSION['userForm'];


		$form=new Form();
		$ok = '<div class="drop-shadow lifted" style="margin: 20px 0 0 440px;">
			    <div style="font-size: 24px;">��������� ��������!</div>
		       </div>';

		//��������� �����
		$form->set("title", "������������:  <strong style='font-size: 28px; margin: 0 0 0 20px;'><i>".$_SESSION['us_name']."</i></strong>");
		$form->set("name", "userForm"); // �������� �����
		$form->set("action", $link); // ������� �� �������� ��������� $link ����� �����
		$form->set("linebreaks", false);
		$form->set("showDebug", true);
		$form->set("showErrors", true); // ���������� ������
		$form->set("errorTitle", '(!) ������!'); // ��������� ���� � ��������
		$form->set("divs", true); // ����������� ���� � ����
		$form->set("html5",true);
		$form->set("sanitize",true);   // ������� ������ �� html � php
		$form->set("placeholders",true);
		$form->set("errorPosition", "in_before"); // ��� �������� ������
		$form->set("submitMessage", $ok); // ��������� ��������� ����� �����
		$form->set("showAfterSuccess", true); // ���������� ����� ����� ����������� �����
		$form->set("cleanAfterSuccess", false);  // ������� ���� ����� ����������� �����
		$form->JSprotection("36CxgD");

		$loader = $db->query('SELECT `login`, `email`,  `skype`,  `phone`,  `block`,  `mail_me`, `us_name`,  `us_surname`, `city` FROM `users` WHERE `id` = ?i',
                array($_SESSION['userid']),'row');

		$block = ($loader['block'] == 1)?'��� ���������� ������ �������� �����, ����������, ���������� ���� ������ ������.
		���� ���������� ������ ����� �������������� ������ � �������� �������
		����� � ������������ ����� �������� ��������.':'������� ������������!';
      unset($loader['block']);

		$form->loadData($loader);

		//mapped data loading (To hide eg. DB field names)
		// ������������ �������� ������ (��������, ����� ������. ����� ���� ��)
		$loader=Array("dbmessage"=>"��������");
		$map=Array("dbmessage"=>"message");
		$form->loadData($loader, $map);

		//�������� ����
		$form->addText($block);

		$form->addItem("<h2>���������� ������:</h2>");
		$form->addField("text", "login","�����", true,'','class = "formUser"');
		$form->addField("password", "pass","������", false,'','class = "formUser"');
		$form->addField("password", "pass2","��������� ������", false,'','class = "formUser"');
		$form->addField("text", "us_name","���", true,'','class = "formUser"');
		$form->addField("text", "us_surname","�������", true,'','class = "formUser"');
		$form->addField("text", "phone","�������", true,'','class = "formUser"');
		$form->addField("text", "skype","Skype", false,'','class = "formUser"');
		$form->addField("text", "email","E-mail", true,'','class = "formUser"');
		$form->addField("text", "city","����� ����������", false,'','class = "formUser"');

		$form->addField("checkbox", "mail_me","��������� �������������", false, '', " �������� ��� �����������?");

		$form->addField("checkbox", "delUser","������� ������������", false, false, " �������� �������� �� ���� ������.");
		$form->addField("checkbox", "terms","��������� �����", true, false, " ����������� ��������� ��������� ������.");


		/**
		 * ��������� ������
		 */
		$form->validator("login", "loginValidator",  3, 20, "/[?a-zA-Z�-��-�0-9_-]{3,20}$/", "����� ����� �������� �� ����, ����, ������� � �������������. ����� �� 3 �� 20 ��������.");
		$form->validator("pass", "passValidator", "pass", "pass2", 8, 20, "/^[0-9a-z\_\-\!\~\*\:\<\>\+\.]+$/i", "� ���� `������` ������� ������������ �������<br> ��� ����� ������ 8 ��������.<br> ����������� ������ ���������� �������, ����� � �����<br>  . - _ ! ~ * : < > + ");
		$form->validator("us_name", "regExpValidator", 2, 20, "/[?a-zA-Z�-��-�0-9_-]{2,20}$/", "��� ����� �������� �� ����, ����, ������� � �������������. ����� �� 2 �� 20 ��������.");
		$form->validator("us_surname", "regExpValidator", 2, 20, "/[?a-zA-Z�-��-�0-9_-]{2,20}$/",
		                                                                                   "������� ����� �������� �� ����, ����, ������� � �������������. ����� �� 2 �� 20 ��������.");
		$form->validator("phone", "phoneValidator",  6, 20, "/[%a-z_@.,^=:;�-�\"*()&$#�!?<>\~`|[{}\]]/i", "������������ ����.<br> ������ ����������� �������: +380-12-34-56-789
		                                                       ��� 8-076-77-56-567 ��� 777-56-56 ��� 7775656");
		$form->validator("skype", "regExpValidator",  3, 20, "/[?a-zA-Z�-��-�0-9_-]{0,20}$/", "skype ����� �������� �� ����, ����, ������� � �������������. ����� �� 3 �� 20 ��������.");
		$form->validator("email", "regExpValidator", 4, 20, "/[0-9a-z_]+@[0-9a-z_^\.-]+\.[a-z]{2,3}/i", "�� �������������� ����� ����������� �����");
		$form->validator("city", "regExpValidator",  3, 20, "/[?a-zA-Z�-��-�0-9_-]{0,20}$/",
		                                                       "�������� ������ ����� �������� �� ����, ����, ������� � �������������. ����� �� 3 �� 20 ��������.");

  ?>
		<div class="user-tabs">
		  <ul id="myTab" class="nav nav-tabs">
			 <li class="active">
				<a data-toggle="tab" href="#user" data-toggle="tab">�������������� ������ ������������</a>
			 </li>
			 <li class="">
				<a data-toggle="tab" href="#zakaz" data-toggle="tab">��� ����������</a>
			 </li>
			 <!--<li class="dropdown">
			  <a class="dropdown-toggle" data-toggle="dropdown" href="#">
				 Dropdown
				 <b class="caret"></b>
			  </a>
			  <ul class="dropdown-menu">
				 <li class="">
					<a data-toggle="tab" href="#dropdown1">����1</a>
				 </li>
				 <li class="">
					<a data-toggle="tab" href="#dropdown2">����2</a>
				 </li>
			  </ul>
			</li>-->
		  </ul>
		  <div id="myTabContent" class="tab-content">
			 <div id="user" class="tab-pane fade active in">
				<?
				/**
				 * ����������� �����
				 */
				$form->display("���������", "form1_submit");
				?>
			 </div>
				<div id="zakaz" class="tab-pane fade">
				<p>� ���� ������� �� ������ ����������� ������� ����������� ����������. �������� ��������� ������ ���������� � ������� �� ������ "�������". ����� ������������ �� ����� ���� ���� ����� ��������� ������� ����������. </p>
				  <?
				  include_once (__DIR__.'./../users/zip.php');
				  ?>
			 </div>
			 <!--<div id="dropdown1" class="tab-pane fade">
			  <p>
				 1
			  </p>
			</div>
			<div id="dropdown2" class="tab-pane fade">
			  <p>
				 2
			  </p>
			</div>-->
		  </div>
		</div>
		<script>
		  $(function () {
//			 $(" #myTab a:last ").tab('show');
//			 $(' #myTab a[href="#zakaz"] ').tab('show');
		  })
		</script>
		<?
		/**
		 * ��������� �������������� ������ ��� ����������� �������������
		 */
		$result=($form->getData());
		/**
		 * ������������� �������� ����� ����� ���������� ������
		 */
		unset($form);

		/**
		 * �������� ��������
		 */
		if(isset($result['delUser'])) {
		  $db->query('DELETE FROM `users` WHERE `id`=?i',array($_SESSION['userid']));
		  unset($result);
		  $db->close();
		  session_destroy();
		  echo "<script>window.document.location.href='/../../index.php'</script>";
		}

	 if ($result){
	  unset($result['terms']);
	  if($result['pass'] == '') {
		 unset($result['pass']);
		 unset($result['pass2']);
	  } else {
		 $result['pass'] = md5($result['pass']);
		 unset($result['pass2']);
	  }
		$result['mail_me'] = isset($result['mail_me'])?$result['mail_me']:'off';
	   $db->query('UPDATE `users` SET ?set WHERE `id`=?i',array($result,$_SESSION['userid']));
		$_SESSION['user'] = $result['login'];
		$_SESSION['us_name'] = $result['us_name'];
		}

	 }else{
	//	print "<br>actual referral Seed:". $_SESSION['referralSeed'] ."<br />\n";
	//	print "<br>link invalid: ${_SERVER['REQUEST_URI']} \n";
		include (__DIR__.'/../../error_.php');
	 }
  } else include (__DIR__.'/../../error_.php');

?>

  <div class="end_content"></div>
  </div>
<?
  include (__DIR__.'/../../inc/footer.php');
?>