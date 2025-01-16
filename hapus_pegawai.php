<?php
// Koneksi ke database
include 'koneksi2.php';

// Cek apakah ID Pegawai ada di POST
if (isset($_POST['idPegawai'])) {
    $idPegawai = $_POST['idPegawai'];

    // Query untuk menghapus data pegawai
    $sql = "DELETE FROM pegawai WHERE ID_Pegawai = $idPegawai";

    if (mysqli_query($koneksi, $sql)) {
        echo "<script>
                alert('Data pegawai berhasil dihapus!');
                window.location.href = 'pegawai.php';
              </script>";
    } else {
        echo "Terjadi kesalahan: " . mysqli_error($koneksi);
    }

    // Menutup koneksi
    mysqli_close($koneksi);
} else {
    echo "<script>
            alert('ID Pegawai tidak ditemukan.');
            window.location.href = 'pegawai.php';
          </script>";
}
?>
