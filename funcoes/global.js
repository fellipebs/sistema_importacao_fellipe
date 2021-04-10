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
        window.location.href = "sistema.php";
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

function logout(){
  Swal.fire({
    title: 'Deseja realmente sair?',
    text: "Você será deslogado do sistema!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar.',
    confirmButtonText: 'Sim, desejo!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "POST",
        url: "auxiliares/logout.php",
        data: { },
        dataType: 'json',
        success: function(result) {  
          window.location.href = "index.php";
        }
      });
    }
  })
}



function excluir(id){
  Swal.fire({
    title: 'Deseja realmente excluir o produto?',
    text: "Após a exclusão sua ação não poderá ser revertida!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar.',
    confirmButtonText: 'Sim, desejo!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "POST",
        url: "auxiliares/exclusao.php",
        data: { 
          id: id
        },
        dataType: 'json',
        success: function(result) {  
          Swal.fire(
            'Tudo certo!',
            'O registro foi excluido corretamente!',
            'success'
          );
          $("#tr_"+id).remove();
        }
      });
    }
  })
}

function editar(id){
  $.ajax({
    type: "POST",
    url: "auxiliares/edicao.php",
    data: { 
      id: id
    },
    dataType: 'json',
    success: function(result) {  
      $('#corpoModal').html(b64DecodeUnicode(result.html));
    }
  });
}


function b64DecodeUnicode(str) { // Decodificação para UTF-8!
  return decodeURIComponent(atob(str).split('').map(function(c) {
      return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
  }).join(''));
}