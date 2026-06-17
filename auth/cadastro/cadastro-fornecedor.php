<?php
// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['razaoS'])) {
    include "C:\wamp64\www\ConectaSQL.php";

    $razao = $_POST["razaoS"];
    $cnpj = $_POST["cnpj"];
    $categoria = $_POST["categoria"];
    $whatsapp = $_POST["whatsApp"];
    $senha = $_POST["senha"];
    
    // Insere o fornecedor no banco de dados
    $inserir = mysqli_query($conexao, "INSERT INTO fornecedor (for_social, for_cnpj, for_categoria, for_whatsapp, for_senha) VALUES ('$razao', '$cnpj', '$categoria', '$whatsapp', '$senha')");

    if ($inserir) {
        $_SESSION['logado_for'] = true;
        header("Location: /painel/gestao-produtos.php");
        exit();
    }
}
?>
<html>
    <head>
        <title>Cadastro Fornecedor</title>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
        <style>
        body { font-family: 'Poppins', sans-serif; background: #fcf6f7; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .container { background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); width: 100%; max-width: 400px; text-align: center; }
        h1 { color: #6C63FF; font-size: 24px; margin-bottom: 10px; }
        h2 { font-size: 16px; color: #6B7280; margin-bottom: 30px; }
        input { width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 10px; box-sizing: border-box; font-family: 'Poppins', sans-serif; outline: none; transition: border 0.3s; }
        input:focus { border-color: #ff8c42; }
        button { width: 100%; background: #ff8c42; color: white; border: none; padding: 12px; border-radius: 10px; font-weight: 600; cursor: pointer; transition: 0.3s; margin-bottom: 15px; font-family: 'Poppins', sans-serif; }
        button:hover { opacity: 0.8; }
        .back{
            display: block; 
            margin-top: 15px; 
            color: #ff8c42; 
            text-decoration: none; 
            font-size: 14px; 
            font-weight: 500; 
        }
        .back:hover { text-decoration: underline; }

        a { color: #ff8c42; text-decoration: none; font-size: 14px; font-weight: 500; }
        a:hover { text-decoration: underline; }
        label { font-size: 13px; font-weight: 600; color: var(--dark); display: block; margin-bottom: 5px; }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>🐾Angico-PetShop</h1>
            <h2>Crie Sua Conta Como Nosso Fornecedor</h2>
            <form action="cadastro-fornecedor.php" method="POST" class="form-group">
                <label for="razao">Razão Social</label>
                <input type="text" name="razaoS" id="razao" placeholder="Ex:Rações S.A" required>
                
                <label for="cnpj1">CNPJ</label>
                <input type="text" name="cnpj" id="cnpj1" placeholder="00.000.000/0001-00" required>
                
                <label for="categoria1">Categoria</label>
                <input type="text" name="categoria" id="categoria1" placeholder="Ex:Higiene, Alimentos..." required>
                
                <label for="whats">WhatsApp</label>
                <input type="tel" name="whatsApp" id="whats" placeholder="(11) 99999-9999" required>
                
                <label for="senha1">Senha</label>
                <input type="password" name="senha" id="senha1" placeholder="Mínimo 6 caracteres" minlength="6" required>
                
                <button type="submit">Cadastrar</button>
                <h2>Já Tem Conta Conosco? <a href="/auth/login/login-fornecedor.php">Fazer Login</a></h2>
                <a href="/index.php" class="back">Voltar para a Loja</a>
            </form>
        </div>
    </body>
</html>