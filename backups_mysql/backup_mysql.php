<?php

$host = "localhost";
$nombre = "varadero";
$usuario = "julisa";
$password = "juVadasa21";

// Definir el directorio de respaldos
$backup_dir = dirname(__FILE__) . '/';

// Verificar y crear el directorio si no existe
if (!file_exists($backup_dir)) {
    mkdir($backup_dir, 0755, true);
}

// Asegurarse que el directorio tenga permisos de escritura
chmod($backup_dir, 0755);

$fecha = date('Ymd_His');
$nombre_sql = $backup_dir . $nombre . '_' . $fecha . '.sql';
$nombre_zip = $backup_dir . $nombre . '_' . $fecha . '.zip';

// Crear el respaldo de la base de datos con opciones adicionales
$dump = sprintf(
    "mysqldump -h%s -u%s -p%s --single-transaction --quick --lock-tables=false %s > %s 2>&1",
    escapeshellarg($host),
    escapeshellarg($usuario),
    escapeshellarg($password),
    escapeshellarg($nombre),
    escapeshellarg($nombre_sql)
);

// Ejecutar el comando y capturar la salida
exec($dump, $output, $return_var);

// Verificar si hubo errores en mysqldump
if ($return_var !== 0) {
    die("Error al crear el respaldo de la base de datos. Código: " . $return_var . "\nSalida: " . implode("\n", $output));
}

// Verificar si el archivo SQL se creó correctamente
if (!file_exists($nombre_sql) || filesize($nombre_sql) == 0) {
    die("El archivo SQL no se creó correctamente o está vacío");
}

// Crear el archivo ZIP
$zip = new ZipArchive();

if ($zip->open($nombre_zip, ZipArchive::CREATE) === true) {
    // Agregar el archivo SQL al ZIP
    if ($zip->addFile($nombre_sql, basename($nombre_sql))) {
        $zip->close();
        
        // Verificar que el ZIP se creó correctamente
        if (file_exists($nombre_zip) && filesize($nombre_zip) > 0) {
            // Eliminar el archivo SQL solo si se comprimió exitosamente
            unlink($nombre_sql);
            
            $size_mb = round(filesize($nombre_zip) / 1048576, 2);
            echo "✓ Respaldo creado exitosamente\n";
            echo "Archivo: " . basename($nombre_zip) . "\n";
            echo "Tamaño: " . $size_mb . " MB\n";
            echo "Ruta completa: " . $nombre_zip . "\n";
            
            // Opcional: Eliminar respaldos antiguos (mantener solo los últimos 10)
            limpiarRespaldosAntiguos($backup_dir, $nombre, 10);
            
        } else {
            echo "Error: El archivo ZIP se creó pero está vacío o corrupto";
        }
    } else {
        $zip->close();
        echo "Error al agregar el archivo SQL al ZIP";
    }
} else {
    echo "Error al crear el archivo ZIP: " . $nombre_zip;
    if (isset($zip->status)) {
        echo "\nCódigo de error ZIP: " . $zip->status;
    }
}

// Función para limpiar respaldos antiguos
function limpiarRespaldosAntiguos($dir, $nombre_db, $mantener = 10) {
    $archivos = glob($dir . $nombre_db . '_*.zip');
    
    if (count($archivos) > $mantener) {
        // Ordenar por fecha de modificación (más antiguo primero)
        usort($archivos, function($a, $b) {
            return filemtime($a) - filemtime($b);
        });
        
        // Eliminar los más antiguos
        $eliminar = array_slice($archivos, 0, count($archivos) - $mantener);
        
        foreach ($eliminar as $archivo) {
            if (unlink($archivo)) {
                echo "Eliminado respaldo antiguo: " . basename($archivo) . "\n";
            }
        }
    }
}

?>