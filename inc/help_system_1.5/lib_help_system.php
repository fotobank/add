<?php
/*
Library "Help System". V1.5. Copyright (C) 2003 - 2006 Richter
This library allow to operate with help - both with main and with the context-dependent
Additional information: http://wpdom.com, richter@wpdom.com
*/

class Help_System {
  var $context_add_parameters;
  var $main_add_parameters;

  function Help_System($cfg_name = '')
  {
    $this->mes[0]	= 'Page of context help not found!';
    $this->mes[1]	= 'Identifier of context help is wrong!';
    $this->mes[2]	= 'Impossible to find file of context help!';
    $this->mes[3]	= 'Page of main help not found!';
    require $cfg_name;
    $this->cfg_name = $cfg_name;
  }

  // Return HTML-code for sections list of main help
  function get_sections($active_hid = '')
  {
    $dump = file($this->data_folder."main_help_index.dat");
    $current_section_number = 0;

    // Defining of active section
    foreach($dump as $I=>$val) {
      $val = explode('|', $val);
      if ($val[0] == 'sb') {
        $current_section_number++;
        $active_section_number = $current_section_number;
      }
      if (trim($val[2])==$active_hid and $active_hid!='') break;
      if (trim($val[0]) == 'se') $active_section_number = '';
    }

    $parent_id = 0;
    foreach($dump as $I=>$val) {
      $val = explode('|', $val);
      if ($val[0] == 'sb') {
        $parent_id++;
        if ($parent_id == $active_section_number) {
          $img = 'o';
          $visibility = 'visible';
        } else {
          $img = 'c';
          $visibility = 'none';
        }
        $out .= '
		<img id="img_'.$parent_id.'" src="'.$this->pic_folder.'folder_'.$img.'.gif"> <a href="javascript:toggle_submenu('.$parent_id.')">'.$val[1].'</a><br />
		<div id="menu_'.$parent_id.'" style="display: '.$visibility.'; padding-left:20px">
        ';
      } elseif ($val[0] == 'd') {
        $out .= '<img src="'.$this->pic_folder.'item.gif"> <a href="'.$this->mainhelp_script.'&cfg_name='.$this->cfg_name.'&main_help_id='.$val[2].$this->main_add_parameters.'">'.$val[1].'</a><br />';
      } elseif (trim($val[0]) == 'se') {
        $out .= '</div>';
      }
    }
    $out .= '
	<script language="javascript">
	submenu_q = '.$parent_id.';

	// Show/hides submenu
	function toggle_submenu(id)
	{
          if (document.getElementById("menu_"+id).style.display == "none") is_closed = 1; else is_closed = 0;
          for (i=1;i<=submenu_q;i++) {
            document.getElementById("menu_"+id).style.display = "none";
            document.getElementById("menu_"+id).src = "'.$this->pic_folder.'folder_c.gif";
          }
          if (is_closed == 1) {
            document.getElementById("menu_"+id).style.display = "block";
            document.getElementById("menu_"+id).src = "'.$this->pic_folder.'folder_o.gif";
          }
	}
	</script>
    ';
    return $out;
  }

  // Return content of page of main help
  function get_content($hid = 'index')
  {
    if (!$hid) $hid = 'index';
    $fname = $this->data_folder.$hid.'.php';
    $fp = @fopen($fname, 'r');
    if ($fp) {
      if ($this->mainhelp_php) include $fname;
      else $out = fread($fp,filesize($fname));
      fclose($fp);
    } else return $this->mes[3];
    return $out;
  }

  // Return start "HREF-block" for link to page of main help
  // $hid - help page ID
  function get_main_href($hid = '')
  {
    $url = $this->mainhelp_script.'&cfg_name='.$this->cfg_name.(!empty($hid)?'&main_help_id='.$hid:'').$this->main_add_parameters;
    return '<a href="'.$url.'" onclick="window.open(\''.$url.'\',\'main_help\',\'scrollbars=yes,left=\'+(screen.width-'.$this->mainhelp_win_w.')+\',top=50,width='.$this->mainhelp_win_w.',height='.$this->mainhelp_win_h.'\');
	return false;" style="cursor: help">';
  }

  // Return start "HREF-block" for link to page of main help, called from main help
  // $hid - help page ID
  function get_main_href_internal($hid = '')
  {
    return '<a href="'.$this->mainhelp_script.'&cfg_name='.$this->cfg_name.(!empty($hid)?'&main_help_id='.$hid:'').$this->main_add_parameters.'">';
  }

  // Write "HREF-block" for link to context help
  function get_context_href($context_id)
  {
    $url = $this->context_script.'&cfg_name='.$this->cfg_name.'&context_help_id='.$context_id.$this->context_add_parameters;
    return '<a href="'.$url.'" onclick="window.open(\''.$url.'\',\'context_help\',\'scrollbars=yes,left=\'+(screen.width-'.$this->context_win_w.')+\',top=20,width='.$this->context_win_w.',height='.$this->context_win_h.'\');
	return false;" style="cursor: help">'.$this->context_href_expr.'</a>';
  }

  // Return content of context help
  // $suffix - any string which can be used for instance as code of language
  function get_context_content($context_id, $suffix = '')
  {
    $fname = $this->data_folder.'context_help_'.$suffix.'.dat';
    if (!file_exists($fname)) $fname = $this->data_folder.'context_help_'.$this->context_default_suffix.'.dat';
    if (!file_exists($fname)) $fname = $this->data_folder.'context_help.dat';
    if (empty($context_id)) $out->header = $this->mes[1];
    elseif (!file_exists($fname)) $out->header = $this->mes[2];
    else {
      $help_context = file($fname);
      foreach ($help_context as $I=>$val) {
        if (trim($val) == $context_id) {
          $out->id	= $context_id;
          $out->header	= $help_context[++$I];
          while (trim($help_context[++$I])!='###' and $I<count($help_context)) {
            $out->body .= $help_context[$I];
          }
          $found = 1;
        }
      }
      if (!$found) $out->header = $this->mes[0];
    }
    return $out;
  }
}
?>