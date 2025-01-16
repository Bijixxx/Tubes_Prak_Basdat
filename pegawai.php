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
        <!-- Tombol Tambah Pegawai -->
        <div class="mb-3 text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahPegawaiModal">Tambah Pegawai</button>
        </div>

        <?php
        //Koneksi ke database
        include 'koneksi2.php';

        //Query untuk menampilkan tabel pegawai
        $sql = "SELECT * FROM pegawai";

        // Menjalankan query
        $result = mysqli_query($koneksi, $sql);

        // Cek apakah ada data yang ditemukan
        if (mysqli_num_rows($result) > 0) {
            echo "<div class='table-responsive'>
                    <table class='table table-bordered mx-auto w-100'>
                    <thead>
                        <tr>
                            <th>ID Pegawai</th>
                            <th>Nama Pegawai</th>
                            <th>Departemen</th>
                            <th>Kontak</th>
                            <th>Posisi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                    <td>" . $row['ID_Pegawai'] . "</td>
                    <td>" . $row['Nama'] . "</td>
                    <td>" . $row['Departemen'] . "</td>
                    <td>" . $row['Kontak'] . "</td>
                    <td>" . $row['Posisi'] . "</td>
                    <td>
                        <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editPegawaiModal' data-id='" . $row['ID_Pegawai'] . "' data-nama='" . $row['Nama'] . "' data-departemen='" . $row['Departemen'] . "' data-kontak='" . $row['Kontak'] . "' data-posisi='" . $row['Posisi'] . "'>Edit</button>
                        <form action='' method='post' style='display:inline;' onsubmit='return confirm(\"Apakah Anda yakin ingin menghapus?\");'>
                            <input type='hidden' name='id_pegawai' value='" . $row['ID_Pegawai'] . "'>
                            <button type='submit' name='hapus' class='btn btn-danger btn-sm'>Hapus</button>
                        </form>
                    </td>
                </tr>";
            }
            echo "</tbody></table></div>";
        } else {
            echo "Tidak ada data yang ditemukan.";
        }

        if (isset($_POST['submit'])) {
            // Koneksi ke database      
            include 'koneksi2.php';
    
            // Mengambil data dari form
            $Nama = $_POST['namaPegawai']; // Sesuaikan nama field dengan atribut "name" pada form
            $Departemen = $_POST['departemen'];
            $Kontak = $_POST['kontak'];
            $Posisi = $_POST['posisi'];
    
            // Query untuk menambahkan data peminjaman
            $sql = "INSERT INTO pegawai (Nama, Departemen, Kontak, Posisi) 
                    VALUES ('$Nama', '$Departemen', '$Kontak', '$Posisi')";
    
            // Menjalankan query dan menampilkan pesan
            if (mysqli_query($koneksi, $sql)) {
                echo "<div class='alert alert-success mt-4'>Data pegawai berhasil ditambahkan!</div>";
            } else {
                echo "<div class='alert alert-danger mt-4'>Terjadi kesalahan: " . mysqli_error($koneksi) . "</div>";
            }
        }

        // Update Pegawai
        if (isset($_POST['updatePegawai'])) {
            $id = $_POST['id_pegawai'];
            $nama = $_POST['editNamaPegawai'];
            $departemen = $_POST['editDepartemen'];
            $kontak = $_POST['editKontak'];
            $posisi = $_POST['editPosisi'];

            $sql = 
            "UPDATE 
                pegawai 
            SET 
                Nama='$nama', 
                Departemen='$departemen', 
                Kontak='$kontak', 
                Posisi='$posisi' 
            WHERE 
                ID_Pegawai='$id'";

            if (mysqli_query($koneksi, $sql)) {
                echo "<div class='alert alert-success mt-4'>Data pegawai berhasil diperbarui!</div>";
            } else {
                echo "<div class='alert alert-danger mt-4'>Terjadi kesalahan: " . mysqli_error($koneksi) . "</div>";
            }
        }

        // Hapus Pegawai
        if (isset($_POST['hapus'])) {
            $id = $_POST['id_pegawai'];

            $sql = "DELETE FROM pegawai WHERE ID_Pegawai='$id'";

            if (mysqli_query($koneksi, $sql)) {
                echo "<div class='alert alert-success mt-4'>Data pegawai berhasil dihapus!</div>";
            } else {
                echo "<div class='alert alert-danger mt-4'>Terjadi kesalahan: " . mysqli_error($koneksi) . "</div>";
            }
        }

        // Menutup koneksi
        mysqli_close($koneksi);
        ?>
    </div>

    <!-- Modal Tambah Pegawai -->
    <div class="modal fade" id="tambahPegawaiModal" tabindex="-1" aria-labelledby="tambahPegawaiLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahPegawaiLabel">Tambah Pegawai</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="namaPegawai" class="form-label">Nama Pegawai</label>
                            <input type="text" class="form-control" id="namaPegawai" name="namaPegawai" placeholder="Masukkan Nama Pegawai" required>
                        </div>
                        <div class="mb-3">
                            <label for="departemen" class="form-label">Departemen</label>
                            <input type="text" class="form-control" id="departemen" name="departemen" placeholder="Masukkan Nama Departemnen" required>
                        </div>
                        <div class="mb-3">
                            <label for="kontak" class="form-label">Kontak</label>
                            <input type="text" class="form-control" id="kontak" name="kontak" placeholder="Masukkan Kontak (Nomor HP)" required>
                        </div>
                        <div class="mb-3">
                            <label for="posisi" class="form-label">Posisi</label>
                            <input type="text" class="form-control" id="posisi" name="posisi" placeholder="Masukkan Posisi" required>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary" name="submit">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Pegawai -->
    <div class="modal fade" id="editPegawaiModal" tabindex="-1" aria-labelledby="editPegawaiLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPegawaiLabel">Edit Pegawai</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="editNamaPegawai" class="form-label">Nama Pegawai</label>
                            <input type="text" class="form-control" id="editNamaPegawai" name="editNamaPegawai" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDepartemen" class="form-label">Departemen</label>
                            <input type="text" class="form-control" id="editDepartemen" name="editDepartemen" required>
                        </div>
                        <div class="mb-3">
                            <label for="editKontak" class="form-label">Kontak</label>
                            <input type="text" class="form-control" id="editKontak" name="editKontak" required>
                        </div>
                        <div class="mb-3">
                            <label for="editPosisi" class="form-label">Posisi</label>
                            <input type="text" class="form-control" id="editPosisi" name="editPosisi" required>
                        </div>
                        <input type="hidden" name="id_pegawai" id="editIdPegawai">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary" name="updatePegawai">Simpan Perubahan</button>
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
        const editButtons = document.querySelectorAll('[data-bs-toggle="modal"][data-bs-target="#editPegawaiModal"]');
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('editIdPegawai').value = this.getAttribute('data-id');
                document.getElementById('editNamaPegawai').value = this.getAttribute('data-nama');
                document.getElementById('editDepartemen').value = this.getAttribute('data-departemen');
                document.getElementById('editKontak').value = this.getAttribute('data-kontak');
                document.getElementById('editPosisi').value = this.getAttribute('data-posisi');
            });
        });
    </script>


</body>
</html>