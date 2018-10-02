<?PHP
header("Content-Type: text/html; charset=utf-8");
require_once('kgUploader.class.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<title>KG Uploader v1.0</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
    body {
        margin:20px; background:#f2f2f2; font:0.8em/1.8em arial, helvetica, sans serif; color:#333;
    }
    form {
        margin:0;
    }
    #reports {
        margin:auto; width:300px; padding:3px;  background:#fff; border:1px solid #e0e0e0;
    }
    #reports ul {
        list-style-type:square;
    }
    #reports ul li {
        border-bottom:1px dotted #e0e0e0;
    }
    #form {
        margin:auto; width:300px; padding:3px; margin-top:3px; background:#fff; border:1px solid #e0e0e0;
    }
</style>
</head>
<body>

<?PHP
if($_FILES) {
?>
<div id="reports">
<?PHP
    $mime_types = array('image/pjpeg', 'image/jpeg', 'image/gif', 'image/png', 'image/x-png', 'application/x-tar', 'application/zip', 'application/msword', 'application/vnd.ms-excel', 'application/vnd.ms-powerpoint', 'application/mspowerpoint', 'application/x-shockwave-flash', 'text/plain', 'text/richtext', 'application/pdf'); // Типы файлов, которые будет разрешено
    $kgUploaderOBJ = new kg_uploader();
    $kgUploaderOBJ -> uploader_set($_FILES['files'], './repo', $mime_types); // 1 файлов параметров последовательности, 2 индекс параметра, 3 Если типы параметров файла допускаются
    $kgUploaderOBJ -> result_report(); // показывает сведения о загрузке
    /* //Если появится запрос на имя файла записывается в таблицу следующим образом: listeletilebilir.
    for ($i = 0; $i < count($kgUploaderOBJ -> uploaded_files); $i++) {
        echo $kgUploaderOBJ -> uploaded_files[$i];
    }
    */
?>
</div>
<?PHP
}
?>

<div id="form">
    <form method="post" action="test.php" enctype="multipart/form-data">
        <p><input type="file" name="files[]" id="file1" /></p>
        <p><input type="file" name="files[]" id="file1" /></p>
        <p><input type="file" name="files[]" id="file1" /></p>
        <p><input type="file" name="files[]" id="file1" /></p>
        <p><input type="file" name="files[]" id="file1" /></p>
        <p><input type="submit" name="upload" value="upload" id="upload" /></p>
    </form>
</div>

</body>
</html>