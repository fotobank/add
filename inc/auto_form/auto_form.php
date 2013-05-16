<?php 
/************************************************************* 
 * Авто класса формы может генерировать простые обновления, вставки, выбрать и удалить
 * HTML-формы, формы проверки и обработки форм программно
 * На основе информации из таблиц MySQL
 * 
 * For more information, examples and online documentation visit:  
 * http://webcodingeasy.com/PHP-classes/Generate-forms-programmatically 
**************************************************************/ 
//проверка структуры 
class custom_validator 
{ 
    public $callback; 
    public $error_text; 
    public $type; 
    public $data; 
} 
//сам класс
class auto_form 
{ 
    /** 
     * Нужно делать: 
     */ 
    private $order = array(); 
    private $debug = false; 
    private $cnt = 1; 
    private $lang = array(); 
    private $html = false; 
    private $types = array( 
        "int" => "int", "smallint" => "int", "mediumint" => "int", "bigint" => "int", 
        "decimal" => "decimal",  
        "float" => "float", "double" => "float", 
        "tinytext" => "text", "text" => "text", "mediumtext" => "text", "longtext" => "text",  
        "tinyblob" => "text", "mediumblob" => "text", "blob" => "text", "longblob" => "text", 
        "tinyint" => "bool", 
        "enum" => "enum", 
        "set" => "set" 
    ); 
    private $user_html = array(); 
    private $error_msg = array( 
                            "required" => "Пожалуйста, заполните поле `%s`.", 
                            "maxlen"   => "В поле `%s` превышена максимальная длина строки.", 
                            "int"      => "Для поля `%s` допустимый тип данных - integer (целое число).", 
                            "dec"      => "Для поля `%s` допустимый тип данных - decimal (десятичное число).", 
                            "float"    => "Для поля `%s` допустимый тип данных - floating (значение с плавающей точкой).", 
                            "enum"     => "В поле `%s` введено некорректное значение.", 
                        ); 
    private $forms = array(); 
    private $disable_validation = false; 
     
    //callbacks 
    private $on_success = array(); 
    private $on_error = array(); 
    private $modify = array(); 
     
    //validation 
    private $errors = array(); 
    private $custom_val = array(); 
     
    //database connection 
    private $con; 
    //constructor 
    function __construct($con){ 
        $this->con = $con; 
    } 
     
    //disable validation 
    public function disable_validation(){ 
        $this->disable_validation = true; 
    } 
     
    //enable validation 
    public function enable_validation(){ 
        $this->disable_validation = false; 
    } 
     
    //set order array of inputs 
    public function set_order($order){ 
        $this->order = $order; 
    } 
     
    //add user defined validation 
    public function add_custom_validation($callback, $error_str){ 
        $validator_obj = new custom_validator(); 
        $validator_obj->callback = $callback; 
        $validator_obj->error_text = $error_str; 
        $validator_obj->type = "custom"; 
        $num = sizeof($this->forms); 
        if(!isset($this->custom_val[$num])) 
        { 
            $this->custom_val[$num] = array(); 
        } 
        array_push($this->custom_val[$num], $validator_obj); 
    } 
     
    //search for input key 
    private function searchForInput($input, $array) { 
        foreach ($array as $key => $val) { 
            if (isset($val['name']) && $val['name'] === $input) { 
                return $key; 
            } 
        } 
        return null; 
    } 

    //reorder info table based on order array 
    private function reorder($info){ 
        //if some order is set 
        if(!empty($this->order)) 
        { 
            //set new order 
            $neworder = array(); 
            //for each provided input 
            foreach($this->order as $val) 
            { 
                //find it's id in info table 
                $id = $this->searchForInput($val, $info); 
                //if id found 
                if($id) 
                { 
                    //set it in new order 
                    $neworder[] = $info[$id]; 
                    //empty old array 
                    $info[$id] = array(); 
                } 
            } 
            //now let's check if anything is left in info array 
            foreach($info as $val) 
            { 
                //if element is left 
                if(!empty($val)) 
                { 
                    //insert it in new order 
                    $neworder[] = $val; 
                } 
            } 
            return $neworder; 
        } 
        return $info; 
    } 
     
    //add built in validation 
    private function add_validation($callback, $args, $type = "built"){ 
        $validator_obj = new custom_validator(); 
        $validator_obj->callback = $callback; 
        $validator_obj->type = $type; 
        $validator_obj->data = $args; 
        $num = sizeof($this->forms); 
        if(!isset($this->custom_val[$num])) 
        { 
            $this->custom_val[$num] = array(); 
        } 
        array_push($this->custom_val[$num], $validator_obj); 
    } 
     
    //add class predefined validation 
    public function add_class_validation($name, $group, $required = true, $maxlen = ""){ 
        $data = array(); 
        $data["validate"] = $required; 
        $data["name"] = $name; 
        $data["size"] = $maxlen; 
        $this->add_validation(array($this, $group."_validate"), $data, "class"); 
         
    } 
     
    //add new error to error array 
    private function add_error($field_name, $err_type, $err_str = ""){ 
        $count = sizeof($this->errors); 
        if($err_type != "custom") 
        { 
            $this->errors[$count]["id"] = $field_name."_".(sizeof($this->forms)); 
            $this->errors[$count]["name"] = $field_name; 
            if(in_array($field_name."_".$err_type, array_keys($this->lang))) 
            { 
                $this->errors[$count]["error"] = $this->lang[$field_name."_".$err_type]; 
            } 
            else 
            { 
                $this->errors[$count]["error"] = sprintf($this->error_msg[$err_type], $field_name); 
            } 
        } 
        else 
        { 
            $this->errors[$count]["id"] = ""; 
            $this->errors[$count]["name"] = ""; 
            $this->errors[$count]["error"] = $err_str; 
        } 
    } 
     
    //return validation error array 
    private function get_errors(){ 
        $temp = $this->errors; 
        $this->errors = array(); 
        return $temp; 
    } 
     
