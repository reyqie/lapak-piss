<?php
	include "../connection.php";
	$date_now 	= date("d M Y");
	$id			= $_GET['id'];
	$sql 		= mysql_query("select * from request where req_id = '".$id."'");
	while($r = mysql_fetch_array($sql)){
	$idq 	= sprintf("%04d", $id);
	$lapak	= executeScalar("select lapak_name from lapak where lapak_id = '".$r['lapak_id']."'");
?>
<page backtop="10mm" backbottom="10mm" backleft="10mm" backright="10mm">
    <page_header>
        <table style="width:100%; font-size: 16px; border:0px; margin-top:30px; margin-left:35px; margin-right:10px;">
            <tr>
                <td><b>NO</b></td>
                <td><b> : </b></td>
                <td><b><?php echo 'P-'.$idq; ?></b></td>
            </tr>
        </table>
    </page_header>
    <!-- <page_footer>
        <table style="width: 95%; border: 0px black; margin-bottom:50px; margin-left:10px; margin-right:30px;">
            <tr>
                <td style="text-align: left;width: 65%"></td>
                <td style="text-align: right;width: 35%"></td>
            </tr>
        </table>
    </page_footer> -->
    <br/>
	<div style="font-size: 16px; font-weight: bold; text-align: center; margin-top:30px;">
		SURAT PERMOHONAN TAMBAH LAPAK
		<br>PASAR INDUK SURABAYA SIDOTOPO
	</div>
	<br/><br/><br/><br/>
	<div style="margin-bottom: 15px;font-size:14px;">Saya yang bertanda tangan dibawah ini :</div>
	<table style="margin-bottom: 5px;font-size:14px; width:800px;" id="tableCheckout">
		<tr>
			<td>Nama      </td>
			<td> </td>
		</tr>
		<tr>
			<td style="padding-left: 15px;">KTP        </td>
			<td> : <?php echo $r['req_name']; ?> </td>
		</tr>
		<tr>
			<td style="padding-left: 15px; padding-bottom: 10px;">Alias      </td>
			<td style="padding-bottom: 10px;"> : <?php echo $r['req_nick'] != NULL ? $r['req_nick'] : '-'; ?> </td>
		</tr>
		<tr>
			<td>Alamat      </td>
			<td></td>
		</tr>
		<tr>
			<td style="padding-left: 15px;">KTP		</td>
			<td> : <?php echo $r['address1']; ?></td>
		</tr>
		<tr>
			<td style="padding-left: 15px; padding-bottom: 10px;">Surat 	 	</td>
			<td style="padding-bottom: 10px;"> : <?php echo $r['address2']; ?></td>
		</tr>
		<tr>
			<td style="padding-bottom: 10px;">No. Telp	</td>
			<td style="padding-bottom: 10px;"> : <?php echo $r['phone1'];
			if ($r['phone1']!=$r['phone2']){echo ' / '.$r['phone2'];}?></td>
		</tr>
		<tr>
			<td>No. Identitas</td><td> </td>
		</tr>
		<tr>
			<td style="padding-left: 15px;">KTP		</td>
			<td> : <?php echo $r['nid_ktp'] == '' ? '-' : $r['nid_ktp']; ?></td>
		</tr>
		<tr>
			<td style="padding-left: 15px;">SIM		</td>
			<td> : <?php echo $r['nid_sim'] == '' ? '-' : $r['nid_sim']; ?></td>
		</tr>
		<tr>
			<td style="padding-left: 15px;">Lainnya	</td>
			<td> : <?php echo $r['nid_lain'] == '' ? '-' : $r['nid_lain']; ?></td>
		</tr>
		<tr>
			<td style="padding-top: 10px;">Jenis Jualan</td>
			<td style="padding-top: 10px;"> : <?php echo $r['merchant_type']; ?></td>
		</tr>
		<tr>
			<td style="padding-top: 10px;">Lapak		</td><td> : <?php echo $lapak; ?></td>
		</tr>
	</table>
    <br /><br />
	<div style="font-size:14px;">Dengan ini memohon untuk menempati lapak di PISS dan menyetujui serta melaksanakan ketentuan yang berlaku sebagai berikut :
	<br><br>
		<table>
			<tr>
				<td>1. </td>
				<td>Patuh pada aturan yang berlaku saat ini maupun yang akan ditetapkan dikemudian hari.</td>
			</tr>
			<tr>
				<td>2. </td>
				<td>Membayar semua kewajiban keuangan sesuai ketentuan manajemen.</td>
			</tr>
			<tr>
				<td>3. </td>
				<td>Segera melakukan aktivitas berjualan maksimal 7 (tujuh) hari kalender sejak disetujui surat permohonan ini.</td>
			</tr>
		</table>
	</div>

	<br /><br /><br /><br />
	<table style="width: 100%; border: 0px black; margin-bottom:50px; margin-left:10px; margin-right:30px;font-size:14px;">
		<tr>
			<td style="text-align: left;width: 70%;"></td>
			<td style="text-align: right;width: 30%;">Surabaya, <?php echo $date_now; ?><br /></td>
		</tr>
		<tr>
			<td style="text-align: left;width: 70%;"></td>
			<td style="text-align: center;width: 30%;"><br/><br/>Pemohon,<br /><br /><br /></td>
		</tr>
		<tr>
			<td style="text-align: left;width: 10%;"></td>
			<td style="text-align: center;width: 90;%"><br/><br/>( <?php echo $r['req_name']; ?> )</td>
		</tr>
	</table>
</page>
<?php } ?>