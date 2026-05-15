<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Funcionários - Angico Petshop</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <style>
        :root { --primary: #6C63FF; --secondary: #00C896; --dark: #1F2937; }
        body { font-family: 'Poppins', sans-serif; background: #fcf6f7; color: var(--dark); padding: 40px; }
        .container { max-width: 900px; margin: 0 auto; background: white; padding: 30px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
        h1 { color: var(--primary); margin-bottom: 20px; }
        .form-group { display: flex; gap: 10px; margin-bottom: 30px; }
        input { flex: 1; padding: 12px; border: 1px solid #ddd; border-radius: 10px; }
        button { font-weight: 600; cursor: pointer; border: none; border-radius: 10px; padding: 12px 20px; background-color: var(--secondary); color: white; }
        .btn-delete { background-color: #ff4d4d; color: white; padding: 8px 15px; text-decoration: none; border-radius: 10px; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        th { background-color: #F9FAFB; }
    </style>
</head>
<body>

<div class="container">
    <h1>👥 Gestão de Funcionário</h1>
    <form action="gestao-cliente.php" method="POST" class="form-group">
        <input type="text" name="nome" placeholder="Nome" required>
        <input type="number" name="cpf" placeholder="CPF(Apenas Números)" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <button type="submit">➕ Incluir Funcionário</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>CPF</th>
                <th>Senha</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
             include "ConectaSQL.php";


            if (isset($_GET['excluir'])) {

            $id_excluir = $_GET['excluir'];

            if (mysqli_query($conexao, "DELETE FROM funcionario WHERE fun_cod = '$id_excluir'")) {
                echo "<div class='msg' style='background: #ffe6e6; color: #cc0000;'>🗑️ Funcionário removido!</div>";
            }
        }
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nome'])) {
            $nome = $_POST["nome"];
            $email = $_POST["cpf"];
            $senha = $_POST["senha"];
            
            $inserir = mysqli_query($conexao, "INSERT INTO funcionario (fun_nome, fun_cpf, fun_senha) VALUES ('$nome', '$cpf', '$senha')");
        
            if ($inserir) {
            echo "<p style='color: green;'>✅ Funcionario gravado com sucesso!</p>";
            }
        }
            $dados = mysqli_query($conexao, "SELECT * FROM funcionario");

            while ($linha = mysqli_fetch_array($dados)) {
                echo "<tr>
                        <td>" . $linha['fun_nome'] . "</td>
                        <td>" . $linha['fun_cpf'] . "</td>
                        <td>" . $linha['fun_senha'] . "</td>
                        <td>
                            <a href='gestao-funcionario.php?excluir=" . $linha['fun_cod'] . "' 
                               class='btn-delete' 
                               onclick=\"return confirm('Deseja excluir?');\">🗑️ Excluir</a>
                        </td>
                        <td>
                            <a href='gestao-funcionario.php
                        </td>
                      </tr>";
            }

            mysqli_close($conexao);
            ?>
        </tbody>
    </table>
</div>

</body>
</html>