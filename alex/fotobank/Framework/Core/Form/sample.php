<?php
       ini_set('display_errors', 1);
       error_reporting(E_ALL | E_STRICT);
       /** -----------------------------------------------------------------------------------*/
       header('Content-type: text/html; charset=windows-1251');

       //------include class
       require __DIR__.'/Formgenerator/Formgenerator.php';
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251"/>
	<title>Another Form generator example</title>
	<style>
		body {
			background-color: #000;
			color: #bbb;
			font-family: Georgia, "times New Roman", serif;
			font-size: 90%;
			padding-bottom: 30px;
		}

		h1 {
			font-weight: bold;
			font-style: italic;
			font-size: 150%;
			color: #933;
		}

		h1 + h2 {
			font-weight: bold;
			font-style: italic;
			font-size: 90%;
			border-bottom: 1px solid #933;
			padding-bottom: 10px;
			margin-bottom: 20px;
		}

		form {
			width: 550px;
			background-color: #111;
			margin: 0 auto;
			padding: 10px 0;
		}

		fieldset {
			border: 1px solid white;
		}

		form div {
			margin: 3px 0;
			padding: 3px 0;
			min-height: 18px;
		}

		form p {
			font-size: 80%;
			font-style: italic;
		}

		input, select, textarea {
			background-color: #777;
			border: 1px solid white;
			border-radius: 3px;
			-moz-border-radius: 3px;
			-webkit-border-radius: 3px;
			display: block;
			width: 260px;
		}

		#form_example input,
		#form_example select,
		#form_example textarea {
			margin-left: 210px;
		}

		input[type=submit]:hover {
			background-color: #aaa;
			cursor: pointer;
		}

		input[type=submit]:active {
			background-color: #fff;
		}

		input[type=radio], input[type=checkbox] {
			display: inline;
			margin: 4px;
			margin-left: 0 !important;
			width: auto;
		}

		label.sublabel {
			float: none;
			text-align: left;;
			margin-left: 210px;
			display: block;
			font-weight: normal;
		}

		label.sublabel:hover {
			background-color: #555;
		}

		input[type=hidden] {
			display: none;
		}

		input:focus, select:focus, textarea:focus {
			background-color: #ddd;
		}

		label {
			text-align: right;
			width: 200px;
			float: left;
			font-weight: bold;
		}

		label span {
			color: red;
		}

		.small {
			float: left;
			margin-left: 10px !important;
			width: 100px !important;
		}

		div.error {
			background-color: #411;
		}

		.errorbox {
			background-color: #411;
			font-size: 80%;
			border: 1px solid #fff;
			line-height: 140%;
		}

		.errorbox ul {
			padding-left: 20px;
		}

		.errorbox h4 {
			margin: 5px;
		}

		.errorbox label {
			float: none;
			cursor: pointer;
		}

		.errorbox label:hover {
			text-decoration: underline;
		}

		#secondform {
			width: 310px;
		}

		#secondform label {
			display: block;
			float: none;
			text-align: left;
		}

		#secondform input[type=text], #secondform input[type=submit], #secondform select, #secondform textarea, #secondform label.sublabel {
			display: block;
			margin-left: 0;
			margin-top: 5px;
		}


	</style>
