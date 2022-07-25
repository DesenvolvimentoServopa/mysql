<?php

switch ($log['tipo_alteracao']) {
    case '0':
      $idLog = 'Edição de Cadastro';
      break;

    case '1':
      $idLog = 'Liberou Check-List';
      break;

    case '2':
      $idLog = 'Emitido Check-List';
      break;

    case '3':
      $idLog = 'Emitido Termo';
      break;

    case '4':
      $idLog = 'Vinculado Equipamento';
      break;

    case '5':
      $idLog = 'Retirado Equipamento';
      break;

    case '6':
      $idLog = 'Documento Anexado';
      break;

    case '7':
      $idLog = 'Documento Excluido';
      break;

    case '8':
      $idLog = 'Inserido Histórico';
      break;

    case '9':
      $idLog = 'Excluido Histórico';
      break;

    case '10':
      $idLog = 'Editado Histórico';
      break;

    case '11':
      $idLog = 'Desativado';
      break;

    case '12':
      $idLog = 'Ativado';
      break;

    case '13':
      $idLog = 'Novo';
      break;

    case '14':
      $idLog = 'Removido Office';
      break;

    case '15':
      $idLog = 'Adicionado Office';
      break;

    case '16':
      $idLog = 'Removido Windows';
      break;

    case '17':
      $idLog = 'Adicionado Windows';
      break;
  }