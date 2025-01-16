<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris Kantor HAR</title>    
    <link rel="stylesheet" href="lightbox.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
          crossorigin="anonymous">
    <style>
        table {
            background-color: #f2f2f2 !important; 
            opacity: 80%;
        }
        th, td {
            background-color: #e0e0e0 !important; 
        }
        tr:nth-child(even) {
            background-color: #d3d3d3 !important; 
        }
    </style>
</head>
<body class="bg-secondary d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-secondary bg-secondary">
        <div class="container-fluid d-flex justify-content-center">
            <a class="navbar-brand" href="#"><span class="span2">Kantor</span><span class="span1">HAR</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link m-2" href="main.php">Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link m-2" href="pegawai.php">Pegawai</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link m-2" href="peminjaman.php">Peminjaman</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link m-2" href="pengembalian.php">Pengembalian</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Isi Data -->
    <div class="container mt-4 flex-grow-1">
        <!-- Tombol Tambah Pengembalian -->
        <div class="mb-3 text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahPengembalianModal">Tambah Pengembalian</button>
        </div>

        <?php
        // Koneksi ke database
        include 'koneksi2.php';

        // Query untuk menampilkan tabel pengembalian
        $sql = "SELECT 
                    p.ID_Pengembalian, 
                    p.ID_Peminjaman, 
                    p.Tanggal_Pengembalian, 
                    pm.Tanggal_Peminjaman
                FROM 
                    pengembalian p
                JOIN 
                    peminjaman pm ON p.ID_Peminjaman = pm.ID_Peminjaman";

        // Menjalankan query
        $result = mysqli_query($koneksi, $sql);

        // Cek apakah ada data yang ditemukan
        if (mysqli_num_rows($result) > 0) {
            echo "<div class='table-responsive'>
                    <table class='table table-bordered mx-auto w-100'>
                    <thead>
                        <tr>
                            <th>ID Pengembalian</th>
                            <th>ID Peminjaman</th>
                            <th>Tanggal Peminjaman</th>
                            <th>Tanggal Pengembalian</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                    <td>" . $row['ID_Pengembalian'] . "</td>
                    <td>" . $row['ID_Peminjaman'] . "</td>
                    <td>" . $row['Tanggal_Peminjaman'] . "</td>
                    <td>" . $row['Tanggal_Pengembalian'] . "</td>
                    <td> 
                        <form action='' method='post' style='display:inline;' onsubmit='return confirm(\"Apakah Anda yakin ingin menghapus?\");'>
                            <input type='hidden' name='id_pengembalian' value='" . $row['ID_Pengembalian'] . "'>
                            <button type='submit' name='hapus' class='btn btn-danger btn-sm'>Hapus</button>
                        </form>
                    </td>
                </tr>";
            }
            echo "</tbody></table></div>";
        } else {
            echo "Tidak ada data yang ditemukan.";
        }

        if (isset($_POST['submitPengembalian'])) {
            // Koneksi ke database      
            include 'koneksi2.php';
    
            // Mengambil data dari form
            $ID_Peminjaman = $_POST['idPeminjaman'];
            $Tanggal_Pengembalian = $_POST['tanggalPengembalian'];
    
            // Query untuk menambahkan data pengembalian
            $sql = "INSERT INTO pengembalian (ID_Peminjaman, Tanggal_Pengembalian) 
                    VALUES ('$ID_Peminjaman', '$Tanggal_Pengembalian')";
    
            // Menjalankan query dan menampilkan pesan
            if (mysqli_query($koneksi, $sql)) {
                echo "<div class='alert alert-success mt-4'>Data pengembalian berhasil ditambahkan!</div>";
            } else {
                echo "<div class='alert alert-danger mt-4'>Terjadi kesalahan: " . mysqli_error($koneksi) . "</div>";
            }
        }

        // Hapus Peminjaman
        if (isset($_POST['hapus'])) {
            $id = $_POST['id_pengembalian'];

            $sql = "DELETE FROM pengembalian WHERE ID_Pengembalian='$id'";

            if (mysqli_query($koneksi, $sql)) {
                echo "<div class='alert alert-success mt-4'>Data pengembalian berhasil dihapus!</div>";
            } else {
                echo "<div class='alert alert-danger mt-4'>Terjadi kesalahan: " . mysqli_error($koneksi) . "</div>";
            }
        }

        // Menutup koneksi
        mysqli_close($koneksi);
        ?>
    </div>

    <!-- Modal Tambah Pengembalian -->
    <div class="modal fade" id="tambahPengembalianModal" tabindex="-1" aria-labelledby="tambahPengembalianLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahPengembalianLabel">Tambah Pengembalian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="idPeminjaman" class="form-label">ID Peminjaman</label>
                            <input type="text" class="form-control" id="idPeminjaman" name="idPeminjaman" placeholder="Masukkan ID Peminjaman" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggalPengembalian" class="form-label">Tanggal Pengembalian</label>
                            <input type="date" class="form-control" id="tanggalPengembalian" name="tanggalPengembalian" required>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary" name="submitPengembalian">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

   <!-- Footer -->
   <footer class="text-dark py-4 bg-secondary mt-auto">
    <div class="container text-center">
        <p>&copy; Kelompok 5</p>
        <p>CONTACT ME</p>
        <p>Email: kelompok5@gmail.com</p>
    </div>
   </footer>

   <script src="lightbox.js"></script>
   <script src="lightbox.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
           integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
           crossorigin="anonymous"></script>
</body>
</html>
