<?PHP
#############################################################################################################
#
#   KG Uploader v1.0
#   Class Name  : KG Uploader Class
#   Version     : 1.0
#   Requirement : PHP4 >
#   Build Date  : January 13, 2007 - Wednesday
#   Developer   : Muharrem ERİN - info@muharremerin.com - muharremerin.com - mhrrmrnr.com - kisiselgunce.com
#   Licence     : GNU General Public License (c) 2007
#
#############################################################################################################

// uploader class
class kg_uploader {

    var $files = array();
    var $error = NULL;
    var $file_names = array();
    var $directory = NULL;
    var $uploaded = false;
    var $uploaded_files = array();
    var $file_new_name = NULL;
    var $results = NULL;

    // управление индексом
    function directory($directory) {
        // У вас есть каталог?
        if (!is_dir($directory)) {
            $this -> error .= '<li><strong>'.$directory.'</strong> нашел папку с именем!</li>';
        }
        // У вас есть права на запись в каталог?
        if (is_dir($path) && !is_writable($directory)) {
            $this -> error .= '<li><strong>'.$directory.'</strong> Существует разрешение на запись в каталоге!</li>';
        }
        $this -> directory = $directory;
    }

    // информация о файле
    function files($files) {
        if ($files) {
            for ($i = 0; $i < count($files); $i++) {
                if ($files['name'][$i]) {
                    $this -> files['tmp_name'][] = $files['tmp_name'][$i];
                    $this -> files['name'][] = $files['name'][$i];
                    $this -> files['type'][] = $files['type'][$i];
                    $this -> files['size'][] = $files['size'][$i];
                }
            }
        }
    }

   
    function bad_character_rewrite($text){
            $first = array("\\", "/", ":", ";", "~", "|", "(", ")", "\"", "#", "*", "$", "@", "%", "[", "]", "{", "}", "<", ">", "`", "'", ",", " ");
            $last = array("_", "_", "_", "_", "_", "_", "", "_", "_", "_", "_", "_", "_", "_", "_", "_", "_", "_", "_", "_", "_", "", "_", "_");
            $text_rewrite = str_replace($first, $last, $text);
            return $text_rewrite;
    }

  
    function file_extension($file_name) {
        $file_extension = strtolower(substr(strrchr($file_name, '.'), 1));
        return $file_extension;
    }

  
    function file_name_control($file_name) {
        $file_name = $this -> bad_character_rewrite($file_name);
        if (!file_exists($this -> directory.'/'.$file_name)) {
            return $file_name;
        }else{
            return rand(000000001,999999999).'_'.rand(000000001,999999999).'_'.$file_name;
        }
    }

    // dosya(lari) yukle
    function upload($mime_types) {
        if(!$this -> error) {
            for ($i = 0; $i < count($this -> files['tmp_name']); $i++) {
                if (in_array($this -> files['type'][$i], $mime_types)) {
                    $this -> file_new_name = $this -> file_name_control($this -> files['name'][$i]);
                    move_uploaded_file($this -> files['tmp_name'][$i], $this -> directory.'/'.$this -> file_new_name);
                    $this -> uploaded_files[] = $this -> file_new_name;
                    $this -> results .= '<li><strong>'.$this -> files['name'][$i].'</strong> Просмотр файлов, <strong>'.$this -> file_new_name.'</strong> загруженное имя<br />(~'.round($this -> files['size'][$i] / 1024, 2).' kb). Тип файла : '.$this -> file_extension($this -> files['name'][$i]).'</li>';
                }else{
                    echo $this -> files['type'][$i];
                    $this -> results .= '<li>'.$this -> files['name'][$i].' Просмотр файлов, из-за несовместимости типов файлов добавлена!</li>';
                }
            }
            $this -> uploaded = true;
        }
    }

    // загрузить результат отчета
    function result_report() {
        if(isset($this -> error)) {
            echo '<ul>';
            echo $this -> error;
            echo '</ul>';
        }
        if ($this -> uploaded == true) {
            echo '<ul>';
            echo $this -> results;
            echo '</ul>';
        }
    }

    function uploader_set($files, $directory, $mime_types) {
        $this -> directory($directory);
        $this -> files($files);
        $this -> upload($mime_types);
    }
}
?>