<?php
	include "../connection.php";
	$date_now 	= date("d-m-Y");
	$no			= date("my");
	$id			= $_GET['id'];
	$sql 		= mysql_query("select * from rent_detail where rent_detail_id = '".$id."'");
	while($r = mysql_fetch_array($sql)){
	
	//$rid 		= executeScalar("select rent_id from rent_detail where rent_detail_id = '".$id."'");
	$mid 		= executeScalar("select merchant_id from rent where rent_id = '".$r['rent_id']."'");
	$lid 		= executeScalar("select lapak_id from rent where rent_id = '".$r['rent_id']."'");
	$name		= executeScalar("select merchant_name from merchant where merchant_id = '".$mid."'");
	$lapak		= executeScalar("select lapak_name from lapak where lapak_id = '".$lid."'");
	$iid 		= executeScalar("select instalment_id from rent where lapak_id = '".$lid."'");
	$ins 		= executeScalar("select instalment_count from instalment where instalment_id = '".$iid."'");
	$rd 		= executeScalar("select rent_date from rent where rent_id = '".$r['rent_id']."'");
	
	//generate tgl jatuh tempo
	$date_in 	= $rd;
	$date_plus	= $r['instalment_no'].' month';
	$exp 		= strtotime($date_plus, strtotime($date_in));
	$dateline 	= date('Y-m-j' , $exp);
?>
<page backtop="10mm" backbottom="10mm" backleft="10mm" backright="10mm">
    <page_header>
        <table style="width:95%; border:0px; margin-top:30px; margin-left:10px; margin-right:10px;">
            <tr>
                <td style="text-align: left;    width: 33%">www.paskomnas.com</td>
                <td style="text-align: center;    width: 34%"></td>
                <td style="text-align: right;    width: 33%">No: <?php echo $no.$mid; ?></td>
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
    <div style="font-size: 18px; font-weight: bold; text-align: center; margin-top:30px;">
		Pembayaran Angsuran Lapak PIOS
	</div>
	<br/><br/>
	<table style="margin-bottom: 5px;font-size:12pt;" id="tableInstalment">
		<tr><td>ID Pedagang			</td><td> : <?php echo $mid; ?></td></tr>
		<tr><td>Nama       			</td><td> : <?php echo $name; ?> </td></tr>
		<tr><td>Lapak				</td><td> : <?php echo $lapak; ?></td></tr>
		<tr><td>Angsuran Ke			</td><td> : <?php echo $r['instalment_no']; ?></td></tr>
		<tr><td>Jumlah Angsuran 	</td><td> : <?php echo format_rupiah($r['cash_total']+$r['trans_total']); ?></td></tr>
		<tr><td>Metode Pembayaran	</td><td> : <?php echo $r['rent_detail_type']; ?></td></tr>
		<tr><td>Tanggal Jatuh Tempo	</td><td> : <?php echo date("d-m-Y", strtotime($dateline)); ?></td></tr>
		<tr><td>Tanggal Bayar		</td><td> : <?php echo date("d-m-Y", strtotime($r['rent_detail_date'])); ?></td></tr>
	</table>
    <br /><br /><br />
	<table style="width:95%;border:0px black;margin-bottom:50px;margin-left:10px;margin-right:30px;font-size:12pt;">
		<tr>
			<td style="text-align: left;width: 52%"></td>
			<td style="text-align: right;width: 45%">Surabaya, <?php echo $date_now; ?><br /></td>
			<td style="text-align: right;width: 3%"></td>
		</tr>
		<tr>
			<td style="text-align: left;width: 52%"></td>
			<td style="text-align: right;width: 45%"><br /><br /><br /><br /><br /><br/><br/><br/><br/><br/><br/>Mengetahui<br /><br /><br /></td>
			<td style="text-align: right;width: 3%"></td>
		</tr>
		<tr>
			<td style="text-align: left;width: 52%"></td>
			<td style="text-align: center;width: 45%"><br />(      </td>
			<td style="text-align: center;width: 3%"><br />)</td>
		</tr>
	</table>
</page>
<?php } ?>