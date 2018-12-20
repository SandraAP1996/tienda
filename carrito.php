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
        ?>



        <div class="jumbotron text-center">
            <div class="row">
                <div class="col-sm-10">

                    <h1>Carrito de la Huerta</h1>
                    <p>Tus productos seleccionados de tu tienda ecológica más cercana</p>
                </div>
                <div class="col-sm-2">
                    <a href="escaparate.php"><img src="img/tienda.PNG" style="weight:150px; height:150px;"></a>
                </div>

            </div>

        </div>

        <div class="container">
            <div class="row">

                <?php   


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







                if($_SESSION['Platanos'] <= 0 && $_SESSION['Arroz'] <= 0 && $_SESSION['Tomates'] <= 0 && $_SESSION['Macarrones'] <= 0){
                    echo "<h1>No ha añadido nada al carrito</h1>";

                }else{

                    echo "<h1>Carrito de tu compra</h1>";


                    if(isset($_SESSION['Platanos']) && $_SESSION['Platanos'] > 0)
                        echo "<span style=\" font-size:20px;\">-Platanos: </span>".$_SESSION['Platanos']." unidades   -   precio  ".$_SESSION['precio_pla']."€<br>";

                    if(isset($_SESSION['Arroz']) && $_SESSION['Arroz'] > 0)
                        echo "<span style=\" font-size:20px;\">-Arroz: </span>".$_SESSION['Arroz']." unidades   -   precio  ".$_SESSION['precio_arr']."€<br>";

                    if(isset($_SESSION['Tomates']) && $_SESSION['Tomates'] > 0)
                        echo "<span style=\" font-size:20px;\">-Tomates: </span>".$_SESSION['Tomates']." unidades   -   precio  ".$_SESSION['precio_tom']."€<br>";

                    if( isset($_SESSION['Macarrones']) && $_SESSION['Macarrones'] > 0){
                        echo "<span style=\" font-size:20px;\">-Macarrones: </span>".$_SESSION['Macarrones']." unidades   -   precio  ".$_SESSION['precio_mac']."€<br>";
                    }
                    echo "------------------------------------------------------------------------------------<br>";


                    $precio= ($_SESSION['precio_pla'] * $_SESSION['Platanos'])+($_SESSION['precio_arr']*$_SESSION['Arroz'])+($_SESSION['precio_tom']*$_SESSION['Tomates'])+($_SESSION['precio_mac']*$_SESSION['Macarrones']);
                    $unidades=$_SESSION['Arroz']+$_SESSION['Platanos']+$_SESSION['Tomates']+$_SESSION['Macarrones'];

                    echo "<span style=\" font-size:30px;\">Total:      ".$precio."€ </span>  unidades   ".$unidades;

                }

                                 echo "<br><br><br><h3>Sessión de la página:</h3> ".@$inicio." ".@$tiempo." ".@$fin;
                ?>              

            </div>
        </div>


    </body>
</html>
