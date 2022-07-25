<?php

require_once('../../unico/config/databases.php');

$drop = "DROP TABLE cad_usuario_api";

$createUsuariosApi = "CREATE TABLE cad_usuario_api (
        id INT NOT NULL AUTO_INCREMENT,
        nome VARCHAR(255) NOT NULL,
        cpf VARCHAR(12),
        ativo VARCHAR(10),
        sistema VARCHAR(10),
        PRIMARY KEY (id));";

?>