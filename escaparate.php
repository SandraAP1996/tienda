<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Bootstrap Example</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>

        <?php
        /////////////////////////////////////////////////////////////////      CONEXION A LA BASE DE DATOS BADULAKE
        @$dwes = new mysqli('localhost','root', '', 'badulaque');

        /*if ($dwes->connect_errno != null) { 
            echo 'Error conectando a la base de datos: '; 
            echo '$dwes->connect_error'; exit(); 
        }else{
            echo 'Exito en la conexion a Badulaque<br>';
        }*/
        /////////////////////////////////////////////////////////////////


        //////////////////////////////////////     INTRODUCCIÓN DE LOS DATOS 1 REFRESCO

        $consulta = "SELECT * FROM `productos`";
        $resultado = $dwes->query($consulta);
        $consult_datos = $resultado->fetch_object();





        // Se inicia la sesión o se recupera la anterior sesión existente
        session_start();

        $hora = time();
        if (!isset($_SESSION['inicio']) && !isset($_SESSION['expira'])) {
            $_SESSION['inicio'] = $hora;
            $_SESSION['expira'] = $hora + (1*60);
        }

        if(isset($_SESSION['inicio']) && isset($_SESSION['expira'])){
            if($hora >= $_SESSION['expira']){
                session_destroy();
            }
        }
        $hace = $hora - $_SESSION['inicio'];
        $inicio= "<p>Inició sesión hace ". floor($hace / 60) .
            " minutos y " . ($hace % 60) . " segundos</p>";
        if ($hora > $_SESSION['expira']) {
            $hace = $hora - $_SESSION['expira'];
            $fin= "<p>Su sesión finalizó hace ". floor($hace / 60) .
                " minutos y " . ($hace % 60) . " segundos</p>";
        } else {
            $hace = $_SESSION['expira'] - $hora;
            $tiempo= "<p>Su sesión finaliza en ". floor($hace / 60) .
                " minutos y " . ($hace % 60) . " segundos</p>";
        }






        // Se comprueba si la variable ya existe
        if (!isset($_SESSION['Tomates']))
            $_SESSION['Tomates']= 0;

        if (!isset($_SESSION['Platanos']))
            $_SESSION['Platanos']= 0;

        if (!isset($_SESSION['Arroz']))
            $_SESSION['Arroz']= 0;

        if (!isset($_SESSION['Macarrones']))
            $_SESSION['Macarrones']= 0;



        if($_POST){
            ///////////   VARIABLES PASADAS
            @$tomates=$_REQUEST['1'];
            @$platanos=$_REQUEST['2'];
            @$arroz=$_REQUEST['3'];
            @$macarrones=$_REQUEST['4'];



            ///////////     VALORES DE LOS PRODUCTOS

            /////   Tomates
            if(isset($_POST['1']) && $tomates == "+"){
                $_SESSION['Tomates']++;
            }

            if(isset($_POST['1']) && $tomates == "-" && $_SESSION['Tomates']>0){
                $_SESSION['Tomates']--;
            }

            if(isset($_POST['1']) && $tomates == "papelera"){
                $_SESSION['Tomates']=0;
            }


            /////   Platanos
            if(isset($_POST['2']) && $platanos == "+"){
                $_SESSION['Platanos']++;
            }
            if(isset($_POST['2']) && $platanos == "-" &&  $_SESSION['Platanos']>0){
                $_SESSION['Platanos']--;
            }
            if(isset($_POST['2']) && $platanos == "papelera"){
                $_SESSION['Platanos']=0;
            }

            /////   Arroz
            if(isset($_POST['3']) && $arroz == "+"){
                $_SESSION['Arroz']++;
            }

            if(isset($_POST['3']) && $arroz == "-" && $_SESSION['Arroz']>0){
                $_SESSION['Arroz']--;
            }

            if(isset($_POST['3']) && $arroz == "papelera"){
                $_SESSION['Arroz']=0;
            }


            /////   Macarrones
            if(isset($_POST['4']) && $macarrones == "+"){
                $_SESSION['Macarrones']++;
            }

            if(isset($_POST['4']) && $macarrones == "-" && $_SESSION['Macarrones']>0){
                $_SESSION['Macarrones']--;
            }
            if(isset($_POST['4']) && $macarrones == "papelera"){
                $_SESSION['Macarrones']=0;
            }


        }


        ?>
        <div class="jumbotron text-center">
            <div class="row">
                <div class="col-sm-10">

                    <h1>Productos de la Huerta en Casa</h1>
                    <p>Productos ecologicos en el escaparate de tu tienda más cercana</p>
                </div>
                <div class="col-sm-2">
                    <a href="carrito.php"><img src="img/carrito.PNG" style="weight:150px; height:150px;"></a>
                </div>

            </div>

        </div>
        <form action="escaparate.php" method="post">
            <div class="container">
                <div class="row">
                    <?php     
                    while( $consult_datos != null){

                        $variable=$consult_datos->nombre;

                        echo "
                <div class=\"col-sm-3\">
                    <img src=".$consult_datos->imagen.">
                    <H3>".$consult_datos->nombre."</H3>
                    <p>Stock: ".$consult_datos->stock."</p>
                    <p>".$consult_datos->precio."€ X ".$consult_datos->unidad."</p>
                    <p>".$_SESSION[$variable]." unidades</p>
                     <div class=\"row\" style=\"weight:5px; height:5px;\">
                        <div class=\"col-sm-4\">
                            <input type=\"submit\" name=\"".$consult_datos->codigo."\" value=\"+\">
                        </div>
                        <div class=\"col-sm-4\">
                            <input type=\"submit\" name=\"".$consult_datos->codigo."\" value=\"-\" >
                        </div>
                        <div class=\"col-sm-4\">
                            <input type=\"submit\" name=\"".$consult_datos->codigo."\" value=\"papelera\">
                        </div>
                     </div>
                </div>";

                        if($consult_datos->codigo == "1"){
                            if (!isset($_SESSION['precio_tom']))
                                $_SESSION['precio_tom']= $consult_datos->precio;
                        }
                        if($consult_datos->codigo == "2"){
                            if (!isset($_SESSION['precio_pla']))
                                $_SESSION['precio_pla']= $consult_datos->precio;
                        }
                        if($consult_datos->codigo == "3"){
                            if (!isset($_SESSION['precio_arr']))
                                $_SESSION['precio_arr']= $consult_datos->precio;
                        }
                        if($consult_datos->codigo == "4"){
                            if (!isset($_SESSION['precio_mac']))
                                $_SESSION['precio_mac']= $consult_datos->precio;
                        }


                        $consult_datos = $resultado->fetch_object();
                    }
                    ?>
                </div>
                <?php   
                echo "<br><h3>Sessión de la página:</h3> ".$inicio." ".$tiempo." ".@$fin;

                ?>
            </div>
        </form>
        <div class="row" style="weight:10px; height:10px;"></div>
    </body>
</html>

