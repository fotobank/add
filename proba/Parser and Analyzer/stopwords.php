<?php
/***************************************************************************************
 * Blitz HTML Analyzer
 * Blitz is a PHP class written specifically for parsing and analysing HTML and XHTML without compromising performance
 * This HTML Parser Class provides functions to retrieve document encoding, Base url,    
 * Hyperlinks with their titles and text, Images with their ALT tags, Text in the document, 
 * Text in <title> or <h1> tag, contents of Meta tags.
 * 
 * This class can also find all keywords in the html docuemnt and the keyword density. 
 * Interestingly this class can also prepare array of weighted keywords, in which keywords can have 
 * different weights depending on their position, Like a keyword in <title> or <h1> or keywords in hyperlinks or Image ALT tag can have more weight 
 * that same keyword in normal text.
 * keyword weight for html = no. of occurances X weight for one occurances(single weight) 
 * 
 * We can easily define keyword weights for position in each tag and then we get Array of all keywords and their weights.
 * This is particularly helpful in indexing keywords in the html document for search engines.
 * HTMLBlitz can also fix syntax of incorrect HTML very fast.
 * 
 * Author: Sameer Shelavale
 * Email: sameer@possible.in
 * website: http://possible.in
 * License: GNU GPL, You should keep Package name, Class name, Author name, Email and website credits.
 * PHP Version: Tested on PHP 5.2.5 but should work on all versions PHP5+
 * 
 ****************************************************************************************/

$_stopWords[] = 'a';
$_stopWords[] = 'more';
$_stopWords[] = 'and';
$_stopWords[] = 'at';
$_stopWords[] = 'no';
$_stopWords[] = 'by';
$_stopWords[] = 'of';
$_stopWords[] = 'on';
$_stopWords[] = 'for';
$_stopWords[] = 'or';
$_stopWords[] = 'in';
$_stopWords[] = 'the';
$_stopWords[] = 'this';
$_stopWords[] = 'that';
$_stopWords[] = 'we';
$_stopWords[] = 'I';
$_stopWords[] = 'you';
$_stopWords[] = 'your';
$_stopWords[] = 'they';
$_stopWords[] = 'there';
$_stopWords[] = 'here';
$_stopWords[] = 'their';
$_stopWords[] = 'these';
$_stopWords[] = 'our';
$_stopWords[] = 'me';
$_stopWords[] = 'he';
$_stopWords[] = 'his';
$_stopWords[] = 'she';
$_stopWords[] = 'her';
$_stopWords[] = 'it';
$_stopWords[] = 'from';
$_stopWords[] = 'can';
$_stopWords[] = 'could';
$_stopWords[] = 'shall';
$_stopWords[] = 'should';
$_stopWords[] = 'may';
$_stopWords[] = 'might';
$_stopWords[] = 'will';
$_stopWords[] = 'would';
$_stopWords[] = 'has';
$_stopWords[] = 'have';
$_stopWords[] = 'had';
$_stopWords[] = 'be';
$_stopWords[] = 'is';
$_stopWords[] = 'are';
$_stopWords[] = 'was';
$_stopWords[] = 'were';
?>