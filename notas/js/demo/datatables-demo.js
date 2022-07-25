// Call the dataTables jQuery plugin
$(document).ready(function() {

	$('#dtUsuario').DataTable( {

        ajax: {
	        url: '../fun/funUsers.php?fun=listar',
	        dataSrc: ''
	    },
	    language: {
	        url: 'https://cdn.datatables.net/plug-ins/1.10.24/i18n/Portuguese-Brasil.json'
	    }
	});

	$('#dtCentroCusto').DataTable( {
	    language: {
	        url: 'https://cdn.datatables.net/plug-ins/1.10.24/i18n/Portuguese-Brasil.json'
	    }
	});

	$('#dtFilial').DataTable( {

        ajax: {
	        url: '../fun/funFilial.php?fun=listarFiliais',
	        dataSrc: ''
	    },
	    language: {
	        url: 'https://cdn.datatables.net/plug-ins/1.10.24/i18n/Portuguese-Brasil.json'
	    }
	});

	$('#dtFornecedores').DataTable( {

        ajax: {
	        url: '../fun/funFornecedor.php?fun=listarfornecedores',
	        dataSrc: ''
	    },
	    language: {
	        url: 'https://cdn.datatables.net/plug-ins/1.10.24/i18n/Portuguese-Brasil.json'
	    }
	});


	$('#dtWorkflow').DataTable( {

        ajax: {
	        url: '../fun/funWorkflow.php?fun=listarworkflows',
	        dataSrc: ''
	    },
	    language: {
	        url: 'https://cdn.datatables.net/plug-ins/1.10.24/i18n/Portuguese-Brasil.json'
	    }
	});

	$('#dtRateioFornecedor').DataTable( {

        ajax: {
	        url: '../fun/funRateioFornecedor.php?fun=listarRateioFornecedor',
	        dataSrc: ''
	    },
	    language: {
	        url: 'https://cdn.datatables.net/plug-ins/1.10.24/i18n/Portuguese-Brasil.json'
	    }
	});

});
