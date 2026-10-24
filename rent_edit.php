<?php
	session_start();
	include "connection.php";
	include "components/role_session.php";

	function headScript(){
		$headScript=file_get_contents("headScript.html");
		return $headScript;
	}

	//Ambil id_rent
	$id		= $_GET['id'];
	$lid 	= executeScalar("select lapak_id from rent where rent_id = '".$id."'");
	$mid 	= executeScalar("select merchant_id from rent where rent_id = '".$id."'");
	$lapak 	= executeScalar("select lapak_name from lapak where lapak_id = '".$lid."'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	<link rel="icon" href="img/logo.png">
    <link rel="shortcut icon" href="img/logo.png" />
    <title>Pembayaran Angsuran Lapak | PISS</title>

    <?php echo headScript(); ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	<script src="js/jquery.min.js"></script>
	<script language="javascript">
		/* hide all elements & show preloader*/
		document.documentElement.className += 'js';
		
		/* display variabel */
		var alertLoadProcess = "<span class='alert alert-info' onclick='clearNotif()'><i class='fa fa-spinner fa-spin'></i> Loading...</span>";
		
		//fungsi input hanya angka
		function isNumber(event) {
		  if (event) {
			var charCode = (event.which) ? event.which : event.keyCode;
			if (charCode != 190 && charCode > 31 && 
			   (charCode < 48 || charCode > 57) && 
			   (charCode < 96 || charCode > 105) && 
			   (charCode < 37 || charCode > 40) && 
				charCode != 110 && charCode != 8 && charCode != 46 )
			   return false;
		  }
		  return true;
		}
	</script>
</head>
<body>
    <div id="wrapper">
		<?php include "components/sidebar.php" ?>

		<div id="page-wrapper">
		<br><br><br><br>
			<div class="panel panel-primary">
				<div class="panel-heading">
					<i class="fa fa-money fa-fw"></i> Detail Data Angsuran
				</div>
				<div class="panel-body">
					<?php
						$sql 	= mysql_query("select * from rent r, merchant m, lapak l
								where r.rent_id = '".$id."' and r.merchant_id = m.merchant_id and
								r.lapak_id = l.lapak_id and rent_sts != 'Batal'");
						while($r = mysql_fetch_array($sql)){
						$ins 	= executeScalar("select instalment_count from instalment where instalment_id = '".$r['instalment_id']."'");
						$did 	= executeScalar("select count(rent_id) from rent_detail where rent_id = '".$id."'");
						$did	= $did+1;
						
						//Cek Sisa Angsuran
						$pay	 	= executeScalar("select sum(cash_total) from rent_detail where rent_id = '".$r['rent_id']."'");
						$leftover3	= $r['leftover2']-$pay;
						
						//generate tgl jatuh tempo
						$date_in 	= $r['rent_date'];
						$date_plus	= $did.' month';
						$exp 		= strtotime($date_plus, strtotime($date_in));
						$dateline 	= date('Y-m-j' , $exp);
					?>
					<div class="row">
						<div class="col-md-12" style="padding:0 35px; margin-bottom:20px;">
							<label>Kode Pedagang</label>
							<input class="form-control" value="<?php echo $mid; ?>" disabled></inp>
						</div>
					</div>
					<div class="col-lg-4" style="padding:10px; margin-bottom:-20px;">
						<div class="form-group" style="padding:10px; margin-top:-20px;">
							<label>Nama</label>
							<input class="form-control" value="<?php echo $r['merchant_name']; ?> / <?php echo $r['merchant_nick']; ?>" disabled></input>               
						</div>
						<div class="form-group" style="padding:10px; margin-top:-20px;">
							<label>Alamat</label>
							<input class="form-control" value="<?php echo $r['address1']; ?>" disabled></input>
						</div>
						<div class="form-group" style="padding:10px; margin-top:-20px;">
							<label>Telepon</label>
							<input class="form-control" value="<?php echo $r['phone1']; ?> / <?php echo $r['phone2']; ?>" disabled></input>
						</div>
						<div class="form-group" style="padding:10px; margin-top:-20px;">
							<label>No Identitas</label>
							<input class="form-control" value="<?php echo $r['nid_ktp'].$r['nid_sim'].$r['nid_lain']; ?> <?php if($r['nid_type']!=''){echo '('.$r['nid_type'].')';} ?>" disabled></input>
						</div>
						<div class="form-group" style="padding:10px; margin-top:-20px;">
							<label>Jenis Jualan</label>
							<input class="form-control" value="<?php echo $r['merchant_type']; ?>" disabled></input>
						</div>
						<div class="form-group" style="padding:10px; margin-top:-20px;">
							<label>Tanggal Masuk</label>
							<input class="form-control" value="<?php echo date("d M Y", strtotime($r['rent_date'])); ?>" disabled></input>
						</div>
					</div>
					<div class="col-lg-5" style="padding:0 10px; margin-bottom:-20px;">
						<div class="row">
							<div class="col-md-6">
								<label>Lapak</label>
								<input class="form-control" value="<?php echo $r['lapak_name']; ?>" disabled></input>
							</div>
							<div class="col-md-6">
								<label>Angsuran</label>
								<input class="form-control" value="<?php echo $ins.'x'; ?>" disabled></input>
							</div>
						</div>
						<div class="row" style="margin-top: 15px;">
							<div class="col-md-6" style="text-align:left;">
								<label>Ukuran M<sup>2</sup></label>
								<input class="form-control" value="<?php echo $r['lapak_size']; ?>" disabled></input>
							</div>
							<div class="col-md-6">
								<label>Bunga</label>
								<input class="form-control" value="<?php echo $r['interest'].'%'; ?>" disabled></input>
							</div>
						</div>
						<div class="row" style="margin-top: 15px;">
							<div class="col-md-6">
								<label>Harga /M<sup>2</sup></label>
								<input class="form-control" value="<?php echo format_rupiah($r['lapak_price']); ?>" disabled></input>
							</div>
							<div class="col-md-6" style="text-align:left;">
								<label>Total Harga</label>
								<input class="form-control" value="<?php echo format_rupiah($r['rent_total']); ?>" disabled></input>
							</div>
						</div>
						<div class="row" style="margin-top: 15px;">
							<div class="col-md-6">
								<label>Pembayaran DP</label>
								<input class="form-control" value="<?php echo format_rupiah($r['rent_dp']); ?>" disabled></input>
							</div>
							<div class="col-md-6" >
								<label>Sisa Pokok</label>
								<input class="form-control" value="<?php echo format_rupiah($r['leftover']);?>" disabled></input>
							</div>
						</div>
						<div class="row" style="margin-top: 15px;">
							<div class="col-md-6">
								<label>Total Angsuran</label>
								<input class="form-control" value="<?php echo format_rupiah($r['leftover2']); ?>" disabled></input>
							</div>
							<div class="col-md-6">
								<label>Angsuran Perbulan</label>
								<input class="form-control" value="<?php echo format_rupiah($r['rent_instalment']); ?>" disabled></input>
							</div>
						</div>
						<div class="row" style="margin-top: 15px;">
							<div class="col-md-6">
								<label>Sisa Angsuran</label>
								<input class="form-control" value="<?php echo format_rupiah($leftover3); ?>" disabled></input>
							</div>
							<div class="col-md-6">
								<label>Keterangan</label>
								<input class="form-control" value="<?php echo $r['rent_desc']; ?>" disabled></input>
							</div>
						</div>
					</div>
					<div class="col-lg-3" style="padding:25px 25px; margin-bottom:-30px;">
						<?php 
							//Jika Angsuran Telat
							if($r['rent_dl']<$date_now){
								//Hitung Perbedaan Tanggal
								// $diff 	= abs(strtotime($r['rent_dl']) - strtotime($date_now));
								
								// $years	= floor($diff / (365*60*60*24));
								// $months = floor(($diff - $years * 365*60*60*24) / (365*60*60*24));
								// $days 	= floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
								// if($years==0){
								// 	$a = '';
								// }
								// else{
								// 	$a = $years.' Tahun';
								// } 

								$date_now = date('Y-m-d'); // Pastikan format tanggal sesuai
								$rent_dl = $r['rent_dl']; // Tanggal dari database atau input

								$datetime1 = new DateTime($rent_dl);
								$datetime2 = new DateTime($date_now);
								$interval = $datetime1->diff($datetime2);

								$years = $interval->y;
								$months = $interval->m;
								$days = $interval->d;

								$total_months = $years * 12 + $months;
								$totalLeftPay = $r['rent_total'] * $total_months;

								echo '<div class="panel panel-danger" style="margin-top:-5px;">
										<div class="panel-heading" style="background-color: red; color: #fff;">
											<i class="fa fa-clock-o"></i>&nbsp;Angsuran Terlambat
										</div>
										<div class="panel-body" style="margin-top:0px;">
											<label>Keterangan Angsuran</label><br>
											<input class="form-control" value="'.$years.' Tahun '.$months.' Bulan '.$days.' Hari" disabled></input>
											<br />
											<label>Total Angsuran</label><br>
											<input class="form-control" value="'.format_rupiah($totalLeftPay).'" disabled></input>
										</div>
									</div>';
							}
							//Jika Angsuran Telah Lunas
							$angsrn = executeScalar("select sum(trans_total+cash_total) from rent_detail where rent_id = '".$id."'");
							$lo2 	= executeScalar("select leftover2 from rent where rent_id = '".$id."'");
							if($angsrn>=$lo2){
								echo '<div class="panel panel-primary">
										<div class="panel-heading">
											<i class="fa fa-money"></i>&nbsp;Angsuran Lunas
										</div>
										<div class="panel-body" style="margin-top:-10px;">
											<label>Angsuran Lapak Ini Telah Lunas</label>
										</div>
								</div>';
							}
							else{
						?>
						<form id="formInstalment" name="formInstalment" method="POST" action="rent_action.php?task=ins&id=<?php echo $id; ?>" class="form-horizontal" >
							<div class="panel panel-primary">
								<div class="panel-heading">
									<i class="fa fa-money"></i>&nbsp;Pembayaran
								</div>
								<div class="panel-body" style="margin-top:0px;">
									<div class="form-group" style="padding:10px; margin-top:-10px;">
										<label>Pembayaran Angsuran Ke-<?php echo $did; ?></label>
										<input class="form-control" value="<?php echo format_rupiah($r['rent_instalment']); ?>" disabled></input>
									</div>
									<div class="form-group" style="padding:10px; margin-top:-20px;">
										<label>Jatuh Tempo</label>
										<input class="form-control" value="<?php echo date("d M Y", strtotime($dateline)); ?>" disabled></input>
									</div>
									<div class="form-group" style="padding:10px; margin-top:-20px; margin-bottom:-10px;">
										<!--<button type="submit" class="btn btn-outline btn-block btn-primary">Bayar Cicilan</button>-->
										<label>Pilih Jenis Pembayaran</label>
										<select class="form-control" id="mySelect" onchange="switchTime()">
											<option value="">- Jenis Pembayaran -</option>
											<option value="cash">Tunai</option>
											<option value="trans">Transfer / Debit</option>
											<option value="cek">Cek</option>
											<option value="giro">Giro</option>
											<option value="combo1">Tunai & Transfer</option>
											<!--<option value="combo1">Tunai & Debit</option>-->
										</select>
									</div>
								</div>
							</div>
						</form>
						<?php }?>
					</div>
					<?php }?>
				</div>
			</div>
			<div id="Area1"></div>
			<div class="panel panel-info">
				<?php
					$sql2	= mysql_query("select * from rent_detail where rent_id = '".$id."' order by rent_detail_id desc");
					while($r2 = mysql_fetch_array($sql2)){
						//generate tgl jatuh tempo
						$date_in 	= executeScalar("select rent_date from rent where rent_id = '".$id."'");
						$date_plus	= $r2['instalment_no'].' month';
						$exp 		= strtotime($date_plus, strtotime($date_in));
						$dateline 	= date('Y-m-j' , $exp);
				?>
				<div class="panel-heading">
					<i class="fa fa-money fa-fw"></i> Pembayaran Angsuran Ke-<?php echo $r2['instalment_no'];?>
				</div>
				<div class="panel-body">
					<form id="formIns" method="POST" action="htmltopdf/Angsuran.php?id=<?php echo $r2['rent_detail_id']; ?>" target="_blank" class="form-horizontal" >
						<div class="col-lg-2" style="padding:10px; margin-bottom:-20px;">
							<div class="form-group" style="padding:10px; margin-top:-20px;">
								<label>Tanggal Jatuh Tempo</label>
								<div><?php echo date("d-m-Y", strtotime($dateline)); ?></div>               
							</div>
						</div>
						<div class="col-lg-2" style="padding:10px; margin-bottom:-20px;">
							<div class="form-group" style="padding:10px; margin-top:-20px;">
								<label>Tanggal Pembayaran</label>
								<div><?php echo date("d-m-Y", strtotime($r2['rent_detail_date'])); ?></div>               
							</div>
						</div>
						<div class="col-lg-2" style="padding:10px; margin-bottom:-20px;">
							<div class="form-group" style="padding:10px; margin-top:-20px;">
								<label>Jumlah Pembayaran</label>
								<div><?php echo format_rupiah($r2['cash_total']+$r2['trans_total']); ?></div>               
							</div>
						</div>
						<div class="col-lg-2" style="padding:10px; margin-bottom:-20px;">
							<div class="form-group" style="padding:10px; margin-top:-20px;">
								<label>Metode Pembayaran</label>
								<div><?php echo $r2['rent_detail_type']; ?></div>               
							</div>
						</div>
						<div class="col-lg-2" style="padding:10px; margin-bottom:-20px;">
							<div class="form-group" style="padding:10px; margin-top:-10px;">
								<button class="btn btn-outline btn-block btn-info">Lihat Detail</button>
							</div>
						</div>
						<div class="col-lg-2" style="padding:10px; margin-bottom:-20px;">
							<div class="form-group" style="padding:10px; margin-top:-10px;">
								<button type="submit" class="btn btn-outline btn-block btn-primary">Cetak</button>
							</div>
						</div>
					</form>
				</div>
				<?php }?>
			</div>
		</div>
    </div>

	<script>
		$(document).ready(function(){
			// Auto Refresh Page
			$("#notifArea").html(alertLoadProcess);
			setTimeout('$("html").removeClass("js")',1000); 
		});
		//Ganti Type Pembayaran
		function switchTime() {
			var x = document.getElementById("mySelect").value;
			
			if(x==""){
				$("#notifArea").html(alertLoadProcess);
				$("#Area1").load("blank.php",function(){clearNotif();});
			}
			else if(x=="cash"){
				$("#notifArea").html(alertLoadProcess);
				$("#Area1").load("cash.php?id=<?php echo $id; ?>",function(){clearNotif();});
			}
			else if(x=="trans"){
				$("#notifArea").html(alertLoadProcess);
				$("#Area1").load("trans.php?id=<?php echo $id; ?>",function(){clearNotif();});
			}
			else if(x=="cek"){
				$("#notifArea").html(alertLoadProcess);
				$("#Area1").load("cek.php?id=<?php echo $id; ?>",function(){clearNotif();});
			}
			else if(x=="giro"){
				$("#notifArea").html(alertLoadProcess);
				$("#Area1").load("giro.php?id=<?php echo $id; ?>",function(){clearNotif();});
			}
			else if(x=="combo1"){
				$("#notifArea").html(alertLoadProcess);
				$("#Area1").load("combo1.php?id=<?php echo $id; ?>",function(){clearNotif();});
			}
			else if(x=="combo2"){
				$("#notifArea").html(alertLoadProcess);
				$("#Area1").load("combo2.php?id=<?php echo $id; ?>",function(){clearNotif();});
			}
		}
		
		function clearNotif(){$("#notifArea").html("");}
    </script>
	
    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="js/plugins/metisMenu/metisMenu.min.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>
</body>
</html>
