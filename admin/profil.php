<?php 
ini_set('display_errors', 0);
date_default_timezone_set('Asia/Jakarta');
require_once("auth.php"); 
require_once("../php/koneksi.php");
$notifikasi='';

$sql = "SELECT * FROM landblog_sosmed";
$stmt = $db->prepare($sql);
$stmt->execute();
$sosmed = $stmt->fetchAll();

$sql = "SELECT * FROM landblog_perusahaan";
$stmt = $db->prepare($sql);
$stmt->execute();
$usaha = $stmt->fetch(PDO::FETCH_ASSOC);

if(isset($_POST['gantipassword'])){
	$passwordlama = filter_input(INPUT_POST, 'passwordlama', FILTER_SANITIZE_STRING);
	$passwordbaru = password_hash($_POST["passwordbaru"], PASSWORD_DEFAULT);
	
	$sql = "SELECT * FROM landblog_admin";
    $stmt = $db->prepare($sql);  
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
	if(password_verify($passwordlama, $admin["password"])){
		$sql = "UPDATE landblog_admin SET password = :passwordbaru";
		$stmt = $db->prepare($sql);
		// bind parameter ke query
		$params = array(":passwordbaru" => $passwordbaru);
		// eksekusi query untuk menyimpan ke database
		$saved = $stmt->execute($params);
		// jika query simpan berhasil, maka user sudah terdaftar
		// maka alihkan ke halaman login
		if($saved) header("Location: logout.php");
	}else{
		$notifikasi='Password Lama Salah, Ulangi Lagi!';
	}
}
if(isset($_POST['sosmed'])){
	$facebook = filter_input(INPUT_POST, 'facebook', FILTER_SANITIZE_STRING);
	$dribble = filter_input(INPUT_POST, 'dribble', FILTER_SANITIZE_STRING);
	$twitter = filter_input(INPUT_POST, 'twitter', FILTER_SANITIZE_STRING);
	$instagram = filter_input(INPUT_POST, 'instagram', FILTER_SANITIZE_STRING);
	$pinterest = filter_input(INPUT_POST, 'pinterest', FILTER_SANITIZE_STRING);
	$sql = "UPDATE landblog_sosmed 
			SET facebook=:facebook, dribble=:dribble, twitter=:twitter, instagram=:instagram, pinterest=:pinterest";
    $stmt = $db->prepare($sql);
	$params = array(
		":facebook" => $facebook,
		":dribble" => $dribble,
		":twitter" => $twitter,
		":instagram" => $instagram,
		":pinterest" => $pinterest
    );
	$saved = $stmt->execute($params);
	if($saved) header("Location: profil.php");
}
if(isset($_POST['usaha'])){
	$nama = filter_input(INPUT_POST, 'nama', FILTER_SANITIZE_STRING);
	$deskripsi_banner = filter_input(INPUT_POST, 'deskripsi_banner', FILTER_SANITIZE_STRING);
	$judul_banner = filter_input(INPUT_POST, 'judul_banner', FILTER_SANITIZE_STRING);
	$tombol_banner = filter_input(INPUT_POST, 'tombol_banner', FILTER_SANITIZE_STRING);
	
	$destination_path = getcwd().DIRECTORY_SEPARATOR;
	
	$nama_favicon = $_FILES['favicon']['name'];
	$ukuran_favicon = $_FILES['favicon']['size'];
	$tipe_favicon = $_FILES['favicon']['type'];
	$tmp_favicon = $_FILES['favicon']['tmp_name'];
	$path_favicon = $destination_path."img/profil/".$nama_favicon;
	
	$nama_logo = $_FILES['logo']['name'];
	$ukuran_logo = $_FILES['logo']['size'];
	$tipe_logo = $_FILES['logo']['type'];
	$tmp_logo = $_FILES['logo']['tmp_name'];
	$path_logo = $destination_path."img/profil/".$nama_logo;
	
	$nama_banner = $_FILES['banner']['name'];
	$ukuran_banner = $_FILES['banner']['size'];
	$tipe_banner = $_FILES['banner']['type'];
	$tmp_banner = $_FILES['banner']['tmp_name'];
	$path_banner = $destination_path."img/profil/".$nama_banner;	
	
	if ($nama_favicon==null && $nama_logo==null && $nama_banner==null){
		$sql = "UPDATE landblog_perusahaan 
				SET nama=:nama, deskripsi_banner=:deskripsi_banner, judul_banner=:judul_banner, tombol_banner=:tombol_banner";
		$stmt = $db->prepare($sql);
		$params = array(
			":nama" => $nama,
			":judul_banner" => $judul_banner,
			":tombol_banner" => $tombol_banner,
			":deskripsi_banner" => $deskripsi_banner
		);
		$saved = $stmt->execute($params);
		if($saved) header("Location: profil.php");
	} else if ($nama_favicon!=null && $nama_logo==null && $nama_banner==null) {
		if($tipe_favicon == "image/jpeg" || $tipe_favicon == "image/png"){ // Cek apakah tipe file yang diupload adalah JPG / JPEG / PNG  
			// Jika tipe file yang diupload JPG / JPEG / PNG, lakukan :  
			if($ukuran_favicon <= 1000000){ // Cek apakah ukuran file yang diupload kurang dari sama dengan 1MB    
				// Jika ukuran file kurang dari sama dengan 1MB, lakukan :    Proses upload    
				if(move_uploaded_file($tmp_favicon, $path_favicon)){
					$sql = "UPDATE landblog_perusahaan 
							SET nama=:nama, favicon=:favicon, deskripsi_banner=:deskripsi_banner, judul_banner=:judul_banner, tombol_banner=:tombol_banner";
					$stmt = $db->prepare($sql);
					$params = array(
						":nama" => $nama,
						":favicon" => $nama_favicon,
						":judul_banner" => $judul_banner,
						":tombol_banner" => $tombol_banner,
						":deskripsi_banner" => $deskripsi_banner
					);
					$saved = $stmt->execute($params);
					if($saved) header("Location: profil.php");
				} else {
					$notifikasi = "Maaf, Favicon gagal untuk diupload!";	
				}
			} else {
				$notifikasi = "Maaf, Ukuran Favicon yang diupload tidak boleh lebih dari 1MB!";	
			}
		} else {
			$notifikasi = "Maaf, Tipe Favicon yang diupload harus JPG/JPEG/PNG!";
		}
	} else if ($nama_logo!=null && $nama_favicon==null && $nama_banner==null) {
		if($tipe_logo == "image/jpeg" || $tipe_logo == "image/png"){ // Cek apakah tipe file yang diupload adalah JPG / JPEG / PNG  
			// Jika tipe file yang diupload JPG / JPEG / PNG, lakukan :  
			if($ukuran_logo <= 1000000){ // Cek apakah ukuran file yang diupload kurang dari sama dengan 1MB    
				// Jika ukuran file kurang dari sama dengan 1MB, lakukan :    Proses upload    
				if(move_uploaded_file($tmp_logo, $path_logo)){
					$sql = "UPDATE landblog_perusahaan 
							SET nama=:nama, logo=:logo, deskripsi_banner=:deskripsi_banner, judul_banner=:judul_banner, tombol_banner=:tombol_banner";
					$stmt = $db->prepare($sql);
					$params = array(
						":nama" => $nama,
						":logo" => $nama_logo,
						":judul_banner" => $judul_banner,
						":tombol_banner" => $tombol_banner,
						":deskripsi_banner" => $deskripsi_banner
					);
					$saved = $stmt->execute($params);
					if($saved) header("Location: profil.php");
				} else {
					$notifikasi = "Maaf, Logo gagal untuk diupload!";	
				}
			} else {
				$notifikasi = "Maaf, Ukuran Logo yang diupload tidak boleh lebih dari 1MB!";	
			}
		} else {
			$notifikasi = "Maaf, Tipe Logo yang diupload harus JPG/JPEG/PNG!";
		}
	} else if ($nama_banner!=null && $nama_logo==null && $nama_favicon==null) {
		if($tipe_banner == "image/jpeg" || $tipe_banner == "image/png"){ // Cek apakah tipe file yang diupload adalah JPG / JPEG / PNG  
			// Jika tipe file yang diupload JPG / JPEG / PNG, lakukan :  
			if($ukuran_banner <= 1000000){ // Cek apakah ukuran file yang diupload kurang dari sama dengan 1MB    
				// Jika ukuran file kurang dari sama dengan 1MB, lakukan :    Proses upload    
				if(move_uploaded_file($tmp_banner, $path_banner)){
					$sql = "UPDATE landblog_perusahaan 
							SET nama=:nama, gambar_banner=:banner, deskripsi_banner=:deskripsi_banner, judul_banner=:judul_banner, tombol_banner=:tombol_banner";
					$stmt = $db->prepare($sql);
					$params = array(
						":nama" => $nama,
						":banner" => $nama_banner,
						":judul_banner" => $judul_banner,
						":tombol_banner" => $tombol_banner,
						":deskripsi_banner" => $deskripsi_banner
					);
					$saved = $stmt->execute($params);
					if($saved) header("Location: profil.php");
				} else {
					$notifikasi = "Maaf, Banner gagal untuk diupload!";	
				}
			} else {
				$notifikasi = "Maaf, Ukuran Banner yang diupload tidak boleh lebih dari 1MB!";	
			}
		} else {
			$notifikasi = "Maaf, Tipe Banner yang diupload harus JPG/JPEG/PNG!";
		}
	} else if ($nama_favicon!=null && $nama_logo!=null && $nama_banner!=null) {
		if(($tipe_logo == "image/jpeg" || $tipe_logo == "image/png")&&($tipe_favicon == "image/jpeg" || $tipe_favicon == "image/png")&&($tipe_banner == "image/jpeg" || $tipe_banner == "image/png")){ // Cek apakah tipe file yang diupload adalah JPG / JPEG / PNG  
			// Jika tipe file yang diupload JPG / JPEG / PNG, lakukan :  
			if(($ukuran_logo <= 1000000) && ($ukuran_favicon <= 1000000) && ($ukuran_banner <= 1000000)){ // Cek apakah ukuran file yang diupload kurang dari sama dengan 1MB    
				// Jika ukuran file kurang dari sama dengan 1MB, lakukan :    Proses upload    
				if((move_uploaded_file($tmp_logo, $path_logo)) && (move_uploaded_file($tmp_favicon, $path_favicon)) && (move_uploaded_file($tmp_banner, $path_banner))){
					$sql = "UPDATE landblog_perusahaan 
							SET nama=:nama, gambar_banner=:banner, logo=:logo, favicon=:favicon, deskripsi_banner=:deskripsi_banner, judul_banner=:judul_banner, tombol_banner=:tombol_banner";
					$stmt = $db->prepare($sql);
					$params = array(
						":nama" => $nama,
						":logo" => $nama_logo,
						":favicon" => $nama_favicon,
						":banner" => $nama_banner,
						":judul_banner" => $judul_banner,
						":tombol_banner" => $tombol_banner,
						":deskripsi_banner" => $deskripsi_banner
					);
					$saved = $stmt->execute($params);
					if($saved) header("Location: profil.php");
				} else {
					$notifikasi = "Maaf, Logo &/ Favicon &/ Banner gagal untuk diupload!";	
				}
			} else {
				$notifikasi = "Maaf, Ukuran Logo &/ Favicon &/ Banner yang diupload tidak boleh lebih dari 1MB!";	
			}
		} else {
			$notifikasi = "Maaf, Tipe Logo &/ Favicon &/ Banner yang diupload harus JPG/JPEG/PNG!";
		}
	}
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profil - Dashboard Admin</title>
	<link rel="icon" href="img/profil/<?php echo $usaha["favicon"];?>" sizes="32x32">
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <!--<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />-->
	<link href="../css/responsive-table.css" rel="stylesheet" type="text/css">
	<style>
		#nav-tabContent{
			border-bottom: solid #dee2e6 1px;
			border-right: solid #dee2e6 1px;
			border-left: solid #dee2e6 1px;
			padding:10px;
		}
	</style>
