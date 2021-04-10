<html>
<head>
<?php
session_start();
include("funcoes/global.php");
include('conexao/conexao.php');
include("vendor/shuchkin/simplexlsx/src/SimpleXLSX.php");
importacoes();

if(!isset($_SESSION['usuario'])){ //Caso não exista sessão, redirecionar o usuário para fora.
    header("Location: index.php");
}
?>

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="sistema.php">Sistema de importação</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="sistema.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
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
  <form action='' method="post" enctype="multipart/form-data">
  <div class='row'>
    <div class='col-md-6'>
      <input type='file' accept='.xlsx' name='arquivo' id='arquivo' required>
    </div>
    <div class='col-md-6'>
      <button type='submit' class='btn btn-success'>Processar arquivo</button>
    </div>
  </div>
  </form>
</div>


<?php
if(isset($_FILES['arquivo'])){ // Validação para o arquivo
  if ( $xlsx = SimpleXLSX::parse($_FILES['arquivo']['tmp_name'] ) ) {
    $html = ""; // Variável que irá armazenar a tabela! 
    $html .= "<div class='container'>
          <table class='table'>";
          $html .= "<tbody>"; 
    $i = 0;

    $validador = array(); // Caso alguma posição venha a ser false, não poderemos inserir nada!
    $mensagem = "Tudo ok!"; // Mensagem para possível erros.

    //Dicionário 
    // [0] -> EAN
    // [1] -> Nome
    // [2] -> Preço
    // [3] -> Estoque
    // [4] -> Data de fabricação

    foreach ($xlsx->rows() as $linha) {
      if($i != 0){ // Validação para campos fora do cabecalho
        $html .= "<tr>";
          if($linha[0] != false && $linha[0] != ""){ // Caso exista EAN, validar se ele já existe!
            $sql = $con->prepare("SELECT COUNT(*) AS ct FROM produto WHERE produto_ean = ?");
            $sql->execute(array($linha[0]));
            $row = $sql->fetchObject(); 
            if(($row->ct) == 0){ 
              $html .= "<td>".$linha[0]."</td>";   
              $validador[$i] = true;         
            }else{
              $html .= "<td>".$linha[0]."</td>";            
              $validador[$i] = false;
              $mensagem = "Campo de EAN repetido!";
            }
          }else{ // Caso não exista, abortar e mensagem de EAN não existente
            $html .= "<td></td>";            
            $validador[$i] = false;
            $mensagem = "Campo de EAN não encontrado!";
          }

          if($linha[1] != false && $linha[1] != ""){ // Validando existência do campo nome
            $html .= "<td>".$linha[1]."</td>";
            if($validador[$i] != false)
              $validador[$i] = true;
          }else{
            $html .= "<td></td>";            
            $validador[$i] = false;
            $mensagem = "Campo de nome não encontrado!";
          }

          if($linha[2] != false && $linha[2] != "" && is_numeric($linha[2])){ // Validando existência do campo preço e se ele é numérico
            $html .= "<td style='text-align: right;'>R$ ".number_format($linha[2],2,',','.')."</td>";
            if($validador[$i] != false)
              $validador[$i] = true;
          }else{
            $html .= "<td></td>";            
            $validador[$i] = false;
            if($linha[2] == "" || $linha[2] == false) // Validação que foi feita com is_numeric para valores não númericos, que poderiam ocasionar em erros no mysql
              $mensagem = "Campo de preço não encontrado!";
            else
              $mensagem = "Campo de preço não é númerico!";
          }

          if($linha[3] != false && $linha[3] != "" && is_numeric($linha[3])){ // Validando existência do campo estoque e se ele é numérico
            $html .= "<td style='text-align: right;'>".number_format($linha[3],2,',','.')."</td>";
            if($validador[$i] != false)
              $validador[$i] = true;
          }else{
            $html .= "<td></td>";            
            $validador[$i] = false;
            if($linha[3] == "" || $linha[3] == false) // Validação que foi feita com is_numeric para valores não númericos, que poderiam ocasionar em erros no mysql
              $mensagem = "Campo de estoque não encontrado!";
            else
              $mensagem = "Campo de estoque não é númerico!";
          }

          if($linha[4] != "" && $linha[4] != false){ // Não existem validações para data!
            $data = substr($linha[4],0,10);
            $data = explode('-',$data);
            $data = $data[2]."/".$data[1]."/".$data[0];
            $html .= "<td>".$data."</td>"; // Tratando forma de exibição na tela
          }else{
            $html .= "<td></td>";
          }
          $html .= "<td>$mensagem</td>";
          $mensagem = "Tudo ok!";
        $html .= "</tr>";
      }else{
          //Validando as informações do cabecalho
          if($linha[0] != "EAN" || $linha[1] != "NOME PRODUTO" || $linha[2] != "PREÇO" || $linha[3] != "ESTOQUE" || $linha[4] != "DATA FABRICAÇÃO"){
            $validador[$i] = false;
          }else{ // Imprimindo Cabeçalho
            $validador[$i] = true;
            $html .= "<thead>";
            $html .= "<tr>";
                $html .= "<td>".$linha[0]."</td>";
                $html .= "<td>".$linha[1]."</td>";
                $html .= "<td>".$linha[2]."</td>";
                $html .= "<td>".$linha[3]."</td>";
                $html .= "<td>".$linha[4]."</td>";
                $html .= "<td>Mensagem</td>";
              $html .= "</tr>";
            $html .= "</thead>";
          }
      }
      $i++;
    }

    $html .= "</tbody>
          </table>
          </div>";

    if(count($validador) == 0){ // Caso nenhuma linha foi inserido um arquivo vazio.
      echo 
      "<script>
        Swal.fire(
        'Arquivo vazio!',
        'Dados não poderão ser incluídos pois o arquivo estava vazio.',
        'error'
        );
      </script>";
    }else if(in_array(false, $validador)){ // Caso encontrado o valor FALSE no arquivo, nada poderá ser impresso
      if($validador[0] == false){ // Caso cabeçalho errado
        echo 
        "<script>
          Swal.fire(
          'Cabeçalho incorreto!',
          'Dados não poderão ser incluídos pois o cabeçalho está incorreto...',
          'error'
          );
        </script>";
      }else{
        echo 
        "<script>
          Swal.fire(
          'Ocorreu algum problema!',
          'Algo está errado com seu arquivo de importação, favor verificar as mensagens e o inseri-lo corretamente.',
          'error'
          );
        </script>";
        echo $html; // Mostrando o problema direto na tabela
      }
    }else{
      echo $html; // Caso chegue aqui, está tudo OK para os inserts na tabela!
      $j = 0;
      foreach ($xlsx->rows() as $linha) { 
        if($j != 0){ // Pulando cabecalho
          $ean = $linha[0];
          $nome = utf8_decode($linha[1]); // Forçando UTF decode para nomes com nossa acentuação PT-BR
          $preco = $linha[2];
          $estoque = $linha[3];
          $data = $linha[4];
          if($data == "" || $data == false || $data == NULL){ // data pode ser nula!
            $data = NULL;
          }
          try{
          $stmt = $con->prepare("INSERT INTO produto (produto_ean, 
                                                      produto_nome, 
                                                      produto_preco, 
                                                      produto_estoque, 
                                                      produto_data_fabricacao) 
                                  VALUES (?,?,?,?,?);");
          $stmt->execute([$ean, $nome, $preco, $estoque, $data]);
          }catch(Exception $e){
              echo $e->getMessage();
          }
        }
        $j++;
      }

      echo 
        "<script>
          Swal.fire(
          'Produtos inseridos com sucesso!',
          'Os produtos foram inseridos corretamente, caso queira vê-los, ou editá-los, vá na aba \"Ver já importados\"!',
          'success'
          );
        </script>";
    }

  } else {
    echo SimpleXLSX::parseError();
  }
}
?>
</body>
