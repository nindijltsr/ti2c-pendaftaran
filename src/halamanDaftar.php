<?php
include "koneksiDB.php";
session_start();

$register_message = " ";
$update_successful = false;

function generateRandomID() {
    return str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
}

if (isset($_POST["daftar"])) {
    $nama = $_POST["nama"];
    $alamat = $_POST["alamat"];
    $jenis_kelamin = $_POST["jenis_kelamin"];
    $agama = $_POST["agama"];
    $sekolah_asal = $_POST["sekolah_asal"];

    $id = generateRandomID();

    try {
        $sql = "INSERT INTO daftar (id, nama, alamat, jenis_kelamin, agama, sekolah_asal) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("isssss", $id, $nama, $alamat, $jenis_kelamin, $agama, $sekolah_asal);

        if ($stmt->execute()) {
            $register_message = "Pendaftaran Berhasil";
            $update_successful = true;

            header("Location: index.php?message=".urldecode($register_message));
            exit();
        } else {
            $register_message = "Pendaftaran Gagal, Coba Lagi !";
            $error_occurred = true;
        }
    } catch (mysqli_sql_exception $e) {
        $register_message = " " . $e->getMessage();
        $error_occurred = true;
    }

    $db->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page Sederhana</title>
    <link rel="stylesheet" href="../vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
    <script src="../vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
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
                width: 590px;
                transform: translate(-50%, -50%);      
                background-color: rgba(255, 255, 255, 0.55);
                padding: 20px;
                border-radius: 10px;
                display: flex;
                flex-direction: column;  
            }
            .font {
                font-weight: bold;
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
            line-height: 12px;
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
    <?php include '../assets-templates/header.html'; ?>
    <div class="container1">
        <h1 class="text-center">Formulir Pendaftaran</h1>
        <?php if ($register_message != " ") : ?>
    <div class="alert alert-info alert-dismissible fade show alert-custom <?php echo $update_successful ? 'success' : ($error_occurred ? 'error' : ''); ?>" role="alert" style="max-height: 100px; overflow-y: auto;">
        <?php echo $register_message; ?>
        <?php if ($update_successful) : ?>
        <?php endif; ?>
    </div>
<?php endif; ?>
        <form method="post" action="">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="row mb-2">
                    <label for="nama" class="col-sm-3 col-form-label font">Nama :</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="nama" id="nama" required>
                    </div>
                </div>
                <div class="row mb-2">
                    <label for="alamat" class="col-sm-3 col-form-label font">Alamat :</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" name="alamat" id="alamat" style="height: 100px" required></textarea>
                    </div>
                </div>
                <div class="row mb-2">
                    <label for="agama" class="col-sm-3 col-form-label font">Agama :</label>
                    <div class="col-sm-9">
                        <select class="form-select" name="agama" id="agama" required>
                            <option value="">Pilih Agama</option>
                            <option value="Islam">Islam</option>
                            <option value="Kristen Katolik">Kristen Katolik</option>
                            <option value="Kristen Protestan">Kristen Protestan</option>
                            <option value="Budha">Budha</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                </div>
                <fieldset class="row mb-2">
                    <legend class="col-form-label col-sm-3 pt-0 font">Jenis Kelamin :</legend>
                    <div class="col-sm-9">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin_perempuan" value="Perempuan" required>
                            <label class="form-check-label" for="jenis_kelamin_perempuan">Perempuan</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin_laki_laki" value="Laki-Laki" required>
                            <label class="form-check-label" for="jenis_kelamin_laki_laki">Laki-Laki</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin_lainnya" value="Lainnya" required>
                            <label class="form-check-label" for="jenis_kelamin_lainnya">Lainnya</label>
                        </div>
                    </div>
                </fieldset>
                <div class="row mb-2">
                    <label for="sekolah_asal" class="col-sm-3 col-form-label font">Sekolah Asal :</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="sekolah_asal" id="sekolah_asal" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-9 offset-sm-3">
                        <button type="submit" name="daftar" class="btn btn-primary">Submit</button>
                        <a href="index.php" class="btn btn-secondary ms-2"> Kembali</a>
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