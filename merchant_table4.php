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
	$('#merchantView3').dataTable( {
			dom: "<'row'<'col-sm-8'l><'col-sm-4'f>>" +  
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
<!-- <h3 style="text-align:center;">Daftar Pedagang</h3> -->
<table id="merchantView3" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th style="text-align: center; width:5%;">NO</th>
			<th style="text-align: center; width:8%;">ID</th>
			<th style="text-align: center; width:14%;">NAMA PEDAGANG</th>
			<th style="text-align: center; width:25%;">ALAMAT</th>
			<th style="text-align: center; width:12%;">LAPAK</th>
			<th style="text-align: center; width:8%;">JUALAN</th>
			<th style="text-align: center; width:8%;">STATUS</th>
			<th style="text-align: center; width:8%;">AKSI</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$sql 	= "select * from merchant order by merchant_id desc";
		$query 	= mysql_query($sql);
		$no		= 1;
		while($data=mysql_fetch_array($query)) { 
		$sql2 	= mysql_query("	SELECT l.lapak_name 
								FROM rent r
								JOIN lapak l ON r.lapak_id = l.lapak_id
								WHERE r.merchant_id = '".$data['merchant_id']."' 
								AND (r.rent_sts != 'Batal' AND r.rent_sts2 NOT IN ('Batal', 'Pindah'))
								ORDER BY l.lapak_name 
								LIMIT 7
								");
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
			<td style="vertical-align: middle; text-align:center;"><?php echo $data['merchant_id']; ?></td>
			<td style="vertical-align: middle; text-align:left;"><?php echo $data['merchant_name']; ?></td>
			<td style="vertical-align: middle; text-align:left;"><?php echo $data['address1']; ?></td>
			<td style="vertical-align: middle; text-align:center;"><?php echo ($lapak != NULL && $lapak != 'Kosong') ? $lapak : 'Tidak ada'; ?></td>
			<td style="vertical-align: middle; text-align:center;"><?php echo $data['merchant_type']; ?></td>
			<td style="vertical-align: middle; text-align:center;">
				<div style="vertical-align: middle; background-color: <?php echo $data['merchant_status'] == 'Aktif' ? 'green' : 'red'; ?>; color: #fff; padding: 3px; border-radius: 5px; margin: 5px auto 5px auto; width: 110px;">		
					<i class="fa <?php echo $data['merchant_status'] == 'Aktif' ? 'fa-check' : 'fa-remove'; ?> fa-fw"></i>&nbsp;<?php echo $data['merchant_status']; ?>
				</div>
			</td>
			<td style="vertical-align: middle; text-align:center;">
			<?php
			if($data['merchant_status']=='Tidak Aktif'){
				echo '<a style="text-decoration: none;" href="modal_active.php?id='.$data['merchant_id'].'" data-toggle="modal" data-target="#modalAktif">
				<button class="btn btn-outline btn-block btn-success btn-xs"><i class="fa fa-check"></i>&nbsp;Aktifkan</button></a>';
			}else{
				echo '<a style="text-decoration: none;" href="modal_nonactive.php?id='.$data['merchant_id'].'" data-toggle="modal" data-target="#modalNonaktif">
				<button class="btn btn-outline btn-block btn-danger btn-xs"><i class="fa fa-remove"></i>&nbsp;NonAktifkan</button></a>';
			}
			?>
			</td>
		</tr>
		<?php $no++;} ?>
	</tbody>
</table>