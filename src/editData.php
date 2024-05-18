<?php
include "koneksiDB.php";
session_start();

$update_message = "";
$update_successful = false;
$error_occurred = false;

if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "SELECT * FROM daftar WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if($stmt->execute()) {
        $result = $stmt->get_result();
        
        if($result->num_rows > 0) {
            $data = $result->fetch_assoc();
        } else {
            echo "Data tidak ditemukan";
        }
    } else {
        echo "Gagal menjalankan perintah";
    }
} else {
    echo "ID tidak valid";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["update"])) {
    $nama = $_POST["nama"];
    $alamat = $_POST["alamat"];
    $jenis_kelamin = $_POST["jenis_kelamin"];
    $agama = $_POST["agama"];
    $sekolah_asal = $_POST["sekolah_asal"];

    try {
        $sql = "UPDATE daftar SET nama=?, alamat=?, jenis_kelamin=?, agama=?, sekolah_asal=? WHERE id=?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("sssssi", $nama, $alamat, $jenis_kelamin, $agama, $sekolah_asal, $id);

        if ($stmt->execute()) {
            $update_message = "Data Berhasil Diperbarui";
            $update_successful = true;

            $data['nama'] = $nama;
            $data['alamat'] = $alamat;
            $data['jenis_kelamin'] = $jenis_kelamin;
            $data['agama'] = $agama;
            $data['sekolah_asal'] = $sekolah_asal;
        } else {
            $update_message = "Data Gagal Diperbarui, Coba Lagi !";
            $error_occurred = true;
        }
    } catch (mysqli_sql_exception $e) {
        $update_message = " " . $e->getMessage();
        $error_occurred = true;
    }

    $db->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Barang</title>
    <style>
        body {
            background-image: url('../assets-templates/bckgrndDaf.png'); 
            background-size: cover;
            background-position: center;
            height: 100vh;
        }
        .container1 {
            position: absolute; 
            top: 52%;
            left: 50%;
            width: 600px;
            transform: translate(-50%, -50%);      
            background-color: rgba(255, 255, 255, 0.50);
            padding: 20px;
            border-radius: 10px;
            display: flex;
            flex-direction: column;    
        }
        .alert-custom {
            width: 450px;
            height: 45px;
            margin: 0 auto 5px;
        }
        .btnM {
            width: 115px;
            margin-top: -10px;
        }
        .success {
            font-weight: bold;
            margin-bottom: 10px;
            line-height: 11px;
        }
        .error {
            color: red;
            font-weight: bold;
            text-align: center;
            line-height: 11px;
        }
    </style>
</head>
<body>

    <?php include "../assets-templates/header.html"; ?>
    
    <div class="container1">
        <h1 class="text-center">Ubah Data</h1>
        <?php if (!empty($update_message)) : ?>
            <div class="alert alert-info alert-dismissible fade show alert-custom <?php echo $update_successful ? 'success' : ($error_occurred ? 'error' : ''); ?>" role="alert">
                <?php echo $update_message; ?>
                <?php if ($update_successful) : ?>
                    <a href="tampilkanPendaftar.php" class="btn btn-sm btn-success float-end btnM">Lihat Pendaftar</a>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <?php endif; ?>

            </div>
        <?php endif; ?>
            <form method="POST" action="editData.php?id=<?= $id ?>">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-12">
                    <div class="row mb-2">
                        <label for="nama" class="col-sm-3 col-form-label">Nama :</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="nama" id="nama" value="<?= htmlspecialchars($data['nama']) ?>" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="alamat" class="col-sm-3 col-form-label">Alamat :</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="alamat" id="alamat" style="height: 100px" required><?= htmlspecialchars($data['alamat']) ?></textarea>
                        </div>
                    </div>
                    <div class="row mb-2">
                    <label for="agama" class="col-sm-3 col-form-label">Agama :</label>
                    <div class="col-sm-9">
                        <select class="form-select" name="agama" id="agama" required>
                            <option value="">Pilih Agama</option>
                            <option value="Islam" <?= ($data['agama'] == 'Islam') ? 'selected' : '' ?>>Islam</option>
                            <option value="Kristen Katolik" <?= ($data['agama'] == 'Kristen Katolik') ? 'selected' : '' ?>>Kristen Katolik</option>
                            <option value="Kristen Protestan" <?= ($data['agama'] == 'Kristen Protestan') ? 'selected' : '' ?>>Kristen Protestan</option>
                            <option value="Budha" <?= ($data['agama'] == 'Budha') ? 'selected' : '' ?>>Budha</option>
                            <option value="Hindu" <?= ($data['agama'] == 'Hindu') ? 'selected' : '' ?>>Hindu</option>
                            <option value="Lainnya" <?= ($data['agama'] == 'Lainnya') ? 'selected' : '' ?>>Lainnya</option>
                        </select>
                    </div>
                </div>
                <fieldset class="row

                <fieldset class="row mb-2">
    <legend class="col-form-label col-sm-3 pt-0">Jenis Kelamin :</legend>
    <div class="col-sm-9">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin_perempuan" value="Perempuan" <?= ($data['jenis_kelamin'] == 'Perempuan') ? 'checked' : '' ?> required>
            <label class="form-check-label" for="jenis_kelamin_perempuan">Perempuan</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin_laki_laki" value="Laki-Laki" <?= ($data['jenis_kelamin'] == 'Laki-Laki') ? 'checked' : '' ?> required>
            <label class="form-check-label" for="jenis_kelamin_laki_laki">Laki-Laki</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin_lainnya" value="Lainnya" <?= ($data['jenis_kelamin'] == 'Lainnya') ? 'checked' : '' ?> required>
            <label class="form-check-label" for="jenis_kelamin_lainnya">Lainnya</label>
        </div>
    </div>
</fieldset>
<div class="row mb-2">
    <label for="sekolah_asal" class="col-sm-3 col-form-label">Sekolah Asal :</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" name="sekolah_asal" id="sekolah_asal" value="<?= htmlspecialchars($data['sekolah_asal']) ?>" required>
    </div>
</div>

                    <div class="row mb-3">
                        <div class="col-sm-9 offset-sm-3">
                            <button type="submit" name="update" class="btn btn-primary">Simpan</button>
                            <a href="tampilkanPendaftar.php" class="btn btn-secondary ms-2 btn-danger">Batal</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    
        </div>
        <?php include '../assets-templates/footer.html'; ?>
        <script src="../vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>    
    </body>
</html>
