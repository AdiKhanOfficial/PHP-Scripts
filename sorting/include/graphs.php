<?php
function generateGraph($type='Line', $title, $label, $dataPoints){
	echo "
			<script src='js/canvasjs.min.js'></script>
			<script>
			window.onload = function () {
			 
			var chart = new CanvasJS.Chart('chartContainer', {
				 animationEnabled: true,
				 animationDuration: 2000,
				 zoomEnabled:true,
				title: {
					text: '$title'
				},
				axisY: {
					title: '$label',
				},
				axisX:{
					interval: 1,
					},
				dataPointWidth: 20,
				data: [{
					type: '$type',
					indexLabel: '{y}',
					dataPoints: ". json_encode($dataPoints, JSON_NUMERIC_CHECK)."
				}]
				
			});
			
			chart.render();
			 
			}
			</script>";
			echo '<div id="chartContainer"  class="" style="height: 200px; width: 100%;border:1px solid red" ></div>';
			
}

?>