    //allow html tags in input 
    public function allow_html($html){ 
        if($html) 
        { 
            $this->html = true; 
        } 
        else 
        { 
            $this->html = false; 
        } 
    } 
     
    //provide language array 
    public function set_language($lang){ 
        $this->lang = $lang; 
    } 
     
    //debug mode 
    public function debug(){ 
        $this->debug = true; 
    } 
     
    //set callback function for successful form submit 
    public function set_onsuccess($callback){ 
        $this->on_success[sizeof($this->forms)] = $callback; 
    } 
     
    //set callback function for unsuccessful form submit 
    public function set_onerror($callback){ 
        $this->on_error[sizeof($this->forms)] = $callback; 
    } 
     
    //set callback function for modifying post values 
    public function set_modification($callback){ 
        $this->modify[sizeof($this->forms)][] = $callback; 
    } 
     
    /*************************************************** 
     * Processing field types 
     **************************************************/ 
    //define char type 
    private function char_type($data, $num, $value = ""){ 
        if(in_array($data["name"], array_keys($this->lang))) 
        { 
            $this->forms[$num]["html"] .= "<tr><td class='char_label'>".$this->lang[$data["name"]].": </td>"; 
        } 
        else 
        { 
            $this->forms[$num]["html"] .= "<tr><td class='char_label'>".$data["name"].": </td>"; 
        } 
        $this->forms[$num]["html"] .= "<td class='char_input'>"; 
        $this->forms[$num]["html"] .= "<input type='text' "; 
        $this->forms[$num]["html"] .= "name='".$data["name"]."_".$num."' id='".$data["name"]."_".$num."'"; 
        if(trim($value) != "") 
        { 
            $this->forms[$num]["html"] .= " value='".$value."'"; 
        } 
        else if(trim($data["default"]) != "") 
        { 
            $this->forms[$num]["html"] .= " value='".$data["default"]."'"; 
        } 
        if(trim($data["size"]) != "") 
        { 
            $this->forms[$num]["html"] .= " maxlength='".$data["size"]."'"; 
        } 
        $this->forms[$num]["html"] .= "/>"; 
        $this->forms[$num]["html"] .= "</td></tr> \n"; 
    } 
     
    //define int type 
    private function int_type($data, $num, $value = ""){ 
        if(in_array($data["name"], array_keys($this->lang))) 
        { 
            $this->forms[$num]["html"] .= "<tr><td class='int_label'>".$this->lang[$data["name"]].": </td>"; 
        } 
        else 
        { 
            $this->forms[$num]["html"] .= "<tr><td class='int_label'>".$data["name"].": </td>"; 
        } 
        $this->forms[$num]["html"] .= "<td class='int_input'>"; 
        $this->forms[$num]["html"] .= "<input type='text' "; 
        $this->forms[$num]["html"] .= "name='".$data["name"]."_".$num."' id='".$data["name"]."_".$num."'"; 
        if(trim($value) != "") 
        { 
            $this->forms[$num]["html"] .= " value='".$value."'"; 
        } 
        else if(trim($data["default"]) != "") 
        { 
            $this->forms[$num]["html"] .= " value='".$data["default"]."'"; 
        } 
        if(trim($data["size"]) != "") 
        { 
            $this->forms[$num]["html"] .= " maxlength='".$data["size"]."'"; 
        } 
        $this->forms[$num]["html"] .= "/>"; 
        $this->forms[$num]["html"] .= "</td></tr> \n"; 
    } 
     
    //define decimal type 
    private function decimal_type($data, $num, $value = ""){ 
        if(in_array($data["name"], array_keys($this->lang))) 
        { 
            $this->forms[$num]["html"] .= "<tr><td class='decimal_label'>".$this->lang[$data["name"]].": </td>"; 
        } 
        else 
        { 
            $this->forms[$num]["html"] .= "<tr><td class='decimal_label'>".$data["name"].": </td>"; 
        } 
        $this->forms[$num]["html"] .= "<td class='decimal_input'>"; 
        $this->forms[$num]["html"] .= "<input type='text' "; 
        $this->forms[$num]["html"] .= "name='".$data["name"]."_".$num."' id='".$data["name"]."_".$num."'"; 
        if(trim($value) != "") 
        { 
            $this->forms[$num]["html"] .= " value='".$value."'"; 
        } 
        else if(trim($data["default"]) != "") 
        { 
            $this->forms[$num]["html"] .= " value='".$data["default"]."'"; 
        } 
        if(trim($data["size"]) != "") 
        { 
            if(strpos($data["size"], ",") !== false) 
            { 
                $size = explode(",", $data["size"]); 
                $this->forms[$num]["html"] .= " maxlength='".($size[0]+1)."'"; 
            } 
            else 
            { 
                $this->forms[$num]["html"] .= " maxlength='".$data["size"]."'"; 
            } 
        } 
        $this->forms[$num]["html"] .= "/>"; 
        $this->forms[$num]["html"] .= "</td></tr> \n"; 
    } 
     
    //define float type 
    private function float_type($data, $num, $value = ""){ 
        if(in_array($data["name"], array_keys($this->lang))) 
        { 
            $this->forms[$num]["html"] .= "<tr><td class='float_label'>".$this->lang[$data["name"]].": </td>"; 
        } 
        else 
        { 
            $this->forms[$num]["html"] .= "<tr><td class='float_label'>".$data["name"].": </td>"; 
        } 
        $this->forms[$num]["html"] .= "<td class='float_input'>"; 
        $this->forms[$num]["html"] .= "<input type='text' "; 
        $this->forms[$num]["html"] .= "name='".$data["name"]."_".$num."' id='".$data["name"]."_".$num."'"; 
        if(trim($value) != "") 
        { 
            $this->forms[$num]["html"] .= " value='".$value."'"; 
        } 
        else if(trim($data["default"]) != "") 
        { 
            $this->forms[$num]["html"] .= " value='".$data["default"]."'"; 
        } 
        if(trim($data["size"]) != "") 
        { 
            $this->forms[$num]["html"] .= " maxlength='".$data["size"]."'"; 
        } 
        $this->forms[$num]["html"] .= "/>"; 
        $this->forms[$num]["html"] .= "</td></tr> \n"; 
    } 
     
