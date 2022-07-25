<?php
//USUÁRIOS DO SISTEMA
$queryUsuarios = "SELECT 
MP.id_profile,
MP.profile_name,
MP.profile_mail,
MP.profile_password,
MP.profile_type AS id_perfil,
MPT.type_name AS nome_perfil,
MP.profile_deleted,
MP.ativar_cpf,
MP.desativar_cpf,
MP.emitir_check_list,
MP.editar_historico,
MP.editar_cadastro_funcionario,
MP.color_header
FROM
manager_profile MP
LEFT JOIN
manager_profile_type MPT ON (MP.profile_type = MPT.type_profile)";

//COLABORADORES
$queryColaborador = "SELECT 
MIF.id_funcionario, 
MIF.nome, 
MIF.cpf,
MDF.nome AS funcao, 
MDD.nome AS departamento, 
MDE.nome AS empresa, 
MDS.nome AS status,
MIF.status AS id_status,
MIF.funcao AS id_funcao,
MIF.departamento AS id_departamento,
MIF.empresa AS id_empresa,
MIF.deletar
FROM
manager_inventario_funcionario MIF
LEFT JOIN
manager_dropfuncao MDF ON (MIF.funcao = MDF.id_funcao)
LEFT JOIN
manager_dropdepartamento MDD ON (MIF.departamento = MDD.id_depart)
LEFT JOIN
manager_dropempresa MDE ON (MIF.empresa = MDE.id_empresa)
LEFT JOIN
manager_dropstatus MDS ON (MIF.status = MDS.id_status)";

//EQUIPAMENTOS
$queryEquipamento = "SELECT 
MIF.id_funcionario,
MIF.nome AS nome,
MIF.cpf,
MDFU.nome AS funcao,
MIE.id_equipamento,
MIE.tipo_equipamento AS id_tipoEquipamento,
MIE.serialnumber,
MIE.hd,
MIE.processador,
MIE.memoria,
MDTE.nome AS tipo_equipamento,
MIE.modelo,
MIE.patrimonio,
MIE.filial AS id_filial,
MDL.nome AS empresa,
MDLC.nome AS locacao,
MIE.locacao AS id_locacao,
MIE.departamento AS id_departamento,
MDD.nome AS departamento,
MIE.operadora AS id_operadora,
MDO.nome AS operadora,
MIE.numero,
MIE.imei_chip,
MIE.planos_voz,
MIE.planos_dados,
MIE.valor,
MIE.fornecedor_scan,
MIE.data_fim_contrato,
MIE.numero_nota,
MIE.data_nota,
MIE.estado AS id_estado,
MDE.nome AS estado,
MIE.situacao AS id_situacao,
MDS.nome AS situacao,
MIE.status AS id_status,
MSE.nome AS status,
MIE.termo,
MIE.ip,
MIE.dominio,
MIE.liberado_rh,
MIE.hostname,
MSO.versao AS versao_so,
MSO.serial AS chave_windows,
MSO.id AS id_windows,
MOFF.versao AS versao_off,
MOFF.serial AS chave_office,
MOFF.id AS id_office
FROM
manager_inventario_equipamento MIE
LEFT JOIN
manager_dropempresa MDL ON (MIE.filial = MDL.id_empresa)
LEFT JOIN
manager_droplocacao MDLC ON (MIE.locacao = MDLC.id_empresa)
LEFT JOIN
manager_dropoperadora MDO ON (MIE.operadora = MDO.id_operadora)
LEFT JOIN
manager_dropestado MDE ON (MIE.estado = MDE.id)
LEFT JOIN
manager_dropsituacao MDS ON (MIE.situacao = MDS.id_situacao)
LEFT JOIN
manager_dropstatusequipamento MSE ON (MIE.status = MSE.id_status)
LEFT JOIN
manager_dropequipamentos MDTE ON (MIE.tipo_equipamento = MDTE.id_equip)
LEFT JOIN
manager_dropdepartamento MDD ON (MIE.departamento = MDD.id_depart)
LEFT JOIN
manager_inventario_funcionario MIF ON (MIE.id_funcionario = MIF.id_funcionario)
LEFT JOIN
manager_dropfuncao MDFU ON (MIF.funcao = MDFU.id_funcao)
LEFT JOIN
manager_sistema_operacional MSO ON (MIE.id_equipamento = MSO.id_equipamento)
LEFT JOIN
manager_office MOFF ON (MIE.id_equipamento = MOFF.id_equipamento)";

//STATUS ATIVO COUNT
$queryAtivosFuncionario = "SELECT 
COUNT(id_funcionario) status 
FROM 
manager_inventario_funcionario 
WHERE 
status = 4 AND 
deletar = 0 
GROUP BY status";

//STATUS FALTA TERMO COUNT
$queryTermoFuncionario = "SELECT 
COUNT(id_funcionario) status 
FROM 
manager_inventario_funcionario 
WHERE 
status = 3 AND 
deletar = 0 
GROUP BY status";

