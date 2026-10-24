<?php
	session_start();
	include "connection.php";
	include "components/role_session.php";

	function headScript(){
		$headScript=file_get_contents("headScript.html");
		return $headScript;
	}

	//$id		= $_GET['id'];
	$edit	= mysql_query("select * from merchant where merchant_id = '".$_GET['id']."'");
	while ($r = mysql_fetch_array($edit)){
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
    <title>Detail Pedagang Aktif | PISS</title>

    <?php echo headScript(); ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	<script src="js/jquery.min.js"></script>
	<script>
		/* hide all elements & show preloader*/
		document.documentElement.className += 'js';

		/* display variabel */
		var alertLoadProcess = "<span class='alert alert-danger' onclick='clearNotif()'><i class='fa fa-spinner fa-spin'></i> Loading...</span>";
    </script>
</head>
<body>
    <div id="wrapper">
		<?php include "components/sidebar.php" ?>

		<div id="page-wrapper">
		<br><br><br><br>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-check-circle fa-fw"></i> Detail Data Pedagang Aktif
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="formMerchant" name = "formMerchant" method="POST" action="merchant_action.php?task=update&id=<?php echo $r[0]; ?>">
								<fieldset>
								<div class="row" style="padding: 0 10px;">
									<div class="col-lg-12">
										<div class="form-group" style="padding: 0 10px;">
											<label>Kode Pedagang</label>
											<input type="text" class="form-control" id="name" name="name" value="<?php echo $r['merchant_id']; ?>" disabled>                
										</div>
									</div>
									<div class="col-lg-3" style="margin-top:-10px;">
										<div class="form-group" style="padding:10px;">
											<label>Nama</label>
											<input type="text" class="form-control" id="name" name="name" placeholder="Nama Pedagang" value="<?php echo $r['merchant_name']; ?>">                
										</div>
										<div class="form-group" style="padding:10px;margin-top:-20px;">
											<label>Alias</label>
											<input type="text" class="form-control" id="nick" name="nick" placeholder="Nama Alias Pedagang" value="<?php echo $r['merchant_nick']; ?>">
										</div>
										<div class="form-group" style="padding:10px;margin-top:-20px;">
											<label>Alamat (KTP)</label>
											<input class="form-control" id="adrs1" name="adrs1" type="text" placeholder="Alamat (KTP)" value="<?php echo $r['address1']; ?>" />
										</div>
										<div class="form-group" style="padding:10px;margin-top:-20px;">
											<label>Alamat (Surat)</label>
											<input class="form-control" id="adrs2" name="adrs2" type="text" placeholder="Alamat (Surat)" value="<?php echo $r['address2']; ?>" />
										</div>
									</div>
									<div class="col-lg-3" style="margin-top:-10px;">
										<div class="form-group" style="padding:10px;">
											<label>Telepon Rumah</label>
											<input id="tlp1" name="tlp1" placeholder="Telepon Rumah" value="<?php echo $r['phone1']; ?>" maxlength="11" onkeydown="return isNumber(event);" type="text" class="form-control" />
										</div>
										<div class="form-group" style="padding:10px;margin-top:-20px;">
											<label>Handphone</label>
											<input id="tlp2" name="tlp2" placeholder="Handphone" value="<?php echo $r['phone2']; ?>" maxlength="13" onkeydown="return isNumber(event);" type="text" class="form-control" />
										</div>
										<div class="form-group" style="padding:10px;margin-top:-20px;">
											<label>Jenis Jualan</label>
											<select class="form-control" name="type" id="type">
												<option value="<?php echo $r['merchant_type']; ?>"><?php echo $r['merchant_type']; ?></option>
												<option value="Sayur">Sayur</option>
												<option value="Buah">Buah</option>
												<option value="Lainnya">Lainnya</option>
											</select>
										</div>
										<div class="form-group" style="padding:10px; margin-top: -20px;">
											<label>Blok Aktif</label>
											<input type="text" class="form-control" id="block" name="block" placeholder="Blok Aktif" value="<?php echo $r['active_block']; ?>" disabled>   
										</div>
									</div>
									<div class="col-lg-6" style="margin-top:0px;">
											<label>No Identitas</label>
												<div class="row">
													<div class="col-lg-4">
														<input id="ktp" name="ktp" value="<?php echo $r['nid_ktp']; ?>" maxlength="16" onkeydown="return isNumber(event);" placeholder="KTP" type="text" class="form-control" />
													</div>
													<div class="col-lg-4">
														<input id="sim" name="sim" value="<?php echo $r['nid_sim']; ?>" placeholder="SIM (Opsional)" maxlength="12" onkeydown="return isNumber(event);" type="text"  class="form-control" />
													</div>
													<div class="col-lg-4">
														<input id="lain" name="lain" value="<?php echo $r['nid_lain']; ?>" placeholder="Lainnya (Opsional)"  maxlength="20" onkeydown="return isNumber(event);" type="text" class="form-control"/>
													</div>
												</div>
												
										<div class="form-group" style="margin-top: 15px; margin-left: 0px; margin-right: 0px">
											<label>Jenis Identitas</label>
											<select class="form-control" name="nid" id="nid" required>
												<?php if ($r['nid_type'] == '' || $r['nid_type'] == null) : ?>
													<option selected>Tidak Ada Identitas Diisi</option>
												<?php endif; ?>

												<option value="KTP" <?php echo ($r['nid_type'] == 'KTP') ? 'selected' : ''; ?>>KTP</option>
												<option value="SIM" <?php echo ($r['nid_type'] == 'SIM') ? 'selected' : ''; ?>>SIM</option>
												<option value="PASPOR" <?php echo ($r['nid_type'] == 'PASPOR') ? 'selected' : ''; ?>>PASPOR</option>
												<option value="Pelajar" <?php echo ($r['nid_type'] == 'Pelajar') ? 'selected' : ''; ?>>Kartu Pelajar/Mahasiswa</option>
												<option value="Lainnya" <?php echo ($r['nid_type'] == 'Lainnya') ? 'selected' : ''; ?>>Lainnya</option>
											</select>
										</div>
									</div>
									<div class="col-lg-3" style="margin-top:0px;">
										<div class="form-group" style="padding:0 15px;">
											<label>Jenis Pedagang</label>
											<select class="form-control" name="kat_merchant" id="kat_merchant">
												<option value="<?php echo $r['kat_merchant']; ?>">
												<?php if($r['kat_merchant'] == ''){
													echo '-- Pilih Jenis Pedagang --';
												}
												else{
													echo $r['kat_merchant'];
												} ?>
												</option>
												<option value="Tetap">Tetap</option>
												<option value="Trial Lapak">Trial Lapak</option>
												<option value="Trial Lapak Jalan">Trial Lapak Jalan</option>
											</select>
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group" style="padding: 0 15px;margin-top:0px;">
											<label>Status Pedagang</label>
											<div class="row">
												<div class="col-lg-12">
													<select class="form-control" name="sts" id="sts" disabled>
														<option value="<?php echo $r['merchant_status'];?>"><?php echo $r['merchant_status'];?></option>
														<option value="Aktif">Aktif</option>
														<option value="Tidak Aktif">Tidak Aktif</option>
													</select>
												</div>
												<!-- <div class="col-lg-6">
													<select class="form-control" name="sts2" id="sts2">
														<option value="<?php echo $r['merchant_status2'];?>"><?php echo $r['merchant_status2'];?></option>
														<option value="Lama Sewa">Lama Sewa</option>
														<option value="Baru Sewa">Baru Sewa</option>
													</select>
												</div> -->
											</div>
										</div>
									</div>
									<div class="col-lg-6">
										
									<div class="form-group" style="padding:0 15px; margin-top: 0px">
											<label>Asal Pasar</label>
											<select class="form-control" name="asal_pasar" id="asal_pasar">
												<option value="<?php echo $r['asal_pasar']; ?>">
												<?php if($r['asal_pasar'] == ''){
													echo '-- Pilih Asal Pasar --';
												}
												else{
													echo $r['asal_pasar'];
												} ?>
												</option>
												<option value="Belum Pernah">Belum Pernah</option>
												<option value="Pasar Osowilangun">Pasar Osowilangun</option>
												<option value="Pasar Pandegiling">Pasar Pandegiling</option>
												<option value="Pasar Keputran">Pasar Keputran</option>
												<option value="Pasar Mangga Dua">Pasar Mangga Dua</option>
												<option value="Pasar Pabean">Pasar Pabean</option>
											</select>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12" style="padding: 0 27px 0 25px;">
											<button class="btn btn-block btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;Simpan</button>
										</div>
									</div>
								</div>
								</fieldset>
							</form> 
                        </div>
                    </div>
					<?php
						$query1	= mysql_query("select lapak_id from rent where merchant_id = '".$_GET['id']."' and (rent_sts2 != 'Batal' && rent_sts2 != 'Pindah')");
						while ($q1 = mysql_fetch_array($query1)){
							$lid	= $q1['lapak_id'];
							$rid	= executeScalar("select rent_id from rent where merchant_id = '".$_GET['id']."' and lapak_id = '".$lid."' and (rent_sts2 != 'Batal' && rent_sts2 != 'Pindah')");
							
							$query2	= mysql_query("select * from rent where rent_id = '".$rid."'");
							while ($q2 = mysql_fetch_array($query2)){
								$iid 	= executeScalar("select instalment_id from rent where rent_id = '".$rid."'");
								$ins 	= executeScalar("select instalment_count from instalment where instalment_id = '".$iid."'");
								
								$query3	= mysql_query("select * from lapak where lapak_id = '".$lid."'");
								while ($q3 = mysql_fetch_array($query3)){
					?>
					<div class="panel panel-success">
                        <div class="panel-heading" style="background: green; color: #fff;">
                            <i class="fa fa-building fa-fw"></i> Detail Data Lapak (<b><?php echo $q3['lapak_name'];?></b>)
                        </div>
                        <div class="panel-body">
							<div class="row">
								<div class="col-lg-3">
									<div class="form-group">
										<div class="row">
											<div class="col-md-6">
												<label>Block</label>
										<input type="text" class="form-control" value="<?php echo $q3['block_id'];?>" disabled>
											</div>
											<div class="col-md-6" >
										<label>Lokasi</label>
										<input type="text" class="form-control" value="<?php echo $q3['lapak_name'];?>" disabled>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label>Masa Pakai</label>
										<input type="text" class="form-control" value="<?php echo $q3['duration'];?> Tahun" disabled>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-md-6">
												<label>Panjang</label>
												<input class="form-control" value="<?php echo $q3['p']; ?> M" disabled />
											</div>
											<div class="col-md-6" >
												<label>Lebar</label>
												<input class="form-control" value="<?php echo $q3['l'];?> M" disabled />
											</div>
										</div>
									</div>
									<div class="form-group" >
										<label>Harga Per M<sup>2</sup></label>
										<input class="form-control" type="text" value="<?php echo format_rupiah($q3['lapak_price']);?>" disabled />
									</div>
									<div class="form-group" >
										<label>Harga Total</label>
										<input class="form-control" type="text" value="<?php echo format_rupiah($q3['lapak_total']);?>" disabled />
									</div>
								</div>
								<div class="col-lg-3">
									<div class="form-group">
										<label>DP</label>
										<input type="text" class="form-control" value="<?php echo format_rupiah($q2['rent_dp']);?>" disabled>    
									</div>
									<div class="form-group" >
										<label>Sisa Pembayaran</label>
										<input type="text" class="form-control" value="<?php echo format_rupiah($q2['leftover']);?>" disabled>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-md-6" >
												<label>Angsuran</label>
												<!-- <input class="form-control" value="<?php echo $ins;?>x" disabled /> -->
												<input class="form-control" value="0x" disabled />
											</div>
											<div class="col-md-6" >
												<label>Bunga /Tahun</label>
												<input class="form-control" value="<?php echo $q2['interest'];?>%" disabled />
											</div>
										</div>
									</div>
									<div class="form-group">
										<label>Jumlah Yg Harus Diangsur</label>
										<input type="text" class="form-control" value="<?php echo format_rupiah($q2['leftover2']);?>" disabled>   
									</div>
									<div class="form-group" >
										<label>Cicilan Perbulan</label>
										<input type="text" class="form-control" value="<?php echo format_rupiah($q2['rent_instalment']);?>" disabled>
									</div>
								</div>
								<div class="col-lg-3">
									<div class="form-group" >
										<label>Tanggal Masuk</label>
										<input type="text" class="form-control" value="<?php echo date("d M Y", strtotime($q2['rent_date']));?>" disabled>                
									</div>
									<div class="form-group" >
										<label>Tanggal Berakhir</label>
										<!-- <input type="text" class="form-control" value="<?php echo date("d M Y", strtotime($q2['rent_expired']));?>" disabled> -->
										<input type="text" class="form-control" value="-" disabled>
									</div>
									<div class="form-group" >
										<label>Jatuh Tempo Angsuran</label>
										<!-- <input type="text" class="form-control" value="<?php echo date("d M Y", strtotime($q2['rent_dl']));?>" disabled> -->
										<input type="text" class="form-control" value="-" disabled>
									</div>
									<div class="form-group" >
										<label>Status Lapak</label>
										<input type="text" class="form-control" value="<?php echo $q2['rent_sts']; ?>" disabled>                
									</div>
									<div class="form-group" >
										<label>Status Lapak 2</label>
										<input type="text" class="form-control" value="<?php echo $q2['rent_sts2']; ?>" disabled>
									</div>
								</div>
								<div class="col-lg-3">
									<div class="form-group" >
										<label>Keterangan</label><br />
										<textarea class="form-control" cols="20" rows="12" disabled><?php echo $q2['rent_desc'];?></textarea>
									</div>
									<div class="form-group" >
										<button data-toggle="modal" data-target="#modalNonactive_<?php echo $q2['rent_id']; ?>" style="margin-top:40px;" class="btn btn-block btn-danger">Nonaktifkan Lapak</button>
									</div>
								</div>
							</div>
						</div>
                    </div>

					<!-- Modal Nonactive -->
					<div class="modal fade" id="modalNonactive_<?php echo $q2['rent_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalNonactiveLabel" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered" role="document">
							<div class="modal-content">
								<div class="modal-header bg-primary text-white" style="border-top-left-radius: 5px; border-top-right-radius: 5px;">
									<h5 class="modal-title" id="modalNonactiveLabel"><b>KONFIRMASI NONAKTIFKAN LAPAK</b></h5>
									<button style="margin-top: -20px;" type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<p>Apakah Anda yakin ingin menonaktifkan lapak?</p>
									<div class="bg-primary" 
										style="color:#fff; padding:4px; border-radius:5px; display:inline-block;">
										<i class="fa fa-user fa-fw d-in"></i>&nbsp;<?php echo $r['merchant_name']; ?>
									</div>
									<div class="bg-primary" 
										style="color:#fff; padding:4px; border-radius:5px; display:inline-block;">
										<i class="fa fa-th fa-fw d-in"></i>&nbsp;<?php echo $q3['lapak_name']; ?>
									</div>
									<br><br>
									<p><b>Catatan:</b> Lapak yang dinonaktifkan dari pedagang tersebut akan berstatus 'Kosong'!</p>
								</div>
								<div class="modal-footer d-flex justify-content-between">
									<button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
									<a href="merchant_action.php?task=deleteRent&id=<?php echo $q2['rent_id']; ?>&merchantID=<?php echo $q2['merchant_id']; ?>" class="btn btn-primary">Ya, nonaktifkan</a>
								</div>
							</div>
						</div>
					</div>
					<?php } } } ?>
                </div>
            </div>
        </div>
    </div>

	<script>
    $(document).ready(function(){
			// Auto Refresh Page
			$("#notifArea").html(alertLoadProcess);
			$('#Area1').load("employee_table.php",function(){clearNotif();});
			setTimeout('$("html").removeClass("js")',1000); 
		});
		function clearNotif(){$("#notifArea").html("")};
    </script>
	<script>
		$(document).ready(function(){
            //Modal Password
            $('#modalPassword').on('shown.bs.modal', function (e) {
                $("#notifArea").html(alertLoadProcess);
                $("#data_password").load("password.php",function(){clearNotif();});
            })
        });
	</script>
	
    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="js/plugins/metisMenu/metisMenu.min.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>
	<!-- Sweet Alert -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js"></script>
			<?php
				// Menampilkan SweetAlert jika session success ada dan bernilai true
				if (isset($_SESSION['success'])) {
					$title = $_SESSION['title'];
					$message = $_SESSION['message'];
					$icon = $_SESSION['success'] ? 'success' : 'error';
					echo "<script>
						Swal.fire({
							title: '$title',
							text: '$message',
							icon: '$icon'
						});
					</script>";
					unset($_SESSION['success']);
					unset($_SESSION['message']);
				}
			?>
</body>

</html>
<?php }?>