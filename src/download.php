<?php
include "koneksiDB.php";
require '../vendor/autoload.php'; // Memuat autoload PHPExcel

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Query untuk mendapatkan data dari tabel
$sql = "SELECT * FROM daftar";
$result = $db->query($sql);

// Inisialisasi objek Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Header kolom
$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'Nama');
$sheet->setCellValue('C1', 'Alamat');
$sheet->setCellValue('D1', 'Agama');
$sheet->setCellValue('E1', 'Jenis Kelamin');
$sheet->setCellValue('F1', 'Asal Sekolah');

// Menulis data dari hasil query ke spreadsheet
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

// Mengatur header untuk mengunduh file Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="data_pendaftar.xlsx"');
header('Cache-Control: max-age=0');

// Menyimpan hasil Spreadsheet ke output
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

// Tutup koneksi database
$db->close();
?>
