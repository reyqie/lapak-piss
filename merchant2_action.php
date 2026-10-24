<?php
	session_start();
	include "connection.php";
	//include "fungsi_thumb.php";
	
	$date_now	= date("Y-m-d");
	$task		= $_GET['task'];
	//$id		= $_POST['id'];
	
	// Update
	if ($task=='update'){
		$id		= $_GET['id'];
		//tambahin jika status merchant nonaktive
		$lid	= executeScalar("select lapak_id from rent where merchant_id = '".$id."' and rent_sts2 != 'Pindah' limit 1");
		$block	= executeScalar("select block_id from lapak where lapak_id = '".$lid."'");	
		/*if($_POST['sts']=='Tidak Aktif'){
			//update sts transaski sewa lapak
			$update1 = mysql_query("update rent r, lapak l set r.rent_sts2 = 'Batal', l.lapak_status = null 
			where r.lapak_id = l.lapak_id and r.merchant_id = '".$id."'");
			//update sts lapak mnjadi kosong
		}*/
		$update2 = mysql_query("update merchant set merchant_name 		= '".$_POST['name']."',
													merchant_nick 		= '".$_POST['nick']."',
													phone1 				= '".$_POST['tlp1']."',
													phone2 				= '".$_POST['tlp2']."',
													address1 			= '".$_POST['adrs1']."',
													address2 			= '".$_POST['adrs2']."',
													nid_ktp 			= '".$_POST['ktp']."',
													nid_sim 			= '".$_POST['sim']."',
													nid_lain 			= '".$_POST['lain']."',
													nid_type 			= '".$_POST['nid']."',
													merchant_type 		= '".$_POST['type']."',
													active_block 		= '".$block."',
													kat_merchant 		= '".$_POST['kat_merchant']."',
													asal_pasar 			= '".$_POST['asal_pasar']."'
											where 	merchant_id 		= '".$id."'");
		if($update2){
			// Alert Information
			$_SESSION['success'] = true;
			$_SESSION['title'] = 'Berhasil';
			$_SESSION['message'] = "Update data pedagang";
			echo "	<script>
						window.location=('merchant2_edit.php?id=$id')
					</script>";
			exit;
		}
		else{
			echo "<script>window.alert('Update Failled');
			window.history.back()</script>";
			exit;
		}
	}

	elseif ($task == 'deleteRent') {
		$id = $_GET['id'];
		$merchantID = $_GET['merchantID'];
		$update = mysql_query("UPDATE rent SET rent_sts = 'Batal', rent_sts2 = 'Pindah' WHERE rent_id = '".$id."'");
		if ($update) {
			$update2 = mysql_query("UPDATE lapak SET lapak_status = 'Kosong' WHERE lapak_id = (SELECT lapak_id FROM rent WHERE rent_id = '".$id."')");
			// Alert Information
			$_SESSION['success'] = true;
			$_SESSION['title'] = 'Berhasil';
			$_SESSION['message'] = "Lapak berhasil dinonaktifkan dari sewa";
			echo "<script>
					window.location=('merchant2_edit.php?id=$merchantID')
				</script>";
			exit;
		} else {
			echo "<script>window.alert('Update Failled');
			window.history.back()</script>";
			exit;
		}
	}
	
	elseif ($task == 'delete'){
		//$delete = mysql_query("delete employee where employee_id = '".$id."'");
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