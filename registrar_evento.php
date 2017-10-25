<!DOCTYPE html>

<?php
    session_start();
    ///*
    if(!isset($_SESSION["Rol"])){
        header("location:cerrar.php");
    }else if($_SESSION["Rol"] != 0){
        header("location:index.php");
    }
    //*/
?>

<html lang="en">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Registro de evento</title>

    </head>

    <body>

        <h1>Registro de eventos</h1>

        <form action="" method="post">

            <p>Nombre del evento: <input type="text" name="nombre" id="nombre" required="required"></p>
            <p>Fecha del evento: <input type="date" name="fecha" id="fecha" required="required"></p>

            Disponibilidad: <br/><br/>
            Altos: <input type="number" name="altos" id="altos" required="required"><br/>
            Medios: <input type="number" name="medios" id="medios" required="required"><br/>
            VIP: <input type="number" name="vip" id="vip" required="required"><br/>
            Platino: <input type="number" name="platino" id="platino" required="required"><br/><br/>

            <input type="submit" name="boton" value="Registrar">

        </form>

        <?php
            if(isset($_POST["boton"]) && $_POST["boton"] == "Registrar"){
                
                if($_POST["altos"] < 1 || $_POST["medios"] < 1 || $_POST["vip"] < 1 || $_POST["platino"] < 1){
                    echo '<script type="text/javascript">alert("Existe un dato incorrecto.");</script>';

                }else{
                    
                    include 'conexion.php';
                    $conexion = new Conectar();
                    $conexion->ConectarBD();
                    
                    $peticion = "select * from eventos where Nombre='".$_POST["nombre"]."'";
                    $resultado = $conexion->getConexion()->query($peticion);
    
                    if($resultado->num_rows>0){
                        echo '<script type="text/javascript">alert("El evento ya se encuentra registrado.");</script>';
    
                    }else{
                        
                        $peticion = "insert into eventos values('".$_POST["nombre"]."','".$_POST["fecha"]."','".$_POST["altos"]."','".$_POST["medios"]."','".$_POST["vip"]."','".$_POST["platino"]."')"; 
                        $resultado = $conexion->getConexion()->query($peticion);
                        
                        if($resultado->affected_rows > 0){
                            echo '<script type="text/javascript">alert("Evento registrado correctamente.");</script>';
                            header("location:administrador.php");
                            
                        }else{
                            echo '<script type="text/javascript">alert("Error al registrar.");</script>';
                        }
         
                    }

                }
                


            }
        ?>

    </body>

</html>