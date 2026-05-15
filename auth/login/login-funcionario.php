<?php
    session_start();

    $erro = ""; // Variável para guardar mensagens de erro

    // Verifica se o formulário foi enviado
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cpfLogin'])) {
        include "C:\wamp64\www\ConectaSQL.php";

    // Pega os dados do formulário e ajuda a evitar erros de aspas na SQL
        $cpf = mysqli_real_escape_string($conexao, $_POST["cpfLogin"]);
        $senha = mysqli_real_escape_string($conexao, $_POST["senhaFunc"]);

    // Busca no banco se existe um funcionário com esse CPF e essa senha
        $busca = mysqli_query($conexao, "SELECT * FROM funcionario WHERE fun_cpf = '$cpf' AND fun_senha = '$senha'");

    // Verifica se encontrou alguma linha de resultado
    if (mysqli_num_rows($busca) > 0) {
        // Se encontrou, o login está correto!
        $dados_funcionario = mysqli_fetch_array($busca);
        
        // Guarda os dados do funcionário na sessão para usar em outras páginas do site
        $_SESSION['logado'] = true;
        $_SESSION['fun_cpf'] = $dados_funcionario['fun_cpf'];
        $_SESSION['fun_cod'] = $dados_funcionario['fun_cod']; //troquei do cli_cod para fun_cod
        
        // Redireciona o funcionário para o site de gestão de cliente
        header("Location: /painel/gestao-funcionario.php");
        exit();
    }else {
        // Se não encontrou (0 linhas), CPF ou senha estão errados
        $erro = "CPF ou senha incorretos!";
    }
    }
    
    ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Funcionário - Angico PetShop</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
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

        .login-card { 
            background: white; 
            padding: 40px; 
            border-radius: 20px; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.05); 
            width: 100%; 
            max-width: 400px; 
            text-align: center; 
        }

        h1 { color: #6C63FF; font-size: 26px; margin-bottom: 5px; }
        h2 { font-size: 14px; color: #6B7280; margin-bottom: 30px; font-weight: 400; }
        
        .input-group { text-align: left; margin-bottom: 15px; }
        label { font-size: 13px; font-weight: 500; color: #1F2937; margin-left: 5px; }

        input { 
            width: 100%; 
            padding: 12px; 
            margin-top: 5px;
            border: 1px solid #ddd; 
            border-radius: 10px; 
            box-sizing: border-box; 
            font-family: 'Poppins', sans-serif; 
            outline: none; 
            transition: 0.3s; 
        }

        input:focus { border-color: #6C63FF; box-shadow: 0 0 0 3px rgba(108, 99, 255, 0.1); }
        
        .btn-entrar { 
            width: 100%; 
            background: #6C63FF; 
            color: white; 
            border: none; 
            padding: 14px; 
            border-radius: 10px; 
            font-weight: 600; 
            cursor: pointer; 
            transition: 0.3s; 
            margin-top: 10px;
            font-size: 16px;
        }

        .btn-entrar:hover { background: #5a52d4; transform: translateY(-2px); }
        .back{ 
            display: block; 
            margin-top: 15px; 
            color: #6C63FF; 
            text-decoration: none; 
            font-size: 14px; 
            font-weight: 500; 
        }
        .back:hover { text-decoration: underline; }
        .back-link { 
            display: block; 
            margin-top: 20px; 
            color: #00C896; 
            text-decoration: none; 
            font-size: 14px; 
            font-weight: 500; 
        }
        .back-link:hover { text-decoration: underline; }

        .logo-icon { font-size: 40px; margin-bottom: 10px; display: block; }
        .msg-erro { background: #ffe6e6; color: #cc0000; padding: 10px; border-radius: 10px; margin-bottom: 15px; font-size: 14px; }
    </style>
</head>
<body>

    <div class="login-card">
        <span class="logo-icon">🐾</span>
        <h1>Angico PetShop</h1>
        <h2>Painel Administrativo do Funcionário</h2>

        <?php if ($erro != "") { echo "<div class='msg-erro'>⚠️ $erro</div>"; }?>

        <form action="login-funcionario.php" method="POST">
            <div class="input-group">
                <label for="cpf">CPF do Funcionário</label>
                <input type="text" id="cpf" name="cpfLogin" placeholder="CPF(Apenas Números)" required>
            </div>
            <div class="input-group">
                <label for="senha">Senha de Acesso</label>
                <input type="password" id="senha" name="senhaFunc" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn-entrar">Entrar no Sistema</button>
            <a href="/auth/cadastro/Cadastro-funcionario.php" class="back">Não tem cadastro? Cadastre-se aqui</a>
            <a href="/index.html" class="back-link">Voltar para a Loja</a>
        </form>
    </div>
</body>
</html>