    //define text type 
    private function text_type($data, $num, $value = ""){ 
        if(in_array($data["name"], array_keys($this->lang))) 
        { 
            $this->forms[$num]["html"] .= "<tr><td colspan='2' class='text_label'>".$this->lang[$data["name"]].": </td></tr> \n"; 
        } 
        else 
        { 
            $this->forms[$num]["html"] .= "<tr><td colspan='2' class='text_label'>".$data["name"].": </td></tr> \n"; 
        } 
        $this->forms[$num]["html"] .= "<tr><td colspan='2' class='text_input'>"; 
        $this->forms[$num]["html"] .= "<textarea name='".$data["name"]."_".$num."' id='".$data["name"]."_".$num."'>"; 
        if(trim($value) != "") 
        { 
            $this->forms[$num]["html"] .= $value; 
        } 
        else if(trim($data["default"]) != "") 
        { 
            $this->forms[$num]["html"] .= $data["default"]; 
        } 
        $this->forms[$num]["html"] .= "</textarea></td></tr> \n"; 
    } 
     
    //define bool type 
    private function bool_type($data, $num, $value = ""){ 
        if($data["size"] == 1) 
        { 
            if(trim($value) != "") 
            { 
                if($value) 
                { 
                    $checked = 'checked'; 
                } 
                else 
                { 
                    $checked = ''; 
                } 
            } 
            else if($data["default"]) 
            { 
                $checked = 'checked'; 
            } 
            else 
            { 
                $checked = ''; 
            } 
            $this->forms[$num]["html"] .= "<tr><td colspan='2' class='bool_input'>"; 
            $this->forms[$num]["html"] .= "<input type='hidden' name='".$data["name"]."_".$num."' value='0'/>"; 
            $this->forms[$num]["html"] .= "<input type='checkbox' name='".$data["name"]."_".$num."' id='".$data["name"]."_".$num."' value='1' ".$checked."/>"; 
            if(in_array($data["name"], array_keys($this->lang))) 
            { 
                $this->forms[$num]["html"] .= $this->lang[$data["name"]]; 
            } 
            else 
            { 
                $this->forms[$num]["html"] .= $data["name"]; 
            } 
            $this->forms[$num]["html"] .= "</td></tr> \n"; 
        } 
        else 
        { 
            $this->int_type($data, $num); 
        } 
    } 
     
    //define enum type 
    private function enum_type($data, $num, $value = ""){ 
        if(in_array($data["name"], array_keys($this->lang))) 
        { 
            $this->forms[$num]["html"] .= "<tr><td class='enum_label'>".$this->lang[$data["name"]].": </td> \n"; 
        } 
        else 
        { 
            $this->forms[$num]["html"] .= "<tr><td class='enum_label'>".$data["name"].": </td> \n"; 
        } 
        $this->forms[$num]["html"] .= "<td class='enum_input'> \n"; 
        $this->forms[$num]["html"] .= "<select name='".$data["name"]."_".$num."' id='".$data["name"]."_".$num."'> \n"; 
        if(!$data["validate"]) 
        { 
            $this->forms[$num]["html"] .= "<option value=''></option> \n"; 
        } 
        $options = explode(",", $data["size"]); 
        foreach($options as $option) 
        { 
            $option = substr($option, 1, sizeof($option)-2); 
            if(in_array($option, array_keys($this->lang))) 
            { 
                $lang = $this->lang[$option]; 
            } 
            else 
            { 
                $lang = $option; 
            } 
            if(trim($value) != "") 
            { 
                if($value == $option) 
                { 
                    $selected = "selected"; 
                } 
                else 
                { 
                    $selected = ""; 
                } 
            } 
            else if(trim($data["default"]) != "" && $data["default"] == $option) 
            { 
                $selected = "selected"; 
            } 
            else 
            { 
                $selected = ""; 
            } 
            $this->forms[$num]["html"] .= "<option value='".$option."' ".$selected.">".$lang."</option> \n"; 
        } 
        $this->forms[$num]["html"] .= "</select> \n"; 
        $this->forms[$num]["html"] .= "</td></tr> \n"; 
    } 
     
    //define set type 
    private function set_type($data, $num, $value = ""){ 
        if(in_array($data["name"], array_keys($this->lang))) 
        { 
            $this->forms[$num]["html"] .= "<tr><td class='set_label'>".$this->lang[$data["name"]].": </td> \n"; 
        } 
        else 
        { 
            $this->forms[$num]["html"] .= "<tr><td class='set_label'>".$data["name"].": </td> \n"; 
        } 
        $this->forms[$num]["html"] .= "<td class='set_input'> \n"; 
        $options = explode(",", $data["size"]); 
        $max = sizeof($options); 
        if($max > 5) 
        { 
            $size = 5; 
        } 
        else 
        { 
            $size = $max; 
        } 
        $this->forms[$num]["html"] .= "<input type='hidden' name='".$data["name"]."_".$num."' value=''/>"; 
        $this->forms[$num]["html"] .= "<select name='".$data["name"]."_".$num."[]' id='".$data["name"]."_".$num."' multiple='multiple' size='".$size."'> \n"; 
        if(!$data["validate"]) 
        { 
            $this->forms[$num]["html"] .= "<option value=''></option> \n"; 
        } 
        $vals = array(); 
        $defs = array(); 
        if(trim($data["default"]) != "") 
        { 
            $defs = explode(",", $value); 
        } 
        foreach($options as $option) 
        { 
            $option = substr($option, 1, sizeof($option)-2); 
            if(in_array($option, array_keys($this->lang))) 
            { 
                $lang = $this->lang[$option]; 
            } 
            else 
            { 
                $lang = $option; 
            } 
            if(!empty($value)) 
            { 
                if(is_array($value)) 
                { 
                    if(in_array($option, $value)) 
                    { 
                        $selected = "selected"; 
                    } 
                    else 
                    { 
                        $selected = ""; 
                    } 
                } 
                else 
                { 
                    if($option == $value) 
                    { 
                        $selected = "selected"; 
                    } 
                    else 
                    { 
                        $selected = ""; 
                    } 
                } 
            } 
            else if(in_array($option, $defs)) 
            { 
                $selected = "selected"; 
            } 
            else 
            { 
                $selected = ""; 
            } 
            $this->forms[$num]["html"] .= "<option value='".$option."' ".$selected.">".$lang."</option> \n"; 
        } 
        $this->forms[$num]["html"] .= "</select> \n"; 
        $this->forms[$num]["html"] .= "</td></tr> \n"; 
    } 
     
