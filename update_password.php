<?php
	session_start();
	include "connection.php";
	include "components/role_session.php";
	
	$user	= $_GET['user'];
	$pass	= $_POST['pass'];
	$pass1	= $_POST['pass1'];
	$pass2	= $_POST['pass2'];
	$check	= mysql_query("select password from admin where username = '".$user."'");
	$passDB = mysql_fetch_row($check);
	if($pass==$passDB[0]){
		if($pass1==$pass2){
		// Update pass
			$update = mysql_query("update admin set password = '".$pass2."' where username = '".$user."'");
			if($update) {
				echo "<script>window.alert('Ganti Password Berhasil');
				window.location=('logout.php')</script>";
				exit();
			}else {
				echo "<script>window.alert('Ganti Password Gagal');
				window.history.back()</script>";
				exit();
			}
		}
		else{
			echo "<script>window.alert('Password Baru Anda Tidak Sama');
			window.history.back()</script>";
			exit();
		}
	}else{
		echo "<script>window.alert('Password Lama Anda Salah');
		window.history.back()</script>";
		exit();
	}
?>
