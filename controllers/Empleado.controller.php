<?php
require_once '../models/Empleado.php';

$empleado = new Empleado();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    if (isset($_GET['operacion'])) {
        if ($_GET['operacion'] == 'listar') {
            $resultado = $empleado->listar();
            echo json_encode($resultado);
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Manejar solicitudes POST
    if (isset($_POST['operacion']) && $_POST['operacion'] == 'registrar') {
        $datosRecibidos = [
            "idsede"           => $_POST["idsede"],
            "apellidos"        => $_POST["apellidos"],
            "nombres"          => $_POST["nombres"],
            "ndocumento"       => $_POST["ndocumento"],
            "fechanacimiento"  => $_POST["fechanacimiento"],
            "telefono"         => $_POST["telefono"]
        ];
        
        $idobtenido = $empleado->registrar($datosRecibidos);
        echo json_encode($idobtenido);
    }

    elseif (isset($_POST['operacion']) && $_POST['operacion'] == 'buscar') {
        
            $respuesta = $empleado->buscar(["ndocumento"=> $_POST['ndocumento']]);
          
            sleep(2);
            // Retornar el resultado
            echo json_encode($respuesta);
          }
    }
    



