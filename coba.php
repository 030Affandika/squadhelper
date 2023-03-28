<?php
require 'db.php';


if (isset($_POST['kirim'])) {
    $nama_sepatu = $_POST['nama_sepatu'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    // $gambar = $_POST['gambar'];

    $gambar = upload();
    if (!$gambar) {
        return false;
    }

    $query = "INSERT INTO produk VALUES (NULL, '$nama_sepatu', '$harga', '$deskripsi', '$gambar')";
    mysqli_query($koneksi, $query);
    header("location:index.php");
}

function upload()
{
    $nama_file = $_FILES['gambar']['name'];
    $ukuran_file = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    if ($error === 4) {
        echo "<script>
            alert('Pilih Gambar Terlebih Dahulu!');
        </script>";
        return false;
    }

    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $nama_file);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>
            alert('Upload Gambar!');
        </script>";
        return false;
    }

    move_uploaded_file($tmpName, 'img/' . $nama_file);

    return $nama_file;
}

?>