    //add custom html code 
    public function add_custom_html($html, $name = "", $in_query = false, $hidden = false){ 
        $num = sizeof($this->forms); 
        if(!isset($this->user_html[$num])) 
        { 
            $this->user_html[$num] = array(); 
        } 
        $count = sizeof($this->user_html[$num]); 
        $this->user_html[$num][$count]["user_html"] = ""; 
        if(trim($name) != "" && !$hidden) 
        { 
            $this->user_html[$num][$count]["user_html"] .= "<tr><td>"; 
            if(in_array($name, array_keys($this->lang))) 
            { 
                $this->user_html[$num][$count]["user_html"] .= $this->lang[$name]; 
            } 
            else 
            { 
                $this->user_html[$num][$count]["user_html"] .= $name; 
            } 
            $this->user_html[$num][$count]["user_html"] .= ": </td><td class='custom_html'>".$html."</td></tr>"; 
        } 
        else 
        { 
            $this->user_html[$num][$count]["user_html"] .= "<tr><td colspan='2' class='custom_html'>".$html."</td></tr>"; 
        } 
        $this->user_html[$num][$count]["include"] = $in_query; 
        $this->user_html[$num][$count]["name"] = $name; 
    } 
     
    /* 
    //char type 
    public function add_char_type($name, $value = "", $maxlen = "", $type = "text", $in_query = false){ 
        $num = sizeof($this->forms); 
        $count = sizeof($this->user_html[$num]); 
        if(in_array($name, array_keys($this->lang))) 
        { 
            $this->user_html[$num][$count]["user_html"] = "<tr><td class='char_label'>".$this->lang[$name].": </td>"; 
        } 
        else 
        { 
            $this->user_html[$num][$count]["user_html"] = "<tr><td class='char_label'>".$name.": </td>"; 
        } 
        $this->user_html[$num][$count]["user_html"] .= "<td class='char_input'>"; 
        $this->user_html[$num][$count]["user_html"] .= "<input type='".$type."' "; 
        $this->user_html[$num][$count]["user_html"] .= "name='".$name."_".$num."' id='".$name."_".$num."'"; 
        $this->user_html[$num][$count]["user_html"] .= " value='".$value."'"; 
        if(trim($maxlen) != "") 
        { 
            $this->user_html[$num][$count]["user_html"] .= " maxlength='".$maxlen."'"; 
        } 
        $this->user_html[$num][$count]["user_html"] .= "/>"; 
        $this->user_html[$num][$count]["user_html"] .= "</td></tr> \n"; 
        $this->user_html[$num][$count]["include"] = $in_query; 
        $this->user_html[$num][$count]["name"] = $name."_".$num; 
    }*/ 
     
