<?php
/* ini_set('display_errors', 1);
error_reporting(E_ALL); */

require_once('../bd/conexao.php');
require_once('header.php');
require_once('../inc/dropdown.php');
require_once('../inc/pesquisas.php');
require_once('../inc/permissoes.php');


//QUERY PARA O TERMO DE RESPONSABILIDADE
$query = " WHERE MIE.id_equipamento = " . $_GET['id_equip'] . "";

//EQUIPAMENTO
$queryEquipamento .= $query;
$resultEquipamento = $conn->query($queryEquipamento);
$equip = $resultEquipamento->fetch_assoc();

//possui office?
if (empty($equip['versao_off'])) {
  $incluirOfficeDisplay = $equip['id_tipoEquipamento'] == 8 || $equip['id_tipoEquipamento'] == 9 ? 'inline-block' : 'none';
} else {
  $incluirOfficeDisplay = 'none';
}

//possui windows?
if (empty($equip['versao_so'])) {
  $incluirWindowsDisplay = $equip['id_tipoEquipamento'] == 8 || $equip['id_tipoEquipamento'] == 9 ? 'inline-block' : 'none';
} else {
  $incluirWindowsDisplay = 'none';
}

//Modelo Hardware Rede
$modeloRede = $equip['id_tipoEquipamento'] == 12 ? 'block' : 'none'; 

?>
<!-- Begin Page Content -->

