<?php
// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nomeCadastro'])) {
    include "ConectaSQL.php";

    $nome = $_POST["nomeCadastro"];
    $cpf = $_POST["cpfCadastro"];
    $senha = $_POST["senhaCadastro"];
    
    // Insere o funcionário no banco de dados
    $inserir = mysqli_query($conexao, "INSERT INTO funcionario (fun_nome, fun_cpf, fun_senha) VALUES ('$nome', '$cpf', '$senha')");

    if ($inserir) {
        // Redireciona o funcionário para a gestão de cliente
        header("Location: gestao-cliente.php");
        exit();
    }
}
?>
<html>
    <head>
        <title>Cadastro Funcionário</title>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
        <style>
        body { font-family: 'Poppins', sans-serif; background: #fcf6f7; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .container { background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); width: 100%; max-width: 400px; text-align: center; }
        h1 { color: #6C63FF; font-size: 24px; margin-bottom: 10px; }
        h2 { font-size: 16px; color: #6B7280; margin-bottom: 30px; }
        input { width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 10px; box-sizing: border-box; font-family: 'Poppins', sans-serif; outline: none; transition: border 0.3s; }
        input:focus { border-color: #6C63FF; }
        button { width: 100%; background: #6C63FF; color: white; border: none; padding: 12px; border-radius: 10px; font-weight: 600; cursor: pointer; transition: 0.3s; margin-bottom: 15px; font-family: 'Poppins', sans-serif; }
        button:hover { opacity: 0.8; }
        a { color: #00C896; text-decoration: none; font-size: 14px; font-weight: 500; }
        a:hover { text-decoration: underline; }
        .back{ 
            display: block; 
            margin-top: 15px; 
            color: #6C63FF; 
            text-decoration: none; 
            font-size: 14px; 
            font-weight: 500; 
        }
        .back:hover { text-decoration: underline; }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>🐾Angico-PetShop</h1>
            <h2>Crie Sua Conta Como Nosso Funcionário</h2>
            <form action="Cadastro-funcionario.php" method="POST" class="form-group">
                <input type="text" name="nomeCadastro" placeholder="Nome" required>
                <input type="number" name="cpfCadastro" placeholder="CPF(Apenas Números)" minlength="11" maxlength="11" required>
                <input type="password" name="senhaCadastro" placeholder="Senha" required>
                <button type="submit">Cadastrar</button>
                <a href="Login-funcionario.php">Já Tem Conta Conosco? Clique Aqui</a>
                <a href="SiteAngico2.html" class="back">Voltar para a Loja</a>
            </form>
        </div>
    </body>
</html>