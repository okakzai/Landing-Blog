<?php 
ini_set('display_errors', 0);
require_once("../auth.php"); 
require_once("../../php/koneksi.php");
$notifikasi='';

$sql = "SELECT * FROM landblog_perusahaan";
$stmt = $db->prepare($sql);
$stmt->execute();
$usaha = $stmt->fetch(PDO::FETCH_ASSOC);

if(isset($_POST['tambah'])){
	$link = filter_input(INPUT_POST, 'link', FILTER_SANITIZE_STRING);
	$nama = filter_input(INPUT_POST, 'nama', FILTER_SANITIZE_STRING);
    $keterangan = filter_input(INPUT_POST, 'keterangan', FILTER_SANITIZE_STRING);
    $destination_path = getcwd().DIRECTORY_SEPARATOR;
	
	$nama_gambar = $_FILES['gambar']['name'];
	$ukuran_gambar = $_FILES['gambar']['size'];
	$tipe_gambar = $_FILES['gambar']['type'];
	$tmp_gambar = $_FILES['gambar']['tmp_name'];
	$path_gambar = $destination_path."img/".$nama_gambar;
	
	if($tipe_gambar == "image/jpeg" || $tipe_gambar == "image/png"){ // Cek apakah tipe file yang diupload adalah JPG / JPEG / PNG  
		// Jika tipe file yang diupload JPG / JPEG / PNG, lakukan :  
		if($ukuran_gambar <= 1000000){ // Cek apakah ukuran file yang diupload kurang dari sama dengan 1MB    
			// Jika ukuran file kurang dari sama dengan 1MB, lakukan :    Proses upload    
			if(move_uploaded_file($tmp_gambar, $path_gambar)){
				$sql = "INSERT INTO landblog_produk (gambar, nama, keterangan, link) 
						VALUES (:gambar, :nama, :keterangan, :link)";
				$stmt = $db->prepare($sql);
				$params = array(
					":gambar" => $nama_gambar,
					":nama" => $nama,
					":keterangan" => $keterangan,
					":link" => $link
				);
				$saved = $stmt->execute($params);
				if($saved) header("Location: index.php");
			} else {
					$notifikasi = "Maaf, Gambar gagal untuk diupload!";	
				}
		} else {
			$notifikasi = "Maaf, Ukuran Gambar yang diupload tidak boleh lebih dari 1MB!";	
		}
	} else {
		$notifikasi = "Maaf, Tipe Gambar yang diupload harus JPG/JPEG/PNG!";
	}
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tambah Produk - Admin</title>
	<link rel="stylesheet" href="../../css/search.css" />
	<link rel="icon" href="../img/profil/<?php echo $usaha["favicon"];?>" sizes="32x32">
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css" />
	<link href="../../css/responsive-table.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="../../css/my-login.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body class="bg-light" style="font-size:17px;">
<nav class="navbar navbar-dark fixed-top navbar-expand-md navbar-no-bg" style="background:#444;">
	<div class="container">
		<a class="navbar-brand" href="../dashboard.php" style="color:white;">Dashboard Admin</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNav">
		    <ul class="navbar-nav ml-auto">
				<li class="nav-item">
		            <a class="nav-link" href="../profil.php">Profil</a>
		        </li>
				<li class="nav-item">
		            <a class="nav-link" href="../produk" style="background:white;color:black;">Produk</a>
		        </li>
				<li class="nav-item">
		            <a class="nav-link" href="../blog">Blog</a>
		        </li>
				<li class="nav-item">
		            <a class="nav-link" href="../logout.php">Logout</a>
		        </li>
		    </ul>
		</div>
	</div>
</nav>
<div class="top-content" style="padding-top:30px;">
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">       
			<?php if ($notifikasi!=''){?>
			<div class="card mb-3">
                <div class="card-body">
					<p align="center" style="color:green;">
						<?php echo $notifikasi;?>
					</p>
				</div>
			</div>
			<?php }?>
			<div class="card mb-3">
				<div class="card-header text-center bg-dark text-white">Tambah Produk</div>
                <div class="card-body">
					<form method="POST" enctype="multipart/form-data">	
						<div class="form-group">
							<label for="gambar">Gambar</label>
							<input id="gambar" type="file" class="form-control" name="gambar">
						</div>
						<div class="form-group">
							<label for="nama">Nama</label>
							<input id="nama" type="text" class="form-control" name="nama" value="" required autofocus>
						</div>
						<div class="form-group">
							<label for="link">Link Website</label>
							<input id="link" type="text" class="form-control" name="link" value="<?php echo $row["link"];?>" required autofocus>
						</div>
						<div class="form-group">
							<label for="keterangan">Keterangan</label>
							<textarea class="form-control ckeditor" id="keterangan" name="keterangan" required></textarea>
						</div>
						<div class="form-group no-margin">
							<input type="submit" class="btn btn-primary btn-block" name="tambah" value="Simpan Data" />
						</div>
					</form>				
				</div>
            </div>
        </div>
    </div>
</div>
</div>

<script src="../../js/jquery.min.js"></script>
<script src="../../bootstrap/js/bootstrap.min.js"></script>
<script src="../../js/my-login.js"></script>
<script type="text/javascript" src="../../ckeditor/ckeditor.js"></script>
</body>
</html>
