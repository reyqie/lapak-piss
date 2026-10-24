<?php
	session_start();
	include "connection.php";
	include "components/role_session.php";
?>

<div class="modal-header bg-primary text-white" style="border-top-left-radius: 5px; border-top-right-radius: 5px;">
	<h4 style="margin-left: 20px;"><i class="fa fa-edit fa-fw"></i>&nbsp;Edit Data Waktu Angsuran Lapak</h4>
	<button style="margin-top: -35px; margin-right: 20px;" type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<div class="modal-body">
	<?php 
		$instalmentID		= $_GET['id'];
		$edit	= mysql_query("select * from instalment where instalment_id = '".$instalmentID."'");
		while($r = mysql_fetch_array($edit)){
	?>

		<form class="form-horizontal" id="formInstalment" name="formInstalment" method="POST" action="instalment_action.php?task=update&id=<?php echo $r[0]; ?>">
			<fieldset>
				<div class="form-group" style="padding: 0 40px;">
					<label>Nama Angsuran</label>
					<input id="ins" name="ins" type="text" value="<?php echo $r['instalment_name']; ?>" class="form-control" autofocus="autofocus" required/>
				</div>
				<div class="form-group" style="padding: 0 40px; margin-top: 10px;">
					<label>Jumlah Angsuran</label>
					<input id="ins_val" name="ins_val" type="number" value="<?php echo $r['instalment_count']; ?>" class="form-control" required/>
				</div>
				<div class="form-group" style="align: center; padding:0 40px; margin-top: 20px; margin-bottom: 10px;">
					<!-- <button class="btn btn-outline btn-success col-md-6" type="button" onclick="history.go(-1);">Batal</button> -->
					<button type="submit" class="btn btn-block btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;Simpan</button>
				</div>
			</fieldset>
		</form>
	<?php }?>
</div>