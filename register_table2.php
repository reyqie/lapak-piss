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
	$('#requestView').dataTable({"aLengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]]});
	});
</script>
<!-- <h3>Daftar Pemohon Lapak PISS</h3> -->
<table id="requestView" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th style="text-align: center; vertical-align: middle; width:5%;">NO</th>
			<th style="text-align: center; vertical-align: middle; width:15%;">NAMA PEDAGANG</th>
			<th style="text-align: center; vertical-align: middle; width:9%;">LAPAK</th>
			<th style="text-align: center; vertical-align: middle; width:26%;">ALAMAT</th>
			<th style="text-align: center; vertical-align: middle; width:10%;">TELP. RUMAH</th>
			<th style="text-align: center; vertical-align: middle; width:10%;">TELP. HP</th>
			<th style="text-align: center; vertical-align: middle; width:10%;">JENIS PEDAGANG</th>
			<th style="text-align: center; vertical-align: middle; width:10%;">TGL PERMOHONAN</th>
			<th style="text-align: center; vertical-align: middle; width:8%;">STATUS</th>
			<th style="text-align: center; vertical-align: middle; width:7%;">AKSI</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$sql 	= "select * from request where req_reffer != '' and req_status != 'Dibatalkan'    order by req_id desc";
			$query 	= mysql_query($sql);
			$no		= 1;

			function timeAgo($date)
			{
				$now = new DateTime(); // waktu sekarang
				$reg = new DateTime($date); // waktu register
				$diff = $now->diff($reg);

				if ($diff->y >= 1) {
					return $diff->y . " tahun lalu";
				} elseif ($diff->m >= 1) {
					return $diff->m . " bulan lalu";
				} else {
					return $diff->d . " hari lalu";
				}
			}

			while($data=mysql_fetch_array($query)){
			$lapak 	= executeScalar("select lapak_name from lapak where lapak_id='".$data['lapak_id']."' ");
			//$rid 	= executeScalar("select rent_id from rent where req_id='".$data['req_id']."' ");
		?>
		<tr>
			<td style="vertical-align: middle; text-align:center;"><?php echo $no; ?></td>
			<td style="vertical-align: middle; text-align:left;">
				<?php echo $data['req_name']; ?>
			</td>
			<td style="vertical-align: middle; text-align: center;">
				<?php echo $lapak; ?>
			</td>
			<td style="vertical-align: middle; text-align: left;"><?php echo $data['address1']; ?></td>
			<td style="vertical-align: middle; text-align: center;">
				<?php echo $data['phone1'] == NULL ? 'Tidak ada' : $data['phone1']; ?>
			</td>
			<td style="vertical-align: middle; text-align: center;">
				<?php echo $data['phone2'] == NULL ? 'Tidak ada' : $data['phone2']; ?>
			</td>
			<td style="vertical-align: middle; text-align: center;">
				<div style="vertical-align: middle; background-color: <?php echo $data['merchant_type'] == 'Buah' ? '#428bca' : ($data['merchant_type'] == 'Sayur' ? 'green' : '#EB8317'); ?>; color: #fff; padding: 3px; border-radius: 5px; margin: 5px auto 5px auto; width: 110px;">		
					<i class="fa fa-cube fa-fw"></i>&nbsp;<?php echo $data['merchant_type']; ?>
				</div>
			</td>
			<td style="vertical-align: middle; text-align: center;">
				<?php echo date("d M Y", strtotime($data['req_date'])); ?>
				<!-- Umur waktu -->
				<div style="margin-top: 5px; background: #ccc; padding: 3px 10px; border-radius: 5px; display: inline-block; font-size: 12px;">
					<?php echo timeAgo($data['req_date']); ?>
				</div>
			</td>
			<td style="vertical-align: middle; text-align: center;">
				<div style="vertical-align: middle; background-color: <?php echo $data['req_status'] == 'Disetujui' ? 'green' : '#EB8317'; ?>; color: #fff; padding: 3px; border-radius: 5px; margin: 5px auto 5px auto; width: 110px;">		
					<i class="fa <?php echo $data['req_status'] == 'Disetujui' ? 'fa-check' : 'fa-spinner' ?> fa-fw"></i>&nbsp;<?php echo $data['req_status']; ?>
				</div>
			</td>
			<td style="vertical-align: middle; text-align: center;"><center><a style="text-decoration: none;" href="register_edit2.php?id=<?php echo $data['req_id']; ?>">
				<button class="btn btn-outline btn-block btn-primary btn-xs"><i class="fa fa-eye"></i>&nbsp;Lihat Detail</button>
			</a></center>
			<?php 
				if($data['req_status']!='Disetujui'){
					echo '<center><a style="text-decoration: none;" href="register_acc2.php?id='.$data['req_id'].'">
						<button style="margin-top: 5px;" class="btn btn-outline btn-block btn-success btn-xs"><i class="fa fa-check fa-fw"></i>Setujui</button>
					</a></center>';
					echo '<center><a style="text-decoration: none;" data-toggle="modal" data-target="#modalCancel" href="#">
						<button style="margin-top: 5px;" class="btn btn-outline btn-block btn-danger btn-xs"><i class="fa fa-times fa-fw"></i>Batalkan</button>
					</a></center>';
				}
				else{
					echo '';
				}
			?>
			</td>
		</tr>


		<!-- Modal Cancel -->
			<div class="modal fade" id="modalCancel" tabindex="-1" role="dialog" aria-labelledby="modalCancelLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header bg-primary text-white" style="border-top-left-radius: 5px; border-top-right-radius: 5px;">
							<h5 class="modal-title" id="modalCancelLabel"><b>KONFIRMASI BATAL PENDAFTARAN</b></h5>
							<button style="margin-top: -20px;" type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<p>Apakah Anda yakin ingin membatalkan pendaftaran pedagang?</p>
							<div class="bg-primary" 
								style="color:#fff; padding:4px; border-radius:5px; display:inline-block;">
								<i class="fa fa-user fa-fw d-in"></i>&nbsp;<?php echo $data['req_name']; ?>
							</div>
							<div class="bg-primary" 
								style="color:#fff; padding:4px; border-radius:5px; display:inline-block;">
								<i class="fa fa-th fa-fw d-in"></i>&nbsp;<?php echo $lapak; ?>
							</div>
							<br><br>
							<p><b>Catatan:</b> Data pendaftaran yang dibatalkan tidak dapat dikembalikan lagi!</p>
						</div>
						<div class="modal-footer d-flex justify-content-between">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
							<a href="register_action.php?task=cancel2&id=<?php echo $data['req_id'] ?>" class="btn btn-primary">Ya, batalkan</a>
						</div>
					</div>
				</div>
			</div>
		<?php $no++; } ?>
	</tbody>
</table>