    /**************************************************** 
     * Form generation and processing 
    ****************************************************/ 
    //generate form 
    private function generate_form($table_name, $form_type, $condition = "", $exclude = array(), $redir = "", $submit = "submit"){ 
        $count = sizeof($this->forms); 
        $table_info = array(); 
        if(isset($_POST[$table_name."_".$count])) 
        { 
            $table_info = $this->get_table_info($table_name); 
            if($this->validate($table_info, $exclude, $count)) 
            { 
                $_POST = $this->safe($_POST, $this->html); 
                $values = $this->process($_POST);
				if(isset($this->modify[$count]))
				{
					foreach($this->modify[$count] as $val)
					{
						if(is_callable($val))
						{ 
							$arr = call_user_func($val, $values); 
							if(is_array($arr))
							{
								$values = $arr;
							}
						} 
					}
				}
                $function = $form_type."_array"; 
                $ex = array($table_name); 
                if(isset($this->user_html[$count])) 
                { 
                    foreach($this->user_html[$count] as $user_input) 
                    { 
                        if(!$user_input["include"]) 
                        { 
                            $keys = explode("_", $user_input["name"]); 
                            if((sizeof($keys) > 1) && ($keys[sizeof($keys)-1] == (string)$count)) 
                            { 
                                array_pop($keys); 
                            } 
                            $ex[] = implode("_", $keys); 
                        } 
                    } 
                } 
                if($form_type == "update") 
                { 
                    $this->$function($table_name, $values, $ex, $condition); 
                    $result = mysql_affected_rows($this->con); 
                } 
                else if($form_type == "delete") 
                { 
                    $this->$function($table_name, $values, $ex); 
                    $result = mysql_affected_rows($this->con); 
                } 
                else if($form_type == "select") 
                { 
                    $result = $this->$function($table_name, $values, $ex, $condition); 
                } 
                else 
                { 
                    $this->$function($table_name, $values, $ex); 
                    $result = mysql_insert_id($this->con); 
                } 
                $redirect = true; 
                if(isset($this->on_success[$count]) && is_callable($this->on_success[$count])) 
                { 
                    $redirect = call_user_func($this->on_success[$count], $result); 
                } 
                if(!$this->debug && !headers_sent() && $redirect) 
                {     
                    header("Location: ".$redir); 
                } 
            } 
            else 
            { 
                if(isset($this->on_error[$count]) && is_callable($this->on_error[$count])) 
                { 
                    call_user_func($this->on_error[$count], $this->get_errors()); 
                } 
                else 
                { 
                    $errors = $this->get_errors(); 
                    echo "<ul class='error_text'>"; 
                    foreach($errors as $error) 
                    { 
                        echo "<li>".$error["error"]."</li>"; 
                    } 
                    echo "</ul>"; 
                } 
            } 
        } 
        if($form_type == "update") 
        { 
            $vals = $this->select("*", $table_name, $condition); 
        } 
        $this->forms[$count]["html"] = "<form id='".$table_name."_".$count."' method='post' action=''> \n"; 
        $this->forms[$count]["html"] .= "<table class='".$table_name."'> \n"; 
        if(empty($table_info)) 
        { 
            $table_info = $this->get_table_info($table_name); 
        } 
        foreach($table_info as $field) 
        { 
            if(!in_array($field["name"], $exclude)) 
            { 
                if(in_array($field["type"], array_keys($this->types))) 
                { 
                    $type = $this->types[$field["type"]]."_type"; 
                    if(isset($_POST[$field["name"]."_".$count])) 
                    { 
                        $this->$type($field, $count, $this->strip($_POST[$field["name"]."_".$count], $this->html)); 
                    } 
                    else if(isset($vals[$field["name"]])) 
                    { 
                        $this->$type($field, $count, $vals[$field["name"]]); 
                    } 
                    else 
                    { 
                        $this->$type($field, $count); 
                    } 
                } 
                else 
                { 
                    if(isset($_POST[$field["name"]."_".$count])) 
                    { 
                        $this->char_type($field, $count, $this->strip($_POST[$field["name"]."_".$count], $this->html)); 
                    } 
                    else if(isset($vals[$field["name"]])) 
                    { 
                        $this->char_type($field, $count, $vals[$field["name"]]); 
                    } 
                    else 
                    { 
                        $this->char_type($field, $count); 
                    } 
                } 
            } 
            else 
            { 
                if(isset($this->user_html[$count])) 
                { 
                    foreach($this->user_html[$count] as $key => $user_html) 
                    { 
                        if($user_html["name"] == $field["name"]) 
                        { 
                            $this->forms[$count]["html"] .= $user_html["user_html"]; 
                            unset($this->user_html[$count][$key]); 
                            break; 
                        } 
                    } 
                } 
            } 
        } 
        if(isset($this->user_html[$count])) 
        { 
            foreach($this->user_html[$count] as $user_html) 
            { 
                $this->forms[$count]["html"] .= $user_html["user_html"]; 
            } 
        } 
        $this->forms[$count]["html"] .= "<tr><td class='submit_input' colspan='2'> \n"; 
        $this->forms[$count]["html"] .= "<input type='hidden' name='".$table_name."_".$count."'/>"; 
        if(in_array($submit, array_keys($this->lang))) 
        { 
            $this->forms[$count]["html"] .= "<input type='submit' id='submit_".$count."' value='".$this->lang[$submit]."'/> \n"; 
        } 
        else 
        { 
            $this->forms[$count]["html"] .= "<input type='submit' id='submit_".$count."' value='".$submit."'/> \n"; 
        } 
        $this->forms[$count]["html"] .= "</td></tr> \n"; 
        $this->forms[$count]["html"] .= "</table> \n"; 
        $this->forms[$count]["html"] .= "</form> \n"; 
        echo $this->forms[$count]["html"]; 
    } 
     
    //generate field names 
    private function process($arr){ 
        $ret = array(); 
        foreach($arr as $key => $val) 
        { 
            $keys = explode("_", $key); 
            if((sizeof($keys) > 1) && ($keys[sizeof($keys)-1] == (string)sizeof($this->forms))) 
            { 
                array_pop($keys); 
            } 
            $ret[implode("_", $keys)] = $val; 
        } 
        return $ret; 
    } 
     
    //generate insert form 
    public function insert_form($table_name, $exclude = array(), $redir = "", $submit = "submit"){ 
        if(trim($redir) == "") 
        { 
            $redir = $_SERVER["REQUEST_URI"]; 
        } 
        $this->generate_form($table_name, "insert", "", $exclude, $redir, $submit); 
    } 
     
    //generate update form 
    public function update_form($table_name, $condition, $exclude = array(), $redir = "", $submit = "submit"){ 
        if(trim($redir) == "") 
        { 
            $redir = $_SERVER["REQUEST_URI"]; 
        } 
        $this->generate_form($table_name, "update", $condition, $exclude, $redir, $submit); 
    } 
     
    //generate select form 
    public function select_form($table_name, $exclude = array(), $addon = "", $redir = "", $submit = "submit"){ 
        if(trim($redir) == "") 
        { 
            $redir = $_SERVER["REQUEST_URI"]; 
        } 
        $this->generate_form($table_name, "select", $addon, $exclude, $redir, $submit); 
    } 
     
    //generate delete form 
    public function delete_form($table_name, $exclude = array(), $redir = "", $submit = "submit"){ 
        if(trim($redir) == "") 
        { 
            $redir = $_SERVER["REQUEST_URI"]; 
        } 
        $this->generate_form($table_name, "delete", "", $exclude, $redir, $submit); 
    } 
     
