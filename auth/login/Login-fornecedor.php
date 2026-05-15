<?php
// Inicia a sessão (o "crachá" do usuário)
session_start();

$erro = ""; // Variável para guardar mensagens de erro

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cnpj'])) {
    include "C:\wamp64\www\ConectaSQL.php";

    // Pega os dados do formulário e ajuda a evitar erros de aspas na SQL
    $cnpj = mysqli_real_escape_string($conexao, $_POST["cnpj"]);
    $senha = mysqli_real_escape_string($conexao, $_POST["senha"]);

    // Busca no banco se existe um fornecedor com esse cnpj e essa senha
    $busca = mysqli_query($conexao, "SELECT * FROM fornecedor WHERE for_cnpj = '$cnpj' AND for_senha = '$senha'");

    // Verifica se encontrou alguma linha de resultado
    if (mysqli_num_rows($busca) > 0) {
        // Se encontrou, o login está correto!
        $dados_fornecedor = mysqli_fetch_array($busca);
        
        // Guarda os dados do cliente na Sessão para usar em outras páginas do site
        $_SESSION['logado'] = true;
        $_SESSION['for_cnpj'] = $dados_fornecedor['for_cnpj'];
        $_SESSION['for_cod'] = $dados_fornecedor['for_cod'];
        
        // Redireciona o fornecedor para o site do estoque
        header("Location: /painel/estoque.php");
        exit();
    } else {
        // Se não encontrou (0 linhas), email ou senha estão errados
        $erro = "CNPJ ou senha incorretos!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login - Angico Petshop</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <style>
        body { font-family: 'Poppins', sans-serif; background: #fcf6f7; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .container { background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); width: 100%; max-width: 400px; text-align: center; }
        h1 { color: #6C63FF; font-size: 24px; margin-bottom: 10px; }
        h2 { font-size: 16px; color: #6B7280; margin-bottom: 30px; }
        input { width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 10px; box-sizing: border-box; font-family: 'Poppins', sans-serif; outline: none; transition: border 0.3s; }
        input:focus { border-color: #ff8c42; }
        button { width: 100%; background: #ff8c42; color: white; border: none; padding: 12px; border-radius: 10px; font-weight: 600; cursor: pointer; transition: 0.3s; margin-bottom: 15px; font-family: 'Poppins', sans-serif; }
        button:hover { opacity: 0.8; }
        a { color: #ff8c42; text-decoration: none; font-size: 14px; font-weight: 500; }
        a:hover { text-decoration: underline; }
        .msg-erro { background: #ffe6e6; color: #cc0000; padding: 10px; border-radius: 10px; margin-bottom: 15px; font-size: 14px; }
        .back-link { display: block; margin-top: 20px; color: #ff8c42; text-decoration: none; font-size: 14px; font-weight: 500; }
        .back-link:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🐾Angico-PetShop</h1>
        <h2>Acesse sua Conta de Fornecedor</h2>

        <?php if ($erro != "") { echo "<div class='msg-erro'>⚠️ $erro</div>"; } ?>

        <form action="Login-fornecedor.php" method="POST">
            <input type="text" name="cnpj" placeholder="00.000.000/0001-00" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <button type="submit">Entrar</button>
            <a href="/auth/cadastro/Cadastro-fornecedor.php">Ainda não é cliente? Cadastre-se</a>
<<<<<<< HEAD
            <a href="/index.html" class="back-link">Voltar para a Loja</a>
=======
            <a href="/index.php" class="back-link">Voltar para a Loja</a>
>>>>>>> 6813f4d (updating emissao)
        </form>
    </div>
</body>
</html>