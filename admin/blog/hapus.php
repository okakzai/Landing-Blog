<?php 
require_once("../auth.php"); 
require_once("../../php/koneksi.php");

$sql = "SELECT * FROM landblog_perusahaan";
$stmt = $db->prepare($sql);
$stmt->execute();
$usaha = $stmt->fetch(PDO::FETCH_ASSOC);

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$sql = "SELECT * FROM landblog_blog  WHERE id=:id";
$stmt = $db->prepare($sql);
$params = array(
	":id" => $id,
);
$stmt->execute($params);
$result = $stmt->fetchAll();

if(isset($_POST['hapus'])){
	$sql = "DELETE from landblog_blog
			WHERE id=:id";
    $stmt = $db->prepare($sql);
	$params = array(
		":id" => $id
    );
	$saved = $stmt->execute($params);
	if($saved) header("Location: index.php");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hapus Tulisan - Admin</title>
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
		            <a class="nav-link" href="../produk">Produk</a>
		        </li>
				<li class="nav-item">
		            <a class="nav-link" href="../blog" style="background:white;color:black;">Blog</a>
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
			<div class="card mb-3">
				<div class="card-header text-center bg-dark text-white">Informasi Tulisan</div>
                <div class="card-body">
					<form method="POST">			
					<?php foreach($result as $row) {?>
						<img src="img/<?php echo $row["gambar"];?>" height="150" />
						<hr />
						<h1><?php echo $row["judul"];?></h1>
						<hr />
						<?php echo $row["deskripsi"];?>
						<hr />
						<a href="<?php echo $row["link"];?>"><?php echo $row["link"];?></a>
						<hr />
						<div class="form-group no-margin">
							<input type="submit" class="btn btn-primary btn-block" name="hapus" value="Hapus Akun" />
						</div>
					<?php } ?>	
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
</body>
</html>
