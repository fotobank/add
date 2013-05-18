    <?
    $zip = new zip();
     
    $zip->add_fileFromString("Esto es una prueba\n Estoy probando hola 1, 2, 3 probando... ", "prueba.txt");
    $zip->add_fileFromString("Este es otro archivo comprimido", "prueba2.txt");
     
    $fileName = substr(md5(rand()),0,5)."-archivo.zip";
    $fd = fopen ($fileName, "wb");
    $out = fwrite ($fd, $zip->file());
    fclose ($fd);
    ?>
