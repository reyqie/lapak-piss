<?php
	session_start();
	include "connection.php";
	include "components/role_session.php";

	function headScript(){
		$headScript=file_get_contents("headScript.html");
		return $headScript;
	}

	$merchant 	= executeScalar("select count(merchant_id) from merchant");
	$lapak 		= executeScalar("select count(lapak_id) from lapak");
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
    <title>Laporan Data Pedagang | PISS</title>

    <?php echo headScript(); ?>
	
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	<script>
		/* hide all elements & show preloader*/
		document.documentElement.className += 'js';
		
		/* display variabel */
		var alertLoadProcess = "<span class='alert alert-info' onclick='clearNotif()'><i class='fa fa-spinner fa-spin'></i> Loading...</span>";
	</script>
</head>
<body>
    <div id="wrapper">
    <?php include "components/sidebar.php" ?>

        <div id="page-wrapper">
        <br><br><br><br>
			<div class="row">
				<div class="col-lg-6">
					<br />
					<div id="Area1"><div class="alert alert-info" onclick="clearNotif()"><center><h3><i class="fa fa-spinner fa-spin"></i> Loading...</h3></center></div></div>
					<div class="panel panel-primary">
						<div class="panel-heading">
                            <i class="fa fa-file-text-o fa-fw"></i> Laporan Data Pedagang Per Jenis Jualan
                        </div>
						<div class="panel-body">
							<form class="form-horizontal" id="reportMerchant" name = "reportMerchant" method="POST">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group" style="padding:0 15px; margin-top:-10px;">
											<label>Jenis Pedagang</label>
											<select class="form-control" name="mtype" id="mtype">
												<option value="">- Pilih Jenis Pedagang -</option>
												<option value="Semua">Semua</option>
												<option value="Sayur">Sayur</option>
												<option value="Buah">Buah</option>
												<option value="Lainnya">Lainnya</option>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group" style="padding: 0 15px; margin-top:-10px;">
											<label>Status Pedagang</label>
											<select class="form-control" name="sts" id="sts" required>
												<option value="">- Pilih Status -</option>
												<option value="Semua">Semua</option>
												<option value="Aktif">Aktif</option>
												<option value="Tidak Aktif">Tidak Aktif</option>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group" style="margin-top:5px; margin-right:0px; margin-left:0px">
												<button type="submit" class="btn btn-primary btn-block"  onclick="setAction('pdf')"><i class="fa fa-file-pdf-o fa-lg" style="font-size: 16px;"></i>&nbsp;&nbsp;Print PDF</button>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group" style="margin-top:5px; margin-left:0px; margin-right: 0px">
											<button type="submit" class="btn btn-success btn-block" style="background-color: #008000;" onclick="setAction('excel')"><i class="fa fa-file-excel-o fa-lg" style="font-size: 16px;"></i>&nbsp;&nbsp;Export Excel</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<br />
					<div id="Area2"><div class="alert alert-info" onclick="clearNotif()"><center><h3><i class="fa fa-spinner fa-spin"></i> Loading...</h3></center></div></div>
					<div class="panel panel-primary">
						<div class="panel-heading">
                            <i class="fa fa-file-text-o fa-fw"></i> Laporan Data Pedagang Per Block
                        </div>
						<div class="panel-body">
							<form class="form-horizontal" id="reportMerchant2" name = "reportMerchant2" method="POST">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group" style="padding: 0 15px; margin-top:-10px;">
											<label>Blok</label>
											<select class="form-control" name="block" id="block" required>
												<option value="">- Pilih Block -</option>
												<?php 
													$sql 		= mysql_query("select block_id from block");
													while($data = mysql_fetch_array($sql)){?>
													<option value="<?php echo $data['block_id'];?>"><?php echo $data['block_id'];?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group" style="margin-top:5px; margin-right:0px; margin-left:0px">
												<button type="submit" class="btn btn-primary btn-block"  onclick="setAction('pdf')"><i class="fa fa-file-pdf-o fa-lg" style="font-size: 16px;"></i>&nbsp;&nbsp;Print PDF</button>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group" style="margin-top:5px; margin-left:0px; margin-right: 0px">
											<button type="submit" class="btn btn-success btn-block" style="background-color: #008000;" onclick="setAction('excel')"><i class="fa fa-file-excel-o fa-lg" style="font-size: 16px;"></i>&nbsp;&nbsp;Export Excel</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
	
    <!-- jQuery -->
    <script src="js/jquery.js"></script>
	<!-- highcharts -->
	<script src="highcharts/js/highcharts.js"></script>
	<script src="highcharts/js/highcharts-more.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="js/plugins/metisMenu/metisMenu.min.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>
	<script>
		$(document).ready(function(){
			$("#notifArea").html(alertLoadProcess);
			setTimeout('$("html").removeClass("js")',1000); 
			loadChart();
			
			//Modal Password
			$('#modalPassword').on('shown.bs.modal', function (e) {
				$("#notifArea").html(alertLoadProcess);
				$("#data_password").load("password.php",function(){clearNotif();});
			})
		});
		//Meload Chart
		function loadChart(){
			$("#notifArea").html(alertLoadProcess);
			$("#Area1").load("line_report_merchant.php",function(){clearNotif();});
			$("#Area2").load("line_report_merchant2.php",function(){clearNotif();});
			//$("#Area5").load("line_block5.php",function(){clearNotif();});
		}
		function clearNotif(){$("#notifArea").html("");}
    </script>
	<script>
		function setAction(type) {
			var form1 = document.getElementById("reportMerchant");
			var form2 = document.getElementById("reportMerchant2");
			if (type === 'pdf') {
				form1.action = "htmltopdf/laporan_pedagang.php";
				form2.action = "htmltopdf/laporan_pedagang2.php";
				form1.target = "_blank";
				form2.target = "_blank";
			} else if (type === 'excel') {
				form1.action = "exportExcel/exportLaporanPedagang.php";
				form2.action = "exportExcel/exportLaporanPedagang2.php";
				form1.target = "_self";
				form2.target = "_self";
			}
		}
	</script>
</body>
</html>