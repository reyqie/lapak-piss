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
<!-- <H3 style="text-align:center; margin-top:-10px;">Data Lapak Pasar Induk Surabaya Sidotopo</H3></br> -->
<table id="lapakView" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th style="width: 6%; text-align:center" >NO</th>
			<th style="width: 9%; text-align:center" >LAPAK</th>
			<th style="width: 9%; text-align:center" >JENIS</th>
			<th style="width: 8%; text-align:center" >P <sup>( M )</sup></th>
			<th style="width: 8%; text-align:center" >L <sup>( M )</sup></th>
			<th style="width: 10%; text-align:center" >LUAS <sup>( M<sup>2</sup> )</sup></th>
			<th style="width: 10%; text-align:center" >HARGA <sup>( /M<sup>2</sup> )</sup></th>
			<th style="width: 10%; text-align:center" >TOTAL</th>
			<th style="width: 10%; text-align:center" >DURASI <sup>( TAHUN )</sup></th>
			<th style="width: 10%; text-align:center" >STATUS</th>
			<th style="width: 10%; text-align:center" >AKSI</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$sql = mysql_query("
			SELECT *
			FROM lapak AS l
			JOIN block AS b ON l.block_id = b.block_id
			WHERE b.status_block = 'active'
			ORDER BY b.block_id, l.lapak_no
		");

		$no		= 1;
			while($data=mysql_fetch_array($sql)) { 
			if($data['lapak_status']==''){
				$sts = 'Kosong';
			}else{$sts = $data['lapak_status'];}
		?>
		<tr>
			<td style="text-align:center; vertical-align: middle;"><?php echo $data['lapak_id']; ?></td>
			<td style="text-align:center; vertical-align: middle;"><?php echo $data['lapak_name']; ?></td>
			<td style="text-align:center; vertical-align: middle;"><?php echo $data['lapak_type']; ?></td>
			<td style="text-align:center; vertical-align: middle;"><?php echo $data['p']; ?></td>
			<td style="text-align:center; vertical-align: middle;"><?php echo $data['l']; ?></td>
			<td style="text-align:center; vertical-align: middle;"><?php echo $data['lapak_size']; ?></td>
			<td style="text-align:right; vertical-align: middle;"><?php echo format_rupiah($data['lapak_price']); ?></td>
			<td style="text-align:right; vertical-align: middle;"><?php echo format_rupiah($data['lapak_total']); ?></td>
			<td style="text-align:center; vertical-align: middle;"><?php echo $data['duration']; ?></td>
			<td style="text-align:center">
				<div style="vertical-align: middle; background-color: <?php echo $sts == 'Kosong' ? '#428bca' : 'green'; ?>; color: #fff; padding: 3px; border-radius: 5px; margin: 5px auto 5px auto; width: 110px;">		
					<?php echo $sts; ?>
				</div>
			</td>
			<!-- <td>
				<?php 
					if($data['lapak_status']==''){
						echo '<a href="lapak_edit.php?id='.$data[0].'">
							<button class="btn btn-outline btn-block btn-primary btn-xs">Edit</button>
						</a>';
					}else{
						echo '<a href="lapak_edit.php?id='.$data[0].'">
							<button class="btn btn-outline btn-block btn-primary btn-xs">Edit</button>
						</a>';
					} 
				?>
			</td> -->
			<td style="text-align: center; vertical-align: middle;">
				<a class="btn btn-xs btn-outline btn-primary btn-block modalEditLapak" data-toggle="modal" data-target="#modalEditLapak" data-id="<?php echo $data['lapak_id']; ?>">
					<i class="fa fa-edit"></i>&nbsp;Edit
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
		$('body').on('click', '.modalEditLapak', function() {
			var goodsID = $(this).data('id'); 

			$.ajax({
				url: 'lapak_modal.php',
				type: 'GET',
				data: { id: goodsID }, 
				success: function(response) {
					$('#modalEditLapak .modal-content').html(response);
					$('#modalEditLapak').modal('show');
				}
			});
		});
	});
</script>