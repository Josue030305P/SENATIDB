<?php
// Incorpora el archivo externo una sola vez, si detecta error,  se detiene.
require_once '../models/Vehiculo.php';

// 1. Recibirá peticiones (GET - POST - REQUEST)
// 2. Realizará el proceso (MODELO - CLASE)
// 3. Retornar un resultado (JSON)


// KEY = VALUE
// isset(): Verifica si el objeto existe
if(isset($_POST['operacion'])){
  // Instanciar la clase
  $vehiculo = new Vehiculo();

  if($_POST['operacion'] == 'search'){
   
    $respuesta = $vehiculo->search(["placa"=> $_POST['placa']]);
  
    sleep(2);
    // Retornar el resultado
    echo json_encode($respuesta);
  }

  if($_POST['operacion'] == 'add'){
    // ALMACENAR LOS DATOS RECIBIDO ´POR LA VISTA, EN UN ARREGLO
      $datosRecibidos =[
        "idmarca" => $_POST["idmarca"],
        "modelo" => $_POST["modelo"],
        "color" => $_POST["color"],
        "tipocombustible" => $_POST["tipocombustible"],
        "peso" => $_POST["peso"],
        "afabricacion" => $_POST["afabricacion"],
        "placa" => $_POST["placa"]
      ];


    // Enviamos el arreglo como parámetro del método add
   $idobtenido =  $vehiculo ->add($datosRecibidos);
   echo json_encode($idobtenido);
 
  }

}




