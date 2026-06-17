<?php
// Inicia a sessão (o "crachá" do usuário)
include "C:\wamp64\www\ConectaSQL.php";
session_start();

if (isset($_SESSION['logado_med'])) {
    header("Location: /painel/gestao-medico.php");
    exit();
}

$erro = ""; // Variável para guardar mensagens de erro

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['crmv'])) {

    // Pega os dados do formulário e ajuda a evitar erros de aspas na SQL
    $crmv = mysqli_real_escape_string($conexao, $_POST["crmv"]);
    $senha = mysqli_real_escape_string($conexao, $_POST["senha"]);

    // Busca no banco se existe um médico com esse CRMV e essa senha
    $busca = mysqli_query($conexao, "SELECT * FROM medico WHERE med_crmv = '$crmv' AND med_senha = '$senha'");

    if (mysqli_num_rows($busca) > 0) {
        $dados_medico = mysqli_fetch_array($busca);
        
        // Define as variáveis de sessão padrão para o sistema
        $_SESSION['logado_med'] = true; 
        $_SESSION['med_nome'] = $dados_medico['med_nome'];
        $_SESSION['med_crmv'] = $dados_medico['med_crmv'];
        $_SESSION['med_cod'] = $dados_medico['med_cod'];
        
        header("Location: /painel/gestao-medico.php");
        exit();
    } else {
        $erro = "CRMV ou senha incorretos!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login Médico - Angico</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <style>
        body { font-family: 'Poppins', sans-serif; background: #fcf6f7; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .container { background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); text-align: center; width: 100%; max-width: 400px; }
        h1 { color: #45df7d; font-size: 24px; margin-bottom: 10px; }
        h2 { font-size: 16px; color: #6B7280; margin-bottom: 30px; }
        input { width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 10px; box-sizing: border-box; font-family: 'Poppins', sans-serif; outline: none; }
        button { width: 100%; background: #4cd956; color: white; border: none; padding: 12px; border-radius: 10px; font-weight: 600; cursor: pointer; transition: 0.3s; font-family: 'Poppins', sans-serif; }
        button:hover { opacity: 0.8; }
        a { color: #00C896; text-decoration: none; font-size: 14px; font-weight： 500; }
        .msg-erro { background: #ffe6e6; color: #cc0000; padding: 10px; border-radius: 10px; margin-bottom: 15px; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🐾Angico-PetShop</h1>
        <h2>Acesse sua conta como médico</h2>
        <?php if ($erro != "") { echo "<div class='msg-erro'>⚠️ $erro</div>"; } ?>
        <form action="login-medico.php" method="POST">
            <input type="text" name="crmv" placeholder="CRMV" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <button type="submit">Entrar</button>
        </form>
        <h2>Quer fazer parte da nossa equipe? <a href="/auth/cadastro/cadastro-medico.php">Cadastre-se</a></h2>
        <a href="/index.php" style="color: #6B7280;">Voltar ao Início</a>
    </div>
</body>
</html>