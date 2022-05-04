<?php

    if($_FILES["archivo"]) {

        $path = $_FILES["archivo"]["name"];
        $name = pathinfo($path, PATHINFO_FILENAME);
        

        $nombre_final = "texto.txt";
        $ruta = "archivoBase/" . $nombre_final;
        $subirarchivo = move_uploaded_file($_FILES["archivo"]["tmp_name"], $ruta);
    }

    $archivo = fopen($ruta, "r");
    $contenido = fread($archivo, filesize($ruta));
    fclose($archivo);

///////////////////////////////////////////////////////////llavepriva////////////
    if($_FILES["llave"]) {

        $path2 = $_FILES["llave"]["name"];
        $name = pathinfo($path2, PATHINFO_FILENAME);
        

        $nombre_final2 = "llave.txt";
        $ruta2 = "archivoBase/" . $nombre_final2;
        $subirarchivo2 = move_uploaded_file($_FILES["llave"]["tmp_name"], $ruta2);
    }

    $archivo2 = fopen($ruta2, "r");
    $key = fread($archivo2, filesize($ruta2));
    fclose($archivo2);
    unlink($ruta2);

///////////////////////////////////////////////////////////////

    $algoritm = "sha256";
    $digesto = hash($algoritm, $contenido, $raw_output = true);

    $key2 = openssl_pkey_get_private($key);

    openssl_private_encrypt($digesto, $encry, $key2);
    $encry = base64_encode($encry);

    $direccion = "archivosCifrados/firmadito.txt"; 
    $newar = fopen($direccion, "w+b");
    fwrite($newar, $contenido);
    fwrite($newar, "****");
    fwrite($newar, $encry);
    fclose($newar);

    header("Content-disposition: attachment; filename=ArchivoFirmado.txt");
    header("Content-type: application/txt");
    readfile("archivosCifrados/firmadito.txt");