    //get information about table 
    private function get_table_info($table_name){ 
        $result = $this->exec("DESCRIBE ".$table_name); 
        $arr = array(); 
        if($result != 0) 
        { 
            while($row = $this->fetch($result)) 
            { 
                $count = sizeof($arr); 
                $arr[$count]["name"] = $row["Field"]; 
                if(strpos($row["Type"], "(") === false) 
                { 
                    $arr[$count]["type"] =  substr($row["Type"], 0); 
                } 
                else 
                { 
                    $arr[$count]["type"] =  substr($row["Type"], 0, strpos($row["Type"], "(")); 
                } 
                if(strpos($row["Type"], "(") == false) 
                { 
                    $arr[$count]["size"] =  ''; 
                } 
                else 
                { 
                    $arr[$count]["size"] =  substr($row["Type"], strpos($row["Type"], "(") + 1, (strpos($row["Type"], ")") - strpos($row["Type"], "(")) -1); 
                } 
                $arr[$count]["default"] = $row["Default"]; 
                if($row["Null"] == "NO") 
                { 
                    $arr[$count]["validate"] = true; 
                } 
                else 
                { 
                    $arr[$count]["validate"] = false; 
                } 
                $arr[$count]["key"] = $row["Key"]; 
                $arr[$count]["extra"] = $row["Extra"]; 
            } 
            $arr = $this->reorder($arr); 
            return $arr; 
        } 
    } 
     
    //insert array into database 
    private function insert_array($where, $arr, $exclude = array()) { 
        //$arr = $this->safe($arr, $this->html); 
        $first = true; 
        $query = "INSERT INTO `".$where."` SET "; 
        foreach ($arr as $key => $value) 
        { 
            if(!in_array($key,$exclude)) 
            { 
                if(is_array($value)) 
                { 
                    $value = implode(",", $value); 
                } 
                if($first) 
                { 
                    $query = $query."`".$key."` = '".$value."'"; 
                    $first = false; 
                } 
                else     
                { 
                    $query = $query.", `".$key."` = '".$value."'"; 
                } 
            } 
        } 
        $result = $this->exec($query); 
        return $result; 
    } 
     
    //update database record from array 
    private function update_array($where, $arr, $exclude = array(), $condition = "") { 
        //$arr = $this->safe($arr, $this->html); 
        $first = true; 
        $query = "UPDATE `".$where."` SET "; 
        foreach ($arr as $key => $value) 
        { 
            if(!in_array($key,$exclude)) 
            { 
                if(is_array($value)) 
                { 
                    $value = implode(",", $value); 
                } 
                if($first) 
                { 
                    $query = $query."`".$key."` = '".$value."'"; 
                    $first = false; 
                } 
                else     
                { 
                    $query = $query.", `".$key."` = '".$value."'"; 
                } 
            } 
        } 
        $query = $query." ".$condition; 
        $result = $this->exec($query); 
        return $result; 
    } 
     
    //select rows from database 
    private function select_array($where, $arr, $exclude = array(), $addon = "") { 
        $what ="*"; 
        $first = true; 
        $query = "select ".$what." from ".$where." where "; 
        foreach ($arr as $key => $value) 
        { 
            if(!in_array($key, $exclude)) 
            { 
                if(is_array($value)) 
                { 
                    $value = implode(",", $value); 
                } 
                if($first) 
                { 
                    $query = $query.$key." = '".$value."'"; 
                    $first = false; 
                } 
                else     
                { 
                    $query = $query." and ".$key." = '".$value."'"; 
                } 
            } 
        } 
        $result = $this->exec($query." ".$addon); 
        return $result; 
    } 
     
    //delete rows from database 
    private function delete_array($where, $arr, $exclude = array()) { 
        $first = true; 
        $query = "delete from ".$where." where "; 
        foreach ($arr as $key => $value) 
        { 
            if(!in_array($key, $exclude)) 
            { 
                if(is_array($value)) 
                { 
                    $value = implode(",", $value); 
                } 
                if($first) 
                { 
                    $query = $query.$key." = '".$value."'"; 
                    $first = false; 
                } 
                else     
                { 
                    $query = $query." and ".$key." = '".$value."'"; 
                } 
            } 
        } 
        $result = $this->exec($query); 
        return $result; 
    } 
     
    //select row from database 
    private function select($what ="*", $where, $condition = "") { 
        $query = "SELECT ".$what." FROM `".$where."` ".$condition; 
        $result = $this->exec($query); 
        if($result != 0 && mysql_num_rows($result) > 0) 
        { 
            $arr = mysql_fetch_assoc($result); 
            foreach ($arr as $key => $value) 
            { 
                $arr[$key] = $this->strip($value, $this->html); 
            } 
             
            return $arr; 
        } 
        else return 0; 
    } 
     
    //make data safe 
    private function safe($arr, $html = false) { 
        if(!empty($arr)) 
        { 
            foreach ($arr as $key => $value) 
            { 
                if(is_array($value)) 
                { 
                    $arr[$key] = $this->safe($arr[$key], $html); 
                } 
                else 
                { 
                    $arr[$key] = $this->strip($value); 
                    if($html) 
                    { 
                        $arr[$key] = mysql_real_escape_string($arr[$key]); 
                    } 
                    else 
                    { 
                        $arr[$key] = mysql_real_escape_string(str_replace("\r\n", "", nl2br(htmlspecialchars($arr[$key], ENT_QUOTES)))); 
                    } 
                } 
            } 
        } 
        return $arr; 
    } 
     
    //fetch new row 
    private function fetch($result) { 
        if($arr = mysql_fetch_assoc($result)) 
        { 
            foreach ($arr as $key => $value) 
            { 
                $arr[$key] = $this->strip($value); 
            } 
            return $arr; 
        } 
        else 
        { 
            return false; 
        } 
    } 
     
    //execute query 
    private function exec($query) { 
        if($this->debug) 
        { 
            echo "<p>".($this->cnt++).") ".$query."</p>"; 
            $result = mysql_query($query) or die (mysql_error()); 
        } 
        else 
        { 
            $result = mysql_query($query, $this->con); 
        } 
        return $result; 
    } 

