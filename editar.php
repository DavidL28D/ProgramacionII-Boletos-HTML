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

                    echo "<br>";

                    $serial = $_POST["serial"];
                    $evento = $_POST["evento"];
                    $ubicacion = $_POST["ubicacion"];

                    if($_SESSION["serial_base"] == $serial){
                        echo "No hay cambio de serial<br/>";

                    }else{

                        $sql = "select * from boletos where Serial = '".$serial."' ";
                        $resultado = $conexion->getConexion()->query($sql);

                        if($resultado->num_rows > 0){
                            echo "Existe el boleto<br/>";
                        }else{
                            echo "Cambio el serial<br/>";
                            /*
                            $sql = "update boletos set Serial='".$serial."' where Serial= '".$_SESSION["Serial"]."'";
                            $conexion->getConexion()->query($sql);
                            //*/
                        }

                    }

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

                    if($_SESSION["evento_base"] == $evento){

                        echo "<br/>";
                        echo "Eventos iguales.<br/>";
                        echo "<br/>";

                        if($_SESSION["ubicacion_base"] == $ubicacion){
                            echo "Ubicaciones iguales.<br/>";
                            echo '<script type="text/javascript">alert("Aqui actualiza boleto.");</script>';

                        }else{
                            echo "Ubicacion vieja != Ubicacion nueva.<br/>";
                            echo "Ubicacion vieja: $old<br/>";
                            echo "Ubicacion nueva: $new<br/>";

                            $sql = "select * from eventos where Nombre = '".$evento."' ";
                            $resultado = $conexion->getConexion()->query($sql);
                            $registro = $resultado->fetch_assoc();

                            if($registro["$new"] > 0){

                                echo "<br/>Modificacion:<br/>";
                                echo "$new -1<br/>";
                                echo "$old +1";

                                /*
                                $x = $registro["$new"] -1;
                                $sql = "update eventos set $new='".$x."' where Nombre= '".$evento."'";
                                $resultado= $conexion->getConexion()->query($sql);

                                $x = $registro["$old"] +1;
                                $sql = "update eventos set $old='".$x."' where Nombre= '".$_SESSION["evento_base"]."'";
                                $resultado= $conexion->getConexion()->query($sql);
                                //*/

                                echo '<script type="text/javascript">alert("Aqui actualiza boleto.");</script>';

                            }else{
                                echo "<br/>No existe disponibilidad en $new.";
                            }

                        }

                    }else{

                        echo "<br/>Evento viejo != Evento nuevo<br/>";
                        echo "Evento viejo:".$_SESSION["evento_base"]."<br/>";
                        echo "Evento nuevo: $evento<br/><br>";

                        $sql = "select * from eventos where Nombre = '".$evento."' ";
                        $resultado = $conexion->getConexion()->query($sql);
                        $registro = $resultado->fetch_assoc();

                        
                        if($_SESSION["ubicacion_base"] == $ubicacion){
                            echo "Ubicaciones iguales.<br/>";

                           if($registro["$new"] > 0){

                            echo "<br/>Modificacion:<br/>";
                            echo "$new -1<br/>";
                            echo "$old +1";

                            /*
                            $x = $registro["$new"] -1;
                            $sql = "update eventos set $new='".$x."' where Nombre= '".$evento."'";
                            $resultado= $conexion->getConexion()->query($sql);

                            $x = $registro["$old"] +1;
                            $sql = "update eventos set $old='".$x."' where Nombre= '".$_SESSION["evento_base"]."'";
                            $resultado= $conexion->getConexion()->query($sql);
                            //*/

                            echo '<script type="text/javascript">alert("Aqui actualiza boleto.");</script>';

                            }else{
                                echo "<br/>No existe disponibilidad en $new.";
                            }

                        }else{
                            echo "Ubicacion vieja != Ubicacion nueva.<br/>";
                            echo "Ubicacion vieja: $old<br/>";
                            echo "Ubicacion nueva: $new<br/>";

                            if($registro["$new"] > 0){

                                echo "<br/>Modificacion:<br/>";
                                echo "$new -1<br/>";
                                echo "$old +1";

                                /*
                                $x = $registro["$new"] -1;
                                $sql = "update eventos set $new='".$x."' where Nombre= '".$evento."'";
                                $resultado= $conexion->getConexion()->query($sql);

                                $x = $registro["$old"] +1;
                                $sql = "update eventos set $old='".$x."' where Nombre= '".$_SESSION["evento_base"]."'";
                                $resultado= $conexion->getConexion()->query($sql);
                                //*/

                                echo '<script type="text/javascript">alert("Aqui actualiza boleto.");</script>';

                            }else{
                                echo "<br/>No existe disponibilidad en $new.";
                            }

                        }

                    }

                    /*
                    $sql = "select * from eventos where Nombre = '".$evento."' ";
                    $resultado = $conexion->getConexion()->query($sql);

                    if($resultado->num_rows > 0){

                        $e = $resultado->fetch_assoc();

                        switch($e["Ubicacion"]){
                            
                            case 0: //Altos
                            $new = "Altos";
                            break;
                            
                            case 1: //Medios
                            $new = "Medios";
                            break;
                            
                            case 3: //Vip
                            $new = "Vip";
                            break;
                            
                            case 4: //Platino
                            $new = "Platino";
                            break;
                        }

                        switch($ubicacion){
                            
                            case 0: //Altos
                            $old= "Altos";
                            break;
                            
                            case 1: //Medios
                            $old = "Medios";
                            break;
                            
                            case 3: //Vip
                            $old = "Vip";
                            break;
                            
                            case 4: //Platino
                            $old = "Platino";
                            break;
                        }

                        if($evento == $e["Nombre"]){

                            echo "Evento viejo = Evento nuevo <br/>";
                            echo "Evento viejo: $evento";

                            if($ubicacion == $e["Ubicacion"]){

                                echo "Ubicacion vieja = Ubicacion nueva";
                                echo '<script type="text/javascript">alert("Datos Iguales, no se modifico el boleto.");</script>';

                            }else{

                                echo "Ubicacion vieja != Ubicacion nueva";
                                echo "ubicacion vieja: $old";
                                echo "ubicacion nueva: $new";

                                if($e["$new"] > 0){

                                    $x = $e["$new"] - 1;
                                    $sql = "update eventos set $new='".$x."' where Serial= '".$e["$new"]."'";
                                    $resultado= $conexion->getConexion()->query($sql);

                                    $x = $e["$old"] + 1;
                                    $sql = "update boletos set $old='".$x."' where Serial= '".$e["$old"]."'";
                                    $resultado= $conexion->getConexion()->query($sql);

                                    echo '<script type="text/javascript">alert("Se actualizo modifico el boleto.");</script>';

                                }else{
                                    echo '<script type="text/javascript">alert("No existe disponibilidad para la ubicacion seleccionada");</script>';
                                }
 
                            }

                        }else{

                            if($ubicacion == $e["Ubicacion"]){

                            }else{

                            }

                        }

                    }
                    
                    /*
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
                    */
                }//boton
             ?>
        
        <script type = "text/javascript">
            function cambiar(){
                document.location = "editar.php?serial="+document.getElementById("serial").value+"&evento="+document.getElementById("evento").value+"&ubicacion="+document.getElementById("ubicacion").value;
            }
        </script>		

    </body>

</html>