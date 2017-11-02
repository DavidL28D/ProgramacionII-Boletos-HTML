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
        <link rel="stylesheet" type="text/css" href="styles.css">
        <meta charset="UTF-8">
        <title>Listado de eventos</title>

    </head>

    <body>
        <div id="contenedor">
    

        <h1 class="titulos">Listado de Eventos</h1><br><br>
        
        <?php
        include 'conexion.php';
        $vacia=true;
        $registros=true;
        $conec = new Conectar();
        $conec->ConectarBD();
        $sql= "select * from clientes order by Nombres";
        $resultado= $conec->getConexion()->query($sql);
        if($resultado->num_rows>0){
           
            
             
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
                         if($registros){
                            echo '<p class="textos"> ';
                            echo '<table>';
                            echo '<tr><th>Nombres</th><th>Apellidos</th><th>Cedula</th><th>Nombre del Evento</th><th>Ubicacion</th><th>Detalles y Modificar</th></tr>';
                            $registros=false;
                         }
                        echo " <tr ><td>".$tabla["Nombres"]."</td><td>".$tabla["Apellidos"]."</td><td> ".$tabla["Cedula"]."</td><td>".$tabla2["Nombre"]."</td><td>".$ubicacion.
                                '</td><td> <a  href="detalles.php?user='.$tabla["Usuario"].'&event='.$tabla2["Serial"].'">Detalles</a>  <a href="editar.php?serial='.$tabla2["Serial"].'&evento='.$tabla2["Nombre"].'&ubicacion='.$tabla2["Ubicacion"].'&flag">Editar</a>  <a href="eliminar.php?boleto='.$tabla2["Serial"].'">Borrar</a></td></tr>';

                    }
                           

                }
                
        }if($vacia){         
                            echo 'Aun no hay boletos Registrados<br><br>';            
        }
        } 
         echo"</table>";
         echo'</p>';
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
        </div>
    </body>
</html>
