<?php 
ini_set('display_errors', 0);
date_default_timezone_set('Asia/Jakarta');
require_once("../php/koneksi.php");

$sql = "SELECT * FROM landblog_perusahaan";
$stmt = $db->prepare($sql);
$stmt->execute();
$usaha = $stmt->fetch(PDO::FETCH_ASSOC);

if(isset($_POST['login'])){

    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    $sql = "SELECT * FROM landblog_admin WHERE username=:username OR email=:email";
    $stmt = $db->prepare($sql);
    
    // bind parameter ke query
    $params = array(
        ":username" => $username,
        ":email" => $username
    );

    $stmt->execute($params);

    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    // jika user terdaftar
    if($admin){
        // verifikasi password
        if(password_verify($password, $admin["password"])){
            // buat Session
            session_start();
            $_SESSION["admin"] = $admin;
            // login sukses, alihkan ke halaman timeline
            header("Location: dashboard.php");
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="author" content="Didin Studio">
	<title>Landblog - Admin</title>
	<link rel="icon" href="img/profil/<?php echo $usaha["favicon"];?>" sizes="32x32">
	<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/my-login.css">
</head>
<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper">
					<div class="brand" style="border-radius:0;height:auto;width:100%;box-shadow:none;">
						<img src="img/profil/<?php echo $usaha["logo"];?>">
					</div>
					<div class="card fat">
						<div class="card-body">
							<h4 class="card-title">Login</h4>
							<form method="POST">
							 
								<div class="form-group">
									<label for="username">Username</label>

									<input id="username" type="username" class="form-control" name="username" value="" required autofocus>
								</div>

								<div class="form-group">
									<label for="password">Password
									</label>
									<input id="password" type="password" class="form-control" name="password" required>
								</div>

								<div class="form-group no-margin">
									<input type="submit" class="btn btn-primary btn-block" name="login" value="Login" />
								</div>
								<div class="margin-top20 text-center">
									Bukan Admin? <a href="../">Home</a>
								</div>
							</form>
						</div>
					</div>
					<div class="footer">
						Copyright &copy; Didin Studio <?php echo date("Y"); ?>
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="../js/jquery.min.js"></script>
	<script src="../bootstrap/js/bootstrap.min.js"></script>
	<script src="../js/my-login.js"></script>
</body>
</html>