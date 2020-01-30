<?php
require_once('koneksi.php');
$list=$koneksi->query("SHOW DATABASES");
while($db=$list->fetch_object()){
	echo "<br/>".$db->Database;
}
?>
