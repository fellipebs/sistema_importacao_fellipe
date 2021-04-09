<?php
include('../conexao/conexao.php');
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = md5($_POST['senha']);

$stmt = $con->prepare("INSERT INTO usuario (usuario_login, usuario_nome, usuario_senha) VALUES (?,?,?);");
$stmt->execute([$nome, $email, $senha]);

$resposta['resp'] = true;

echo json_encode($resposta);
?>