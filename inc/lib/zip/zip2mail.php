    <?
    $zip = new zip();
     
    $zip->add_fileFromString("Esto es una prueba\n Estoy probando hola 1, 2, 3 probando... ", "prueba.txt");
    $zip->add_fileFromString("Este es otro archivo comprimido", "prueba2.txt");
     
    $zip->add_file("/images/foto.jpg","foto.jpg"); //Tambien es posible agregar archivos
     
    $zip->add_dir("mas_images");//agregar directorio
    $zip->add_file("/images/foto2.jpg","mas_images/foto.jpg");
    $zip->add_file("/images/foto3.jpg","mas_images/foto2.jpg");
     
    header("Content-type: application/force-download");
    header("Content-Transfer-Encoding: Binary");
    header("Content-length: ".strlen($zip->file()));
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"All-Leagues-{$format}.zip\"");
     
    echo $zip->file();
    ?>
