<?php
include('../conexao/conexao.php');

$sql = $con->prepare("SELECT usuario_id, usuario_login FROM usuario WHERE usuario_login = ? AND usuario_senha = ?");
$sql->execute(array($_POST['email'], md5($_POST['senha'])));

$row = $sql->fetchObject();  // devolve um único registro

// Se o usuário foi localizado
if ($row) {
    $_SESSION['usuario'] = $row;
    $resposta['resp'] = true;
}else{
    $resposta['resp'] = false;

}

echo json_encode($resposta);
?>