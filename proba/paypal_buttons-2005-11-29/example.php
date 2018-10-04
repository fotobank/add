<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Paypal Buttons Example</title>
</head>

<body>

<p><strong><a href="http://www.jc21.com/portfolio/">Get the latest version</a></strong></p>

<?php

		require_once('paypal.inc.php');													//require the class include file


/*
		$button = new PayPalButton;														//initiate the class instance
		$button->accountemail = 'jason@almost-anything.com.au';							//the account that is registered with paypal where money will be sent to
		$button->custom = 'my custom passthrough variable'; 							//a custom string that gets passed through paypals pages, back to your IPN page and Return URL as $_POST['custom'] . useful for database id's or invoice numbers. WARNING: does have a max string limit, don't go over 150 chars to be safe
		$button->currencycode = 'AUD';													//currency code
		$button->target = '_blank';														//Frame Name, usually '_blank','_self','_top' . Comment out to use current frame.
		$button->class = 'paypalbutton';												//CSS class to apply to the button. Comes in very handy
		$button->width = '150';															//button width in pixels. Will apply am Inline CSS Style to the button. Comment if not needed.
		$button->image = 'http://www.jc21.com.au/paypal/logo.jpg';						//image 150px x 50px that can be displayed on your paypal pages.
		//$button->buttonimage = '/paypal/purchase.jpg';								//img to use for this button
		$button->buttontext = 'I agree, proceed to Payment';							//text to use if image not found or not specified
		$button->askforaddress = false;													//wether to ask for mailing address or not
		$button->return_url = 'http://www.almost-anything.com.au/index.php';			//url of the page users are sent to after successful payment
		$button->ipn_url = 'http://www.almost-anything.com.au/index.php';				//url of the IPN page (this overrides account settings, IF IPN has been setup at all.
		$button->cancel_url = 'http://www.almost-anything.com.au/index.php'; 			//url of the page users are sent to if they cancel through the paypal process

		//------------------------------------
		// BEFORE YOU CONTINUE - Please decide if you want to use this for a one-off purchase (ITEMS) or SUBSCRIPTIONS. Do not specify both.
		//------------------------------------

		//ITEMS
		//Paypal buttons are different when you're selling 1 item and anything more than 1 item. My class takes care of this for you.
		//Syntax: $button->AddItem(item_name, quantity, price, item_code, shipping, shipping2, handling, tax, field1_name, field1_options, field2_name, field2_options);
		//Here are a few examples:
		//               name        qty  price    code    shiip  ship2  hand   tax    f1n      f1_options               f2n    f2_options
		$button->AddItem('Item Name','1','100.00','wsc001','2.00','1.00','5.00','0.00','Colour','Red with White stripes','Size','One size fits all :)');							
		$button->AddItem('Item Name','1','100.00','wsc001');							//1 quantity, no shipping, no handling, default tax.
		$button->AddItem('Item Name','1','100.00','wsc001','','','','0.00');			//1 quantity, no shipping, no handling, NO TAX
		$button->AddItem('Item Name','3','100.00','wsc001','10.00');					//3 quantities, $10.00 shipping, no handling, default tax.
		//END ITEMS
		
		//SUBSCRIPTIONS
		//Paypal subscriptions are not a one-off purchase. The amount is billed to the customer at the specified interval.
		//You should only specify ONE (1) subscription. If others are specified aswell, they will be ignored. Examples:
		//					     name        price   code     int period
		//$button->AddSubscription('Item Name','10.00','SUB100',56,'D');				//each 56 days
		//$button->AddSubscription('Item Name','10.00','SUB100',1,'M');					//each month
		//$button->AddSubscription('Item Name','10.00','SUB100',1,'Y');					//each year
		//END SUBSCRIPTIONS
		
		$button->OutputButton();														//output the button!
*/		
?>

<h2>Example of One-Off Purchase Buttons</h2>

