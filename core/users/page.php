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
	 if(($link->check($_SERVER['SCRIPT_NAME'].'?go='.trim(isset($_GET['go'])?$_GET['go']:''))) || $_GET['user'] == $_SESSION['userForm']){
	//	   print "<br>actual referral Seed:". $_SESSION['referralSeed'] ."<br />\n";
	//		print "checked link: ${_SERVER['REQUEST_URI']}<br />\n";
?>
		<style>

		  #userForm legend {
			 border-image: none;
			 border: 0 none #000000;
			 border-bottom: 1px solid;
			 color: #6e26ab;
			 display: block;
			 font-size: 26px;
			 line-height: 40px;
			 margin-bottom: 20px;
			 padding: 0;
			 width: 100%;
		  }

		  #userForm div{
		          margin:3px 0;
                padding:3px 0;
                min-height:18px;
            }

		  #userForm p{
		          font-size:80%;
                font-style:italic;
            }

		   input.formUser, input[name="form1_submit"], select, textarea{
		     		 background-color: #e6e0ce;
                border:1px solid #585559;
                border-radius:4px;
                -moz-border-radius:4px;
                -webkit-border-radius:4px;
                display:block;
                width:260px;
				    padding: 0 5px;
            }

            #form_example input,
            #form_example select,
            #form_example textarea{
                margin-left:210px;
            }

		  input[type=submit]{
			float: right;
			 margin-right: 210px;
			 width:100px;
		  }

		  input[type=submit]:hover{
							background-color: #e6b1ba;
							cursor:pointer;
            }

		  input[type=submit]:active{
							background-color: #7cff7e;
				         color: #030202;
            }

		  input[type=radio], input[type=checkbox]{
							 display:inline;
							 margin:4px;
							 margin-left:0 !important;
							 width: auto;
            }

           label.sublabel{
					 float:none;
					 text-align:left;
                margin-left: 210px;
                display:block;
                font-weight:normal;
				    width: 300px;
            }

            input[type=hidden]{
						display:none;
				 }
            input:focus, select:focus, textarea:focus{
						background-color: #f4f0ed;
            }

		  form fieldset div label{
					  	text-align:right;
              	   width:200px;
              	 	float:left;
                  font-weight:bold;
				      margin-right: 10px;
            }

		  #errorList label{
			 text-align:left;
			 width:500px;
			 font-weight:bold;
			 margin-right: 10px;
		  }

		  #userForm  label span{
		            color: #ff686b;
	 }

            .small{
						float:left;
						margin-left:10px !important;
               	 width:100px !important;
            }

            div.error{
						background-color: #e6d1b2;
            }
            .errorbox{
					background-color: #ddddde;
                font-size:80%;
                border:1px solid #302d31;
                line-height:140%;
            }

            .errorbox ul{
					padding-left:20px;
            }

            .errorbox h4{
					margin:5px;
            }
            .errorbox label{
				  float:none;
				  cursor:pointer;
	        }

            .errorbox label:hover{
					text-decoration:underline;
            }

        </style>
		<br><br>


<?
		require(__DIR__.'/../../core/users/form/formgenerator.php');
      // ������ ��������
		$_SESSION['userForm'] = genpass(20, 2);
		$link='/core/users/page.php?user='.$_SESSION['userForm'];

		$form=new Form();
		$ok = '<div class="drop-shadow lifted" style="margin: 20px 0 0 470px;">
			    <div style="font-size: 24px;">��������� ��������!</div>
		       </div>';

		//��������� �����
		$form->set("title", "��������� ������������:  <strong style='font-size: 28px; margin: 0 0 0 20px;'><i>".$_SESSION['us_name']."</i></strong>");
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
		$form->set("showAfterSuccess", true); // ���������� ����� ����� �����
		$form->set("cleanAfterSuccess", false);  // ������� ���� ����� ����������� �����
		$form->JSprotection("36CxgD");

		$loader = $db->query('SELECT `login`, `email`,  `skype`,  `phone`,  `block`,  `mail_me`, `us_name`,  `us_surname`, `city` FROM `users` WHERE `id` = ?i',
                array($_SESSION['userid']),'row');

		$block = ($loader['block'] == 1)?'����������, ��� ���������� ������ �������� ������ ���������� ���� ������ ������.
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

		$form->addField("checkbox", "mail_me","��������� �������������", false, $loader['mail_me'], " �������� ��� �����������?");

		$form->addField("checkbox", "delUser","������� ������������", false, false, " �������� �������� �� ���� ������.");
		$form->addField("checkbox", "terms","��������� �����", true, false, " ����������� ��������� ��������� ������.");


		/**
		 * ��������� ������
		 */
		$form->validator("login", "loginValidator",  3, 20, "/[?a-zA-Z�-��-�0-9_-]{3,20}$/", "����� ����� �������� �� ����, ����, ������� � �������������. ����� �� 3 �� 20 ��������.");
		$form->validator("pass", "passValidator", "pass", "pass2", 4, 20, "/^[0-9a-z]+$/i", "� ���� `������` ������� ������������ �������.<br>����������� ��������� ����������
		 �� ���������� ����. ����������� ������ ��������� ������� � �����! ��� ������������ ����� ������ ������ ���� �� ������ 8-10 ��������.");
		$form->validator("us_name", "regExpValidator", 2, 20, "/[?a-zA-Z�-��-�0-9_-]{2,20}$/", "��� ����� �������� �� ����, ����, ������� � �������������. ����� �� 2 �� 20 ��������.");
		$form->validator("us_surname", "regExpValidator", 2, 20, "/[?a-zA-Z�-��-�0-9_-]{2,20}$/",
		                                                                                   "������� ����� �������� �� ����, ����, ������� � �������������. ����� �� 2 �� 20 ��������.");
		$form->validator("phone", "phoneValidator",  6, 20, "/[%a-z_@.,^=:;�-�\"*()&$#�!?<>\~`|[{}\]]/i", "������������ ����.<br> ������ ����������� �������: +380-12-34-56-789
		                                                       ��� 8-076-77-56-567 ��� 777-56-56 ��� 7775656");
		$form->validator("skype", "regExpValidator",  3, 20, "/[?a-zA-Z�-��-�0-9_-]{0,20}$/", "skype ����� �������� �� ����, ����, ������� � �������������. ����� �� 3 �� 20 ��������.");
		$form->validator("email", "regExpValidator", 4, 20, "/[0-9a-z_]+@[0-9a-z_^\.-]+\.[a-z]{2,3}/i", "�� �������������� ����� ����������� �����");
		$form->validator("city", "regExpValidator",  3, 20, "/[?a-zA-Z�-��-�0-9_-]{0,20}$/",
		                                                       "�������� ������ ����� �������� �� ����, ����, ������� � �������������. ����� �� 3 �� 20 ��������.");

		//����������� �����
		$form->display("���������", "form1_submit");

		//��������� �������������� ������ ��� ����������� �������������
		$result=($form->getData());
		// ������������� �������� ����� ����� ���������� ������
		unset($form);

		// �������� ��������
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