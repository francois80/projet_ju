<?php
define('USER', 'fglavieux');
define('PASS', '2.-ufD9T');
define('HOST', 'localhost');
define('DB', 'hospitalE2N');

function connectDb(){

    $dsn = 'mysql:dbname='. DB. ';host='. HOST. ';';
    try{
        $db = new PDO($dsn, USER, PASS);
        return $db;
    } catch (Exception $ex) {
        var_dump($ex);
        die('La connexion à la bdd a échoué !!');
    }
}
?>