    //strip out values from database based on magic quotes settings 
    private function strip($val, $html = true){ 
        if(is_array($val)) 
        { 
            foreach($val as $key => $value) 
            { 
                $val[$key] = $this->strip($value); 
            } 
        } 
        else 
        { 
            if (TRUE == function_exists('get_magic_quotes_gpc') && 1 == get_magic_quotes_gpc()) 
            { 
                $mqs = strtolower(ini_get('magic_quotes_sybase')); 

                if (TRUE == empty($mqs) || 'off' == $mqs) 
                { 
                    $val = stripslashes($val); 
                } 
                else 
                { 
                    $val =  str_replace("''", "'", $val); 
                } 
                if(!$html) 
                { 
                    $val = preg_replace('/<br\\s*?\/??>/i', "\r\n", htmlspecialchars_decode($val)); 
                } 
            } 
        } 
        return $val; 
    } 
     
    /*************************************************** 
     * Validate types 
     **************************************************/ 
    //main validate 
    private function validate($table_info, $exclude, $count){ 
        $valid = true; 
        if(!$this->disable_validation) 
        { 
            foreach($table_info as $field) 
            { 
                if(!in_array($field["name"], $exclude)) 
                { 
                    if(in_array($field["type"], array_keys($this->types))) 
                    { 
                        $type = $this->types[$field["type"]]."_validate"; 
                        if(isset($_POST[$field["name"]."_".$count])) 
                        { 
                            $valid = $this->$type($field, $count, $_POST[$field["name"]."_".$count], $valid); 
                        } 
                    } 
                    else 
                    { 
                        if(isset($_POST[$field["name"]."_".$count])) 
                        { 
                            $valid = $this->char_validate($field, $count, $_POST[$field["name"]."_".$count], $valid); 
                        } 
                    } 
                } 
            } 
        } 
        $valid = $this->custom_validate($count, $valid); 
        return $valid; 
    } 
     
    //custom validation 
    private function custom_validate($count, $valid){ 
        if(!empty($this->custom_val[$count])) 
        { 
            $form = array(); 
            foreach($_POST as $key => $val) 
            { 
                if(substr($key, strlen($key) - strlen("_".$count)) == "_".$count) 
                { 
                    $form[substr($key, 0, strlen($key) - strlen("_".$count))] = $val; 
                } 
                else 
                { 
                    $form[$key] = $val; 
                } 
            } 
            foreach($this->custom_val[$count] as $validation) 
            { 
                if($validation->type == "custom") 
                { 
                    if(is_callable($validation->callback)) 
                    { 
                        if(!call_user_func($validation->callback, $form)) 
                        { 
                            $valid = false; 
                            $this->add_error("", "custom", $validation->error_text); 
                        } 
                    } 
                } 
                else if($validation->type == "built") 
                { 
                    if(is_callable($validation->callback)) 
                    { 
                        $valid = call_user_func($validation->callback, $validation->data, $count, $_POST[$validation->data["name"]."_".$count], $valid); 
                    } 
                } 
                else if($validation->type == "class") 
                { 
                    if(is_callable($validation->callback)) 
                    { 
                        $valid = call_user_func($validation->callback, $validation->data, "", $_POST[$validation->data["name"]], $valid); 
                    } 
                } 
            } 
        } 
        return $valid;     
    } 
     
    //validate char type 
    private function char_validate($data, $num, $value, $valid){ 
        if($data["validate"] && !$this->required($value)) 
        { 
            $valid = false; 
            $this->add_error($data["name"], "required"); 
        } 
        if($this->max_len($value, $data["size"])) 
        { 
            $valid = false; 
            $this->add_error($data["name"], "maxlen"); 
        } 
        return $valid; 
    } 
     
    //validate int type 
    private function int_validate($data, $num, $value, $valid){ 
        if($data["validate"]) 
        { 
            if(!$this->required($value)) 
            { 
                $valid = false; 
                $this->add_error($data["name"], "required"); 
            } 
        } 
        else 
        { 
            if(!$this->required($value)) 
            { 
                $value = 0; 
                if($num === "") 
                { 
                    $_POST[$data["name"]] = 0; 
                } 
                else 
                { 
                    $_POST[$data["name"]."_".$num] = 0; 
                } 
            } 
        } 
        if($this->max_len($value, $data["size"])) 
        { 
            $valid = false; 
            $this->add_error($data["name"], "maxlen"); 
        } 
        if($this->not_int($value)) 
        { 
            $valid = false; 
            $this->add_error($data["name"], "int"); 
        } 
        switch($data["type"]) 
        { 
            case "tinyint": 
                if($value < -128 || $value > 127) 
                {     
                    $valid = false; 
                    $this->add_error($data["name"], "int"); 
                } 
                break; 
            case "smallint": 
                if($value < -32768 || $value > 32767) 
                { 
                    $valid = false; 
                    $this->add_error($data["name"], "int"); 
                } 
                break; 
            case "mediumint": 
                if($value < -8388608 || $value > 8388607) 
                { 
                    $valid = false; 
                    $this->add_error($data["name"], "int"); 
                } 
                break; 
            case "int": 
                if($value < -2147483648 || $value > 2147483647) 
                { 
                    $valid = false; 
                    $this->add_error($data["name"], "int"); 
                } 
                break; 
            case "bigint": 
                if($value < -9223372036854775808 || $value > 9223372036854775807) 
                { 
                    $valid = false; 
                    $this->add_error($data["name"], "int"); 
                } 
                break; 
        } 
        return $valid; 
    } 
     
    //validate decimal type 
    private function decimal_validate($data, $num, $value, $valid){ 
        $value = str_replace(",", ".", $value); 
        if($num === "") 
        { 
            $fname = $data["name"]; 
        } 
        else 
        { 
            $fname = $data["name"]."_".$num; 
        } 
        $_POST[$fname] = $value; 
        $sizes = explode(",", $data["size"]); 
        if($data["validate"]) 
        { 
            if(!$this->required($value)) 
            { 
                $valid = false; 
                $this->add_error($data["name"], "required"); 
                 
            } 
        } 
        else 
        { 
            if(!$this->required($value)) 
            { 
                $value = 0; 
                $_POST[$fname] = 0; 
                 
            } 
        } 
        if($this->max_len(str_replace(".", "", $value), $sizes[0])) 
        { 
            $valid = false; 
            $this->add_error($data["name"], "maxlen"); 
        } 
        if($this->not_decimal($value, $sizes[1])) 
        { 
            $valid = false; 
            $this->add_error($data["name"], "dec"); 
        } 
        return $valid; 
    } 
     
