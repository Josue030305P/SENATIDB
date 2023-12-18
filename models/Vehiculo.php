<?php
// 1- Acceso al archivo de conexión
require 'Conexion.php';

// 2- Heredar sus métodos

class Vehiculo extends Conexion{

  // Este objeto gurdara la conexión y se lo facilitará a todos los metodos
  private $pdo;

  // 3- Almacenar la conexión el el objeto pdo.
  
  public function __CONSTRUCT(){
    $this->pdo = parent:: getConexion();

  }


  //$data es un arreglo aosicativo que contiene los valores requeridos
  //por el spu para regiustro de vehículos.
  public function add($data = []){
    try{
      $consulta = $this->pdo->prepare("CALL spu_vehiculos_registrar(?,?,?,?,?,?,?)");
      $consulta->execute(
        array(
          $data['idmarca'],
          $data['modelo'],
          $data['color'],
          $data['tipocombustible'],
          $data['peso'],
          $data['afabricacion'],
          $data['placa']
        )
      );
      // Actualización, ahora retornamos el id vehiculo.
      return $consulta->fetch(PDO::FETCH_ASSOC);

    }
    catch(Exception $e){
      die($e->getMessage());

    }
  }



  public function search($data = []){

    try{
      // El SPU requiere el número de placa

      $consulta = $this->pdo->prepare("CALL spu_vehiculos_buscar(?)");
      $consulta->execute(
        array($data['placa'])

      );
      // Devolver el resgistro encontrado
      // fetch(): Retorna una coincidencia.
      // fetchAll: Retorna todas las coincidencias.
      // El FETCH_ASSOC: Define el resultado como un objeto.
      return $consulta->fetch(PDO::FETCH_ASSOC);


    }
    catch(Exception $e){
      die($e->getMessage());
    }
  }


}

// Prueba:

// $vehiculo = new Vehiculo();
// $registro = $vehiculo->search(["placa" => "ABC-111"]);
// var_dump($registro);