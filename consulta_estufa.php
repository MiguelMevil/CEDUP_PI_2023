<?php
session_start();

if (!isset($_SESSION['email_user'])) {
    header('Location: index.php');
    session_destroy();
    exit();
}

include('conexao.php');

$id_user = $_SESSION['id_user'];

$sql = "SELECT * FROM estufa WHERE id_user = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
$conexao->close();
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
    </style>
</head>

<!--Página-->

<body>

    <div class="wrapper">

        <!--Header-->

        <div class="head">
            <div class="menu-icon" onclick="toggleMenu()">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
            <ul>
                <li><a href="perfil.php">Voltar</a></li>
            </ul>
        </div>

        <!--Botão Dark Mode-->

        <div id="darkModeButton">
            <i id="icon" class="fas fa-moon"></i>
        </div>

        <!--Popup-->

        <div class="login-popup" id="loginPopup">
            <div class="login-popup-content">
                <span class="close" onclick="closeLoginPopup()">&times;</span>
                <div class="central">
                    <h2>Cadastrar Estufa</h2>
                </div>
                <form id="loginFields" method="post" action="cadastrarEstufa.php">
                    <div id="campos">
                        <h3>Digite o código serial:</h3>
                        <input type="text" id="Campo_serial" name="campoSerial" placeholder="Digite o código serial" required autocomplete="off">
                        <button type="submit" class="submit-button">ENVIAR</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="popup" class="popup">
            <div class="popup-content">
                <p>Esta estufa já está cadastrada.</p>
                <div class="central_botao">
                    <button id="fecharPopup">Fechar</button>
                </div>
            </div>
        </div>

        <!--Estrutura-->

        <main>

            <!--Primeira Seção-->

            <section class="module content" style="height: 100vh">
                <div class="container" style="margin-top: 80px">
                    <div class="central">
                        <button onclick="openLoginPopup()" class="submit-button">CADASTRAR ESTUFA</button>
                    </div>

                    <div class="rounded-table">
                        <table class="pure-table pure-table-horizontal">
                            <thead>
                                <tr>
                                    <th scope="col">N. Serial</th>
                                    <th scope="col">Temperatura</th>
                                    <th scope="col">Umidade Solo</th>
                                    <th scope="col">Horário</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($dadoEstufa = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $dadoEstufa['numero_serial'] . "</td>";
                                    echo "<td>" . $dadoEstufa['temperatura'] . "</td>";
                                    echo "<td>" . $dadoEstufa['umidade_solo'] . "</td>";
                                    echo "<td>" . $dadoEstufa['horario'] . "</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
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
        document.addEventListener('DOMContentLoaded', function() {
            const popup = document.getElementById('popup');
            const fecharPopup = document.getElementById('fecharPopup');

            <?php
            if (isset($_SESSION['estufaExiste'])) {
                echo "popup.style.display = 'block';";
                echo "popup.style.display = 'flex';";
                unset($_SESSION['estufaExiste']);
            }
            ?>

            fecharPopup.addEventListener('click', function() {
                popup.style.display = 'none';
            });
        });
    </script>

    <script>
        function openLoginPopup(userId, nome, email, telefone) {
            var loginPopup = document.getElementById('loginPopup');
            var loginPopupContent = document.querySelector('.login-popup-content');

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