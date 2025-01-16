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
        <!-- Tombol Tambah Barang -->
        <div class="mb-3 text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahBarangForm">Tambah Barang</button>
        </div>
        <?php
        //Koneksi ke database
        include 'koneksi2.php';

        //Query untuk menampilkan tabel barang
        $sql = "SELECT * FROM barang";

        // Menjalankan query
        $result = mysqli_query($koneksi, $sql);

        // Cek apakah ada data yang ditemukan
        if (mysqli_num_rows($result) > 0) {
            echo "<div class='table-responsive'>
                    <table class='table table-bordered mx-auto w-100'>
                    <thead>
                        <tr>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                    <td>" . $row['Kode_Barang'] . "</td>
                    <td>" . $row['Nama_Barang'] . "</td>
                    <td>" . $row['Deskripsi'] . "</td>
                    <td>" . $row['Status_Barang'] . "</td>
                    <td>
                        <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editBarang' 
                        data-id='" . $row['Kode_Barang'] . "' 
                        data-nama='" . $row['Nama_Barang'] . "' 
                        data-deskripsi='" . $row['Deskripsi'] . "'>Edit</button>
                        <form action='' method='post' style='display:inline;' onsubmit='return confirm(\"Apakah Anda yakin ingin menghapus?\");'>
                            <input type='hidden' name='kode_barang' value='" . $row['Kode_Barang'] . "'>
                            <button type='submit' name='hapus' class='btn btn-danger btn-sm'>Hapus</button>
                        </form>
                    </td>
                </tr>";
            }
            echo "</tbody></table></div>";
        } else {
            echo "Tidak ada data yang ditemukan.";
        }

        if (isset($_POST['submitBarang'])) {
            // Koneksi ke database      
            include 'koneksi2.php';
    
            // Mengambil data dari form
            $Nama_Barang = $_POST['Nama_Barang'];
            $Deskripsi = $_POST['Deskripsi'];
    
            // Query untuk menambahkan data peminjaman
            $sql = "INSERT INTO barang (Nama_Barang, Deskripsi) 
                    VALUES ('$Nama_Barang', '$Deskripsi')";
    
            // Menjalankan query dan menampilkan pesan
            if (mysqli_query($koneksi, $sql)) {
                echo "<div class='alert alert-success mt-4'>Data barang berhasil ditambahkan!</div>";
            } else {
                echo "<div class='alert alert-danger mt-4'>Terjadi kesalahan: " . mysqli_error($koneksi) . "</div>";
            }
        }

        // Update Barang
        if (isset($_POST['updatePegawai'])) {
            $id = $_POST['kode_barang'];
            $nama = $_POST['editNamaBarang'];
            $deskripsi = $_POST['editDeskripsi'];

            $sql = "UPDATE barang SET Nama_Barang='$nama', Deskripsi='$deskripsi' WHERE Kode_Barang='$id'";

            if (mysqli_query($koneksi, $sql)) {
                echo "<div class='alert alert-success mt-4'>Data barang berhasil diperbarui!</div>";
            } else {
                echo "<div class='alert alert-danger mt-4'>Terjadi kesalahan: " . mysqli_error($koneksi) . "</div>";
            }
        }

        // Hapus Barang
        if (isset($_POST['hapus'])) {
            $id = $_POST['kode_barang'];

            $sql = "DELETE FROM barang WHERE Kode_Barang='$id'";

            if (mysqli_query($koneksi, $sql)) {
                echo "<div class='alert alert-success mt-4'>Data barang berhasil dihapus!</div>";
            } else {
                echo "<div class='alert alert-danger mt-4'>Terjadi kesalahan: " . mysqli_error($koneksi) . "</div>";
            }
        }

        // Menutup koneksi
        mysqli_close($koneksi);
        ?>
    </div>

    <!-- Modal Tambah Barang -->
    <div class="modal fade" id="tambahBarangForm" tabindex="-1" aria-labelledby="tambahBarangLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahBarangLabel">Tambah Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="Nama_Barang" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" id="Nama_Barang" name="Nama_Barang" placeholder="Masukkan Nama Barang" required>
                        </div>
                        <div class="mb-3">
                            <label for="Deskripsi" class="form-label">Deskripsi</label>
                            <input type="text" class="form-control" id="Deskripsi" name="Deskripsi" placeholder="Masukkan Deskripsi" required>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary" name="submitBarang">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Pegawai -->
    <div class="modal fade" id="editBarang" tabindex="-1" aria-labelledby="editBarangLabel" aria-hidden="true">
        <div class="modal-dialog">`
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBarangLabel">Edit Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="editNamaBarang" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" id="editNamaBarang" name="editNamaBarang" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDeskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="editDeskripsi" name="editDeskripsi" rows="3" placeholder="Masukkan deskripsi" required></textarea>
                        </div>
                        <input type="hidden" name="kode_barang" id="editKodeBarang">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary" name="updateBarang">Simpan Perubahan</button>
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
           crossorigin="anonymous">
    </script>
    <script>
        const editButtons = document.querySelectorAll('[data-bs-toggle="modal"][data-bs-target="#editBarang"]');
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('editKodeBarang').value = this.getAttribute('data-id');
                document.getElementById('editNamaBarang').value = this.getAttribute('data-nama');
                document.getElementById('editDeskripsi').value = this.getAttribute('data-deskripsi');
            });
        });
    </script>

</body>
</html>
