<?php
include('../conexao/conexao.php');
if (isset($_POST['id'])) {
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
       $html .= "<input type='hidden' id='idProd' value='" . $row->produto_id . "'>";
       $html .= "<label>EAN:</label>";
       $html .= "<input type='text' id='ean' name='ean' class='form-control' value='" . $row->produto_ean . "'>";
       $html .= "<label>Nome:</label>";
       $html .= "<input type='text' id='nome' name='nome' class='form-control' value='" . utf8_encode($row->produto_nome) . "'>";
       $html .= "<label>Preco:</label>";
       $html .= "<input type='text' id='preco' name='preco' class='form-control' value='" . number_format($row->produto_preco, 2, ',', '.') . "' onKeyUp='mascaraMoeda(this, event)'>";
       $html .= "<label>Estoque:</label>";
       $html .= "<input type='text' id='estoque' name='estoque' class='form-control' value='" . number_format($row->produto_estoque, 2, ',', '.') . "' onKeyUp='mascaraMoeda(this, event)'>";
       $html .= "<label>Data de fabricação:</label>";
       $html .= "<input type='date' id='data' name='data' class='form-control' value='" . $row->produto_data_fabricacao . "'>";
       $resposta['html'] = base64_encode($html); // Necessário codificar para base64, pois o ajax não entende nossa acentuação.
} else if (isset($_POST['idProd'])) {

       $idProd = $_POST['idProd'];
       $ean = $_POST['ean'];
       $nome =  $_POST['nome'];
       $preco = $_POST['preco'];
       $estoque = $_POST['estoque'];               
       $data = $_POST['data'];
       if($data == ""){
          $data = NULL;
       }
       $stmt = $con->prepare("UPDATE produto SET produto_ean = ?,
                                                 produto_nome = ?,
                                                 produto_preco = ?,
                                                 produto_estoque = ?,
                                                 produto_data_fabricacao = ?
                              WHERE produto_id = ?;");
       $stmt->execute([$ean, $nome, $preco, $estoque, $data, $idProd]);

       //Motando html para TD
       $sql = $con->prepare("SELECT produto_id, 
                                    produto_ean, 
                                    produto_nome, 
                                    produto_preco, 
                                    produto_estoque, 
                                    DATE_FORMAT(produto_data_fabricacao, '%d/%m/%Y') as  produto_data_fabricacao
                             FROM produto
                             WHERE produto_id = ?");
       $sql->execute(array($idProd));
       $row = $sql->fetchObject();  // devolve um único registro
       $html = "";
       $html .= "<td><button class='btn btn-success' onclick='editar(".$row->produto_id.")' data-toggle='modal' data-target='#myModal'>Editar</button>
                     <button class='btn btn-danger' onclick='excluir(".$row->produto_id.")'>Excluir</button>
                 </td>";
       $html .= "<td>".$row->produto_ean."</td>";
       $html .= "<td>".$row->produto_nome."</td>";
       $html .= "<td style='text-align: right;'>R$ ".number_format($row->produto_preco,2,',','.')."</td>";
       $html .= "<td style='text-align: right;'>".number_format($row->produto_estoque,2,',','.')."</td>";
       $html .= "<td style='text-align: center;'>".$row->produto_data_fabricacao."</td>";
       $resposta['html'] = base64_encode($html); // Necessário codificar para base64, pois o ajax não entende nossa acentuação.

}

echo json_encode($resposta);
