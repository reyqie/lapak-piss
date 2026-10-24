<?php
	include "connection.php";

	$dp		= executeScalar("select sum(rent_dp) from rent where rent_sts != 'Batal' ");
	$ins	= executeScalar("select sum(rd.cash_total+rd.trans_total) from rent r, rent_detail rd 
							where r.rent_id = rd.rent_id and r.rent_sts != 'Batal' ");
	$lo		= executeScalar("select sum(leftover2) from rent where rent_sts != 'Batal' ");
	$paid 	= $dp+$ins;
	$unpaid = $lo-$ins;
?>
<script type="text/javascript">
	(function($){ // encapsulate jQuery
		$(function () {
			Highcharts.setOptions({
			 colors: ['#00ff94', '#ff3c3c']
			});
			// Radialize the colors
			Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {
				return {
					radialGradient: { cx: 0.5, cy: 0.3, r: 0.7 },
					stops: [
						[0, color],
						[1, Highcharts.Color(color).brighten(-0.5).get('rgb')] // darken
					]
				};
			});
			

			// Build the chart
			$('#revenue1').highcharts({
				chart: {
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false
				},
				title: {
					text: 'Pendapatan Lapak PISS'
				},
				tooltip: {
					shared: false,
					valueSuffix: ' Rupiah'
				},
				plotOptions: {
					pie: {
						allowPointSelect: true,
						cursor: 'pointer',
						dataLabels: {
							enabled: true,
							format: '<b>{point.name}</b>: {point.percentage:.1f} %',
							style: {
								color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
							},
							connectorColor: 'silver'
						}
					}
				},
				credits: {
					enabled: false
				},
				series: [{
					type: 'pie',
					name: 'Jumlah ',
					data: [
						['Terbayar ', <?php echo $paid; ?>],
						['Belum Terbayar ', <?php echo $unpaid; ?>]
					]
				}]
			});
		});
	})(jQuery);
</script>
<div class="panel panel-primary">
	<div class="panel-body">
		<div id="revenue1" style="min-width: 350px; max-width: 600px; height: 200px; margin: 0 auto"></div>
	</div>
</div>