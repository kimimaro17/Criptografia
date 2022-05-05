<?php

    if($_FILES["archivo"]) {

        $path = $_FILES["archivo"]["name"];
        $name = pathinfo($path, PATHINFO_FILENAME);
        

        $nombre_final = "textofirmado.txt";
        $ruta = "archivoBase/" . $nombre_final;
        $subirarchivo = move_uploaded_file($_FILES["archivo"]["tmp_name"], $ruta);
    }

    $archivo = fopen($ruta, "r");
    $contenido = fread($archivo, filesize($ruta));
    fclose($archivo);

///////////////////////////////////////////////////////////llavepriva////////////
    if($_FILES["llavepu"]) {

        $path2 = $_FILES["llavepu"]["name"];
        $name = pathinfo($path2, PATHINFO_FILENAME);
        

        $nombre_final2 = "llavepu.txt";
        $ruta2 = "archivoBase/" . $nombre_final2;
        $subirarchivo2 = move_uploaded_file($_FILES["llavepu"]["tmp_name"], $ruta2);
    }

    $archivo2 = fopen($ruta2, "r");
    $key = fread($archivo2, filesize($ruta2));
    fclose($archivo2);
    unlink($ruta2);

    $keypub = openssl_pkey_get_public($key);
///////////////////////////////////////////////////////////////

    $cont = 0;

    $texto = array();
    $firma = array();

    for($i = 0; $i < strlen($contenido); $i++){
        if($cont < 3){
            if($contenido[$i] != "["){
                $texto[] = $contenido[$i];
            }else{
                $cont++;
            }
        }else{
            $firma[] = $contenido[$i];
        }
    }

    $cancion = implode($texto);
    $lafirma = implode($firma);

    $algoritm = "sha256";
    $digesto = hash($algoritm, $cancion, $raw_output = true);

    openssl_public_decrypt(base64_decode($lafirma),$decry,$keypub);

    if($digesto == $decry){
        echo "<font face='Arial' size='5'> Verificado, mensaje sin modificaciones y la llave pública coincide con la privada </font><br>";
        echo "<div style='text-align: center;'><img src='data:image/png;base64,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' 
        width='500'></div>";
    }else{
        echo "<font face='Arial' size='5'> Error en la verificacion, posible error en la llave pública o el mensaje ha sido modificado</font><br>";
        echo "<div style='text-align: center;'><img src='https://thumbs.dreamstime.com/b/icono-rojo-de-la-marca-plana-ronda-bot%C3%B3n-s-mbolo-cruzado-aislado-en-el-fondo-blanco-vector-eps-143476706.jpg' 
        width='500'></div>";
    }