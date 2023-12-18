<?php

require_once 'Conexion.php';

class Empleado extends Conexion{

  private $pdo;

  public function __CONSTRUCT(){

    $this->pdo = parent ::getConexion();

  }


  public function listar(){

    try{

      $consulta = $this->pdo->prepare("CALL spu_empleados_listar");
      $consulta->execute();

      return $consulta->fetchAll(PDO::FETCH_ASSOC);
     

    }
    
    catch(Exception $e){
      die($e->getMessage());

    }
  }



public function listarConSedes() {
  try {
      $consulta = $this->pdo->prepare("CALL spu_empleados_por_sede");
      $consulta->execute();
      $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

      // Dividir la cadena de nombres y apellidos en un array
      foreach ($resultados as &$resultado) {
          $resultado['nombres_empleados'] = explode(', ', $resultado['nombres_empleados']);
      }

      return $resultados;
  } catch (Exception $e) {
      die($e->getMessage());
  }
}



  public function registrar($datos = []){

    try{

      $consulta = $this->pdo->prepare("CALL spu_empleados_registrar(?,?,?,?,?,?)");
      $consulta->execute(

        array(

          $datos["idsede"],
          $datos["apellidos"],
          $datos["nombres"],
          $datos["ndocumento"],
          $datos["fechanacimiento"],
          $datos["telefono"]

        )

      );
      return $consulta->fetch(PDO::FETCH_ASSOC);

    }
    catch(Exception $e){
      die($e->getMessage());

    }

  }


  public function buscar($data = []){

    try{
     

      $consulta = $this->pdo->prepare("CALL spu_empleados_buscar(?)");
      $consulta->execute(
        array($data['ndocumento'])

      );
      
      return $consulta->fetch(PDO::FETCH_ASSOC);


    }
    catch(Exception $e){
      die($e->getMessage());
    }
  }








}
// $empleado = new Empleado();
// $resultado = $empleado->listar();
// echo json_encode($resultado);



