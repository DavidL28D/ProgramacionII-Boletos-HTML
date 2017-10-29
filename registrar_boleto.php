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

        <link rel="stylesheet" type="text/css" href="styles.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Registro de boleto</title>

    </head>

    <body>
    <div id="contenedor">

        <h1 class="titulos">Registro de boletos</h1>

        <form action="" method="get">

            <p class="textos">
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
                    
                    echo 'Seleccione Evento: <select name="evento" id="evento" onchange="cambiar()">';
                    
                    $i = 0;
                     while($evento = $resultado->fetch_assoc()){

                        if(isset($_GET["event"])){
                            if($_GET["event"] == $evento["Nombre"]){
                                echo '<option value="'.$evento["Nombre"].'" selected="selected">'.$evento["Nombre"].'</option>';
                                $variable = $evento["Nombre"];
                            }else{
                                echo '<option value="'.$evento["Nombre"].'">'.$evento["Nombre"].'</option>';
                                $variable = $_GET["event"];
                            }
                        }else{
                            echo '<option value="'.$evento["Nombre"].'">'.$evento["Nombre"].'</option>';
                            if($i == 0){
                                $variable = $evento["Nombre"];
                                $i=1;
                            }
                        }
                        
                     }
                    
                    echo'</select><br><br>';

                }else{
                    echo '<script type="text/javascript">alert("Aun no existen eventos.");</script>';
                    
                }

                $sql = "select * from eventos where Nombre='".$variable."'";
                $resultado = $conexion->getConexion()->query($sql);
                $registro = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
                echo "Disponibilidad: Altos: ".$registro["Altos"].", Medios: ".$registro["Medios"].", VIP: ".$registro["Vip"].", Platino: ".$registro["Platino"]." <br/><br/>";

            ?>

            Seleccione ubicacion: 
                <select name="ubicacion" id="ubicacion">
                    <option value="0">Altos</option>
                    <option value="1">Medios</option>
                    <option value="2">VIP</option>
                    <option value="3">Platino</option>
                </select><br/><br/><br/>

                <input type="submit" formnovalidate name="boton" value="Volver">
            <input type="submit" name="boton" value="Registrar">
            </p>
        </form>

        <?php
            if(isset($_GET["boton"]) && $_GET["boton"] == "Registrar"){

                if($_SESSION["Rol"] == 1){
                    $usuario = $_GET["usuario"];
                }else if($_SESSION["Rol"] == 0){
                    $usuario = $_SESSION["Usuario"];
                }
                
                $peticion = "select * from boletos where Serial='".$_GET["serial"]."'";
                $resultado = $conexion->getConexion()->query($peticion);

                if($resultado->num_rows > 0){
                    echo '<script type="text/javascript">alert("El boleto ya se encuentra registrado.");</script>';

                }else{

                    $peticion = "select * from eventos where Nombre='".$_GET["evento"]."'";
                    $resultado = $conexion->getConexion()->query($peticion);
                    $registro = $resultado->fetch_assoc();
                    
                    switch($_GET["ubicacion"]){

                        case 0: //Altos
                            if($registro["Altos"] > 0){

                                $numero = $registro["Altos"] - 1;
                                $sql = "update eventos set Altos='".$numero."' where Nombre= '".$_GET["evento"]."'";
                                $resultado = $conexion->getConexion()->query($sql);
                                $flag = true;

                            }else{
                                $flag = false;
                            }
                        break;

                        case 1: //Medios
                            if($registro["Medios"] > 0){

                                $numero = $registro["Medios"] - 1;
                                $sql = "update eventos set Medios='".$numero."' where Nombre= '".$_GET["evento"]."'";
                                $resultado = $conexion->getConexion()->query($sql);
                                $flag = true;

                            }else{
                                $flag = false;
                            }
                        break;

                        case 2: //Vip
                            if($registro["Vip"] > 0){
                                
                                $numero = $registro["Vip"] - 1;
                                $sql = "update eventos set Vip='".$numero."' where Nombre= '".$_GET["evento"]."'";
                                $resultado = $conexion->getConexion()->query($sql);
                                $flag = true;

                            }else{
                                $flag = false;
                            }
                        break;

                        case 3: //Platino
                            if($registro["Platino"] > 0){
                                
                                $numero = $registro["Platino"] - 1;
                                $sql = "update eventos set Platino='".$numero."' where Nombre= '".$_GET["evento"]."'";
                                $resultado = $conexion->getConexion()->query($sql);
                                $flag = true;

                            }else{
                                $flag = false;
                            }
                        break;
                    }

                    if($flag){
                        $peticion = "insert into boletos values( '".$_GET["serial"]."','".$_GET["evento"]."','".$registro["Fecha"]."','".$_GET["ubicacion"]."','".$usuario."')";
                        $resultado = $conexion->getConexion()->query($peticion);
                        
                        if($conexion->getConexion()->affected_rows > 0){
                            echo '<script type="text/javascript">alert("Boleto registrado correctamente.");';
                            if($_SESSION["Rol"]==0){
                            echo 'window.location.href="index.php";';
                            }else{
                                echo 'window.location.href="administrador.php";';
                            }
                            echo '</script>';
                            
                        }else{
                            echo '<script type="text/javascript">alert("Error al registrar.");</script>';
                        }

                    }else{
                        echo '<script type="text/javascript">alert("No existe disponibilidad para la ubicacion seleccionada");</script>';
                    }
                    
                            
                }

            }else if(isset($_GET["boton"]) && $_GET["boton"] == "Volver"){
                header("location:administrador.php");
            }//boton
        ?>

        <script type = "text/javascript">
            function cambiar(){
                document.location = "registrar_boleto.php?event="+document.getElementById("evento").value;
            }
        </script>

    </div>
    </body>

</html>