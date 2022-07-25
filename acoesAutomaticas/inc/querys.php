<?php
require_once('../db/connSqlServer.php');
require_once('../db/conexao.php');

$queryV_func = "SELECT nomfun, numcpf, emacom, dessit FROM Vetorh.dbo.v_func";

$tabelaVetor = "CREATE TABLE vetor_users (
    id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(100) NULL,
    usuario VARCHAR(100) NULL,
    email VARCHAR(100) NULL,
    dessit VARCHAR(100) NULL,    
    PRIMARY KEY (id))";

$tabelaSelbetti = "CREATE TABLE selbetti_users (
    id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(100) NULL,
    usuario VARCHAR(100) NULL,
    email VARCHAR(100) NULL,
    stAtivo VARCHAR(100) NULL, 
    idTipoUsuario VARCHAR(100) NULL,
    cdUsuario VARCHAR(100) NULL,
    PRIMARY KEY (id))";

$tabelaRelatorio = "CREATE TABLE relatorio_users (
    id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(100) NULL,
    usuario VARCHAR(100) NULL,
    email VARCHAR(100) NULL,
    dessit VARCHAR(100) NULL,  
    PRIMARY KEY (id))";

$tabelaRelatorioDemitidos = "CREATE TABLE relatorio_demitidos (
    id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(100) NULL,
    usuario VARCHAR(100) NULL,
    email VARCHAR(100) NULL,
    PRIMARY KEY (id))";
    
$dropSelbetti = "DROP TABLE selbetti_users";

$dropVetor = "DROP TABLE vetor_users";

$dropRelatorioUsers = "DROP TABLE relatorio_users";

$dropRelatorioDemitidos = "DROP TABLE relatorio_demitidos";

$queryVetorUsers = "SELECT * FROM vetor_users;";

$queryRelatorioUsers = "SELECT * FROM relatorio_users ";

$querySelbettiDemitidos = "SELECT * FROM selbetti_users";

$queryDemitidos = "SELECT * FROM selbetti_users WHERE stAtivo = '0' order by usuario ASC";

$selectDemitidos = "SELECT * FROM relatorio_demitidos";




