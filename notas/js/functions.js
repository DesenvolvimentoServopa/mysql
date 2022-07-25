




////////////////////// FUNCOES GERAIS  /////////////////////////







function funTipoDespesa($id) {
	$.ajax({
		type: 'GET',
		url: '../fun/functions.php?function=funTipoDespesa',
		success: function(data) {
			// Adiciona a primeira linha.
			$($id).append($('<option>', {
			  value: '',
			  text: 'Selecione um tipo de despesa'
			}));

			torneios = JSON.parse(data);

			// Adiciona as demais linhas (dinâmico).
			$.each(torneios, function(id, torneio) {
			  $($id).append($('<option>', {
			      value: torneio.ID,
			      text: torneio.nome
			  }));
			});
		}
	});
}

function funPeriodicidade($id) {
	$.ajax({
		type: 'GET',
		url: '../fun/functions.php?function=funPeriodicidade',
		success: function(data) {
			// Adiciona a primeira linha.
			$($id).append($('<option>', {
			  value: '',
			  text: 'Selecione um período'
			}));

			torneios = JSON.parse(data);

			// Adiciona as demais linhas (dinâmico).
			$.each(torneios, function(id, torneio) {
			  $($id).append($('<option>', {
			      value: torneio.ID,
			      text: torneio.nome
			  }));
			});
		}
	});
}

function funTipoPgto($id) {
	$.ajax({
		type: 'GET',
		url: '../fun/functions.php?function=funTipoPgto',
		success: function(data) {
			// Adiciona a primeira linha.
			$($id).append($('<option>', {
			  value: '',
			  text: 'Selecione o tipo de pagamento'
			}));

			torneios = JSON.parse(data);

			// Adiciona as demais linhas (dinâmico).
			$.each(torneios, function(id, torneio) {
			  $($id).append($('<option>', {
			      value: torneio.ID,
			      text: torneio.nome
			  }));
			});
		}
	});
}

$("#tipoPgto").change(function(){
	if($("#tipoPgto").val() == '2'){
		$("#dep").css("display", "block");
	}else{
		$("#dep").css("display", "none");
	}
});


/* Máscaras ER */
function mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}
function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}
function mtel(v){
    v=v.replace(/\D/g,""); //Remove tudo o que não é dígito
    v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
    v=v.replace(/(\d)(\d{4})$/,"$1-$2"); //Coloca hífen entre o quarto e o quinto dígitos
    return v;
}
function id( el ){
	return document.getElementById( el );
}
window.onload = function(){
	id('telefone').onkeyup = function(){
		mascara( this, mtel );
	}
}







////////////////////// RATEIO FORNECEDOR  /////////////////////////









$("#txtFilial").change(function(){
	
	$("#selectCC").empty();

	var $idfilial = $("#filial").val();

	$.ajax({
	  type: 'GET',
	  url: '../fun/functions.php?function=funRetornaCC&idfilial='+$idfilial,
	  success: function(data) {
	    // Adiciona a primeira linha.
	    $("#selectCC").append($('<option>', {
	      value: -1,
	      text: 'Selecione um Centro de Custo'
	    }));

	    torneios = JSON.parse(data);

	    // Adiciona as demais linhas (dinâmico).
	    $.each(torneios, function(id, torneio) {
	      $("#selectCC").append($('<option>', {
	          value: torneio.ID+'_'+torneio.nome,
	          text: torneio.nome
	      }));
	    });
	  }
	});

	$.post("../fun/functions.php?function=funCheckConsorcio",
    {
        idfilial: $idfilial
    },
    function(data,status){
        if(data == 1){
			$("#cons").css("display", "block");
		}else if(data == 0){
			$("#cons").css("display", "none");
		}
    });

});







////////////////////////// EDIT RATEIO FORNECEDOR  /////////////////////////









function editRateioFornecedor($idrateiofornecedor){

	$.post("../fun/funRateioFornecedor.php?fun=editarRateioFornecedor",
	{
		idusuario: $('#IDuserLanc').val(),
		idfornecedor: $('#idfornecedor').val(),
		filial: $('#filial').val(),
		periodicidade: $('#periodicidade').val(),
		tipodespesa: $('#tipoDespesa').val(),
		obs: $('#obs').val(),
		tipoPgto: $('#tipoPgto').val(),
		banco: $('#banco').val(),
		ag: $('#ag').val(),
		conta: $('#conta').val(),
		digito: $('#digito').val(),
		nfDptoAudi: $("[type=radio][name=nfDptoAudi]:checked").val(),
		nfObras: $("[type=radio][name=nfObras]:checked").val(),
		conferencia: $("[type=radio][name=conferencia]:checked").val(),
		relSiscon: $("[type=radio][name=relSiscon]:checked").val(),
		motivoSiscon: $('#motivoSiscon').val(),
		vencRateio: $('#vencRateio').val(),
		vencRateioTipo: $("[type=radio][name=vencRateioTipo]:checked").val(),
		telefone: $('#telefone').val(),
		idrateiofornecedor: $idrateiofornecedor,
		tipo_serv: $('#tipo_serv').val(),
		

	},
	function(data,status){
		window.location.href = 'rateioFornecedor.php?msn=3';
	});
}


