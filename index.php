<!DOCTYPE html>

<?php
    session_start();
    ///*
    if(isset($_SESSION["Rol"])){
        if($_SESSION["Rol"]==1){
            header("location:administrador.php");
        }else if($_SESSION["Rol"]==0) {
            header("location:cliente.php");
        }
    }
    //*/
?>

<html lang="en">

    <head>

        <link rel="stylesheet" type="text/css" href="style.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Sistema de boleteria</title>

    </head>
    
    <body>
    <div id="contenedor">

        <h1 class="titulos">INGRESAR</h1>

        <form action="" method="post">
            <fieldset enabled=false>
                <input type="text" name="usuario" id="usuario" placeholder="Usuario"><br/><br/>
                <input type="password" name="contraseña" id="contraseña" placeholder="Contraseña"><br/><br/>
                <input type="submit" name="boton" value="Iniciar Sesion"><br/><br/>
                <a href="registro.php">Registrarse</a>
            </fieldset>

            <?php
                if(isset($_POST["boton"]) && $_POST["boton"] == "Iniciar Sesion"){
                    
                    if( (isset($_POST["usuario"]) && $_POST["usuario"] != null) && (isset($_POST["contraseña"]) && $_POST["contraseña"] != null)){
                        include 'conexion.php';
                        $conexion= new Conectar();
                        $conexion->ConectarBD();
                        $sql= "select * from clientes where Usuario='".$_POST["usuario"]."'"; 
                        $resultado= $conexion->getConexion()->query($sql);
                        
                        
                        if($resultado->num_rows>0){
                        $fila=mysqli_fetch_array($resultado,MYSQLI_ASSOC);
                           if($fila["Contrasena"] == $_POST["contraseña"]){
                               $_SESSION=$fila; 

                               if($_SESSION["Rol"]==1){
                                   header("location:administrador.php");
                               }else if ($_SESSION["Rol"]==0){
                                   header("location:cliente.php");
                               }         

                            }else{
                                echo '<script type="text/javascript">alert("Usuario o Contraseña Inválida.");</script>';
                            }
                        }else{
                            echo '<script type="text/javascript">alert("Usuario no registrado.");</script>';                            
                        }

                    }else{
                        echo '<script type="text/javascript">alert("Datos vacios.");</script>';
                    }
                }
                
            ?>
        </form>

        <footer>
        Elaborado por:
        <br>David L. Chacón G. C.I:25.023.230.
        <br>Yeison B. Fuentes C. C.I:23.498.281.
        <br><br>Proyecto PHP y MySQL.
        <br>Programación II Sección 1.

        </footer>
    
    </div>
    </body>

</html>