<?php
// Éssa tela é chamada pelo robo (https://ondemand.automationedge.com/#/workflow/workflows/edit/5075)

require_once('../inc/querysApi.php');



switch ($_GET['acao']) {
    case NULL:

        if (($execDrop = $conn->query($drop)) === false) { //drop da tabela existente no unico
            printf("Invalid query[1]: %s\nWhole query: %s\n", $conn->error, $drop);
            exit;
        }

        if (($execCreate = $conn->query($createUsuariosApi)) === false) { //drop da tabela existente no unico
            printf("Invalid query[2]: %s\nWhole query: %s\n", $conn->error, $createUsuariosApi);
            exit;
        }
        
        require_once('../inc/apiApollo.php');
        break;

    case '2':
        require_once('../inc/apiNbs.php');
        break;
}

$conn->close();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importação</title>
</head>

<body>
    <div id="sucess">Importação Feita com Sucesso!</div>
</body>

</html>