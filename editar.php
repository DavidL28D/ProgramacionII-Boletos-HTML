<!DOCTYPE html>

<?php
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

            include 'conexion.php';
            $conexion= new Conectar();
            $conexion->ConectarBD();
            $sql= "select * from boletos where Serial='".$_GET["event"]."'"; 
            $resultado= $conexion->getConexion()->query($sql);

            if($resultado->num_rows>0){
                $fila=mysqli_fetch_array($resultado,MYSQLI_ASSOC);
            }

        ?>

        <form action="" method="post">
            Serial: <input type="number" name="serial" id="serial" placeholder="Serial" required="required" value='<?php echo $fila["Serial"];?>'><br/><br/>
            Nombre del evento: <input type="text" name="nombre" id="nombre" placeholder="Nombre del evento" required="required" value='<?php echo $fila["Nombre_Evento"];?>'><br/><br/>
            Fecha: <input type="date" name="fecha" id="fecha" placeholder="Fecha" required="required" value='<?php echo $fila["Fecha"];?>'><br/><br/>

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
                    //$sql="update persona set nombre='".$_POST["nombre"]."',". "direccion='".$_POST["direccion"]."',". "edad='".$_POST["edad"]."' "."',". "edad='".$_POST["edad"]."' ". "where cedula='".$_POST["cedula"]."'";
                    
                    $sql= "select * from boletos where Serial='".$_POST["serial"]."'"; 
                    $resultado= $conexion->getConexion()->query($sql);

                    if($resultado->num_rows>0){
                        
                        if($_POST["serial"] == $fila["Serial"]){
                            
                            $sql="update boletos set Serial='".$fila["Serial"]."',"."Nombre_Evento='".$_POST["nombre"]."',"."Fecha='".$_POST["fecha"]."',"."Ubicacion='".$_POST["ubicacion"]."',"."Usuario='".$fila["Usuario"]."' ". "where Serial='".$fila["Serial"]."'";
                            $resultado= $conexion->getConexion()->query($sql);
                            echo '<script type="text/javascript">alert("Registro modificado.");</script>';
                            header("location:listado.php");
                        }else{
                            echo '<script type="text/javascript">alert("Boleto ya registrado.");</script>';
                        }

                    }else{
                        
                        if($_POST["serial"] != $fila["Serial"]){
                            $sql="update boletos set Serial='".$_POST["serial"]."',"."Nombre_Evento='".$_POST["nombre"]."',"."Fecha='".$_POST["fecha"]."',"."Ubicacion='".$_POST["ubicacion"]."',"."Usuario='".$fila["Usuario"]."' ". "where Serial='".$fila["Serial"]."'";
                            $resultado= $conexion->getConexion()->query($sql);
                            echo '<script type="text/javascript">alert("Registro modificado.");</script>';
                            header("location:listado.php");
                        }
                        
                    }
                }
             ?>

    </body>

</html>