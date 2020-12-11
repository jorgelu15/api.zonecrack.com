<?php

/*******************************************************************
 * LLAVES SECRETAS ALEATORIAS PARA LAS CREDENCIALES DE LOS USUARIOS
 *******************************************************************/
# base64_encode(openssl_random_pseudo_bytes(32))
# base64_encode(openssl_random_pseudo_bytes(64))

define('FIRST_KEY', 'KHwecMKA/iwKfXEGmfzblEvZ2zz5YNRUbDV/BRBzVHk=');
define('SECOND_KEY', 'GAUP/MtbdPYKPgMtdgrGusbzVckgVpT4ZJ1UXKSGEUcxa1rhoUW9JSoWT0FhjBKNRrZU4ejpzg5/ll36mPSM0A==');


/*******************************************************************
 * ENCRIPTA LAS CREDENCIALES DEL CLIENTE
 *******************************************************************/
function secured_encrypt($data)
{
    $first_key = base64_decode(FIRST_KEY);
    $second_key = base64_decode(SECOND_KEY);

    $method = "aes-256-cbc";
    $iv_length = openssl_cipher_iv_length($method);
    $iv = openssl_random_pseudo_bytes($iv_length);

    $first_encrypted = openssl_encrypt($data, $method, $first_key, OPENSSL_RAW_DATA, $iv);
    $second_encrypted = hash_hmac('sha3-512', $first_encrypted, $second_key, TRUE);

    $output = base64_encode($iv . $second_encrypted . $first_encrypted);
    return $output;
}


/*******************************************************************
 * DESENCRIPTA LAS CREDENCIALES DEL CLIENTE
 *******************************************************************/
function secured_decrypt($input)
{
    $first_key = base64_decode(FIRST_KEY);
    $second_key = base64_decode(SECOND_KEY);
    $mix = base64_decode($input);

    $method = "aes-256-cbc";
    $iv_length = openssl_cipher_iv_length($method);

    $iv = substr($mix, 0, $iv_length);
    $second_encrypted = substr($mix, $iv_length, 64);
    $first_encrypted = substr($mix, $iv_length + 64);

    $data = openssl_decrypt($first_encrypted, $method, $first_key, OPENSSL_RAW_DATA, $iv);
    $second_encrypted_new = hash_hmac('sha3-512', $first_encrypted, $second_key, TRUE);

    if (hash_equals($second_encrypted, $second_encrypted_new))
        return $data;

    return false;
}

function url($titulo)
{
    $titulo = strtolower($titulo);
    $titulo = trim($titulo);
    $titulo = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        'a',
        $titulo
    );
    $titulo = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        'e',
        $titulo
    );
    $titulo = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        'i',
        $titulo
    );
    $titulo = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        'o',
        $titulo
    );
    $titulo = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        'u',
        $titulo
    );
    $titulo = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C',),
        $titulo
    );
    $titulo = str_replace(
        array(
            "\\", "¨", "º", "-", "~",
            "#", "@", "|", "!", "\"",
            "·", "$", "%", "&",
            "(", ")", "?", "'", "¡",
            "¿", "[", "^", "`", "]",
            "+", "}", "{", "¨", "´",
            ">", "< ", ";", ",",
            "."
        ),
        '-',
        $titulo
    );
    $titulo = str_replace("/", "/", $titulo);
    $titulo = str_replace("-", " ", $titulo);
    return $titulo;
}

function urltotitle($titulo)
{
    $titulo = strtolower($titulo);
    $titulo = trim($titulo);
    $titulo = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        'a',
        $titulo
    );
    $titulo = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        'e',
        $titulo
    );
    $titulo = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        'i',
        $titulo
    );
    $titulo = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        'o',
        $titulo
    );
    $titulo = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        'u',
        $titulo
    );
    $titulo = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C',),
        $titulo
    );
    $titulo = str_replace(
        array(
            "\\", "¨", "º", "-", "~",
            "#", "@", "|", "!", "\"",
            "·", "$", "%", "&",
            "(", ")", "?", "'", "¡",
            "¿", "[", "^", "`", "]",
            "+", "}", "{", "¨", "´",
            ">", "< ", ";", ",",
            "."
        ),
        '-',
        $titulo
    );
    $titulo = str_replace("/", "/", $titulo);
    $titulo = str_replace(" ", "-", $titulo);
    return $titulo;
}

function urlApos($titulo)
{
    $titulo = str_replace("'", ".1", $titulo);
    $titulo = str_replace(" ", "-", $titulo);
    $titulo = str_replace(":", ".2", $titulo);
    return $titulo;
}

function urlAposInverse($titulo)
{
    $titulo = str_replace(".1", "'", $titulo);
    $titulo = str_replace("-", " ", $titulo);
    $titulo = str_replace(".2", ":", $titulo);
    return $titulo;
}
