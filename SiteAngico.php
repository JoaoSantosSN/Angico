<?php
session_start();
include_once('ConectaSQL.php');

$mensagem_php = "";

// Lógica de Processamento do Agendamento
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn_agendar'])) {
    $dono = mysqli_real_escape_string($conexao, $_POST['dono']);
    $pet = mysqli_real_escape_string($conexao, $_POST['pet']);
    $servico = $_POST['servico'];
    $data_hora = $_POST['data_hora'];

    $ts = strtotime($data_hora);
    $diaSemana = date('w', $ts);
    $diaMes = date('d-m', $ts);

    $ehFeriado = false;
    switch ($diaMes) {
        case '01-01':
        case '21-04':
        case '01-05':
        case '07-09':
        case '12-10':
        case '02-11':
        case '15-11':
        case '20-11':
        case '25-12':
            $ehFeriado = true;
            break;
    }

    if ($diaSemana == 0) {
        $mensagem_php = "<script>alert('❌ O Petshop não abre aos domingos!');</script>";
    } else if ($ehFeriado) {
        $mensagem_php = "<script>alert('🚩 Hoje é feriado! Estaremos fechados.');</script>";
    } else {
        $sql = "INSERT INTO agendamentos (nome_dono, nome_pet, servico, data_hora) VALUES ('$dono', '$pet', '$servico', '$data_hora')";
        if (mysqli_query($conexao, $sql)) {
            $mensagem_php = "<script>alert('✅ Agendamento de $pet realizado com sucesso!');</script>";
        } else {
            $mensagem_php = "<script>alert('❌ Erro ao salvar: " . mysqli_error($conexao) . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Angico Petshop - Oficial</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #6C63FF;
            --secondary: #00C896;
            --dark: #1F2937;
            --light: #F9FAFB;
            --gray: #6B7280;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #fcf6f7;
            color: var(--dark);
            overflow-x: hidden;
        }

        /* NAVBAR */
        .navbar {
            position: sticky;
            top: 0;
            background: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 40px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            z-index: 100;
        }

        .logo {
            font-weight: 700;
            font-size: 20px;
            color: var(--primary);
        }

        .nav-links {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--dark);
            font-weight: 500;
            transition: 0.3s;
        }

        .nav-links a:hover {
            color: var(--primary);
        }


        /* CARROSSEL */
        .carousel {
            position: relative;
            width: 100%;
            overflow: hidden;
        }

        .carousel-track {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .carousel-slide {
            min-width: 100%;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-around;
            padding: 80px 40px;
            box-sizing: border-box;
        }

        .slide1 {
            background: linear-gradient(90deg, #FF6A00 0%, #FFB347 100%);
        }

        .slide2 {
            background: linear-gradient(90deg, #00b3ff, #6C63FF);
        }

        .slide-text h2 {
            font-size: 3rem;
            margin-bottom: 10px;
        }

        .btn-slide {
            background-color: #1F2937;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        /* ================= ESTILO DA AGENDA (IGUAL SITEANGICO2) ================= */
        .section {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .calendar-wrapper {
            background: white;
            padding: 40px;
            border-radius: 25px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
            max-width: 550px;
            margin: auto;
            border: 1px solid rgba(108, 99, 255, 0.1);
        }

        .calendar-wrapper h3 {
            text-align: center;
            color: var(--primary);
            margin-bottom: 25px;
            font-size: 24px;
            font-weight: 700;
        }

        .input-pet {
            width: 100%;
            padding: 14px;
            margin: 12px 0;
            border: 1.5px solid #eee;
            border-radius: 12px;
            outline: none;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            transition: all 0.3s;
            background: #fdfdfd;
        }

        .input-pet:focus {
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 4px rgba(108, 99, 255, 0.1);
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            border: none;
            width: 100%;
            padding: 16px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-primary:hover {
            background: #564ed9;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(108, 99, 255, 0.3);
        }

        /* PRODUTOS */
        .produtos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }

        .produto-card {
            background: white;
            border-radius: 20px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            transition: 0.3s;
        }

        .produto-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 15px;
        }

        .btn-add {
            background: var(--secondary);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 15px;
            cursor: pointer;
            font-weight: 600;
        }

        footer {
            text-align: center;
            padding: 40px;
            color: var(--gray);
            font-size: 14px;
        }

        .cart-link {
            background: var(--primary);
            color: white !important;
            padding: 6px 15px;
            border-radius: 20px;
            transition: 0.3s;
        }

        .btn-secondary {
            background: #eee;
            border: none;
            padding: 10px 15px;
            border-radius: 10px;
            cursor: pointer;
        }

        .modal-content {
            background: white;
            padding: 25px;
            border-radius: 20px;
            width: 380px;
            max-width: 90%;
            position: relative;
        }
    </style>
</head>

<body>

    <?php echo $mensagem_php; ?>

    <nav class="navbar">
        <div class="logo">🐾 Angico Petshop</div>
        <div class="nav-links">
            <?php if (isset($_SESSION['cli_nome'])): ?>
                <span style="color: var(--primary); font-weight: 600;">Olá,
                    <?php echo htmlspecialchars($_SESSION['cli_nome']); ?>!</span>
                <a href="logout.php" style="color: #e74c3c;">Sair</a>
            <?php else: ?>
                <a href="login-cliente.php">Entrar</a>
            <?php endif; ?>
            <a href="#agenda">Agenda</a>
            <a href="#produtos">Produtos</a>
            <a class="cart-link" onclick="abrirCarrinho()">🛒 (<span id="qtdCarrinho">0</span>)</a>
        </div>
    </nav>
    <div class="modal" id="modalCarrinho">
        <div class="modal-content">
            <h3>🛒 Seu Carrinho</h3>
            <div id="listaCarrinho" style="margin-top:20px; max-height:300px; overflow-y:auto;"></div>
            <hr style="margin:15px 0; border:0; border-top:1px solid #eee;">
            <p style="display:flex; justify-content:space-between; font-weight:bold; font-size:1.1rem;">
                <span>Total:</span>
                <span>R$ <span id="totalCarrinho">0.00</span></span>
            </p>
            <div class="modal-footer">
                <button class="btn-secondary" onclick="fecharCarrinho()">Fechar</button>
                <button class="btn-emissao" onclick="cupomfiscal()">Emitir Cupom</button>
            </div>
        </div>
    </div>
    <div class="carousel">
        <div class="carousel-track">
            <div class="carousel-slide slide1">
                <div class="slide-text">
                    <h2>Quinzena do Ronron</h2>
                    <p>Até 50% OFF para os gatinhos!</p>
                    <button class="btn-slide" onclick="window.location.href='#produtos'">Ver Ofertas</button>
                </div>
            </div>
            <div class="carousel-slide slide2">
                <div class="slide-text">
                    <h2>Banho & Tosa</h2>
                    <p>Seu pet cheiroso e feliz.</p>
                    <button class="btn-slide" onclick="window.location.href='#agenda'">Agendar Agora</button>
                </div>
            </div>
        </div>
    </div>
    <section class="section" id="produtos">
        <h2 style="margin-bottom:20px;">🛍️ Loja</h2>
        <div class="produtos-grid">
            <div class="produto-card">
                <img src="RaçaoCao.png" alt="Ração">
                <h3>Ração Premium</h3>
                <p>R$ 89,90</p>
                <button class="btn-primary" onclick="addCarrinho('Ração Premium', 89.90)">Adicionar</button>
            </div>
            <div class="produto-card">
                <img src="Brinquedo.png" alt="Mordedor">
                <h3>Brinquedo Mordedor</h3>
                <p>R$ 29,90</p>
                <button class="btn-primary" onclick="addCarrinho('Brinquedo Mordedor', 29.90)">Adicionar</button>
            </div>
            <div class="produto-card">
                <img src="Shampoo.png" alt="Shampoo">
                <h3>Shampoo Pet</h3>
                <p>R$ 39,90</p>
                <button class="btn-primary" onclick="addCarrinho('Shampoo Pet', 39.90)">Adicionar</button>
            </div>
            <div class="produto-card">
                <img src="Condicionador.png" alt="Condicionador">
                <h3>Condicionador Pet</h3>
                <p>R$ 29,90</p>
                <button class="btn-primary" onclick="addCarrinho('Condicionador Pet', 29.90)">Adicionar</button>
            </div>
            <div class="produto-card">
                <img src="AntiPulga.png" alt="Anti-Pulga">
                <h3>Anti-Pulga</h3>
                <p>R$ 19,90</p>
                <button class="btn-primary" onclick="addCarrinho('Anti-Pulga', 19.90)">Adicionar</button>
            </div>
            <div class="produto-card">
                <img src="CamaPet.png" alt="Cama Pet">
                <h3>Cama Pet</h3>
                <p>R$ 59,90</p>
                <button class="btn-primary" onclick="addCarrinho('Cama Pet', 59.90)">Adicionar</button>
            </div>
            <div class="produto-card">
                <img src="dentastix.png" alt="Dentastix">
                <h3>Dentastix</h3>
                <p>R$ 14,90</p>
                <button class="btn-primary" onclick="addCarrinho('Dentastix', 59.90)">Adicionar</button>
            </div>
            <div class="produto-card">
                <img src="Bolinha.png" alt="Bolinha Brinquedo">
                <h3>Bolinha Brinquedo</h3>
                <p>R$ 19,90</p>
                <button class="btn-primary" onclick="addCarrinho('Bolinha Brinquedo', 19.90)">Adicionar</button>
            </div>
        </div>
    </section>
    <section class="section" id="agenda">
        <div class="calendar-wrapper">
            <h3>📅 Novo Agendamento</h3>
            <form method="POST">
                <input type="text" name="dono" placeholder="Seu Nome" class="input-pet"
                    value="<?php echo $_SESSION['cli_nome'] ?? ''; ?>" required>

                <input type="text" name="pet" placeholder="Nome do Pet" class="input-pet" required>

                <select name="servico" class="input-pet" required>
                    <option value="">Selecione o Serviço</option>
                    <option value="Banho">Banho</option>
                    <option value="Tosa">Tosa</option>
                    <option value="Consulta">Consulta</option>
                </select>
                <input type="datetime-local" name="data_hora" id="data_input" class="input-pet" required
                    onchange="validar()">
                <button type="submit" name="btn_agendar" class="btn-primary">FINALIZAR AGENDAMENTO</button>
            </form>
        </div>
    </section>

    <footer>© 2026 Angico Petshop - Todos os direitos reservados</footer>

    <script>
        // Lógica do Carrossel
        let slideIndex = 0;
        function mudarSlide() {
            const track = document.querySelector('.carousel-track');
            const slides = document.querySelectorAll('.carousel-slide');
            slideIndex = (slideIndex + 1) % slides.length;
            track.style.transform = `translateX(-${slideIndex * 100}%)`;
        }
        setInterval(mudarSlide, 5000);

        // Bloqueio de datas passadas
        document.getElementById('data_input').min = new Date().toISOString().slice(0, 16);

        function validar() {
            const input = document.getElementById('data_input');
            const dataObj = new Date(input.value);
            const feriados = ['01-01', '21-04', '01-05', '07-09', '12-10', '02-11', '15-11', '20-11', '25-12'];
            const diaMes = String(dataObj.getDate()).padStart(2, '0') + '-' + String(dataObj.getMonth() + 1).padStart(2, '0');

            if (dataObj.getDay() === 0) {
                alert("Fechado aos domingos!");
                input.value = "";
            } else {
                let f = false;
                for (let i = 0; i < feriados.length; i++) {
                    if (feriados[i] === diaMes) f = true;
                }
                if (f) { alert("Data bloqueada: Feriado!"); input.value = ""; }
            }
        }

        let carrinho = [];

        function addCarrinho(nome, preco) {
            const itemExistente = carrinho.find(item => item.nome === nome);
            if (itemExistente) {
                itemExistente.qtd += 1;
            } else {
                carrinho.push({ nome, preco, qtd: 1 });
            }
            atualizarCarrinho();
            alert("Produto adicionado: " + nome); 
        }

        function atualizarCarrinho() {
            const lista = document.getElementById('listaCarrinho');
            const qtdDisplay = document.getElementById('qtdCarrinho');

            // Atualiza o número na Navbar
            if (qtdDisplay) {
                qtdDisplay.innerText = carrinho.reduce((acc, item) => acc + item.qtd, 0);
            }

            if (!lista) return;

            lista.innerHTML = '';
            let totalGeral = 0;

            carrinho.forEach(item => {
                totalGeral += (item.preco * item.qtd);
                lista.innerHTML += `
            <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
                <span>${item.qtd}x ${item.nome}</span>
                <span>R$ ${(item.preco * item.qtd).toFixed(2)}</span>
            </div>`;
            });

            document.getElementById('totalCarrinho').innerText = totalGeral.toFixed(2);
        }

        function abrirCarrinho() {
            document.getElementById('modalCarrinho').style.display = 'flex';
        }

        function fecharCarrinho() {
            document.getElementById('modalCarrinho').style.display = 'none';
        }
    </script>
</body>

</html>