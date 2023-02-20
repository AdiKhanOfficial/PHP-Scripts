<html>
	<head>
		<?php
			$pageTitle = "Buuble Sort";
			include("include/sources.php");
		?>
		<style>
			input{width:100%;padding:10px}
			.bubble{border:1px solid;margin-left:5px;width:30;height:30px;display:inline-block;border-radius:20px;padding:5px;}
			
		</style>
	</head>
	<body>
		<center>
			<table border='1' style="padding:10px">
				<tr>
					<td>
						<h3>Buuble Sort Algorith Analysis</h3>
					</td>
				</tr>
				<tr>
					<td>
						<br>
						<form action="" method="post">
							<input type="text"name="array" placeholder="Input Array e.g. 1,2,3,1,4.." class="form-control"/><br>
							<input type="submit" name="submit" value="Sort" class="form-control btn btn-primary">
						</form>
					</td>
				</tr>
				
				<tr>
					<td style="padding:10px;" align="center">
						<?php
							if(isset($_POST["submit"])){
								$input = $_POST["array"];
								if($input == ""){
									echo "<h3 align='center' style='margin-top:50px;'>Please give an array of numbers as input</h2>";
								}
								else{
									$array = explode(",",$input);
									$outPut = bubbleSort($array);
									$sortedArray = $outPut[0];
									$time = $outPut[1];
									echo "<p>Time : <b>$time<b> sec.</b>";
									include("include/graphs.php");
									$dataPoints = array();
									array_push($dataPoints,array("y"=>$time,"label"=>"n = " . count($sortedArray) ));
									generateGraph("column","Bubble Sort Time","Time",$dataPoints);
									
									}
							}
							
							
							// sort array
							function bubbleSort($arr)
							{
								$sTime =  microtime(true);
								$arrLength = count($arr);

								for ($i = 0; $i < $arrLength; $i++) {
									for ($j = $i; $j < $arrLength; $j++) {	
										printArray($arr,$i,$j);									
										if ($arr[$j] < $arr[$i]) {
											echo "Swapped " . $arr[$j] . " and " . $arr[$i]."<br>";											
											$temp = $arr[$j];
											$arr[$j] = $arr[$i];
											$arr[$i] = $temp;
											
										}
									}
								}
								printArray($arr,-1,-1);
								$eTime =  microtime(true);
								$time = $eTime - $sTime;
								return array($arr, round($time,5));
								
							}


							// print array as Bubbles
							function printArray($arr, $p1, $p2){
								for($i=0;$i<count($arr);$i++){
									$color = "";
									if($i == $p1){
										$color = "lightblue";
									}
									else if($i == $p2){
										$color = "lightpink";
									}
									echo "<div align='center' class='bubble' style='background:$color'>".$arr[$i]."</div>";
								}
								echo "<br><br>";
							}
						
						?>
					</td>
				</tr>
			
			</table>
		
		</center>
	</body>


</html>
