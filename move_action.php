<?php
	session_start();
	include "connection.php";
	$task	= $_GET['task'];
	
	//Pindah ke lapak kosong
	if ($task=='move1'){
		$mid	= $_GET['id'];
		//Ambil data penyewaan lapak awal
		$select = mysql_query("select * from rent where merchant_id = '".$mid."' and 
		lapak_id = '".$_POST['lapak1']."' and rent_sts != 'Batal'");
		while ($r = mysql_fetch_array($select)){
			$rid		= $r['rent_id'];
			$dp			= $r['rent_dp'];
			$leftover	= $r['leftover'];
			$req_id		= $r['req_id'];
			$instalment	= $r['rent_instalment'];
			$interest	= $r['interest'];
			$rent_dl	= $r['rent_dl'];
			$expired	= $r['rent_expired'];
			$ins_id		= $r['instalment_id'];
			$name 		= executeScalar("select lapak_name from lapak where lapak_id = '".$_POST['lapak1']."'");
			$type1		= executeScalar("select lapak_type from lapak where lapak_id = '".$_POST['lapak1']."'");
			//ambil masa angsuran lapak lama
			$ins_count	= executeScalar("select instalment_count from instalment where instalment_id = '".$ins_id."'");
			//ambil jml yg telah dianggsur selama ini di lapak lama
			$ins_sum	= executeScalar("select (sum(trans_total)+sum(cash_total)) from rent_detail where rent_id = '".$r['rent_id']."'");
			if($ins_sum==''){
				$ins_sum=0;
			}
			//ambil jml brp kali telah melakukan cicilan
			$ins_total	= executeScalar("select count(rent_detail_id) from rent_detail where rent_id = '".$r['rent_id']."'");
			if($ins_total==''){
				$ins_total=0;
			}
		}
		//Ambil data penyewaan lapak baru / lapak tujuan
		$type2		= executeScalar("select lapak_type from lapak where lapak_id = '".$_POST['lapak2']."'");
		$block		= executeScalar("select block_id from lapak where lapak_id = '".$_POST['lapak2']."'");
		$total		= executeScalar("select lapak_total from lapak where lapak_id = '".$_POST['lapak2']."'");
		
		//Validasi Jika Tipe Lapak Berbeda
		if($type1!=$type2){
			echo "<script>window.alert('Tipe Lapak Berbeda, Mohon dicek lagi');
			window.history.back()</script>";
			exit();
		}
		//Bunga Perbulan 	= (sisa bayar * bunga pertahun)/12
		$interest_permonth 	= ($leftover*$interest/100)/12;
		//Angsuran Bersih 	= Sisa Pokok / jml angsuran * jml yg telah dicicil
		$instalment_pure	= $leftover/$ins_count*$ins_total;
		//hitung jml bunga dr angsuran lama yg telah dibayarkan
		$instalment_bruto 	= $interest_permonth*$ins_total;
		
		//Hitung angsuran lapak tujuan dengan jml angsuran yg baru
		$interest2		= $_POST['interest'];
		$ins 			= executeScalar("select instalment_count from instalment where instalment_id = '".$_POST['ins']."'");
		$dp2			= $dp+$instalment_pure;
		
		//Jika pindah ke lapak yg lebih murah dan angsuran yg dibayar sdh lebih besar dr lapak yg baru dianggap lunas
		if($total<=($dp+$instalment_pure)){
			$leftover2		= 0;
			$angs			= 0;
			$instalment2 	= 0;
			$status			= 'Lunas';
		}
		else{
			//Sisa = total harga - dp - angsuran bersih
			$leftover2		= $total-$dp-$instalment_pure;
			//Cicilan Pertahun = (jml cicilan/12) * bunga
			$year_interest 	= ($ins/12)*($interest2/100);
			//Sisa Angsuran = sisa bayar + jml bunga baru
			$angs			= $leftover2+($leftover2*$year_interest);
			//hitung angsuran lapak yg baru
			$instalment2 	= $angs/$ins;
			$status			= 'Belum Lunas';
		}
		
		//Update status rent
		$update		= mysql_query("update rent set rent_sts = 'Batal', rent_sts2 = 'Pindah' where rent_id = '".$rid."'");
		//Update status lapak
		$update2 	= mysql_query("update lapak set lapak_status = 'Kosong' where lapak_id = '".$_POST['lapak1']."'");
		
		if($update&&$update2){
			//Generate Tgl Jatuh Tempo Pembayaran Angsuran Lapak Baru
			/*$date_plus 	= strtotime('1 month', strtotime($date_now));
			$dateline 	= date('Y-m-j' , $date_plus);*/
			
			//Insert ke table rental
			$insert = mysql_query("insert into rent(rent_id, req_id, merchant_id, lapak_id, 
			instalment_id, rent_total, rent_dp, interest, leftover, leftover2, rent_instalment, 
			rent_date, rent_dl, rent_expired, rent_desc, instalment_reffer, rent_sts, rent_sts2)
			values('', '".$req_id."', '".$mid."', '".$_POST['lapak2']."', '".$_POST['ins']."', '".$total."', 
			'".$dp2."', '".$interest2."', '".$leftover2."', '".$angs."', '".$instalment2."', '".$date_now."', 
			'".$rent_dl."', '".$expired."', 'Pindahan Dari Lapak ".$name."', '".$total."', 
			'".$status."', 'Pindahan')");
			//Ubah status lapak Baru
			$update3	= mysql_query("update lapak set lapak_status = 'Terisi' where lapak_id = '".$_POST['lapak2']."'");
			if($insert&&$update3){
				//Insert ke table history pindah lapak
				$insert2 = mysql_query("insert into move_log(move_log_id, merchant_id, move_start, move_end, move_date, move_interest)
				values('', '".$mid."', '".$_POST['lapak1']."', '".$_POST['lapak2']."', '".$date_now."', '".$_POST['interest']."')");
				
				if($insert2){
					//Update aktive block merchant
					$update4	= mysql_query("update merchant set active_block = '".$block."' where merchant_id = '".$mid."'");
					if($update4){
						// Alert Information
						$_SESSION['success'] = true;
						$_SESSION['title'] = 'Berhasil';
						$_SESSION['message'] = "Pindah lapak";
						echo "<script>window.location=('move_select.php')</script>";
						exit();
					}
					else{
						// Alert Information
						$_SESSION['success'] = false;
						$_SESSION['title'] = 'Gagal';
						$_SESSION['message'] = "Pindah lapak";
						echo "<script>window.history.back()</script>";
						exit();
					}
				}
				else{
					echo "<script>window.alert('Pindah Lapak Gagal');
					window.history.back()</script>";
					exit();
				}
			}
			else{
				echo "<script>window.alert('Insert Failled');
				window.history.back()</script>";
				exit();
			}
		}
		else{
			echo "<script>window.alert('Update Status Gagal');
			window.location=('move_select.php')</script>";
		}
	}

	//Tukar Lapak
	elseif ($task=='move2'){
		$lapak1		= $_POST['lapak1'];
		$lapak2		= $_POST['lapak2'];
		
		//Ambil dan simpan data lapak 1
		$save1	= mysql_query("select * from rent where lapak_id = '".$lapak1."' and rent_sts != 'Batal'");
		while($s1 = mysql_fetch_array($save1)){
			$rid1		= $s1['rent_id'];
			$mid1		= $s1['merchant_id'];
			$total1		= $s1['rent_total'];
			$dp1		= $s1['rent_dp'];
			$leftover1	= $s1['leftover'];
			$req_id1	= $s1['req_id'];
			$interest1	= $s1['interest'];
			$rent_dl1	= $s1['rent_dl'];
			$expired1	= $s1['rent_expired'];
			$ins_id1	= $s1['instalment_id'];
			$name1		= executeScalar("select lapak_name from lapak where lapak_id = '".$lapak1."'");
			$type1		= executeScalar("select lapak_type from lapak where lapak_id = '".$lapak1."'");
			$total1		= executeScalar("select lapak_total from lapak where lapak_id = '".$lapak1."'");
			//ambil masa angsuran lapak lama
			$ins_count1	= executeScalar("select instalment_count from instalment where instalment_id = '".$ins_id1."'");
			//ambil jml yg telah dianggsur selama ini di lapak lama
			$ins_sum1	= executeScalar("select (sum(trans_total)+sum(cash_total)) from rent_detail where rent_id = '".$rid1."'");
			if($ins_sum1==''){
				$ins_sum1=0;
			}
			//ambil jml brp kali telah melakukan cicilan
			$ins_total1	= executeScalar("select count(rent_detail_id) from rent_detail where rent_id = '".$rid1."'");
			if($ins_total1==''){
				$ins_total1=0;
			}
		}
		
		//Ambil dan simpan data lapak 2
		$save2	= mysql_query("select * from rent where lapak_id = '".$lapak2."' and rent_sts != 'Batal'");
		while($s2 = mysql_fetch_array($save2)){
			$rid2		= $s2['rent_id'];
			$mid2		= $s2['merchant_id'];
			$total2		= $s2['rent_total'];
			$dp2		= $s2['rent_dp'];
			$leftover2	= $s2['leftover'];
			$req_id2	= $s2['req_id'];
			$interest2	= $s2['interest'];
			$rent_dl2	= $s2['rent_dl'];
			$expired2	= $s2['rent_expired'];
			$ins_id2	= $s2['instalment_id'];
			$name2		= executeScalar("select lapak_name from lapak where lapak_id = '".$lapak2."'");
			$type2		= executeScalar("select lapak_type from lapak where lapak_id = '".$lapak2."'");
			$total2		= executeScalar("select lapak_total from lapak where lapak_id = '".$lapak2."'");
			//ambil masa angsuran lapak lama
			$ins_count2	= executeScalar("select instalment_count from instalment where instalment_id = '".$ins_id2."'");
			//ambil jml yg telah dianggsur selama ini di lapak lama
			$ins_sum2	= executeScalar("select (sum(trans_total)+sum(cash_total)) from rent_detail where rent_id = '".$rid2."'");
			if($ins_sum2==''){
				$ins_sum2=0;
			}
			//ambil jml brp kali telah melakukan cicilan
			$ins_total2	= executeScalar("select count(rent_detail_id) from rent_detail where rent_id = '".$rid2."'");
			if($ins_total2==''){
				$ins_total2=0;
			}
		}
		
		//Validasi Jika Tipe Lapak Berbeda
		if($type1!=$type2){
			echo "<script>window.alert('Tipe Lapak Berbeda, Mohon dicek lagi');
			window.history.back()</script>";
			exit();
		}
		
		//Hitung uang yg telah dibayar di lapak 1
		//Bunga Perbulan 	= (sisa bayar * bunga pertahun)/12
		$interest_permonth1 = ($leftover1*$interest1/100)/12;
		//Angsuran Bersih 	= Sisa Pokok / jml angsuran * jml yg telah dicicil
		$instalment_pure1	= $leftover1/$ins_count1*$ins_total1;
		//hitung jml bunga dr angsuran lama yg telah dibayarkan
		$instalment_bruto1 	= $interest_permonth1*$ins_total1;
		
		//Hitung uang yg telah dibayar di lapak 2
		//Bunga Perbulan 	= (sisa bayar * bunga pertahun)/12
		$interest_permonth2 = ($leftover2*$interest2/100)/12;
		//Angsuran Bersih 	= Sisa Pokok / jml angsuran * jml yg telah dicicil
		$instalment_pure2	= $leftover2/$ins_count2*$ins_total2;
		//hitung jml bunga dr angsuran lama yg telah dibayarkan
		$instalment_bruto2 	= $interest_permonth2*$ins_total2;
		
		$dp3		= $dp1+$instalment_pure1;
		$dp4		= $dp2+$instalment_pure2;
		
		//Jika pindah ke lapak yg lebih murah dan angsuran yg dibayar sdh lebih besar dr lapak yg baru dianggap lunas
		if($total2<=($dp3)){
			$leftover3		= 0;
			$angs3			= 0;
			$instalment3 	= 0;
			$status3		= 'Lunas';
		}
		else{
			//Sisa = total harga - dp - angsuran bersih
			$leftover3		= $total2-$dp3;
			//Cicilan Pertahun = (jml cicilan/12) * bunga pertahun (menggunakan bunga lapak tujuan)
			$year_interest3 = ($ins_count1/12)*($interest1/100);
			//Sisa Angsuran = sisa bayar + jml bunga baru
			$angs3			= $leftover3+($leftover3*$year_interest3);
			//hitung angsuran lapak yg baru
			$instalment3 	= $angs3/$ins_count1;
			$status3		= 'Belum Lunas';
		}
		if($total1<=($dp4)){
			$leftover4		= 0;
			$angs4			= 0;
			$instalment4 	= 0;
			$status4		= 'Lunas';
		}
		else{
			//Sisa = total harga - dp - angsuran bersih
			$leftover4		= $total1-$dp4;
			//Cicilan Pertahun = (jml cicilan/12) * bunga pertahun (menggunakan bunga lapak tujuan)
			$year_interest4 = ($ins_count2/12)*($interest2/100);
			//Sisa Angsuran = sisa bayar + jml bunga baru
			$angs4			= $leftover4+($leftover4*$year_interest4);
			//hitung angsuran lapak yg baru
			$instalment4 	= $angs4/$ins_count2;
			$status4		= 'Belum Lunas';
		}
		
		//Update status rent 
		$update1	= mysql_query("update rent set rent_sts = 'Batal', rent_sts2 = 'Pindah' 
		where rent_id = '".$rid1."'");
		$update2	= mysql_query("update rent set rent_sts = 'Batal', rent_sts2 = 'Pindah' 
		where rent_id = '".$rid2."'");	
		
		if($update1&&$update2){
			//Insert data M1 ke table rental
			$insert1 = mysql_query("insert into rent(rent_id, req_id, merchant_id, lapak_id, 
			instalment_id, rent_total, rent_dp, interest, leftover, leftover2, rent_instalment, 
			rent_date, rent_dl, rent_expired, rent_desc, instalment_reffer, rent_sts, rent_sts2)
			values('', '".$req_id1."', '".$mid1."', '".$lapak2."', '".$ins_id1."', '".$total2."', 
			'".$dp3."', '".$interest1."', '".$leftover3."', '".$angs3."', '".$instalment3."', 
			'".$date_now."', '".$rent_dl1."', '".$expired1."', 'Pindahan Dari Lapak ".$name1."', 
			'".$instalment_pure1."', '".$status3."', 'Pindahan')");
			
			//Insert data M2 ke table rental
			$insert2 = mysql_query("insert into rent(rent_id, req_id, merchant_id, lapak_id, 
			instalment_id, rent_total, rent_dp, interest, leftover, leftover2, rent_instalment, 
			rent_date, rent_dl, rent_expired, rent_desc, instalment_reffer, rent_sts, rent_sts2)
			values('', '".$req_id2."', '".$mid2."', '".$lapak1."', '".$ins_id2."', '".$total1."', 
			'".$dp4."', '".$interest2."', '".$leftover4."', '".$angs4."', '".$instalment4."', 
			'".$date_now."', '".$rent_dl2."', '".$expired2."', 'Pindahan Dari Lapak ".$name2."', 
			'".$instalment_pure2."', '".$status4."', 'Pindahan')");
			
			if($insert1&&$insert2){
				//Insert ke table history pindah lapak
				$insert3 = mysql_query("insert into move_log(move_log_id, merchant_id, move_start, 
				move_end, move_date, move_interest)
				values('', '".$mid1."', '".$lapak1."', '".$lapak2."', '".$date_now."', 
				'".$interest_permonth1."')");
				$insert4 = mysql_query("insert into move_log(move_log_id, merchant_id, move_start, 
				move_end, move_date, move_interest)
				values('', '".$mid2."', '".$lapak2."', '".$lapak1."', '".$date_now."', 
				'".$interest_permonth1."')");
				
				//cari block dari lapak yg pindah
				$block1	= executeScalar("select block_id from lapak where lapak_id = '".$lapak1."'");
				$block2	= executeScalar("select block_id from lapak where lapak_id = '".$lapak2."'");
				
				if($insert3&&$insert4){
					//Update aktive block merchant
					$update3	= mysql_query("update merchant set active_block = '".$block2."' where merchant_id = '".$mid1."'");
					$update4	= mysql_query("update merchant set active_block = '".$block1."' where merchant_id = '".$mid2."'");
					if($update3&&$update4){
						// Alert Information
						$_SESSION['success'] = true;
						$_SESSION['title'] = 'Berhasil';
						$_SESSION['message'] = "Pertukaran lapak";
						echo "<script>window.location=('move_select2.php')</script>";
						exit();
					}
					else{
						// Alert Information
						$_SESSION['success'] = false;
						$_SESSION['title'] = 'gagal';
						$_SESSION['message'] = "Pertukaran lapak";
						echo "<script>window.history.back()</script>";
						exit();
					}
				}
				else{
					echo "<script>window.alert('Pertukaran Lapak Gagal');
					window.history.back()</script>";
					exit();
				}
			}
			else{
				echo "<script>window.alert('Pertukaran Lapak Gagal');
				window.history.back()</script>";
				exit();
			}
		}
		else{
			echo "<script>window.alert('Pertukaran Lapak Gagal');
			window.history.back()</script>";
			exit();
		}
	}
	
	elseif ($task == 'delete'){
		//$delete = mysql_query("delete home where home_id = '".$id."'");
		if($delete){
			//Writes the photo to the server 
			echo "<script>window.alert('Delete Success');
			window.location=('home.php')</script>";
		}
		else{
			echo "<script>window.alert('Delete Failled');
			window.location=('home.php')</script>";
		}
	}
?>