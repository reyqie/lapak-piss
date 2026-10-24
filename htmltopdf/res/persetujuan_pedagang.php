<?php
	include "../connection.php";
	$date_now 	= date("d-m-Y");
	$no			= date("my");
	$id			= $_GET['id'];
	$sql 		= mysql_query("select * from rent where rent_id = '".$id."'");
	while($r = mysql_fetch_array($sql)){
	$name		= executeScalar("select merchant_name from merchant where merchant_id = '".$r['merchant_id']."'");
	$adrs		= executeScalar("select address1 from merchant where merchant_id = '".$r['merchant_id']."'");
	$mtype		= executeScalar("select merchant_type from merchant where merchant_id = '".$r['merchant_id']."'");
	$lapak		= executeScalar("select lapak_name from lapak where lapak_id = '".$r['lapak_id']."'");
	$price		= executeScalar("select lapak_price from lapak where lapak_id = '".$r['lapak_id']."'");
	//$total		= executeScalar("select rent_total from rent where rent_id = '".$id."'");
	$dur		= executeScalar("select duration from lapak where lapak_id = '".$r['lapak_id']."'");
	$size		= executeScalar("select lapak_size from lapak where lapak_id = '".$r['lapak_id']."'");
	$iid 		= executeScalar("select instalment_id from rent where lapak_id = '".$r['lapak_id']."'");
	$ins 		= executeScalar("select instalment_count from instalment where instalment_id = '".$iid."'");
?>
<page backtop="10mm" backbottom="10mm" backleft="10mm" backright="10mm">
    <page_header>
        <table style="width:95%; border:0px; margin-top:30px; margin-left:10px; margin-right:10px;">
            <tr>
                <td style="text-align: left;    width: 33%">www.paskomnas.com</td>
                <td style="text-align: center;    width: 34%"></td>
                <td style="text-align: right;    width: 33%">No: <?php echo $no.$r['merchant_id']; ?></td>
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
		Persetujuan Permohonan Menempati Lapak PIOS
	</div>
	<br/><br/><br/><br/>
	<table style="margin-bottom: 5px;font-size:12pt;" id="tableRent">
		<tr><td style="width: 50%;">ID Pedagang	</td><td style="width: 50%;"> : <?php echo $r['merchant_id']; ?> </td></tr>
		<tr><td>Nama        			</td><td> : <?php echo $name; ?> </td></tr>
		<tr><td>Alamat     				</td><td> : <?php echo $adrs; ?> </td></tr>
		<tr><td>Jualan      			</td><td> : <?php echo $mtype; ?> </td></tr>
		<tr><td>Lapak					</td><td> : <?php echo $lapak; ?></td></tr>
		<tr><td>Luas Lapak				</td><td> : <?php echo $size; ?> M<sup>2</sup></td></tr>
		<tr><td>Harga /M<sup>2</sup>	</td><td> : <?php echo format_rupiah($price); ?></td></tr>
		<tr><td>Total Harga				</td><td> : <?php echo format_rupiah($r['rent_total']); ?></td></tr>
		<tr><td>Masa Pakai				</td><td> : <?php echo $dur; ?> Tahun</td></tr>
		<tr><td>Uang Muka				</td><td> : <?php echo format_rupiah($r['rent_dp']); ?></td></tr>
		<tr><td>Sisa Pembayaran			</td><td> : <?php echo format_rupiah($r['leftover']); ?></td></tr>
		<tr><td>Bunga Angsuran			</td><td> : <?php echo $r['interest']; ?>%</td></tr>
		<tr><td>Angsuran Yg Harus Dibayar</td><td> : <?php echo format_rupiah($r['leftover2']); ?></td></tr>
		<tr><td>Jumlah Angsuran			</td><td> : <?php echo $ins; ?>x</td></tr>
		<tr><td>Angsuran Perbulan		</td><td> : <?php echo format_rupiah($r['rent_instalment']); ?></td></tr>
		<tr><td>Kajian					</td><td> : <?php echo $r['rent_desc']; ?></td></tr>
	</table>
    <br /><br /><br /><br />
	<br /><br /><br /><br />
	<table style="width:95%;border:0px black;margin-bottom:50px;margin-left:10px;margin-right:30px;font-size:12pt;">
		<tr>
			<td style="text-align: left;width: 62%"></td>
			<td style="text-align: right;width: 35%">Surabaya, <?php echo $date_now; ?><br /></td>
			<td style="text-align: right;width: 3%"></td>
		</tr>
		<tr>
			<td style="text-align: left;width: 62%"></td>
			<td style="text-align: right;width: 35%"><br /><br /><br/><br/><br/><br /><br /><br/><br/><br/><br/><br/><br/>Disetujui oleh<br /><br /><br /></td>
			<td style="text-align: right;width: 3%"></td>
		</tr>
		<tr>
			<td style="text-align: left;width: 62%"></td>
			<td style="text-align: center;width: 35%">(      </td>
			<td style="text-align: center;width: 3%">)</td>
		</tr>
	</table>
</page>
<?php } ?>