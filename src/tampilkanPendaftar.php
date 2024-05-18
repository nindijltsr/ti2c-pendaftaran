<?php
include "koneksiDB.php";

$delete_message = "";

if (isset($_GET["delete"])) {
    $id = $_GET["delete"];
    $sql_delete = "DELETE FROM daftar WHERE id = ?";
    $stmt = $db->prepare($sql_delete);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $delete_message = "Data berhasil dihapus.";
    } else {
        $delete_message = "Gagal menghapus data.";
    }
}

$sql = "SELECT * FROM daftar";
$result = $db->query($sql);
$total_rows = $result->num_rows;
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Pendaftar</title>
    <link rel="stylesheet" href="../vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('../assets-templates/bckgrndPen.png');
            background-size: cover;
            background-position: center;
            height: 100vh;
        }

        h2 {
            padding: 10px;
            font-weight: bold;
            transition: 0.5s;
            cursor: pointer;
        }

        h2:hover {
            font-size: 40px;
        }

        .total {
            padding-bottom: 10px;
        }
    </style>
</head>

<body>
    <?php include "../assets-templates/header.html"; ?>

    <div class="container">
        <div class="center">
            <h2 class="text-center" style="color:#E8F3F4;">Mahasiswa Terdaftar</h2>

            <?php if (!empty($delete_message)) : ?>
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <?= $delete_message ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
                
            <?php if ($total_rows > 0) : ?>
                <table class="table table-secondary table-hover text-center">
                    <thead>
                        <tr class="table table-dark">
                            <th scope="col">ID</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Agama</th>
                            <th scope="col">Jenis Kelamin</th>
                            <th scope="col">Asal Sekolah</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) : ?>
                            <tr id="row-<?= $row["id"] ?>">
                                <th scope="row"><?= $row["id"] ?></th>
                                <td><?= $row["nama"] ?></td>
                                <td><?= $row["alamat"] ?></td>
                                <td><?= $row["agama"] ?></td>
                                <td><?= $row["jenis_kelamin"] ?></td>
                                <td><?= $row["sekolah_asal"] ?></td>
                                <td>
                                    <a class="btn btn-custom delete-btn btn-danger " name="delete" href="?delete=<?= $row["id"] ?>">Hapus Data</a>
                                    <a class="btn btn-custom edit-btn btn-success " href="editData.php?id=<?= $row["id"] ?>">Edit</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <div class="alert alert-warning">
                    Tidak ada data yang ditemukan.
                </div>
            <?php endif; ?>
            <div class="total" style="color: #5CE1E6;">
                Total Mahasiswa Terdaftar : <?= $total_rows ?>
            </div>

            <a href="halamanDaftar.php" class="btn btn-custom btn-primary ">[+]Tambah Baru</a>
            <a class="btn btn-custom btn-secondary ms-3" href="index.php">Kembali ke Beranda</a>
            <a href="download.php" class="btn btn-custom ms-3 btn-warning">Unduh Data</a>


        </div>
    </div>

    <?php $db->close(); ?>

    <?php include "../assets-templates/footer.html"; ?>
    <script src="../vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>