//STATUS DEMITIDO COUNT
$queryDemitidoFuncionario = "SELECT 
COUNT(id_funcionario) status 
FROM 
manager_inventario_funcionario 
WHERE
status = 8 AND 
deletar = 0 
GROUP BY status";

//EQUIPAMENTOS COUNT
$queryEquipamentosCount = "SELECT 
COUNT(*) AS quantidade, 
id_funcionario 
FROM 
manager_inventario_equipamento";

//LOGS FUNCIONARIOS
$queryLog = "SELECT 
ML.id,
ML.id_funcionario,
ML.id_equipamento, 
ML.data_alteracao, 
MIF.nome, 
MP.profile_name, 
ML.tipo_alteracao
FROM
manager_log ML
LEFT JOIN
manager_inventario_funcionario MIF ON (ML.id_funcionario = MIF.id_funcionario)
LEFT JOIN
manager_profile MP ON (ML.usuario = MP.id_profile)";

//SISTEMA OPERCIONAL
$queryso = "SELECT 
MSO.id,
MSO.versao AS id_versao, 
MDSO.nome AS versao,
MSO.serial,
MSO.file_nota AS caminho,
MSO.file_nota_nome AS nome,
MSO.data_nota AS data_nota,
MSO.id AS id_anexo,
MSO.empresa AS id_empresa,
MDE.nome AS empresa,
MSO.locacao AS id_locacao,
MDL.nome AS locacao,
MSO.numero_nota,
MSO.fornecedor
FROM
manager_sistema_operacional MSO
LEFT JOIN
manager_dropsistemaoperacional MDSO ON (MSO.versao = MDSO.id)
LEFT JOIN
manager_dropempresa MDE ON (MSO.empresa = MDE.id_empresa)
LEFT JOIN
manager_droplocacao MDL ON (MSO.locacao = MDL.id_empresa)";

//OFFICE
$queryoffice = "SELECT 
MO.id,
MO.id_equipamento,
MO.versao AS id_versao, 
MDO.nome AS versao,
MO.serial,
MO.fornecedor,
MO.file_nota AS caminho,
MO.file_nota_nome AS nome,
MO.data_nota AS data_nota,
MO.numero_nota,
MO.id AS id_anexo,
MO.empresa AS id_empresa,
MDE.nome AS empresa,
MO.locacao AS id_locacao,
MDL.nome AS locacao

FROM
manager_office MO
LEFT JOIN
manager_dropoffice MDO ON (MO.versao = MDO.id)
LEFT JOIN
manager_dropempresa MDE ON (MO.empresa = MDE.id_empresa)
LEFT JOIN
manager_droplocacao MDL ON (MO.locacao = MDL.id_empresa)";


//COLABORADORES PARA PDF
$queryColaboradorPDF = "SELECT 
MIF.id_funcionario, 
MIF.nome, 
MIF.cpf,
MDF.nome AS funcao, 
MDD.nome AS departamento, 
MDE.nome AS empresa, 
MDS.nome AS status,
MIF.status AS id_status,
MIF.funcao AS id_funcao,
MIF.departamento AS id_departamento,
MIF.empresa AS id_empresa,
MIF.deletar
FROM
manager_inventario_funcionario MIF
LEFT JOIN
manager_dropfuncao MDF ON (MIF.funcao = MDF.id_funcao)
LEFT JOIN
manager_dropdepartamento MDD ON (MIF.departamento = MDD.id_depart)
LEFT JOIN
manager_dropempresa MDE ON (MIF.empresa = MDE.id_empresa)
LEFT JOIN
manager_dropstatus MDS ON (MIF.status = MDS.id_status)
LEFT JOIN
manager_inventario_equipamento MIE ON (MIF.id_funcionario = MIE.id_funcionario)";

//DOCUMENTOS DIVERSOS FUNCIONÁRIO

$queryDocumento = "SELECT 
MIA.caminho,
MIA.nome,
MIA.data_criacao,
MIA.id_anexo,
MDD.nome AS tipo_documento,
MIE.fornecedor_scan AS fornecedor,
MIE.numero_nota,
MIE.data_nota
FROM
manager_inventario_anexo MIA
    LEFT JOIN
manager_dropdocumento MDD ON (MIA.tipo = MDD.id)
    LEFT JOIN
manager_inventario_equipamento MIE ON (MIA.id_equipamento = MIE.id_equipamento)";

//EQUIPAMENTO NO OCS

