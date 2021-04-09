<?php
try {
    $con = new PDO('mysql:host=localhost;dbname=sistema_importacao', "root", "");
} catch (PDOException $e) {
    print "Problema no BD " . $e->getMessage() . "<br/>";
    die();
}