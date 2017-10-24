<!DOCTYPE html>

<?php
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

        <h1>Sistema de registro</h1>

        <form action="" method="post">
            <input type="number" name="serial" id="serial" placeholder="Serial" required="required"><br/><br/>

            <?php
                if($_SESSION["Rol"] == 1){
                    include 'conexion.php';
                    $conexion= new Conectar();
                    $conexion->ConectarBD();
                    $sql=" select * from clientes order by Usuario";
                    $resultado=$conexion->getConexion()->query($sql);
                    if($resultado->num_rows>0){
                        
                        echo 'Seleccione Usuario: <select name="usuario" id="usuario">';
                         while($user=$resultado->fetch_assoc()){
                             if($user["Usuario"]!="admin"){
                                 echo "<option value=".$user["Usuario"].">".$user["Usuario"]."</option>";
                             }
                             
                         }
                        
                        echo'</select><br><br>';
                    }
                    
                }
            ?>

            <input type="text" name="nombre" id="nombre" placeholder="Nombre del evento" required="required"><br/><br/>
            <input type="date" name="fecha" id="fecha" placeholder="AAAA/MM/DD" required="required"><br/><br/>

            Seleccione su ubicacion: 
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
                    $name = $_POST["usuario"];
               }else if($_SESSION["Rol"] == 0){
                   $name = $_SESSION["Usuario"];
               }

                $peticion = "select * from boletos where Serial='".$_POST["serial"]."'";
                $resultado = $conexion->getConexion()->query($peticion);

                $haveUser = "select * from clientes where Usuario='".$name."'";
                $result = $conexion->getConexion()->query($haveUser);

                if($resultado->num_rows>0){
                    echo '<script type="text/javascript">alert("El boleto ya se encuentra registrado.");</script>';

                }else if ($result->num_rows > 0){

                    $peticion = "insert into boletos values('".$_POST["serial"]."',"."'".$_POST["nombre"]."',"."'".$_POST["fecha"]."',"."'".$_POST["ubicacion"]."',"."'".$name."') ";
                    $resultado=$conexion->getConexion()->query($peticion);
                    
                    if($conexion->getConexion()->affected_rows>0){
                        echo '<script type="text/javascript">alert("Boleto registrado correctamente.");</script>';
                        header("location:index.php");
                        
                    }else{
                        echo '<script type="text/javascript">alert("Error al registrar.");</script>';
                    }
                            
                }else{
                    echo '<script type="text/javascript">alert("No existe ese usuario registrado.");</script>';
                }

            }
        ?>

    </body>

</html>