<?php

    $config = array(
        "digest_alg" => "sha512",
        "private_key_bits" => 512,
        "private_key_type" => OPENSSL_KEYTYPE_RSA,
    );

    $res=openssl_pkey_new($config);

    openssl_pkey_export($res, $privKey,NULL,$config); //llave privada

    $pubKey=openssl_pkey_get_details($res);
    $pubKey=$pubKey["key"];

    $direccion = "llavero.txt"; 
    $newar = fopen($direccion, "w+b");
    fwrite($newar, $pubKey.$privKey);
    fclose($newar);

    header("Content-disposition: attachment; filename=llavero.txt");
    header("Content-type: application/txt");
    readfile("llavero.txt");

    unlink($direccion);
    