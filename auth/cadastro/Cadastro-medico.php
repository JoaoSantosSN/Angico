<?php
// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nome'])) {
    include "C:\wamp64\www\ConectaSQL.php";

    $nome = $_POST["nome"];
    $crmv = $_POST["crmv"];
    $senha = $_POST["senha"];
    
    // Insere o cliente no banco de dados
    $inserir = mysqli_query($conexao, "INSERT INTO medico (med_nome, med_crmv, med_senha) VALUES ('$nome', '$crmv', '$senha')");

    if ($inserir) {
        // Redireciona o médico para o Painel dele
        header("Location: /painel/gestao-medico.php");
        exit();
    }
}
?>
<html>
    <head>
        <title>Cadastro Médico</title>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
        <style>
        body { font-family: 'Poppins', sans-serif; background: #fcf6f7; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .container { background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); width: 100%; max-width: 400px; text-align: center; }
        h1 { color: #45df7d; font-size: 24px; margin-bottom: 10px; }
        h2 { font-size: 16px; color: #6B7280; margin-bottom: 30px; }
        input { width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 10px; box-sizing: border-box; font-family: 'Poppins', sans-serif; outline: none; transition: border 0.3s; }
        input:focus { border-color: #52d466; }
        button { width: 100%; background: #4cd956; color: white; border: none; padding: 12px; border-radius: 10px; font-weight: 600; cursor: pointer; transition: 0.3s; margin-bottom: 15px; font-family: 'Poppins', sans-serif; }
        button:hover { opacity: 0.8; }
        a { color: #00C896; text-decoration: none; font-size: 14px; font-weight: 500; }
        a:hover { text-decoration: underline; }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>🐾Angico-PetShop</h1>
            <h2>Crie Sua Conta Como Nosso Médico</h2>
            <form action="Cadastro-medico.php" method="POST" class="form-group">
                <input type="text" name="nome" placeholder="Nome" required>
                <input type="text" name="crmv" placeholder="CRMV" required>
                <input type="password" name="senha" placeholder="Senha" required>
                <button type="submit">Cadastrar</button>
                <a href="/auth/login/Login-medico.php">Já Tem Conta Conosco? Clique Aqui</a>
                <br>
                <br>
                <a href="/index.html" style="color: #6B7280;">Voltar ao Início</a>
            </form>
        </div>
    </body>
</html>