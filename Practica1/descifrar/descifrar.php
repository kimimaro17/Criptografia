<?php

    $multi = $_POST["alpha"];
    $adi = $_POST["beta"];

    $invermulti = gmp_invert($multi,31);
    $mod = $adi % 31;
    $inveradi = 31 - $mod;

    $abecedario = array(
        0=> "a", 1=> "b", 2=> "c", 3=> "d", 4=> "e", 5=> "f",
        6=> "g", 7=> "h", 8=> "i", 9=> "j", 10=> "k", 11=> "l", 
        12=> "m", 13=> "n", 14=> "o", 15=> "p", 16=> "q", 17=> "r",
        18=> "s", 19=> "t", 20=> "u", 21=> "v", 22=> "w", 23=> "x",
        24=> "y", 25=> "z", 26=> "?", 27=> "(", 28=> ",", 29=> " ' ", 30=> ")"
    );

    $mayusculas = array(
        0=> "A", 1=> "B", 2=> "C", 3=> "D", 4=> "E", 5=> "F",
        6=> "G", 7=> "H", 8=> "I", 9=> "J", 10=> "K", 11=> "L", 
        12=> "M", 13=> "N", 14=> "O", 15=> "P", 16=> "Q", 17=> "R",
        18=> "S", 19=> "T", 20=> "U", 21=> "V", 22=> "W", 23=> "X",
        24=> "Y", 25=> "Z", 26=> "?", 27=> "(", 28=> ",", 29=> " ' ", 30=> ")"
    );

    if($_FILES["archivo"]) {
        $nombre_final = "Archivo_Base.txt";
        $ruta = "archivosBase/" . $nombre_final;
        $subirarchivo = move_uploaded_file($_FILES["archivo"]["tmp_name"], $ruta);
    }

    $archivo = fopen($ruta, "r");
    $contenido = fread($archivo, filesize($ruta));
    fclose($archivo);

    $cambio = array();

    for($i = 0; $i < strlen($contenido); $i++){
        for($x = 0; $x < sizeof($mayusculas); $x++){ 
            if($contenido[$i] == $mayusculas[$x]){
                $conteo = array_search($contenido[$i], $mayusculas);
                $procedimiento = ($conteo + $inveradi) * $invermulti;
                $modulo = $procedimiento % 31;
                $cambio[] = $abecedario["$modulo"];
            }
        }
    }

    $direccion = "archivosDescifrados/ArchivoDescifrado.txt"; 
    $newar = fopen($direccion, "w+b");
    for($y = 0; $y < sizeof($cambio); $y++){
        fwrite($newar, $cambio[$y]);
    }
    fclose($newar);

    header("Content-disposition: attachment; filename=ArchivoDescifrado.txt");
    header("Content-type: application/txt");
    readfile("archivosDescifrados/ArchivoDescifrado.txt");

    unlink($ruta);