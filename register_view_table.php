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
<!-- <h3>Daftar Pemohon Lapak PIOS</h3> -->
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
			<th style="text-align: center; vertical-align: middle; width:10%;">TGL PENGAJUAN</th>
			<th style="text-align: center; vertical-align: middle; width:8%;">STATUS</th>
			<th style="text-align: center; vertical-align: middle; width:7%;">AKSI</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$sql 	= "select * from request where req_status = 'Disetujui' order by req_id desc";
			$query 	= mysql_query($sql);
			$no		= 1;
			while($data=mysql_fetch_array($query)){
			$lapak 	= executeScalar("select lapak_name from lapak where lapak_id='".$data['lapak_id']."' ");
			$rid 	= executeScalar("select rent_id from rent where req_id='".$data['req_id']."' ");
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
				<?php echo date("d M Y", strtotime($data['req_date'])); ?><br>
				<div style="vertical-align: middle; background-color: #4c575fff; color: #fff; padding: 3px; border-radius: 5px; margin: 5px auto 5px auto; width: 110px;">		
					<?php 
						if($data['req_reffer'] != ''){
							echo "Tambah Lapak";
						} else {
							echo "Daftar Baru";
						}
					?>
				</div>
			</td>
			<td style="vertical-align: middle; text-align: center;">
				<div style="vertical-align: middle; background-color: <?php echo $data['req_status'] == 'Disetujui' ? 'green' : '#EB8317'; ?>; color: #fff; padding: 3px; border-radius: 5px; margin: 5px auto 5px auto; width: 110px;">		
					<i class="fa <?php echo $data['req_status'] == 'Disetujui' ? 'fa-check' : 'fa-spinner' ?> fa-fw"></i>&nbsp;<?php echo $data['req_status']; ?>
				</div>
			</td>
			<?php if($data['req_reffer'] == ''){ ?>
				<td style="vertical-align: middle; text-align: center;"><center><a style="text-decoration: none;" href="register_edit.php?id=<?php echo $data['req_id']; ?>">
					<button class="btn btn-outline btn-block btn-primary btn-xs"><i class="fa fa-eye"></i>&nbsp;Lihat Detail</button>
				</a></center>
				</td>
			<?php } else { ?>
				<td style="vertical-align: middle; text-align: center;"><center><a style="text-decoration: none;" href="register_edit2.php?id=<?php echo $data['req_id']; ?>">
					<button class="btn btn-outline btn-block btn-primary btn-xs"><i class="fa fa-eye"></i>&nbsp;Lihat Detail</button>
				</a></center>
				</td>
			<?php } ?>
		</tr>
		<?php $no++; } ?>
	</tbody>
</table>