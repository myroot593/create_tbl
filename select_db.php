<?php
require_once('koneksi.php');

$select_db=$koneksi->select_db("latihan1");
if(!$select_db){
	echo "Gagal memilih database";
}
?>
