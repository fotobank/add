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
	 if(($link->check($_SERVER['SCRIPT_NAME'].'?go='.trim(isset($_GET['go'])?$_GET['go']:''))) || $_GET['user'] == $_SESSION['userVer']){
	//	   print "<br>actual referral Seed:". $_SESSION['referralSeed'] ."<br />\n";
	//		print "checked link: ${_SERVER['REQUEST_URI']}<br />\n";
?>
		<style>
            form{
		 			 width:550px;
                background-color: #e6e0ce;
                margin:0 auto;
                padding:10px 0;
            }

            fieldset{
					  border:1px solid #e5dfcd;
            }

            form div{
		          margin:3px 0;
                padding:3px 0;
                min-height:18px;
            }

            form p{
		          font-size:80%;
                font-style:italic;
            }

            input,select, textarea{
		     		 background-color: #cacacb;
                border:1px solid #585559;
                border-radius:3px;
                -moz-border-radius:3px;
                -webkit-border-radius:3px;
                display:block;
                width:260px;
            }

            #form_example input,
            #form_example select,
            #form_example textarea{
                margin-left:210px;
            }

				 input[type=submit]:hover{
							background-color: #67c746;
							cursor:pointer;
            }

            input[type=submit]:active{
							background-color: #8f3ad0;
            }

            input[type=radio],input[type=checkbox]{
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
            }

            label.sublabel:hover{
						background-color: #f6f0e8;
            }

            input[type=hidden]{
						display:none;
				 }
            input:focus, select:focus, textarea:focus{
						background-color: #f4f0ed;
            }

            label{
					  	text-align:right;
              	   width:200px;
              	 	float:left;
                  font-weight:bold;
            }

            label span{
		            color: #ff38cb;
	 }

            .small{
						float:left;
						margin-left:10px !important;
               	 width:100px !important;
            }

            div.error{
						background-color: #63778c;
            }
            .errorbox{
					background-color: #a72121;
                font-size:80%;
                border:1px solid #791eff;
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

            #secondform{
                width:410px;
            }

				#secondform label{
				display:block;
				float:none;
				text-align:left;
							 }

            #secondform input[type=text], #secondform input[type=submit], #secondform select,  #secondform textarea, #secondform label.sublabel{
                display:block;
                margin-left:0;
                margin-top:5px;
            }

        </style>
		<br><br>
<?
		require(__DIR__.'/../../core/users/form/formgenerator.php');

		$_SESSION['userVer'] = (!isset($_SESSION['userVer']))? genpass(10, 2):$_SESSION['userVer'];
		$link='/core/users/page.php?user='.$_SESSION['userVer'];
		//------create first form


		$form=new Form();
		//setup form

		$form->set("title", "Страничка пользователя:  <strong style='font-size: 28px; margin: 0 0 0 20px;'><i>".$_SESSION['us_name']."</i></strong>");
		$form->set("name", "userForm");
		$form->set("action", $link);
		$form->set("linebreaks", false);
		$form->set("showDebug", true);
		$form->set("showErrors", true);
		$form->set("errorTitle", true);
		$form->set("divs", true);
		$form->set("html5",true);
		$form->set("placeholders",true);
		$form->set("errorPosition", "in_after");
		$form->set("submitMessage", "Изменения записаны.");
		$form->set("showAfterSuccess", true);
		$form->JSprotection("36CxgD");


		//simple data loading
		$loader=Array( "login"=>"test",
							"us_name"=>"John",
							"us_surname"=>"Alex",
							"phone"=>"777",
		               "skype"=>"",
						   "email"=>"john@doe.com",
		               "city"=>"Одесса",
							"mail_me"=>"Одесса" );

		$form->loadData($loader);

		//mapped data loading (To hide eg. DB field names)
		$loader=Array("dbmessage"=>"Sample message");
		$map=Array("dbmessage"=>"message");
		$form->loadData($loader, $map);

		//add input & misc fields
		$form->addText("Пожалуйста, если Вы планируете заказывать фотографии, указывайте свои точные данные.
		Ваши контактные данные будут использоваться только в пределах данного
		 сайта для правильной идентификации и доставки Вам фотографий.");

		$form->addItem("<h2>Контактные данные</h2>");
		$form->addField("text", "login","Логин", true);
		$form->addField("password", "pass1","Пароль", false);
		$form->addField("password", "pass2","Повторить пароль", false);
		$form->addField("text", "us_name","Имя", true);
		$form->addField("text", "us_surname","Фамилия", true);
		$form->addField("text", "phone","Телефон", true);
		$form->addField("text", "skype","Skype", false);
		$form->addField("text", "email","E-mail", true);
		$form->addField("text", "city","Город проживания", false);

		$form->addField("checkbox", "mail_me","Разрешить администрации", false, true, " посылать Вам уведомления?");


		$form->addField("checkbox", "checkbox","Удалить пользователя", false, false, " Внимание! Данные пользователя будут удалены из базы данных сайта.");
		$form->addField("checkbox", "terms","Заполненно верно", true, false, " проверьте внимательно");


		//assign validators to certain fields
		$form->validator("username", "textValidator", 2, 20);
		$form->validator("login", "textValidator", 2, 20);
		$form->validator("email", "regExpValidator", "/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/", "Not a valid e-mail address");
		$form->validator("terms", "termValidator");

		//display the form
		$form->display("Применить", "form1_submit");

		//save the valid data for further use
		$result=($form->getData());
		// it is advised to unset the form after saving the data
		unset($form);


//------use data from the first form
		if ($result){
		  echo "<p>Data from form1 (Example form):</p>";
		  foreach ($result as $name =>$item){
			 echo "<p>". $name . ": ". $item . "</p>";
		  }
		}




	 }else{
	//	print "<br>actual referral Seed:". $_SESSION['referralSeed'] ."<br />\n";
	//	print "<br>link invalid: ${_SERVER['REQUEST_URI']} \n";
		include (__DIR__.'/../../error_.php');
	 }
  }

?>
  <div class="end_content"></div>
  </div>
<?
  include (__DIR__.'/../../inc/footer.php');
?>