function retornaCentroC(){
  $("#selectCC").empty();

  var $idfilial = $("#filial").val();

  $.ajax({
    type: 'GET',
    url: '../fun/functions.php?function=funRetornaCC&idfilial='+$idfilial,
    success: function(data) {
      // Adiciona a primeira linha.
      $("#selectCC").append($('<option>', {
        value: -1,
        text: 'Selecione um Centro de Custo'
      }));

      torneios = JSON.parse(data);

      // Adiciona as demais linhas (dinâmico).
      $.each(torneios, function(id, torneio) {
        $("#selectCC").append($('<option>', {
            value: torneio.ID+'_'+torneio.nome,
            text: torneio.nome
        }));
      });
    }
  });


  $.post("../fun/functions.php?function=funCheckConsorcio",
    {
        idfilial: $idfilial
    },
    function(data,status){
        if(data == 1){
	      $("#cons").css("display", "block");
	    }else if(data == 0){
	      $("#cons").css("display", "none");
	    }
  });
}

function funRetornaRateioPercentual($id) {

	$.post('../fun/functions.php?function=funRetornaRateioPercentual&idrateiofornecedor='+$id,
	{},
	function(data,status){
	    
	      $("#retornoRATEIO").html(data);

	});

}







/////////////////////////////// LANC NOTA  /////////////////////////////////











function funRetornaFornecedor($idfornecedor,$idfilial,$idusuario,$tipo_serv) {

	$.post("../fun/functions.php?function=funRetornaFornecedor",
	{
		idfornecedor: $idfornecedor,
		idfilial: $idfilial,
		idusuario: $idusuario,
		tipo_serv: $tipo_serv,
	},
	function(data,status){

		if (data !== 'erro') {
			$("#msgrateio").css("display", "none");
			$("#rateio").css("display", "block");

			torneios = JSON.parse(data);

			// Adiciona as demais linhas (dinâmico).
			$.each(torneios, function(id, torneio) {
				$('#tipoPgto').find('option[value="'+torneio.TIPOPGTO+'"]').attr('selected','selected');
				$('#periodicidade').find('option[value="'+torneio.PERIODICIDADE+'"]').attr('selected','selected');
				$('#tipoDespesa').find('option[value="'+torneio.TIPODESPESA+'"]').attr('selected','selected');
				$('#obs').html(torneio.OBSERVACAO);
				$('input[name=nfDptoAudi][value=' + torneio.AUDITORIA + ']').prop('checked', true);
				$('input[name=nfObras][value=' + torneio.OBRA + ']').prop('checked', true);
				$('#banco').val(torneio.BANCO);
				$('#txtBanco').val(torneio.BANCO);
				$('#ag').val(torneio.AGENCIA);
				$('#conta').val(torneio.CONTA);
				$('#digito').val(torneio.DIGITO);
				$('#motivoSiscon').val(torneio.MOTIVO);
				$('input[name=relSiscon][value=' + torneio.RELSISCON + ']').prop('checked', true);
				$('#cnpjfornecedor2').val(torneio.CNPJ);
				$('#idrateiofornecedor').val(torneio.ID);
				$('#telefone').val(torneio.TELEFONE);
				if(torneio.TIPOPGTO == '2'){
					$("#dep").css("display", "block");
				}else{
					$("#dep").css("display", "none");
				}

			});

		}else{

			$("#msgrateio").css("display", "block");
			$("#rateio").css("display", "none");

			if ($('#tipoPgto').val() != '') {
				limpaPgto();
			}

			if ($('#periodicidade').val() != '') {
				limpaPerio();
			}

			if ($('#tipoDespesa').val() != '') {
				limpaDesp();
			}

			$('#obs').html('');
			$('#telefone').val('');

			$('input[name=nfDptoAudi]').removeAttr("checked");
			$('input[name=nfObras]').removeAttr("checked");

			$('#banco').val('');
			$('#txtBanco').val('');
			$('#ag').val('');
			$('#conta').val('');
			$('#digito').val('');
			$('#motivoSiscon').val('');
			$('input[name=relSiscon]').removeAttr("checked");

			$('#cnpjfornecedor2').val('');
			$('#idrateiofornecedor').val('');

			if($("#tipoPgto").val() == '2'){
				$("#dep").css("display", "block");
			}else{
				$("#dep").css("display", "none");
			}
		}

	    if($("#idrateiofornecedor").val() != ''){       
	      $("#numeroNota").focus();
	    }

	});
}

function funRetornaRateioLanc() {
	$.post("../fun/functions.php?function=funRetornaRateio",
	{
		idrateiofornecedor: $("#idrateiofornecedor").val(),
		valor: $("#valorNota").val(),
	},
	function(data,status){

		if (data.search("Fatal error") < 1) {
			$("#retorno").html(data);
			calcRateioNota();
		}

	});
}

