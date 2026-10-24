<?php
	include "connection.php";
	$aktif		= executeScalar("select count(merchant_id) as total from merchant where merchant_status = 'Aktif'");
	$nonaktif	= executeScalar("select count(merchant_id) as total from merchant where merchant_status = 'Tidak Aktif'");
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
			$('#report_merchant_sts').highcharts({
				chart: {
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false
				},
				title: {
					text: 'Status Pedagang'
				},
				tooltip: {
					shared: false,
					valueSuffix: ' Orang'
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
						['Aktif', <?php echo $aktif; ?>],
						['Tidak Aktif', <?php echo $nonaktif; ?>]
					]
				}]
			});
		});
	})(jQuery);
</script>
<div class="panel panel-primary">
	<div class="panel-body">
		<div id="report_merchant_sts" style="min-width: 450px; max-width: 600px; height: 200px; margin: 0 auto"></div>
	</div>
</div>