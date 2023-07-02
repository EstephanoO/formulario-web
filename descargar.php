<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registro";

// Establish the database connection
$conex = mysqli_connect($servername, $username, $password, $dbname);
if (!$conex) {
    die("Connection failed: " . mysqli_connect_error());
}

// Obtener los datos de la base de datos
$query = "SELECT * FROM `registrof`";
$result = mysqli_query($conex, $query);

// Crear una instancia del objeto Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Establecer los encabezados de columna
$sheet->setCellValue('A1', 'Fecha');
$sheet->setCellValue('B1', 'Nombre');
$sheet->setCellValue('C1', 'Grupo');
$sheet->setCellValue('D1', 'Nombre de compañeros');
$sheet->setCellValue('E1', 'Tipo de Trabajo');
$sheet->setCellValue('F1', 'RD');
$sheet->setCellValue('G1', 'RA');
$sheet->setCellValue('H1', 'DP');
$sheet->setCellValue('I1', 'Bandejas');
$sheet->setCellValue('J1', 'Instalaciones');
$sheet->setCellValue('K1', 'Activaciones');
$sheet->setCellValue('L1', 'Ubicacion');
$sheet->setCellValue('M1', 'Observacion');

// Recorrer los resultados y escribirlos en el archivo Excel
$row = 2;
while ($row_data = mysqli_fetch_assoc($result)) {
    $sheet->setCellValue('A' . $row, $row_data['Fecha']);
    $sheet->setCellValue('B' . $row, $row_data['Nombre']);
    $sheet->setCellValue('C' . $row, $row_data['grupo']);
    $sheet->setCellValue('D' . $row, $row_data['Nombre de compañeros']);
    $sheet->setCellValue('E' . $row, $row_data['Tipo de Trabajo']);
    $sheet->setCellValue('F' . $row, $row_data['RD']);
    $sheet->setCellValue('G' . $row, $row_data['RA']);
    $sheet->setCellValue('H' . $row, $row_data['DP']);
    $sheet->setCellValue('I' . $row, $row_data['BANDEJAS']);
    $sheet->setCellValue('J' . $row, $row_data['INSTALACIONES']);
    $sheet->setCellValue('K' . $row, $row_data['ACTIVACIONES']);
    $sheet->setCellValue('L' . $row, $row_data['UBICACION']);
    $sheet->setCellValue('M' . $row, $row_data['observacion']);

    $row++;
}

// Crear el objeto Writer y guardar el archivo
$writer = new Xlsx($spreadsheet);
$writer->save('registro.xlsx');

// Descargar el archivo
$file = 'registro.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $file . '"');
header('Cache-Control: max-age=0');
readfile($file);
unlink($file); // Eliminar el archivo después de la descarga
// Close the database connection
mysqli_close($conex);
?>