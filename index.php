<?php
session_start();

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Angico-PetShop</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    <style>
        /* ================= RESET & CORES ================= */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --primary: #6C63FF;
            --secondary: #00C896;
            --dark: #1F2937;
            --light: #F9FAFB;
            --gray: #6B7280;
            --green: #4caf50;
            --vet: #008B8B;
        }
        html{ scroll-behavior: smooth; scroll-padding-top: 80px; }

        body { font-family: 'Poppins', sans-serif; background: #fcf6f7; color: var(--dark); overflow-x: hidden; }

        /* ================= NAVBAR ================= */
        .navbar {
            position: sticky; top: 0; background: white;
            display: flex; justify-content: space-between; align-items: center;
            padding: 15px 40px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05); z-index: 100;
        }
        .logo { font-weight: 700; font-size: 20px; color: var(--primary); }
        .nav-links { display: flex; gap: 20px; align-items: center; }
        .nav-links a { text-decoration: none; color: var(--dark); font-weight: 500; cursor: pointer; transition: color 0.3s; }
        .nav-links a:hover { color: var(--primary); }
        .cart-link { background: var(--primary); color: white !important; padding: 6px 15px; border-radius: 20px; transition: 0.3s; }
        
        #user-info { display: none; align-items: center; gap: 10px; }
        #user-name { font-weight: 600; color: var(--primary); }
        .logout-link { font-size: 12px; color: var(--gray) !important; text-decoration: underline; cursor: pointer; }

        /* ================= CARROSSEL ================= */
        .carousel { position: relative; width: 100%; overflow: hidden; }
        .carousel-track { display: flex; transition: transform 0.5s ease-in-out; }
        .carousel-slide {
            min-width: 100%; color: white; border-radius: 0; 
            display: flex; align-items: center; justify-content: space-around;
            padding: 60px 40px; box-sizing: border-box;
        }
        .slide1 { background: linear-gradient(90deg, #FF6A00 0%, #FFB347 100%); }
        .slide2 { background: linear-gradient(90deg, #00b3ff, #6C63FF); }

        .slide-text { max-width: 50%; }
        .slide-text h2 { font-size: 3rem; margin-bottom: 10px; }
        .btn-buy {
            background-color: #1F2937; color: white; border: none; padding: 12px 30px;
            border-radius: 30px; font-weight: 600; cursor: pointer; transition: 0.3s;
        }
        .btn-buy:hover { background-color: var(--secondary); }

        .carousel-btn {
            position: absolute; top: 50%; transform: translateY(-50%);
            background: rgba(255,255,255,0.8); border: none; width: 40px; height: 40px;
            border-radius: 50%; cursor: pointer; z-index: 10; font-size: 1.5rem;
        }
        .prev { left: 20px; }
        .next { right: 20px; }

        /* ================= SEÇÕES ================= */
        .section { max-width: 1100px; margin: 60px auto; padding: 0 20px; }
        .calendar-wrapper { background: white; border-radius: 20px; padding: 25px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
        .calendar-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .calendar-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 8px; }
        .day { background: #F9FAFB; padding: 10px; border-radius: 10px; min-height: 90px; cursor: pointer; }
        .day:hover { background: #eee; }
        .event-chip { background: var(--secondary); color: white; font-size: 10px; padding: 2px 5px; border-radius: 4px; display: block; margin-top: 2px; }

        .produtos-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 25px; }
        .produto-card { background: white; border-radius: 20px; padding: 20px; text-align: center; box-shadow: 0 10px 25px rgba(0,0,0,0.05); transition: 0.3s; }
        .produto-card img { width: 100%; height: 180px; object-fit: cover; border-radius: 15px; margin-bottom: 15px; }
        .btn-primary { background: var(--primary); color: white; border: none; padding: 10px 20px; border-radius: 20px; cursor: pointer; }

        /* ================= MODAIS ================= */
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center; z-index: 200; }
        .modal-content { background: white; padding: 25px; border-radius: 20px; width: 380px; max-width: 90%; position: relative; }
        .modal-footer { display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; }
        .btn-perfil {
            display: block; width: 100%; padding: 12px; margin-bottom: 12px;
            font-size: 15px; cursor: pointer; border: 2px solid var(--primary);
            background-color: transparent; color: var(--primary); border-radius: 12px; transition: all 0.3s; font-weight: 500;
        }
        .btn-perfil:hover { background-color: var(--primary); color: white; }
        .btn-secondary { background: #eee; border: none; padding: 10px 15px; border-radius: 10px; cursor: pointer; }
        .btn-emissao { background-color: var(--secondary); color: white; border: none; padding: 10px 15px; border-radius: 10px; cursor: pointer; font-weight: bold; }

        footer { text-align: center; padding: 40px; color: var(--gray); font-size: 14px; }
        .toast { position: fixed; bottom: 20px; right: 20px; background: var(--secondary); color: white; padding: 12px 25px; border-radius: 10px; display: none; z-index: 1000; }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="logo">🐾 Angico Petshop</div>
    <div class="nav-links">
        <a href="#agenda">Agenda</a>
        <a href="#produtos">Produtos</a>
        
        <span id="auth-links">
            <a onclick="abrirModalAcesso('Login')">Login</a>
            <a onclick="abrirModalAcesso('Cadastro')">Cadastrar-se</a>
        </span>

        <span id="user-info">
            <span id="user-name"></span>
            <a onclick="logout()" class="logout-link">Sair</a>
        </span>

        <a class="cart-link" onclick="abrirCarrinho()">🛒 (<span id="qtdCarrinho">0</span>)</a>
    </div>
</nav>

<div class="carousel">
    <div class="carousel-track">
        <div class="carousel-slide slide1">
            <div class="slide-text">
                <h2>Quinzena do Ronron</h2>
                <p>Até 50% OFF para os gatinhos!</p>
                <button class="btn-buy" onclick="window.location.href='#produtos'">Ver Ofertas</button>
            </div>
        </div>
        <div class="carousel-slide slide2">
            <div class="slide-text">
                <h2>Banho & Tosa</h2>
                <p>Seu pet cheiroso e feliz.</p>
                <button class="btn-buy" onclick="window.location.href='#agenda'">Agendar Agora</button>
            </div>
        </div>
    </div>
    <button class="carousel-btn prev" onclick="mudarSlide(-1)">&#10094;</button>
    <button class="carousel-btn next" onclick="mudarSlide(1)">&#10095;</button>
</div>

<section class="section" id="agenda">
    <h2 style="margin-bottom:20px;">📅 Agenda de Serviços</h2>
    <div class="calendar-wrapper">
        <div class="calendar-header">
            <button class="btn-secondary" onclick="mudarMes(-1)">◀</button>
            <h3 id="mes-ano"></h3>
            <button class="btn-secondary" onclick="mudarMes(1)">▶</button>
        </div>
        <div class="calendar-grid" id="calendar"></div>
    </div>
</section>

<section class="section" id="produtos">
    <h2 style="margin-bottom:30px;">🛍️ Nossos Produtos</h2>
    <div class="produtos-grid">
        <div class="produto-card">
            <img src="https://images.unsplash.com/photo-1583512603805-3cc6b41f3edb" alt="Ração">
            <h3>Ração Premium</h3>
            <p>R$ 89,90</p>
            <button class="btn-primary" onclick="addCarrinho('Ração Premium', 89.90)">Adicionar</button>
        </div>
        <div class="produto-card">
            <img src="https://images.unsplash.com/photo-1601758228041-f3b2795255f1" alt="Mordedor">
            <h3>Brinquedo Mordedor</h3>
            <p>R$ 29,90</p>
            <button class="btn-primary" onclick="addCarrinho('Brinquedo Mordedor', 29.90)">Adicionar</button>
        </div>
        <div class="produto-card">
            <img src="assets/Shampoo.png" alt="Shampoo">
            <h3>Shampoo Pet</h3>
            <p>R$ 39,90</p>
            <button class="btn-primary" onclick="addCarrinho('Shampoo Pet', 39.90)">Adicionar</button>
        </div>
        <div class="produto-card">
            <img src="assets/Condicionador.png" alt="Condicionador">
            <h3>Condicionador Pet</h3>
            <p>R$ 29,90</p>
            <button class="btn-primary" onclick="addCarrinho('Condicionador Pet', 29.90)">Adicionar</button>
        </div>
        <div class="produto-card">
            <img src="assets/AntiPulga.png" alt="Anti-Pulga">
            <h3>Anti-Pulga</h3>
            <p>R$ 19,90</p>
            <button class="btn-primary" onclick="addCarrinho('Anti-Pulga', 19.90)">Adicionar</button>
        </div>
        <div class="produto-card">
            <img src="assets/CamaPet.png" alt="Cama Pet">
            <h3>Cama Pet</h3>
            <p>R$ 59,90</p>
            <button class="btn-primary" onclick="addCarrinho('Cama Pet', 59.90)">Adicionar</button>
        </div>
    </div>
</section>

<div class="modal" id="modalAgenda">
    <div class="modal-content">
        <h3>Novo Agendamento</h3><br>
        <input type="time" id="hora" style="width:100%; padding:10px; margin-bottom:10px; border-radius:8px; border:1px solid #ddd;">
        <input type="text" id="desc" placeholder="Nome do pet e serviço" style="width:100%; padding:10px; margin-bottom:10px; border-radius:8px; border:1px solid #ddd;">
        <div class="modal-footer">
            <button class="btn-secondary" onclick="fecharAgenda()">Cancelar</button>
            <button class="btn-primary" onclick="salvarAgenda()">Salvar</button>
        </div>
    </div>
</div>

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

<div class="modal" id="modalAcesso">
    <div class="modal-content" style="text-align: center;">
        <h3 id="tituloAcesso" style="margin-bottom: 20px;">Fazer Login como:</h3>
        <button class="btn-perfil" onclick="executarAcesso('Cliente')">👤 Sou Cliente</button>
        <button class="btn-perfil" onclick="executarAcesso('Fornecedor')">📦 Sou Fornecedor</button>
        <button class="btn-perfil" onclick="executarAcesso('Funcionário')">💼 Sou Funcionário</button>
        <button class="btn-perfil" style="border-color: var(--vet); color: var(--vet);" onclick="executarAcesso('Veterinário')">🩺 Sou Médico Veterinário</button>
        <div class="modal-footer" style="justify-content: center;">
            <button class="btn-secondary" onclick="fecharModalAcesso()">Cancelar</button>
        </div>
    </div>
</div>

<footer>© 2026 Angico Petshop - Todos os direitos reservados</footer>
<div id="toast" class="toast">Produto adicionado! 🐾</div>

<script>
    /* ===== LÓGICA DE USUÁRIO ===== */
    function atualizarNavbar() {
        const usuario = localStorage.getItem('usuarioNome');
        const linksLogin = document.getElementById('auth-links');
        const infoUsuario = document.getElementById('user-info');
        const displayNome = document.getElementById('user-name');

        if (usuario) {
            linksLogin.style.display = 'none';
            infoUsuario.style.display = 'flex';
            displayNome.innerText = "Olá, " + usuario;
        } else {
            linksLogin.style.display = 'inline';
            infoUsuario.style.display = 'none';
        }
    }

    function logout() {
        localStorage.removeItem('usuarioNome');
        location.reload();
    }

    /* ===== LÓGICA DO CARROSSEL ===== */
    let slideIndex = 0;
    function mudarSlide(n) {
        const track = document.querySelector('.carousel-track');
        const slides = document.querySelectorAll('.carousel-slide');
        if(!track || slides.length === 0) return;
        slideIndex = (slideIndex + n + slides.length) % slides.length;
        track.style.transform = `translateX(-${slideIndex * 100}%)`;
    }
    setInterval(() => mudarSlide(1), 5000);

    /* ===== LÓGICA DA AGENDA ===== */
    const calendar = document.getElementById('calendar');
    const mesAnoLabel = document.getElementById('mes-ano');
    let dataAtual = new Date();
    let eventos = JSON.parse(localStorage.getItem('agenda')) || {};
    let diaSelecionado = null;

    function renderCalendar() {
        if(!calendar) return;
        calendar.innerHTML = '';
        const ano = dataAtual.getFullYear();
        const mes = dataAtual.getMonth();
        mesAnoLabel.innerText = dataAtual.toLocaleDateString('pt-BR', { month: 'long', year: 'numeric' });
        const primeiroDia = new Date(ano, mes, 1).getDay();
        const diasNoMes = new Date(ano, mes + 1, 0).getDate();
        for (let i = 0; i < primeiroDia; i++) calendar.innerHTML += '<div></div>';
        for (let d = 1; d <= diasNoMes; d++) {
            const chave = `${ano}-${mes}-${d}`;
            let htmlEventos = '';
            if (eventos[chave]) {
                eventos[chave].forEach(ev => htmlEventos += `<span class="event-chip">${ev.hora} - ${ev.desc}</span>`);
            }
            const diaDiv = document.createElement('div');
            diaDiv.className = 'day';
            diaDiv.innerHTML = `<strong>${d}</strong>${htmlEventos}`;
            diaDiv.onclick = () => { diaSelecionado = chave; document.getElementById('modalAgenda').style.display = 'flex'; };
            calendar.appendChild(diaDiv);
        }
    }
    function mudarMes(n) { dataAtual.setMonth(dataAtual.getMonth() + n); renderCalendar(); }
    function fecharAgenda() { document.getElementById('modalAgenda').style.display = 'none'; }
    function salvarAgenda() {
        const hora = document.getElementById('hora').value;
        const desc = document.getElementById('desc').value;
        if (!hora || !desc) return alert("Preencha os dados!");
        if (!eventos[diaSelecionado]) eventos[diaSelecionado] = [];
        eventos[diaSelecionado].push({ hora, desc });
        localStorage.setItem('agenda', JSON.stringify(eventos));
        fecharAgenda();
        renderCalendar();
    }

    /* ===== LÓGICA DO CARRINHO ===== */
    let carrinho = [];
    function addCarrinho(nome, preco) {
        const itemExistente = carrinho.find(item => item.nome === nome);
        if (itemExistente) itemExistente.qtd += 1;
        else carrinho.push({ nome, preco, qtd: 1 });
        atualizarCarrinho();
        const toast = document.getElementById('toast');
        toast.style.display = 'block';
        setTimeout(() => toast.style.display = 'none', 2000);
    }
    function atualizarCarrinho() {
        const lista = document.getElementById('listaCarrinho');
        const qtdDisplay = document.getElementById('qtdCarrinho');
        if(qtdDisplay) qtdDisplay.innerText = carrinho.reduce((acc, item) => acc + item.qtd, 0);
        if(!lista) return;
        lista.innerHTML = '';
        let totalGeral = 0;
        carrinho.forEach(item => {
            totalGeral += (item.preco * item.qtd);
            lista.innerHTML += `<div style="display:flex; justify-content:space-between; margin-bottom:10px;"><span>${item.qtd}x ${item.nome}</span><span>R$ ${(item.preco * item.qtd).toFixed(2)}</span></div>`;
        });
        document.getElementById('totalCarrinho').innerText = totalGeral.toFixed(2);
    }
    function abrirCarrinho() { document.getElementById('modalCarrinho').style.display = 'flex'; }
    function fecharCarrinho() { document.getElementById('modalCarrinho').style.display = 'none'; }
    function cupomfiscal() {
        if (carrinho.length === 0) return alert("Carrinho vazio!");
        localStorage.setItem('dadosCompra', JSON.stringify(carrinho));
        window.location.href = "EmissaoFiscal.html";
    }

    /* ===== ACESSO E REDIRECIONAMENTO CORRIGIDO ===== */
    let acaoAcesso = ""; // Armazena se é 'Login' ou 'Cadastro'

    function abrirModalAcesso(acao) {
        acaoAcesso = acao;
        document.getElementById('tituloAcesso').innerText = acao === 'Login' ? 'Fazer Login como:' : 'Cadastrar-se como:';
        document.getElementById('modalAcesso').style.display = 'flex';
    }

    function fecharModalAcesso() { document.getElementById('modalAcesso').style.display = 'none'; }

    function executarAcesso(perfil) {
        let caminho = "";
        
        // Normaliza o perfil para o nome do ficheiro (ex: Funcionário -> funcionario)
        let p = perfil.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "").replace(/\s+/g, "-");

        if (acaoAcesso === "Login") {
            // --- REDIRECIONAMENTO DE LOGIN ---
            if (perfil === 'Veterinário') {
                caminho = "auth/login/login-medico.php";
            } else if (perfil === 'Cliente') {
                caminho = "auth/login/login-Cliente.php";
            } else {
                caminho = `auth/login/login-${p}.php`; // login-funcionario.html ou login-fornecedor.html
            }
        } else {
            // --- REDIRECIONAMENTO DE CADASTRO ---
            if (perfil === 'Veterinário') {
                // login-medico.html já tem a aba de cadastro incluída
                caminho = "auth/cadastro/cadastro-medico.php";
            } else if (perfil === 'Cliente') {
                caminho = "auth/cadastro/cadastro-Cliente.php";
            } else {
                // Segue o padrão: Cadastro-funcionario.html ou Cadastro-fornecedor.html
                caminho = `auth/cadastro/Cadastro-${p}.php`;
            }
        }

        window.location.href = caminho;
    }

    window.addEventListener('load', () => {
        renderCalendar();
        atualizarNavbar();
    });
</script>

</body>
</html>