</head>
<body>
<h1>Another Form generator example page</h1>
<h2>Пример &bdquo;Form&rdquo; генератора</h2>
<?php

       //------create first form
       $form = new \Framework\Core\Form\Generator();
       //setup form
       $form->set('title', 'Example form');
       $form->set('name', 'form_example');
       $form->set('action', 'sample.php');
       $form->set('linebreaks', false);
       $form->set('showDebug', true);
       $form->set('divs', true);
       $form->set('html5', true);
       $form->set('placeholders', true);
       $form->set('errorPosition', 'in_before');
       $form->set('submitMessage', 'Form submitted!');
       $form->set('showAfterSuccess', true);
       $form->JSprotection('36CxgD');
       //sample optionlist form radiobuttons and selects
       $optionlist = Array('First value' => 'first', 'Second value' => 'second', 'Third value' => 'third');
       //simple data loading
       $loader = Array('username' => 'John Doe', 'email' => 'john@doe.com');
       $form->loadData($loader);
       //отображенных загрузки данных (например, чтобы скрыть. имена поля БД)
       $loader = Array('dbmessage' => 'Sample message');
       $map    = Array('dbmessage' => 'message');
       $form->loadData($loader, $map);
       //add input & misc fields
       $form->addText('Fields marked with * must be filled.');
       $form->addItem('<h2>H2 Пример!</h2>');
       $form->addField('text', 'username', 'Name', true);
       $form->addField('text', 'email', 'E-mail', true);
       $form->addField('text', 'date', 'Date', true);
       $form->addField('date', 'inp1', 'Date', false);
       $form->addField('number', 'inp2', 'Number', false);
       $form->addField('email', 'inp3', 'Email', false);
       $form->addField('range', 'inp4', 'Range', false);
       $form->addField('url', 'inp5', 'URL', false);
       $form->addField('tel', 'inp6', 'Phone', false);
       $form->addField('text', 'sub1', 'Joined', false, false, "class='small'");
       $form->addField('text', 'sub2', false, false, false, "class='small'");
       $form->addField('checkbox', 'terms', 'Accept terms', true, false, 'I accept the terms.');
       $form->addField('checkbox', 'checkbox', 'Initially checked', false, true, 'waddawadda.');
       $form->addField('radio', 'radiobuttons', 'Choose one', true, false, $optionlist);
       $form->addField('select', 'selector', 'Choose', false, 'third', $optionlist);
       $form->addField('file', 'file', 'File', true);
       $form->addField('checkbox', 'checklist', 'Choose some', false, 'second, first', $optionlist);
       $form->addField('textarea', 'message', 'Message', true, false, "cols='40' rows='7'");
       $form->button('reset', 'resetter', 'Reset form');
       //assign validators to certain fields
       $form->validator('username', 'textValidator', 2, 20);
       $form->validator('email', 'regExpValidator', "/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/", 'Not a valid e-mail address');
       $form->validator('terms', 'termValidator');
       $form->join('sub1', 'sub2');
       //display the form
       $form->display('Submit', 'form1_submit');
       //save the valid data for further use      
       $result = $form->getData();
       // it is advised to unset the form after saving the data
       unset($form);
       //------create second form
       $form2 = new Generator();
       $form2->set('showDebug', true);
       $form2->set('title', 'Second example form');
       $form2->set('name', 'secondform');
       $form2->set('action', 'sample.php');
       $form2->set('linebreaks', false);
       $form2->set('divs', true);
       $form2->set('errorPosition', 'in_after');
       $form2->set('errorTitle', 'Arrrggghhh!!!');
       $form2->set('errorLabel', '<i><sup>DUH!</sup></i> ');
       $form2->set('showAfterSuccess', false);
       $form2->JSprotection('36CxsaegD', 'prtcode2');
       //sample errors for debugging
       echo '<p>Some debug messages: </p>';
       $form2->set('naasdfsme', 'xyzsfkjl');
       $form2->set('errorPosition', 'somewhere');
       $form2->validator('username2', 'textasdValidator', 2, 20);
       $form2->addText('Wazzup!');
       $optionlist = Array('First value' => 'first', 'Second value' => 'second');
       $form2->addItem('<fieldset><legend>fieldset</legend>');
       $form2->addField('text', 'username2', 'Name', true, 'test', "maxlength='10'");
       $form2->addField('text', 'email2', 'E-mail', true);
       $form2->addItem('</fieldset>');
       $form2->addField('hidden', 'hiddy', 'Hidden', false);
       $form2->addField('password', 'pass', 'Password', true);
       $form2->addField('file', 'file2', 'File', true);
       $form2->addField('checkbox', 'checkbox2', 'Accept terms', true, 'I accept the terms.');
       $form2->validator('username2', 'textValidator', 2, 20);
       $form2->validator('email2', 'regExpValidator', "/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/", 'Не доступен e-mail');
       $form2->validator('checkbox2', 'termValidator');
       $form2->button('submit', 'submit2', 'Hit me!');
       $form2->button('reset', 'resetter2', 'Reset');
       $form2->display();
       $result2 = $form2->getData();
       unset($form2);
       //------use data from the first form
       if (is_array($result)) {
              echo '<p>Data from form1 (Example form):</p>';
              foreach ($result as $name => $item) {
                     echo '<p>'.$name.': '.$item.'</p>';
              }
       }
?>
<hr/>
</body>
</html>
