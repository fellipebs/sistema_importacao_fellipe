<?php
include('../conexao/conexao.php');

$consulta = $pdo->query("SELECT nome, usuario FROM login;"); // Continuar daqui amanhã

while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
    echo "Nome: {$linha['nome']} - Usuário: {$linha['usuario']}<br />";
}

?>