<!DOCTYPE html>

<?php
    include 'conexion.php';
    session_start();
    ///*

    if(isset($_GET["serial"]) && isset($_GET["evento"])){
        if(isset($_SESSION["Rol"])){
            if($_SESSION["Rol"]==0){
                header("location:cliente.php");
            }
        }else{
            header("location:cerrar.php");
        }
    }else{
        header("location:listado.php");
    }
    //*/
?>

<html lang="en">

    <head>
    

        <link rel="stylesheet" type="text/css" href="style.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Editar boleto</title>

    </head>

    <body>
    <div id="contenedor">

        <?php

        $serial = $_GET["serial"];
        $evento = $_GET["evento"];
        $ubicacion = $_GET["ubicacion"];

        if(isset($_GET["flag"])){

            $_SESSION["serial_base"] = $_GET["serial"];
            $_SESSION["evento_base"] = $_GET["evento"];
            $_SESSION["ubicacion_base"] = $_GET["ubicacion"];

        }

        /*
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

            case 2: //Vip
            echo "Ubicacion: Vip. <br/>";
            break;

            case 3: //Platino
            echo "Ubicacion: Platino. <br/>";
            break;
        }
        echo"<br/><br/>";
        //*/
        ?>

        <h1 class="titulos">Edicion de boleto.</h1>
        <form action="" method="post">

            <p class="textos">
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

            <input type="submit" name="boton" value="Volver">
            <input type="submit" name="boton" value="Modificar">
            </p>
        </form>

            <?php
                if(isset($_POST["boton"]) && $_POST["boton"] == "Modificar"){

                    echo "<br>";

                    $b = true;
                    $serial = $_POST["serial"];
                    $evento = $_POST["evento"];
                    $ubicacion = $_POST["ubicacion"];

                    if($_SESSION["serial_base"] != $serial){
                        
                        $sql = "select * from boletos where Serial = '".$serial."' ";
                        $resultado = $conexion->getConexion()->query($sql);

                        if($resultado->num_rows > 0){
                            echo '<script type="text/javascript">alert("Existe un boleto con ese serial.");</script>';
                            $b = false;

                        }else{
                            //echo "Serial modificado a = $serial<br/>";
                        }

                    }

                    if($b){

                        switch($_SESSION["ubicacion_base"]){
                            
                            case 0: //Altos
                            $old= "Altos";
                            break;
                            
                            case 1: //Medios
                            $old = "Medios";
                            break;
                            
                            case 2: //Vip
                            $old = "Vip";
                            break;
                            
                            case 3: //Platino
                            $old = "Platino";
                            break;
    
                        }
    
                        switch($ubicacion){
                            
                            case 0: //Altos
                            $new = "Altos";
                            break;
                            
                            case 1: //Medios
                            $new = "Medios";
                            break;
                            
                            case 2: //Vip
                            $new = "Vip";
                            break;
                            
                            case 3: //Platino
                            $new = "Platino";
                            break;
    
                        }
    
                        //echo "Evento viejo:".$_SESSION["evento_base"]."<br/>";
                        //echo "Evento nuevo: $evento<br/><br>";
    
                        $sql = "select * from eventos where Nombre = '".$evento."' ";
                        $resultado = $conexion->getConexion()->query($sql);
                        $registroNEW = $resultado->fetch_assoc();

                        $sql = "select * from eventos where Nombre = '".$_SESSION["evento_base"]."' ";
                        $resultado = $conexion->getConexion()->query($sql);
                        $registroOLD = $resultado->fetch_assoc();
    
                        if($registroNEW["$new"] > 0){

                            ///*
                            
                            if(($_SESSION["evento_base"] == $evento) && ($new == $old)){

                            }else{
                                
                                //echo "Ubicacion vieja: $old<br/>";
                                //echo "Ubicacion nueva: $new<br/><br>";

                                //echo "Modificacion:<br/>";
                                //echo "$old +1<br/>";
                                //echo "$new -1<br/>";

                                $x = $registroNEW["$new"] - 1;
                                $sql = "update eventos set $new='".$x."' where Nombre= '".$evento."'";
                                $resultado= $conexion->getConexion()->query($sql);
        
                                $y = $registroOLD["$old"] + 1;
                                $sql = "update eventos set $old='".$y."' where Nombre= '".$_SESSION["evento_base"]."'";
                                $resultado= $conexion->getConexion()->query($sql);
    
                                $sql = "update boletos set Serial='".$serial."', Nombre='".$evento."', Fecha='".$registroNEW["Fecha"]."', Ubicacion='".$ubicacion."' where Serial ='".$_SESSION["serial_base"]."' ";
                                $resultado= $conexion->getConexion()->query($sql);

                                echo '<script type="text/javascript">alert("Boleto Actualizado.");</script>';
                                header("location:listado.php");

                            }
                            //*/

                        }else{
                            if($old == $new){

                                $sql = "update boletos set Serial='".$serial."' where Serial ='".$_SESSION["serial_base"]."' ";
                                $resultado= $conexion->getConexion()->query($sql);

                                echo '<script type="text/javascript">alert("Boleto Actualizado.");</script>';
                                header("location:listado.php");

                            }else{
                                echo '<script type="text/javascript">alert("No existe disponibilidad para la ubicacion seleccionada.");</script>';
                            }
                            
                        }

                    }
                }else if(isset($_POST["boton"]) && $_POST["boton"] == "Volver"){
                    header("location:listado.php");
                }//boton
             ?>
        
        <script type = "text/javascript">
            function cambiar(){
                document.location = "editar.php?serial="+document.getElementById("serial").value+"&evento="+document.getElementById("evento").value+"&ubicacion="+document.getElementById("ubicacion").value;
            }
        </script>		

        </div>
    </body>

</html>