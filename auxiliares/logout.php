<?php
session_start();
session_destroy(); // Limpando variavel de sessão.

$resposta['resp'] = true; 
echo json_encode($resposta);