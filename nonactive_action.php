<?php
	session_start();
	include "connection.php";
	date_default_timezone_set('Asia/Jakarta');
	$dt_now	= date("Y-m-d H:i:s");
	$task	= $_GET['task'];
	$reason	= $_POST['reason'];
	
	if($task=='active'){
		//Ambil ID Pedagang
		$mid	= $_GET['id'];
		
		//Update Status Pedagang
		$update = mysql_query("update merchant set merchant_status = 'Aktif' where merchant_id = '".$mid."'");
		if($update){
			$spv	= $_SESSION['username'];
			$spvName = executeScalar("select name from admin where username = '".$spv."'");
			$insert = mysql_query("insert into nonactive_log (nonactive_id, spv_name, merchant_id, lapak_id, nonactive_reason, nonactive_date) 
			value('', '".$spvName."', '".$mid."', '', '".$reason."', '".$dt_now."')");
			if($insert){
				// Alert Information
				$_SESSION['success'] = true;
				$_SESSION['title'] = 'Berhasil';
				$_SESSION['message'] = "Aktifkan Pedagang";
				echo "<script>window.location=('nonactive_merchant.php')</script>";
				exit();
			}else{
				// Alert Information
				$_SESSION['success'] = false;
				$_SESSION['title'] = 'Gagal';
				$_SESSION['message'] = "Aktifkan Pedagang";
				echo "<script>window.history.back()</script>";
				exit();
			}
		}else{
			// Alert Information
			$_SESSION['success'] = false;
			$_SESSION['title'] = 'Gagal';
			$_SESSION['message'] = "Aktifkan Pedagang";
			echo "<script>window.history.back()</script>";
			exit();
		}
	}
	
	if($task=='nonactive'){
		//Ambil ID Pedagang
		$mid	= $_GET['id'];
		
		//Update Status Pedagang
		$update = mysql_query("update merchant set merchant_status = 'Tidak Aktif' where merchant_id = '".$mid."'");
		if($update){
			$spv	= $_SESSION['username'];
			$spvName = executeScalar("select name from admin where username = '".$spv."'");
			
			$update2 = mysql_query("update rent set rent_sts = 'Batal', rent_sts2 = 'Batal' where merchant_id = '".$mid."'");
			$update3 = mysql_query("update lapak set lapak_status = 'Kosong' where lapak_id in (select r.lapak_id from rent r where r.merchant_id = '".$mid."')");

			$insert = mysql_query("insert into nonactive_log (nonactive_id, spv_name, merchant_id, lapak_id, nonactive_reason, nonactive_date) 
			value('', '".$spvName."', '".$mid."', '-', '".$reason."', '".$dt_now."')");
			if($insert){
				// Alert Information
				$_SESSION['success'] = true;
				$_SESSION['title'] = 'Berhasil';
				$_SESSION['message'] = "NonAktifkan Pedagang";
				echo "<script>window.location=('nonactive_merchant.php')</script>";
				exit();
			}else{
				// Alert Information
				$_SESSION['success'] = false;
				$_SESSION['title'] = 'Gagal';
				$_SESSION['message'] = "NonAktifkan Pedagang";
				echo "<script>window.history.back()</script>";
				exit();
			}
		}else{
			// Alert Information
			$_SESSION['success'] = false;
			$_SESSION['title'] = 'Gagal';
			$_SESSION['message'] = "NonAktifkan Pedagang";
			echo "<script>window.history.back()</script>";
			exit();
		}
	}
?>