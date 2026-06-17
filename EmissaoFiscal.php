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

        <div id="lista-itens"></div>

        <div class="divisor"></div>

        <div class="total-container">
            <span>TOTAL:</span>
            <span id="valor-final">R$0.00</span>
        </div>

        <div class="footer">
            <p>Agradecemos a sua compra!</p>
            <p>Obrigado pela preferência!</p>
        </div>
    </div>

    <div class="area-botoes">
        <a href="index.php" class="btn btn-voltar">⬅ Voltar</a>
        <button class="btn btn-imprimir" onclick="window.print()">🖨️ Imprimir Cupom</button>
    </div>

    <script>
        function carregarCupom() {
            // Puxa os dados salvos no navegador pelo site principal
            const dadosSalvos = localStorage.getItem('dadosCompra');
            const listaItens = document.getElementById('lista-itens');
            const valorFinal = document.getElementById('valor-final');
            const dataEmissao = document.getElementById('data-emissao');

            if (!dadosSalvos) {
                listaItens.innerHTML = "<p style='text-align:center'>Nenhum dado encontrado.</p>";
                return;
            }

            const carrinho = JSON.parse(dadosSalvos);
            let totalGeral = 0;

            // Define a data e hora do momento da emissão
            const agora = new Date();
            dataEmissao.innerText = agora.toLocaleDateString('pt-BR') + ' ' + agora.toLocaleTimeString('pt-BR');

            // Limpa a lista antes de preencher
            listaItens.innerHTML = '';

            carrinho.forEach(item => {
                const subtotal = item.preco * item.qtd; // Multiplicação por quantidade
                totalGeral += subtotal;

                const div = document.createElement('div');
                div.className = 'item-linha';
                div.innerHTML = `
                    <span class="item-nome">${item.qtd}x${item.nome} </span>
                    <span class="item-valor">R$${subtotal.toFixed(2)}</span>
                `;
                listaItens.appendChild(div);
            });

            valorFinal.innerText = ` R$${totalGeral.toFixed(2)}`;
        }

        // Executa a função assim que a página abre
        window.onload = carregarCupom;
    </script>
</body>
</html>