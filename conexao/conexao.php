<?php
// header('Content-Type: text/html; charset=UTF-8');
try {
    $con = new PDO('mysql:host=localhost;dbname=sistema_importacao', "root", "");
} catch (PDOException $e) {
    print "Problema no BD " . $e->getMessage() . "<br/>";
    die();
}