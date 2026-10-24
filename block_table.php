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
	$('#lapakView').dataTable({"aLengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]]});
	});
</script>
<!-- <H3 style="text-align:center; margin-top:-10px;">Data Blok Lapak Pasar Induk Surabaya Sidotopo</H3> -->
<table id="lapakView" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th style="text-align:center;">NO</th>
			<th style="text-align:center;">BLOCK</th>
			<th style="text-align:center">JUMLAH UNIT SEKARANG</th>
			<th style="text-align:center">JUMLAH MAX UNIT</th>
			<th style="text-align:center;">TIPE BLOCK</th>
			<th style="text-align:center">AKSI</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$sql 	= mysql_query("select * from block where status_block = 'active' order by block_id asc");
		$no		= 1;
			while($data=mysql_fetch_array($sql)) { 
		?>
		<tr>
			<td style="vertical-align: middle; text-align:center;"><?php echo $no; ?></td>
			<td style="vertical-align: middle; text-align:center;"><?php echo $data['block_id']; ?></td>
			<td style="vertical-align: middle; text-align:center"><?php echo $data['block_now']; ?> Unit</td>
			<td style="vertical-align: middle; text-align:center"><?php echo $data['block_max']; ?> Unit</td>
			<td style="vertical-align: middle; text-align:center;">
				<div style="vertical-align: middle; background-color: <?php echo $data['block_type'] == 'Buah' ? '#428bca' : ($data['block_type'] == 'Sayur' ? 'green' : '#EB8317'); ?>; color: #fff; padding: 3px; border-radius: 5px; margin: 5px auto 5px auto; width: 110px;">		
					<i class="fa fa-cube fa-fw"></i>&nbsp;<?php echo $data['block_type']; ?>
				</div>
			</td>
			<!-- <td><center>
				<a href="block_edit.php?id=<?php echo $data[0]; ?>">
					<button class="btn btn-outline btn-block btn-primary btn-xs">Edit</button>
				</a>
			</center></td> -->
			<td style="text-align: center; vertical-align: middle;">
				<a class="btn btn-xs btn-outline btn-primary btn-block modalEditBlock" data-toggle="modal" data-target="#modalEditBlock" data-id="<?php echo $data['block_id']; ?>">
					<i class="fa fa-edit"></i>&nbsp;Edit
				</a>
				<a class="btn btn-xs btn-outline btn-danger btn-block modalDeleteBlock" data-toggle="modal" data-target="#modalDeleteGoods" data-id="<?php echo $data['block_id']; ?>">
					<i class="fa fa-trash"></i>&nbsp;Hapus
				</a>
			</td>
		</tr>
		<?php
			$no++;
			}
		?>
	</tbody>
</table>

<script>
	$(document).ready(function() {
		$('body').on('click', '.modalEditBlock', function() {
			var blockID = $(this).data('id'); 

			$.ajax({
				url: 'block_modal.php',
				type: 'GET',
				data: { id: blockID }, 
				success: function(response) {
					$('#modalEditBlock .modal-content').html(response);
					$('#modalEditBlock').modal('show');
				}
			});
		});
		
		$('body').on('click', '.modalDeleteBlock', function() {
			var blockID = $(this).data('id'); 

			$.ajax({
				url: 'block_modal_delete.php',
				type: 'GET',
				data: { id: blockID }, 
				success: function(response) {
					$('#modalDeleteBlock .modal-content').html(response);
					$('#modalDeleteBlock').modal('show');
				}
			});
		});
	});
</script>