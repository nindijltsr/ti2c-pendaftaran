<?php
include "koneksiDB.php";
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$sql = "SELECT * FROM daftar";
$result = $db->query($sql);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'Nama');
$sheet->setCellValue('C1', 'Alamat');
$sheet->setCellValue('D1', 'Agama');
$sheet->setCellValue('E1', 'Jenis Kelamin');
$sheet->setCellValue('F1', 'Asal Sekolah');

$rowIndex = 2;
while ($row = $result->fetch_assoc()) {
    $sheet->setCellValue('A' . $rowIndex, $row['id']);
    $sheet->setCellValue('B' . $rowIndex, $row['nama']);
    $sheet->setCellValue('C' . $rowIndex, $row['alamat']);
    $sheet->setCellValue('D' . $rowIndex, $row['agama']);
    $sheet->setCellValue('E' . $rowIndex, $row['jenis_kelamin']);
    $sheet->setCellValue('F' . $rowIndex, $row['sekolah_asal']);
    $rowIndex++;
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="data_pendaftar.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

$db->close();
?>