$query_ocs = "SELECT 
DISTINCT H.ID AS hardware_id,
H.WORKGROUP AS dominio,
AI.TAG AS patrimonio,
H.NAME AS hostname,
H.IPSRC AS ip,
B.SSN AS serial_number,
B.SMODEL AS modelo,
B.TYPE AS tipo_equipamento,
C.TYPE AS processador,
(SELECT SUM(DISKSIZE) FROM storages S WHERE H.id = S.HARDWARE_ID) AS hd,
(SELECT SUM(capacity) FROM memories M WHERE H.id = M.HARDWARE_ID) AS memoria,
H.OSNAME AS sistema_operacional,
H.WINPRODKEY AS chave_windows,
Ofi.PRODUCT AS office,
Ofi.OFFICEKEY AS chave_office
FROM
hardware H
LEFT JOIN
accountinfo AI ON H.id = AI.HARDWARE_ID
LEFT JOIN
cpus C ON H.ID = C.HARDWARE_ID
LEFT JOIN
bios B ON H.ID = B.HARDWARE_ID
LEFT JOIN
officepack Ofi ON H.ID = Ofi.HARDWARE_ID
LEFT JOIN
storages S ON H.ID = S.HARDWARE_ID";

//RELATÓRIO COLABORADOR
$queryRelColab = "SELECT 
MIF.nome,
MIF.cpf,
MDF.nome AS funcao,
MDD.nome AS departamento,
MDE.nome AS empresa,
MIF.status AS id_status,
MDS.nome AS status,
MIE.id_equipamento,
MDEQ.nome AS tipo_equipamento
FROM
manager_inventario_funcionario MIF
    LEFT JOIN
manager_dropfuncao MDF ON (MIF.funcao = MDF.id_funcao)
    LEFT JOIN
manager_dropdepartamento MDD ON (MIF.departamento = MDD.id_depart)
    LEFT JOIN
manager_dropempresa MDE ON (MIF.empresa = MDE.id_empresa)
    LEFT JOIN
manager_dropstatus MDS ON (MIF.status = MDS.id_status)
    LEFT JOIN
manager_inventario_equipamento MIE ON (MIF.id_funcionario = MIE.id_funcionario)
    LEFT JOIN
manager_dropequipamentos MDEQ ON (MIE.tipo_equipamento = MDEQ.id_equip)";

//TIPOS DE QUERY PARA RELATÓRIO

//colaborador
$whereColaborador = " WHERE ";

if (empty($_GET['funcao'])) {
    if (empty($_GET['departamento'])) {
        if (empty($_GET['empresa'])) {
            if (!empty($_GET['status'])) {
                $whereColaborador .= "MIF.status = " . $_GET['status'];
            }
        } else {
            $whereColaborador .= "MIF.empresa = '" . $_GET['empresa'] . "'";

            if (!empty($_GET['status'])) {
                $whereColaborador .= " AND MIF.status = " . $_GET['status'] . "";
            }
        }
    } else {
        $whereColaborador .= "MIF.departamento = '" . $_GET['departamento'] . "'";

        if (empty($_GET['empresa'])) {
            if (empty($_GET['status'])) {
            }
        } else {
            $whereColaborador .= " AND MIF.empresa = '" . $_GET['empresa'] . "'";
            if (empty($_GET['status'])) {
            } else {
                $whereColaborador .= " AND MIF.status= " . $_GET['status'] . "";
            }
        }
    }
} else {
    $whereColaborador .= "MIF.funcao = '" . $_GET['funcao'] . "'";

    if (empty($_GET['departamento'])) {
        if (empty($_GET['empresa'])) {
            if (empty($_GET['status'])) {
            } else {
                $whereColaborador .= " AND MIF.status= " . $_GET['status'] . "";
            }
        } else {
            $whereColaborador .= " AND MIF.empresa = '" . $_GET['empresa'] . "'";

            if (empty($_GET['status'])) {
            } else {
                $whereColaborador .= " AND MIF.status= " . $_GET['status'] . "";
            }
        }
    } else {
        $whereColaborador .= " AND MIF.departamento = '" . $_GET['departamento'] . "'";

        if (empty($_GET['empresa'])) {
            if (empty($_GET['status'])) {
            }
        } else {
            $whereColaborador .= " AND MIF.empresa = '" . $_GET['empresa'] . "'";

            if (empty($_GET['status'])) {
            } else {
                $whereColaborador .= " AND MIF.status= " . $_GET['status'] . "";
            }
        }
    }
}

//equipamento
$whereEquipamento = " WHERE ";

if (empty($_GET['tipoEquip'])) {

    if (empty($_GET['status'])) {

        if (!empty($_GET['empresa'])) {

            $whereEquipamento .= "MIE.filial =" . $_GET['empresa'];
        }
    } else {

        $whereEquipamento .= "MIE.status =" . $_GET['status'];

        if (!empty($_GET['empresa'])) {

            $whereEquipamento .= " AND MIE.filial =" . $_GET['empresa'];
        }
    }
} else {
    $whereEquipamento .= "MIE.tipo_equipamento =" . $_GET['tipoEquip'];

    if (empty($_GET['status'])) {

        if (!empty($_GET['empresa'])) {

            $whereEquipamento .= " AND MIE.filial =" . $_GET['empresa'];
        }
    } else {

        $whereEquipamento .= " AND MIE.status =" . $_GET['status'];

        if (!empty($_GET['empresa'])) {

            $whereEquipamento .= " AND MIE.filial =" . $_GET['empresa'];
        }
    }
}
