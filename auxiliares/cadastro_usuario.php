<?php
include('../conexao/conexao.php');
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = md5($_POST['senha']);

$stmt = $con->prepare("INSERT INTO usuario (usuario_login, usuario_nome, usuario_senha) VALUES (?,?,?);");
$stmt->execute([$email, $nome, $senha]); // Inserindo usuario na tabela de usuarios

$resposta['resp'] = true;

echo json_encode($resposta);
?>