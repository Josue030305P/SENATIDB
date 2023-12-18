<?php

require_once 'Conexion.php';

class Sede extends Conexion{

    private $pdo;

    public function __CONSTRUCT(){
        $this->pdo = parent:: getConexion();

    }

    public function listar(){

        try{
    
          $consulta = $this->pdo->prepare("CALL spu_sedes_listar");
          $consulta->execute();
    
          return $consulta->fetchAll(PDO::FETCH_ASSOC);
         
    
        }
        
        catch(Exception $e){
          die($e->getMessage());
    
        }
      }

}

// $sede = new Sede();
// $resultado = $sede->listar();

// echo json_encode($resultado);