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
<!-- <H3 style="text-align:center; margin-top:-10px;">Jangka Waktu Angsuran Lapak Pasar Induk Surabaya Sidotopo</H3> -->
<table id="lapakView" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th style="vertical-align: middle; text-align:center;">NO</th>
			<th style="vertical-align: middle; text-align:center;">NAMA ANGSURAN</th>
			<th style="vertical-align: middle; text-align:center">JUMLAH ANGSURAN</th>
			<th style="vertical-align: middle; text-align:center">AKSI</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$sql 	= mysql_query("select * from instalment order by instalment_id desc");
		$no		= 1;
			while($data=mysql_fetch_array($sql)) { 
		?>
		<tr>
			<td style="vertical-align: middle; text-align:center;"><?php echo $no; ?></td>
			<td style="vertical-align: middle; text-align:center;"><?php echo $data['instalment_name']; ?></td>
			<td style="vertical-align: middle; text-align:center"><?php echo $data['instalment_count']; ?>x</td>
			<!-- <td><center>
				<a href="instalment_edit.php?id=<?php echo $data[0]; ?>">
					<button class="btn btn-outline btn-block btn-primary btn-xs">Edit</button>
				</a>
			</center></td> -->
			<td style="vertical-align: middle; text-align: center; vertical-align: middle;">
				<a class="btn btn-xs btn-outline btn-primary btn-block modalEditInstalment" data-toggle="modal" data-target="#modalEditBlock" data-id="<?php echo $data['instalment_id']; ?>">
					<i class="fa fa-edit"></i>&nbsp;Edit
				</a>
				<a class="btn btn-xs btn-outline btn-danger btn-block modalDeleteInstalment" data-toggle="modal" data-target="#modalDeleteGoods" data-id="<?php echo $data['instalment_id']; ?>">
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
		$('body').on('click', '.modalEditInstalment', function() {
			var instalmentID = $(this).data('id'); 

			$.ajax({
				url: 'instalment_modal.php',
				type: 'GET',
				data: { id: instalmentID }, 
				success: function(response) {
					$('#modalEditInstalment .modal-content').html(response);
					$('#modalEditInstalment').modal('show');
				}
			});
		});
		
		$('body').on('click', '.modalDeleteInstalment', function() {
			var instalmentID = $(this).data('id'); 

			$.ajax({
				url: 'instalment_modal_delete.php',
				type: 'GET',
				data: { id: instalmentID }, 
				success: function(response) {
					$('#modalDeleteInstalment .modal-content').html(response);
					$('#modalDeleteInstalment').modal('show');
				}
			});
		});
	});
</script>