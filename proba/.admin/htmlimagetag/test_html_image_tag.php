<?php
/*
 * html_image_tag.php
 *
 * @(#) $Id: test_html_image_tag.php,v 1.2 2003/10/28 05:25:43 mlemos Exp $
 *
 */

	require('html_image_tag_class.php');

 	$image=new html_image_tag_class;

?>
<html>
<head>
<title>Test Manuel Lemos HTML Image Tag class</title>
</head>
<body>
<center><h1>Test Manuel Lemos HTML Image Tag class</h1></center>
<hr />

<center><p>Image from a file: <?php
	/*
	 *  The image is read from a locally accessible file
	 *  to determine the its width and height automatically.
	 */
	$image->SRC='http://www.phpclasses.org/graphics/logo.gif';
	$image->ALT='Image from a file';
	$image->TITLE='Image from file '.$image->SRC;
	$image->ALIGN='middle';
	$tag=$image->GetMarkup();
	if(strlen($tag))
		echo $tag;
	else
	{
?>
<b>Error: <?php echo HtmlEntities($image->error); ?>.</b>
<?php
		$image->error='';
	}
?>
</p></center>

<center><p>Image from a file embedded in the HTML: <?php
	/*
	 *  The image is read from a locally accessible file
	 *  to determine the its width and height automatically
	 *  and also to read its contents and embed in the
	 *  generated HTML tag.
	 */
	$image->SRC='http://www.phpclasses.org/graphics/elephpant_logo.gif';
	$image->ALT='Image from a file embedded in the HTML';
	$image->TITLE='Embedded image from file '.$image->SRC;
	$image->embedded=1;
	$tag=$image->GetMarkup();
	if(strlen($tag))
		echo $tag;
	else
	{
?>
<b>Error: <?php echo HtmlEntities($image->error); ?>.</b>
<?php
		$image->error='';
	}
?>
</p></center>

