<?php
	include "connection.php";
	$id		= $_GET['id'];
	$ins 	= executeScalar("select rent_instalment from rent where rent_id = '".$id."'");
?>

<div class="panel panel-primary">
	<div class="panel-heading">
		<i class="fa fa-money fa-fw"></i> Pembayaran Giro
	</div>
	<div class="panel-body">
		<form id="formInstalment" name="formInstalment" method="POST" action="rent_action.php?task=ins&sts=giro&id=<?php echo $id; ?>" class="form-horizontal" >
			<div class="row">
				<div class="col-lg-4">
					<div class="form-group" style="padding:10px; margin-top:-10px;">
						<label>Nama Bank</label>
						<input id="bname" name="bname" placeholder="Nama Bank" type="text" class="form-control" required />
					</div>
					<div class="form-group" style="padding:10px; margin-top:-10px;">
						<label>Nama Pemilik Giro</label>
						<input id="mname" name="mname" placeholder="Pemilik Rekening" type="text" class="form-control" required />
					</div>
				</div>
				<div class="col-lg-4">
					<div class="form-group" style="padding:10px; margin-top:-10px;">
						<label>No Giro</label>
						<input id="norek" name="norek" placeholder="No Rekening" type="text" class="form-control" required />
					</div>
					<div class="form-group" style="padding:10px; margin-top:-10px;">
						<label>Jumlah Uang yg diterima</label>
						<input id="total" name="total" placeholder="Uang yg Diterima" type="number" class="form-control" required />
					</div>
				</div>
				<div class="col-lg-4">
					<div class="form-group" style="padding:10px; margin-top:-10px;">
						<label>Tanggal Pencairan Giro</label>
						<input id="date" name="date" type="date" class="form-control" required />
					</div>
					<div class="form-group" style="padding:10px; margin-top:30px;">
						<button type="submit" class="btn btn-block btn-primary"><i class="fa fa-money"></i>&nbsp;&nbsp;Bayar Angsuran</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>