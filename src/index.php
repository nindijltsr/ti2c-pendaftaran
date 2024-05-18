<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Landing Page Sederhana</title>
  <link rel="stylesheet" href="../vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
  <style>
    body {
      background-image: url('../assets-templates/bckgrndIndex.png');
      background-size: cover;
      background-position: center;
      height: 100vh;
    }

    .container1 {
      position: absolute;
      top: 50%;
      left: 50%;
      width: 550px;
      transform: translate(-50%, -50%);
      background-color: rgba(255, 255, 255, 0.50);
      padding: 20px;
      border-radius: 10px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }

    h1 {
      text-align: center;
      margin-bottom: 20px;
    }

    .btn {
      margin: 0 auto;
    }

    .btnM {
      width: 115px;
      margin-top: -10px;

    }
  </style>
</head>

<body>
  <?php include '../assets-templates/header.html'; ?>
  <?php
  if (isset($_GET['message'])) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
    echo htmlspecialchars($_GET['message']);
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '<a href="tampilkanPendaftar.php" class="btn btn-sm btn-success float-end btnM">Lihat Pendaftar</a>';
    echo '</div>';
  }
  ?>
  <div class="container1">
    <h1>Pendaftaran Mahasiswa Baru !</h1>
    <p>Mulai Perjalanan Pendidikanmu di CRUDIFY</p>

    <a href="halamanDaftar.php" class="btn btn-primary">Daftar</a>
  </div>
  <?php include '../assets-templates/footer.html'; ?>
  <script src="../vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>