</head>
<body class="bg-light" style="font-size:17px;">
<nav class="navbar navbar-dark fixed-top navbar-expand-md navbar-no-bg" style="background:#444;">
	<div class="container">
		<a class="navbar-brand" href="./dashboard.php" style="color:white;">Dashboard Admin</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNav">
		    <ul class="navbar-nav ml-auto">
				<li class="nav-item">
		            <a class="nav-link" href="./profil.php" style="background:white;color:black;">Profil</a>
		        </li>
				<li class="nav-item">
		            <a class="nav-link" href="produk">Produk</a>
		        </li>
				<li class="nav-item">
		            <a class="nav-link" href="blog">Blog</a>
		        </li>
				<li class="nav-item">
		            <a class="nav-link" href="logout.php">Logout</a>
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
				<div class="card-header text-center bg-dark text-white">Halaman Pengaturan Profil</div>
                <div class="card-body">
					<div class="row">
						<div class="col-md-12">
							<nav>
								<div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
									<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#perusahaan" role="tab" aria-controls="perusahaan" aria-selected="true">Perusahaan</a>
									<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#social-media" role="tab" aria-controls="social-media" aria-selected="false">Social Media</a>
									<a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#keamanan" role="tab" aria-controls="keamanan" aria-selected="false">Keamanan</a>
								</div>
							</nav>
							<div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
								<div class="tab-pane fade show active" id="perusahaan" role="tabpanel" aria-labelledby="perusahaan" style="padding:10px;">
									<div class="card mb-3">
										<div class="card-body">
											<form method="POST" enctype="multipart/form-data">			
												<div class="form-group">
													<label for="nama">Nama Usaha</label>
													<input id="nama" type="text" class="form-control" name="nama" value="<?php echo $usaha["nama"];?>" autofocus required>
												</div>
												<div class="form-group">
													<label for="favicon">Favicon</label>
													<input id="favicon" type="file" class="form-control" name="favicon">
												</div>
												<div class="form-group">
													<label for="logo">Logo</label>
													<input id="logo" type="file" class="form-control" name="logo">
												</div>
												<div class="form-group">
													<label for="banner">Banner</label>
													<input id="banner" type="file" class="form-control" name="banner">
												</div>
												<div class="form-group">
													<label for="judul_banner">Judul Banner</label>
													<input id="judul_banner" type="text" class="form-control" name="judul_banner" value="<?php echo $usaha["judul_banner"];?>" autofocus required>
												</div>
												<div class="form-group">
													<label for="deskripsi_banner">Deskripsi Banner</label>
													<textarea class="form-control ckeditor" id="deskripsi_banner" name="deskripsi_banner" autofocus required><?php echo $usaha["deskripsi_banner"];?></textarea>
												</div>
												<div class="form-group">
													<label for="tombol_banner">Tombol Banner</label>
													<input id="tombol_banner" type="text" class="form-control" name="tombol_banner" value="<?php echo $usaha["tombol_banner"];?>" autofocus required>
												</div>
												<div class="form-group no-margin">
													<input type="submit" class="btn btn-primary btn-block" name="usaha" value="Simpan Data" />
												</div>
											</form>				
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="social-media" role="tabpanel" aria-labelledby="social-media" style="padding:10px;">
									<div class="card mb-3">
										<div class="card-body">
											<form method="POST">			
											<?php foreach($sosmed as $row) {?>
												<div class="form-group">
													<label for="facebook">Facebook URL</label>
													<input id="facebook" type="text" class="form-control" name="facebook" value="<?php echo $row["facebook"];?>" autofocus>
												</div>
												<div class="form-group">
													<label for="dribble">Dribble URL</label>
													<input id="dribble" type="text" class="form-control" name="dribble" value="<?php echo $row["dribble"];?>" autofocus>
												</div>
												<div class="form-group">
													<label for="twitter">Twitter URL</label>
													<input id="twitter" type="text" class="form-control" name="twitter" value="<?php echo $row["twitter"];?>" autofocus>
												</div>
												<div class="form-group">
													<label for="instagram">Instagram URL</label>
													<input id="instagram" type="text" class="form-control" name="instagram" value="<?php echo $row["instagram"];?>" autofocus>
												</div>
												<div class="form-group">
													<label for="pinterest">Pinterest URL</label>
													<input id="pinterest" type="text" class="form-control" name="pinterest" value="<?php echo $row["pinterest"];?>" autofocus>
												</div>
												<div class="form-group no-margin">
													<input type="submit" class="btn btn-primary btn-block" name="sosmed" value="Simpan Data" />
												</div>
											<?php } ?>	
											</form>				
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="keamanan" role="tabpanel" aria-labelledby="keamanan" style="padding:10px;">
									<div class="card mb-3">
										<div class="card-body">
											<form method="POST">
												<div class="form-group">
													<label for="passwordlama">Password Lama</label>
													<input id="passwordlama" type="password" class="form-control" name="passwordlama" required data-eye>
												</div>
												<div class="form-group">
													<label for="passwordbaru">Password Baru</label>
													<input id="passwordbaru" type="password" class="form-control" name="passwordbaru" required data-eye>
												</div>
												<div class="form-group no-margin">
													<input type="submit" class="btn btn-primary btn-block" name="gantipassword" value="Ganti Password" />
												</div>
											</form>
										</div>	
									</div>
								</div>
							</div>
						</div>
					</div>	
				</div>
            </div>            
        </div>    
    </div>
</div>
</div>

<script src="../js/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<!--<script src="../bootstrap/js/bootstrap.min.js"></script>-->
<script src="../js/my-login.js"></script>
<script type="text/javascript" src="../ckeditor/ckeditor.js"></script>
</body>
</html>
