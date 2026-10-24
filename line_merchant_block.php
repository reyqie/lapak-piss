<?php
	include "connection.php";
	function getBlock(){
		$query 	= "select distinct(active_block) as block, count(merchant_id) as total
		from merchant group by block desc";
		$data=mysql_query($query);
		$string="'";
		$counter=0;
		while($row=mysql_fetch_array($data)){
			if($counter!=0){
				$string="','".$string;
			}
			$string=$row['block'].$string;
			$counter++;
		}
		return "'".$string;
	}
	function getTotal(){
		$query 	= "select distinct(active_block) as block, count(merchant_id) as total
		from merchant group by block desc";
		$data	= mysql_query($query);
		$string	= "";
		$counter= 0;
		while($row=mysql_fetch_array($data)){
			if($counter!=0){
				$string=" , ".$string;
			}
			$string=$row['total'].$string;
			$counter++;
		}
		return "".$string;
	}
?>
<script type="text/javascript">
	(function($){ // encapsulate jQuery
		$(function () {
			$('#report_merchant2').highcharts({
				chart: {
					type: 'spline'
				},
				title: {
					text: 'Pedagang Per Block',
					x: -20 //center
				},
				xAxis: {
					categories: [<?php echo getBlock(); ?>]
				},
				yAxis: {
					min: 0,
					labels: {
						style: {
							color: 'rgba(119, 119, 119, 1)'
						}
					},
					title: {
						text: 'Pedagang'
						//enabled : false
					}
				},
				plotOptions: {
					line: {
						dataLabels: {
							enabled: false
						},
						enableMouseTracking: true
					},
					column: {
						dataLabels: {
							enabled: false
						},
						enableMouseTracking: true,
						pointWidth: 20
					},
					series: {
						allowPointSelect: true,
						point: {
							events: {
								click: function() {
									/*//alert(this.category+' / '+ this.x +' was last selected');
									var str = this.category;
									//nres = (this.category).substring(2, 2);
									var x = str.substring(1,3);
									callDetailDay(x);
									//alert(x);*/
									
									var str = this.category;
									var day = str.substring(1,11);
									callDaySales(this.category);
								}
							}
						}
					}
				},
				legend: {
					layout: 'vertical',
					align: 'right',
					verticalAlign: 'top',
					x: -3,
					y: 15,
					floating: true,
					borderWidth: 1,
					backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
					shadow: true
				},
				tooltip: {
					crosshairs: true,
					shared: true,
					valueSuffix: ' Pedagang'
				},
				credits: {
					enabled: false
				},
				series: [{
					name: 'Jumlah ',
					marker: {
						symbol: 'circle'
					},
					color: '#0075ff',
					data: [<?php echo getTotal(); ?>]
				}]
			});
		});
	})(jQuery);
</script>
<div class="panel panel-primary">
	<div class="panel-body">
		<div id="report_merchant2" style="min-width: 1000px; max-width: 1000px; height: 300px; margin: 0 auto"></div>
	</div>
</div>