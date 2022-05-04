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
    //unlink($ruta2);

///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////llavepubli////////////
if($_FILES["llavepu"]) {

    $path3 = $_FILES["llavepu"]["name"];
    $name = pathinfo($path2, PATHINFO_FILENAME);
    

    $nombre_final3 = "llavepu.txt";
    $ruta3 = "archivoBase/" . $nombre_final3;
    $subirarchivo3 = move_uploaded_file($_FILES["llavepu"]["tmp_name"], $ruta3);
}

$archivo2 = fopen($ruta2, "r");
$key = fread($archivo2, filesize($ruta2));
fclose($archivo2);
//unlink($ruta2);

$archivo3 = fopen($ruta3, "r");
$keypu = fread($archivo3, filesize($ruta3));
fclose($archivo3);

///////////////////////////////////////////////////////////////


    $algoritm = "sha256";
    $digesto = hash($algoritm, $contenido, $raw_output = true);

    $key2 = openssl_pkey_get_private($key);

    openssl_private_encrypt($digesto, $encry, $key2);
    $encry = base64_encode($encry);
    //echo $encry."\n";

    $keypub2 = openssl_pkey_get_public($keypu);

    openssl_public_decrypt(base64_decode($encry),$decry,$keypub2);
    echo $digesto."----------";
    echo $decry;

/*
    $rsa = new Crypt_RSA();
    $rsa->loadKey($key);
    $rsa->setPrivateKey($key);

    echo $rsa->getPrivateKey();
*/

    /*
    $digebin = hex2bin($digesto);

    echo $digebin;*/



    /*
    $cambio = array();

    for($i = 0; $i < strlen($contenido); $i++){
        for($x = 0; $x < sizeof($abecedario); $x++){ 
            if($contenido[$i] == $abecedario[$x]){
                $conteo = array_search($contenido[$i], $abecedario);
                $procedimiento = ($conteo * $multi) + $adi;
                $modulo = $procedimiento % 31;
                $cambio[] = $mayusculas[$modulo];
            }else if($contenido[$i] == $mayusculas[$x]){
                $conteo = array_search($contenido[$i], $mayusculas);
                $procedimiento = ($conteo * $multi) + $adi;
                $modulo = $procedimiento % 31;
                $cambio[] = $mayusculas[$modulo];
            }
        }
    }

    $direccion = "archivosCifrados/ArchivoCifrado.txt"; 
    $newar = fopen($direccion, "w+b");
    for($y = 0; $y < sizeof($cambio); $y++){
        fwrite($newar, $cambio[$y]);
    }
    fclose($newar);

    header("Content-disposition: attachment; filename=".$name."_C.txt");
    header("Content-type: application/txt");
    readfile("archivosCifrados/ArchivoCifrado.txt");

    unlink($ruta);*/