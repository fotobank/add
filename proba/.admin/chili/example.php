<?php

require_once 'ChiliHighlighter.php';

ChiliHighlighter::init('js-chili');

$html = <<<CODE
<html>
  <head>
    <title>Code Sample</title>
  </head>
  <body>
    <b>Hello World!</b>
  </body>
</html>
CODE;

ChiliHighlighter::highlightString($html, 'html');

ChiliHighlighter::highlightFile('ChiliHighlighter.php', 'php');

?>