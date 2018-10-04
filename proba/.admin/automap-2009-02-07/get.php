<?php
/*------------------------------------------------------------------------------------------

This file is part of auto google site maps creation by lee johnstone
this file was orginaly made by a third party site please read below for there license.

YOU MAY NOT
(1) Remove or modify this copyright notice.
(2) Distribute this code as your own
(3) Use this code in commercial projects
    
YOU MAY
(1) Use this code or any modified version of it on your website.
(2) Use this code as part of another product.

u may not remove this notice
please read our copyright license here
http://www.freakcms.com/licensing.php
or contact us here
http://www.toy17s.com/index.php?page=Contact-us
--------------------------------------------------------------------------------------------

this file grabs the sitemap after the user requests it.

-------------------------------------------------------------------------------------------*/


include 'create.php';
$map = new AutoMaps();
$map->GetMap();
                                                
?>

