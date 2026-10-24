<?php
	include "../connection.php";
	$year	= date('Y');
	$mtype	= $_POST['mtype'];
	if($mtype=='Semua'){
		$sql = "select m.merchant_id, m.merchant_name 
		from merchant m, lapak l, rent r
		where m.merchant_id = r.merchant_id and
		l.lapak_id = r.lapak_id and
		m.merchant_status = 'Aktif' and
		r.rent_sts != 'Batal' and
		r.rent_sts2 != 'Batal' and
		r.rent_sts2 != 'pindah'
		group by m.merchant_id
		order by l.block_id, l.lapak_no";
		$total = executeScalar("select count(distinct(m.merchant_id)) from merchant m, rent r
		where m.merchant_id = r.merchant_id and m.merchant_status = 'Aktif'");
	}
	elseif($mtype=='Buah'){
		$sql = "select m.merchant_id, m.merchant_name 
		from merchant m, lapak l, rent r
		where m.merchant_id = r.merchant_id and
		l.lapak_id = r.lapak_id and
		m.merchant_status = 'Aktif' and
		m.merchant_type = 'Buah' and
		r.rent_sts != 'Batal' and
		r.rent_sts2 != 'Batal' and
		r.rent_sts2 != 'pindah'
		group by m.merchant_id
		order by l.block_id, l.lapak_no";
		$total = executeScalar("select count(distinct(m.merchant_id)) from merchant m, rent r
		where m.merchant_id = r.merchant_id and m.merchant_status = 'Aktif' and
		m.merchant_type = 'Buah'");
	}
	elseif($mtype=='Sayur'){
		$sql = "select m.merchant_id, m.merchant_name 
		from merchant m, lapak l, rent r
		where m.merchant_id = r.merchant_id and
		l.lapak_id = r.lapak_id and
		m.merchant_status = 'Aktif' and
		m.merchant_type = 'Sayur' and
		r.rent_sts != 'Batal' and
		r.rent_sts2 != 'Batal' and
		r.rent_sts2 != 'pindah'
		group by m.merchant_id
		order by l.block_id, l.lapak_no";
		$total = executeScalar("select count(distinct(m.merchant_id)) from merchant m, rent r
		where m.merchant_id = r.merchant_id and m.merchant_status = 'Aktif' and
		m.merchant_type = 'Sayur'");
	}
	elseif($mtype=='Lainnya'){
		$sql = "select m.merchant_id, m.merchant_name 
		from merchant m, lapak l, rent r
		where m.merchant_id = r.merchant_id and
		l.lapak_id = r.lapak_id and
		m.merchant_status = 'Aktif' and
		m.merchant_type = 'Lainnya' and
		r.rent_sts != 'Batal' and
		r.rent_sts2 != 'Batal' and
		r.rent_sts2 != 'pindah'
		group by m.merchant_id
		order by l.block_id, l.lapak_no";
		$total = executeScalar("select count(distinct(m.merchant_id)) from merchant m, rent r
		where m.merchant_id = r.merchant_id and m.merchant_status = 'Aktif' and
		m.merchant_type = 'Lainnya'");
	}
	/*$total 	= executeScalar("select count(m.merchant_id) from merchant m, lapak l, rent r 
			where m.merchant_id = r.merchant_id and
			l.lapak_id = r.lapak_id and
			m.merchant_status = 'Aktif' and
			l.block_id = '".$_POST['block']."'");*/
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
        <table style="width: 95%; border: 0px black; margin-bottom:50px; margin-left:10px; margin-right:10px;">
			<tr>
                <td style="text-align: left;width: 33%"><?php echo date("d M Y", strtotime($date_now)); ?></td>
				<td style="text-align: left;width: 34%"></td>
                <td style="text-align: right;width: 33%">Halaman [[page_cu]]/[[page_nb]]</td>
            </tr>
        </table>
    </page_footer>
    <h4 style="text-align:center; margin-top: -30px;">LAPORAN DATA PIUTANG PER PEDAGANG</h4><br>
    <h4 style="text-align:center; margin-top: -30px;">PASAR INDUK SURABAYA SIDOTOPO (PISS)</h4><br>
	Jumlah Pedagang : <?php echo $total; ?> Orang <br /><br>
	Jenis Pedagang : <?php echo $mtype; ?><br /><br>
	<table style="border: solid 1px black; border-collapse: collapse; margin-bottom: 5px;font-size:10pt; width:1050px; margin-top:10px;" id="merchant">
		<thead>
			<tr>
				<th style="vertical-align: middle; width:4%; text-align: center; border: solid 1px black;">NO</th>
				<th style="vertical-align: middle; width:6%; text-align:center; border: solid 1px black;">KODE</th>
				<th style="vertical-align: middle; width:20%; text-align:center; border: solid 1px black;">NAMA PEDAGANG</th>
				<th style="vertical-align: middle; width:15%; text-align:center; border: solid 1px black;">LAPAK</th>
				<th style="vertical-align: middle; width:10%; text-align:center; border: solid 1px black;">LUAS</th>
				<th style="vertical-align: middle; width:10%; text-align:center; border: solid 1px black;">TOTAL HARGA (RP)</th>
				<th style="vertical-align: middle; width:10%; text-align:center; border: solid 1px black;">UANG MUKA (RP)</th>
				<th style="vertical-align: middle; width:10%; text-align:center; border: solid 1px black;">PIUTANG (RP)</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$query 	= mysql_query($sql);
				$no		= 1;
				$totalPrice = 0;
				$totalDP = 0;
				$totalLeftPay = 0;
				while($data = mysql_fetch_array($query)) {
					$sql2 	= mysql_query("select l.lapak_name from rent r, lapak l
					where r.lapak_id = l.lapak_id and 
					r.merchant_id = '".$data['merchant_id']."' and
					r.rent_sts2 != 'Pindah'
					order by l.lapak_no desc ");
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
					
					$sql3 	= mysql_query("select sum(l.lapak_size) as size, sum(l.lapak_total) as total,
					sum(r.rent_dp) as dp, sum(r.leftover) as lo
					from rent r, lapak l
					where r.lapak_id = l.lapak_id and 
					r.merchant_id = '".$data['merchant_id']."' and
					r.rent_sts != 'Batal' and
					r.rent_sts2 != 'Batal' and
					r.rent_sts2 != 'pindah'");
					$counter= 0;
					while($row=mysql_fetch_array($sql3)){
						$size = $row['size'];
						$total = $row['total'];
						$dp = $row['dp'];
						$lo = $row['lo'];
						$counter++;
					}

				$totalPrice += $total;
				$totalDP += $dp;
				$totalLeftPay += $lo;
			?>
			<tr>
				<td style="width:4%; text-align:center; vertical-align:middle; border: solid 1px black;"><?php echo $no; ?></td>
				<td style="width:6%; text-align:center; vertical-align:middle; border: solid 1px black;"><?php echo $data['merchant_id']; ?></td>
				<td style="width:20%; text-align:left; vertical-align:middle; border: solid 1px black;"><?php echo $data['merchant_name']; ?></td>
				<td style="width:18%; text-align:left; vertical-align:middle; border: solid 1px black;"><?php echo $lapak; ?></td>
				<td style="width:10%; text-align:right; vertical-align:middle; border: solid 1px black;"><?php echo $size; ?> M<sup>2</sup></td>
				<td style="width:12%; text-align:right; vertical-align:middle; border: solid 1px black;"><?php echo format_rupiah($total); ?></td>
				<td style="width:12%; text-align:right; vertical-align:middle; border: solid 1px black;"><?php echo format_rupiah($dp); ?></td>
				<td style="width:12%; text-align:right; vertical-align:middle; border: solid 1px black;"><?php echo format_rupiah($lo); ?></td>
			</tr>
			<?php $no++;} ?>
			<tr>
				<td style="width:12%; text-align:center; vertical-align:middle; border: solid 1px black;" colspan="5"><b>TOTAL</b></td>
				<td style="width:12%; text-align:right; vertical-align:middle; border: solid 1px black;"><b><?php echo format_rupiah($totalPrice); ?></b></td>
				<td style="width:12%; text-align:right; vertical-align:middle; border: solid 1px black;"><b><?php echo format_rupiah($totalDP); ?></b></td>
				<td style="width:12%; text-align:right; vertical-align:middle; border: solid 1px black;"><b><?php echo format_rupiah($totalLeftPay); ?></b></td>
			</tr>
		</tbody>
	</table>
</page>