<?php

$koneksi = mysqli_connect("localhost", "root", "", "sistempeminjamanbarang");
    
if(!$koneksi){
    die("Koneksi gagal: " . mysqli_connect_error());
}

?>