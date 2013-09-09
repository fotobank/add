<?php
//CLASS phpSEO example usage
$start_time=microtime(true);
require_once("phpSEO.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="icon" href="http://neo22s.com/favicon.ico" type="image/x-icon" />
<title>phpSEO v0.1 by Neo22s.com </title>
</head>

<body>
<?php 
if ($_POST) $text=$_POST["text"];
else $text="<b>Lorem ipsum</b> dolor sit amet, <pre>consectetur adipiscing elit</pre>. <div id='asd'>In sit amet mauris quis dui dapibus fermentum.</div> Morbi dapibus, mauris a dignissim convallis, magna felis accumsan nisi, in aliquam eros purus vitae libero. Aliquam non vehicula libero. Suspendisse potenti. In luctus tristique elit nec malesuada. Sed id purus mauris, vitae commodo nibh. Nullam id volutpat quam. Morbi et neque erat, ut dictum sem. Duis a augue non libero faucibus dapibus tincidunt iaculis quam. Duis eget lorem nisl, id bibendum erat. Vestibulum elit enim, egestas id euismod eu, elementum ut velit. Curabitur laoreet auctor lorem et tempor.
Donec cursus tellus neque, id ultricies augue. In ipsum dolor, interdum quis laoreet sit amet, vulputate eu ante. Praesent a mauris mi. In tristique, neque et aliquam posuere, ipsum augue bibendum metus, dignissim dapibus neque sem in elit. In hac habitasse platea dictumst. Donec rhoncus sapien eget libero accumsan scelerisque. Vestibulum et nisl augue. Cras et turpis eros, non tincidunt metus. Donec commodo eros ut est mollis suscipit. Sed consectetur elit eu ante scelerisque consequat.
Phasellus sed nisi leo, at rhoncus leo. Integer ultrices, eros fringilla molestie aliquam, felis dolor facilisis magna, in mollis libero magna ut nulla. Cras a nibh ac arcu ultricies placerat. Donec molestie velit quis purus pretium at laoreet libero sollicitudin. Mauris pulvinar justo in sapien facilisis rhoncus. Suspendisse porttitor semper malesuada. Aenean ac elementum risus. Fusce vitae mi dui. Pellentesque mollis viverra pulvinar. Sed faucibus consectetur augue quis pulvinar. Ut pellentesque malesuada ante vel dignissim.
Sed venenatis erat sapien, quis cursus sem. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam sed dolor nunc. Etiam molestie ultrices iaculis. Proin mi tortor, eleifend non semper sit amet, volutpat in mi. Vestibulum scelerisque condimentum metus, ut interdum urna dapibus dignissim. Donec lorem leo, commodo non iaculis et, tincidunt a magna. Duis sit amet dui et nulla blandit scelerisque quis vitae arcu. Suspendisse vitae ligula libero, non accumsan turpis. Aenean sit amet hendrerit augue. Pellentesque commodo, tortor nec tincidunt convallis, risus velit scelerisque neque, ac fermentum magna lectus et quam. Nunc nisi ante, viverra et commodo ut, sagittis in mi. Nunc et vehicula eros. Praesent sapien odio, scelerisque id accumsan ut, imperdiet vitae felis.
Sed urna ante, sodales rutrum commodo in, egestas vel metus. Fusce tincidunt, sapien nec posuere mollis, purus justo tincidunt purus, nec sagittis mauris nulla vel felis. Proin et odio tortor, nec consectetur est. Vivamus sed porttitor velit. Mauris imperdiet mattis mi, tincidunt cursus enim dictum et. Proin tincidunt ligula vitae tellus sagittis in condimentum nunc mattis. In hac habitasse platea dictumst. Duis vulputate quam eget nisi dapibus pharetra. Maecenas eget cursus mi. Etiam aliquet sagittis felis, eget aliquet ligula posuere id. ";
?>

<b>Paste text here:</b><br />
<form action="" method="post">
<textarea rows="30" cols="100" name="text" onclick="this.select();"><?php echo $text?></textarea><br />
<input type="submit" value="Get keywords and description!" />
</form>

<?php 
//SEO CLASS EXAMPLE
	
	
	//Advanced usage
	/*$seo = new phpSEO();
	$seo->setText(file_get_contents("http://neo22s.com"));
	echo $seo->getText();
	echo "<br/><br/><br/>";
	$seo->setDescriptionLen(10);
	echo $seo->getMetaDescription();
	echo "<br/><br/><br/>";
	$seo->setBannedWords("sed,non,libero");
	$seo->setMaxKeywords(10);
	$seo->setMinWordLen(5);
	echo $seo->getKeyWords();*/


	//Simple usage:
	$seo = new phpSEO($text);
	$keywords = $seo->getKeyWords(12);
	$desc = $seo->getMetaDescription(150);
	echo '<br /><b>KeyWords:</b> '.$keywords;
	echo '<br /><b>Description:</b> '.$desc;
	echo '<br /><b>Executed in '.round((microtime(true)-$start_time),3).'s</b>';
?>

<br/><br/><br/><br/>
<a href="http://neo22s.com/phpseo/">phpSEO</a> by <a href="http://neo22s.com/">neo22s.com</a>

</body>
</html>
