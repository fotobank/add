<?
    $today = @file("../total/".date("Y-m-d"));
    if($today)
       {
        global $today_hit;
		$today_host = 0;
        for($ttt=0;$ttt<count($today);$ttt++)
           {
             list($i,$h,$t,$w) = explode('<<>>',$today[$ttt]);
             if($w == "own_site")
			 {
			  $today_hit += $h;
			 } 
            }
            
        for($tt=0;$tt<count($today);$tt++)
           {
             list($i,$h,$t,$w) = explode('<<>>',$today[$tt]);
             if($w == "own_site")
			 {
			  $today_host++;
			 } 
            }      

            }
              if(!$today)
            {
              $today_host = 0;
              $today_hit = 0;
            }

   function add_blank($count)
        {
         return substr("         ".$count, -10);
        }

   $hits_today = add_blank($today_hit);
   $host_today = add_blank($today_host);

   header("Content-Type:image/png");
   $image = "count.png";
   $imgpng = imagecreatefrompng ($image);

   $host_color = imagecolorallocate($imgpng,  0, 0, 0);
   $hit_color = imagecolorallocate($imgpng,   0, 0, 0);

   ImageString($imgpng, 1, 81, 12, "$hits_today", $hit_color);
   ImageString($imgpng, 1, 81, 3, "$host_today", $host_color);

   ImagePNG ($imgpng);
   ImageDestroy ($imgpng);
?>