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
		<title>Lapak | PISS</title>

        <?php echo headScript(); ?>

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
		<script src="js/jquery.min.js"></script>
		<!-- input number -->
		<link href="js/touchpin/jquery.bootstrap-touchspin.css" rel="stylesheet" type="text/css" media="all">
		<script src="js/touchpin/jquery.bootstrap-touchspin.js"></script>
		<script>
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

			<!-- Start Main Content ============================================================================================================== -->
			<div id="page-wrapper">
				<br><br><br><br>
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<i class="fa fa-pencil fa-fw"></i> Tambah Data Lapak
							</div>
							<div class="panel-body">
								<form class="form-horizontal" id="formLapak" name = "formLapak" method="POST" action="lapak_action.php?task=insert">
									<fieldset>
										<label>Blok</label>
										<select class="form-control" name="block" id="block" autofocus="autofocus" required>
											<option value="">- Pilih Blok -</option>
											<?php 
												$sql 		= mysql_query("select block_id from block where block_now < block_max and status_block = 'active' order by block_id");
												while($data = mysql_fetch_array($sql)){?>
												<option value="<?php echo $data['block_id'];?>"><?php echo $data['block_id'];?></option>
											<?php } ?>
										</select>
										<div class="row">
											<div class="col-md-6" style="margin-top:20px;">
												<label>Panjang</label><sup> ( m )</sup>
												<input class="form-control" id="p" name="p" type="number" placeholder="0" required />
											</div>
											<div class="col-md-6" style="margin-top:20px;">
												<label>Lebar</label><sup> ( m )</sup>
												<input class="form-control" id="l" name="l" type="number" placeholder="0" required />
											</div>
										</div>
										<div class="form-group" style="padding:0 15px; margin-top: 15px;">
											<label>Harga</label><sup> ( /m<sup>2</sup> - /tahun )</sup>
											<input class="form-control" id="price" name="price" type="text" placeholder="0" required />
											<script>
												$("input[name='price']").TouchSpin({
													min: 0,
													max: 10000000,
													step: 100000,
													postfix: 'Rupiah',
													verticalbuttons: true,
													verticalupclass: 'glyphicon glyphicon-plus',
													verticaldownclass: 'glyphicon glyphicon-minus'
												});
											</script>
										</div>
										<div class="form-group" style="padding:0 15px; margin-top: 15px;">
											<label>Masa Pakai</label><sup> ( tahun )</sup>
											<input class="form-control" id="dur" name="dur" type="text" placeholder="0" required />
											<script>
												$("input[name='dur']").TouchSpin({
												verticalbuttons: true,
													postfix: 'Tahun',
												verticalupclass: 'glyphicon glyphicon-plus',
												verticaldownclass: 'glyphicon glyphicon-minus'
												});
											</script>
										</div>
										<div class="form-group" style="padding:0 15px; margin-top: 15px;">
											<label>Jenis</label>
											<select class="form-control" name="type" id="type" required>
												<option value="">- Pilih Jenis Lapak -</option>
												<option value="Sayur">Sayur</option>
												<option value="Buah">Buah</option>
												<option value="Lainnya">Lainnya</option>
											</select>
										</div>
										<div class="form-group" style="padding:0 15px; margin-top: 25px;">
											<center><button type="submit" class="btn btn-block btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;Simpan</button></center>
										</div>
									</fieldset>
								</form> 
							</div>
						</div>
					</div>

					<div class="col-md-12" style="margin-top:10px;">
						<div class="panel panel-primary" style="overflow-x: auto">
							<div class="panel-heading">
								<i class="fa fa-building fa-fw"></i> Data Lapak
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
			<!-- End Main Content ============================================================================================================== -->
		</div>

		<!-- Modal Edit -->
		<div id="modalEditLapak" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<!-- Meload modal "lapak_modal.php" file -->
				</div>
			</div>
		</div>

		<script>
			$(document).ready(function(){
				// Auto Refresh Page
				$("#notifArea").html(alertLoadProcess);
				$('#Area1').load("lapak_table.php",function(){clearNotif();});
				setTimeout('$("html").removeClass("js")',1000); 
			});
			function clearNotif(){$("#notifArea").html("");}
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