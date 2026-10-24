<?php
	session_start();
	include "connection.php";
	include "components/role_session.php"
?>
<!-- jquery -->
<script src="dataTables/jquery.dataTables.js"></script>
<script src="dataTables/dataTables.tableTools.js"></script>
<script src="dataTables/dataTables.bootstrap.js"></script>
<script>
	$(document).ready(function() {
	//data table
	$('#DeadlineView').dataTable({
		dom: "<'row'<'col-sm-8'l><'col-sm-4'f>>" +  
			"<'row'<'col-sm-12'tr>>" +
			"<'row'<'col-sm-7'i><'col-sm-5'p>>",
		"aLengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]]});
	});
</script>
<table id="DeadlineView" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th style="width:5%; text-align:center;">NO</th>
			<th style="width:15%; text-align:center;">PEDAGANG</th>
			<th style="width:10%; text-align:center;">LAPAK</th>
			<th style="width:10%; text-align:center;">BATAS SEWA</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$no			= 0;
			$date_min 	= strtotime('-30 day', strtotime($date_now));
			$first_date	= date('Y-m-j' , $date_min);
			$date_plus 	= strtotime('30 day', strtotime($date_now));
			$last_date	= date('Y-m-j' , $date_plus);
			$sql 		= mysql_query("	select 	r.merchant_id, 
												r.lapak_id, 
												r.rent_expired 
										from 	rent r, 
												merchant m 
										where 	r.merchant_id = m.merchant_id and 
												m.merchant_status = 'Aktif' and
												r.rent_sts != 'Batal' and 
												(r.rent_expired between '".$first_date."' and '".$last_date."')");
			while($r	= mysql_fetch_array($sql)) { 
				$lapak 	= executeScalar("select lapak_name from lapak where lapak_id = '".$r['lapak_id']."'");
				$merchant = executeScalar("select merchant_name from merchant where merchant_id = '".$r['merchant_id']."'");
				$no		= $no++;
		?>
		<tr>
			<td style="vertical-align: middle; text-align: center"><?php $no++; echo $no; ?></td>
			<td style="vertical-align: middle; text-align: left"><?php echo $r['merchant_id'].' - '.$merchant; ?></td>
			<td style="vertical-align: middle; text-align: center"><?php echo $lapak; ?></td>
			<td style="vertical-align: middle; text-align: center"><?php echo date('d M Y', strtotime($r['rent_expired'])); ?></td>
		</tr>
		<?php } ?>
	</tbody>
</table>