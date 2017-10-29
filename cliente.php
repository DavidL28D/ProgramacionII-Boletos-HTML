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

        <link rel="stylesheet" type="text/css" href="styles.css">
        <meta charset="UTF-8">
        <title>Cliente</title>

    </head>

    <body>
    <div id="contenedor">

        <h1 class="titulos">Bienvenido.</h1>
        <?php echo "<p class='subtitulos'>", $_SESSION["Nombres"]." ". $_SESSION["Apellidos"]."</p>";?><br/>

        <form action="" method="post">
            <a href="registrar_boleto.php">Registrar boleto</a><br/><br/>
            <input type="submit" name="boton" value="Cerrar Sesion">
        </form>

        <?php
            if(isset($_POST["boton"]) && $_POST["boton"] == "Cerrar Sesion"){
                header("location:cerrar.php");
            }
        ?>
    
        </div>
    </body>
</html>
