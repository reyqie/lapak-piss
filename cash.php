<?php
	include "connection.php";
	$id		= $_GET['id'];
	$ins 	= executeScalar("select rent_instalment from rent where rent_id = '".$id."'");
?>

<div class="panel panel-primary">
	<div class="panel-heading">
		<i class="fa fa-money fa-fw"></i> Pembayaran Tunai (<?php echo $id; ?>)
	</div>
	<div class="panel-body">
		<form id="formInstalment" name="formInstalment" method="POST" action="rent_action.php?task=ins&sts=cash&id=<?php echo $id; ?>" class="form-horizontal" >
			<div class="row">
				<div class="col-lg-4">
					<div class="form-group" style="padding:10px; margin-top:-10px;">
						<label>Jumlah Angsuran</label>
						<input id="total" name="total" value="<?php echo format_rupiah($ins); ?>" type="text" class="form-control" disabled/>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="form-group" style="padding:10px; margin-top:-10px;">
						<label>Jumlah Uang yg Dibayarkan</label>
						<input id="total" name="total" placeholder="Uang yg Diterima" type="number" class="form-control" required />
					</div>
				</div>
				<div class="col-lg-4">
					<div class="form-group" style="padding:10px; margin-top:15px;">
						<button type="submit" class="btn btn-block btn-primary"><i class="fa fa-money"></i>&nbsp;&nbsp;Bayar Angsuran</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>