function calcRateioNota(){

	if ( $.fn.dataTable.isDataTable( '#dtRateioLanc' ) ) {
      	table = $('#dtRateioLanc').DataTable();
    }else{
		table = $('#dtRateioLanc').DataTable( { 
		retrieve: true,
		paging: false,
		ordering: false,
		info:     false,
		filter:   false
		} );
    }

    table.destroy();

	var data = table.$('input').serializeArray();
	var ids = [];
	var valores = [];
	$.each(data, function(i, field){
		if (field.name =="id") {
			ids.push(field.value);
		}else if(field.name =="valor"){
			valores.push(field.value);
		}
	});
	var result =  valores.reduce(function(result, field, index) {
		result[ids[index]] = field;
		return result;
	}, {});   


	$.post("../fun/funLancNota.php?fun=armazenaRateioSessao",
    {
        dadosrateio: result
    },
    function(data,status){
        
    });
}



function limpaPgto(){
	$('#tipoPgto').find("option:selected").removeAttr("selected");
	$('#tipoPgto').empty();
	funTipoPgto('#tipoPgto');
}

function limpaPerio(){
	$('#periodicidade').find("option:selected").removeAttr("selected");
	$("#periodicidade").empty();
	funPeriodicidade('#periodicidade');
}

function limpaDesp(){
	$('#tipoDespesa').find("option:selected").removeAttr("selected");
	$("#tipoDespesa").empty();
	funTipoDespesa('#tipoDespesa');
}




///////////////////////////// EDIT NOTA ////////////////////////////////









function funRetornaRateioEdit() {
	$.post("../fun/functions.php?function=funRetornaRateio",
	{
		idrateiofornecedor: $("#idrateiofornecedor").val(),
		valor: $("#valorNotaEdit").val(),
	},
	function(data,status){
		if (data.search("Fatal error") < 1) {
			$("#retorno").html(data);
		}else{
			$("#rateio").css("display", "none");
		}
	});
}


function funCheckConsorcioEdit() {
	$.post("../fun/functions.php?function=funCheckConsorcio",
	{
		idfilial: $('#filialNota').val()
	},
	function(data,status){
		if(data == 1){
			$("#cons").css("display", "block");
		}else if(data == 0){
			$("#cons").css("display", "none");
		}
	});
}



function editNota($idnota){

	table = $('#dtRateioEdit').DataTable();
	var data = table.$('input').serializeArray();
	var ids = [];
	var valores = [];
	$.each(data, function(i, field){
		if (field.name =="id") {
			ids.push(field.value);
		}else if(field.name =="valor"){
			valores.push(field.value);
		}
	});
	var result =  valores.reduce(function(result, field, index) {
		result[ids[index]] = field;
		return result;
	}, {}); 

	if($('#carimbo').prop("checked")){
		vCarimbo = 1;
	}else{
		vCarimbo = 0;
	}


	$.post("../fun/funLancNota.php?fun=editarnota",
	{
		dados: result,
		idnota: $idnota,
		idusuario: $('#IDuserLanc').val(),
		cnpjfornecedor: $('#cnpjfornecedor').text(),
		idrateiofornecedor: $('#idrateiofornecedor').val(),
		filialEdit: $('#filialNota').val(),

		periodicidadeEdit: $('#periodicidadeEdit').val(),
		tipoDespesaEdit: $('#tipoDespesaEdit').val(), 
		obsEdit: $('#obsEdit').val(),
		tipoPgtoEdit: $('#tipoPgtoEdit').val(),

		bancoEdit: $('#banco').val(),
		agEdit: $('#agEdit').val(),
		contaEdit: $('#contaEdit').val(),
		digitoEdit: $('#digitoEdit').val(),

		nfDptoAudiEdit: $("[type=radio][name=nfDptoAudiEdit]:checked").val(),
		nfObrasEdit: $("[type=radio][name=nfObrasEdit]:checked").val(),

		carimbo: vCarimbo,

		relSisconEdit: $("[type=radio][name=relSisconEdit]:checked").val(),
		motivoSisconEdit: $('#motivoSisconEdit').val(),

		numeroNotaEdit: $('#numeroNotaEdit').val(),
		serieNotaEdit: $('#serieNotaEdit').val(),
		emissaoNotaEdit: $('#emissaoNotaEdit').val(),
		vencNotaEdit: $('#vencNotaEdit').val(),
		valorNotaEdit: $('#valorNotaEdit').val(),
		telefone: $('#telefone').val(),
		tipo_serv: $('#tipo_serv').val()


	},
	function(data,status){

		sendFormData2(data);
		//alert(data);
	});
}

function sendFormData2($anexoName){

	var formData = new FormData($("#formAnexos").get(0));

	formData.append("anexoname", $anexoName);
	
	var ajaxUrl = "../fun/upload2.php";

	$.ajax({
		url : ajaxUrl,
		type : "POST",
		data : formData,
		// both 'contentType' and 'processData' parameters are
		// required so that all data are correctly transferred
		contentType : false,
		processData : false
	}).done(function(response){
		// In this callback you get the AJAX response to check
		// if everything is right...
		
		window.location.href = '../index.php?msn=3';

	}).fail(function(){
		// Here you should treat the http errors (e.g., 403, 404)
	}).always(function(){
		// alert("AJAX request finished!");
	});
}