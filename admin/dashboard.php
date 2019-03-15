<?php 
require_once("auth.php"); 
require_once("../php/koneksi.php");

$sql = "SELECT * FROM landblog_perusahaan";
$stmt = $db->prepare($sql);
$stmt->execute();
$usaha = $stmt->fetch(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard Admin</title>
	<link rel="stylesheet" href="../css/search.css" />
	<link rel="icon" href="img/profil/<?php echo $usaha["favicon"];?>" sizes="32x32">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
	<link href="../css/responsive-table.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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
		            <a class="nav-link" href="profil.php">Profil</a>
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
			<div class="card mb-3">
				<div class="card-header text-center bg-dark text-white">Halo, Admin</div>
                <div class="card-body">
					<div class="row">
						<div class="col-md-12">
							<p>Selamat Datang!</p>
						</div>
					</div>	
				</div>
            </div>
        </div>
    </div>
</div>
</div>

<script src="../js/jquery.min.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
