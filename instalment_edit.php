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
                <div class="col-lg-4" style="padding:10px;">
                    <br /><br /><br />
					<div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-pencil fa-fw"></i> Ubah Jangka Waktu Angsuran Lapak
                        </div>
                        <div class="panel-body">
							<?php 
								$id		= $_GET['id'];
								$edit	= mysql_query("select * from instalment where instalment_id = '".$id."'");
								while($r = mysql_fetch_array($edit)){
							?>
                            <form class="form-horizontal" id="formInstalment" name="formInstalment" method="POST" action="instalment_action.php?task=update&id=<?php echo $r[0]; ?>">
								<fieldset>
									<div class="form-group" style="padding:10px; margin-top:-20px;">
										<label>Nama Angsuran</label>
										<input id="ins" name="ins" type="text" value="<?php echo $r['instalment_name']; ?>" class="form-control" autofocus="autofocus" required/>
									</div>
									<div class="form-group" style="padding:10px; margin-top:-20px;">
										<label>Jumlah Angsuran</label>
										<input id="ins_val" name="ins_val" type="number" value="<?php echo $r['instalment_count']; ?>" class="form-control" required/>
									</div>
									<div class="form-group" style="align: center; padding:10px; margin-top: -20px;margin-bottom: -10px;">
										<button class="btn btn-outline btn-success col-md-6" type="button" onclick="history.go(-1);">Batal</button>
										<button type="submit" class="btn btn-outline btn-primary col-md-6">Simpan</button>
									</div>
								</fieldset>
							</form>
							<?php }?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8" style="margin-top:20px;">
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
			$('#Area1').load("instalment_table.php",function(){clearNotif();});
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