<?php
	session_start();
	include "connection.php";
	include "fungsi_thumb.php";
	
	$task	= $_GET['task'];
	//$id		= $_POST['id'];
	
	// Input 
	if ($task == 'insert'){
		$date_now 	= date("Y-m-d");
		
		$insert = mysql_query("INSERT INTO `pios`.`bayar` (`id_bayar`, `id_pedagang`, `lapak_id`, `jumlah`, `tanggal`, `ket_bayar`) 
		VALUES ('', '".$_POST['pedagang']."', '".$_POST['lapak']."', '".$_POST['bayar']."', '".$date_now."', '".$_POST['ket']."')");
		
		if($insert){
			echo "<script>window.alert('Insert Success');
			window.location=('maintenance.php')</script>";
		}
		else{
			echo "<script>window.alert('Insert Failled');
			window.location=('maintenance.php')</script>";
		}
	}

	// Update
	elseif ($task == 'update'){
		if(isset($_FILES['fupload'])){
			$id			= $_GET['id'];
			$check		= mysql_query("select photo from employee where employee_id = ".$id." ");                
			while($data = mysql_fetch_array($check)){
				
				$lokasi_file    = $_FILES['fupload']['tmp_name'];
				$tipe_file      = $_FILES['fupload']['type'];
				$nama_file      = $_FILES['fupload']['name'];
				$acak           = rand(1,999);
				$nama_file_unik = $acak.$nama_file; 
				
				if (!empty($lokasi_file)){
					$delete	= $data['photo'];
					unlink("employee/".$delete."");
					unlink("employee/small_".$delete."");
					employeeImage($nama_file_unik);
					$update	= mysql_query("update employee set employee_name= '".$_POST['name']."',
															job_title 		= '".$_POST['job']."',
															education 		= '".$_POST['edu']."',
															photo			= '".$nama_file_unik."'
														where employee_id 	= '".$id."'");
					if($update){
						echo "<script>window.alert('".$task." Pict Success');
						window.location=('employee.php')</script>";
						exit;
					}
					else{
						echo "<script>window.alert('".$task." pict ".$id." Fail');
						window.location=('employee.php')</script>";
						exit;
					}
				}
				else{
					$update2 = mysql_query("update employee set employee_name= '".$_POST['name']."',
															job_title 		= '".$_POST['job']."',
															education 		= '".$_POST['edu']."',
														where employee_id 	= '".$id."'");
					if($update2){
						//Writes the photo to the server 
						echo "<script>window.alert('".$task." Success Without pict');
						window.location=('employee.php')</script>";
					}
					else{
						echo "<script>window.alert('".$task." Failled Without pict');
						window.location=('employee.php')</script>";
					}
				}
			}
		}
		elseif(isset($_POST['fupload'])){
			echo "<script>window.alert('".$task." Failled Without pict');
				window.location=('employee.php')</script>";	
		}
	}
	
	elseif ($task == 'delete'){
		$delete = mysql_query("delete employee where employee_id = '".$id."'");
		if($delete){
			//Writes the photo to the server 
			echo "<script>window.alert('Delete Success');
			window.location=('employee.php')</script>";
		}
		else{
			echo "<script>window.alert('Delete Failled');
			window.location=('employee.php')</script>";
		}
	}
?>