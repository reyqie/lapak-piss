<?php
	session_start();
	include "connection.php";
	//include "fungsi_thumb.php";
	
	$date_now	= date("Y-m-d");
	$task		= $_GET['task'];
	//$id		= $_POST['id'];
	
	// Input 
	if ($task == 'insert'){
		$ktp 	= executeScalar("select nid_ktp from merchant where nid_ktp = '".$_POST['ktp']."'");
		$sim 	= executeScalar("select nid_sim from merchant where nid_sim = '".$_POST['ktp']."'");
		$lain 	= executeScalar("select nid_lain from merchant where nid_lain = '".$_POST['lain']."'");
		//Jika ktp tidak ada yg sama
		if($ktp>0||$sim>0||$lain>0){
			echo "<script>window.alert('No ID Pedagang sudah ada, mohon dicek lagi');
			window.history.back()</script>";
			exit();
		}
		else{
			//jika adrs2 kosong
			if($_POST['adrs2']==''){
				$adrs2 = $_POST['adrs1'];
			}
			else{
				$adrs2 = $_POST['adrs2'];
			}
			$insert = mysql_query("INSERT INTO `pios`.`merchant` (`merchant_id`, `merchant_name`, `merchant_nick`, 
			`merchant_phone1`, `merchant_phone2`, `address1`, `address2`, `nid_ktp`, `nid_sim`, `nid_lain`, 
			`nid_type`, `merchant_type`, `merchant_status`) 
			VALUES ('', '".$_POST['name1']."', '".$_POST['name2']."', '".$_POST['tlp1']."', '".$_POST['tlp2']."',
			'".$_POST['adrs1']."', '".$adrs2."', '".$_POST['ktp']."', '".$_POST['sim']."', '".$_POST['lain']."', 
			'".$_POST['nid']."', '".$_POST['type']."', 'Baru')");
			//$merchant = mysql_insert_id();
			if($insert){
				// mendapatkan nomor orders
				$merchant 	= mysql_insert_id();
				$total 		= executeScalar("select lapak_total from lapak where lapak_id = '".$_POST['lapak']."'");
				$leftover 	= 0;
				$instament 	= 0;
				$leftover 	= $total-$_POST['dp'];
				$instalment = $leftover/24;
				$insert2 	= mysql_query("INSERT INTO `pios`.`rent` (`rent_id`, `merchant_id`, `lapak_id`, 
				`rent_total`, `rent_dp`, `leftover`, `rent_instalment`, `rent_date`, `rent_desc`) 
				VALUES ('', '".$merchant."', '".$_POST['lapak']."', '".$total."', '".$_POST['dp']."',
				'".$leftover."', '".$instalment."', '".$date_now."', '".$_POST['ket']."')");
				if($insert2){
					$update	= mysql_query("update lapak set lapak_status = 'Terisi' where lapak_id = '".$_POST['lapak']."'");
					if($update){
						echo "<script>window.location=('merchant.php')</script>";
						exit();
					}
					else{
						echo "<script>window.alert('Update Data Gagal');
						window.history.back()</script>";
						exit();
					}
				}
				else{
					echo "<script>window.alert('Data Gagal Masuk 2');
					window.history.back()</script>";
					exit();
				}
			}
			else{
				echo "<script>window.alert('Data Gagal Masuk');
				window.history.back()</script>";
				exit();
			}
		}
	}

	// Update
	elseif ($task=='update'){
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
						window.location=('merchant_edit.php?id=$id')
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
					window.location=('merchant_edit.php?id=$merchantID')
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