    //validate float type 
    private function float_validate($data, $num, $value, $valid){ 
        $value = str_replace(",", ".", $value); 
        if($num === "") 
        { 
            $fname = $data["name"]; 
        } 
        else 
        { 
            $fname = $data["name"]."_".$num; 
        } 
        $_POST[$fname] = $value; 
        if($data["validate"]) 
        { 
            if(!$this->required($value)) 
            { 
                $valid = false; 
                $this->add_error($data["name"], "required"); 
                 
            } 
        } 
        else 
        { 
            if(!$this->required($value)) 
            { 
                $value = 0; 
                $_POST[$fname] = 0; 
                 
            } 
        } 
        if($this->not_float($value)) 
        { 
            $valid = false; 
            $this->add_error($data["name"], "float"); 
        } 
        return $valid; 
    } 
     
    //validate text type 
    private function text_validate($data, $num, $value, $valid){ 
        if($data["validate"] && !$this->required($value)) 
        { 
            $valid = false; 
            $this->add_error($data["name"], "required"); 
             
        } 
        return $valid; 
    } 
     
    //validate bool type 
    private function bool_validate($data, $num, $value, $valid){ 
        if($data["validate"] && !$value) 
        { 
            $valid = false; 
            $this->add_error($data["name"], "required"); 
        } 
        return $valid; 
    } 
     
    //validate enum type 
    private function enum_validate($data, $num, $value, $valid){ 
        if($data["validate"]) 
        { 
            if(!$this->required($value)) 
            { 
                $valid = false; 
                $this->add_error($data["name"], "required"); 
                 
            } 
        } 
        else 
        { 
            if(!$this->required($value)) 
            { 
                $value = 0; 
                if($num === "") 
                { 
                    $_POST[$data["name"]] = 0; 
                } 
                else 
                { 
                    $_POST[$data["name"]."_".$num] = 0; 
                } 
            } 
        } 
        if($this->not_set($value, $data["size"])) 
        { 
            $valid = false; 
            $this->add_error($data["name"], "enum"); 
        } 
        return $valid; 
    } 
     
    //validate set type 
    private function set_validate($data, $num, $value, $valid){ 
        if(is_array($value)) 
        { 
            $vals = $value; 
        } 
        else 
        { 
            $vals = array($value); 
        } 
        if($data["validate"]) 
        { 
            foreach($vals as $val) 
            { 
                if(!$this->required($val)) 
                { 
                    $valid = false; 
                    $this->add_error($data["name"], "required"); 
                    break; 
                     
                } 
            } 
        } 
        foreach($vals as $val) 
        { 
            if($this->not_set($val, $data["size"])) 
            { 
                $valid = false; 
                $this->add_error($data["name"], "enum"); 
                break; 
            } 
        } 
        return $valid; 
    } 
     
    /*************************************************** 
     * Validation functions 
     **************************************************/ 
    //field is required if not null 
    private function required($value){ 
        if(strlen($value) <=0) 
        { 
            return false; 
        } 
        else 
        { 
            return true; 
        } 
    } 
     
    //field length is used as maximal length for value 
    private function max_len($value, $len){ 
        if(trim($len) == "") 
        { 
            return false; 
        } 
        if(strlen($value) > $len) 
        { 
            return true; 
        } 
        else 
        { 
            return false; 
        } 
    } 
     
    //checking if value is not integer 
    private function not_int($value, $signed = true){ 
        if($signed) 
        { 
            $reg = "/^[-+]?\d*$/"; 
        } 
        else 
        { 
            $reg = "/[0-9]+/"; 
        } 
        if(preg_match($reg, $value)) 
        { 
            return false; 
        } 
        else 
        { 
            return true; 
        } 
    } 
     
    //checking if value is not decimal 
    private function not_decimal($value, $size){ 
        $isn_dec = false; 
        $dec = explode(".", $value); 
        if(isset($dec[1]) && (strlen($dec[1]) > $size)) 
        { 
            $isn_dec = true; 
        } 
        else if(sizeof($dec) > 2) 
        { 
            $isn_dec = true; 
        } 
        else 
        { 
            $first = true; 
            foreach($dec as $frac) 
            { 
                if($first) 
                { 
                    if($this->not_int($frac)) 
                    { 
                        $isn_dec = true; 
                    } 
                    $first = false; 
                } 
                else 
                { 
                    if($this->not_int($frac, false)) 
                    { 
                        $isn_dec = true; 
                    } 
                } 
            } 
        } 
        return $isn_dec; 
    } 
     
    //check if value is not float 
    private function not_float($value){ 
        $isn_fl = false; 
        $dec = explode(".", $value); 
        if(sizeof($dec) > 2) 
        { 
            $isn_fl = true; 
        } 
        else 
        { 
            $first = true; 
            foreach($dec as $frac) 
            { 
                if($first) 
                { 
                    if($this->not_int($frac)) 
                    { 
                        $isn_dec = true; 
                    } 
                    $first = false; 
                } 
                else 
                { 
                    if($this->not_int($frac, false)) 
                    { 
                        $isn_dec = true; 
                    } 
                } 
            } 
        } 
        return $isn_fl; 
    } 
     
    //check if value is not in specified values list 
    private function not_set($value, $size){ 
        $arr = explode(",", $size); 
        foreach($arr as $key => $val) 
        { 
            $arr[$key] = str_replace("'", "", $val); 
        } 
        $arr[] = 0; 
        if(in_array($value, $arr)) 
        { 
            return false; 
        } 
        else 
        { 
            return true; 
        } 
    } 
} 
?>