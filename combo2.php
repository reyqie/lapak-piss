<?php
	include "connection.php";
	$id		= $_GET['id'];
	$ins 	= executeScalar("select rent_instalment from rent where rent_id = '".$id."'");
?>

<div class="panel panel-primary">
	<div class="panel-heading">
		<i class="fa fa-money fa-fw"></i> Pembayaran Tunai & Debit
	</div>
	<div class="panel-body">
		<form id="formInstalment" name="formInstalment" method="POST" action="rent_action.php?task=ins&sts=combo1&id=<?php echo $id; ?>" class="form-horizontal" >
			<div class="row">
				<div class="col-lg-4">
					<div class="form-group" style="padding:10px; margin-top:-10px;">
						<label>Nama Bank</label>
						<input id="bname" name="bname" placeholder="Nama Bank" type="text" class="form-control" required />
					</div>
					<div class="form-group" style="padding:10px; margin-top:-10px;">
						<label>Nama Pemilik Rekening</label>
						<input id="mname" name="mname" placeholder="Pemilik Rekening" type="text" class="form-control" required />
					</div>
				</div>
				<div class="col-lg-4">
					<div class="form-group" style="padding:10px; margin-top:-10px;">
						<label>Rek Asal</label>
						<input id="norek" name="norek" placeholder="No Rekening" type="text" class="form-control" required />
					</div>
					<div class="form-group" style="padding:10px; margin-top:-10px;">
						<label>Tanggal Transfer</label>
						<input id="date" name="date" type="date" class="form-control" required />
					</div>
				</div>
				<div class="col-lg-4">
					<div class="form-group" style="padding:10px; margin-top:-10px;">
						<label>Jumlah Transfer</label>
						<input id="total2" name="total2" placeholder="Uang Transfer yg Diterima" type="number" step="1000" class="form-control" required />
					</div>
					<div class="form-group" style="padding:10px; margin-top:-10px;">
						<label>Jumlah Tunai</label>
						<input id="total1" name="total1" placeholder="Uang Tunai yg Diterima" type="number" step="1000" class="form-control" required />
					</div>
				</div>
			</div>
			<div class="form-group" style="padding:10px; margin-top:-30px; margin-bottom:-10px;">
				<button type="submit" class="btn btn-outline btn-block btn-primary">Bayar Angsuran</button>
			</div>
		</form>
	</div>
</div>