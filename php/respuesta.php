<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>Pokinator</title>
</head>
<body>
    <?php
        require "bd-connect.php";       // Conectamos con la base de datos [don't touch]

        // Cogemos la informacion con el $_GET
        $respuesta = $_GET['r'];
        $nodo = $_GET['n'];
        $nombreAnterior = $_GET['p'];
        $numPreg = $_GET['np'];

        //------------------------------------------------------------------------
        // Formulario respuesta
        function formRespuesta($n, $p) {
            echo "<textarea id='nodo' name='nodo' form='formulario' placeholder='nombre' style='display:none;'>".$n."</textarea>";
	        echo "<textarea id='nombreAnterior' name='nombreAnterior' form='formulario' placeholder='nombre' style='display:none;'>".$p."</textarea>";

            echo "<div class='text_preg wrapper d-flex flex-column div-resposta'>";
                echo "<h3 class='text_preg typing-demo-petit'>Ens hem equivocat! Ajudan's!!</h3>";
            echo "</div>";
            echo "<div class='cagada'>";
                echo "<h4> En qui havies pensat? </h4>";    
                echo "<textarea rows='1' cols='30' id='nombre' name='nombre' form='formulario' placeholder='Nom del pokemon'></textarea>";
                echo "<h4 class='text_preg'>¿Que pregunta faries per diferenciar-lo de ".$p."?</h4>";        
                echo "<textarea rows='1' cols='50' id='caracteristicas' name='caracteristicas' form='formulario' placeholder='Caracteristiques'></textarea>";
                echo "<form action='crear.php' id='formulario' method='POST' >";
                    echo "<button type='submit' name='ENVIAR'>Enviar</button>";
                echo "</form>";
            echo "</div>";
        }
    ?>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg text-dark">
        <div class="container">
            <!-- Logo -->
            <img src="../src/logo.png" class="logo-header">
            <!-- Boton para cuando se hace pequeña -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Menu -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 d-flex justify-content-end align-items-center">
                    <!-- Primer Link a Inicio -->
                    <li class="nav-item"> 
                        <a class="nav-link active fw-bold" aria-current="page" href="../html/index.html">Inici</a>
                    </li>
                    <!-- Segundo Link a ???? -->
                    <li class="nav-item"> 
                        <a class="nav-link active fw-bold" aria-current="page" href="../html/about.html">Qui som?</a>
                    </li>
                    <!-- Tercer Link a ???? -->
                    <li class="nav-item">
                        <a class="nav-link active fw-bold" aria-current="page" href="../html/index.html">FAQ</a>
                    </li>
                    <!-- Dropdown con links a ???? -->
                    <li class="nav-item dropdown fw-bold color_text_blue">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Més Informació</a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item fw-bold color_text_blue" href="../html/gamep.html">Pokemons del joc</a></li>
                          <li><hr class="dropdown-divider"></li>
                          <li><a class="dropdown-item fw-bold color_text_blue" href="../html/versions.html">Control de versions</a></li>
                        </ul>
                    </li>
                    <!-- Link a jugar -->
                    <li class="nav-item"> 
                        <a class="nav-link active fw-bold" aria-current="page" href="../html/ini_game.html"><div class="play-image"></div></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Section -->
    <div class="container mt-5 d-flex justify-content-between">
        <div class="d-flex flex-column align-items-center justify-content-start w-100" id="juego">
            <?php
                //------------------------------------------------------------------------
                // JUEGO
                // Si fallamos hacemos una cosa, en caso contrario significa que habremos acertado
                if ( $respuesta == 0 ) {
                    session_start();            // Iniciamos la sesion
                    $nodosRepuesto = array();   // Creamos el array
                    // Comprovamos si existe la variable sesion
                    if ( isset($_SESSION['nodosRepuesto']) ) {
                        $nodosRepuesto = $_SESSION['nodosRepuesto'];   // Si existe la variable sesion la guardamos en el array
                        $size = count($nodosRepuesto);
                        // Si el tamaño del nodo es diferente a 0
                        if ( $size != 0 ) {
                            $nodoRevisar = array_pop($nodosRepuesto);   // Obtenemos el ultimo elemento del nodo y lo desapilamos
                            $_SESSION['nodosRepuesto'] = $nodosRepuesto; // Guardamos el array en la variable sesion
                            header("Location:game.php?n=".$nodoRevisar."&r=0&np=".$numPreg.""); // Redirigimos a la pagina game.php con el nodo
                        } else {
                            formRespuesta($nodo, $nombreAnterior); // Si el tamaño del nodo es 0 mostramos el formulario
                        }
                    } else {
                        formRespuesta($nodo, $nombreAnterior); // Si no existe la variable sesion mostramos el formulario
                    }
                } else {
                    // Si hemos acertado
                    //------------------------------------------------------------------------
                    // Guardamos el acierto en el log de la BD (tabla partida)
                    
                    $consulta = "INSERT INTO `partida`(`personaje`, `acierto`) VALUES ('".$nombreAnterior."', true)";
                    mysqli_query($enlace, $consulta);

                    //------------------------------------------------------------------------
                    // Borramos la variable de sesion con el array
                    session_start();
                    $arrayVacio =array();	
                    if(isset($_SESSION['nodosRepuesto'])){ $_SESSION['nodosRepuesto']=$arrayVacio; }

                    //------------------------------------------------------------------------
                    // Mostramos el mensaje de acierto
                    echo "<div class='text_preg wrapper d-flex flex-column div-resposta'>";
                        echo "<h3 class='text_preg typing-demo-molt-petit'>El joc s'ha acabat!<h3>";
                    echo "</div>";
                    echo "<div class='d-flex flex-column justify-content-center preguntas'>";
                        echo "<h4 class='acertado text-center'>¿Voleu tornar a jugar?</h4>";
                        echo "<div class='d-flex justify-content-center'>";
                            echo "<a class='button_preg_dif m-5' href='game.php'>Si</a>";
                            echo "<a class='button_preg_dif m-5' href='../html/index.html'>No</a>";
                        echo "</div>";
                    echo "</div>";
                }
            ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="py-5 mt-5 color_primary_yellow">
        <div class="container">
            <div class="row d-flex justify-content-between">
                <!-- Section de informacion -->
                <div class="col-6 col-lg-2 d-flex flex-column align-items-center">
                    <h5 class="fw-bold color_text_blue">Informació</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2"><a href="../html/about.html" class="nav-link p-0 text-center color_text_blue">Qui som?</a></li>
                        <li class="nav-item mb-2"><a href="../html/gamep.html" class="nav-link p-0 text-center color_text_blue">Pokemons del joc</a></li>
                        <li class="nav-item mb-2"><a href="../html/gameq.html" class="nav-link p-0 text-center color_text_blue">Preguntes del joc</a></li>
                        <li class="nav-item mb-2"><a href="../html/index.html" class="nav-link p-0 text-center color_text_blue">FAQs</a></li>
                        <li class="nav-item mb-2"><a href="../html/versions.html" class="nav-link p-0 text-center color_text_blue">Versions</a></li>
                    </ul>
                </div>
                <!-- Section de contacte -->
                <div class="col-6 col-lg-2 d-flex flex-column align-items-center">
                    <h5 class="fw-bold color_text_blue">Xarxes Socials</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2"><a href="https://getbootstrap.com/docs/5.1/examples/footers/#" class="nav-link p-0 text-center color_text_blue">Twitter</a></li>
                        <li class="nav-item mb-2"><a href="https://getbootstrap.com/docs/5.1/examples/footers/#" class="nav-link p-0 text-center color_text_blue">Instagram</a></li>
                        <li class="nav-item mb-2"><a href="https://getbootstrap.com/docs/5.1/examples/footers/#" class="nav-link p-0 text-center color_text_blue">Google+</a></li>
                        <li class="nav-item mb-2"><a href="https://getbootstrap.com/docs/5.1/examples/footers/#" class="nav-link p-0 text-center color_text_blue">Facebook</a></li>
                        <li class="nav-item mb-2"><a href="https://getbootstrap.com/docs/5.1/examples/footers/#" class="nav-link p-0 text-center color_text_blue">LinkedIn</a></li>
                    </ul>
                </div>
                <!-- Section de jugar -->
                <div class="col-12 col-lg-4 offset-1 p-0 m-0">
                    <form class="d-flex flex-column align-items-center">
                        <h5 class="fw-bold color_text_blue">Vols probar pokinator?</h5>
                        <p class="fw-bold text-center color_text_blue">Hem d'endevinar el pokemon en el que estiguis pensant!</p>
                        <a href="../html/ini_game.html" class="btn btn-primary text-light w-75 m-auto mt-4 color_primary_blue">Play</a>
                        <p class="pt-5 text-center fw-bold color_text_blue">&copy;2022 Pokinator, Inc. All rights reserved.</p>
                    </form>
                </div>
            </div>
        </div>
    </footer>
    <script src="../js/bootstrap.bundle.js"></script>
</body>
</html>