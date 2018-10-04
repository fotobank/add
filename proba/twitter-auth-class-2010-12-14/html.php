<?php
	/* Common html-template generator
				Author: Shafiul Azam
				ishafiul@gmail.com
				* How to Use *
				* Call html_head() to start The HTML Page. See source for details and optional parameter lists.
	*/
		
	function html_head($title = "Generated HTML", $css_array = "", $js_array = "", $start_body=false, $keys = "", $desc = ""){
            // $css_array, $js_array contains external .css files & .js files to be included, must be supplied as an array.
			if(empty($keys))
				$keys = 'code host, host code, code hosting, online code hosting, online code highlight, online code demonstration, free code hosting, code paste, free code markup, free code upload, free code download, online code upload';
			if(empty($desc))
				$desc = 'Simply Upload, View, Download and share your codes Online Free!';
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
		<!--
                        Project HostCode.sourceforge.net : Simply Host, View or Download your code!
                        by * BDHACKER * | http://bdhacker.wordpress.com
						Twitter: http://twitter.com/ishafiul
						Copyright: Shafiul Azam, PROGmaatic Developer Network, http://shafiul.progmaatic.com
			This HTML has been generated automatically by PHP, See http://bdhacker.wordpress.com for Documentations
			Author : Shafiul Azam © shafiul@progmaatic.com 
		-->
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<LINK REL="SHORTCUT ICON" HREF="http://i42.tinypic.com/2h540t1.jpg">
		<meta name="description" content="<?= $desc ?>" />
		<meta name="keywords" content="<?= $keys ?>" />
		<title><?= $title ?></title>
			<?php
				if($css_array){
					foreach($css_array as $js_i){
						echo '<LINK href="' . $js_i . '" rel="stylesheet" type="text/css">';
					}
				}
				else{
					echo '<style type="text/css">
                                            body{font-family:Arial, Helvetica, sans-serif; font-size:10px; color:#333;}
                                            input {width: 140px; margin-right: 5px; padding: 3px; border: 1px solid #DFE1E0;}
                                        </style>';
				}
				if($js_array){
					foreach($js_array as $js_i){
						echo '<script type="text/javascript" src ="' . $js_i . '"></script>';
					}
				}
				if($start_body){
					echo "</head><body>";
				}
	}
                function select_yesno($select_name){
                    $str = '<select name="' . $select_name . '"><option value="">no</option><option value="on">yes</option></select>';
                    return $str;
                }
                function html_tr($td_array){
                    echo "<tr>";
                    foreach($td_array as $i){
                        echo "<td>$i</td>";
                    }
                    echo "</tr>";
                }
                function html_input($name,$type="text", $id="", $value=""){
                    return "<input id='$id' type='$type' name = '$name' value='$value'>";
                }
                function html_confirm($text, $link, $msg = "Are you sure to continue?"){
                    return "<a onclick = \"if(confirm($msg)){window.location = '$link'}\" href = '#'>$text</a>";
                }
                function html_date($unix_ts, $show_time = false){
                    $temp = "";
                    if($show_time)
                        $temp = date("j M Y, g:i a",$unix_ts);
                    else
                        $temp = $temp = date("j M Y",$unix_ts);
                    return $temp;
                    echo "hi koddus";
                }
                function html_foot(){
			echo "</body></html>";
		}
		function html_error($msg,$not_error=false,$exit = false){
			$bg = "background-color:#FFFF99; color:#F00;";
			if($not_error)
				$bg = "background-color:#9F9; color:#096;";
			?>
			<div style="width:80%; height:30px; <?= $bg ?> border:1px solid #C60; font-size:11px; font-family:Arial, Helvetica, sans-serif; text-align:center; padding:10px; font-weight:bold;">
			<?php
			echo "$msg</div><br /><br />";
			if($exit){
				echo "</div></body></html>";
				exit();
			}
		}
		function super_slash($str){
			$str = str_replace("\\\\","*shan2#",$str);
			$str = stripslashes($str);
			$str = str_replace("*shan2#","\\",$str);
			return $str;
		}
		function msgbox($message, $mode = 1, $exit = false, $id = ""){
            // modes: 0: info, 1: success, 2: warning, 4: error
            echo "<br>";
            $base_style = "border: 1px solid; margin: 10px 0px; padding:15px 10px 15px 50px; background-repeat: no-repeat; background-position: 10px center; ";
            $color = array("00529B", "4F8A10", "9F6000", "D8000C");
            $bgcolor = array("BDE5F8","DFF2BF","FEEFB3","FFBABA");
            $bgimg = array("http://i45.tinypic.com/2eduji9.jpg","http://i45.tinypic.com/15fnfuo.jpg","http://i47.tinypic.com/fx7x90.jpg","http://i50.tinypic.com/23l19js.jpg");
            $style = $base_style . " color: #" . $color[$mode] . "; background-color: #" . $bgcolor[$mode] . "; background-image: url('" . $bgimg[$mode] . "');";
            echo "<div id = '$id' style = \"$style\">$message</div>";
            echo "<br>";
            if($exit){
                exit();
            }
        }


?>
