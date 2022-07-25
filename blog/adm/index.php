<?php

session_start();

echo empty($_SESSION['id']) ? '<script>window.location="http://10.100.1.217/unico"</script>' : '<script>window.location="dashboard.php?pagina=1"</script>';

?>