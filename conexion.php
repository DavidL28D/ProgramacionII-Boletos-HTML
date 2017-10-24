<?php
class Conectar{

    private $Conexion;

    public function __construct(){}

    public function getConexion(){
        return $this->Conexion;
    }

    public function ConectarBD(){

        $this->Conexion=new mysqli("localhost", "root", "", "boleteria");

        if($this->Conexion->connect_errno){
            echo "No es posible conectarse a la Base de Datos";
            exit;
        }   

    }

}
?>