<?php
if (!isset($_POST['enviar'])) {
    echo "El archivo registrar.php no se ha ejecutado correctamente.";
} else {
    include("con_db.php");

    $fecha = $_POST['anio'] . '-' . $_POST['mes'] . '-' . $_POST['dia'];
    $nombre = $_POST['nombre'];
    $trabajoEnGrupo = isset($_POST['trabajo-grupo']) ? $_POST['trabajo-grupo'] : 'Si';
    $personas = isset($_POST['personas']) ? $_POST['personas'] : '';
    $observacion = isset($_POST['tiempo-trabajado']) ? $_POST['tiempo-trabajado'] : '';
    $especifica = isset($_POST['especifica']) ? $_POST['especifica'] : '';

    // Concatenate casilla1, casilla2, and casilla3 with "-"
    $ubicacion = $_POST['casilla1'] . '-' . $_POST['casilla2'] . '-' . $_POST['casilla3'];

    // Función para obtener el tipo de trabajo seleccionado
    function obtenerTipoTrabajo()
    {
        $tiposTrabajo = array('RD', 'RA', 'DP', 'BANDEJAS', 'INSTALACIONES', 'ACTIVACIONES');
        foreach ($tiposTrabajo as $tipo) {
            if (isset($_POST['tipo-trabajo']) && $_POST['tipo-trabajo'] === $tipo) {
                return $tipo;
            }
        }
        return '';
    }

    $tipoTrabajo = obtenerTipoTrabajo();

    // Initialize all the response variables
    $respuestaRD = '';
    $respuestaRA = '';
    $respuestaDP = '';
    $respuestaBandejas = '';
    $respuestaInstalaciones = '';
    $respuestaActivaciones = '';
    $respuestaBackbone = '';
    $respuestaFusionado = '';
    $respuestaOtros = '';

    // Set the specific response variable based on the selected type of work
    switch ($tipoTrabajo) {
        case 'RD':
            $respuestaRD = $especifica;
            break;
        case 'RA':
            $respuestaRA = $especifica;
            break;
        case 'DP':
            $respuestaDP = $especifica;
            break;
        case 'BANDEJAS':
            $respuestaBandejas = $especifica;
            break;
        case 'INSTALACIONES':
            $respuestaInstalaciones = $especifica;
            break;
        case 'ACTIVACIONES':
            $respuestaActivaciones = $especifica;
            break;
        case 'BACKBONE':
            $respuestaActivaciones = $especifica;
            break;
        case 'FUSIONADO':
            $respuestaActivaciones = $especifica;
            break;
        default:
            $respuestaOtros = $especifica;
            break;
    }

    // Preparar la consulta SQL con marcadores de posición
    $consulta = "INSERT INTO `registrof` (`Fecha`, `Nombre`, `grupo`, `Nombre de compañeros`, `Tipo de Trabajo`, `RD`, `RA`, `DP`, `BANDEJAS`, `INSTALACIONES`, `ACTIVACIONES`, `soplado`, `fusiones`, `UBICACION`, `observacion`, `submit`) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

    // Preparar la declaración y vincular los valores
    $stmt = mysqli_prepare($conex, $consulta);
    mysqli_stmt_bind_param($stmt, 'sssssssssssssss', $fecha, $nombre, $trabajoEnGrupo, $personas, $tipoTrabajo, $respuestaRD, $respuestaRA, $respuestaDP, $respuestaBandejas, $respuestaInstalaciones, $respuestaActivaciones, $respuestaFusionado, $respuestaBackbone, $ubicacion, $observacion);

    // Ejecutar la declaración
    if (mysqli_stmt_execute($stmt)) {
        echo "<h3>¡Registro exitoso!</h3>";
        echo '<a href="descargar.php">Descargar archivo Excel</a>';
    } else {
        echo "Error: " . mysqli_error($conex);
    }

    // Cerrar la declaración y la conexión
    mysqli_stmt_close($stmt);
    mysqli_close($conex);
}
?>
