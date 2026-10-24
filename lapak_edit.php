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
    <title>Admin</title>

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
    </script>
</head>
<body>
    <div id="wrapper">
		<?php include "components/sidebar.php" ?>

        <div id="page-wrapper">
			<br><br><br><br>
            <div class="row">
                <div class="col-lg-3" style="padding:10px;">
                    <br /><br /><br />
					<div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-pencil fa-fw"></i> Update Data Lapak
                        </div>
                        <div class="panel-body">
							<?php 
								$id		= $_GET['id'];
								$edit	= mysql_query("select * from lapak where lapak_id = '".$id."'");
								while($r = mysql_fetch_array($edit)){
									$sts		= '';
									if($r['lapak_status']==null){
										$sts		= 'Kosong';
									}
							?>
                            <form class="form-horizontal" id="formlapak" name="formlapak" method="POST" action="lapak_action.php?task=update&id=<?php echo $r[0]; ?>">
								<fieldset>
									<div class="row">
										<div class="col-md-6" style="padding:10px; margin-top: -20px;">
											<label>Blok</label>
											<select class="form-control" name="block" id="block" disabled>
												<option value="<?php echo $r['block_id']; ?>"><?php echo $r['block_id']; ?></option>
												<?php 
													$sql 		= mysql_query("select block_id from block where block_now < block_max");
													while($data = mysql_fetch_array($sql)){?>
													<option value="<?php echo $data['block_id'];?>"><?php echo $data['block_id'];?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-6" style="padding:10px; margin-top: -20px;">
											<label>No</label>
											<input class="form-control" id="no" name="no" type="number" value="<?php echo $r['lapak_no']; ?>" disabled/>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6" style="padding:10px; margin-top: -10px;">
											<label>Panjang</label>
											<input class="form-control" id="p" name="p" type="number" step="0.01" value="<?php echo $r['p']; ?>" required />
										</div>
										<div class="col-md-6" style="padding:10px; margin-top: -10px;">
											<label>Lebar</label>
											<input class="form-control" id="l" name="l" type="number" step="0.01" value="<?php echo $r['l']; ?>" required />
										</div>
									</div>
									<div class="form-group" style="padding:10px; margin-top: -20px;">
										<label>Harga Per (M<sup>2</sup>)</label>
										<input class="form-control" id="price" name="price" type="text" value="<?php echo $r['lapak_price']; ?>" required />
										<script>
											$("input[name='price']").TouchSpin({
											  verticalbuttons: true,
											  min: 0,
												max: 10000000,
												step: 10000,
												postfix: 'Rupiah',
											  verticalupclass: 'glyphicon glyphicon-plus',
											  verticaldownclass: 'glyphicon glyphicon-minus'
											});
										</script>
									</div>
									<div class="form-group" style="padding:10px; margin-top: -20px;">
										<label>Masa Pakai</label>
										<input class="form-control" id="dur" name="dur" type="text" value="<?php echo $r['duration']; ?>" required />
										<script>
											$("input[name='dur']").TouchSpin({
											  verticalbuttons: true,
											  postfix: 'Tahun',
											  verticalupclass: 'glyphicon glyphicon-plus',
											  verticaldownclass: 'glyphicon glyphicon-minus'
											});
										</script>
									</div>
									<div class="form-group" style="padding:10px; margin-top: -20px;">
										<label>Jenis</label>
										<select class="form-control" name="type" id="type">
											<option value="<?php echo $r['lapak_type']; ?>" required ><?php echo $r['lapak_type']; ?></option>
											<option value="Sayur">Sayur</option>
											<option value="Buah">Buah</option>
											<option value="Lainnya">Lainnya</option>
										</select>
									</div>
									<div class="form-group" style="padding:10px; margin-top: -20px;">
										<label>Status</label>
										<select class="form-control" name="status" id="status">
											<option value="<?php echo $r['lapak_status']; ?>" required ><?php echo $r['lapak_status']; ?></option>
											<option value="Terisi">Terisi</option>
											<option value="">Kosong</option>
										</select>
									</div>
									<div class="row" style="margin-top: -10px;">
										<div class="col-md-6">
											<div class="form-group" style="padding:10px; margin-top: -10px; margin-bottom: -10px;">
												<button class="btn btn-outline btn-success btn-block" type="button" onclick="history.go(-1);">Batal</button>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group" style="padding:10px; margin-top: -10px; margin-bottom: -10px;">
												<button type="submit" class="btn btn-outline btn-block btn-primary">Simpan</button>
											</div>
										</div>
									</div>
								</fieldset>
							</form>
							<?php }?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9" style="margin-top:20px;">
                    <div id="Area1">
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
			$('#Area1').load("lapak_table.php",function(){clearNotif();});
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
</body>
</html>