<?php

	/*
	 *  The image data is generated dynamically by this code
	 *  and is passed to the class to embed the image data
	 *  that is passed explicitly.
	 *
	 *  This example tries to generate an image with the
	 *  GD extension, if available. Otherwise, it supplies
	 *  pre-generated image data hardcoded in a string.
	 */

	if(function_exists($function='ImageGif'))
		$image->mime_type='image/gif';
	elseif(function_exists($function='ImagePNG'))
		$image->mime_type='image/png';
	if(function_exists($function='ImageJPEG'))
		$image->mime_type='image/jpeg';
	else
		$function='';
	if(strlen($function))
	{
		$example_text='Embedded';
		$font=1;
		$image->WIDTH=ImageFontWidth($font)*strlen($example_text)+4;
		$image->HEIGHT=ImageFontHeight($font)+4;
		$image_graphic=ImageCreate($image->WIDTH,$image->HEIGHT);
		$black=ImageColorAllocate($image_graphic,0,0,0);
		$yellow=ImageColorAllocate($image_graphic,255,255,0);
		ImageFilledRectangle($image_graphic,1,1,$image->WIDTH-2,$image->HEIGHT-2,$yellow);
		ImageRectangle($image_graphic,0,0,$image->WIDTH-1,$image->HEIGHT-1,$black);
		ImageString($image_graphic,$font,2,2,$example_text,$black);
		$previous_buffer=ob_get_clean();
		ob_start();
		@$function($image_graphic);
		$image->SRC=ob_get_clean();
		echo $previous_buffer;
	}
	else
	{
		$image->mime_type='image/jpeg';
		$image->SRC=base64_decode(
'/9j/4AAQSkZJRgABAQAAAQABAAD//gA+Q1JFQVRPUjogZ2QtanBlZyB2MS4wICh1c2luZyBJSkcg
SlBFRyB2NjIpLCBkZWZhdWx0IHF1YWxpdHkK/9sAQwAIBgYHBgUIBwcHCQkICgwUDQwLCwwZEhMP
FB0aHx4dGhwcICQuJyAiLCMcHCg3KSwwMTQ0NB8nOT04MjwuMzQy/9sAQwEJCQkMCwwYDQ0YMiEc
ITIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIy/8AAEQgA
DAAsAwEiAAIRAQMRAf/EAB8AAAEFAQEBAQEBAAAAAAAAAAABAgMEBQYHCAkKC//EALUQAAIBAwMC
BAMFBQQEAAABfQECAwAEEQUSITFBBhNRYQcicRQygZGhCCNCscEVUtHwJDNicoIJChYXGBkaJSYn
KCkqNDU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6g4SFhoeIiYqSk5SVlpeY
mZqio6Slpqeoqaqys7S1tre4ubrCw8TFxsfIycrS09TV1tfY2drh4uPk5ebn6Onq8fLz9PX29/j5
+v/EAB8BAAMBAQEBAQEBAQEAAAAAAAABAgMEBQYHCAkKC//EALURAAIBAgQEAwQHBQQEAAECdwAB
AgMRBAUhMQYSQVEHYXETIjKBCBRCkaGxwQkjM1LwFWJy0QoWJDThJfEXGBkaJicoKSo1Njc4OTpD
REVGR0hJSlNUVVZXWFlaY2RlZmdoaWpzdHV2d3h5eoKDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ip
qrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uLj5OXm5+jp6vLz9PX29/j5+v/aAAwDAQACEQMR
AD8ATwtaacdFe9v/AAxo0mk6VpkM0839lRPLOws4pmHmGUHeTITzHggfeyeNKW/8GJrSWo8Gaf8A
Z4bO4ub7OnW++3WKRELnnBVWE6sF3MTHlQVILeTWXxOu7K2t4/8AhGvDM8sFstr9pnsC0skaxiPD
Nv5yg2ntjjpxV+5+Mmq3t/Df3XhzwzPeQbfKuJbFmkj2nI2sXyMEkjHevz+tRm6rbfdbtf8AD663
/A6k9D1tT4DkudRhi8JWUgspRB5qaXEY5pjIIvKVsYV/MKrh9vDBvufNWPBqHhS406wki8I6G1ze
agkHFnbmOOF7x4UJO752ZI5CPLLjKEnC4z54/wAZNVkurm6fw54Za5uojDcTNYsXmjIAKOd+WXAA
weOBTz8a9aYoToPhwlGZ1Js3+VmcSEj95wS6q5PdgD1FYxw84rdvb7T7arbq9en3aFXR6jBd+ALr
TJL+DwjZPD5uyBm02BEuV2NIXSRsR7QiSFtzKV2EMA2AfHPidHafb/D11a6fZWP23Q7a6lhs4RFH
5jlySAPwHOTgCr8Xxk1WCS4kh8OeGY5LmVZp2SxYGWRW3K7EP8zBvmBPIPNcp4p8U3fiy/trq6tL
K1+zWy2sUNnGUjWNSxAAJOPvEccYAr1cmoyhi73dtd230/r+tFnUd4n/2Q==');
		$image->WIDTH=44;
		$image->HEIGHT=12;
	}
?>
<center><p>Image from a dynamically generated graphic embedded in the HTML: <?php
	$image->ALT='Image from a dynamically generated graphic embedded in the HTML';
	$image->TITLE='Dynamically generated embedded image';
	$image->embedded=1;
	$image->from_data=1;
	$tag=$image->GetMarkup();
	if(strlen($tag))
		echo $tag;
	else
	{
?>
<b>Error: <?php echo HtmlEntities($image->error); ?>.</b>
<?php
		$image->error='';
	}
?>
</p></center>

<center><p><b>Leave the mouse pointer over an image.</b></p></center>

<hr />
<address>Manuel Lemos (<a href="mailto:mlemos@acm.org">mlemos@acm.org</a>)</address>
</body>
</html>
