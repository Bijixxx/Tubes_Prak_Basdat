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
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        <!-- Tombol Tambah Peminjaman -->
        <div class="mb-3 text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahPeminjamanModal">Tambah Peminjaman</button>
        </div>

        <?php
        //Koneksi ke database
        include 'koneksi2.php';

        //Query untuk menampilkan tabel peminjaman
        $sql = "SELECT * FROM peminjaman";

        // Menjalankan query
        $result = mysqli_query($koneksi, $sql);

        // Cek apakah ada data yang ditemukan
        if (mysqli_num_rows($result) > 0) {
            echo "<div class='table-responsive'>
                    <table class='table table-bordered mx-auto w-100'>
                    <thead>
                        <tr>
                            <th>ID Peminjaman</th>
                            <th>ID Pegawai</th>
                            <th>Kode Barang</th>
                            <th>Tanggal Peminjaman</th>
                            <th>Status Peminjaman</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                    <td>" . $row['ID_Peminjaman'] . "</td>
                    <td>" . $row['ID_Pegawai'] . "</td>
                    <td>" . $row['Kode_Barang'] . "</td>
                    <td>" . $row['Tanggal_Peminjaman'] . "</td>
                    <td>" . $row['Status_Peminjaman'] . "</td>
                    <td> 
                        <form action='' method='post' style='display:inline;' onsubmit='return confirm(\"Apakah Anda yakin ingin menghapus?\");'>
                            <input type='hidden' name='id_peminjaman' value='" . $row['ID_Peminjaman'] . "'>
                            <button type='submit' name='hapus' class='btn btn-danger btn-sm'>Hapus</button>
                        </form>
                    </td>
                </tr>";
            }
            echo "</tbody></table></div>";
        } else {
            echo "Tidak ada data yang ditemukan.";
        }

        if (isset($_POST['submitPeminjaman'])) {
            // Koneksi ke database      
            include 'koneksi2.php';
    
            // Mengambil data dari form
            $ID_Pegawai = $_POST['idPegawai'];
            $Kode_Barang = $_POST['kodeBarang'];
            $Tanggal_Peminjaman = $_POST['tanggalPeminjaman'];
    
            // Query untuk menambahkan data peminjaman
            $sql = "INSERT INTO peminjaman (ID_Pegawai, Kode_Barang, Tanggal_Peminjaman) 
                    VALUES ('$ID_Pegawai', '$Kode_Barang', '$Tanggal_Peminjaman')";
    
            // Menjalankan query dan menampilkan pesan
            if (mysqli_query($koneksi, $sql)) {
                echo "<div class='alert alert-success mt-4'>Data peminjaman berhasil ditambahkan!</div>";
            } else {
                echo "<div class='alert alert-danger mt-4'>Terjadi kesalahan: " . mysqli_error($koneksi) . "</div>";
            }
        }

        // Hapus Peminjaman
        if (isset($_POST['hapus'])) {
            $id = $_POST['id_peminjaman'];

            $sql = "DELETE FROM peminjaman WHERE ID_Peminjaman='$id'";

            if (mysqli_query($koneksi, $sql)) {
                echo "<div class='alert alert-success mt-4'>Data peminjaman berhasil dihapus!</div>";
            } else {
                echo "<div class='alert alert-danger mt-4'>Terjadi kesalahan: " . mysqli_error($koneksi) . "</div>";
            }
        }

        // Menutup koneksi
        mysqli_close($koneksi);
        ?>
    </div>

    <!-- Modal Tambah Peminjaman -->
    <div class="modal fade" id="tambahPeminjamanModal" tabindex="-1" aria-labelledby="tambahPeminjamanLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahPeminjamanLabel">Tambah Peminjaman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="idPegawai" class="form-label">ID Pegawai</label>
                            <input type="text" class="form-control" id="idPegawai" name="idPegawai" placeholder="Masukkan ID Pegawai" required>
                        </div>
                        <div class="mb-3">
                            <label for="kodeBarang" class="form-label">Kode Barang</label>
                            <input type="text" class="form-control" id="kodeBarang" name="kodeBarang" placeholder="Masukkan Kode Barang" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggalPeminjaman" class="form-label">Tanggal Peminjaman</label>
                            <input type="date" class="form-control" id="tanggalPeminjaman" name="tanggalPeminjaman" required>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary" name="submitPeminjaman">Simpan</button>
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
