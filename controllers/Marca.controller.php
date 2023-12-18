<?php

require_once '../models/Marca.php';

if(isset($_GET['operacion'])){
  $marca = new Marca();

  if($_GET['operacion'] == 'listar'){
    $resultado = $marca->getAll();
    echo json_encode($resultado);
  }
}