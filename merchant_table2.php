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
	$('#employeeView').dataTable({"aLengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]]});
	});
</script>
<table id="employeeView" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th style="width:5%;">No</th>
			<th style="width:25%;">Nama</th>
			<th style="width:20%;">Tlp</th>
			<th style="width:20%;">Domisili</th>
			<th style="width:10%;">Jualan</th>
			<th style="width:10%;">Lapak</th>
			<th style="width:10%;">DP</th>
			<th style="width:10%;">Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$sql 	= "select * from pedagang order by id_pedagang desc";
		$query 	= mysql_query($sql);
		$no		= 1;
			while($data=mysql_fetch_array($query)) { 
		?>
		<tr>
			<td style="text-align:center;"><?php echo $no; ?></td>
			<td><?php echo $data[1]; ?></td>
			<td><?php echo $data[2]; ?></td>
			<td><?php echo $data[3]; ?></td>
			<td><?php echo $data[7]; ?></td>
			<td><?php 
				$lapak 	= executeScalar("select lapak_total from lapak where lapak_id='".$data[5]."' ");
				echo format_rupiah($lapak); ?></td>
			
			<td><?php echo format_rupiah($data[8]); ?></td>
			<td><center><a href="home_edit.php?id=<?php echo $data[0]; ?>"><button class="btn btn-outline btn-block btn-primary btn-xs">Pindah Lapak</button></a></center></td>
		</tr>
		<?php
			$no++;
			}
		?>
	</tbody>
</table>