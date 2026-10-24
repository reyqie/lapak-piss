<?php
	session_start();
	include "connection.php";
	//Validasi role
	if($_SESSION['role']==''){
		header("Location:../login.html");
	}
	$id 	= $_GET['id'];
?>
<div class="row" style="margin-top:20px;margin-bottom:10px;">
	<div class="col-md-8 col-md-offset-2">
		<form action="nonactive_action.php?sub=lapak&task=nonactive&lid=<?php echo $id; ?>"  id="form_nonactive" name="form_nonactive" method="POST" class="form-horizontal">
			<div class="form-group" style="padding:10px; margin-top:10px; margin-right:0px;">
				<label>Alasan NonAktif Lapak</label>
				<input id="reason" name="reason" placeholder="Alasan Mengapa Lapak DinonAktifkan. ." type="text" class="form-control" required>                  
			</div>
			<div class="form-group" style="padding:10px; margin-top:-10px; margin-right:0px;">
				<button type="submit" class="btn btn-outline btn-primary btn-block btn-sm">Simpan</button>               
			</div>
		</form>
	</div>
</div>