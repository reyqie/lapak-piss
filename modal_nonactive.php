<?php
	session_start();
	include "connection.php";
	//Validasi role
	if($_SESSION['role']==''){
		header("Location:logout.php");
	}
	$id = $_GET['id'];
?>

<div class="modal-header bg-primary text-white" style="border-top-left-radius: 5px; border-top-right-radius: 5px;">
	<h4 style="margin-left: 20px;"><i class="fa fa-remove fa-fw"></i>&nbsp;NonAktifkan Pedagang</h4>
	<button style="margin-top: -35px; margin-right: 20px;" type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<div class="modal-body">
	<div class="row" style="margin-top:-10px; margin-bottom:-10px; margin-left: 20px; margin-right: 20px;">
		<div class="col-md-12">
			<form action="nonactive_action.php?task=nonactive&id=<?php echo $id; ?>"  id="form_nonactive" name="form_nonactive" method="POST" class="form-horizontal">
				<div class="form-group" style="padding:10px; margin-top:10px; margin-right:0px;">
					<label>Alasan Penonaktifan Pedagang</label>
					<input id="reason" name="reason" placeholder="Alasan Mengapa DiNonAktifkan" type="text" class="form-control" required>                  
				</div>
				<div class="form-group" style="padding:10px; margin-top:-10px; margin-right:0px;">
					<button type="submit" class="btn btn-danger btn-block btn-sm"><i class="fa fa-remove"></i>&nbsp;&nbsp;NonAktifkan</button>               
				</div>
			</form>
		</div>
	</div>
</div>