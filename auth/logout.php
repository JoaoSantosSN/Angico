<?php
// Inicia a sessão para poder destruí-la
session_start();

// Remove todas as variáveis de sessão
session_unset();

// Destrói a sessão por completo
session_destroy();

// Redireciona de volta para a tela inicial do site
header("Location: SiteAngico2.php");
exit();
?>