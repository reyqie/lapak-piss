<?php
	include "../connection.php";
	$year	= date('Y');
	$mtype	= $_POST['mtype'];
	$sts	= $_POST['sts'];
	
	//select tonase berdasarkan komoditi & Status
	if($sts=='Semua'){
		if($mtype=='Semua'){
			$sql 	= "select * from merchant order by merchant_id";
			$total 	= executeScalar("select count(merchant_id) from merchant");
		}
		else{
			$sql 	= "select * from merchant where merchant_type = '".$mtype."' order by merchant_id";
			$total 	= executeScalar("select count(merchant_id) from merchant 
			where merchant_type = '".$mtype."'");
		}
	}
	else{
		if($mtype=='Semua'){
			$sql 	= "select * from merchant where merchant_status = '".$sts."' order by merchant_id";
			$total 	= executeScalar("select count(merchant_id) from merchant where merchant_status = '".$sts."'");
		}
		else{
			$sql 	= "select * from merchant where merchant_type = '".$mtype."' and merchant_status = '".$sts."'
			order by merchant_id";
			$total 	= executeScalar("select count(merchant_id) from merchant 
			where merchant_type = '".$mtype."' and merchant_status = '".$sts."'");
		}
	}
?>
<page backtop="20mm" backbottom="10mm" backleft="5mm" backright="5mm">
    <!-- <page_header>
        <table style="width:95%; border:0px; margin-top:30px; margin-left:10px; margin-right:10px;">
            <tr>
                <td style="text-align: left; width: 33%">www.paskomnas.com</td>
                <td style="text-align: center; width: 34%"></td>
                <td style="text-align: right; width: 33%"><?php echo date("d M Y", strtotime($date_now)); ?></td>
            </tr>
        </table>
    </page_header> -->
    <page_footer>
        <table style="width: 95%; border: 0px black; margin-bottom:50px; margin-left:10px; margin-right:30px;">
            <tr>
                <td style="text-align: left;width: 33%"><?php echo date("d M Y", strtotime($date_now)); ?></td>
				<td style="text-align: left;width: 34%"></td>
                <td style="text-align: right;width: 33%">Halaman [[page_cu]]/[[page_nb]]</td>
            </tr>
        </table>
    </page_footer>
	    <h4 style="text-align:center; margin-top: -30px;">LAPORAN DATA PEDAGANG PER JENIS JUALAN</h4><br>
	    <h4 style="text-align:center; margin-top: -30px;">PASAR INDUK SURABAYA SIDOTOPO (PISS)</h4><br><br>
	Jumlah Pedagang : <?php echo $total; ?> Orang <br /><br>
	Status Pedagang : <?php echo $sts; ?> <br /><br>
	<table style="border: solid 1px black; border-collapse: collapse; margin-bottom: 5px;font-size:10pt; width:1050px; margin-top:10px;" id="merchant">
		<thead>
			<tr>
				<th style="vertical-align: middle; width:4%; text-align: center; border: solid 1px black;">NO</th>
				<th style="vertical-align: middle; width:5%; text-align:center; border: solid 1px black;">KODE</th>
				<th style="vertical-align: middle; width:16%; text-align:center; border: solid 1px black;">NAMA PEDAGANG</th>
				<th style="vertical-align: middle; width:10%; text-align:center; border: solid 1px black;">TLP RUMAH</th>
				<th style="vertical-align: middle; width:11%; text-align:center; border: solid 1px black;">HANDPHONE</th>
				<th style="vertical-align: middle; width:27%; text-align:center; border: solid 1px black;">ALAMAT</th>
				<th style="vertical-align: middle; width:12%; text-align:center;  border: solid 1px black;">LAPAK</th>
				<th style="vertical-align: middle; width:8%; text-align:center; border: solid 1px black;">JENIS PEDAGANG</th>
				<th style="vertical-align: middle; width:7%; text-align:center;  border: solid 1px black;">STATUS</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$query 	= mysql_query($sql);
				$no		= 1;
				
				while($data=mysql_fetch_array($query)) {
					if($data['phone1']!=''){
						$p1 = $data['phone1'];
					}
					else{
						$p1 = '-';
					}
					if($data['phone2']!=''){
						$p2 = $data['phone2'];
					}
					else{
						$p2 = '-';
					}
					
					$sql2 	= mysql_query("select l.lapak_name from rent r, lapak l
							where r.lapak_id = l.lapak_id and 
							r.merchant_id = '".$data['merchant_id']."' and
							(r.rent_sts2 != 'Pindah' && r.rent_sts2 != 'Batal')
							order by l.lapak_name limit 7");
					$string	= "";
					$counter= 0;
					while($row=mysql_fetch_array($sql2)){
						if($counter!=0){
							$string = ", ".$string;
						}
						$string = $row['lapak_name'].$string;
						$counter++;
					}
					$lapak 	= "".$string;
			?>
			<tr>
				<td style="vertical-align: middle; width:4%; text-align:center; border: solid 1px black;"><?php echo $no; ?></td>
				<td style="vertical-align: middle; width:5%; text-align:center; border: solid 1px black;"><?php echo $data['merchant_id']; ?></td>
				<td style="vertical-align: middle; width:16%; text-align:left; border: solid 1px black;"><?php echo $data['merchant_name']; ?></td>
				<td style="vertical-align: middle; width:10%; text-align:center; border: solid 1px black;"><?php echo $p1; ?></td>
				<td style="vertical-align: middle; width:11%; text-align:center; border: solid 1px black;"><?php echo $p2; ?></td>
				<td style="vertical-align: middle; width:27%; text-align:left; border: solid 1px black;"><?php echo $data['address1']; ?></td>
				<td style="vertical-align: middle; width:12%; text-align:left; border: solid 1px black;"><?php echo $lapak != NULL ? $lapak : '-' ?></td>
				<td style="vertical-align: middle; width:6%; text-align:center; border: solid 1px black;"><?php echo $data['merchant_type']; ?></td>
				<td style="vertical-align: middle; width:7%; text-align:center; border: solid 1px black;"><?php echo $data['merchant_status']; ?></td>
			</tr>
			<?php $no++;} ?>
		</tbody>
	</table>
</page>