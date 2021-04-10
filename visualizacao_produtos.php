<?php
session_start();
include("funcoes/global.php");
include('conexao/conexao.php');
importacoes();

if(!isset($_SESSION['usuario'])){ //Caso não exista sessão, redirecionar o usuário para fora.
    header("Location: index.php");
}
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="sistema.php">Sistema de importação</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="sistema.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item" active>
        <a class="nav-link" href="visualizacao_produtos.php">Ver já importados</a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#"><?php echo 'Seja bem-vindo '.$_SESSION['usuario']->usuario_login.'!'; ?></a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <button class="btn btn-outline-success my-2 my-sm-0" type="button" onclick='logout()'>Logout</button>
    </form>
  </div>
</nav>

<div class='container'>
<?php

$stmt = $con->query("SELECT produto_id, 
                            produto_ean, 
                            produto_nome, 
                            produto_preco, 
                            produto_estoque, 
                            DATE_FORMAT(produto_data_fabricacao,'%d/%m/%Y') as produto_data_fabricacao
                      FROM produto");
$i = 0;   
echo "<table class='table'>";
    echo "<thead>";
        echo "<tr>";
            echo "<th>Ações</th>";
            echo "<th>EAN</th>";
            echo "<th>Nome</th>";
            echo "<th>Preço</th>";
            echo "<th>Estoque</th>";
            echo "<th>Data de fabricação</th>";
        echo "</tr>";
    echo "</thead>";
    echo "<tbody>"; 
while ($row = $stmt->fetch()) {
        echo "<tr id='tr_".$row['produto_id']."'>"; 
            echo "<td><button class='btn btn-success' onclick='editar(".$row['produto_id'].")' data-toggle='modal' data-target='#myModal'>Editar</button>
                      <button class='btn btn-danger' onclick='excluir(".$row['produto_id'].")'>Excluir</button>
                  </td>";
            echo "<td>".$row['produto_ean']."</td>";
            echo "<td>".$row['produto_nome']."</td>";
            echo "<td style='text-align: right;'>R$ ".number_format($row['produto_preco'],2,',','.')."</td>";
            echo "<td style='text-align: center;'>".$row['produto_estoque']."</td>";
            echo "<td style='text-align: center;'>".$row['produto_data_fabricacao']."</td>";
        echo "</tr>"; 
    $i++;
}
if($i == 0){ // Caso i == 0, não foram encontrados produtos no SQL, portanto disparar mensagem.
    echo "<script>";
    echo "Swal.fire(
            'Info!',
            'Nenhum dado para produto ainda foi encontrado!',
            'info'
         );";
    echo "</script>";
}
?>
</div>

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edição de produto</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body" id='corpoModal'>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success btn-block ml-1" id='btnConfirmar' onclick='cadastrar();'>Confirmar</button>
        </div>
      </div>
    </div>
  </div>