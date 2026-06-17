<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cupom Fiscal - Angico Petshop</title>
    <style>
        /* Estilos para visualização na tela */
        body {
            font-family: 'Courier New', Courier, monospace;
            background-color: #f0f0f0;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            margin: 0;
        }

        .cupom-container {
            background-color: white;
            width: 320px;
            padding: 20px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            border-top: 8px solid #6C63FF;
        }

        .header {
            text-align: center;
            border-bottom: 1px dashed #000;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }

        .header h2 { margin: 0; font-size: 22px; }
        .header p { margin: 5px 0; font-size: 12px; }

        .item-linha {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .item-nome { flex: 2; }
        .item-valor { flex: 1; text-align: right; }

        .divisor {
            border-top: 1px dashed #000;
            margin: 15px 0;
        }

        .total-container {
            font-weight: bold;
            font-size: 18px;
            display: flex;
            justify-content: space-between;
        }

        .footer {
            text-align: center;
            margin-top: 25px;
            font-size: 12px;
        }

        /* Botões de Ação */
        .area-botoes {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            font-family: 'Poppins', sans-serif;
            transition: 0.3s;
        }

        .btn-imprimir { background-color: #4caf50; color: white; }
        .btn-voltar { background-color: #6B7280; color: white; text-decoration: none; display: flex; align-items: center; }
        .btn:hover { opacity: 0.8; transform: scale(1.05); }

        /* REGRAS DE IMPRESSÃO - Esconde o que não deve sair no papel */
        @media print {
            body { background-color: white;}
            .cupom-container { width: 100%; border:0;}
            .area-botoes { display: none; }
        }
    </style>
</head>
<body>

    <div class="cupom-container">
        <div class="header">
            <h2>ANGICO PETSHOP</h2>
            <p>CNPJ: 00.000.000/0001-90</p>
            <p>Rua dos Angicos, 456 - Amazonias</p>
            <p id="data-emissao"></p>
        </div>

        <div id="lista-itens">
            <?php
            include "C:\wamp64\www\ConectaSQL.php";
            if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
                $atualizar = mysqli_query($conexao, "UPDATE agenda SET status = 'Concluida' WHERE id = {$_POST['id']}");
                $consulta = mysqli_query($conexao, "SELECT * FROM agenda WHERE id = {$_POST['id']}");
            
                $dados = mysqli_fetch_array($consulta);

                echo "<div class='item-linha'>
                        <span class='item-nome'>{$dados['servico']} - {$dados['nome_pet']}</span>
                        <span class='item-valor'>{$dados['data_hora']}</span>
                      </div>
                ";
            }
            ?>
        </div>

        <div class="divisor"></div>

        <div class="total-container">
            <span>DOUTOR:</span>
            <span id="valor-final"><?php echo isset($dados['medico']) ? $dados['medico'] : 'Não especificado'; ?></span>
        </div>

        <div class="footer">
            <p>Obrigado pela preferência!</p>
        </div>
    </div>

    <div class="area-botoes">
        <a href="/painel/gestao-medico.php" class="btn btn-voltar">⬅ Voltar</a>
        <button class="btn btn-imprimir" onclick="window.print()">🖨️ Imprimir Cupom</button>
    </div>

    <script>
        function carregarCupom() {
            const dataEmissao = document.getElementById('data-emissao');

            const agora = new Date();
            dataEmissao.innerText = agora.toLocaleDateString('pt-BR') + ' ' + agora.toLocaleTimeString('pt-BR');
        }

        window.onload = carregarCupom;
    </script>
</body>
</html>