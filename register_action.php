<?php
	session_start();
	include "connection.php";
	//include "fungsi_thumb.php";
	//Validasi role
	// if($_SESSION['role']!='admin'){
	// 	if($_SESSION['role']!='super_admin'){
	// 		header("Location:index.php");
	// 	}
	// }
	$task		= $_GET['task'];
	//$id		= $_POST['id'];
	
	//Pendaftaran Padagang baru (Permohonan Lapak)
	if ($task == 'insert'){
		$type 	= executeScalar("select lapak_type from lapak where lapak_id = '".$_POST['lapak']."'");
		//Jika ktp tidak ada yg sama
		if($_POST['ktp']!=''){
			$ktp 	= executeScalar("select count(nid_ktp) from request where nid_ktp = '".$_POST['ktp']."'");
			if($ktp>0){
				echo "<script>window.alert('No ID Pedagang sudah ada, mohon dicek lagi');
				window.history.back()</script>";
				exit();
			}
			$ktp 	= $_POST['ktp'];
			$sim 	= null;
			$lain 	= null;
			$nid	= $_POST['nid'];
		}
		elseif($_POST['sim']!=''){
			$sim 	= executeScalar("select count(nid_sim)from request where nid_sim = '".$_POST['sim']."'");
			if($sim>0){
				echo "<script>window.alert('No ID Pedagang sudah ada, mohon dicek lagi');
				window.history.back()</script>";
				exit();
			}
			$sim	= $_POST['sim'];
			$ktp 	= null;
			$lain 	= null;
			$nid	= $_POST['nid'];
		}
		elseif($_POST['lain']!=''){
			$lain 	= executeScalar("select count(nid_lain) from request where nid_lain = '".$_POST['lain']."'");
			if($lain>0){
				echo "<script>window.alert('No ID Pedagang sudah ada, mohon dicek lagi');
				window.history.back()</script>";
				exit();
			}
			$lain 	= $_POST['lain'];
			$ktp 	= null;
			$sim 	= null;
			$nid	= $_POST['nid'];
		}
		else{
			$ktp 	= null;
			$sim 	= null;
			$lain 	= null;
			$nid 	= null;
		}

		// Pengecekan apakah sudah melakukan pengisian kategori merchant
		if($_POST['kat_merchant']=='0'){
			echo "<script>window.alert('Silahkan pilih jenis pedagang dahulu !');
				window.history.back()</script>";
			exit();
		}

		// Pengecekan apakah sudah melakukan pengisian asal pasar
		if($_POST['asal_pasar']=='0'){
			echo "<script>window.alert('Silahkan pilih asal pasar dahulu !');
				window.history.back()</script>";
			exit();
		}

		//jika adrs2 kosong
		if($_POST['adrs2']==''){
			$adrs2 = $_POST['adrs1'];
		}
		else{
			$adrs2 = $_POST['adrs2'];
		}
		
		$insert = mysql_query("	INSERT INTO request (`req_id`, 
													`lapak_id`, 
													`req_name`, 
													`req_nick`, 
													`phone1`, 
													`phone2`, 
													`address1`, 
													`address2`, 
													`nid_ktp`, 
													`nid_sim`, 
													`nid_lain`, 
													`nid_type`, 
													`merchant_type`, 
													`req_date`, 
													`req_status`,
													`kat_merchant`, 
													`asal_pasar`) 
								VALUES ('', 
										'".$_POST['lapak']."', 
										'".$_POST['name1']."', 
										'".$_POST['name2']."', 
										'".$_POST['tlp1']."', 
										'".$_POST['tlp2']."', 
										'".$_POST['adrs1']."', 
										'".$adrs2."', 
										'".$ktp."', 
										'".$sim."', 
										'".$lain."', 
										'".$nid."', 
										'".$type."', 
										'".$date_now."', 
										'Pending',
										'".$_POST['kat_merchant']."', 
										'".$_POST['asal_pasar']."')");
				//$request 	= mysql_insert_id();
		
		if($insert){
			// Alert Information
			$_SESSION['success'] = true;
			$_SESSION['title'] = 'Berhasil';
			$_SESSION['message'] = "Menambah pendaftar pedagang baru";
			echo "<script>window.location=('register.php')</script>";
			exit();
		}
		else{
			// Alert Information
			$_SESSION['success'] = false;
			$_SESSION['title'] = 'Gagal';
			$_SESSION['message'] = "Menambah pendaftar pedagang baru";
			echo "<script>window.history.back()</script>";
			exit();
		}
	}
	
	//Pendaftaran Padagang Lama (Permohonan Lapak)
	if ($task == 'insert2'){
		//ambil data merchant
		$id		= $_POST['merchant'];
		
		if($_POST['merchant']==''){
			echo "<script>window.alert('Pedagang Belum Dipilih');
			window.history.back()</script>";
			exit();
		}
		$type 	= executeScalar("select lapak_type from lapak where lapak_id = '".$_POST['lapak']."'");
		//Cek apakah type lapak dgn type pemohon sama
		$mtype 	= executeScalar("select merchant_type from merchant where merchant_id = '".$id."'");
			if($type!=$mtype){
			echo "<script>window.alert('Tipe Lapak Dengan Tipe Pedagang Tidak Sama');
			window.history.back()</script>";
			exit();
		}
		
		$sql	= mysql_query("select * from merchant where merchant_id = '".$id."'");
		while($r = mysql_fetch_array($sql)){
		//Input data pedagang ke tabel pemohon
			$insert = mysql_query("	INSERT INTO request (`req_id`, 
														`lapak_id`, 
														`req_name`, 
														`req_nick`, 
														`phone1`, 
														`phone2`, 
														`address1`, 
														`address2`, 
														`nid_ktp`, 
														`nid_sim`, 
														`nid_lain`, 
														`nid_type`, 
														`merchant_type`, 
														`req_date`, 
														`req_status`, 
														`req_reffer`) 
									VALUES ('', 
											'".$_POST['lapak']."', 
											'".$r['merchant_name']."', 
											'".$r['merchant_nick']."', 
											'".$r['phone1']."', 
											'".$r['phone2']."', 
											'".$r['address1']."', 
											'".$r['address2']."', 
											'".$r['nid_ktp']."', 
											'".$r['nid_sim']."', 
											'".$r['nid_lain']."', 
											'".$r['nid_type']."', 
											'".$r['merchant_type']."', 
											'".$date_now."', 
											'Pending', 
											'".$id."')");
			
			//Ambil ID Pemohon
			$rid 	= mysql_insert_id();
			// var_dump($insert);
			if($insert){
				//echo "<script>window.location=('register_edit.php?id=".$rid."')</script>";
				$_SESSION['success'] = true;
				$_SESSION['title'] = 'Berhasil';
				$_SESSION['message'] = "Menambah permohonan lapak";
				echo "<script>window.location=('register2.php?id=$rid')</script>";
				exit();
			}
			else{
				$_SESSION['success'] = false;
				$_SESSION['title'] = 'Gagal';
				$_SESSION['message'] = "Menambah permohonan lapak";
				echo "<script>window.history.back()</script>";
				exit();
			}
		}
	}
	
	// Update
	elseif ($task == 'update'){
		$id	= $_GET['id'];
		if($_POST['adrs2']==''){
			$adrs2 = $_POST['adrs1'];
		}
		else{
			$adrs2 = $_POST['adrs2'];
		}
		$update	= mysql_query("update request set lapak_id	= '".$_POST['lapak']."',
												req_name 	= '".$_POST['name1']."',
												req_nick 	= '".$_POST['name2']."',
												phone1 		= '".$_POST['tlp1']."',
												phone2 		= '".$_POST['tlp2']."',
												address1 	= '".$_POST['adrs1']."',
												address2 	= '".$_POST['adrs2']."',
												nid_ktp 	= '".$_POST['ktp']."',
												nid_sim 	= '".$_POST['sim']."',
												nid_lain 	= '".$_POST['lain']."',
												nid_type 	= '".$_POST['nid']."',
											merchant_type 	= '".$_POST['type']."'
											where req_id 	= '".$id."'");
		if($update){
			$reffer = executeScalar("select req_reffer from request where req_id = '".$id."'");
			if($reffer!=''){
				// Alert Information
				$_SESSION['success'] = true;
				$_SESSION['title'] = 'Berhasil';
				$_SESSION['message'] = "Update data";
				echo "<script>window.location=('register_edit2.php?id=$id')</script>";
				exit;
			}else{
				// Alert Information
				$_SESSION['success'] = true;
				$_SESSION['title'] = 'Berhasil';
				$_SESSION['message'] = "Update data";
				echo "<script>window.location=('register_edit.php?id=$id')</script>";
				exit;
			}
			
		}
		else{
			// Alert Information
			$_SESSION['success'] = false;
			$_SESSION['title'] = 'Gagal';
			$_SESSION['message'] = "Update data";
			echo "<script>window.history.back()</script>";
			exit;
		}
	}
	
	elseif($task == 'ok'){
		$id 	= $_GET['id'];
		//Ubah status pemohon
		//$update	= mysql_query("update request set req_status = 'Direview' where req_id = '$id'");
		
		if($update){
			//pergi ke halaman persetujuan Permohonan
			echo "<script>window.location=('register_acc.php?id=$id')</script>";
			exit();
		}
		else{
			echo "<script>window.alert('Data Gagal Masuk');
			window.history.back()</script>";
			exit();
		}
	}
	
	elseif($task == 'acc'){
		// ambil id pemohon
		$id		= $_GET['id'];
		//Jika DP > total
		$lid 	= executeScalar("select lapak_id from request where req_id = '".$id."'");
		$total 	= executeScalar("select lapak_total from lapak where lapak_id = '".$lid."'");
		//verifikasi data
		if($_POST['dp']==''||$_POST['ins']==''||$_POST['interest']==''||$_POST['datein']==''){
			echo "<script>window.alert('Data Belum Lengkap, Coba Cek Lagi');
			window.history.back()</script>";
			exit();
		}
		//Jika DP lebih besar dari total bayar
		/*if($_POST['dp']>$total||$_POST['dp']==0){
			echo "<script>window.alert('Uang Muka Salah Input, Coba Cek Lagi');
			window.history.back()</script>";
			exit();
		}*/
		//Cek status lapak yg diinginkan
		$sts 	= executeScalar("select lapak_status from lapak where lapak_id = '".$lid."'");
		$block 	= executeScalar("select block_id from lapak where lapak_id = '".$lid."'");
		$type 	= executeScalar("select lapak_type from lapak where lapak_id = '".$lid."'");
		$type2 	= executeScalar("select merchant_type from request where req_id = '".$id."'");
		//Cek apakah type lapak dgn type pemohon sama
		if($type!=$type2){
			echo "<script>window.alert('Tipe Lapak Tidak Sama Dengan Tipe Pedagang');
			window.history.back()</script>";
			exit();
		}
		if($sts!='Terisi'){
			$read	= mysql_query("select * from request where req_id = '".$id."'");
			while($r= mysql_fetch_array($read)){
				//Generate ID Pedagang
				if($type=='Sayur'){
					$code 	= 'S';
					$count 	= executeScalar("select code_total from code where code_id = 'S'");
					$count	= $count+1;
				}
				elseif($type=='Buah'){
					$code 	= 'B';
					$count 	= executeScalar("select code_total from code where code_id = 'B'");
					$count	= $count+1;
				}
				else{
					$code 	= 'L';
					$count 	= executeScalar("select code_total from code where code_id = 'L'");
					$count	= $count+1;
				}
				$tot 	= sprintf("%04d", $count);
				$mid	= $code.$tot;
				//Insert data ke table pedagang
				$insert1 = mysql_query	("	INSERT INTO merchant (	`merchant_id`, 
																	`merchant_name`, 
																	`merchant_nick`, 
																	`phone1`, 
																	`phone2`, 
																	`address1`, 
																	`address2`, 
																	`nid_ktp`, 
																	`nid_sim`, 
																	`nid_lain`, 
																	`nid_type`, 
																	`merchant_type`, 
																	`merchant_status`, 
																	`active_block`,
																	`kat_merchant`, 
																	`asal_pasar`) 
											VALUES (	'".$mid."', 
														'".$r['req_name']."', 
														'".$r['req_nick']."', 
														'".$r['phone1']."', 
														'".$r['phone2']."', 
														'".$r['address1']."', 
														'".$r['address2']."', 
														'".$r['nid_ktp']."', 
														'".$r['nid_sim']."', 
														'".$r['nid_lain']."', 
														'".$r['nid_type']."', 
														'".$r['merchant_type']."', 
														'Aktif', 
														'".$block."',
														'".$r['kat_merchant']."', 
														'".$r['asal_pasar']."')
										");
				
				//Ambil id merchant yg barusan masuk
				//$mid 	= mysql_insert_id();
				if($insert1){
					$date_in 	= $_POST['datein'];
					//update table code
					$update	= mysql_query("update code set code_total = '".$count."' where code_id = '".$code."'");
					if($update){
						//baca data lapak yg dipilih oleh pedagang
						$cicilan 	= executeScalar("select instalment_count from instalment where instalment_id = '".$_POST['ins']."'");
						$dur 		= executeScalar("select duration from lapak where lapak_id = '".$lid."'");
						
						//kekurangan biaya rent
						$leftover 	= 0;
						$leftover2 	= 0;
						$instalment	= 0;
						
						//Rumus menghitung biaya Lapak
						if($total<=$_POST['dp']){
							$leftover 	= 0;
							$leftover2	= 0;
							$instalment	= 0;
							
							//generate tgl keluar
							$dur		= $dur.' year';
							$exp 		= strtotime($dur, strtotime($date_in));
							$expired 	= date('Y-m-j' , $exp);
							$status		= 'Lunas';
							
							//Insert data transaksi ke table rent
							$insert2 	= mysql_query("	INSERT INTO rent (	`rent_id`, 
																			`req_id`, 
																			`merchant_id`, 
																			`lapak_id`, 
																			`instalment_id`, 
																			`rent_total`, 
																			`rent_dp`, 
																			`interest`, 
																			`leftover`, 
																			`leftover2`, 
																			`rent_instalment`, 
																			`rent_date`, 
																			`rent_expired`, 
																			`rent_desc`, 
																			`rent_sts`, 
																			`rent_sts2`) 
														VALUES (	'', 
																	'".$id."', 
																	'".$mid."', 
																	'".$lid."', 
																	'".$_POST['ins']."', 
																	'".$total."', 
																	'".$_POST['dp']."', 
																	'".$_POST['interest']."', 
																	'".$leftover."',
																	'".$leftover2."', 
																	'".$instalment."', 
																	'".$date_in."', 
																	'".$expired."', 
																	'".$_POST['ket']."', 
																	'".$status."', 
																	'Normal')");
						}
						else{
							//sisa bayar = total biaya - dp
							$leftover 	= $total - $_POST['dp'];
							//Bunga pertahun = jml cicilan / jml tahun * bunga
							$year_interest = $cicilan/12*$_POST['interest']/100;
							$leftover2	= $leftover + ($leftover * $year_interest);
							$instalment	= $leftover2/$cicilan;
							
							//generate tgl Jatuh Tempo
							$date_plus 	= strtotime('1 month', strtotime($date_in));
							$dateline 	= date('Y-m-j' , $date_plus);
							
							//generate tgl keluar
							$dur		= $dur.' year';
							$exp 		= strtotime($dur, strtotime($date_in));
							$expired 	= date('Y-m-j' , $exp);
							$status		= 'Belum Lunas';
							
							//Insert data transaksi ke table rent
							$insert2 	= mysql_query("INSERT INTO rent (`rent_id`, `req_id`, `merchant_id`, 
							`lapak_id`, `instalment_id`, `rent_total`, `rent_dp`, `interest`, `leftover`, 
							`leftover2`, `rent_instalment`, `rent_date`, `rent_dl`, `rent_expired`, `rent_desc`, 
							`rent_sts`, `rent_sts2`) 
							VALUES ('', '".$id."', '".$mid."', '".$lid."', '".$_POST['ins']."', '".$total."', 
							'".$_POST['dp']."', '".$_POST['interest']."', '".$leftover."','".$leftover2."', 
							'".$instalment."', '".$date_in."', '".$dateline."', '".$dateline."', '".$_POST['ket']."', 
							'".$status."', 'Normal')");
						}
						
						$rid 	= mysql_insert_id();
						if($insert2){
							//Ubah status lapak
							$update1	= mysql_query("update lapak set lapak_status = 'Terisi' where lapak_id = '".$lid."'");
							//hapus data pemohon yg sudah d acc
							//mysql_query("delete request where request_id = '".$id."'");
							
							if($update1){
								//Ubah status Pemohon
								$update2	= mysql_query("update request set req_status = 'Disetujui' where req_id = '".$id."'");
								
								if($update2){
									//pergi ke halaman cetak form perizinan
									//echo "<script>window.location=('htmltopdf/persetujuan_pedagang.php?id=$rid')</script>";
									// Alert Information
									$_SESSION['success'] = true;
									$_SESSION['title'] = 'Berhasil';
									$_SESSION['message'] = "Setujui permohonan lapak";
									echo "<script>window.location=('register.php')</script>";
									exit();
								}
								else{
									// Alert Information
									$_SESSION['success'] = false;
									$_SESSION['title'] = 'Gagal';
									$_SESSION['message'] = "Setujui permohonan lapak 1";
									echo "<script>window.history.back()</script>";
									exit();
								}
							}
							else{
								// Alert Information
								$_SESSION['success'] = false;
								$_SESSION['title'] = 'Gagal';
								$_SESSION['message'] = "Setujui permohonan lapak 2";
								echo "<script>window.history.back()</script>";
								exit();
							}
						}
						else{
							// Alert Information
							$_SESSION['success'] = false;
							$_SESSION['title'] = 'Gagal';
							$_SESSION['message'] = "Setujui permohonan lapak 3";
							echo "<script>window.history.back()</script>";
							exit();
						}
					}
				}
				else{
					$delete = mysql_query("delete merchant where merchant_id = '".$mid."'");
					echo "<script>window.alert('Data Gagal Masuk 3 $mid');
					window.history.back()</script>";
					exit();
				}
			}
		}
		else{
			echo "<script>window.alert('Lapak Sudah Terisi, Coba Cek Sekali Lagi');
			window.history.back()</script>";
			exit();
		}
	}
	
	elseif($task == 'acc2'){
		//Ambil id pemohon
		$id		= $_GET['id'];
		$date_in 	= $_POST['datein'];
		//Jika DP > total
		$lid 	= executeScalar("select lapak_id from request where req_id = '".$id."'");
		$total 	= executeScalar("select lapak_total from lapak where lapak_id = '".$lid."'");
		//verifikasi data
		if($_POST['dp']==''||$_POST['ins']==''||$_POST['interest']==''||$_POST['datein']==''){
			echo "<script>window.alert('Data Belum Lengkap, Coba Cek Lagi');
			window.history.back()</script>";
			exit();
		}
		//Jika DP lebih besar dari total bayar
		/*if($_POST['dp']>$total||$_POST['dp']==''||$_POST['dp']==0){
			echo "<script>window.alert('Uang Muka Salah Input, Coba Cek Lagi');
			window.history.back()</script>";
			exit();
		}*/
		//Cek status lapak yg diinginkan
		$sts 	= executeScalar("select lapak_status from lapak where lapak_id = '".$lid."'");
		$type 	= executeScalar("select lapak_type from lapak where lapak_id = '".$lid."'");
		$type2 	= executeScalar("select merchant_type from request where req_id = '".$id."'");
		//Cek apakah type lapak dgn type pemohon sama
		if($type!=$type2){
			echo "<script>window.alert('Tipe Lapak Tidak Sama Dengan Tipe Pedagang');
			window.history.back()</script>";
			exit();
		}
		if($sts!='Terisi'){
			$read	= mysql_query("select * from request where req_id = '".$id."'");
			while($r= mysql_fetch_array($read)){
				//baca data lapak yg dipilih oleh pedagang
				$cicilan 	= executeScalar("select instalment_count from instalment where instalment_id = '".$_POST['ins']."'");
				$dur 		= executeScalar("select duration from lapak where lapak_id = '".$lid."'");
				
				//kekurangan biaya rent
				$leftover 	= 0;
				$leftover2 	= 0;
				$instalment	= 0;
				
				//Rumus menghitung biaya Lapak
				if($total<=$_POST['dp']){
					$leftover 	= 0;
					$leftover2	= 0;
					$instalment	= 0;
					
					//generate tgl keluar
					$dur		= $dur.' year';
					$exp 		= strtotime($dur, strtotime($date_in));
					$expired 	= date('Y-m-j' , $exp);
					$status		= 'Lunas';
					
					//Insert data transaksi ke table rent
					$insert2 	= mysql_query("INSERT INTO rent (`rent_id`, `req_id`, `merchant_id`, 
					`lapak_id`, `instalment_id`, `rent_total`, `rent_dp`, `interest`, `leftover`, 
					`leftover2`, `rent_instalment`, `rent_date`, `rent_expired`, `rent_desc`, 
					`rent_sts`, `rent_sts2`) 
					VALUES ('', '".$id."', '".$r['req_reffer']."', '".$lid."', '".$_POST['ins']."', '".$total."', 
					'".$_POST['dp']."', '".$_POST['interest']."', '".$leftover."','".$leftover2."', 
					'".$instalment."', '".$date_in."', '".$expired."', '".$_POST['ket']."', 
					'".$status."', 'Normal')");
				}
				else{
					//sisa bayar = total biaya - dp
					$leftover 	= $total - $_POST['dp'];
					//Bunga pertahun = jml cicilan / jml tahun * bunga
					$year_interest = $cicilan/12*$_POST['interest']/100;
					$leftover2	= $leftover + ($leftover * $year_interest);
					$instalment	= $leftover2/$cicilan;
					
					//generate tgl Jatuh Tempo
					$date_in 	= $_POST['datein'];
					$date_plus 	= strtotime('1 month', strtotime($date_in));
					$dateline 	= date('Y-m-j' , $date_plus);
					
					//generate tgl keluar
					$dur		= $dur.' year';
					$exp 		= strtotime($dur, strtotime($date_in));
					$expired 	= date('Y-m-j' , $exp);
					$status		= 'Belum Lunas';
					
					//Insert data transaksi ke table rent
					$insert2 	= mysql_query("INSERT INTO rent (`rent_id`, `req_id`, `merchant_id`, 
					`lapak_id`, `instalment_id`, `rent_total`, `rent_dp`, `interest`, `leftover`, 
					`leftover2`, `rent_instalment`, `rent_date`, `rent_dl`, `rent_expired`, `rent_desc`, 
					`rent_sts`, `rent_sts2`) 
					VALUES ('', '".$id."', '".$r['req_reffer']."', '".$lid."', '".$_POST['ins']."', '".$total."', 
					'".$_POST['dp']."', '".$_POST['interest']."', '".$leftover."','".$leftover2."', 
					'".$instalment."', '".$date_in."', '".$dateline."', '".$expired."', '".$_POST['ket']."', 
					'".$status."', 'Normal')");
				}
				
				$rid 	= mysql_insert_id();
				if($insert2){
					//Ubah status lapak
					$update1 = mysql_query("update lapak set lapak_status = 'Terisi' where lapak_id = '".$lid."'");
					if($update1){
						//Ubah status Pemohon
						$update2 = mysql_query("update request set req_status = 'Disetujui' where req_id = '".$id."'");
						if($update2){
							//pergi ke halaman cetak form perizinan
							//echo "<script>window.location=('htmltopdf/persetujuan_pedagang.php?id=$rid')</script>";
							$_SESSION['success'] = true;
							$_SESSION['title'] = 'Berhasil';
							$_SESSION['message'] = "Setujui permohonan lapak";
							echo "<script>window.location=('register2.php')</script>";
							exit();
						}
						else{
							// Alert Information
							$_SESSION['success'] = false;
							$_SESSION['title'] = 'Gagal';
							$_SESSION['message'] = "Setujui permohonan lapak 1";
							echo "<script>window.history.back()</script>";
							exit();
						}
					}
					else{
						// Alert Information
						$_SESSION['success'] = false;
						$_SESSION['title'] = 'Gagal';
						$_SESSION['message'] = "Setujui permohonan lapak 2";
						echo "<script>window.history.back()</script>";
						exit();
					}
				}
				else{
					// Alert Information
					$_SESSION['success'] = false;
					$_SESSION['title'] = 'Gagal';
					$_SESSION['message'] = "Setujui permohonan lapak 3";
					echo "<script>window.history.back()</script>";
					exit();
				}
			}
		}
		else{
			echo "<script>window.alert('Lapak Sudah Terisi, Coba Cek Sekali Lagi');
			window.history.back()</script>";
			exit();
		}
	}
	
	elseif($task == 'cancel'){
		$id		= $_GET['id'];
		$update	= mysql_query("update request set req_status = 'Dibatalkan' where req_id = '".$id."'");
		if($update){
			$_SESSION['success'] = true;
			$_SESSION['title'] = 'Berhasil';
			$_SESSION['message'] = "Membatalkan Pendaftaran Pedagang";
			echo "<script>window.location=('register.php')</script>";
			exit();
		}
		else{
			$_SESSION['success'] = false;
			$_SESSION['title'] = 'Gagal';
			$_SESSION['message'] = "Membatalkan Pendaftaran Pedagang";
			echo "<script>window.location=('register.php')</script>";
			exit();
		}
	}

	elseif($task == 'cancel2'){
		$id		= $_GET['id'];
		$update	= mysql_query("update request set req_status = 'Dibatalkan' where req_id = '".$id."'");
		if($update){
			$_SESSION['success'] = true;
			$_SESSION['title'] = 'Berhasil';
			$_SESSION['message'] = "Membatalkan Pendaftaran Pedagang";
			echo "<script>window.location=('register2.php')</script>";
			exit();
		}
		else{
			$_SESSION['success'] = false;
			$_SESSION['title'] = 'Gagal';
			$_SESSION['message'] = "Membatalkan Pendaftaran Pedagang";
			echo "<script>window.location=('register2.php')</script>";
			exit();
		}
	}
	
	elseif ($task == 'delete'){
		//$delete = mysql_query("delete request where request_id = '".$id."'");
		if($delete){
			//Writes the photo to the server 
			echo "<script>window.alert('Delete Success');
			window.location=('request.php')</script>";
		}
		else{
			echo "<script>window.alert('Delete Failled');
			window.location=('request.php')</script>";
		}
	}
?>