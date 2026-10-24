<?php
	session_start();
	include "connection.php";
	include "fungsi_thumb.php";
	
	$task	= $_GET['task'];
	//$id	= $_POST['id'];
	
	// Input 
	if ($task == 'insert'){
		$exist 	= executeScalar("select count(block_id) from block where block_id = '".$_POST['block']."' ");
		
		if($exist>0||$_POST['block']==''){
			$_SESSION['success'] = false;
			$_SESSION['title'] = 'Gagal';
			$_SESSION['message'] = "Nama Block Sudah Ada, Mohon Dicek Lagi";
			echo "<script>window.history.back()</script>";
			exit();
		}
		else{
			$insert = mysql_query("INSERT INTO `block` (`block_id`, `block_max`, `block_type`) 
			VALUES ('".$_POST['block']."', '".$_POST['max']."', '".$_POST['type']."')");
			
			if($insert){
				// Alert Information
				$_SESSION['success'] = true;
				$_SESSION['title'] = 'Berhasil';
				$_SESSION['message'] = "Menambahkan data blok baru";
				echo "<script>window.location=('block.php')</script>";
				exit();
			}
			else{
				// Alert Information
				$_SESSION['success'] = false;
				$_SESSION['title'] = 'Gagal';
				$_SESSION['message'] = "Menambahkan data blok baru";
				echo "<script>window.history.back()</script>";
				exit();
			}
		}
	}

	// Update
	elseif ($task=='update'){
		$id		= $_GET['id'];
		$update	= mysql_query("update block set block_max	= '".$_POST['max']."',
											block_type 		= '".$_POST['type']."'
											where block_id 	= '".$id."'");
		if($update){
			// Alert Information
			$_SESSION['success'] = true;
			$_SESSION['title'] = 'Berhasil';
			$_SESSION['message'] = "Update data blok";
			echo "<script>window.location=('block.php')</script>";
			exit();
		}
		else{
			// Alert Information
			$_SESSION['success'] = fasle;
			$_SESSION['title'] = 'Gagal';
			$_SESSION['message'] = "Update data blok";
			echo "<script>window.history.back()</script>";
			exit();
		}
	}
	
	elseif ($task=='delete'){
		$id		= $_GET['id'];
		$delete = mysql_query("delete from block where block_id = '".$id."'");
		$delete2 = mysql_query("delete from lapak where block_id = '".$id."'");
		if($delete && $delete2){
			// Alert Information
			$_SESSION['success'] = true;
			$_SESSION['title'] = 'Berhasil';
			$_SESSION['message'] = "Hapus data blok";
			echo "<script>window.location=('block.php')</script>";
			exit();
		}
		else{
			// Alert Information
			$_SESSION['success'] = false;
			$_SESSION['title'] = 'Gagal';
			$_SESSION['message'] = "Hapus data blok";
			echo "<script>window.location=('block.php')</script>";
			exit();
		}
	}
?>