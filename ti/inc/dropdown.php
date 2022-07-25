<?php
//perfil
$queryPerfil = "SELECT * FROM manager_profile_type";

//função
$queryFuncao = "SELECT id_funcao AS id, nome FROM manager_dropfuncao WHERE deletar = '0' ORDER BY nome ASC";

//Departamento
$queryDepartamento = "SELECT id_depart AS id, nome FROM manager_dropdepartamento WHERE deletar = 0 ORDER BY nome ASC";

//Empresa
$queryEmpresa = "SELECT id_empresa AS id, nome FROM manager_dropempresa WHERE deletar = 0 ORDER BY nome ASC";

//Locacao
$queryLocacao = "SELECT id_empresa AS id, nome FROM manager_droplocacao WHERE deletar = 0 ORDER BY nome ASC";

//Status Funcionario
$queryStatusFuncionario = "SELECT id_status AS id, nome FROM manager_dropstatus WHERE deletar = 0";

//Equipamento
$queryEquipamentos = "SELECT id_equip AS id, nome FROM manager_dropequipamentos WHERE deletar = 0";

//Status Equipamento
$queryStatusEquipamento = "SELECT id_status AS id, nome FROM manager_dropstatusequipamento WHERE deletar = 0 ORDER BY nome ASC";

//Situacao
$querySituacao = "SELECT id_situacao AS id, nome FROM manager_dropsituacao WHERE deletar = 0";

//Estado
$queryEstado = "SELECT id, nome FROM manager_dropestado WHERE deletar = 0";

//Acessorios
$queryAcessorios = "SELECT id_acessorio AS id, nome FROM manager_dropacessorios WHERE deletar = 0";

//Operadora
$queryOperadora = "SELECT id_operadora AS id, nome FROM manager_dropoperadora WHERE deletar = 0 ORDER BY nome ASC";

//Office
$queryListOffice = "SELECT id, nome FROM manager_dropoffice WHERE deletar = 0";

//Windows
$queryWindows = "SELECT id, nome FROM manager_dropsistemaoperacional WHERE deletar = 0";

//Documentos
$queryDocumentos = "SELECT id, nome FROM manager_dropdocumento WHERE deletar = 0";

//Fornecedores
$queryFornecedor = "SELECT id_fornecedor as id, nome FROM manager_dropfornecedor WHERE deletar = 0 ORDER BY nome";
?>