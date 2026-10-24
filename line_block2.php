<?php
	include "connection.php";
	function getSayur(){
		$query 	= "select sum(lapak_size) as size, lapak_type from lapak where lapak_type = 'Sayur' group by lapak_type";
		$data=mysql_query($query);
		$string="";
		$counter=0;
		while($row=mysql_fetch_array($data)){
			if($counter!=0){
				$string=" , ".$string;
			}
			$string=$row['size'].$string;
			$counter++;
		}
		return "".$string;
	}
	function getBuah(){
		$query 	= "select sum(lapak_size) as size, lapak_type from lapak where lapak_type = 'Buah' group by lapak_type";
		$data=mysql_query($query);
		$string="";
		$counter=0;
		while($row=mysql_fetch_array($data)){
			if($counter!=0){
				$string=" , ".$string;
			}
			$string=$row['size'].$string;
			$counter++;
		}
		return "".$string;
	}
	function getLain(){
		$query 	= "select sum(lapak_size) as size, lapak_type from lapak where lapak_type = 'Lainnya' group by lapak_type";
		$data=mysql_query($query);
		$string="";
		$counter=0;
		while($row=mysql_fetch_array($data)){
			if($counter!=0){
				$string=" , ".$string;
			}
			$string=$row['size'].$string;
			$counter++;
		}
		return "".$string;
	}
?>
<script type="text/javascript">
	(function($){ // encapsulate jQuery
		$(function () {
			Highcharts.setOptions({
			 colors: ['#00ff94', '#0075ff', '#ff3c3c']
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
			$('#block2').highcharts({
				chart: {
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false
				},
				title: {
					text: 'Luas Lapak Per Jenis Jualan'
				},
				tooltip: {
					shared: false,
					valueSuffix: ' M2'
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
					name: 'Luas ',
					data: [
						['Sayur', <?php echo getSayur(); ?>],
						['Buah', <?php echo getBuah(); ?>],
						['Lainnya', <?php echo getLain(); ?>]
					]
				}]
			});
		});
	})(jQuery);
</script>
<div class="panel panel-primary">
	<div class="panel-body">
		<div id="block2" style="min-width: 200px; max-width: 600px; height: 200px; margin: 0 auto"></div>
	</div>
</div>