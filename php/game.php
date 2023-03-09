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
        $random_node = array(1,3,7,15,31,63,127,255);
        // numero random entre 1 y 8
        $random = rand(1,8);
        // coje el valor del random del array
        $random = $random_node[$random-1];
        // Creamos todos los nodos necesarios para que funcione
        $nodo = $random;          // Nodo base con el que trabajamos
        $nodoRes = 0;       // Nodo de repuesto
        $numPreg = 1;       // Numero de pregunta
        $proxPreg = 2;      // Pregunta siguiente

        // Obtenemos el numero de nodo [en caso de estar] con $_GET
        if (isset($_GET['n'])) { $nodo = $_GET['n']; }

        // Obtenemos el numero de nodo de respuesta [en caso de estar] con $_GET
        if (isset($_GET['r'])) { $nodoRes = $_GET['r']; }

        // Obtenemos el numero de pregunta [en caso de estar] con $_GET
        if (isset($_GET['p'])) { 
            $numPreg = $_GET['p'];
            $proxPreg = $numPreg + 1; }

        //------------------------------------------------------------------------
        // En caso de haber un nodo de respuesto se añade al array
        if($nodoRes!=0) {
            session_start();            // Iniciamos la sesion
            $nodoRes = array();         // Creamos el array

            // En caos que en la sesion haya algo, añadimos i actualizamos, en caso contrario solo actualizamos
            if (isset($_SESSION['nodoRes'])) { 
                $nodoRes = $_SESSION['nodoRes'];    // Si existe el array lo guardamos en el otro array
                array_push($nodoRes,$nodoRes);      // Añadimos el nodo a la lista
                $_SESSION['nodoRes']=$nodoRes;      // Actualizamos el array de la sesion
            } else {
                array_push($nodoRes,$nodoRes);      // Añadimos el nodo a la lista
                $_SESSION['nodoRes']=$nodoRes;      // Actualizamos el array de la sesion
            }
        }

        //------------------------------------------------------------------------
        // Calculamos los siguientes pasos a seguir con los nodos
        $nodoSi = $nodo * 2;            // Calculamos el nodo del [si]
        $nodoNo = $nodo * 2 + 1;        // Calculamos el nodo del [no]
        $nodoProbSi = $nodoSi;          // Calculamos el nodo del [puede que si]
        $nodoProbNo = $nodoNo;          // Calculamos el nodo del [puede que no]

        //------------------------------------------------------------------------
        // Obtenemos un numero random entre 0 o 1 [eviatmos que recorra siempre el mismo camino]
        $rand = rand(0,1);
        $nodoRand = 0;      //Numero que elegimos
        $nodoRandAlt = 0;   //Numero contrario al anterior

        // En caso de que el numero random sea 0, el nodo random sera el del [si] y el contrario el del [no], en caso contrario, al reves
        if ($rand == 0) { 
            $nodoRand = $nodoSi; 
            $nodoRandAlt = $nodoNo; 
        } else { 
            $nodoRand = $nodoNo; 
            $nodoRandAlt = $nodoSi; }

        if ($nodo == 511) {
            $nodo = 1;
            $nodoSi = 2;
            $nodoNo = 3;
            $nodoRes = 0;
            $numPreg = 1;
            $proxPreg = 2;
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
                // Hacemos la consulta a la BBDD
                $consulta = "SELECT `texto`, `pregunta` FROM `arbol` WHERE `nodo` = $nodo";     // Consulta a la BBDD
                $texto = "";
                $pregunta = true;
                //------------------------------------------------------------------------
                // JUEGO
                    if ($resultado = mysqli_query($enlace, $consulta)) {
                    // En caso de no tener lineas [no haber consulta] mostramos un error, en caso contrario continuamos con el juego
                        if ($resultado->num_rows === 0) {
                            echo("El nodo no existe");
                            exit();
                        } else {
                        // Asignamos los datos de las consultas a las variables
                            while ($fila = mysqli_fetch_row($resultado)) {
                                $texto = $fila[0];
                                $pregunta = $fila[1]; }
                        // Si es la pregunta final damos una repsuesta, en caso contrario seguimos preguntando
                            if ( $pregunta == 0 ) {
                                echo "<div class='text_preg wrapper'><h3 class='text-center typing-demo'>El teu pokemon es $texto?</h3></div>";
                                echo "<div class='d-flex justify-content-center preguntas alto'>";
                                    echo "<a class='button_preg_dif' href='respuesta.php?r=1&n=".$nodo."&p=".$texto."&np=".$proxPreg."'>Si</a>";
			                        echo "<a class='button_preg_dif' href='respuesta.php?r=0&n=".$nodo."&p=".$texto."&np=".$proxPreg."'>No</a>";
                                echo "</div>";
                            } else {
                                echo "<div class='text_preg wrapper'><h3 class='text-center typing-demo'>$texto</h3></div>";
                                echo "<div class='preguntas d-flex flex-row justify-content-around align-items-center'>";
                                    echo "<div class='d-flex flex-column justify-content-center'>";
                                        echo "<a class='button_preg_dif' href='game.php?n=".$nodoSi."&r=0&np=".$proxPreg."'>Si</a>";
                                        echo "<a class='button_preg_dif' href='game.php?n=".$nodoNo."&r=0&np=".$proxPreg."'>No</a>";
                                    echo "</div>";
                                    echo "<div class='d-flex flex-column justify-content-center'>";
                                        echo "<a class='button_preg' href='game.php?n=".$nodoProbSi."&r=".$nodoProbNo."&np=".$proxPreg."'>Puede que si</a>";
                                        echo "<a class='button_preg' href='game.php?n=".$nodoProbNo."&r=".$nodoProbSi."&np=".$proxPreg."'>Puede que no</a>";
                                        echo "<a class='button_preg' href='game.php?n=".$nodoRand."&r=".$nodoRandAlt."&np=".$proxPreg."'>No lo se</a>";
                                    echo "</div>";
                                echo "</div>";
                            }
                        }
                        mysqli_free_result($resultado);
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