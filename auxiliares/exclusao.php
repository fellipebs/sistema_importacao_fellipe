<?php
include('../conexao/conexao.php');
$id = $_POST['id'];

$stmt = $con->prepare("DELETE FROM produto WHERE produto_id = ?;");
$stmt->execute([$id]); // Arquivo feito para deletar o produto

$resposta['resp'] = true;

echo json_encode($resposta);