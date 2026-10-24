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
	$('#merchantView').dataTable({"aLengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]]});
	});
</script>
<!-- <h3>Data Pedagang PISS</h3> -->
<table id="merchantView" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th style="vertical-align: middle; text-align: center; width:5%;">NO</th>
			<th style="vertical-align: middle; text-align: center; width:5%;">ID</th>
			<th style="vertical-align: middle; text-align: center; width:14%;">NAMA PEDAGANG</th>
			<th style="vertical-align: middle; text-align: center; width:20%;">ALAMAT</th>
			<th style="vertical-align: middle; text-align: center; width:9%;">LAPAK</th>
			<th style="vertical-align: middle; text-align: center; width:7%;">JENIS PEDAGANG</th>
			<th style="vertical-align: middle; text-align: center; width:7%;">STATUS</th>
			<!-- <th style="vertical-align: middle; text-align: center; width:7%;">STATUS 2</th> -->
			<th style="vertical-align: middle; text-align: center; width:7%;">STATUS PEDAGANG</th>
			<th style="vertical-align: middle; text-align: center; width:5%;">AKSI</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$sql 	= "	select 		merchant_id, 
								merchant_name, 
								address1, 
								merchant_type, 
								merchant_status, 
								merchant_status2,
								kat_merchant
					from 		merchant 
					where 		merchant_status = 'Tidak Aktif'
					order by 	merchant_id desc";
		$query 	= mysql_query($sql);
		$no		= 1;
		while($data=mysql_fetch_array($query)) {
		$sql2 	= mysql_query("	SELECT l.lapak_name 
								FROM rent r
								JOIN lapak l ON r.lapak_id = l.lapak_id
								WHERE r.merchant_id = '".$data['merchant_id']."' 
								AND r.rent_sts != 'Batal'
								AND r.rent_sts2 NOT IN ('Batal', 'Pindah')
								ORDER BY l.lapak_name 
								LIMIT 7
								");
		$string	= "";
		$counter= 0;
		while($row=mysql_fetch_array($sql2)){
			if($counter!=0){
				$string = ", ".$string;
			}
			$string = $row['lapak_name'].$string;
			$counter++;
		}
		$lapak 	= "".$string;
		?>
		<tr>
			<td style="vertical-align: middle; text-align:center;"><?php echo $no; ?></td>
			<td style="vertical-align: middle; text-align: center;"><?php echo $data['merchant_id']; ?></td>
			<td style="vertical-align: middle; text-align: left;"><?php echo $data['merchant_name']; ?></td>
			<td style="vertical-align: middle; text-align: left;"><?php echo $data['address1']; ?></td>
			<td style="vertical-align: middle; text-align: center;"><?php echo $lapak != NULL ? $lapak : 'Tidak ada'; ?></td>
			<td style="vertical-align: middle; text-align: center;"><?php echo $data['merchant_type']; ?></td>
			<td style="vertical-align: middle; text-align: center;">
				<div style="vertical-align: middle; background-color: <?php echo $data['merchant_status'] == 'Aktif' ? 'green' : 'red'; ?>; color: #fff; padding: 3px; border-radius: 5px; margin: 5px auto 5px auto; width: 110px;">		
					<i class="fa <?php echo $data['merchant_status'] == 'Aktif' ? 'fa-check' : 'fa-remove'; ?> fa-fw"></i>&nbsp;<?php echo $data['merchant_status']; ?>
				</div>
			</td>
			<!-- <td style="vertical-align: middle; text-align: center;"><?php echo $data['merchant_status2']; ?></td> -->
			<td style="vertical-align: middle; text-align: center;">
				<div style="vertical-align: middle; background-color: <?php echo $data['kat_merchant'] == 'Tetap' ? 'green' : '#E3AB57'; ?>; color: #fff; padding: 3px; border-radius: 5px; margin: 5px auto 5px auto; width: 110px;">		
					<i class="fa <?php echo $data['kat_merchant'] == 'Tetap' ? 'fa-check' : 'fa-circle-o'; ?> fa-fw"></i>&nbsp;<?php echo $data['kat_merchant']; ?>
				</div>
			</td>
			<td style="vertical-align: middle; text-align: center;">
				<center>
					<a style="text-decoration: none;" href="merchant2_edit.php?id=<?php echo $data['merchant_id']; ?>">
						<button class="btn btn-outline btn-block btn-primary btn-xs"><i class="fa fa-eye"></i>&nbsp;Lihat Detail</button>
					</a>
				</center>
			</td>
		</tr>
		<?php $no++;} ?>
	</tbody>
</table>