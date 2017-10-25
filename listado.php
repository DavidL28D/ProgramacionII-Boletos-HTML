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
        <title>Listado de eventos</title>

    </head>

    <body>

        <h1>Listado de Eventos</h1>
        
        <?php
        include 'conexion.php';
        $vacia=true;
        $conec = new Conectar();
        $conec->ConectarBD();
        $sql= "select * from clientes order by Nombres";
        $resultado= $conec->getConexion()->query($sql);
        //echo $resultado->num_rows;
        if($resultado->num_rows>0){
            echo '<tr><td>&nbsp&nbsp&nbsp&nbspNombres&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp   </td><td>Apellidos&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp   </td><td>Cedula &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp    </td><td>Nombre del Evento &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp    </td><td>Ubicacion</td><br><br>';
        while($tabla=$resultado->fetch_assoc()){
             
            $sql2= "select * from boletos where Usuario='".$tabla["Usuario"]."'";
            $resultado2= $conec->getConexion()->query($sql2);
                if($resultado2->num_rows>0){
                    while($tabla2=$resultado2->fetch_assoc()){
                        $vacia=false;
                        if($tabla2["Ubicacion"]==0){
                            $ubicacion="Altos";
                        }
                        if($tabla2["Ubicacion"]==1){
                            $ubicacion="Medio";
                        }
                        if($tabla2["Ubicacion"]==2){
                            $ubicacion="VIP";
                        }
                        if($tabla2["Ubicacion"]==3){
                            $ubicacion="Platino";
                        }
                        echo "<td>".$tabla["Nombres"]."</td> &nbsp&nbsp  <td>".$tabla["Apellidos"]."</td> &nbsp&nbsp<td> ".$tabla["Cedula"]."</td> &nbsp&nbsp<td>".$tabla2["Nombre"]."</td> &nbsp&nbsp<td>".$ubicacion.
                                '</td> &nbsp&nbsp<td> <a  href="detalles.php?user='.$tabla["Usuario"].'&event='.$tabla2["Serial"].'">Detalles</a>  <a href="editar.php?event='.$tabla2["Serial"].'">Editar</a>  <a href="eliminar.php?boleto='.$tabla2["Serial"].'">Borrar</a></td><br>';

                    }
                }                        
        }if($vacia){         
                            echo 'Aun no hay boletos Registrados<br><br><a href="administrador.php">Volver</a>';            
        }
        echo '</tr>';
        }       
        ?>

        <form action="" method="post">
            <br/><br/><input type="submit" name="boton" value="Volver">
        </form>

        <?php
            if(isset($_POST["boton"]) && $_POST["boton"] == "Volver"){
                if($_SESSION["Rol"] == 1){
                    header("location:index.php");
                }
            }
        ?>

    </body>
</html>
