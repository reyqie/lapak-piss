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
			<th style="text-align: center; width:14%;">NAMA</th>
			<th style="text-align: center; width:25%;">ALAMAT</th>
			<th style="text-align: center; width:12%;">LAPAK</th>
			<th style="text-align: center; width:8%;">JENIS PEDAGANG</th>
			<th style="text-align: center; width:8%;">STATUS</th>
			<th style="text-align: center; width:8%;">AKSI</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$sql 	= "select * from merchant where merchant_status = 'Aktif' order by merchant_id desc";
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
			<td style="vertical-align: middle; text-align:center;"><?php echo $lapak != NULL ? $lapak : 'Tidak ada'; ; ?></td>
			<td style="vertical-align: middle; text-align:center;"><?php echo $data['merchant_type']; ?></td>
			<td style="vertical-align: middle; text-align:center;">
				<div style="vertical-align: middle; background-color: <?php echo $data['merchant_status'] == 'Aktif' ? 'green' : 'red'; ?>; color: #fff; padding: 3px; border-radius: 5px; margin: 5px auto 5px auto; width: 110px;">		
					<i class="fa <?php echo $data['merchant_status'] == 'Aktif' ? 'fa-check' : 'fa-remove'; ?> fa-fw"></i>&nbsp;<?php echo $data['merchant_status']; ?>
				</div>
			</td>
			<td style="vertical-align: middle; text-align:center;"><center>
				<button class="btn btn-outline btn-block btn-primary btn-xs modalMoveLapak" data-toggle="modal" data-target="#modalMoveLapak" data-id="<?php echo $data['merchant_id']; ?>">
					<i class="fa fa-retweet"></i>&nbsp;&nbsp;Pindah
				</button>
			</td>
		</tr>
		<?php $no++;} ?>
	</tbody>
</table>

<script>
	$(document).ready(function() {
		$('body').on('click', '.modalMoveLapak', function() {
			var goodsID = $(this).data('id'); 

			$.ajax({
				url: 'move_modal.php',
				type: 'GET',
				data: { id: goodsID }, 
				success: function(response) {
					$('#modalMoveLapak .modal-content').html(response);
					$('#modalMoveLapak').modal('show');
				}
			});
		});
	});
</script>