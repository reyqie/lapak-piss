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
	$('#nonactiveView').dataTable( {
			dom: "<'row'<'col-sm-7'l><'col-sm-5'f>>" +  
			"<'row'<'col-sm-12'tr>>" +
			"<'row'<'col-sm-6'i><'col-sm-6'p>>",
			renderer: 'bootstrap',
			/*/*"tableTools": {
				"sSwfPath": "dataTables/tableTools/swf/copy_csv_xls_pdf.swf",
				"aButtons": ["xls", "pdf", "print"]
			},*/
			"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]
		} );
	});
</script>

<!-- <h3 style="text-align:center;">Histori NonAktif</h3> -->
<table id="nonactiveView" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th style="text-align: center; width:5%;">NO</th>
			<th style="text-align: center; width:15%;">NAMA SPV / PP</th>
			<th style="text-align: center; width:20%;">PEDAGANG</th>
			<th style="text-align: center; width:10%;">LAPAK</th>
			<th style="text-align: center; width:25%;">ALASAN</th>
			<th style="text-align: center; width:15%;">TGL & JAM</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$no		= 1;
			$sql 	= mysql_query("select * from nonactive_log order by nonactive_date desc limit 100");
			while($data=mysql_fetch_array($sql)) {
				$name 	= executeScalar("select merchant_name from merchant where merchant_id = '".$data['merchant_id']."'");
				// $lapak 	= executeScalar("select lapak_name from lapak where lapak_id='".$data['lapak_id']."' ");
				$sql2 	= mysql_query("select distinct l.lapak_name from rent r, lapak l
						where r.lapak_id = l.lapak_id and 
						r.merchant_id = '".$data['merchant_id']."'
						order by l.lapak_name limit 7");
				$string="";
				$counter=0;
				while($row=mysql_fetch_array($sql2)){
					if($counter!=0){
						$string = ", ".$string;
					}
					$string = $row['lapak_name'].$string;
					$counter++;
				}
				$lapak = "".$string;
		?>
		<tr>
			<td style="vertical-align: middle; text-align:center;"><?php echo $no; ?></td>
			<td style="vertical-align: middle; text-align:left; text-transform: capitalize"><?php echo $data['spv_name']; ?></td>
			<td style="vertical-align: middle; text-align:left;"><?php echo $name; ?></td>
			<td style="vertical-align: middle; text-align:center;"><?php if($lapak!=null){echo $lapak;}else{echo ' - ';} ?></td>
			<td style="vertical-align: middle; text-align:left;"><?php echo $data['nonactive_reason']; ?></td>
			<td style="vertical-align: middle; text-align:center;">
				<?php echo date("d M Y", strtotime($data['nonactive_date'])); ?><br>
				<?php echo date("H:i", strtotime($data['nonactive_date'])); ?>
			</td>
		</tr>
		<?php
			$no++;
			}
		?>
	</tbody>
</table>