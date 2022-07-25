
<?php
//sessão
session_start();
//chamando banco de dados
include 'conexao.php';


/* ----------------------- BUSCANDO INFORMAÇÕES DO USUÁRIO  ----------------------- */
$frase = $_POST['comentario'];

$palavrao = '';
$palavroes = array('arrombado','arrombada','arombado','arombada','buceta','boceta','bucetao','bocetao','bucetaum','bocetaum','bucetinha',
'bocetinha',
'blowjob',
'#@?$%~',
'caralinho',
'caralhao',
'caralhaum',
'caralhex',
'cacete',
'cacetinho',
'cacetao',
'cacetaum',
'epenis',
'ehpenis',
'penis',
'pênis',
'c*',
'c*',
'c*',
'cu',
'cuzinho',
'cúzinho',
'cuzão',
'cúzao',
'cuzudo',
'cúzudo',
'cusinho',
'cúsinho',
'cúsão',
'cusão',
'cúsao',
'cusao',
'cusudo',
'cúsudo',
'foder',
'f****',
'fodase',
'f***-se',
'fodasse',
'f***-sse',
'fodasi',
'f***-si',
'fodassi',
'f***-ssi',
'fodassa',
'f***ça',
'fodinha',
'fodao',
'fodaum',
'f***',
'fodona',
'f***',
'foder',
'f****',
'fodeu',
'fuckoff',
'fuckyou',
'fuck',
'filhodaputa',
'filho-da-#@?$%~',
'fdp',
'filhadaputa',
'filha-da-#@?$%~',
'filho de uma egua',
'filho de uma égua',
'filho-de-uma-egua',
'filho-de-uma-égua',
'filhodeumaegua',
'filhodeumaégua',
'filha de uma egua',
'filha de uma égua',
'filha-de-uma-egua',
'filha-de-uma-égua',
'filhadeumaegua',
'filhadeumaégua',
'gozo',
'goza',
'gozar',
'gozada',
'gozadanacara',
'm*****',
'merda',
'merdao',
'merdaum',
'merdinha',
'vadia',
'vasefoder',
'venhasefoder',
'voufoder',
'vasefuder',
'venhasefuder',
'voufuder',
'vaisefoder',
'vaisefuder',
'venhasefuder',
'vaisifude',
'v****',
'vaisifuder',
'vasifuder',
'vasefuder',
'vasefoder',
'pirigueti',
'piriguete',
'p****',
'p****',
'porraloca',
'porraloka',
'porranacara',
'#@?$%~',
'putinha',
'putona',
'putassa',
'putao',
'punheta',
'putamerda',
'putaquepariu',
'putaquemepariu',
'putaquetepariu',
'putavadia',
'pqp',
'putaqpariu',
'putaqpario',
'putaqparil',
'peido',
'peidar',
'xoxota',
'xota',
'xoxotinha',
'xoxotona', 'puta',
'pqp', 'fdp', 'se fode', 'toma no cu','cachorro','cadela','cachorra','nem fudendo','filho da puta', 'vtnc', 'vagabunda','vagabundo','vai toma no cu','caralho','ai sim caralho', 'ai sim, caralho', 'porra','que merda', 'merda'
);

foreach ($palavroes as $value){
$pos = strpos($frase, $value);

if (!($pos === false))
    $palavrao = $palavrao.$value.'|';        
}

if (strlen($palavrao) > 1) {
    // echo"
    // <div><h1><strong >Atenção!</strong> Seu comentário foi bloqueado por conter alguma palavra imprópria</h1>
    // <img src='robo.svg' width='70%'></div>";

    header('location: postagem.php?id_post='.$_GET['id_post'].'&msn=2');
    
} else {       


/* ----------------------- BUSCANDO AS INFORMAÇÕES DO COMENTÁRIO  ----------------------- */
$comentario_query = "SELECT 
                        *
                    FROM
                    blog_post
                    WHERE
                        id_postagem = ".$_GET['id_post']."";

$result_comentario = $conn->query($comentario_query);
while ( $row = $result_comentario->fetch_assoc() ){
    $row['data'];
    $data = $row['data'];
    $id_post = $row['id_postagem'];
    $alerta_comentario = $row['alerta_comentario'];
}

$_POST['comentario'];
$_POST['empresa'];
$_POST['departamento'];
$_POST['nome'];
$comentario = $_POST['comentario'];
$empresa = $_POST["empresa"];
$departamento = $_POST['departamento'];
$nome = $_POST['nome'];


$query = "INSERT INTO blog_comentarios(id_postagem,nome,departamento,empresa, comentario, data, avisado_responsavel) 
VALUE ('$id_post','$nome','$departamento','$empresa','$comentario','$data','0');";
$result = $conn->query($query);


//chamando o PHPMailer

//voltando para informar que foi salvo com sucesso!
header('location: postagem.php?id_post='.$_GET['id_post'].'&msn=1');

//fecha conexao com o banco de dados

mysqli_close();

}
?>
</body>
</html>