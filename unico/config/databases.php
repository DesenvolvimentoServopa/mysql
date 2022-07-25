<?php

	//SERVIDOR UNICO
	$ipservidorUnico = "#";	
	$portaUnico = "#";
	$userUnico = "#";
	$passUnico = "##";
	$dbnameUnico = "#";

	//SERVIDOR NOTAS
	$ipservidorNotas = "#";	
	$portaNotas = "#";
	$userNotas = "#";
	$passNotas = "##";
	$dbnameNotas = "#";

	//SERVIDOR LOCAL(UNICO)
	$ipservidorLocal = "#";	
	$portaLocal = "#";
	$userLocal = "#";
	$passLocal = "#";
	$dbnameLocal = "#";

	// ########### UNICO ###########
	$conn = new mysqli($ipservidorUnico, $userUnico, $passUnico, $dbnameUnico, $portaUnico);
	if ($conn->connect_error) {
		die("ERRO CONEXÂO SERVIDOR UNICO: " . $conn->connect_error);
	}

	// ########### DBNOTAS ###########
	$connNOTAS = new mysqli($ipservidorNotas, $userNotas, $passNotas, $dbnameNotas, $portaNotas);
	if ($connNOTAS->connect_error) {
		die("ERRO CONEXÂO SERVIDOR DBNOTAS: " . $connNOTAS->connect_error);
	}

	// ########### LOCAL - UNICO ###########
	$connLOCALUnico = new mysqli($ipservidorLocal, $userLocal, $passLocal, $dbnameLocal, $portaLocal);
	if ($connLOCALUnico->connect_error) {
		die("ERRO CONEXÂO SERVIDOR LOCAL-UNICO: " . $connLOCALUnico->connect_error);
	}
	
?>







