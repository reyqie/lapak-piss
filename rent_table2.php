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
	$('#rentView2').dataTable({
		dom: "<'row'<'col-sm-8'l><'col-sm-4'f>>" +  
			"<'row'<'col-sm-12'tr>>" +
			"<'row'<'col-sm-7'i><'col-sm-5'p>>",
		"aLengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]]});
	});
</script>
<!-- <h3 style="text-align:center;">Data Angsuran Lapak PIOS Yang Terlambat</h3> -->
<table id="rentView2" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th style="width:5%; text-align:center;">NO</th>
			<th style="width:7%; text-align:center;">NIP</th>
			<th style="width:20%; text-align:center;">PEDAGANG</th>
			<th style="width:7%; text-align:center;">LAPAK</th>
			<th style="width:10%;text-align:center;">SISA ANGSURAN</th>
			<th style="width:10%;text-align:center;">ANGSURAN</th>
			<th style="width:10%;text-align:center;">ANGSURAN KE-</th>
			<th style="width:10%;text-align:center;">JATUH TEMPO</th>
			<th style="width:10%;text-align:center;">AKSI</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$no		= 1;
			//$sql 	= "select * from rent where rent_dl < '".$date_now."' and rent_sts != 'Batal' order by rent_dl";
			$sql 	= "select r.rent_id, r.instalment_id, r.rent_instalment, r.merchant_id, m.merchant_name, r.lapak_id, r.leftover2, r.rent_dl 
			from rent r, merchant m
			where r.merchant_id = m.merchant_id and 
			r.rent_dl < '".$date_now."' and
			m.merchant_status = 'Aktif' and
			r.rent_sts != 'Batal' 
			order by r.rent_dl desc";
			$query 	= mysql_query($sql);
			while($r=mysql_fetch_array($query)){
				$cicilan 	= executeScalar("select instalment_count from instalment where instalment_id = '".$r['instalment_id']."'");
				$lapak 		= executeScalar("select lapak_name from lapak where lapak_id='".$r['lapak_id']."' ");
				
				//hitung sisa angsuran
				$total1 	= executeScalar("select (sum(trans_total)+sum(cash_total)) as total from rent_detail where rent_id='".$r['rent_id']."' ");
				$sisa		= $r['leftover2']-$total1;
				
				//Hitung Angsuran ke brp yg belum dibayar
				$angsrn 	= executeScalar("select count(rent_detail_id) from rent_detail where rent_id='".$r['rent_id']."' ");
				$angsrn 	= $angsrn+1;
				
				if($sisa<=0){
					$angsrn = 'Lunas';
				}
		?>
		<tr>
			<td style="text-align:center;"><?php echo $no; ?></td>
			<td style="text-align:center;"><?php echo $r['merchant_id']; ?></td>
			<td style="text-align:left;"><?php echo $r['merchant_name']; ?></td>
			<td style="text-align:center;"><?php echo $lapak; ?></td>
			<td style="text-align:right;"><?php
				if($sisa<=0){
					echo '-';
				}
				else{
					echo format_rupiah($sisa);
				}?></td>
			<td style="text-align:right;"><?php echo format_rupiah($r['rent_instalment']); ?></td>
			<td style="text-align:center;"><?php echo $angsrn; ?></td>
			<td style="text-align:center;"><?php echo date("d M Y", strtotime($r['rent_dl'])); ?></td>
			<td><center><a href="rent_edit.php?id=<?php echo $r['rent_id']; ?>">
			<button class="btn btn-outline btn-block btn-primary btn-xs"><i class="fa fa-money"></i>&nbsp;&nbsp;Bayar</button>
			</a></center></td>
		</tr>
		<?php $no++; } ?>
	</tbody>
</table>