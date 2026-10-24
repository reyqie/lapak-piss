<?php
	include "connection.php";
?>
<!-- jquery -->
<script src="dataTables/jquery.dataTables.js"></script>
<script src="dataTables/dataTables.tableTools.js"></script>
<script src="dataTables/dataTables.bootstrap.js"></script>
<script>
	$(document).ready(function() {
	//data table
	$('#rentView').dataTable({
		dom: "<'row'<'col-sm-8'l><'col-sm-4'f>>" +  
			"<'row'<'col-sm-12'tr>>" +
			"<'row'<'col-sm-7'i><'col-sm-5'p>>",
		"aLengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]]});
	});
</script>
<!-- <h3 style="text-align:center;">Data Angsuran Lapak PIOS</h3> -->
<table id="rentView" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th style="width:5%;text-align:center;">NO</th>
			<th style="text-align: center; width:5%;">NIP</th>
			<th style="text-align: center; width:15%;">PEDAGANG</th>
			<th style="text-align: center; width:6%;">LAPAK</th>
			<th style="width:10%;text-align:center;">JATUH TEMPO</th>
			<th style="width:9%;text-align:center;"> NOMINAL</th>
			<th style="width:13%;text-align:center;">ANGSURAN</th>
			<th style="width:7%;text-align:center;">AKSI</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$no		= 1;
			$sql 	= "select r.rent_id, r.instalment_id, r.rent_instalment, r.merchant_id, m.merchant_name, r.lapak_id, r.leftover2, r.rent_dl 
			from rent r, merchant m
			where r.merchant_id = m.merchant_id and 
			m.merchant_status = 'Aktif' and
			r.rent_sts != 'Batal' 
			order by r.rent_id desc";
			$query 	= mysql_query($sql);
			while($data=mysql_fetch_array($query)){
				$cicilan 	= executeScalar("select instalment_count from instalment where instalment_id = '".$data['instalment_id']."'");
				$lapak 		= executeScalar("select lapak_name from lapak where lapak_id='".$data['lapak_id']."' ");
				//hitung sisa angsuran
				$total1 	= executeScalar("select (sum(trans_total)+sum(cash_total)) as total from rent_detail where rent_id='".$data['rent_id']."' ");
				$sisa		= $data['leftover2']-$total1;
			?>
		<tr>
			<td style="vertical-align: center; text-align:center;"><?php echo $no; ?></td>
			<td style="vertical-align: center; text-align:center;"><?php echo $data['merchant_id']; ?></td>
			<td style="vertical-align: center; text-align:left;"><?php echo $data['merchant_name']; ?></td>
			<td style="vertical-align: center; text-align:center;"><?php echo $lapak; ?></td>
			<td style="vertical-align: center; text-align:center;"><?php echo date("d M Y", strtotime($data['rent_dl'])); ?></td>
			<td style="vertical-align: center; text-align:right;"><?php echo format_rupiah($sisa); ?></td>
			<td style="vertical-align: center; text-align:right;"><?php echo format_rupiah($data['rent_instalment']).' x '.$cicilan; ?></td>
			<td><center><a style="text-decoration: none;" href="rent_edit.php?id=<?php echo $data['rent_id']; ?>">
			<button class="btn btn-outline btn-block btn-primary btn-xs"><i class="fa fa-money"></i>&nbsp;Bayar</button>
			</a></center></td>
		</tr>
		<?php $no++; } ?>
	</tbody>
</table>