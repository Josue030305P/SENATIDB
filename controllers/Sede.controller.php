<?php
require_once '../models/Sede.php';

if(isset($_GET['operacion'])){

    $sede = new Sede();

    if($_GET['operacion'] == 'listar'){
        $resultado = $sede->listar();
        echo json_encode($resultado);
    }






    

}