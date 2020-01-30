<?php
define("DB_HOST", "localhost");
define("DB_USER","root");
define("DB_PASS","");

$koneksi= new mysqli(DB_HOST, DB_USER, DB_PASS);
if($koneksi==false):
	die("Gagal melakukan koneksi".$koneksi->connect_error());
endif;

?>
