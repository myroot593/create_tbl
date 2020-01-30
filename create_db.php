<?php
require_once('koneksi.php');
$nama_database_err="";
if($_SERVER['REQUEST_METHOD']=='POST'){
	if(empty($_POST['nama_database'])){
		$nama_database_err='Nama database tidak boleh kosong';
	}else{
		//cek apakah nama database tersebut sudah ada sebelumnya
		$cek_db=$koneksi->select_db($_POST['nama_database']);
		if($cek_db){
			$nama_database_err="Database ".$_POST['nama_database']." sudah ada !";			
		}else{
			$nama_database=$koneksi->escape_string($_POST['nama_database']);
		}
	}
	if(empty($nama_database_err)){
		$sql=sprintf("CREATE DATABASE IF NOT EXISTS %s",$nama_database);
		if($koneksi->query($sql)):
			echo "Database berhasil dibuat";
		else:
			echo "Database gagal dibuat";
		endif;
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Buat Database</title>
	<link href="../style/bootstrap.min.css" rel="stylesheet">
	
</head>
<body>
<div class="container">
	<h1>Buat Database</h1>
	<hr>
	<div class="row">
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

		
				<div class="form-group">
					<label>Nama Database :</label>
					<input class="form-control" type="text" name="nama_database" id="nama_database" />
					<span><?php echo $nama_database_err; ?></span>
				</div>
				<div class="form-group">
					<input class="btn btn-md btn-primary" type="submit" name="buat" value="Buat" />
				</div>		
		</form>
		<a href="list_db.php">Lihat Database</a>
	</div>
</div>
</body>
</html>
