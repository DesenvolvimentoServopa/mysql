<?php
switch ($_GET['tipo']) {
    case '1': //função
      $result = $conn->query($queryFuncao);
  
      $nome = "Função";
      $icone = "fas fa-users";
      break;
  
    case '2': //Departamento
      $result = $conn->query($queryDepartamento);
  
      $nome = "Departamento";
      $icone = "fas fa-address-card";
      break;
  
    case '3': //empresa
      $result = $conn->query($queryEmpresa);
  
      $nome = "Empresa";
      $icone = "fas fa-home";
      break;
    case '4': //Locação
      $result = $conn->query($queryLocacao);
  
      $nome = "Locação";
      $icone = "fas fa-warehouse";
      break;
  
    case '5': //Status Funcionario
      $result = $conn->query($queryStatusFuncionario);
  
      $nome = "Status Funcionário";
      $icone = "fas fa-user";
      break;
  
    case '6': //Equipamentos
      $result = $conn->query($queryEquipamentos);
  
      $nome = "Equipamentos";
      $icone = "fas fa-laptop";
      break;
  
    case '7': //Status Equipamento
      $result = $conn->query($queryStatusEquipamento);
  
      $nome = "Status Equipamento";
      $icone = "fas fa-laptop-code";
      break;
  
    case '8': //Situação
      $result = $conn->query($querySituacao);
  
      $nome = "Situação";
      $icone = "fas fa-star";
      break;
  
    case '9': //Estado
      $result = $conn->query($queryEstado);
  
      $nome = "Estado";
      $icone = "fas fa-magic";
      break;
  
    case '10': //Acessórios
      $result = $conn->query($queryAcessorios);
  
      $nome = "Acessórios";
      $icone = "fas fa-tag";
      break;
  
    case '11': //Operadora
      $result = $conn->query($queryOperadora);
  
      $nome = "Operadoras";
      $icone = "fas fa-sim-card";
      break;
  
    case '12': //Office
      $result = $conn->query($queryListOffice);
  
      $nome = "Office's";
      $icone = "fab fa-windows";
      break;
  
    case '13': //Windows
      $result = $conn->query($queryWindows);
  
      $nome = "Windows";
      $icone = "fab fa-microsoft";
      break;
  
    case '14': //Documentos
      $result = $conn->query($queryDocumentos);
  
      $nome = "Tipos Documentos";
      $icone = "fas fa-file";
      break;
  
    case '15': //Fornecedores
      $result = $conn->query($queryFornecedor);
  
      $nome = "Fornecedor";
      $icone = "fas fa-dolly-flatbed";
      break;
  }

  ?>