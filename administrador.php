<!DOCTYPE html>

<?php
    session_start();
    ///*
    if(isset($_SESSION["Rol"])){
        if($_SESSION["Rol"]==0) {
            header("location:cliente.php");
        }
    }else{
        header("location:cerrar.php");
    }
    //*/
?>

<html>

    <head>

        <meta charset="UTF-8">
        <title>Administrador</title>

    </head>

    <body>

        <h1>Bienvenido.</h1>
        <?php echo "", $_SESSION["Nombres"]." ". $_SESSION["Apellidos"];?><br/><br/>

        <form action="" method="post">
            <fieldset>
                <legend>Menú Principal</legend>
                <a href="listado.php">Ver listado de Registros de asistencia por eventos</a><br><br/>
                <a href="registrar_evento.php">Registrar Evento</a><br/><br/>
                <a href="registrar_boleto.php">Registrar Boleto</a><br/><br/>
                <input type="submit" name="boton" value="Cerrar Sesion">
            </fieldset>
        </form>

        <?php
            if(isset($_POST["boton"]) && $_POST["boton"] == "Cerrar Sesion"){
                header("location:cerrar.php");
            }
        ?>

    </body>

</html>
