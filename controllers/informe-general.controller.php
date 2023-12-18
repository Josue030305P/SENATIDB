<?php
require_once '../models/Empleado.php';
require_once '../models/Sede.php';

$empleado = new Empleado();
$sede = new Sede();

try {
    // Obtener la cantidad de empleados
    $cantidadEmpleados = count($empleado->listar());

    // Obtener la cantidad de sedes
    $cantidadSedes = count($sede->listar());

    // Obtener la lista de empleados por sede
    $empleadosPorSede = $empleado->listarConSedes();

    // Obtener los nombres de los empleados por sede
    $nombresEmpleadosPorSede = [];
    foreach ($empleadosPorSede as $empleadoSede) {
        $nombresEmpleadosPorSede[] = $empleadoSede['nombres_empleados'];
    }

    // Datos actualizados
    $datosActualizados = [
        'empleados' => $cantidadEmpleados,
        'sedes' => $cantidadSedes,
        'empleadosPorSede' => $empleadosPorSede,
        'nombresEmpleadosPorSede' => $nombresEmpleadosPorSede, 
    ];

    echo json_encode($datosActualizados);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>

