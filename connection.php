<?php
	$server 	= "localhost";
	$username 	= "root";
	$password 	= "";
	$database 	= "db_piss";

	// Koneksi dan memilih database di server
	mysql_connect($server,$username,$password) or die("Koneksi gagal");
	mysql_select_db($database) or die("Database tidak bisa dibuka");

	function format_rupiah($angka){
		// $rupiah = 'Rp '.number_format($angka,0,',',',');
		$rupiah = number_format($angka,0,',',',');
		return $rupiah;
	}
	
	function executeScalar($sql,$def=0){
		$rs = mysql_query($sql) or die(mysql_error().$sql);
		if (mysql_num_rows($rs)) {
			$r = mysql_fetch_row($rs);
			mysql_free_result($rs);
			return $r[0];
		}
		return $def;
	}
	date_default_timezone_set('Asia/Jakarta');
	$date_now = date("Y-m-d");
?>
