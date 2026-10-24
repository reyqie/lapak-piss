<?php
	session_start();
	include "connection.php";
	include "components/role_session.php";
?>

<div class="modal-header bg-primary text-white" style="border-top-left-radius: 5px; border-top-right-radius: 5px;">
	<h4 style="margin-left: 20px;"><i class="fa fa-retweet fa-fw"></i>&nbsp;Pindah Ke Lapak Kosong</h4>
	<button style="margin-top: -35px; margin-right: 20px;" type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<div class="modal-body">
	<?php $sql	= mysql_query("select * from merchant where merchant_id = '".$_GET['id']."'");
							while ($r = mysql_fetch_array($sql)){ ?>
							<form action="move_action.php?task=move1&id=<?php echo $r['merchant_id'];?>"  class="form-horizontal" id="formHome" name = "formHome" method="POST">
								<fieldset>
									<div class="form-group" style="padding:0 40px; margin-top:0px;">
										<label>Nama Pedagang</label>
										<input type="text" class="form-control" id="name" name="name" value="<?php echo $r['merchant_name']; ?>" disabled>
									</div>
									<div class="form-group" style="padding:0 40px; margin-top:0px;">
										<label>Lapak Awal</label>
										<select class="form-control chzn-select" name="lapak1" id="lapak1">
											<option value="">- Pilih Lapak -</option>
											<?php 
												$sql2 = mysql_query("select l.lapak_id, l.lapak_name, l.lapak_type from lapak l, rent r where 
												l.lapak_id = r.lapak_id and r.merchant_id = '".$r['merchant_id']."' and (rent_sts2 != 'Batal' && rent_sts2 != 'Pindah')");
												while($r2 = mysql_fetch_array($sql2))
											{?>
												<option value="<?php echo $r2['lapak_id'];?>"><?php echo $r2['lapak_name'].' / '.$r2['lapak_type'];?></option>
											<?php } ?>
										</select>
									</div>
									<div class="form-group" style="padding:0 40px; margin-top:0px;">
										<label>Lapak Tujuan</label>
										<select class="form-control chzn-select" name="lapak2" id="lapak2">
											<option value="">- Pilih Lapak -</option>
											<?php 
												$sql3 = mysql_query("select lapak_id, lapak_name, lapak_type from lapak where lapak_status is null OR lapak_status = 'Kosong' ");
												while($r3 = mysql_fetch_array($sql3))
											{?>
												<option value="<?php echo $r3['lapak_id'];?>"><?php echo $r3['lapak_name'].' / '.$r3['lapak_type'];?></option>
											<?php } ?>
										</select>
									</div>
									<div class="form-group" style="padding:0 40px; margin-top:0px;">
										<div class="row">
											<div class="col-md-6">
												<label>Cicilan</label>
												<!-- <select class="form-control" name="ins" id="ins" required>
													<option value="">- Pilih Cicilan -</option>
													<?php 
														$sql1 		= mysql_query("select * from instalment order by instalment_name");
														while($d1 = mysql_fetch_array($sql1)){
														?>
														<option value="<?php echo $d1['instalment_id'];?>"><?php echo $d1['instalment_name'].' / '.$d1['instalment_count'].'x';?></option>
													<?php } ?>
												</select> -->
												<input class="form-control" type="number" value="0" readonly />
												<input type="hidden" id="ins" name="ins" value="1" />
											</div>
											<div class="col-md-6">
												<label>Bunga Pertahun (%)</label>
												<input class="form-control" id="interest" name="interest" type="number" value="0" required  readonly/>
											</div>
										</div>
									</div>
									<div class="form-group" style="padding:0 40px; margin-bottom:10px; margin-top: 20px;">
										<center><button type="submit" class="btn btn-block btn-primary"><i class="fa fa-retweet"></i>&nbsp;&nbsp;Pindahkan</button></center>
									</div>
								</fieldset>
							</form>
							<?php } ?>
</div>

<script src="js/plugins/chosen/chosen.jquery.js"></script>
<script type="text/javascript">
	$(".chzn-select").chosen({"search_contains": true,"width":"100%", "no_results_text":"Hasil tidak ditemukan !"});
</script>