<?php
	require_once('koneksi.php');
	require_once('select_db.php');
	/*
	Bagian ini proses untuk menyimpan nama dan panjang kolom

	*/
	$nama_tbl_err = $pjg_kolom_err = $nama_tbl = $pjg_kolom ="";
	if($_SERVER['REQUEST_METHOD']=='POST'){
		if(empty($_POST['nama_tbl'])){
			$nama_tbl_err="Nama tabel masih kosong";
		}else{
			$nama_tbl=$_POST['nama_tbl'];
		}
		if(empty($_POST['pjg_kolom'])){
			$pjg_kolom_err="Panjang kolom tidak boleh kosong";
		}elseif(!is_numeric($_POST['pjg_kolom'])){
			$pjg_kolom_err="Panjang kolom harus berupa angka";
		
		}else{
			$pjg_kolom=$_POST['pjg_kolom'];
		}
		if(empty($nama_tbl_err) && empty($pjg_kolom_err)){
			$nama_tabel=$nama_tbl;
			$panjang_kolom=$pjg_kolom;
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Membuat Tabel</title>
	<link href="../style/bootstrap.min.css" rel="stylesheet">
</head>
<body>
	<div class="container">
		<h1>Buat Tabel</h1>
		<hr>
	<div class="row">
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
			<div class="row">	
				<div class="col-6">
					<div class="form-group">
						<label>Nama Tabel</label>
						<input class="form-control" type="text" name="nama_tbl" id="nama_tbl" value="<?php echo $nama_tbl; ?>">
						<span><?php echo $nama_tbl_err; ?></span>
					</div>
				</div>
				<div class="col-4">
					<div class="form-group">
						<label>Jumlah kolom</label>
						<input class="form-control" type="text" name="pjg_kolom" id="pjg_kolom" value="<?php echo $pjg_kolom; ?>" />
						<span><?php echo $pjg_kolom_err; ?></span>					
					</div>
				</div>
				<div class="col-4">
					<input class="btn btn-md btn-primary" type="submit" name="kirim" id="kirim" value="kirim" />
				</div>
			</div>
		</form>

		<?php
		/*jika kondisi $nama_tabel dan $panjang_kolom terpenuhi atau tidak kosong, maka jalankan perintah berikutnya
		lakukan perulangan berdasakrkan panjang kolom yang dimiinta oleh user
		*/
		if(!empty($nama_tabel)&& ($panjang_kolom)){
			$tabel = $nama_kolom_err= $panjang_kolom_err ="";
			/*Validasi tabel
			Saat terjadi proses simpan pada tabel. Kondisi ini akan terpenuhi jika $nama_tabel dan $panjang kolom terpenuhi
			*/
			if(isset($_POST['ciptakan_tabel'])){
				$kol="";
				for($i=1; $i<=$panjang_kolom; $i++){
					$nmkol="nama_kolom".$i;
					$tipe="tipe_data".$i;
					$pjg="length".$i;
					$nul="kosong".$i;
					if($nul!="NULL"){
						$kos="NOT NULL";
					}
					//validasi nama kolom dan length kolom
					if(empty(trim($_POST[$nmkol]))){
						$nama_kolom_err="Nama kolom tidak boleh kosong";
					}elseif(empty($_POST[$pjg])){
						$panjang_kolom_err="Panjang kolom tidak boleh kosong";
					}else{	
						/*$kol ini berisi format nama kolom tipe dan panjang serta atribut not null
						Contoh query nantinya akan berisi format berikut : nama_kolom INT(13) NOT NULL, dst
						*/			
						$kol.=$_POST[$nmkol]." ".$_POST[$tipe]." (".$_POST[$pjg].") ".$kos.",";

					}
				//akhir perulangan for	
				}
				//jika nama klom dan length kolom tidak kosong, maka eksekusi perintah berikutnya
				if(empty($nama_kolom_err) && empty($panjang_kolom_err)){
					/*query untuk membuat tabel
					jadi querynya kurang lebih akan memiliki hasil CREATE TABLE nama_tabel (nama_kolom INT(13) NOT NULL,
					 dan seterusnya dan memberi primary key pada paramter nama_kolom1
					)
					*/
					$per=sprintf("CREATE TABLE %s(%s%s)",$_POST['nama_tabel'],$kol,"PRIMARY KEY(".$_POST['nama_kolom1'].")");
					if(!$koneksi->query($per)){
						$tabel='<div class="alert alert-danger">Tabel gagal dibuat</div>';
					}else{
						$tabel='<div class="alert alert-success">Tabel berhasil dibuat</div>';
					}
				}

				//query test
				//CREATE TABLE `latihan1`.`uji` ( `id` INT(13) NOT NULL AUTO_INCREMENT , `nama` VARCHAR(30) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
			}
		/*jika kondisi $nama_tabel dan $panjang_kolom terpenuhi atau tidak kosong, maka jalankan perintah berikutnya
		lakukan perulangan berdasakrkan panjang kolom yang dimiinta oleh user. Formulir ini akan ditampilkan
		*/
			echo '
		<form action="'.$_SERVER['PHP_SELF'].'" method="post">
			<input type="hidden" name="nama_tbl" id="nama_tbl" value="'.$nama_tabel.'" />
			<input type="hidden" name="pjg_kolom" id="pjg_kolom" value="'.$panjang_kolom.'" />
			<div class="row">
				'.$tabel.'
				<table class="table table-bordered">
					<tr>
						<th colspan="4">Tabel '.$nama_tabel.'<br/><span>'.$nama_kolom_err.''.$panjang_kolom_err.'</th>
					</tr>
					<tr>
						<th>Nama Kolom</th>
						<th>Tipe Data</th>
						<th>Length</th>
						<th>Kosong</>
					</tr>

					';
					//lakukan perulangan sesuai dengan panjang kolom
					for($k=1; $k<=$panjang_kolom; $k++){
						$nama_kolom="nama_kolom".$k;
						$tipe_data="tipe_data".$k;
						$length="length".$k;
						$kosong="kosong".$k;
						echo '
						<tr>
							<td>
							<input class="form-control" type="text" name="'.$nama_kolom.'" id="'.$nama_kolom.'"  />
							
							
							</td>
							<td>
							<select class="form-control" name="'.$tipe_data.'" id="'.$tipe_data.'">
								<option value="char">char</option>
								<option value="varchar">varchar</option>
								<option value="text">text</option>
								<option value="int">int</option>
								<option value="bigint">bigint</option>
								<option value="longtext">longtext</option>
								<option value="set">set</option>
								<option value="enum">enum</option>
								<option value="float">float</option>
							</select>
							</td>

							<td><input class="form-control" type="text" name="'.$length.'" id="'.$length.'" /></td>
							<td><input type="checkbox" name="'.$kosong.'" id="'.$kosong.'" value="NULL"/></td>							
							
						</tr>					

						';
					}

			echo'
						<tr>
						<input type="hidden" name="nama_tabel" id="nama_tabel" value="'.$nama_tabel.'" />
						<input type="hidden" name="'.$panjang_kolom.'" id="'.$panjang_kolom.'" value="'.$panjang_kolom.'" />

						<td colspan="5"><input class="btn btn-md btn-primary" type="submit" name="ciptakan_tabel" id="ciptakan_tabel" value="Simpan" /></td>
						</tr>		
			</div>
			</form>
			';
		}

		?>

	</div>
</div>
</body>
</html>
