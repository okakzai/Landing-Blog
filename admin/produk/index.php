<?php 
require_once("../auth.php"); 
require_once("../../php/koneksi.php");

$sql = "SELECT * FROM landblog_produk";
$stmt = $db->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll();
$array=array();
$no =1;
foreach($result as $row) {
	$array[]=array(
		'no'=>$no++,
		'gambar'=>'<img src="img/'.$row["gambar"].'" height="150"/>',
		'nama'=>$row["nama"],
		'keterangan'=>$row["keterangan"],
		'link'=>$row["link"],
		'pengaturan'=>'<a href="edit.php?id='.$row["id"].'" class="btn btn-info btn-block"><i class="fa fa-pencil"></i> Edit</a>
					<a href="hapus.php?id='.$row["id"].'" class="btn btn-danger btn-block"><i class="fa fa-trash"></i> Hapus</a>'
	);	
}
$dataphp = array('data'=>$array);
$datajson=json_encode($dataphp);
$fp = fopen('produk.json', 'w');
fwrite($fp,$datajson);
fclose($fp);

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
    <title>Produk - Admin</title>
	<link rel="stylesheet" href="../../css/search.css" />
	<link rel="icon" href="../img/profil/<?php echo $usaha["favicon"];?>" sizes="32x32">
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css" />
	<link href="../../css/responsive-table.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css"/>
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
			<div class="card mb-3">
				<div class="card-header text-center bg-dark text-white">Halaman Pengaturan Produk</div>
                <div class="card-body">
					<div class="row">
						<div class="col-md-12">
							<a href="tambah.php" class="btn btn-dark btn-block"><i class="fa fa-plus"></i> Tambah Produk</a>
						</div>
						<!--
						<div class="col-md-6">
							<form action="cari.php" class="search-form">
								<div class="form-group has-feedback">
									<label for="search" class="sr-only">search</label>
									<input type="text" class="form-control" name="search" id="search" placeholder="Ketik NAMA PRODUK yang Anda cari, kemudian tekan ENTER">
									<span class="fa fa-search form-control-feedback"></span>
								</div>
							</form>
						</div>
						-->
					</div>	
					<hr>
					<div id="no-more-tables">
						<table id="produk" class="table table-bordered table-responsive">
							<thead class="bg-secondary text-white">
								<tr>
									<th style="text-align:left">No.</th>
									<th style="text-align:center">Gambar</th>
									<th style="text-align:center">Nama</th>
									<th style="text-align:center">Keterangan</th>
									<th style="text-align:center">Link</th>
									<th style="text-align:right">Pengaturan</th>										
								</tr>
							</thead>
							<tbody>
								<!--
								<?php foreach($result as $row) {?>
								<tr>
									<td data-title="No." style="text-align:left;"><?php echo $row["id"];?>.</td>
									<td data-title="NIP" style="text-align:center">
										<img src="img/<?php echo $row["gambar"];?>" height="150"/>
									</td>
									<td data-title="Nama" style="text-align:center"><?php echo $row["nama"];?></td>
									<td data-title="Username" style="text-align:center;"><?php echo  $row["keterangan"];?></td>
									<td data-title="Pengaturan" style="text-align:right">
										<a href="edit.php?id=<?php echo $row["id"];?>" class="btn btn-secondary btn-block"><i class="fa fa-pencil"></i> Edit</a>
										<a href="hapus.php?id=<?php echo $row["id"];?>" class="btn btn-secondary btn-block"><i class="fa fa-trash"></i> Hapus</a>
									</td>												
								</tr>
								<?php } ?>
								-->
							</tbody>
						</table>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>
</div>

<script src="../../js/jquery.min.js"></script>
<script src="../../bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script>
$('document').ready(function(){
	$('#produk').dataTable( {
		"ajax": "produk.json",
		"columns": [
			{ "data": "no" },
			{ "data": "gambar" },
			{ "data": "nama" },
			{ "data": "keterangan" },
			{ "data": "link" },
			{ "data": "pengaturan" }
		]
	} );
})
</script>
</body>
</html>
