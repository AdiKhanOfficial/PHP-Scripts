<html>
	<head>
		<?php include("include/sources.php");?>
	</head>
  	<body>
			<center>
			<div class="col-lg-4 col-md-3 col-sm-2"></div>
			<table style="min-height:100%; padding: 20px;box-shadow: 0px 1px 7px 2px grey;background:white" class="col-lg-4 col-md-6 col-sm-8 col-xs-12" align="center">
				<?php echo $topHeader;?>
				
				<tr>
					<td  style="height:50px">
						<form method="post" action="">
							<div class="form-group" align='left'>
								<label for="regNo">Input Array (Separated By ',')</label>
								<input type="text" class="form-control" name="array" placeholder="2,1,32,4,5,3,22,3" >
							</div>
							<div class="form-group" align='left'>
								<input type="submit" class="form-control btn btn-success" name="submit" value="Submit">
							</div>
						</form>
					</td>
				</tr>
				<tr>
					<td id="result" align="center">
						<?php
							if(isset($_POST["submit"])){
								$input = $_POST["array"];
								if($input == ""){
									echo "<h4 align='center' style='margin-top:50px;'>Please give an array of numbers as input</h2>";
								}
								else{
									$dataPoints = array();
									$inputArray = explode(",",$input);
									
									$time = microtime(true);
									$sortedArray = bubbleSort($inputArray);
									$time = round(microtime(true) - $time,8);
									array_push($dataPoints,array("y"=>$time,"label"=>"Bubble SOrt" ));
									echo "<div align='left' class='printCard'><h4>Bubble Sort</h4>";
									echo "<b>Input: </b>". implode(',', $inputArray)."<br>";
									echo "<b>Output: </b>". implode(',', $sortedArray)."<br>";
									echo "<b>Time: </b>$time Sec.</div>";
									
									$time = microtime(true);
									$sortedArray = quickSort($inputArray);
									$time = round(microtime(true) - $time,8);
									array_push($dataPoints,array("y"=>$time,"label"=>"Quick SOrt" ));
									echo "<div align='left' class='printCard'><h4>Quick Sort</h4>";
									echo "<b>Input: </b>". implode(',', $inputArray)."<br>";
									echo "<b>Output: </b>". implode(',', $sortedArray)."<br>";
									echo "<b>Time: </b>$time Sec.</div>";
									
									
									$time = microtime(true);
									$sortedArray = mergesort($inputArray);
									$time = round(microtime(true) - $time,8);
									array_push($dataPoints,array("y"=>$time,"label"=>"Merge SOrt" ));
									echo "<div align='left' class='printCard'><h4>Merge Sort</h4>";
									echo "<b>Input: </b>". implode(',', $inputArray)."<br>";
									echo "<b>Output: </b>". implode(',', $sortedArray)."<br>";
									echo "<b>Time: </b>$time Sec.</div>";
									
									$time = microtime(true);
									$sortedArray = selectionSort($inputArray);
									$time = round(microtime(true) - $time,8);
									array_push($dataPoints,array("y"=>$time,"label"=>"Selection SOrt" ));
									echo "<div align='left' class='printCard'><h4>Selection Sort</h4>";
									echo "<b>Input: </b>". implode(',', $inputArray)."<br>";
									echo "<b>Output: </b>". implode(',', $sortedArray)."<br>";
									echo "<b>Time: </b>$time Sec.</div>";
									
									echo "<br><br>";
									include("include/graphs.php");
									generateGraph("column","Time Analysis","Time (Seconds)",$dataPoints);
									
									}
							}
							
							
							// bubble sort 
							function bubbleSort($arr)
							{
								$arrLength = count($arr);
								for ($i = 0; $i < $arrLength; $i++) {
									for ($j = $i; $j < $arrLength; $j++) {									
										if ($arr[$j] < $arr[$i]) {										
											$temp = $arr[$j];
											$arr[$j] = $arr[$i];
											$arr[$i] = $temp;											
										}
									}
								}
								return $arr;								
							}
							
							//quick sort
							function quickSort($arr)
							{
								if(count($arr) <= 1){
									return $arr;
								}
								else{
									$pivot = $arr[0];
									$left = array();
									$right = array();
									for($i = 1; $i < count($arr); $i++)
									{
										if($arr[$i] < $pivot){
											$left[] = $arr[$i];
										}
										else{
											$right[] = $arr[$i];
										}
									}
									return array_merge(quickSort($left), array($pivot), quickSort($right));
								}
							}
							
							// merge sort
							function mergesort($numlist)
							{
								if(count($numlist) == 1 ) return $numlist;
							 
								$mid = count($numlist) / 2;
								$left = array_slice($numlist, 0, $mid);
								$right = array_slice($numlist, $mid);
							 
								$left = mergesort($left);
								$right = mergesort($right);
								 
								return merge($left, $right);
							}
							 
							function merge($left, $right)
							{
								$result=array();
								$leftIndex=0;
								$rightIndex=0;
							 
								while($leftIndex<count($left) && $rightIndex<count($right))
								{
									if($left[$leftIndex]>$right[$rightIndex])
									{
							 
										$result[]=$right[$rightIndex];
										$rightIndex++;
									}
									else
									{
										$result[]=$left[$leftIndex];
										$leftIndex++;
									}
								}
								while($leftIndex<count($left))
								{
									$result[]=$left[$leftIndex];
									$leftIndex++;
								}
								while($rightIndex<count($right))
								{
									$result[]=$right[$rightIndex];
									$rightIndex++;
								}
								return $result;
							}
							
							
							function selectionSort($data)
							{
							for($i=0; $i<count($data)-1; $i++) {
								$min = $i;
								for($j=$i+1; $j<count($data); $j++) {
									if ($data[$j]<$data[$min]) {
										$min = $j;
									}
								}
								$data = swap_positions($data, $i, $min);
							}
							return $data;
							}

							function swap_positions($data1, $left, $right) {
								$backup_old_data_right_value = $data1[$right];
								$data1[$right] = $data1[$left];
								$data1[$left] = $backup_old_data_right_value;
								return $data1;
							}
						
						?>
					</td>
				</tr>
				<?php echo $footer;?>
			</table>
			<style>
				body{background-size:cover;min-width:100%}
				#loading{border: none;    box-shadow: none;border-radius:100%}
				
			</style>

		</center>
	</body>
</html>