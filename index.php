<!doctype html>
<html lang="en">
  <head>
    <!-- Meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS do Bootstrap -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap-4.6.0-dist/css/bootstrap.min.css">
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="bootstrap-4.6.0-dist/js/bootstrap.min.js"></script>
    
    <!-- CSS da página feito por mim! -->
    <link rel="stylesheet" href="css_principal/style.css">

    <title>Login!</title>
  </head>
  <body>
    <div class='container-fluid'>
    <form action=''>
        <div class='row'>
            <div class='col-md-4'></div>
            <div class='col-md-4'>
                <center><img src='img/avatar.png' id='imgAvatar'></center>
                <br>
                <label>Digite seu login:</label>
                <input type='text' name='login' id='login' class='form-control' required>
                <label>Digite sua senha:</label>
                <input type='password' name='senha' id='senha' class='form-control' required>
                <a href='' data-toggle="modal" data-target="#myModal">Caso não possua login, clique aqui para fazer seu cadastro!</a>
                <button class='btn btn-primary' id='btnEntra'>Entrar</button>
            </div>
        </div>
        </form>
    </div>
  </body>
</html>


<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Cadastro de usuário</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
        <label>Digite seu nome:</label>
        <input type='text' name='nomeCad' id='nomeCad' class='form-control' required>
        <label>Digite seu login:</label>
        <input type='text' name='loginCad' id='loginCad' class='form-control' required>
        <label>Digite sua senha:</label>
        <input type='password' name='senhaCad' id='senhaCad' class='form-control' required>
        <label>Confirme sua senha:</label>
        <input type='password' name='senhaCadConfirma' id='senhaCadConfirma' class='form-control' required>
        <label>Caso deseje uma foto de perfil, basta anexa-la:</label>
        <input type='file' accept='.png, .jpg'>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success btn-block ml-1" id='btnConfirmar'>Confirmar</button>
        </div>
      </div>
    </div>
  </div>