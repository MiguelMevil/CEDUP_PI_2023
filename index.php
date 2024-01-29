<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projeto Oasys - Página Inicial</title>
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
                <li><a href="#Home">Home</a></li>
                <li><a href="#Sobre">Sobre</a></li>
                <li><a href="#Galeria">Galeria</a></li>
                <li><a href="#Contato">Contato</a></li>
                <?php
                if (isset($_SESSION['email_user'])) {
                    echo '<li><a href="perfil.php">Perfil<i class="fa-solid fa-user" style="color: #ffffff; margin-left: 10px;"></i></a></li>';
                    echo '<li><a href="logout.php">Sair<i class="fa-solid fa-right-from-bracket" style="color: #ffffff; margin-left: 10px;"></i></a></li>';
                } else {
                    echo '<li><a onclick="openLoginPopup()">Login<i class="fa-solid fa-user" style="color: #ffffff; margin-left: 10px;"></i></a></li>';
                }
                ?>
            </ul>
        </div>

        <div id="popupDinamico" class="popup">
            <div class="popup-content">
                <p id="mensagemPopup"></p>
                <div class="central_botao">
                    <button id="fecharPopup">Fechar</button>
                </div>
            </div>
        </div>

        <!--Botão Dark Mode-->

        <div id="darkModeButton">
            <i id="icon" class="fas fa-moon"></i>
        </div>

        <!--Popup Login-->

        <div class="login-popup" id="loginPopup">
            <div class="login-popup-content">
                <span class="close" onclick="closeLoginPopup()">&times;</span>
                <div class="central">
                    <h2>Login</h2>
                </div>
                <form id="loginFields" method="post" action="loginUsuario.php">
                    <div id="campos">
                        <h3>E-mail:</h3>
                        <input type="text" id="Campo_email" name="campoEmail" placeholder="Digite seu e-mail" required autocomplete="off" onblur="validacaoEmail(this)">

                        <h3>Senha:</h3>
                        <input type="password" id="Campo_senha1" name="campoSenha" placeholder="Digite sua senha" required>

                        <button type="submit" class="submit-button">LOGIN</button>

                        <div class="central">
                            <p onclick="switchToRegisterForm()">Não tem uma conta? <b>Cadastre-se!</b></p>
                        </div>
                        <div class="central">
                            <a href="login_adm.php">
                                <h5>Logar como administrador</h5>
                            </a>
                        </div>
                    </div>
                </form>

                <!--Registro-->

                <form style="display: none" id="registerFields" method="post" action="cadastrar.php">
                    <div id="campos">
                        <h3>Nome:</h3>
                        <input type="text" id="Campo_nome" name="campoNome" placeholder="Digite seu nome" required oninvalid="this.setCustomValidity('Por favor, preencha este campo.')">

                        <h3>E-mail:</h3>
                        <input type="text" id="Campo_email" name="campoEmail" placeholder="Digite seu e-mail" required autocomplete="off" onblur="validacaoEmail(this)">

                        <h3>Telefone:</h3>
                        <input type="text" id="Campo_telefone" name="campoTelefone" pattern="\([0-9]{2}\) [0-9]{5}-[0-9]{4}" placeholder="Digite seu número de telefone" required autocomplete="off">

                        <h3>Senha:</h3>
                        <input type="password" id="Campo_senha2" name="campoSenha" placeholder="Digite sua senha" required>

                        <h3>Confirme a Senha:</h3>
                        <input type="password" id="Campo_confirmarSenha" name="campoConfirmarSenha" placeholder="Confirme sua senha" required>
                        <span id="msgsenha"></span>

                        <button type="submit" class="submit-button" onclick="return validarSenha();">CADASTRAR</button>

                        <div class="central">
                            <p onclick="swithToLoginForm()">Já possui uma conta?</p>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!--Estrutura-->

        <main>

            <!--Primeira Seção-->

            <section class="module parallax parallax-1" id="Home">
                <h1 data-aos="fade-down">Projeto Oasys</h1>
            </section>

            <section class="module content">
                <div class="container">
                    <h2 data-aos="fade-right">O OASYS</h2>
                    <p data-aos="fade-right">
                        Este projeto envolve a criação de uma estufa interna projetada para ser tanto funcional
                        quanto
                        esteticamente agradável. A ideia é criar um ambiente onde as plantas possam crescer e
                        prosperar
                        de forma autônoma, enquanto também adicionam um toque de verde e serenidade à decoração de
                        interiores.
                    </p>
                    <p data-aos="fade-right">
                        Além de fornecer um ambiente propício para o crescimento das plantas, este projeto oferece
                        benefícios adicionais, como a autonomia na manutenção das plantas, a melhoria da qualidade
                        do ar
                        e da temperatura interior. Sendo uma maneira de combinar tecnologia e natureza para criar um
                        ambiente doméstico mais agradável e saudável.
                    </p>
                </div>
            </section>

            <!--Segunda Seção-->

            <section class="module parallax parallax-2" id="Sobre">
                <h1 data-aos="fade-down">Sobre o Projeto</h1>
            </section>

            <section class="module content">
                <div class="container">
                    <h2 data-aos="fade-right">O PROJETO</h2>
                    <p data-aos="fade-right">
                        Os principais componentes deste projeto incluem um Arduino como o principal componente do
                        sistema, sensores de umidade e temperatura para monitorar as condições ambientais dentro da
                        estufa, um sistema de irrigação automatizada que é controlado pelo Arduino com base na
                        umidade
                        do solo e uma estrutura feita de acrílico que cria o ambiente da estufa. </p>
                    <p data-aos="fade-right">
                        Em termos de estética, a estufa foi cuidadosamente planejada para ser visualmente agradável.
                        Sua
                        estrutura de acrílico proporciona uma experiência única, permitindo que as plantas
                        sejam vistas de todos os ângulos. Isso não só contribui para a decoração, mas também cria
                        uma
                        exibição aconchegante e convidativa.
                    </p>
                </div>
            </section>

            <!--Terceira Seção-->

            <section class="module parallax parallax-3" id="Galeria">
                <h1 data-aos="fade-down">Galeria</h1>
            </section>
            <section class="module last-content-section">
                <div class="container">
                    <h2 data-aos="fade-right">GALERIA</h2>
                    <p data-aos="fade-right">
                        Galeria de imagens de estufas que inspiraram a inicialização projeto.
                    </p>

                    <div data-aos="fade-right" class="carousel">
                        <div class="carousel-slide">
                            <img src="img/galeria/estufa1.jpg" alt="Slide 1" draggable="false">
                        </div>
                        <div class="carousel-slide">
                            <img src="img/galeria/estufa2.jpg" alt="Slide 2" draggable="false">
                        </div>
                        <div class="carousel-slide">
                            <img src="img/galeria/estufa3.png" alt="Slide 3" draggable="false">
                        </div>
                        <button class="carousel-prev"><i class="fas fa-chevron-left"></i></button>
                        <button class="carousel-next"><i class="fas fa-chevron-right"></i></button>
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
                            <ul>
                                <?php
                                if (isset($_SESSION['email_user'])) {
                                    echo '<li><a href="feedback.php">Feedback</a></li>';
                                } else {
                                    echo '<li><a onclick="openLoginPopup()">Feedback</a></li>';
                                }
                                ?>
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

    <!--Suavidade ao descer/subir pela página-->

    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();

                const targetId = this.getAttribute('href').substring(1);
                const targetElement = document.getElementById(targetId);

                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });
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

    <!--Validar E-mail-->

    <script>
        function validarEmail() {
            var emailField = document.getElementById("Campo_email");
            var email = emailField.value.trim();

            if (email === "") {
                return true;
            }

            usuario = email.substring(0, email.indexOf("@"));
            dominio = email.substring(email.indexOf("@") + 1, email.length);

            if (
                (usuario.length >= 1) &&
                (dominio.length >= 3) &&
                (usuario.search("@") == -1) &&
                (dominio.search("@") == -1) &&
                (usuario.search(" ") == -1) &&
                (dominio.search(" ") == -1) &&
                (dominio.search(".") != -1) &&
                (dominio.indexOf(".") >= 1) &&
                (dominio.lastIndexOf(".") < dominio.length - 1)
            ) {
                document.getElementById("msgemail").innerHTML = "";
                return true;
            } else {
                document.getElementById("msgemail").innerHTML = "<font color='red' style='font-family: Raleway; font-size: 90%;'>E-mail inválido</font>";
                emailField.focus();
                return false;
            }
        }
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

    <!--Login-->

    <script>
        function openLoginPopup() {
            var loginPopup = document.getElementById('loginPopup');
            var loginPopupContent = document.querySelector('.login-popup-content');
            loginPopup.style.display = 'flex';
            loginPopupContent.style.display = 'flex';
        }

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

        function switchToRegisterForm() {
            document.getElementById('loginFields').style.display = 'none';
            document.getElementById('registerFields').style.display = 'block';
        }

        function swithToLoginForm() {
            document.getElementById('registerFields').style.display = 'none';
            document.getElementById('loginFields').style.display = 'block';
        }
    </script>

    <!--Carrossel-->

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const slides = document.querySelectorAll(".carousel-slide");
            let currentSlide = 0;

            function showSlide(n) {
                slides[currentSlide].classList.remove("active");
                currentSlide = (n + slides.length) % slides.length;
                slides[currentSlide].classList.add("active");
            }

            function nextSlide() {
                showSlide(currentSlide + 1);
            }

            function prevSlide() {
                showSlide(currentSlide - 1);
            }

            document.querySelector(".carousel-next").addEventListener("click", nextSlide);
            document.querySelector(".carousel-prev").addEventListener("click", prevSlide);

            showSlide(currentSlide);
        });
    </script>

    <!--Telefone-->

    <script type="text/javascript">
        $(document).ready(function() {
            $("#Campo_telefone").mask("(00) 00000-0000");
        });
    </script>

    <!--Aviso Senha-->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const popupDinamico = document.getElementById('popupDinamico');
            const fecharPopup = document.getElementById('fecharPopup');
            const mensagemPopup = document.getElementById('mensagemPopup');

            <?php
            if (isset($_SESSION['senhaIncorreta']) && $_SESSION['senhaIncorreta']) {
                echo "popupDinamico.style.display = 'block';";
                echo "popupDinamico.style.display = 'flex';";
                echo "mensagemPopup.innerText = 'Dados incorretos.';";
                unset($_SESSION['senhaIncorreta']);
            } elseif (isset($_SESSION['usuarioExiste']) && $_SESSION['usuarioExiste']) {
                echo "popupDinamico.style.display = 'block';";
                echo "popupDinamico.style.display = 'flex';";
                echo "mensagemPopup.innerText = 'Seu e-mail já foi cadastrado.';";
                unset($_SESSION['usuarioExiste']);
            }
            ?>

            fecharPopup.addEventListener('click', function() {
                popupDinamico.style.display = 'none';
            });
        });
    </script>

    <script>
        function validarSenha() {
            var senha = document.getElementById("Campo_senha2").value;
            var confirmarSenha = document.getElementById("Campo_confirmarSenha").value;
            if (senha != confirmarSenha) {
                document.getElementById("msgsenha").innerHTML = "<font color='red' style='font-family: Raleway; font-size: 90%;'>Senha não coincide</font>";
                return false;
            } else {
                return true;
            }
        }
    </script>

</body>