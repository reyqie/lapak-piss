<?php
	include "connection.php";
	function executeScalar($sql,$def=0){
		$rs = mysql_query($sql) or die(mysql_error().$sql);
		if (mysql_num_rows($rs)) {$r = mysql_fetch_row($rs);mysql_free_result($rs);return $r[0];}
		return $def;
	}
?>
<!-- jquery -->
<script src="dataTables/jquery.dataTables.js"></script>
<script src="dataTables/dataTables.tableTools.js"></script>
<script src="dataTables/dataTables.bootstrap.js"></script>
<script>
	$(document).ready(function() {
	//data table
	$('#maintenanceView').dataTable({"aLengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]]});
	});
</script>
<table id="maintenanceView" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th style="width:5%;">No</th>
			<th style="width:17%;">Nama Pedagang</th>
			<th style="width:27%;">Lapak</th>
			<th style="width:11%;">Jumlah Cicilan</th>
			<th style="width:12%;">Sisa Bayar</th>
			<th style="width:18%;">Keterangan</th>
			<th style="width:10%;">Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$sql 	= "select * from bayar";
		$query 	= mysql_query($sql);
		$no		= 1;
		$sisa	= 0;
			while($data=mysql_fetch_array($query)) { 
		?>
		<tr>
			<td><center><?php echo $no; ?></center></td>
			<td>
			<?php 
				$sql 		= mysql_query("select nama from pedagang where id_pedagang='".$data[1]."'");
				while($d = mysql_fetch_array($sql))
			{
				echo $d['nama'];
			} ?></td>
			<td>
			<?php 
				$sql 		= mysql_query("select lapak_nama from lapak where lapak_id='".$data[2]."'");
				while($r = mysql_fetch_array($sql))
			{
				echo $r['lapak_nama'];
			} ?>
			</td>
			<td><?php echo format_rupiah($data[3]); ?></td>
			<td>
			<?php 
				$cicilan= executeScalar("select sum(jumlah) from bayar where id_pedagang='".$data[1]."' ");
				$dp 	= executeScalar("select dp from pedagang where id_pedagang='".$data[1]."' ");
				$lapak 	= executeScalar("select lapak_total from lapak where lapak_id='".$data[2]."' ");
				
				$sisa 	= $lapak-$dp-$cicilan;
				echo format_rupiah($sisa);
				?>
			</td>
			<td><?php echo $data[4]; ?></td>
			<td><center><button class="btn btn-outline btn-block btn-primary btn-xs" href="construction_edit.php?id=<?php echo $data[0]; ?>">Edit</button></center></td>
		</tr>
		<?php
			$no++;
			}
		?>
	</tbody>
</table>