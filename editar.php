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

        $serial = $_GET["serial"];
        $evento = $_GET["evento"];
        $ubicacion = $_GET["ubicacion"];

        if(isset($_GET["flag"])){

            $_SESSION["serial_base"] = $_GET["serial"];
            $_SESSION["evento_base"] = $_GET["evento"];
            $_SESSION["ubicacion_base"] = $_GET["ubicacion"];

        }

        echo "Datos registrados: <br/>";
        echo "Serial: ".$_SESSION["serial_base"].".<br/>";
        echo "Evento: ".$_SESSION["evento_base"].".<br/>";
        switch($_SESSION["ubicacion_base"]){

            case 0: //Altos
            echo "Ubicacion: Altos. <br/>";
            break;

            case 1: //Medios
            echo "Ubicacion: Medios. <br/>";
            break;

            case 3: //Vip
            echo "Ubicacion: Vip. <br/>";
            break;

            case 4: //Platino
            echo "Ubicacion: Platino. <br/>";
            break;
        }
        echo"<br/><br/>";
        ?>

        <form action="" method="post">

            Serial: <input type="number" name="serial" id="serial" placeholder="Serial" required="required" value='<?php echo $serial ?>'><br/><br/>
           
            <?php
                $conexion = new Conectar();
                $conexion->ConectarBD();

                $sql = "select * from eventos order by Nombre ";
                $resultado = $conexion->getConexion()->query($sql);

                if($resultado->num_rows > 0){
                    
                    echo 'Seleccione Evento: <select name="evento" id="evento" onchange="cambiar()">';
                     $i=0;
                     while($opcion = $resultado->fetch_assoc()){
                        
                        if($evento == $opcion["Nombre"]){
                            echo '<option value="'.$opcion["Nombre"].'" selected="selected">'.$opcion["Nombre"].'</option>';
                        }else{
                            echo '<option value="'.$opcion["Nombre"].'">'.$opcion["Nombre"].'</option>';
                        }
                                             
                     }
                    
                    echo'</select><br><br>';
                }

                $sql = "select * from eventos where Nombre='".$evento."'";
                $resultado = $conexion->getConexion()->query($sql);
                $registro = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
                echo "Disponibilidad: Altos: ".$registro["Altos"].", Medios: ".$registro["Medios"].", VIP: ".$registro["Vip"].", Platino: ".$registro["Platino"]." <br/><br/>";


            ?>

            Seleccione su ubicacion: 
                <select name="ubicacion" id="ubicacion">

                    <option value="0" <?php if($ubicacion == 0) echo "selected='selected'";?>>Altos</option>
                    <option value="1" <?php if($ubicacion == 1) echo "selected='selected'";?>>Medios</option>
                    <option value="2" <?php if($ubicacion == 2) echo "selected='selected'";?>>VIP</option>
                    <option value="3" <?php if($ubicacion == 3) echo "selected='selected'";?>>Platino</option>
                </select><br/><br/><br/>

            <input type="submit" name="boton" value="Modificar">
        </form>

            <?php
                if(isset($_POST["boton"]) && $_POST["boton"] == "Modificar"){

                    $sql = "select * from boletos where Serial = '".$serial."' ";
                    $resultado = $conexion->getConexion()->query($sql);
                    
                    if($resultado->num_rows > 0){

                        $boleto = $resultado->fetch_assoc();

                        if($serial == $boleto["Serial"]){
                            $sql = "update boletos set Serial='".$serial."' where Serial= '".$boleto["Serial"]."'";
                            $resultado= $conexion->getConexion()->query($sql);
                        }else{
                            echo '<script type="text/javascript">alert("El boleto ya se encuentra registrado.");</script>';
                        }

                    }

                    $sql = "select * from eventos where Nombre = '".$evento."' ";
                    $resultado = $conexion->getConexion()->query($sql);

                    if($resultado->num_rows > 0){

                        $evento = $resultado->fetch_assoc();

                    }
                    

                    
                    
                    
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
        
        <script type = "text/javascript">
            function cambiar(){
                document.location = "editar.php?serial="+document.getElementById("serial").value+"&evento="+document.getElementById("evento").value+"&ubicacion="+document.getElementById("ubicacion").value;
            }
			
	 
 </script>		

    </body>

</html>