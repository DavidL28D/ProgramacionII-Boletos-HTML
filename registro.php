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

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Registro de cliente</title>

    </head>

    <body>
       
        <form action="" method="post">
            <fieldset>
                <legend><h1>Registro de usuario</h1></legend>
                * <input type="text" name="primer_nombre" id="primer_nombre" placeholder="Primer nombre" required="required">
                <input type="text" name="segundo_nombre" id="segundo_nombre" placeholder="Segundo nombre"><br/><br/>
                * <input type="text" name="primer_apellido" id="primer_apellido" placeholder="Primer apellido" required="required">
                <input type="text" name="segundo_apellido" id="segundo_apellido" placeholder="Segundo apellido"><br/><br/>
                <input type="text" name="cedula" id="cedula" placeholder="Cedula"><br/><br/>
                <input type="text" name="direccion" id="direccion" placeholder="Direccion"><br/><br/>

                * Seleccione su sexo: 
                <select name="sexo" id="sexo">
                    <option value="0">Masculino</option>
                    <option value="1">Femenino</option>
                    <option value="2">Prefiero no decirlo</option>
                </select><br/><br/>

                <input type="text" name="telefono" id="telefono" placeholder="Telefono"><br/><br/>
                * <input type="text" name="correo" id="correo" placeholder="Correo" required="required"><br/><br/>
                * <input type="text" name="user" id="user" placeholder="Usuario" required="required"><br/><br/>
                * <input type="password" name="pass" id="pass" placeholder="Contraseña" required="required"><br/><br/>

                <input type="submit" name="boton" value="Registrar">

            </fieldset>
        </form>

            <?php 
                if(isset($_POST["boton"]) && $_POST["boton"] == "Registrar"){

                    $rol=0;
                    include 'conexion.php';
                    $conec= new Conectar();
                    $conec->ConectarBD();

                    $peticion="select * from clientes where Usuario='".$_POST["user"]."'";
                    $resultado=$conec->getConexion()->query($peticion);

                    if($resultado->num_rows>0){
                        echo '<script type="text/javascript">alert("El usuario ya existe.");</script>';
                    }else{

                        $peticion="insert into clientes values('".$_POST["primer_nombre"]." ".$_POST["segundo_nombre"]."',"
                                ."'".$_POST["primer_apellido"]." ".$_POST["segundo_apellido"]."',"
                                ."'".$_POST["cedula"]."',"
                                ."'".$_POST["direccion"]."',"
                                ."'".$_POST["sexo"]."',"."'".$_POST["telefono"]."',"
                                ."'".$_POST["correo"]."',"."'".$_POST["user"]."',"
                                ."'".$_POST["pass"]."',"."'".$rol."') ";
                                
                        $resultado=$conec->getConexion()->query($peticion);
                        
                        if($conec->getConexion()->affected_rows>0){
                            echo '<script type="text/javascript">alert("Usuario registrado satisfactoriamente.");</script>';
                            unset($_POST["boton"]);
                            header("location:index.php");
                            
                        }else{
                            echo '<script type="text/javascript">alert("Error al registrar.");</script>';
                        }    
                    }
                }
            ?>
        <p>La informacion marcada con el * es obligatoria</p>

    </body>

</html>