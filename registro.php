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

        <link rel="stylesheet" type="text/css" href="styles.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Registro de cliente</title>

    </head>

    <body>
    

        <h1 class="titulos">Registro de usuario</h1>

        <form action="" method="post">
            <fieldset>

                <p class="textos"> 
                    * <input type="text" name="primer_nombre" id="primer_nombre" placeholder="Primer nombre" required="required" <?php if(isset($_POST["primer_nombre"])) echo 'value="'.$_POST["primer_nombre"].'"'; ?>>
                    <input type="text" name="segundo_nombre" id="segundo_nombre" placeholder="Segundo nombre" <?php if(isset($_POST["segundo_nombre"])) echo 'value="'.$_POST["segundo_nombre"].'"'; ?> ><br/><br/>
                
                    * <input type="text" name="primer_apellido" id="primer_apellido" placeholder="Primer apellido" required="required" <?php if(isset($_POST["primer_apellido"])) echo 'value="'.$_POST["primer_apellido"].'"'; ?> >
                    <input type="text" name="segundo_apellido" id="segundo_apellido" placeholder="Segundo apellido" <?php if(isset($_POST["segundo_apellido"])) echo 'value="'.$_POST["segundo_apellido"].'"'; ?> ><br/><br/>
                
                    <input type="text" name="cedula" id="cedula" placeholder="Cedula" <?php if(isset($_POST["cedula"])) echo 'value="'.$_POST["cedula"].'"'; ?> ><br/><br/>
                    <input type="text" name="direccion" id="direccion" placeholder="Direccion" <?php if(isset($_POST["direccion"])) echo 'value="'.$_POST["direccion"].'"'; ?>><br/><br/>

                    * Seleccione su sexo: 
                    <select name="sexo" id="sexo">
                        <option value="0" <?php if(isset($_POST["sexo"]) && $_POST["sexo"] == 0) echo 'selected="selected"'; ?>>Masculino</option>
                        <option value="1" <?php if(isset($_POST["sexo"]) && $_POST["sexo"] == 1) echo 'selected="selected"'; ?>>Femenino</option>
                        <option value="2" <?php if(isset($_POST["sexo"]) && $_POST["sexo"] == 2) echo 'selected="selected"'; ?>>Prefiero no decirlo</option>
                    </select><br/><br/>
                
                    <input type="text" name="telefono" id="telefono" placeholder="Telefono" <?php if(isset($_POST["telefono"])) echo 'value="'.$_POST["telefono"].'"'; ?>><br/><br/>
                    * <input type="text" name="correo" id="correo" placeholder="Correo" required="required" <?php if(isset($_POST["correo"])) echo 'value="'.$_POST["correo"].'"'; ?>><br/><br/>
                    * <input type="text" name="user" id="user" placeholder="Usuario" required="required" <?php if(isset($_POST["user"])) echo 'value="'.$_POST["user"].'"'; ?>><br/><br/>
                    * <input type="password" name="pass" id="pass" placeholder="Contraseña" required="required"><br/><br/>
               
                </p>

                <input type="submit" formnovalidate name="boton" value="Volver">
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
                            echo '<script type="text/javascript">alert("Usuario registrado satisfactoriamente.");
                            window.location.href="index.php";</script>';
                            unset($_POST["boton"]);
                            header("location:index.php");
                            
                        }else{
                            echo '<script type="text/javascript">alert("Error al registrar.");</script>';
                        }    
                    }
                }else if(isset($_POST["boton"]) && $_POST["boton"] == "Volver"){
                    header("location:index.php");
                }//boton
                
            ?>
        <p class="textos">La informacion marcada con el * es obligatoria</p>

   
    </body>

</html>