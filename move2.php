<?php
	session_start();
	include "connection.php";
	include "components/role_session.php";

	function headScript(){
		$headScript=file_get_contents("headScript.html");
		return $headScript;
	}
	
	$m1		= $_POST['m1'];
	$m2		= $_POST['m2'];
	$type1 	= executeScalar("select merchant_type from merchant where merchant_id = '".$m1."'");
	$type2 	= executeScalar("select merchant_type from merchant where merchant_id = '".$m2."'");
	if($m1==$m2){
		// Alert Information
		$_SESSION['success'] = false;
		$_SESSION['title'] = 'Gagal';
		$_SESSION['message'] = "Pedagang yg sama tidak bisa bertukar tempat";
		// echo "<script>window.history.back()</script>";
		echo "<script>window.location=('move_select2.php')</script>";
		exit();
	}
	elseif($type1!=$type2){
		// Alert Information
		$_SESSION['success'] = false;
		$_SESSION['title'] = 'Gagal';
		$_SESSION['message'] = "Jenis pedagang harus sama, tidak boleh berbeda";
		// echo "<script>window.history.back()</script>";
		echo "<script>window.location=('move_select2.php')</script>";
		exit();
	}
	$name1 	= executeScalar("select merchant_name from merchant where merchant_id = '".$m1."'");
	$name2 	= executeScalar("select merchant_name from merchant where merchant_id = '".$m2."'");
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
    <title>Pertukaran Lapak | PISS</title>

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
		var alertLoadProcess = "<span class='alert alert-info' onclick='clearNotif()'><i class='fa fa-spinner fa-spin'></i> Loading...</span>";
    </script>
</head>
<body>
    <div id="wrapper">
		<?php include"components/sidebar.php" ?>

        <div id="page-wrapper">
            <div class="row">
				<br><br><br><br>
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-retweet fa-fw"></i> Data Pertukaran Lapak Antar Pedagang
                        </div>
                        <div class="panel-body">
                            <?php 
							?>
							<form class="form-horizontal" id="formHome" name="formHome" method="POST" action="move_action.php?task=move2" >
								<div class="row">
									<div class="col-md-6">
										<div class="panel panel-primary">
											<div class="panel-heading panel-primary">
												<i class="fa fa-user"></i>&nbsp;&nbsp;Pedagang 1
											</div>
											<div class="panel-body">
												<div class="form-group" style="padding:10px; margin-top:-10px;">
													<label>Nama Pedagang</label>
													<input type="text" class="form-control" id="m1" name="m1" value="<?php echo $name1; ?>" disabled>
												</div>
												<div class="form-group" style="padding:10px; margin-top:-10px;">
													<label>Lapak</label>
													<select class="form-control" name="lapak1" id="lapak1" required>
														<option value="">- Lapak Yg Akan Dipindah -</option>
														<?php 
															$sql2 = mysql_query("select l.lapak_id, l.lapak_name from lapak l, rent r where l.lapak_id = r.lapak_id and r.merchant_id = '".$m1."' and (r.rent_sts2 != 'Pindah' && r.rent_sts2 != 'Batal')");
															while($r2 = mysql_fetch_array($sql2)){
														?>
															<option value="<?php echo $r2['lapak_id'];?>"><?php echo $r2['lapak_name'];?></option>
														<?php } ?>
													</select>
												</div>
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="panel panel-success">
											<div class="panel-heading" style="background-color: green; color: #fff;">
												<i class="fa fa-user"></i>&nbsp;&nbsp;Pedagang 2
											</div>
											<div class="panel-body">
												<div class="form-group" style="padding:10px; margin-top:-10px;">
													<label>Nama Pedagang</label>
													<input type="text" class="form-control" id="m2" name="m2" value="<?php echo $name2; ?>" disabled>
												</div>
												<div class="form-group" style="padding:10px; margin-top:-10px;">
													<label>Lapak</label>
													<select class="form-control" name="lapak2" id="lapak2" required>
														<option value="">- Lapak Yg Akan Dipindah -</option>
														<?php 
															$sql3 = mysql_query("select l.lapak_id, l.lapak_name from lapak l, rent r where l.lapak_id = r.lapak_id and r.merchant_id = '".$m2."' and (r.rent_sts2 != 'Pindah' && r.rent_sts2 != 'Batal')");
															while($r3 = mysql_fetch_array($sql3)){
														?>
															<option value="<?php echo $r3['lapak_id'];?>"><?php echo $r3['lapak_name'];?></option>
														<?php } ?>
													</select>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="form-group" style="padding:0 15px; margin-top:-10px;">
									<center><button type="submit" class="btn btn-block btn-primary"><i class="fa fa-retweet"></i>&nbsp;&nbsp;Tukar Lapak</button></center>
								</div>
							</form>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-lg-8" style="margin-top:20px;">
                    <h3>Histori Pindah Lapak</h3>
					<div id="Area2">
						<div class="alert alert-info" onclick="clearNotif()">
							<center><h3><i class="fa fa-spinner fa-spin"></i> Loading...</h3></center>
						</div>
					</div>
                </div> -->
            </div>
        </div>
    </div>

	<script>
		$(document).ready(function(){
			// Auto Refresh Page
			$("#notifArea").html(alertLoadProcess);
			$('#Area1').load("merchant_table3.php",function(){clearNotif();});
			$('#Area2').load("move_table.php",function(){clearNotif();});
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
</body>
</html>
