<!DOCTYPE html>

<?php
    session_start();
    ///*
    if(isset($_SESSION["Rol"])){
        if($_SESSION["Rol"]==1){
            header("location:administrador.php");
        }
    }else{
        header("location:cerrar.php");
    }
    //*/
?>

<html>

    <head>

        <meta charset="UTF-8">
        <title>Cliente</title>

    </head>

    <body>

        <h1>Bienvenido.</h1>
        <?php echo "", $_SESSION["Nombres"]." ". $_SESSION["Apellidos"];?><br/><br/>

        <form action="" method="post">
            <a href="registrar_boleto.php">Registrar boleto</a><br/><br/>
            <input type="submit" name="boton" value="Cerrar Sesion">
        </form>

        <?php
            if(isset($_POST["boton"]) && $_POST["boton"] == "Cerrar Sesion"){
                header("location:cerrar.php");
            }
        ?>
        
    </body>
</html>
