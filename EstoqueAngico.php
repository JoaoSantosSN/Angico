<?php
include "ConectaSQL.php";

// 1. Cadastrar Novo Produto
if (isset($_POST['btn-cadastrar'])) {
    $nome = $_POST['nome'];
    $qtd = $_POST['qtd'];
    $preco = $_POST['preco'];
    $fornecedor = $_POST['fornecedor'];

    $query = "INSERT INTO produtos (pro_nome, pro_quantidade, pro_preco, pro_fornecedor) VALUES ('$nome', '$qtd', '$preco', '$fornecedor')";
    if (mysqli_query($conexao, $query)) {
        // Correção: alterado $motivo para $fornecedor, pois $motivo não existia neste escopo
        mysqli_query($conexao, "INSERT INTO historico (his_produto, his_quantidade, his_fornecedor) VALUES ('$nome', '$qtd', '$fornecedor')");
    }
    header("Location: EstoqueAngico.php");
}

// 2. Excluir Produto
if (isset($_GET['excluir'])) {
    $id = $_GET['excluir'];
    mysqli_query($conexao, "DELETE FROM produtos WHERE pro_id = $id");
    header("Location: EstoqueAngico.php");
}

// 3. Editar Produto (Processar Alteração)
if (isset($_POST['btn-editar'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $qtd_nova = $_POST['qtd'];
    $preco = $_POST['preco'];
    $motivo = $_POST['fornecedor2'];

    // Buscar quantidade antiga para o histórico
    $res = mysqli_query($conexao, "SELECT pro_quantidade FROM produtos WHERE pro_id = $id");
    $prod = mysqli_fetch_assoc($res);
    $dif = $qtd_nova - $prod['pro_quantidade'];

    $sql = "UPDATE produtos SET pro_nome='$nome', pro_quantidade='$qtd_nova', pro_preco='$preco', pro_fornecedor='$motivo' WHERE pro_id=$id";
    if (mysqli_query($conexao, $sql) && $dif != 0) {
        mysqli_query($conexao, "INSERT INTO historico (his_produto, his_quantidade, his_fornecedor) VALUES ('$nome', '$dif', '$motivo')");
    }
    header("Location: EstoqueAngico.php");
}

// Variável para controlar se exibe o formulário de edição
$editar_dados = null;
if (isset($_GET['editar'])) {
    $id_edit = $_GET['editar'];
    $res_edit = mysqli_query($conexao, "SELECT * FROM produtos WHERE pro_id = $id_edit");
    $editar_dados = mysqli_fetch_assoc($res_edit);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Estoque Angico-PetShop</title>
    <style>
        :root { --primary: #2563eb; --danger: #dc2626; --success: #16a34a; --bg: #f8fafc; --text: #334155; }
        body { font-family: sans-serif; background: var(--bg); color: var(--text); padding: 20px; }
        .container { max-width: 900px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background: #f4f4f4; }
        .form-section { background: #f1f5f9; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        input { padding: 8px; margin: 5px 0; width: 100%; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        .btn { padding: 8px 12px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; color: white; font-size: 14px; display: inline-block; text-align: center; }
        .btn-add { background: var(--success); }
        .btn-edit { background: var(--primary); }
        .btn-del { background: var(--danger); }
        .btn-cancel { background: #64748b; }
        
        /* Estilos adicionais para a barra de busca */
        .search-bar { display: flex; gap: 10px; margin-bottom: 20px; align-items: center; background: #f1f5f9; padding: 10px; border-radius: 5px; }
        .search-bar input { margin: 0; flex: 1; }
    </style>
</head>
<body>

<div class="container">
    <h1>📦 Gestão de Estoque</h1>

    <div class="form-section">
        <?php if ($editar_dados): ?>
            <h2>Editar Produto: <?php echo $editar_dados['pro_nome']; ?></h2>
            <form method="POST">
                <input type="hidden" name="id" value="<?php echo $editar_dados['pro_id']; ?>">
                <label>Nome:</label> 
                <input type="text" name="nome" value="<?php echo $editar_dados['pro_nome']; ?>" required>
                <label>Quantidade:</label> 
                <input type="number" name="qtd" value="<?php echo $editar_dados['pro_quantidade']; ?>" required>
                <label>Fornecedor/Motivo</label>
                <input type="text" name="fornecedor2" value="<?php echo $editar_dados['pro_fornecedor']?>" required>
                <label>Preço:</label> 
                <input type="number" step="0.01" name="preco" value="<?php echo $editar_dados['pro_preco']; ?>" required>
                <button type="submit" name="btn-editar" class="btn btn-edit">Salvar Alterações</button>
                <a href="EstoqueAngico.php" class="btn btn-cancel">Cancelar</a>
            </form>
        <?php else: ?>
            <h2>Cadastrar Novo Produto</h2>
            <form method="POST">
                <input type="text" name="nome" placeholder="Nome do Produto" required>
                <input type="number" name="qtd" placeholder="Qtd. Inicial" required>
                <input type="number" step="0.01" name="preco" placeholder="Preço (ex: 10.50)" required>
                <input type="text" name="fornecedor" placeholder="Fornecedor" required>
                <button type="submit" name="btn-cadastrar" class="btn btn-add">Cadastrar Produto</button>
            </form>
        <?php endif; ?>
    </div>

    <form method="GET" class="search-bar">
        <input type="text" name="busca" placeholder="Consultar por nome do produto ou fornecedor..." value="<?php echo isset($_GET['busca']) ? htmlspecialchars($_GET['busca']) : ''; ?>">
        <button type="submit" class="btn btn-edit">Pesquisar</button>
        <?php if (!empty($_GET['busca'])): ?>
            <a href="EstoqueAngico.php" class="btn btn-cancel">Limpar</a>
        <?php endif; ?>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Produto</th>
                <th>Fornecedor</th>
                <th>Qtd.</th>
                <th>Preço</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // VERIFICA SE EXISTE UMA BUSCA E ADAPTA A QUERY
            $busca = isset($_GET['busca']) ? mysqli_real_escape_string($conexao, $_GET['busca']) : '';
            
            if (!empty($busca)) {
                // Pesquisa por nome do produto OU fornecedor
                $query_produtos = "SELECT * FROM produtos WHERE pro_nome LIKE '%$busca%' OR pro_fornecedor LIKE '%$busca%' ORDER BY pro_id DESC";
            } else {
                // Lista padrão sem busca
                $query_produtos = "SELECT * FROM produtos ORDER BY pro_id DESC";
            }
            
            $produtos = mysqli_query($conexao, $query_produtos);

            // Verifica se encontrou algum produto
            if (mysqli_num_rows($produtos) > 0):
                while ($row = mysqli_fetch_assoc($produtos)): 
            ?>
            <tr>
                <td><?php echo $row['pro_id']; ?></td>
                <td><?php echo $row['pro_nome']; ?></td>
                <td><?php echo $row['pro_fornecedor']; ?></td>
                <td style="font-weight: bold; color: <?php echo $row['pro_quantidade'] < 5 ? 'red' : 'green'; ?>">
                    <?php echo $row['pro_quantidade']; ?>
                </td>
                <td>R$ <?php echo number_format($row['pro_preco'], 2, ',', '.'); ?></td>
                <td>
                    <a href="?editar=<?php echo $row['pro_id']; ?>" class="btn btn-edit">Editar</a>
                    <a href="?excluir=<?php echo $row['pro_id']; ?>" class="btn btn-del" onclick="return confirm('Excluir produto?')">Excluir</a>
                </td>
            </tr>
            <?php 
                endwhile; 
            else:
            ?>
            <tr>
                <td colspan="6" style="text-align: center; color: #64748b;">Nenhum produto encontrado.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <h2 style="margin-top: 40px;">📜 Histórico Recente</h2>
    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Produto</th>
                <th>Alteração</th>
                <th>Fornecedor/Motivo</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $his = mysqli_query($conexao, "SELECT * FROM historico ORDER BY his_datahora DESC LIMIT 10");
            if (mysqli_num_rows($his) > 0):
                while ($histo = mysqli_fetch_assoc($his)):
                    $cor = $histo['his_quantidade'] > 0 ? 'green' : 'red';
                    $sinal = $histo['his_quantidade'] > 0 ? '+' : '';
            ?>
            <tr>
                <td><?php echo isset($histo['his_datahora']) ? date('d/m H:i', strtotime($histo['his_datahora'])) : 'N/A'; ?></td>
                <td><?php echo $histo['his_produto']; ?></td>
                <td style="color: <?php echo $cor; ?>; font-weight:bold;">
                    <?php echo $sinal . $histo['his_quantidade']; ?>
                </td>
                <td><?php echo $histo['his_fornecedor']; ?></td>
            </tr>
            <?php 
                endwhile;
            else: 
            ?>
            <tr>
                <td colspan="4" style="text-align: center; color: #64748b;">Nenhum histórico registrado.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>