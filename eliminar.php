<!DOCTYPE html>

<?phpsession_start();
    ///*
    if(isset($_SESSION["Rol"])){
        if($_SESSION["Rol"]==0) {
            header("location:cliente.php");
        }
    }else{
        header("location:cerrar.php");
    }
 ?>  

<html>

    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>

    <body>
        <?php
            include 'conexion.php';
            $con=new Conectar();
            $con->ConectarBD();
            $sql="delete from boletos where Serial='".$_GET["boleto"]."'";
            $result=$con->getConexion()->query($sql);
            echo 'Se ha borrado correctamente el registro seleccionado<br><br> <a href="listado.php">Volver</a>';
           
        ?>
    </body>
    
</html>
