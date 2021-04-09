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

<div class='container-fluid'>

</div>