<?php
session_start();
include "C:\wamp64\www\ConectaSQL.php";

if (!isset($_SESSION['logado_fun'])) {
    header("Location: /index.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['adicionar'])) {
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    $inserir = mysqli_query($conexao, "INSERT INTO cliente (cli_nome, cli_email, cli_senha) VALUES ('$nome', '$email', '$senha')");

    if ($inserir) {
        echo "<script>alert('Cliente gravado com sucesso!');</script>";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editar'])) {
    $id = $_POST["id"];
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    $atualizar = mysqli_query($conexao, "UPDATE cliente SET 
    cli_nome = '$nome', 
    cli_email = '$email', 
    cli_senha = '$senha' 
    WHERE cli_cod = '$id'");

    if ($atualizar) {
        echo "<script>alert('Cliente atualizado com sucesso!');</script>";
    }
}


if (isset($_GET['excluir'])) {
    $id_excluir = $_GET['excluir'];

    if (mysqli_query($conexao, "DELETE FROM cliente WHERE cli_cod = '$id_excluir'")) {
        echo "<script>alert('Cliente excluído com sucesso!');</script>";
    } 
}

if (isset($_GET['editar'])) {    
    $id_editar = $_GET['editar'];
    $query = mysqli_query($conexao, "SELECT cli_cod, cli_nome, cli_email, cli_senha FROM cliente WHERE cli_cod = '$id_editar'");
    $saida = mysqli_fetch_array($query);
    $codigo = $saida[0];
    $nome = $saida[1];
    $email = $saida[2];
    $senha = $saida[3];   
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Clientes - Angico Petshop</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <style>
        :root { --primary: #6C63FF; --secondary: #00C896; --dark: #1F2937; }
        .header {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 10px;
        }
        body { font-family: 'Poppins', sans-serif; background: #fcf6f7; color: var(--dark); padding: 40px; }
        .container { max-width: 900px; margin: 0 auto; background: white; padding: 30px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
        h1 { color: var(--primary); margin-bottom: 20px; }
        .form-group { display: flex; gap: 10px; margin-bottom: 30px; }
        #form-editar { display: none; }
        input { flex: 1; padding: 12px; border: 1px solid #ddd; border-radius: 10px; }
        button { font-weight: 600; cursor: pointer; border: none; border-radius: 10px; padding: 12px 20px; background-color: var(--secondary); color: white; }
        .btn-delete { background-color: #ff4d4d; color: white; padding: 8px 15px; text-decoration: none; border-radius: 10px; font-size: 14px; }
        .btn-edit { background-color: #4d79ff; color: white; padding: 8px 15px; text-decoration: none; border-radius: 10px; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        th { background-color: #F9FAFB; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>Gestão de Clientes</h1>
        <a href="/auth/logout.php" class="btn-delete">Sair da conta</a>
        <a href="/index.php" class="btn-edit">Visitar loja</a>
    </div>
    <form action="gestao-cliente.php" method="POST" id="form-adicionar" class="form-group">
        <input type="hidden" name="adicionar" value="1">
        <input type="text" name="nome" placeholder="Nome" required>
        <input type="email" name="email" placeholder="E-mail" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <button type="submit">adicionar clientes</button>
    </form>

    <form method="POST" action="gestao-cliente.php" id="form-editar" class="form-group">
        <input type="hidden" name="editar" value="2">
        <input type="hidden" name="id" id="id-editar" value="<?php echo $codigo; ?>">
        <input type="text" name="nome" placeholder="Nome" value="<?php echo $nome; ?>" required>
        <input type="email" name="email" placeholder="E-mail" value="<?php echo $email; ?>" required>
        <input type="password" name="senha" placeholder="Senha" value="<?php echo $senha; ?>" required>
        <button type="submit">Editar cliente</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Senha</th>
                <th>Excluir</th>
                <th>Editar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $dados = mysqli_query($conexao, "SELECT * FROM cliente");

            while ($linha = mysqli_fetch_array($dados)) {
                echo "<tr>
                        <td>" . $linha['cli_nome'] . "</td>
                        <td>" . $linha['cli_email'] . "</td>
                        <td>" . $linha['cli_senha'] . "</td>
                        <td>
                            <a href='gestao-cliente.php?excluir=" . $linha['cli_cod'] . "' 
                               class='btn-delete' 
                               onclick=\"return confirm('Deseja excluir?');\">Excluir</a>
                        </td>
                        <td>
                            <a href='gestao-cliente.php?editar=" . $linha['cli_cod'] . "' class='btn-edit'>Editar</a>
                        </td>
                      </tr>";
            }

            mysqli_close($conexao);
            ?>
        </tbody>
    </table>
</div>
<?php 
    if (isset($_GET['editar'])) {
        echo "<script>
                document.getElementById('form-adicionar').style.display = 'none';
                document.getElementById('form-editar').style.display = 'flex';
              </script>";
    }
?>
</body>
</html>