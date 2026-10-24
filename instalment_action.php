<?php
	session_start();
	include "connection.php";
	include "fungsi_thumb.php";
	
	$task	= $_GET['task'];
	//$id		= $_POST['id'];
	// Input 
	if ($task == 'insert'){
		$exist 	= executeScalar("select count(instalment_id) from instalment where instalment_name = '".$_POST['ins_val']."' ");
		
		if($exist>0){
			$_SESSION['success'] = false;
			$_SESSION['title'] = 'Gagal';
			$_SESSION['message'] = "Nama Cicilan Sudah Ada, Mohon Dicek Lagi";
			echo "<script>window.history.back()</script>";
			exit();
		}
		// if($_POST['ins']==''||$_POST['ins_val']==''){
		// 	echo "<script>window.alert('Data Belum Lengkap, Mohon Dicek Lagi');
		// 	window.history.back()</script>";
		// 	exit();
		// }
		else{
			$insert = mysql_query("INSERT INTO `instalment` (`instalment_id`, `instalment_name`, `instalment_count`) 
			VALUES ('', '".$_POST['ins']."', '".$_POST['ins_val']."')");
			
			if($insert){
				// Alert Information
				$_SESSION['success'] = true;
				$_SESSION['title'] = 'Berhasil';
				$_SESSION['message'] = "Menambahkan data waktu angsuran baru";
				echo "<script>window.location=('instalment.php')</script>";
				exit();
			}
			else{
				// Alert Information
				$_SESSION['success'] = false;
				$_SESSION['title'] = 'Gagal';
				$_SESSION['message'] = "Menambahkan data waktu angsuran baru";
				echo "<script>window.history.back()</script>";
				exit();
			}
		}
	}

	// Update
	elseif ($task == 'update'){
		$id		= $_GET['id'];
		$update	= mysql_query("update instalment set instalment_name	= '".$_POST['ins']."',
													instalment_count 	= '".$_POST['ins_val']."'
												where instalment_id 	= '".$id."'");
		if($update){
			// Alert Information
			$_SESSION['success'] = true;
			$_SESSION['title'] = 'Berhasil';
			$_SESSION['message'] = "Update data waktu angsuran";
			echo "<script>window.location=('instalment.php')</script>";
			exit();
		}
		else{
			// Alert Information
			$_SESSION['success'] = false;
			$_SESSION['title'] = 'Gagal';
			$_SESSION['message'] = "Update data waktu angsuran";
			echo "<script>window.history.back()</script>";
			exit();
		}
	}
	
	elseif ($task == 'delete'){
		$id		= $_GET['id'];
		$delete = mysql_query("delete from instalment where instalment_id = '".$id."'");
		if($delete){
			// Alert Information
			$_SESSION['success'] = true;
			$_SESSION['title'] = 'Berhasil';
			$_SESSION['message'] = "Hapus data waktu angsuran";
			echo "<script>window.location=('instalment.php')</script>";
			exit();
		}
		else{
			// Alert Information
			$_SESSION['success'] = false;
			$_SESSION['title'] = 'Gagal';
			$_SESSION['message'] = "Hapus data waktu angsuran";
			echo "<script>window.location=('instalment.php')</script>";
			exit();
		}
	}
?>