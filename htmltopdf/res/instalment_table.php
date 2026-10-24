<?php
	include "../connection.php";
	$date_now 	= date("d-m-Y");
	$no			= date("my");
	$sql 		= mysql_query("select * from rent where rent_id = '".$_GET['id']."'");
	while($r = mysql_fetch_array($sql)){
	$name		= executeScalar("select merchant_name from merchant where merchant_id = '".$r['merchant_id']."'");
	$lapak		= executeScalar("select lapak_name from lapak where lapak_id = '".$r['lapak_id']."'");
	$iid 		= executeScalar("select instalment_id from rent where lapak_id = '".$r['lapak_id']."'");
	$ins 		= executeScalar("select instalment_count from instalment where instalment_id = '".$iid."'");
	
	//ambil jml brp kali telah melakukan cicilan
	$ins_total	= executeScalar("select count(rent_detail_id) from rent_detail where rent_id = '".$r['rent_id']."'");
	if($ins_total==''){
		$ins_total=1;
	}else{
		$ins_total=$ins_total+1;
	}
	//generate tgl jatuh tempo
	/*$date_in 	= $r['rent_date'];
	$date_plus	= $r['instalment_no'].' month';
	$exp 		= strtotime($date_plus, strtotime($date_in));
	$dateline 	= date('Y-m-j' , $exp);*/
?>
<page backtop="10mm" backbottom="10mm" backleft="10mm" backright="10mm">
    <page_header>
		<table style="width:100%; font-size: 16px; border:0px; margin-top:30px; margin-left:35px; margin-right:10px;">
            <tr>
                <td><b>NO</b></td>
                <td><b> : </b></td>
                <td><b><?php echo "(".$no.") ".$r['merchant_id']; ?></b></td>
            </tr>
        </table>
    </page_header>
    <page_footer>
        <table style="width: 95%; border: 0px black; margin-bottom:50px; margin-left:10px; margin-right:30px;">
            <tr>
                <td style="text-align: left;width: 65%"></td>
                <td style="text-align: right;width: 35%"></td>
            </tr>
        </table>
    </page_footer>
	<br/>
	<div style="font-size: 16px; font-weight: bold; text-align: center; margin-top:30px;">
		ANGSURAN LAPAK
		<br>PASAR INDUK SURABAYA SIDOTOPO
	</div>
	<br/><br/><br>
	<table style="margin-bottom: 5px;font-size:12pt;" id="tableInstalment">
		<tr><td>ID Pedagang			</td><td> : <?php echo $r['merchant_id']; ?></td></tr>
		<tr><td>Nama       			</td><td> : <?php echo $name; ?> </td></tr>
		<tr><td>Lapak				</td><td> : <?php echo $lapak; ?></td></tr>
		<tr><td>Total Angsuran 		</td><td> : <?php echo format_rupiah($r['leftover2']); ?></td></tr>
		<tr><td>Angsuran Saat Ini	</td><td> : <?php echo $ins_total; ?></td></tr>
		<tr><td>Tanggal Masuk		</td><td> : <?php echo date("d M Y", strtotime($r['rent_date'])); ?></td></tr>
	</table>
    <br /><br><br>
	<div style="font-size: 16px; font-weight: bold; text-align: center; margin-top:0px; margin-bottom:10px;">
		TABEL ANGSURAN LAPAK <?php echo $lapak; ?>
	</div><br>
	<table style="width:100%;border:1px black;border-collapse: collapse; font-size:11pt;">
		<tr>
			<th style="text-align: center;width: 10%; border: solid 1px black;">NO</th>
			<th style="text-align: center;width: 45%;border: solid 1px black;">JATUH TEMPO</th>
			<th style="text-align: center;width: 45%; border: solid 1px black;">JUMLAH ANGSURAN</th>
		</tr>
		<?php
			$date 	= $r['rent_dl'];
			
			$i	= 0;
			$x	= 0-1;
			while($i<$ins) {
			$i++;
			$x++;
			$date_plus 	= strtotime($x.' month', strtotime($date));
			$dateline 	= date('Y-m-j' , $date_plus);
		?>
		<tr>
			<td style="text-align: center;border: solid 1px black;"><?php echo $i; ?>.</td>
			<td style="text-align: center;border: solid 1px black;"><?php echo date("d M Y", strtotime($dateline)); ?></td>
			<td style="text-align: right;border: solid 1px black;"><?php echo format_rupiah($r['rent_instalment']); ?></td>
		</tr>
		<?php } ?>
	</table>
</page>
<?php } ?>