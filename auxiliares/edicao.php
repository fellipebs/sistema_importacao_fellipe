<?php
include('../conexao/conexao.php');
$id = $_POST['id'];

$sql = $con->prepare("SELECT produto_id, 
                             produto_ean, 
                             produto_nome, 
                             produto_preco, 
                             produto_estoque, 
                             produto_data_fabricacao 
                      FROM produto
                      WHERE produto_id = ?");
$sql->execute(array($_POST['id']));
$row = $sql->fetchObject();  // devolve um único registro
$html = "";
$html .= "<label>EAN:</label>";
$html .= "<input type='text' id='ean' name='ean' class='form-control' value='".$row->produto_ean."'>";
$html .= "<label>Nome:</label>";
$html .= "<input type='text' id='nome' name='nome' class='form-control' value='".$row->produto_nome."'>";
$html .= "<label>Preco:</label>";
$html .= "<input type='text' id='preco' name='preco' class='form-control' value='".$row->produto_preco."'>";
$html .= "<label>Estoque:</label>";
$html .= "<input type='text' id='estoque' name='estoque' class='form-control' value='".$row->produto_estoque."'>";
$html .= "<label>Data de fabricação:</label>";
$html .= "<input type='date' id='data' name='data' class='form-control' value='".$row->produto_data_fabricacao."'>";

$resposta['html'] = base64_encode($html);

echo json_encode($resposta);