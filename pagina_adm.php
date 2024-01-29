<?php
session_start();

if (!isset($_SESSION['email_adm'])) {
    header('Location: login_adm.php');
    session_destroy();
    exit();
}

include('conexao.php');

if (isset($_GET['pagina']) && is_numeric($_GET['pagina'])) {
    $pagina = intval($_GET['pagina']);
} else {
    $pagina = 1;
}

$registrosPagina = 10;
$offset = ($pagina - 1) * $registrosPagina;

$sql = "SELECT * FROM usuarios ";
$params = array();

if (isset($_POST['mostrar_tudo'])) {
} elseif (isset($_POST['pesquisa'])) {
    $sql .= "WHERE email_user LIKE ?";
    $params[] = "%" . $_POST['pesquisa'] . "%";
}

$sql .= " ORDER BY id_user DESC LIMIT ? OFFSET ?";
$params[] = $registrosPagina;
$params[] = $offset;

$stmt = $conexao->prepare($sql);

if (!empty($params)) {
    $types = str_repeat('s', count($params) - 2) . 'ii';
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projeto Oasys - Administrador</title>
    <link rel="stylesheet" href="./estilos/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:400,500,600">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css">
    <script src="https://kit.fontawesome.com/809aa15f99.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
    <link rel="icon" href="img/logo.png">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <!--Estilo da Tabela-->

    <style>
        table {
            border-collapse: collapse;
            margin-top: 20px;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.15);
            color: black;
            border-radius: 10px;
        }

        .dark-mode table {
            color: #899095;
        }

        th,
        td {
            border: none;
            padding: 8px;
            text-align: left;
        }

        th,
        td {
            border-right: 1px solid #dddddd;
        }

        .dark-mode th,
        .dark-mode td {
            border-right: #ffffff;
        }

        th:last-child,
        td:last-child {
            border-right: none;
        }

        .icon-black {
            color: black;
        }

        .dark-mode .icon-black {
            color: #899095;
        }

        .seta-esquerda::before {
            content: '\2190';
            font-size: 20px;
            margin-right: 5px;
        }

        .popup {
            align-items: center;
            background: rgba(0, 0, 0, 0.7);
            display: none;
            height: 100%;
            justify-content: center;
            left: 0;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 9999;
            animation: fadeIn 0.2s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .popup-content {
            background: #ffffffdb;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.5);
            padding: 50px;
            text-align: center;
            font-family: 'Raleway', sans-serif;
            font-size: 25px;
        }

        .dark-mode .popup-content {
            background: #212529db;
            color: #899095;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.5);
            padding: 50px;
            text-align: center;
            font-family: 'Raleway', sans-serif;
            font-size: 25px;
        }

        #fecharPopup {
            background: #4CAF50;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            padding: 10px 20px;
            margin-top: 25px;
            color: white;
            font-family: 'Raleway', sans-serif;
            font-size: 20px;
        }

        #fecharPopup:hover {
            background: #45a049;
        }

        .popup-content button {
            height: auto;
            width: 150px;
        }

        button {
            background: #4CAF50;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            padding: 10px 20px;
            margin-top: 25px;
            margin-left: 10px;
            margin-right: 10px;
            color: white;
            font-family: 'Raleway', sans-serif;
            font-size: 20px;
            transition: background-image 0.3s ease, border 0.3s ease, transform 0.3s ease;
        }

        button:hover {
            background: #45a049;
            transform: scale(1.05);
        }

        @media only screen and (max-width: 600px) {

            th,
            td {
                display: none;
            }

            th:nth-child(3),
            td:nth-child(3),
            th:nth-child(5),
            td:nth-child(5) {
                display: table-cell;
                text-align: center;
            }

            th:last-child,
            td:last-child {
                border-bottom: none;
            }
        }
    </style>
</head>

<!--Página-->