<p>A Single Item Purchase:</p>
<?php
		$button1 = new PayPalButton;													//initiate the class instance
		$button1->accountemail = 'jason@almost-anything.com.au';						//the account that is registered with paypal where money will be sent to
		$button1->custom = 'my custom passthrough variable'; 							//a custom string that gets passed through paypals pages, back to your IPN page and Return URL as $_POST['custom'] . useful for database id's or invoice numbers. WARNING: does have a max string limit, don't go over 150 chars to be safe
		$button1->currencycode = 'AUD';													//currency code
		$button1->class = 'paypalbutton';												//CSS class to apply to the button. Comes in very handy
		$button1->width = '150';														//button width in pixels. Will apply am Inline CSS Style to the button. Comment if not needed.
		$button1->image = 'http://www.jc21.com/paypal/logo.jpg';						//image 150px x 50px that can be displayed on your paypal pages.
		$button1->buttonimage = 'http://www.jc21.com/paypal/buy.jpg';					//img to use for this button
		$button1->buttontext = 'I agree, proceed to Payment';							//text to use if image not found or not specified
		$button1->askforaddress = false;												//wether to ask for mailing address or not
		$button1->return_url = 'http://www.jc21.com/';									//url of the page users are sent to after successful payment
		$button1->ipn_url = 'http://www.jc21.com/';										//url of the IPN page (this overrides account settings, IF IPN has been setup at all.
		$button1->cancel_url = 'http://www.jc21.com/'; 									//url of the page users are sent to if they cancel through the paypal process

		//ITEMS
		//Paypal buttons are different when you're selling 1 item and anything more than 1 item. My class takes care of this for you.
		//Syntax: $button->AddItem(item_name, quantity, price, item_code, shipping, shipping2, handling, tax, field1_name, field1_options, field2_name, field2_options);
		//Here are a few examples:
		//               name        qty  price    code    shiip  ship2  hand   tax    f1n      f1_options               f2n    f2_options
		$button1->AddItem('Item Name','1','100.00','wsc001','2.00','1.00','5.00','0.00','Colour','Red with White stripes','Size','One size fits all :)');							
		//END ITEMS
		
		$button1->OutputButton();														//output the button!
?>


<p>A Multiple Item Purchase (shopping cart):</p>
<?php
		$button2 = new PayPalButton;													//initiate the class instance
		$button2->accountemail = 'jason@almost-anything.com.au';						//the account that is registered with paypal where money will be sent to
		$button2->custom = 'my custom passthrough variable'; 							//a custom string that gets passed through paypals pages, back to your IPN page and Return URL as $_POST['custom'] . useful for database id's or invoice numbers. WARNING: does have a max string limit, don't go over 150 chars to be safe
		$button2->currencycode = 'AUD';													//currency code
		$button2->class = 'paypalbutton';												//CSS class to apply to the button. Comes in very handy
		$button2->width = '150';														//button width in pixels. Will apply am Inline CSS Style to the button. Comment if not needed.
		$button2->image = 'http://www.jc21.com/paypal/logo.jpg';						//image 150px x 50px that can be displayed on your paypal pages.
		$button2->buttonimage = 'http://www.jc21.com/paypal/buy.jpg';					//img to use for this button
		$button2->buttontext = 'I agree, proceed to Payment';							//text to use if image not found or not specified
		$button2->askforaddress = false;												//wether to ask for mailing address or not
		$button2->return_url = 'http://www.jc21.com/';									//url of the page users are sent to after successful payment
		$button2->ipn_url = 'http://www.jc21.com/';										//url of the IPN page (this overrides account settings, IF IPN has been setup at all.
		$button2->cancel_url = 'http://www.jc21.com/'; 									//url of the page users are sent to if they cancel through the paypal process

		//ITEMS
		//Paypal buttons are different when you're selling 1 item and anything more than 1 item. My class takes care of this for you.
		//Syntax: $button->AddItem(item_name, quantity, price, item_code, shipping, shipping2, handling, tax, field1_name, field1_options, field2_name, field2_options);
		//Here are a few examples:
		//               name        qty  price    code    shiip  ship2  hand   tax    f1n      f1_options               f2n    f2_options
		$button2->AddItem('Item Name1','1','100.00','wsc001','2.00','1.00','5.00','0.00','Colour','Red with White stripes','Size','One size fits all :)');							
		$button2->AddItem('Item Name2','1','10.00','wsc002');							//1 quantity, no shipping, no handling, default tax.
		$button2->AddItem('Item Name3','1','120.00','wsc003','','','','0.00');			//1 quantity, no shipping, no handling, NO TAX
		$button2->AddItem('Item Name4','3','110.00','wsc004','10.00');					//3 quantities, $10.00 shipping, no handling, default tax.
		//END ITEMS
				
		$button2->OutputButton();														//output the button!
