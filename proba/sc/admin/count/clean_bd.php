<?
  function scan_dir($dirname) 
  { 
    $dir = opendir($dirname); 
    while (($file = readdir($dir)) !== false) 
    { 
      if($file != "." && $file != ".." && $file != "count.png" && $file != "cntimg.php" && $file != "ban") 
      { 
        if(is_file($dirname."/".$file)) 
        { 
         unlink($dirname."/".$file);
        } 
        if(is_dir($dirname."/".$file)) 
        { 
           scan_dir($dirname."/".$file); 
        } 
      } 
    } 
    closedir($dir); 
  } 

    scan_dir("../../data/");
    
    print" <html><head>\n";
    print"<META HTTP-EQUIV='Refresh' CONTENT='0; URL=index.php'>"; 
    print"</head></html>\n";


?>