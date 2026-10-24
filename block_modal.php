<?php
	session_start();
	include "connection.php";
	include "components/role_session.php";
?>

<div class="modal-header bg-primary text-white" style="border-top-left-radius: 5px; border-top-right-radius: 5px;">
	<h4 style="margin-left: 20px;"><i class="fa fa-edit fa-fw"></i>&nbsp;Edit Data Block</h4>
	<button style="margin-top: -35px; margin-right: 20px;" type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<div class="modal-body">
    <?php 
		$blockID		= $_GET['id'];
		$edit	= mysql_query("select * from block where block_id = '".$blockID."'");

		while($r = mysql_fetch_array($edit)){
	?>

		<form class="form-horizontal" id="formBlock" name="formBlock" method="POST" action="block_action.php?task=update&id=<?php echo $r[0]; ?>">
			<fieldset>
				<div class="form-group" style="padding: 0 40px;">
					<label>Blok</label>
					<input class="form-control" id="block" name="block" type="text" value="<?php echo $r['block_id']; ?>" disabled/>
				</div>
				<div class="form-group" style="padding: 0 40px; margin-top: 10px;">
					<label>Jumlah Max Unit</label>
					<input class="form-control" id="max" name="max" min="1" type="number" value="<?php echo $r['block_max']; ?>" required/>
				</div>
				<div class="form-group" style="padding: 0 40px; margin-top: 10px;">
					<label>Jenis</label>
					<select class="form-control" name="type" id="type">
						<!-- <option value="<?php echo $r['block_type']; ?>"><?php echo $r['block_type']; ?></option> -->
						<option value="Buah" <?php echo ($r['block_type'] == 'Buah') ? 'Selected' : ''; ?>>Buah</option>
						<option value="Sayur" <?php echo ($r['block_type'] == 'Sayur') ? 'Selected' : ''; ?> >Sayur</option>
						<option value="Campuran" <?php echo ($r['block_type'] == 'Campuran') ? 'Selected' : ''; ?> >Campuran</option>
					</select>
				</div>
				<div class="form-group" style="align: center; padding:0 40px; margin-top: 20px; margin-bottom: 10px;">
					<!-- <button class="btn btn-outline btn-success col-md-6" type="button" onclick="history.go(-1);">Batal</button> -->
					<button type="submit" class="btn btn-block btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;Simpan</button>
				</div>
			</fieldset>
		</form>
	<?php }?>
</div>