?>

<p>A Multiple Item Purchase (shopping cart) with no styling:</p>
<?php
		$button3 = new PayPalButton;													//initiate the class instance
		$button3->accountemail = 'jason@almost-anything.com.au';						//the account that is registered with paypal where money will be sent to
		$button3->custom = 'my custom passthrough variable'; 							//a custom string that gets passed through paypals pages, back to your IPN page and Return URL as $_POST['custom'] . useful for database id's or invoice numbers. WARNING: does have a max string limit, don't go over 150 chars to be safe
		$button3->currencycode = 'AUD';													//currency code
		$button3->image = 'http://www.jc21.com/paypal/logo.jpg';						//image 150px x 50px that can be displayed on your paypal pages.
		$button3->buttontext = 'I agree, proceed to Payment';							//text to use if image not found or not specified
		$button3->askforaddress = false;												//wether to ask for mailing address or not
		$button3->return_url = 'http://www.jc21.com/';									//url of the page users are sent to after successful payment
		$button3->ipn_url = 'http://www.jc21.com/';										//url of the IPN page (this overrides account settings, IF IPN has been setup at all.
		$button3->cancel_url = 'http://www.jc21.com/'; 									//url of the page users are sent to if they cancel through the paypal process

		//ITEMS
		//Paypal buttons are different when you're selling 1 item and anything more than 1 item. My class takes care of this for you.
		//Syntax: $button->AddItem(item_name, quantity, price, item_code, shipping, shipping2, handling, tax, field1_name, field1_options, field2_name, field2_options);
		//Here are a few examples:
		//               name        qty  price    code    shiip  ship2  hand   tax    f1n      f1_options               f2n    f2_options
		$button3->AddItem('Item Name1','1','100.00','wsc001','2.00','1.00','5.00','0.00','Colour','Red with White stripes','Size','One size fits all :)');							
		$button3->AddItem('Item Name2','1','10.00','wsc002');							//1 quantity, no shipping, no handling, default tax.
		$button3->AddItem('Item Name3','1','120.00','wsc003','','','','0.00');			//1 quantity, no shipping, no handling, NO TAX
		$button3->AddItem('Item Name4','3','110.00','wsc004','10.00');					//3 quantities, $10.00 shipping, no handling, default tax.
		//END ITEMS
				
		$button3->OutputButton();														//output the button!
?>

<hr />
<h2>Example of Subscription Buttons</h2>

