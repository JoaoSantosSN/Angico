<?php
    $servidor = "localhost";
    $usuario = "root";
    $senha = "";
    $bancoDados = "angico";

    $conexao = mysqli_connect($servidor,$usuario,$senha,$bancoDados) or die ("Problemas ao conectar ao banco de dados. Verifique!");
?>