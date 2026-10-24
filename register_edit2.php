<?php
	session_start();
	include "connection.php";
	include "components/role_session.php";

	function headScript(){
		$headScript=file_get_contents("headScript.html");
		return $headScript;
	}
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
    <title>Detail Tambah Lapak | PISS</title>

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
	<?php 
		$id		= $_GET['id'];
		$edit	= mysql_query("select * from request where req_id = '".$id."'");
		while($r = mysql_fetch_array($edit)){
	?>
    <div id="wrapper">
	<?php include "components/sidebar.php" ?>

	<div id="page-wrapper">
		<br><br><br><br>
            <div class="row">
				<div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-user fa-fw"></i> Detail Tambah Lapak Pedagang
                        </div>
                        <div class="panel-body">
							<form action="register_action.php?task=update&id=<?php echo $id; ?>" id="formRegisterAcc" name = "formRegisterAcc" method="POST" class="form-horizontal">
								<fieldset>
									<div class="row">
										<div class="col-lg-12" style="padding:0 20px 15px 20px">
											<label>No. Form</label>
											<input id="pl" name="pl" value="<?php $idq = sprintf("%04d", $id);echo 'P-'.$idq; ?>" type="text" class="form-control" disabled />
										</div>
									</div>

									<div class="row">
										<div class="col-lg-6" style="padding:0 10px 0 20px">
											<label>Nama</label>
											<input id="name1" name="name1" value="<?php echo $r['req_name']; ?>" placeholder="Nama Sesuai KTP" type="text" class="form-control" required />   
											<input style="margin-top: 5px;" id="name2" name="name2" value="<?php echo $r['req_nick']; ?>" placeholder="Nama Alias" type="text" class="form-control">          
										</div>

										<div class="col-lg-6" style="padding:0 20px 0 10px;">
											<label>Alamat</label>
											<input id="adrs1" name="adrs1" value="<?php echo $r['address1']; ?>" placeholder="Alamat Sesuai KTP" type="text" class="form-control" required />
											<input style="margin-top: 5px;" id="adrs2" name="adrs2" value="<?php echo $r['address2']; ?>" placeholder="Alamat Surat (Opsional)" type="text" class="form-control" />
										</div>
									</div>

									<div class="row">
										<div class="col-lg-6" style="padding:0 10px 0 20px; margin-top: 15px;">
											<label>Telepon</label>
											<input id="tlp1" name="tlp1" value="<?php echo $r['phone1']; ?>" maxlength="11" onkeydown="return isNumber(event);" placeholder="Telepon Rumah" type="text" class="form-control" />
											<input style="margin-top: 5px;" id="tlp2" name="tlp2" value="<?php echo $r['phone2']; ?>" maxlength="13" onkeydown="return isNumber(event);" placeholder="Handphone (HP)" type="text" class="form-control" />
										</div>

										<div class="col-lg-6" style="padding:0 20px 0 10px; margin-top: 15px;">
											<label>No Identitas</label>
											<div class="row">
												<div class="col-lg-4">
													<input id="ktp" name="ktp" value="<?php echo $r['nid_ktp']; ?>" maxlength="16" onkeydown="return isNumber(event);" placeholder="KTP" type="text" class="form-control" />
												</div>
												<div class="col-lg-4">
													<input id="sim" name="sim" value="<?php echo $r['nid_sim']; ?>" maxlength="12" onkeydown="return isNumber(event);" placeholder="SIM (Opsional)" type="text"  class="form-control" />
												</div>
												<div class="col-lg-4">
													<input id="lain" name="lain" value="<?php echo $r['nid_lain']; ?>"  maxlength="20" onkeydown="return isNumber(event);" placeholder="Lainnya (Opsional)" type="text" class="form-control"/>
												</div>
											</div>

											<select style="margin-top: 5px;" class="form-control" name="nid" id="nid">
												<option value="<?php echo $r['nid_type']; ?>"><?php echo $r['nid_type']; ?></option>
												<option value="KTP">KTP</option>
												<option value="SIM">SIM</option>
												<option value="PASPOR">PASPOR</option>
												<option value="Pelajar">Kartu Pelajar/Mahasiswa</option>
												<option value="Lainnya">Lainnya</option>
											</select>
										</div>
									</div>

									<div class="row">
										<div class="col-lg-4" style="padding:0 10px 0 20px; margin-top: 15px;">
											<label>Lapak</label>
											<select class="form-control chzn-select" name="lapak" id="lapak">
												<?php 
													$lapak 	= mysql_query("select lapak_id, lapak_name, lapak_type from lapak where lapak_id='".$r['lapak_id']."'");
													while($d = mysql_fetch_array($lapak)){
														echo '<option value="'.$d['lapak_id'].'">'.$d['lapak_name'].' / '.$d['lapak_type'].'</option>';
													}
													$sql 		= mysql_query("select lapak_id, lapak_name, lapak_type from lapak where lapak_status = 'Kosong' or lapak_status is NULL ");
													while($data = mysql_fetch_array($sql)){?>
													<option value="<?php echo $data['lapak_id'];?>"><?php echo $data['lapak_name'].' / '.$data['lapak_type'];?></option>
												<?php } ?>
											</select>
										</div>

										<div class="col-lg-4" style="padding:0 10px 0 10px; margin-top: 15px;">
											<label>Jenis Jualan</label>
											<select class="form-control" name="type" id="type">
												<!-- <option value="<?php echo $r['merchant_type']; ?>"><?php echo $r['merchant_type']; ?></option> -->
												<option value="Sayur" <?php echo $r['merchant_type'] == "Sayur" ? 'Selected' : ''; ?> >Sayur</option>
												<option value="Buah" <?php echo $r['merchant_type'] == "Buah" ? 'Selected' : ''; ?> >Buah</option>
												<option value="Sembako" <?php echo $r['merchant_type'] == "Sembako" ? 'Selected' : ''; ?> >Sembako</option>
												<option value="Lainnya" <?php echo $r['merchant_type'] == "Lainnya" ? 'Selected' : ''; ?> >Lainnya</option>
											</select>
										</div>

										<div class="col-lg-4" style="padding:0 20px 0 10px; margin-top: 15px;">
											<label>Asal Pasar</label>
											<select class="form-control chzn-select" name="asal_pasar" id="asal_pasar" >
												<!-- <option value="0" selected disabled>-- Pilih Asal Pasar --</option> -->
												<option value="Belum Pernah" <?php echo $r['asal_pasar'] == "Belum Pernah" ? 'Selected' : ''; ?> >Belum Pernah</option>
												<option value="Pasar Osowilangun" <?php echo $r['asal_pasar'] == "Pasar Osowilangun" ? 'Selected' : ''; ?> >Pasar Osowilangun</option>
												<option value="Pasar Pandegiling" <?php echo $r['asal_pasar'] == "Pasar Pandegiling" ? 'Selected' : ''; ?> >Pasar Pandegiling</option>
												<option value="Pasar Keputran" <?php echo $r['asal_pasar'] == "Pasar Keputran" ? 'Selected' : ''; ?> >Pasar Keputran</option>
												<option value="Pasar Mangga Dua" <?php echo $r['asal_pasar'] == "Pasar Mangga Dua" ? 'Selected' : ''; ?> >Pasar Mangga Dua</option>
												<option value="Pasar Pabean" <?php echo $r['asal_pasar'] == "Pasar Pabean" ? 'Selected' : ''; ?> >Pasar Pabean</option>
												<option value="Pasar Wonokusumo" <?php echo $r['asal_pasar'] == "Pasar Wonokusumo" ? 'Selected' : ''; ?> >Pasar Wonokusumo</option>
												<option value="Pasar Lainnya" <?php echo $r['asal_pasar'] == "Pasar Lainnya" ? 'Selected' : ''; ?> >Pasar Lainnya</option>
											</select>
										</div>
									</div>
									
									<div class="row">
										<div class="col-lg-12" style="padding:0 20px 0 20px; margin-top: 30px;">
											<button type="submit" class="btn btn-block btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;Edit Data</button>
										</div>
									</div>
								</fieldset>
							</form> 

							<div class="row">
								<div class="col-lg-12" style="padding:0 20px 0 20px; margin-top: 10px;">
									<a style="text-decoration: none;" href="htmltopdf/permohonan_lapak.php?id=<?php echo $id;?>" target="_blank">
										<button style="margin-top:10px;" class="btn btn-block btn-info" type="button">
											<i class="fa fa-print"></i>&nbsp;&nbsp;Cetak Surat Permohonan
										</button>
									</a>
								</div>

								<div class="col-lg-6" style="padding:0 20px 0 20px; margin-top: 10px;">
									<?php 
										if($r['req_status']!='Disetujui'){
											echo '<center><a style="text-decoration: none;" data-toggle="modal" data-target="#modalCancel" href="#">
												<button style="margin-top: 10px;" class="btn btn-block btn-danger"><i class="fa fa-times fa-fw"></i>Batalkan</button>
											</a></center>';
										}
										else{
											echo '';
										}
									?>
								</div>

								<div class="col-lg-6" style="padding:0 20px 0 20px; margin-top: 10px;">
									<?php 
										if($r['req_status']!='Disetujui'){
											echo '<center>
											<a style="text-decoration: none;" href="register_acc2.php?id='.$id.'">
												<button style="margin-top:10px;" class="btn btn-block btn-success"><i class="fa fa-arrow-right"></i>&nbsp;&nbsp;Lanjut Form Persetujuan</button>
											</a></center>';
										}
										else{
											echo '';
										}
									?>
								</div>
							</div>
                        </div>
                    </div>
                </div>
			</div>
        </div>
    </div>

	<!-- Modal Cancel -->
			<div class="modal fade" id="modalCancel" tabindex="-1" role="dialog" aria-labelledby="modalCancelLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header bg-primary text-white" style="border-top-left-radius: 5px; border-top-right-radius: 5px;">
							<h5 class="modal-title" id="modalCancelLabel"><b>KONFIRMASI BATAL PENDAFTARAN</b></h5>
							<button style="margin-top: -20px;" type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<p>Apakah Anda yakin ingin membatalkan pendaftaran pedagang?</p>
							<div class="bg-primary" 
								style="color:#fff; padding:4px; border-radius:5px; display:inline-block;">
								<i class="fa fa-user fa-fw d-in"></i>&nbsp;<?php echo $r['req_name']; ?>
							</div>
							<div class="bg-primary" 
								style="color:#fff; padding:4px; border-radius:5px; display:inline-block;">
								<?php 
									$lapak 	= executeScalar("select lapak_name from lapak where lapak_id='".$r['lapak_id']."' "); 
								?>
								<i class="fa fa-th fa-fw d-in"></i>&nbsp;<?php echo $lapak; ?>
							</div>
							<br><br>
							<p><b>Catatan:</b> Data pendaftaran yang dibatalkan tidak dapat dikembalikan lagi!</p>
						</div>
						<div class="modal-footer d-flex justify-content-between">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
							<a href="register_action.php?task=cancel2&id=<?php echo $r['req_id'] ?>" class="btn btn-primary">Ya, batalkan</a>
						</div>
					</div>
				</div>
			</div>

	<script>
		$(document).ready(function(){
			// Auto Refresh Page
			$("#notifArea").html(alertLoadProcess);
			$('#Area1').load("register_table.php",function(){clearNotif();});
			setTimeout('$("html").removeClass("js")',1000); 
		});
		function print(){
			window.location=('weighing_action.php?task=merge&id=<?php echo $r['merchant_id']; ?>');
		}
		function clearNotif(){$("#notifArea").html("");}
    </script>
	
	<?php }?>
    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="js/plugins/metisMenu/metisMenu.min.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>
	<script src="js/plugins/chosen/chosen.jquery.js"></script>
	<script type="text/javascript">
    	$(".chzn-select").chosen({"search_contains": true,"width":"100%", "no_results_text":"Hasil tidak ditemukan !"});
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