<body>

    <div id="popupConfirmacao" class="popup">
        <div class="popup-content">
            <p>Tem certeza de que deseja deletar este usuário?</p>
            <div class="central_botao">
                <button id="confirmarDelecao">Sim</button>
                <button id="cancelarDelecao">Cancelar</button>
            </div>
        </div>
    </div>

    <div class="login-popup" id="loginPopup">
        <div class="login-popup-content">
            <span class="close" onclick="closeLoginPopup()">&times;</span>
            <div class="central">
                <h2>EDITAR USUÁRIO</h2>
            </div>
            <form id="loginFields" method="POST" action="editarUsuario.php">
                <div id="campos">
                    <h3>ID (inalterável):</h3>
                    <input type="text" id="Campo_id" name="campoID" value="" readonly>

                    <h3>Nome:</h3>
                    <input type="text" id="Campo_nome" name="campoNome" placeholder="Digite seu nome" autocomplete="off" required oninvalid="this.setCustomValidity('Por favor, preencha este campo.')">

                    <h3>E-mail:</h3>
                    <input type="text" id="Campo_email" name="campoEmail" placeholder="Digite seu e-mail" required autocomplete="off" onblur="validacaoEmail(this)">

                    <h3>Telefone:</h3>
                    <input type="text" id="Campo_telefone" name="campoTelefone" pattern="\([0-9]{2}\) [0-9]{5}-[0-9]{4}" placeholder="Digite seu número de telefone" required autocomplete="off">

                    <button type="submit" class="submit-button">ENVIAR</button>
                </div>
            </form>
        </div>
    </div>

    <div class="wrapper">

        <!--Header-->

        <div class="head">
            <div class="menu-icon" onclick="toggleMenu()">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
            <ul>
                <li><a href="perfil_adm.php">Voltar</a></li>
            </ul>
        </div>

        <!--Botão Dark Mode-->

        <div id="darkModeButton">
            <i id="icon" class="fas fa-moon"></i>
        </div>

        <!--Estrutura-->

        <main>

            <!--Primeira Seção-->

            <section class="module content" style="height: 100vh">
                <div class="container" style="margin-top: 80px">

                    <form method="POST" action="#">
                        <div id="perfil">
                            <div id="campos">
                                <h3>Pesquisar por E-mail</h3>
                                <div id="pesquisa-container">
                                    <input type="text" name="pesquisa" id="campoPesquisa" placeholder="" autocomplete="off">
                                    <button type="submit"><i class="fas fa-search"></i></button>
                                    <button type="submit" name="mostrar_tudo">Mostrar Tudo</button>
                                </div>
                            </div>
                            <!-- <span id="msginput"></span> -->
                        </div>
                    </form>

                    <div class="rounded-table">
                        <table class="pure-table pure-table-horizontal">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">E-mail</th>
                                    <th scope="col">Telefone</th>
                                    <th scope="col">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($user_data = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $user_data['id_user'] . "</td>";
                                    echo "<td>" . $user_data['username'] . "</td>";
                                    echo "<td>" . $user_data['email_user'] . "</td>";
                                    echo "<td>" . $user_data['fone_user'] . "</td>";
                                    echo '<td> <a href="#" onclick="openLoginPopup(' . $user_data['id_user'] . ', \'' . $user_data['username'] . '\', \'' . $user_data['email_user'] . '\', \'' . $user_data['fone_user'] . '\')"><i class="fas fa-pencil-alt icon-black"></i></a> <a href="#" class="delecao" id_user="' . $user_data['id_user'] . '"><i class="fas fa-trash-alt icon-black"></i></a> </td>';
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginação -->
                    <div class="pagina">
                        <?php
                        $registrosTotais = mysqli_num_rows($conexao->query("SELECT * FROM usuarios"));
                        $paginasTotais = ceil($registrosTotais / $registrosPagina);

                        if (isset($_GET['pagina']) && is_numeric($_GET['pagina'])) {
                            $paginaAtual = intval($_GET['pagina']);
                        } else {
                            $paginaAtual = 1;
                        }

                        if ($paginaAtual > 1) {
                            echo "<button class='button-pagination' onclick=\"window.location.href='pagina_adm.php?pagina=" . ($paginaAtual - 1) . "'\"><span class='seta-esquerda'></span> Anterior</button>";
                        }

                        if ($paginaAtual < $paginasTotais) {
                            echo "<button class='button-pagination' onclick=\"window.location.href='pagina_adm.php?pagina=" . ($paginaAtual + 1) . "';\">Próximo <span class='seta-direita'></span></button>";
                        }
                        ?>
                    </div>

                </div>
            </section>

            <!--Footer/Rodapé-->

            <footer class="footer" id="Contato">
                <div class="footer-container">
                    <div class="row">
                        <div class="footer-col">
                            <h4>Sobre nós</h4>
                            <ul>
                                <p>
                                    Idealializado em 2023, o Projeto Oasys busca desenvolver uma maneira autônoma o
                                    cultivo de plantas em ambientes caseiros, sendo economicamente viável e plausível.
                                </p>
                            </ul>
                        </div>
                        <div class="footer-col">
                            <h4>Contatos</h4>
                            <ul>
                                <p>E-mail: projetooasys@gmail.com</p>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="copyright">Projeto Oasys &copy; 2023 - Todos os direitos reservados</div>
            </footer>

        </main>
    </div>

    <!--Scripts-->

    <!--Biblioteca de animações-->

    <script>
        AOS.init();
    </script>

    <!--Menu Responsivo-->

    <script>
        function toggleMenu() {
            var menu = document.querySelector('.head ul');
            menu.classList.toggle('active');
        }

        document.addEventListener('click', function(e) {
            var menu = document.querySelector('.head ul');
            var menuIcon = document.querySelector('.menu-icon');

            if (!menu.contains(e.target) && !menuIcon.contains(e.target)) {
                menu.classList.remove('active');
            }
        });
    </script>

    <!--Dark Mode-->

    <script>
        // Função para alternar entre o modo claro e escuro
        function toggleDarkMode() {
            const body = document.body;
            body.classList.toggle('dark-mode');

            // Verifica se o modo escuro está ativado e armazena a preferência do usuário no localStorage
            const isDarkMode = body.classList.contains('dark-mode');
            localStorage.setItem('darkMode', isDarkMode);

            // Altera o ícone com base no tema
            const icon = document.getElementById('icon');
            if (isDarkMode) {
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            } else {
                icon.classList.remove('fa-sun');
                icon.classList.add('fa-moon');
            }
        }

        // Verifica e aplica o tema correto ao carregar a página
        window.onload = function() {
            const isDarkMode = JSON.parse(localStorage.getItem('darkMode'));

            if (isDarkMode) {
                document.body.classList.add('dark-mode');
                const icon = document.getElementById('icon');
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            }
        };

        // Evento de clique no botão para alternar o tema
        document.getElementById('darkModeButton').addEventListener('click', toggleDarkMode);
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const popupConfirmacao = document.getElementById('popupConfirmacao');
            const botaoConfirmar = document.getElementById('confirmarDelecao');
            const botaoCancelar = document.getElementById('cancelarDelecao');
            const delecaoLinks = document.querySelectorAll('.delecao');

            delecaoLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const id_user = this.getAttribute('id_user');

                    popupConfirmacao.style.display = 'flex';

                    botaoConfirmar.addEventListener('click', function() {
                        window.location.href = 'deletarUsuario.php?id=' + encodeURIComponent(id_user);
                    });

                    botaoCancelar.addEventListener('click', function() {
                        popupConfirmacao.style.display = 'none';
                    });
                });
            });
        });
    </script>

    <script>
        function openLoginPopup(userId, nome, email, telefone) {
            var loginPopup = document.getElementById('loginPopup');
            var loginPopupContent = document.querySelector('.login-popup-content');
            var campoId = document.getElementById('Campo_id');
            var campoNome = document.getElementById('Campo_nome');
            var campoEmail = document.getElementById('Campo_email');
            var campoTelefone = document.getElementById('Campo_telefone');

            campoId.value = userId;
            campoNome.value = nome;
            campoEmail.value = email;
            campoTelefone.value = telefone;

            loginPopupContent.style.animation = '';
            loginPopup.style.animation = '';

            loginPopup.style.display = 'flex';
            loginPopupContent.style.display = 'flex';
        }
    </script>


    <script>
        function closeLoginPopup() {
            var loginPopup = document.getElementById('loginPopup');
            var loginPopupContent = document.querySelector('.login-popup-content');
            loginPopupContent.style.animation = 'slideOut 0.5s ease-in-out forwards';
            loginPopup.style.animation = 'fadeOut 0.5s ease forwards';

            var campoId = document.getElementById('Campo_id');
            var campoNome = document.getElementById('Campo_nome');
            var campoEmail = document.getElementById('Campo_email');
            var campoTelefone = document.getElementById('Campo_telefone');

            campoId.value = '';
            campoNome.value = '';
            campoEmail.value = '';
            campoTelefone.value = '';

            setTimeout(() => {
                loginPopup.style.display = 'none';
                loginPopupContent.style.display = 'none';
                loginPopup.style.animation = '';
                loginPopupContent.style.animation = '';
            }, 500);
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fecharPopup = document.querySelector('.login-popup-content .close');

            fecharPopup.addEventListener('click', function() {
                resetarCampos();
                closeLoginPopup();
            });

            function resetarCampos() {
                var campoId = document.getElementById('Campo_id');
                var campoNome = document.getElementById('Campo_nome');
                var campoEmail = document.getElementById('Campo_email');
                var campoTelefone = document.getElementById('Campo_telefone');

                campoId.value = '';
                campoNome.value = '';
                campoEmail.value = '';
                campoTelefone.value = '';
            }
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#Campo_telefone").mask("(00) 00000-0000");
        });
    </script>

</body>

</html>