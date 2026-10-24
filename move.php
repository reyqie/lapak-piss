<?php
	session_start();
	include "connection.php";
	include "components/role_session.php";
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
    <title>Pindah Lapak | PISS</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">
    <!-- Timeline CSS -->
    <link href="css/plugins/timeline.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/sb-admin-2.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<!-- CSS Search dropdown -->
	<link href="css/plugins/chosen/chosen.css" rel="stylesheet" />
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
		var alertLoadProcess = "<span class='alert alert-info' onclick='clearNotif()'><i class='fa fa-spinner fa-spin'></i> Loading...</span>";
    </script>
</head>
<body>
    <div id="wrapper">
	<?php include "components/sidebar.php" ?>

		<div id="page-wrapper">
		<br><br><br><br>
            <div class="row">
                <div class="col-lg-4" style="padding:10px;">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-plus fa-fw"></i> Data Perpindahan Lapak
                        </div>
                        <div class="panel-body">
                            <?php $sql	= mysql_query("select * from merchant where merchant_id = '".$_GET['id']."'");
							while ($r = mysql_fetch_array($sql)){ ?>
							<form action="move_action.php?task=move1&id=<?php echo $r['merchant_id'];?>"  class="form-horizontal" id="formHome" name = "formHome" method="POST">
								<fieldset>
									<div class="form-group" style="padding:10px; margin-top:-10px;">
										<label>Nama Pedagang</label>
										<input type="text" class="form-control" id="name" name="name" value="<?php echo $r['merchant_name']; ?>" disabled>
									</div>
									<div class="form-group" style="padding:10px; margin-top:-10px;">
										<label>Lapak Awal</label>
										<select class="form-control chzn-select" name="lapak1" id="lapak1">
											<option value="">- Pilih Lapak -</option>
											<?php 
												$sql2 = mysql_query("select l.lapak_id, l.lapak_name, l.lapak_type from lapak l, rent r where 
												l.lapak_id = r.lapak_id and r.merchant_id = '".$r['merchant_id']."' and (rent_sts2 != 'Batal' && rent_sts2 != 'Pindah')");
												while($r2 = mysql_fetch_array($sql2))
											{?>
												<option value="<?php echo $r2['lapak_id'];?>"><?php echo $r2['lapak_name'].' / '.$r2['lapak_type'];?></option>
											<?php } ?>
										</select>
									</div>
									<div class="form-group" style="padding:10px; margin-top:-10px;">
										<label>Lapak Tujuan</label>
										<select class="form-control chzn-select" name="lapak2" id="lapak2">
											<option value="">- Pilih Lapak -</option>
											<?php 
												$sql3 = mysql_query("select lapak_id, lapak_name, lapak_type from lapak where lapak_status is null OR lapak_status = 'Kosong' ");
												while($r3 = mysql_fetch_array($sql3))
											{?>
												<option value="<?php echo $r3['lapak_id'];?>"><?php echo $r3['lapak_name'].' / '.$r3['lapak_type'];?></option>
											<?php } ?>
										</select>
									</div>
									<div class="form-group" style="padding:10px; margin-top:-10px;">
										<div class="row">
											<div class="col-md-6">
												<label>Cicilan</label>
												<select class="form-control" name="ins" id="ins" required>
													<option value="">- Pilih Cicilan -</option>
													<?php 
														$sql1 		= mysql_query("select * from instalment order by instalment_name");
														while($d1 = mysql_fetch_array($sql1)){
														?>
														<option value="<?php echo $d1['instalment_id'];?>"><?php echo $d1['instalment_name'].' / '.$d1['instalment_count'].'x';?></option>
													<?php } ?>
												</select>
											</div>
											<div class="col-md-6">
												<label>Bunga Pertahun (%)</label>
												<input class="form-control" id="interest" name="interest" type="number" value="0" required />
											</div>
										</div>
									</div>
									<div class="form-group" style="padding:10px; margin-top:-10px; margin-bottom:-10px;">
										<center><button type="submit" class="btn btn-outline btn-block btn-primary">Simpan</button></center>
									</div>
								</fieldset>
							</form>
							<?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8" style="margin-top:20px;">
                    <h3>Histori Pindah Lapak</h3>
					<div id="Area2">
						<div class="alert alert-info" onclick="clearNotif()">
							<center><h3><i class="fa fa-spinner fa-spin"></i> Loading...</h3></center>
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
			$('#Area2').load("move_table.php",function(){clearNotif();});
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
	<!-- Search Dropdown -->
	<script src="js/plugins/chosen/chosen.jquery.js"></script>
	<script type="text/javascript">
    	$(".chzn-select").chosen({"search_contains": true,"width":"100%", "no_results_text":"Hasil tidak ditemukan !"});
    </script>
</body>
</html>
