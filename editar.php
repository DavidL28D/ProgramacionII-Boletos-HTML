<!DOCTYPE html>

<?php
    include 'conexion.php';
    session_start();
    ///*
    if(isset($_SESSION["Rol"])){
        if($_SESSION["Rol"]==0){
            header("location:cliente.php");
        }
    }else{
        header("location:cerrar.php");
    }
    //*/
?>

<html lang="en">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Editar boleto</title>

    </head>

    <body>

        <?php

            $conexion = new Conectar();
            $conexion->ConectarBD();

            $sql = "select * from boletos where Serial='".$_GET["event"]."'"; 
            $resultado = $conexion->getConexion()->query($sql);

            if($resultado->num_rows>0){
                $fila = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
            }else{
                echo '<script type="text/javascript">alert("Ha ocurrido un error, intente de nuevo.");</script>';
            }

        ?>

        <form action="" method="post">

            Serial: <input type="number" name="serial" id="serial" placeholder="Serial" required="required" value='<?php echo $fila["Serial"];?>'><br/><br/>
           
            <?php
                $conexion = new Conectar();
                $conexion->ConectarBD();

                $sql = "select * from eventos order by Nombre ";
                $resultado = $conexion->getConexion()->query($sql);

                if($resultado->num_rows > 0){
                    
                    echo 'Seleccione Evento: <select name="evento" id="evento">';

                     while($opcion= $resultado->fetch_assoc()){
                        
                        if($opcion["Nombre"] == $fila["Nombre"]){
                            echo '<option value="'.$opcion["Nombre"].'" selected ="selected">'.$opcion["Nombre"].'</option>'; 
                        }else{
                            echo '<option value="'.$opcion["Nombre"].'">'.$opcion["Nombre"].'</option>'; 
                        }
                        
                     }
                    
                    echo'</select><br><br>';
                }

            ?>

            Seleccione su ubicacion: 
                <select name="ubicacion" id="ubicacion">

                    <option value="0" <?php if($fila["Ubicacion"] == 0) echo "selected='selected'";?>>Altos</option>
                    <option value="1" <?php if($fila["Ubicacion"] == 1) echo "selected='selected'";?>>Medios</option>
                    <option value="2" <?php if($fila["Ubicacion"] == 2) echo "selected='selected'";?>>VIP</option>
                    <option value="3" <?php if($fila["Ubicacion"] == 3) echo "selected='selected'";?>>Platino</option>
                </select><br/><br/><br/>

            <input type="submit" name="boton" value="Modificar">
        </form>

            <?php
                if(isset($_POST["boton"]) && $_POST["boton"] == "Modificar"){
                    
                    $sql = "select * from eventos where Nombre= '".$_POST["evento"]."' ";
                    $resultado = $conexion->getConexion()->query($sql);
                    $fecha = $resultado->fetch_assoc();

                    $sql= "select * from boletos where Serial='".$_POST["serial"]."'"; 
                    $resultado= $conexion->getConexion()->query($sql);

                    if($resultado->num_rows>0){
                        
                        if($_POST["serial"] == $fila["Serial"]){
                            
                            $sql = "update boletos set Serial='".$_POST["serial"]."', Nombre='".$_POST["evento"]."', Fecha='".$fecha["Fecha"]."', Ubicacion='".$_POST["ubicacion"]."', Usuario='".$fila["Usuario"]."' where Serial= '".$fila["Serial"]."'";
                            $resultado= $conexion->getConexion()->query($sql);

                            echo '<script type="text/javascript">alert("Registro modificado.");</script>';
                            header("location:listado.php");

                        }else{
                            echo '<script type="text/javascript">alert("Boleto ya registrado.");</script>';
                        }

                    }else{
                        
                        if($_POST["serial"] != $fila["Serial"]){

                            $sql = "update boletos set Serial='".$_POST["serial"]."', Nombre='".$_POST["evento"]."', Fecha='".$fecha["Fecha"]."', Ubicacion='".$_POST["ubicacion"]."', Usuario='".$fila["Usuario"]."' where Serial= '".$fila["Serial"]."'";
                            $resultado= $conexion->getConexion()->query($sql);

                            echo '<script type="text/javascript">alert("Registro modificado.");</script>';
                            header("location:listado.php");

                        } 
                    }
                }
             ?>

    </body>

</html>