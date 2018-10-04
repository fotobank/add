<?php

error_reporting(0);
require_once('blitz.class.php');
require_once('stopwords.php');

$targetUrl = "http://possible.in";
//$targetUrl = "test.html";

$data = file_get_contents( $targetUrl );

$startTime = microtime(true);

$blitz = new Blitz();

$blitz->LoadHTML($data);

$result =  $blitz->Analyze();

$endTime = microtime(true);
$totalTime = (float)$endTime - (float)$startTime;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $blitz->encoding; ?>">
<title>Blitz HTML Parser and Analyzer</title>
<style>
body{font-family:arial;}
#container{ magin:0 auto; width:98%; }
li{ padding:5px 0; border-bottom:1px dotted #ddd;}
i{ color:#666; }
.block{ padding:10px; border:1px dotted #ddd;margin:5px; }
.w48{ width:46%;}
.fleft{float:left; }
.clear{clear:both;}
</style>
</head>
<body>
<div id="container">
	<div id="doctype" class="block">
		<b>Doctype:</b> <?php echo $result['doctype']['name']; ?><br/>
		<b>Doctype PublicId:</b> <?php echo $result['doctype']['publicId']; ?><br/>
		<b>Doctype SystemId:</b> <?php echo $result['doctype']['systemId']; ?><br/>
	</div>
	<div id="encoding" class="block">
		<b>Encoding:</b> <?php echo $result['encoding']; ?><br/>
	</div>
	<div id="meta" class="block">
		<b>Meta tags:</b> <br/>
			<ul>
			<?php foreach( $result['meta'] as $key => $meta ) { 
				echo '<li><i>name: ',$meta['name'],'</i><br />';
				echo 'content: ',$meta['content'],'<br />';
				if( $meta['http-equiv'] != '') echo 'http-equiv: ',$meta['http-equiv'],'<br />';
				echo '</li>';
			}
			?>
			</ul>
	</div>
	<div id="title" class="block">
		<b>Page Title:</b><?php echo $result['title']; ?><br/>
	</div>
	<div id="text" class="block">
		<b>Text content:</b><br/>  <?php echo $result['text']; ?><br/>
	</div>
	<div id="links" class="block">
		<b>Links:</b><br />
		<ul>
		<?php 
			foreach( $result['links'] as $link ){
				echo '<li><i>',$link['href'],'</i><br />';
				if( $link['text'] != '' )echo 'text: ',$link['text'],'<br />';
				if( $link['title'] != '' ) echo 'title: ',$link['title'],'<br />';
				echo '</li>';
			}
		?>
		</ul>
		<br/>
	</div>
	<div id="images" class="block">
		<b>Images:</b><br />
		<ul>
		<?php 
			foreach( $result['images'] as $img ){
				echo '<li><i>src: ',$img['src'],'</i><br />';
				if( $img['alt'] != '' ) echo 'alt: ',$img['alt'],'<br />';
				echo '</li>';
			}
		?>
		</ul>
		<br/>
	</div>
	<div id="density" class="block fleft w48">
		<b>Density:</b>(<?php echo  count($result['words']['density']); ?>)<br />
		<ul>
		<?php 
			foreach( $result['words']['density'] as $w ){
				echo sprintf( '%02s', $w['count']),'<i> ',$w['word'],'</i><br />';
				echo '</li>';
			}
		?>
		</ul>
		<br/>
	</div>
	<div id="weights" class="block fleft w48">
		<b>Word Weights:</b>(<?php echo  count($result['words']['weights']); ?>)<br />
		<ul>
		<?php 
			foreach( $result['words']['weights'] as $w ){
				echo sprintf( '%02s', $w['weight']),'<i> ',$w['word'],'</i><br />';
				echo '</li>';
			}
		?>
		</ul>
		<br/>
	</div>
	<div id="processingtime" class="block clear" style="border:1px solid red;">
		<br/><b>Processing time: </b><?php echo $totalTime; ?> seconds<br />
		
		<br/>
	</div>
</div>
</body>
</html>