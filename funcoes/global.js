function cadastrar(){
    var nome = $('#nomeCad').val();
    var email = $('#emailCad').val();
    var senha = $('#senhaCad').val();
    var confirmaSenha = $('#senhaCadConfirma').val();

    if(nome == ""){
        Swal.fire({
            title: 'Alerta!',
            text: 'Nome não preenchido corretamente!',
            icon: 'warning',
            confirmButtonText: 'Continuar'
          });
    }else if(email == ""){
        Swal.fire({
            title: 'Alerta!',
            text: 'Email não preenchido corretamente!',
            icon: 'warning',
            confirmButtonText: 'Continuar'
          });
    }else if(senha == ""){
        Swal.fire({
            title: 'Alerta!',
            text: 'Senha não preenchido corretamente!',
            icon: 'warning',
            confirmButtonText: 'Continuar'
          });
    }else if(confirmaSenha == ""){
        Swal.fire({
            title: 'Alerta!',
            text: 'Confirmação de senha não preenchido corretamente!',
            icon: 'warning',
            confirmButtonText: 'Continuar'
          });
    }else if(senha != confirmaSenha){
        Swal.fire({
            title: 'Alerta!',
            text: 'Senha e confirmação não conferem!',
            icon: 'warning',
            confirmButtonText: 'Continuar'
          });
    }else{ //Caso chegue aqui, as validações iniciais foram supridas!
      $.ajax({
        type: "POST",
        url: "auxiliares/cadastro_usuario.php",
        data: {
          'nome': nome,
          'email': email,
          'senha': senha,
          'confirmaSenha': confirmaSenha
        },
        dataType: 'json',
        success: function(result) {
          if(result.resp == true){
            Swal.fire(
            'Tudo certo!',
            'Usuário cadastrado com sucesso!',
            'success'
            )
          }else{
            Swal.fire(
              'Algo ocorreu...',
              'Algum problema aconteceu...',
              'error'
            )
          }
        }
      });
    }
}

function login(){
  var email = $('#email').val();
  var senha = $('#senha').val();

  $.ajax({
    type: "POST",
    url: "auxiliares/autenticacao_usuario.php",
    data: {
      'email': email,
      'senha': senha
    },
    dataType: 'json',
    success: function(result) {
      if(result.resp == true){
        window.location.href = "sistema.php"
      }else{
        Swal.fire(
          'Alerta!',
          'Login ou senha incorretos!',
          'warning'
        )
      }
    }
  });
 
}