<body onload="tipoEquipamento()">
  <div class="container-fluid py-4">
    <!-- Page Heading -->
    <h1 class="text-xs mb-6 text-gray-800">
      <a href="front.php?pagina=1"><i class="fas fa-home"></i> Home</a> /
      <a href="listequipamentos.php?pagina=5"><i class="fas fa-laptop"></i> Equipamentos</a> /
      <i class="fas fa-pen"></i> Editando <?= $_GET['id_equip']  ?>
    </h1>
    <hr>

    <div class="row">
      <!--NOTAS / DOCUMENTOS-->
      <div class="col-xl-4 col-md-6 mb-4">
        <a href="equipamentodocumentos.php?pagina=5&id_equip=<?= $_GET['id_equip'] ?>" class="text-decoration">
          <div class="card border-left-success shadow h-100 py-2" style="background-color: white">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="menu font-weight-bold text-success text-uppercase mb-1">Arquivos</div>
                  <div class="menu font-weight-bold text-dark text-uppercase mb-1">Notas / Documentos</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-file fa-2x" style="color: #dddfeb"></i>
                </div>
              </div>
            </div>
          </div>
        </a>
      </div>
      <!--HISTÓRICO-->
      <div class="col-xl-4 col-md-6 mb-4">
        <a href="equipamentohistorico.php?pagina=5&id_equip=<?= $_GET['id_equip'] ?>" class="text-decoration">
          <div class="card border-left-warning shadow h-100 py-2" style="background-color: white">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="menu font-weight-bold text-warning text-uppercase mb-1">Histórico</div>
                  <div class="menu font-weight-bold text-dark text-uppercase mb-1">Equipamento</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-list fa-2x" style="color: #dddfeb"></i>
                </div>
              </div>
            </div>
          </div>
        </a>
      </div>
      <!--COLABORADOR-->

      <div class="col-xl-4 col-md-6 mb-4">
        <a href="<?= !empty($equip['nome']) ? "../inc/pesquisaFuncionario.php?id=" . $equip['id_funcionario'] . "" : "vincular.php?pagina=5&id_equip=" . $_GET['id_equip'] . ""  ?>" class="text-decoration">
          <div class="card border-left-info shadow h-100 py-2" style="background-color: white">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="menu font-weight-bold text-info text-uppercase mb-1">Respónsavel</div>
                  <div class="menu font-weight-bold text-dark text-uppercase mb-1"><?= !empty($equip['nome']) ? $equip['nome'] : "Vincular a funcionário"  ?></div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                </div>
              </div>
            </div>
          </div>
        </a>
      </div>


      <div class="termo" <?php if ($equip['id_tipoEquipamento'] == 8) {
                            echo "style='margin-left: 60%'";
                          } elseif ($equip['id_tipoEquipamento'] == 9) {
                            echo "style='margin-left: 35%'";
                          } else {
                            echo "style='margin-left: 72%'";
                          } ?>>
        <!-- Condicional para emissão de termo de responsabilidade -->
        <?php if (!empty($equip['nome']) & $equip['id_tipoEquipamento'] != 8) { ?>
          <a href="../inc/termogeral.php?query=<?= $query ?>" class="btn-sm btn-primary btn-icon-split">
            <span class="icon text-white-50">
              <i class="fas fa-file-signature"></i>
            </span>
            <span class="text text-xs">Emitir Termo Responsabilidade</span>
          </a>
        <?php } ?>

        <!--VINCULAR OFFICE-->
        <a href="#" data-toggle="modal" data-target="#adicionarOffice" class="btn-sm btn-warning btn-icon-split" title="Remover OFFICE" style="display: <?= $incluirOfficeDisplay ?>">
          <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
          </span>
          <span class="text text-xs">Incluir Office</span>
        </a>

        <!--VINCULAR WINDOWS-->
        <a href="#" data-toggle="modal" data-target="#adicionarWindows" class="btn-sm btn-success btn-icon-split" title="Remover WINDOWS" style="display: <?= $incluirWindowsDisplay ?>">
          <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
          </span>
          <span class="text text-xs">Incluir Windows</span>
        </a>

      </div>

    </div>

    <div class="col-lg-6 left">
      <!-- Circle Buttons -->
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-<?= $_SESSION["colorHeader"] ?>"><i class="fas fa-pen"></i> Editando Equipamento</h6>
          <a href="#" data-toggle="modal" data-target="#desativar" class="float-right btn-danger btn-sm" title="Excluir Equipamento">
            <i class="fas fa-trash"></i>
          </a>
          <a href="../inc/modeloEquipamento.php?idEquipamento=<?=$equip['id_equipamento']?>" class="float-right btn-warning btn-sm right" title="Emitir Modelo" style="display: <?= $modeloRede ?>">
            <i class="fas fa-file"></i> | Emitir Modelo
          </a>
        </div>
        <div class="card-body">
          <form action="../inc/editequipamento.php?id_equipamento=<?= $_GET['id_equip'] ?>&id_so=<?= $equip['id_windows'] ?>&id_of=<?= $equip['id_office'] ?>" method="POST" enctype="multipart/form-data">

            <div class="form-group">
              <!--EQUIPAMENTO-->
              <label for="versao">Tipo Equipamento:</label>
              <select class="form-control" id="tipo_equipamento" name="tipo_equipamento">
                <?php

                $queryEquipamentos .= " AND id_equip = " . $equip['id_tipoEquipamento'] . "";

                $rest = $conn->query($queryEquipamentos);

                if ($tipoEquip = $rest->fetch_assoc()) {
                  echo '<option value="' . $tipoEquip['id'] . '">' . $tipoEquip['nome'] . '</option>';
                }

                ?>
              </select>
            </div>

            <!--CELULAR / TABLET-->
            <div id="celularTablet" style="display: <?= $equip['id_tipoEquipamento'] == 1 || $equip['id_tipoEquipamento'] ==  2 ? 'block' : 'none' ?>;">
              <!--MODELO CELULAR / TABLET-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">Modelo:</label>
                <input type="text" class="form-control" name="modelo" value="<?= $equip['modelo']  ?>">
              </div>
              <!--PATRIMONIO CELULAR / TABLET-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">Patrimônio:</label>
                <input type="text" class="form-control" name="patrimonio" value="<?= $equip['patrimonio']  ?>">
              </div>
              <!--EMPRESA CELULAR / TABLET-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">Empresa Faturada:</label>
                <select class="form-control" id="exampleFormControlSelect2" name="empresa">
                  <?php

                  if (!empty($equip['id_filial'])) {

                    echo '<option value="' . $equip['id_filial'] . '">' . $equip['empresa'] . '</option>';

                    echo '<option>----------</option>';

                    $resultEmpresa = $conn->query($queryEmpresa);

                    while ($empresa = $resultEmpresa->fetch_assoc()) {
                      echo '<option value="' . $empresa['id'] . '">' . $empresa['nome'] . '</option>';
                    }
                  } else {

                    echo '<option>----------</option>';

                    $resultEmpresa = $conn->query($queryEmpresa);

                    while ($empresa = $resultEmpresa->fetch_assoc()) {
                      echo '<option value="' . $empresa['id'] . '">' . $empresa['nome'] . '</option>';
                    }
                  }
                  ?>
                </select>
              </div>
              <!--ESTADO CELULAR / TABLET-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">Estado:</label>
                <select class="form-control" id="exampleFormControlSelect2" name="estado">

                  <?php

                  if (!empty($equip['id_estado'])) {
                    echo '<option value="' . $equip['id_estado'] . '">' . $equip['estado'] . '</option>';
                    echo '<option>----------</option>';
                    $resultEstado = $conn->query($queryEstado);

                    while ($estado = $resultEstado->fetch_assoc()) {
                      echo '<option value="' . $estado['id'] . '">' . $estado['nome'] . '</option>';
                    }
                  } else {

                    echo '<option>----------</option>';

                    $resultEstado = $conn->query($queryEstado);

                    while ($estado = $resultEstado->fetch_assoc()) {
                      echo '<option value="' . $estado['id'] . '">' . $estado['nome'] . '</option>';
                    }
                  }
                  ?>
                </select>
              </div>

              <!--SITUAÇÂO CELULAR / TABLET-->
              <div class="form-group">
                <label for="situacaoCelularTablet">Situação:</label>
                <select class="form-control" id="situacaoCelularTablet" name="situacaoCelularTablet">
                  <?php

                  if (!empty($equip['id_situacao'])) {

                    echo '<option value="' . $equip['id_situacao'] . '">' . $equip['situacao'] . '</option>';

                    $resultSituacao = $conn->query($querySituacao);

                    echo '<option>----------</option>';

                    while ($situacao = $resultSituacao->fetch_assoc()) {
                      echo '<option value="' . $situacao['id'] . '">' . $situacao['nome'] . '</option>';
                    }
                  } else {
                    $resultSituacao = $conn->query($querySituacao);

                    echo '<option>----------</option>';

                    while ($situacao = $resultSituacao->fetch_assoc()) {
                      echo '<option value="' . $situacao['id'] . '">' . $situacao['nome'] . '</option>';
                    }
                  }

                  ?>
                </select>
              </div>

              <!--ACESSORIOS CELULAR / TABLET-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">Acessorios:</label><br>
                <?php

                $resultAcessorios = $conn->query($queryAcessorios);

                while ($Acessorios = $resultAcessorios->fetch_assoc()) {

                  $queryAcessoriosEquip = "SELECT * FROM manager_inventario_acessorios where id_equipamento = " . $_GET['id_equip'] . " AND tipo_acessorio = " . $Acessorios['id'] . "";

                  $res = $conn->query($queryAcessoriosEquip);
                  $acessorioEquip = $res->fetch_assoc();

                  if (!empty($acessorioEquip['id_acessorio'])) {
                    echo '<input type="checkbox" id="acessorios' . $Acessorios['id'] . '" name="acessorio[]" value="' . $Acessorios['id'] . '" checked>
                        <label class="form-check-label" for="acessorios' . $Acessorios['id'] . '">' . $Acessorios['nome'] . '</label><br>';
                  } else {
                    echo '<input type="checkbox" id="acessorios' . $Acessorios['id'] . '" name="acessorio[]" value="' . $Acessorios['id'] . '">
                        <label class="form-check-label" for="acessorios' . $Acessorios['id'] . '">' . $Acessorios['nome'] . '</label><br>';
                  }
                }
                ?>
              </div>
              <!--* IMEI CELULAR / TABLET-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">IMEI:</label>
                <input type="text" class="form-control" name="imei" value="<?= $equip['imei_chip']  ?>">
              </div>
              <!--STATUS CELULAR / TABLET-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">Status:</label>
                <select class="form-control" id="exampleFormControlSelect2" name="status">
                  <?php

                  if (!empty($equip['id_status'])) {
                    echo '<option value="' . $equip['id_status'] . '">' . $equip['status'] . '</option>';

                    echo '<option>----------</option>';

                    $resultStatus = $conn->query($queryStatusEquipamento);

                    while ($status = $resultStatus->fetch_assoc()) {
                      echo '<option value="' . $status['id'] . '">' . $status['nome'] . '</option>';
                    }
                  } else {
                    echo '<option>----------</option>';

                    $resultStatus = $conn->query($queryStatusEquipamento);

                    while ($status = $resultStatus->fetch_assoc()) {
                      echo '<option value="' . $status['id'] . '">' . $status['nome'] . '</option>';
                    }
                  }


                  ?>
                </select>
              </div>
              <!--* VALOR CELULAR / TABLET-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">Valor:</label>
                <div class="form-group col-md-4">
                  <div class="input-group-append">
                    <span class="btn btn-primary">
                      R$
                    </span>
                  </div>
                  <input type="text" class="form-control iconeAjustar" name="valor" onKeyPress="return(moeda(this,'.',',',event))" value="<?= $equip['valor']  ?>">
                </div>
              </div>
            </div>
            <!--FIM-->

            <!--CHIP / MODEM-->
            <div id="chipModem" style="display: <?= $equip['id_tipoEquipamento'] == 3 || $equip['id_tipoEquipamento'] ==  4 ? 'block' : 'none' ?>;">
              <!--EMPRESA CHIP / MODEM-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">Empresa Faturada:</label>
                <select class="form-control" id="exampleFormControlSelect2" name="empresaChip">
                  <?php

                  if (!empty($equip['id_filial'])) {

                    echo '<option value="' . $equip['id_filial'] . '">' . $equip['empresa'] . '</option>';

                    echo '<option>----------</option>';

                    $resultEmpresa = $conn->query($queryEmpresa);

                    while ($empresa = $resultEmpresa->fetch_assoc()) {
                      echo '<option value="' . $empresa['id'] . '">' . $empresa['nome'] . '</option>';
                    }
                  } else {

                    echo '<option>----------</option>';

                    $resultEmpresa = $conn->query($queryEmpresa);

                    while ($empresa = $resultEmpresa->fetch_assoc()) {
                      echo '<option value="' . $empresa['id'] . '">' . $empresa['nome'] . '</option>';
                    }
                  }
                  ?>
                </select>
              </div>
              <!--OPERADOR CHIP / MODEM-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">Operadora:</label>
                <select class="form-control" id="exampleFormControlSelect2" name="operadoraChip">

                  <?php

                  if (!empty($equip['id_operadora'])) {
                    echo '<option value="' . $equip['id_operadora'] . '">' . $equip['operadora'] . '</option>';

                    $resultqueryOperadora = $conn->query($queryOperadora);

                    echo '<option>----------</option>';

                    while ($operadora = $resultqueryOperadora->fetch_assoc()) {
                      echo '<option value="' . $operadora['id'] . '">' . $operadora['nome'] . '</option>';
                    }
                  } else {

                    $resultqueryOperadora = $conn->query($queryOperadora);

                    echo '<option>----------</option>';

                    while ($operadora = $resultqueryOperadora->fetch_assoc()) {
                      echo '<option value="' . $operadora['id'] . '">' . $operadora['nome'] . '</option>';
                    }
                  }
                  ?>
                </select>
              </div>
              <!--NUMERO CHIP / MODEM-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">Número:</label>
                <input type="text" class="form-control" name="numeroChip" id="telefone" maxlength="15" placeholder="(xx) xxxx-xxx" value="<?= $equip['numero']  ?>">
              </div>
              <!--PLANOS CHIP / MODEM-->
              <div class="form-group">
                <label for="voz">Planos:</label><br>
                <input type="checkbox" name="planosVoz" value="VOZ" id="voz" <?= empty($equip['planos_voz']) ?: 'checked' ?>>
                <label class="form-check-label" for="voz">Voz</label><br>

                <input type="checkbox" name="planosDados" value="DADOS" id="dados" <?= empty($equip['planos_dados']) ?: 'checked' ?>>
                <label class="form-check-label" for="dados">Dados</label><br>
              </div>
              <!--STATUS CHIP / MODEM-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">Status:</label>
                <select class="form-control" id="exampleFormControlSelect2" name="statusChip">
                  <?php

                  if (!empty($equip['id_status'])) {
                    echo '<option value="' . $equip['id_status'] . '">' . $equip['status'] . '</option>';

                    echo '<option>----------</option>';

                    $resultStatus = $conn->query($queryStatusEquipamento);

                    while ($status = $resultStatus->fetch_assoc()) {
                      echo '<option value="' . $status['id'] . '">' . $status['nome'] . '</option>';
                    }
                  } else {
                    echo '<option>----------</option>';

                    $resultStatus = $conn->query($queryStatusEquipamento);

                    while ($status = $resultStatus->fetch_assoc()) {
                      echo '<option value="' . $status['id'] . '">' . $status['nome'] . '</option>';
                    }
                  }


                  ?>
                </select>
              </div>
              <!--IMEI CHIP / MODEM-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">IMEI:</label>
                <input type="text" class="form-control" name="imeiChip" value="<?= $equip['imei_chip']  ?>">
              </div>
            </div>
            <!--FIM-->

            <!--DVR-->
            <div id="dvr" style="display: <?= $equip['id_tipoEquipamento'] == 11 ? 'block' : 'none' ?>;">

              <!--MODELO DVR-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">Modelo:</label>
                <input type="text" class="form-control" name="modeloDVR" value="<?= $equip['modelo']  ?>">
              </div>
              <!--PATRIMONIO DVR-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">Patrimônio:</label>
                <input type="text" class="form-control" name="patrimonioDVR" value="<?= $equip['patrimonio']  ?>">
              </div>
              <!--NUMERO SERIE DVR-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">N. de série:</label>
                <input type="text" class="form-control" name="serieDVR" value="<?= $equip['serialnumber']  ?>">
              </div>
              <!--IP DVR-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">IP:</label>
                <input type="text" class="form-control" name="ipDVR" value="<?= $equip['ip']  ?>">
              </div>
              <!--LOCALIZAÇÂO DVR-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">Localização:</label>
                <select class="form-control" id="exampleFormControlSelect2" name="localizacaoDVR">

                  <?php

                  if (!empty($equip['id_locacao'])) {

                    echo '<option value="' . $equip['id_locacao'] . '">' . $equip['locacao'] . '</option>';

                    $resultLocacao = $conn->query($queryLocacao);

                    echo '<option>----------</option>';

                    while ($locacao = $resultLocacao->fetch_assoc()) {
                      echo '<option value="' . $locacao['id'] . '">' . $locacao['nome'] . '</option>';
                    }
                  } else {
                    $resultLocacao = $conn->query($queryLocacao);

                    echo '<option>----------</option>';

                    while ($locacao = $resultLocacao->fetch_assoc()) {
                      echo '<option value="' . $locacao['id'] . '">' . $locacao['nome'] . '</option>';
                    }
                  }


                  ?>
                </select>
              </div>
            </div>
            <!--FIM-->

            <!--HARDWARE REDE-->
            <div id="hREDE" style="display: <?= $equip['id_tipoEquipamento'] == 12 ? 'block' : 'none' ?>;">

              <!--MODELO REDE-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">Modelo:</label>
                <input type="text" class="form-control" name="modeloREDE" value="<?= $equip['modelo']  ?>">
              </div>
              <!--PATRIMONIO REDE-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">Patrimônio:</label>
                <input type="text" class="form-control" name="patrimonioREDE" value="<?= $equip['patrimonio']  ?>">
              </div>
              <!--NUMERO SERIE REDE-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">N. de série:</label>
                <input type="text" class="form-control" name="serieREDE" value="<?= $equip['serialnumber']  ?>">
              </div>
              <!--LOCALIZAÇÂO DVR-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">Localização:</label>
                <select class="form-control" id="exampleFormControlSelect2" name="localizacaoREDE">

                  <?php

                  if (!empty($equip['id_locacao'])) {

                    echo '<option value="' . $equip['id_locacao'] . '">' . $equip['locacao'] . '</option>';

                    $resultLocacao = $conn->query($queryLocacao);

                    echo '<option>----------</option>';

                    while ($locacao = $resultLocacao->fetch_assoc()) {
                      echo '<option value="' . $locacao['id'] . '">' . $locacao['nome'] . '</option>';
                    }
                  } else {
                    $resultLocacao = $conn->query($queryLocacao);

                    echo '<option>----------</option>';

                    while ($locacao = $resultLocacao->fetch_assoc()) {
                      echo '<option value="' . $locacao['id'] . '">' . $locacao['nome'] . '</option>';
                    }
                  }


                  ?>
                </select>
              </div>
            </div>
            <!--FIM-->

            <!--RAMAL IP-->
            <div id="ramalIP" style="display: <?= $equip['id_tipoEquipamento'] == 5 ? 'block' : 'none' ?>;">
              <!--MODELO RAMAL-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">Modelo:</label>
                <input type="text" class="form-control" name="modeloRamal" value="<?= $equip['modelo']  ?>">
              </div>
              <!--NUMERO RAMAL-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">Número:</label>
                <input type="text" class="form-control" name="numeroRamal" maxlength="15" value="<?= $equip['numero']  ?>">
              </div>
              <!--EMPRESA RAMAL-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">Empresa Faturada:</label>
                <select class="form-control" id="exampleFormControlSelect2" name="empresaRamal">
                  <?php

                  if (!empty($equip['id_filial'])) {

                    echo '<option value="' . $equip['id_filial'] . '">' . $equip['empresa'] . '</option>';

                    echo '<option>----------</option>';

                    $resultEmpresa = $conn->query($queryEmpresa);

                    while ($empresa = $resultEmpresa->fetch_assoc()) {
                      echo '<option value="' . $empresa['id'] . '">' . $empresa['nome'] . '</option>';
                    }
                  } else {

                    echo '<option>----------</option>';

                    $resultEmpresa = $conn->query($queryEmpresa);

                    while ($empresa = $resultEmpresa->fetch_assoc()) {
                      echo '<option value="' . $empresa['id'] . '">' . $empresa['nome'] . '</option>';
                    }
                  }
                  ?>
                </select>
              </div>
              <!--LOCACAO RAMAL-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">Localização:</label>
                <select class="form-control" id="exampleFormControlSelect2" name="locacaoRamal">
                  <?php

                  if (!empty($equip['id_locacao'])) {

                    echo '<option value="' . $equip['id_locacao'] . '">' . $equip['locacao'] . '</option>';

                    $resultLocacao = $conn->query($queryLocacao);

                    echo '<option>----------</option>';

                    while ($locacao = $resultLocacao->fetch_assoc()) {
                      echo '<option value="' . $locacao['id'] . '">' . $locacao['nome'] . '</option>';
                    }
                  } else {
                    $resultLocacao = $conn->query($queryLocacao);

                    echo '<option>----------</option>';

                    while ($locacao = $resultLocacao->fetch_assoc()) {
                      echo '<option value="' . $locacao['id'] . '">' . $locacao['nome'] . '</option>';
                    }
                  }


                  ?>
                </select>
              </div>
            </div>
            <!--FIM-->

            <!--SCANNER-->
            <div id="scanner" style="display: <?= $equip['id_tipoEquipamento'] == 10 ? 'block' : 'none' ?>;">
              <!--MODELO Scan-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">Modelo:</label>
                <input type="text" class="form-control" name="modeloScan" value="<?= $equip['modelo']  ?>">
              </div>
              <!--SERIE Scan-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">N. série:</label>
                <input type="text" class="form-control" name="serieScan" value="<?= $equip['serialnumber']  ?>">
              </div>
              <!--PATRIMONIO Scan-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">Patrimônio:</label>
                <input type="text" class="form-control" name="patrimonioScan" value="<?= $equip['patrimonio']  ?>">
              </div>
              <!--EMPRESA Scan-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">Empresa Faturada:</label>
                <select class="form-control" id="exampleFormControlSelect2" name="empresaScan" value="<?= $equip['emp']  ?>">
                  <?php

                  if (!empty($equip['id_filial'])) {

                    echo '<option value="' . $equip['id_filial'] . '">' . $equip['empresa'] . '</option>';

                    echo '<option>----------</option>';

                    $resultEmpresa = $conn->query($queryEmpresa);

                    while ($empresa = $resultEmpresa->fetch_assoc()) {
                      echo '<option value="' . $empresa['id'] . '">' . $empresa['nome'] . '</option>';
                    }
                  } else {

                    echo '<option>----------</option>';

                    $resultEmpresa = $conn->query($queryEmpresa);

                    while ($empresa = $resultEmpresa->fetch_assoc()) {
                      echo '<option value="' . $empresa['id'] . '">' . $empresa['nome'] . '</option>';
                    }
                  }
                  ?>
                </select>
              </div>
              <!--LOCACAO Scan-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">Localização</label>
                <select class="form-control" id="exampleFormControlSelect2" name="locacaoScan">
                  <?php

                  if (!empty($equip['id_locacao'])) {

                    echo '<option value="' . $equip['id_locacao'] . '">' . $equip['locacao'] . '</option>';

                    $resultLocacao = $conn->query($queryLocacao);

                    echo '<option>----------</option>';

                    while ($locacao = $resultLocacao->fetch_assoc()) {
                      echo '<option value="' . $locacao['id'] . '">' . $locacao['nome'] . '</option>';
                    }
                  } else {
                    $resultLocacao = $conn->query($queryLocacao);

                    echo '<option>----------</option>';

                    while ($locacao = $resultLocacao->fetch_assoc()) {
                      echo '<option value="' . $locacao['id'] . '">' . $locacao['nome'] . '</option>';
                    }
                  }


                  ?>
                </select>
              </div>
              <!--SITUAÇÂO Scan-->
              <div class="form-group">
                <label for="situacaoScan">Situação:</label>
                <select class="form-control" id="situacaoscan" name="situacaoscan">
                  <?php

                  if (!empty($equip['id_situacao'])) {

                    echo '<option value="' . $equip['id_situacao'] . '">' . $equip['situacao'] . '</option>';

                    $resultSituacao = $conn->query($querySituacao);

                    echo '<option>----------</option>';

                    while ($situacao = $resultSituacao->fetch_assoc()) {
                      echo '<option value="' . $situacao['id'] . '">' . $situacao['nome'] . '</option>';
                    }
                  } else {
                    $resultSituacao = $conn->query($querySituacao);

                    echo '<option>----------</option>';

                    while ($situacao = $resultSituacao->fetch_assoc()) {
                      echo '<option value="' . $situacao['id'] . '">' . $situacao['nome'] . '</option>';
                    }
                  }

                  ?>
                </select>
              </div>

              <!--SITUAÇÂO ALUGADO Scan-->
              <div id="alugado" style="display: <?= $equip['id_situacao'] == 4 ? 'block' : 'none' ?>;">
                <!--FORNECEDOR-->
                <div class="form-group">
                  <label for="fornecedorScan">Fornecedor:</label>
                  <input type="text" class="form-control" name="fornecedorScan" value="<?= $equip['fornecedor_scan']  ?>">
                </div>
                <!--DATA FIM CONTRATO-->
                <div class="form-group">
                  <label for="dataFimContrato">Data fim contrato:</label>
                  <input type="text" class="form-control" name="dataFimContrato" placeholder="xx/xx/xxxx" value="<?= $equip['data_fim_contrato'] ?>">
                </div>
              </div>
              <!--SITUAÇÂO COMPRADO Scan-->
              <div id="comprado" style="display: <?= $equip['id_situacao'] == 5 ? 'block' : 'none' ?>;">
                <div class="form-group">
                  <label for="numero_notaScan">Número Nota:</label>
                  <div class="col-md-6 py-2">
                    <input type="text" class="form-control" name="numero_notaScan" value="<?= $equip['numero_nota']  ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label for="data_notaScan">Data Nota:</label>
                  <div class="col-md-4 py-2">
                    <input type="text" class="form-control" name="data_notaScan" placeholder="xx/xx/xxxx" value="<?= $equip['data_nota']  ?>">
                  </div>
                </div>
              </div>
            </div>
            <!--FIM-->

            <!--CPU / NOTEBOOK-->
            <div id="cpuNotebook" style="display: <?= $equip['id_tipoEquipamento'] == 8 || $equip['id_tipoEquipamento'] ==  9 ? 'block' : 'none' ?>;">

              <!--MODELO-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">Modelo:</label>
                <input type="text" class="form-control" name="modeloCPU" value="<?= $equip['modelo'] ?>">
              </div>
              <!--PATRIMONIO-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">Patrimônio:</label>
                <input type="text" class="form-control" name="patrimonioCPU" value="<?= $equip['patrimonio'] ?>">
              </div>
              <!--DOMINIO-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">Dominío:</label>
                <div class="form-group col-md-3">
                  <?= $equip['dominio'] == 0 ? '<input type="text" class="form-control text-success" name="dominio" value="' . $equip['dominio'] . '" style="text-align: center; display: none;" > <i class="fas fa-check-circle text-success" style="width: 175%;"> Cadastrado</i>' : '<input type="text" class="form-control text-danger" name="dominio" value="OFF" style="text-align: center; display: none; "><i class="fas fa-times-circle text-danger" style="width: 175%;"> Não cadastrado</i> ' ?>

                </div>
              </div>
              <!--EMPRESA-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">Empresa Faturado:</label>
                <select class="form-control" id="exampleFormControlSelect2" name="empresaCPU">
                  <?php

                  if (!empty($equip['id_filial'])) {

                    echo '<option value="' . $equip['id_filial'] . '">' . $equip['empresa'] . '</option>';

                    echo '<option>----------</option>';

                    $resultEmpresa = $conn->query($queryEmpresa);

                    while ($empresa = $resultEmpresa->fetch_assoc()) {
                      echo '<option value="' . $empresa['id'] . '">' . $empresa['nome'] . '</option>';
                    }
                  } else {

                    echo '<option>----------</option>';

                    $resultEmpresa = $conn->query($queryEmpresa);

                    while ($empresa = $resultEmpresa->fetch_assoc()) {
                      echo '<option value="' . $empresa['id'] . '">' . $empresa['nome'] . '</option>';
                    }
                  }
                  ?>
                </select>
              </div>
              <!--LOCACAO-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">Localização:</label>
                <select class="form-control" id="exampleFormControlSelect2" name="locacaoCPU">
                  <?php

                  if (!empty($equip['id_locacao'])) {

                    echo '<option value="' . $equip['id_locacao'] . '">' . $equip['locacao'] . '</option>';

                    $resultLocacao = $conn->query($queryLocacao);

                    echo '<option>----------</option>';

                    while ($locacao = $resultLocacao->fetch_assoc()) {
                      echo '<option value="' . $locacao['id'] . '">' . $locacao['nome'] . '</option>';
                    }
                  } else {
                    $resultLocacao = $conn->query($queryLocacao);

                    echo '<option>----------</option>';

                    while ($locacao = $resultLocacao->fetch_assoc()) {
                      echo '<option value="' . $locacao['id'] . '">' . $locacao['nome'] . '</option>';
                    }
                  }


                  ?>
                </select>
              </div>
              <!--Departamento-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">Departamento:</label>
                <select class="form-control" id="exampleFormControlSelect2" name="departamentoCPU">

                  <?php

                  if (!empty($equip['id_departamento'])) {

                    echo '<option value="' . $equip['id_departamento'] . '">' . $equip['departamento'] . '</option>';

                    $resultDepartamento = $conn->query($queryDepartamento);

                    echo '<option>----------</option>';

                    while ($departamento = $resultDepartamento->fetch_assoc()) {
                      echo '<option value="' . $departamento['id'] . '">' . $departamento['nome'] . '</option>';
                    }
                  } else {
                    $resultDepartamento = $conn->query($queryDepartamento);

                    echo '<option>----------</option>';

                    while ($departamento = $resultDepartamento->fetch_assoc()) {
                      echo '<option value="' . $departamento['id'] . '">' . $departamento['nome'] . '</option>';
                    }
                  }


                  ?>
                </select>
              </div>
              <!--Situação-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">Situação:</label>
                <select class="form-control" id="exampleFormControlSelect2" name="situacaoCPU">
                  <?php

                  if (!empty($equip['id_situacao'])) {

                    echo '<option value="' . $equip['id_situacao'] . '">' . $equip['situacao'] . '</option>';

                    $resultSituacao = $conn->query($querySituacao);

                    echo '<option>----------</option>';

                    while ($situacao = $resultSituacao->fetch_assoc()) {
                      echo '<option value="' . $situacao['id'] . '">' . $situacao['nome'] . '</option>';
                    }
                  } else {
                    $resultSituacao = $conn->query($querySituacao);

                    echo '<option>----------</option>';

                    while ($situacao = $resultSituacao->fetch_assoc()) {
                      echo '<option value="' . $situacao['id'] . '">' . $situacao['nome'] . '</option>';
                    }
                  }

                  ?>
                </select>
              </div>
              <!--status-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">Status:</label>
                <select class="form-control" id="exampleFormControlSelect2" name="statusCPU">
                  <?php

                  if (!empty($equip['id_status'])) {
                    echo '<option value="' . $equip['id_status'] . '">' . $equip['status'] . '</option>';

                    echo '<option>----------</option>';

                    $resultStatus = $conn->query($queryStatusEquipamento);

                    while ($status = $resultStatus->fetch_assoc()) {
                      echo '<option value="' . $status['id'] . '">' . $status['nome'] . '</option>';
                    }
                  } else {
                    echo '<option>----------</option>';

                    $resultStatus = $conn->query($queryStatusEquipamento);

                    while ($status = $resultStatus->fetch_assoc()) {
                      echo '<option value="' . $status['id'] . '">' . $status['nome'] . '</option>';
                    }
                  }


                  ?>
                </select>
              </div>
              <!--HOSTNAME-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">Nome:</label>
                <input type="text" class="form-control" name="hostnameCPU" value="<?= $equip['hostname'] ?>">
              </div>
              <!--HOSTNAME-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">IP:</label>
                <input type="text" class="form-control" name="ipCPU" value="<?= $equip['ip'] ?>">
              </div>
              <!--PROCESSADOR-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">Processador:</label>
                <input type="text" class="form-control" name="processadorCPU" value="<?= $equip['processador'] ?>">
              </div>
              <!--HD-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">HD:</label>
                <input type="text" class="form-control" name="hdCPU" value="<?= $equip['hd'] ?>">
              </div>
              <!--MEMORIA-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">Memória:</label>
                <input type="text" class="form-control" name="memoriaCPU" value="<?= $equip['memoria'] ?>">
              </div>
              <!--SERIAL NUMBER-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">Número de Série:</label>
                <input type="text" class="form-control" name="serial_numberCPU" value="<?= $equip['serialnumber'] ?>">
              </div>
              <!--SISTEMA OPERACIONAL-->
              <div style="display: <?= !empty($equip['versao_so']) ? "block; margin-bottom: 69px;" : "none;" ?>">

                <hr>
                <h6 class="m-0 font-weight-bold text-primary"><i class="fab fa-windows"></i> Sistema Operacional</h6><br>

                <!--VERSÃO-->
                <div class="form-group">
                  <label for="exampleFormControlSelect2">Versão:</label>
                  <select class="form-control" id="exampleFormControlSelect2" name="versaoSO">
                    <?php

                    $queryWindows  .= " AND id = '" . $equip['versao_so'] . "'";
                    $resultWindows  = $conn->query($queryWindows);
                    $windows = $resultWindows->fetch_assoc();

                    if (!empty($windows['id'])) {
                      echo '<option value="' . $windows['id'] . '">' . $windows['nome'] . '</option>';
                    }
                    ?>
                  </select>
                </div>
                <!--SERIAL-->
                <div class="form-group">
                  <label for="exampleFormControlSelect2">Chave do produto:</label>
                  <input type="text" class="form-control" name="chaveProdutoSO" value="<?= $equip['chave_windows'] ?>">
                </div>
                <!--REMOVER WINDOWSS-->
                <div class="float-rigth">
                  <a href="#" data-toggle="modal" data-target="#removerWindows" class="float-right btn-danger btn" title="Remover WINDOWS">
                    <span class="icon text-white-50">
                      <i class="fas fa-trash"></i>
                    </span>
                    <span class="text text-xs"> | Remover</span>
                  </a>
                </div>
                <!--EMITIR MODELO WINDOWS-->
                <div class="float-left">
                  <a href="../inc/equip_modelo.php?id_equip=<?= $_GET['id_equip'] ?>" class="float-right btn-warning btn" target="_blank">
                    <span class="icon text-white-50">
                      <i class="fas fa-file"></i>
                    </span>
                    <span class="text text-xs"> | Emitir Modelo</span>
                  </a>
                </div>
              </div>
              <!--OFFICE-->
              <div style="display: <?= !empty($equip['versao_off']) ? "block;" : "none;" ?>">
                <hr>
                <h6 class="m-0 font-weight-bold text-primary"><i class="fab fa-windows"></i> OFFICE</h6><br>
                <!--VERSÃO-->
                <div class="form-group">
                  <label for="exampleFormControlSelect2">Versão:</label>
                  <select class="form-control" id="exampleFormControlSelect2" name="versaoOF">
                    <?php

                    $queryListOffice  .= " AND id = '" . $equip['versao_off'] . "' ORDER BY nome ASC";
                    $resultOffice  = $conn->query($queryListOffice);
                    $office = $resultOffice->fetch_assoc();

                    if (!empty($office['id'])) {
                      echo '<option value="' . $office['id'] . '">' . $office['nome'] . '</option>';
                    }
                    ?>
                  </select>
                </div>
                <!--SERIAL-->
                <div class="form-group">
                  <label for="exampleFormControlSelect2">Chave do produto:</label>
                  <input type="text" class="form-control" name="chaveProdutoOF" value="<?= $equip['chave_office'] ?>">
                </div>
                <!--REMOVER OFFICE-->
                <div class="float-rigth">
                  <a href="#" data-toggle="modal" data-target="#removerOffice" class="float-right btn-danger btn" title="Remover OFFICE">
                    <span class="icon text-white-50">
                      <i class="fas fa-trash"></i>
                    </span>
                    <span class="text text-xs"> | Remover</span>
                  </a>
                </div>
                <!--EMITIR MODELO OFFICE-->
                <div class="float-left">
                  <a href="../inc/equip_modelo.php?id_office=<?= $office['id'] ?>&id_equip=<?= $_GET['id_equip'] ?>" class="float-right btn-warning btn" target="_blank">
                    <span class="icon text-white-50">
                      <i class="fas fa-file"></i>
                    </span>
                    <span class="text text-xs"> | Emitir Modelo</span>
                  </a>
                </div>
              </div>
            </div>

            <!--FIM-->
            <!-- BOTAO SALVAR-->
            <div id="salvarButton" style="margin-top: 69px;">
              <hr>
              <button type="submit" class="btn btn-success btn-block">Salvar</button>
              <hr>
            </div>
          </form>
          <!--FIM-->
        </div>
      </div>
    </div>
  </div>

  <!-- End of Main Content -->

  <!-- Footer -->
  <footer class="sticky-footer bg-white">
    <div class="container my-auto">
      <div class="copyright text-center my-auto">
        <span>TI Grupo Servopa - Qualquer dúvida ligue no 110-2151</span>
      </div>
    </div>
  </footer>
  <!-- End of Footer -->

  </div>
  <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="desativar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Realmente quer <span class='colorRed'>EXCLUIR</span> o Equipamento?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <p class="colorRed textoCentro" style="display: <?= empty($equip['nome']) ? 'none' : 'block' ?>;"> Não é permitido excluir este equipamento pois possui um colaborador vinculado.</p>
        </div>
        <div class="modal-footer">
          <button class="btn btn-success" type="button" data-dismiss="modal">Não</button>
          <a class="btn btn-danger" href="<?= empty($equip['nome']) ? '../inc/desativarequipamento.php?id=' . $equip['id_equipamento'] . '' : 'javascript:' ?>">Sim</a>
        </div>
      </div>
    </div>
  </div>

  <!--Excluir OFFICE-->
  <div class="modal fade" id="removerOffice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Realmente quer <span class='colorRed'>Remover</span> este OFFICE ?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-footer">
          <button class="btn btn-success" type="button" data-dismiss="modal">Não</button>
          <a class="btn btn-danger" href="../inc/remover.php?id_equip=<?= $_GET['id_equip'] ?>&id_of=<?= $equip['id_office'] ?>">Sim</a>
        </div>
      </div>
    </div>
  </div>

  <!--Excluir WINDOWS-->
  <div class="modal fade" id="removerWindows" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Realmente quer <span class='colorRed'>Remover</span> este WINDOWS ?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-footer">
          <button class="btn btn-success" type="button" data-dismiss="modal">Não</button>
          <a class="btn btn-danger" href="../inc/remover.php?id_equip=<?= $_GET['id_equip'] ?>&id_so=<?= $equip['id_windows'] ?>">Sim</a>
        </div>
      </div>
    </div>
  </div>

  <!--Cadastrar OFFICE-->
  <div class="modal fade" id="adicionarOffice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title " id="exampleModalLabel"><i class="fas fa-plus"></i> INCLUIR OFFICE</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body textoCentro">
          <p>Você está presta a vincular um office neste equipamento, porém preciso que me responda a sequinte pergunta!</p>
          <p class="colorRed">O Office já esta cadastrado no sistema ?</p>
        </div>
        <div class="modal-footer">
          <a href="officeedit.php?pagina=5&id_equip=<?= $_GET['id_equip'] ?>" class="btn btn-success btn-icon-split" style="margin-right: 56%;">
            <span class="icon text-white-50">
              <i class="fas fa-plus"></i>
            </span>
            <span class="text">NÃO</span>
          </a>
          <a href="office.php?pagina=5&id_equip=<?= $_GET['id_equip'] ?>" class="btn btn-info btn-icon-split">
            <span class="icon text-white-50">
              <i class="fas fa-laptop-medical"></i>
            </span>
            <span class="text">SIM</span>
          </a>
        </div>
      </div>
    </div>
  </div>

  <!--Cadastrar WINDOWS-->
  <div class="modal fade" id="adicionarWindows" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title " id="exampleModalLabel"><i class="fas fa-plus"></i> INCLUIR WINDOWS</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body textoCentro">
          <p>Você está presta a vincular um sistema operacional neste equipamento, porém preciso que me responda a sequinte pergunta!</p>
          <p class="colorRed">O Windows já esta cadastrado no sistema ?</p>
        </div>
        <div class="modal-footer">
          <a href="windowsedit.php?pagina=5&id_equip=<?= $_GET['id_equip'] ?>" class="btn btn-success btn-icon-split" style="margin-right: 56%;">
            <span class="icon text-white-50">
              <i class="fas fa-plus"></i>
            </span>
            <span class="text">NÃO</span>
          </a>
          <a href="windows.php?pagina=5&id_equip=<?= $_GET['id_equip'] ?>" class="btn btn-info btn-icon-split">
            <span class="icon text-white-50">
              <i class="fas fa-laptop-medical"></i>
            </span>
            <span class="text">SIM</span>
          </a>
        </div>
      </div>
    </div>
  </div>

</body>
<!--MOSTRAR TABELA DOS EQUIPAMENTOS-->
<script>
  function nao() {
    document.getElementById("notafiscal").style.display = "none";
  }

  function sim() {
    document.getElementById("notafiscal").style.display = "block";
  }
</script>

</html>