<p>Transactions are made every 56 days:</p>
<?php
		$button4 = new PayPalButton;													//initiate the class instance
		$button4->accountemail = 'jason@almost-anything.com.au';						//the account that is registered with paypal where money will be sent to
		$button4->custom = 'my custom passthrough variable'; 							//a custom string that gets passed through paypals pages, back to your IPN page and Return URL as $_POST['custom'] . useful for database id's or invoice numbers. WARNING: does have a max string limit, don't go over 150 chars to be safe
		$button4->currencycode = 'AUD';													//currency code
		$button4->class = 'paypalbutton';												//CSS class to apply to the button. Comes in very handy
		$button4->image = 'http://www.jc21.com.au/paypal/logo.jpg';						//image 150px x 50px that can be displayed on your paypal pages.
		$button4->buttonimage = 'http://www.jc21.com/paypal/subscribe.jpg';				//img to use for this button
		$button4->buttontext = 'I agree, proceed to Payment';							//text to use if image not found or not specified
		$button4->askforaddress = false;												//wether to ask for mailing address or not
		$button4->return_url = 'http://www.almost-anything.com.au/index.php';			//url of the page users are sent to after successful payment
		$button4->ipn_url = 'http://www.almost-anything.com.au/index.php';				//url of the IPN page (this overrides account settings, IF IPN has been setup at all.
		$button4->cancel_url = 'http://www.almost-anything.com.au/index.php'; 			//url of the page users are sent to if they cancel through the paypal process

		//SUBSCRIPTIONS
		//Paypal subscriptions are not a one-off purchase. The amount is billed to the customer at the specified interval.
		//You should only specify ONE (1) subscription. If others are specified aswell, they will be ignored. Examples:
		//					     name        price   code     int period
		$button4->AddSubscription('My Subscription','10.00','SUB100',56,'D');			//each 56 days
		//END SUBSCRIPTIONS
				
		$button4->OutputButton();														//output the button!
?>


<p>Transactions are made every month: (no styling)</p>
<?php
		$button4 = new PayPalButton;													//initiate the class instance
		$button4->accountemail = 'jason@almost-anything.com.au';						//the account that is registered with paypal where money will be sent to
		$button4->custom = 'my custom passthrough variable'; 							//a custom string that gets passed through paypals pages, back to your IPN page and Return URL as $_POST['custom'] . useful for database id's or invoice numbers. WARNING: does have a max string limit, don't go over 150 chars to be safe
		$button4->currencycode = 'AUD';													//currency code
		$button4->image = 'http://www.jc21.com.au/paypal/logo.jpg';						//image 150px x 50px that can be displayed on your paypal pages.
		$button4->buttontext = 'I agree, proceed to Payment';							//text to use if image not found or not specified
		$button4->askforaddress = false;												//wether to ask for mailing address or not
		$button4->return_url = 'http://www.almost-anything.com.au/index.php';			//url of the page users are sent to after successful payment
		$button4->ipn_url = 'http://www.almost-anything.com.au/index.php';				//url of the IPN page (this overrides account settings, IF IPN has been setup at all.
		$button4->cancel_url = 'http://www.almost-anything.com.au/index.php'; 			//url of the page users are sent to if they cancel through the paypal process

		//SUBSCRIPTIONS
		//Paypal subscriptions are not a one-off purchase. The amount is billed to the customer at the specified interval.
		//You should only specify ONE (1) subscription. If others are specified aswell, they will be ignored. Examples:
		//					     name        price   code     int period
		$button4->AddSubscription('My Subscription','10.00','SUB100',1,'M');			//each 56 days
		//END SUBSCRIPTIONS
				
		$button4->OutputButton();														//output the button!
?>




<hr />
<h2>Example of Cancel Subscription Links</h2>

<?php

		$cancellink = new PayPalButton;														//initiate the class instance
		$cancellink->accountemail = 'jason@almost-anything.com.au';							//the account that is registered with paypal where money will be sent to
		$cancellink->class = 'paypalbutton';												//CSS class to apply to the button. Comes in very handy
		$cancellink->width = '150';															//button width in pixels. Will apply am Inline CSS Style to the button. Comment if not needed.
		$cancellink->buttonimage = 'http://www.jc21.com/paypal/unsubscribe.jpg';			//img to use for this button
		$cancellink->buttontext = 'Cancel Subscription';									//text to use if image not found or not specified
		$cancellink->OutputSubscriptionCancel();											//output the button!
		
?>

<p>With no styling:</p>

<?php

		$cancellink = new PayPalButton;														//initiate the class instance
		$cancellink->accountemail = 'jason@almost-anything.com.au';							//the account that is registered with paypal where money will be sent to
		$cancellink->buttontext = 'Cancel Subscription';									//text to use if image not found or not specified
		$cancellink->OutputSubscriptionCancel();											//output the button!
		
?>

</body>
</html>
