<!DOCTYPE html>

<?php session_start(); ?>

<html lang="en">

    <head>

        <link rel="stylesheet" type="text/css" href="style.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Detalles</title>

    </head>

    <body>
    <div id="contenedor">

        <h1 class="titulos">Destalles</h1>

        <?php

            include 'conexion.php';
            $conexion= new Conectar();
            $conexion->ConectarBD();

            if($_SESSION["Rol"] == 1){  

                echo '<h2 class="subtitulos">Del usuario</h2>';
            
                $sql= "select * from clientes where Usuario='".$_GET["user"]."'"; 
                $resultado= $conexion->getConexion()->query($sql);
            
                if($resultado->num_rows>0){
            
                    $fila=mysqli_fetch_array($resultado,MYSQLI_ASSOC);
                    echo '<p class="textos">';
                    echo "Nombre: ".$fila["Nombres"]."<br/>";
                    echo "Apellido: ".$fila["Apellidos"]."<br/>";
                    echo "Cedula: ".$fila["Cedula"]."<br/>";
                    echo "Direccion: ".$fila["Direccion"]."<br/>";
                    if($fila["Sexo"] == 0){
                        echo "Sexo: Masculino <br/>";
                    }else if($fila["Sexo"] == 1){
                        echo "Sexo: Femenino <br/>";
                    }else{
                        echo "Sexo: No suministrado <br/>";
                    }
                    echo "Telefono: ".$fila["Telefono"]."<br/>";
                    echo "Correo: ".$fila["Correo"]."<br/>";
                    echo '</p>';
                }
            }
        ?>
        
        <h2 class="subtitulos">Del boleto</h2>
        <?php
        
            $sql= "select * from boletos where Serial='".$_GET["event"]."'"; 
            $resultado= $conexion->getConexion()->query($sql);

            if($resultado->num_rows>0){

                    $fila=mysqli_fetch_array($resultado,MYSQLI_ASSOC);

                    echo '<p class="textos">';
                    echo "Serial: ".$fila["Serial"]."<br/>";
                    echo "Nombre del evento: ".$fila["Nombre"]."<br/>";
                    echo "Fecha: ".$fila["Fecha"]."<br/>";
                    
                    if($fila["Ubicacion"] == 0){
                        echo "Ubicacion: Altos.<br/>";
                    }else if($fila["Ubicacion"] == 1){
                        echo "Ubicacion: Medios.<br/>";
                    }else if($fila["Ubicacion"] == 2){
                        echo "Ubicacion: VIP.<br/>";
                    }else if($fila["Ubicacion"] == 0){
                        echo "Ubicacion: Platino.<br/>";
                    }
                    echo '</p>';
            }

        ?>

        <form action="" method="post">
            <br/><br/><input type="submit" name="boton" value="Volver">
        </form>

        <?php
            if(isset($_POST["boton"]) && $_POST["boton"] == "Volver"){
                if($_SESSION["Rol"] == 1){
                    header("location:listado.php");
                }else{
                    header("location:index.php");
                }
            }
        ?>
    </div>
    </body>

</html>