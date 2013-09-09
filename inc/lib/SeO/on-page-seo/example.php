<?php

// include class
require_once "seo.class.php";
// create object
$seo = new seo ("www.somesite.com");


// set vars
// $vars[var_name] = var value
// var names a-zA-Z0-9_  eg. asdf or asd_f9
// var values can be plain text or html
$vars = array();
$vars['id'] = 32;
$vars['cat'] = "Chrome Web Apps";
$vars['title'] = "How To Create Your Own Chrome Web Apps";
$vars['date'] = "21 dec 2012"; // :-)
$vars['author'] = "Radovan Janjic";
$vars['desc'] = "<!-- some comment -->ćčjklč<em>\"Google\"</em> recently launched the <b>Chrome Web Store</b> and I was excited to see a lot of really cool web apps being added to the Web Store everyday. Most of the Web Apps listed are just regular websites packaged to be installable on your Chrome browser, and these apps and extensions can then be synched across computers, so that you always get the same personalized experience in your browser, no matter which computer you use.
We have created some Google Chrome Themes and I wanted to see how to create a Web App. After reading the <strong>Chrome Web Apps</strong> Documentation for a while, I found that the process of making a web app from any existing website is quite easy. As an example, I created a Web App for Mind42.com which is my favorite site for creating Mind Maps.
Using the process described below you can create your own Chrome Web Apps. Lets see how it's done."; 

// add vars
$seo->addVars($vars);


/* examples

	// page stuf
	$page['title'] 		 = $seo->getPageTitle("[title] | example.com");
	$page['description'] = $seo->getDescription("[date] - [title] - [author] - [desc]");
	$page['canonical'] 	 = $seo->getCanonical();
	
	// link
	$link['href']		 = $seo->getHref("/[cat]/[id]-[title].html");
	$link['title']		 = $seo->getTitle("[title]");
	
	// img
	$img['src']			 = $seo->getHref("/images/[img_id]-[title].jpg");
	$img['alt']			 = $seo->getAlt("[title]");
	$img['title']		 = $seo->getTitle("[title]");
	
	
	// db example /////////////////////////////
	require_once "seo.class.php";
	
	// create object
	$seo = new seo ("www.somesite.com");

	mysql_connect("localhost", "mysql_user", "mysql_password") or die("Could not connect: " . mysql_error());
	mysql_select_db("mydb");
	
	$result = mysql_query("SELECT id, title, desc FROM mynews");
	
	$news = array(array());
	$i=0;
	while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
		$seo->dumpVars();
		
		$vars = $row;
		$seo->addVars($vars);
		
		$news[$i][href]  = $seo->getHref("/news/[id]-[title].html");
		$news[$i][title] = $seo->getTitle("[title]");
		$news[$i][alt]   = $seo->getAlt("[title]");
		// etc.
		$i++;
	}
	
	mysql_free_result($result);
	
	 // to use seo url u mast have .htaccess in root dir /////////////////////////////////////////////
	 // .htaccess example

		RewriteEngine On
	
	  # redirect non-www to www 
	  RewriteCond %{HTTP_HOST} !^www..* [NC]
	  RewriteCond %{HTTP_HOST} !^[0-9]+.[0-9]+..+ [NC]
	  RewriteRule ^(.*) http://www.%{HTTP_HOST}/$1 [R=301,L]
	  
	  # $seo->getHref("/[cat]/[id]-[title].html")
	  # http://www.example.com/chrome-web-apps/32-how-to-create-your-own-chrome-web-apps.html
	  # ([0-9]+)			=> int
	  # ([0-9a-zA-Z_-]+)	=> a-z, A-Z, int, -, _
	  RewriteRule ^([0-9a-zA-Z_-]+)/([0-9]+)-([0-9a-zA-Z_-]+).html$ index.php?id=$2
*/
?>
<html>
<head>
        <title><?php echo $seo->getPageTitle("[title] | example.com"); ?></title>
        <meta name="robots" content="index,follow" />
        <meta name="description" content="<?php echo $seo->getDescription("[date] - [title] - [author] - [desc]"); ?>" />
        <link rel="canonical" href="<?php echo $seo->getCanonical(); ?>" />
        
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <h1><?php echo $vars['title']; ?></h1>
        <h2>
            Date: <?php echo $vars['date']; ?> | 
            Autor: <a href="<?php echo $seo->getHref("/author/[author]"); ?>" title="<?php echo $seo->getTitle("[author]"); ?>"><?php echo $vars['author']; ?></a> | 
            Category: <a href="<?php echo $seo->getHref("/[cat]"); ?>" title="<?php echo $seo->getTitle("[cat]"); ?>"><?php echo $vars['cat']; ?></a>
        </h2>
        <p>
            <img src="http://cdn.vikitech.netdna-cdn.com/wp-content/uploads/2010/12/image35.png" alt="<?php echo $seo->getAlt("[title]"); ?>" title="<?php echo $seo->getTitle("[title]"); ?>" />
                
                <?php echo $vars['desc']; ?>
                
        </p>
        <a href="<?php echo $seo->getHref("/[cat]/[id]-[title].html"); ?>" title="<?php echo $seo->getTitle("[title]"); ?>"> <?php echo $vars['title'] ?></a>
    </body>
</html>