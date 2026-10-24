<?php
	session_start();
	include "connection.php";
	include "components/role_session.php";
?>

<div class="modal-header bg-primary text-white" style="border-top-left-radius: 5px; border-top-right-radius: 5px;">
	<h4 style="margin-left: 20px;"><i class="fa fa-edit fa-fw"></i>&nbsp;Edit Data Lapak</h4>
	<button style="margin-top: -35px; margin-right: 20px;" type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<div class="modal-body">
    <?php 
		$lapakID = $_GET['id'];
		$edit	= mysql_query("select * from lapak where lapak_id = '".$lapakID."'");
		while($r = mysql_fetch_array($edit)){
			$sts		= '';
			if($r['lapak_status']==null){
				$sts		= 'Kosong';
			}
		?>

        <form class="form-horizontal" id="formlapak" name="formlapak" method="POST" action="lapak_action.php?task=update&id=<?php echo $r[0]; ?>">
			<fieldset>
				<div class="row">
					<div class="col-md-4" style="padding-left:40px; padding-right: 10px;">
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
					<div class="col-md-4" style="padding-left:15px; padding-right: 10px;">
						<label>No</label>
						<input class="form-control" id="no" name="no" type="number" value="<?php echo $r['lapak_no']; ?>" disabled/>
					</div>
					<div class="col-md-4" style="padding-left:15px; padding-right: 40px;">
						<label>Nama Lapak</label>
						<input class="form-control" id="name" name="name" type="text" value="<?php echo $r['lapak_name']; ?>"/>
					</div>
					<div class="col-md-4" style="padding-left:40px; margin-top: 10px;">
						<label>Panjang</label>
						<input class="form-control" id="p" name="p" type="number" step="0.01" value="<?php echo $r['p']; ?>" required />
					</div>
					<div class="col-md-4" style="padding-right: 10px; margin-top: 10px;">
						<label>Lebar</label>
						<input class="form-control" id="l" name="l" type="number" step="0.01" value="<?php echo $r['l']; ?>" required />
					</div>
					<div class="col-md-4" style="padding-right: 40px; margin-top: 10px;">
						<label>Luas</label>
						<input class="form-control" id="size" name="size" type="number" step="0.01" value="<?php echo $r['lapak_size']; ?>" required disabled/>
					</div>
					<div class="col-md-12" style="padding-left:40px; padding-right: 40px; margin-top: 10px">
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
					<div class="col-md-12" style="padding-left:40px; padding-right: 40px; margin-top: 10px">
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
					<div class="col-md-12" style="padding-left:40px; padding-right: 40px; margin-top: 10px">
					    <label>Jenis</label>
						<select class="form-control" name="type" id="type">
							<option value="<?php echo $r['lapak_type']; ?>" required ><?php echo $r['lapak_type']; ?></option>
							<option value="Sayur">Sayur</option>
							<option value="Buah">Buah</option>
							<option value="Lainnya">Lainnya</option>
						</select>
					</div>
					<div class="col-md-12" style="padding-left:40px; padding-right: 40px; margin-top: 10px">
						<label>Status</label>
						<select class="form-control" name="status" id="status">
						    <!-- <option value="<?php echo $r['lapak_status']; ?>" required ><?php echo $r['lapak_status']; ?></option> -->
						    <option value="Terisi" <?php echo ($r['lapak_status'] == 'Terisi') ? 'Selected' : ''; ?> >Terisi</option>
						    <option value="Kosong" <?php echo ($r['lapak_status'] == 'Kosong' || $r['lapak_status'] == NULL) ? 'Selected' : ''; ?> >Kosong</option>
						</select>
					</div>
					<div class="row" style="margin-top: 20px;">
					    <!-- <div class="col-md-6">
						    <div class="form-group" style="padding:10px; margin-top: -10px; margin-bottom: -10px;">
								<button class="btn btn-outline btn-success btn-block" type="button" onclick="history.go(-1);">Batal</button>
							</div>
						</div> -->
					<div class="col-md-12">
					    <div class="form-group" style="padding: 0 55px; margin-top: 20px; ">
							<button type="submit" class="btn btn-block btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;Simpan</button>
						</div>
					</div>
				</div>
			</fieldset>
		</form>
	<?php }?>
</div>