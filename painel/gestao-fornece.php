<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Fornecedor - Angico Petshop</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <style>
        :root { 
            --primary: #ff8c42; 
            --primary-hover: #e67e3a;
            --secondary: #6c757d;
            --danger: #ef4444;
            --success: #10b981;
            --dark: #1F2937; 
            --bg: #f8fafc;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body { 
            font-family: 'Poppins', sans-serif; 
            background: var(--bg); 
            color: var(--dark); 
            padding: 20px; 
            line-height: 1.6;
        }

        .container { 
            max-width: 1000px; 
            margin: 0 auto; 
            background: white; 
            padding: 40px; 
            border-radius: 20px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.08); 
        }

        h1 { 
            color: var(--primary); 
            margin-bottom: 30px; 
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Ajuste do Formulário para Grid */
        .form-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); 
            gap: 15px; 
            margin-bottom: 40px;
            background: #fff9f5;
            padding: 20px;
            border-radius: 15px;
            border: 1px solid #ffe8d9;
        }

        input { 
            width: 100%;
            padding: 12px 15px; 
            border: 2px solid #eee; 
            border-radius: 10px; 
            font-family: inherit;
            transition: border-color 0.3s;
        }

        input:focus {
            outline: none;
            border-color: var(--primary);
        }

        button { 
            grid-column: 1 / -1; /* Botão ocupa a linha toda no grid */
            font-weight: 600; 
            cursor: pointer; 
            border: none; 
            border-radius: 10px; 
            padding: 15px; 
            background-color: var(--primary); 
            color: white; 
            transition: background 0.3s, transform 0.2s;
        }

        button:hover { 
            background-color: var(--primary-hover); 
            transform: translateY(-2px);
        }

        /* Estilização da Tabela */
        .table-container { overflow-x: auto; }

        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px;
        }

        th { 
            background-color: #f1f5f9; 
            color: #64748b;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.05em;
            padding: 15px;
            text-align: left;
        }

        td { 
            padding: 15px; 
            border-bottom: 1px solid #f1f5f9; 
            font-size: 14px;
        }

        tr:hover { background-color: #fafafa; }

        /* Botões de Ação */
        .btn-delete { 
            background-color: var(--danger); 
            color: white; 
            padding: 8px 12px; 
            text-decoration: none; 
            border-radius: 8px; 
            font-size: 13px; 
            font-weight: 500;
            transition: opacity 0.3s;
        }

        .btn-delete:hover { opacity: 0.8; }

        .msg {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 500;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>👥 Gestão de Fornecedor</h1>
    
    <form action="gestao-fornecedor.php" method="POST" class="form-grid">
        <input type="text" name="razao" placeholder="Razão Social" required>
        <input type="text" name="cnpj" placeholder="CNPJ (00.000.000/0001-00)" required>
        <input type="text" name="categoria" placeholder="Categoria" required>
        <input type="tel" name="Whatsapp" placeholder="WhatsApp: (11) 99999-9999" required>
        <input type="password" name="senha" placeholder="Senha de Acesso" required>
        <button type="submit">➕ Incluir Fornecedor no Sistema</button>
    </form>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Razão Social</th>
                    <th>CNPJ</th>
                    <th>Categoria</th>
                    <th>WhatsApp</th>
                    <th>Senha</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include "C:\wamp64\www\ConectaSQL.php";

                // Lógica de Exclusão
                if (isset($_GET['excluir'])) {
                    $id_excluir = mysqli_real_escape_string($conexao, $_GET['excluir']);
                    if (mysqli_query($conexao, "DELETE FROM fornecedor WHERE for_cod = '$id_excluir'")) {
                        echo "<div class='msg' style='background: #fee2e2; color: #b91c1c;'>🗑️ Fornecedor removido com sucesso!</div>";
                    }
                }

                // Lógica de Inserção
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['razao'])) {
                    $razao = mysqli_real_escape_string($conexao, $_POST["razao"]);
                    $cnpj = mysqli_real_escape_string($conexao, $_POST["cnpj"]);
                    $categoria = mysqli_real_escape_string($conexao, $_POST["categoria"]);
                    $whatsapp = mysqli_real_escape_string($conexao, $_POST["Whatsapp"]);
                    $senha = mysqli_real_escape_string($conexao, $_POST["senha"]);
                    
                    $query = "INSERT INTO fornecedor (for_social, for_cnpj, for_categoria, for_whatsapp, for_senha) VALUES ('$razao', '$cnpj', '$categoria', '$whatsapp', '$senha')";
                    
                    if (mysqli_query($conexao, $query)) {
                        echo "<div class='msg' style='background: #dcfce7; color: #15803d;'>✅ Fornecedor gravado com sucesso!</div>";
                    }
                }

                // Listagem
                $dados = mysqli_query($conexao, "SELECT * FROM fornecedor");
                while ($linha = mysqli_fetch_array($dados)) {
                    echo "<tr>
                            <td><strong>" . $linha['for_social'] . "</strong></td>
                            <td>" . $linha['for_cnpj'] . "</td>
                            <td><span style='background:#eee; padding:4px 8px; border-radius:5px; font-size:12px;'>" . $linha['for_categoria'] . "</span></td>
                            <td>" . $linha['for_whatsapp'] . "</td>
                            <td>". $linha['for_senha']."</td>
                            <td>
                                <a href='gestao-fornecedor.php?excluir=" . $linha['for_cod'] . "' 
                                   class='btn-delete' 
                                   onclick=\"return confirm('Deseja realmente excluir este fornecedor?');\">Excluir</a>
                            </td>
                          </tr>";
                }
                mysqli_close($conexao);
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>