<?php
	session_start();
	include "connection.php";
	
	$task		= $_GET['task'];
	$sts		= $_GET['sts'];
	$id			= $_GET['id'];
	//Bayar Angsuran Tunai
	if($task=='ins'&&$sts=='cash'){
		$ins 	= executeScalar("select rent_instalment from rent where rent_id = '".$id."'");
		if($_POST['total']<$ins){
			echo "<script>window.alert('Uang yg diterima Kurang, Coba cek lagi');
			window.history.back()</script>";
			exit();
		}
		elseif($_POST['total']>$ins){
			$refound	= ($ins-$_POST['total'])*(-1);
			$kembalian	= format_rupiah($refound);
			echo "<script>window.alert('Uang yg diterima, kembali $kembalian')</script>";
		}
		//cek apakah pembayaran sudah selesai part 1
		$rsts 	= executeScalar("select rent_sts from rent where rent_id = '".$id."'");
		$angsrn = executeScalar("select sum(cash_total+trans_total) from rent_detail where rent_id = '".$id."'");
		$lo2 	= executeScalar("select leftover2 from rent where rent_id = '".$id."'");
		if($angsrn>=$lo2||$rsts=='Lunas'){
			echo "<script>window.alert('Angsuran Sudah Lunas');
			window.history.back()</script>";
			exit();
		}
		$did 	= executeScalar("select count(rent_id) from rent_detail where rent_id = '".$id."'");
		$did	= $did+1;
		
		$insert = mysql_query("insert into `rent_detail` (`rent_detail_id`, `rent_id`, `rent_detail_date`, 
		`instalment_no`, `cash_total`, `rent_detail_type`) 
		VALUES('', '".$id."', '".$date_now."', '".$did."', '".$ins."', 'Tunai')");
		
		if($insert){
			//update deadline bayar
			//cek apakah pembayaran sudah selesai stlh melakukan cicilan part 2
			//ubah logika pengecekan mnjadi count(instalment_no) >= instalment_count
			$angsrn 	= executeScalar("select sum(cash_total+trans_total) from rent_detail where rent_id = '".$id."'");
			$lo2 		= executeScalar("select leftover2 from rent where rent_id = '".$id."'");
			$dl 		= executeScalar("select rent_dl from rent where rent_id = '".$id."'");
			$date_plus 	= strtotime('1 month', strtotime($dl));
			$dateline 	= date('Y-m-j' , $date_plus);
			
			if($angsrn>=$lo2){
				
				$update	= mysql_query("update rent set rent_sts = 'Lunas', rent_dl = '".$dateline."',
				rent_paidoff = '".$date_now."' where rent_id = '".$id."'");
				if($update){
					echo "<script>window.alert('Pembayaran Angsuran Berhasil Dan Telah Lunas');
					window.location=('rent_edit.php?id=$id')</script>";
					exit();
				}
				else{
					echo "<script>window.alert('Pembayaran Pelunasan Angsuran Gagal');
					window.history.back()</script>";
					exit();
				}
			}
			//jika belum lunas
			else{
				$update2	= mysql_query("update rent set rent_dl = '".$dateline."' where rent_id = '".$id."'");
				if($update2){
					echo "<script>window.alert('Pembayaran Angsuran Berhasil');
					window.location=('rent_edit.php?id=$id')</script>";
					exit();
				}
				else{
					echo "<script>window.alert('Pembayaran Angsuran Gagal');
					window.history.back()</script>";
					exit();
				}
			}
		}
		else{
			echo "<script>window.alert('Pembayaran Angsuran Gagal');
			window.history.back()</script>";
			exit();
		}
	}
	//Bayar Angsuran Transfer
	if($task=='ins'&&$sts=='trans'){
		$ins 	= executeScalar("select rent_instalment from rent where rent_id = '".$id."'");
		if($_POST['total']<$ins){
			echo "<script>window.alert('Uang yg diterima kurang, Coba cek lagi');
			window.history.back()</script>";
			exit();
		}
		elseif($_POST['total']>$ins){
			$refound	= $_POST['total']-$ins;
			$kembalian	= format_rupiah($refound);
			echo "<script>window.alert('Uang yg diterima, kembali $kembalian')</script>";
		}
		//cek apakah pembayaran sudah selesai part 1
		$rsts 	= executeScalar("select rent_sts from rent where rent_id = '".$id."'");
		$angsrn = executeScalar("select sum(cash_total+trans_total) from rent_detail where rent_id = '".$id."'");
		$lo2 	= executeScalar("select leftover2 from rent where rent_id = '".$id."'");
		if($angsrn>=$lo2||$rsts=='Lunas'){
			echo "<script>window.alert('Angsuran Sudah Lunas');
			window.history.back()</script>";
			exit();
		}
		$did 	= executeScalar("select count(rent_id) from rent_detail where rent_id = '".$id."'");
		$did	= $did+1;
		
		$insert = mysql_query("insert into `rent_detail` (`rent_detail_id`, `rent_id`, `rent_detail_date`, 
		`instalment_no`, `bank_name`, `bank_account_name`, `norek`, `trans_total`, `trans_date`, `rent_detail_type`) 
		VALUES('', '".$id."', '".$date_now."', '".$did."', '".$_POST['bname']."', '".$_POST['mname']."', 
		 '".$_POST['norek']."', '".$ins."',  '".$_POST['date']."', 'Transfer')");
		
		if($insert){
			//update deadline bayar
			//cek apakah pembayaran sudah selesai stlh melakukan cicilan part 2
			//ubah logika pengecekan mnjadi count(instalment_no) >= instalment_count
			$angsrn 	= executeScalar("select sum(cash_total+trans_total) from rent_detail where rent_id = '".$id."'");
			$lo2 		= executeScalar("select leftover2 from rent where rent_id = '".$id."'");
			$dl 		= executeScalar("select rent_dl from rent where rent_id = '".$id."'");
			$date_plus 	= strtotime('1 month', strtotime($dl));
			$dateline 	= date('Y-m-j' , $date_plus);
			
			if($angsrn>=$lo2){
				
				$update	= mysql_query("update rent set rent_sts = 'Lunas', rent_dl = '".$dateline."',
				rent_paidoff = '".$date_now."' where rent_id = '".$id."'");
				if($update){
					echo "<script>window.alert('Pembayaran Angsuran Berhasil Dan Telah Lunas');
					window.location=('rent_edit.php?id=$id')</script>";
					exit();
				}
				else{
					echo "<script>window.alert('Pembayaran Pelunasan Angsuran Gagal');
					window.history.back()</script>";
					exit();
				}
			}
			//jika belum lunas
			else{
				$update2	= mysql_query("update rent set rent_dl = '".$dateline."' where rent_id = '".$id."'");
				if($update2){
					echo "<script>window.alert('Pembayaran Angsuran Berhasil');
					window.location=('rent_edit.php?id=$id')</script>";
					exit();
				}
				else{
					echo "<script>window.alert('Pembayaran Angsuran Gagal');
					window.history.back()</script>";
					exit();
				}
			}
		}
		else{
			echo "<script>window.alert('Pembayaran Angsuran Gagal');
			window.history.back()</script>";
			exit();
		}
	}
	//Bayar Angsuran Cek
	if($task=='ins'&&$sts=='cek'){
		$ins 	= executeScalar("select rent_instalment from rent where rent_id = '".$id."'");
		if($_POST['total']<$ins){
			echo "<script>window.alert('Uang yg diterima Kurang, Coba cek lagi');
			window.history.back()</script>";
			exit();
		}
		elseif($_POST['total']>$ins){
			$refound	= $_POST['total']-$ins;
			$kembalian=format_rupiah($refound);
			echo "<script>window.alert('Uang yg diterima, kembali $kembalian')</script>";
		}
		//cek apakah pembayaran sudah selesai part 1
		$rsts 	= executeScalar("select rent_sts from rent where rent_id = '".$id."'");
		$angsrn = executeScalar("select sum(cash_total+trans_total) from rent_detail where rent_id = '".$id."'");
		$lo2 	= executeScalar("select leftover2 from rent where rent_id = '".$id."'");
		if($angsrn>=$lo2||$rsts=='Lunas'){
			echo "<script>window.alert('Angsuran Sudah Lunas');
			window.history.back()</script>";
			exit();
		}
		$did 	= executeScalar("select count(rent_id) from rent_detail where rent_id = '".$id."'");
		$did	= $did+1;
		
		$insert = mysql_query("insert into `rent_detail` (`rent_detail_id`, `rent_id`, `rent_detail_date`, 
		`instalment_no`, `bank_name`, `bank_account_name`, `norek`, `cash_total`, `rent_detail_dl`, `rent_detail_type`) 
		VALUES('', '".$id."', '".$date_now."', '".$did."', '".$_POST['bname']."', '".$_POST['mname']."', 
		 '".$_POST['norek']."', '".$ins."',  '".$_POST['date']."', 'Cek')");
		
		if($insert){
			//update deadline bayar
			//cek apakah pembayaran sudah selesai stlh melakukan cicilan part 2
			//ubah logika pengecekan mnjadi count(instalment_no) >= instalment_count
			$angsrn 	= executeScalar("select sum(cash_total+trans_total) from rent_detail where rent_id = '".$id."'");
			$lo2 		= executeScalar("select leftover2 from rent where rent_id = '".$id."'");
			$dl 		= executeScalar("select rent_dl from rent where rent_id = '".$id."'");
			$date_plus 	= strtotime('1 month', strtotime($dl));
			$dateline 	= date('Y-m-j' , $date_plus);
			
			if($angsrn>=$lo2){
				
				$update	= mysql_query("update rent set rent_sts = 'Lunas', rent_dl = '".$dateline."',
				rent_paidoff = '".$date_now."' where rent_id = '".$id."'");
				if($update){
					echo "<script>window.alert('Pembayaran Angsuran Berhasil Dan Telah Lunas');
					window.location=('rent_edit.php?id=$id')</script>";
					exit();
				}
				else{
					echo "<script>window.alert('Pembayaran Pelunasan Angsuran Gagal');
					window.history.back()</script>";
					exit();
				}
			}
			//jika belum lunas
			else{
				$update2	= mysql_query("update rent set rent_dl = '".$dateline."' where rent_id = '".$id."'");
				if($update2){
					echo "<script>window.alert('Pembayaran Angsuran Berhasil');
					window.location=('rent_edit.php?id=$id')</script>";
					exit();
				}
				else{
					echo "<script>window.alert('Pembayaran Angsuran Gagal');
					window.history.back()</script>";
					exit();
				}
			}
		}
		else{
			echo "<script>window.alert('Pembayaran Angsuran Gagal');
			window.history.back()</script>";
			exit();
		}
	}
	//Bayar Angsuran Giro
	if($task=='ins'&&$sts=='giro'){
		$ins 	= executeScalar("select rent_instalment from rent where rent_id = '".$id."'");
		if($_POST['total']<$ins){
			echo "<script>window.alert('Uang yg diterima Kurang, Coba cek lagi');
			window.history.back()</script>";
			exit();
		}
		elseif($_POST['total']>$ins){
			$refound	= $_POST['total']-$ins;
			$kembalian	= format_rupiah($refound);
			echo "<script>window.alert('Uang yg diterima, kembali $kembalian')</script>";
		}
		//cek apakah pembayaran sudah selesai part 1
		$rsts 	= executeScalar("select rent_sts from rent where rent_id = '".$id."'");
		$angsrn = executeScalar("select sum(cash_total+trans_total) from rent_detail where rent_id = '".$id."'");
		$lo2 	= executeScalar("select leftover2 from rent where rent_id = '".$id."'");
		if($angsrn>=$lo2||$rsts=='Lunas'){
			echo "<script>window.alert('Angsuran Sudah Lunas');
			window.history.back()</script>";
			exit();
		}
		$did 	= executeScalar("select count(rent_id) from rent_detail where rent_id = '".$id."'");
		$did	= $did+1;
		
		$insert = mysql_query("insert into `rent_detail` (`rent_detail_id`, `rent_id`, `rent_detail_date`, 
		`instalment_no`, `bank_name`, `bank_account_name`, `norek`, `cash_total`, `rent_detail_dl`, `rent_detail_type`) 
		VALUES('', '".$id."', '".$date_now."', '".$did."', '".$_POST['bname']."', '".$_POST['mname']."', 
		 '".$_POST['norek']."', '".$ins."',  '".$_POST['date']."', 'Giro')");
		
		if($insert){
			//update deadline bayar
			//cek apakah pembayaran sudah selesai stlh melakukan cicilan part 2
			//ubah logika pengecekan mnjadi count(instalment_no) >= instalment_count
			$angsrn 	= executeScalar("select sum(cash_total+trans_total) from rent_detail where rent_id = '".$id."'");
			$lo2 		= executeScalar("select leftover2 from rent where rent_id = '".$id."'");
			$dl 		= executeScalar("select rent_dl from rent where rent_id = '".$id."'");
			$date_plus 	= strtotime('1 month', strtotime($dl));
			$dateline 	= date('Y-m-j' , $date_plus);
			
			if($angsrn>=$lo2){
				
				$update	= mysql_query("update rent set rent_sts = 'Lunas', rent_dl = '".$dateline."',
				rent_paidoff = '".$date_now."' where rent_id = '".$id."'");
				if($update){
					echo "<script>window.alert('Pembayaran Angsuran Berhasil Dan Telah Lunas');
					window.location=('rent_edit.php?id=$id')</script>";
					exit();
				}
				else{
					echo "<script>window.alert('Pembayaran Pelunasan Angsuran Gagal');
					window.history.back()</script>";
					exit();
				}
			}
			//jika belum lunas
			else{
				$update2	= mysql_query("update rent set rent_dl = '".$dateline."' where rent_id = '".$id."'");
				if($update2){
					echo "<script>window.alert('Pembayaran Angsuran Berhasil');
					window.location=('rent_edit.php?id=$id')</script>";
					exit();
				}
				else{
					echo "<script>window.alert('Pembayaran Angsuran Gagal');
					window.history.back()</script>";
					exit();
				}
			}
		}
		else{
			echo "<script>window.alert('Pembayaran Angsuran Gagal');
			window.history.back()</script>";
			exit();
		}
	}
	//Bayar Angsuran Tunai & Transfer
	if($sts=='combo1'&&$task=='ins'){
		$ins 	= executeScalar("select rent_instalment from rent where rent_id = '".$id."'");
		if(($_POST['total1']+$_POST['total2'])<$ins){
			echo "<script>window.alert('Uang yg diterima Kurang, Coba cek lagi');
			window.history.back()</script>";
			exit();
		}
		elseif(($_POST['total1']+$_POST['total2'])>$ins){
			$refound	= ($_POST['total1']+$_POST['total2'])-$ins;
			$kembalian	= format_rupiah($refound);
			echo "<script>window.alert('Uang yg diterima, kembali $kembalian')</script>";
		}
		//cek apakah pembayaran sudah selesai part 1
		$rsts 	= executeScalar("select rent_sts from rent where rent_id = '".$id."'");
		$angsrn = executeScalar("select sum(cash_total+trans_total) from rent_detail where rent_id = '".$id."'");
		$lo2 	= executeScalar("select leftover2 from rent where rent_id = '".$id."'");
		if($angsrn>=$lo2||$rsts=='Lunas'){
			echo "<script>window.alert('Angsuran Sudah Lunas');
			window.history.back()</script>";
			exit();
		}
		$did 	= executeScalar("select count(rent_id) from rent_detail where rent_id = '".$id."'");
		$did	= $did+1;
		$cash	= $ins-$_POST['total2'];
		
		$insert = mysql_query("insert into `rent_detail` (`rent_detail_id`, `rent_id`, `rent_detail_date`, 
		`instalment_no`, `cash_total`, `bank_name`, `bank_account_name`, `norek`, `trans_total`, `rent_detail_dl`, `rent_detail_type`) 
		VALUES('', '".$id."', '".$date_now."', '".$did."', '".$cash."', '".$_POST['bname']."', '".$_POST['mname']."', 
		 '".$_POST['norek']."', '".$_POST['total2']."',  '".$_POST['date']."', 'Tunai & Transfer')");
		
		if($insert){
			//update deadline bayar
			//cek apakah pembayaran sudah selesai stlh melakukan cicilan part 2
			//ubah logika pengecekan mnjadi count(instalment_no) >= instalment_count
			$angsrn 	= executeScalar("select sum(cash_total+trans_total) from rent_detail where rent_id = '".$id."'");
			$lo2 		= executeScalar("select leftover2 from rent where rent_id = '".$id."'");
			$dl 		= executeScalar("select rent_dl from rent where rent_id = '".$id."'");
			$date_plus 	= strtotime('1 month', strtotime($dl));
			$dateline 	= date('Y-m-j', $date_plus);
			
			if($angsrn>=$lo2){
				$update	= mysql_query("update rent set rent_sts = 'Lunas', rent_dl = '".$dateline."',
				rent_paidoff = '".$date_now."' where rent_id = '".$id."'");
				if($update){
					echo "<script>window.alert('Pembayaran Angsuran Berhasil Dan Telah Lunas');
					window.location=('rent_edit.php?id=$id')</script>";
					exit();
				}
				else{
					echo "<script>window.alert('Pembayaran Pelunasan Angsuran Gagal');
					window.history.back()</script>";
					exit();
				}
			}
			//jika belum lunas
			else{
				$update2	= mysql_query("update rent set rent_dl = '".$dateline."' where rent_id = '".$id."'");
				if($update2){
					echo "<script>window.alert('Pembayaran Angsuran Berhasil');
					window.location=('rent_edit.php?id=$id')</script>";
					exit();
				}
				else{
					echo "<script>window.alert('Pembayaran Angsuran Gagal');
					window.history.back()</script>";
					exit();
				}
			}
		}
		else{
			echo "<script>window.alert('Pembayaran Angsuran Gagal');
			window.history.back()</script>";
			exit();
		}
	}
?>