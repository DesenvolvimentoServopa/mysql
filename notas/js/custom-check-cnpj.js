function funCheckDuplicidadeCNPJfilial($cnpj) {
  $.post("../fun/funFilial.php?fun=checkfilial",
  {
    cnpjFilial: $cnpj,
  },
  function(data,status){
    if(data == 'duplicado'){
      alert("CNPJ já existente!");
    }
  });
}

function funCheckDuplicidadeCNPJfornecedor($cnpj) {
  $.post("../fun/funFornecedor.php?fun=checkfornecedor",
  {
    cnpjFornecedor: $cnpj,
  },
  function(data,status){
    if(data == 'duplicado'){
        alert("CNPJ já existente!");
    }
  });
}

function validarCNPJ(cnpj) {

  cnpj = cnpj.replace(/[^\d]+/g,'');

  if(cnpj == '') return false;
   
  if (cnpj.length != 14)
      return false;

  // Elimina CNPJs invalidos conhecidos
  if (cnpj == "00000000000000" || 
      cnpj == "11111111111111" || 
      cnpj == "22222222222222" || 
      cnpj == "33333333333333" || 
      cnpj == "44444444444444" || 
      cnpj == "55555555555555" || 
      cnpj == "66666666666666" || 
      cnpj == "77777777777777" || 
      cnpj == "88888888888888" || 
      cnpj == "99999999999999")
      return false;
       
  // Valida DVs
  tamanho = cnpj.length - 2
  numeros = cnpj.substring(0,tamanho);
  digitos = cnpj.substring(tamanho);
  soma = 0;
  pos = tamanho - 7;
  for (i = tamanho; i >= 1; i--) {
    soma += numeros.charAt(tamanho - i) * pos--;
    if (pos < 2)
          pos = 9;
  }
  resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
  if (resultado != digitos.charAt(0))
      return false;
       
  tamanho = tamanho + 1;
  numeros = cnpj.substring(0,tamanho);
  soma = 0;
  pos = tamanho - 7;
  for (i = tamanho; i >= 1; i--) {
    soma += numeros.charAt(tamanho - i) * pos--;
    if (pos < 2)
          pos = 9;
  }
  resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
  if (resultado != digitos.charAt(1))
        return false;
         
  return true;
  
}

$("#cpfcnpj").on("blur", function(e){

  if ($(this).val().length == 11) {
    $(this).val(
      $(this).val()
      .replace(/\D/g, '')
      .replace(/^(\d{3})(\d{3})?(\d{3})?(\d{2})?/, "$1.$2.$3-$4"));

    funCheckDuplicidadeCNPJfornecedor($("#cpfcnpj").val());

  }else if ($(this).val().length >= 14) {
    $(this).val(
      $(this).val()
      .replace(/\D/g, '')
      .replace(/^(\d{2})(\d{3})?(\d{3})?(\d{4})?(\d{2})?/, "$1.$2.$3/$4-$5")); 

    if (validarCNPJ($("#cpfcnpj").val()) == false && $("#cpfcnpj").val() !== '') {
      alert("CNPJ inválido!");
    }

    funCheckDuplicidadeCNPJfornecedor($("#cpfcnpj").val());

  }

});

