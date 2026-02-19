<?php
/**
 * ACTUALIZAR COSTO DE ORDEN
 * 
 * Actualiza el costo y total de una orden en la base de datos.
 * 
 * @param POST idOrden - ID de la orden
 * @param POST costo - Costo unitario
 * @param POST cantidad - Cantidad de items
 * 
 * @return JSON {1} si se actualiza correctamente, {0} si falla
 */

// Incluir conexión a la base de datos
include_once '../../../conexion1.php';

// Obtener parámetros del POST
$idorden = $_POST['idOrden'];
$costo = $_POST['costo'];
$cantidad = $_POST['cantidad'];

// Calcular el total (costo * cantidad)
$total = $costo * $cantidad;

// Ejecutar consulta UPDATE para actualizar el costo y total de la orden
$sql = mysqli_query($conn, "UPDATE ordenes SET ord_costo='$costo', ord_total='${total}' WHERE ord_id_orden=${idorden}");

// Verificar si la consulta se ejecutó correctamente
if ($sql) {
    $id = 1;  // Éxito
} else {
    $id = 0;  // Error
}

// Retornar resultado en formato JSON
echo json_encode($id);
?>