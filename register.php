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
    <title>Pendaftaran Pedagang | PISS</title>

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
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-pencil fa-fw"></i> Form Pendaftaran Pedagang
                        </div>
                        <div class="panel-body">
                            <form action="register_action.php?task=insert"  id="formRegister" name = "formRegister" method="POST" class="form-horizontal">
								<fieldset>
									<div class="row">
										<div class="col-lg-6" style="padding:0 10px 0 20px">
											<label>Nama</label>
											<input id="name1" name="name1" placeholder="Nama Sesuai Ktp" type="text" class="form-control" autofocus="autofocus" required>    
											<input style="margin-top: 5px;" id="name2" name="name2" placeholder="Nama Alias" type="text" class="form-control">          
										</div>

										<div class="col-lg-6" style="padding:0 20px 0 10px;">
											<label>Alamat</label>
											<input id="adrs1" name="adrs1" placeholder="Alamat Sesuai KTP" type="text" class="form-control" required/>
											<input style="margin-top: 5px;" id="adrs2" name="adrs2" placeholder="Alamat Surat (Opsional)" type="text" class="form-control" />
										</div>
									</div>

									<div class="row">
										<div class="col-lg-6" style="padding:0 10px 0 20px; margin-top: 15px;">
											<label>Telepon</label>
											<input id="tlp1" name="tlp1" placeholder="Telepon Rumah" maxlength="13" onkeydown="return isNumber(event);" type="text" class="form-control" />
											<input style="margin-top: 5px;" id="tlp2" name="tlp2" placeholder="Handphone (HP)" maxlength="13" onkeydown="return isNumber(event);" type="text" class="form-control" />
										</div>

										<div class="col-lg-6" style="padding:0 20px 0 10px; margin-top: 15px;">
											<label>No Identitas</label>
												<div class="row">
													<div class="col-lg-4">
														<input id="ktp" name="ktp" placeholder="KTP" maxlength="16" onkeydown="return isNumber(event);" type="text" class="form-control" />
													</div>
													<div class="col-lg-4">
														<input id="sim" name="sim" placeholder="SIM (Opsional)" maxlength="12" onkeydown="return isNumber(event);" type="text"  class="form-control" />
													</div>
													<div class="col-lg-4">
														<input id="lain" name="lain" placeholder="Lainnya (Opsional)"  maxlength="20" onkeydown="return isNumber(event);" type="text" class="form-control"/>
													</div>
												</div>
												
											<select style="margin-top: 5px;" class="form-control" name="nid" id="nid" required>
												<option value="">Jenis Identitas Yang Diisi</option>
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
											<select class="form-control chzn-select" name="lapak" id="lapak" required>
												<option value="">- Pilih Lapak -</option>
												<?php 
													$sql = mysql_query("
														SELECT 
															l.lapak_id, 
															l.lapak_name, 
															l.lapak_type 
														FROM lapak l 
														JOIN block b ON l.block_id = b.block_id 
														WHERE (l.lapak_status = 'Kosong' OR l.lapak_status IS NULL)
														AND b.status_block = 'active'
													");
													while($data = mysql_fetch_array($sql))
												{?>
													<option value="<?php echo $data['lapak_id'];?>"><?php echo $data['lapak_name'].' / '.$data['lapak_type'];?></option>
												<?php } ?>
											</select>
										</div>

										<div class="col-lg-4" style="padding:0 10px 0 10px; margin-top: 15px;">
											<label>Jenis Pedagang</label>
											<select class="form-control " name="kat_merchant" id="kat_merchant" >
												<option value="0" selected disabled>-- Pilih Jenis Pedagang --</option>
												<option value="Tetap">Tetap</option>
												<option value="Trial Lapak">Trial Lapak</option>
												<option value="Trial Lapak Jalan">Trial Lapak Jalan</option>
											</select>
										</div>

										<div class="col-lg-4" style="padding:0 20px 0 10px; margin-top: 15px;">
											<label>Asal Pasar</label>
											<select class="form-control" name="asal_pasar" id="asal_pasar" >
												<option value="0" selected disabled>-- Pilih Asal Pasar --</option>
												<option value="Belum Pernah">Belum Pernah</option>
												<option value="Pasar Osowilangun">Pasar Osowilangun</option>
												<option value="Pasar Pandegiling">Pasar Pandegiling</option>
												<option value="Pasar Keputran">Pasar Keputran</option>
												<option value="Pasar Mangga Dua">Pasar Mangga Dua</option>
												<option value="Pasar Pabean">Pasar Pabean</option>
												<option value="Pasar Wonokusumo">Pasar Wonokusumo</option>
												<option value="Pasar Lainnya">Pasar Lainnya</option>
											</select>
										</div>
									</div>
									
									<div class="row">
										<div class="col-lg-12" style="padding: 0 20px; margin-top: 20px; margin-bottom: 10px;">
											<center><button type="submit" class="btn btn-block btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;Simpan</button></center>
										</div>
									</div>
								</fieldset>
							</form> 
                        </div>
                    </div>
                </div>

                <div class="col-md-12" style="margin-top:10px;">
					<div class="panel panel-primary" style="overflow-x: auto">
						<div class="panel-heading">
							<i class="fa fa-user fa-fw"></i> Data Pendaftaran Pedagang
						</div>
						<div class="panel-body">
							<div id="Area1">
								<div class="alert alert-info" onclick="clearNotif()">
									<center><h3><i class="fa fa-spinner fa-spin"></i> Loading...</h3></center>
								</div>
							</div>
						</div>
					</div>
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
	<script src="js/plugins/chosen/chosen.jquery.js"></script>
	<script type="text/javascript">
    	$(".chzn-select").chosen({"search_contains": true,"width":"100%", "no_results_text":"Hasil tidak ditemukan !"});
    </script>
	<!-- Sweet Alert -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js"></script>
	<script>
		$(document).ready(function(){
            //Modal Password
            $('#modalPassword').on('shown.bs.modal', function (e) {
                $("#notifArea").html(alertLoadProcess);
                $("#data_password").load("password.php",function(){clearNotif();});
            })
        });
	</script>
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