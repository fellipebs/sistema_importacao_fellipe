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
            );
            $('#myModal').modal('hide');
          }else{
            Swal.fire(
              'Algo ocorreu...',
              'Algum problema aconteceu...',
              'error'
            );
            $('#myModal').modal('hide');
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

function confirmarEdicao(){  // Validação para campos de edição
    if($("#ean").val() == "" || $("#ean").val() == undefined){
      Swal.fire(
        'Alerta!',
        'Favor digitar um EAN!',
        'warning'
      );
    }else if($("#nome").val() == "" || $("#nome").val() == undefined){
      Swal.fire(
        'Alerta!',
        'Favor digitar um nome!',
        'warning'
      );
    }else if($("#preco").val() == "" || $("#preco").val() == undefined){
      Swal.fire(
        'Alerta!',
        'Favor digitar um preço!',
        'warning'
      );
    }else if($("#estoque").val() == "" || $("#estoque").val() == undefined){
      Swal.fire(
        'Alerta!',
        'Favor digitar um estoque!',
        'warning'
      );
    }else{
      var idProd = $("#idProd").val();

      var ean = $("#ean").val();
      var nome = $("#nome").val();

      var preco = $("#preco").val(); // Convertendo formatação da moeda
      preco = preco.replace('.','');
      preco = preco.replace(',','.');

      var estoque = $("#estoque").val(); // Convertendo formatação da moeda
      estoque = estoque.replace('.','');
      estoque = estoque.replace(',','.');

      var data = $('#data').val();

      $.ajax({
        type: "POST",
        url: "auxiliares/edicao.php",
        data: { 
          idProd: idProd,
          ean: ean,
          nome: nome,
          preco: preco,
          estoque: estoque,               
          data: data
        },
        dataType: 'json',
        success: function(result) {  
          Swal.fire(
            'Tudo certo!',
            'O registro foi editado corretamente!',
            'success'
          );
          $("#tr_"+idProd).html(atob(result.html));
          $('#myModal').modal('hide');
        }
      });

    }
}



function b64DecodeUnicode(str) { // Decodificação para UTF-8!
  return decodeURIComponent(atob(str).split('').map(function(c) {
      return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
  }).join(''));
}


// Funções para máscaras de R$
String.prototype.reverse = function(){
  return this.split('').reverse().join(''); 
};

function mascaraMoeda(campo,evento){
  var tecla = (!evento) ? window.event.keyCode : evento.which;
  var valor  =  campo.value.replace(/[^\d]+/gi,'').reverse();
  var resultado  = "";
  var mascara = "##.###.###,##".reverse();
  for (var x=0, y=0; x<mascara.length && y<valor.length;) {
    if (mascara.charAt(x) != '#') {
      resultado += mascara.charAt(x);
      x++;
    } else {
      resultado += valor.charAt(y);
      y++;
      x++;
    }
  }
  campo.value = resultado.reverse();
}