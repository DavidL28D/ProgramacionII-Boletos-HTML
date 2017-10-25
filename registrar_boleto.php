<!DOCTYPE html>

<?php
    include 'conexion.php';
    session_start();
    ///*
    if(!isset($_SESSION["Rol"])){
        header("location:cerrar.php");
    }
    //*/
?>

<html lang="en">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Registro de boleto</title>

    </head>

    <body>

        <h1>Registro de boletos</h1>

        <form action="" method="post">

            <input type="number" name="serial" id="serial" placeholder="Serial" required="required"><br/><br/>

            <?php
                if($_SESSION["Rol"] == 1){

                    $conexion = new Conectar();
                    $conexion->ConectarBD();

                    $peticion = "select * from clientes order by Usuario";
                    $resultado = $conexion->getConexion()->query($peticion);

                    if($resultado->num_rows > 0){
                        
                        echo 'Seleccione Usuario: <select name="usuario" id="usuario">';

                         while($usuario = $resultado->fetch_assoc()){
                             if($usuario["Rol"] != 1){
                                 echo "<option value=".$usuario["Usuario"].">".$usuario["Usuario"]."</option>";
                             }
                             
                         }
                        
                        echo'</select><br><br>';

                    }else{
                        echo '<script type="text/javascript">alert("Aun no existen clientes.");</script>';
                    }
                    
                }

                $conexion = new Conectar();
                $conexion->ConectarBD();

                $peticion = "select * from eventos order by Nombre";
                $resultado = $conexion->getConexion()->query($peticion);

                if($resultado->num_rows > 0){
                    
                    echo 'Seleccione Evento: <select name="evento" id="evento">';

                     while($evento = $resultado->fetch_assoc()){
                        echo '<option value="'.$evento["Nombre"].'">'.$evento["Nombre"].'</option>';
                     }
                    
                    echo'</select><br><br>';

                }else{
                    echo '<script type="text/javascript">alert("Aun no existen eventos.");</script>';
                }

            ?>

            Seleccione ubicacion: 
                <select name="ubicacion" id="ubicacion">
                    <option value="0">Altos</option>
                    <option value="1">Medios</option>
                    <option value="2">VIP</option>
                    <option value="3">Platino</option>
                </select><br/><br/><br/>

            <input type="submit" name="boton" value="Registrar">
        </form>

        <?php
            if(isset($_POST["boton"]) && $_POST["boton"] == "Registrar"){

                if($_SESSION["Rol"] == 1){
                    $usuario = $_POST["usuario"];
                }else if($_SESSION["Rol"] == 0){
                    $usuario = $_SESSION["Usuario"];
                }
                
                $peticion = "select * from boletos where Serial='".$_POST["serial"]."'";
                $resultado = $conexion->getConexion()->query($peticion);

                if($resultado->num_rows > 0){
                    echo '<script type="text/javascript">alert("El boleto ya se encuentra registrado.");</script>';

                }else{

                    $peticion = "select * from eventos where Nombre='".$_POST["evento"]."'";
                    $resultado = $conexion->getConexion()->query($peticion);
                    $fecha = $resultado->fetch_assoc();

                    $peticion = "insert into boletos values( '".$_POST["serial"]."','".$_POST["evento"]."','".$fecha["Fecha"]."','".$_POST["ubicacion"]."','".$usuario."')";
                    $resultado = $conexion->getConexion()->query($peticion);
                    
                    if($resultado->affected_rows > 0){
                        echo '<script type="text/javascript">alert("Boleto registrado correctamente.");</script>';
                        header("location:index.php");
                        
                    }else{
                        echo '<script type="text/javascript">alert("Error al registrar.");</script>';
                    }
                            
                }

            }
        ?>

    </body>

</html>