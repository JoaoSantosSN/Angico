<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nome'])) {
    include "ConectaSQL.php";

    // Proteção básica contra aspas que quebram o SQL
    $nome = mysqli_real_escape_string($conexao, $_POST["nome"]);
    $email = mysqli_real_escape_string($conexao, $_POST["email"]);
    $senha = mysqli_real_escape_string($conexao, $_POST["senha"]);

    $sql = mysqli_query($conexao, "INSERT INTO cliente (cli_nome, cli_email, cli_senha) VALUES ('$nome', '$email', '$senha')");

    if ($sql) {
        $_SESSION['logado'] = true;
        $_SESSION['cli_nome'] = $nome;
        $_SESSION['cli_email'] = $email;
        $_SESSION['cli_cod'] = mysqli_insert_id($conexao); // Pega o ID automático do banco

        header("Location: SiteAngico.php");
        exit();
    } else {
        echo "Erro ao cadastrar: " . mysqli_error($conexao);
    }
}
?>
<html>

<head>
    <title>Cadastro Cliente</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #fcf6f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h1 {
            color: #6C63FF;
            font-size: 24px;
            margin-bottom: 10px;
        }

        h2 {
            font-size: 16px;
            color: #6B7280;
            margin-bottom: 30px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
            outline: none;
            transition: border 0.3s;
        }

        input:focus {
            border-color: #6C63FF;
        }

        button {
            width: 100%;
            background: #6C63FF;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            margin-bottom: 15px;
            font-family: 'Poppins', sans-serif;
        }

        button:hover {
            opacity: 0.8;
        }

        a {
            color: #00C896;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>🐾Angico-PetShop</h1>
        <h2>Crie Sua Conta Como Nosso Cliente</h2>
        <form action="Cadastro-cliente.php" method="POST" class="form-group">
            <input type="text" name="nome" placeholder="Nome" required>
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <button type="submit">Cadastrar</button>
            <a href="Login-Cliente.php">Já Tem Conta Conosco? Clique Aqui</a>
        </form>
    </div>
</body>

</html>