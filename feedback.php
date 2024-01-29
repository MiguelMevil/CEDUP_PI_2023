<?php
session_start();

if (!isset($_SESSION['email_user'])) {
    header('Location: index.php');
    session_destroy();
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projeto Oasys - Feedback</title>
    <link rel="stylesheet" href="./estilos/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:400,500,600">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css">
    <script src="https://kit.fontawesome.com/809aa15f99.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
    <link rel="icon" href="img/logo.png">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
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
                <li><a href="index.php">Voltar</a></li>
            </ul>
        </div>

        <!--Botão Dark Mode-->

        <div id="darkModeButton">
            <i id="icon" class="fas fa-moon"></i>
        </div>

        <!--Estrutura-->

        <main>

            <!-- Primeira Seção -->

            <section class="module content" style="height: 100vh">
                <div class="container" style="margin-top: 80px">
                    <form id="editFields" method="POST" action="enviarFeedback.php">
                        <div id="perfil">
                            <div id="campos">
                                <h3>E-mail:</h3>
                                <input type="text" id="Campo_email" name="campoEmail" value="<?php echo $_SESSION['email_user']; ?>" readonly>
            
                                <h3>Deixe seu feedback:</h3>
                                <textarea id="Campo_feedback" name="campoFeedback" rows="10" cols="50"></textarea>
                                
                                <button type="submit" class="submit-button">ENVIAR</button>
                            </div>
                        </div>
                    </form>
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

</body>

</html>