$(function() {
  $( "#userLanc" ).autocomplete({
    source: "../fun/funSearch.php?fun=users",
    minLength: 3,
    autoFocus:true,
    select: function( event, ui ) {
      $( "#userLanc" ).val( ui.item.label );
      $( "#IDuserLanc" ).val( ui.item.value );
      return false;
    }
  });
});


$(function() {
  $( "#txtBanco" ).autocomplete({
    source: "../fun/funSearch.php?fun=bancos",
    minLength: 3,
    autoFocus:true,
    select: function( event, ui ) {
      $( "#txtBanco" ).val( ui.item.label );
      $( "#banco" ).val( ui.item.value );
      return false;
    }
  });
});


$(function() {
  $( "#fornecedor" ).autocomplete({
    source: "../fun/funSearch.php?fun=fornecedores",
    minLength: 3,
    autoFocus:true,
    select: function( event, ui ) {
      $( "#fornecedor" ).val( ui.item.label);
      $( "#idfornecedor" ).val( ui.item.value );
      $( "#cnpjfornecedor" ).css("display", "block").html(ui.item.desc);

      if (ui.item.value == '000') {
        $('#modalNewFornecedor').modal('show');
      }

      return false;
    }
  });
});


$(function() {
  $( "#txtFilial" ).autocomplete({
    source: "../fun/funSearch.php?fun=filiais",
    minLength: 2,
    autoFocus:true,
    select: function( event, ui ) {
      $( "#txtFilial" ).val( ui.item.label );
      $( "#filial" ).val( ui.item.value );
      return false;
    }
  });
});


$(function() {
  $( "#txtFilialNota" ).autocomplete({
    source: "../fun/funSearch.php?fun=filiais",
    minLength: 2,
    autoFocus:true,
    select: function( event, ui ) {
      $( "#txtFilialNota" ).val( ui.item.label );
      $( "#filialNota" ).val( ui.item.value );
      return false;
    }
  });
});