<?php
session_start();
require_once('../bd/conexao.php');

//DATA DE HOJE
$dataHoje = date('d/m/Y');

switch ($_POST['tipo_equipamento']) {
    case '1':
        # CELULAR...

        $update = "UPDATE manager_inventario_equipamento SET 
            modelo = '" . $_POST['modelo'] . "', 
            patrimonio = '" . $_POST['patrimonio'] . "',
            filial = '" . $_POST['empresa'] . "',
            estado = '" . $_POST['estado'] . "',
            situacao = '" . $_POST['situacaoCelularTablet'] . "',
            imei_chip = '" . $_POST['imei'] . "',
            status = '" . $_POST['status'] . "',
            valor = '" . $_POST['valor'] . "'        
        WHERE id_equipamento = '" . $_GET['id_equipamento'] . "'";

        if (!$result = $conn->query($update)) {
            printf('ERRO[1]: %s\n', $conn->error);
        } else {

            //acessórios
            $limpar = "DELETE FROM manager_inventario_acessorios WHERE (id_equipamento = '" . $_GET['id_equipamento'] . "')";

            if (!$resultLimpar = $conn->query($limpar)) {
                printf('ERRO[2]: %s\n', $conn->error);
            } else {
                if (isset($_POST['acessorio'])) {
                    foreach ($_POST['acessorio'] as $id_acessorio) {

                        $inserAcessorios = "INSERT INTO manager_inventario_acessorios 
                                                (id_equipamento, tipo_acessorio) 
                                            VALUES ('" . $_GET['id_equipamento'] . "', '" . $id_acessorio . "')";

                        if (!$resultAcessorios = $conn->query($inserAcessorios)) {
                            printf('ERRO[3]: %s\n', $conn->error);
                        }
                    }
                }
            }

            //CRIANDO LOG
            $insertLog = "INSERT INTO manager_log 
                            (id_equipamento,  data_alteracao, usuario, tipo_alteracao) 
                        VALUES 
                            ('" . $_GET['id_equipamento'] . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '0')";

            if (!$log = $conn->query($insertLog)) {
                printf('Erro[4]: %s\n', $conn->error);
            } else {
                header('location: ../front/editequipamento.php?pagina=5&id_equip=' . $_GET['id_equipamento'] . '');
            }
        }

        break;
    case '2':
        # TABLET...

        $update = "UPDATE manager_inventario_equipamento SET 
            modelo = '" . $_POST['modelo'] . "', 
            patrimonio = '" . $_POST['patrimonio'] . "',
            filial = '" . $_POST['empresa'] . "',
            estado = '" . $_POST['estado'] . "',
            situacao = '" . $_POST['situacaoCelularTablet'] . "',
            imei_chip = '" . $_POST['imei'] . "',
            status = '" . $_POST['status'] . "',
            valor = '" . $_POST['valor'] . "'        
        WHERE id_equipamento = '" . $_GET['id_equipamento'] . "'";

        if (!$result = $conn->query($update)) {
            printf('ERRO[1]: %s\n', $conn->error);
        } else {

            //acessórios
            $limpar = "DELETE FROM manager_inventario_acessorios WHERE (id_equipamento = '" . $_GET['id_equipamento'] . "')";

            if (!$resultLimpar = $conn->query($limpar)) {
                printf('ERRO[2]: %s\n', $conn->error);
            } else {
                if (isset($_POST['acessorio'])) {
                    foreach ($_POST['acessorio'] as $id_acessorio) {

                        $inserAcessorios = "INSERT INTO manager_inventario_acessorios 
                                                (id_equipamento, tipo_acessorio) 
                                            VALUES ('" . $_GET['id_equipamento'] . "', '" . $id_acessorio . "')";

                        if (!$resultAcessorios = $conn->query($inserAcessorios)) {
                            printf('ERRO[3]: %s\n', $conn->error);
                        }
                    }
                }
            }

            //CRIANDO LOG
            $insertLog = "INSERT INTO manager_log 
                            (id_equipamento,  data_alteracao, usuario, tipo_alteracao) 
                        VALUES 
                            ('" . $_GET['id_equipamento'] . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '0')";

            if (!$log = $conn->query($insertLog)) {
                printf('Erro[4]: %s\n', $conn->error);
            } else {
                header('location: ../front/editequipamento.php?pagina=5&id_equip=' . $_GET['id_equipamento'] . '');
            }
        }
        break;
    case '3':
        # CHIP...

        $update = "UPDATE manager_inventario_equipamento SET 
            filial = '" . $_POST['empresaChip'] . "',
            operadora = '" . $_POST['operadoraChip'] . "',
            numero = '" . $_POST['numeroChip'] . "',
            planos_voz = '" . $_POST['planosVoz'] . "',
            planos_dados = '" . $_POST['planosDados'] . "',
            imei_chip = '" . $_POST['imeiChip'] . "',
            status = '" . $_POST['statusChip'] . "'       
        WHERE id_equipamento = '" . $_GET['id_equipamento'] . "'";

        if (!$result = $conn->query($update)) {
            printf('ERRO[1]: %s\n', $conn->error);
        } else {

            //CRIANDO LOG
            $insertLog = "INSERT INTO manager_log 
                            (id_equipamento,  data_alteracao, usuario, tipo_alteracao) 
                        VALUES 
                            ('" . $_GET['id_equipamento'] . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '0')";

            if (!$log = $conn->query($insertLog)) {
                printf('Erro[4]: %s\n', $conn->error);
            } else {
                header('location: ../front/editequipamento.php?pagina=5&id_equip=' . $_GET['id_equipamento'] . '');
            }
        }
        break;
    case '4':
        # MODEM...

        $update = "UPDATE manager_inventario_equipamento SET 
            filial = '" . $_POST['empresaChip'] . "',
            operadora = '" . $_POST['operadoraChip'] . "',
            numero = '" . $_POST['numeroChip'] . "',
            planos_voz = '" . $_POST['planosVoz'] . "',
            planos_dados = '" . $_POST['planosDados'] . "',
            imei_chip = '" . $_POST['imeiChip'] . "',
            status = '" . $_POST['statusChip'] . "'       
        WHERE id_equipamento = '" . $_GET['id_equipamento'] . "'";

        if (!$result = $conn->query($update)) {
            printf('ERRO[1]: %s\n', $conn->error);
        } else {

            //CRIANDO LOG
            $insertLog = "INSERT INTO manager_log 
                            (id_equipamento,  data_alteracao, usuario, tipo_alteracao) 
                        VALUES 
                            ('" . $_GET['id_equipamento'] . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '0')";

            if (!$log = $conn->query($insertLog)) {
                printf('Erro[4]: %s\n', $conn->error);
            } else {
                header('location: ../front/editequipamento.php?pagina=5&id_equip=' . $_GET['id_equipamento'] . '');
            }
        }
        break;
    case '5':
        # RAMAL IP...

        $update = "UPDATE manager_inventario_equipamento SET 
            modelo = '" . $_POST['modeloRamal'] . "',
            filial = '" . $_POST['empresaRamal'] . "',
            locacao = '" . $_POST['locacaoRamal'] . "',
            numero = '" . $_POST['numeroRamal'] . "'    
        WHERE id_equipamento = '" . $_GET['id_equipamento'] . "'";

        if (!$result = $conn->query($update)) {
            printf('ERRO[1]: %s\n', $conn->error);
        } else {

            //CRIANDO LOG
            $insertLog = "INSERT INTO manager_log 
                            (id_equipamento,  data_alteracao, usuario, tipo_alteracao) 
                        VALUES 
                            ('" . $_GET['id_equipamento'] . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '0')";

            if (!$log = $conn->query($insertLog)) {
                printf('Erro[4]: %s\n', $conn->error);
            } else {
                header('location: ../front/editequipamento.php?pagina=5&id_equip=' . $_GET['id_equipamento'] . '');
            }
        }
        break;
    case '8':
        # CPU...

        $update = "UPDATE manager_inventario_equipamento SET 
            modelo = '" . $_POST['modeloCPU'] . "',
            patrimonio = '" . $_POST['patrimonioCPU'] . "',
            filial = '" . $_POST['empresaCPU'] . "',
            locacao = '" . $_POST['locacaoCPU'] . "',
            departamento = '" . $_POST['departamentoCPU'] . "',            
            situacao = '" . $_POST['situacaoCPU'] . "',            
            status = '" . $_POST['statusCPU'] . "',
            ip = '" . $_POST['ipCPU'] . "',
            processador = '" . $_POST['processadorCPU'] . "',            
            hd = '" . $_POST['hdCPU'] . "',            
            serialnumber = '" . $_POST['serial_numberCPU'] . "' 

        WHERE id_equipamento = '" . $_GET['id_equipamento'] . "'";

        if (!$result = $conn->query($update)) {
            printf('ERRO[1]: %s\n', $conn->error);
        } else {

            //Serial windows

            $serialSO = "UPDATE manager_sistema_operacional SET serial = '" . $_POST['chaveProdutoSO'] . "' WHERE (id = '" . $_GET['id_so'] . "')";

            if (!$resultSerialSO = $conn->query($serialSO)) {
                printf('ERRO[1]: %s\n', $conn->error);
            }

            //serial office
            if (!empty($_GET['id_of'])) {
                $serialOF = "UPDATE manager_office SET serial = '" . $_POST['chaveProdutoOF'] . "' WHERE (id = '" . $_GET['id_of'] . "')";

                if (!$resultSerialOF = $conn->query($serialOF)) {
                    printf('ERRO[1]: %s\n', $conn->error);
                }
            }

            //CRIANDO LOG
            $insertLog = "INSERT INTO manager_log 
                            (id_equipamento,  data_alteracao, usuario, tipo_alteracao) 
                        VALUES 
                            ('" . $_GET['id_equipamento'] . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '0')";

            if (!$log = $conn->query($insertLog)) {
                printf('Erro[4]: %s\n', $conn->error);
            } else {
                header('location: ../front/editequipamento.php?pagina=5&id_equip=' . $_GET['id_equipamento'] . '');
            }
        }
        break;
    case '9':
        # NOTEBOOK...

        $update = "UPDATE manager_inventario_equipamento SET 
            modelo = '" . $_POST['modeloCPU'] . "',
            patrimonio = '" . $_POST['patrimonioCPU'] . "',
            filial = '" . $_POST['empresaCPU'] . "',
            locacao = '" . $_POST['locacaoCPU'] . "',
            departamento = '" . $_POST['departamentoCPU'] . "',            
            situacao = '" . $_POST['situacaoCPU'] . "',            
            status = '" . $_POST['statusCPU'] . "',
            ip = '" . $_POST['ipCPU'] . "',
            processador = '" . $_POST['processadorCPU'] . "',            
            hd = '" . $_POST['hdCPU'] . "',            
            serialnumber = '" . $_POST['serial_numberCPU'] . "' 

        WHERE id_equipamento = '" . $_GET['id_equipamento'] . "'";

        if (!$result = $conn->query($update)) {
            printf('ERRO[1]: %s\n', $conn->error);
        } else {

            //Serial windows
            $serialSO = "UPDATE manager_sistema_operacional SET serial = '" . $_POST['chaveProdutoSO'] . "' WHERE (id = '" . $_GET['id_so'] . "')";

            if (!$resultSerialSO = $conn->query($serialSO)) {
                printf('ERRO[1]: %s\n', $conn->error);
            }

            //serial office
            if (!empty($_GET['id_of'])) {
                $serialOF = "UPDATE manager_office SET serial = '" . $_POST['chaveProdutoOF'] . "' WHERE (id = '" . $_GET['id_of'] . "')";

                if (!$resultSerialOF = $conn->query($serialOF)) {
                    printf('ERRO[1]: %s\n', $conn->error);
                }
            }

            //CRIANDO LOG
            $insertLog = "INSERT INTO manager_log 
                            (id_equipamento,  data_alteracao, usuario, tipo_alteracao) 
                        VALUES 
                            ('" . $_GET['id_equipamento'] . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '0')";

            if (!$log = $conn->query($insertLog)) {
                printf('Erro[4]: %s\n', $conn->error);
            } else {
                header('location: ../front/editequipamento.php?pagina=5&id_equip=' . $_GET['id_equipamento'] . '');
            }
        }
        break;
    case '10':
        # SCANNER...

        switch ($_POST['situacaoscan']) {
            case '4':
                # ALUGADO...
                $fornecedor = ",fornecedor_scan = '" . $_POST['fornecedorScan'] . "'";

                $datafimcontrato = ", data_fim_contrato = '" . $_POST['dataFimContrato'] . "'";

                break;
            case '5':
                # COMPRADO...                
                $numeronota = ", numero_nota = '" . $_POST['numero_notaScan'] . "'";

                $datanota = ", data_nota = '" . $_POST['data_notaScan'] . "'";

                break;
        }

        $update = "UPDATE manager_inventario_equipamento SET 

            modelo = '" . $_POST['modeloScan'] . "',
            serialnumber = '" . $_POST['serieScan'] . "',
            patrimonio = '" . $_POST['patrimonioScan'] . "',
            filial = '" . $_POST['empresaScan'] . "',
            locacao = '" . $_POST['locacaoScan'] . "',
            situacao = '" . $_POST['situacaoscan'] . "'";

        if ($_POST['situacaoscan'] == 4) {

            $update .= $fornecedor;
            $update .= $datafimcontrato;
        } else if ($_POST['situacaoscan'] == 5) {
            $update .= $numeronota;
            $update .= $datanota;
        }

        $update .= " WHERE id_equipamento = '" . $_GET['id_equipamento'] . "'";

        if (!$result = $conn->query($update)) {
            printf('ERRO[1]: %s\n', $conn->error);
        } else {

            //CRIANDO LOG
            $insertLog = "INSERT INTO manager_log 
                        (id_equipamento,  data_alteracao, usuario, tipo_alteracao) 
                    VALUES 
                        ('" . $_GET['id_equipamento'] . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '0')";

            if (!$log = $conn->query($insertLog)) {
                printf('Erro[4]: %s\n', $conn->error);
            } else {
                header('location: ../front/editequipamento.php?pagina=5&id_equip=' . $_GET['id_equipamento'] . '');
            }
        }

        break;
    case '11':
        # DVR...
        $update = "UPDATE manager_inventario_equipamento SET 
            modelo = '" . $_POST['modeloDVR'] . "',   
            patrimonio = '" . $_POST['patrimonioDVR'] . "',   
            serialnumber = '" . $_POST['serieDVR'] . "',    
            ip = '" . $_POST['ipDVR'] . "',            
            locacao = '" . $_POST['localizacaoDVR'] . "'
                
        WHERE id_equipamento = '" . $_GET['id_equipamento'] . "'";

        if (!$result = $conn->query($update)) {
            printf('ERRO[1]: %s\n', $conn->error);
        } else {

            //CRIANDO LOG
            $insertLog = "INSERT INTO manager_log 
                            (id_equipamento,  data_alteracao, usuario, tipo_alteracao) 
                        VALUES 
                            ('" . $_GET['id_equipamento'] . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '0')";

            if (!$log = $conn->query($insertLog)) {
                printf('Erro[4]: %s\n', $conn->error);
            } else {
                header('location: ../front/editequipamento.php?pagina=5&id_equip=' . $_GET['id_equipamento'] . '');
            }
        }
        break;
        
    case '12':

        # HARDWARE REDE...
        $update = "UPDATE manager_inventario_equipamento SET 
            modelo = '" . $_POST['modeloREDE'] . "',   
            patrimonio = '" . $_POST['patrimonioREDE'] . "',   
            serialnumber = '" . $_POST['serieREDE'] . "', 
            locacao = '" . $_POST['localizacaoREDE'] . "'
                
        WHERE id_equipamento = '" . $_GET['id_equipamento'] . "'";

        if (!$result = $conn->query($update)) {
            printf('ERRO[5]: %s\n', $conn->error);
        } else {

            //CRIANDO LOG
            $insertLog = "INSERT INTO manager_log 
                            (id_equipamento,  data_alteracao, usuario, tipo_alteracao) 
                        VALUES 
                            ('" . $_GET['id_equipamento'] . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '0')";

            if (!$log = $conn->query($insertLog)) {
                printf('Erro[6]: %s\n', $conn->error);
            } else {
                header('location: ../front/editequipamento.php?pagina=5&id_equip=' . $_GET['id_equipamento'] . '');
            }
        }
        break;
}

$conn->close();