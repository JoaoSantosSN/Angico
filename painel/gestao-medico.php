<?php
// Inicia a sessão para verificar o login
session_start();
include "C:\wamp64\www\ConectaSQL.php";

// Verifica se o médico está realmente logado (segurança)
if (!isset($_SESSION['logado_med'])){
    header("Location: /index.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST["id"];
    $atualizar = mysqli_query($conexao, "UPDATE agenda SET status = 'Cancelada' WHERE id = '$id'");

    if ($atualizar) {
        echo "<script>alert('Consulta cancelada com sucesso!');</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Médico | Angico Petshop</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --vet-primary: #008B8B;
            --vet-bg: #f0f4f4;
            --danger: #ff4d4d;
            --success: #00C896;
            --dark: #1F2937;
        }

        body { font-family: 'Poppins', sans-serif; background: var(--vet-bg); margin: 0; display: flex; }

        /* Sidebar - Menu Lateral */
        .sidebar { width: 250px; background: var(--dark); height: 100vh; color: white; padding: 20px; position: fixed; }
        .sidebar h2 { color: #45df7d; font-size: 1.1rem; margin-bottom: 30px; }
        .nav-link { color: #ccc; text-decoration: none; display: block; padding: 12px 0; border-bottom: 1px solid #333; transition: 0.3s; font-size: 14px; }
        .nav-link:hover { color: white; padding-left: 10px; }
        .med-info { background: #2d3748; padding: 15px; border-radius: 10px; margin-top: 20px; font-size: 13px; }

        /* Conteúdo Principal */
        .main-content { margin-left: 265px; width: calc(100% - 250px); padding: 40px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; border-bottom: 2px solid #ddd; padding-bottom: 15px; }

        /* Tabela de Consultas */
        .card { background: white; border-radius: 15px; padding: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 12px; border-bottom: 2px solid #eee; color: var(--vet-primary); }
        td { padding: 12px; border-bottom: 1px solid #eee; font-size: 14px; }
        
        .badge { padding: 5px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .status-pendente { background: #fff3cd; color: #856404; }
        .status-concluido { background: #d4edda; color: #155724; }

        .btn-action { border: none; padding: 8px 12px; border-radius: 8px; cursor: pointer; transition: 0.3s; font-family: 'Poppins'; font-size: 12px; }
        .btn-finish { background: var(--success); color: white; }
        .btn-finish:hover { background: #00a87d; }
        .btn-cancel { background: #eee; color: #666; margin-left: 5px; }

        /* Filtros */
        .filter-section { margin-bottom: 20px; display: flex; gap: 15px; align-items: center; }
        input[type="date"] { padding: 8px; border-radius: 8px; border: 1px solid #ddd; outline: none; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Angico-PetShop</h2>
    <div class="med-info">
        <strong>Dr(a). <?= $_SESSION['med_nome'] ?></strong><br>
        <span>CRMV: <?= $_SESSION['med_crmv'] ?></span>
    </div>
    <br>
    <a href="/index.php" class="nav-link">🏠 Voltar ao Site</a>
    <a href="#" class="nav-link">📅 Minha Agenda</a>
    <a href="#" class="nav-link">📝 Prontuários</a>
    <a href="/auth/logout.php" class="nav-link" style="margin-top: 50px; color: var(--danger);">🚪 Sair do Painel</a>
</div>

<div class="main-content">
    <div class="header">
        <h1>Gestão de Consultas</h1>
        <div id="relogio" style="font-weight: 500; color: #666;"></div>
    </div>

    <div class="filter-section">
        <label>Visualizar dia:</label>
        <form action="gestao-medico.php" method="get" id="formFiltro">
            <input type="date" name="data" id="filtroData" value="<?= isset($_GET['data']) ? $_GET['data'] : '' ?>"
                onchange="document.getElementById('formFiltro').submit()">
        </form>

        <a href="gestao-medico.php" class="btn-action"
        style="background: var(--dark); color: white;">
            Ver Tudo
        </a>
    </div>

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Horário</th>
                    <th>Data</th>
                    <th>Paciente / Serviço</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $busca = isset($_GET['data']) ? mysqli_real_escape_string($conexao, $_GET['data']) : '';
                if (!empty($busca)) {
                    $sql = "SELECT * FROM  agenda WHERE medico = '{$_SESSION['med_nome']}' AND DATE(data_hora) = '{$busca}' ORDER BY data_hora";
                } else {
                    // Lista padrão sem busca
                    $sql = "SELECT * FROM agenda WHERE medico = '{$_SESSION['med_nome']}' ORDER BY data_hora";
                }
                
                $agendamentos = mysqli_query($conexao, $sql);
                while($agenda = mysqli_fetch_assoc($agendamentos)) {
                    $hora = date('H:i', strtotime($agenda['data_hora']));
                    $data = date('d/m/Y', strtotime($agenda['data_hora']));
                    echo "<tr>
                        <td>{$hora}</td>
                        <td>{$data}</td>
                        <td>{$agenda['nome_dono']}</td>
                        <td>
                            <span class='badge {$agenda['status']}'>
                                {$agenda['status']}
                            </span>
                        </td>
                        <td>
                            <form action='/emitirConsulta.php' method='POST' style='display:inline;'>
                                <input type='hidden' name='id' value='{$agenda['id']}'>

                                <button type='submit' class='btn-action'>
                                    Atender
                                </button>
                            </form>

                            <form action='gestao-medico.php' method='POST' style='display:inline;'>
                                <input type='hidden' name='id' value='{$agenda['id']}'>

                                <button type='submit'
                                        name='cancelar'
                                        class='btn-action'
                                        onclick=\"return confirm('Deseja realmente cancelar esta consulta?')\">
                                    Cancelar
                                </button>
                            </form>
                        </td>
                    </tr>";
                }
            ?>
            </tbody>
        </table>
    </div>
</div>

<script>
class AppMedico {
    constructor() {
        this.tabela = document.getElementById('listaAgendaMed');
        this.filtro = document.getElementById('filtroData');
        this.iniciarRelogio();
    }

    iniciarRelogio() {
        const span = document.getElementById('relogio');
        setInterval(() => {
            const agora = new Date();
            span.innerText = agora.toLocaleDateString() + ' - ' + agora.toLocaleTimeString();
        }, 1000);
    }
}

// Inicializa o painel
const appMed = new AppMedico();
</script>

</body>
</html>