<?php 
session_start();
include 'db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
<div class="container">
		<h3 class="my-4">Tambah Data Produk</h3>
		<div class="card border-primary">
			<div class="card-body">
				<form action="" method="POST" enctype="multipart/form-data">
					<div class="mb-3">
						<label for="nama" class="form-label">Judul</label>
						<input type="text" name="nama" class="form-control" placeholder="Judul" required>
					</div>
					<div class="mb-3">
						<label for="kategori" class="form-label">Kategori</label>
						<select class="form-select" name="kategori" required>
							<option value="">--Pilih--</option>
							<?php 
							$kategori = mysqli_query($conn, "SELECT * FROM tb_category ORDER BY category_id DESC");
							while($r = mysqli_fetch_array($kategori)){
								?>
								<option value="<?php echo $r['category_id'] ?>"><?php echo $r['category_name'] ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="mb-3">
							<label for="harga" class="form-label">Harga</label>
							<input type="text" name="harga" class="form-control" placeholder="Harga" required>
						</div>
						<div class="mb-3">
							<label for="gambar" class="form-label">Gambar</label>
							<input type="file" name="gambar" class="form-control" required>
						</div>
						<div class="mb-3">
							<label for="deskripsi" class="form-label">Deskripsi</label>
							<textarea class="form-control" name="deskripsi" placeholder="Deskripsi"></textarea><br>
						</div>
						<div class="mb-3">
							<label for="status" class="form-label">Status</label>
							<select class="form-select" name="status">
								<option value="">--Pilih--</option>
								<option value="1">Aktif</option>
								<option value="0">Tidak Aktif</option>
							</select>
						</div>
						<input type="submit" name="submit" value="Submit" class="btn btn-primary">
					</form>

					<?php



if (isset($_POST['submit'])) {
    $kategori 	= $_POST['kategori'];
	$nama 		= $_POST['nama'];
	$harga 		= $_POST['harga'];
	$deskripsi 	= $_POST['deskripsi'];
	$status 	= $_POST['status'];
	// $gambar		= $_POST['gambar'];

    $gambar = upload();
    if (!$gambar) {
        return false;
    }

    $insert = mysqli_query($conn, "INSERT INTO tb_product VALUES (
		null,
		'".$kategori."',
		'".$nama."',
		'".$harga."',
		'".$deskripsi."',
		'".$newname."',
		'".$status."',
		null
			) ");
    // mysqli_query($conn, $query);
    header("location:beranda.php");
}

function upload()
{
    $nama_file = $_FILES['gambar']['name'];
    
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
</body>
</html>