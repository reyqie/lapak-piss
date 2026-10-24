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
    <title>Tambah Lapak Pedagang | PISS</title>

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
                            <i class="fa fa-pencil fa-fw"></i> Tambah Lapak Pedagang
                        </div>
                        <div class="panel-body">
							<div class="alert alert-warning" role="alert">
								<table>
									<tr>
										<td style="font-size:20px; padding-right: 10px;">
											<i class="fa fa-info"></i> 
										</td>
										<td>
											<p style="font-size: 12px; padding-top:10px;"> Tambah lapak hanya bisa untuk pedagang dengan status 'Aktif'.</p>
										</td>
									</tr>
								</table>
							</div>
                            <form action="register_action.php?task=insert2" id="formRegister" name = "formRegister" method="POST" class="form-horizontal">
								<div class="col-lg-6" style="padding:10px; margin-top:-20px; margin-bottom:-10px;">
									<div class="form-group" style="padding:10px;">
										<label>Pedagang</label>
										<select class="form-control chzn-select" name="merchant" id="merchant">
											<option value="">- Pilih Pedagang -</option>
											<?php 
												$sql1 		= mysql_query("select merchant_id, merchant_name, merchant_nick, merchant_type from merchant where merchant_status = 'Aktif' order by merchant_name");
												while($d1 = mysql_fetch_array($sql1))
											{?>
												<option value="<?php echo $d1['merchant_id'];?>"><?php echo $d1['merchant_name'].' / '.$d1['merchant_nick'].' ('.$d1['merchant_id'].')';?></option>
											<?php } ?>
										</select>
										<br />
									</div>
								</div>
								<div class="col-lg-3" style="padding:10px; margin-top:-20px; margin-bottom:-10px;">
									<div class="form-group" style="padding:10px;">
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
								</div>
								<div class="col-lg-3" style="padding:10px; margin-top:5px; margin-bottom:-20px;">
									<div class="form-group" style="padding:10px;">
										<center><button type="submit" class="btn btn-block btn-primary"><i class="fa fa-save fa-lg"></i>&nbsp;&nbsp;Simpan</button></center>
									</div>
								</div>
							</form> 
                        </div>
                    </div>
                </div>

                <div class="col-md-12" style="margin-top:10px;">
					<div class="panel panel-primary" style="overflow-x: auto">
						<div class="panel-heading">
							<i class="fa fa-user fa-fw"></i> Data Tambah Lapak Pedagang
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
			$('#Area1').load("register_table2.php",function(){clearNotif();});
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