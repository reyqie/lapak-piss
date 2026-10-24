<?php
	include "../connection.php";
	$year	= date('Y');
	$total 	= executeScalar("select count(distinct(m.merchant_id)) from merchant m, lapak l, rent r 
			where m.merchant_id = r.merchant_id and
			l.lapak_id = r.lapak_id and
			m.merchant_status = 'Aktif' and
			(r.rent_sts2 != 'Batal' && r.rent_sts2 != 'Pindah') and
			l.block_id = '".$_POST['block']."'");
	$sql 	= "select * from merchant m, lapak l, rent r 
			where m.merchant_id = r.merchant_id and
			l.lapak_id = r.lapak_id and
			(r.rent_sts2 != 'Batal' && r.rent_sts2 != 'Pindah') and
			m.merchant_status = 'Aktif' and
			l.block_id = '".$_POST['block']."' 
			order by l.lapak_no";
?>
<page backtop="20mm" backbottom="10mm" backleft="5mm" backright="5mm">
    <!-- <page_header>
        <table style="width:95%; border:0px; margin-top:30px; margin-left:30px; margin-right:30px;">
			<tr>
                <td style="text-align: left;width: 33%"><?php echo date("d M Y", strtotime($date_now)); ?></td>
				<td style="text-align: left;width: 34%"></td>
                <td style="text-align: right;width: 33%">Halaman [[page_cu]]/[[page_nb]]</td>
            </tr>
        </table>
    </page_header> -->
    <page_footer>
        <table style="width: 100%; border: 0px black; margin-bottom:50px; margin-left:15px; margin-right:15px;">
			<tr>
                <td style="text-align: left;width: 33%"><?php echo date("d M Y", strtotime($date_now)); ?></td>
				<td style="text-align: left;width: 34%"></td>
                <td style="text-align: right;width: 33%">Halaman [[page_cu]]/[[page_nb]]</td>
            </tr>
        </table>
    </page_footer>
	    <h4 style="text-align:center; margin-top: -30px;">LAPORAN DATA PEDAGANG BLOK <?php echo $_POST['block']; ?></h4><br>
	    <h4 style="text-align:center; margin-top: -30px;">PASAR INDUK SURABAYA SIDOTOPO (PISS)</h4><br>
	Jumlah Pedagang: <?php echo $total; ?> Orang <br /><br>
	<table style="border: solid 1px black; border-collapse: collapse; margin-bottom: 5px;font-size:9pt; width:100%; margin-top:10px;" id="merchant">
		<thead>
			<tr>
				<th style="vertical-align: middle; width:5%; text-align: center; border: solid 1px black;">NO</th>
				<th style="vertical-align: middle; width:5%; text-align:center; border: solid 1px black;">KODE</th>
				<th style="vertical-align: middle; width:20%; text-align:center; border: solid 1px black;">NAMA PEDAGANG</th>
				<th style="vertical-align: middle; width:9%; text-align:center; border: solid 1px black;">TELP RUMAH</th>
				<th style="vertical-align: middle; width:9%; text-align:center; border: solid 1px black;">HANDPHONE</th>
				<th style="vertical-align: middle; width:30%; text-align:center; border: solid 1px black;">ALAMAT</th>
				<th style="vertical-align: middle; width:5%; text-align:center; border: solid 1px black;">LAPAK</th>
				<th style="vertical-align: middle; width:8%; text-align:center; border: solid 1px black;">JENIS PEDAGANG</th>
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
			?>
			<tr>
				<td style="width:4%; text-align:center; vertical-align:middle; border: solid 1px black;"><?php echo $no; ?></td>
				<td style="width:5%; text-align:center; vertical-align:middle; border: solid 1px black;"><?php echo $data['merchant_id']; ?></td>
				<td style="width:20%; text-align:left; vertical-align:middle; border: solid 1px black;"><?php echo $data['merchant_name']; ?></td>
				<td style="width:12%; text-align:center; vertical-align:middle; border: solid 1px black;"><?php echo $p1; ?></td>
				<td style="width:12%; text-align:center; vertical-align:middle; border: solid 1px black;"><?php echo $p2; ?></td>
				<td style="width:35%; text-align:left; vertical-align:middle; border: solid 1px black;"><?php echo $data['address1']; ?></td>
				<td style="width:5%; text-align:center; vertical-align:middle; border: solid 1px black;"><?php echo $data['lapak_name']; ?></td>
				<td style="width:6%; text-align:center; vertical-align:middle; border: solid 1px black;"><?php echo $data['merchant_type']; ?></td>
			</tr>
			<?php $no++;} ?>
		</tbody>
	</table>
</page>